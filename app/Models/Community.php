<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;   

class Community extends Model
{
    protected $fillable = ['user_id', 'name', 'description', 'image'];

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'community_user', 'community_id', 'user_id')->withTimestamps();
    }

    public function articles()
    {
        return $this->hasMany(ArticleCommunity::class);
    }

}

