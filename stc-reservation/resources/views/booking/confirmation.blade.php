@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="max-w-2xl mx-auto">
        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                <div class="flex items-center">
                    <i class="bi bi-check-circle text-xl mr-2"></i>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <!-- Booking Confirmation Card -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white p-6">
                <div class="text-center">
                    <i class="bi bi-ticket-perforated text-4xl mb-2"></i>
                    <h1 class="text-2xl font-bold">Booking Confirmed!</h1>
                    <p class="text-blue-100">Your seat has been reserved</p>
                </div>
            </div>

            <!-- Booking Details -->
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Trip Information -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Trip Details</h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Route:</span>
                                <span class="font-medium">{{ $booking->trip->route->origin }} → {{ $booking->trip->route->destination }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Date:</span>
                                <span class="font-medium">{{ $booking->trip->departure_date }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Time:</span>
                                <span class="font-medium">{{ $booking->trip->departure_time }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Bus:</span>
                                <span class="font-medium">{{ $booking->trip->bus->name }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Passenger Information -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Passenger Details</h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Name:</span>
                                <span class="font-medium">{{ $booking->user->name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Email:</span>
                                <span class="font-medium">{{ $booking->user->email }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Seat Number:</span>
                                <span class="font-medium text-lg text-blue-600">{{ $booking->seat->seat_number }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Status:</span>
                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800 font-medium">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </div>
                            @if($booking->expires_at)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Expires:</span>
                                <span class="font-medium {{ $booking->isExpired() ? 'text-red-600' : 'text-green-600' }}">
                                    {{ $booking->expires_at->format('M d, Y g:i A') }}
                                </span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- QR Code Section -->
                @if($booking->qr_code_path)
                <div class="border-t pt-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3 text-center">Your Digital Ticket</h3>
                    <div class="text-center">
                        <div class="inline-block p-4 bg-gray-50 rounded-lg mb-4">
                            <img src="{{ asset('storage/' . $booking->qr_code_path) }}" 
                                 alt="QR Code Ticket" 
                                 class="mx-auto"
                                 style="max-width: 200px;">
                        </div>
                        <p class="text-sm text-gray-600 mb-4">
                            Present this QR code at the terminal for boarding verification
                        </p>
                        
                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-3 justify-center">
                            <a href="{{ asset('storage/' . $booking->qr_code_path) }}" 
                               download="STC-Ticket-{{ $booking->id }}.png"
                               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center justify-center">
                                <i class="bi bi-download mr-2"></i> Download QR Code
                            </a>
                            <button onclick="window.print()" 
                                    class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center justify-center">
                                <i class="bi bi-printer mr-2"></i> Print Ticket
                            </button>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Important Information -->
                <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <h4 class="text-sm font-semibold text-yellow-800 mb-2">Important Information</h4>
                    <ul class="text-sm text-yellow-700 space-y-1">
                        <li>• Arrive at the terminal at least 30 minutes before departure</li>
                        <li>• Present your QR code or booking ID for verification</li>
                        <li>• Keep this confirmation safe until your journey is complete</li>
                        <li>• Contact support if you need to make changes to your booking</li>
                    </ul>
                </div>

                <!-- Action Buttons -->
                <div class="mt-6 flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="{{ route('routes.index') }}" 
                       class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg text-center">
                        Book Another Trip
                    </a>
                    <a href="/" 
                       class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg text-center">
                        Back to Home
                    </a>
                </div>

                <!-- Booking Reference -->
                <div class="mt-6 text-center text-sm text-gray-500">
                    <p>Booking ID: <span class="font-mono font-semibold">#{{ $booking->id }}</span></p>
                    <p>Booked on: {{ $booking->created_at->format('M d, Y \a\t H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    body * {
        visibility: hidden;
    }
    .container, .container * {
        visibility: visible;
    }
    .bg-gradient-to-r {
        background: #2563eb !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
    button, .hidden-print {
        display: none !important;
    }
}
</style>
@endsection
