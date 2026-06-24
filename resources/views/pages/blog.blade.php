@extends('layouts.app')
@section('title', 'Blog — Keenkings Media')
@section('description', 'Stories, insights and behind-the-scenes content from Keenkings Media studio in Lusaka, Zambia.')

@section('content')

<!-- Page Hero -->
<section class="page-hero">
  <div class="page-hero-bg parallax-bg"
       style="background-image: url('{{ $pageSettings->blog_page_image_url ?: 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=1600&q=80' }}')"></div>
  <div class="page-hero-content reveal">
    <div class="breadcrumb">
      <a href="{{ route('home') }}">Home</a>
      <span class="breadcrumb-sep">✦</span>
      <span class="breadcrumb-current">Blog</span>
    </div>
    <h1 class="page-hero-title">{{ $pageSettings->blog_page_title }}</h1>
  </div>
</section>

<!-- Blog Grid -->
<div class="blog-section">
  <div class="blog-grid">
    @forelse($posts as $post)
    <article class="blog-card reveal reveal-delay-{{ ($loop->index % 3) + 1 }}">
      <a href="{{ route('blog.show', $post->slug) }}" class="blog-card-thumb">
        @if($post->featured_image_url)
          <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" loading="lazy">
        @else
          <div class="blog-card-thumb-empty">KK</div>
        @endif
      </a>
      <div class="blog-card-body">
        <div class="blog-card-meta">
          @if($post->category)
          <span class="blog-card-cat">{{ $post->category }}</span>
          @endif
          <span>{{ $post->published_at?->format('d M Y') }}</span>
          <span>{{ $post->reading_time }} min read</span>
        </div>
        <h2 class="blog-card-title">
          <a href="{{ route('blog.show', $post->slug) }}" style="text-decoration:none;color:inherit">
            {{ $post->title }}
          </a>
        </h2>
        @if($post->excerpt)
        <p class="blog-card-excerpt">{{ $post->excerpt }}</p>
        @endif
        <a href="{{ route('blog.show', $post->slug) }}" class="blog-card-link">Read More</a>
      </div>
    </article>
    @empty
    <div class="blog-empty">No posts published yet.</div>
    @endforelse
  </div>

  {{-- Pagination --}}
  @if($posts->hasPages())
  <nav class="blog-pagination" aria-label="Blog pages">
    {{-- Previous --}}
    @if($posts->onFirstPage())
      <span>&larr;</span>
    @else
      <a href="{{ $posts->previousPageUrl() }}">&larr;</a>
    @endif

    {{-- Page numbers --}}
    @foreach($posts->getUrlRange(1, $posts->lastPage()) as $page => $url)
      @if($page === $posts->currentPage())
        <span class="blog-page-active">{{ $page }}</span>
      @elseif(abs($page - $posts->currentPage()) <= 2 || $page === 1 || $page === $posts->lastPage())
        <a href="{{ $url }}">{{ $page }}</a>
      @elseif(abs($page - $posts->currentPage()) === 3)
        <span class="blog-page-dots">&hellip;</span>
      @endif
    @endforeach

    {{-- Next --}}
    @if($posts->hasMorePages())
      <a href="{{ $posts->nextPageUrl() }}">&rarr;</a>
    @else
      <span>&rarr;</span>
    @endif
  </nav>
  @endif
</div>

@endsection
