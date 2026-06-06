@extends('admin.layouts.app')
@section('title', isset($testimonial) ? 'Edit Testimonial' : 'Add Testimonial')
@section('breadcrumb')
    <a href="{{ route('admin.testimonials.index') }}">Testimonials</a>
    <i data-feather="chevron-right"></i>
    {{ isset($testimonial) ? 'Edit' : 'Add' }}
@endsection

@section('content')
<div class="page-header">
    <h1 class="page-title">{{ isset($testimonial) ? 'Edit Testimonial' : 'Add Testimonial' }}</h1>
</div>

<div class="form-layout" style="max-width:700px">
    <form method="POST"
          action="{{ isset($testimonial) ? route('admin.testimonials.update', $testimonial) : route('admin.testimonials.store') }}"
          class="admin-form">
        @csrf
        @if(isset($testimonial)) @method('PUT') @endif

        <div class="form-card">
            <div class="form-row">
                <div class="form-group">
                    <label>Client Name *</label>
                    <input type="text" name="name" value="{{ old('name', $testimonial->name ?? '') }}" required>
                </div>
                <div class="form-group">
                    <label>Role / Title *</label>
                    <input type="text" name="role" value="{{ old('role', $testimonial->role ?? '') }}"
                           placeholder="CEO, Apex Ventures" required>
                </div>
            </div>
            <div class="form-group">
                <label>Quote *</label>
                <textarea name="quote" rows="4" required maxlength="600">{{ old('quote', $testimonial->quote ?? '') }}</textarea>
                <small>Max 600 characters</small>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Sort Order</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $testimonial->sort_order ?? 0) }}">
                </div>
                <div class="form-group" style="align-self:flex-end">
                    <label class="toggle-label">
                        <input type="hidden"   name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1"
                               {{ old('is_active', $testimonial->is_active ?? true) ? 'checked' : '' }}>
                        <span class="toggle-switch"></span>
                        Active
                    </label>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.testimonials.index') }}" class="btn btn-ghost">Cancel</a>
            <button type="submit" class="btn btn-primary">
                <i data-feather="save"></i> {{ isset($testimonial) ? 'Update' : 'Add Testimonial' }}
            </button>
        </div>
    </form>
</div>
@endsection
