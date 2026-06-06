@extends('admin.layouts.app')
@section('title', isset($post) ? 'Edit Post' : 'New Post')
@section('breadcrumb')
    <a href="{{ route('admin.blog.index') }}">Blog</a>
    <i data-feather="chevron-right"></i>
    {{ isset($post) ? 'Edit' : 'New Post' }}
@endsection

@section('content')
<div class="page-header">
    <h1 class="page-title">{{ isset($post) ? 'Edit: ' . $post->title : 'New Blog Post' }}</h1>
</div>

<div class="form-layout form-layout-2col">
    <form method="POST"
          action="{{ isset($post) ? route('admin.blog.update', $post) : route('admin.blog.store') }}"
          class="admin-form"
          id="blogForm">
        @csrf
        @if(isset($post)) @method('PUT') @endif

        <!-- Left column: meta -->
        <div class="form-col">
            <div class="form-card">
                <h3 class="form-section-title"><i data-feather="settings"></i> Post Settings</h3>

                <div class="form-group">
                    <label>Category</label>
                    <input type="text" name="category"
                           value="{{ old('category', $post->category ?? '') }}"
                           placeholder="e.g. Photography, Behind the Scenes">
                    @error('category')<span class="form-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label>Author</label>
                    <input type="text" name="author"
                           value="{{ old('author', $post->author ?? 'Keenkings Media') }}"
                           placeholder="Keenkings Media">
                    @error('author')<span class="form-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label class="toggle-label">
                        <input type="hidden"   name="is_published" value="0">
                        <input type="checkbox" name="is_published" value="1"
                               {{ old('is_published', $post->is_published ?? false) ? 'checked' : '' }}>
                        <span class="toggle-switch"></span>
                        Published (visible on site)
                    </label>
                </div>

                @if(isset($post) && $post->published_at)
                <div class="form-group">
                    <label style="opacity:.5;font-size:12px">Published on</label>
                    <p style="font-size:13px;opacity:.7;margin-top:4px">{{ $post->published_at->format('d F Y, H:i') }}</p>
                </div>
                @endif

                @if(isset($post))
                <div class="form-group">
                    <label style="opacity:.5;font-size:12px">Permalink</label>
                    <p style="font-size:12px;opacity:.55;margin-top:4px;word-break:break-all">
                        <a href="{{ route('blog.show', $post->slug) }}" target="_blank" style="text-decoration:underline">
                            /blog/{{ $post->slug }}
                        </a>
                    </p>
                </div>
                @endif
            </div>

            <div class="form-card">
                <h3 class="form-section-title"><i data-feather="image"></i> Featured Image</h3>
                <div class="image-preview-box" id="imagePreview" style="height:200px">
                    @if(isset($post) && $post->featured_image_url)
                    <img src="{{ $post->featured_image_url }}" alt="" style="width:100%;height:100%;object-fit:cover">
                    @else
                    <div class="image-placeholder">
                        <i data-feather="upload-cloud"></i>
                        <span>Enter image URL below</span>
                    </div>
                    @endif
                </div>
                <div class="form-group mt">
                    <label>Image URL</label>
                    <input type="url" name="featured_image_url"
                           value="{{ old('featured_image_url', $post->featured_image_url ?? '') }}"
                           placeholder="https://..." oninput="previewUrl(this)">
                    @error('featured_image_url')<span class="form-error">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>

        <!-- Right column: content -->
        <div class="form-col">
            <div class="form-card">
                <h3 class="form-section-title"><i data-feather="edit-3"></i> Content</h3>

                <div class="form-group">
                    <label>Title *</label>
                    <input type="text" name="title"
                           value="{{ old('title', $post->title ?? '') }}"
                           placeholder="Post title..." required
                           oninput="updateSlugPreview(this.value)">
                    @error('title')<span class="form-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label>Excerpt <small style="opacity:.5">(shown on blog listing, max 500 chars)</small></label>
                    <textarea name="excerpt" rows="3"
                              placeholder="Short summary of this post...">{{ old('excerpt', $post->excerpt ?? '') }}</textarea>
                    @error('excerpt')<span class="form-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label>Body *</label>
                    <textarea name="body" id="bodyEditor" rows="20"
                              placeholder="Write your post content here... (HTML is supported)"
                              required>{{ old('body', $post->body ?? '') }}</textarea>
                    @error('body')<span class="form-error">{{ $message }}</span>@enderror
                    <small style="opacity:.5;margin-top:6px;display:block">HTML tags are supported: &lt;p&gt;, &lt;h2&gt;, &lt;h3&gt;, &lt;strong&gt;, &lt;em&gt;, &lt;ul&gt;, &lt;ol&gt;, &lt;li&gt;, &lt;img&gt;, &lt;a&gt;, &lt;blockquote&gt;</small>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="form-actions sticky-actions">
    <a href="{{ route('admin.blog.index') }}" class="btn btn-ghost">Cancel</a>
    <button form="blogForm" type="submit" class="btn btn-primary">
        <i data-feather="save"></i> {{ isset($post) ? 'Update Post' : 'Create Post' }}
    </button>
</div>
@endsection

@push('scripts')
<script>
function previewUrl(input) {
    const box = document.getElementById('imagePreview');
    if (input.value) {
        box.innerHTML = `<img src="${input.value}" alt="" style="width:100%;height:100%;object-fit:cover">`;
    }
}

function updateSlugPreview(title) {
    // Just visual feedback; real slug generated server-side
}
</script>
@endpush
