@extends('layouts.app')
@section('title', $post->title . ' — Keenkings Media')
@section('description', $post->excerpt ?? \Illuminate\Support\Str::limit(strip_tags($post->body), 160))

@section('content')

<!-- Article Hero -->
<section class="blog-detail-hero">
  @if($post->featured_image_url)
  <div class="blog-detail-hero-bg" style="background-image: url('{{ $post->featured_image_url }}')"></div>
  @endif
  <div class="blog-detail-hero-inner reveal">
    <div class="breadcrumb">
      <a href="{{ route('home') }}">Home</a>
      <span class="breadcrumb-sep">✦</span>
      <a href="{{ route('blog') }}">Blog</a>
      <span class="breadcrumb-sep">✦</span>
      <span class="breadcrumb-current">{{ Str::limit($post->title, 40) }}</span>
    </div>
    @if($post->category)
    <span class="blog-detail-cat">{{ $post->category }}</span>
    @endif
    <h1 class="blog-detail-title">{{ $post->title }}</h1>
    <div class="blog-detail-meta">
      <span>{{ $post->author }}</span>
      <span>·</span>
      <span>{{ $post->published_at?->format('d F Y') }}</span>
      <span>·</span>
      <span>{{ $post->reading_time }} min read</span>
    </div>
  </div>
</section>

<!-- Article Body -->
<div class="blog-detail-body">
  <div class="blog-body-content reveal">
    {!! $post->body !!}
  </div>

  <a href="{{ route('blog') }}" class="blog-back-link">Back to Blog</a>
</div>

<!-- Related Posts -->
@if($related->isNotEmpty())
<section class="blog-related">
  <div class="blog-related-inner">
    <p class="blog-related-label">More Stories</p>
    <h2 class="blog-related-heading">You Might Also Like</h2>
    <div class="blog-grid">
      @foreach($related as $rel)
      <article class="blog-card reveal reveal-delay-{{ $loop->index + 1 }}">
        <a href="{{ route('blog.show', $rel->slug) }}" class="blog-card-thumb">
          @if($rel->featured_image_url)
            <img src="{{ $rel->featured_image_url }}" alt="{{ $rel->title }}" loading="lazy">
          @else
            <div class="blog-card-thumb-empty">KK</div>
          @endif
        </a>
        <div class="blog-card-body">
          <div class="blog-card-meta">
            @if($rel->category)
            <span class="blog-card-cat">{{ $rel->category }}</span>
            @endif
            <span>{{ $rel->published_at?->format('d M Y') }}</span>
          </div>
          <h3 class="blog-card-title">
            <a href="{{ route('blog.show', $rel->slug) }}" style="text-decoration:none;color:inherit">
              {{ $rel->title }}
            </a>
          </h3>
          <a href="{{ route('blog.show', $rel->slug) }}" class="blog-card-link">Read More</a>
        </div>
      </article>
      @endforeach
    </div>
  </div>
</section>
@endif

@endsection

@push('head')
<meta property="og:title"       content="{{ $post->title }}">
<meta property="og:description" content="{{ $post->excerpt ?? \Illuminate\Support\Str::limit(strip_tags($post->body), 160) }}">
@if($post->featured_image_url)
<meta property="og:image" content="{{ $post->featured_image_url }}">
@endif
@endpush
