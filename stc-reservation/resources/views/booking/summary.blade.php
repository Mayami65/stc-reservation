@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="max-w-4xl mx-auto">
        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                <div class="flex items-center">
                    <i class="bi bi-check-circle text-xl mr-2"></i>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <!-- Booking Summary Header -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white p-6">
                <div class="text-center">
                    <i class="bi bi-ticket-perforated text-4xl mb-2"></i>
                    <h1 class="text-2xl font-bold">Multiple Bookings Confirmed!</h1>
                    <p class="text-blue-100">{{ $bookings->count() }} seat(s) have been reserved</p>
                </div>
            </div>
        </div>

        <!-- Trip Information -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Trip Details</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <span class="text-gray-600 text-sm">Route:</span>
                    <p class="font-medium">{{ $trip->route->origin }} → {{ $trip->route->destination }}</p>
                </div>
                <div>
                    <span class="text-gray-600 text-sm">Date & Time:</span>
                    <p class="font-medium">{{ $trip->departure_date }} at {{ $trip->departure_time }}</p>
                </div>
                <div>
                    <span class="text-gray-600 text-sm">Bus:</span>
                    <p class="font-medium">{{ $trip->bus->name }}</p>
                </div>
            </div>
        </div>

        <!-- Individual Bookings -->
        <div class="space-y-6">
            @foreach($bookings as $booking)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="p-6">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                        <!-- Booking Details -->
                        <div class="flex-1">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-gray-800">
                                    Seat {{ $booking->seat->seat_number }}
                                </h3>
                                <span class="px-3 py-1 text-sm rounded-full bg-green-100 text-green-800 font-medium">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </div>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-600">Passenger:</span>
                                    <p class="font-medium">{{ $booking->user->name }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-600">Booking ID:</span>
                                    <p class="font-mono font-medium">#{{ $booking->id }}</p>
                                </div>
                                @if($booking->expires_at)
                                <div class="sm:col-span-2">
                                    <span class="text-gray-600">Expires:</span>
                                    <p class="font-medium {{ $booking->isExpired() ? 'text-red-600' : 'text-green-600' }}">
                                        {{ $booking->expires_at->format('M d, Y g:i A') }}
                                    </p>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- QR Code -->
                        @if($booking->qr_code_path)
                        <div class="flex-shrink-0">
                            <div class="text-center">
                                <div class="inline-block p-4 bg-gray-50 rounded-lg mb-3">
                                    <img src="{{ asset('storage/' . $booking->qr_code_path) }}" 
                                         alt="QR Code for Seat {{ $booking->seat->seat_number }}" 
                                         class="w-32 h-32">
                                </div>
                                <div class="space-y-2">
                                    <a href="{{ asset('storage/' . $booking->qr_code_path) }}" 
                                       download="STC-Ticket-{{ $booking->id }}.png"
                                       class="block w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                                        <i class="bi bi-download mr-2"></i> Download QR
                                    </a>
                                    <a href="{{ route('bookings.show', $booking) }}" 
                                       class="block w-full bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                                        <i class="bi bi-eye mr-2"></i> View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Important Information -->
        <div class="mt-8 bg-yellow-50 border border-yellow-200 rounded-lg p-6">
            <h4 class="text-lg font-semibold text-yellow-800 mb-3">Important Information</h4>
            <ul class="text-yellow-700 space-y-2">
                <li class="flex items-start">
                    <i class="bi bi-info-circle mr-2 mt-0.5 text-yellow-600"></i>
                    <span>Each passenger needs their own QR code for boarding verification</span>
                </li>
                <li class="flex items-start">
                    <i class="bi bi-clock mr-2 mt-0.5 text-yellow-600"></i>
                    <span>Arrive at the terminal at least 30 minutes before departure</span>
                </li>
                <li class="flex items-start">
                    <i class="bi bi-shield-check mr-2 mt-0.5 text-yellow-600"></i>
                    <span>Keep all QR codes safe until your journey is complete</span>
                </li>
                <li class="flex items-start">
                    <i class="bi bi-telephone mr-2 mt-0.5 text-yellow-600"></i>
                    <span>Contact support if you need to make changes to your bookings</span>
                </li>
            </ul>
        </div>

        <!-- Action Buttons -->
        <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="{{ route('book.tickets') }}" 
               class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg text-center font-medium transition">
                <i class="bi bi-plus-circle mr-2"></i> Book More Trips
            </a>
            <a href="{{ route('user.bookings') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg text-center font-medium transition">
                <i class="bi bi-list-ul mr-2"></i> View All Bookings
            </a>
            <a href="/" 
               class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg text-center font-medium transition">
                <i class="bi bi-house mr-2"></i> Back to Home
            </a>
        </div>

        <!-- Booking Summary -->
        <div class="mt-8 text-center text-sm text-gray-500">
            <p>Total Bookings: <span class="font-mono font-semibold">{{ $bookings->count() }}</span></p>
            <p>Booked on: {{ $bookings->first()->created_at->format('M d, Y \a\t H:i') }}</p>
        </div>
    </div>
</div>
@endsection 