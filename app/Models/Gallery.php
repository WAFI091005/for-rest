<?php

// app/Models/Gallery.php

// app/Models/Gallery.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = ['user_id', 'category_id', 'image_url', 'title', 'article_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // kalau perlu relasi category juga
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id');
    }

}

