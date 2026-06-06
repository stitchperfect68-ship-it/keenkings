@extends('admin.layouts.app')
@section('title', 'Clients')
@section('breadcrumb', 'Clients')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Our Clients</h1>
        <p class="page-sub">{{ $clients->total() }} clients total &middot; Manage the marquee rows on the home page.</p>
    </div>
    <a href="{{ route('admin.clients.create') }}" class="btn btn-primary">
        <i data-feather="plus"></i> Add Client
    </a>
</div>

<!-- Filters -->
<div class="filter-bar">
    <form method="GET" class="filter-form">
        <div class="filter-group">
            <select name="row" onchange="this.form.submit()" class="filter-select">
                <option value="">All Rows</option>
                <option value="1" {{ request('row') == '1' ? 'selected' : '' }}>Row 1 (left)</option>
                <option value="2" {{ request('row') == '2' ? 'selected' : '' }}>Row 2 (right)</option>
                <option value="3" {{ request('row') == '3' ? 'selected' : '' }}>Row 3 (left)</option>
            </select>
        </div>
        <div class="filter-group filter-search">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name..." class="filter-input">
            <button type="submit" class="filter-btn"><i data-feather="search"></i></button>
        </div>
        @if(request()->hasAny(['row','search']))
        <a href="{{ route('admin.clients.index') }}" class="filter-clear">
            <i data-feather="x"></i> Clear
        </a>
        @endif
    </form>
</div>

<!-- Row legend -->
<div style="display:flex;gap:16px;margin-bottom:20px;flex-wrap:wrap;">
    @foreach([1=>'Row 1 — scrolls left',2=>'Row 2 — scrolls right (reverse)',3=>'Row 3 — scrolls left'] as $r => $label)
    <div style="display:flex;align-items:center;gap:8px;font-size:12px;opacity:.7;">
        <span style="width:28px;height:4px;background:rgba(255,255,255,.3);border-radius:2px;display:block"></span>
        <span>{{ $label }}</span>
    </div>
    @endforeach
</div>

<!-- Client Grid -->
<div class="portfolio-admin-grid">
    @forelse($clients as $client)
    <div class="padmin-card {{ !$client->is_active ? 'hidden-item' : '' }}">

        @if(!$client->is_active)
        <div class="padmin-hidden-ribbon">Hidden</div>
        @endif

        <div class="padmin-thumb" style="aspect-ratio:16/7;background:#111">
            @if($client->logo_url)
            <img src="{{ $client->logo_url }}" alt="{{ $client->name }}"
                 style="width:100%;height:100%;object-fit:contain;padding:12px">
            @else
            <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-family:var(--font-serif);font-size:18px;letter-spacing:.12em;opacity:.4;">
                {{ strtoupper($client->name) }}
            </div>
            @endif
        </div>

        <div class="padmin-info">
            <div class="padmin-cats">
                <span class="cat-badge" style="background:rgba(255,255,255,.08);color:inherit;font-size:10px;padding:2px 8px">
                    Row {{ $client->row }}
                </span>
                @if($client->website_url)
                <span class="sub-badge">Has link</span>
                @endif
            </div>
            <h4 class="padmin-title">{{ $client->name }}</h4>
        </div>

        <div class="padmin-actions">
            <a href="{{ route('admin.clients.edit', $client) }}" class="padmin-btn" title="Edit">
                <i data-feather="edit-2"></i>
            </a>
            <form method="POST" action="{{ route('admin.clients.toggle', $client) }}" style="display:inline">
                @csrf
                <button type="submit" class="padmin-btn" title="{{ $client->is_active ? 'Hide' : 'Show' }}">
                    <i data-feather="{{ $client->is_active ? 'eye-off' : 'eye' }}"></i>
                </button>
            </form>
            <form method="POST" action="{{ route('admin.clients.destroy', $client) }}" style="display:inline"
                  onsubmit="return confirm('Remove {{ addslashes($client->name) }}?')">
                @csrf @method('DELETE')
                <button type="submit" class="padmin-btn danger" title="Delete">
                    <i data-feather="trash-2"></i>
                </button>
            </form>
        </div>
    </div>
    @empty
    <div class="empty-card" style="grid-column:1/-1">
        <i data-feather="users"></i>
        <p>No clients yet.</p>
        <a href="{{ route('admin.clients.create') }}" class="btn btn-primary">Add First Client</a>
    </div>
    @endforelse
</div>

<div class="pagination-wrap">
    {{ $clients->withQueryString()->links('admin.components.pagination') }}
</div>
@endsection
