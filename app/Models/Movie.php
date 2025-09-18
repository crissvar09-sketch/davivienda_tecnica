<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Movie extends Model
{

    protected $fillable = [
        'title', 'genre', 'poster', 'year','director'
    ];
    public function favoredBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorite_movies');
    }

}
