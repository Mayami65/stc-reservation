@extends('layouts.app')

@section('content')
<!-- HERO SECTION -->
<div class="relative bg-cover bg-center min-h-[60vh] flex items-center justify-center text-white"
     style="background-image: url('https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&w=1500&q=80');">
    <div class="absolute inset-0 bg-blue-950 bg-opacity-60"></div>
    <div class="relative z-10 text-center max-w-2xl px-4 py-16 sm:py-24">
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-6 drop-shadow-lg">Travel Smart with STC</h1>
        <p class="text-base sm:text-lg md:text-xl mb-8 drop-shadow">Book your seat online, receive your QR code ticket, and travel with comfort across Ghana.</p>
        <a href="{{ route('routes.index') }}"
           class="inline-block bg-white text-blue-700 font-semibold text-base sm:text-lg px-6 sm:px-8 py-3 sm:py-4 rounded-full shadow-lg transition duration-300 hover:bg-blue-50 hover:shadow-xl transform hover:-translate-y-1">
            <i class="bi bi-ticket-perforated me-2"></i> Start Booking
        </a>
    </div>
</div>

<!-- FEATURES SECTION -->
<div class="max-w-6xl mx-auto px-4 py-12 sm:py-16">
    <div class="text-center mb-10">
        <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 mb-4">Why Choose STC Online?</h2>
        <p class="text-gray-600 text-base sm:text-lg max-w-2xl mx-auto">Experience the future of bus travel with our modern booking system designed for your convenience.</p>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8">
        <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-2">
            <div class="text-blue-600 text-3xl sm:text-4xl mb-4 text-center"><i class="bi bi-laptop"></i></div>
            <h3 class="text-lg sm:text-xl font-semibold mb-3 text-center">Online Booking</h3>
            <p class="text-gray-600 text-sm text-center">Reserve your seat from anywhere, anytime with our easy-to-use platform.</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-2">
            <div class="text-green-600 text-3xl sm:text-4xl mb-4 text-center"><i class="bi bi-grid-1x2"></i></div>
            <h3 class="text-lg sm:text-xl font-semibold mb-3 text-center">Real-Time Seats</h3>
            <p class="text-gray-600 text-sm text-center">See live seat availability for every trip and choose your preferred spot.</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-2">
            <div class="text-purple-600 text-3xl sm:text-4xl mb-4 text-center"><i class="bi bi-qr-code"></i></div>
            <h3 class="text-lg sm:text-xl font-semibold mb-3 text-center">QR Code Tickets</h3>
            <p class="text-gray-600 text-sm text-center">Get secure QR code tickets instantly - no more paper tickets to lose.</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-2">
            <div class="text-red-600 text-3xl sm:text-4xl mb-4 text-center"><i class="bi bi-shield-check"></i></div>
            <h3 class="text-lg sm:text-xl font-semibold mb-3 text-center">Secure & Fast</h3>
            <p class="text-gray-600 text-sm text-center">Enjoy peace of mind with our secure booking and fast check-in process.</p>
        </div>
    </div>
</div>

<!-- STATS SECTION -->
<div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white py-16">
    <div class="max-w-6xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
            <div>
                <div class="text-4xl md:text-5xl font-bold mb-2">50+</div>
                <div class="text-lg opacity-90">Routes Available</div>
            </div>
            <div>
                <div class="text-4xl md:text-5xl font-bold mb-2">10K+</div>
                <div class="text-lg opacity-90">Happy Passengers</div>
            </div>
            <div>
                <div class="text-4xl md:text-5xl font-bold mb-2">99%</div>
                <div class="text-lg opacity-90">On-Time Performance</div>
            </div>
        </div>
    </div>
</div>

<!-- TESTIMONIAL SECTION -->
<div class="bg-gray-50 py-12 sm:py-16">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <h2 class="text-2xl sm:text-3xl font-bold mb-8 text-gray-800">What Our Passengers Say</h2>
        <div class="bg-white rounded-2xl shadow-lg p-6 sm:p-8 mx-auto max-w-3xl">
            <div class="flex items-center justify-center mb-4">
                <div class="flex text-yellow-400 text-lg sm:text-xl">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                </div>
            </div>
            <p class="text-gray-700 text-base sm:text-lg italic mb-6">"Booking my ticket online was so easy! The QR code system is fast and secure. No more waiting in long queues. Great service by STC!"</p>
            <div class="flex items-center justify-center">
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold mr-4">A</div>
                <div>
                    <div class="font-semibold text-gray-800">Ama Owusu</div>
                    <div class="text-gray-600 text-xs sm:text-sm">Regular Passenger, Accra</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CTA SECTION -->
<div class="bg-gradient-to-r from-blue-700 to-blue-800 text-white py-12 sm:py-16">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold mb-4">Ready to Travel Smarter?</h2>
        <p class="text-base sm:text-lg mb-8 opacity-90">Join thousands of satisfied passengers. Book your next trip with ease and convenience.</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('routes.index') }}"
               class="inline-block bg-white text-blue-800 font-semibold text-base sm:text-lg px-6 sm:px-8 py-3 sm:py-4 rounded-full shadow-lg transition duration-300 hover:bg-gray-100 transform hover:-translate-y-1">
                <i class="bi bi-geo-alt me-2"></i> Reserve Your Seat Now
            </a>
            @guest
            <a href="{{ route('register') }}"
               class="inline-block border-2 border-white text-white font-semibold text-base sm:text-lg px-6 sm:px-8 py-3 sm:py-4 rounded-full transition duration-300 hover:bg-white hover:text-blue-800 transform hover:-translate-y-1">
                <i class="bi bi-person-plus me-2"></i> Create Account
            </a>
            @endguest
        </div>
    </div>
</div>
@endsection
