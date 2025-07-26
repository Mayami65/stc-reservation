@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2 flex items-center">
                        <i class="bi bi-list-ul text-orange-600 mr-3"></i> Manage Bookings
                    </h1>
                    <p class="text-gray-600">View and manage all bus reservations</p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="bg-orange-50 text-orange-800 px-4 py-2 rounded-lg">
                        <div class="text-sm font-medium">Total Bookings</div>
                        <div class="text-2xl font-bold">{{ $bookings->total() }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search and Filter Section -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <form method="GET" action="" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="relative">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}" 
                               placeholder="Search by user, route, seat..." 
                               class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                        <i class="bi bi-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                    
                    <div class="relative">
                        <select name="status"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent appearance-none bg-white">
                            <option value="">All Status</option>
                            <option value="booked" @if(request('status')=='booked') selected @endif>Booked</option>
                            <option value="checked-in" @if(request('status')=='checked-in') selected @endif>Checked-in</option>
                            <option value="cancelled" @if(request('status')=='cancelled') selected @endif>Cancelled</option>
                            <option value="completed" @if(request('status')=='completed') selected @endif>Completed</option>
                        </select>
                        <i class="bi bi-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                    </div>
                    
                    <div class="relative">
                        <select name="trip_id"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent appearance-none bg-white">
                            <option value="">All Trips</option>
                            @foreach(\App\Models\Trip::with('route')->get() as $trip)
                                <option value="{{ $trip->id }}" @if(request('trip_id') == $trip->id) selected @endif>
                                    {{ $trip->route->origin }} → {{ $trip->route->destination }} ({{ $trip->departure_date }})
                                </option>
                            @endforeach
                        </select>
                        <i class="bi bi-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                    </div>
                    
                    <button type="submit" 
                            class="bg-orange-600 hover:bg-orange-700 text-white px-6 py-2 rounded-lg font-medium transition duration-200 flex items-center justify-center">
                        <i class="bi bi-funnel mr-2"></i>
                        Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Bookings Table -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="bi bi-person mr-2"></i>
                                    User
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="bi bi-geo-alt mr-2"></i>
                                    Route
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="bi bi-calendar mr-2"></i>
                                    Trip Date
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="bi bi-clock mr-2"></i>
                                    Time
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="bi bi-grid-1x2 mr-2"></i>
                                    Seat
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="bi bi-info-circle mr-2"></i>
                                    Status
                                </div>
                            </th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($bookings as $booking)
                        <tr class="hover:bg-gray-50 transition duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                        <i class="bi bi-person text-blue-600"></i>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $booking->user->name ?? '-' }}</div>
                                        <div class="text-sm text-gray-500">{{ $booking->user->email ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $booking->trip->route->origin ?? '-' }} → {{ $booking->trip->route->destination ?? '-' }}
                                </div>
                                <div class="text-sm text-gray-500">{{ $booking->trip->bus->name ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $booking->trip->departure_date ?? '-' }}</div>
                                <div class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($booking->trip->departure_date ?? now())->format('l') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $booking->trip->departure_time ?? '-' }}</div>
                                <div class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($booking->trip->departure_time ?? '00:00')->format('g:i A') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    <i class="bi bi-grid-1x2 mr-1"></i>
                                    {{ $booking->seat->seat_number ?? '-' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php 
                                    $statusColors = [
                                        'booked' => 'bg-blue-100 text-blue-800',
                                        'checked-in' => 'bg-green-100 text-green-800',
                                        'cancelled' => 'bg-red-100 text-red-800',
                                        'completed' => 'bg-gray-100 text-gray-800',
                                    ];
                                @endphp
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $statusColors[$booking->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    <i class="bi bi-circle-fill mr-1 text-xs"></i>
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('admin.bookings.show', $booking) }}" 
                                       class="text-blue-600 hover:text-blue-900 transition duration-200"
                                       title="View Details">
                                        <i class="bi bi-eye text-lg"></i>
                                    </a>
                                    
                                    <form action="{{ route('admin.bookings.update', $booking) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" 
                                                onchange="this.form.submit()" 
                                                class="text-xs px-2 py-1 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-500 bg-white">
                                            <option value="booked" @if($booking->status=='booked') selected @endif>Booked</option>
                                            <option value="checked-in" @if($booking->status=='checked-in') selected @endif>Checked-in</option>
                                            <option value="cancelled" @if($booking->status=='cancelled') selected @endif>Cancelled</option>
                                            <option value="completed" @if($booking->status=='completed') selected @endif>Completed</option>
                                        </select>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="bi bi-inbox text-4xl text-gray-300 mb-3"></i>
                                    <h3 class="text-lg font-semibold text-gray-600 mb-2">No bookings found</h3>
                                    <p class="text-gray-500">Try adjusting your search or filter criteria</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if(method_exists($bookings, 'links'))
        <div class="mt-6 bg-white rounded-lg shadow-lg p-4">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Showing {{ $bookings->firstItem() ?? 0 }} to {{ $bookings->lastItem() ?? 0 }} of {{ $bookings->total() }} results
                </div>
                <div>
                    {{ $bookings->links() }}
                </div>
            </div>
        </div>
        @endif

        <!-- Quick Stats -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                        <i class="bi bi-bookmark-check text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Booked</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $bookings->where('status', 'booked')->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-4">
                        <i class="bi bi-check-circle text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Checked In</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $bookings->where('status', 'checked-in')->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mr-4">
                        <i class="bi bi-x-circle text-red-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Cancelled</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $bookings->where('status', 'cancelled')->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mr-4">
                        <i class="bi bi-check2-all text-gray-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Completed</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $bookings->where('status', 'completed')->count() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 