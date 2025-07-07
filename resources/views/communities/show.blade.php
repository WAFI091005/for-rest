@extends('layouts.app')

@section('title', $community->name)

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-16 space-y-10">

    <div class="bg-white rounded-3xl shadow-xl p-8 md:p-10 flex flex-col md:flex-row gap-8 items-center justify-center border border-gray-100">
        @if($community->image)
            <div class="w-48 h-48 rounded-2xl overflow-hidden border border-gray-200 shadow-md flex-shrink-0">
                <img src="{{ asset('storage/' . $community->image) }}"
                     alt="Gambar Komunitas"
                     class="w-full h-full object-cover" />
            </div>
        @else
            <div class="w-32 h-32 rounded-2xl bg-gray-50 flex items-center justify-center border border-dashed border-gray-300 text-gray-400 flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M3 7v10a4 4 0 004 4h10a4 4 0 004-4V7M3 7l7-4m0 0l7 4m-7-4v18" />
                </svg>
            </div>
        @endif

        {{-- Menghapus 'flex-1' agar konten tidak mengambil seluruh sisa ruang,
             memungkinkan 'justify-center' pada parent untuk memusatkan kedua elemen (gambar dan teks) --}}
        <div class="space-y-4 text-center">
            <h2 class="text-4xl font-extrabold text-gray-900 leading-tight">{{ $community->name }}</h2>
            <p class="text-gray-700 text-lg leading-relaxed max-w-prose mx-auto">
                {{ $community->description }}
            </p>
            <div class="pt-4">
                <a href="{{ route('communities.articles.create', $community->id) }}"
                   class="inline-flex items-center px-6 py-3 bg-green-600 text-white font-semibold rounded-lg shadow-lg hover:bg-green-700 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Tambah Informasi Baru
                </a>
            </div>
        </div>
    </div>

    <div class="mt-12 space-y-6">
        <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center md:text-left">Informasi Terbaru</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @forelse($community->articles->sortByDesc('created_at') as $index => $article)
                <div x-data="{ openComments: false }"
                     {{-- Jika ini adalah artikel ketiga (index 2 karena dimulai dari 0), maka akan mengambil 2 kolom --}}
                     @if($loop->iteration === 3) class="md:col-span-2 bg-white rounded-2xl shadow-lg hover:shadow-xl transition duration-300 p-6 border border-gray-100"
                     @else class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition duration-300 p-6 border border-gray-100" @endif
                >
                    <div class="flex flex-col md:flex-row gap-6 items-start">
                        @if($article->image)
                            <div class="w-48 h-32 overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm flex-shrink-0">
                                <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover" />
                            </div>
                        @endif

                        <div class="flex-1 space-y-2">
                            <p class="text-sm text-gray-500 flex items-center">
                                <span class="mr-1">✍️</span> {{ $article->user->name }}
                                <span class="mx-2 text-gray-400">•</span>
                                <span class="text-xs">{{ $article->created_at->diffForHumans() }}</span>
                            </p>
                            <h3 class="text-xl font-semibold text-gray-900 leading-snug">{{ $article->title }}</h3>
                            <p class="text-gray-700 leading-relaxed text-base">{{ Str::limit($article->content, 200) }}</p>

                            <div class="flex items-center gap-4 pt-2">
                                @php
                                    $reactions = $article->reactions->groupBy('type');
                                    $userReaction = $article->reactions->firstWhere('user_id', auth()->id());
                                @endphp
                                @foreach(['like' => '👍', 'love' => '❤️', 'laugh' => '😂'] as $type => $emoji)
                                    <form method="POST" action="{{ route('communities.articles.react', $article->id) }}">
                                        @csrf
                                        <input type="hidden" name="type" value="{{ $type }}">
                                        <button type="submit"
                                                class="flex items-center text-sm space-x-1 p-2 rounded-full transition-all duration-200
                                                {{ $userReaction && $userReaction->type === $type ? 'bg-blue-100 text-blue-600 font-semibold' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700' }}
                                                active:scale-95 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-300">
                                            <span>{{ $emoji }}</span>
                                            <span>{{ optional($reactions[$type] ?? null)->count() ?? 0 }}</span>
                                        </button>
                                    </form>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 border-t border-gray-100 pt-6">
                        <h5 class="font-semibold text-gray-800 mb-4 flex items-center">
                            <span class="mr-2">💬</span> Komentar
                        </h5>
                        <div class="space-y-4">
                            {{-- Menampilkan 2 komentar pertama --}}
                            @foreach($article->comments->take(2) as $comment)
                                <div class="flex items-start gap-3">
                                    <img src="{{ asset($comment->user->avatar ?? 'assets/img/default.png') }}"
                                         alt="{{ $comment->user->name }}"
                                         class="w-8 h-8 rounded-full object-cover border border-gray-200 shadow-sm flex-shrink-0">
                                    <div class="flex-1 bg-gray-50 border border-gray-200 rounded-xl p-3 shadow-sm">
                                        <div class="flex justify-between items-center mb-1">
                                            <span class="font-semibold text-gray-800 text-sm">{{ $comment->user->name }}</span>
                                            <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-gray-700 text-sm leading-relaxed">{{ $comment->content }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Tombol untuk melihat semua komentar jika lebih dari 2 --}}
                        @if($article->comments->count() > 2)
                            <button @click="openComments = true" class="mt-4 text-sm text-green-600 hover:underline font-medium focus:outline-none focus:ring-2 focus:ring-green-400 rounded">
                                Lihat semua komentar ({{ $article->comments->count() }})
                            </button>
                        @elseif($article->comments->count() > 0)
                            <button @click="openComments = true" class="mt-4 text-sm text-green-600 hover:underline font-medium focus:outline-none focus:ring-2 focus:ring-green-400 rounded">
                                Lihat komentar ({{ $article->comments->count() }})
                            </button>
                        @else
                            <p class="text-sm text-gray-500 mt-4">Belum ada komentar.</p>
                        @endif

                        <div x-show="openComments"
                             x-transition:enter="ease-out duration-300"
                             x-transition:enter-start="opacity-0 scale-90"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="ease-in duration-200"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-90"
                             class="fixed inset-0 z-50 bg-black bg-opacity-60 flex items-center justify-center p-4" x-cloak>
                            <div @click.away="openComments = false" class="bg-white w-full max-w-2xl max-h-[90vh] overflow-y-auto rounded-xl p-6 shadow-2xl relative transform transition-all duration-300">
                                <button @click="openComments = false" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-xl focus:outline-none focus:ring-2 focus:ring-gray-300 rounded-full p-1">✖</button>
                                <h3 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-3">Semua Komentar</h3>
                                <div class="space-y-5">
                                    @foreach($article->comments as $comment)
                                        <div class="flex items-start gap-3">
                                            <img src="{{ asset($comment->user->avatar ?? 'assets/img/default.png') }}"
                                                 alt="{{ $comment->user->name }}"
                                                 class="w-9 h-9 rounded-full object-cover border border-gray-200 shadow-sm flex-shrink-0">
                                            <div class="flex-1 bg-gray-50 border border-gray-200 rounded-xl p-4 shadow-sm">
                                                <div class="flex justify-between items-center mb-1">
                                                    <span class="font-semibold text-gray-800 text-base">{{ $comment->user->name }}</span>
                                                    <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                                </div>
                                                <p class="text-gray-700 text-sm leading-relaxed">{{ $comment->content }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        @auth
                            <form method="POST" action="{{ route('communities.articles.comment', $article->id) }}" class="mt-5">
                                @csrf
                                <textarea name="content" rows="3" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 text-sm p-3 placeholder-gray-400" placeholder="Tulis komentar yang positif dan membangun..."></textarea>
                                <button type="submit" class="mt-3 w-full md:w-auto bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-lg text-base font-semibold shadow transition-all duration-200 transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">
                                    Kirim Komentar
                                </button>
                            </form>
                        @else
                            <p class="text-sm text-gray-500 mt-4 p-3 bg-gray-50 rounded-md border border-gray-200">
                                <a href="{{ route('login') }}" class="text-green-600 hover:underline font-semibold">Login</a> untuk menambahkan komentar.
                            </p>
                        @endauth
                    </div>
                </div>
            @empty
                <div class="md:col-span-2 p-8 bg-blue-50 border border-blue-200 text-blue-800 rounded-xl shadow-md text-center flex flex-col items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-4 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-lg font-medium">Belum ada informasi yang ditambahkan oleh anggota komunitas ini.</p>
                    <p class="text-md text-blue-700 mt-2">Jadilah yang pertama untuk berbagi!</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection