<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'user_id','title', 'author', 'author_image', 'location', 'trip_date', 'image','image2','image3', 'excerpt', 'content', 'category_id', 'is_public',
    ];

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function community()
    {
        return $this->belongsTo(Community::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'article_id');
    }

    public function isLikedBy($user): bool
    {
        if (!$user) return false;
        return $this->likes()->where('user_id', $user->id)->exists();
    }
    public function galleries()
    {
        return $this->hasMany(Gallery::class, 'article_id');
    }



}
