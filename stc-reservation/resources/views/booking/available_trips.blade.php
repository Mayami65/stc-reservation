@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6 md:py-8">
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-lg p-4 md:p-6 mb-6 md:mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-xl md:text-2xl lg:text-3xl font-bold text-gray-800 mb-2 flex items-center">
                    <i class="bi bi-calendar-check text-green-600 mr-3"></i> Available Trips
                </h1>
                <p class="text-gray-600 text-sm md:text-base">Book your journey with STC - All trips shown have available seats</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="bg-green-50 text-green-800 px-3 md:px-4 py-2 rounded-lg">
                    <div class="text-xs md:text-sm font-medium">Available Trips</div>
                    <div class="text-xl md:text-2xl font-bold">{{ $trips->count() }}</div>
                </div>
                <div class="bg-blue-50 text-blue-800 px-3 md:px-4 py-2 rounded-lg">
                    <div class="text-xs md:text-sm font-medium">Ready to Book</div>
                    <div class="text-sm font-semibold">✓</div>
                </div>
                <a href="{{ route('routes.index') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200">
                    <i class="bi bi-geo-alt me-2"></i>View Routes
                </a>
            </div>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="bg-white rounded-lg shadow-lg p-4 md:p-6 mb-6 md:mb-8">
        <div class="flex flex-col lg:flex-row gap-4 items-center justify-between">
            <div class="flex flex-wrap gap-2 md:gap-3 w-full lg:w-auto">
                <button onclick="filterTrips('all')" 
                        class="filter-btn active px-3 md:px-4 py-2 rounded-lg text-xs md:text-sm font-medium transition-all duration-200 bg-green-600 text-white">
                    All Trips ({{ $trips->count() }})
                </button>
                <button onclick="filterTrips('today')" 
                        class="filter-btn px-3 md:px-4 py-2 rounded-lg text-xs md:text-sm font-medium transition-all duration-200 bg-gray-100 text-gray-700 hover:bg-gray-200">
                    Today
                </button>
                <button onclick="filterTrips('tomorrow')" 
                        class="filter-btn px-3 md:px-4 py-2 rounded-lg text-xs md:text-sm font-medium transition-all duration-200 bg-gray-100 text-gray-700 hover:bg-gray-200">
                    Tomorrow
                </button>
                <button onclick="filterTrips('week')" 
                        class="filter-btn px-3 md:px-4 py-2 rounded-lg text-xs md:text-sm font-medium transition-all duration-200 bg-gray-100 text-gray-700 hover:bg-gray-200">
                    This Week
                </button>
            </div>
            <div class="relative w-full lg:w-auto">
                <input type="text" 
                       id="searchInput" 
                       placeholder="Search by origin, destination, or bus..." 
                       class="w-full lg:w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent text-sm">
                <i class="bi bi-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            </div>
        </div>
    </div>

    <!-- Trips Grid -->
    <div id="tripsGrid" class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6">
        @foreach($trips as $trip)
        @php
            $departureDate = \Carbon\Carbon::parse($trip->departure_date);
            $departureTime = \Carbon\Carbon::parse($trip->departure_time);
            $isToday = $departureDate->isToday();
            $isTomorrow = $departureDate->isTomorrow();
            $isThisWeek = $departureDate->isBetween(now(), now()->addWeek());
        @endphp
        <div class="trip-card bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1"
             data-trip-id="{{ $trip->id }}"
             data-origin="{{ strtolower($trip->route->origin) }}"
             data-destination="{{ strtolower($trip->route->destination) }}"
             data-bus="{{ strtolower($trip->bus->name) }}"
             data-date="{{ $departureDate->format('Y-m-d') }}"
             data-today="{{ $isToday ? 'true' : 'false' }}"
             data-tomorrow="{{ $isTomorrow ? 'true' : 'false' }}"
             data-week="{{ $isThisWeek ? 'true' : 'false' }}">
            
            <!-- Trip Header -->
            <div class="bg-gradient-to-r from-green-600 to-green-700 text-white p-4 md:p-6">
                <div class="flex items-center justify-between mb-3 md:mb-4">
                    <div class="flex items-center">
                        <div class="w-8 h-8 md:w-10 md:h-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                            <i class="bi bi-bus-front text-white text-base md:text-lg"></i>
                        </div>
                        <div class="ml-2 md:ml-3">
                            <h3 class="text-sm md:text-lg font-bold">{{ $trip->bus->name }}</h3>
                            <p class="text-green-100 text-xs md:text-sm">STC Express Service</p>
                        </div>
                    </div>
                    <div class="text-right">
                        @if($isToday)
                            <span class="inline-block bg-orange-400 text-orange-900 text-xs px-2 py-1 rounded-full font-medium">
                                <i class="bi bi-calendar-day me-1"></i>Today
                            </span>
                        @elseif($isTomorrow)
                            <span class="inline-block bg-blue-400 text-blue-900 text-xs px-2 py-1 rounded-full font-medium">
                                <i class="bi bi-calendar-plus me-1"></i>Tomorrow
                            </span>
                        @else
                            <span class="inline-block bg-green-400 text-green-900 text-xs px-2 py-1 rounded-full font-medium">
                                <i class="bi bi-check-circle me-1"></i>Available
                            </span>
                        @endif
                    </div>
                </div>
                
                <!-- Route Path -->
                <div class="flex items-center justify-center mb-3 md:mb-4">
                    <div class="text-center">
                        <div class="text-sm md:text-lg font-bold">{{ $trip->route->origin }}</div>
                        <div class="text-green-100 text-xs">Departure</div>
                    </div>
                    <div class="mx-2 md:mx-4">
                        <i class="bi bi-arrow-right text-lg md:text-2xl"></i>
                    </div>
                    <div class="text-center">
                        <div class="text-sm md:text-lg font-bold">{{ $trip->route->destination }}</div>
                        <div class="text-green-100 text-xs">Arrival</div>
                    </div>
                </div>
            </div>

            <!-- Trip Details -->
            <div class="p-4 md:p-6">
                <div class="space-y-3 md:space-y-4">
                                         <!-- Trip Information -->
                     <div class="grid grid-cols-3 gap-3 md:gap-4 text-xs md:text-sm">
                         <div class="bg-gray-50 rounded-lg p-2 md:p-3 text-center">
                             <div class="text-gray-600 mb-1">
                                 <i class="bi bi-calendar3 me-1"></i>Date
                             </div>
                             <div class="font-bold text-gray-800">{{ $departureDate->format('M j, Y') }}</div>
                             <div class="text-xs text-gray-500">{{ $departureDate->format('l') }}</div>
                         </div>
                         <div class="bg-gray-50 rounded-lg p-2 md:p-3 text-center">
                             <div class="text-gray-600 mb-1">
                                 <i class="bi bi-clock me-1"></i>Time
                             </div>
                             <div class="font-bold text-gray-800">{{ $departureTime->format('g:i A') }}</div>
                         </div>
                         <div class="bg-green-50 rounded-lg p-2 md:p-3 text-center border border-green-200">
                             <div class="text-green-700 mb-1">
                                 <i class="bi bi-currency-dollar me-1"></i>Price
                             </div>
                                                           <div class="font-bold text-green-800 text-lg">₵{{ number_format($trip->effective_price, 2) }}</div>
                             <div class="text-xs text-green-600">per seat</div>
                         </div>
                     </div>

                    <!-- Seat Availability -->
                    <div class="bg-blue-50 rounded-lg p-3 md:p-4 border border-blue-200">
                        <div class="flex items-center justify-between mb-2">
                            <div class="text-blue-800 font-semibold text-sm md:text-base">
                                <i class="bi bi-people me-2"></i>Seat Availability
                            </div>
                            <div class="text-right">
                                <div class="text-lg font-bold {{ $trip->available_seats <= 5 ? 'text-red-600' : 'text-green-600' }}">
                                    {{ $trip->available_seats }}
                                </div>
                                <div class="text-xs text-gray-600">available</div>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <div class="flex-1 bg-gray-200 rounded-full h-2 mr-2">
                                <div class="h-2 rounded-full {{ $trip->occupancy_percentage >= 80 ? 'bg-red-500' : ($trip->occupancy_percentage >= 60 ? 'bg-yellow-500' : 'bg-green-500') }}" 
                                     style="--width: {{ $trip->occupancy_percentage }}%; width: var(--width)"></div>
                            </div>
                            <span class="text-xs text-gray-600">{{ round($trip->occupancy_percentage) }}% full</span>
                        </div>
                        <div class="text-xs text-gray-600 mt-1">
                            {{ $trip->total_seats - $trip->available_seats }} of {{ $trip->total_seats }} seats booked
                        </div>
                    </div>

                    <!-- Action Button -->
                    <div class="pt-2">
                        <a href="{{ route('trips.seats', $trip) }}" 
                           class="block w-full bg-green-600 hover:bg-green-700 text-white text-center py-2 md:py-3 px-4 rounded-lg font-semibold transition duration-200 transform hover:scale-105 text-sm md:text-base">
                            <i class="bi bi-calendar-check me-2"></i>
                            Select Seats
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Empty State -->
    <div id="emptyState" class="hidden text-center py-12">
        <div class="max-w-md mx-auto">
            <i class="bi bi-calendar-x text-4xl text-gray-400 mb-4"></i>
            <h3 class="text-lg font-semibold text-gray-600 mb-2">No available trips</h3>
            <p class="text-gray-500 text-sm">Currently no trips have available seats. Please check back later.</p>
        </div>
    </div>

    <!-- No Results State -->
    <div id="noResults" class="hidden text-center py-12">
        <div class="max-w-md mx-auto">
            <i class="bi bi-search text-6xl text-gray-400 mb-6"></i>
            <h3 class="text-lg font-semibold text-gray-600 mb-2">No matching trips</h3>
            <p class="text-gray-500 text-sm mb-4">We couldn't find any trips matching your search.</p>
            <button onclick="clearSearch()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm">
                <i class="bi bi-house me-2"></i>
                Show All Trips
            </button>
        </div>
    </div>
</div>

<script>
    let currentFilter = 'all';
    let searchTerm = '';

    function filterTrips(filter) {
        currentFilter = filter;
        updateActiveFilterButton();
        filterAndSearch();
    }

    function updateActiveFilterButton() {
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.classList.remove('active', 'bg-green-600', 'text-white');
            btn.classList.add('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');
        });

        const activeButton = document.querySelector(`[onclick="filterTrips('${currentFilter}')"]`);
        if (activeButton) {
            activeButton.classList.remove('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');
            activeButton.classList.add('active', 'bg-green-600', 'text-white');
        }
    }

    function filterAndSearch() {
        const tripCards = document.querySelectorAll('.trip-card');
        let visibleCount = 0;

        tripCards.forEach(card => {
            const origin = card.dataset.origin;
            const destination = card.dataset.destination;
            const bus = card.dataset.bus;
            const isToday = card.dataset.today === 'true';
            const isTomorrow = card.dataset.tomorrow === 'true';
            const isWeek = card.dataset.week === 'true';

            let showCard = true;

            if (currentFilter === 'today' && !isToday) showCard = false;
            if (currentFilter === 'tomorrow' && !isTomorrow) showCard = false;
            if (currentFilter === 'week' && !isWeek) showCard = false;

            if (searchTerm && showCard) {
                const searchLower = searchTerm.toLowerCase();
                const matchesSearch = origin.includes(searchLower) || 
                                    destination.includes(searchLower) || 
                                    bus.includes(searchLower);
                if (!matchesSearch) showCard = false;
            }

            if (showCard) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        const emptyState = document.getElementById('emptyState');
        const noResults = document.getElementById('noResults');
        const tripsGrid = document.getElementById('tripsGrid');

        if (visibleCount === 0) {
            tripsGrid.style.display = 'none';
            if (searchTerm) {
                noResults.classList.remove('hidden');
                emptyState.classList.add('hidden');
            } else {
                emptyState.classList.remove('hidden');
                noResults.classList.add('hidden');
            }
        } else {
            tripsGrid.style.display = 'grid';
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

    document.getElementById('searchInput').addEventListener('input', function(e) {
        searchTerm = e.target.value;
        filterAndSearch();
    });

    updateActiveFilterButton();
</script>

<style>
    .filter-btn.active {
        background-color: #16a34a !important;
        color: white !important;
    }
    
    .trip-card {
        border: 1px solid transparent;
        transition: all 0.3s ease;
    }
    
    .trip-card:hover {
        border-color: #16a34a;
    }
</style>
@endsection
