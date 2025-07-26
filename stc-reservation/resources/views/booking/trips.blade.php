@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 px-4">
    <!-- Header -->
    <div class="max-w-4xl mx-auto">
        <!-- Breadcrumb -->
        <nav class="mb-6">
            <ol class="flex flex-wrap items-center space-x-2 text-xs sm:text-sm text-gray-600">
                <li><a href="{{ route('routes.index') }}" class="hover:text-blue-600 transition">Available Routes</a></li>
                <li><i class="bi bi-chevron-right"></i></li>
                <li class="text-gray-800 font-medium">{{ $route->origin }} → {{ $route->destination }}</li>
            </ol>
        </nav>
        <div class="text-center mb-8">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                <i class="bi bi-calendar-week text-blue-600 me-2"></i>
                Available Trips
            </h1>
            <div class="inline-flex items-center bg-blue-50 text-blue-800 px-4 py-2 rounded-lg text-xs sm:text-base">
                <i class="bi bi-geo-alt me-2"></i>
                <span class="font-semibold">{{ $route->origin }}</span>
                <i class="bi bi-arrow-right mx-3 text-blue-600"></i>
                <span class="font-semibold">{{ $route->destination }}</span>
            </div>
        </div>
        @if($trips->count() > 0)
            <!-- Trips List -->
            <div class="space-y-4">
                @foreach($trips as $trip)
                    @php
                        $departureDate = \Carbon\Carbon::parse($trip->departure_date);
                        $departureTime = \Carbon\Carbon::parse($trip->departure_time);
                        $isToday = $departureDate->isToday();
                        $isPast = $departureDate->isPast();
                        $totalSeats = $trip->bus?->seat_count ?? 0;
                        $bookedSeats = $trip->bookings()->count();
                        $availableSeats = $totalSeats - $bookedSeats;
                        $occupancyPercentage = $totalSeats > 0 ? ($bookedSeats / $totalSeats) * 100 : 0;
                    @endphp
                    <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition duration-300 {{ $isPast ? 'opacity-60' : '' }} flex flex-col md:flex-row md:items-center md:justify-between">
                        <div class="p-6 flex-1">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                                <!-- Trip Info -->
                                <div class="flex-1">
                                    <div class="flex flex-col sm:flex-row items-center mb-3 gap-3 sm:gap-0">
                                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white">
                                            <i class="bi bi-bus-front text-lg sm:text-xl"></i>
                                        </div>
                                        <div class="ml-0 sm:ml-4 mt-2 sm:mt-0 text-center sm:text-left">
                                            <h3 class="text-base sm:text-lg font-bold text-gray-800">
                                                {{ $trip->bus?->name ?? 'Bus Not Assigned' }}
                                            </h3>
                                            <p class="text-gray-600 text-xs sm:text-sm">STC Express Service</p>
                                        </div>
                                        @if($isToday)
                                            <span class="ml-0 sm:ml-3 mt-2 sm:mt-0 inline-block bg-orange-100 text-orange-800 text-xs px-2 py-1 rounded-full">Today</span>
                                        @endif
                                        @if($isPast)
                                            <span class="ml-0 sm:ml-3 mt-2 sm:mt-0 inline-block bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded-full">Past</span>
                                        @endif
                                    </div>
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                                        <div>
                                            <div class="text-xs sm:text-sm text-gray-600 mb-1">
                                                <i class="bi bi-calendar3 me-1"></i>Date
                                            </div>
                                            <div class="font-semibold text-gray-800">
                                                {{ $departureDate->format('M j, Y') }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                {{ $departureDate->format('l') }}
                                            </div>
                                        </div>
                                        <div>
                                            <div class="text-xs sm:text-sm text-gray-600 mb-1">
                                                <i class="bi bi-clock me-1"></i>Departure
                                            </div>
                                            <div class="font-semibold text-gray-800">
                                                {{ $departureTime->format('g:i A') }}
                                            </div>
                                        </div>
                                        <div>
                                            <div class="text-xs sm:text-sm text-gray-600 mb-1">
                                                <i class="bi bi-people me-1"></i>Available Seats
                                            </div>
                                            <div class="font-semibold {{ $availableSeats <= 5 ? 'text-red-600' : 'text-green-600' }}">
                                                {{ $availableSeats }} / {{ $totalSeats }}
                                            </div>
                                        </div>
                                        <div>
                                            <div class="text-xs sm:text-sm text-gray-600 mb-1">
                                                <i class="bi bi-speedometer me-1"></i>Occupancy
                                            </div>
                                            <div class="flex items-center">
                                                <div class="w-16 bg-gray-200 rounded-full h-2 mr-2">
                                                    <div class="h-2 rounded-full {{ $occupancyPercentage >= 80 ? 'bg-red-500' : ($occupancyPercentage >= 60 ? 'bg-yellow-500' : 'bg-green-500') }}" 
                                                         style="--width: {{ $occupancyPercentage }}%; width: var(--width);"></div>
                                                </div>
                                                <span class="text-xs text-gray-600">{{ round($occupancyPercentage) }}%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Action Button -->
                                <div class="md:ml-6 mt-4 md:mt-0 flex-shrink-0">
                                    @if($isPast)
                                        <button disabled class="w-full md:w-auto bg-gray-300 text-gray-600 py-2 px-4 rounded-lg font-semibold cursor-not-allowed text-xs sm:text-sm">
                                            <i class="bi bi-clock-history me-2"></i>
                                            Trip Completed
                                        </button>
                                    @elseif($availableSeats <= 0)
                                        <button disabled class="w-full md:w-auto bg-red-100 text-red-600 py-2 px-4 rounded-lg font-semibold cursor-not-allowed text-xs sm:text-sm">
                                            <i class="bi bi-x-circle me-2"></i>
                                            Fully Booked
                                        </button>
                                    @else
                                        <a href="{{ route('trips.seats', $trip) }}" 
                                           class="block w-full md:w-auto text-center bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg font-semibold transition duration-300 transform hover:scale-105 text-xs sm:text-sm">
                                            <i class="bi bi-grid-1x2 me-2"></i>
                                            Select Seat
                                            @if($availableSeats <= 5)
                                                <span class="ml-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full">{{ $availableSeats }} left</span>
                                            @endif
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="max-w-md mx-auto">
                    <i class="bi bi-calendar-x text-gray-300 text-5xl sm:text-6xl mb-4"></i>
                    <h3 class="text-lg sm:text-xl font-semibold text-gray-600 mb-2">No Trips Available</h3>
                    <p class="text-gray-500 mb-6">Sorry, there are currently no trips scheduled for this route. Please try another route or check back later.</p>
                    <a href="{{ route('routes.index') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white py-2 px-6 rounded-lg transition duration-300">
                        <i class="bi bi-arrow-left me-2"></i>
                        Back to Routes
                    </a>
                </div>
            </div>
        @endif
        <!-- Back Button -->
        @if($trips->count() > 0)
            <div class="text-center mt-8">
                <a href="{{ route('routes.index') }}" 
                   class="inline-block bg-gray-100 hover:bg-gray-200 text-gray-700 py-2 px-6 rounded-lg transition duration-300 text-xs sm:text-sm">
                    <i class="bi bi-arrow-left me-2"></i>
                    Back to All Routes
                </a>
            </div>
        @endif
    </div>
</div>
@endsection