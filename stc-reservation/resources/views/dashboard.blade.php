@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 px-4">
    <!-- Page Header -->
    <x-page-header 
        title="Dashboard" 
        description="Welcome back, {{ Auth::user()->name }}! Here's your account overview."
        icon="speedometer2" />

    <!-- Welcome Card -->
    <div class="max-w-4xl mx-auto">
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg shadow-lg p-8 mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h2 class="text-2xl font-bold mb-2">Welcome to STC Reservations!</h2>
                    <p class="text-blue-100 mb-4">You're successfully logged in and ready to book your next journey.</p>
                    <div class="flex items-center text-blue-100">
                        <i class="bi bi-person-circle me-2"></i>
                        <span>{{ Auth::user()->email }}</span>
                    </div>
                </div>
                <div class="mt-4 md:mt-0">
                    <div class="w-20 h-20 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <span class="text-3xl font-bold">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <x-action-card 
                href="{{ route('routes.index') }}"
                icon="geo-alt"
                title="Book a Trip"
                description="Find and book your next journey"
                icon-color="blue" />

            <x-action-card 
                href="#"
                icon="ticket-perforated"
                title="My Bookings"
                description="View your travel history"
                icon-color="green" />

            <x-action-card 
                href="{{ route('profile.edit') }}"
                icon="person-gear"
                title="Profile Settings"
                description="Update your information"
                icon-color="purple" />
        </div>

        @if(auth()->user()->hasRole('admin'))
        <!-- Admin Section -->
        <x-alert type="info" class="bg-red-50 border-red-200 text-red-700">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="p-3 bg-red-100 rounded-full mr-4">
                        <i class="bi bi-shield-check text-red-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-red-800">Administrator Access</h3>
                        <p class="text-red-600 text-sm">You have admin privileges for this system</p>
                    </div>
                </div>
                <a href="{{ route('admin.dashboard') }}" 
                   class="inline-flex items-center bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-lg transition duration-300">
                    <i class="bi bi-speedometer2 me-2"></i>
                    Go to Admin Dashboard
                </a>
            </div>
        </x-alert>
        @endif

        <!-- Recent Activity -->
        <x-section-card 
            title="Recent Activity" 
            icon="clock-history"
            header-color="gray">
            <div class="space-y-3">
                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                    <div class="w-2 h-2 bg-green-500 rounded-full mr-3"></div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-800">Account created successfully</p>
                        <p class="text-xs text-gray-500">{{ Auth::user()->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                    <div class="w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-800">Logged in to dashboard</p>
                        <p class="text-xs text-gray-500">Just now</p>
                    </div>
                </div>
            </div>
        </x-section-card>
    </div>
</div>
@endsection
