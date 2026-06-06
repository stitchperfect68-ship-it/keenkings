@extends('admin.layouts.app')
@section('title', 'Blog Posts')
@section('breadcrumb', 'Blog')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Blog Posts</h1>
        <p class="page-sub">{{ $posts->total() }} posts total &middot; Manage your articles and announcements.</p>
    </div>
    <a href="{{ route('admin.blog.create') }}" class="btn btn-primary">
        <i data-feather="plus"></i> New Post
    </a>
</div>

<!-- Filters -->
<div class="filter-bar">
    <form method="GET" class="filter-form">
        <div class="filter-group">
            <select name="status" onchange="this.form.submit()" class="filter-select">
                <option value="">All Statuses</option>
                <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                <option value="draft"     {{ request('status') === 'draft'     ? 'selected' : '' }}>Draft</option>
            </select>
        </div>
        @if($categories->count())
        <div class="filter-group">
            <select name="category" onchange="this.form.submit()" class="filter-select">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>
        </div>
        @endif
        <div class="filter-group filter-search">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by title..." class="filter-input">
            <button type="submit" class="filter-btn"><i data-feather="search"></i></button>
        </div>
        @if(request()->hasAny(['status','category','search']))
        <a href="{{ route('admin.blog.index') }}" class="filter-clear">
            <i data-feather="x"></i> Clear
        </a>
        @endif
    </form>
</div>

<!-- Posts Table -->
<div class="table-card">
    <table class="admin-table">
        <thead>
            <tr>
                <th style="width:44px"></th>
                <th>Title</th>
                <th>Category</th>
                <th>Author</th>
                <th>Status</th>
                <th>Published</th>
                <th style="width:120px">Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse($posts as $post)
        <tr>
            <td>
                @if($post->featured_image_url)
                <img src="{{ $post->featured_image_url }}" alt=""
                     style="width:40px;height:40px;object-fit:cover;border-radius:4px;display:block">
                @else
                <div style="width:40px;height:40px;background:rgba(255,255,255,.06);border-radius:4px;display:flex;align-items:center;justify-content:center;opacity:.4">
                    <i data-feather="image" style="width:16px;height:16px"></i>
                </div>
                @endif
            </td>
            <td>
                <strong style="display:block;margin-bottom:2px">{{ $post->title }}</strong>
                <small style="opacity:.5;font-size:11px">/blog/{{ $post->slug }}</small>
            </td>
            <td>
                @if($post->category)
                <span class="cat-badge" style="background:rgba(255,255,255,.08);color:inherit;font-size:11px;padding:3px 8px;border-radius:3px;text-transform:uppercase;letter-spacing:.06em">
                    {{ $post->category }}
                </span>
                @else
                <span style="opacity:.3">—</span>
                @endif
            </td>
            <td style="opacity:.7;font-size:13px">{{ $post->author }}</td>
            <td>
                @if($post->is_published)
                <span class="status-badge status-active">Published</span>
                @else
                <span class="status-badge status-inactive">Draft</span>
                @endif
            </td>
            <td style="font-size:12px;opacity:.6">
                {{ $post->published_at ? $post->published_at->format('d M Y') : '—' }}
            </td>
            <td>
                <div class="row-actions">
                    <a href="{{ route('blog.show', $post->slug) }}" target="_blank"
                       class="row-action-btn" title="View">
                        <i data-feather="external-link"></i>
                    </a>
                    <a href="{{ route('admin.blog.edit', $post) }}" class="row-action-btn" title="Edit">
                        <i data-feather="edit-2"></i>
                    </a>
                    <form method="POST" action="{{ route('admin.blog.toggle', $post) }}" style="display:inline">
                        @csrf
                        <button type="submit" class="row-action-btn" title="{{ $post->is_published ? 'Unpublish' : 'Publish' }}">
                            <i data-feather="{{ $post->is_published ? 'eye-off' : 'eye' }}"></i>
                        </button>
                    </form>
                    <form method="POST" action="{{ route('admin.blog.destroy', $post) }}" style="display:inline"
                          onsubmit="return confirm('Delete &quot;{{ addslashes($post->title) }}&quot;?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="row-action-btn danger" title="Delete">
                            <i data-feather="trash-2"></i>
                        </button>
                    </form>
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7">
                <div class="empty-card">
                    <i data-feather="file-text"></i>
                    <p>No blog posts yet.</p>
                    <a href="{{ route('admin.blog.create') }}" class="btn btn-primary">Write Your First Post</a>
                </div>
            </td>
        </tr>
        @endforelse
        </tbody>
    </table>
</div>

<div class="pagination-wrap">
    {{ $posts->withQueryString()->links('admin.components.pagination') }}
</div>
@endsection
