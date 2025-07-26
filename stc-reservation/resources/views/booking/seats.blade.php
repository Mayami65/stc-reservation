@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 px-4">
    <div class="max-w-4xl mx-auto">
        <!-- Breadcrumb -->
        <nav class="mb-6">
            <ol class="flex flex-wrap items-center space-x-2 text-xs sm:text-sm text-gray-600">
                <li><a href="{{ route('routes.index') }}" class="hover:text-blue-600 transition">Available Routes</a></li>
                <li><i class="bi bi-chevron-right"></i></li>
                <li><a href="{{ route('routes.trips', $trip->route) }}" class="hover:text-blue-600 transition">{{ $trip->route->origin }} → {{ $trip->route->destination }}</a></li>
                <li><i class="bi bi-chevron-right"></i></li>
                <li class="text-gray-800 font-medium">Select Seats</li>
            </ol>
        </nav>
        <!-- Trip Info Header -->
        <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6 mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-lg sm:text-2xl md:text-3xl font-bold text-gray-800 mb-2">
                        <i class="bi bi-grid-1x2 text-blue-600 me-2"></i>
                        Select Your Seats
                    </h1>
                    <div class="text-gray-600 text-xs sm:text-sm">
                        <div class="flex items-center mb-1">
                            <i class="bi bi-geo-alt me-2"></i>
                            <span>{{ $trip->route->origin }} → {{ $trip->route->destination }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="bi bi-calendar3 me-2"></i>
                            <span>{{ \Carbon\Carbon::parse($trip->departure_date)->format('l, M j, Y') }} at {{ \Carbon\Carbon::parse($trip->departure_time)->format('g:i A') }}</span>
                        </div>
                    </div>
                </div>
                <div class="mt-4 md:mt-0">
                    <div class="bg-blue-50 text-blue-800 px-4 py-2 rounded-lg text-xs sm:text-base">
                        <div class="text-xs">Bus</div>
                        <div class="font-bold">{{ $trip->bus->name }}</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Alerts -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 text-xs sm:text-sm">
                <div class="flex items-center">
                    <i class="bi bi-check-circle text-xl me-2"></i>
                    {{ session('success') }}
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 text-xs sm:text-sm">
                <div class="flex items-center">
                    <i class="bi bi-exclamation-triangle text-xl me-2"></i>
                    {{ session('error') }}
                </div>
            </div>
        @endif
        <!-- Seat Legend -->
        <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6 mb-8">
            <h3 class="text-base sm:text-lg font-semibold text-gray-800 mb-4">Seat Legend</h3>
            <div class="flex flex-wrap gap-4 sm:gap-6">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-green-500 rounded-lg mr-2 flex items-center justify-center text-white text-xs sm:text-sm font-bold">A1</div>
                    <span class="text-gray-700 text-xs sm:text-sm">Available</span>
                </div>
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-blue-500 rounded-lg mr-2 flex items-center justify-center text-white text-xs sm:text-sm font-bold">A2</div>
                    <span class="text-gray-700 text-xs sm:text-sm">Selected</span>
                </div>
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-red-500 rounded-lg mr-2 flex items-center justify-center text-white text-xs sm:text-sm font-bold">A3</div>
                    <span class="text-gray-700 text-xs sm:text-sm">Booked</span>
                </div>
            </div>
        </div>
        <!-- Seat Map -->
        <form method="POST" action="{{ route('trips.book', $trip) }}" id="seatForm">
            @csrf
            <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6 mb-8">
                <div class="text-center mb-6">
                    <div class="inline-block bg-gray-100 px-4 py-2 rounded-lg text-xs sm:text-base">
                        <i class="bi bi-person-workspace me-2"></i>
                        <span class="font-semibold">Driver</span>
                    </div>
                </div>
                <!-- Bus Seat Layout -->
                <div class="max-w-xs sm:max-w-md mx-auto">
                    <div class="grid grid-cols-4 gap-2 sm:gap-3 mb-4">
                        @foreach($seats as $index => $seat)
                            @php
                                $isBooked = in_array($seat->id, $bookedSeatIds);
                                $seatNumber = $seat->seat_number;
                                $row = substr($seatNumber, 0, 1); // A, B, C, etc.
                                $col = substr($seatNumber, 1); // 1, 2, 3, 4
                                $isAisle = ($col == '2'); // Add space after seat 2 for aisle
                            @endphp
                            <div class="relative">
                                <input type="checkbox" 
                                       name="seat_ids[]" 
                                       value="{{ $seat->id }}" 
                                       id="seat_{{ $seat->id }}"
                                       class="sr-only seat-checkbox"
                                       {{ $isBooked ? 'disabled' : '' }}>
                                <label for="seat_{{ $seat->id }}" 
                                       class="seat-label w-10 h-10 sm:w-12 sm:h-12 rounded-lg border-2 cursor-pointer transition-all duration-200 flex items-center justify-center text-white font-bold text-xs sm:text-sm
                                              {{ $isBooked ? 'bg-red-500 border-red-600 cursor-not-allowed' : 'bg-green-500 border-green-600 hover:bg-green-600 hover:scale-105' }}">
                                    {{ $seatNumber }}
                                </label>
                            </div>
                            @if($isAisle && ($index + 1) % 4 != 0)
                                <div class="w-2 sm:w-4"></div> <!-- Aisle space -->
                            @endif
                        @endforeach
                    </div>
                </div>
                <!-- Selected Seats Info -->
                <div id="selectedSeatsInfo" class="text-center py-4 hidden">
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 inline-block text-xs sm:text-sm">
                        <div class="text-blue-800 mb-2">
                            <i class="bi bi-check-circle me-2"></i>
                            Selected Seats: <span id="selectedSeatsList" class="font-bold"></span>
                        </div>
                        <div class="text-blue-700">
                            Total Seats: <span id="selectedSeatsCount" class="font-bold">0</span>
                        </div>
                    </div>
                </div>
                <!-- Book Button -->
                <div class="text-center mt-6">
                    <button type="submit" 
                            id="bookButton"
                            class="bg-blue-600 hover:bg-blue-700 text-white py-2 sm:py-3 px-6 sm:px-8 rounded-lg font-semibold transition duration-300 transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none text-xs sm:text-sm"
                            disabled>
                        <i class="bi bi-ticket-perforated me-2"></i>
                        Book Selected Seats
                    </button>
                </div>
            </div>
        </form>
        <!-- Back Button -->
        <div class="text-center">
            <a href="{{ route('routes.trips', $trip->route) }}" 
               class="inline-block bg-gray-100 hover:bg-gray-200 text-gray-700 py-2 px-6 rounded-lg transition duration-300 text-xs sm:text-sm">
                <i class="bi bi-arrow-left me-2"></i>
                Back to Trips
            </a>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const seatCheckboxes = document.querySelectorAll('.seat-checkbox');
    const selectedSeatsInfo = document.getElementById('selectedSeatsInfo');
    const selectedSeatsList = document.getElementById('selectedSeatsList');
    const selectedSeatsCount = document.getElementById('selectedSeatsCount');
    const bookButton = document.getElementById('bookButton');
    const seatLabels = document.querySelectorAll('.seat-label');

    function updateSelectedSeats() {
        const selectedSeats = Array.from(seatCheckboxes)
            .filter(checkbox => checkbox.checked)
            .map(checkbox => {
                const label = document.querySelector(`label[for="${checkbox.id}"]`);
                return label.textContent.trim();
            });

        const count = selectedSeats.length;
        
        if (count > 0) {
            selectedSeatsInfo.classList.remove('hidden');
            selectedSeatsList.textContent = selectedSeats.join(', ');
            selectedSeatsCount.textContent = count;
            bookButton.disabled = false;
            bookButton.innerHTML = `<i class="bi bi-ticket-perforated me-2"></i>Book ${count} Seat${count > 1 ? 's' : ''}`;
        } else {
            selectedSeatsInfo.classList.add('hidden');
            bookButton.disabled = true;
            bookButton.innerHTML = `<i class="bi bi-ticket-perforated me-2"></i>Book Selected Seats`;
        }
    }

    // Handle seat selection
    seatCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const label = document.querySelector(`label[for="${this.id}"]`);
            
            if (this.checked) {
                label.classList.remove('bg-green-500', 'border-green-600', 'hover:bg-green-600');
                label.classList.add('bg-blue-500', 'border-blue-600');
            } else {
                label.classList.remove('bg-blue-500', 'border-blue-600');
                label.classList.add('bg-green-500', 'border-green-600', 'hover:bg-green-600');
            }
            
            updateSelectedSeats();
        });
    });

    // Initialize
    updateSelectedSeats();
});
</script>
@endsection