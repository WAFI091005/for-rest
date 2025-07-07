<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Memory extends Model
{
    // Relasi Memory ke Article (Memory punya satu Article)
    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}


