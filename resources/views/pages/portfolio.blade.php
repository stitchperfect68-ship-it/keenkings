@extends('layouts.app')

@section('title', 'Portfolio — Keenkings Media')
@section('description', 'Browse our photography, videography and graphic design portfolio. Lusaka, Zambia.')

{{-- Enhanced lightbox for the portfolio page --}}
@section('lightbox')
<div class="lightbox" id="lightbox">
  <button class="lightbox-close" onclick="closeLightbox()">✕</button>
  <button class="lb-arrow lb-arrow--prev" onclick="lbNav(-1)">
    <svg width="12" height="12" viewBox="0 0 12 12" fill="none"><path d="M8 1L3 6l5 5" stroke="white" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/></svg>
  </button>
  <div class="lightbox-media" id="lightboxMedia"></div>
  <button class="lb-arrow lb-arrow--next" onclick="lbNav(1)">
    <svg width="12" height="12" viewBox="0 0 12 12" fill="none"><path d="M4 1l5 5-5 5" stroke="white" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/></svg>
  </button>
</div>
@endsection

@push('head')
<style>
.filter-bar {
  position: sticky; top: 0; z-index: 90;
  background: var(--off-black);
  border-bottom: 1px solid var(--border-dark);
  transition: box-shadow .3s;
}
.filter-bar.raised { box-shadow: 0 4px 32px rgba(0,0,0,.6); }

.parent-tabs {
  display: flex;
  max-width: var(--max-wide); margin: 0 auto;
  padding: 0 var(--space-xl);
  border-bottom: 1px solid var(--border-dark);
  overflow-x: auto; scrollbar-width: none;
}
.parent-tabs::-webkit-scrollbar { display: none; }

.parent-tab {
  display: flex; align-items: center; gap: 10px;
  padding: 20px 32px;
  font-family: var(--font-sans); font-size: 11px; font-weight: 400;
  letter-spacing: .22em; text-transform: uppercase;
  color: var(--muted-dark); background: none; border: none;
  border-bottom: 2px solid transparent; margin-bottom: -1px;
  cursor: pointer; white-space: nowrap;
  transition: color .3s, border-color .3s;
}
.parent-tab svg { width:16px; height:16px; opacity:.45; transition:opacity .3s; flex-shrink:0; }
.parent-tab:hover { color: var(--off-white); }
.parent-tab:hover svg { opacity: .75; }
.parent-tab.active { color: var(--white); border-bottom-color: var(--accent); }
.parent-tab.active svg { opacity: 1; }
.tab-count {
  font-size: 10px; background: var(--mid); color: var(--muted-dark);
  padding: 2px 7px; border-radius: 20px; transition: background .3s, color .3s; font-weight: 400;
}
.parent-tab.active .tab-count { background: rgba(137,221,223,.18); color: var(--accent); }

.sub-filter-row {
  max-width: var(--max-wide); margin: 0 auto;
  padding: 14px var(--space-xl);
  display: flex; align-items: center; gap: 8px;
  overflow-x: auto; scrollbar-width: none;
}
.sub-filter-row::-webkit-scrollbar { display: none; }
.chip {
  padding: 6px 16px;
  font-family: var(--font-sans); font-size: 11px; font-weight: 400;
  letter-spacing: .14em; text-transform: uppercase;
  color: var(--muted-dark); border: 1px solid var(--border-dark);
  background: transparent; cursor: pointer; white-space: nowrap;
  transition: border-color .2s, color .2s, background .2s;
}
.chip:hover { border-color: rgba(137,221,223,.4); color: var(--off-white); }
.chip.active { border-color: var(--accent); color: var(--black); background: var(--accent); }

.filter-summary {
  padding: 9px var(--space-xl);
  max-width: var(--max-wide); margin: 0 auto;
  display: flex; align-items: center; gap: 12px;
  font-size: 12px; color: var(--muted-dark);
  border-top: 1px solid var(--border-dark);
}
.filter-summary strong { color: var(--accent); font-weight: 400; }
.filter-clear {
  margin-left: auto; font-size: 11px; letter-spacing: .14em; text-transform: uppercase;
  color: var(--muted-dark); background: none; border: none; cursor: pointer;
  font-family: var(--font-sans); display: flex; align-items: center; gap: 6px;
  transition: color .3s;
}
.filter-clear:hover { color: var(--accent); }

.gallery-section { padding: 48px var(--space-xl) 100px; background: var(--black); min-height: 70vh; }
.gallery-inner { max-width: var(--max-wide); margin: 0 auto; }
.results-bar {
  display: flex; align-items: center; justify-content: space-between;
  margin-bottom: 24px; padding-bottom: 18px; border-bottom: 1px solid var(--border-dark);
}
.results-count { font-size: 12px; color: var(--muted-dark); letter-spacing: .1em; }
.results-count strong { color: var(--off-white); font-weight: 400; }
.view-toggles { display: flex; gap: 4px; }
.view-btn {
  width: 32px; height: 32px; border: 1px solid var(--border-dark);
  background: none; cursor: pointer; display: flex; align-items: center; justify-content: center;
  transition: border-color .3s;
}
.view-btn svg { opacity: .35; transition: opacity .3s; }
.view-btn.active { border-color: rgba(137,221,223,.5); }
.view-btn.active svg { opacity: 1; }

.gallery-grid {
  display: grid; grid-template-columns: repeat(4,1fr); gap: 3px;
  transition: opacity .3s, transform .3s;
}
.gallery-grid.masonry { grid-template-columns: repeat(3,1fr); align-items: start; }

.gallery-item {
  position: relative; overflow: hidden; cursor: pointer;
  aspect-ratio: 1/1; background: var(--dark);
}
.gallery-item.tall    { aspect-ratio: 3/4; }
.gallery-item.wide    { grid-column: span 2; aspect-ratio: 16/9; }
.gallery-item.feature { grid-column: span 2; grid-row: span 2; aspect-ratio: 1/1; }
.gallery-grid.masonry .gallery-item,
.gallery-grid.masonry .gallery-item.tall,
.gallery-grid.masonry .gallery-item.wide,
.gallery-grid.masonry .gallery-item.feature {
  grid-column: span 1; grid-row: span 1; aspect-ratio: 4/5;
}

.gallery-item img {
  width: 100%; height: 100%; object-fit: cover; display: block;
  transition: transform .7s var(--ease), filter .4s;
  filter: brightness(.88) saturate(.95);
}
.gallery-item:hover img { transform: scale(1.06); filter: brightness(.6) saturate(.8); }

.gitem-overlay {
  position: absolute; inset: 0;
  background: linear-gradient(160deg, transparent 40%, rgba(10,10,10,.9) 100%);
  opacity: 0; transition: opacity .4s;
  display: flex; flex-direction: column; justify-content: flex-end; padding: 22px;
}
.gallery-item:hover .gitem-overlay { opacity: 1; }
.gitem-parent { font-size: 9px; letter-spacing: .22em; text-transform: uppercase; color: var(--accent); margin-bottom: 3px; }
.gitem-title  { font-family: var(--font-serif); font-size: 17px; font-weight: 300; color: var(--white); line-height: 1.2; margin-bottom: 5px; }
.gitem-sub    { font-size: 10px; letter-spacing: .14em; text-transform: uppercase; color: rgba(255,255,255,.45); }

.type-badge {
  position: absolute; top: 14px; left: 14px;
  padding: 3px 9px; font-size: 9px; letter-spacing: .16em;
  text-transform: uppercase; font-family: var(--font-sans); font-weight: 400;
  pointer-events: none;
}
.badge-photo    { background: rgba(10,10,10,.55);  color: var(--off-white); }
.badge-video    { background: rgba(20,40,80,.75);  color: #92b8f0; }
.badge-graphics { background: rgba(50,25,5,.75);   color: #89dddf; }

.play-btn {
  position: absolute; top: 50%; left: 50%;
  transform: translate(-50%,-50%) scale(.75);
  width: 54px; height: 54px;
  border: 1.5px solid rgba(255,255,255,.55); border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  opacity: 0; transition: opacity .35s, transform .35s; pointer-events: none;
}
.gallery-item:hover .play-btn { opacity: 1; transform: translate(-50%,-50%) scale(1); }

.gallery-empty { grid-column: 1/-1; padding: 100px; text-align: center; }
.gallery-empty-icon { font-size: 40px; opacity: .15; margin-bottom: 16px; }
.gallery-empty h3 { font-family: var(--font-serif); font-size: 26px; font-weight: 300; color: var(--white); margin-bottom: 10px; }
.gallery-empty p  { font-size: 14px; color: var(--muted-dark); }

/* Enhanced lightbox */
.lightbox-media {
  position: relative;
  max-width: min(90vw,1100px);
  max-height: 88vh;
  display: flex; align-items: center; justify-content: center;
}
.lightbox-media img { max-width: 100%; max-height: 85vh; object-fit: contain; display: block; }
.lightbox-caption {
  position: absolute; bottom: -40px; left: 0; right: 0; text-align: center;
  font-family: var(--font-serif); font-size: 15px; font-weight: 300;
  color: var(--muted-dark); letter-spacing: .05em;
}
.lb-arrow {
  position: absolute; top: 50%; transform: translateY(-50%);
  width: 48px; height: 48px;
  border: 1px solid var(--border-dark); background: rgba(10,10,10,.7);
  display: flex; align-items: center; justify-content: center;
  cursor: pointer; z-index: 10; transition: border-color .3s, background .3s;
}
.lb-arrow:hover { border-color: var(--accent); background: rgba(137,221,223,.15); }
.lb-arrow--prev { left: -68px; }
.lb-arrow--next { right: -68px; }

@media (max-width: 1200px) {
  .gallery-grid { grid-template-columns: repeat(3,1fr); }
  .gallery-item.feature { grid-column: span 1; grid-row: span 1; aspect-ratio: 1/1; }
}
@media (max-width: 900px) {
  .gallery-grid { grid-template-columns: repeat(2,1fr); }
  .gallery-item.wide { grid-column: span 2; }
  .gallery-item.feature { grid-column: span 2; aspect-ratio: 16/9; }
  .parent-tabs, .sub-filter-row, .filter-summary { padding-left: 24px; padding-right: 24px; }
  .gallery-section { padding: 36px 24px 80px; }
  .lb-arrow--prev { left: 8px; } .lb-arrow--next { right: 8px; }
}
@media (max-width: 600px) {
  .gallery-grid { grid-template-columns: 1fr; }
  .gallery-item.wide, .gallery-item.feature { grid-column: span 1; aspect-ratio: 4/3; }
  .parent-tab { padding: 15px 18px; font-size: 10px; }
  .results-bar { flex-wrap: wrap; gap: 10px; }
}
</style>
@endpush

@section('content')

<!-- Page hero -->
<div class="page-hero">
  <div class="page-hero-bg" style="background-image:url('https://images.unsplash.com/photo-1542038784456-1ea8e935640e?w=1600&q=80');"></div>
  <div class="page-hero-content">
    <nav class="breadcrumb">
      <a href="{{ route('home') }}">Home</a>
      <span class="breadcrumb-sep">✦</span>
      <span class="breadcrumb-current" id="heroCrumb">Portfolio</span>
    </nav>
    <span class="section-tag" id="heroTag">Our Work</span>
    <h1 class="page-hero-title" id="heroTitle">The <em>Portfolio</em></h1>
  </div>
</div>

<!-- Filter bar -->
<div class="filter-bar" id="filterBar">
  <div class="parent-tabs" id="parentTabs">
    <button class="parent-tab active" data-parent="photography" onclick="setParent('photography')">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M23 19a2 2 0 01-2 2H3a2 2 0 01-2-2V8a2 2 0 012-2h4l2-3h6l2 3h4a2 2 0 012 2z"/><circle cx="12" cy="13" r="4"/></svg>
      Photography <span class="tab-count" id="count-photography">0</span>
    </button>
    <button class="parent-tab" data-parent="videography" onclick="setParent('videography')">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2"/></svg>
      Videography <span class="tab-count" id="count-videography">0</span>
    </button>
    <button class="parent-tab" data-parent="graphics" onclick="setParent('graphics')">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg>
      Graphics <span class="tab-count" id="count-graphics">0</span>
    </button>
  </div>
  <div class="sub-filter-row" id="subFilterRow"></div>
  <div class="filter-summary">
    <span>Showing: <strong id="summaryText">All Photography</strong></span>
    <span id="summaryCount" style="color:var(--muted-dark)"></span>
    <button class="filter-clear" id="clearBtn" onclick="clearSub()" style="display:none">
      <svg width="9" height="9" viewBox="0 0 9 9" fill="none"><path d="M1 1l7 7M8 1L1 8" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/></svg>
      Clear filter
    </button>
  </div>
</div>

<!-- Gallery -->
<div class="gallery-section">
  <div class="gallery-inner">
    <div class="results-bar">
      <p class="results-count"><strong id="resultsNum">0</strong>&nbsp;<span id="resultsLabel">works</span></p>
      <div class="view-toggles">
        <button class="view-btn active" id="btnGrid" onclick="setView('grid')" title="Grid">
          <svg width="13" height="13" viewBox="0 0 13 13" fill="none"><rect x="1" y="1" width="4" height="4" stroke="white" stroke-width="1"/><rect x="8" y="1" width="4" height="4" stroke="white" stroke-width="1"/><rect x="1" y="8" width="4" height="4" stroke="white" stroke-width="1"/><rect x="8" y="8" width="4" height="4" stroke="white" stroke-width="1"/></svg>
        </button>
        <button class="view-btn" id="btnMasonry" onclick="setView('masonry')" title="Masonry">
          <svg width="13" height="13" viewBox="0 0 13 13" fill="none"><rect x="1" y="1" width="4" height="7" stroke="white" stroke-width="1"/><rect x="8" y="1" width="4" height="4" stroke="white" stroke-width="1"/><rect x="8" y="8" width="4" height="4" stroke="white" stroke-width="1"/></svg>
        </button>
      </div>
    </div>
    <div class="gallery-grid" id="galleryGrid"></div>
  </div>
</div>

@endsection

@push('scripts')
<script>
var ITEMS = @json($items);
var SUBS  = @json($subs);

var HERO = {
  photography: {tag:'Photography', title:'Frames That <em>Speak</em>', crumb:'Photography'},
  videography: {tag:'Videography', title:'Stories in <em>Motion</em>', crumb:'Videography'},
  graphics: {tag:'Graphic Design', title:'Design That <em>Resonates</em>', crumb:'Graphics'}
};

var BADGE = {
  photography: {cls:'badge-photo', lbl:'Photo'},
  videography: {cls:'badge-video', lbl:'Video'},
  graphics: {cls:'badge-graphics', lbl:'Design'}
};

var RLABEL = {photography:'photographs', videography:'films', graphics:'designs'};

var S = {parent:'photography', sub:null, view:'grid'};
var LB_IDX = 0, LB_ITEMS = [];

document.addEventListener('DOMContentLoaded', function () {
  updateCounts();
  var hash = location.hash.replace('#','');
  setParent(HERO[hash] ? hash : 'photography', true);
  window.addEventListener('scroll', function(){
    document.getElementById('filterBar').classList.toggle('raised', scrollY > 260);
  },{passive:true});
});

function updateCounts() {
  ['photography','videography','graphics'].forEach(function(p){
    document.getElementById('count-'+p).textContent = ITEMS.filter(function(i){return i.p===p;}).length;
  });
}

function setParent(p, skipScroll) {
  S.parent=p; S.sub=null;
  document.querySelectorAll('.parent-tab').forEach(function(t){ t.classList.toggle('active',t.dataset.parent===p); });
  var h=HERO[p];
  document.getElementById('heroTag').textContent = h.tag;
  document.getElementById('heroTitle').innerHTML = h.title;
  document.getElementById('heroCrumb').textContent= h.crumb;
  renderChips(); renderGallery(); updateSummary();
  if(!skipScroll) document.getElementById('filterBar').scrollIntoView({behavior:'smooth',block:'start'});
  location.hash=p;
}

function renderChips() {
  var html='<button class="chip active" data-sub="" onclick="setSub(this,\'\')">All</button>';
  (SUBS[S.parent]||[]).forEach(function(c){
    html+='<button class="chip" data-sub="'+c.v+'" onclick="setSub(this,\''+c.v+'\')">'+c.l+'</button>';
  });
  document.getElementById('subFilterRow').innerHTML=html;
}

function setSub(btn,sub){
  S.sub=sub||null;
  document.querySelectorAll('.chip').forEach(function(c){ c.classList.toggle('active',c.dataset.sub===(sub||'')); });
  renderGallery(); updateSummary();
}

function clearSub(){
  S.sub=null;
  document.querySelectorAll('.chip').forEach(function(c){ c.classList.toggle('active',c.dataset.sub===''); });
  renderGallery(); updateSummary();
}

function getFiltered(){
  return ITEMS.filter(function(i){ return i.p===S.parent && (!S.sub||i.s===S.sub); });
}

function updateSummary(){
  var f=getFiltered();
  var subsForParent = SUBS[S.parent] || [];
  var sl=S.sub?(subsForParent.find(function(s){return s.v===S.sub;})||{}).l:'All';
  var pl=S.parent.charAt(0).toUpperCase()+S.parent.slice(1);
  document.getElementById('summaryText').textContent = sl+' '+pl;
  document.getElementById('summaryCount').textContent= f.length+' '+(RLABEL[S.parent]||'works');
  document.getElementById('resultsNum').textContent = f.length;
  document.getElementById('resultsLabel').textContent= RLABEL[S.parent]||'works';
  document.getElementById('clearBtn').style.display = S.sub?'':'none';
}

function renderGallery(){
  var grid=document.getElementById('galleryGrid');
  var items=getFiltered();
  LB_ITEMS=items;
  grid.className='gallery-grid'+(S.view==='masonry'?' masonry':'');

  if(!items.length){
    grid.innerHTML='<div class="gallery-empty"><div class="gallery-empty-icon">◎</div><h3>Nothing here yet</h3><p>No work found in this category.</p></div>';
    return;
  }

  var isVid=S.parent==='videography';
  var badge=BADGE[S.parent];
  var subsForParent = SUBS[S.parent] || [];

  var html=items.map(function(item,idx){
    var sc=item.sz?' '+item.sz:'';
    var play=isVid?'<div class="play-btn"><svg width="12" height="14" viewBox="0 0 12 14" fill="none"><path d="M1 1.5l10 5.5-10 5.5V1.5z" fill="white" fill-opacity=".9"/></svg></div>':'';
    var sl=(subsForParent.find(function(s){return s.v===item.s;})||{}).l||item.s;
    var pl=item.p.charAt(0).toUpperCase()+item.p.slice(1);
    return '<div class="gallery-item'+sc+'" onclick="openItem('+idx+')">'
      +'<img src="'+item.img+'" alt="'+item.t+'" loading="lazy"/>'
      +'<span class="type-badge '+badge.cls+'">'+badge.lbl+'</span>'
      +play
      +'<div class="gitem-overlay"><p class="gitem-parent">'+pl+'</p>'
      +'<h3 class="gitem-title">'+item.t+'</h3>'
      +'<p class="gitem-sub">'+sl+'</p></div></div>';
  }).join('');

  grid.style.opacity='0'; grid.style.transform='translateY(12px)';
  grid.style.transition='opacity .3s,transform .3s';
  setTimeout(function(){
    grid.innerHTML=html;
    requestAnimationFrame(function(){ grid.style.opacity='1'; grid.style.transform='translateY(0)'; });
  },150);
}

function setView(v){
  S.view=v;
  document.getElementById('btnGrid').classList.toggle('active',v==='grid');
  document.getElementById('btnMasonry').classList.toggle('active',v==='masonry');
  renderGallery();
}

function openItem(idx){
  LB_IDX=idx; renderLB();
  document.getElementById('lightbox').classList.add('open');
  document.body.style.overflow='hidden';
}

function renderLB(){
  var item=LB_ITEMS[LB_IDX]; if(!item) return;
  var subsForParent = SUBS[item.p] || [];
  var sl=(subsForParent.find(function(s){return s.v===item.s;})||{}).l||item.s;
  var m=document.getElementById('lightboxMedia');
  if(item.vid){
    m.innerHTML='<iframe src="'+item.vid+'" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen style="width:100%;aspect-ratio:16/9;max-width:960px;max-height:80vh;"></iframe>'
      +'<div class="lightbox-caption">'+item.t+' &nbsp;·&nbsp; '+sl+'</div>';
  } else {
    m.innerHTML='<img src="'+item.img+'" alt="'+item.t+'" style="max-width:min(90vw,1100px);max-height:85vh;object-fit:contain"/>'
      +'<div class="lightbox-caption">'+item.t+' &nbsp;·&nbsp; '+sl+'</div>';
  }
}

function lbNav(dir){
  LB_IDX=(LB_IDX+dir+LB_ITEMS.length)%LB_ITEMS.length;
  renderLB();
}

function closeLightbox(){
  document.getElementById('lightbox').classList.remove('open');
  document.body.style.overflow='';
}

document.addEventListener('keydown',function(e){
  if(!document.getElementById('lightbox').classList.contains('open')) return;
  if(e.key==='Escape') closeLightbox();
  if(e.key==='ArrowLeft') lbNav(-1);
  if(e.key==='ArrowRight') lbNav(1);
});
document.getElementById('lightbox').addEventListener('click',function(e){
  if(e.target===this) closeLightbox();
});
</script>
@endpush
