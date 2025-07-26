@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center mb-6">
            <a href="{{ route('admin.buses.index') }}" class="text-blue-600 hover:text-blue-800 mr-4">
                <i class="bi bi-arrow-left text-xl"></i>
            </a>
            <h1 class="text-3xl font-bold text-gray-800">Add New Bus</h1>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('admin.buses.store') }}" method="POST">
                @csrf
                
                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Bus Name</label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="e.g., STC Express 001"
                           required>
                    @error('name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="seat_count" class="block text-sm font-medium text-gray-700 mb-2">Number of Seats</label>
                    <input type="number" 
                           id="seat_count" 
                           name="seat_count" 
                           value="{{ old('seat_count', 40) }}"
                           min="1" 
                           max="100"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="40"
                           required>
                    <p class="text-sm text-gray-500 mt-1">Seats will be automatically generated (A1, A2, B1, B2, etc.)</p>
                    @error('seat_count')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="bg-blue-50 border border-blue-200 rounded-md p-4 mb-6">
                    <div class="flex items-start">
                        <i class="bi bi-info-circle text-blue-600 mt-0.5 mr-3"></i>
                        <div>
                            <h4 class="text-sm font-medium text-blue-800">Seat Layout Information</h4>
                            <p class="text-sm text-blue-700 mt-1">
                                Seats are arranged in rows of 4 (A1-A4, B1-B4, C1-C4, etc.). 
                                For example, a 40-seat bus will have seats A1 through J4.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('admin.buses.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        Cancel
                    </a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Create Bus
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 