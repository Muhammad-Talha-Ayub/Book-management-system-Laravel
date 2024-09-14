<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Media;
use App\Team;
use App\Author;
use App\Book;
use App\Category;
// use App\BlogPost; 

class MainController extends Controller
{
    public function index()
    {
        $sliders=Media::where(['status'=>'ACTIVE', 'media_type' => 'slider'])->get();
        $upcoming_books=Book::where('status','UPCOMING')->limit(5)->get();
        $downloaded_books=Book::with('author', 'category')->orderBy('downloaded','DESC')->get();
        $recommended_books=Book::where('recommended','yes')->get();
        $categories=Category::where('status','ACTIVE')->get();
        $books=Book::with('author')->where('status','ACTIVE')->paginate(10);
        $author_feature=Author::with('author_books')->where(['status'=>'ACTIVE','author_feature'=>'yes'])->inRandomOrder()->first();
        //first mean single record
        $galleries=Media::where(['status'=>'ACTIVE', 'media_type'=>'gallery'])->limit(6)->get();
        // $latest_posts = BlogPost::latest()->take(3)->get();
        return view('index',compact('sliders','upcoming_books','downloaded_books','recommended_books','categories','books','author_feature','galleries'));
    }
    public function gallery()
    {
        $galleries= Media::where(['status'=>'ACTIVE', 'media_type'=>'gallery'])->paginate(8);
        return view('gallery', compact('galleries'));
    }
    public function author()
    {
        $getSearch=request()->get('letter');
        $authors=Author::where('title', 'LIKE', "$getSearch%")->get();
        $author_features = Author::where('author_feature', 'yes')->inRandomOrder()->limit(5)->get();
        $downloaded_books = Book::orderBy('downloaded', 'DESC')->limit(5)->get();
        return view('author', compact('authors','downloaded_books' , 'author_features'));
    }
    public function contact()
    {
        return view('contact');
    }
    public function about()
    {
        $teams= Team::where('status', 'ACTIVE')->limit(4)->get();
        return view('about', compact('teams'));
    }
}
