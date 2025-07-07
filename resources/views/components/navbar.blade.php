<nav class="fixed w-full z-50 bg-white/90 backdrop-blur-md shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <div class="flex-shrink-0 flex items-center">
                    <i class="fas fa-mountain text-2xl text-green-500 mr-2"></i>
                    <span class="text-xl font-bold text-gray-800">For-<span class="text-green-500">Rest</span></span>
                </div>
            </div>

            <!-- Menu Desktop -->
            <div class="hidden md:ml-6 md:flex md:items-center md:space-x-8">
                <a href="{{ route('beranda') }}" class="text-gray-900 hover:text-green-500 px-3 py-2 text-sm font-medium">Beranda</a>
                <a href="{{ route('memori') }}" class="text-gray-900 hover:text-green-500 px-3 py-2 text-sm font-medium">Memori</a>
                <a href="{{ route('galeri') }}" class="text-gray-900 hover:text-green-500 px-3 py-2 text-sm font-medium">Galeri</a>
                <a href="{{ route('komunitas') }}" class="text-gray-900 hover:text-green-500 px-3 py-2 text-sm font-medium">Komunitas</a>
                <a href="{{ route('memori.create') }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-300">Bagikan Memori</a>
            </div>

            <!-- Avatar & Name (for logged-in user) -->
            @auth
                <div class="hidden md:flex items-center space-x-3">
                    <img src="{{ asset(Auth::user()->avatar ?? 'assets/img/default-avatar.png') }}" alt="avatar" width="40" height="40" class="rounded-full object-cover">
                    <span class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</span>

                    <!-- Settings Dropdown -->
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">Profile</x-dropdown-link>
                            <x-dropdown-link :href="route('logout')" :method="'POST'">Logout</x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
                </div>
            @else
                <div class="hidden md:flex items-center space-x-3">
                    <a href="{{ route('login') }}" class="text-sm text-gray-700">Login</a>
                </div>
            @endauth

            <!-- Mobile Button -->
            <div class="-mr-2 flex items-center md:hidden">
                <button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-green-500" aria-controls="mobile-menu" aria-expanded="false" id="mobile-menu-button">
                    <span class="sr-only">Buka menu utama</span>
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Menu Mobile -->
    <div class="hidden md:hidden" id="mobile-menu">
        <div class="pt-2 pb-3 space-y-1 sm:px-3">
            <a href="{{ route('beranda') }}" class="block px-3 py-2 text-base font-medium text-gray-900 hover:text-green-500 hover:bg-gray-50">Beranda</a>
            <a href="{{ route('memori') }}" class="block px-3 py-2 text-base font-medium text-gray-900 hover:text-green-500 hover:bg-gray-50">Memori</a>
            <a href="{{ route('galeri') }}" class="block px-3 py-2 text-base font-medium text-gray-900 hover:text-green-500 hover:bg-gray-50">Galeri</a>
            <a href="{{ route('komunitas') }}" class="block px-3 py-2 text-base font-medium text-gray-900 hover:text-green-500 hover:bg-gray-50">Komunitas</a>
            <a href="{{ route('memori.create') }}" class="block px-3 py-2 text-base font-medium text-white bg-green-500 rounded-md mx-3">Bagikan Memori</a>

            @auth
                <div class="flex items-center px-3 py-2 mt-3 space-x-3 border-t pt-3">
                    <img src="{{ asset(Auth::user()->avatar ?? 'assets/img/default-avatar.png') }}" alt="avatar" width="36" class="rounded-full object-cover">
                    <span class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</span>
                </div>
            @endauth
        </div>
    </div>
</nav>
