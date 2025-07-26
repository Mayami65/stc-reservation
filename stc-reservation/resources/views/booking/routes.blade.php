@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 px-4">
    <!-- Header -->
    <div class="text-center mb-8">
        <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 mb-4 flex flex-col items-center justify-center">
            <i class="bi bi-geo-alt text-blue-600 mb-2 text-3xl sm:text-4xl"></i>
            Available Routes
        </h1>
        <p class="text-gray-600 text-base sm:text-lg">Choose your destination and start your journey with STC</p>
    </div>

    @if($routes->count() > 0)
        <!-- Routes Grid -->
        <div class="max-w-4xl mx-auto">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                @foreach($routes as $route)
                    <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-1 overflow-hidden flex flex-col">
                        <div class="p-6 flex-1 flex flex-col justify-between">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="bi bi-bus-front text-blue-600 text-lg sm:text-xl"></i>
                                    </div>
                                    <div class="ml-3 sm:ml-4">
                                        <h3 class="text-base sm:text-lg font-semibold text-gray-800">Route #{{ $route->id }}</h3>
                                        <p class="text-gray-600 text-xs sm:text-sm">STC Express Service</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">Available</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-center my-4 sm:my-6">
                                <div class="text-center">
                                    <div class="text-base sm:text-lg font-bold text-gray-800">{{ $route->origin }}</div>
                                    <div class="text-gray-500 text-xs sm:text-sm">Departure</div>
                                </div>
                                <div class="mx-4 sm:mx-6">
                                    <i class="bi bi-arrow-right text-blue-600 text-xl sm:text-2xl"></i>
                                </div>
                                <div class="text-center">
                                    <div class="text-base sm:text-lg font-bold text-gray-800">{{ $route->destination }}</div>
                                    <div class="text-gray-500 text-xs sm:text-sm">Arrival</div>
                                </div>
                            </div>
                            <div class="flex flex-col sm:flex-row items-center justify-between mb-4 gap-2 sm:gap-0">
                                <div class="text-xs sm:text-sm text-gray-600 flex items-center">
                                    <i class="bi bi-clock mr-1"></i>
                                    Multiple times daily
                                </div>
                                <div class="text-xs sm:text-sm text-gray-600 flex items-center">
                                    <i class="bi bi-people mr-1"></i>
                                    40-45 seats
                                </div>
                            </div>
                            <a href="{{ route('routes.trips', $route) }}" 
                               class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center py-2 sm:py-3 px-4 rounded-lg font-semibold transition duration-300 transform hover:scale-105 mt-4">
                                <i class="bi bi-calendar-check me-2"></i>
                                View Available Trips
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-16">
            <div class="max-w-md mx-auto">
                <i class="bi bi-geo text-gray-300 text-5xl sm:text-6xl mb-4"></i>
                <h3 class="text-lg sm:text-xl font-semibold text-gray-600 mb-2">No Routes Available</h3>
                <p class="text-gray-500 mb-6">Sorry, there are currently no routes available. Please check back later.</p>
                <a href="/" class="inline-block bg-blue-600 hover:bg-blue-700 text-white py-2 px-6 rounded-lg transition duration-300">
                    <i class="bi bi-house me-2"></i>
                    Back to Home
                </a>
            </div>
        </div>
    @endif

    <!-- Additional Info -->
    <div class="max-w-4xl mx-auto mt-12">
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <i class="bi bi-info-circle text-blue-600 text-xl"></i>
                </div>
                <div class="ml-3">
                    <h4 class="text-base sm:text-lg font-semibold text-blue-800 mb-2">Booking Information</h4>
                    <ul class="text-blue-700 text-xs sm:text-sm space-y-1">
                        <li>• Select your preferred route to view available trips and times</li>
                        <li>• Choose your seat from our interactive seat map</li>
                        <li>• Receive your QR code ticket instantly after booking</li>
                        <li>• Present your QR code at the terminal for quick check-in</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection