@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="max-w-6xl mx-auto">
        <!-- Header Section -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2 flex items-center">
                        <i class="bi bi-ticket-perforated text-blue-600 mr-3"></i> My Bookings
                    </h1>
                    <p class="text-gray-600">Manage and track all your bus reservations</p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="bg-blue-50 text-blue-800 px-4 py-2 rounded-lg">
                        <div class="text-sm font-medium">Total Bookings</div>
                        <div class="text-2xl font-bold">{{ $bookings->count() }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter and Search Section -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <div class="flex flex-col lg:flex-row gap-4 items-center justify-between">
                <div class="flex flex-wrap gap-3">
                    <button onclick="filterBookings('all')" 
                            class="filter-btn active px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 bg-blue-600 text-white">
                        All ({{ $bookings->count() }})
                    </button>
                    <button onclick="filterBookings('booked')" 
                            class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 bg-gray-100 text-gray-700 hover:bg-gray-200">
                        Booked ({{ $bookings->where('status', 'booked')->count() }})
                    </button>
                    <button onclick="filterBookings('checked-in')" 
                            class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 bg-gray-100 text-gray-700 hover:bg-gray-200">
                        Checked In ({{ $bookings->where('status', 'checked-in')->count() }})
                    </button>
                    <button onclick="filterBookings('cancelled')" 
                            class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 bg-gray-100 text-gray-700 hover:bg-gray-200">
                        Cancelled ({{ $bookings->where('status', 'cancelled')->count() }})
                    </button>
                </div>
                <div class="relative">
                    <input type="text" 
                           id="searchInput" 
                           placeholder="Search by route, seat, or booking ID..." 
                           class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent w-64">
                    <i class="bi bi-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
            </div>
        </div>

        <!-- Bookings Grid -->
        @if($bookings->count())
        <div id="bookingsGrid" class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach($bookings as $booking)
            <div class="booking-card bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1"
                 data-status="{{ $booking->status }}"
                 data-route="{{ strtolower($booking->trip->route->origin . ' ' . $booking->trip->route->destination) }}"
                 data-seat="{{ strtolower($booking->seat->seat_number) }}"
                 data-booking-id="{{ $booking->id }}">
                
                <!-- Status Badge -->
                <div class="relative">
                    <div class="absolute top-4 right-4 z-10">
                        <span class="px-3 py-1 text-xs rounded-full font-medium {{
                            $booking->status === 'booked' ? 'bg-blue-100 text-blue-800' :
                            ($booking->status === 'checked-in' ? 'bg-green-100 text-green-800' :
                            ($booking->status === 'cancelled' ? 'bg-red-100 text-red-800' :
                            'bg-gray-100 text-gray-700'))
                        }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </div>
                    
                    <!-- Route Header -->
                    <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white p-6">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-lg font-bold">{{ $booking->trip->route->origin }} → {{ $booking->trip->route->destination }}</h3>
                            <div class="text-right">
                                <div class="text-2xl font-bold">{{ $booking->seat->seat_number }}</div>
                                <div class="text-blue-100 text-sm">Seat</div>
                            </div>
                        </div>
                        <div class="flex items-center text-blue-100 text-sm">
                            <i class="bi bi-bus-front me-2"></i>
                            {{ $booking->trip->bus->name }}
                        </div>
                    </div>
                </div>

                <!-- Booking Details -->
                <div class="p-6">
                    <div class="space-y-4">
                        <!-- Date and Time -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-gray-600">
                                <i class="bi bi-calendar3 me-2"></i>
                                <span class="text-sm">{{ \Carbon\Carbon::parse($booking->trip->departure_date)->format('M d, Y') }}</span>
                            </div>
                            <div class="flex items-center text-gray-600">
                                <i class="bi bi-clock me-2"></i>
                                <span class="text-sm font-medium">{{ $booking->trip->departure_time }}</span>
                            </div>
                        </div>

                        <!-- Booking ID and Expiry -->
                        <div class="bg-gray-50 rounded-lg p-3">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-600">Booking ID:</span>
                                <span class="font-mono font-bold text-gray-800">#{{ $booking->id }}</span>
                            </div>
                            @if($booking->expires_at)
                            <div class="flex items-center justify-between text-sm mt-1">
                                <span class="text-gray-600">Expires:</span>
                                <span class="font-medium {{ $booking->isExpired() ? 'text-red-600' : 'text-green-600' }}">
                                    {{ $booking->expires_at->format('M d, g:i A') }}
                                </span>
                            </div>
                            @endif
                        </div>

                        <!-- Time Until Departure -->
                        @php
                            $departureTime = \Carbon\Carbon::parse($booking->trip->departure_date . ' ' . $booking->trip->departure_time);
                            $now = \Carbon\Carbon::now();
                            $timeUntilDeparture = $now->diffForHumans($departureTime, ['parts' => 2]);
                            $isPast = $departureTime->isPast();
                        @endphp
                        <div class="text-center">
                            @if($isPast)
                                <div class="text-red-600 text-sm font-medium">
                                    <i class="bi bi-exclamation-triangle me-1"></i>
                                    Trip Completed
                                </div>
                            @else
                                <div class="text-blue-600 text-sm font-medium">
                                    <i class="bi bi-clock-history me-1"></i>
                                    Departs {{ $timeUntilDeparture }}
                                </div>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-2 pt-2">
                            <a href="{{ route('bookings.show', $booking) }}" 
                               class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-center py-2 px-4 rounded-lg text-sm font-medium transition duration-200">
                                <i class="bi bi-eye me-1"></i> View Details
                            </a>
                            @if($booking->qr_code_path)
                            <a href="{{ asset('storage/' . $booking->qr_code_path) }}" 
                               download="STC-Ticket-{{ $booking->id }}.png"
                               class="bg-green-600 hover:bg-green-700 text-white py-2 px-3 rounded-lg text-sm font-medium transition duration-200">
                                <i class="bi bi-download"></i>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- No Results Message -->
        <div id="noResults" class="hidden bg-white rounded-lg shadow-lg p-12 text-center">
            <i class="bi bi-search text-4xl text-gray-400 mb-4"></i>
            <h3 class="text-lg font-semibold text-gray-600 mb-2">No bookings found</h3>
            <p class="text-gray-500">Try adjusting your search or filter criteria</p>
        </div>

        @else
        <!-- Empty State -->
        <div class="bg-white rounded-lg shadow-lg p-12 text-center">
            <i class="bi bi-emoji-frown text-6xl text-gray-400 mb-6"></i>
            <h3 class="text-xl font-semibold text-gray-600 mb-2">No bookings yet</h3>
            <p class="text-gray-500 mb-6">Start your journey by booking your first trip!</p>
            <a href="{{ route('routes.index') }}" 
               class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition duration-200">
                <i class="bi bi-plus-circle me-2"></i>
                Book Your First Trip
            </a>
        </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const bookingCards = document.querySelectorAll('.booking-card');
    const noResults = document.getElementById('noResults');
    const bookingsGrid = document.getElementById('bookingsGrid');
    const filterBtns = document.querySelectorAll('.filter-btn');

    let currentFilter = 'all';

    // Search functionality
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        filterAndSearch();
    });

    // Filter functionality
    function filterBookings(status) {
        currentFilter = status;
        
        // Update active button
        filterBtns.forEach(btn => {
            btn.classList.remove('active', 'bg-blue-600', 'text-white');
            btn.classList.add('bg-gray-100', 'text-gray-700');
        });
        
        event.target.classList.remove('bg-gray-100', 'text-gray-700');
        event.target.classList.add('active', 'bg-blue-600', 'text-white');
        
        filterAndSearch();
    }

    function filterAndSearch() {
        const searchTerm = searchInput.value.toLowerCase();
        let visibleCount = 0;

        bookingCards.forEach(card => {
            const status = card.dataset.status;
            const route = card.dataset.route;
            const seat = card.dataset.seat;
            const bookingId = card.dataset.bookingId;

            const matchesFilter = currentFilter === 'all' || status === currentFilter;
            const matchesSearch = route.includes(searchTerm) || 
                                seat.includes(searchTerm) || 
                                bookingId.includes(searchTerm);

            if (matchesFilter && matchesSearch) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        // Show/hide no results message
        if (visibleCount === 0) {
            noResults.classList.remove('hidden');
            bookingsGrid.classList.add('hidden');
        } else {
            noResults.classList.add('hidden');
            bookingsGrid.classList.remove('hidden');
        }
    }

    // Make filterBookings function global
    window.filterBookings = filterBookings;
});
</script>

<style>
.filter-btn.active {
    background-color: #2563eb !important;
    color: white !important;
}

.booking-card {
    border: 1px solid #e5e7eb;
}

.booking-card:hover {
    border-color: #3b82f6;
}
</style>
@endsection 