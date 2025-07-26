@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 relative" style="background: linear-gradient(rgba(13,110,253,0.7),rgba(13,110,253,0.7)), url('https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1500&q=80') center/cover no-repeat;">
    <div class="w-full max-w-md bg-white bg-opacity-95 p-8 rounded-xl shadow-lg z-10">
        <div class="text-center mb-6">
            <h2 class="text-3xl font-bold text-blue-800">STC Bus Reservation</h2>
            <p class="text-sm text-gray-500">Create your account to start booking your seat.</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                       class="mt-1 block w-full px-4 py-2 border rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none focus:border-blue-500">
                @error('name')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                       class="mt-1 block w-full px-4 py-2 border rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none focus:border-blue-500">
                @error('email')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input id="password" type="password" name="password" required
                       class="mt-1 block w-full px-4 py-2 border rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none focus:border-blue-500">
                @error('password')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                       class="mt-1 block w-full px-4 py-2 border rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none focus:border-blue-500">
            </div>

            <!-- Submit -->
            <div>
                <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md shadow transition duration-200">
                    Register
                </button>
            </div>
        </form>

        <div class="text-center mt-6">
            <span class="text-sm text-gray-600">Already have an account?</span>
            <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:underline ml-1">Log in</a>
        </div>

        <div class="text-center text-sm text-gray-500 mt-6">
            &copy; {{ date('Y') }} STC Ghana. All rights reserved.
        </div>
    </div>
</div>
@endsection
