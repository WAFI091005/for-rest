<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
{
    $articles = \App\Models\Article::with('tags')->latest()->get();

    return view('beranda', compact('articles'));
}

}
