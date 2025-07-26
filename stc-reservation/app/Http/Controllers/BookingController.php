<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

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
        $routes = \App\Models\Route::all();
        return view('booking.routes', compact('routes'));
    }

    public function showTrips(\App\Models\Route $route)
    {
        $this->abortIfAdmin();
        $trips = $route->trips()->with('bus')->get();
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
            'seat_id' => 'required|exists:seats,id',
        ]);

        // Check if seat is already booked for this trip
        $alreadyBooked = $trip->bookings()->where('seat_id', $request->seat_id)->exists();
        if ($alreadyBooked) {
            return back()->with('error', 'Seat already booked!');
        }

        // Set expiry time (24 hours from now, or 1 hour before trip departure, whichever is earlier)
        $expiresAt = now()->addHours(24);
        $tripDepartureTime = \Carbon\Carbon::parse($trip->departure_date . ' ' . $trip->departure_time);
        $oneHourBeforeTrip = $tripDepartureTime->subHour();
        
        if ($oneHourBeforeTrip->isFuture() && $oneHourBeforeTrip->lt($expiresAt)) {
            $expiresAt = $oneHourBeforeTrip;
        }

        $booking = \App\Models\Booking::create([
            'user_id' => Auth::id(),
            'trip_id' => $trip->id,
            'seat_id' => $request->seat_id,
            'status' => 'booked',
            'expires_at' => $expiresAt,
        ]);

        // Generate QR code
        $this->generateQRCode($booking);

        return redirect()->route('bookings.show', $booking->id)->with('success', 'Seat booked successfully!');
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
            ->where('user_id', \Auth::id())
            ->latest()
            ->get();

        return view('booking.user_bookings', compact('bookings'));
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
