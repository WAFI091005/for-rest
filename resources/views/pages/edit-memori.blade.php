@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto py-12">
    <h2 class="text-2xl font-bold mb-4">Edit Artikel</h2>
    
    <form action="{{ route('memories.update', $article->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Judul:</label>
        <input type="text" name="title" value="{{ old('title', $article->title) }}" class="w-full border p-2 rounded mb-4">

        <label>Tanggal Trip:</label>
        <input type="date" name="trip_date" value="{{ old('trip_date', $article->trip_date) }}" class="w-full border p-2 rounded mb-4">

        <label>Lokasi:</label>
        <input type="text" name="location" value="{{ old('location', $article->location) }}" class="w-full border p-2 rounded mb-4">

        <label>Kategori:</label>
        <select name="category_id" class="w-full border p-2 rounded mb-4">
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ $article->category_id == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        <label>Deskripsi:</label>
        <textarea name="description" class="w-full border p-2 rounded mb-4">{{ old('description', $article->content) }}</textarea>

        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Simpan</button>
    </form>
</div>
@endsection
