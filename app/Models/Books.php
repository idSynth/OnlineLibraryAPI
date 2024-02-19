<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    protected $fillable = ['name'];

    public function authors()
    {
        return $this->belongsToMany(Authors::class, 'book_authors');
    }

    public function genres()
    {
        return $this->belongsToMany(Genres::class, 'book_genres');
    }
}
