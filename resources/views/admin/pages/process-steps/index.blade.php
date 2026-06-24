@extends('admin.layouts.app')
@section('title', 'Process Steps')
@section('breadcrumb', 'Process Steps')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Process Steps</h1>
        <p class="page-sub">Manage the steps shown in the "How It Works" section.</p>
    </div>
    <a href="{{ route('admin.process-steps.create') }}" class="btn btn-primary">
        <i data-feather="plus"></i> Add Step
    </a>
</div>

<div class="list-cards">
    @forelse($steps as $i => $step)
    <div class="list-card {{ !$step->is_active ? 'inactive' : '' }}">
        <div class="list-card-icon" style="font-size:18px; font-weight:700; font-family:var(--font-serif); color:var(--accent);">
            {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}
        </div>
        <div class="list-card-body">
            <h4>{{ $step->title }}</h4>
            <p>{{ Str::limit($step->description, 120) }}</p>
        </div>
        <div class="list-card-actions">
            <span class="status-dot {{ $step->is_active ? 'active' : 'inactive' }}"></span>
            <a href="{{ route('admin.process-steps.edit', $step) }}" class="action-btn" title="Edit">
                <i data-feather="edit-2"></i>
            </a>
            <form method="POST" action="{{ route('admin.process-steps.destroy', $step) }}"
                  onsubmit="return confirm('Delete \'{{ addslashes($step->title) }}\'?')">
                @csrf @method('DELETE')
                <button class="action-btn danger" title="Delete"><i data-feather="trash-2"></i></button>
            </form>
        </div>
    </div>
    @empty
    <div class="empty-card">
        <i data-feather="git-pull-request"></i>
        <p>No process steps yet.</p>
        <a href="{{ route('admin.process-steps.create') }}" class="btn btn-primary">Add First Step</a>
    </div>
    @endforelse
</div>

<p style="font-size:12px; opacity:.5; margin-top:16px;">
    Steps are displayed on the website in sort-order order. Edit the section heading (tag &amp; title) under
    <a href="{{ route('admin.page-content.index') }}">Page Content → Home Sections</a>.
</p>
@endsection
