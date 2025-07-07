@extends('layouts.app')

@section('title', 'Memori')

@section('content')
<!-- Header Section -->
<section class="bg-green-700 py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-white leading-tight mb-4">Memori Perjalanan</h1>
            <p class="text-lg sm:text-xl text-green-100 max-w-2xl mx-auto">
                Jelajahi cerita dan pengalaman dari para penjelajah hutan di seluruh dunia.
            </p>
        </div>
    </div>
</section>

<!-- Filter Section -->
<section class="bg-white shadow">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <form method="GET" action="{{ route('memori') }}" class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <div class="flex items-center space-x-4">
                {{-- Filter Kategori --}}
                <div class="relative">
                    <select name="category" onchange="this.form.submit()" class="appearance-none bg-gray-100 border border-gray-300 text-gray-700 py-2 px-4 pr-8 rounded-lg leading-tight focus:outline-none focus:bg-white focus:border-green-500">
                        <option value="">Semua Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </div>

                {{-- Sort Dummy
                <div class="relative">
                    <select disabled class="appearance-none bg-gray-100 border border-gray-300 text-gray-400 py-2 px-4 pr-8 rounded-lg leading-tight cursor-not-allowed">
                        <option selected>Terbaru</option>
                        <option>Terpopuler</option>
                        <option>Teratas</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </div> --}}
            </div>

            {{-- Search Dummy --}}
            {{-- <div class="relative w-full md:w-64">
                <input type="text" placeholder="Cari memori..." disabled class="w-full bg-gray-100 border border-gray-300 text-gray-400 py-2 px-4 pl-10 rounded-lg leading-tight cursor-not-allowed">
                <div class="absolute inset-y-0 left-0 flex items-center px-3 pointer-events-none text-gray-400">
                    <i class="fas fa-search"></i>
                </div>
            </div> --}}
        </form>
    </div>
</section>

<!-- Memories List -->
<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Semua Memori</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($memories as $article)
                <div class="bg-white rounded-lg shadow-md overflow-hidden transform transition-transform duration-300 hover:scale-105 hover:shadow-xl">
                    <div class="relative">
                        <img src="{{ $article->image ? asset($article->image) : '/api/placeholder/600/400' }}" alt="{{ $article->title }}" class="w-full h-48 object-cover">
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-4">
                            <h3 class="text-white font-bold text-xl truncate">{{ $article->title }}</h3>
                        </div>
                    </div>
                    <div class="p-4">
                        <p class="text-sm text-gray-500 mb-2">Kategori: {{ $article->category->name ?? 'Tidak diketahui' }}</p>
                        <p class="text-gray-700 text-sm mb-3">{{ \Illuminate\Support\Str::limit(strip_tags($article->content), 100) }}</p>
                        <div class="flex justify-between items-center mt-4">
                            <a href="{{ route('memories.show', $article->id) }}" class="text-green-600 hover:underline font-semibold">
                                Baca Selengkapnya
                            </a>
                            @auth
                                <livewire:article-like :article="$article" :wire:key="'like-'.$article->id" />
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-8">
            {{ $memories->withQueryString()->links() }}
        </div>
    </div>
</section>
@endsection
