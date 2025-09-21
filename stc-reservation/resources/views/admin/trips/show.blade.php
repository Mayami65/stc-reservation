@extends('layouts.app')

@section('content')
    <div class="container mx-auto max-w-2xl bg-white rounded-lg shadow-lg p-6 mt-8">
        <h1 class="text-3xl font-bold mb-8 flex items-center gap-2">
            <i class="bi bi-bus-front text-blue-600"></i>
            Trip Details
        </h1>
        <dl class="grid grid-cols-1 gap-y-4 text-base md:text-lg divide-y divide-gray-100 mb-8">
            <div class="flex items-center justify-between py-2">
                <dt class="font-semibold text-gray-500 flex items-center gap-2">
                    <i class="bi bi-geo-alt text-blue-500"></i> Route:
                </dt>
                <dd class="text-gray-900 font-medium flex items-center gap-2">
                    {{ $trip->route->origin }} <i class="bi bi-arrow-right mx-1 text-gray-400"></i> {{ $trip->route->destination }}
                </dd>
            </div>
            <div class="flex items-center justify-between py-2">
                <dt class="font-semibold text-gray-500 flex items-center gap-2">
                    <i class="bi bi-truck-front text-blue-500"></i> Bus:
                </dt>
                <dd class="text-gray-900 font-medium">{{ $trip->bus->name }} <span class="text-xs text-gray-500">({{ $trip->bus->seat_count }} seats)</span></dd>
            </div>
            <div class="flex items-center justify-between py-2">
                <dt class="font-semibold text-gray-500 flex items-center gap-2">
                    <i class="bi bi-calendar-event text-blue-500"></i> Departure Date:
                </dt>
                <dd class="text-gray-900 font-medium">{{ $trip->departure_date->format('l, jS F Y') }}</dd>
            </div>
            <div class="flex items-center justify-between py-2">
                <dt class="font-semibold text-gray-500 flex items-center gap-2">
                    <i class="bi bi-clock text-blue-500"></i> Departure Time:
                </dt>
                <dd class="text-gray-900 font-medium">{{ $trip->departure_time->format('H:i') }}</dd>
            </div>
            <div class="flex items-center justify-between py-2">
                <dt class="font-semibold text-gray-500 flex items-center gap-2">
                    <i class="bi bi-cash-coin text-blue-500"></i> Price:
                </dt>
                <dd class="text-gray-900 font-medium">GHS {{ number_format($trip->effective_price, 2) }}</dd>
            </div>
        </dl>
        <div class="mt-8">
            <a href="{{ route('admin.trips.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 hover:bg-blue-100 rounded text-blue-700 font-medium border border-blue-200 transition">
                <i class="bi bi-arrow-left"></i> Back to Trips
            </a>
        </div>

        <div class="mt-12">
            <h2 class="text-xl font-semibold mb-4 flex items-center gap-2">
                <i class="bi bi-person-check text-green-600"></i>
                Booked Seats
            </h2>
            @if($trip->bookings->count())
                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 border-b text-left text-sm font-semibold text-gray-700">Seat Number</th>
                                <th class="px-4 py-3 border-b text-left text-sm font-semibold text-gray-700">Passenger</th>
                                <th class="px-4 py-3 border-b text-left text-sm font-semibold text-gray-700">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($trip->bookings as $booking)
                                <tr class="hover:bg-blue-50 {{ $loop->even ? 'bg-gray-50' : '' }}">
                                    <td class="px-4 py-2 border-b text-center font-mono">{{ $booking->seat->seat_number ?? '-' }}</td>
                                    <td class="px-4 py-2 border-b">{{ $booking->user->name ?? 'N/A' }}</td>
                                    <td class="px-4 py-2 border-b text-center">
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded text-xs font-semibold {{ $booking->status === 'cancelled' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                            <i class="bi {{ $booking->status === 'cancelled' ? 'bi-x-circle' : 'bi-check-circle' }}"></i>
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500">No seats have been booked for this trip yet.</p>
            @endif
        </div>
    </div>
@endsection
