@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2 flex items-center">
                        <i class="bi bi-speedometer2 text-red-600 mr-3"></i> Admin Dashboard
                    </h1>
                    <p class="text-gray-600">Manage your STC Bus Reservation system</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.scanner') }}" 
                       class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center transition duration-200">
                        <i class="bi bi-qr-code-scan mr-2"></i>
                        QR Scanner
                    </a>
                    <div class="bg-red-50 text-red-800 px-4 py-2 rounded-lg">
                        <div class="text-sm font-medium">Admin Access</div>
                        <div class="text-lg font-bold">Active</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Total Users</p>
                        <p class="text-3xl font-bold text-gray-800">{{ $stats['total_users'] }}</p>
                        <p class="text-xs text-green-600 mt-1">+12% from last month</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="bi bi-people text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Total Bookings</p>
                        <p class="text-3xl font-bold text-gray-800">{{ $stats['total_bookings'] }}</p>
                        <p class="text-xs text-green-600 mt-1">+8% from last month</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="bi bi-ticket-perforated text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Total Buses</p>
                        <p class="text-3xl font-bold text-gray-800">{{ $stats['total_buses'] }}</p>
                        <p class="text-xs text-blue-600 mt-1">All operational</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                        <i class="bi bi-bus-front text-purple-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Total Routes</p>
                        <p class="text-3xl font-bold text-gray-800">{{ $stats['total_routes'] }}</p>
                        <p class="text-xs text-orange-600 mt-1">Active routes</p>
                    </div>
                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                        <i class="bi bi-geo-alt text-orange-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Today's Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg shadow-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-medium mb-1">Today's Bookings</p>
                        <p class="text-3xl font-bold">{{ $stats['bookings_today'] }}</p>
                        <p class="text-blue-100 text-xs mt-1">New reservations</p>
                    </div>
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <i class="bi bi-calendar-check text-white text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg shadow-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm font-medium mb-1">Checked In Today</p>
                        <p class="text-3xl font-bold">{{ $stats['checked_in_today'] }}</p>
                        <p class="text-green-100 text-xs mt-1">Passengers boarded</p>
                    </div>
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <i class="bi bi-check-circle text-white text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-purple-500 to-purple-600 text-white rounded-lg shadow-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm font-medium mb-1">Upcoming Trips</p>
                        <p class="text-3xl font-bold">{{ $stats['upcoming_trips'] }}</p>
                        <p class="text-purple-100 text-xs mt-1">Scheduled departures</p>
                    </div>
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <i class="bi bi-clock text-white text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <i class="bi bi-lightning text-yellow-600 mr-2"></i>
                Quick Actions
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('admin.routes.create') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white p-4 rounded-lg text-center transition duration-200 transform hover:scale-105">
                    <i class="bi bi-plus-circle text-2xl mb-2 block"></i>
                    <div class="font-semibold">Add Route</div>
                    <div class="text-blue-100 text-xs">Create new route</div>
                </a>
                
                <a href="{{ route('admin.buses.create') }}" 
                   class="bg-green-600 hover:bg-green-700 text-white p-4 rounded-lg text-center transition duration-200 transform hover:scale-105">
                    <i class="bi bi-bus-front text-2xl mb-2 block"></i>
                    <div class="font-semibold">Add Bus</div>
                    <div class="text-green-100 text-xs">Register new bus</div>
                </a>
                
                <a href="{{ route('admin.trips.create') }}" 
                   class="bg-purple-600 hover:bg-purple-700 text-white p-4 rounded-lg text-center transition duration-200 transform hover:scale-105">
                    <i class="bi bi-calendar-plus text-2xl mb-2 block"></i>
                    <div class="font-semibold">Add Trip</div>
                    <div class="text-purple-100 text-xs">Schedule new trip</div>
                </a>
                
                <a href="{{ route('admin.bookings.index') }}" 
                   class="bg-orange-600 hover:bg-orange-700 text-white p-4 rounded-lg text-center transition duration-200 transform hover:scale-105">
                    <i class="bi bi-list-ul text-2xl mb-2 block"></i>
                    <div class="font-semibold">View Bookings</div>
                    <div class="text-orange-100 text-xs">Manage reservations</div>
                </a>
            </div>
        </div>

        <!-- Recent Activity Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Recent Bookings -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white p-6">
                    <h3 class="text-lg font-semibold flex items-center">
                        <i class="bi bi-clock-history mr-2"></i>
                        Recent Bookings
                    </h3>
                    <p class="text-blue-100 text-sm">Latest reservations made by users</p>
                </div>
                <div class="p-6">
                    @forelse($recentBookings as $booking)
                    <div class="flex items-center justify-between py-4 border-b border-gray-100 last:border-b-0 hover:bg-gray-50 rounded-lg px-3 transition duration-200">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="bi bi-person text-blue-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">{{ $booking->user->name }}</p>
                                <p class="text-sm text-gray-600">{{ $booking->trip->route->origin }} → {{ $booking->trip->route->destination }}</p>
                                <p class="text-xs text-gray-500">Seat: {{ $booking->seat->seat_number }} • {{ $booking->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            @php
                                $statusClasses = match($booking->status) {
                                    'booked' => 'bg-blue-100 text-blue-800',
                                    'checked-in' => 'bg-green-100 text-green-800',
                                    'cancelled' => 'bg-red-100 text-red-800',
                                    default => 'bg-gray-100 text-gray-800'
                                };
                            @endphp
                            <span class="px-3 py-1 text-xs rounded-full font-medium {{ $statusClasses }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8">
                        <i class="bi bi-inbox text-4xl text-gray-300 mb-3"></i>
                        <p class="text-gray-500">No recent bookings</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Upcoming Trips -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-green-600 to-green-700 text-white p-6">
                    <h3 class="text-lg font-semibold flex items-center">
                        <i class="bi bi-calendar-event mr-2"></i>
                        Upcoming Trips
                    </h3>
                    <p class="text-green-100 text-sm">Scheduled departures in the next few days</p>
                </div>
                <div class="p-6">
                    @forelse($upcomingTrips as $trip)
                    <div class="flex items-center justify-between py-4 border-b border-gray-100 last:border-b-0 hover:bg-gray-50 rounded-lg px-3 transition duration-200">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="bi bi-bus-front text-green-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">{{ $trip->route->origin }} → {{ $trip->route->destination }}</p>
                                <p class="text-sm text-gray-600">{{ $trip->bus->name }}</p>
                                <p class="text-xs text-gray-500">{{ $trip->departure_date }} at {{ $trip->departure_time }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <a href="{{ route('admin.trips.show', $trip) }}" 
                               class="text-green-600 hover:text-green-800 text-sm font-medium">
                                View Details
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8">
                        <i class="bi bi-calendar-x text-4xl text-gray-300 mb-3"></i>
                        <p class="text-gray-500">No upcoming trips</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- System Status -->
        <div class="mt-8 bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <i class="bi bi-gear text-gray-600 mr-2"></i>
                System Status
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="flex items-center p-3 bg-green-50 rounded-lg">
                    <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                    <div>
                        <p class="font-medium text-gray-800">Database</p>
                        <p class="text-sm text-gray-600">All systems operational</p>
                    </div>
                </div>
                <div class="flex items-center p-3 bg-green-50 rounded-lg">
                    <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                    <div>
                        <p class="font-medium text-gray-800">QR Generation</p>
                        <p class="text-sm text-gray-600">Working properly</p>
                    </div>
                </div>
                <div class="flex items-center p-3 bg-green-50 rounded-lg">
                    <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                    <div>
                        <p class="font-medium text-gray-800">Booking System</p>
                        <p class="text-sm text-gray-600">Active and responsive</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
