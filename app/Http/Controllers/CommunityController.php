<?php

namespace App\Http\Controllers;

use App\Models\Community;
use Illuminate\Http\Request;
use App\Models\ArticleCommunity;
use App\Models\CommunityArticleComment;
use App\Models\ArticleCommunityReaction;

class CommunityController extends Controller
{
    public function index()
    {
        $communities = Community::withCount('members')->get();  // <- ini supaya ada members_count
        // Optional: eager load relasi user yang login gabung agar bisa dicek di blade lebih efisien
        auth()->user()->load('joinedCommunities');
        
        return view('communities.index', compact('communities'));
    }


    public function create()
    {
        return view('communities.create');
    }

public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'image' => 'nullable|image|max:2048',
    ]);

    $imagePath = null;
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('communities', 'public');
    }

    $community = Community::create([
        'user_id' => auth()->id(), // wajib isi user_id
        'name' => $validated['name'],
        'description' => $validated['description'],
        'image' => $imagePath,
    ]);

    $community->members()->attach(auth()->id()); // otomatis join

    return redirect()->route('communities.index')->with('success', 'Komunitas berhasil dibuat!');
}


    public function join($id)
    {
        $community = Community::findOrFail($id);
        $user = auth()->user();

        if (!$community->members()->where('user_id', $user->id)->exists()) {
            $community->members()->attach($user->id);
        }

        return redirect()->back()->with('success', 'Berhasil bergabung komunitas.');
    }

    public function leave($id)
    {
        $community = Community::findOrFail($id);
        $user = auth()->user();

        if ($community->members()->where('user_id', $user->id)->exists()) {
            $community->members()->detach($user->id);
        }

        return redirect()->back()->with('success', 'Berhasil keluar komunitas.');
    }

    public function show($id)
{
    $community = Community::with(['articles.user'])->findOrFail($id);
    return view('communities.show', compact('community'));
}

// Tampil form tambah artikel komunitas
public function createArticleCommunity($id)
{
    $community = Community::findOrFail($id);
    return view('communities.create-article', compact('community'));
}

// Simpan artikel komunitas baru
public function storeArticle(Request $request, $id)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'image' => 'nullable|image|max:2048',
    ]);

    $imagePath = null;
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('article_communities', 'public');
    }

    ArticleCommunity::create([
        'community_id' => $id,
        'user_id' => auth()->id(),
        'title' => $request->title,
        'content' => $request->content,
        'image' => $imagePath,
    ]);

    return redirect()->route('communities.show', $id)->with('success', 'Informasi berhasil ditambahkan.');
}
public function reactToArticle(Request $request, ArticleCommunity $article)
{
    $request->validate([
        'type' => 'required|in:like,love,laugh',
    ]);

    $reaction = ArticleCommunityReaction::updateOrCreate(
        [
            'user_id' => auth()->id(),
            'article_community_id' => $article->id,
        ],
        [
            'type' => $request->type,
        ]
    );

    return back()->with('success', 'Reaksi ditambahkan!');
}
public function storeComment(Request $request, $id)
{
    $request->validate([
        'content' => 'required|string|max:1000',
    ]);

    CommunityArticleComment::create([
        'user_id' => auth()->id(),
        'article_community_id' => $id,
        'content' => $request->content,
    ]);

    return back()->with('success', 'Komentar berhasil ditambahkan.');
}


}
