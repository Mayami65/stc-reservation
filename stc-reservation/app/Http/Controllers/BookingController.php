<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Notifications\BookingConfirmed;

class BookingController extends Controller
{
    private function abortIfAdmin()
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        if ($user && $user->hasRole('admin')) {
            abort(403, 'Admins cannot access user booking pages.');
        }
    }

    public function showRoutes()
    {
        $this->abortIfAdmin();
        
        // Get routes that have trips with available seats and future departure times
        $routes = \App\Models\Route::whereHas('trips', function ($query) {
            $query->where('departure_date', '>=', now()->toDateString())
                  ->whereHas('bus', function ($busQuery) {
                      $busQuery->whereHas('seats', function ($seatQuery) {
                          // Get seats that are not booked for this trip
                          $seatQuery->whereDoesntHave('bookings', function ($bookingQuery) {
                              $bookingQuery->whereColumn('bookings.trip_id', 'trips.id');
                          });
                      });
                  });
        })->get();
        
        return view('booking.routes', compact('routes'));
    }

    public function showAvailableTrips()
    {
        $this->abortIfAdmin();
        
        // Get all available trips with their route, bus, and seat availability information
        $trips = \App\Models\Trip::with(['route', 'bus'])
            ->where('departure_date', '>=', now()->toDateString())
            ->whereHas('bus.seats', function ($seatQuery) {
                // Get seats that are not booked for this trip
                $seatQuery->whereDoesntHave('bookings', function ($bookingQuery) {
                    $bookingQuery->whereColumn('bookings.trip_id', 'trips.id');
                });
            })
            ->orderBy('departure_date')
            ->orderBy('departure_time')
            ->get()
            ->map(function ($trip) {
                // Calculate available seats for each trip
                $totalSeats = $trip->bus->seats()->count();
                $bookedSeats = $trip->bookings()->count();
                $availableSeats = $totalSeats - $bookedSeats;
                
                $trip->available_seats = $availableSeats;
                $trip->total_seats = $totalSeats;
                $trip->occupancy_percentage = $totalSeats > 0 ? ($bookedSeats / $totalSeats) * 100 : 0;
                
                return $trip;
            });
        
        return view('booking.available_trips', compact('trips'));
    }

    public function showTrips(\App\Models\Route $route)
    {
        $this->abortIfAdmin();
        $trips = $route->trips()->with('bus')
            ->where('departure_date', '>=', now()->toDateString())
            ->orderBy('departure_date')
            ->orderBy('departure_time')
            ->get()
            ->map(function ($trip) {
                // Calculate available seats for each trip
                $totalSeats = $trip->bus->seats()->count();
                $bookedSeats = $trip->bookings()->count();
                $availableSeats = $totalSeats - $bookedSeats;
                
                $trip->available_seats = $availableSeats;
                $trip->total_seats = $totalSeats;
                $trip->occupancy_percentage = $totalSeats > 0 ? ($bookedSeats / $totalSeats) * 100 : 0;
                
                return $trip;
            });
        return view('booking.trips', compact('route', 'trips'));
    }

    public function showSeats(\App\Models\Trip $trip)
    {
        $this->abortIfAdmin();
        $bus = $trip->bus;
        $seats = $bus->seats;
        $bookedSeatIds = $trip->bookings()->pluck('seat_id')->toArray();
        return view('booking.seats', compact('trip', 'seats', 'bookedSeatIds'));
    }

    public function bookSeat(Request $request, \App\Models\Trip $trip)
    {
        $this->abortIfAdmin();
        $request->validate([
            'seat_ids' => 'required|array|min:1',
            'seat_ids.*' => 'exists:seats,id',
        ]);

        $seatIds = $request->seat_ids;
        $bookings = [];

        // Check if any seats are already booked
        $alreadyBookedSeats = $trip->bookings()->whereIn('seat_id', $seatIds)->pluck('seat_id')->toArray();
        if (!empty($alreadyBookedSeats)) {
            $seatNumbers = \App\Models\Seat::whereIn('id', $alreadyBookedSeats)->pluck('seat_number')->toArray();
            return back()->with('error', 'Seat(s) ' . implode(', ', $seatNumbers) . ' already booked!');
        }

        // Set expiry time (24 hours from now, or 1 hour before trip departure, whichever is earlier)
        $expiresAt = now()->addHours(24);
        $tripDepartureTime = \Carbon\Carbon::parse($trip->departure_date)->setTimeFrom($trip->departure_time);
        $oneHourBeforeTrip = $tripDepartureTime->subHour();
        
        if ($oneHourBeforeTrip->isFuture() && $oneHourBeforeTrip->lt($expiresAt)) {
            $expiresAt = $oneHourBeforeTrip;
        }

        // Create bookings for each selected seat
        foreach ($seatIds as $seatId) {
            $booking = \App\Models\Booking::create([
                'user_id' => Auth::id(),
                'trip_id' => $trip->id,
                'seat_id' => $seatId,
                'status' => 'booked',
                'expires_at' => $expiresAt,
            ]);

            // Generate QR code for each booking
            $this->generateQRCode($booking);
            
            $bookings[] = $booking;
        }

        $seatCount = count($bookings);
        $message = $seatCount === 1 
            ? 'Seat booked successfully!'
            : "{$seatCount} seats booked successfully!";

        // Send email notification
        $user = $bookings[0]->user;
        if ($seatCount > 1) {
            $user->notify(new \App\Notifications\MultipleBookingsConfirmed(collect($bookings), $trip));
        } else {
            $user->notify(new \App\Notifications\BookingConfirmed($bookings[0]));
        }

        // If multiple bookings, redirect to a summary page, otherwise to the single booking
        if ($seatCount > 1) {
            return redirect()->route('bookings.summary', ['trip' => $trip->id])->with('success', $message);
        } else {
            return redirect()->route('bookings.show', $bookings[0]->id)->with('success', $message);
        }
    }

    public function showBooking(\App\Models\Booking $booking)
    {
        $this->abortIfAdmin();
        // Ensure user can only view their own booking (unless admin)
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if ($booking->user_id !== Auth::id() && !$user->hasRole('admin')) {
            abort(403);
        }

        $booking->load(['user', 'trip.route', 'trip.bus', 'seat']);
        return view('booking.confirmation', compact('booking'));
    }

    public function userBookings()
    {
        $this->abortIfAdmin();
        $bookings = \App\Models\Booking::with(['trip.route', 'trip.bus', 'seat'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('booking.user_bookings', compact('bookings'));
    }

    public function showBookingSummary(\App\Models\Trip $trip)
    {
        $this->abortIfAdmin();
        
        // Get all bookings for this trip by the current user
        $bookings = \App\Models\Booking::with(['trip.route', 'trip.bus', 'seat'])
            ->where('trip_id', $trip->id)
            ->where('user_id', Auth::id())
            ->whereDate('created_at', today()) // Only today's bookings
            ->latest()
            ->get();

        if ($bookings->isEmpty()) {
            return redirect()->route('book.tickets')->with('error', 'No bookings found for this trip.');
        }

        return view('booking.summary', compact('bookings', 'trip'));
    }

    private function generateQRCode(\App\Models\Booking $booking)
    {
        // Create QR code data with booking information
        $qrData = "Booking ID: {$booking->id}, Seat: {$booking->seat->seat_number}, Trip: {$booking->trip->id}";

        // Generate QR code image
        $qrImage = QrCode::format('png')
            ->size(300)
            ->errorCorrection('M')
            ->generate($qrData);

        // Create directory if it doesn't exist
        $directory = 'qrcodes';
        if (!Storage::disk('public')->exists($directory)) {
            Storage::disk('public')->makeDirectory($directory);
        }

        // Save QR code to storage
        $filename = "booking_{$booking->id}.png";
        $path = "{$directory}/{$filename}";
        
        Storage::disk('public')->put($path, $qrImage);

        // Update booking with QR code path
        $booking->update(['qr_code_path' => $path]);

        return $path;
    }
}
