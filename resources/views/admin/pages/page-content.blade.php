@extends('admin.layouts.app')
@section('title', 'Page Content')
@section('breadcrumb', 'Page Content')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Page Content</h1>
        <p class="page-sub">Edit all hardcoded text and images across the website pages.</p>
    </div>
</div>

@if ($errors->any())
<div class="alert alert-error" style="margin-bottom:20px;">
    <i data-feather="alert-circle"></i>
    <div>
        <strong>Save failed — please fix the following:</strong>
        <ul style="margin:6px 0 0 16px; padding:0;">
            @foreach ($errors->all() as $error)
            <li style="font-size:13px;">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif

<div class="tabs-nav" id="pageTabs">
    <button class="tab-btn active" data-tab="home-hero">Home Hero</button>
    <button class="tab-btn" data-tab="home-sections">Home Sections</button>
    <button class="tab-btn" data-tab="parallax">Parallax Banners</button>
    <button class="tab-btn" data-tab="contact">Contact</button>
    <button class="tab-btn" data-tab="process">Process Section</button>
    <button class="tab-btn" data-tab="portfolio-page">Portfolio Page</button>
    <button class="tab-btn" data-tab="blog-page">Blog Page</button>
</div>

{{-- ── TAB: Home Hero ── --}}
<div class="tab-panel active" id="tab-home-hero">
    <form method="POST" action="{{ route('admin.page-content.update') }}" enctype="multipart/form-data" class="admin-form">
        @csrf @method('PUT')
        <input type="hidden" name="_tab" value="home-hero">

        <div class="form-card">
            <h3 class="form-section-title"><i data-feather="type"></i> Hero Text</h3>
            <div class="form-row">
                <div class="form-group">
                    <label>Eyebrow Tag</label>
                    <input type="text" name="hero_tag" value="{{ old('hero_tag', $settings->hero_tag) }}" maxlength="100">
                </div>
                <div class="form-group">
                    <label>CTA Primary Button</label>
                    <input type="text" name="hero_cta_primary" value="{{ old('hero_cta_primary', $settings->hero_cta_primary) }}" maxlength="100">
                </div>
                <div class="form-group">
                    <label>CTA Secondary Button</label>
                    <input type="text" name="hero_cta_secondary" value="{{ old('hero_cta_secondary', $settings->hero_cta_secondary) }}" maxlength="100">
                </div>
            </div>
            <div class="form-group">
                <label>Hero Title</label>
                <input type="text" name="hero_title" value="{{ old('hero_title', $settings->hero_title) }}" maxlength="200">
            </div>
            <div class="form-group">
                <label>Hero Description</label>
                <textarea name="hero_description" rows="3">{{ old('hero_description', $settings->hero_description) }}</textarea>
            </div>
        </div>

        <div class="form-card">
            <h3 class="form-section-title"><i data-feather="refresh-cw"></i> Ticker Items <small style="font-size:11px;font-weight:400;opacity:.6;">(one per line)</small></h3>
            <div class="form-group">
                <textarea name="ticker_items" rows="10" placeholder="Portrait Photography&#10;Wedding Stories&#10;...">{{ old('ticker_items', is_array($settings->ticker_items) ? implode("\n", $settings->ticker_items) : '') }}</textarea>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><i data-feather="save"></i> Save Hero &amp; Ticker</button>
        </div>
    </form>
</div>

{{-- ── TAB: Home Sections ── --}}
<div class="tab-panel" id="tab-home-sections">
    <form method="POST" action="{{ route('admin.page-content.update') }}" enctype="multipart/form-data" class="admin-form">
        @csrf @method('PUT')

        <div class="form-card">
            <h3 class="form-section-title"><i data-feather="layers"></i> Portfolio Preview Section</h3>
            <div class="form-row">
                <div class="form-group">
                    <label>Eyebrow Tag</label>
                    <input type="text" name="portfolio_section_tag" value="{{ old('portfolio_section_tag', $settings->portfolio_section_tag) }}" maxlength="100">
                </div>
                <div class="form-group">
                    <label>Section Title</label>
                    <input type="text" name="portfolio_section_title" value="{{ old('portfolio_section_title', $settings->portfolio_section_title) }}" maxlength="200">
                </div>
            </div>
        </div>

        <div class="form-card">
            <h3 class="form-section-title"><i data-feather="briefcase"></i> Services Section</h3>
            <div class="form-row">
                <div class="form-group">
                    <label>Eyebrow Tag</label>
                    <input type="text" name="services_tag" value="{{ old('services_tag', $settings->services_tag) }}" maxlength="100">
                </div>
                <div class="form-group">
                    <label>Section Title</label>
                    <input type="text" name="services_title" value="{{ old('services_title', $settings->services_title) }}" maxlength="200">
                </div>
            </div>
            <div class="form-group">
                <label>Intro Description</label>
                <textarea name="services_description" rows="3">{{ old('services_description', $settings->services_description) }}</textarea>
            </div>
            <div style="margin-top:16px; padding:14px 16px; background:rgba(137,221,223,.08); border:1px solid rgba(137,221,223,.2); border-radius:8px; display:flex; align-items:center; justify-content:space-between; gap:16px;">
                <p style="font-size:13px; margin:0; opacity:.8;">Manage the individual service cards (add, edit, delete) in the Services section.</p>
                <a href="{{ route('admin.services.index') }}" class="btn btn-ghost" style="white-space:nowrap; flex-shrink:0;">
                    <i data-feather="briefcase"></i> Manage Services
                </a>
            </div>
        </div>

        <div class="form-card">
            <h3 class="form-section-title"><i data-feather="users"></i> Clients Section</h3>
            <div class="form-row">
                <div class="form-group">
                    <label>Eyebrow Tag</label>
                    <input type="text" name="clients_tag" value="{{ old('clients_tag', $settings->clients_tag) }}" maxlength="100">
                </div>
                <div class="form-group">
                    <label>Section Title</label>
                    <input type="text" name="clients_title" value="{{ old('clients_title', $settings->clients_title) }}" maxlength="200">
                </div>
            </div>
        </div>

        <div class="form-card">
            <h3 class="form-section-title"><i data-feather="git-pull-request"></i> Process Section Headings</h3>
            <div class="form-row">
                <div class="form-group">
                    <label>Eyebrow Tag</label>
                    <input type="text" name="process_tag" value="{{ old('process_tag', $settings->process_tag) }}" maxlength="100">
                </div>
                <div class="form-group">
                    <label>Section Title</label>
                    <input type="text" name="process_title" value="{{ old('process_title', $settings->process_title) }}" maxlength="200">
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><i data-feather="save"></i> Save Section Headings</button>
        </div>
    </form>
</div>

{{-- ── TAB: Parallax Banners ── --}}
<div class="tab-panel" id="tab-parallax">
    <form method="POST" action="{{ route('admin.page-content.update') }}" enctype="multipart/form-data" class="admin-form">
        @csrf @method('PUT')

        <div class="form-card">
            <h3 class="form-section-title"><i data-feather="image"></i> Parallax Banner 1 <small style="font-size:11px;font-weight:400;opacity:.6;">(after About section)</small></h3>
            <div class="form-row">
                <div class="form-group">
                    <label>Eyebrow Tag</label>
                    <input type="text" name="parallax1_tag" value="{{ old('parallax1_tag', $settings->parallax1_tag) }}" maxlength="100">
                </div>
                <div class="form-group">
                    <label>CTA Button Text</label>
                    <input type="text" name="parallax1_cta" value="{{ old('parallax1_cta', $settings->parallax1_cta) }}" maxlength="100">
                </div>
            </div>
            <div class="form-group">
                <label>Title</label>
                <input type="text" name="parallax1_title" value="{{ old('parallax1_title', $settings->parallax1_title) }}" maxlength="200">
            </div>
            <div class="form-group">
                <label>Body Text</label>
                <textarea name="parallax1_body" rows="3">{{ old('parallax1_body', $settings->parallax1_body) }}</textarea>
            </div>
            @if($settings->parallax1_image_url)
            <div class="image-preview-sm"><img src="{{ $settings->parallax1_image_url }}" alt="Parallax 1"></div>
            @endif
            <div class="form-row">
                <div class="form-group">
                    <label>Upload Background Image</label>
                    <input type="file" name="parallax1_image_file" accept="image/*">
                </div>
                <div class="form-group">
                    <label>Or Image URL</label>
                    <input type="text" name="parallax1_image_url" value="{{ old('parallax1_image_url', $settings->parallax1_image_url) }}" placeholder="https://...">
                </div>
            </div>
        </div>

        <div class="form-card">
            <h3 class="form-section-title"><i data-feather="image"></i> Parallax Banner 2 <small style="font-size:11px;font-weight:400;opacity:.6;">(after Clients section)</small></h3>
            <div class="form-group">
                <label>Eyebrow Tag</label>
                <input type="text" name="parallax2_tag" value="{{ old('parallax2_tag', $settings->parallax2_tag) }}" maxlength="100">
            </div>
            <div class="form-group">
                <label>Title</label>
                <input type="text" name="parallax2_title" value="{{ old('parallax2_title', $settings->parallax2_title) }}" maxlength="200">
            </div>
            <div class="form-group">
                <label>Body Text</label>
                <textarea name="parallax2_body" rows="3">{{ old('parallax2_body', $settings->parallax2_body) }}</textarea>
            </div>
            @if($settings->parallax2_image_url)
            <div class="image-preview-sm"><img src="{{ $settings->parallax2_image_url }}" alt="Parallax 2"></div>
            @endif
            <div class="form-row">
                <div class="form-group">
                    <label>Upload Background Image</label>
                    <input type="file" name="parallax2_image_file" accept="image/*">
                </div>
                <div class="form-group">
                    <label>Or Image URL</label>
                    <input type="text" name="parallax2_image_url" value="{{ old('parallax2_image_url', $settings->parallax2_image_url) }}" placeholder="https://...">
                </div>
            </div>
        </div>

        <div class="form-card">
            <h3 class="form-section-title"><i data-feather="image"></i> Parallax Banner 3 <small style="font-size:11px;font-weight:400;opacity:.6;">(CTA strip after Process)</small></h3>
            <div class="form-row">
                <div class="form-group">
                    <label>CTA Button Text</label>
                    <input type="text" name="parallax3_cta" value="{{ old('parallax3_cta', $settings->parallax3_cta) }}" maxlength="100">
                </div>
            </div>
            <div class="form-group">
                <label>Title</label>
                <input type="text" name="parallax3_title" value="{{ old('parallax3_title', $settings->parallax3_title) }}" maxlength="200">
            </div>
            <div class="form-group">
                <label>Body Text</label>
                <textarea name="parallax3_body" rows="3">{{ old('parallax3_body', $settings->parallax3_body) }}</textarea>
            </div>
            @if($settings->parallax3_image_url)
            <div class="image-preview-sm"><img src="{{ $settings->parallax3_image_url }}" alt="Parallax 3"></div>
            @endif
            <div class="form-row">
                <div class="form-group">
                    <label>Upload Background Image</label>
                    <input type="file" name="parallax3_image_file" accept="image/*">
                </div>
                <div class="form-group">
                    <label>Or Image URL</label>
                    <input type="text" name="parallax3_image_url" value="{{ old('parallax3_image_url', $settings->parallax3_image_url) }}" placeholder="https://...">
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><i data-feather="save"></i> Save Parallax Banners</button>
        </div>
    </form>
</div>

{{-- ── TAB: Contact ── --}}
<div class="tab-panel" id="tab-contact">
    <form method="POST" action="{{ route('admin.page-content.update') }}" enctype="multipart/form-data" class="admin-form">
        @csrf @method('PUT')

        <div class="form-card">
            <h3 class="form-section-title"><i data-feather="mail"></i> Contact Section Headings</h3>
            <div class="form-row">
                <div class="form-group">
                    <label>Eyebrow Tag</label>
                    <input type="text" name="contact_tag" value="{{ old('contact_tag', $settings->contact_tag) }}" maxlength="100">
                </div>
                <div class="form-group">
                    <label>Section Title</label>
                    <input type="text" name="contact_title" value="{{ old('contact_title', $settings->contact_title) }}" maxlength="200">
                </div>
            </div>
            <div class="form-group">
                <label>Intro Description</label>
                <textarea name="contact_description" rows="3">{{ old('contact_description', $settings->contact_description) }}</textarea>
            </div>
        </div>

        <div class="form-card">
            <h3 class="form-section-title"><i data-feather="phone"></i> Contact Details</h3>
            <div class="form-row">
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="text" name="contact_email" value="{{ old('contact_email', $settings->contact_email) }}" maxlength="200">
                </div>
                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="text" name="contact_phone" value="{{ old('contact_phone', $settings->contact_phone) }}" maxlength="100">
                </div>
            </div>
            <div class="form-group">
                <label>Studio Address</label>
                <textarea name="contact_address" rows="2">{{ old('contact_address', $settings->contact_address) }}</textarea>
            </div>
        </div>

        <div class="form-card">
            <h3 class="form-section-title"><i data-feather="list"></i> Service Dropdown Options <small style="font-size:11px;font-weight:400;opacity:.6;">(one per line)</small></h3>
            <div class="form-group">
                <textarea name="contact_services" rows="8" placeholder="Photography&#10;Videography&#10;...">{{ old('contact_services', is_array($settings->contact_services) ? implode("\n", $settings->contact_services) : '') }}</textarea>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><i data-feather="save"></i> Save Contact Content</button>
        </div>
    </form>
</div>

{{-- ── TAB: Process Section ── --}}
<div class="tab-panel" id="tab-process">
    <form method="POST" action="{{ route('admin.page-content.update') }}" class="admin-form">
        @csrf @method('PUT')

        <div class="form-card">
            <h3 class="form-section-title"><i data-feather="git-pull-request"></i> Process Section Headings</h3>
            <div class="form-row">
                <div class="form-group">
                    <label>Eyebrow Tag</label>
                    <input type="text" name="process_tag" value="{{ old('process_tag', $settings->process_tag) }}" maxlength="100">
                </div>
                <div class="form-group">
                    <label>Section Title</label>
                    <input type="text" name="process_title" value="{{ old('process_title', $settings->process_title) }}" maxlength="200">
                </div>
            </div>
            <div style="margin-top:16px; padding:14px 16px; background:rgba(137,221,223,.08); border:1px solid rgba(137,221,223,.2); border-radius:8px; display:flex; align-items:center; justify-content:space-between; gap:16px;">
                <p style="font-size:13px; margin:0; opacity:.8;">Add, edit, and delete individual process steps in the dedicated section.</p>
                <a href="{{ route('admin.process-steps.index') }}" class="btn btn-ghost" style="white-space:nowrap; flex-shrink:0;">
                    <i data-feather="git-pull-request"></i> Manage Steps
                </a>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><i data-feather="save"></i> Save Process Headings</button>
        </div>
    </form>
</div>

{{-- ── TAB: Portfolio Page ── --}}
<div class="tab-panel" id="tab-portfolio-page">
    <form method="POST" action="{{ route('admin.page-content.update') }}" enctype="multipart/form-data" class="admin-form">
        @csrf @method('PUT')

        <div class="form-card">
            <h3 class="form-section-title"><i data-feather="layers"></i> Portfolio Page Hero</h3>
            <div class="form-row">
                <div class="form-group">
                    <label>Eyebrow Tag</label>
                    <input type="text" name="portfolio_page_tag" value="{{ old('portfolio_page_tag', $settings->portfolio_page_tag) }}" maxlength="100">
                </div>
                <div class="form-group">
                    <label>Page Title</label>
                    <input type="text" name="portfolio_page_title" value="{{ old('portfolio_page_title', $settings->portfolio_page_title) }}" maxlength="200">
                </div>
            </div>
            @if($settings->portfolio_page_image_url)
            <div class="image-preview-sm"><img src="{{ $settings->portfolio_page_image_url }}" alt="Portfolio Page Hero"></div>
            @endif
            <div class="form-row">
                <div class="form-group">
                    <label>Upload Background Image</label>
                    <input type="file" name="portfolio_page_image_file" accept="image/*">
                </div>
                <div class="form-group">
                    <label>Or Image URL</label>
                    <input type="text" name="portfolio_page_image_url" value="{{ old('portfolio_page_image_url', $settings->portfolio_page_image_url) }}" placeholder="https://...">
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><i data-feather="save"></i> Save Portfolio Page</button>
        </div>
    </form>
</div>

{{-- ── TAB: Blog Page ── --}}
<div class="tab-panel" id="tab-blog-page">
    <form method="POST" action="{{ route('admin.page-content.update') }}" enctype="multipart/form-data" class="admin-form">
        @csrf @method('PUT')

        <div class="form-card">
            <h3 class="form-section-title"><i data-feather="file-text"></i> Blog Page Hero</h3>
            <div class="form-group">
                <label>Page Title</label>
                <input type="text" name="blog_page_title" value="{{ old('blog_page_title', $settings->blog_page_title) }}" maxlength="200">
            </div>
            @if($settings->blog_page_image_url)
            <div class="image-preview-sm"><img src="{{ $settings->blog_page_image_url }}" alt="Blog Page Hero"></div>
            @endif
            <div class="form-row">
                <div class="form-group">
                    <label>Upload Background Image</label>
                    <input type="file" name="blog_page_image_file" accept="image/*">
                </div>
                <div class="form-group">
                    <label>Or Image URL</label>
                    <input type="text" name="blog_page_image_url" value="{{ old('blog_page_image_url', $settings->blog_page_image_url) }}" placeholder="https://...">
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><i data-feather="save"></i> Save Blog Page</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
const tabBtns = document.querySelectorAll('#pageTabs .tab-btn');
tabBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('#pageTabs .tab-btn, .tab-panel').forEach(el => el.classList.remove('active'));
        btn.classList.add('active');
        document.getElementById('tab-' + btn.dataset.tab).classList.add('active');
    });
});
</script>
@endpush
