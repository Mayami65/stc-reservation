<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\GdImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'trip.route', 'trip.bus', 'seat']);

        // Filter by status if provided
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by trip if provided
        if ($request->filled('trip_id')) {
            $query->where('trip_id', $request->trip_id);
        }

        // Search by user name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $bookings = $query->latest()->paginate(15);
        
        // Get available statuses for filter
        $statuses = ['booked', 'checked-in', 'cancelled'];

        return view('admin.bookings.index', compact('bookings', 'statuses'));
    }

    public function show(Booking $booking)
    {
        $booking->load(['user', 'trip.route', 'trip.bus', 'seat']);
        return view('admin.bookings.show', compact('booking'));
    }

    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:booked,checked-in,cancelled',
        ]);

        $oldStatus = $booking->status;
        $booking->update(['status' => $request->status]);

        $message = "Booking status updated from '{$oldStatus}' to '{$request->status}'.";
        
        return redirect()->back()->with('success', $message);
    }

    private function generateQRCode(\App\Models\Booking $booking)
    {
        $qrData = "Booking ID: {$booking->id}, Seat: {$booking->seat->seat_number}, Trip: {$booking->trip->id}";

        $qrImage = QrCode::format('png')
            ->size(300)
            ->errorCorrection('M')
            ->generate($qrData);

        $directory = 'qrcodes';
        if (!Storage::disk('public')->exists($directory)) {
            Storage::disk('public')->makeDirectory($directory);
        }

        $filename = "booking_{$booking->id}.png";
        $path = "{$directory}/{$filename}";
        Storage::disk('public')->put($path, $qrImage);

        $booking->update(['qr_code_path' => $path]);

        return $path;
    }
}
