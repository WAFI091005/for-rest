<?php

namespace App\Livewire;

use App\Models\Article;
use Livewire\Component;
use App\Notifications\ArticleLiked;
use Illuminate\Support\Facades\Auth;

class ArticleLike extends Component
{
    public Article $article;

    public function toggleLike()
    {
        $user = Auth::user();
        if (!$user) return;

        if ($this->article->isLikedBy($user)) {
            $this->article->likes()->where('user_id', $user->id)->delete();
        } else {
            $this->article->likes()->create(['user_id' => $user->id]);

            // Kirim notifikasi ke pemilik artikel (jika bukan dirinya sendiri)
            if ($this->article->user_id !== $user->id) {
                $this->article->user->notify(new ArticleLiked($this->article));
            }
        }

        $this->article->refresh();
    }

    public function render()
    {
        return view('livewire.article-like', [
            'likesCount' => $this->article->likes()->count(),
            'isLiked' => $this->article->isLikedBy(Auth::user()),
        ]);
    }
}
