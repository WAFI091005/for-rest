<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Notifications\ArticleLiked;

class LikeController extends Controller
{
    public function store(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        $user = auth()->user();

        $alreadyLiked = $article->likes()->where('user_id', $user->id)->exists();

        if (!$alreadyLiked) {
            $article->likes()->create(['user_id' => $user->id]);

            if ($article->user_id !== $user->id) {
                $article->user->notify(new ArticleLiked($user, $article));
            }
        }

        return back()->with('success', 'Artikel berhasil di-like.');
    }

}
