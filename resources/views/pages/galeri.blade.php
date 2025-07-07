@extends('layouts.app')

@section('title', 'Galeri')

@section('content')
<section class="bg-green-700 py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-white leading-tight mb-4">Galeri Foto</h1>
            <p class="text-lg sm:text-xl text-green-100 max-w-2xl mx-auto">
                Koleksi momen-momen yang kamu upload sendiri.
            </p>
        </div>
    </div>
</section>

<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Galeri Saya</h2>

        @php
            $galleriesWithArticle = $galleries->filter(fn($gallery) => $gallery->article);
        @endphp

        @if ($galleriesWithArticle->isNotEmpty())
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($galleriesWithArticle as $gallery)
                <div id="gallery-card-{{ $gallery->article->id }}" class="bg-white rounded-lg shadow hover:shadow-md transition duration-300 overflow-hidden flex flex-col">
                    <img src="{{ asset($gallery->image_url) }}" alt="{{ $gallery->title }}" class="w-full h-48 object-cover">

                    <div class="p-4 flex flex-col flex-grow">
                        <h3 class="text-lg font-semibold text-gray-800 mb-1">{{ $gallery->title }}</h3>

                        <div class="flex items-center space-x-3 mb-3">
                            <div class="w-8 h-8 rounded-full overflow-hidden">
                                <img src="{{ optional($gallery->user)->avatar ? asset($gallery->user->avatar) : asset('assets/img/avatar.jpg') }}" alt="{{ optional($gallery->user)->name ?? 'Anonim' }}" class="w-full h-full object-cover">
                            </div>
                            <span class="text-sm text-gray-700">{{ optional($gallery->user)->name ?? 'Anonim' }}</span>
                        </div>

                        <div class="mt-auto flex items-center justify-between space-x-2 text-sm">
                            <a href="{{ route('memories.show', $gallery->article->id) }}" class="text-green-600 hover:underline font-semibold" aria-label="Lihat Selengkapnya">
                                Lihat Selengkapnya
                            </a>

                            @if (auth()->check() && auth()->id() === $gallery->article->user_id)
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('memories.edit', $gallery->article->id) }}" title="Edit Artikel" class="text-blue-600 hover:text-blue-800 transition-colors duration-300" aria-label="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="m11.25 6c.398 0 .75.352.75.75 0 .414-.336.75-.75.75-1.505 0-7.75 0-7.75 0v12h17v-8.75c0-.414.336-.75.75-.75s.75.336.75.75v9.25c0 .621-.522 1-1 1h-18c-.48 0-1-.379-1-1v-13c0-.481.38-1 1-1zm-2.011 6.526c-1.045 3.003-1.238 3.45-1.238 3.84 0 .441.385.626.627.626.272 0 1.108-.301 3.829-1.249zm.888-.889 3.22 3.22 8.408-8.4c.163-.163.245-.377.245-.592 0-.213-.082-.427-.245-.591-.58-.578-1.458-1.457-2.039-2.036-.163-.163-.377-.245-.591-.245-.213 0-.428.082-.592.245z"/>
                                    </svg>
                                </a>

                                <form action="{{ route('memories.destroy', $gallery->article->id) }}" method="POST" onsubmit="return handleDelete(event, {{ $gallery->article->id }})" class="inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Hapus Artikel" class="text-red-600 hover:text-red-800 transition-colors duration-300 flex items-center" aria-label="Hapus">
                                        <svg clip-rule="evenodd" fill="red" fill-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5">
                                            <path d="m20.015 6.506h-16v14.423c0 .591.448 1.071 1 1.071h14c.552 0 1-.48 1-1.071 0-3.905 0-14.423 0-14.423zm-5.75 2.494c.414 0 .75.336.75.75v8.5c0 .414-.336.75-.75.75s-.75-.336-.75-.75v-8.5c0-.414.336-.75.75-.75zm-4.5 0c.414 0 .75.336.75.75v8.5c0 .414-.336.75-.75.75s-.75-.336-.75-.75v-8.5c0-.414.336-.75.75-.75zm-.75-5v-1c0-.535.474-1 1-1h4c.526 0 1 .465 1 1v1h5.254c.412 0 .746.335.746.747s-.334.747-.746.747h-16.507c-.413 0-.747-.335-.747-.747s.334-.747.747-.747zm4.5 0v-.5h-3v.5z"/>
                                        </svg>
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('article.togglePublic', $gallery->article->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <label class="inline-flex items-center space-x-1 text-sm text-gray-600">
                                        <input 
                                            type="checkbox" 
                                            name="is_public" 
                                            onchange="this.form.submit()" 
                                            {{ $gallery->article->is_public ? 'checked' : '' }}
                                            class="w-4 h-4 text-green-600 bg-white border-2 border-gray-300 rounded-full focus:ring-green-500 focus:ring-2 appearance-none checked:bg-green-600 checked:border-green-600"
                                        >
                                        <span>Public</span>
                                    </label>
                                </form>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @else
            <p class="text-center text-gray-600">Belum ada galeri yang kamu unggah.</p>
        @endif
    </div>
</section>
@endsection

@push('scripts')
<script>
    function handleDelete(event, articleId) {
        event.preventDefault();

        if (!confirm('Yakin ingin menghapus artikel ini?')) return false;

        const form = event.target;
        const url = form.action;
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        fetch(url, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
        })
        .then(response => {
            if (response.ok) {
                const card = document.getElementById(`gallery-card-${articleId}`);
                if (card) card.remove();
                alert('Artikel berhasil dihapus.');
            } else {
                alert('Gagal menghapus artikel.');
            }
        })
        .catch(() => {
            alert('Terjadi kesalahan saat menghapus.');
        });

        return false;
    }
</script>
@endpush
