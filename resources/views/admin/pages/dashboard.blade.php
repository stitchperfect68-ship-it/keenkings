@extends('admin.layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Dashboard</h1>
        <p class="page-sub">Welcome back — here's an overview of your site content.</p>
    </div>
    <a href="{{ route('admin.portfolio.create') }}" class="btn btn-primary">
        <i data-feather="plus"></i> Add Portfolio Item
    </a>
</div>

<!-- Stats Row -->
<div class="stats-row">
    <div class="stat-card">
        <div class="stat-icon" style="--c: #C9A84C">
            <i data-feather="layers"></i>
        </div>
        <div>
            <div class="stat-val">{{ $stats['portfolio'] }}</div>
            <div class="stat-lbl">Portfolio Items</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="--c: #4CAF50">
            <i data-feather="eye"></i>
        </div>
        <div>
            <div class="stat-val">{{ $stats['active'] }}</div>
            <div class="stat-lbl">Active Items</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="--c: #2196F3">
            <i data-feather="mail"></i>
        </div>
        <div>
            <div class="stat-val">{{ $stats['enquiries'] }}</div>
            <div class="stat-lbl">Total Enquiries</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="--c: #FF5722">
            <i data-feather="bell"></i>
        </div>
        <div>
            <div class="stat-val">{{ $stats['new_enquiries'] }}</div>
            <div class="stat-lbl">New Enquiries</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="--c: #9C27B0">
            <i data-feather="image"></i>
        </div>
        <div>
            <div class="stat-val">{{ $stats['hero_slides'] }}</div>
            <div class="stat-lbl">Hero Slides</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="--c: #00BCD4">
            <i data-feather="briefcase"></i>
        </div>
        <div>
            <div class="stat-val">{{ $stats['services'] }}</div>
            <div class="stat-lbl">Services</div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="quick-actions-bar">
    <span>Quick Actions:</span>
    <a href="{{ route('admin.hero.create') }}"        class="qa-btn"><i data-feather="image"></i> Add Hero Slide</a>
    <a href="{{ route('admin.portfolio.create') }}"  class="qa-btn"><i data-feather="plus-circle"></i> Add Portfolio Item</a>
    <a href="{{ route('admin.testimonials.create') }}" class="qa-btn"><i data-feather="message-square"></i> Add Testimonial</a>
    <a href="{{ route('admin.services.create') }}"   class="qa-btn"><i data-feather="briefcase"></i> Add Service</a>
    <a href="{{ route('home') }}" target="_blank"    class="qa-btn"><i data-feather="external-link"></i> View Site</a>
</div>

<div class="dashboard-grid">
    <!-- Recent Portfolio -->
    <div class="dash-card">
        <div class="dash-card-header">
            <h3><i data-feather="layers"></i> Recent Portfolio Items</h3>
            <a href="{{ route('admin.portfolio.index') }}">View all</a>
        </div>
        <div class="portfolio-mini-grid">
            @forelse($recentPortfolio as $item)
            <div class="portfolio-mini-item {{ !$item->is_active ? 'inactive' : '' }}">
                <img src="{{ $item->image_url }}" alt="{{ $item->title }}" loading="lazy">
                <div class="mini-overlay">
                    <span class="mini-cat">{{ $item->parent_category }}</span>
                    <span class="mini-title">{{ Str::limit($item->title, 25) }}</span>
                    <div class="mini-actions">
                        <a href="{{ route('admin.portfolio.edit', $item) }}" title="Edit"><i data-feather="edit-2"></i></a>
                        <form method="POST" action="{{ route('admin.portfolio.toggle', $item) }}" style="display:inline">
                            @csrf
                            <button title="{{ $item->is_active ? 'Hide' : 'Show' }}">
                                <i data-feather="{{ $item->is_active ? 'eye-off' : 'eye' }}"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <p class="empty-state">No portfolio items yet.</p>
            @endforelse
        </div>
    </div>

    <!-- Recent Enquiries -->
    <div class="dash-card">
        <div class="dash-card-header">
            <h3><i data-feather="mail"></i> Recent Enquiries</h3>
            <a href="{{ route('admin.enquiries.index') }}">View all</a>
        </div>
        <div class="enquiries-list">
            @forelse($recentEnquiries as $enq)
            <a href="{{ route('admin.enquiries.show', $enq) }}" class="enquiry-row {{ $enq->status === 'new' ? 'unread' : '' }}">
                <div class="enq-avatar">{{ strtoupper(substr($enq->name, 0, 1)) }}</div>
                <div class="enq-info">
                    <strong>{{ $enq->name }}</strong>
                    <span>{{ $enq->service ?? 'General enquiry' }}</span>
                </div>
                <div class="enq-meta">
                    <span class="enq-status status-{{ $enq->status }}">{{ $enq->status }}</span>
                    <time>{{ $enq->created_at->diffForHumans() }}</time>
                </div>
            </a>
            @empty
            <p class="empty-state">No enquiries yet.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
