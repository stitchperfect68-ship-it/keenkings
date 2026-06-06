@extends('admin.layouts.app')
@section('title', 'Services')
@section('breadcrumb', 'Services')

@section('content')
<div class="page-header">
    <div><h1 class="page-title">Services</h1></div>
    <a href="{{ route('admin.services.create') }}" class="btn btn-primary">
        <i data-feather="plus"></i> Add Service
    </a>
</div>

<div class="list-cards">
    @forelse($services as $service)
    <div class="list-card {{ !$service->is_active ? 'inactive' : '' }}">
        <div class="list-card-icon">
            <i data-feather="{{ $service->icon }}"></i>
        </div>
        <div class="list-card-body">
            <h4>{{ $service->title }}</h4>
            <p>{{ Str::limit($service->description, 100) }}</p>
            @if($service->items)
            <div class="tag-list">
                @foreach($service->items as $item)
                <span class="tag">{{ $item }}</span>
                @endforeach
            </div>
            @endif
        </div>
        <div class="list-card-actions">
            <span class="status-dot {{ $service->is_active ? 'active' : 'inactive' }}"></span>
            <a href="{{ route('admin.services.edit', $service) }}" class="action-btn">
                <i data-feather="edit-2"></i>
            </a>
            <form method="POST" action="{{ route('admin.services.destroy', $service) }}"
                  onsubmit="return confirm('Delete {{ addslashes($service->title) }}?')">
                @csrf @method('DELETE')
                <button class="action-btn danger"><i data-feather="trash-2"></i></button>
            </form>
        </div>
    </div>
    @empty
    <div class="empty-card">
        <i data-feather="briefcase"></i>
        <p>No services yet.</p>
        <a href="{{ route('admin.services.create') }}" class="btn btn-primary">Add Service</a>
    </div>
    @endforelse
</div>
@endsection
