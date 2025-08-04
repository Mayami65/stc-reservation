@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6 md:py-8">
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-lg p-4 md:p-6 mb-6 md:mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-xl md:text-2xl lg:text-3xl font-bold text-gray-800 mb-2 flex items-center">
                    <i class="bi bi-speedometer2 text-red-600 mr-3"></i> Admin Dashboard
                </h1>
                <p class="text-gray-600 text-sm md:text-base">Manage your STC Bus Reservation system</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.scanner') }}" 
                   class="bg-green-600 hover:bg-green-700 text-white px-3 md:px-4 py-2 rounded-lg flex items-center transition duration-200 text-sm">
                    <i class="bi bi-qr-code-scan mr-2"></i>
                    QR Scanner
                </a>
                <div class="bg-red-50 text-red-800 px-3 md:px-4 py-2 rounded-lg">
                    <div class="text-xs md:text-sm font-medium">Admin Access</div>
                    <div class="text-lg font-bold">Active</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-6 md:mb-8">
        <div class="bg-white rounded-lg shadow-lg p-4 md:p-6 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs md:text-sm font-medium text-gray-600 mb-1">Total Users</p>
                    <p class="text-2xl md:text-3xl font-bold text-gray-800">{{ $stats['total_users'] }}</p>
                    <p class="text-xs text-green-600 mt-1">+12% from last month</p>
                </div>
                <div class="w-10 h-10 md:w-12 md:h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="bi bi-people text-blue-600 text-lg md:text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-lg p-4 md:p-6 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs md:text-sm font-medium text-gray-600 mb-1">Total Bookings</p>
                    <p class="text-2xl md:text-3xl font-bold text-gray-800">{{ $stats['total_bookings'] }}</p>
                    <p class="text-xs text-green-600 mt-1">+8% from last month</p>
                </div>
                <div class="w-10 h-10 md:w-12 md:h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="bi bi-ticket-perforated text-green-600 text-lg md:text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-lg p-4 md:p-6 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs md:text-sm font-medium text-gray-600 mb-1">Total Buses</p>
                    <p class="text-2xl md:text-3xl font-bold text-gray-800">{{ $stats['total_buses'] }}</p>
                    <p class="text-xs text-blue-600 mt-1">All operational</p>
                </div>
                <div class="w-10 h-10 md:w-12 md:h-12 bg-purple-100 rounded-full flex items-center justify-center">
                    <i class="bi bi-bus-front text-purple-600 text-lg md:text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-lg p-4 md:p-6 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs md:text-sm font-medium text-gray-600 mb-1">Total Routes</p>
                    <p class="text-2xl md:text-3xl font-bold text-gray-800">{{ $stats['total_routes'] }}</p>
                    <p class="text-xs text-orange-600 mt-1">Active routes</p>
                </div>
                <div class="w-10 h-10 md:w-12 md:h-12 bg-orange-100 rounded-full flex items-center justify-center">
                    <i class="bi bi-geo-alt text-orange-600 text-lg md:text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Today's Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6 mb-6 md:mb-8">
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white p-4 md:p-6 rounded-lg shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs md:text-sm opacity-90 mb-1">Today's Bookings</p>
                    <p class="text-2xl md:text-3xl font-bold">{{ $stats['today_bookings'] ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 md:w-12 md:h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                    <i class="bi bi-calendar-check text-white text-lg md:text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-r from-green-600 to-green-700 text-white p-4 md:p-6 rounded-lg shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs md:text-sm opacity-90 mb-1">Active Users</p>
                    <p class="text-2xl md:text-3xl font-bold">{{ $stats['active_users'] ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 md:w-12 md:h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                    <i class="bi bi-check-circle text-white text-lg md:text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-r from-purple-600 to-purple-700 text-white p-4 md:p-6 rounded-lg shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs md:text-sm opacity-90 mb-1">Pending Trips</p>
                    <p class="text-2xl md:text-3xl font-bold">{{ $stats['pending_trips'] ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 md:w-12 md:h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                    <i class="bi bi-clock text-white text-lg md:text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow-lg p-4 md:p-6 mb-6 md:mb-8">
        <h2 class="text-lg md:text-xl font-bold text-gray-800 mb-4 flex items-center">
            <i class="bi bi-lightning text-yellow-600 mr-2"></i>
            Quick Actions
        </h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('admin.routes.create') }}" class="bg-blue-50 hover:bg-blue-100 p-4 rounded-lg transition duration-200 text-center group">
                <i class="bi bi-plus-circle text-2xl mb-2 block text-blue-600 group-hover:scale-110 transition-transform"></i>
                <h3 class="font-semibold text-blue-800 text-sm md:text-base">Add Route</h3>
                <p class="text-blue-600 text-xs">Create new bus route</p>
            </a>
            <a href="{{ route('admin.buses.create') }}" class="bg-green-50 hover:bg-green-100 p-4 rounded-lg transition duration-200 text-center group">
                <i class="bi bi-bus-front text-2xl mb-2 block text-green-600 group-hover:scale-110 transition-transform"></i>
                <h3 class="font-semibold text-green-800 text-sm md:text-base">Add Bus</h3>
                <p class="text-green-600 text-xs">Register new bus</p>
            </a>
            <a href="{{ route('admin.trips.create') }}" class="bg-purple-50 hover:bg-purple-100 p-4 rounded-lg transition duration-200 text-center group">
                <i class="bi bi-calendar-plus text-2xl mb-2 block text-purple-600 group-hover:scale-110 transition-transform"></i>
                <h3 class="font-semibold text-purple-800 text-sm md:text-base">Schedule Trip</h3>
                <p class="text-purple-600 text-xs">Create new trip</p>
            </a>
            <a href="{{ route('admin.bookings.index') }}" class="bg-orange-50 hover:bg-orange-100 p-4 rounded-lg transition duration-200 text-center group">
                <i class="bi bi-list-ul text-2xl mb-2 block text-orange-600 group-hover:scale-110 transition-transform"></i>
                <h3 class="font-semibold text-orange-800 text-sm md:text-base">View Bookings</h3>
                <p class="text-orange-600 text-xs">Manage reservations</p>
            </a>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-8">
        <!-- Recent Bookings -->
        <div class="bg-white rounded-lg shadow-lg p-4 md:p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg md:text-xl font-bold text-gray-800 flex items-center">
                    <i class="bi bi-clock-history mr-2"></i>
                    Recent Bookings
                </h2>
                <a href="{{ route('admin.bookings.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">View All</a>
            </div>
            @if($recentBookings->count() > 0)
                <div class="space-y-3">
                    @foreach($recentBookings->take(5) as $booking)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                <i class="bi bi-person text-blue-600 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-800">{{ $booking->user->name }}</p>
                                <p class="text-xs text-gray-600">{{ $booking->trip->route->origin }} → {{ $booking->trip->route->destination }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-gray-500">{{ $booking->created_at->diffForHumans() }}</p>
                            <span class="inline-block px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <i class="bi bi-inbox text-4xl text-gray-300 mb-3"></i>
                    <p class="text-gray-500 text-sm">No recent bookings</p>
                </div>
            @endif
        </div>

        <!-- Upcoming Trips -->
        <div class="bg-white rounded-lg shadow-lg p-4 md:p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg md:text-xl font-bold text-gray-800 flex items-center">
                    <i class="bi bi-calendar-event mr-2"></i>
                    Upcoming Trips
                </h2>
                <a href="{{ route('admin.trips.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">View All</a>
            </div>
            @if($upcomingTrips->count() > 0)
                <div class="space-y-3">
                    @foreach($upcomingTrips->take(5) as $trip)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                <i class="bi bi-bus-front text-green-600 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-800">{{ $trip->route->origin }} → {{ $trip->route->destination }}</p>
                                <p class="text-xs text-gray-600">{{ $trip->departure_date }} at {{ $trip->departure_time }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-gray-500">{{ $trip->bus->name }}</p>
                            <span class="inline-block px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                                {{ $trip->bookings_count ?? 0 }}/{{ $trip->bus->seat_count }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <i class="bi bi-calendar-x text-4xl text-gray-300 mb-3"></i>
                    <p class="text-gray-500 text-sm">No upcoming trips</p>
                </div>
            @endif
        </div>
    </div>

    <!-- System Status -->
    <div class="mt-6 md:mt-8 bg-white rounded-lg shadow-lg p-4 md:p-6">
        <h2 class="text-lg md:text-xl font-bold text-gray-800 mb-4 flex items-center">
            <i class="bi bi-gear text-gray-600 mr-2"></i>
            System Status
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="flex items-center p-3 bg-green-50 rounded-lg">
                <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                <div>
                    <p class="text-sm font-medium text-gray-800">Database</p>
                    <p class="text-xs text-gray-600">All systems operational</p>
                </div>
            </div>
            <div class="flex items-center p-3 bg-green-50 rounded-lg">
                <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                <div>
                    <p class="text-sm font-medium text-gray-800">QR Generation</p>
                    <p class="text-xs text-gray-600">Working properly</p>
                </div>
            </div>
            <div class="flex items-center p-3 bg-green-50 rounded-lg">
                <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                <div>
                    <p class="text-sm font-medium text-gray-800">Booking System</p>
                    <p class="text-xs text-gray-600">Online and active</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
