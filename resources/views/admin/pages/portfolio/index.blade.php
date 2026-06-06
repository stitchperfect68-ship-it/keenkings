@extends('admin.layouts.app')
@section('title', 'Portfolio')
@section('breadcrumb', 'Portfolio')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Portfolio Items</h1>
        <p class="page-sub">{{ $items->total() }} items total · Manage your photography, videography and graphics work.</p>
    </div>
    <a href="{{ route('admin.portfolio.create') }}" class="btn btn-primary">
        <i data-feather="plus"></i> Add Item
    </a>
</div>

<!-- Filters -->
<div class="filter-bar">
    <form method="GET" class="filter-form" id="filterForm">
        <div class="filter-group">
            <select name="parent" onchange="this.form.submit()" class="filter-select">
                <option value="">All Categories</option>
                @foreach($parentCats as $cat)
                <option value="{{ $cat }}" {{ request('parent') === $cat ? 'selected' : '' }}>
                    {{ ucfirst($cat) }}
                </option>
                @endforeach
            </select>
        </div>
        @if(request('parent') && isset($subCats[request('parent')]))
        <div class="filter-group">
            <select name="sub" onchange="this.form.submit()" class="filter-select">
                <option value="">All Sub-categories</option>
                @foreach($subCats[request('parent')] as $sub)
                <option value="{{ $sub }}" {{ request('sub') === $sub ? 'selected' : '' }}>
                    {{ ucfirst(str_replace('-', ' ', $sub)) }}
                </option>
                @endforeach
            </select>
        </div>
        @endif
        <div class="filter-group filter-search">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by title..." class="filter-input">
            <button type="submit" class="filter-btn"><i data-feather="search"></i></button>
        </div>
        @if(request()->hasAny(['parent','sub','search']))
        <a href="{{ route('admin.portfolio.index') }}" class="filter-clear">
            <i data-feather="x"></i> Clear
        </a>
        @endif
    </form>
</div>

<!-- Bulk Actions -->
<form method="POST" action="{{ route('admin.portfolio.bulk-destroy') }}" id="bulkForm" onsubmit="return confirmBulk()">
    @csrf
    <div class="bulk-bar" id="bulkBar" style="display:none">
        <span id="bulkCount">0 selected</span>
        <button type="submit" class="btn btn-danger btn-sm">
            <i data-feather="trash-2"></i> Delete Selected
        </button>
        <button type="button" class="btn btn-ghost btn-sm" onclick="clearSelection()">Cancel</button>
    </div>

<!-- Portfolio Grid View -->
<div class="portfolio-admin-grid" id="portfolioAdminGrid">
    @forelse($items as $item)
    <div class="padmin-card {{ !$item->is_active ? 'hidden-item' : '' }}" data-id="{{ $item->id }}">
        <label class="padmin-select">
            <input type="checkbox" name="ids[]" value="{{ $item->id }}" class="bulk-checkbox" onchange="updateBulk()">
        </label>

        @if(!$item->is_active)
        <div class="padmin-hidden-ribbon">Hidden</div>
        @endif

        <div class="padmin-thumb">
            <img src="{{ $item->image_url }}" alt="{{ $item->title }}" loading="lazy">
            @if($item->video_url)
            <div class="padmin-video-badge"><i data-feather="play"></i></div>
            @endif
        </div>

        <div class="padmin-info">
            <div class="padmin-cats">
                <span class="cat-badge cat-{{ $item->parent_category }}">{{ $item->parent_category }}</span>
                <span class="sub-badge">{{ str_replace('-', ' ', $item->sub_category) }}</span>
                @if($item->size)
                <span class="size-badge">{{ $item->size }}</span>
                @endif
            </div>
            <h4 class="padmin-title">{{ $item->title }}</h4>
        </div>

        <div class="padmin-actions">
            <a href="{{ route('admin.portfolio.edit', $item) }}" class="padmin-btn" title="Edit">
                <i data-feather="edit-2"></i>
            </a>
            <form method="POST" action="{{ route('admin.portfolio.toggle', $item) }}" style="display:inline">
                @csrf
                <button type="submit" class="padmin-btn" title="{{ $item->is_active ? 'Hide' : 'Show' }}">
                    <i data-feather="{{ $item->is_active ? 'eye-off' : 'eye' }}"></i>
                </button>
            </form>
            <form method="POST" action="{{ route('admin.portfolio.destroy', $item) }}" style="display:inline"
                  onsubmit="return confirm('Delete {{ addslashes($item->title) }}?')">
                @csrf @method('DELETE')
                <button type="submit" class="padmin-btn danger" title="Delete">
                    <i data-feather="trash-2"></i>
                </button>
            </form>
        </div>
    </div>
    @empty
    <div class="empty-card" style="grid-column: 1/-1">
        <i data-feather="layers"></i>
        <p>No portfolio items found.</p>
        <a href="{{ route('admin.portfolio.create') }}" class="btn btn-primary">Add Your First Item</a>
    </div>
    @endforelse
</div>
</form>

<!-- Pagination -->
<div class="pagination-wrap">
    {{ $items->withQueryString()->links('admin.components.pagination') }}
</div>
@endsection

@push('scripts')
<script>
function updateBulk() {
    const checked = document.querySelectorAll('.bulk-checkbox:checked');
    const bar = document.getElementById('bulkBar');
    document.getElementById('bulkCount').textContent = checked.length + ' selected';
    bar.style.display = checked.length > 0 ? 'flex' : 'none';
}
function clearSelection() {
    document.querySelectorAll('.bulk-checkbox').forEach(c => c.checked = false);
    document.getElementById('bulkBar').style.display = 'none';
}
function confirmBulk() {
    const n = document.querySelectorAll('.bulk-checkbox:checked').length;
    return n > 0 && confirm('Permanently delete ' + n + ' items?');
}
</script>
@endpush
