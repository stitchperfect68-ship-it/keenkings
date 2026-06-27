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

@if ($errors->any())
<div class="alert alert-error" style="margin-bottom:20px;">
    <i data-feather="alert-circle"></i>
    <div>
        <strong>Please fix the following:</strong>
        <ul style="margin:6px 0 0 16px; padding:0;">
            @foreach ($errors->all() as $error)
            <li style="font-size:13px;">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif

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

    {{-- Existing links — each row is its own independent form --}}
    @if($socialLinks->isNotEmpty())
    <div class="form-card">
        <h3 class="form-section-title"><i data-feather="share-2"></i> Existing Social Links</h3>
        <p style="font-size:12px;opacity:.55;margin-bottom:16px;">Icon: choose the platform icon. Short Label: small text beside icon (e.g. "ig"). Display Name: shown in the Connect column.</p>

        @foreach($socialLinks as $link)
        {{-- EDIT form — standalone, no nesting --}}
        <form method="POST" action="{{ route('admin.footer.social.update', $link) }}" class="stat-edit-row" style="align-items:center; flex-wrap:wrap; gap:8px; margin-bottom:10px; padding-bottom:10px; border-bottom:1px solid var(--border-dark);">
            @csrf @method('PUT')

            {{-- Icon picker --}}
            <select name="icon" title="Platform icon" style="padding:8px 10px; background:var(--input-bg); border:1px solid var(--border-dark); border-radius:6px; color:var(--text-primary); font-size:13px; flex-shrink:0;">
                <option value="">— icon —</option>
                @php $icons = ['instagram'=>'Instagram','facebook'=>'Facebook','twitter'=>'Twitter / X','youtube'=>'YouTube','linkedin'=>'LinkedIn','tiktok'=>'TikTok','whatsapp'=>'WhatsApp','github'=>'GitHub','globe'=>'Website','mail'=>'Email','link'=>'Other']; @endphp
                @foreach($icons as $val => $lbl)
                <option value="{{ $val }}" {{ ($link->icon ?? '') === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                @endforeach
            </select>

            <input type="text" name="platform" value="{{ $link->platform }}" placeholder="ig" title="Short label (e.g. ig)" style="width:64px; flex-shrink:0; padding:8px 10px; background:var(--input-bg); border:1px solid var(--border-dark); border-radius:6px; color:var(--text-primary); font-size:13px;" required maxlength="50">

            <input type="text" name="label" value="{{ $link->label }}" placeholder="Instagram" title="Display name" style="width:120px; flex-shrink:0; padding:8px 10px; background:var(--input-bg); border:1px solid var(--border-dark); border-radius:6px; color:var(--text-primary); font-size:13px;" required maxlength="100">

            <input type="text" name="url" value="{{ $link->url }}" placeholder="https://instagram.com/..." title="Full URL" style="flex:1; min-width:180px; padding:8px 12px; background:var(--input-bg); border:1px solid var(--border-dark); border-radius:6px; color:var(--text-primary); font-size:13px;" required maxlength="500">

            <label class="toggle-label small" title="Active">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" value="1" {{ $link->is_active ? 'checked' : '' }}>
                <span class="toggle-switch"></span>
            </label>

            <button type="submit" class="action-btn" title="Save changes"><i data-feather="save"></i></button>
        </form>

        {{-- DELETE form — completely separate, outside the edit form --}}
        <form id="del-social-{{ $link->id }}" method="POST" action="{{ route('admin.footer.social.destroy', $link) }}" style="display:inline;">
            @csrf @method('DELETE')
            <button type="submit" class="action-btn danger" title="Delete" onclick="return confirm('Delete {{ addslashes($link->label) }}?')" style="margin-top:-10px; margin-bottom:10px;"><i data-feather="trash-2"></i></button>
        </form>
        @endforeach
    </div>
    @else
    <div class="form-card">
        <p class="empty-state">No social links yet. Add one below.</p>
    </div>
    @endif

    {{-- Add new link --}}
    <div class="form-card">
        <h3 class="form-section-title"><i data-feather="plus-circle"></i> Add Social Link</h3>
        <form method="POST" action="{{ route('admin.footer.social.store') }}" class="admin-form">
            @csrf
            <div class="form-row">
                <div class="form-group">
                    <label>Platform Icon</label>
                    <select name="icon" style="width:100%; padding:10px 12px; background:var(--input-bg); border:1px solid var(--border-dark); border-radius:6px; color:var(--text-primary); font-size:14px;">
                        <option value="">— select icon —</option>
                        <option value="instagram">Instagram</option>
                        <option value="facebook">Facebook</option>
                        <option value="twitter">Twitter / X</option>
                        <option value="youtube">YouTube</option>
                        <option value="linkedin">LinkedIn</option>
                        <option value="tiktok">TikTok</option>
                        <option value="whatsapp">WhatsApp</option>
                        <option value="github">GitHub</option>
                        <option value="globe">Website</option>
                        <option value="mail">Email</option>
                        <option value="link">Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Short Label <small style="opacity:.6;">(e.g. ig)</small></label>
                    <input type="text" name="platform" placeholder="ig" required maxlength="50">
                </div>
                <div class="form-group">
                    <label>Display Name <small style="opacity:.6;">(e.g. Instagram)</small></label>
                    <input type="text" name="label" placeholder="Instagram" required maxlength="100">
                </div>
                <div class="form-group">
                    <label>URL</label>
                    <input type="text" name="url" placeholder="https://instagram.com/keenkings" required maxlength="500">
                </div>
                <div class="form-group" style="align-self:flex-end">
                    <button type="submit" class="btn btn-primary" style="width:100%"><i data-feather="plus"></i> Add Link</button>
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
