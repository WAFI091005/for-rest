<?php

// app/Notifications/ArticleLiked.php
namespace App\Notifications;

use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ArticleLiked extends Notification
{
    use Queueable;

    public Article $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    public function via($notifiable)
    {
        return ['database']; // wajib ada agar masuk ke unreadNotifications
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Disukai oleh ' . auth()->user()->name,
            'article_id' => $this->article->id,
        ];
    }
}

