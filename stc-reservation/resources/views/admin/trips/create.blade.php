@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center mb-6">
            <a href="{{ route('admin.trips.index') }}" class="text-blue-600 hover:text-blue-800 mr-4">
                <i class="bi bi-arrow-left text-xl"></i>
            </a>
            <h1 class="text-3xl font-bold text-gray-800">Schedule New Trip</h1>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('admin.trips.store') }}" method="POST">
                @csrf
                
                <div class="mb-6">
                    <label for="route_id" class="block text-sm font-medium text-gray-700 mb-2">Route</label>
                    <select id="route_id" 
                            name="route_id" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            required>
                        <option value="">Select a route</option>
                        @foreach($routes as $route)
                            <option value="{{ $route->id }}" {{ old('route_id') == $route->id ? 'selected' : '' }}>
                                {{ $route->origin }} → {{ $route->destination }}
                            </option>
                        @endforeach
                    </select>
                    @error('route_id')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="bus_id" class="block text-sm font-medium text-gray-700 mb-2">Bus</label>
                    <select id="bus_id" 
                            name="bus_id" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            required>
                        <option value="">Select a bus</option>
                        @foreach($buses as $bus)
                            <option value="{{ $bus->id }}" {{ old('bus_id') == $bus->id ? 'selected' : '' }}>
                                {{ $bus->name }} ({{ $bus->seat_count }} seats)
                            </option>
                        @endforeach
                    </select>
                    @error('bus_id')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="departure_date" class="block text-sm font-medium text-gray-700 mb-2">Departure Date</label>
                        <input type="date" 
                               id="departure_date" 
                               name="departure_date" 
                               value="{{ old('departure_date', date('Y-m-d')) }}"
                               min="{{ date('Y-m-d') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               required>
                        @error('departure_date')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="departure_time" class="block text-sm font-medium text-gray-700 mb-2">Departure Time</label>
                        <input type="time" 
                               id="departure_time" 
                               name="departure_time" 
                               value="{{ old('departure_time', '08:00') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               required>
                        @error('departure_time')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                @if($routes->isEmpty() || $buses->isEmpty())
                    <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4 mb-6">
                        <div class="flex items-start">
                            <i class="bi bi-exclamation-triangle text-yellow-600 mt-0.5 mr-3"></i>
                            <div>
                                <h4 class="text-sm font-medium text-yellow-800">Missing Requirements</h4>
                                <div class="text-sm text-yellow-700 mt-1">
                                    @if($routes->isEmpty())
                                        <p>• You need to <a href="{{ route('admin.routes.create') }}" class="underline">create at least one route</a> first.</p>
                                    @endif
                                    @if($buses->isEmpty())
                                        <p>• You need to <a href="{{ route('admin.buses.create') }}" class="underline">add at least one bus</a> first.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('admin.trips.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 {{ ($routes->isEmpty() || $buses->isEmpty()) ? 'opacity-50 cursor-not-allowed' : '' }}"
                            {{ ($routes->isEmpty() || $buses->isEmpty()) ? 'disabled' : '' }}>
                        Schedule Trip
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 