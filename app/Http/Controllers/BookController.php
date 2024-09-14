<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;

class BookController extends Controller
{
    public function show($slug)
    {
    $book = Book::where('slug', $slug)->first();
    return view('book.book_detail', compact('book'));
    }
}
