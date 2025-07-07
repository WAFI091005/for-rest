<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityArticleComment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'article_community_id', 'content'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function article()
    {
        return $this->belongsTo(ArticleCommunity::class, 'article_community_id');
    }
}