@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6 md:py-8">
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-lg p-4 md:p-6 mb-6 md:mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-xl md:text-2xl lg:text-3xl font-bold text-gray-800 mb-2 flex items-center">
                    <i class="bi bi-ticket-perforated text-blue-600 mr-3"></i> My Bookings
                </h1>
                <p class="text-gray-600 text-sm md:text-base">Manage and track all your bus reservations</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="bg-blue-50 text-blue-800 px-3 md:px-4 py-2 rounded-lg">
                    <div class="text-xs md:text-sm font-medium">Total Bookings</div>
                    <div class="text-xl md:text-2xl font-bold">{{ $bookings->count() }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="bg-white rounded-lg shadow-lg p-4 md:p-6 mb-6 md:mb-8">
        <div class="flex flex-col lg:flex-row gap-4 items-center justify-between">
            <div class="flex flex-wrap gap-2 md:gap-3 w-full lg:w-auto">
                <button onclick="filterBookings('all')" 
                        class="filter-btn active px-3 md:px-4 py-2 rounded-lg text-xs md:text-sm font-medium transition-all duration-200 bg-blue-600 text-white">
                    All ({{ $bookings->count() }})
                </button>
                <button onclick="filterBookings('booked')" 
                        class="filter-btn px-3 md:px-4 py-2 rounded-lg text-xs md:text-sm font-medium transition-all duration-200 bg-gray-100 text-gray-700 hover:bg-gray-200">
                    Booked ({{ $bookings->where('status', 'booked')->count() }})
                </button>
                <button onclick="filterBookings('checked-in')" 
                        class="filter-btn px-3 md:px-4 py-2 rounded-lg text-xs md:text-sm font-medium transition-all duration-200 bg-gray-100 text-gray-700 hover:bg-gray-200">
                    Checked In ({{ $bookings->where('status', 'checked-in')->count() }})
                </button>
                <button onclick="filterBookings('cancelled')" 
                        class="filter-btn px-3 md:px-4 py-2 rounded-lg text-xs md:text-sm font-medium transition-all duration-200 bg-gray-100 text-gray-700 hover:bg-gray-200">
                    Cancelled ({{ $bookings->where('status', 'cancelled')->count() }})
                </button>
            </div>
            <div class="relative w-full lg:w-auto">
                <input type="text" 
                       id="searchInput" 
                       placeholder="Search by route, seat, or booking ID..." 
                       class="w-full lg:w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                <i class="bi bi-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            </div>
        </div>
    </div>

    <!-- Bookings Grid -->
    <div id="bookingsGrid" class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-4 md:gap-6">
        @foreach($bookings as $booking)
        <div class="booking-card bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1"
             data-status="{{ $booking->status }}"
             data-route="{{ strtolower($booking->trip->route->origin . ' ' . $booking->trip->route->destination) }}"
             data-seat="{{ strtolower($booking->seat->seat_number) }}"
             data-booking-id="{{ $booking->id }}">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white p-4 md:p-6">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-sm md:text-lg font-bold">{{ $booking->trip->route->origin }} → {{ $booking->trip->route->destination }}</h3>
                    <div class="text-right">
                        <div class="text-xl md:text-2xl font-bold">{{ $booking->seat->seat_number }}</div>
                        <div class="text-blue-100 text-xs">Seat</div>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center text-xs md:text-sm">
                        <i class="bi bi-bus-front me-2"></i>
                        <span>{{ $booking->trip->bus->name }}</span>
                    </div>
                    <div class="text-right text-xs md:text-sm">
                        <div class="font-semibold">{{ \Carbon\Carbon::parse($booking->trip->departure_date)->format('M j, Y') }}</div>
                        <div class="text-blue-100">{{ \Carbon\Carbon::parse($booking->trip->departure_time)->format('g:i A') }}</div>
                    </div>
                </div>
            </div>
            <div class="p-4 md:p-6">
                <div class="space-y-3 md:space-y-4">
                    <!-- Status and Info -->
                    <div class="flex items-center justify-between">
                        <span class="px-2 py-1 text-xs rounded-full font-medium status-badge status-{{ $booking->status }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                        <div class="text-xs text-gray-500">
                            ID: {{ $booking->id }}
                        </div>
                    </div>

                    <!-- Trip Details -->
                    <div class="space-y-2">
                        <div class="flex items-center text-xs md:text-sm text-gray-600">
                            <i class="bi bi-calendar3 me-2"></i>
                            <span>{{ \Carbon\Carbon::parse($booking->trip->departure_date)->format('l, M j, Y') }}</span>
                        </div>
                        <div class="flex items-center text-xs md:text-sm text-gray-600">
                            <i class="bi bi-clock me-2"></i>
                            <span>Departure: {{ \Carbon\Carbon::parse($booking->trip->departure_time)->format('g:i A') }}</span>
                        </div>
                    </div>

                    <!-- Trip Status Indicators -->
                    @if($booking->trip->departure_date < now()->toDateString())
                        <div class="flex items-center text-xs text-gray-500">
                            <i class="bi bi-check-circle me-1"></i>
                            <span>Trip completed</span>
                        </div>
                    @elseif($booking->trip->departure_date == now()->toDateString())
                        <div class="flex items-center text-xs text-orange-600">
                            <i class="bi bi-exclamation-triangle me-1"></i>
                            <span>Trip today - arrive early!</span>
                        </div>
                    @else
                        <div class="flex items-center text-xs text-green-600">
                            <i class="bi bi-clock-history me-1"></i>
                            <span>Upcoming trip</span>
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="flex gap-2 pt-2">
                        <a href="{{ route('bookings.show', $booking) }}" 
                           class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-center py-2 px-3 md:px-4 rounded-lg text-xs md:text-sm font-medium transition duration-200">
                            <i class="bi bi-eye me-1"></i> View Details
                        </a>
                        @if($booking->qr_code_path)
                        <a href="{{ asset('storage/' . $booking->qr_code_path) }}" 
                           download="STC-Ticket-{{ $booking->id }}.png"
                           class="bg-green-600 hover:bg-green-700 text-white py-2 px-3 rounded-lg text-xs md:text-sm font-medium transition duration-200">
                            <i class="bi bi-download"></i>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Empty State -->
    <div id="emptyState" class="hidden text-center py-12">
        <div class="max-w-md mx-auto">
            <i class="bi bi-search text-4xl text-gray-400 mb-4"></i>
            <h3 class="text-lg font-semibold text-gray-600 mb-2">No bookings found</h3>
            <p class="text-gray-500 text-sm">Try adjusting your search or filter criteria.</p>
        </div>
    </div>

    <!-- No Results State -->
    <div id="noResults" class="hidden text-center py-12">
        <div class="max-w-md mx-auto">
            <i class="bi bi-emoji-frown text-6xl text-gray-400 mb-6"></i>
            <h3 class="text-lg font-semibold text-gray-600 mb-2">No matching bookings</h3>
            <p class="text-gray-500 text-sm mb-4">We couldn't find any bookings matching your search.</p>
            <button onclick="clearSearch()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm">
                <i class="bi bi-plus-circle me-2"></i>
                Show All Bookings
            </button>
        </div>
    </div>

    <!-- No Bookings State -->
    @if($bookings->count() === 0)
    <div class="text-center py-12">
        <div class="max-w-md mx-auto">
            <i class="bi bi-emoji-frown text-6xl text-gray-400 mb-6"></i>
            <h3 class="text-lg font-semibold text-gray-600 mb-2">No bookings yet</h3>
            <p class="text-gray-500 text-sm mb-6">You haven't made any bookings yet. Start your journey with STC!</p>
                            <a href="{{ route('book.tickets') }}" class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition duration-200">
                <i class="bi bi-plus-circle me-2"></i>
                Book Your First Trip
            </a>
        </div>
    </div>
    @endif
</div>

<script>
    let currentFilter = 'all';
    let searchTerm = '';

    function filterBookings(filter) {
        currentFilter = filter;
        updateActiveFilterButton();
        filterAndSearch();
    }

    function updateActiveFilterButton() {
        // Remove active class from all filter buttons
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.classList.remove('active', 'bg-blue-600', 'text-white');
            btn.classList.add('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');
        });

        // Add active class to current filter button
        const activeButton = document.querySelector(`[onclick="filterBookings('${currentFilter}')"]`);
        if (activeButton) {
            activeButton.classList.remove('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');
            activeButton.classList.add('active', 'bg-blue-600', 'text-white');
        }
    }

    function filterAndSearch() {
        const bookingCards = document.querySelectorAll('.booking-card');
        let visibleCount = 0;

        bookingCards.forEach(card => {
            const status = card.dataset.status;
            const route = card.dataset.route;
            const seat = card.dataset.seat;
            const bookingId = card.dataset.bookingId;

            let showCard = true;

            // Apply filter
            if (currentFilter !== 'all' && status !== currentFilter) {
                showCard = false;
            }

            // Apply search
            if (searchTerm && showCard) {
                const searchLower = searchTerm.toLowerCase();
                const matchesSearch = route.includes(searchLower) || 
                                    seat.includes(searchLower) || 
                                    bookingId.includes(searchTerm);
                if (!matchesSearch) showCard = false;
            }

            // Show/hide card
            if (showCard) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        // Show/hide empty states
        const emptyState = document.getElementById('emptyState');
        const noResults = document.getElementById('noResults');
        const bookingsGrid = document.getElementById('bookingsGrid');

        if (visibleCount === 0) {
            bookingsGrid.style.display = 'none';
            if (searchTerm) {
                noResults.classList.remove('hidden');
                emptyState.classList.add('hidden');
            } else {
                emptyState.classList.remove('hidden');
                noResults.classList.add('hidden');
            }
        } else {
            bookingsGrid.style.display = 'grid';
            emptyState.classList.add('hidden');
            noResults.classList.add('hidden');
        }
    }

    function clearSearch() {
        document.getElementById('searchInput').value = '';
        searchTerm = '';
        currentFilter = 'all';
        updateActiveFilterButton();
        filterAndSearch();
    }

    // Search input event listener
    document.getElementById('searchInput').addEventListener('input', function(e) {
        searchTerm = e.target.value;
        filterAndSearch();
    });

    // Initialize
    updateActiveFilterButton();
</script>

<style>
    .filter-btn.active {
        background-color: #2563eb !important;
        color: white !important;
    }
    
    .booking-card {
        border: 1px solid transparent;
        transition: all 0.3s ease;
    }
    
    .booking-card:hover {
        border-color: #3b82f6;
    }

    /* Status badge styling */
    .status-badge.status-booked {
        background-color: #dbeafe;
        color: #1e40af;
    }
    
    .status-badge.status-checked-in {
        background-color: #dcfce7;
        color: #166534;
    }
    
    .status-badge.status-cancelled {
        background-color: #fee2e2;
        color: #991b1b;
    }
    
    .status-badge.status-completed {
        background-color: #f3f4f6;
        color: #374151;
    }
</style>
@endsection 