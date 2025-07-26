@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
            <i class="bi bi-ticket-perforated text-blue-600 mr-2"></i> My Bookings
        </h1>
        @if($bookings->count())
        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full divide-y divide-blue-100">
                <thead class="bg-blue-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-gray-700">Route</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-gray-700">Date</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-gray-700">Time</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-gray-700">Bus</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-gray-700">Seat</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-gray-700">Status</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-gray-700">Expires</th>
                        <th class="px-4 py-2"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-blue-50">
                    @foreach($bookings as $booking)
                    <tr>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $booking->trip->route->origin }} → {{ $booking->trip->route->destination }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $booking->trip->departure_date }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $booking->trip->departure_time }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $booking->trip->bus->name }}</td>
                        <td class="px-4 py-2 whitespace-nowrap font-bold text-blue-700">{{ $booking->seat->seat_number }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs rounded-full {{
                                $booking->status === 'booked' ? 'bg-blue-100 text-blue-800' :
                                ($booking->status === 'checked-in' ? 'bg-green-100 text-green-800' :
                                ($booking->status === 'cancelled' ? 'bg-red-100 text-red-800' :
                                'bg-gray-100 text-gray-700'))
                            }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-2 whitespace-nowrap">
                            @if($booking->expires_at)
                                <span class="{{ $booking->isExpired() ? 'text-red-600' : 'text-green-600' }}">
                                    {{ $booking->expires_at->format('M d, Y g:i A') }}
                                </span>
                            @else
                                <span class="text-gray-400">N/A</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 whitespace-nowrap text-right">
                            <a href="{{ route('bookings.show', $booking) }}" class="text-blue-600 hover:underline text-xs font-semibold">View</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="bg-white rounded-lg shadow p-6 text-center text-gray-500">
            <i class="bi bi-emoji-frown text-3xl mb-2"></i>
            <p>You have no bookings yet.</p>
        </div>
        @endif
    </div>
</div>
@endsection 