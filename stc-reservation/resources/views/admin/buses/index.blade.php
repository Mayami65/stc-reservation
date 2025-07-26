@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Manage Buses</h1>
        <a href="{{ route('admin.buses.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
            <i class="bi bi-plus mr-2"></i> Add New Bus
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
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bus Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Seat Count</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actual Seats</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($buses as $bus)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $bus->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $bus->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $bus->seat_count }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $bus->seats_count }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($bus->seat_count == $bus->seats_count)
                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Active</span>
                        @else
                            <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Setup Required</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $bus->created_at->format('M d, Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex justify-end space-x-2">
                            <a href="{{ route('admin.buses.show', $bus) }}" class="text-blue-600 hover:text-blue-900">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('admin.buses.edit', $bus) }}" class="text-yellow-600 hover:text-yellow-900">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.buses.destroy', $bus) }}" method="POST" class="inline" 
                                  onsubmit="return confirm('Are you sure you want to delete this bus? This will also delete all its seats and trips.')">
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
                        No buses found. <a href="{{ route('admin.buses.create') }}" class="text-blue-600 hover:underline">Add the first bus</a>.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($buses->hasPages())
        <div class="mt-6">
            {{ $buses->links() }}
        </div>
    @endif
</div>
@endsection 