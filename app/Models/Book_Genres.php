<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book_Genres extends Model
{
    protected $table = 'book_genres';

    protected $fillable = ['book_id','genre_id'];
}
