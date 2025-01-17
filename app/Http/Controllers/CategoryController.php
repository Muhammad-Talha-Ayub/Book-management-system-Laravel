<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Book;

class CategoryController extends Controller
{
    public function show($slug)
    {
        $categories = Category::get();
        $category = Category::where('slug', $slug)->first();
        $books = Book::where('category_id', $category->id)->paginate(10);
        return view('category.category_detail', compact('categories', 'books'));
    }
}
