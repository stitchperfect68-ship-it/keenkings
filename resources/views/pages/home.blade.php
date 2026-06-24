@extends('layouts.app')

@section('title', 'Keenkings — Photography Portfolio')
@section('description', 'Keenkings Media is a dynamic media production company specializing in storytelling, digital content creation, and brand development. Based in Lusaka, Zambia. Est. 2016.')

@section('content')

<!-- ═══════════════════════════════════════════
     HERO
════════════════════════════════════════════ -->
<section class="hero" id="home">
  <div class="hero-bg" id="heroBg" style="background-image: url('{{ $heroSlides->first()->image_url ?? 'https://images.unsplash.com/photo-1492691527719-9d1e07e534b4?w=1800&q=80' }}');"></div>
  <div class="hero-overlay"></div>
  <div class="hero-content">
    <span class="hero-tag">Media Production Studio</span>
    <h1 class="hero-title">Pictures with <em>Love</em><br/>for Creativity</h1>
    <p class="hero-desc">Keenkings Media is a dynamic media production company specializing in storytelling, digital content creation, and brand development. We bring your vision to life with precision and passion.</p>
    <div class="hero-actions">
      <a href="#portfolio" class="btn-primary">View Portfolio</a>
      <a href="#about" class="btn-ghost">About Us</a>
    </div>
  </div>
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
<div class="ticker">
  <div class="ticker-inner" id="ticker">
    <span class="ticker-item">Portrait Photography</span>
    <span class="ticker-item">Wedding Stories</span>
    <span class="ticker-item">Editorial Work</span>
    <span class="ticker-item">Commercial Shoots</span>
    <span class="ticker-item">Nature &amp; Landscape</span>
    <span class="ticker-item">Fine Art Prints</span>
    <span class="ticker-item">Fashion Photography</span>
    <span class="ticker-item">Event Coverage</span>
    <span class="ticker-item">Portrait Photography</span>
    <span class="ticker-item">Wedding Stories</span>
    <span class="ticker-item">Editorial Work</span>
    <span class="ticker-item">Commercial Shoots</span>
    <span class="ticker-item">Nature &amp; Landscape</span>
    <span class="ticker-item">Fine Art Prints</span>
    <span class="ticker-item">Fashion Photography</span>
    <span class="ticker-item">Event Coverage</span>
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
      <span class="section-tag reveal">About the Studio</span>
      <h2 class="section-title reveal">Where Vision<br/>Meets <em>Innovation</em></h2>
      <p class="section-body reveal">{{ $about->lead_text }}</p>
      <blockquote class="about-quote reveal">"Our commitment to creativity, innovation, and integrity drives us to deliver impactful content."</blockquote>
      <p class="section-body reveal">{{ $about->body_text }}</p>
      <div class="about-skills reveal">
        <span class="skill-pill">Photography</span>
        <span class="skill-pill">Videography</span>
        <span class="skill-pill">Digital Marketing</span>
        <span class="skill-pill">Branding</span>
        <span class="skill-pill">Consultancy</span>
        <span class="skill-pill">Social Media</span>
      </div>
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
        <span class="section-tag reveal">Selected Works</span>
        <h2 class="section-title reveal">Portfolio</h2>
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
     PARALLAX BANNER 1
════════════════════════════════════════════ -->
<div class="parallax-banner">
  <div class="parallax-bg parallax-bg--subtle"
       style="background-image: url('https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=1800&q=80');"
       data-parallax-speed="0.4"></div>
  <div class="parallax-banner-content">
    <span class="section-tag reveal" style="display:block;margin-bottom:16px;">The Art of Seeing</span>
    <h2 class="parallax-banner-title reveal">Every Frame is a<br/><em>Decision</em></h2>
    <p class="parallax-banner-body reveal">Photography is not about the camera. It is about the eye, the patience, and the quiet bravery to press the shutter at exactly the right moment.</p>
    <a href="{{ route('portfolio') }}" class="btn-primary reveal">Explore the Work</a>
  </div>
</div>


<!-- ═══════════════════════════════════════════
     SERVICES — LIGHT section
════════════════════════════════════════════ -->
<section id="services" class="services-section--light">
  <div class="services-inner">
    <div class="services-top">
      <div>
        <span class="section-tag reveal">What We Offer</span>
        <h2 class="section-title reveal" style="color: var(--light-heading);">Services &amp;<br/><em>Packages</em></h2>
      </div>
      <p class="section-body reveal" style="max-width:380px; color: var(--light-muted);">From intimate portrait sessions to full-scale commercial productions — we tailor every shoot to your vision.</p>
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
  // Fallback: if a row is empty, use all clients
  $all  = $clientRows->flatten();
  if ($row1->isEmpty()) $row1 = $all;
  if ($row2->isEmpty()) $row2 = $all;
  if ($row3->isEmpty()) $row3 = $all;
@endphp
<section class="clients-section">
  <div class="clients-header reveal">
    <span class="section-tag" style="display:block;margin-bottom:10px;">Trusted By</span>
    <h2 class="section-title" style="color:var(--white);">Our <em>Clients</em></h2>
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
       style="background-image: url('https://images.unsplash.com/photo-1483653364400-eedcfb9f1f88?w=1800&q=80');"
       data-parallax-speed="0.35"></div>
  <div class="parallax-banner-content">
    <span class="section-tag reveal" style="display:block;margin-bottom:16px;">Behind the Lens</span>
    <h2 class="parallax-banner-title reveal"><em>Light</em> Changes<br/>Everything</h2>
    <p class="parallax-banner-body reveal">From golden-hour portraits to the drama of controlled studio light — the right illumination transforms a good photograph into an unforgettable one.</p>
  </div>
</div>


<!-- ═══════════════════════════════════════════
     PROCESS — WHITE section
════════════════════════════════════════════ -->
<section id="process" class="section--light-alt">
  <div class="process-inner">
    <div class="process-header">
      <span class="section-tag reveal">How It Works</span>
      <h2 class="section-title reveal">Our Creative <em>Process</em></h2>
    </div>
    <div class="process-steps">
      <div class="process-step reveal">
        <div class="process-step-title">Discovery Call</div>
        <p class="process-step-desc">We start with a conversation. We learn about your vision, goals, and the story you want to tell. No commitment required.</p>
      </div>
      <div class="process-step reveal reveal-delay-1">
        <div class="process-step-title">Creative Planning</div>
        <p class="process-step-desc">From location scouting to mood boards, we prepare every detail to ensure your shoot runs smoothly and looks stunning.</p>
      </div>
      <div class="process-step reveal reveal-delay-2">
        <div class="process-step-title">The Shoot</div>
        <p class="process-step-desc">On the day, we guide and direct while keeping the atmosphere relaxed and authentic. Great images come from genuine moments.</p>
      </div>
      <div class="process-step reveal reveal-delay-3">
        <div class="process-step-title">Delivery</div>
        <p class="process-step-desc">Carefully retouched images delivered via a private gallery within 2–3 weeks. Print-ready files included with every package.</p>
      </div>
    </div>
  </div>
</section>


<!-- ═══════════════════════════════════════════
     PARALLAX BANNER 3 — CTA strip
════════════════════════════════════════════ -->
<div class="parallax-banner">
  <div class="parallax-bg parallax-bg--subtle"
       style="background-image: url('https://images.unsplash.com/photo-1509048191080-d2984bad6ae5?w=1800&q=80');"
       data-parallax-speed="0.45"></div>
  <div class="parallax-banner-content">
    <h2 class="parallax-banner-title reveal">Ready to Create<br/>Something <em>Beautiful?</em></h2>
    <p class="parallax-banner-body reveal">Whether it's a once-in-a-lifetime wedding, a brand campaign, or simply capturing who you are right now — let's talk.</p>
    <a href="#contact" class="btn-primary reveal">Start a Conversation</a>
  </div>
</div>


<!-- ═══════════════════════════════════════════
     CONTACT — LIGHT section
════════════════════════════════════════════ -->
<section id="contact" class="contact-section--light">
  <div class="contact-inner">
    <div class="contact-info">
      <span class="section-tag reveal">Get in Touch</span>
      <h2 class="section-title reveal" style="color: var(--light-heading);">Let's Create<br/><em>Something</em><br/>Beautiful</h2>
      <p class="section-body reveal" style="color: var(--light-muted);">Ready to start your photography journey? Fill out the form and we'll get back to you within 24 hours to discuss your project.</p>
      <div class="contact-details">
        <div class="contact-detail-item reveal">
          <div class="contact-detail-icon">✉</div>
          <div>
            <div class="contact-detail-label">Email</div>
            <div class="contact-detail-value">keenkingsmedia@gmail.com</div>
          </div>
        </div>
        <div class="contact-detail-item reveal reveal-delay-1">
          <div class="contact-detail-icon">☎</div>
          <div>
            <div class="contact-detail-label">Phone</div>
            <div class="contact-detail-value">[+260] 977 231 555</div>
          </div>
        </div>
        <div class="contact-detail-item reveal reveal-delay-2">
          <div class="contact-detail-icon">◎</div>
          <div>
            <div class="contact-detail-label">Studio</div>
            <div class="contact-detail-value">Medoreen Business Park, Plot 36998, Alick Nkhata Road, Mass Media, Lusaka</div>
          </div>
        </div>
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
          <option>Photography</option>
          <option>Videography</option>
          <option>Digital Marketing</option>
          <option>Branding Consultancy</option>
          <option>Content Production</option>
          <option>Event Coverage</option>
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
