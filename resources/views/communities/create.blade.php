{{-- @extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 max-w-lg">
    <h1 class="text-2xl font-bold mb-4">Buat Komunitas Baru</h1>

    <form action="{{ route('communities.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div>
            <label for="name" class="block font-semibold mb-1">Nama Komunitas</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                class="w-full border border-gray-300 rounded px-3 py-2 @error('name') border-red-500 @enderror">
            @error('name')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="description" class="block font-semibold mb-1">Deskripsi</label>
            <textarea name="description" id="description" rows="4" required
                class="w-full border border-gray-300 rounded px-3 py-2 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="image" class="block font-semibold mb-1">Gambar (opsional)</label>
            <input type="file" name="image" id="image" accept="image/*"
                class="w-full @error('image') border-red-500 @enderror">
            @error('image')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            Buat Komunitas
        </button>
    </form>
</div>
@endsection --}}

@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full bg-white p-8 rounded-xl shadow-lg space-y-6 border border-gray-200">
        <div class="text-center">
            <h1 class="text-3xl font-extrabold text-gray-900">
                Buat Komunitas Baru
            </h1>
            <p class="mt-2 text-sm text-gray-600">
                Isi detail di bawah untuk membuat komunitas Anda.
            </p>
        </div>

        <form action="{{ route('communities.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            {{-- Nama Komunitas --}}
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Komunitas</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                    class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm
                           @error('name') border-red-500 @enderror"
                    placeholder="Nama Komunitas Anda">
                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Deskripsi --}}
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                <textarea name="description" id="description" rows="4" required
                    class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm
                           @error('description') border-red-500 @enderror"
                    placeholder="Deskripsi singkat tentang komunitas ini...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Gambar (opsional) --}}
            <div>
                <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Gambar Komunitas (opsional)</label>
                <input type="file" name="image" id="image" accept="image/*"
                    class="block w-full text-sm text-gray-900
                           file:mr-4 file:py-2 file:px-4
                           file:rounded-full file:border-0
                           file:text-sm file:font-semibold
                           file:bg-green-50 file:text-green-700
                           hover:file:bg-green-100
                           @error('image') border-red-500 @enderror">
                @error('image')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol Submit --}}
            <div>
                <button type="submit"
                    class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 ease-in-out shadow-md">
                    Buat Komunitas
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

