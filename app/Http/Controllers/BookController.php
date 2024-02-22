<?php

namespace App\Http\Controllers;

use App\Models\Book_Authors;
use App\Models\Book_Genres;
use App\Models\Books;
use App\Models\User_Favorites;
use Illuminate\Http\Request;
use Illuminate\Database;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function showAll()
    {
        if(!Books::exists())
            return response()->json('No books found',404);

        return Books::all();
    }

    public function add(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string'
        ]);


        //TODO: Add genres and authors creation
        $book = Books::create(['name' => $request->input('name')]);

        return response()->json(['book' => $book], 201);
    }

    /**
     * @throws \Exception
     */
    public function showById($id)
    {
        $book = $this->validateBook($id);

        return response()->json($book);
    }

    /**
     * @throws \Exception
     */
    public function remove($id)
    {
        $book = $this->validateBook($id);

        User_Favorites::where('book_id', $id)->delete();
        Book_Authors::where('book_id', $id)->delete();
        Book_Genres::where('book_id', $id)->delete();

        $book->delete();

        return response()->json('Book deleted successfully', 201);
    }

    public function csvExport()
    {
        $books = Books::all();

        $csvFileName = 'exported_books.csv';
        $filePath = storage_path($csvFileName);
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$csvFileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $handle = fopen($filePath, 'w');
        fputcsv($handle, ['id', 'name', 'created_at']);

        foreach ($books as $book) {
            fputcsv($handle, [$book->id, $book->name, $book->created_at]);
        }

        fclose($handle);

        return response()->download($filePath, $csvFileName, $headers)->deleteFileAfterSend(true);
    }
}
