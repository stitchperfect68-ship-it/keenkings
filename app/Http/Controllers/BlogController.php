<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\PageSetting;

class BlogController extends Controller
{
    public function index()
    {
        $posts        = BlogPost::published()->paginate(9);
        $pageSettings = PageSetting::current();
        return view('pages.blog', compact('posts', 'pageSettings'));
    }

    public function show(string $slug)
    {
        $post = BlogPost::where('slug', $slug)->where('is_published', true)->firstOrFail();
        $related = BlogPost::published()
            ->where('id', '!=', $post->id)
            ->when($post->category, fn($q) => $q->where('category', $post->category))
            ->take(3)
            ->get();
        return view('pages.blog-detail', compact('post', 'related'));
    }
}
