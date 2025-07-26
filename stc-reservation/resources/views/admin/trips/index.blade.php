@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Manage Trips</h1>
        <a href="{{ route('admin.trips.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
            <i class="bi bi-plus mr-2"></i> Add New Trip
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Route</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bus</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Time</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bookings</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($trips as $trip)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $trip->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $trip->route->origin }} → {{ $trip->route->destination }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $trip->bus->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div>{{ $trip->departure_date }}</div>
                        <div class="text-gray-500">{{ $trip->departure_time }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($trip->departure_date < now()->toDateString())
                            <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">Completed</span>
                        @elseif($trip->departure_date == now()->toDateString())
                            <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Today</span>
                        @else
                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Upcoming</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $trip->bookings_count ?? 0 }} / {{ $trip->bus->seat_count }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex justify-end space-x-2">
                            <a href="{{ route('admin.trips.show', $trip) }}" class="text-blue-600 hover:text-blue-900">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('admin.trips.edit', $trip) }}" class="text-yellow-600 hover:text-yellow-900">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.trips.destroy', $trip) }}" method="POST" class="inline" 
                                  onsubmit="return confirm('Are you sure you want to delete this trip? This will also cancel all bookings.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                        No trips found. <a href="{{ route('admin.trips.create') }}" class="text-blue-600 hover:underline">Schedule the first trip</a>.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($trips->hasPages())
        <div class="mt-6">
            {{ $trips->links() }}
        </div>
    @endif
</div>
@endsection 