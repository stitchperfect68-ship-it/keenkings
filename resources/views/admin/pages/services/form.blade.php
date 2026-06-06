@extends('admin.layouts.app')
@section('title', isset($service) ? 'Edit Service' : 'Add Service')
@section('breadcrumb')
    <a href="{{ route('admin.services.index') }}">Services</a>
    <i data-feather="chevron-right"></i>
    {{ isset($service) ? 'Edit' : 'Add' }}
@endsection

@section('content')
<div class="page-header">
    <h1 class="page-title">{{ isset($service) ? 'Edit Service' : 'Add Service' }}</h1>
</div>

<div class="form-layout">
    <form method="POST"
          action="{{ isset($service) ? route('admin.services.update', $service) : route('admin.services.store') }}"
          class="admin-form">
        @csrf
        @if(isset($service)) @method('PUT') @endif

        <div class="form-card">
            <h3 class="form-section-title"><i data-feather="briefcase"></i> Service Details</h3>

            <div class="form-row">
                <div class="form-group">
                    <label>Icon (Feather icon name) *</label>
                    <div class="icon-picker-wrap">
                        <select name="icon" id="iconSelect" required onchange="updateIconPreview(this.value)">
                            @foreach($icons as $icon)
                            <option value="{{ $icon }}" {{ old('icon', $service->icon ?? '') === $icon ? 'selected' : '' }}>
                                {{ $icon }}
                            </option>
                            @endforeach
                        </select>
                        <div class="icon-preview" id="iconPreview">
                            <i data-feather="{{ old('icon', $service->icon ?? $icons[0]) }}"></i>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Title *</label>
                    <input type="text" name="title" value="{{ old('title', $service->title ?? '') }}" required maxlength="100">
                    @error('title')<span class="form-error">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="form-group">
                <label>Description *</label>
                <textarea name="description" rows="3" required maxlength="500">{{ old('description', $service->description ?? '') }}</textarea>
            </div>

            <div class="form-group">
                <label>Service Items <small>(one per line)</small></label>
                <textarea name="items" rows="5" placeholder="Portrait & Headshots&#10;Wedding Photography&#10;Corporate Events">{{ old('items', isset($service) ? implode("\n", $service->items ?? []) : '') }}</textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Sort Order</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $service->sort_order ?? 0) }}" min="0">
                </div>
                <div class="form-group" style="align-self:flex-end">
                    <label class="toggle-label">
                        <input type="hidden"   name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1"
                               {{ old('is_active', $service->is_active ?? true) ? 'checked' : '' }}>
                        <span class="toggle-switch"></span>
                        Active
                    </label>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.services.index') }}" class="btn btn-ghost">Cancel</a>
            <button type="submit" class="btn btn-primary">
                <i data-feather="save"></i> {{ isset($service) ? 'Update Service' : 'Add Service' }}
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
function updateIconPreview(val) {
    document.getElementById('iconPreview').innerHTML = `<i data-feather="${val}"></i>`;
    feather.replace();
}
</script>
@endpush
