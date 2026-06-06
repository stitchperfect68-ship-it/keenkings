<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = BlogPost::orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('status')) {
            $query->where('is_published', $request->status === 'published');
        }
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $posts = $query->paginate(20);
        $categories = BlogPost::whereNotNull('category')->distinct()->pluck('category')->sort()->values();

        return view('admin.pages.blog.index', compact('posts', 'categories'));
    }

    public function create()
    {
        return view('admin.pages.blog.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'             => 'required|string|max:255',
            'excerpt'           => 'nullable|string|max:500',
            'body'              => 'required|string',
            'featured_image_url'=> 'nullable|url|max:500',
            'author'            => 'nullable|string|max:100',
            'category'          => 'nullable|string|max:100',
            'is_published'      => 'nullable|boolean',
        ]);

        $data['slug']         = BlogPost::generateSlug($data['title']);
        $data['is_published'] = $request->boolean('is_published');
        $data['author']       = $data['author'] ?: 'Keenkings Media';
        if ($data['is_published']) {
            $data['published_at'] = now();
        }

        BlogPost::create($data);

        return redirect()->route('admin.blog.index')
                         ->with('success', 'Blog post created successfully.');
    }

    public function edit(BlogPost $blog)
    {
        return view('admin.pages.blog.form', ['post' => $blog]);
    }

    public function update(Request $request, BlogPost $blog)
    {
        $data = $request->validate([
            'title'             => 'required|string|max:255',
            'excerpt'           => 'nullable|string|max:500',
            'body'              => 'required|string',
            'featured_image_url'=> 'nullable|url|max:500',
            'author'            => 'nullable|string|max:100',
            'category'          => 'nullable|string|max:100',
            'is_published'      => 'nullable|boolean',
        ]);

        $data['is_published'] = $request->boolean('is_published');
        $data['author']       = $data['author'] ?: 'Keenkings Media';

        if ($data['title'] !== $blog->title) {
            $data['slug'] = BlogPost::generateSlug($data['title'], $blog->id);
        }
        if ($data['is_published'] && !$blog->published_at) {
            $data['published_at'] = now();
        } elseif (!$data['is_published']) {
            $data['published_at'] = null;
        }

        $blog->update($data);

        return redirect()->route('admin.blog.index')
                         ->with('success', 'Blog post updated successfully.');
    }

    public function destroy(BlogPost $blog)
    {
        $blog->delete();
        return back()->with('success', 'Blog post deleted.');
    }

    public function togglePublish(BlogPost $blog)
    {
        $blog->is_published = !$blog->is_published;
        $blog->published_at = $blog->is_published ? now() : null;
        $blog->save();

        return back()->with('success', $blog->is_published ? 'Post published.' : 'Post unpublished.');
    }
}
