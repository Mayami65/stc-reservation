<nav class="fixed top-0 left-0 right-0 z-50 bg-gradient-to-b from-white to-blue-50 shadow-md border-b border-blue-100">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center justify-between h-16 md:h-20">
            <!-- Brand -->
            <a href="/" class="flex items-center font-bold text-xl md:text-2xl text-blue-800 tracking-wide">
                <i class="bi bi-bus-front text-blue-600 mr-2 text-2xl md:text-3xl"></i>
                <span class="hidden sm:inline">STC Reservations</span>
                <span class="sm:hidden">STC</span>
            </a>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-1 lg:space-x-4">
                @auth
                    @if(auth()->user()->hasRole('admin'))
                        <a href="{{ route('admin.dashboard') }}" class="px-3 lg:px-4 py-2 rounded-lg font-semibold text-red-700 bg-red-100 hover:bg-red-200 transition flex items-center text-sm">
                            <i class="bi bi-speedometer2 mr-2"></i>
                            <span class="mr-2">Admin</span>
                            <span class="inline-block bg-gradient-to-r from-red-500 to-red-700 text-white text-xs px-2 py-0.5 rounded-full font-bold uppercase tracking-wider">Admin</span>
                        </a>
                        <a href="{{ route('admin.routes.index') }}" class="px-3 lg:px-4 py-2 rounded-lg font-medium text-gray-700 hover:bg-red-100 hover:text-red-700 transition text-sm {{ request()->routeIs('admin.routes.*') ? 'bg-red-100 text-red-700' : '' }}">
                            <i class="bi bi-geo-alt me-1"></i>
                            Manage Routes
                        </a>
                        <a href="{{ route('admin.trips.index') }}" class="px-3 lg:px-4 py-2 rounded-lg font-medium text-gray-700 hover:bg-red-100 hover:text-red-700 transition text-sm {{ request()->routeIs('admin.trips.*') ? 'bg-red-100 text-red-700' : '' }}">
                            <i class="bi bi-calendar-event me-1"></i>
                            Manage Trips
                        </a>
                        <a href="{{ route('admin.buses.index') }}" class="px-3 lg:px-4 py-2 rounded-lg font-medium text-gray-700 hover:bg-red-100 hover:text-red-700 transition text-sm {{ request()->routeIs('admin.buses.*') ? 'bg-red-100 text-red-700' : '' }}">
                            <i class="bi bi-bus-front me-1"></i>
                            Manage Buses
                        </a>
                    @else
                        <a href="/" class="px-3 lg:px-4 py-2 rounded-lg font-medium text-gray-700 hover:bg-blue-100 hover:text-blue-700 transition text-sm {{ request()->is('/') ? 'bg-blue-100 text-blue-700' : '' }}">
                            <i class="bi bi-house me-1"></i>
                            Home
                        </a>
                        <a href="{{ route('routes.index') }}" class="px-3 lg:px-4 py-2 rounded-lg font-medium text-gray-700 hover:bg-blue-100 hover:text-blue-700 transition text-sm {{ request()->routeIs('routes.index') ? 'bg-blue-100 text-blue-700' : '' }}">
                            <i class="bi bi-geo-alt me-1"></i>
                            Routes
                        </a>
                        <a href="{{ route('book.tickets') }}" class="px-3 lg:px-4 py-2 rounded-lg font-medium text-gray-700 hover:bg-blue-100 hover:text-blue-700 transition text-sm {{ request()->routeIs('book.tickets') ? 'bg-blue-100 text-blue-700' : '' }}">
                            <i class="bi bi-ticket-perforated me-1"></i>
                            Book Ticket
                        </a>
                        <a href="{{ route('user.bookings') }}" class="px-3 lg:px-4 py-2 rounded-lg font-medium text-gray-700 hover:bg-blue-100 hover:text-blue-700 transition text-sm {{ request()->routeIs('user.bookings') ? 'bg-blue-100 text-blue-700' : '' }}">
                            <i class="bi bi-list-ul me-1"></i>
                            My Bookings
                        </a>
                    @endif
                @else
                    <a href="/" class="px-3 lg:px-4 py-2 rounded-lg font-medium text-gray-700 hover:bg-blue-100 hover:text-blue-700 transition text-sm {{ request()->is('/') ? 'bg-blue-100 text-blue-700' : '' }}">
                        <i class="bi bi-house me-1"></i>
                        Home
                    </a>
                    <a href="{{ route('routes.index') }}" class="px-3 lg:px-4 py-2 rounded-lg font-medium text-gray-700 hover:bg-blue-100 hover:text-blue-700 transition text-sm {{ request()->routeIs('routes.index') ? 'bg-blue-100 text-blue-700' : '' }}">
                        <i class="bi bi-geo-alt me-1"></i>
                        Routes
                    </a>
                    <a href="{{ route('book.tickets') }}" class="px-3 lg:px-4 py-2 rounded-lg font-medium text-gray-700 hover:bg-blue-100 hover:text-blue-700 transition text-sm {{ request()->routeIs('book.tickets') ? 'bg-blue-100 text-blue-700' : '' }}">
                        <i class="bi bi-ticket-perforated me-1"></i>
                        Book Ticket
                    </a>
                @endauth
            </div>

            <!-- Right Side -->
            <div class="flex items-center space-x-2">
                @auth
                    <!-- Desktop User Dropdown -->
                    <div x-data="{ open: false }" class="relative hidden md:block">
                        <button @click="open = !open" @keydown.escape="open = false" class="flex items-center px-3 py-2 rounded-lg hover:bg-blue-100 transition focus:outline-none">
                            <span class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-600 to-blue-400 text-white flex items-center justify-center font-bold mr-2 text-sm">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </span>
                            <span class="text-gray-800 font-semibold text-sm">{{ Auth::user()->name }}</span>
                            <i class="bi bi-chevron-down ml-1 text-gray-500"></i>
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg py-2 z-50 border border-blue-100" x-transition>
                            <a href="{{ route('profile.edit') }}" class="px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition flex items-center text-sm">
                                <i class="bi bi-person-circle mr-2 text-blue-500"></i>
                                Profile
                            </a>
                            @if(auth()->user()->hasRole('admin'))
                            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition flex items-center text-sm">
                                <i class="bi bi-speedometer2 mr-2 text-red-500"></i>
                                Admin Dashboard
                            </a>
                            <a href="{{ route('admin.routes.index') }}" class="px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition flex items-center text-sm">
                                <i class="bi bi-geo-alt mr-2 text-red-500"></i>
                                Manage Routes
                            </a>
                            <a href="{{ route('admin.trips.index') }}" class="px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition flex items-center text-sm">
                                <i class="bi bi-calendar-event mr-2 text-red-500"></i>
                                Manage Trips
                            </a>
                            <a href="{{ route('admin.buses.index') }}" class="px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition flex items-center text-sm">
                                <i class="bi bi-bus-front mr-2 text-red-500"></i>
                                Manage Buses
                            </a>
                            <a href="{{ route('admin.bookings.index') }}" class="px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition flex items-center text-sm">
                                <i class="bi bi-list-ul mr-2 text-red-500"></i>
                                Manage Bookings
                            </a>
                            @else
                            <a href="{{ route('dashboard') }}" class="px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition flex items-center text-sm">
                                <i class="bi bi-speedometer2 mr-2 text-blue-500"></i>
                                Dashboard
                            </a>
                            @endif
                            <a href="#" class="px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition flex items-center text-sm">
                                <i class="bi bi-gear mr-2 text-blue-500"></i>
                                Settings
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition flex items-center text-sm">
                                    <i class="bi bi-box-arrow-right mr-2 text-blue-500"></i>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Mobile User Avatar -->
                    <div class="md:hidden">
                        <a href="{{ route('profile.edit') }}" class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-600 to-blue-400 text-white flex items-center justify-center font-bold text-sm">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </a>
                    </div>
                @else
                    <!-- Desktop Auth Links -->
                    <div class="hidden md:flex items-center space-x-2">
                        <a href="{{ route('login') }}" class="px-3 py-2 rounded-lg font-medium text-gray-700 hover:bg-blue-100 hover:text-blue-700 transition text-sm">
                            <i class="bi bi-box-arrow-in-right me-1"></i>
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="px-3 py-2 rounded-lg font-medium text-gray-700 hover:bg-blue-100 hover:text-blue-700 transition text-sm">
                            <i class="bi bi-person-plus me-1"></i>
                            Register
                        </a>
                    </div>
                @endauth

                <!-- Mobile Menu Button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 rounded-lg text-gray-700 hover:bg-blue-100 transition">
                    <i class="bi bi-list text-xl"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-data="{ mobileMenuOpen: false }" x-show="mobileMenuOpen" @click.away="mobileMenuOpen = false" 
             class="md:hidden bg-white border-t border-blue-100 shadow-lg" x-transition>
            <div class="px-4 py-2 space-y-1">
                @auth
                    @if(auth()->user()->hasRole('admin'))
                        <a href="{{ route('admin.dashboard') }}" class="px-4 py-3 rounded-lg font-semibold text-red-700 bg-red-100 hover:bg-red-200 transition flex items-center">
                            <i class="bi bi-speedometer2 mr-3"></i>
                            <span class="mr-2">Admin Dashboard</span>
                            <span class="inline-block bg-gradient-to-r from-red-500 to-red-700 text-white text-xs px-2 py-0.5 rounded-full font-bold uppercase tracking-wider">Admin</span>
                        </a>
                        <a href="{{ route('admin.routes.index') }}" class="px-4 py-3 rounded-lg font-medium text-gray-700 hover:bg-red-100 hover:text-red-700 transition flex items-center {{ request()->routeIs('admin.routes.*') ? 'bg-red-100 text-red-700' : '' }}">
                            <i class="bi bi-geo-alt mr-3"></i>
                            Manage Routes
                        </a>
                        <a href="{{ route('admin.trips.index') }}" class="px-4 py-3 rounded-lg font-medium text-gray-700 hover:bg-red-100 hover:text-red-700 transition flex items-center {{ request()->routeIs('admin.trips.*') ? 'bg-red-100 text-red-700' : '' }}">
                            <i class="bi bi-calendar-event mr-3"></i>
                            Manage Trips
                        </a>
                        <a href="{{ route('admin.buses.index') }}" class="px-4 py-3 rounded-lg font-medium text-gray-700 hover:bg-red-100 hover:text-red-700 transition flex items-center {{ request()->routeIs('admin.buses.*') ? 'bg-red-100 text-red-700' : '' }}">
                            <i class="bi bi-bus-front mr-3"></i>
                            Manage Buses
                        </a>
                    @else
                        <a href="/" class="px-4 py-3 rounded-lg font-medium text-gray-700 hover:bg-blue-100 hover:text-blue-700 transition flex items-center {{ request()->is('/') ? 'bg-blue-100 text-blue-700' : '' }}">
                            <i class="bi bi-house mr-3"></i>
                            Home
                        </a>
                        <a href="{{ route('routes.index') }}" class="px-4 py-3 rounded-lg font-medium text-gray-700 hover:bg-blue-100 hover:text-blue-700 transition flex items-center {{ request()->routeIs('routes.index') ? 'bg-blue-100 text-blue-700' : '' }}">
                            <i class="bi bi-geo-alt mr-3"></i>
                            Routes
                        </a>
                        <a href="{{ route('book.tickets') }}" class="px-4 py-3 rounded-lg font-medium text-gray-700 hover:bg-blue-100 hover:text-blue-700 transition flex items-center {{ request()->routeIs('book.tickets') ? 'bg-blue-100 text-blue-700' : '' }}">
                            <i class="bi bi-ticket-perforated mr-3"></i>
                            Book Ticket
                        </a>
                        <a href="{{ route('user.bookings') }}" class="px-4 py-3 rounded-lg font-medium text-gray-700 hover:bg-blue-100 hover:text-blue-700 transition flex items-center {{ request()->routeIs('user.bookings') ? 'bg-blue-100 text-blue-700' : '' }}">
                            <i class="bi bi-list-ul mr-3"></i>
                            My Bookings
                        </a>
                    @endif

                    <!-- Mobile User Menu -->
                    <div class="border-t border-gray-200 pt-2 mt-2">
                        <a href="{{ route('profile.edit') }}" class="px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition flex items-center">
                            <i class="bi bi-person-circle mr-3 text-blue-500"></i>
                            Profile
                        </a>
                        @if(auth()->user()->hasRole('admin'))
                        <a href="{{ route('admin.dashboard') }}" class="px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition flex items-center">
                            <i class="bi bi-speedometer2 mr-3 text-red-500"></i>
                            Admin Dashboard
                        </a>
                        <a href="{{ route('admin.routes.index') }}" class="px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition flex items-center">
                            <i class="bi bi-geo-alt mr-3 text-red-500"></i>
                            Manage Routes
                        </a>
                        <a href="{{ route('admin.trips.index') }}" class="px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition flex items-center">
                            <i class="bi bi-calendar-event mr-3 text-red-500"></i>
                            Manage Trips
                        </a>
                        <a href="{{ route('admin.buses.index') }}" class="px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition flex items-center">
                            <i class="bi bi-bus-front mr-3 text-red-500"></i>
                            Manage Buses
                        </a>
                        <a href="{{ route('admin.bookings.index') }}" class="px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition flex items-center">
                            <i class="bi bi-list-ul mr-3 text-red-500"></i>
                            Manage Bookings
                        </a>
                        @else
                        <a href="{{ route('dashboard') }}" class="px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition flex items-center">
                            <i class="bi bi-speedometer2 mr-3 text-blue-500"></i>
                            Dashboard
                        </a>
                        @endif
                        <a href="#" class="px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition flex items-center">
                            <i class="bi bi-gear mr-3 text-blue-500"></i>
                            Settings
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition flex items-center">
                                <i class="bi bi-box-arrow-right mr-3 text-blue-500"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                @else
                    <a href="/" class="px-4 py-3 rounded-lg font-medium text-gray-700 hover:bg-blue-100 hover:text-blue-700 transition flex items-center {{ request()->is('/') ? 'bg-blue-100 text-blue-700' : '' }}">
                        <i class="bi bi-house mr-3"></i>
                        Home
                    </a>
                    <a href="{{ route('routes.index') }}" class="px-4 py-3 rounded-lg font-medium text-gray-700 hover:bg-blue-100 hover:text-blue-700 transition flex items-center {{ request()->routeIs('routes.index') ? 'bg-blue-100 text-blue-700' : '' }}">
                        <i class="bi bi-geo-alt mr-3"></i>
                        Routes
                    </a>
                    <a href="{{ route('book.tickets') }}" class="px-4 py-3 rounded-lg font-medium text-gray-700 hover:bg-blue-100 hover:text-blue-700 transition flex items-center {{ request()->routeIs('book.tickets') ? 'bg-blue-100 text-blue-700' : '' }}">
                        <i class="bi bi-ticket-perforated mr-3"></i>
                        Book Ticket
                    </a>
                    <div class="border-t border-gray-200 pt-2 mt-2">
                        <a href="{{ route('login') }}" class="px-4 py-3 rounded-lg font-medium text-gray-700 hover:bg-blue-100 hover:text-blue-700 transition flex items-center">
                            <i class="bi bi-box-arrow-in-right mr-3"></i>
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="px-4 py-3 rounded-lg font-medium text-gray-700 hover:bg-blue-100 hover:text-blue-700 transition flex items-center">
                            <i class="bi bi-person-plus mr-3"></i>
                            Register
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>
