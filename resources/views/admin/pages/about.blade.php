@extends('admin.layouts.app')
@section('title', 'About Content')
@section('breadcrumb', 'About')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">About Section</h1>
        <p class="page-sub">Edit the About section content and manage site statistics.</p>
    </div>
</div>

<div class="tabs-nav" id="aboutTabs">
    <button class="tab-btn active" data-tab="content">About Content</button>
    <button class="tab-btn" data-tab="stats">Stats Bar</button>
</div>

<!-- About Content Tab -->
<div class="tab-panel active" id="tab-content">
    <form method="POST" action="{{ route('admin.about.update') }}" enctype="multipart/form-data" class="admin-form">
        @csrf @method('PUT')

        <div class="form-card">
            <h3 class="form-section-title"><i data-feather="type"></i> Section Text</h3>
            <div class="form-row">
                <div class="form-group">
                    <label>Eyebrow Text</label>
                    <input type="text" name="eyebrow" value="{{ old('eyebrow', $about->eyebrow) }}" required>
                </div>
                <div class="form-group">
                    <label>Founding Year</label>
                    <input type="text" name="founded_year" value="{{ old('founded_year', $about->founded_year) }}" maxlength="4" required>
                </div>
            </div>
            <div class="form-group">
                <label>Heading</label>
                <input type="text" name="heading" value="{{ old('heading', $about->heading) }}" required>
            </div>
            <div class="form-group">
                <label>Lead Paragraph</label>
                <textarea name="lead_text" rows="3" required>{{ old('lead_text', $about->lead_text) }}</textarea>
            </div>
            <div class="form-group">
                <label>Body Paragraph</label>
                <textarea name="body_text" rows="5" required>{{ old('body_text', $about->body_text) }}</textarea>
            </div>
            <div class="form-group">
                <label>Blockquote</label>
                <textarea name="quote" rows="3" placeholder="Our commitment to creativity...">{{ old('quote', $about->quote) }}</textarea>
            </div>
            <div class="form-group">
                <label>Skill Pills <small style="opacity:.6;">(one per line)</small></label>
                <textarea name="skills" rows="8" placeholder="Photography&#10;Videography&#10;...">{{ old('skills', is_array($about->skills) ? implode("\n", $about->skills) : '') }}</textarea>
            </div>

            <h3 class="form-section-title mt"><i data-feather="zap"></i> Pillars</h3>
            <div class="form-row form-row-3">
                <div class="form-group">
                    <label>Pillar 1</label>
                    <input type="text" name="pillar_1" value="{{ old('pillar_1', $about->pillar_1) }}" required>
                </div>
                <div class="form-group">
                    <label>Pillar 2</label>
                    <input type="text" name="pillar_2" value="{{ old('pillar_2', $about->pillar_2) }}" required>
                </div>
                <div class="form-group">
                    <label>Pillar 3</label>
                    <input type="text" name="pillar_3" value="{{ old('pillar_3', $about->pillar_3) }}" required>
                </div>
            </div>
        </div>

        <div class="form-card">
            <h3 class="form-section-title"><i data-feather="image"></i> Main Image</h3>
            @if($about->main_image_url)
            <div class="image-preview-sm"><img src="{{ $about->main_image_url }}" alt="Main"></div>
            @endif
            <div class="form-row">
                <div class="form-group">
                    <label>Upload New Main Image</label>
                    <input type="file" name="main_image_file" accept="image/*">
                </div>
                <div class="form-group">
                    <label>Or Image URL</label>
                    <input type="text" name="main_image_url" value="{{ old('main_image_url', $about->main_image_url) }}" placeholder="https://...">
                </div>
            </div>

            <h3 class="form-section-title mt"><i data-feather="image"></i> Accent Image</h3>
            @if($about->accent_image_url)
            <div class="image-preview-sm"><img src="{{ $about->accent_image_url }}" alt="Accent"></div>
            @endif
            <div class="form-row">
                <div class="form-group">
                    <label>Upload New Accent Image</label>
                    <input type="file" name="accent_image_file" accept="image/*">
                </div>
                <div class="form-group">
                    <label>Or Image URL</label>
                    <input type="text" name="accent_image_url" value="{{ old('accent_image_url', $about->accent_image_url) }}" placeholder="https://...">
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <i data-feather="save"></i> Save About Content
            </button>
        </div>
    </form>
</div>

<!-- Stats Tab -->
<div class="tab-panel" id="tab-stats">
    <div class="form-card">
        <h3 class="form-section-title"><i data-feather="bar-chart-2"></i> Current Stats</h3>
        <div class="stats-admin-list">
            @forelse($stats as $stat)
            <form method="POST" action="{{ route('admin.about.stats.update', $stat) }}" class="stat-edit-row">
                @csrf @method('PUT')
                <input type="text" name="value" value="{{ $stat->value }}" placeholder="500+" class="stat-val-input" required>
                <input type="text" name="label" value="{{ $stat->label }}" placeholder="Projects Done" class="stat-lbl-input" required>
                <label class="toggle-label small">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" {{ $stat->is_active ? 'checked' : '' }}>
                    <span class="toggle-switch"></span>
                </label>
                <button type="submit" class="action-btn"><i data-feather="save"></i></button>
                <a href="{{ route('admin.about.stats.destroy', $stat) }}"
                   onclick="event.preventDefault(); if(confirm('Delete this stat?')) { document.getElementById('del-stat-{{ $stat->id }}').submit(); }"
                   class="action-btn danger"><i data-feather="trash-2"></i></a>
                <form id="del-stat-{{ $stat->id }}" method="POST" action="{{ route('admin.about.stats.destroy', $stat) }}" style="display:none">
                    @csrf @method('DELETE')
                </form>
            </form>
            @empty
            <p class="empty-state">No stats yet.</p>
            @endforelse
        </div>
    </div>

    <div class="form-card">
        <h3 class="form-section-title"><i data-feather="plus-circle"></i> Add New Stat</h3>
        <form method="POST" action="{{ route('admin.about.stats.store') }}" class="admin-form">
            @csrf
            <div class="form-row">
                <div class="form-group">
                    <label>Value</label>
                    <input type="text" name="value" placeholder="500+" required maxlength="20">
                </div>
                <div class="form-group">
                    <label>Label</label>
                    <input type="text" name="label" placeholder="Projects Done" required maxlength="50">
                </div>
                <div class="form-group" style="align-self:flex-end">
                    <button type="submit" class="btn btn-primary" style="width:100%">
                        <i data-feather="plus"></i> Add Stat
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.tab-btn, .tab-panel').forEach(el => el.classList.remove('active'));
        btn.classList.add('active');
        document.getElementById('tab-' + btn.dataset.tab).classList.add('active');
    });
});
</script>
@endpush
