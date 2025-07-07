<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ArticleCommunity extends Model
{
    use HasFactory;

    protected $fillable = [
        'community_id', 'user_id', 'title', 'content', 'image'
    ];

    public function community()
    {
        return $this->belongsTo(Community::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function reactions()
    {
        return $this->hasMany(ArticleCommunityReaction::class);
    }
    // app/Models/ArticleCommunity.php
    public function comments()
    {
        return $this->hasMany(CommunityArticleComment::class, 'article_community_id');
    }


}
