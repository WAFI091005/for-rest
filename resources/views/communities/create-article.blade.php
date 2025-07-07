@extends('layouts.app')

@section('title', 'Tambah Informasi - ' . $community->name)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50 py-12">
    <div class="max-w-4xl mx-auto px-6">
        <!-- Header Section -->
        <div class="text-center mb-8 mt-8">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-green-600 rounded-full mb-4">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
        </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Tambah Informasi Baru</h1>
            <p class="text-gray-600">untuk Komunitas <span class="font-semibold text-green-600">{{ $community->name }}</span></p>
        </div>

        <!-- Main Form Card -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 overflow-hidden">
            <div class="p-8">
                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-lg">
                        <div class="flex items-center mb-2">
                            <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            <h3 class="text-red-800 font-semibold">Terdapat kesalahan:</h3>
                        </div>
                        <ul class="text-red-700 text-sm space-y-1">
                            @foreach ($errors->all() as $error)
                                <li class="flex items-center">
                                    <span class="w-1 h-1 bg-red-500 rounded-full mr-2"></span>
                                    {{ $error }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('communities.articles.store', $community->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Title Field -->
                    <div class="group">
                        <label class="block text-sm font-semibold text-gray-700 mb-2" for="title">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2h4a1 1 0 110 2h-1v14a2 2 0 01-2 2H6a2 2 0 01-2-2V6H3a1 1 0 110-2h4z"></path>
                                </svg>
                                Judul Artikel
                            </span>
                        </label>
                        <input 
                            type="text" 
                            name="title" 
                            id="title" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white/50 hover:bg-white/80 focus:bg-white" 
                            value="{{ old('title') }}" 
                            placeholder="Masukkan judul yang menarik..."
                            required
                        >
                    </div>

                    <!-- Content Field -->
                    <div class="group">
                        <label class="block text-sm font-semibold text-gray-700 mb-2" for="content">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Konten Artikel
                            </span>
                        </label>
                        <textarea 
                            name="content" 
                            id="content" 
                            rows="8" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white/50 hover:bg-white/80 focus:bg-white resize-vertical" 
                            placeholder="Tulis konten artikel Anda di sini..."
                            required
                        >{{ old('content') }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">Minimal 10 karakter untuk konten yang bermakna</p>
                    </div>

                    <!-- Image Upload Field -->
                    <div class="group">
                        <label class="block text-sm font-semibold text-gray-700 mb-2" for="image">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Gambar Pendukung <span class="text-gray-400 font-normal">(opsional)</span>
                            </span>
                        </label>
                        <div class="relative">
                            <input 
                                type="file" 
                                name="image" 
                                id="image" 
                                class="hidden"
                                accept="image/*"
                                onchange="updateFileLabel(this)"
                            >
                            <label for="image" class="flex items-center justify-center w-full px-4 py-6 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-indigo-400 hover:bg-indigo-50/50 transition-all duration-200 group">
                                <div class="text-center">
                                    <svg class="w-8 h-8 mx-auto text-gray-400 group-hover:text-indigo-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                    </svg>
                                    <p class="text-sm text-gray-600 group-hover:text-indigo-600">
                                        <span class="font-semibold">Klik untuk upload</span> atau drag & drop
                                    </p>
                                    <p class="text-xs text-gray-400 mt-1">PNG, JPG, GIF up to 2MB</p>
                                    <p id="file-name" class="text-xs text-indigo-600 mt-2 font-medium hidden"></p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                        <div class="text-sm text-gray-500">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Pastikan semua informasi sudah benar sebelum menyimpan
                        </div>
                        <button 
                            type="submit" 
                            class="px-8 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 focus:ring-4 focus:ring-green-300 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl"
                        >
                            <span class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Tambah Informasi
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Additional Info Card -->
        <div class="mt-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-100">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-semibold text-blue-900">Tips untuk artikel yang baik:</h3>
                    <div class="mt-2 text-sm text-blue-700">
                        <p>• Gunakan judul yang menarik dan deskriptif</p>
                        <p>• Tulis konten yang informatif dan mudah dipahami</p>
                        <p>• Tambahkan gambar untuk memperkaya konten (format: JPG, PNG, GIF)</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function updateFileLabel(input) {
    const fileName = document.getElementById('file-name');
    if (input.files && input.files[0]) {
        fileName.textContent = `File terpilih: ${input.files[0].name}`;
        fileName.classList.remove('hidden');
    } else {
        fileName.classList.add('hidden');
    }
}
</script>

<style>
/* Custom animations */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.group {
    animation: fadeIn 0.3s ease-out;
}

/* Enhanced focus styles */
input:focus, textarea:focus {
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
}

/* Smooth transitions for all interactive elements */
* {
    transition: all 0.2s ease-in-out;
}
</style>
@endsection