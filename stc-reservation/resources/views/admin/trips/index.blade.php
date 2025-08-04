@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2 flex items-center">
                        <i class="bi bi-calendar-week text-purple-600 mr-3"></i> Manage Trips
                    </h1>
                    <p class="text-gray-600">Schedule and manage bus trips for your routes</p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="bg-purple-50 text-purple-800 px-4 py-2 rounded-lg">
                        <div class="text-sm font-medium">Total Trips</div>
                        <div class="text-2xl font-bold">{{ $trips->count() }}</div>
                    </div>
                    <a href="{{ route('admin.trips.create') }}" 
                       class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-semibold transition duration-200 flex items-center">
                        <i class="bi bi-plus-circle mr-2"></i>
                        Add New Trip
                    </a>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                <div class="flex items-center">
                    <i class="bi bi-check-circle text-xl mr-2"></i>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <!-- Trips Grid -->
        @if($trips->count() > 0)
        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6 mb-8">
            @foreach($trips as $trip)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <!-- Trip Header -->
                <div class="bg-gradient-to-r from-purple-600 to-purple-700 text-white p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                                <i class="bi bi-bus-front text-white text-lg"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-lg font-bold">Trip #{{ $trip->id }}</h3>
                                <p class="text-purple-100 text-sm">{{ $trip->bus->name }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            @if($trip->departure_date < now()->toDateString())
                                <span class="inline-block bg-gray-400 text-gray-900 text-xs px-2 py-1 rounded-full font-medium">
                                    <i class="bi bi-check-circle me-1"></i>Completed
                                </span>
                            @elseif($trip->departure_date == now()->toDateString())
                                <span class="inline-block bg-yellow-400 text-yellow-900 text-xs px-2 py-1 rounded-full font-medium">
                                    <i class="bi bi-clock me-1"></i>Today
                                </span>
                            @else
                                <span class="inline-block bg-green-400 text-green-900 text-xs px-2 py-1 rounded-full font-medium">
                                    <i class="bi bi-calendar-check me-1"></i>Upcoming
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Route Path -->
                    <div class="flex items-center justify-center mb-4">
                        <div class="text-center">
                            <div class="text-lg font-bold">{{ $trip->route->origin }}</div>
                            <div class="text-purple-100 text-xs">Origin</div>
                        </div>
                        <div class="mx-4">
                            <i class="bi bi-arrow-right text-2xl"></i>
                        </div>
                        <div class="text-center">
                            <div class="text-lg font-bold">{{ $trip->route->destination }}</div>
                            <div class="text-purple-100 text-xs">Destination</div>
                        </div>
                    </div>
                </div>

                <!-- Trip Details -->
                <div class="p-6">
                    <div class="space-y-4">
                        <!-- Trip Statistics -->
                        <div class="grid grid-cols-3 gap-4 text-sm">
                            <div class="bg-gray-50 rounded-lg p-3 text-center">
                                <div class="text-gray-600 mb-1">Date</div>
                                <div class="font-bold text-gray-800">{{ \Carbon\Carbon::parse($trip->departure_date)->format('M j, Y') }}</div>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-3 text-center">
                                <div class="text-gray-600 mb-1">Time</div>
                                <div class="font-bold text-gray-800">{{ \Carbon\Carbon::parse($trip->departure_time)->format('g:i A') }}</div>
                            </div>
                            <div class="bg-green-50 rounded-lg p-3 text-center border border-green-200">
                                <div class="text-green-600 mb-1">Price</div>
                                <div class="font-bold text-green-800 text-lg">₵{{ number_format($trip->route->price, 2) }}</div>
                            </div>
                        </div>

                        <!-- Booking Status -->
                        <div class="bg-blue-50 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="text-sm font-medium text-blue-800">Bookings</div>
                                    <div class="text-lg font-bold text-blue-900">{{ $trip->bookings_count ?? 0 }} / {{ $trip->bus->seat_count }}</div>
                                </div>
                                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                                    @php
                                        $percentage = $trip->bus->seat_count > 0 ? (($trip->bookings_count ?? 0) / $trip->bus->seat_count) * 100 : 0;
                                    @endphp
                                    <div class="text-blue-600 font-bold text-sm">{{ round($percentage) }}%</div>
                                </div>
                            </div>
                            <div class="mt-2 w-full bg-blue-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full progress-bar" data-percentage="{{ $percentage }}"></div>
                            </div>
                        </div>

                        <!-- Trip Features -->
                        <div class="space-y-2">
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="bi bi-calendar-week me-2 text-purple-600"></i>
                                <span>{{ \Carbon\Carbon::parse($trip->departure_date)->format('l, M j') }}</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="bi bi-clock me-2 text-purple-600"></i>
                                <span>Departure at {{ \Carbon\Carbon::parse($trip->departure_time)->format('g:i A') }}</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="bi bi-people me-2 text-purple-600"></i>
                                <span>{{ $trip->bus->seat_count }} seats available</span>
                            </div>
                            <div class="flex items-center text-sm text-green-600">
                                <i class="bi bi-currency-dollar me-2 text-green-600"></i>
                                <span>₵{{ number_format($trip->route->price, 2) }} per seat</span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-2 pt-2">
                            <a href="{{ route('admin.trips.show', $trip) }}" 
                               class="flex-1 bg-purple-600 hover:bg-purple-700 text-white text-center py-2 px-4 rounded-lg text-sm font-medium transition duration-200">
                                <i class="bi bi-eye me-1"></i> View Details
                            </a>
                            <a href="{{ route('admin.trips.edit', $trip) }}" 
                               class="bg-yellow-600 hover:bg-yellow-700 text-white py-2 px-3 rounded-lg text-sm font-medium transition duration-200">
                                <i class="bi bi-pencil"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @else
        <!-- Empty State -->
        <div class="bg-white rounded-lg shadow-lg p-12 text-center">
            <i class="bi bi-calendar-x text-6xl text-gray-400 mb-6"></i>
            <h3 class="text-xl font-semibold text-gray-600 mb-2">No Trips Scheduled</h3>
            <p class="text-gray-500 mb-6">Start by creating your first bus trip</p>
            <a href="{{ route('admin.trips.create') }}" 
               class="inline-flex items-center bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-medium transition duration-200">
                <i class="bi bi-plus-circle me-2"></i>
                Schedule First Trip
            </a>
        </div>
        @endif

        <!-- Trip Management Info -->
        <div class="mt-8 bg-gradient-to-r from-purple-50 to-indigo-50 rounded-lg shadow-lg p-8">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Trip Management</h2>
                <p class="text-gray-600">Efficiently schedule and monitor your bus trips</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center">
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="bi bi-calendar-plus text-purple-600 text-xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-2">Schedule Trips</h3>
                    <p class="text-gray-600 text-sm">Create new trips for your routes</p>
                </div>
                
                <div class="text-center">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="bi bi-eye text-green-600 text-xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-2">Monitor Bookings</h3>
                    <p class="text-gray-600 text-sm">Track passenger reservations</p>
                </div>
                
                <div class="text-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="bi bi-pencil text-blue-600 text-xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-2">Update Details</h3>
                    <p class="text-gray-600 text-sm">Modify trip information as needed</p>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        @if($trips->hasPages())
        <div class="mt-8 bg-white rounded-lg shadow-lg p-4">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Showing {{ $trips->firstItem() ?? 0 }} to {{ $trips->lastItem() ?? 0 }} of {{ $trips->total() }} results
                </div>
                <div>
                    {{ $trips->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const progressBars = document.querySelectorAll('.progress-bar');
    progressBars.forEach(bar => {
        const percentage = bar.getAttribute('data-percentage');
        bar.style.width = percentage + '%';
    });
});
</script>

@endsection 