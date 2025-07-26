@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Manage Bookings</h1>
        <form method="GET" action="" class="flex flex-col sm:flex-row gap-3 items-center">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by user, route, seat..." class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
            <div class="relative w-44 sm:w-52">
                <select name="status"
                    class="block w-full px-4 py-2 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-500 text-base font-semibold bg-white text-gray-800 !appearance-none pr-10 transition">
                    <option value="">All Status</option>
                    <option value="booked" @if(request('status')=='booked') selected @endif>Booked</option>
                    <option value="checked-in" @if(request('status')=='checked-in') selected @endif>Checked-in</option>
                    <option value="cancelled" @if(request('status')=='cancelled') selected @endif>Cancelled</option>
                    <option value="completed" @if(request('status')=='completed') selected @endif>Completed</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-300">
                </div>
            </div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm">Filter</button>
        </form>
    </div>
    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-xs sm:text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <!-- <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">ID</th> -->
                    <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">User</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Route</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Trip Date</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Time</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Seat</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-4 py-3 text-right font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($bookings as $booking)
                <tr>
                    <!-- <td class="px-4 py-3 font-semibold text-gray-900">#{{ $booking->id }}</td> -->
                    <td class="px-4 py-3">{{ $booking->user->name ?? '-' }}</td>
                    <td class="px-4 py-3">{{ $booking->trip->route->origin ?? '-' }} → {{ $booking->trip->route->destination ?? '-' }}</td>
                    <td class="px-4 py-3">{{ $booking->trip->departure_date ?? '-' }}</td>
                    <td class="px-4 py-3">{{ $booking->trip->departure_time ?? '-' }}</td>
                    <td class="px-4 py-3">{{ $booking->seat->seat_number ?? '-' }}</td>
                    <td class="px-4 py-3">
                        @php $statusColors = [
                            'booked' => 'bg-blue-100 text-blue-800',
                            'checked-in' => 'bg-green-100 text-green-800',
                            'cancelled' => 'bg-red-100 text-red-800',
                            'completed' => 'bg-gray-200 text-gray-900',
                        ]; @endphp
                        <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $statusColors[$booking->status] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-right">
                        <a href="{{ route('admin.bookings.show', $booking) }}" class="text-blue-600 hover:text-blue-900 mr-2" title="View"><i class="bi bi-eye"></i></a>
                        {{-- Remove Edit link since admin.bookings.edit route does not exist --}}
                        {{-- <a href="{{ route('admin.bookings.edit', $booking) }}" class="text-yellow-600 hover:text-yellow-900 mr-2" title="Edit"><i class="bi bi-pencil"></i></a> --}}
                        <form action="{{ route('admin.bookings.update', $booking) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <select name="status" onchange="this.form.submit()" class="text-xs px-2 py-1 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="booked" @if($booking->status=='booked') selected @endif>Booked</option>
                                <option value="checked-in" @if($booking->status=='checked-in') selected @endif>Checked-in</option>
                                <option value="cancelled" @if($booking->status=='cancelled') selected @endif>Cancelled</option>
                                <option value="completed" @if($booking->status=='completed') selected @endif>Completed</option>
                            </select>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-4 py-6 text-center text-gray-500">No bookings found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if(method_exists($bookings, 'links'))
        <div class="mt-6">
            {{ $bookings->links() }}
        </div>
    @endif
</div>
@endsection 