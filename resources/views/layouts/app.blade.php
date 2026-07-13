<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'Keenkings Media — Photography, Film & Creative Production | Lusaka, Zambia')</title>
<meta name="description" content="@yield('description', 'Keenkings Media is a Lusaka-based creative studio delivering world-class photography, videography, branding and digital content. We capture moments that move people.')">

{{-- Open Graph / Social Sharing --}}
@php $ogImage = asset('images/KEEN-KINGS-LOGO WHITE.png'); @endphp
<meta property="og:type"        content="website">
<meta property="og:site_name"   content="Keenkings Media">
<meta property="og:title"       content="@yield('og_title', 'Keenkings Media — Creative Studio, Lusaka Zambia')">
<meta property="og:description" content="@yield('og_description', 'Photography, film, branding and digital content production based in Lusaka, Zambia. Telling stories that move people.')">
<meta property="og:image"       content="{{ $ogImage }}">
<meta property="og:image:alt"   content="Keenkings Media Logo">
<meta property="og:url"         content="{{ url()->current() }}">

{{-- Twitter / X Card --}}
<meta name="twitter:card"        content="summary_large_image">
<meta name="twitter:title"       content="@yield('og_title', 'Keenkings Media — Creative Studio, Lusaka Zambia')">
<meta name="twitter:description" content="@yield('og_description', 'Photography, film, branding and digital content production based in Lusaka, Zambia. Telling stories that move people.')">
<meta name="twitter:image"       content="{{ $ogImage }}">
@php
    try {
        $siteSetting = \App\Models\SiteSetting::current();
    } catch (\Exception $e) {
        $siteSetting = null;
    }
    $fontCss      = '';
    $googleFontsUrl = null;

    if ($siteSetting && $siteSetting->font_preset === 'custom') {
        $serifName = $siteSetting->custom_serif_name ?: 'CustomSerif';
        $sansName  = $siteSetting->custom_sans_name  ?: 'CustomSans';
        if ($siteSetting->custom_serif_path) {
            $fontCss .= "@font-face{font-family:'{$serifName}';src:url('" . asset('storage/' . $siteSetting->custom_serif_path) . "');font-display:swap;}";
        }
        if ($siteSetting->custom_sans_path) {
            $fontCss .= "@font-face{font-family:'{$sansName}';src:url('" . asset('storage/' . $siteSetting->custom_sans_path) . "');font-display:swap;}";
        }
        $fontCss .= ":root{--font-serif:'{$serifName}',serif;--font-sans:'{$sansName}',sans-serif;}";
    } else {
        $headingFont = $siteSetting->heading_font ?? 'Cormorant Garamond';
        $bodyFont    = $siteSetting->body_font    ?? 'Jost';
        $googleFontsUrl = \App\Models\SiteSetting::googleFontsUrl($headingFont, $bodyFont);
        if ($headingFont !== 'Cormorant Garamond' || $bodyFont !== 'Jost') {
            $fontCss = ":root{--font-serif:'{$headingFont}',serif;--font-sans:'{$bodyFont}',sans-serif;}";
        }
    }
@endphp
@if($googleFontsUrl)
<link rel="preconnect" href="https://fonts.googleapis.com"/>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
<link href="{{ $googleFontsUrl }}" rel="stylesheet"/>
@endif
@if($fontCss)
<style>{!! $fontCss !!}</style>
@endif
<link rel="stylesheet" href="{{ asset('css/zoomin.css') }}"/>
<script src="https://unpkg.com/feather-icons/dist/feather.min.js" defer></script>
@stack('head')
</head>
<body>

<!-- Lightbox -->
@hasSection('lightbox')
  @yield('lightbox')
@else
<div class="lightbox" id="lightbox">
  <button class="lightbox-close" onclick="closeLightbox()">✕</button>
  <div id="lightbox-media"></div>
</div>
@endif

<!-- ─── NAV ─── -->
<nav id="nav">
  <a href="{{ route('home') }}" class="nav-logo">
    <img src="{{ $siteSetting?->logo_url ?? asset('images/KEEN-KINGS-LOGO WHITE.png') }}" alt="Keen Kings Media" style="height:38px;width:auto;display:block;">
  </a>
  <ul class="nav-links">
    <li><a href="{{ route('home') }}#about">About</a></li>
    <li><a href="{{ route('portfolio') }}"{{ request()->routeIs('portfolio') ? ' class="active"' : '' }}>Portfolio</a></li>
    <li><a href="{{ route('home') }}#services">Services</a></li>
    <li><a href="{{ route('blog') }}"{{ request()->routeIs('blog*') ? ' class="active"' : '' }}>Blog</a></li>
    <li><a href="{{ route('home') }}#contact">Contact</a></li>
  </ul>
  <button class="nav-hamburger" aria-label="Menu"><span></span><span></span><span></span></button>
</nav>

@yield('content')

<!-- ─── FOOTER ─── -->
@php
    try {
        $footerSettings  = \App\Models\PageSetting::current();
        $footerSocial    = \App\Models\SocialLink::active()->get();
        $footerServices  = \App\Models\Service::active()->take(6)->get();
    } catch (\Exception $e) {
        $footerSettings = null;
        $footerSocial   = collect();
        $footerServices = collect();
    }
@endphp
<footer>
  <div class="footer-top">
    <div class="footer-brand">
      <a href="{{ route('home') }}" class="nav-logo">
        <img src="{{ $siteSetting?->logo_url ?? asset('images/KEEN-KINGS-LOGO WHITE.png') }}" alt="Keen Kings Media" style="height:40px;width:auto;display:block;">
      </a>
      <p>{{ $footerSettings?->footer_description ?? 'Dynamic media production studio based in Lusaka. Specializing in storytelling, digital content creation, and brand development since 2016.' }}</p>
      @if($footerSocial->isNotEmpty())
      <div class="social-links">
        @foreach($footerSocial as $link)
        <a href="{{ $link->url }}" class="social-link" target="_blank" rel="noopener noreferrer" title="{{ $link->label }}">
          @if($link->icon)
          <i data-feather="{{ $link->icon }}" style="width:16px;height:16px;vertical-align:middle;"></i>
          @else
          {{ $link->platform }}
          @endif
        </a>
        @endforeach
      </div>
      @endif
    </div>
    <div class="footer-col">
      <h4>Services</h4>
      <ul>
        @if($footerServices->isNotEmpty())
          @foreach($footerServices as $svc)
          <li><a href="{{ route('home') }}#services">{{ $svc->title }}</a></li>
          @endforeach
        @else
          <li><a href="{{ route('home') }}#services">Photography</a></li>
          <li><a href="{{ route('home') }}#services">Videography</a></li>
          <li><a href="{{ route('home') }}#services">Digital Marketing</a></li>
          <li><a href="{{ route('home') }}#services">Branding</a></li>
          <li><a href="{{ route('home') }}#services">Content Production</a></li>
          <li><a href="{{ route('home') }}#services">Event Coverage</a></li>
        @endif
      </ul>
    </div>
    <div class="footer-col">
      <h4>Navigation</h4>
      <ul>
        <li><a href="{{ route('home') }}#home">Home</a></li>
        <li><a href="{{ route('home') }}#about">About</a></li>
        <li><a href="{{ route('portfolio') }}">Portfolio</a></li>
        <li><a href="{{ route('blog') }}">Blog</a></li>
        <li><a href="{{ route('home') }}#process">Process</a></li>
        <li><a href="{{ route('home') }}#contact">Contact</a></li>
      </ul>
    </div>
    @if($footerSocial->isNotEmpty())
    <div class="footer-col">
      <h4>Connect</h4>
      <ul>
        @foreach($footerSocial as $link)
        <li><a href="{{ $link->url }}" target="_blank" rel="noopener noreferrer">{{ $link->label }}</a></li>
        @endforeach
      </ul>
    </div>
    @endif
  </div>
  <div class="footer-bottom">
    <p>© {{ date('Y') }} {{ $footerSettings?->footer_copyright ?? 'Keenkings Media. All rights reserved.' }}</p>
  </div>
</footer>

<script src="{{ asset('js/zoomin.js') }}"></script>
<script>if(window.feather)feather.replace();</script>
@stack('scripts')
</body>
</html>
