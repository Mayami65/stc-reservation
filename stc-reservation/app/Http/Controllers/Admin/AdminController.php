<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Booking;
use App\Models\Trip;
use App\Models\Route;
use App\Models\Bus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_bookings' => Booking::count(),
            'total_trips' => Trip::count(),
            'total_routes' => Route::count(),
            'total_buses' => Bus::count(),
            'checked_in_today' => Booking::where('status', 'checked-in')
                ->whereDate('updated_at', today())->count(),
            'bookings_today' => Booking::whereDate('created_at', today())->count(),
            'upcoming_trips' => Trip::where('departure_date', '>=', today())->count(),
        ];

        $recentBookings = Booking::with(['user', 'trip.route', 'seat'])
            ->latest()
            ->limit(5)
            ->get();

        $upcomingTrips = Trip::with(['route', 'bus'])
            ->where('departure_date', '>=', today())
            ->orderBy('departure_date')
            ->orderBy('departure_time')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentBookings', 'upcomingTrips'));
    }

    public function scanner()
    {
        return view('admin.scanner');
    }

    public function scanTicket(Request $request)
    {
        try {
            // Log the incoming request
            Log::info('QR Scan request received', [
                'headers' => $request->headers->all(),
                'body' => $request->all(),
                'content_type' => $request->header('Content-Type')
            ]);

            $request->validate([
                'qr_data' => 'required|string',
            ]);

            // Parse QR code data (assuming format: "Booking ID: {id}, Seat: {seat}, Trip: {trip}")
            $qrData = $request->qr_data;
            
            Log::info('QR Data received', ['qr_data' => $qrData]);
            
            // Extract booking ID from QR data
            if (preg_match('/Booking ID: (\d+)/', $qrData, $matches)) {
                $bookingId = $matches[1];
                
                Log::info('Booking ID extracted', ['booking_id' => $bookingId]);
                
                $booking = Booking::with(['user', 'trip.route', 'seat'])
                    ->find($bookingId);

                if (!$booking) {
                    Log::warning('Booking not found', ['booking_id' => $bookingId]);
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid ticket. Booking not found.',
                    ]);
                }

                if ($booking->status === 'cancelled') {
                    Log::info('Booking cancelled', ['booking_id' => $bookingId]);
                    return response()->json([
                        'success' => false,
                        'message' => 'This ticket has been cancelled.',
                    ]);
                }

                if ($booking->status === 'checked-in') {
                    Log::info('Booking already checked in', ['booking_id' => $bookingId]);
                    return response()->json([
                        'success' => false,
                        'message' => 'This ticket has already been checked in.',
                        'booking' => $booking,
                        'already_checked_in' => true,
                    ]);
                }

                // Check if ticket has expired
                if ($booking->isExpired()) {
                    Log::info('Booking expired', ['booking_id' => $bookingId, 'expires_at' => $booking->expires_at]);
                    return response()->json([
                        'success' => false,
                        'message' => 'This ticket has expired.',
                        'booking' => $booking,
                        'expired' => true,
                    ]);
                }

                // Check if trip is today or in the future
                if ($booking->trip->departure_date < today()) {
                    Log::info('Booking for past trip', ['booking_id' => $bookingId, 'trip_date' => $booking->trip->departure_date]);
                    return response()->json([
                        'success' => false,
                        'message' => 'This ticket is for a past trip.',
                    ]);
                }

                // Update booking status to checked-in
                $booking->update(['status' => 'checked-in']);
                
                Log::info('Booking checked in successfully', ['booking_id' => $bookingId]);

                return response()->json([
                    'success' => true,
                    'message' => 'Ticket verified successfully. Passenger checked in.',
                    'booking' => $booking,
                ]);
            }

            Log::warning('Invalid QR code format', ['qr_data' => $qrData]);
            return response()->json([
                'success' => false,
                'message' => 'Invalid QR code format.',
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error in scanTicket', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Server error occurred. Please try again.',
                'debug' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
}
