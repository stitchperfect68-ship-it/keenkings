@extends('admin.layouts.app')
@section('title', 'Our Team')
@section('breadcrumb', 'Our Team')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Our Team</h1>
        <p class="page-sub">Manage team members shown on the home page.</p>
    </div>
    <a href="{{ route('admin.team.create') }}" class="btn btn-primary">
        <i data-feather="user-plus"></i> Add Member
    </a>
</div>

<div class="list-cards">
    @forelse($members as $member)
    <div class="list-card {{ !$member->is_active ? 'inactive' : '' }}">
        <div class="list-card-icon" style="padding:0;overflow:hidden;width:52px;height:52px;border-radius:50%;flex-shrink:0;">
            @if($member->image_url)
            <img src="{{ $member->image_url }}" alt="{{ $member->name }}"
                 style="width:100%;height:100%;object-fit:cover;">
            @else
            <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:var(--surface-2);font-size:20px;font-weight:600;color:var(--gold);">
                {{ strtoupper(substr($member->name, 0, 1)) }}
            </div>
            @endif
        </div>
        <div class="list-card-body">
            <h4>{{ $member->name }}</h4>
            <p style="color:var(--gold);font-size:12px;margin-bottom:4px;">{{ $member->role }}</p>
            @if($member->bio)
            <p>{{ Str::limit($member->bio, 90) }}</p>
            @endif
        </div>
        <div class="list-card-actions">
            <span class="status-dot {{ $member->is_active ? 'active' : 'inactive' }}"></span>
            <a href="{{ route('admin.team.edit', $member) }}" class="action-btn">
                <i data-feather="edit-2"></i>
            </a>
            <form method="POST" action="{{ route('admin.team.destroy', $member) }}"
                  onsubmit="return confirm('Delete {{ addslashes($member->name) }}?')">
                @csrf @method('DELETE')
                <button class="action-btn danger"><i data-feather="trash-2"></i></button>
            </form>
        </div>
    </div>
    @empty
    <div class="empty-card">
        <i data-feather="users"></i>
        <p>No team members yet.</p>
        <a href="{{ route('admin.team.create') }}" class="btn btn-primary">Add Member</a>
    </div>
    @endforelse
</div>
@endsection
