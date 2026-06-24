@extends('admin.layouts.app')
@section('title', 'Footer')
@section('breadcrumb', 'Footer')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Footer</h1>
        <p class="page-sub">Edit footer text and manage social media links.</p>
    </div>
</div>

<div class="tabs-nav" id="footerTabs">
    <button class="tab-btn active" data-tab="footer-text">Footer Text</button>
    <button class="tab-btn" data-tab="social-links">Social Links</button>
</div>

{{-- ── TAB: Footer Text ── --}}
<div class="tab-panel active" id="tab-footer-text">
    <form method="POST" action="{{ route('admin.footer.update') }}" class="admin-form">
        @csrf @method('PUT')

        <div class="form-card">
            <h3 class="form-section-title"><i data-feather="align-left"></i> Brand Description</h3>
            <div class="form-group">
                <label>Description (shown under logo in footer)</label>
                <textarea name="footer_description" rows="4">{{ old('footer_description', $settings->footer_description) }}</textarea>
            </div>
        </div>

        <div class="form-card">
            <h3 class="form-section-title"><i data-feather="copyright"></i> Copyright</h3>
            <div class="form-group">
                <label>Copyright Text <small style="opacity:.6;">(year is added automatically)</small></label>
                <input type="text" name="footer_copyright" value="{{ old('footer_copyright', $settings->footer_copyright) }}" maxlength="200" placeholder="Keenkings Media. All rights reserved.">
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><i data-feather="save"></i> Save Footer Text</button>
        </div>
    </form>
</div>

{{-- ── TAB: Social Links ── --}}
<div class="tab-panel" id="tab-social-links">
    <div class="form-card">
        <h3 class="form-section-title"><i data-feather="share-2"></i> Social Media Links</h3>
        <div class="stats-admin-list">
            @forelse($socialLinks as $link)
            <form method="POST" action="{{ route('admin.footer.social.update', $link) }}" class="stat-edit-row">
                @csrf @method('PUT')
                <input type="text" name="platform" value="{{ $link->platform }}" placeholder="instagram" class="stat-val-input" required title="Platform identifier (e.g. instagram)">
                <input type="text" name="label" value="{{ $link->label }}" placeholder="Instagram" class="stat-lbl-input" required title="Display label">
                <input type="url" name="url" value="{{ $link->url }}" placeholder="https://instagram.com/..." style="flex:2; min-width:180px; padding:8px 12px; background:var(--input-bg); border:1px solid var(--border-dark); border-radius:6px; color:var(--text-primary); font-size:13px;" required>
                <label class="toggle-label small">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" {{ $link->is_active ? 'checked' : '' }}>
                    <span class="toggle-switch"></span>
                </label>
                <button type="submit" class="action-btn" title="Save"><i data-feather="save"></i></button>
                <a href="{{ route('admin.footer.social.destroy', $link) }}"
                   onclick="event.preventDefault(); if(confirm('Delete this social link?')) { document.getElementById('del-social-{{ $link->id }}').submit(); }"
                   class="action-btn danger" title="Delete"><i data-feather="trash-2"></i></a>
                <form id="del-social-{{ $link->id }}" method="POST" action="{{ route('admin.footer.social.destroy', $link) }}" style="display:none">
                    @csrf @method('DELETE')
                </form>
            </form>
            @empty
            <p class="empty-state">No social links yet. Add one below.</p>
            @endforelse
        </div>
        <p style="font-size:11px; opacity:.5; margin-top:12px;">Platform is used for the short label shown next to the icon (e.g. "ig", "fb", "yt"). Label is the full name shown in the Connect column.</p>
    </div>

    <div class="form-card">
        <h3 class="form-section-title"><i data-feather="plus-circle"></i> Add Social Link</h3>
        <form method="POST" action="{{ route('admin.footer.social.store') }}" class="admin-form">
            @csrf
            <div class="form-row">
                <div class="form-group">
                    <label>Platform <small style="opacity:.6;">(short label, e.g. ig)</small></label>
                    <input type="text" name="platform" placeholder="ig" required maxlength="50">
                </div>
                <div class="form-group">
                    <label>Label <small style="opacity:.6;">(full name, e.g. Instagram)</small></label>
                    <input type="text" name="label" placeholder="Instagram" required maxlength="100">
                </div>
                <div class="form-group">
                    <label>URL</label>
                    <input type="url" name="url" placeholder="https://instagram.com/keenkings" required maxlength="500">
                </div>
                <div class="form-group" style="align-self:flex-end">
                    <button type="submit" class="btn btn-primary" style="width:100%"><i data-feather="plus"></i> Add</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.querySelectorAll('#footerTabs .tab-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('#footerTabs .tab-btn, .tab-panel').forEach(el => el.classList.remove('active'));
        btn.classList.add('active');
        document.getElementById('tab-' + btn.dataset.tab).classList.add('active');
    });
});
</script>
@endpush
