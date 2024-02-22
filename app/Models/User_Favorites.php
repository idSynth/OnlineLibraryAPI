<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_Favorites extends Model
{
    protected $table = 'user_favorites';
    protected $fillable = ['user_id', 'book_id'];

}
