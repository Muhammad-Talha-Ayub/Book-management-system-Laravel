<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    protected $table = 'blog_posts';

    // If you have fillable fields
    protected $fillable = ['title', 'content', 'author_id'];
}
