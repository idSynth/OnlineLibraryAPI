<?php

namespace App\Http\Controllers;

use App\Models\Books;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function showAll()
    {
        return Books::all();
    }

    public function add(Request $request)
    {
        $data = $request->validate([
            'name' => ['required']
        ]);

        return Books::create($data);
    }

    public function showById(Books $id)
    {
        $book = Books::find($id);

        if (!$book) {
            return response()->json(['error' => 'Book not found'], 404);
        }

        return response()->json($book);
    }

    public function update(Request $request, Books $book)
    {
        $data = $request->validate([
            'name' => ['required'],
        ]);

        $book->update($data);

        return $book;
    }

    public function remove(Books $book)
    {
        $book->delete();

        return response()->json();
    }
}
