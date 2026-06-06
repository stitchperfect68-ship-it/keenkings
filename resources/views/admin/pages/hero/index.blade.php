@extends('admin.layouts.app')
@section('title', 'Hero Slides')
@section('breadcrumb', 'Hero Slides')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Hero Slides</h1>
        <p class="page-sub">Manage the homepage hero carousel — up to 5 slides recommended.</p>
    </div>
    <a href="{{ route('admin.hero.create') }}" class="btn btn-primary">
        <i data-feather="plus"></i> Add Slide
    </a>
</div>

<div class="slides-grid" id="slidesGrid">
    @forelse($slides as $slide)
    <div class="slide-card {{ !$slide->is_active ? 'inactive' : '' }}" data-id="{{ $slide->id }}">
        <div class="slide-thumb">
            <img src="{{ $slide->image_url }}" alt="Slide {{ $slide->sort_order }}" loading="lazy">
            <div class="slide-num">#{{ $loop->iteration }}</div>
            @if(!$slide->is_active)<div class="slide-hidden-badge">Hidden</div>@endif
        </div>
        <div class="slide-info">
            @if($slide->heading)
            <p class="slide-heading">{{ Str::limit($slide->heading, 50) }}</p>
            @endif
            @if($slide->subheading)
            <p class="slide-sub">{{ Str::limit($slide->subheading, 60) }}</p>
            @endif
            <p class="slide-url">{{ Str::limit($slide->image_url, 50) }}</p>
        </div>
        <div class="slide-actions">
            <a href="{{ route('admin.hero.edit', $slide) }}" class="action-btn">
                <i data-feather="edit-2"></i> Edit
            </a>
            <form method="POST" action="{{ route('admin.hero.destroy', $slide) }}" onsubmit="return confirm('Delete this slide?')">
                @csrf @method('DELETE')
                <button type="submit" class="action-btn danger">
                    <i data-feather="trash-2"></i> Delete
                </button>
            </form>
        </div>
    </div>
    @empty
    <div class="empty-card">
        <i data-feather="image"></i>
        <p>No hero slides yet.</p>
        <a href="{{ route('admin.hero.create') }}" class="btn btn-primary">Add Your First Slide</a>
    </div>
    @endforelse
</div>
@endsection
