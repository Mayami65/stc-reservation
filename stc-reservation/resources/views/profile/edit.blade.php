@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 px-4">
    <!-- Breadcrumb -->
    <nav class="mb-6">
        <ol class="flex items-center space-x-2 text-sm text-gray-600">
            <li><a href="{{ route('dashboard') }}" class="hover:text-blue-600 transition">Dashboard</a></li>
            <li><i class="bi bi-chevron-right"></i></li>
            <li class="text-gray-800 font-medium">Profile Settings</li>
        </ol>
    </nav>

    <!-- Page Header -->
    <x-page-header 
        title="Profile Settings" 
        description="Manage your account information and security settings"
        icon="person-gear" />

    <div class="max-w-4xl mx-auto space-y-8">
        <!-- Profile Information -->
        <x-section-card 
            title="Profile Information" 
            icon="person"
            header-color="blue">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </x-section-card>

        <!-- Update Password -->
        <x-section-card 
            title="Update Password" 
            icon="shield-lock"
            header-color="green">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </x-section-card>

        <!-- Delete Account -->
        <x-section-card 
            title="Delete Account" 
            icon="exclamation-triangle"
            header-color="red">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </x-section-card>

        <!-- Back to Dashboard -->
        <div class="text-center">
            <a href="{{ route('dashboard') }}" 
               class="inline-flex items-center bg-gray-100 hover:bg-gray-200 text-gray-700 py-2 px-6 rounded-lg transition duration-300">
                <i class="bi bi-arrow-left me-2"></i>
                Back to Dashboard
            </a>
        </div>
    </div>
</div>
@endsection
