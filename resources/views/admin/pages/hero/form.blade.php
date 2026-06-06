@extends('admin.layouts.app')
@section('title', isset($slide) ? 'Edit Slide' : 'Add Slide')
@section('breadcrumb')
    <a href="{{ route('admin.hero.index') }}">Hero Slides</a>
    <i data-feather="chevron-right"></i>
    {{ isset($slide) ? 'Edit' : 'Add' }}
@endsection

@section('content')
<div class="page-header">
    <h1 class="page-title">{{ isset($slide) ? 'Edit Hero Slide' : 'Add Hero Slide' }}</h1>
</div>

<div class="form-layout">
    <form method="POST"
          action="{{ isset($slide) ? route('admin.hero.update', $slide) : route('admin.hero.store') }}"
          enctype="multipart/form-data"
          class="admin-form">
        @csrf
        @if(isset($slide)) @method('PUT') @endif

        <div class="form-card">
            <h3 class="form-section-title"><i data-feather="image"></i> Slide Image</h3>

            <!-- Image Preview -->
            <div class="image-preview-box" id="imagePreview">
                @if(isset($slide) && $slide->image_url)
                <img src="{{ $slide->image_url }}" alt="Current" id="previewImg">
                @else
                <div class="image-placeholder" id="imagePlaceholder">
                    <i data-feather="upload-cloud"></i>
                    <span>Upload image or enter URL below</span>
                </div>
                @endif
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Upload Image File</label>
                    <input type="file" name="image_file" accept="image/*" id="imageFile" onchange="previewFile(this)">
                    <small>Max 8MB. JPG, PNG, WebP recommended. Ideal: 1600×900px</small>
                </div>
                <div class="form-group">
                    <label>Or Image URL</label>
                    <input type="url" name="image_url" value="{{ old('image_url', $slide->image_url ?? '') }}"
                           placeholder="https://..." id="imageUrl" oninput="previewUrl(this)">
                    @error('image_url')<span class="form-error">{{ $message }}</span>@enderror
                </div>
            </div>

            <h3 class="form-section-title mt"><i data-feather="type"></i> Overlay Text (Optional)</h3>
            <div class="form-group">
                <label>Heading</label>
                <input type="text" name="heading" value="{{ old('heading', $slide->heading ?? '') }}"
                       placeholder="We Don't Just Capture Moments">
            </div>
            <div class="form-group">
                <label>Subheading</label>
                <input type="text" name="subheading" value="{{ old('subheading', $slide->subheading ?? '') }}"
                       placeholder="We Craft Legacies.">
            </div>

            <h3 class="form-section-title mt"><i data-feather="settings"></i> Settings</h3>
            <div class="form-row">
                <div class="form-group">
                    <label>Sort Order</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $slide->sort_order ?? 0) }}" min="0">
                </div>
                <div class="form-group">
                    <label class="toggle-label">
                        <input type="hidden"   name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1"
                               {{ old('is_active', $slide->is_active ?? true) ? 'checked' : '' }}>
                        <span class="toggle-switch"></span>
                        Active (visible on site)
                    </label>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.hero.index') }}" class="btn btn-ghost">Cancel</a>
            <button type="submit" class="btn btn-primary">
                <i data-feather="save"></i> {{ isset($slide) ? 'Update Slide' : 'Add Slide' }}
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
function previewFile(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => showPreview(e.target.result);
        reader.readAsDataURL(input.files[0]);
    }
}
function previewUrl(input) {
    if (input.value) showPreview(input.value);
}
function showPreview(src) {
    const box = document.getElementById('imagePreview');
    box.innerHTML = `<img src="${src}" alt="Preview" id="previewImg" style="width:100%;height:100%;object-fit:cover">`;
}
</script>
@endpush
