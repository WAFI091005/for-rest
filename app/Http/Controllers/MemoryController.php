<?php

namespace App\Http\Controllers;

use id;
use Carbon\Carbon;
use App\Models\Memory;
use App\Models\Article;
use App\Models\Gallery;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MemoryController extends Controller
{
    // Menampilkan semua artikel (memori), dengan opsi filter kategori
    public function index(Request $request)
    {
        // Ambil semua kategori dari database
        $categories = Category::all();

        // Ambil input category dari query string
        $categoryId = $request->input('category');

        // Query artikel dengan relasi category dan tags, urut terbaru
        $query = Article::with('category', 'tags')
        ->where('is_public', true)
        ->latest();


        $category = null; // opsional, kategori yang sedang difilter

        if ($categoryId) {
            $query->where('category_id', $categoryId);
            $category = Category::find($categoryId);
        }

        // Paginate hasil query, 9 per halaman
        $memories = $query->paginate(9);
        

        // Format tanggal trip_date jika ada
        foreach ($memories as $memory) {
            if ($memory->trip_date) {
                $memory->trip_date = Carbon::parse($memory->trip_date)->format('d F Y');
            }
        }

        
        // Kirim data ke view, termasuk kategori aktif (jika ada)
        return view('pages.memori', compact('memories', 'categories', 'category'));
    }

    // Menampilkan artikel berdasarkan ID
    public function show($id)
    {
        $article = Article::with('category', 'tags')->findOrFail($id);
        return view('memories.show', compact('article'));
    }

    // Menampilkan halaman form untuk menambah artikel (memori)
    public function create()
    {
        $categories = Category::all();
        return view('pages.create-memori', compact('categories'));
    }

    // Menyimpan artikel (memori) baru
public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'trip_date' => 'required|date|before_or_equal:today',
        'location' => 'required|string|max:255',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:10240',
        'image2' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:10240',
        'image3' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:10240',
        'category_id' => 'required|exists:categories,id',
        'description' => 'nullable|string',
    ]);

    $destination = public_path('assets/img');

    $imagePath = null;
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '_1_' . $image->getClientOriginalName();
        $image->move($destination, $imageName);
        $imagePath = 'assets/img/' . $imageName;
    }

    $imagePath2 = null;
    if ($request->hasFile('image2')) {
        $image2 = $request->file('image2');
        $imageName2 = time() . '_2_' . $image2->getClientOriginalName();
        $image2->move($destination, $imageName2);
        $imagePath2 = 'assets/img/' . $imageName2;
    }

    $imagePath3 = null;
    if ($request->hasFile('image3')) {
        $image3 = $request->file('image3');
        $imageName3 = time() . '_3_' . $image3->getClientOriginalName();
        $image3->move($destination, $imageName3);
        $imagePath3 = 'assets/img/' . $imageName3;
    }

    $article = new Article([
        'user_id' => auth()->id(),
        'title' => $validated['title'],
        'author' => auth()->user()->name ?? 'Unknown',
        'author_image' => auth()->user()->avatar ?? null,
        'location' => $validated['location'],
        'trip_date' => $validated['trip_date'],
        'image' => $imagePath,
        'image2' => $imagePath2,
        'image3' => $imagePath3,
        'excerpt' => substr($validated['description'], 0, 150),
        'content' => $validated['description'],
        'category_id' => $validated['category_id'],
    ]);

    $article->save();

    // Simpan juga ke galeri (pakai gambar pertama saja)
    Gallery::create([
        'user_id' => auth()->id(),
        'category_id' => $validated['category_id'],
        'image_url' => $imagePath,
        'title' => $validated['title'],
        'article_id' => $article->id,
    ]);

    return redirect()->route('memori')->with('success', 'Memori berhasil ditambahkan!');
}


    // (Opsional) Menampilkan artikel berdasarkan kategori lewat slug
    public function filterByCategory($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $categories = Category::all();

        $memories = Article::with('category', 'tags')
                    ->where('category_id', $category->id)
                    ->latest()
                    ->paginate(9);

        foreach ($memories as $memory) {
            if ($memory->trip_date) {
                $memory->trip_date = Carbon::parse($memory->trip_date)->format('d F Y');
            }
        }

        return view('pages.memori', compact('memories', 'category', 'categories'));
    }
    public function edit($id)
{
    $article = Article::findOrFail($id);
    if ($article->user_id !== auth()->id()) {
        abort(403, 'Kamu tidak punya izin untuk mengedit artikel ini.');
    }

    $categories = Category::all();
    return view('pages.edit-memori', compact('article', 'categories'));
}

public function update(Request $request, $id)
{
    $article = Article::findOrFail($id);

    // Cek otorisasi user
    if ($article->user_id !== auth()->id()) {
        abort(403, 'Kamu tidak punya izin untuk mengubah artikel ini.');
    }

    // Validasi input, termasuk gambar opsional
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'trip_date' => 'required|date|before_or_equal:today',
        'location' => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id',
        'description' => 'nullable|string',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:10240', // validasi gambar opsional
    ]);

    // Handle update gambar jika ada upload baru
    if ($request->hasFile('image')) {
        // Hapus gambar lama kalau ada
        if ($article->image && file_exists(public_path($article->image))) {
            unlink(public_path($article->image));
        }

        $image = $request->file('image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $destination = public_path('assets/img');
        $image->move($destination, $imageName);
        $imagePath = 'assets/img/' . $imageName;

        $article->image = $imagePath; // update path gambar di artikel
    }

    // Update field lain
    $article->title = $validated['title'];
    $article->location = $validated['location'];
    $article->trip_date = $validated['trip_date'];
    $article->content = $validated['description'];
    $article->excerpt = substr($validated['description'], 0, 150);
    $article->category_id = $validated['category_id'];

    $article->save();

    // Update juga data di Gallery yang terkait article ini
    $gallery = Gallery::where('article_id', $article->id)->first();
    if ($gallery) {
        $gallery->title = $validated['title'];
        $gallery->category_id = $validated['category_id'];

        if (isset($imagePath)) {
            $gallery->image_url = $imagePath;
        }

        $gallery->save();
    }

    return redirect()->route('memories.show', $article->id)->with('success', 'Artikel berhasil diperbarui.');
}


public function destroy($id)
{
    $article = Article::findOrFail($id);
    if ($article->user_id !== auth()->id()) {
        abort(403, 'Kamu tidak punya izin untuk menghapus artikel ini.');
    }

    if ($article->image && file_exists(public_path($article->image))) {
        unlink(public_path($article->image));
    }

    Gallery::where('article_id', $article->id)->update(['article_id' => null]);

    $article->delete();

    return redirect()->route('galeri')->with('success', 'Artikel berhasil dihapus.');
}

public function togglePublic(Request $request, $id)
{
    $article = Article::findOrFail($id);

    // Cek otorisasi (hanya pemilik artikel)
    if ($article->user_id !== auth()->id()) {
        abort(403, 'Kamu tidak punya izin untuk mengubah status artikel ini.');
    }

    // Cek apakah checkbox di-submit dan set is_public sesuai itu
    $article->is_public = $request->has('is_public');
    $article->save();

    return redirect()->back()->with('success', 'Status public/private artikel berhasil diperbarui.');
}



}
