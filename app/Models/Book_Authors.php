<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book_Authors extends Model
{
    protected $table = 'book_authors';

    protected $fillable = ['book_id','author_id'];
}
