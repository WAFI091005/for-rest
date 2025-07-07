<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Like;
use App\Models\Article;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar', // Menambahkan kolom avatar
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Menambahkan timestamp untuk created_at dan updated_at
     */
    public $timestamps = true;

    /**
     * Artikel yang disukai user ini
     */
    public function likedArticles()
    {
        return $this->belongsToMany(Article::class, 'likes')->withTimestamps();
    }

    /**
     * Artikel yang ditulis oleh user ini
     */
    public function articles()
    {
        return $this->hasMany(Article::class);
    }   

    // app/Models/User.php

    // public function canAccessFilament(): bool
    // {
    //     return $this->email === 'admin@for-rest.com'; // Ganti dengan email admin kamu
    // }
    public function createdCommunities()
    {
        return $this->hasMany(Community::class);
    }

    public function joinedCommunities()
    {
        return $this->belongsToMany(Community::class, 'community_user')->withTimestamps();
    }
    public function articleCommunityReactions()
    {
        return $this->hasMany(ArticleCommunityReaction::class);
    }



}
