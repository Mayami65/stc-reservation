<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>STC Bus Reservation</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body { 
            background: #f8fafc; 
            font-family: 'Figtree', sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        .main-content {
            min-height: calc(100vh - 200px);
            padding-top: 80px; /* Reduced for mobile */
        }
        @media (min-width: 768px) {
            .main-content {
                padding-top: 100px; /* Full padding for desktop */
            }
        }
        .footer {
            background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
            color: #9ca3af;
            padding: 1.5rem 0;
            margin-top: 2rem;
        }
        @media (min-width: 768px) {
            .footer {
                padding: 2rem 0;
                margin-top: 4rem;
            }
        }
        .footer a {
            color: #60a5fa;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        .footer a:hover {
            color: #93c5fd;
        }
        /* Mobile-specific styles */
        @media (max-width: 767px) {
            .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }
            .max-w-7xl {
                max-width: 100%;
            }
        }
        /* Touch-friendly buttons */
        @media (max-width: 767px) {
            button, a {
                min-height: 44px;
                min-width: 44px;
            }
        }
    </style>
</head>
<body>
    @include('layouts.navigation')
    <main class="main-content">
        @yield('content')
    </main>
    <footer class="footer">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 md:gap-6">
                <div class="flex items-center mb-2 md:mb-0">
                    <i class="bi bi-bus-front text-blue-600 mr-2 text-2xl md:text-3xl"></i>
                    <strong class="text-sm md:text-base">State Transport Company</strong>
                </div>
                <div class="text-center md:text-right">
                    <p class="mb-1 flex items-center justify-center md:justify-end gap-2 text-sm">
                        <i class="bi bi-envelope"></i>
                        <a href="mailto:info@stc.com.gh">info@stc.com.gh</a>
                    </p>
                    <p class="mb-0 flex items-center justify-center md:justify-end gap-2 text-sm">
                        <i class="bi bi-telephone"></i>
                        <a href="tel:+233123456789">+233 123 456 789</a>
                    </p>
                </div>
            </div>
            <hr class="my-3 border-gray-700">
            <div class="text-center">
                <small class="text-xs md:text-sm">&copy; {{ date('Y') }} State Transport Company (STC). All rights reserved.</small>
            </div>
        </div>
    </footer>
</body>
</html>
