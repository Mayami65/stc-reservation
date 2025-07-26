@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="max-w-6xl mx-auto">
        <!-- Header Section -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2 flex items-center">
                        <i class="bi bi-geo-alt text-blue-600 mr-3"></i> Available Routes
                    </h1>
                    <p class="text-gray-600">Choose your destination and start your journey with STC</p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="bg-blue-50 text-blue-800 px-4 py-2 rounded-lg">
                        <div class="text-sm font-medium">Total Routes</div>
                        <div class="text-2xl font-bold">{{ $routes->count() }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search and Filter Section -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <div class="flex flex-col lg:flex-row gap-4 items-center justify-between">
                <div class="flex flex-wrap gap-3">
                    <button onclick="filterRoutes('all')" 
                            class="filter-btn active px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 bg-blue-600 text-white">
                        All Routes ({{ $routes->count() }})
                    </button>
                    <button onclick="filterRoutes('popular')" 
                            class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 bg-gray-100 text-gray-700 hover:bg-gray-200">
                        Popular Routes
                    </button>
                    <button onclick="filterRoutes('recent')" 
                            class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 bg-gray-100 text-gray-700 hover:bg-gray-200">
                        Recently Added
                    </button>
                </div>
                <div class="relative">
                    <input type="text" 
                           id="searchInput" 
                           placeholder="Search by origin, destination, or route ID..." 
                           class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent w-64">
                    <i class="bi bi-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
            </div>
        </div>

        <!-- Routes Grid -->
        @if($routes->count() > 0)
        <div id="routesGrid" class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach($routes as $route)
            <div class="route-card bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1"
                 data-route-id="{{ $route->id }}"
                 data-origin="{{ strtolower($route->origin) }}"
                 data-destination="{{ strtolower($route->destination) }}"
                 data-popular="{{ $route->id <= 3 ? 'true' : 'false' }}"
                 data-recent="{{ $route->id > 3 ? 'true' : 'false' }}">
                
                <!-- Route Header -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                                <i class="bi bi-bus-front text-white text-lg"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-lg font-bold">Route #{{ $route->id }}</h3>
                                <p class="text-blue-100 text-sm">STC Express Service</p>
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
                    <div class="flex items-center justify-center mb-4">
                        <div class="text-center">
                            <div class="text-lg font-bold">{{ $route->origin }}</div>
                            <div class="text-blue-100 text-xs">Departure</div>
                        </div>
                        <div class="mx-4">
                            <i class="bi bi-arrow-right text-2xl"></i>
                        </div>
                        <div class="text-center">
                            <div class="text-lg font-bold">{{ $route->destination }}</div>
                            <div class="text-blue-100 text-xs">Arrival</div>
                        </div>
                    </div>
                </div>

                <!-- Route Details -->
                <div class="p-6">
                    <div class="space-y-4">
                        <!-- Route Statistics -->
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div class="bg-gray-50 rounded-lg p-3 text-center">
                                <div class="text-gray-600 mb-1">Daily Trips</div>
                                <div class="font-bold text-gray-800">3-5</div>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-3 text-center">
                                <div class="text-gray-600 mb-1">Capacity</div>
                                <div class="font-bold text-gray-800">40-45</div>
                            </div>
                        </div>

                        <!-- Route Features -->
                        <div class="space-y-2">
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="bi bi-clock me-2 text-blue-600"></i>
                                <span>Multiple departure times daily</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="bi bi-wifi me-2 text-blue-600"></i>
                                <span>Free WiFi on board</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="bi bi-thermometer-half me-2 text-blue-600"></i>
                                <span>Air-conditioned buses</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="bi bi-shield-check me-2 text-blue-600"></i>
                                <span>Safe and reliable service</span>
                            </div>
                        </div>

                        <!-- Action Button -->
                        <div class="pt-2">
                            <a href="{{ route('routes.trips', $route) }}" 
                               class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center py-3 px-4 rounded-lg font-semibold transition duration-200 transform hover:scale-105">
                                <i class="bi bi-calendar-check me-2"></i>
                                View Available Trips
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- No Results Message -->
        <div id="noResults" class="hidden bg-white rounded-lg shadow-lg p-12 text-center">
            <i class="bi bi-search text-4xl text-gray-400 mb-4"></i>
            <h3 class="text-lg font-semibold text-gray-600 mb-2">No routes found</h3>
            <p class="text-gray-500">Try adjusting your search criteria</p>
        </div>

        @else
        <!-- Empty State -->
        <div class="bg-white rounded-lg shadow-lg p-12 text-center">
            <i class="bi bi-geo text-6xl text-gray-400 mb-6"></i>
            <h3 class="text-xl font-semibold text-gray-600 mb-2">No Routes Available</h3>
            <p class="text-gray-500 mb-6">Sorry, there are currently no routes available. Please check back later.</p>
            <a href="/" class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition duration-200">
                <i class="bi bi-house me-2"></i>
                Back to Home
            </a>
        </div>
        @endif

        <!-- Route Information Section -->
        <div class="mt-12 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg shadow-lg p-8">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Why Choose STC?</h2>
                <p class="text-gray-600">Experience the best in intercity transportation</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="bi bi-shield-check text-blue-600 text-xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-2">Safe Travel</h3>
                    <p class="text-gray-600 text-sm">Professional drivers and well-maintained vehicles</p>
                </div>
                
                <div class="text-center">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="bi bi-clock text-green-600 text-xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-2">Punctual Service</h3>
                    <p class="text-gray-600 text-sm">Reliable departure and arrival times</p>
                </div>
                
                <div class="text-center">
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="bi bi-wifi text-purple-600 text-xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-2">Modern Amenities</h3>
                    <p class="text-gray-600 text-sm">Free WiFi and comfortable seating</p>
                </div>
                
                <div class="text-center">
                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="bi bi-credit-card text-orange-600 text-xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-2">Easy Booking</h3>
                    <p class="text-gray-600 text-sm">Quick online booking with instant confirmation</p>
                </div>
            </div>
        </div>

        <!-- Booking Information -->
        <div class="mt-8 bg-white rounded-lg shadow-lg p-6">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <i class="bi bi-info-circle text-blue-600 text-xl"></i>
                </div>
                <div class="ml-3">
                    <h4 class="text-lg font-semibold text-blue-800 mb-2">Booking Information</h4>
                    <ul class="text-blue-700 text-sm space-y-1">
                        <li>• Select your preferred route to view available trips and times</li>
                        <li>• Choose your seat from our interactive seat map</li>
                        <li>• Receive your QR code ticket instantly after booking</li>
                        <li>• Present your QR code at the terminal for quick check-in</li>
                        <li>• Arrive at least 30 minutes before departure time</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const routeCards = document.querySelectorAll('.route-card');
    const noResults = document.getElementById('noResults');
    const routesGrid = document.getElementById('routesGrid');
    const filterBtns = document.querySelectorAll('.filter-btn');

    let currentFilter = 'all';

    // Search functionality
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        filterAndSearch();
    });

    // Filter functionality
    function filterRoutes(filter) {
        currentFilter = filter;
        
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

        routeCards.forEach(card => {
            const routeId = card.dataset.routeId;
            const origin = card.dataset.origin;
            const destination = card.dataset.destination;
            const isPopular = card.dataset.popular === 'true';
            const isRecent = card.dataset.recent === 'true';

            const matchesFilter = currentFilter === 'all' || 
                                (currentFilter === 'popular' && isPopular) ||
                                (currentFilter === 'recent' && isRecent);
            
            const matchesSearch = origin.includes(searchTerm) || 
                                destination.includes(searchTerm) || 
                                routeId.includes(searchTerm);

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
            routesGrid.classList.add('hidden');
        } else {
            noResults.classList.add('hidden');
            routesGrid.classList.remove('hidden');
        }
    }

    // Make filterRoutes function global
    window.filterRoutes = filterRoutes;
});
</script>

<style>
.filter-btn.active {
    background-color: #2563eb !important;
    color: white !important;
}

.route-card {
    border: 1px solid #e5e7eb;
}

.route-card:hover {
    border-color: #3b82f6;
}
</style>
@endsection