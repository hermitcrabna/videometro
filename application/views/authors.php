<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!doctype html>
<html lang="it">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="<?= htmlspecialchars($pageDescription ?? 'I protagonisti di VideoMetro.') ?>" />
  <link rel="canonical" href="<?= htmlspecialchars($canonical ?? ($siteUrl . $basePath . '/protagonisti')) ?>" />
  <meta name="robots" content="<?= htmlspecialchars($robots ?? 'index, follow') ?>" />
  <meta property="og:type" content="website">
  <meta property="og:title" content="<?= htmlspecialchars($pageTitle ?? 'VideoMetro – Protagonisti') ?>">
  <meta property="og:description" content="<?= htmlspecialchars($pageDescription ?? 'I protagonisti di VideoMetro.') ?>">
  <meta property="og:url" content="<?= htmlspecialchars($canonical ?? ($siteUrl . $basePath . '/protagonisti')) ?>">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <title><?= htmlspecialchars($pageTitle ?? 'VideoMetro – Protagonisti') ?></title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap');
    :root {
      --bg: #0f1115;
      --bar: #1f2740;
      --bar-border: #2b3554;
      --text: #ffffff;
      --muted: rgba(255,255,255,.72);
      --card: #303a52;
      --card-border: rgba(255,255,255,.06);
      --accent: #ff2d2d;
      --badge-url: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="%23ff2d2d" stroke-width="2"><circle cx="12" cy="8" r="5"/><path d="M9 13v8l3-2 3 2v-8"/></svg>');
    }
    body { min-height:100vh; display:flex; flex-direction:column; margin:0; font-family: system-ui, Arial; background:var(--bg); color:var(--text); }
    .topbar { position: sticky; top: 0; z-index: 50; background: rgba(31,39,64,0.92); border-bottom: 1px solid var(--bar-border); backdrop-filter: blur(6px); }
    .topbar-inner { max-width: 1200px; margin: 0 auto; padding: 14px 16px; display:flex; align-items:center; gap: 14px; position: relative; transform: none; }
    .brand { font-weight: 700; font-size: 26px; letter-spacing: .2px; text-decoration:none; color:#fff; font-family: 'Montserrat', system-ui, Arial, sans-serif; display:inline-flex; align-items:center; position: relative; transform: translateY(-3px); }
    .brand .dot { color: var(--accent); font-size: 1.1em; }
    .brand-text { display:inline-flex; align-items:center; }
    .brand-skeleton { width: min(160px, 40vw); height: 24px; border-radius: 999px; background: linear-gradient(90deg, #2f3850 25%, #3a4563 50%, #2f3850 75%); background-size:200% 100%; animation: shimmer 1.2s infinite; display:none; position:absolute; left:0; top:50%; transform: translateY(-50%); pointer-events:none; }
    .brand.loading .brand-text { opacity: 0; }
    .brand.loading .brand-skeleton { display:inline-block; }
    .nav { display:flex; align-items:center; gap: 10px; color: var(--muted); font-size: 14px; font-family: 'Montserrat', system-ui, Arial, sans-serif; letter-spacing: .2px; }
        .nav > a, .nav > span, .nav > button, .nav .nav-cat { color: inherit; text-decoration: none; cursor: pointer; padding: 8px 12px; border-radius: 999px; display:inline-flex; align-items:center; gap:6px; transition: background .2s ease, color .2s ease; background: transparent; border: none; font: inherit; }
    .nav .caret { pointer-events: none; pointer-events: none; display:inline-block; width: 6px; height: 6px; position: relative; font-size: 0; line-height: 0; transform: translateY(1px); }
.nav > a:hover, .nav > span:hover, .nav > button:hover, .nav .nav-cat:hover { color: #fff; background: rgba(255,255,255,.08); }
    .nav .nav-cat { padding-right: 16px; }
    .mega { position:absolute; left:0; right:0; top:100%; background: rgba(24,30,49,0.98); border-bottom: 1px solid var(--bar-border); display:none; z-index: 40; }
    .mega.open { display:block; }
    .mega-inner { max-width: 1200px; margin: 0 auto; padding: 18px 16px 22px; display:flex; flex-wrap:wrap; gap: 10px 12px; }
    .mega a { padding: 10px 12px; border-radius: 999px; color: var(--muted); text-decoration:none; border: 1px solid rgba(255,255,255,.08); font-size: 13px; display:inline-flex; align-items:center; gap: 6px; }
    .mega a:hover { color:#fff; background: rgba(255,255,255,.08); }
    .mega-skeletons { display:flex; flex-wrap:wrap; gap:10px 12px; }
    .mega-pill { width:120px; height:28px; border-radius:999px; background: linear-gradient(90deg, #2f3850 25%, #3a4563 50%, #2f3850 75%); background-size:200% 100%; animation: shimmer 1.2s infinite; }
        .caret {display:inline-block; width: 6px; height: 6px; position: relative; font-size: 0; line-height: 0; transform: translateY(0); transform: translateY(1px); }
    .caret::before { content:""; display:block; width:6px; height:6px; border-right: 2px solid currentColor; border-bottom: 2px solid currentColor; transform: rotate(45deg) translateY(-5px); }
    .mobile-nav .caret {width: 9px; height: 9px; flex: 0 0 9px; margin-left: 8px; display:inline-block; transform: translateY(9px); transform: translateY(1px); }
    .mobile-nav .caret::before { content:""; display:block; width:6px; height:6px; border-right: 2px solid currentColor; border-bottom: 2px solid currentColor; transform: rotate(45deg) translateY(-5px); }
    .badge { width: 14px; height: 18px; flex: 0 0 auto; font-size: 0; border: none; color: transparent; background: no-repeat center/contain; background-image: var(--badge-url); }
.spacer { flex: 1; }
    .icon-btn { width: 36px; height: 36px; border-radius: 999px; border: none; background: transparent; color: #fff; display:grid; place-items:center; cursor:pointer; }
    .icon-btn svg { width: 18px; height: 18px; }
    .social-sep { width:1px; height:20px; background: rgba(255,255,255,.2); border-radius: 999px; display:none; }
    .socials { display:flex; align-items:center; gap:8px; }
    .socials a { width: 32px; height: 32px; border-radius: 100%; border:1px solid rgba(255,255,255,.12); display:grid; place-items:center; color:#fff; text-decoration:none; background: rgba(255,255,255,.04); }
    .socials a:hover { background: rgba(255,255,255,.1); }
    .socials svg { width:16px; height:16px; display:block; }
    .hamburger { width: 36px; height: 36px; border-radius: 10px; border: none; background: transparent; color: #fff; display:none; place-items:center; cursor:pointer; }
    .hamburger span { width: 18px; height: 2px; background: currentColor; display:block; position: relative; }
    .hamburger span::before, .hamburger span::after { content:""; position:absolute; left:0; width: 18px; height: 2px; background: currentColor; }
    .hamburger span::before { top:-6px; }
    .hamburger span::after { top:6px; }
    .search { display:none; align-items:center; gap: 10px; width: 100%; position: relative; }
    .search input { flex:1; height: 38px; border-radius: 999px; border: 1px solid rgba(255,255,255,.18); background:#151b2b; color:#fff; padding: 0 40px 0 14px; font-size: 15px; font-family: 'Montserrat', system-ui, Arial, sans-serif; }
    .search input::placeholder { color: rgba(255,255,255,.6); }
    .search.active { display:flex; }
    .clear-btn { width: 28px; height: 28px; border-radius: 999px; border: 1px solid rgba(255,80,80,.5); background: transparent; color: #ff6b6b; display:none; place-items:center; cursor:pointer; position:absolute; right: 6px; top: 50%; transform: translateY(-50%); }
    .clear-btn.visible { display:grid; }
    .clear-btn svg { width: 16px; height: 16px; }
    #navDynamic { display: contents; }
    .nav.hidden { display:none; }
    .mobile-nav { display:none; padding: 10px 16px 16px; border-bottom: 1px solid var(--bar-border); background: rgba(31,39,64,0.95); max-height: 60vh; overflow-y: auto; }
    .mobile-nav.open { display:block; }
    .mobile-nav a, .mobile-nav span { display:block; padding: 10px 12px; color: var(--muted); text-decoration:none; border-radius: 12px; background: transparent; border: none; width: 100%; text-align:left; font: inherit; cursor: pointer; margin:0; }
    .mobile-nav button { font-size: 14px; display:flex; align-items:center; justify-content:space-between; padding: 10px 12px; color: var(--muted); text-decoration:none; border-radius: 12px; background: transparent; border: none; width: 100%; text-align:left; font: inherit; cursor: pointer; gap: 8px; margin:0;  font-size: 14px; }
    .mobile-nav > a:hover, .mobile-nav > span:hover { color: #fff; background: rgba(255,255,255,.08); }
    .mobile-nav > button:hover { color: #fff; background: rgba(255,255,255,.08); }
    .mobile-sub a:hover { color:#fff; background: rgba(255,255,255,.08); }
    .mobile-sub { display:none; padding: 0; margin:0; height:0; overflow:hidden; }
    .mobile-sub.open { display:block; padding: 4px 0 4px 12px; height:auto; overflow:visible; }
    .mobile-sub a { font-size: 13px; padding: 8px 10px; margin:0; line-height:1.2; }
    .hide-mobile { display:inline-grid; }
    @media (max-width: 900px) {
      .nav { display:none; }
      .hamburger { display:grid; }
      .hide-mobile { display:none; }
      .searching-mobile .brand,
      .searching-mobile .hamburger { display:none; }
    }
    .wrap { flex:1; width:100%; max-width: 1200px; margin: 0 auto; padding: 0 16px 28px; box-sizing: border-box; }
    h1 { margin:22px 0 12px 0; font-size: 18px; font-weight: 600; }
    .banner { max-width: 1200px; margin: 0 auto; padding: 22px 16px 18px; }
    .banner img { width:100%; height:auto; border-radius:14px; display:block; }
    .inline-banner { grid-column: 1 / -1; }
    .inline-banner img { width:100%; height:auto; border-radius:14px; display:block; }

    .grid { display:grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 18px;  min-width: 0; box-sizing: border-box; }
    @media (max-width: 520px) { .grid { grid-template-columns: 1fr; } }
    .card { background: var(--card); border-radius: 16px; border: 1px solid var(--card-border); overflow: hidden; cursor: pointer;  box-sizing: border-box; }
    .card-top { padding: 26px 20px 20px; display:flex; flex-direction:column; align-items:center; gap: 12px; min-height: 260px; justify-content:center; }
    .avatar { width: 110px; height: 110px; border-radius: 999px; border: 6px solid rgba(255,255,255,.08); object-fit: cover; background:#1b2234; opacity:0; filter: blur(8px); transform: scale(1.01); transition: opacity .6s ease, filter .6s ease, transform .6s ease; }
    .avatar.is-loaded { opacity:1; filter: blur(0); transform: scale(1); }
    .name { font-size: 20px; font-weight: 600; margin: 0; text-align:center; }
    .count { opacity:.7; margin: 2px 0 0; }
    .card-bottom { border-top: 1px solid rgba(255,255,255,.06); padding: 12px 18px; display:flex; align-items:center; gap: 16px; color: rgba(255,255,255,.6); }
    .card-bottom a { color: inherit; text-decoration:none; font-weight:600; }
    .card-bottom a:hover { color:#fff; }

    .loader, .error { padding: 14px; text-align:center; opacity:.85; }
    .skeletons { display:grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap:14px; }
    .s-card { background:#2a334a; border-radius:16px; border:1px solid rgba(255,255,255,.06); overflow:hidden; position:relative; display:flex; flex-direction:column; }
    .s-top { padding:26px 20px 20px; display:flex; flex-direction:column; align-items:center; gap:12px; min-height:260px; justify-content:center; }
    .s-avatar { width:72px; height:72px; border-radius:999px; background: linear-gradient(90deg, #2f3850 25%, #3a4563 50%, #2f3850 75%); background-size:200% 100%; animation: shimmer 1.2s infinite; }
    .s-line { height:9px; border-radius:6px; background: #3a4563; width:70%; }
    .s-line.w2 { width:50%; }
    .s-bottom { border-top: 1px solid rgba(255,255,255,.06); padding: 12px 18px; display:flex; align-items:center; gap: 12px; }
    .s-pill { height:9px; width:28px; border-radius:6px; background:#3a4563; }
    .s-spinner { position:absolute; left:50%; top:50%; transform:translate(-50%, -50%); width:26px; height:26px; border:2px solid rgba(255,255,255,.3); border-top-color:#fff; border-radius:50%; animation: spin 0.8s linear infinite; }
    
    .site-footer { margin-top: 46px; padding: 22px 16px 32px; background: #0d1018; border-top: 1px solid rgba(255,255,255,.06); }
    .footer-inner { max-width: 1200px; margin: 0 auto; display:flex; flex-direction:column; gap: 18px; }
    .footer-top { display:flex; align-items:center; justify-content:space-between; gap: 16px; }
    .footer-links { display:flex; align-items:center; gap: 18px; flex-wrap:wrap; }
    .footer-links a { color:#fff; text-decoration:none; font-weight:600; font-size:14px; opacity:.9; }
    .footer-links a:hover { opacity:1; }
    .footer-bottom { display:grid; grid-template-columns: 1fr 1fr; gap: 26px; }
    .footer-brand { font-weight: 700; font-size: 20px; letter-spacing: .2px; color:#fff; font-family: 'Montserrat', system-ui, Arial, sans-serif; display:inline-flex; align-items:center; }
    .footer-brand .dot { color: var(--accent); font-size: 1.05em; margin-left: 1px; }
    .footer-col { color: rgba(255,255,255,.82); line-height: 1.6; font-size: 14px; }
    .footer-col a { color:#fff; font-weight:700; text-decoration:none; }
    @media (max-width: 900px) {
      .footer-top { flex-direction:column; align-items:flex-start; }
      .footer-bottom { grid-template-columns: 1fr; }
    }
    
    @media (max-width: 768px) { .socials, .social-sep { display: none !important; } }
@keyframes shimmer { 0% { background-position: 200% 0; } 100% { background-position: -200% 0; } }
    @keyframes spin { to { transform:translate(-50%, -50%) rotate(360deg); } }
    .sentinel { height: 1px; }
    .btn { padding:10px 14px; border-radius:10px; border:1px solid #333; background:#111; color:#fff; cursor:pointer; }
  </style>
</head>
<body>
  <header class="topbar">
    <div class="topbar-inner">
      <button class="hamburger" id="mobileToggle" aria-label="Menu">
        <span></span>
      </button>
      <a class="brand loading" id="brandLogo" href="<?= htmlspecialchars($baseHref) ?>">
        <span class="brand-skeleton" id="brandSkeleton"></span>
        <span class="brand-text" id="brandText">videometro.tv</span>
      </a>
      <nav class="nav" id="navMenu">
        <a href="<?= htmlspecialchars($basePath . '/protagonisti') ?>">Protagonisti</a>
        <span id="navDynamic">
          <?php foreach ($categories as $c): ?>
            <?php
              $name = $c['categoria'] ?? $c['category'] ?? '';
              $id = $c['cat_id'] ?? $c['id'] ?? '';
              if (!$name || !$id) continue;
            ?>
            <button type="button" class="nav-cat" data-cat-id="<?= vm_h($id) ?>"><?= vm_h($name) ?> <span class="caret"></span></button>
          <?php endforeach; ?>
        </span>
        <a href="<?= htmlspecialchars($basePath . '/blog') ?>" id="navBlog" style="display:none;">Blog</a>
      </nav>


      <div class="spacer"></div>
      <div class="search" id="searchBar">
        <input id="searchInput" type="search" placeholder="Cerca protagonisti..." autocomplete="off" />
        <button class="clear-btn" id="searchClear" aria-label="Svuota ricerca">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M6 6l12 12M18 6l-12 12"></path>
          </svg>
        </button>
      </div>
      <button class="icon-btn search-btn" id="searchToggle" aria-label="Cerca">
        <svg class="icon-search" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <circle cx="11" cy="11" r="7"></circle>
          <path d="M20 20l-3.5-3.5"></path>
        </svg>
      </button>
      <span class="social-sep" id="socialSep"></span>
      <div class="socials" id="socials"></div>
    </div>
    <div class="mobile-nav" id="mobileNav">
      <a href="<?= htmlspecialchars($basePath . '/protagonisti') ?>">Protagonisti</a>
      <div id="mobileNavDynamic">
        <?php foreach ($categories as $c): ?>
          <?php
            $name = $c['categoria'] ?? $c['category'] ?? '';
            $id = $c['cat_id'] ?? $c['id'] ?? '';
            if (!$name || !$id) continue;
          ?>
          <button type="button" class="mobile-cat" data-cat-id="<?= vm_h($id) ?>"><?= vm_h($name) ?> <span class="caret"></span></button>
          <div class="mobile-sub"></div>
        <?php endforeach; ?>
      </div>
      <a href="<?= htmlspecialchars($basePath . '/blog') ?>" id="mobileBlog" style="display:none;">Blog</a>
    </div>
    <div class="mega" id="megaMenu">
      <div class="mega-inner" id="megaInner"></div>
    </div>
  </header>

  <div class="banner" id="banner" style="display:none;">
    <a id="bannerLink" href="#" target="_blank" rel="noopener">
      <img id="bannerImg" alt="">
    </a>
  </div>
  <div class="wrap">
    <h1>I nostri protagonisti</h1>

    <div id="grid" class="grid">
      <?php foreach ($authorsItems as $a): ?>
        <?php
          $name = $a['name'] ?? 'Senza nome';
          $img = $a['image'] ?? '';
          $count = $a['num_video'] ?? 0;
          $fb = $a['facebook'] ?? '';
          $li = $a['linkedin'] ?? '';
          $id = $a['id'] ?? '';
          $slug = $a['slug'] ?? vm_slugify($name);
          $href = $basePath . '/protagonisti/' . $slug;
        ?>
        <div class="card" onclick="location.href='<?= vm_h($href) ?>'">
          <div class="card-top">
            <img class="avatar" src="<?= vm_h($img) ?>" alt="" loading="lazy" decoding="async">
            <p class="name"><?= vm_h($name) ?></p>
            <div class="count"><?= vm_h($count) ?> video</div>
          </div>
          <div class="card-bottom">
            <?= $fb ? '<a href="' . vm_h($fb) . '" target="_blank" rel="noopener">f</a>' : '<span>f</span>' ?>
            <?= $li ? '<a href="' . vm_h($li) . '" target="_blank" rel="noopener">in</a>' : '<span>in</span>' ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <div id="skeletons" class="skeletons" style="display:none;"></div>

    <div id="status" class="loader" style="display:none;">Caricamento…</div>
    <div id="err" class="error" style="display:none;">
      <div id="errMsg" style="margin-bottom:10px;">Errore di caricamento.</div>
      <button id="retry" class="btn">Riprova</button>
    </div>

    <div id="sentinel" class="sentinel"></div>
  </div>

  <script>
    window.__SSR__ = <?= json_encode([
      'items' => $authorsItems,
      'offset' => count($authorsItems),
      'limit' => $limit,
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>;
  </script>
  <script>
    window.APP_CONFIG = {
      aziendaId: <?= (int)$aziendaId ?>,
      siteUrl: <?= json_encode($siteUrl) ?>,
      basePath: <?= json_encode($basePath) ?>,
    };
  </script>
  <script src="<?= htmlspecialchars($baseHref) ?>config.js"></script>
  <script>
    const params = new URLSearchParams(location.search);
    const aziendaId = parseInt(window.APP_CONFIG?.aziendaId || '1', 10);
    const limit = parseInt(params.get('limit') || '20', 10);
    const BASE_PATH = String(window.APP_CONFIG?.basePath || '').replace(/\/+$/,'');
    const SSR = window.__SSR__ || null;
    function baseUrl(path = '') {
      const clean = String(path || '').replace(/^\/+/, '');
      if (!BASE_PATH) return '/' + clean;
      return clean ? `${BASE_PATH}/${clean}` : BASE_PATH || '/';
    }
    function withQuery(path, query) {
      const base = baseUrl(path);
      return query ? `${base}?${query}` : base;
    }
    let searchTerm = params.get('search_term') || '';

    let offset = 0;
    let loading = false;
    let ended = false;
    let restoredScroll = false;

    const grid = document.getElementById('grid');
    const skeletons = document.getElementById('skeletons');
    const status = document.getElementById('status');
    const errBox = document.getElementById('err');
    const errMsg = document.getElementById('errMsg');
    const retryBtn = document.getElementById('retry');
    const sentinel = document.getElementById('sentinel');
    const navMenu = document.getElementById('navMenu');
    const navDynamic = document.getElementById('navDynamic');
    const navBlog = document.getElementById('navBlog');
    const mobileBlog = document.getElementById('mobileBlog');
    const searchBar = document.getElementById('searchBar');
    const searchInput = document.getElementById('searchInput');
    const searchToggle = document.getElementById('searchToggle');
    const searchClear = document.getElementById('searchClear');
    const mobileToggle = document.getElementById('mobileToggle');
    const mobileNav = document.getElementById('mobileNav');
    const mobileNavDynamic = document.getElementById('mobileNavDynamic');
    const brandLogo = document.getElementById('brandLogo');
    const brandText = document.getElementById('brandText');
    const siteFooter = document.getElementById('siteFooter');
    const footerLogo = document.getElementById('footerLogo');
    const footerLeft = document.getElementById('footerLeft');
    const footerRight = document.getElementById('footerRight');
    const socialsEl = document.getElementById('socials');
    const socialSep = document.getElementById('socialSep');
    const banner = document.getElementById('banner');
    const bannerImg = document.getElementById('bannerImg');
    const bannerLink = document.getElementById('bannerLink');
    let bannerDesktopUrl = '';
    let bannerMobileUrl = '';
    let bannerWebsiteUrl = '';
    let authorRenderCount = 0;

    function showLoading(on) {
      status.style.display = on ? 'block' : 'none';
    }
    function showSkeletons(on, count = 8) {
      if (!skeletons) return;
      if (!on) {
        skeletons.style.display = 'none';
        skeletons.innerHTML = '';
        return;
      }
      skeletons.style.display = 'grid';
      skeletons.innerHTML = '';
      for (let i = 0; i < count; i += 1) {
        const sk = document.createElement('div');
        sk.className = 's-card';
        sk.innerHTML = `
          <div class="s-top">
            <div class="s-avatar"></div>
            <div class="s-line"></div>
            <div class="s-line w2"></div>
          </div>
          <div class="s-bottom">
            <div class="s-pill"></div>
            <div class="s-pill"></div>
          </div>
          <div class="s-spinner"></div>
        `;
        skeletons.appendChild(sk);
      }
    }
    function showError(on, msg = 'Errore di caricamento.') {
      errBox.style.display = on ? 'block' : 'none';
      if (errMsg) errMsg.textContent = msg;
    }
    function restoreScrollIfNeeded() {
      if (restoredScroll) return;
      const pending = (() => {
        try { return sessionStorage.getItem(`scroll:pending:${location.pathname}`); } catch { return null; }
      })();
      if (!pending) {
        if (location.hash.includes('scroll=')) history.replaceState(null, '', location.pathname + location.search);
        return;
      }
      const m = location.hash.match(/scroll=(\d+)/);
      const saved = (() => {
        try { return sessionStorage.getItem(`scroll:${location.pathname}`); } catch { return null; }
      })();
      const targetY = m ? parseInt(m[1], 10) : (saved ? parseInt(saved, 10) : null);
      if (targetY !== null && !Number.isNaN(targetY)) {
        restoredScroll = true;
        setTimeout(() => window.scrollTo(0, targetY), 50);
        try { sessionStorage.removeItem(`scroll:pending:${location.pathname}`); } catch {}
      }
    }
    function showInfo(msg) {
      status.style.display = 'block';
      status.textContent = msg;
    }
    function clearInfo() {
      status.textContent = 'Caricamento…';
    }

    function escapeHtml(s) {
      return String(s ?? '')
        .replaceAll('&','&amp;')
        .replaceAll('<','&lt;')
        .replaceAll('>','&gt;')
        .replaceAll('"','&quot;')
        .replaceAll("'","&#039;");
    }
    function slugify(value) {
      return String(value ?? '')
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '')
        .toLowerCase()
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/(^-|-$)+/g, '');
    }

    function bindSoftFadeImages(root = document) {
      root.querySelectorAll('img.avatar').forEach((img) => {
        const onLoad = () => img.classList.add('is-loaded');
        const onError = () => img.classList.remove('is-loaded');
        if (img.complete && img.naturalWidth > 0) {
          onLoad();
          return;
        }
        img.addEventListener('load', onLoad, { once: true });
        img.addEventListener('error', onError, { once: true });
      });
    }

    function setAccent(color) {
      if (!color) return;
      document.documentElement.style.setProperty('--accent', color);
      const svg = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="${color}" stroke-width="2"><circle cx="12" cy="8" r="5"/><path d="M9 13v8l3-2 3 2v-8"/></svg>`;
      const encoded = encodeURIComponent(svg);
      document.documentElement.style.setProperty('--badge-url', `url("data:image/svg+xml,${encoded}")`);
    }

    function setBrandName(name) {
      if (!brandLogo || !brandText) return;
      if (!name) {
        brandLogo.classList.remove('loading');
        return;
      }
      const safe = name.replace(/</g, '&lt;').replace(/>/g, '&gt;');
      const idx = safe.lastIndexOf('.');
      if (idx !== -1) {
        brandText.innerHTML = `${safe.slice(0, idx)}<span class="dot">.</span>${safe.slice(idx + 1)}`;
      } else {
        brandText.textContent = name;
      }
      brandLogo.classList.remove('loading');
    }
    function setBanner(bannerUrl, bannerMobileUrl) {
      if (!banner || !bannerImg || !bannerLink) return;
      bannerDesktopUrl = bannerUrl || '';
      bannerMobileUrl = bannerMobileUrl || '';
      const isMobile = window.matchMedia('(max-width: 900px)').matches;
      const src = isMobile && bannerMobileUrl ? bannerMobileUrl : bannerUrl;
      if (!src) {
        banner.style.display = 'none';
        return;
      }
      bannerLink.href = bannerWebsiteUrl || '#';
      bannerImg.src = src;
      bannerImg.loading = 'eager';
      banner.style.display = 'block';
    }
    function createInlineBanner() {
      const src = bannerDesktopUrl || '';
      const srcMobile = bannerMobileUrl || '';
      if (!src && !srcMobile) return null;
      const wrap = document.createElement('div');
      wrap.className = 'inline-banner';
      const href = bannerWebsiteUrl || '#';
      if (srcMobile) {
        wrap.innerHTML = `<a href="${escapeHtml(href)}" target="_blank" rel="noopener"><picture><source media="(max-width: 900px)" srcset="${escapeHtml(srcMobile)}"><img src="${escapeHtml(src || srcMobile)}" alt="" loading="lazy" decoding="async"></picture></a>`;
      } else {
        wrap.innerHTML = `<a href="${escapeHtml(href)}" target="_blank" rel="noopener"><img src="${escapeHtml(src)}" alt="" loading="lazy" decoding="async"></a>`;
      }
      return wrap;
    }

    function normalizeAzienda(data) {
      if (!data) return null;
      if (Array.isArray(data)) return data[0] || null;
      if (data.id || data.name || data.url || data.banner) return data;
      const vals = Object.values(data);
      return vals && vals.length ? vals[0] : null;
    }

    function setBlogMenuVisible(visible) {
      if (navBlog) navBlog.style.display = visible ? '' : 'none';
      if (mobileBlog) mobileBlog.style.display = visible ? '' : 'none';
    }

    async function checkBlogMenu() {
      try {
        const qs = new URLSearchParams();
        if (aziendaId) qs.set('azienda_id', String(aziendaId));
        qs.set('limit', '1');
        qs.set('offset', '0');
        qs.set('blog', '1');
        qs.set('gallery', '1');
        const res = await fetch(`${baseUrl('api/videos.php')}?${qs.toString()}`, { headers: { 'Accept': 'application/json' } });
        if (!res.ok) throw new Error(`HTTP ${res.status}`);
        const data = await res.json();
        const items = extractItems(data) || [];
        setBlogMenuVisible(items.length > 0);
      } catch (e) {
        console.error(e);
        setBlogMenuVisible(false);
      }
    }

    function renderSocials(a) {
      if (!socialsEl || !socialSep) return;
      socialsEl.innerHTML = '';
      const links = [
        { key: 'facebook', label: 'Facebook', svg: `<svg viewBox="0 0 24 24" fill="currentColor"><path d="M13 22v-9h3l1-4h-4V7a2 2 0 0 1 2-2h2V2h-3a5 5 0 0 0-5 5v3H7v4h3v9z"></path></svg>` },
        { key: 'instagram', label: 'Instagram', svg: `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="5"></rect><circle cx="12" cy="12" r="4"></circle><circle cx="17" cy="7" r="1"></circle></svg>` },
        { key: 'youtube', label: 'YouTube', svg: `<svg viewBox="0 0 24 24" fill="currentColor"><path d="M21.6 7.2a3 3 0 0 0-2.1-2.1C17.7 4.5 12 4.5 12 4.5s-5.7 0-7.5.6a3 3 0 0 0-2.1 2.1A31.7 31.7 0 0 0 2.4 12a31.7 31.7 0 0 0 .6 4.8 3 3 0 0 0 2.1 2.1c1.8.6 7.5.6 7.5.6s5.7 0 7.5-.6a3 3 0 0 0 2.1-2.1A31.7 31.7 0 0 0 21.6 12a31.7 31.7 0 0 0 0-4.8ZM10 15.5v-7l6 3.5-6 3.5Z"></path></svg>` },
        { key: 'linkedin', label: 'LinkedIn', svg: `<svg viewBox="0 0 24 24" fill="currentColor"><path d="M4 3a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-1 6h2v12H3zM9 9h2v2a4 4 0 0 1 4-2c3 0 5 2 5 6v6h-2v-6c0-2-1-4-3-4s-3 2-3 4v6H9z"></path></svg>` },
      ];
      let added = 0;
      links.forEach(item => {
        const href = (a && a[item.key]) ? String(a[item.key]).trim() : '';
        if (!href) return;
        const link = document.createElement('a');
        link.href = href;
        link.target = '_blank';
        link.rel = 'noopener';
        link.setAttribute('aria-label', item.label);
        link.innerHTML = item.svg;
        socialsEl.appendChild(link);
        added += 1;
      });
      socialSep.style.display = added ? 'inline-block' : 'none';
    }

    
    
    
    function renderFooter(a) {
      const siteFooterEl = document.getElementById('siteFooter');
      const footerLogoEl = document.getElementById('footerLogo');
      const footerLeftEl = document.getElementById('footerLeft');
      const footerRightEl = document.getElementById('footerRight');
      const footerBottomEl = document.getElementById('footerBottom');
      if (!siteFooterEl || !footerLeftEl || !footerRightEl) {
        setTimeout(() => renderFooter(a), 0);
        return;
      }
      const left = (a && a.footer_left) ? String(a.footer_left).trim() : '';
      const right = (a && a.footer_right) ? String(a.footer_right).trim() : '';
      footerLeftEl.innerHTML = left;
      footerRightEl.innerHTML = right;
      if (footerLogoEl && brandText) footerLogoEl.innerHTML = brandText.innerHTML;
      if (footerBottomEl) footerBottomEl.style.display = (!left && !right) ? 'none' : 'grid';
      siteFooterEl.style.display = 'block';
    }

    async function loadAzienda() {
      if (brandLogo) brandLogo.classList.add('loading');
      try {
        const res = await fetch(`${baseUrl('api/azienda.php')}?azienda_id=${encodeURIComponent(aziendaId)}`, {
          headers: { 'Accept': 'application/json' },
        });
        if (!res.ok) throw new Error(`HTTP ${res.status}`);
        const data = await res.json();
        const item = normalizeAzienda(data?.data ?? data);
        if (!item) {
          if (brandLogo) brandLogo.classList.remove('loading');
          return;
        }
        setBrandName(item.name || item.url || '');
        setAccent(item.color_point || '');
        bannerWebsiteUrl = item.website || item.url || '';
        setBanner(item.banner || '', item.banner_mobile || '');
        renderFooter(item);
        window.addEventListener('resize', () => setBanner(item.banner || '', item.banner_mobile || ''));
        renderSocials(item);
      } catch (e) {
        console.error(e);
        if (brandLogo) brandLogo.classList.remove('loading');
      }
    }

    async function loadCategories() {
      if (!navDynamic) return;
      bindMegaMenu();
      bindMobileSubmenus();
    }

    const megaMenu = document.getElementById('megaMenu');
    const megaInner = document.getElementById('megaInner');
    let megaCloseTimer = null;

    function openMega() {
      megaMenu.classList.add('open');
      if (megaCloseTimer) clearTimeout(megaCloseTimer);
    }
    function closeMega() {
      megaCloseTimer = setTimeout(() => {
        megaMenu.classList.remove('open');
        megaInner.innerHTML = '';
      }, 120);
    }
    function renderMegaSkeleton(count = 8) {
      let html = '<div class="mega-skeletons">';
      for (let i = 0; i < count; i += 1) html += '<span class="mega-pill"></span>';
      html += '</div>';
      return html;
    }
    function setMegaLoading(on) {
      if (!megaInner) return;
      if (on) megaInner.innerHTML = renderMegaSkeleton();
    }

    async function loadSubcategories(catId) {
      setMegaLoading(true);
      try {
        const res = await fetch(`${baseUrl('api/subcategories.php')}?azienda_id=${encodeURIComponent(aziendaId)}&cat_id=${encodeURIComponent(catId)}`, {
          headers: { 'Accept': 'application/json' },
        });
        if (!res.ok) throw new Error(`HTTP ${res.status}`);
        const data = await res.json();
        const items = Array.isArray(data) ? data : (data.data ?? []);
        megaInner.innerHTML = '';
        if (!items.length) {
          megaInner.textContent = 'Nessuna sottocategoria.';
          return;
        }
        items.forEach(s => {
          const name = s.sub_categoria ?? s.subcategory ?? '';
          const sid = s.subcat_id ?? s.id ?? '';
          const featured = String(s.featured ?? '0') === '1';
          if (!name || !sid) return;
          const link = document.createElement('a');
          link.href = baseUrl(`video/categoria/${slugify(name)}`);
          link.textContent = name;
          if (featured) {
            const badge = document.createElement('span');
            badge.className = 'badge';
            badge.textContent = 'Sigillo';
            link.appendChild(badge);
          }
          megaInner.appendChild(link);
        });
      } catch (e) {
        megaInner.textContent = 'Errore caricamento.';
        console.error(e);
      }
    }

    function bindMegaMenu() {
      if (!navDynamic || navDynamic.dataset.bound === '1') return;
      navDynamic.dataset.bound = '1';
      navDynamic.addEventListener('mouseover', (e) => {
        const btn = e.target.closest('.nav-cat');
        if (!btn) return;
        openMega();
        loadSubcategories(btn.dataset.catId);
      });
      navDynamic.querySelectorAll('.nav-cat').forEach(btn => {
        btn.addEventListener('mouseenter', () => {
          openMega();
          loadSubcategories(btn.dataset.catId);
        });
        btn.addEventListener('focus', () => {
          openMega();
          loadSubcategories(btn.dataset.catId);
        });
      });
      navMenu.addEventListener('mouseleave', closeMega);
      megaMenu.addEventListener('mouseenter', openMega);
      megaMenu.addEventListener('mouseleave', closeMega);
    }
    function bindMobileSubmenus() {
      if (!mobileNavDynamic) return;
      const buttons = mobileNavDynamic.querySelectorAll('.mobile-cat');
      buttons.forEach(btn => {
        const sub = btn.nextElementSibling;
        if (!sub || !sub.classList.contains('mobile-sub')) return;
        btn.addEventListener('click', () => {
          const open = sub.classList.toggle('open');
          if (open && sub.childElementCount === 0) {
            loadSubcategoriesInto(sub, btn.dataset.catId);
          }
        });
      });
    }

    function renderItems(items) {
      const frag = document.createDocumentFragment();
      items.forEach(a => {
        const name = a.name ?? 'Senza nome';
        const img = a.image ?? '';
        const count = a.num_video ?? 0;
        const fb = a.facebook ?? '';
        const li = a.linkedin ?? '';

        const card = document.createElement('div');
        card.className = 'card';
        card.innerHTML = `
          <div class="card-top">
            <img class="avatar" src="${escapeHtml(img)}" alt="" loading="lazy" decoding="async">
            <p class="name">${escapeHtml(name)}</p>
            <div class="count">${escapeHtml(count)} video</div>
          </div>
          <div class="card-bottom">
            ${fb ? `<a href="${escapeHtml(fb)}" target="_blank" rel="noopener">f</a>` : '<span>f</span>'}
            ${li ? `<a href="${escapeHtml(li)}" target="_blank" rel="noopener">in</a>` : '<span>in</span>'}
          </div>
        `;
        card.addEventListener('click', (e) => {
          if (e.target && e.target.tagName === 'A') return;
          const authorSlug = a.slug || slugify(name);
          const path = baseUrl(`protagonisti/${authorSlug}`);
          location.href = path;
        });
        frag.appendChild(card);
        authorRenderCount += 1;
        if (authorRenderCount % 20 === 0) {
          const bannerEl = createInlineBanner();
          if (bannerEl) frag.appendChild(bannerEl);
        }
      });
      grid.appendChild(frag);
      bindSoftFadeImages(grid);
      restoreScrollIfNeeded();
    }

    function applySSR() {
      if (!SSR?.items || !Array.isArray(SSR.items)) return false;
      grid.innerHTML = '';
      renderItems(SSR.items);
      offset = typeof SSR.offset === 'number' ? SSR.offset : SSR.items.length;
      ended = SSR.items.length < (SSR.limit || limit);
      showSkeletons(false);
      return true;
    }

    function extractItems(json) {
      if (Array.isArray(json)) return json;
      if (Array.isArray(json?.data)) return json.data;
      return null;
    }

    async function loadNextPage() {
      if (loading || ended) return;
      loading = true;
      showError(false);
      showLoading(true);
      clearInfo();
      showSkeletons(true, Math.min(8, limit));

      try {
        const qs = new URLSearchParams();
        if (aziendaId) qs.set('azienda_id', String(aziendaId));
        if (limit) qs.set('limit', String(limit));
        qs.set('offset', String(offset));
        if (searchTerm) qs.set('search_term', searchTerm);

        const url = `${baseUrl('api/authors.php')}?${qs.toString()}`;
        const res = await fetch(url, { headers: { 'Accept': 'application/json' } });

        let json = null;
        if (!res.ok) {
          try { json = await res.json(); } catch {}
          const detail = json?.error || json?.detail || `HTTP ${res.status}`;
          throw new Error(detail);
        }

        json = await res.json();
        const items = extractItems(json);
        if (!items) throw new Error('Risposta non valida: array non trovato');

        renderItems(items);

        if (items.length === 0 || items.length < limit) {
          ended = true;
          showLoading(false);
          showSkeletons(false);
          return;
        }

        offset += items.length;
        showLoading(false);
        showSkeletons(false);
      } catch (e) {
        console.error(e);
        showLoading(false);
        showSkeletons(false);
        showError(true, e?.message || 'Errore di caricamento.');
      } finally {
        loading = false;
      }
    }

    if ('IntersectionObserver' in window) {
      const io = new IntersectionObserver((entries) => {
        if (entries.some(e => e.isIntersecting)) loadNextPage();
      }, { root: null, rootMargin: '800px 0px', threshold: 0 });

      io.observe(sentinel);
    }

    const onScroll = () => {
      const nearBottom = window.innerHeight + window.scrollY >= document.body.offsetHeight - 800;
      if (nearBottom) loadNextPage();
    };
    window.addEventListener('scroll', onScroll, { passive: true });

    retryBtn.addEventListener('click', () => loadNextPage());
    loadCategories();
    loadAzienda();
    checkBlogMenu();
    if ('scrollRestoration' in history) history.scrollRestoration = 'manual';


    function resetAndLoad() {
      offset = 0;
      ended = false;
      authorRenderCount = 0;
      grid.innerHTML = '';
      loadNextPage();
    }

    let searchDebounce = null;
    function handleSearchInput(value) {
      searchTerm = value.trim();
      if (searchTerm.length === 0) {
        resetAndLoad();
        return;
      }
      if (searchTerm.length < 3) {
        grid.innerHTML = '';
        ended = true;
        showInfo('Inserisci almeno 3 lettere per cercare.');
        return;
      }
      resetAndLoad();
    }

    function closeSearch() {
      searchBar.classList.remove('active');
      navMenu.classList.remove('hidden');
      searchInput.value = '';
      searchTerm = '';
      searchClear.classList.remove('visible');
      clearInfo();
      document.body.classList.remove('searching-mobile');
    }

    searchToggle.addEventListener('click', () => {
      const active = searchBar.classList.toggle('active');
      navMenu.classList.toggle('hidden', active);
      if (active) {
        searchInput.focus();
        document.body.classList.add('searching-mobile');
      } else {
        searchInput.value = '';
        searchTerm = '';
        clearInfo();
        resetAndLoad();
        document.body.classList.remove('searching-mobile');
      }
    });

    searchInput.addEventListener('input', (e) => {
      const value = e.target.value;
      searchClear.classList.toggle('visible', value.trim().length > 0);
      if (searchDebounce) clearTimeout(searchDebounce);
      searchDebounce = setTimeout(() => handleSearchInput(value), 300);
    });

    searchClear.addEventListener('click', () => {
      window.scrollTo({ top: 0, behavior: 'smooth' });
      closeSearch();
      resetAndLoad();
    });

    mobileToggle.addEventListener('click', () => {
      mobileNav.classList.toggle('open');
    });
    mobileNav.addEventListener('click', (e) => {
      if (e.target && e.target.tagName === 'A') mobileNav.classList.remove('open');
    });

    if (!applySSR()) loadNextPage();
    bindSoftFadeImages();
  </script>

  <footer class="site-footer" id="siteFooter" style="display:none;">
    <div class="footer-inner">
      <div class="footer-top">
        <div class="footer-brand" id="footerLogo">videometro<span class="dot">.</span>tv</div>
        <div class="footer-links">
          <a href="<?= htmlspecialchars($basePath . '/privacy') ?>">Privacy Policy</a>
          <a href="<?= htmlspecialchars($basePath . '/cookie') ?>">Cookie Policy</a>
        </div>
      </div>
      <div class="footer-bottom" id="footerBottom">
        <div class="footer-col" id="footerLeft"></div>
        <div class="footer-col" id="footerRight"></div>
      </div>
    </div>
  </footer>

</body>
</html>
