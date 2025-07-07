@extends('layouts.app')

@section('title', $article->title)

@section('content')
<section class="py-16 bg-gradient-to-b from-green-50 via-white to-white">
    <div class="max-w-4xl mx-auto px-6 sm:px-8 lg:px-10">

        <!-- Header Artikel -->
        <div class="mb-10">
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 leading-tight mb-4">
                {{ $article->title }}
            </h1>
            <div class="flex items-center flex-wrap text-sm text-gray-600 gap-3">
                @if ($article->author_image)
                    <img src="{{ asset($article->author_image) }}" alt="{{ $article->author }}"
                        class="w-9 h-9 rounded-full object-cover border border-gray-300 shadow-sm">
                @endif
                <span>Ditulis oleh <strong class="text-gray-800">{{ $article->author }}</strong></span>
                <span>&bull;</span>
                <span>{{ \Carbon\Carbon::parse($article->trip_date)->translatedFormat('d F Y') }}</span>
                <span>&bull;</span>
                <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded text-xs">
                    {{ $article->category->name ?? 'Kategori tidak tersedia' }}
                </span>
            </div>
        </div>

<!-- Galeri Gambar Artikel dengan Alpine.js Carousel -->
<div 
    x-data="{
        images: [
            '{{ asset($article->image) }}',
            @if($article->image2) '{{ asset($article->image2) }}', @endif
            @if($article->image3) '{{ asset($article->image3) }}', @endif
        ].filter(Boolean),
        currentIndex: 0,
        prev() {
            this.currentIndex = (this.currentIndex === 0) ? this.images.length - 1 : this.currentIndex - 1;
        },
        next() {
            this.currentIndex = (this.currentIndex === this.images.length - 1) ? 0 : this.currentIndex + 1;
        }
    }" 
    class="relative flex flex-col items-center mb-16"
>

    <div class="relative flex justify-center items-center w-[150px] h-[100px] mb-6">
        <!-- Tombol kiri -->
        <button
            x-show="images.length > 1"
            @click="prev"
            class="absolute left-0 -translate-x-full top-1/2 transform -translate-y-1/2 bg-white/10 hover:bg-white/20 backdrop-blur-sm rounded-full p-2 shadow z-10 transition"
            aria-label="Previous Image"
        >
            <svg class="h-5 w-5 text-gray-600 opacity-40 hover:opacity-80 transition" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <polyline points="15 18 9 12 15 6"></polyline>
            </svg>
        </button>

        <!-- Gambar -->
        <img 
            :src="images[currentIndex]" 
            alt="{{ $article->title }}" 
            class="w-full h-full object-contain border border-gray-200 shadow-lg rounded-xl"
        >

        <!-- Tombol kanan -->
        <button
            x-show="images.length > 1"
            @click="next"
            class="absolute right-0 translate-x-full top-1/2 transform -translate-y-1/2 bg-white/10 hover:bg-white/20 backdrop-blur-sm rounded-full p-2 shadow z-10 transition"
            aria-label="Next Image"
        >
            <svg class="h-5 w-5 text-gray-600 opacity-40 hover:opacity-80 transition" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
        </button>
    </div>

    <!-- Dots -->
    <div class="flex justify-center w-full space-x-2 mb-4">
        <template x-for="(img, index) in images" :key="index">
            <button
                @click="currentIndex = index"
                :class="{'bg-green-700': currentIndex === index, 'bg-gray-300': currentIndex !== index}"
                class="w-3 h-3 rounded-full"
                aria-label="Select image"
            ></button>
        </template>
    </div>

    <!-- Tombol download di bawah gambar -->
    <a
        :href="`{{ url('download-image/'.$article->id) }}/` + currentIndex"
        class="inline-flex items-center gap-2 px-5 py-2.5 bg-green-700 text-white text-sm font-semibold rounded-lg hover:bg-green-800 transition shadow"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M3 20h18M12 4v12m0 0l-4-4m4 4l4-4" />
        </svg>
        Unduh dari <span class="italic font-bold">For-Rest</span> 🌿
    </a>

</div>

        <!-- Tombol & Like -->
        <div class="flex justify-between items-center mb-8">
            @auth
                <livewire:article-like :article="$article" :wire:key="'like-'.$article->id" />
            @endauth
        </div>

        <!-- Lokasi -->
        <div class="text-sm text-gray-600 mb-6">
            <p><strong>📍 Lokasi:</strong> {{ $article->location }}</p>
        </div>

        <!-- Ringkasan -->
        @if ($article->excerpt)
            <div class="bg-green-50 border-l-4 border-green-500 text-green-800 p-4 rounded-lg mb-10 shadow-sm">
                <p class="italic">{{ $article->excerpt }}</p>
            </div>
        @endif

        <!-- Konten Artikel -->
        <article class="prose prose-green lg:prose-lg max-w-none mb-12">
            {!! $article->content !!}
        </article>

        <!-- Tanggal Publikasi -->
        <div class="text-right text-xs text-gray-400 italic">
            Dipublikasikan pada: {{ $article->created_at->translatedFormat('d F Y H:i') }}
        </div>
    </div>
</section>
@endsection
