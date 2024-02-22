<?php

namespace App\Http\Controllers;

use App\Models\Books;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * @throws \Exception
     */
    public function validateBook($id){
        $book = Books::find($id);

        if (!$book) {
            throw new \Exception('Book not found', 404);
        }

        return $book;
    }

}
