<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        // Mengambil semua kategori
        $categories = Category::all();
        return view('pages.beranda', compact('categories'));
    }
}

