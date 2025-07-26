@extends('layouts.app')

@section('content')
<style>
    .login-bg {
        background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('/images/bus.jpg');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
    }
</style>
<div class="min-h-screen flex items-center justify-center px-4 relative login-bg">
    <div class="w-full max-w-md bg-white bg-opacity-95 p-8 rounded-2xl shadow-2xl backdrop-blur-md z-10">
        <div class="text-center mb-6">
            <h2 class="text-3xl font-extrabold text-blue-800">STC Bus Reservation</h2>
            <p class="text-sm text-gray-600 mt-1">Login to manage your bookings</p>
        </div>

        @if(session('status'))
        <div class="mb-4 text-sm text-green-600 font-medium">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-6 animate-fade-in">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="mt-2 w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none">
                @error('email')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-semibold text-gray-700">Password</label>
                <input id="password" type="password" name="password" required
                    class="mt-2 w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none">
                @error('password')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between">
                <label class="flex items-center text-sm text-gray-600">
                    <input type="checkbox" name="remember" class="mr-2">
                    Remember me
                </label>
                <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:underline">
                    Forgot password?
                </a>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md transition-all duration-200">
                    Login
                </button>
            </div>
        </form>

        <!-- Register Link -->
        <div class="text-center mt-6">
            <span class="text-sm text-gray-600">Don't have an account?</span>
            <a href="{{ route('register') }}" class="text-sm text-blue-600 hover:underline ml-1">Register</a>
        </div>

        <!-- Footer -->
        <div class="text-center text-xs text-gray-400 mt-6">
            &copy; {{ date('Y') }} STC Ghana. All rights reserved.
        </div>
    </div>
</div>

<style>
    @keyframes fade-in {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in {
        animation: fade-in 0.5s ease-out;
    }
</style>
@endsection