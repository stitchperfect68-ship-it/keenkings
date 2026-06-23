@extends('admin.layouts.app')
@section('title', 'Settings')
@section('breadcrumb', 'Settings')

@push('head')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;1,400&family=DM+Sans:wght@300;400&family=DM+Serif+Display:ital@0;1&family=Inter:wght@300;400&family=Jost:wght@300;400&family=Libre+Baskerville:ital,wght@0,400;1,400&family=Playfair+Display:ital,wght@0,400;0,500;1,400&family=Raleway:wght@300;400&display=swap" rel="stylesheet">
<style>
.font-preset-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 14px;
    margin-top: 4px;
}
.font-preset-card {
    position: relative;
    display: flex;
    flex-direction: column;
    gap: 12px;
    padding: 20px 16px 16px;
    border: 1.5px solid var(--admin-border, rgba(255,255,255,0.1));
    border-radius: 8px;
    cursor: pointer;
    transition: border-color .2s, background .2s;
    background: var(--admin-surface, rgba(255,255,255,0.03));
    user-select: none;
}
.font-preset-card input[type="radio"] {
    position: absolute;
    opacity: 0;
    pointer-events: none;
}
.font-preset-card:hover {
    border-color: rgba(255,255,255,0.3);
}
.font-preset-card.selected {
    border-color: var(--accent, #89dddf);
    background: rgba(137,221,223,0.06);
}
.preset-check {
    position: absolute;
    top: 10px;
    right: 10px;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: var(--accent, #89dddf);
    display: none;
    align-items: center;
    justify-content: center;
    color: #000;
}
.font-preset-card.selected .preset-check {
    display: flex;
}
.preset-preview {
    display: flex;
    flex-direction: column;
    gap: 4px;
    padding-bottom: 10px;
    border-bottom: 1px solid var(--admin-border, rgba(255,255,255,0.08));
    min-height: 64px;
    justify-content: center;
}
.preset-heading {
    font-size: 22px;
    font-weight: 400;
    line-height: 1.2;
    color: var(--admin-text, #fff);
}
.preset-body {
    font-size: 12px;
    font-weight: 300;
    letter-spacing: .04em;
    color: var(--admin-muted, rgba(255,255,255,0.5));
}
.preset-info strong {
    display: block;
    font-size: 13px;
    font-weight: 500;
}
.preset-info small {
    font-size: 11px;
    color: var(--admin-muted, rgba(255,255,255,0.45));
}
.custom-upload-panel {
    display: none;
    margin-top: 8px;
}
.custom-upload-panel.active {
    display: block;
}
.upload-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}
.current-file {
    font-size: 11px;
    color: var(--admin-muted, rgba(255,255,255,0.45));
    margin-top: 4px;
}
.current-file a {
    color: var(--accent, #89dddf);
    text-decoration: none;
}
@media (max-width: 640px) {
    .font-preset-grid { grid-template-columns: 1fr 1fr; }
    .upload-row { grid-template-columns: 1fr; }
}
</style>
@endpush

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Settings</h1>
        <p class="page-sub">Manage global site settings.</p>
    </div>
</div>

<form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="admin-form" id="settingsForm">
    @csrf @method('PUT')

    <div class="form-card">
        <h3 class="form-section-title"><i data-feather="type"></i> Website Font</h3>
        <p style="font-size:13px;color:var(--admin-muted,rgba(255,255,255,.5));margin-bottom:20px;">
            Choose a font pairing for the public website. The heading font is used for titles; the body font is used for all other text.
        </p>

        <div class="font-preset-grid" id="presetGrid">
            @foreach($presets as $key => $preset)
            @php $isSelected = $settings->font_preset === $key; @endphp
            <label class="font-preset-card {{ $isSelected ? 'selected' : '' }}" data-preset="{{ $key }}">
                <input type="radio" name="font_preset" value="{{ $key }}" {{ $isSelected ? 'checked' : '' }}>

                <div class="preset-preview">
                    @if($key === 'custom')
                        <span class="preset-heading" style="font-size:18px;font-style:italic;opacity:.5;">Aa Bb Cc</span>
                        <span class="preset-body">your uploaded fonts</span>
                    @else
                        <span class="preset-heading" style="font-family:'{{ $preset['serif'] }}',serif;">The Story</span>
                        <span class="preset-body" style="font-family:'{{ $preset['sans'] }}',sans-serif;">Begins here — Keenkings Media</span>
                    @endif
                </div>

                <div class="preset-info">
                    <strong>{{ $preset['label'] }}</strong>
                    <small>{{ $preset['description'] }}</small>
                </div>

                <div class="preset-check">
                    <svg width="11" height="11" viewBox="0 0 11 11" fill="none"><path d="M1.5 5.5L4.5 8.5L9.5 2.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
            </label>
            @endforeach
        </div>

        <!-- Custom Upload Panel -->
        <div class="custom-upload-panel {{ $settings->font_preset === 'custom' ? 'active' : '' }}" id="customPanel">
            <div class="form-card" style="margin-top:20px;background:rgba(255,255,255,0.02);">
                <h3 class="form-section-title"><i data-feather="download"></i> Upload Custom Fonts</h3>
                <p style="font-size:13px;color:var(--admin-muted,rgba(255,255,255,.5));margin-bottom:16px;">
                    Accepted formats: .woff2, .woff, .ttf, .otf — max 5 MB each.
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
                        <p class="current-file">
                            Current: <a href="{{ asset('storage/' . $settings->custom_serif_path) }}" target="_blank">{{ basename($settings->custom_serif_path) }}</a>
                        </p>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Body Font File</label>
                        <input type="file" name="custom_sans_file" accept=".woff2,.woff,.ttf,.otf">
                        @if($settings->custom_sans_path)
                        <p class="current-file">
                            Current: <a href="{{ asset('storage/' . $settings->custom_sans_path) }}" target="_blank">{{ basename($settings->custom_sans_path) }}</a>
                        </p>
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
    const cards  = document.querySelectorAll('.font-preset-card');
    const panel  = document.getElementById('customPanel');

    cards.forEach(function (card) {
        card.addEventListener('click', function () {
            cards.forEach(function (c) { c.classList.remove('selected'); });
            card.classList.add('selected');
            card.querySelector('input[type="radio"]').checked = true;
            panel.classList.toggle('active', card.dataset.preset === 'custom');
        });
    });
})();
</script>
@endpush
