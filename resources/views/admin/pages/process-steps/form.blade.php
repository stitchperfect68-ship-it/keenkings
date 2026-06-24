@extends('admin.layouts.app')
@section('title', isset($step) ? 'Edit Step' : 'Add Step')
@section('breadcrumb')
    <a href="{{ route('admin.process-steps.index') }}">Process Steps</a>
    <i data-feather="chevron-right"></i>
    {{ isset($step) ? 'Edit' : 'Add' }}
@endsection

@section('content')
<div class="page-header">
    <h1 class="page-title">{{ isset($step) ? 'Edit Step' : 'Add Step' }}</h1>
</div>

<div class="form-layout">
    <form method="POST"
          action="{{ isset($step) ? route('admin.process-steps.update', $step) : route('admin.process-steps.store') }}"
          class="admin-form">
        @csrf
        @if(isset($step)) @method('PUT') @endif

        <div class="form-card">
            <h3 class="form-section-title"><i data-feather="git-pull-request"></i> Step Details</h3>

            <div class="form-group">
                <label>Step Title *</label>
                <input type="text" name="title"
                       value="{{ old('title', $step->title ?? '') }}"
                       required maxlength="100"
                       placeholder="e.g. Discovery Call">
                @error('title')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label>Description *</label>
                <textarea name="description" rows="5" required maxlength="1000"
                          placeholder="Describe what happens in this step...">{{ old('description', $step->description ?? '') }}</textarea>
                @error('description')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Sort Order</label>
                    <input type="number" name="sort_order"
                           value="{{ old('sort_order', $step->sort_order ?? 0) }}" min="0">
                </div>
                <div class="form-group" style="align-self:flex-end">
                    <label class="toggle-label">
                        <input type="hidden"   name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1"
                               {{ old('is_active', $step->is_active ?? true) ? 'checked' : '' }}>
                        <span class="toggle-switch"></span>
                        Active
                    </label>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.process-steps.index') }}" class="btn btn-ghost">Cancel</a>
            <button type="submit" class="btn btn-primary">
                <i data-feather="save"></i> {{ isset($step) ? 'Update Step' : 'Add Step' }}
            </button>
        </div>
    </form>
</div>
@endsection
