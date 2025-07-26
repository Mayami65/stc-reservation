<nav class="fixed top-0 left-0 right-0 z-50 bg-gradient-to-b from-white to-blue-50 shadow-md border-b border-blue-100">
    <div class="max-w-7xl mx-auto px-4 flex items-center justify-between h-20">
        <!-- Brand -->
        <a href="/" class="flex items-center font-bold text-2xl text-blue-800 tracking-wide">
            <span class="inline-flex mr-2">
                <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 24 24"><path d="M3 17.25V19a2 2 0 002 2h14a2 2 0 002-2v-1.75M3 17.25V8.75A2.75 2.75 0 015.75 6h12.5A2.75 2.75 0 0121 8.75v8.5M3 17.25h18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </span>
            STC Reservations
        </a>
        <!-- Main Nav -->
        <div class="flex-1 flex items-center justify-center">
            <ul class="flex space-x-2 md:space-x-4">
                @auth
                    @if(auth()->user()->hasRole('admin'))
                        <li>
                            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded-lg font-semibold text-red-700 bg-red-100 hover:bg-red-200 transition flex items-center">
                                <span class="mr-2">Admin Dashboard</span>
                                <span class="inline-block bg-gradient-to-r from-red-500 to-red-700 text-white text-xs px-2 py-0.5 rounded-full font-bold uppercase tracking-wider">Admin</span>
                            </a>
                        </li>
                    @else
                        <li>
                            <a href="/" class="px-4 py-2 rounded-lg font-medium text-gray-700 hover:bg-blue-100 hover:text-blue-700 transition {{ request()->is('/') ? 'bg-blue-100 text-blue-700' : '' }}">
                                Home
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('routes.index') }}" class="px-4 py-2 rounded-lg font-medium text-gray-700 hover:bg-blue-100 hover:text-blue-700 transition {{ request()->routeIs('routes.index') ? 'bg-blue-100 text-blue-700' : '' }}">
                                Book Ticket
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('user.bookings') }}" class="px-4 py-2 rounded-lg font-medium text-gray-700 hover:bg-blue-100 hover:text-blue-700 transition {{ request()->routeIs('user.bookings') ? 'bg-blue-100 text-blue-700' : '' }}">
                                My Bookings
                            </a>
                        </li>
                    @endif
                @else
                    <li>
                        <a href="/" class="px-4 py-2 rounded-lg font-medium text-gray-700 hover:bg-blue-100 hover:text-blue-700 transition {{ request()->is('/') ? 'bg-blue-100 text-blue-700' : '' }}">
                            Home
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('routes.index') }}" class="px-4 py-2 rounded-lg font-medium text-gray-700 hover:bg-blue-100 hover:text-blue-700 transition {{ request()->routeIs('routes.index') ? 'bg-blue-100 text-blue-700' : '' }}">
                            Book Ticket
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
        <!-- Right Side -->
        <div class="flex items-center space-x-2">
            @auth
                <!-- User Dropdown -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" @keydown.escape="open = false" class="flex items-center px-3 py-2 rounded-lg hover:bg-blue-100 transition focus:outline-none">
                        <span class="w-9 h-9 rounded-full bg-gradient-to-br from-blue-600 to-blue-400 text-white flex items-center justify-center font-bold mr-2">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </span>
                        <span class="hidden md:inline text-gray-800 font-semibold">{{ Auth::user()->name }}</span>
                        <svg class="w-4 h-4 ml-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg py-2 z-50 border border-blue-100" x-transition>
                        <a href="{{ route('profile.edit') }}" class="px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition flex items-center">
                            <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.485 0 4.847.635 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            Profile
                        </a>
                        @if(auth()->user()->hasRole('admin'))
                        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition flex items-center">
                            <svg class="w-4 h-4 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6" /></svg>
                            Admin Dashboard
                        </a>
                        @else
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition flex items-center">
                            <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6" /></svg>
                            Dashboard
                        </a>
                        @endif
                        <a href="#" class="px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition flex items-center">
                            <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                            Settings
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition flex items-center">
                                <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7" /></svg>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="px-4 py-2 rounded-lg font-medium text-gray-700 hover:bg-blue-100 hover:text-blue-700 transition">Login</a>
                <a href="{{ route('register') }}" class="px-4 py-2 rounded-lg font-medium text-gray-700 hover:bg-blue-100 hover:text-blue-700 transition">Register</a>
            @endauth
        </div>
    </div>
</nav>
