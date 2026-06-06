@extends('admin.layouts.app')
@section('title', isset($client) ? 'Edit Client' : 'Add Client')
@section('breadcrumb')
    <a href="{{ route('admin.clients.index') }}">Clients</a>
    <i data-feather="chevron-right"></i>
    {{ isset($client) ? 'Edit' : 'Add Client' }}
@endsection

@section('content')
<div class="page-header">
    <h1 class="page-title">{{ isset($client) ? 'Edit: ' . $client->name : 'Add Client' }}</h1>
</div>

<div class="form-layout" style="max-width:680px">
    <form method="POST"
          action="{{ isset($client) ? route('admin.clients.update', $client) : route('admin.clients.store') }}"
          class="admin-form"
          id="clientForm">
        @csrf
        @if(isset($client)) @method('PUT') @endif

        <div class="form-card">
            <h3 class="form-section-title"><i data-feather="user"></i> Client Details</h3>

            <div class="form-group">
                <label>Client / Company Name *</label>
                <input type="text" name="name"
                       value="{{ old('name', $client->name ?? '') }}"
                       placeholder="e.g. Zanaco, Airtel Zambia" required>
                @error('name')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label>Website URL <small style="opacity:.5">(optional, makes logo a link)</small></label>
                <input type="url" name="website_url"
                       value="{{ old('website_url', $client->website_url ?? '') }}"
                       placeholder="https://example.com">
                @error('website_url')<span class="form-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Marquee Row *</label>
                    <select name="row" required>
                        <option value="1" {{ old('row', $client->row ?? 1) == 1 ? 'selected' : '' }}>Row 1 — scrolls left</option>
                        <option value="2" {{ old('row', $client->row ?? 1) == 2 ? 'selected' : '' }}>Row 2 — scrolls right (reverse)</option>
                        <option value="3" {{ old('row', $client->row ?? 1) == 3 ? 'selected' : '' }}>Row 3 — scrolls left</option>
                    </select>
                    <small>Controls which of the 3 marquee rows this client appears in.</small>
                    @error('row')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label>Sort Order</label>
                    <input type="number" name="sort_order"
                           value="{{ old('sort_order', $client->sort_order ?? 0) }}" min="0">
                    <small>Lower numbers appear first within the row.</small>
                </div>
            </div>

            <div class="form-group">
                <label class="toggle-label">
                    <input type="hidden"   name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1"
                           {{ old('is_active', $client->is_active ?? true) ? 'checked' : '' }}>
                    <span class="toggle-switch"></span>
                    Active (visible in marquee)
                </label>
            </div>
        </div>

        <div class="form-card">
            <h3 class="form-section-title"><i data-feather="image"></i> Logo Image</h3>

            <div class="image-preview-box" id="logoPreview" style="height:120px;background:#111">
                @if(isset($client) && $client->logo_url)
                <img src="{{ $client->logo_url }}" alt="{{ $client->name }}"
                     style="width:100%;height:100%;object-fit:contain;padding:12px">
                @else
                <div class="image-placeholder">
                    <i data-feather="image"></i>
                    <span>Logo preview</span>
                </div>
                @endif
            </div>

            <div class="form-group mt">
                <label>Logo URL</label>
                <input type="url" name="logo_url"
                       value="{{ old('logo_url', $client->logo_url ?? '') }}"
                       placeholder="https://..."
                       oninput="previewLogo(this)">
                <small>Use a PNG or SVG with transparent background for best results. Recommended size: 300×120px.</small>
                @error('logo_url')<span class="form-error">{{ $message }}</span>@enderror
            </div>
        </div>
    </form>
</div>

<div class="form-actions sticky-actions">
    <a href="{{ route('admin.clients.index') }}" class="btn btn-ghost">Cancel</a>
    <button form="clientForm" type="submit" class="btn btn-primary">
        <i data-feather="save"></i> {{ isset($client) ? 'Update Client' : 'Add Client' }}
    </button>
</div>
@endsection

@push('scripts')
<script>
function previewLogo(input) {
    const box = document.getElementById('logoPreview');
    if (input.value) {
        box.innerHTML = `<img src="${input.value}" alt="Preview" style="width:100%;height:100%;object-fit:contain;padding:12px">`;
    }
}
</script>
@endpush
