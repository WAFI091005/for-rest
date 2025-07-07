<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Kolom yang bisa diisi
    protected $fillable = ['name', 'image', 'memories_count'];

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function memories()
    {
        return $this->hasMany(Memory::class);
    }
}
