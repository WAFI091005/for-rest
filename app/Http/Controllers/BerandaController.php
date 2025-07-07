<?php

// app/Http/Controllers/BerandaController.php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Article;
use App\Models\Category;
use App\Models\Community;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class BerandaController extends Controller
{
    public function index()
    {
        // Mengambil artikel dengan tags, kategori, dan komunitas
        $articles = Article::with(['tags', 'category', 'community'])
        ->where('is_public', true)
        ->latest()
        ->get();


        // Mengonversi trip_date menjadi Carbon instance untuk format yang sesuai
        foreach ($articles as $article) {
            if ($article->trip_date) {
                $article->trip_date = Carbon::parse($article->trip_date)->format('d F Y');
            }
        }

        // Mengambil kategori dan komunitas
        $categories = Category::latest()->take(4)->get();
        $communities = Community::latest()->take(1)->get();

        // Mengambil memori untuk featured memories
        $memories = Article::where('is_public', true)->latest()->take(3)->get();


        // Mengirim data ke view 'pages.beranda'
        return view('pages.beranda', compact('articles', 'categories', 'communities', 'memories'));
    }

    public function memori()
    {
        // Mengambil memori berdasarkan kategori tertentu, misalnya 'forest'
        $memories = Article::with('category')->whereHas('category', function ($query) {
            $query->where('name', 'forest');
        })->latest()->get();

        // Mengonversi trip_date menjadi Carbon instance untuk format yang sesuai
        foreach ($memories as $memory) {
            if ($memory->trip_date) {
                $memory->trip_date = Carbon::parse($memory->trip_date)->format('d F Y');
            }
        }

        return view('pages.memori', compact('memories'));
    }

    public function galeri()
    {
        $galleries = Article::whereHas('category', function ($query) {
            $query->where('name', 'galeri');  // Misalnya kamu mencari kategori dengan nama 'galeri'
        })->latest()->get();

        foreach ($galleries as $gallery) {
            if ($gallery->trip_date) {
                $gallery->trip_date = Carbon::parse($gallery->trip_date)->format('d F Y');
            }
        }

        return view('pages.galeri', compact('galleries'));
    }

    // public function komunitas()
    // {
    //     // Mengambil semua komunitas yang tersedia
    //     $communities = Community::all();
    //     return view('pages.komunitas', compact('communities'));
    // }

public function downloadImage(Article $article, $imageIndex)
{
    // Buat array gambar yang ada di carousel
    $images = [
        $article->image,
        $article->image2,
        $article->image3,
    ];

    // Filter yang tidak null
    $images = array_filter($images);

    // Cek apakah indeks gambar valid
    if (!isset($images[$imageIndex])) {
        abort(404, 'Gambar tidak ditemukan');
    }

    $path = public_path($images[$imageIndex]);

    if (!file_exists($path)) {
        abort(404, 'File gambar tidak ditemukan');
    }

    // Buat nama file yang diunduh
    $ext = pathinfo($path, PATHINFO_EXTENSION);
    $filename = 'for-rest-' . Str::slug(pathinfo($article->title, PATHINFO_FILENAME)) . "-img{$imageIndex}." . $ext;

    return response()->download($path, $filename);
}


    public function show($id)
{
    $article = Article::with(['tags', 'category', 'community'])->findOrFail($id);

    if ($article->trip_date) {
        $article->trip_date = Carbon::parse($article->trip_date);
        // simpan sebagai Carbon instance biar bisa pakai translatedFormat di view
    }

    return view('memories.show', compact('article'));
}

    
}



