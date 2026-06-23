@extends('admin.layouts.app')
@section('title', 'Settings')
@section('breadcrumb', 'Settings')

@push('head')
<style>
/* ── Font Selector ───────────────────────────────── */
.font-selector-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}
.font-select-wrap {
    position: relative;
}
.font-select-wrap select {
    width: 100%;
    padding: 10px 36px 10px 14px;
    background: var(--admin-input-bg, rgba(255,255,255,0.05));
    border: 1.5px solid var(--admin-border, rgba(255,255,255,0.12));
    border-radius: 6px;
    color: var(--admin-text, #fff);
    font-size: 14px;
    appearance: none;
    cursor: pointer;
    transition: border-color .2s;
}
.font-select-wrap select:focus {
    outline: none;
    border-color: var(--accent, #89dddf);
}
.font-select-wrap::after {
    content: '';
    pointer-events: none;
    position: absolute;
    right: 12px; top: 50%;
    transform: translateY(-50%);
    width: 0; height: 0;
    border-left: 5px solid transparent;
    border-right: 5px solid transparent;
    border-top: 6px solid rgba(255,255,255,0.4);
}
.font-select-wrap select option,
.font-select-wrap select optgroup {
    background: #1a1a1a;
    color: #fff;
}

/* ── Live Preview ────────────────────────────────── */
.font-preview-box {
    margin-top: 20px;
    padding: 28px 28px 22px;
    border: 1.5px solid var(--admin-border, rgba(255,255,255,0.1));
    border-radius: 8px;
    background: rgba(255,255,255,0.02);
    min-height: 130px;
}
.preview-heading-text {
    font-size: 32px;
    font-weight: 400;
    line-height: 1.2;
    margin-bottom: 12px;
    color: var(--admin-text, #fff);
    transition: font-family .3s;
}
.preview-body-text {
    font-size: 14px;
    font-weight: 300;
    line-height: 1.7;
    color: rgba(255,255,255,0.55);
    transition: font-family .3s;
}
.preview-label {
    margin-top: 16px;
    padding-top: 12px;
    border-top: 1px solid rgba(255,255,255,0.07);
    font-size: 11px;
    letter-spacing: .06em;
    text-transform: uppercase;
    color: rgba(255,255,255,0.35);
}

/* ── Custom Upload Toggle ────────────────────────── */
.custom-toggle-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    background: none;
    border: 1.5px solid rgba(255,255,255,0.12);
    border-radius: 6px;
    color: rgba(255,255,255,0.55);
    font-size: 13px;
    padding: 9px 16px;
    cursor: pointer;
    transition: border-color .2s, color .2s;
    margin-top: 8px;
}
.custom-toggle-btn:hover { border-color: rgba(255,255,255,0.3); color: #fff; }
.custom-toggle-btn.active { border-color: var(--accent, #89dddf); color: var(--accent, #89dddf); }

.custom-upload-panel { display: none; }
.custom-upload-panel.active { display: block; }
.upload-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}
.current-file {
    font-size: 11px;
    color: rgba(255,255,255,0.4);
    margin-top: 4px;
}
.current-file a { color: var(--accent, #89dddf); text-decoration: none; }

.mode-hint {
    display: inline-block;
    font-size: 11px;
    padding: 2px 8px;
    border-radius: 4px;
    background: rgba(137,221,223,0.12);
    color: var(--accent, #89dddf);
    margin-left: 6px;
    vertical-align: middle;
}

@media (max-width: 640px) {
    .font-selector-grid { grid-template-columns: 1fr; }
    .upload-row { grid-template-columns: 1fr; }
    .preview-heading-text { font-size: 24px; }
}
</style>
@endpush

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Settings</h1>
        <p class="page-sub">Manage global website settings.</p>
    </div>
</div>

<form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="admin-form" id="settingsForm">
    @csrf @method('PUT')
    <input type="hidden" name="font_preset" id="fontPresetInput" value="{{ $settings->font_preset === 'custom' ? 'custom' : 'google' }}">

    <div class="form-card">
        <h3 class="form-section-title">
            <i data-feather="type"></i> Website Font
            <span class="mode-hint" id="modeHint">
                {{ $settings->font_preset === 'custom' ? 'Custom Upload' : 'Google Fonts' }}
            </span>
        </h3>
        <p style="font-size:13px;color:rgba(255,255,255,.45);margin-bottom:20px;">
            Choose fonts for the public site. The heading font is used for titles; the body font for all other text.
        </p>

        {{-- ── Dropdowns ── --}}
        <div class="font-selector-grid">
            <div class="form-group">
                <label>Heading Font</label>
                <div class="font-select-wrap">
                    <select name="heading_font" id="headingSelect">
                        @foreach($headingFonts as $group => $fonts)
                        <optgroup label="{{ $group }}">
                            @foreach($fonts as $font)
                            <option value="{{ $font }}" {{ ($settings->heading_font ?? 'Cormorant Garamond') === $font ? 'selected' : '' }}>
                                {{ $font }}
                            </option>
                            @endforeach
                        </optgroup>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label>Body Font</label>
                <div class="font-select-wrap">
                    <select name="body_font" id="bodySelect">
                        @foreach($bodyFonts as $group => $fonts)
                        <optgroup label="{{ $group }}">
                            @foreach($fonts as $font)
                            <option value="{{ $font }}" {{ ($settings->body_font ?? 'Jost') === $font ? 'selected' : '' }}>
                                {{ $font }}
                            </option>
                            @endforeach
                        </optgroup>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        {{-- ── Live Preview ── --}}
        <div class="font-preview-box" id="fontPreview">
            <div class="preview-heading-text" id="previewHeading">The Art of Visual Storytelling</div>
            <div class="preview-body-text" id="previewBody">
                Keenkings Media is a dynamic media production studio based in Lusaka, Zambia —
                specialising in photography, videography, and brand development since 2016.
            </div>
            <div class="preview-label" id="previewLabel">
                {{ $settings->heading_font ?? 'Cormorant Garamond' }} + {{ $settings->body_font ?? 'Jost' }}
            </div>
        </div>

        {{-- ── Custom Upload Toggle ── --}}
        <button type="button" class="custom-toggle-btn {{ $settings->font_preset === 'custom' ? 'active' : '' }}" id="customToggle">
            <i data-feather="upload"></i>
            Upload Custom Fonts Instead
        </button>

        <div class="custom-upload-panel {{ $settings->font_preset === 'custom' ? 'active' : '' }}" id="customPanel">
            <div class="form-card" style="margin-top:16px;background:rgba(255,255,255,0.02);">
                <h3 class="form-section-title"><i data-feather="download"></i> Custom Font Files</h3>
                <p style="font-size:13px;color:rgba(255,255,255,.45);margin-bottom:16px;">
                    Accepted: .woff2, .woff, .ttf, .otf — max 5 MB each. When custom fonts are active, the dropdown selection above is ignored.
                </p>
                <div class="upload-row">
                    <div class="form-group">
                        <label>Heading Font Name</label>
                        <input type="text" name="custom_serif_name"
                               value="{{ old('custom_serif_name', $settings->custom_serif_name) }}"
                               placeholder="e.g. MyHeadingFont">
                    </div>
                    <div class="form-group">
                        <label>Body Font Name</label>
                        <input type="text" name="custom_sans_name"
                               value="{{ old('custom_sans_name', $settings->custom_sans_name) }}"
                               placeholder="e.g. MyBodyFont">
                    </div>
                </div>
                <div class="upload-row" style="margin-top:4px;">
                    <div class="form-group">
                        <label>Heading Font File</label>
                        <input type="file" name="custom_serif_file" accept=".woff2,.woff,.ttf,.otf">
                        @if($settings->custom_serif_path)
                        <p class="current-file">Current: <a href="{{ asset('storage/'.$settings->custom_serif_path) }}" target="_blank">{{ basename($settings->custom_serif_path) }}</a></p>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Body Font File</label>
                        <input type="file" name="custom_sans_file" accept=".woff2,.woff,.ttf,.otf">
                        @if($settings->custom_sans_path)
                        <p class="current-file">Current: <a href="{{ asset('storage/'.$settings->custom_sans_path) }}" target="_blank">{{ basename($settings->custom_sans_path) }}</a></p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div style="display:flex;justify-content:flex-end;margin-top:8px;">
        <button type="submit" class="btn-primary">
            <i data-feather="save"></i> Save Settings
        </button>
    </div>
</form>
@endsection

@push('scripts')
<script>
(function () {
    const headingSelect  = document.getElementById('headingSelect');
    const bodySelect     = document.getElementById('bodySelect');
    const previewHeading = document.getElementById('previewHeading');
    const previewBody    = document.getElementById('previewBody');
    const previewLabel   = document.getElementById('previewLabel');
    const customToggle   = document.getElementById('customToggle');
    const customPanel    = document.getElementById('customPanel');
    const fontPresetInput = document.getElementById('fontPresetInput');
    const modeHint       = document.getElementById('modeHint');

    const loadedFonts = new Set();

    function loadFont(name) {
        if (loadedFonts.has(name)) return;
        loadedFonts.add(name);
        const link = document.createElement('link');
        link.rel = 'stylesheet';
        const f = name.replace(/ /g, '+');
        link.href = 'https://fonts.googleapis.com/css2?family=' + f + ':ital,wght@0,300;0,400;0,500;0,700;1,300;1,400&display=swap';
        document.head.appendChild(link);
    }

    function updatePreview() {
        const h = headingSelect.value;
        const b = bodySelect.value;
        loadFont(h);
        loadFont(b);
        previewHeading.style.fontFamily = "'" + h + "', serif";
        previewBody.style.fontFamily    = "'" + b + "', sans-serif";
        previewLabel.textContent        = h + ' + ' + b;
    }

    // Preload currently active fonts
    loadFont(headingSelect.value);
    loadFont(bodySelect.value);
    updatePreview();

    headingSelect.addEventListener('change', updatePreview);
    bodySelect.addEventListener('change', updatePreview);

    // Custom upload toggle
    customToggle.addEventListener('click', function () {
        const isCustom = customPanel.classList.toggle('active');
        customToggle.classList.toggle('active', isCustom);
        fontPresetInput.value = isCustom ? 'custom' : 'google';
        modeHint.textContent  = isCustom ? 'Custom Upload' : 'Google Fonts';
        feather.replace();
    });
})();
</script>
@endpush
