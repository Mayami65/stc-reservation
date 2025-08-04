@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2 flex items-center">
                        <i class="bi bi-geo-alt text-blue-600 mr-3"></i> Manage Routes
                    </h1>
                    <p class="text-gray-600">Create and manage bus routes for your transportation network</p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="bg-blue-50 text-blue-800 px-4 py-2 rounded-lg">
                        <div class="text-sm font-medium">Total Routes</div>
                        <div class="text-2xl font-bold">{{ $routes->count() }}</div>
                    </div>
                    <a href="{{ route('admin.routes.create') }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition duration-200 flex items-center">
                        <i class="bi bi-plus-circle mr-2"></i>
                        Add New Route
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

        <!-- Routes Grid -->
        @if($routes->count() > 0)
        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6 mb-8">
            @foreach($routes as $route)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
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
                            <span class="inline-block bg-green-400 text-green-900 text-xs px-2 py-1 rounded-full font-medium">
                                <i class="bi bi-check-circle me-1"></i>Active
                            </span>
                        </div>
                    </div>
                    
                    <!-- Route Path -->
                    <div class="flex items-center justify-center mb-4">
                        <div class="text-center">
                            <div class="text-lg font-bold">{{ $route->origin }}</div>
                            <div class="text-blue-100 text-xs">Origin</div>
                        </div>
                        <div class="mx-4">
                            <i class="bi bi-arrow-right text-2xl"></i>
                        </div>
                        <div class="text-center">
                            <div class="text-lg font-bold">{{ $route->destination }}</div>
                            <div class="text-blue-100 text-xs">Destination</div>
                        </div>
                    </div>
                </div>

                <!-- Route Details -->
                <div class="p-6">
                    <div class="space-y-4">
                        <!-- Route Statistics -->
                        <div class="grid grid-cols-3 gap-4 text-sm">
                            <div class="bg-gray-50 rounded-lg p-3 text-center">
                                <div class="text-gray-600 mb-1">Total Trips</div>
                                <div class="font-bold text-gray-800">{{ $route->trips_count ?? $route->trips()->count() }}</div>
                            </div>
                            <div class="bg-green-50 rounded-lg p-3 text-center border border-green-200">
                                <div class="text-green-600 mb-1">Price</div>
                                <div class="font-bold text-green-800 text-lg">₵{{ number_format($route->price, 2) }}</div>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-3 text-center">
                                <div class="text-gray-600 mb-1">Created</div>
                                <div class="font-bold text-gray-800">{{ $route->created_at->format('M j') }}</div>
                            </div>
                        </div>

                        <!-- Route Features -->
                        <div class="space-y-2">
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="bi bi-calendar-week me-2 text-blue-600"></i>
                                <span>{{ $route->trips_count ?? $route->trips()->count() }} scheduled trips</span>
                            </div>
                            <div class="flex items-center text-sm text-green-600">
                                <i class="bi bi-currency-dollar me-2 text-green-600"></i>
                                <span>₵{{ number_format($route->price, 2) }} per seat</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="bi bi-clock-history me-2 text-blue-600"></i>
                                <span>Created {{ $route->created_at->diffForHumans() }}</span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-2 pt-2">
                            <a href="{{ route('admin.routes.show', $route) }}" 
                               class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-center py-2 px-4 rounded-lg text-sm font-medium transition duration-200">
                                <i class="bi bi-eye me-1"></i> View Details
                            </a>
                            <a href="{{ route('admin.routes.edit', $route) }}" 
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
            <i class="bi bi-geo text-6xl text-gray-400 mb-6"></i>
            <h3 class="text-xl font-semibold text-gray-600 mb-2">No Routes Available</h3>
            <p class="text-gray-500 mb-6">Start by creating your first bus route</p>
            <a href="{{ route('admin.routes.create') }}" 
               class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition duration-200">
                <i class="bi bi-plus-circle me-2"></i>
                Create First Route
            </a>
        </div>
        @endif

        <!-- Route Management Info -->
        <div class="mt-8 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg shadow-lg p-8">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Route Management</h2>
                <p class="text-gray-600">Efficiently manage your transportation network</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="bi bi-plus-circle text-blue-600 text-xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-2">Create Routes</h3>
                    <p class="text-gray-600 text-sm">Add new routes to expand your network</p>
                </div>
                
                <div class="text-center">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="bi bi-pencil text-green-600 text-xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-2">Edit Routes</h3>
                    <p class="text-gray-600 text-sm">Update route information as needed</p>
                </div>
                
                <div class="text-center">
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="bi bi-eye text-purple-600 text-xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-2">Monitor Activity</h3>
                    <p class="text-gray-600 text-sm">Track trips and bookings per route</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 