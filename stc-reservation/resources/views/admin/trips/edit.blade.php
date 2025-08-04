@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center mb-6">
            <a href="{{ route('admin.trips.index') }}" class="text-blue-600 hover:text-blue-800 mr-4">
                <i class="bi bi-arrow-left text-xl"></i>
            </a>
            <h1 class="text-3xl font-bold text-gray-800">Edit Trip</h1>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('admin.trips.update', $trip) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-6">
                    <label for="route_id" class="block text-sm font-medium text-gray-700 mb-2">Route</label>
                    <select id="route_id" 
                            name="route_id" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            required>
                        <option value="">Select a route</option>
                        @foreach($routes as $route)
                            <option value="{{ $route->id }}" {{ old('route_id', $trip->route_id) == $route->id ? 'selected' : '' }}>
                                {{ $route->origin }} → {{ $route->destination }} (₵{{ number_format($route->price, 2) }})
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
                            <option value="{{ $bus->id }}" {{ old('bus_id', $trip->bus_id) == $bus->id ? 'selected' : '' }}>
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
                               value="{{ old('departure_date', $trip->departure_date->format('Y-m-d')) }}"
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
                               value="{{ old('departure_time', $trip->departure_time->format('H:i')) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               required>
                        @error('departure_time')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-6">
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                        Price per Seat (GHS) 
                        <span class="text-gray-500 text-xs">(Leave empty to use route default price)</span>
                    </label>
                    <input type="number" 
                           id="price" 
                           name="price" 
                           value="{{ old('price', $trip->price) }}"
                           step="0.01"
                           min="0"
                           placeholder="Enter custom price or leave empty for route default"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('price')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-sm text-gray-500 mt-1">
                        <i class="bi bi-info-circle me-1"></i>
                        Current effective price: <strong>₵{{ number_format($trip->effective_price, 2) }}</strong>
                        @if($trip->hasCustomPrice())
                            <span class="text-blue-600">(Custom price set)</span>
                        @else
                            <span class="text-gray-600">(Using route default)</span>
                        @endif
                    </p>
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('admin.trips.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        Cancel
                    </a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Update Trip
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 