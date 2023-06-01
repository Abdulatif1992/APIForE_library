<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ApiController extends Controller
{
    public function books()
    {
        $booksId = DB::table('books')->pluck('book_id');
        return $booksId;
    }

    public function getBook($book_id)
    {
        $book = DB::table('books')->select('book_id','book_name', 'book_title', 'status', 'base64')->where('book_id', $book_id)->first();
        return $book;
    }
    
    public function getBooks($booksIdList)
    {
        $books = DB::table('books')->select('book_id','book_name', 'book_title', 'status', 'base64')->whereIn('book_id', explode(',', $booksIdList))->get();

        return $books;
    }

    public function download($filename)
    {
        $file = storage_path('app/' . $filename . '.zip');

        if (!file_exists($file)) {
            return response()->json(['message' => 'File not found.'], 404);
        }

        $headers = [
            'Content-Type' => 'application/octet-stream',
            'Content-Description' => 'File Transfer',
            'Content-Disposition' => 'attachment; filename="' . basename($file) . '"',
            'Content-Length' => filesize($file),
            'Pragma' => 'public',
        ];

        return response()->download($file, basename($file), $headers);
    }
    
    public function books2()
    {
        $booksId = DB::table('books')->pluck('book_id');
        return $booksId;
    }

}
