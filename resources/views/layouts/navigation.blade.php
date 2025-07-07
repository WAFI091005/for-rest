<nav x-data="{ open: false, notifOpen: false, currentNotifIndex: 0 }" class="fixed w-full z-50 bg-white/90 backdrop-blur-md shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            {{-- Logo --}}
            <div class="flex items-center space-x-2">
                <img src="{{ asset('assets/img/logo.png') }}" alt="For-Rest Logo" class="h-20 w-auto object-contain" />
            </div>

            {{-- Menu Desktop --}}
            <div class="hidden md:flex items-center space-x-6">
                <a href="{{ route('dashboard') }}" class="nav-link">Beranda</a>
                <a href="{{ route('memori') }}" class="nav-link">Memori</a>
                <a href="{{ route('galeri') }}" class="nav-link">Galeri</a>
                <a href="{{ route('communities.index') }}" class="nav-link">Komunitas</a>
            </div>

            {{-- Auth Desktop --}}
            <div class="hidden md:flex items-center space-x-4 relative">
                @auth
                    {{-- Notifikasi Icon --}}
                    <button @click="notifOpen = !notifOpen; currentNotifIndex = 0" class="relative focus:outline-none">
                        <svg class="w-6 h-6 text-gray-700 hover:text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 8a6 6 0 00-12 0c0 7-3 9-3 9h18s-3-2-3-9"></path>
                            <path d="M13.73 21a2 2 0 01-3.46 0"></path>
                        </svg>
                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <span class="absolute -top-1 -right-1 w-4 h-4 text-[10px] font-bold text-white bg-red-600 rounded-full flex items-center justify-center">
                                {{ auth()->user()->unreadNotifications->count() }}
                            </span>
                        @endif
                    </button>

                    {{-- User Dropdown with avatar near name --}}
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 space-x-2 ml-2">
                                <img src="{{ asset(Auth::user()->avatar ?? 'assets/img/default-avatar.png') }}" alt="avatar" 
                                     class="w-8 h-8 rounded-full object-cover border border-gray-300" />
                                <span>{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">Profile</x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link href="#" onclick="event.preventDefault(); this.closest('form').submit();">Logout</x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>

                    {{-- Notifikasi Dropdown --}}
                    <div x-show="notifOpen" @click.away="notifOpen = false"
                        x-transition
                        class="absolute right-0 mt-12 w-80 bg-white border border-gray-200 rounded-xl shadow-2xl z-50 ring-1 ring-black/5">
                        <div class="p-4">
                            <h2 class="text-lg font-semibold text-gray-800 mb-3 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 8a6 6 0 00-12 0c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.73 21a2 2 0 01-3.46 0"></path>
                                </svg>
                                Notifikasi
                            </h2>
                            
                            @php
                                $notifications = auth()->user()->unreadNotifications;
                                $notifCount = $notifications->count();
                            @endphp
                            
                            @if($notifCount > 0)
                                {{-- Navigation arrows (only show if more than 1 notification) --}}
                                @if($notifCount > 1)
                                    <div class="flex items-center justify-between mb-3">
                                        <button @click="currentNotifIndex = currentNotifIndex > 0 ? currentNotifIndex - 1 : {{ $notifCount - 1 }}"
                                                class="p-1 rounded-full hover:bg-gray-100 transition-colors">
                                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                            </svg>
                                        </button>
                                        <span class="text-sm text-gray-500" x-text="`${currentNotifIndex + 1} dari {{ $notifCount }}`"></span>
                                        <button @click="currentNotifIndex = currentNotifIndex < {{ $notifCount - 1 }} ? currentNotifIndex + 1 : 0"
                                                class="p-1 rounded-full hover:bg-gray-100 transition-colors">
                                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </button>
                                    </div>
                                @endif

                                {{-- Single notification display --}}
                                @foreach($notifications as $index => $notif)
                                    <div x-show="currentNotifIndex === {{ $index }}"
                                         class="bg-gray-50 border border-gray-200 rounded-lg p-3 flex gap-3 shadow-sm hover:bg-green-50 transition">
                                        <div class="flex-shrink-0">
                                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" stroke-width="2"
                                                viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M13 16h-1v-4h-1m1-4h.01"></path>
                                                <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"></path>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm text-gray-800 font-medium">
                                                {{ $notif->data['message'] }}
                                            </p>
                                            <div class="flex justify-between items-center mt-2 text-sm">
                                                <a href="{{ route('articles.show', $notif->data['article_id']) }}"
                                                class="text-green-600 font-semibold hover:underline">
                                                    Baca Artikel
                                                </a>
                                                <form action="{{ route('notifications.read', $notif->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                            class="text-red-500 hover:underline text-xs">
                                                        Tandai Dibaca
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-sm text-gray-500 text-center py-4">
                                    Tidak ada notifikasi baru.
                                </div>
                            @endif
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:text-green-500">Login</a>
                    <a href="{{ route('register') }}" class="text-sm text-gray-700 hover:text-green-500">Register</a>
                @endauth
            </div>

            {{-- Hamburger Button --}}
            <div class="md:hidden flex items-center">
                <button @click="open = !open" type="button" class="p-2 rounded-md text-green-600 hover:text-green-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-green-500">
                    <span class="sr-only">Buka menu utama</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
{{-- Mobile Menu --}}
<div x-show="open" x-transition class="md:hidden bg-white shadow-lg border-t border-gray-200 rounded-b-lg">
    <div class="px-4 py-3">
        <div class="flex flex-wrap gap-2 justify-between">
            <a href="{{ route('dashboard') }}" class="flex-1 text-center px-4 py-2 text-green-700 font-semibold bg-green-100 rounded hover:bg-green-200">Beranda</a>
            <a href="{{ route('memori') }}" class="flex-1 text-center px-4 py-2 text-green-700 font-semibold bg-green-100 rounded hover:bg-green-200">Memori</a>
            <a href="{{ route('galeri') }}" class="flex-1 text-center px-4 py-2 text-green-700 font-semibold bg-green-100 rounded hover:bg-green-200">Galeri</a>
            <a href="{{ route('communities.index') }}" class="flex-1 text-center px-4 py-2 text-green-700 font-semibold bg-green-100 rounded hover:bg-green-200">Komunitas</a>
        </div>
    </div>

    @auth
    <div class="border-t border-gray-200 px-4 pt-4 pb-3">
        {{-- Avatar dan nama --}}
        <div class="flex items-center space-x-3">
            <img src="{{ asset(Auth::user()->avatar ?? 'assets/img/default-avatar.png') }}" class="w-10 h-10 rounded-full object-cover border border-gray-300">
            <div>
                <p class="text-sm font-medium text-gray-800">{{ Auth::user()->name }}</p>
            </div>
        </div>

        {{-- Notifikasi Mobile --}}
        <div class="mt-4">
            <div class="flex items-center gap-2 mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-700" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10 2a6 6 0 00-6 6v2.586l-.707.707A1 1 0 004 13h12a1 1 0 00.707-1.707L16 10.586V8a6 6 0 00-6-6zM8 16a2 2 0 104 0H8z" />
                </svg>
                <h2 class="text-lg font-semibold">Notifikasi</h2>
            </div>

            @forelse(auth()->user()->unreadNotifications as $notif)
                <div class="bg-white border rounded p-3 my-2 shadow">
                    <p>{{ $notif->data['message'] }}</p>
                    <div class="flex items-center justify-between mt-1">
                        <a href="{{ route('articles.show', $notif->data['article_id']) }}" class="text-green-600 font-semibold hover:underline">
                            Baca Artikel
                        </a>
                        <form action="{{ route('notifications.read', $notif->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="text-red-500 text-xs hover:underline">Tandai Dibaca</button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-500 text-center py-2">Tidak ada notifikasi baru.</p>
            @endforelse
        </div>

        <div class="mt-4">
            <a href="{{ route('profile.edit') }}" class="block w-full text-center px-4 py-2 text-green-700 font-semibold bg-green-100 rounded hover:bg-green-200">Profile</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full mt-2 px-4 py-2 text-center text-red-600 font-semibold bg-red-100 rounded hover:bg-red-200">Logout</button>
            </form>
        </div>
    </div>
    @else
    <div class="px-4 py-3 space-y-2">
        <a href="{{ route('login') }}" class="block text-center text-green-600 font-semibold hover:underline">Login</a>
        <a href="{{ route('register') }}" class="block text-center text-green-600 font-semibold hover:underline">Register</a>
    </div>
    @endauth
</div>
</nav>

{{-- Styles for links --}}
<style>
    .nav-link {
        @apply text-gray-700 font-semibold hover:text-green-600 transition duration-150 ease-in-out;
    }
    .mobile-link {
        @apply block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-green-100 hover:text-green-700 transition;
    }
</style>