<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'Keenkings — Photography Portfolio')</title>
<meta name="description" content="@yield('description', 'Keenkings Media is a dynamic media production studio based in Lusaka, Zambia. Est. 2016.')">
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
    <img src="{{ asset('images/KEEN-KINGS-LOGO WHITE.png') }}" alt="Keen Kings Media" style="height:38px;width:auto;display:block;">
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
<footer>
  <div class="footer-top">
    <div class="footer-brand">
      <a href="{{ route('home') }}" class="nav-logo">
        <img src="{{ asset('images/KEEN-KINGS-LOGO WHITE.png') }}" alt="Keen Kings Media" style="height:40px;width:auto;display:block;">
      </a>
      <p>Dynamic media production studio based in Lusaka. Specializing in storytelling, digital content creation, and brand development since 2016.</p>
      <div class="social-links">
        <a href="#" class="social-link">ig</a>
        <a href="#" class="social-link">fb</a>
        <a href="#" class="social-link">yt</a>
        <a href="#" class="social-link">li</a>
      </div>
    </div>
    <div class="footer-col">
      <h4>Services</h4>
      <ul>
        <li><a href="{{ route('home') }}#services">Portrait Sessions</a></li>
        <li><a href="{{ route('home') }}#services">Wedding Photography</a></li>
        <li><a href="{{ route('home') }}#services">Editorial &amp; Fashion</a></li>
        <li><a href="{{ route('home') }}#services">Commercial Work</a></li>
        <li><a href="{{ route('home') }}#services">Fine Art Prints</a></li>
        <li><a href="{{ route('home') }}#services">Workshops</a></li>
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
    <div class="footer-col">
      <h4>Connect</h4>
      <ul>
        <li><a href="#">Instagram</a></li>
        <li><a href="#">Facebook</a></li>
        <li><a href="#">Pinterest</a></li>
        <li><a href="#">LinkedIn</a></li>
        <li><a href="#">Behance</a></li>
      </ul>
    </div>
  </div>
  <div class="footer-bottom">
    <p>© {{ date('Y') }} Keenkings Media. All rights reserved.</p>
    <p><a href="#">Privacy Policy</a> · <a href="#">Terms of Use</a></p>
  </div>
</footer>

<script src="{{ asset('js/zoomin.js') }}"></script>
@stack('scripts')
</body>
</html>
