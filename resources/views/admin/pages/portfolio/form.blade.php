@extends('admin.layouts.app')
@section('title', isset($item) ? 'Edit Item' : 'Add Portfolio Item')
@section('breadcrumb')
    <a href="{{ route('admin.portfolio.index') }}">Portfolio</a>
    <i data-feather="chevron-right"></i>
    {{ isset($item) ? 'Edit' : 'Add Item' }}
@endsection

@section('content')
<div class="page-header">
    <h1 class="page-title">{{ isset($item) ? 'Edit: ' . $item->title : 'Add Portfolio Item' }}</h1>
</div>

<div class="form-layout form-layout-2col">
    <form method="POST"
          action="{{ isset($item) ? route('admin.portfolio.update', $item) : route('admin.portfolio.store') }}"
          enctype="multipart/form-data"
          class="admin-form"
          id="portfolioForm">
        @csrf
        @if(isset($item)) @method('PUT') @endif

        <!-- Left Column -->
        <div class="form-col">
            <div class="form-card">
                <h3 class="form-section-title"><i data-feather="folder"></i> Category</h3>
                <div class="form-group">
                    <label>Parent Category *</label>
                    <select name="parent_category" id="parentCat" required onchange="updateSubCats(this.value)">
                        <option value="">Select category</option>
                        @foreach($parentCats as $cat)
                        <option value="{{ $cat }}" {{ old('parent_category', $item->parent_category ?? '') === $cat ? 'selected' : '' }}>
                            {{ ucfirst($cat) }}
                        </option>
                        @endforeach
                    </select>
                    @error('parent_category')<span class="form-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label>Sub-Category *</label>
                    <select name="sub_category" id="subCat" required>
                        <option value="">Select parent first</option>
                    </select>
                    @error('sub_category')<span class="form-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label>Grid Size</label>
                    <div class="size-picker" id="sizePicker">
                        @foreach($sizes as $val => $label)
                        <label class="size-option {{ old('size', $item->size ?? '') === $val ? 'active' : '' }}">
                            <input type="radio" name="size" value="{{ $val }}"
                                   {{ old('size', $item->size ?? '') === $val ? 'checked' : '' }}>
                            <span class="size-box size-{{ $val ?: 'square' }}"></span>
                            <span>{{ $label }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="form-card">
                <h3 class="form-section-title"><i data-feather="settings"></i> Settings</h3>
                <div class="form-group">
                    <label>Sort Order</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $item->sort_order ?? 0) }}" min="0">
                </div>
                <div class="form-group">
                    <label class="toggle-label">
                        <input type="hidden"   name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1"
                               {{ old('is_active', $item->is_active ?? true) ? 'checked' : '' }}>
                        <span class="toggle-switch"></span>
                        Active (visible on site)
                    </label>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="form-col">
            <div class="form-card">
                <h3 class="form-section-title"><i data-feather="edit-3"></i> Details</h3>
                <div class="form-group">
                    <label>Title *</label>
                    <input type="text" name="title" value="{{ old('title', $item->title ?? '') }}"
                           placeholder="e.g. UNZA Graduation 2023" required>
                    @error('title')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label>Description (optional)</label>
                    <textarea name="description" rows="3" placeholder="Brief description...">{{ old('description', $item->description ?? '') }}</textarea>
                </div>
            </div>

            <div class="form-card">
                <h3 class="form-section-title"><i data-feather="image"></i> Cover Image</h3>

                <div class="image-preview-box" id="imagePreview" style="height:220px">
                    @if(isset($item) && $item->image_url)
                    <img src="{{ $item->image_url }}" alt="Current" style="width:100%;height:100%;object-fit:cover">
                    @else
                    <div class="image-placeholder">
                        <i data-feather="upload-cloud"></i>
                        <span>Upload or enter URL</span>
                    </div>
                    @endif
                </div>

                <div class="form-row mt">
                    <div class="form-group">
                        <label>Upload Image</label>
                        <input type="file" name="image_file" accept="image/*" onchange="previewFile(this)">
                        <small>Max 5MB</small>
                    </div>
                    <div class="form-group">
                        <label>Or Image URL *</label>
                        <input type="url" name="image_url" value="{{ old('image_url', $item->image_url ?? '') }}"
                               placeholder="https://..." oninput="previewUrl(this)">
                        @error('image_url')<span class="form-error">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            <div class="form-card">
                <h3 class="form-section-title"><i data-feather="video"></i> Video (Videography only)</h3>
                <div class="form-group">
                    <label>Video Embed URL</label>
                    <input type="url" name="video_url" value="{{ old('video_url', $item->video_url ?? '') }}"
                           placeholder="https://www.youtube.com/embed/...">
                    <small>Use YouTube embed URL format: youtube.com/embed/VIDEO_ID</small>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="form-actions sticky-actions">
    <a href="{{ route('admin.portfolio.index') }}" class="btn btn-ghost">Cancel</a>
    <button form="portfolioForm" type="submit" class="btn btn-primary">
        <i data-feather="save"></i> {{ isset($item) ? 'Update Item' : 'Add to Portfolio' }}
    </button>
</div>
@endsection

@push('scripts')
<script>
const SUB_CATS = @json($subCats);
const currentSub = '{{ old('sub_category', $item->sub_category ?? '') }}';

function updateSubCats(parent) {
    const sel = document.getElementById('subCat');
    sel.innerHTML = '<option value="">Select sub-category</option>';
    if (!parent || !SUB_CATS[parent]) return;
    SUB_CATS[parent].forEach(sub => {
        const opt = document.createElement('option');
        opt.value = sub;
        opt.textContent = sub.split('-').map(w => w[0].toUpperCase() + w.slice(1)).join(' ');
        if (sub === currentSub) opt.selected = true;
        sel.appendChild(opt);
    });
}

// Init on load
const parentVal = document.getElementById('parentCat').value;
if (parentVal) updateSubCats(parentVal);

// Size picker visual
document.querySelectorAll('.size-option input').forEach(input => {
    input.addEventListener('change', () => {
        document.querySelectorAll('.size-option').forEach(o => o.classList.remove('active'));
        input.closest('.size-option').classList.add('active');
    });
});

function previewFile(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => showPreview(e.target.result);
        reader.readAsDataURL(input.files[0]);
    }
}
function previewUrl(input) { if (input.value) showPreview(input.value); }
function showPreview(src) {
    document.getElementById('imagePreview').innerHTML =
        `<img src="${src}" alt="Preview" style="width:100%;height:100%;object-fit:cover">`;
}
</script>
@endpush
