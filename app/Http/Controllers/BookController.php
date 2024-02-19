<?php

namespace App\Http\Controllers;

use App\Models\Books;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        return Books::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required']
        ]);

        return Books::create($data);
    }

    public function show(Books $id)
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

    public function destroy(Books $book)
    {
        $book->delete();

        return response()->json();
    }
}
