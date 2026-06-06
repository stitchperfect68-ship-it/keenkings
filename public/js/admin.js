/* ============================================================
   KEENKINGS MEDIA — ADMIN.JS
   ============================================================ */

document.addEventListener('DOMContentLoaded', () => {

  // ── Feather Icons ──
  if (window.feather) feather.replace();

  // ── Theme Toggle ──
  const html = document.documentElement;
  const savedTheme = localStorage.getItem('kk_admin_theme') || 'dark';
  html.setAttribute('data-theme', savedTheme);

  document.querySelectorAll('#adminThemeToggle').forEach(btn => {
    btn.addEventListener('click', () => {
      const next = html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
      html.setAttribute('data-theme', next);
      localStorage.setItem('kk_admin_theme', next);
      if (window.feather) feather.replace();
    });
  });

  // ── Mobile Sidebar ──
  const sidebar = document.getElementById('adminSidebar');
  const mobileBtn = document.getElementById('mobileMenuBtn');
  if (mobileBtn && sidebar) {
    mobileBtn.addEventListener('click', () => {
      sidebar.classList.toggle('open');
    });
    // Close on outside click
    document.addEventListener('click', e => {
      if (sidebar.classList.contains('open') && !sidebar.contains(e.target) && !mobileBtn.contains(e.target)) {
        sidebar.classList.remove('open');
      }
    });
  }

  // ── Sidebar Collapse (desktop) ──
  const collapseBtn = document.getElementById('sidebarCollapse');
  if (collapseBtn) {
    const savedCollapsed = localStorage.getItem('kk_sidebar_collapsed') === 'true';
    if (savedCollapsed) collapseSidebar(true);

    collapseBtn.addEventListener('click', () => {
      const isNow = sidebar.style.width === '60px';
      collapseSidebar(!isNow);
    });
  }

  function collapseSidebar(collapse) {
    if (!sidebar) return;
    sidebar.style.width = collapse ? '60px' : '';
    document.querySelector('.admin-main').style.marginLeft = collapse ? '60px' : '';
    localStorage.setItem('kk_sidebar_collapsed', collapse);
    if (window.feather) feather.replace();
  }

  // ── Auto-dismiss flash alerts ──
  const flash = document.getElementById('flashAlert');
  if (flash) {
    setTimeout(() => {
      flash.style.transition = 'opacity 0.4s';
      flash.style.opacity = '0';
      setTimeout(() => flash.remove(), 400);
    }, 4000);
  }

  // ── Confirm delete on all .confirm-delete links ──
  document.querySelectorAll('[data-confirm]').forEach(el => {
    el.addEventListener('click', e => {
      if (!confirm(el.dataset.confirm)) e.preventDefault();
    });
  });

  // ── Re-run feather after dynamic content ──
  const observer = new MutationObserver(() => {
    if (window.feather) feather.replace();
  });
  observer.observe(document.body, { childList: true, subtree: true });
});
