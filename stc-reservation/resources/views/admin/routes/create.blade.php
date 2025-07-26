@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center mb-6">
            <a href="{{ route('admin.routes.index') }}" class="text-blue-600 hover:text-blue-800 mr-4">
                <i class="bi bi-arrow-left text-xl"></i>
            </a>
            <h1 class="text-3xl font-bold text-gray-800">Add New Route</h1>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('admin.routes.store') }}" method="POST">
                @csrf
                
                <div class="mb-6">
                    <label for="origin" class="block text-sm font-medium text-gray-700 mb-2">Origin</label>
                    <input type="text" 
                           id="origin" 
                           name="origin" 
                           value="{{ old('origin') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="e.g., Accra"
                           required>
                    @error('origin')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="destination" class="block text-sm font-medium text-gray-700 mb-2">Destination</label>
                    <input type="text" 
                           id="destination" 
                           name="destination" 
                           value="{{ old('destination') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="e.g., Kumasi"
                           required>
                    @error('destination')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('admin.routes.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        Cancel
                    </a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Create Route
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 