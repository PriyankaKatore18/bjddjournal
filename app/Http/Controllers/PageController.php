<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;

class PageController extends Controller
{
    public function faq()
    {
        return view('faq');
    }
    public function blogs()
    {
        $blogs = Blog::latest()->paginate(5);

        return view('blogs', compact('blogs'));
    }
}
