@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 to-blue-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="container mx-auto max-w-7xl">

        <!-- Header Halaman -->
        <h1 class="mt-12 text-4xl md:text-5xl font-extrabold mb-10 text-center text-gray-900 tracking-tight leading-tight">
            <span class="bg-clip-text text-transparent bg-gradient-to-r from-green-600 to-blue-600">
                🌐 Jelajahi Komunitas Kami
            </span>
        </h1>

        <!-- Tombol Buat Komunitas Baru -->
        <div class="flex justify-center mb-12">
            <a href="{{ route('communities.create') }}"
               class="inline-flex items-center px-8 py-3 bg-green-600 text-white font-bold rounded-full shadow-lg hover:bg-green-700 hover:scale-105 transition transform duration-300 ease-in-out
                      focus:outline-none focus:ring-4 focus:ring-green-300 focus:ring-opacity-75">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Buat Komunitas Baru
            </a>
        </div>

        <!-- Pesan Sukses -->
        @if(session('success'))
            <div class="mb-8 p-5 bg-green-50 border-l-4 border-green-500 text-green-800 rounded-lg shadow-md text-center text-lg font-medium animate-fade-in-down">
                {{ session('success') }}
            </div>
        @endif

        <!-- Daftar Komunitas -->
        <div class="grid gap-8 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @forelse($communities as $community)
                <div class="bg-white rounded-3xl overflow-hidden shadow-lg hover:shadow-xl transform hover:-translate-y-2 transition-all duration-300 ease-in-out flex flex-col border border-gray-100">
                    @if($community->image)
                        <img src="{{ asset('storage/'.$community->image) }}"
                             alt="Gambar Komunitas {{ $community->name }}"
                             class="h-48 w-full object-cover object-center">
                    @else
                        <div class="h-48 w-full bg-gray-100 flex items-center justify-center text-gray-400 text-xl font-semibold border-b border-gray-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif

                    <div class="p-6 flex flex-col flex-grow">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2 leading-tight">{{ $community->name }}</h2>
                        <p class="text-gray-600 text-sm mb-4 flex-grow line-clamp-3">{{ Str::limit($community->description, 120, '...') }}</p>

                        <div class="flex items-center text-md text-gray-500 mb-6 mt-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 002 15v3H0v-3a3 3 0 014.75-2.906z" />
                            </svg>
                            <span class="font-semibold">{{ $community->members_count }}</span> anggota
                        </div>

                        <div class="space-y-3">
                            @if(auth()->user()->joinedCommunities->contains($community->id))
                                <form action="{{ route('communities.leave', $community->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="w-full flex items-center justify-center px-4 py-2.5 bg-red-600 text-white rounded-lg font-semibold hover:bg-red-700 transition duration-300 ease-in-out shadow-md hover:shadow-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H5a3 3 0 01-3-3v-10a3 3 0 013-3h5a3 3 0 013 3v1" />
                                        </svg>
                                        Keluar Komunitas
                                    </button>
                                </form>
                                <a href="{{ route('communities.show', $community->id) }}"
                                   class="w-full flex items-center justify-center px-4 py-2.5 bg-gray-200 text-gray-800 rounded-lg font-semibold hover:bg-gray-300 transition duration-300 ease-in-out shadow-sm hover:shadow-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Lihat Detail
                                </a>
                            @else
                                <form action="{{ route('communities.join', $community->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="w-full flex items-center justify-center px-4 py-2.5 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition duration-300 ease-in-out shadow-md hover:shadow-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                        </svg>
                                        Gabung Komunitas
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-24 w-24 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                    </svg>
                    <p class="text-xl text-gray-500 font-medium">Belum ada komunitas yang tersedia saat ini.</p>
                    <p class="text-md text-gray-400 mt-2">Jadilah yang pertama membuat komunitas baru!</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<style>
    @keyframes fade-in-down {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in-down {
        animation: fade-in-down 0.5s ease-out forwards;
    }

    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection
