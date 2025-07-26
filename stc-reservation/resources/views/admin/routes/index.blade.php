@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 px-4">
    <!-- Breadcrumb -->
    <nav class="mb-6">
        <ol class="flex items-center space-x-2 text-sm text-gray-600">
            <li><a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 transition">Admin Dashboard</a></li>
            <li><i class="bi bi-chevron-right"></i></li>
            <li class="text-gray-800 font-medium">Manage Routes</li>
        </ol>
    </nav>

    <!-- Page Header with Action -->
    <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-8">
        <div>
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">
                <i class="bi bi-geo-alt text-blue-600 me-2"></i>
                Manage Routes
            </h1>
            <p class="text-gray-600">Create and manage bus routes for your transportation network</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('admin.routes.create') }}" 
               class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition duration-300 transform hover:scale-105">
                <i class="bi bi-plus me-2"></i> 
                Add New Route
            </a>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <x-alert type="success" class="mb-6">
            {{ session('success') }}
        </x-alert>
    @endif

    <!-- Routes Table -->
    <x-section-card title="All Routes" icon="list" header-color="gray">
        @if($routes->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <i class="bi bi-hash me-1"></i>ID
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <i class="bi bi-geo me-1"></i>Origin
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <i class="bi bi-geo-alt me-1"></i>Destination
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <i class="bi bi-calendar-week me-1"></i>Total Trips
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <i class="bi bi-calendar-plus me-1"></i>Created
                            </th>
                            <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <i class="bi bi-gear me-1"></i>Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($routes as $route)
                        <tr class="hover:bg-gray-50 transition duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">#{{ $route->id }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-gray-900">{{ $route->origin }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-gray-900">{{ $route->destination }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $route->trips_count ?? $route->trips()->count() }} trips
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $route->created_at->format('M j, Y') }}
                                <div class="text-xs text-gray-400">{{ $route->created_at->diffForHumans() }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end items-center space-x-2">
                                    <a href="{{ route('admin.routes.show', $route) }}" 
                                       class="text-blue-600 hover:text-blue-900 p-2 rounded-lg hover:bg-blue-50 transition duration-200"
                                       title="View Route">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.routes.edit', $route) }}" 
                                       class="text-yellow-600 hover:text-yellow-900 p-2 rounded-lg hover:bg-yellow-50 transition duration-200"
                                       title="Edit Route">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.routes.destroy', $route) }}" method="POST" class="inline" 
                                          onsubmit="return confirm('Are you sure you want to delete this route? This will also delete all associated trips.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-red-600 hover:text-red-900 p-2 rounded-lg hover:bg-red-50 transition duration-200"
                                                title="Delete Route">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="max-w-md mx-auto">
                    <i class="bi bi-geo text-gray-300 text-6xl mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">No Routes Available</h3>
                    <p class="text-gray-500 mb-6">Start by creating your first bus route to connect different destinations.</p>
                    <a href="{{ route('admin.routes.create') }}" 
                       class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white py-2 px-6 rounded-lg transition duration-300">
                        <i class="bi bi-plus me-2"></i>
                        Create First Route
                    </a>
                </div>
            </div>
        @endif
    </x-section-card>

    <!-- Pagination -->
    @if($routes->hasPages())
        <div class="mt-8">
            {{ $routes->links() }}
        </div>
    @endif

    <!-- Quick Stats -->
    @if($routes->count() > 0)
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            <x-action-card 
                href="#"
                icon="geo-alt"
                title="Total Routes"
                description="{{ $routes->total() }} routes configured"
                icon-color="blue" />

            <x-action-card 
                href="#"
                icon="calendar-week"
                title="Active Trips"
                description="{{ $routes->sum(fn($route) => $route->trips()->count()) }} scheduled trips"
                icon-color="green" />

            <x-action-card 
                href="#"
                icon="arrow-repeat"
                title="Most Popular"
                description="@if($routes->count() > 0){{ $routes->first()->origin }} → {{ $routes->first()->destination }}@else N/A @endif"
                icon-color="purple" />
        </div>
    @endif
</div>
@endsection 