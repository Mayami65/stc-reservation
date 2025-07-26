<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>STC Bus Reservation</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body { 
            background: #f8fafc; 
            font-family: 'Figtree', sans-serif;
        }
        .main-content {
            min-height: calc(100vh - 200px);
            padding-top: 100px; /* Account for fixed navbar */
        }
        .footer {
            background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
            color: #9ca3af;
            padding: 2rem 0;
            margin-top: 4rem;
        }
        .footer a {
            color: #60a5fa;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        .footer a:hover {
            color: #93c5fd;
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
            <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-6">
                <div class="flex items-center mb-2 md:mb-0">
                    <i class="bi bi-bus-front text-blue-600 mr-2" style="font-size: 1.5rem;"></i>
                    <strong>State Transport Company</strong>
                </div>
                <div class="text-md-end">
                    <p class="mb-1 flex items-center gap-2">
                        <i class="bi bi-envelope"></i>
                        <a href="mailto:info@stc.com.gh">info@stc.com.gh</a>
                    </p>
                    <p class="mb-0 flex items-center gap-2">
                        <i class="bi bi-telephone"></i>
                        <a href="tel:+233123456789">+233 123 456 789</a>
                    </p>
                </div>
            </div>
            <hr class="my-3 border-gray-700">
            <div class="text-center">
                <small>&copy; {{ date('Y') }} State Transport Company (STC). All rights reserved.</small>
            </div>
        </div>
    </footer>
</body>
</html>
