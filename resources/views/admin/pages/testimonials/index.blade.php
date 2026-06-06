@extends('admin.layouts.app')
@section('title', 'Testimonials')
@section('breadcrumb', 'Testimonials')

@section('content')
<div class="page-header">
    <div><h1 class="page-title">Testimonials</h1></div>
    <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary">
        <i data-feather="plus"></i> Add Testimonial
    </a>
</div>

<div class="testimonials-admin-grid">
    @forelse($testimonials as $t)
    <div class="testimonial-admin-card {{ !$t->is_active ? 'inactive' : '' }}">
        <div class="tac-header">
            <div class="tac-avatar">{{ strtoupper(substr($t->name, 0, 1)) }}</div>
            <div>
                <strong>{{ $t->name }}</strong>
                <span>{{ $t->role }}</span>
            </div>
            <span class="status-dot {{ $t->is_active ? 'active' : 'inactive' }}" style="margin-left:auto"></span>
        </div>
        <p class="tac-quote">"{{ Str::limit($t->quote, 120) }}"</p>
        <div class="tac-actions">
            <a href="{{ route('admin.testimonials.edit', $t) }}" class="action-btn">
                <i data-feather="edit-2"></i> Edit
            </a>
            <form method="POST" action="{{ route('admin.testimonials.destroy', $t) }}"
                  onsubmit="return confirm('Delete this testimonial?')">
                @csrf @method('DELETE')
                <button class="action-btn danger"><i data-feather="trash-2"></i> Delete</button>
            </form>
        </div>
    </div>
    @empty
    <div class="empty-card" style="grid-column:1/-1">
        <i data-feather="message-square"></i>
        <p>No testimonials yet.</p>
        <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary">Add First Testimonial</a>
    </div>
    @endforelse
</div>
@endsection
