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
    body { margin:0; font-family: system-ui, Arial; background:var(--bg); color:var(--text); }
    .topbar { position: sticky; top: 0; z-index: 50; background: rgba(31,39,64,0.92); border-bottom: 1px solid var(--bar-border); backdrop-filter: blur(6px); }
    .topbar-inner { max-width: 1200px; margin: 0 auto; padding: 14px 16px; display:flex; align-items:center; gap: 14px; position: relative; }
    .brand { font-weight: 700; font-size: 26px; letter-spacing: .2px; text-decoration:none; color:#fff; font-family: 'Montserrat', system-ui, Arial, sans-serif; display:inline-flex; align-items:center; position: relative; }
    .brand .dot { color: var(--accent); font-size: 1.1em; }
    .brand-text { display:inline-flex; align-items:center; }
    .brand-skeleton { width: min(160px, 40vw); height: 24px; border-radius: 999px; background: linear-gradient(90deg, #2f3850 25%, #3a4563 50%, #2f3850 75%); background-size:200% 100%; animation: shimmer 1.2s infinite; display:none; position:absolute; left:0; top:50%; transform: translateY(-50%); pointer-events:none; }
    .brand.loading .brand-text { opacity: 0; }
    .brand.loading .brand-skeleton { display:inline-block; }
    .nav { display:flex; align-items:center; gap: 10px; color: var(--muted); font-size: 14px; font-family: 'Montserrat', system-ui, Arial, sans-serif; letter-spacing: .2px; }
    .nav a, .nav span, .nav button { color: inherit; text-decoration: none; cursor: pointer; padding: 8px 12px; border-radius: 999px; display:inline-block; transition: background .2s ease, color .2s ease; background: transparent; border: none; font: inherit; }
    .nav a .caret, .nav span.caret { padding: 0; border-radius: 0; background: transparent; }
    .nav a .caret:hover, .nav span.caret:hover { background: transparent; }
    .nav a:hover, .nav span:hover, .nav button:hover { color: #fff; background: rgba(255,255,255,.08); }
    .mega { position:absolute; left:0; right:0; top:100%; background: rgba(24,30,49,0.98); border-bottom: 1px solid var(--bar-border); display:none; z-index: 40; }
    .mega.open { display:block; }
    .mega-inner { max-width: 1200px; margin: 0 auto; padding: 18px 16px 22px; display:flex; flex-wrap:wrap; gap: 10px 12px; }
    .mega a { padding: 10px 12px; border-radius: 999px; color: var(--muted); text-decoration:none; border: 1px solid rgba(255,255,255,.08); font-size: 13px; display:inline-flex; align-items:center; gap: 6px; }
    .mega a:hover { color:#fff; background: rgba(255,255,255,.08); }
    .mega-skeletons { display:flex; flex-wrap:wrap; gap:10px 12px; }
    .mega-pill { width:120px; height:28px; border-radius:999px; background: linear-gradient(90deg, #2f3850 25%, #3a4563 50%, #2f3850 75%); background-size:200% 100%; animation: shimmer 1.2s infinite; }
    .badge { width: 14px; height: 18px; flex: 0 0 auto; font-size: 0; border: none; color: transparent; background: no-repeat center/contain; background-image: var(--badge-url); }
    .caret { display:inline-block; margin-left: 6px; width: 8px; height: 8px; position: relative; font-size: 0; line-height: 0; transform: translateY(-1px); }
    .caret::before { content:""; position:absolute; inset:0; border-right: 2px solid currentColor; border-bottom: 2px solid currentColor; transform: rotate(45deg); }
    .spacer { flex: 1; }
    .icon-btn { width: 36px; height: 36px; border-radius: 999px; border: none; background: transparent; color: #fff; display:grid; place-items:center; cursor:pointer; }
    .icon-btn svg { width: 18px; height: 18px; }
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
    .mobile-nav button { display:flex; align-items:center; justify-content:space-between; padding: 10px 12px; color: var(--muted); text-decoration:none; border-radius: 12px; background: transparent; border: none; width: 100%; text-align:left; font: inherit; cursor: pointer; gap: 8px; margin:0; }
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

    .wrap { max-width: 1200px; margin: 0 auto; padding: 0 16px 28px; }
    h1 { margin:22px 0 12px 0; font-size: 18px; font-weight: 600; }
    .banner { max-width: 1200px; margin: 0 auto; padding: 22px 16px 18px; }
    .banner img { width:100%; height:auto; border-radius:14px; display:block; }
    .inline-banner { grid-column: 1 / -1; }
    .inline-banner img { width:100%; height:auto; border-radius:14px; display:block; }

    .grid { display:grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 18px; }
    .card { background: var(--card); border-radius: 16px; border: 1px solid var(--card-border); overflow: hidden; cursor: pointer; }
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
    .s-line { height:12px; border-radius:6px; background: #3a4563; width:70%; }
    .s-line.w2 { width:50%; }
    .s-bottom { border-top: 1px solid rgba(255,255,255,.06); padding: 12px 18px; display:flex; align-items:center; gap: 12px; }
    .s-pill { height:12px; width:28px; border-radius:6px; background:#3a4563; }
    .s-spinner { position:absolute; left:50%; top:50%; transform:translate(-50%, -50%); width:26px; height:26px; border:2px solid rgba(255,255,255,.3); border-top-color:#fff; border-radius:50%; animation: spin 0.8s linear infinite; }
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
        <a href="<?= htmlspecialchars($basePath . '/blog') ?>" id="navBlog" style="display:none;">Blog</a>
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
      <a class="icon-btn hide-mobile" href="<?= htmlspecialchars($baseHref) ?>" aria-label="Video">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M4 6h16v12H4z"></path>
          <path d="M10 8l6 4-6 4z"></path>
        </svg>
      </a>
      <button class="icon-btn search-btn" id="searchToggle" aria-label="Cerca">
        <svg class="icon-search" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <circle cx="11" cy="11" r="7"></circle>
          <path d="M20 20l-3.5-3.5"></path>
        </svg>
      </button>
    </div>
    <div class="mobile-nav" id="mobileNav">
      <a href="<?= htmlspecialchars($basePath . '/protagonisti') ?>">Protagonisti</a>
      <a href="<?= htmlspecialchars($basePath . '/blog') ?>" id="mobileBlog" style="display:none;">Blog</a>
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
        window.addEventListener('resize', () => setBanner(item.banner || '', item.banner_mobile || ''));
      } catch (e) {
        console.error(e);
        if (brandLogo) brandLogo.classList.remove('loading');
      }
    }

    async function loadCategories() {
      if (navDynamic && navDynamic.children.length > 0) {
        bindMegaMenu();
        bindMobileSubmenus();
        return;
      }
      try {
        const res = await fetch(`${baseUrl('api/categories.php')}?azienda_id=${encodeURIComponent(aziendaId)}`, {
          headers: { 'Accept': 'application/json' },
        });
        if (!res.ok) throw new Error(`HTTP ${res.status}`);
        const data = await res.json();
        const items = Array.isArray(data) ? data : (data.data ?? []);
        if (!items.length) return;

        navDynamic.innerHTML = '';
        mobileNavDynamic.innerHTML = '';

        items.forEach(c => {
          const name = c.categoria ?? c.category ?? '';
          const id = c.cat_id ?? c.id ?? '';
          if (!name || !id) return;
          const btn = document.createElement('button');
          btn.type = 'button';
          btn.className = 'nav-cat';
          btn.dataset.catId = id;
          btn.textContent = name + ' ';
          const caret = document.createElement('span');
          caret.className = 'caret';
          caret.textContent = '';
          btn.appendChild(caret);
          navDynamic.appendChild(btn);

          const btnMobile = document.createElement('button');
          btnMobile.type = 'button';
          btnMobile.className = 'mobile-cat';
          btnMobile.dataset.catId = id;
          btnMobile.textContent = name;
          const caretMobile = document.createElement('span');
          caretMobile.className = 'caret';
          caretMobile.textContent = '';
          btnMobile.appendChild(caretMobile);
          const subWrap = document.createElement('div');
          subWrap.className = 'mobile-sub';
          mobileNavDynamic.appendChild(btnMobile);
          mobileNavDynamic.appendChild(subWrap);
        });
        bindMegaMenu();
        bindMobileSubmenus();
      } catch (e) {
        console.error(e);
      }
    }

    async function loadSubcategoriesInto(container, catId) {
      container.innerHTML = 'Caricamento…';
      try {
        const res = await fetch(`${baseUrl('api/subcategories.php')}?azienda_id=${encodeURIComponent(aziendaId)}&cat_id=${encodeURIComponent(catId)}`, {
          headers: { 'Accept': 'application/json' },
        });
        if (!res.ok) throw new Error(`HTTP ${res.status}`);
        const data = await res.json();
        const items = Array.isArray(data) ? data : (data.data ?? []);
        container.innerHTML = '';
        if (!items.length) {
          const empty = document.createElement('div');
          empty.style.padding = '6px 10px';
          empty.style.opacity = '.7';
          empty.textContent = 'Nessuna sottocategoria.';
          container.appendChild(empty);
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
            link.appendChild(badge);
          }
          container.appendChild(link);
        });
      } catch (e) {
        container.textContent = 'Errore caricamento.';
        console.error(e);
      }
    }

    function bindMobileSubmenus() {
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
</body>
</html>
