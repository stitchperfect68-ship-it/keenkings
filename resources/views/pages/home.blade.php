@extends('layouts.app')

@section('title', 'Keenkings — Photography Portfolio')
@section('description', 'Keenkings Media is a dynamic media production company specializing in storytelling, digital content creation, and brand development. Based in Lusaka, Zambia. Est. 2016.')

@push('head')
<style>
/* ── Hero Recent Activity Strip ── */
.hero-activity {
  position: absolute;
  bottom: 24px;
  left: clamp(20px, 5vw, 80px);
  z-index: 50;
  display: flex;
  flex-direction: column;
  gap: 10px;
}
.hero-activity-label {
  display: flex;
  align-items: center;
  gap: 8px;
  margin: 0;
  font-size: 10px;
  letter-spacing: .2em;
  text-transform: uppercase;
  color: rgba(255,255,255,.4);
  font-family: var(--font-sans);
  font-weight: 400;
}
.hero-activity-pulse {
  display: inline-block;
  width: 6px;
  height: 6px;
  border-radius: 50%;
  background: var(--accent, #89dddf);
  flex-shrink: 0;
  animation: ha-pulse 2.6s ease-in-out infinite;
}
@keyframes ha-pulse {
  0%, 100% { opacity: 1; }
  50%       { opacity: .22; }
}
.hero-activity-rail {
  display: flex;
  align-items: center;
  background: rgba(8, 8, 8, .72);
  backdrop-filter: blur(24px);
  -webkit-backdrop-filter: blur(24px);
  border: 1px solid rgba(255,255,255,.09);
  border-radius: 16px;
  padding: 4px;
}
.hero-activity-item {
  display: flex;
  align-items: center;
  gap: 16px;
  padding: 14px 24px 14px 14px;
  border-radius: 12px;
  text-decoration: none;
  color: inherit;
  max-width: 420px;
  transition: background .22s;
}
.hero-activity-item:hover { background: rgba(255,255,255,.06); }
.hero-activity-thumb {
  width: 72px;
  height: 72px;
  border-radius: 10px;
  object-fit: cover;
  flex-shrink: 0;
  border: 1px solid rgba(255,255,255,.1);
}
.hero-activity-icon {
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 28px;
  background: rgba(255,255,255,.05);
  color: rgba(255,255,255,.5);
}
.hero-activity-meta {
  display: flex;
  flex-direction: column;
  gap: 6px;
  min-width: 0;
}
.hero-activity-cat {
  font-size: 11px;
  letter-spacing: .16em;
  text-transform: uppercase;
  color: var(--accent, #89dddf);
  opacity: .9;
  font-family: var(--font-sans);
  white-space: nowrap;
}
.hero-activity-name {
  font-size: 18px;
  font-family: var(--font-sans);
  font-weight: 500;
  color: rgba(255,255,255,.92);
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  max-width: 300px;
  letter-spacing: .01em;
}
/* Mobile — column flex so strip sits directly below the buttons */
@media (max-width: 600px) {
  .hero {
    flex-direction: column !important;
    align-items: stretch !important;
    justify-content: flex-start !important;
  }
  .hero-content { padding: 84px 20px 20px !important; }
  .hero-activity {
    position: relative !important;
    bottom: auto !important;
    left: auto !important;
    right: auto !important;
    display: flex;
    margin: 0 16px;
    width: auto;
  }
  .hero-activity-rail { align-items: stretch; }
  .hero-activity-item { max-width: 100%; }
  .hero-activity-name { max-width: none; }
}
</style>
@endpush

@section('content')

<!-- ═══════════════════════════════════════════
     HERO
════════════════════════════════════════════ -->
<section class="hero" id="home">
  <div class="hero-bg" id="heroBg" style="background-image: url('{{ $heroSlides->first()->image_url ?? 'https://images.unsplash.com/photo-1492691527719-9d1e07e534b4?w=1800&q=80' }}');"></div>
  <div class="hero-overlay"></div>
  <div class="hero-content">
    <span class="hero-tag">{{ $pageSettings->hero_tag }}</span>
    <h1 class="hero-title">{!! nl2br(e($pageSettings->hero_title)) !!}</h1>
    <p class="hero-desc">{{ $pageSettings->hero_description }}</p>
    <div class="hero-actions">
      <a href="#portfolio" class="btn-primary">{{ $pageSettings->hero_cta_primary }}</a>
      <a href="#about" class="btn-ghost">{{ $pageSettings->hero_cta_secondary }}</a>
    </div>
  </div>

  {{-- ── Recent Activity Strip ── --}}
  @if($latestBlog)
  <div class="hero-activity">
    <p class="hero-activity-label">
      <span class="hero-activity-pulse"></span>
      Recent Activities
    </p>
    <div class="hero-activity-rail">
      <a href="{{ route('blog.show', $latestBlog->slug) }}" class="hero-activity-item">
        @if($latestBlog->featured_image_url)
        <img src="{{ $latestBlog->featured_image_url }}" alt="{{ $latestBlog->title }}" class="hero-activity-thumb" loading="lazy">
        @else
        <div class="hero-activity-thumb hero-activity-icon">✍</div>
        @endif
        <div class="hero-activity-meta">
          <span class="hero-activity-cat">Blog{{ $latestBlog->category ? ' · ' . $latestBlog->category : '' }}</span>
          <span class="hero-activity-name">{{ \Illuminate\Support\Str::limit($latestBlog->title, 36) }}</span>
        </div>
      </a>
    </div>
  </div>
  @endif

  <div class="hero-scroll">
    <div class="scroll-line"></div>
    <span>Scroll</span>
  </div>
</section>


<!-- ═══════════════════════════════════════════
     STATS BAR
════════════════════════════════════════════ -->
<div class="stats-bar stats-bar--dark">
  <div class="stats-inner">
    @foreach($stats as $i => $stat)
    @php
      $count  = preg_replace('/[^0-9]/', '', $stat->value);
      $suffix = preg_replace('/[0-9]/', '', $stat->value);
    @endphp
    <div class="stat reveal{{ $i > 0 ? ' reveal-delay-'.$i : '' }}">
      <div class="stat-number" data-count="{{ $count }}">0<span>{{ $suffix }}</span></div>
      <div class="stat-label">{{ $stat->label }}</div>
    </div>
    @endforeach
  </div>
</div>

<!-- Ticker -->
@php $tickerItems = $pageSettings->ticker_items ?: ['Portrait Photography','Wedding Stories','Editorial Work','Commercial Shoots','Nature & Landscape','Fine Art Prints','Fashion Photography','Event Coverage']; @endphp
<div class="ticker">
  <div class="ticker-inner" id="ticker">
    @foreach(array_merge($tickerItems, $tickerItems) as $item)
    <span class="ticker-item">{{ $item }}</span>
    @endforeach
  </div>
</div>


<!-- ═══════════════════════════════════════════
     ABOUT — LIGHT section
════════════════════════════════════════════ -->
<section id="about" class="section--light">
  <div class="about">
    <!-- Image side -->
    <div class="about-image reveal-left">
      <img src="{{ $about->main_image_url }}" alt="Keenkings Media"/>
      <div class="about-image-accent"></div>
      <div class="about-image-label">Est. {{ $about->founded_year }} · Lusaka</div>
    </div>
    <!-- Text side -->
    <div class="about-content">
      <span class="section-tag reveal">{{ $about->eyebrow }}</span>
      <h2 class="section-title reveal">{!! nl2br(e($about->heading)) !!}</h2>
      <p class="section-body reveal">{{ $about->lead_text }}</p>
      @if($about->quote)
      <blockquote class="about-quote reveal">"{{ $about->quote }}"</blockquote>
      @endif
      <p class="section-body reveal">{{ $about->body_text }}</p>
      @if($about->skills && count($about->skills))
      <div class="about-skills reveal">
        @foreach($about->skills as $skill)
        <span class="skill-pill">{{ $skill }}</span>
        @endforeach
      </div>
      @endif
    </div>
  </div>
</section>


<!-- ═══════════════════════════════════════════
     PORTFOLIO PREVIEW — DARK section
════════════════════════════════════════════ -->
<section id="portfolio" style="background: var(--black);">
  <div class="portfolio-section">
    <div class="portfolio-header">
      <div>
        <span class="section-tag reveal">{{ $pageSettings->portfolio_section_tag }}</span>
        <h2 class="section-title reveal">{{ $pageSettings->portfolio_section_title }}</h2>
      </div>
      <div class="portfolio-filters reveal">
        <button class="filter-btn active" data-filter="all">All</button>
        <button class="filter-btn" data-filter="photography">Photography</button>
        <button class="filter-btn" data-filter="videography">Videography</button>
        <button class="filter-btn" data-filter="graphics">Graphics</button>
      </div>
    </div>
    <div class="portfolio-grid" id="portfolioGrid">
      @foreach($previewItems as $item)
      <div class="portfolio-item {{ $item['sz'] }} reveal"
           data-cat="{{ $item['p'] }}"
           data-video="{{ $item['vid'] }}"
           onclick="openLightbox(this)">
        <img src="{{ $item['img'] }}" alt="{{ $item['t'] }}" loading="lazy"/>
        @if($item['vid'])
        <div class="play-btn">
          <svg width="13" height="15" viewBox="0 0 13 15" fill="none">
            <path d="M1.5 1.5l10 6-10 6V1.5z" fill="white" fill-opacity=".95"/>
          </svg>
        </div>
        @endif
        <div class="portfolio-item-overlay">
          <div class="portfolio-item-info">
            <div class="portfolio-item-cat">{{ ucfirst($item['p']) }}</div>
            <div class="portfolio-item-title">{{ $item['t'] }}</div>
          </div>
        </div>
        <div class="portfolio-item-arrow">
          <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M2 12L12 2M12 2H4M12 2V10" stroke="white" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </div>
      </div>
      @endforeach
    </div>
    <div style="text-align:center; margin-top:48px;">
      <a href="{{ route('portfolio') }}" class="btn-primary">View Full Portfolio</a>
    </div>
  </div>
</section>


<!-- ═══════════════════════════════════════════
     OUR TEAM
════════════════════════════════════════════ -->
@if($teamMembers->isNotEmpty())
<section id="team" class="section--light">
  <div class="team-section">
    <div class="team-header reveal">
      <span class="section-tag" style="display:block;margin-bottom:10px;">The People Behind the Lens</span>
      <h2 class="section-title" style="color:var(--light-heading);">Meet Our Team</h2>
    </div>
    <div class="team-grid">
      @foreach($teamMembers as $i => $member)
      <div class="team-card reveal{{ $i % 3 > 0 ? ' reveal-delay-'.($i % 3) : '' }}">
        <div class="team-photo-wrap">
          @if($member->image_url)
          <img src="{{ $member->image_url }}" alt="{{ $member->name }}" class="team-photo" loading="lazy">
          @else
          <div class="team-photo team-photo--placeholder">
            {{ strtoupper(substr($member->name, 0, 1)) }}
          </div>
          @endif
        </div>
        <div class="team-info">
          <h3 class="team-name">{{ $member->name }}</h3>
          @if($member->role)
          <span class="team-role">{{ $member->role }}</span>
          @endif
          @if($member->bio)
          <p class="team-bio">{{ $member->bio }}</p>
          @endif
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>
@endif


<!-- ═══════════════════════════════════════════
     PARALLAX BANNER 1
════════════════════════════════════════════ -->
<div class="parallax-banner">
  <div class="parallax-bg parallax-bg--subtle"
       style="background-image: url('{{ $pageSettings->parallax1_image_url ?: 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=1800&q=80' }}');"
       data-parallax-speed="0.4"></div>
  <div class="parallax-banner-content">
    @if($pageSettings->parallax1_tag)
    <span class="section-tag reveal" style="display:block;margin-bottom:16px;">{{ $pageSettings->parallax1_tag }}</span>
    @endif
    <h2 class="parallax-banner-title reveal">{!! nl2br(e($pageSettings->parallax1_title)) !!}</h2>
    @if($pageSettings->parallax1_body)
    <p class="parallax-banner-body reveal">{{ $pageSettings->parallax1_body }}</p>
    @endif
    @if($pageSettings->parallax1_cta)
    <a href="{{ route('portfolio') }}" class="btn-primary reveal">{{ $pageSettings->parallax1_cta }}</a>
    @endif
  </div>
</div>


<!-- ═══════════════════════════════════════════
     SERVICES — LIGHT section
════════════════════════════════════════════ -->
<section id="services" class="services-section--light">
  <div class="services-inner">
    <div class="services-top">
      <div>
        <span class="section-tag reveal">{{ $pageSettings->services_tag }}</span>
        <h2 class="section-title reveal" style="color: var(--light-heading);">{!! nl2br(e($pageSettings->services_title)) !!}</h2>
      </div>
      @if($pageSettings->services_description)
      <p class="section-body reveal" style="max-width:380px; color: var(--light-muted);">{{ $pageSettings->services_description }}</p>
      @endif
    </div>
    <div class="services-grid">
      @foreach($services as $i => $service)
      <div class="service-card reveal{{ $i % 3 > 0 ? ' reveal-delay-'.($i % 3) : '' }}">
        <div class="service-num">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</div>
        <div class="service-title">{{ $service->title }}</div>
        <p class="service-desc">{{ $service->description }}</p>
        <a href="#contact" class="service-link">{{ $i >= 4 ? ($i === 4 ? 'Enquire →' : 'Learn More →') : 'Book Now →' }}</a>
      </div>
      @endforeach
    </div>
  </div>
</section>


<!-- ═══════════════════════════════════════════
     TESTIMONIAL — dark
════════════════════════════════════════════ -->
@php
  $testimonialData = $testimonials->map(function($t) {
    return [
      'text'   => '"' . $t->quote . '"',
      'name'   => $t->name,
      'role'   => $t->role,
      'avatar' => $t->avatar_url ?? 'https://i.ibb.co/Lhpg3qYZ/team-2.jpg',
    ];
  })->values()->toArray();
  $firstT = $testimonials->first();
@endphp
<div class="testimonial-section testimonial-section--dark">
  <div class="testimonial-inner"
       id="testimonialInner"
       data-testimonials="{{ json_encode($testimonialData) }}">
    <div class="testimonial-stars">
      <span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span>
    </div>
    <p class="testimonial-text" id="testimonialText">"{{ $firstT->quote ?? 'Keenkings Media brought our vision to life with their incredible storytelling. Their passion and creativity are truly unmatched.' }}"</p>
    <div class="testimonial-author">
      <img class="testimonial-avatar" id="testimonialAvatar"
           src="{{ $firstT->avatar_url ?? 'https://i.ibb.co/Lhpg3qYZ/team-2.jpg' }}"
           alt="{{ $firstT->name ?? 'Client' }}"/>
      <div>
        <div class="testimonial-name" id="testimonialName">{{ $firstT->name ?? 'Joshua Phiri' }}</div>
        <div class="testimonial-role" id="testimonialRole">{{ $firstT->role ?? 'Editor, 2024' }}</div>
      </div>
    </div>
    <div class="testimonial-dots">
      @foreach($testimonials as $i => $t)
      <div class="dot {{ $i === 0 ? 'active' : '' }}" onclick="setTestimonial({{ $i }})"></div>
      @endforeach
    </div>
  </div>
</div>


<!-- ═══════════════════════════════════════════
     CLIENTS MARQUEE
════════════════════════════════════════════ -->
@if($clientRows->isNotEmpty())
@php
  $row1 = $clientRows->get(1, collect());
  $row2 = $clientRows->get(2, collect());
  $row3 = $clientRows->get(3, collect());
  $all  = $clientRows->flatten();
  if ($row1->isEmpty()) $row1 = $all;
  if ($row2->isEmpty()) $row2 = $all;
  if ($row3->isEmpty()) $row3 = $all;
@endphp
<section class="clients-section">
  <div class="clients-header reveal">
    <span class="section-tag" style="display:block;margin-bottom:10px;">{{ $pageSettings->clients_tag }}</span>
    <h2 class="section-title" style="color:var(--white);">{{ $pageSettings->clients_title }}</h2>
  </div>

  <div class="clients-track-wrap">

    {{-- Row 1: scrolls left --}}
    <div class="clients-row">
      <div class="clients-track clients-track--left">
        @for($rep = 0; $rep < 2; $rep++)
          @foreach($row1 as $client)
          <div class="clients-logo-item">
            @if($client->website_url)
            <a href="{{ $client->website_url }}" target="_blank" rel="noopener" class="clients-logo">
            @else
            <div class="clients-logo">
            @endif
              @if($client->logo_url)
              <img src="{{ $client->logo_url }}" alt="{{ $client->name }}" loading="lazy">
              @else
              <span class="clients-logo-text">{{ strtoupper($client->name) }}</span>
              @endif
            @if($client->website_url)</a>@else</div>@endif
          </div>
          @endforeach
        @endfor
      </div>
    </div>

    {{-- Row 2: scrolls right (reversed) --}}
    <div class="clients-row">
      <div class="clients-track clients-track--right">
        @for($rep = 0; $rep < 2; $rep++)
          @foreach($row2->reverse()->values() as $client)
          <div class="clients-logo-item">
            @if($client->website_url)
            <a href="{{ $client->website_url }}" target="_blank" rel="noopener" class="clients-logo">
            @else
            <div class="clients-logo">
            @endif
              @if($client->logo_url)
              <img src="{{ $client->logo_url }}" alt="{{ $client->name }}" loading="lazy">
              @else
              <span class="clients-logo-text">{{ strtoupper($client->name) }}</span>
              @endif
            @if($client->website_url)</a>@else</div>@endif
          </div>
          @endforeach
        @endfor
      </div>
    </div>

    {{-- Row 3: scrolls left (different speed) --}}
    <div class="clients-row">
      <div class="clients-track clients-track--left clients-track--slow">
        @for($rep = 0; $rep < 2; $rep++)
          @foreach($row3 as $client)
          <div class="clients-logo-item">
            @if($client->website_url)
            <a href="{{ $client->website_url }}" target="_blank" rel="noopener" class="clients-logo">
            @else
            <div class="clients-logo">
            @endif
              @if($client->logo_url)
              <img src="{{ $client->logo_url }}" alt="{{ $client->name }}" loading="lazy">
              @else
              <span class="clients-logo-text">{{ strtoupper($client->name) }}</span>
              @endif
            @if($client->website_url)</a>@else</div>@endif
          </div>
          @endforeach
        @endfor
      </div>
    </div>

  </div>
</section>
@endif


<!-- ═══════════════════════════════════════════
     PARALLAX BANNER 2
════════════════════════════════════════════ -->
<div class="parallax-banner">
  <div class="parallax-bg"
       style="background-image: url('{{ $pageSettings->parallax2_image_url ?: 'https://images.unsplash.com/photo-1483653364400-eedcfb9f1f88?w=1800&q=80' }}');"
       data-parallax-speed="0.35"></div>
  <div class="parallax-banner-content">
    @if($pageSettings->parallax2_tag)
    <span class="section-tag reveal" style="display:block;margin-bottom:16px;">{{ $pageSettings->parallax2_tag }}</span>
    @endif
    <h2 class="parallax-banner-title reveal">{!! nl2br(e($pageSettings->parallax2_title)) !!}</h2>
    @if($pageSettings->parallax2_body)
    <p class="parallax-banner-body reveal">{{ $pageSettings->parallax2_body }}</p>
    @endif
  </div>
</div>


<!-- ═══════════════════════════════════════════
     PROCESS — WHITE section
════════════════════════════════════════════ -->
<section id="process" class="section--light-alt">
  <div class="process-inner">
    <div class="process-header">
      <span class="section-tag reveal">{{ $pageSettings->process_tag }}</span>
      <h2 class="section-title reveal">{{ $pageSettings->process_title }}</h2>
    </div>
    <div class="process-steps">
      @foreach($processSteps as $i => $step)
      <div class="process-step reveal{{ $i > 0 ? ' reveal-delay-'.$i : '' }}">
        <div class="process-step-title">{{ $step->title }}</div>
        <p class="process-step-desc">{{ $step->description }}</p>
      </div>
      @endforeach
    </div>
  </div>
</section>


<!-- ═══════════════════════════════════════════
     PARALLAX BANNER 3 — CTA strip
════════════════════════════════════════════ -->
<div class="parallax-banner">
  <div class="parallax-bg parallax-bg--subtle"
       style="background-image: url('{{ $pageSettings->parallax3_image_url ?: 'https://images.unsplash.com/photo-1509048191080-d2984bad6ae5?w=1800&q=80' }}');"
       data-parallax-speed="0.45"></div>
  <div class="parallax-banner-content">
    <h2 class="parallax-banner-title reveal">{!! nl2br(e($pageSettings->parallax3_title)) !!}</h2>
    @if($pageSettings->parallax3_body)
    <p class="parallax-banner-body reveal">{{ $pageSettings->parallax3_body }}</p>
    @endif
    @if($pageSettings->parallax3_cta)
    <a href="#contact" class="btn-primary reveal">{{ $pageSettings->parallax3_cta }}</a>
    @endif
  </div>
</div>


<!-- ═══════════════════════════════════════════
     CONTACT — LIGHT section
════════════════════════════════════════════ -->
@php $contactServices = $pageSettings->contact_services ?: ['Photography','Videography','Digital Marketing','Branding Consultancy','Content Production','Event Coverage']; @endphp
<section id="contact" class="contact-section--light">
  <div class="contact-inner">
    <div class="contact-info">
      <span class="section-tag reveal">{{ $pageSettings->contact_tag }}</span>
      <h2 class="section-title reveal" style="color: var(--light-heading);">{!! nl2br(e($pageSettings->contact_title)) !!}</h2>
      @if($pageSettings->contact_description)
      <p class="section-body reveal" style="color: var(--light-muted);">{{ $pageSettings->contact_description }}</p>
      @endif
      <div class="contact-details">
        @if($pageSettings->contact_email)
        <div class="contact-detail-item reveal">
          <div class="contact-detail-icon">✉</div>
          <div>
            <div class="contact-detail-label">Email</div>
            <div class="contact-detail-value">{{ $pageSettings->contact_email }}</div>
          </div>
        </div>
        @endif
        @if($pageSettings->contact_phone)
        <div class="contact-detail-item reveal reveal-delay-1">
          <div class="contact-detail-icon">☎</div>
          <div>
            <div class="contact-detail-label">Phone</div>
            <div class="contact-detail-value">{{ $pageSettings->contact_phone }}</div>
          </div>
        </div>
        @endif
        @if($pageSettings->contact_address)
        <div class="contact-detail-item reveal reveal-delay-2">
          <div class="contact-detail-icon">◎</div>
          <div>
            <div class="contact-detail-label">Studio</div>
            <div class="contact-detail-value">{{ $pageSettings->contact_address }}</div>
          </div>
        </div>
        @endif
      </div>
    </div>
    <form class="contact-form reveal" action="{{ route('contact.send') }}" method="POST">
      @csrf
      @if(session('success'))
      <div style="padding:14px 18px; background:#1a3a1a; border:1px solid rgba(255,255,255,.15); color:#8fd48f; margin-bottom:24px; font-size:13px;">
        {{ session('success') }}
      </div>
      @endif
      <div class="form-row">
        <div class="form-group">
          <label>First Name</label>
          <input type="text" name="first_name" placeholder="Your first name" value="{{ old('first_name') }}"/>
        </div>
        <div class="form-group">
          <label>Last Name</label>
          <input type="text" name="last_name" placeholder="Your last name" value="{{ old('last_name') }}"/>
        </div>
      </div>
      <div class="form-group">
        <label>Email Address</label>
        <input type="email" name="email" placeholder="you@example.com" value="{{ old('email') }}"/>
        @error('email')<span style="font-size:11px;color:#e07070;">{{ $message }}</span>@enderror
      </div>
      <div class="form-group">
        <label>Service Interested In</label>
        <select name="service">
          <option value="">Select a service...</option>
          @foreach($contactServices as $svc)
          <option {{ old('service') === $svc ? 'selected' : '' }}>{{ $svc }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label>Tell Us About Your Project</label>
        <textarea name="message" placeholder="Describe your vision, dates, location, any special requests...">{{ old('message') }}</textarea>
        @error('message')<span style="font-size:11px;color:#e07070;">{{ $message }}</span>@enderror
      </div>
      <button type="submit" class="submit-btn">Send Message →</button>
    </form>
  </div>
</section>

@endsection
