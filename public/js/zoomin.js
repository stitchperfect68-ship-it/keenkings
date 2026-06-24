/* ============================================================
   KEENKINGS PHOTOGRAPHY — SHARED JAVASCRIPT  v2
   Includes smooth parallax scrolling engine
   ============================================================ */

(function () {
  'use strict';

  /* ─── STICKY NAV + MOBILE TOGGLE ─── */
  var nav = document.getElementById('nav');
  var hamburger = document.querySelector('.nav-hamburger');
  var navLinks = document.querySelector('.nav-links');

  if (nav) {
    window.addEventListener('scroll', function () {
      nav.classList.toggle('scrolled', window.scrollY > 60);
    }, { passive: true });
  }

  if (hamburger && navLinks) {
    hamburger.addEventListener('click', function() {
      hamburger.classList.toggle('open');
      navLinks.classList.toggle('open');
      document.body.style.overflow = navLinks.classList.contains('open') ? 'hidden' : '';
    });
    navLinks.querySelectorAll('a').forEach(function(link) {
      link.addEventListener('click', function() {
        hamburger.classList.remove('open');
        navLinks.classList.remove('open');
        document.body.style.overflow = '';
      });
    });
  }

  /* Mark active nav link */
  var page = window.location.pathname.split('/').pop() || 'index.html';
  document.querySelectorAll('.nav-links a').forEach(function (a) {
    var href = (a.getAttribute('href') || '').replace(/^\.\//, '');
    if (href && href !== '#' && page.endsWith(href)) a.classList.add('active');
  });

  /* ─── HERO KEN BURNS ─── */
  var heroBg = document.getElementById('heroBg');
  if (heroBg) setTimeout(function () { heroBg.classList.add('loaded'); }, 100);

  /* ─── SCROLL REVEAL ─── */
  var revealEls = document.querySelectorAll('.reveal, .reveal-left, .reveal-right');
  if (revealEls.length && 'IntersectionObserver' in window) {
    var revealObs = new IntersectionObserver(function (entries) {
      entries.forEach(function (e) {
        if (e.isIntersecting) { e.target.classList.add('in'); revealObs.unobserve(e.target); }
      });
    }, { threshold: 0.12 });
    revealEls.forEach(function (el) { revealObs.observe(el); });
  } else {
    revealEls.forEach(function (el) { el.classList.add('in'); });
  }

  /* ─── PARALLAX ENGINE ─── */
  var parallaxEls = [];

  function collectParallax() {
    parallaxEls = [];
    document.querySelectorAll('.parallax-bg').forEach(function (el) {
      if (el.closest('.hero')) return;
      parallaxEls.push({
        el:       el,
        speed:    parseFloat(el.dataset.parallaxSpeed || '0.35'),
        current:  0,
        target:   0
      });
    });
  }
  collectParallax();

  var pageHeroBg = document.querySelector('.page-hero-bg');
  var pageHeroBgObj = null;
  if (pageHeroBg) {
    pageHeroBgObj = { el: pageHeroBg, speed: 0.25, current: 0, target: 0 };
  }

  var scrollY = 0;
  var ticking = false;

  function onScroll() {
    scrollY = window.scrollY;
    if (!ticking) { requestAnimationFrame(updateParallax); ticking = true; }
  }

  function updateParallax() {
    ticking = false;
    parallaxEls.forEach(function (p) {
      var rect   = p.el.parentElement.getBoundingClientRect();
      var inView = rect.bottom > 0 && rect.top < window.innerHeight;
      if (!inView) return;
      var sectionMid  = rect.top + rect.height / 2;
      var viewportMid = window.innerHeight / 2;
      p.target  = (sectionMid - viewportMid) * p.speed;
      p.current += (p.target - p.current) * 0.08;
      p.el.style.transform = 'translateY(' + p.current.toFixed(2) + 'px)';
    });
    if (pageHeroBgObj) {
      var p = pageHeroBgObj;
      p.target  = scrollY * p.speed;
      p.current += (p.target - p.current) * 0.08;
      p.el.style.transform = 'translateY(' + p.current.toFixed(2) + 'px)';
    }
    if (parallaxEls.length || pageHeroBgObj) {
      requestAnimationFrame(updateParallax);
      ticking = true;
    }
  }

  window.addEventListener('scroll', onScroll, { passive: true });
  if (parallaxEls.length || pageHeroBgObj) requestAnimationFrame(updateParallax);

  /* ─── STAT COUNTERS ─── */
  var statEls = document.querySelectorAll('.stat');
  if (statEls.length && 'IntersectionObserver' in window) {
    var statObs = new IntersectionObserver(function (entries) {
      entries.forEach(function (e) {
        if (!e.isIntersecting) return;
        var numEl = e.target.querySelector('.stat-number');
        if (!numEl || numEl.dataset.counted) return;
        numEl.dataset.counted = 'true';
        var target = parseInt(numEl.dataset.count, 10);
        var suffix = numEl.querySelector('span') ? numEl.querySelector('span').textContent : '';
        var start  = null;
        var dur    = 1800;
        (function step(ts) {
          if (!start) start = ts;
          var prog  = Math.min((ts - start) / dur, 1);
          var eased = 1 - Math.pow(1 - prog, 3);
          numEl.innerHTML = Math.round(eased * target) + '<span>' + suffix + '</span>';
          if (prog < 1) requestAnimationFrame(step);
        })(performance.now());
        statObs.unobserve(e.target);
      });
    }, { threshold: 0.5 });
    statEls.forEach(function (s) { statObs.observe(s); });
  }

  /* ─── PORTFOLIO FILTERS (home page preview) ─── */
  document.querySelectorAll('.filter-btn').forEach(function (btn) {
    btn.addEventListener('click', function () {
      document.querySelectorAll('.filter-btn').forEach(function (b) { b.classList.remove('active'); });
      btn.classList.add('active');
      var filter = btn.dataset.filter;
      document.querySelectorAll('.portfolio-item').forEach(function (item) {
        item.style.display = (filter === 'all' || item.dataset.cat === filter) ? '' : 'none';
      });
    });
  });

  /* ─── LIGHTBOX ─── */
  var lightbox = document.getElementById('lightbox');

  function openLightbox(el) {
    if (!lightbox) return;
    var media    = document.getElementById('lightbox-media');
    if (!media) return;
    var videoUrl = el.dataset && el.dataset.video ? el.dataset.video : '';
    if (videoUrl) {
      // Append autoplay to the embed URL
      var sep = videoUrl.indexOf('?') === -1 ? '?' : '&';
      media.innerHTML = '<iframe src="' + videoUrl + sep + 'autoplay=1" '
        + 'frameborder="0" allow="accelerometer; autoplay; clipboard-write; '
        + 'encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
    } else {
      var img = el.querySelector ? el.querySelector('img') : el;
      if (!img) return;
      media.innerHTML = '<img src="' + img.src + '" alt=""/>';
    }
    lightbox.classList.add('open');
    document.body.style.overflow = 'hidden';
  }
  function closeLightbox() {
    if (!lightbox) return;
    lightbox.classList.remove('open');
    document.body.style.overflow = '';
    // Clear media so the iframe stops playing
    var media = document.getElementById('lightbox-media');
    if (media) media.innerHTML = '';
  }
  if (lightbox) {
    lightbox.addEventListener('click', function (e) { if (e.target === lightbox) closeLightbox(); });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') closeLightbox(); });
  }
  document.querySelectorAll('[data-lightbox]').forEach(function (el) {
    el.addEventListener('click', function () { openLightbox(el); });
  });

  window.openLightbox  = openLightbox;
  window.closeLightbox = closeLightbox;

  /* ─── TESTIMONIAL CAROUSEL ─── */
  var testimonialWrap = document.getElementById('testimonialInner');
  if (testimonialWrap) {
    var testimonials;
    try { testimonials = JSON.parse(testimonialWrap.dataset.testimonials || 'null'); } catch(e) { testimonials = null; }
    testimonials = testimonials || [
      { text: '"Keenkings Media brought our vision to life with their incredible storytelling. Their passion and creativity are truly unmatched, making the entire process a pleasure."', name: 'Joshua Phiri', role: 'Editor, 2024', avatar: 'https://i.ibb.co/Lhpg3qYZ/team-2.jpg' },
      { text: '"The portrait session was an incredible experience. The Keenkings team has a gift for making you feel at ease, and the results were beyond anything I imagined."', name: 'Daniel Musonda', role: 'Founder, 2024', avatar: 'https://i.ibb.co/DHZDX87Y/team-1.jpg' },
      { text: '"Our brand presence was transformed by Keenkings\' vision. They understand light and story in a way that very few studios do. Exceptional."', name: 'Joyce Banda', role: 'Agency CEO, 2024', avatar: 'https://i.ibb.co/chZXP5Lp/team-3.jpg' }
    ];

    var currentT = 0;

    function setTestimonial(idx) {
      currentT = idx;
      var t      = testimonials[idx];
      var textEl = document.getElementById('testimonialText');
      var nameEl = document.getElementById('testimonialName');
      var roleEl = document.getElementById('testimonialRole');
      var avEl   = document.getElementById('testimonialAvatar');
      if (!textEl) return;
      textEl.style.opacity = '0';
      if (nameEl) nameEl.style.opacity = '0';
      if (roleEl) roleEl.style.opacity = '0';
      setTimeout(function () {
        textEl.textContent = t.text;
        if (nameEl) nameEl.textContent = t.name;
        if (roleEl) roleEl.textContent = t.role;
        if (avEl)   avEl.src = t.avatar;
        textEl.style.opacity = '1';
        if (nameEl) nameEl.style.opacity = '1';
        if (roleEl) roleEl.style.opacity = '1';
      }, 200);
      document.querySelectorAll('.dot').forEach(function (d, i) { d.classList.toggle('active', i === idx); });
    }
    window.setTestimonial = setTestimonial;
    setInterval(function () { setTestimonial((currentT + 1) % testimonials.length); }, 5000);
  }

  /* ─── FORM SUBMIT FEEDBACK ─── */
  document.querySelectorAll('.submit-btn').forEach(function (btn) {
    btn.addEventListener('click', function (e) {
      if (btn.closest('form')) return;
      e.preventDefault();
      var orig = btn.textContent;
      btn.textContent = 'Message Sent ✓';
      btn.style.background = '#4a7c59';
      btn.style.color = '#fff';
      setTimeout(function () {
        btn.textContent = orig;
        btn.style.background = btn.style.color = '';
      }, 3000);
    });
  });

  /* ─── TICKER ─── */
  var ticker = document.getElementById('ticker');
  if (ticker && !ticker.dataset.cloned) {
    ticker.dataset.cloned = '1';
    var orig = ticker.innerHTML;
    while (ticker.scrollWidth < window.innerWidth * 2.5) ticker.innerHTML += orig;
  }

  /* ─── PUBLIC API ─── */
  window.Keenkings = {
    openLightbox:    openLightbox,
    closeLightbox:   closeLightbox,
    setTestimonial:  window.setTestimonial || null,
    refreshParallax: collectParallax
  };

})();
