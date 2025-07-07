<?php

// // app/Http/Controllers/GalleryController.php


// namespace App\Http\Controllers;

// use App\Models\Gallery;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Storage;

// class GalleryController extends Controller
// {
//     public function index()
//     {
//         $user = Auth::user();

//         // Ambil gallery hanya milik user login
//         $galleries = Gallery::with('user')
//             ->where('user_id', $user->id)
//             ->latest()
//             ->get();

//         return view('pages.galeri', compact('galleries'));
//     }


//     public function store(Request $request)
//     {
//         // Validasi file gambar yang diupload
//         $request->validate([
//             'image' => 'required|image|mimes:jpg,png,jpeg,gif|max:2048',
//             'title' => 'required|string|max:255',
//         ]);

//         // Pastikan hanya pengguna yang sama dengan artikel yang bisa menambah foto
//         if (Auth::user()->galleries->count() >= 10) {
//             return redirect()->back()->with('error', 'Anda sudah mencapai batas maksimal foto!');
//         }

//         // Simpan gambar yang diupload
//         $path = $request->file('image')->store('public/galleries');

//         // Simpan data galeri ke database
//         Gallery::create([
//             'user_id' => Auth::id(),
//             'image_url' => Storage::url($path),
//             'title' => $request->title,
//         ]);

//         return redirect()->route('galeri')->with('success', 'Foto berhasil ditambahkan!');
//     }
// }
namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil galleries milik user login sekaligus eager load relasi article dan user
        $galleries = Gallery::with(['user', 'article'])
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return view('pages.galeri', compact('galleries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,png,jpeg,gif|max:2048',
            'title' => 'required|string|max:255',
        ]);

        if (Auth::user()->galleries->count() >= 10) {
            return redirect()->back()->with('error', 'Anda sudah mencapai batas maksimal foto!');
        }

        $path = $request->file('image')->store('public/galleries');

        Gallery::create([
            'user_id' => Auth::id(),
            'image_url' => Storage::url($path),
            'title' => $request->title,
            // Jangan lupa isi article_id jika ada dari request
            'article_id' => $request->article_id ?? null,
        ]);

        return redirect()->route('galeri')->with('success', 'Foto berhasil ditambahkan!');
    }
    
    
}
