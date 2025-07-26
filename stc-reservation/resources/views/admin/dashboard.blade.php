@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Admin Dashboard</h1>
        <div class="flex space-x-4">
            <a href="{{ route('admin.scanner') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center">
                <!-- Heroicon: QrCode -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h4v4H4V4zm6 0h4v4h-4V4zm6 0h4v4h-4V4zM4 10h4v4H4v-4zm6 0h4v4h-4v-4zm6 0h4v4h-4v-4zM4 16h4v4H4v-4zm6 6h4v-4h-4v4zm6-6h4v4h-4v-4z"/></svg>
                QR Scanner
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-full">
                    <!-- Heroicon: Users -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-2a4 4 0 10-8 0 4 4 0 008 0zm6 2a4 4 0 00-3-3.87"/></svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Total Users</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['total_users'] }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-full">
                    <!-- Heroicon: Ticket -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a2 2 0 012-2h2a2 2 0 012 2v2m-6 0h6m-6 0a2 2 0 01-2-2v-2a2 2 0 012-2h6a2 2 0 012 2v2a2 2 0 01-2 2h-6z"/></svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Total Bookings</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['total_bookings'] }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-full">
                    <!-- Heroicon: Bus (use Truck as closest) -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a2 2 0 012-2h2a2 2 0 012 2v2m-6 0h6m-6 0a2 2 0 01-2-2v-2a2 2 0 012-2h6a2 2 0 012 2v2a2 2 0 01-2 2h-6z"/></svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Total Buses</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['total_buses'] }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-orange-100 rounded-full">
                    <!-- Heroicon: MapPin -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm0 0c-4.418 0-8 2.239-8 5v2a2 2 0 002 2h12a2 2 0 002-2v-2c0-2.761-3.582-5-8-5z"/></svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Total Routes</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['total_routes'] }}</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Today's Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Today's Bookings</h3>
            <p class="text-3xl font-bold text-blue-600">{{ $stats['bookings_today'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Checked In Today</h3>
            <p class="text-3xl font-bold text-green-600">{{ $stats['checked_in_today'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Upcoming Trips</h3>
            <p class="text-3xl font-bold text-purple-600">{{ $stats['upcoming_trips'] }}</p>
        </div>
    </div>
    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <a href="{{ route('admin.routes.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white p-4 rounded-lg text-center">
            <!-- Heroicon: PlusCircle -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 mb-2 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            Add Route
        </a>
        <a href="{{ route('admin.buses.create') }}" class="bg-green-600 hover:bg-green-700 text-white p-4 rounded-lg text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 mb-2 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            Add Bus
        </a>
        <a href="{{ route('admin.trips.create') }}" class="bg-purple-600 hover:bg-purple-700 text-white p-4 rounded-lg text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 mb-2 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            Add Trip
        </a>
        <a href="{{ route('admin.bookings.index') }}" class="bg-orange-600 hover:bg-orange-700 text-white p-4 rounded-lg text-center">
            <!-- Heroicon: ListBullet -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 mb-2 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" /></svg>
            View Bookings
        </a>
    </div>
    <!-- Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Bookings -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b">
                <h3 class="text-lg font-semibold text-gray-800">Recent Bookings</h3>
            </div>
            <div class="p-6">
                @forelse($recentBookings as $booking)
                <div class="flex items-center justify-between py-3 border-b last:border-b-0">
                    <div>
                        <p class="font-medium">{{ $booking->user->name }}</p>
                        <p class="text-sm text-gray-600">{{ $booking->trip->route->origin }} → {{ $booking->trip->route->destination }}</p>
                        <p class="text-xs text-gray-500">Seat: {{ $booking->seat->seat_number }}</p>
                    </div>
                    <div class="text-right">
                        @php
                            $statusClasses = match($booking->status) {
                                'booked' => 'bg-blue-100 text-blue-800',
                                'checked-in' => 'bg-green-100 text-green-800',
                                default => 'bg-red-100 text-red-800'
                            };
                        @endphp
                        <span class="px-2 py-1 text-xs rounded-full {{ $statusClasses }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                        <p class="text-xs text-gray-500 mt-1">{{ $booking->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                @empty
                <p class="text-gray-500 text-center py-4">No recent bookings</p>
                @endforelse
            </div>
        </div>
        <!-- Upcoming Trips -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b">
                <h3 class="text-lg font-semibold text-gray-800">Upcoming Trips</h3>
            </div>
            <div class="p-6">
                @forelse($upcomingTrips as $trip)
                <div class="flex items-center justify-between py-3 border-b last:border-b-0">
                    <div>
                        <p class="font-medium">{{ $trip->route->origin }} → {{ $trip->route->destination }}</p>
                        <p class="text-sm text-gray-600">{{ $trip->bus->name }}</p>
                        <p class="text-xs text-gray-500">{{ $trip->departure_date }} at {{ $trip->departure_time }}</p>
                    </div>
                    <div class="text-right">
                        <a href="{{ route('admin.trips.show', $trip) }}" class="text-blue-600 hover:text-blue-800 text-sm">
                            View Details
                        </a>
                    </div>
                </div>
                @empty
                <p class="text-gray-500 text-center py-4">No upcoming trips</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
