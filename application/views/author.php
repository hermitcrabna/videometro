<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!doctype html>
<html lang="it">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="<?= htmlspecialchars($pageDescription ?? "Contenuti dell'autore su VideoMetro.") ?>" />
  <link rel="canonical" href="<?= htmlspecialchars($canonical ?? ($siteUrl . $basePath . '/protagonisti/' . ($authorSlug ?: ''))) ?>" />
  <meta name="robots" content="<?= htmlspecialchars($robots ?? 'index, follow') ?>" />
  <meta property="og:type" content="profile">
  <meta property="og:title" content="<?= htmlspecialchars($pageTitle ?? 'VideoMetro – Autore') ?>">
  <meta property="og:description" content="<?= htmlspecialchars($pageDescription ?? "Contenuti dell'autore su VideoMetro.") ?>">
  <meta property="og:url" content="<?= htmlspecialchars($canonical ?? ($siteUrl . $basePath . '/protagonisti/' . ($authorSlug ?: ''))) ?>">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <script type="application/ld+json" id="schemaPerson"></script>
  <script type="application/ld+json" id="schemaVideos"></script>
  <?php
    $personSchema = [
      '@context' => 'https://schema.org',
      '@type' => 'Person',
      'name' => $authorName ?: null,
      'image' => $authorImg ?: null,
      'url' => $canonical ?? null,
      'sameAs' => array_values(array_filter([$authorFb ?? null, $authorLi ?? null])),
    ];
    $items = [];
    $pos = 1;
    foreach ($authorItems as $v) {
      $slug = $v['slug'] ?? '';
      if (!$slug) continue;
      $items[] = [
        '@type' => 'ListItem',
        'position' => $pos++,
        'url' => $siteUrl . $basePath . '/video/' . $slug,
      ];
      if ($pos > 50) break;
    }
    $listSchema = [
      '@context' => 'https://schema.org',
      '@type' => 'ItemList',
      'itemListElement' => $items,
    ];
  ?>
  <script type="application/ld+json"><?= json_encode($personSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
  <script type="application/ld+json"><?= json_encode($listSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
  <title><?= htmlspecialchars($pageTitle ?? 'VideoMetro – Autore') ?></title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap');
    :root {
      --bg: #0f1115;
      --bar: #1f2740;
      --bar-border: #2b3554;
      --text: #ffffff;
      --muted: rgba(255,255,255,.72);
      --card: #171a21;
      --accent: #ff2d2d;
      --badge-url: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="%23ff2d2d" stroke-width="2"><circle cx="12" cy="8" r="5"/><path d="M9 13v8l3-2 3 2v-8"/></svg>');
    }
    body { min-height:100vh; display:flex; flex-direction:column; margin:0; font-family: system-ui, Arial; background:var(--bg); color:var(--text); }
    .topbar { position: sticky; top: 0; z-index: 50; background: rgba(31,39,64,0.92); border-bottom: 1px solid var(--bar-border); backdrop-filter: blur(6px); }
    .topbar-inner { max-width: 1200px; margin: 0 auto; padding: 14px 16px; display:flex; align-items:center; gap: 14px; position: relative; transform: translateY(-3px); }
    .brand { font-weight: 700; font-size: 26px; letter-spacing: .2px; text-decoration:none; color:#fff; font-family: 'Montserrat', system-ui, Arial, sans-serif; display:inline-flex; align-items:center; position: relative; transform: translateY(-3px); }
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
    .search { display:flex; align-items:center; gap: 10px; width: 360px; max-width: 360px; position: relative; }
    .search input { flex:1; height: 38px; border-radius: 999px; border: 1px solid rgba(255,255,255,.18); background:#151b2b; color:#fff; padding: 0 40px 0 14px; font-size: 15px; font-family: 'Montserrat', system-ui, Arial, sans-serif; }
    .search input::placeholder { color: rgba(255,255,255,.6); }
    .clear-btn { width: 28px; height: 28px; border-radius: 999px; border: 1px solid rgba(255,80,80,.5); background: transparent; color: #ff6b6b; display:none; place-items:center; cursor:pointer; position:absolute; right: 6px; top: 50%; transform: translateY(-50%); }
    .clear-btn.visible { display:grid; }
    .clear-btn svg { width: 16px; height: 16px; }
    .mobile-nav { display:none; padding: 10px 16px 16px; border-bottom: 1px solid var(--bar-border); background: rgba(31,39,64,0.95); max-height: 60vh; overflow-y: auto; }
    #navDynamic { display: contents; }
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
    .wrap { flex:1; width:100%; max-width: 1200px; margin: 0 auto; padding: 0 16px 28px; box-sizing: border-box; }
    .hero { display:flex; align-items:center; gap: 18px; margin-bottom: 18px; }
    .hero-content { display:flex; align-items:center; gap: 18px; width: 100%; }
    .hero-left { display:flex; align-items:center; gap: 18px; }
    .hero-right { margin-left: auto; }
    .author-sticky { position: sticky; top: 66px; z-index: 40; margin-bottom: 12px; display:none; }
    .author-sticky.active { display:block; }
    .author-sticky-inner { background: rgba(48,58,82,0.92); border: 1px solid rgba(255,255,255,.06); border-radius: 999px; padding: 10px 14px; display:flex; align-items:center; gap: 12px; box-shadow: 0 10px 30px rgba(0,0,0,.25); }
    .author-sticky .avatar { width: 34px; height: 34px; border-width: 3px; }
    .author-sticky .search { width: 100%; max-width: none; }
    .author-sticky .search input { height: 34px; }
    .avatar { width: 72px; height: 72px; border-radius: 999px; border: 4px solid rgba(255,255,255,.08); object-fit: cover; background:#1b2234; }
    .hero h1 { margin:0; font-size: 28px; }
    .meta { color: var(--muted); margin-top: 4px; }
    .meta a { color: inherit; text-decoration: none; margin-right: 10px; }

    .grid { display:grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 14px; }
    .grid.dim .card { opacity: .35; transition: opacity .2s ease; }
    .grid.dim .card.show-desc { opacity: 1; }
    .card { background:#303a52; border-radius:14px; overflow:hidden; cursor:pointer; border: 1px solid rgba(255,255,255,.06); transition: background .2s ease, border-color .2s ease; position: relative; }
    .card:hover { background: color-mix(in srgb, var(--accent) 65%, #303a52); border-color: color-mix(in srgb, var(--accent) 70%, rgba(255,255,255,.06)); }
    .tag { background: rgba(15,17,21,.6); color:#fff; font-size:11px; padding:4px 8px; border-radius:999px; border:1px solid rgba(255,255,255,.15); text-decoration:none; transition: background .2s ease; }
    .tag:hover { background: var(--accent); }
    .tag:hover { background: rgba(255,255,255,.12); }
    .thumb { width:100%; aspect-ratio: 16/9; background:#222; display:block; object-fit:cover; opacity:0; filter: blur(8px); transform: scale(1.01); transition: opacity .6s ease, filter .6s ease, transform .6s ease; }
    .thumb.is-loaded { opacity:1; filter: blur(0); transform: scale(1); }
    .card-meta { padding:12px 14px 10px; display:flex; flex-direction:column; gap:8px; }
    .title { font-size:15px; line-height:1.25; margin:0; font-weight:600; }
    .desc { font-size:12px; opacity:.6; margin:0; max-height:0; overflow:hidden; transition:max-height .3s cubic-bezier(.22,.61,.36,1), opacity .3s ease; }
    .card.show-desc .desc { max-height:140px; opacity:.75; }
    .card-footer { display:flex; align-items:center; justify-content:space-between; padding: 10px 14px 14px; border-top: 1px solid rgba(255,255,255,.06); }
    .author { display:flex; align-items:center; gap:10px; position: relative; }
    .author img { width:28px; height:28px; border-radius:999px; object-fit:cover; border:2px solid rgba(255,255,255,.1); }
    .author-tooltip { position:absolute; left:0; bottom:36px; background:#2b3450; border:1px solid rgba(255,255,255,.08); color:#fff; padding:8px 10px; border-radius:10px; font-size:12px; white-space:nowrap; display:none; }
    .author:hover .author-tooltip { display:block; }
    .share-wrap { position:relative; }
    .share-btn { width:28px; height:28px; border-radius:999px; border:1px solid rgba(255,255,255,.15); background:transparent; color:#fff; display:grid; place-items:center; cursor:pointer; }
    .share-panel { position:absolute; right:0; bottom:36px; background:#2b3450; border:1px solid rgba(255,255,255,.08); border-radius:12px; padding:8px; display:none; flex-direction:column; gap:8px; }
    .share-panel.open { display:flex; }
    .share-panel a { color:#fff; text-decoration:none; display:grid; place-items:center; padding:6px; border-radius:8px; }
    .share-panel svg { width:18px; height:18px; }
    .share-panel a:hover { background:rgba(255,255,255,.08); }

    .loader, .error { padding: 14px; text-align:center; opacity:.85; }
    .skeletons { display:grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap:14px; }
    .inline-banner { grid-column: 1 / -1; }
    .inline-banner img { width:100%; height:auto; border-radius:14px; display:block; }
    .s-card { background:#303a52; border-radius:14px; border:1px solid rgba(255,255,255,.06); overflow:hidden; position:relative; }
    .s-thumb { aspect-ratio:16/9; background: linear-gradient(90deg, #2b3248 25%, #36405c 50%, #2b3248 75%); background-size:200% 100%; animation: shimmer 1.2s infinite; }
    .s-body { min-height:100vh; display:flex; flex-direction:column; padding:12px 14px 14px; display:flex; flex-direction:column; gap:10px; }
    .s-line { height:10px; border-radius:6px; background: #2b3248; }
    .s-line.w1 { width:70%; }
    .s-line.w2 { width:50%; }
    .s-spinner { position:absolute; left:50%; top:50%; transform:translate(-50%, -50%); width:26px; height:26px; border:2px solid rgba(255,255,255,.3); border-top-color:#fff; border-radius:50%; animation: spin 0.8s linear infinite; }
    
    .site-footer { margin-top: 46px; padding: 28px 16px 40px; background: #0d1018; border-top: 1px solid rgba(255,255,255,.06); }
    .footer-inner { max-width: 1200px; margin: 0 auto; display:grid; grid-template-columns: 1fr 1fr; gap: 26px; }
    .footer-brand { font-weight: 700; font-size: 22px; letter-spacing: .2px; color:#fff; font-family: 'Montserrat', system-ui, Arial, sans-serif; display:inline-flex; align-items:center; }
    .footer-brand .dot { color: var(--accent); font-size: 1.05em; margin-left: 1px; }
    .footer-col { color: rgba(255,255,255,.82); line-height: 1.6; font-size: 14px; }
    .footer-col a { color:#fff; font-weight:700; text-decoration:none; }
    @media (max-width: 900px) { .footer-inner { grid-template-columns: 1fr; } }
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
      <a class="icon-btn hide-mobile" href="<?= htmlspecialchars($baseHref) ?>" aria-label="Video">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M4 6h16v12H4z"></path>
          <path d="M10 8l6 4-6 4z"></path>
        </svg>
      </a>
      <button class="icon-btn search-btn" id="searchJump" aria-label="Cerca">
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

  <div class="wrap">
    <div class="hero">
      <div class="hero-content">
        <div class="hero-left">
          <img id="authorImg" class="avatar" src="" alt="">
          <div>
            <h1 id="authorName">Autore</h1>
            <div class="meta" id="authorMeta"></div>
          </div>
        </div>
        <div class="hero-right">
          <div class="search" id="searchBar">
            <input id="searchInput" type="search" placeholder="Cerca nei video dell’autore..." autocomplete="off" />
            <button class="clear-btn" id="searchClear" aria-label="Svuota ricerca">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M6 6l12 12M18 6l-12 12"></path>
              </svg>
            </button>
          </div>
        </div>
      </div>
    </div>
    <div class="author-sticky" id="authorSticky">
      <div class="author-sticky-inner">
        <img id="authorImgSticky" class="avatar" src="" alt="">
        <div class="search">
          <input id="searchInputSticky" type="search" placeholder="Cerca nei suoi contenuti..." autocomplete="off" />
          <button class="clear-btn" id="searchClearSticky" aria-label="Svuota ricerca">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M6 6l12 12M18 6l-12 12"></path>
            </svg>
          </button>
        </div>
      </div>
    </div>

    <div id="grid" class="grid">
      <?php foreach ($authorItems as $v): ?>
        <?php
          $title = $v['title'] ?? $v['seo-title'] ?? 'Senza titolo';
          $thumb = $v['image'] ?? $v['thumbnail'] ?? $v['thumb'] ?? $v['poster'] ?? '';
          $summary = strip_tags((string)($v['summary'] ?? $v['seo-description'] ?? ''));
          $author = is_array($v['authors'] ?? null) && !empty($v['authors']) ? $v['authors'][0] : null;
          $aImg = is_array($author) ? ($author['image'] ?? '') : '';
          $aName = is_array($author) ? ($author['name'] ?? '') : '';
          $aCount = is_array($author) ? ($author['num_video'] ?? '') : '';
          $aId = is_array($author) ? ($author['id'] ?? '') : '';
          $aSlug = strtolower(trim(preg_replace('/[^a-z0-9]+/i', '-', iconv('UTF-8','ASCII//TRANSLIT', (string)$aName)), '-'));
          $aPath = $aSlug ? ($basePath . '/protagonisti/' . $aSlug) : '';
          $aHref = $aPath ? $aPath . '?' . http_build_query(array_filter([
            'id' => $aId ?: null,
            'name' => $aName ?: null,
            'image' => $aImg ?: null,
            'num_video' => $aCount ?: null,
          ])) : '';
          $cat = is_array($v['cat'] ?? null) && !empty($v['cat']) ? $v['cat'][0] : null;
          $subcatName = is_array($cat) ? ($cat['subcategory'] ?? '') : '';
          $catId = is_array($cat) ? ($cat['cat_id'] ?? ($v['cat_id'] ?? '')) : ($v['cat_id'] ?? '');
          $subcatId = is_array($cat) ? ($cat['subcat_id'] ?? ($v['subcat_id'] ?? '')) : ($v['subcat_id'] ?? '');
        ?>
        <div class="card">
          <img class="thumb" src="<?= vm_h($thumb) ?>" alt="" loading="lazy" decoding="async">
          <div class="card-meta">
            <p class="title"><?= vm_h($title) ?></p>
            <p class="desc"><?= vm_h($summary) ?></p>
          </div>
          <div class="card-footer">
            <div class="author">
              <?php if ($aImg && $aHref): ?>
                <a href="<?= vm_h($aHref) ?>"><img src="<?= vm_h($aImg) ?>" alt="" loading="lazy" decoding="async"></a>
              <?php endif; ?>
              <?php if ($aName): ?>
                <div class="author-tooltip"><?= vm_h($aName) ?><?= $aCount ? ' · ' . vm_h($aCount) . ' video' : '' ?></div>
              <?php endif; ?>
            </div>
            <?php if ($subcatName): ?>
              <a class="tag" href="<?= vm_h($basePath . '/?cat_id=' . urlencode((string)$catId) . '&subcat_id=' . urlencode((string)$subcatId)) ?>"><?= vm_h($subcatName) ?></a>
            <?php endif; ?>
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
      'items' => $authorItems,
      'offset' => count($authorItems),
      'limit' => $limit,
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>;
  </script>
  <script>
    window.__AUTHOR__ = <?= json_encode([
      'id' => $authorId ?: null,
      'name' => $authorName ?: null,
      'image' => $authorImg ?: null,
      'num_video' => $authorCount ?: null,
      'facebook' => $authorFb ?: null,
      'linkedin' => $authorLi ?: null,
      'slug' => $authorSlug ?: null,
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
    function normalizeBasePath(p) {
      const parts = String(p || '').split('/').filter(Boolean);
      if (parts.length >= 2 && parts[0] === parts[1]) parts.splice(1, 1);
      return parts.length ? '/' + parts.join('/') : '';
    }
    const BASE_PATH = normalizeBasePath(String(window.APP_CONFIG?.basePath || '').replace(/\/+$/,''));
    const SITE_URL = String(window.APP_CONFIG?.siteUrl || window.location.origin).replace(/\/+$/,'');
    const SITE_BASE = SITE_URL + (BASE_PATH || '');
    const SSR = window.__SSR__ || null;
    function baseUrl(path = '') {
      const clean = String(path || '').replace(/^\/+/, '');
      const baseSeg = BASE_PATH.replace(/^\/+/, '');
      const baseRoot = window.location.origin + (BASE_PATH || '');
      if (!clean) return baseRoot || '/';
      if (baseSeg && (clean === baseSeg || clean.startsWith(baseSeg + '/'))) return window.location.origin + '/' + clean;
      return `${baseRoot}/${clean}`;
    }
    function withQuery(path, query) {
      const base = baseUrl(path);
      return query ? `${base}?${query}` : base;
    }

    const pathMatch = location.pathname.match(/\/protagonisti\/([^/]+)/);
    const rawSegment = pathMatch ? pathMatch[1] : '';
    const idMatch = rawSegment.match(/^(\d+)(?:-|$)/);
    const pathId = idMatch ? idMatch[1] : '';
    const pathSlug = rawSegment ? rawSegment.replace(/^\d+-?/, '') : '';

    const AUTHOR = window.__AUTHOR__ || {};
    const authorId = AUTHOR.id || params.get('id') || pathId || '';
    const authorName = AUTHOR.name || params.get('name') || (pathSlug ? pathSlug.replace(/-/g, ' ') : 'Autore');
    const authorImg = AUTHOR.image || params.get('image') || '';
    const authorCount = AUTHOR.num_video || params.get('num_video') || '';
    const authorFb = AUTHOR.facebook || params.get('facebook') || '';
    const authorLi = AUTHOR.linkedin || params.get('linkedin') || '';

    let searchTerm = params.get('search_term') || '';

    let offset = 0;
    let loading = false;
    let ended = false;
    let restoredScroll = false;

    const grid = document.getElementById('grid');
    const status = document.getElementById('status');
    const skeletons = document.getElementById('skeletons');
    const errBox = document.getElementById('err');
    const errMsg = document.getElementById('errMsg');
    const retryBtn = document.getElementById('retry');
    const sentinel = document.getElementById('sentinel');
    const searchInput = document.getElementById('searchInput');
    const searchClear = document.getElementById('searchClear');
    const authorSticky = document.getElementById('authorSticky');
    const authorImgSticky = document.getElementById('authorImgSticky');
    const searchInputSticky = document.getElementById('searchInputSticky');
    const searchClearSticky = document.getElementById('searchClearSticky');
    const mobileToggle = document.getElementById('mobileToggle');
    const mobileNav = document.getElementById('mobileNav');
    const navBlog = document.getElementById('navBlog');
    const mobileBlog = document.getElementById('mobileBlog');
    const searchJump = document.getElementById('searchJump');
    const navDynamic = document.getElementById('navDynamic');
    const mobileNavDynamic = document.getElementById('mobileNavDynamic');
    const brandLogo = document.getElementById('brandLogo');
    const brandText = document.getElementById('brandText');
    const siteFooter = document.getElementById('siteFooter');
    const footerLogo = document.getElementById('footerLogo');
    const footerLeft = document.getElementById('footerLeft');
    const footerRight = document.getElementById('footerRight');
    const socialsEl = document.getElementById('socials');
    const socialSep = document.getElementById('socialSep');
    let bannerDesktopUrl = '';
    let bannerMobileUrl = '';
    let bannerWebsiteUrl = '';
    let videoRenderCount = 0;

    document.getElementById('authorName').textContent = authorName;
    const imgEl = document.getElementById('authorImg');
    if (authorImg) imgEl.src = authorImg;
    if (authorImg) authorImgSticky.src = authorImg;
    const canonicalEl = document.querySelector('link[rel="canonical"]');
    if (canonicalEl) {
      const nameSlug = AUTHOR.slug || slugify(authorName);
      if (nameSlug) {
        canonicalEl.href = `${SITE_BASE}/protagonisti/${nameSlug}`;
      } else if (pathSlug) {
        canonicalEl.href = `${SITE_BASE}/protagonisti/${pathSlug}`;
      }
    }

    const meta = document.getElementById('authorMeta');
    const metaParts = [];
    if (authorCount) metaParts.push(`${authorCount} video`);
    if (authorFb) metaParts.push(`<a href="${authorFb}" target="_blank" rel="noopener">Facebook</a>`);
    if (authorLi) metaParts.push(`<a href="${authorLi}" target="_blank" rel="noopener">LinkedIn</a>`);
    meta.innerHTML = metaParts.join(' · ');

    function setPersonSchema() {
      const schemaEl = document.getElementById('schemaPerson');
      if (!schemaEl) return;
      const sameAs = [];
      if (authorFb) sameAs.push(authorFb);
      if (authorLi) sameAs.push(authorLi);
      schemaEl.textContent = JSON.stringify({
        '@context': 'https://schema.org',
        '@type': 'Person',
        name: authorName,
        image: authorImg || undefined,
        url: window.location.href,
        sameAs: sameAs.length ? sameAs : undefined,
      });
    }
    setPersonSchema();

    function showLoading(on) {
      status.style.display = on ? 'block' : 'none';
    }
    function showError(on, msg = 'Errore di caricamento.') {
      errBox.style.display = on ? 'block' : 'none';
      if (errMsg) errMsg.textContent = msg;
    }
    function showInfo(msg) {
      status.style.display = 'block';
      status.textContent = msg;
    }
    function clearInfo() {
      status.textContent = 'Caricamento…';
    }
    function showSkeletons(on, count = 6) {
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
          <div class="s-thumb"></div>
          <div class="s-body">
            <div class="s-line w1"></div>
            <div class="s-line w2"></div>
          </div>
          <div class="s-spinner"></div>
        `;
        skeletons.appendChild(sk);
      }
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
      root.querySelectorAll('img.thumb').forEach((img) => {
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
    function setBannerUrls(bannerUrl, bannerMobile) {
      bannerDesktopUrl = bannerUrl || '';
      bannerMobileUrl = bannerMobile || '';
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
      if (!siteFooterEl || !footerLeftEl || !footerRightEl) {
        setTimeout(() => renderFooter(a), 0);
        return;
      }
      const left = (a && a.footer_left) ? String(a.footer_left).trim() : '';
      const right = (a && a.footer_right) ? String(a.footer_right).trim() : '';
      if (!left && !right) { siteFooterEl.style.display = 'none'; return; }
      footerLeftEl.innerHTML = left;
      footerRightEl.innerHTML = right;
      if (footerLogoEl && brandText) footerLogoEl.innerHTML = brandText.innerHTML;
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
        setBannerUrls(item.banner || '', item.banner_mobile || '');
        renderFooter(item);
        renderSocials(item);
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

    function stripHtml(html) {
      const div = document.createElement('div');
      div.innerHTML = html || '';
      return div.textContent || div.innerText || '';
    }

    function toFlag(val) {
      return parseInt(String(val ?? '0'), 10) === 1;
    }
    function normalizeSlug(raw) {
      let slug = String(raw ?? '').trim();
      if (!slug) return '';
      slug = slug.replace(/^https?:\/\/[^/]+/i, '');
      slug = slug.replace(/^[\/]+/, '');
      const baseSeg = BASE_PATH.replace(/^\/+/, '');
      while (baseSeg && slug.startsWith(baseSeg + '/')) {
        slug = slug.slice(baseSeg.length + 1);
      }
      slug = slug.replace(/^(video|blog|gallery)\//, '');
      return slug;
    }
    function contentPathFromItem(v) {
      const slug = normalizeSlug(v?.slug ?? v?.url ?? v?.link ?? '');
      const isGallery = toFlag(v?.gallery);
      const isBlog = toFlag(v?.blog);
      const id = v?.post_id ?? v?.id ?? v?.video_id ?? '';
      if (isGallery && id) return `gallery/${encodeURIComponent(String(id))}`;
      if (isGallery && slug) return `gallery/${slug}`;
      if (isBlog && slug) return `blog/${slug}`;
      if (isBlog && id) return `blog/${encodeURIComponent(String(id))}`;
      if (slug) return `video/${slug}`;
      if (id) return `video/${encodeURIComponent(String(id))}`;
      return '';
    }
    function shareUrlFromItem(v) {
      const path = contentPathFromItem(v);
      return path ? `${SITE_BASE}/${path}` : '';
    }

    const schemaItems = [];
    function updateVideoSchema(items) {
      items.forEach((v) => {
        const slug = v.slug ?? '';
        const url = shareUrlFromItem(v);
        if (!url) return;
        schemaItems.push({
          '@type': 'ListItem',
          position: schemaItems.length + 1,
          url,
          item: {
            '@type': 'VideoObject',
            name: v.title ?? v['seo-title'] ?? '',
            description: stripHtml(v.summary ?? v['seo-description'] ?? ''),
            thumbnailUrl: v.image ?? v.thumbnail ?? v.thumb ?? v.poster ?? '',
            url,
          },
        });
      });
      const schemaEl = document.getElementById('schemaVideos');
      if (schemaEl) {
        schemaEl.textContent = JSON.stringify({
          '@context': 'https://schema.org',
          '@type': 'ItemList',
          itemListElement: schemaItems,
        });
      }
    }

    function renderItems(items) {
      const frag = document.createDocumentFragment();
      items.forEach(v => {
        const title = v.title ?? v['seo-title'] ?? 'Senza titolo';
        const thumb = v.image ?? v.thumbnail ?? v.thumb ?? v.poster ?? '';
        const summary = stripHtml(v.summary ?? v['seo-description'] ?? '');
        const author = Array.isArray(v.authors) && v.authors.length ? v.authors[0] : null;
        const authorImg = author?.image ?? '';
        const authorName = author?.name ?? '';
        const authorCount = author?.num_video ?? '';
        const authorId = author?.id ?? '';
        const authorSlug = author?.slug ?? slugify(authorName);
        const authorHref = authorSlug ? baseUrl(`protagonisti/${authorSlug}`) : '';
        const shareUrl = shareUrlFromItem(v);
        const cat = Array.isArray(v.cat) && v.cat.length ? v.cat[0] : null;
        const subcatName = cat?.subcategory ?? '';
        const catId = cat?.cat_id ?? v.cat_id ?? '';
        const subcatId = cat?.subcat_id ?? v.subcat_id ?? '';

        const card = document.createElement('div');
        card.className = 'card';
        card.innerHTML = `
          <img class="thumb" src="${escapeHtml(thumb)}" alt="" loading="lazy" decoding="async">
          <div class="card-meta">
            <p class="title">${escapeHtml(title)}</p>
            <p class="desc">${escapeHtml(summary)}</p>
          </div>
          <div class="card-footer">
            <div class="author">
              ${authorImg && authorHref ? `<a href="${authorHref}"><img src="${escapeHtml(authorImg)}" alt="" loading="lazy" decoding="async"></a>` : ''}
              ${authorName ? `<div class="author-tooltip">${escapeHtml(authorName)}${authorCount ? ` · ${escapeHtml(authorCount)} video` : ''}</div>` : ''}
            </div>
            ${subcatName ? `<a class="tag" href="${baseUrl(`video/categoria/${slugify(subcatName)}`)}">${escapeHtml(subcatName)}</a>` : ''}
            <div class="share-wrap">
              <button class="share-btn" aria-label="Condividi">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <circle cx="18" cy="5" r="2"></circle>
                  <circle cx="6" cy="12" r="2"></circle>
                  <circle cx="18" cy="19" r="2"></circle>
                  <path d="M8 12l8-6M8 12l8 6"></path>
                </svg>
              </button>
              <div class="share-panel">
                <a aria-label="Mail" href="mailto:?subject=${encodeURIComponent(title)}&body=${encodeURIComponent(shareUrl)}">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 6h16v12H4z"></path>
                    <path d="M4 7l8 6 8-6"></path>
                  </svg>
                </a>
                <a aria-label="Facebook" href="https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(shareUrl)}" target="_blank" rel="noopener">
                  <svg viewBox="0 0 24 24" fill="currentColor">
                    <path d="M13 22v-9h3l1-4h-4V7a2 2 0 0 1 2-2h2V2h-3a5 5 0 0 0-5 5v3H7v4h3v9z"></path>
                  </svg>
                </a>
                <a aria-label="LinkedIn" href="https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(shareUrl)}" target="_blank" rel="noopener">
                  <svg viewBox="0 0 24 24" fill="currentColor">
                    <path d="M4 3a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-1 6h2v12H3zM9 9h2v2a4 4 0 0 1 4-2c3 0 5 2 5 6v6h-2v-6c0-2-1-4-3-4s-3 2-3 4v6H9z"></path>
                  </svg>
                </a>
                <a aria-label="X" href="https://twitter.com/intent/tweet?url=${encodeURIComponent(shareUrl)}&text=${encodeURIComponent(title)}" target="_blank" rel="noopener">
                  <svg viewBox="0 0 24 24" fill="currentColor">
                    <path d="M4 3h3l5 7 5-7h3l-6.5 9L20 21h-3l-5-7-5 7H4l6.5-9z"></path>
                  </svg>
                </a>
              </div>
            </div>
          </div>
        `;
        card.addEventListener('click', () => {
          const path = contentPathFromItem(v);
          try {
            sessionStorage.setItem(`scroll:${location.pathname}`, String(window.scrollY || 0));
          } catch {}
          const base = location.href.split('#')[0];
          const from = `${base}#scroll=${window.scrollY || 0}`;
          if (path) {
            try { sessionStorage.setItem('vm:from', from); } catch {}
            location.href = baseUrl(path);
          }
        });
        const shareBtn = card.querySelector('.share-btn');
        const sharePanel = card.querySelector('.share-panel');
        let shareCloseTimer = null;
        if (shareBtn && sharePanel) {
          shareBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            sharePanel.classList.toggle('open');
          });
          sharePanel.addEventListener('click', (e) => e.stopPropagation());
          sharePanel.addEventListener('mouseenter', () => {
            if (shareCloseTimer) clearTimeout(shareCloseTimer);
          });
          sharePanel.addEventListener('mouseleave', () => {
            if (!sharePanel.classList.contains('open')) return;
            shareCloseTimer = setTimeout(() => sharePanel.classList.remove('open'), 180);
          });
        }
        const openDesc = () => {
          card.classList.add('show-desc');
          grid.classList.add('dim');
        };
        const closeDesc = () => {
          card.classList.remove('show-desc');
          grid.classList.remove('dim');
          if (sharePanel && sharePanel.classList.contains('open')) {
            if (shareCloseTimer) clearTimeout(shareCloseTimer);
            shareCloseTimer = setTimeout(() => sharePanel.classList.remove('open'), 180);
          }
        };
        card.addEventListener('mouseenter', openDesc);
        card.addEventListener('mouseleave', closeDesc);
        card.addEventListener('focusin', openDesc);
        card.addEventListener('focusout', (e) => {
          if (!card.contains(e.relatedTarget)) closeDesc();
        });
        frag.appendChild(card);
        videoRenderCount += 1;
        if (videoRenderCount % 20 === 0) {
          const bannerEl = createInlineBanner();
          if (bannerEl) frag.appendChild(bannerEl);
        }
      });
      grid.appendChild(frag);
      bindSoftFadeImages(grid);
      restoreScrollIfNeeded();
      updateVideoSchema(items);
    }

    function applySSR() {
      if (!SSR?.items || !Array.isArray(SSR.items)) return false;
      grid.innerHTML = '';
      renderItems(SSR.items);
      offset = typeof SSR.offset === 'number' ? SSR.offset : SSR.items.length;
      ended = SSR.items.length < (SSR.limit || limit);
      return true;
    }

    function extractItems(json) {
      if (Array.isArray(json)) return json;
      if (Array.isArray(json?.data)) return json.data;
      if (Array.isArray(json?.videos)) return json.videos;
      if (Array.isArray(json?.data?.data)) return json.data.data;
      return null;
    }

    function effectiveSearchTerm() {
      if (authorId) return searchTerm;
      if (!searchTerm) return authorName || '';
      return `${authorName} ${searchTerm}`.trim();
    }

    async function loadNextPage() {
      if (loading || ended) return;
      loading = true;
      showError(false);
      showLoading(false);
      clearInfo();
      showSkeletons(true, Math.min(6, limit));
      await new Promise(r => setTimeout(r, 250));

      try {
        const qs = new URLSearchParams();
        if (aziendaId) qs.set('azienda_id', String(aziendaId));
        if (limit) qs.set('limit', String(limit));
        qs.set('offset', String(offset));
        const eff = effectiveSearchTerm();
        if (eff) qs.set('search_term', eff);
        if (authorId) qs.set('author_id', authorId);

        const url = `${baseUrl('api/author_videos.php')}?${qs.toString()}`;
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

    function resetAndLoad() {
      offset = 0;
      ended = false;
      videoRenderCount = 0;
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

    searchInput.addEventListener('input', (e) => {
      const value = e.target.value;
      searchClear.classList.toggle('visible', value.trim().length > 0);
      if (searchInputSticky.value !== value) searchInputSticky.value = value;
      searchClearSticky.classList.toggle('visible', value.trim().length > 0);
      if (searchDebounce) clearTimeout(searchDebounce);
      searchDebounce = setTimeout(() => handleSearchInput(value), 300);
    });

    searchInput.addEventListener('focus', () => {
      document.body.classList.add('searching-mobile');
    });
    searchInput.addEventListener('blur', () => {
      document.body.classList.remove('searching-mobile');
    });

    searchClear.addEventListener('click', () => {
      searchInput.value = '';
      searchClear.classList.remove('visible');
      searchInputSticky.value = '';
      searchClearSticky.classList.remove('visible');
      searchTerm = '';
      resetAndLoad();
    });

    searchInputSticky.addEventListener('input', (e) => {
      const value = e.target.value;
      searchClearSticky.classList.toggle('visible', value.trim().length > 0);
      if (searchInput.value !== value) searchInput.value = value;
      searchClear.classList.toggle('visible', value.trim().length > 0);
      if (searchDebounce) clearTimeout(searchDebounce);
      searchDebounce = setTimeout(() => handleSearchInput(value), 300);
    });

    searchInputSticky.addEventListener('focus', () => {
      document.body.classList.add('searching-mobile');
    });
    searchInputSticky.addEventListener('blur', () => {
      document.body.classList.remove('searching-mobile');
    });

    searchClearSticky.addEventListener('click', () => {
      searchInputSticky.value = '';
      searchClearSticky.classList.remove('visible');
      searchInput.value = '';
      searchClear.classList.remove('visible');
      searchTerm = '';
      resetAndLoad();
    });

    mobileToggle.addEventListener('click', () => {
      mobileNav.classList.toggle('open');
    });
    mobileNav.addEventListener('click', (e) => {
      if (e.target && e.target.tagName === 'A') mobileNav.classList.remove('open');
    });

    searchJump.addEventListener('click', () => {
      if (document.activeElement === searchInput || document.activeElement === searchInputSticky) {
        searchInput.blur();
        searchInputSticky.blur();
        document.body.classList.remove('searching-mobile');
        return;
      }
      searchInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
      setTimeout(() => searchInput.focus(), 250);
    });

    const onSticky = () => {
      const y = window.scrollY || 0;
      authorSticky.classList.toggle('active', y > 140);
    };
    window.addEventListener('scroll', onSticky, { passive: true });
    onSticky();

    loadCategories();
    loadAzienda();
    checkBlogMenu();
    if (!applySSR()) loadNextPage();
    bindSoftFadeImages();

    if ('scrollRestoration' in history) history.scrollRestoration = 'manual';
  </script>

  <footer class="site-footer" id="siteFooter" style="display:none;">
    <div class="footer-inner">
      <div class="footer-col">
        <div class="footer-brand" id="footerLogo">videometro<span class="dot">.</span>tv</div>
        <div id="footerLeft"></div>
      </div>
      <div class="footer-col" id="footerRight"></div>
    </div>
  </footer>

</body>
</html>