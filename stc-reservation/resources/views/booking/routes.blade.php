@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6 md:py-8">
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-lg p-4 md:p-6 mb-6 md:mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-xl md:text-2xl lg:text-3xl font-bold text-gray-800 mb-2 flex items-center">
                    <i class="bi bi-geo-alt text-blue-600 mr-3"></i> Available Routes
                </h1>
                <p class="text-gray-600 text-sm md:text-base">Choose your destination and start your journey with STC</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="bg-blue-50 text-blue-800 px-3 md:px-4 py-2 rounded-lg">
                    <div class="text-xs md:text-sm font-medium">Total Routes</div>
                    <div class="text-xl md:text-2xl font-bold">{{ $routes->count() }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="bg-white rounded-lg shadow-lg p-4 md:p-6 mb-6 md:mb-8">
        <div class="flex flex-col lg:flex-row gap-4 items-center justify-between">
            <div class="flex flex-wrap gap-2 md:gap-3 w-full lg:w-auto">
                <button onclick="filterRoutes('all')" 
                        class="filter-btn active px-3 md:px-4 py-2 rounded-lg text-xs md:text-sm font-medium transition-all duration-200 bg-blue-600 text-white">
                    All Routes ({{ $routes->count() }})
                </button>
                <button onclick="filterRoutes('popular')" 
                        class="filter-btn px-3 md:px-4 py-2 rounded-lg text-xs md:text-sm font-medium transition-all duration-200 bg-gray-100 text-gray-700 hover:bg-gray-200">
                    Popular Routes
                </button>
                <button onclick="filterRoutes('recent')" 
                        class="filter-btn px-3 md:px-4 py-2 rounded-lg text-xs md:text-sm font-medium transition-all duration-200 bg-gray-100 text-gray-700 hover:bg-gray-200">
                    Recently Added
                </button>
            </div>
            <div class="relative w-full lg:w-auto">
                <input type="text" 
                       id="searchInput" 
                       placeholder="Search by origin, destination, or route ID..." 
                       class="w-full lg:w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                <i class="bi bi-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            </div>
        </div>
    </div>

    <!-- Routes Grid -->
    <div id="routesGrid" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 md:gap-6">
        @foreach($routes as $route)
        <div class="route-card bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1"
             data-route-id="{{ $route->id }}"
             data-origin="{{ strtolower($route->origin) }}"
             data-destination="{{ strtolower($route->destination) }}"
             data-popular="{{ $route->id <= 3 ? 'true' : 'false' }}"
             data-recent="{{ $route->id > 3 ? 'true' : 'false' }}">
            
            <!-- Route Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white p-4 md:p-6">
                <div class="flex items-center justify-between mb-3 md:mb-4">
                    <div class="flex items-center">
                        <div class="w-8 h-8 md:w-10 md:h-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                            <i class="bi bi-bus-front text-white text-base md:text-lg"></i>
                        </div>
                        <div class="ml-2 md:ml-3">
                            <h3 class="text-sm md:text-lg font-bold">Route #{{ $route->id }}</h3>
                            <p class="text-blue-100 text-xs md:text-sm">STC Express Service</p>
                        </div>
                    </div>
                    <div class="text-right">
                        @if($route->id <= 3)
                            <span class="inline-block bg-yellow-400 text-yellow-900 text-xs px-2 py-1 rounded-full font-medium">
                                <i class="bi bi-star-fill me-1"></i>Popular
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
                        <div class="text-sm md:text-lg font-bold">{{ $route->origin }}</div>
                        <div class="text-blue-100 text-xs">Departure</div>
                    </div>
                    <div class="mx-2 md:mx-4">
                        <i class="bi bi-arrow-right text-lg md:text-2xl"></i>
                    </div>
                    <div class="text-center">
                        <div class="text-sm md:text-lg font-bold">{{ $route->destination }}</div>
                        <div class="text-blue-100 text-xs">Arrival</div>
                    </div>
                </div>
            </div>

            <!-- Route Details -->
            <div class="p-4 md:p-6">
                <div class="space-y-3 md:space-y-4">
                    <!-- Route Statistics -->
                    <div class="grid grid-cols-2 gap-3 md:gap-4 text-xs md:text-sm">
                        <div class="bg-gray-50 rounded-lg p-2 md:p-3 text-center">
                            <div class="text-gray-600 mb-1">Daily Trips</div>
                            <div class="font-bold text-gray-800">3-5</div>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-2 md:p-3 text-center">
                            <div class="text-gray-600 mb-1">Capacity</div>
                            <div class="font-bold text-gray-800">40-45</div>
                        </div>
                    </div>

                    <!-- Route Features -->
                    <div class="space-y-1 md:space-y-2">
                        <div class="flex items-center text-xs md:text-sm text-gray-600">
                            <i class="bi bi-clock me-2 text-blue-600"></i>
                            <span>Multiple departure times daily</span>
                        </div>
                        <div class="flex items-center text-xs md:text-sm text-gray-600">
                            <i class="bi bi-wifi me-2 text-blue-600"></i>
                            <span>Free WiFi on board</span>
                        </div>
                        <div class="flex items-center text-xs md:text-sm text-gray-600">
                            <i class="bi bi-thermometer-half me-2 text-blue-600"></i>
                            <span>Air-conditioned buses</span>
                        </div>
                        <div class="flex items-center text-xs md:text-sm text-gray-600">
                            <i class="bi bi-shield-check me-2 text-blue-600"></i>
                            <span>Safe and reliable service</span>
                        </div>
                    </div>

                    <!-- Action Button -->
                    <div class="pt-2">
                        <a href="{{ route('routes.trips', $route) }}" 
                           class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center py-2 md:py-3 px-4 rounded-lg font-semibold transition duration-200 transform hover:scale-105 text-sm md:text-base">
                            <i class="bi bi-calendar-check me-2"></i>
                            View Available Trips
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
            <i class="bi bi-search text-4xl text-gray-400 mb-4"></i>
            <h3 class="text-lg font-semibold text-gray-600 mb-2">No routes found</h3>
            <p class="text-gray-500 text-sm">Try adjusting your search or filter criteria.</p>
        </div>
    </div>

    <!-- No Results State -->
    <div id="noResults" class="hidden text-center py-12">
        <div class="max-w-md mx-auto">
            <i class="bi bi-geo text-6xl text-gray-400 mb-6"></i>
            <h3 class="text-lg font-semibold text-gray-600 mb-2">No matching routes</h3>
            <p class="text-gray-500 text-sm mb-4">We couldn't find any routes matching your search.</p>
            <button onclick="clearSearch()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm">
                <i class="bi bi-house me-2"></i>
                Show All Routes
            </button>
        </div>
    </div>

    <!-- Additional Info Section -->
    <div class="mt-8 md:mt-12 space-y-6 md:space-y-8">
        <!-- Why Choose STC? -->
        <div class="bg-white rounded-lg shadow-lg p-4 md:p-6">
            <h2 class="text-lg md:text-xl font-bold text-gray-800 mb-4 flex items-center">
                <i class="bi bi-shield-check text-blue-600 text-xl mr-2"></i>
                Why Choose STC?
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="flex items-center text-sm md:text-base">
                    <i class="bi bi-shield-check text-blue-600 text-xl mr-3"></i>
                    <span>Safe and reliable service</span>
                </div>
                <div class="flex items-center text-sm md:text-base">
                    <i class="bi bi-clock text-green-600 text-xl mr-3"></i>
                    <span>Punctual departures</span>
                </div>
                <div class="flex items-center text-sm md:text-base">
                    <i class="bi bi-wifi text-purple-600 text-xl mr-3"></i>
                    <span>Free WiFi on board</span>
                </div>
                <div class="flex items-center text-sm md:text-base">
                    <i class="bi bi-credit-card text-orange-600 text-xl mr-3"></i>
                    <span>Secure online payments</span>
                </div>
            </div>
        </div>

        <!-- Booking Information -->
        <div class="bg-white rounded-lg shadow-lg p-4 md:p-6">
            <h2 class="text-lg md:text-xl font-bold text-gray-800 mb-4 flex items-center">
                <i class="bi bi-info-circle text-blue-600 text-xl mr-2"></i>
                Booking Information
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm md:text-base">
                <div>
                    <h3 class="font-semibold text-gray-800 mb-2">How to Book:</h3>
                    <ol class="list-decimal list-inside space-y-1 text-gray-600">
                        <li>Select your desired route</li>
                        <li>Choose your preferred trip date and time</li>
                        <li>Select your seat from the interactive map</li>
                        <li>Complete your booking and receive QR code</li>
                    </ol>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800 mb-2">Important Notes:</h3>
                    <ul class="list-disc list-inside space-y-1 text-gray-600">
                        <li>Bookings close 2 hours before departure</li>
                        <li>Present QR code at boarding</li>
                        <li>Valid ID required for verification</li>
                        <li>No refunds for missed trips</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let currentFilter = 'all';
    let searchTerm = '';

    function filterRoutes(filter) {
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
        const activeButton = document.querySelector(`[onclick="filterRoutes('${currentFilter}')"]`);
        if (activeButton) {
            activeButton.classList.remove('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');
            activeButton.classList.add('active', 'bg-blue-600', 'text-white');
        }
    }

    function filterAndSearch() {
        const routeCards = document.querySelectorAll('.route-card');
        let visibleCount = 0;

        routeCards.forEach(card => {
            const routeId = card.dataset.routeId;
            const origin = card.dataset.origin;
            const destination = card.dataset.destination;
            const isPopular = card.dataset.popular === 'true';
            const isRecent = card.dataset.recent === 'true';

            let showCard = true;

            // Apply filter
            if (currentFilter === 'popular' && !isPopular) showCard = false;
            if (currentFilter === 'recent' && !isRecent) showCard = false;

            // Apply search
            if (searchTerm && showCard) {
                const searchLower = searchTerm.toLowerCase();
                const matchesSearch = origin.includes(searchLower) || 
                                    destination.includes(searchLower) || 
                                    routeId.includes(searchTerm);
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
        const routesGrid = document.getElementById('routesGrid');

        if (visibleCount === 0) {
            routesGrid.style.display = 'none';
            if (searchTerm) {
                noResults.classList.remove('hidden');
                emptyState.classList.add('hidden');
            } else {
                emptyState.classList.remove('hidden');
                noResults.classList.add('hidden');
            }
        } else {
            routesGrid.style.display = 'grid';
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
    
    .route-card {
        border: 1px solid transparent;
        transition: all 0.3s ease;
    }
    
    .route-card:hover {
        border-color: #3b82f6;
    }
</style>
@endsection