<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!doctype html>
<html lang="it">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="<?= htmlspecialchars($pageDescription ?? 'Blog e gallery di VideoMetro.') ?>" />
  <link rel="canonical" href="<?= htmlspecialchars($canonical ?? ($siteUrl . $basePath . '/blog')) ?>" />
  <meta name="robots" content="<?= htmlspecialchars($robots ?? 'index, follow') ?>" />
  <meta property="og:type" content="website">
  <meta property="og:title" content="<?= htmlspecialchars($pageTitle ?? 'VideoMetro – Blog & Gallery') ?>">
  <meta property="og:description" content="<?= htmlspecialchars($pageDescription ?? 'Blog e gallery di VideoMetro.') ?>">
  <meta property="og:url" content="<?= htmlspecialchars($canonical ?? ($siteUrl . $basePath . '/blog')) ?>">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <script type="application/ld+json" id="schemaVideos"></script>
  <?php
    $schemaItems = [];
    $pos = 1;
    foreach ($mainItems as $v) {
      $slug = $v['slug'] ?? '';
      if (!$slug) continue;
      $schemaItems[] = [
        '@type' => 'ListItem',
        'position' => $pos++,
        'url' => $siteUrl . $basePath . '/video/' . $slug,
      ];
      if ($pos > 50) break;
    }
    $schema = [
      '@context' => 'https://schema.org',
      '@type' => 'ItemList',
      'itemListElement' => $schemaItems,
    ];
  ?>
  <script type="application/ld+json"><?= json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
  <title><?= htmlspecialchars($pageTitle ?? 'VideoMetro – Blog & Gallery') ?></title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap');
    :root {
      --bg: #0f1115;
      --bar: #1f2740;
      --bar-border: #2b3554;
      --text: #ffffff;
      --muted: rgba(255,255,255,.72);
      --accent: #ff2d2d;
      --badge-url: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="%23ff2d2d" stroke-width="2"><circle cx="12" cy="8" r="5"/><path d="M9 13v8l3-2 3 2v-8"/></svg>');
    }
    body { margin:0; font-family: system-ui, Arial; background:var(--bg); color:var(--text); }
    .topbar { position: sticky; top: 0; z-index: 50; background: rgba(31,39,64,0.92); border-bottom: 1px solid var(--bar-border); backdrop-filter: blur(6px); }
    .topbar-inner { max-width: 1200px; margin: 0 auto; padding: 14px 16px; display:flex; align-items:center; gap: 14px; position: relative; }
    .brand { font-weight: 700; font-size: 26px; letter-spacing: .2px; text-decoration:none; color:#fff; font-family: 'Montserrat', system-ui, Arial, sans-serif; }
    .brand .dot { color: var(--accent); font-size: 1.1em; }
    .nav { display:flex; align-items:center; gap: 16px; color: var(--muted); font-size: 14px; font-family: 'Montserrat', system-ui, Arial, sans-serif; letter-spacing: .2px; }
    .nav a, .nav span, .nav button { color: inherit; text-decoration: none; cursor: pointer; padding: 8px 14px; border-radius: 999px; display:inline-block; transition: background .2s ease, color .2s ease; background: transparent; border: none; font: inherit; }
    .nav a .caret, .nav span.caret { padding: 0; border-radius: 0; background: transparent; }
    .nav a .caret:hover, .nav span.caret:hover { background: transparent; }
    .nav a:hover, .nav span:hover, .nav button:hover { color: #fff; background: rgba(255,255,255,.08); }
    .mega { position:absolute; left:0; right:0; top:100%; background: rgba(24,30,49,0.98); border-bottom: 1px solid var(--bar-border); display:none; z-index: 40; }
    .mega.open { display:block; }
    .mega-inner { max-width: 1200px; margin: 0 auto; padding: 18px 16px 22px; display:flex; flex-wrap:wrap; gap: 10px 12px; }
    .mega a { padding: 10px 12px; border-radius: 999px; color: var(--muted); text-decoration:none; border: 1px solid rgba(255,255,255,.08); font-size: 13px; display:inline-flex; align-items:center; gap: 6px; }
    .mega a:hover { color:#fff; background: rgba(255,255,255,.08); }
    .badge { width: 14px; height: 18px; flex: 0 0 auto; font-size: 0; border: none; color: transparent; background: no-repeat center/contain; background-image: var(--badge-url); }
    .caret { display:inline-block; margin-left: 6px; font-size: 16px; transform: translateY(-1px); }
    .spacer { flex: 1; }
    .icon-btn { width: 36px; height: 36px; border-radius: 999px; border: none; background: transparent; color: #fff; display:grid; place-items:center; cursor:pointer; }
    .icon-btn svg { width: 18px; height: 18px; }
    .hamburger { width: 36px; height: 36px; border-radius: 10px; border: none; background: transparent; color: #fff; display:none; place-items:center; cursor:pointer; }
    .hamburger span { width: 18px; height: 2px; background: currentColor; display:block; position: relative; }
    .hamburger span::before, .hamburger span::after { content:""; position:absolute; left:0; width: 18px; height: 2px; background: currentColor; }
    .hamburger span::before { top:-6px; }
    .hamburger span::after { top:6px; }
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
    .search { display:none; align-items:center; gap: 10px; width: 100%; position: relative; }
    .search input { flex:1; height: 38px; border-radius: 999px; border: 1px solid rgba(255,255,255,.18); background:#151b2b; color:#fff; padding: 0 40px 0 14px; font-size: 15px; font-family: 'Montserrat', system-ui, Arial, sans-serif; }
    .search input::placeholder { color: rgba(255,255,255,.6); }
    .search.active { display:flex; }
    .clear-btn { width: 28px; height: 28px; border-radius: 999px; border: 1px solid rgba(255,80,80,.5); background: transparent; color: #ff6b6b; display:none; place-items:center; cursor:pointer; position:absolute; right: 6px; top: 50%; transform: translateY(-50%); }
    .clear-btn.visible { display:grid; }
    .clear-btn svg { width: 16px; height: 16px; }
    #navDynamic { display: contents; }
    .nav.hidden { display:none; }
    .wrap { max-width: 1200px; margin: 0 auto; padding: 18px 16px 16px; }
    .section { margin-top: 22px; }
    .section:first-of-type { margin-top: 0; }
    .section-title { font-size: 18px; font-weight: 600; margin: 0 0 12px 0; }
    .featured-wrap { margin: 0; padding: 0; }
    .featured { position:relative; overflow:hidden; border-radius:16px; }
    .featured-track { display:flex; gap:16px; transition: transform .6s ease; }
    .f-slide { min-width: calc((100% - 16px) / 2); background:#20283f; border-radius:16px; overflow:hidden; border:1px solid rgba(255,255,255,.08); position:relative; cursor:pointer; display:flex; flex-direction:column; }
    .f-thumb { width:100%; aspect-ratio: 16/9; object-fit:cover; display:block; }
    .f-meta { padding:12px 14px; display:flex; flex-direction:column; gap:6px; flex:1; }
    .f-title { font-size:16px; font-weight:600; margin:0; }
    .f-desc { font-size:12px; opacity:.7; margin:0; }
    .f-footer { display:flex; align-items:center; justify-content:space-between; padding: 10px 14px 14px; border-top: 1px solid rgba(255,255,255,.06); margin-top:auto; }
    .f-author { display:flex; align-items:center; gap:8px; position:relative; }
    .f-author img { width:26px; height:26px; border-radius:999px; object-fit:cover; border:2px solid rgba(255,255,255,.1); }
    .f-author .author-tooltip { position:absolute; left:0; bottom:34px; background:#2b3450; border:1px solid rgba(255,255,255,.08); color:#fff; padding:6px 8px; border-radius:10px; font-size:12px; white-space:nowrap; display:none; }
    .f-author:hover .author-tooltip { display:block; }
    .f-share { width:28px; height:28px; border-radius:999px; border:1px solid rgba(255,255,255,.15); background:transparent; color:#fff; display:grid; place-items:center; }
    .f-slide:hover { background: color-mix(in srgb, var(--accent) 65%, #20283f); border-color: color-mix(in srgb, var(--accent) 70%, rgba(255,255,255,.08)); }
    .f-slide:hover .tag { background: var(--accent); }
    @media (max-width: 900px) {
      .f-slide { min-width: 100%; }
    }
    .banner { max-width: 1200px; margin: 0 auto; padding: 22px 16px 18px; }
    .banner img { width:100%; height:auto; border-radius:14px; display:block; }
    .banner-skeleton { width:100%; height:0; padding-bottom:28%; border-radius:14px; background: linear-gradient(90deg, #2f3850 25%, #3a4563 50%, #2f3850 75%); background-size:200% 100%; animation: shimmer 1.2s infinite; display:none; }
    .grid { display:grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 14px; }
    .grid-4 { grid-template-columns: repeat(4, minmax(0, 1fr)); }
    @media (max-width: 1100px) { .grid-4 { grid-template-columns: repeat(3, minmax(0, 1fr)); } }
    @media (max-width: 900px) { .grid-4 { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
    @media (max-width: 600px) { .grid-4 { grid-template-columns: 1fr; } }
    .inline-banner { grid-column: 1 / -1; }
    .inline-banner img { width:100%; height:auto; border-radius:14px; display:block; }
    .grid.dim .card { opacity: .35; transition: opacity .2s ease; }
    .grid.dim .card.show-desc { opacity: 1; }
    .card { background:#303a52; border-radius:14px; overflow:hidden; cursor:pointer; border: 1px solid rgba(255,255,255,.06); transition: background .2s ease, border-color .2s ease; position: relative; }
    .card:hover { background: color-mix(in srgb, var(--accent) 65%, #303a52); border-color: color-mix(in srgb, var(--accent) 70%, rgba(255,255,255,.06)); }
    .tag { background: rgba(15,17,21,.6); color:#fff; font-size:11px; padding:4px 8px; border-radius:999px; border:1px solid rgba(255,255,255,.15); text-decoration:none; transition: background .2s ease; }
    .tag:hover { background: var(--accent); }
    .tag:hover { background: rgba(255,255,255,.12); }
    .thumb-wrap { position:relative; width:100%; }
    .thumb { width:100%; aspect-ratio: 16/9; background:#222; display:block; object-fit:cover; }
    .thumb-overlay { position:absolute; inset:0; display:flex; align-items:center; justify-content:center; gap:8px; opacity:0; pointer-events:none; background: linear-gradient(180deg, rgba(0,0,0,0) 0%, rgba(0,0,0,.45) 100%); transition: opacity .2s ease; }
    .card:hover .thumb-overlay,
    .f-slide:hover .thumb-overlay,
    .thumb-wrap:hover .thumb-overlay { opacity:1; }
    .type-icon { width:46px; height:46px; border-radius:999px; background: color-mix(in srgb, var(--accent) 22%, rgba(15,17,21,.7)); border:1px solid rgba(255,255,255,.2); display:grid; place-items:center; box-shadow: 0 6px 16px rgba(0,0,0,.35); }
    .type-icon svg { width:24px; height:24px; display:block; }
    .type-icon.blog { background: color-mix(in srgb, var(--accent) 22%, rgba(10, 42, 66, .75)); }
    .type-icon.gallery { background: color-mix(in srgb, var(--accent) 22%, rgba(32, 58, 26, .75)); }
    .type-icon.video { background: color-mix(in srgb, var(--accent) 22%, rgba(84, 20, 20, .75)); }
    .meta { padding:12px 14px 10px; display:flex; flex-direction:column; gap:8px; }
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
    .s-card { background:#2a334a; border-radius:14px; border:1px solid rgba(255,255,255,.06); overflow:hidden; position:relative; display:flex; flex-direction:column; }
    .s-thumb { aspect-ratio:16/9; background: linear-gradient(90deg, #2f3850 25%, #3a4563 50%, #2f3850 75%); background-size:200% 100%; animation: shimmer 1.2s infinite; }
    .s-body { padding:12px 14px 10px; display:flex; flex-direction:column; gap:10px; }
    .s-line { height:10px; border-radius:6px; background: #3a4563; }
    .s-line.w1 { width:70%; }
    .s-line.w2 { width:50%; }
    .s-footer { display:flex; align-items:center; justify-content:space-between; padding: 10px 14px 14px; border-top: 1px solid rgba(255,255,255,.06); }
    .s-avatar-mini { width:28px; height:28px; border-radius:999px; background: #3a4563; }
    .s-pill { height:12px; width:64px; border-radius:999px; background:#3a4563; }
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
      <a class="brand" id="brandLogo" href="<?= htmlspecialchars($baseHref) ?>">videometro.tv</a>
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
            <button type="button" class="nav-cat" data-cat-id="<?= vm_h($id) ?>"><?= vm_h($name) ?> <span class="caret">▾</span></button>
          <?php endforeach; ?>
        </span>
      </nav>
      <div class="spacer"></div>
      <div class="search" id="searchBar">
        <input id="searchInput" type="search" placeholder="Cerca video..." autocomplete="off" />
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
          <button type="button" class="mobile-cat" data-cat-id="<?= vm_h($id) ?>"><?= vm_h($name) ?> <span class="caret">▾</span></button>
          <div class="mobile-sub"></div>
        <?php endforeach; ?>
      </div>
    </div>
    <div class="mega" id="megaMenu">
      <div class="mega-inner" id="megaInner"></div>
    </div>
  </header>
  <div class="banner" id="banner" style="display:none;">
    <div id="bannerSkeleton" class="banner-skeleton"></div>
    <a id="bannerLink" href="#" target="_blank" rel="noopener">
      <img id="bannerImg" alt="">
    </a>
  </div>
  <div class="wrap">
    <section class="section" id="latestSection" style="display:none;">
      <h2 class="section-title">Ultimi contenuti</h2>
      <div id="latestGrid" class="grid grid-4">
        <?php foreach ($latestItems as $v): ?>
          <?php
            $title = $v['title'] ?? $v['seo-title'] ?? 'Senza titolo';
            $thumb = $v['image'] ?? $v['thumbnail'] ?? $v['thumb'] ?? $v['poster'] ?? '';
            $summary = strip_tags((string)($v['summary'] ?? $v['seo-description'] ?? ''));
            $author = is_array($v['authors'] ?? null) && !empty($v['authors']) ? $v['authors'][0] : null;
            $authorImg = is_array($author) ? ($author['image'] ?? '') : '';
            $authorName = is_array($author) ? ($author['name'] ?? '') : '';
            $authorCount = is_array($author) ? ($author['num_video'] ?? '') : '';
            $authorId = is_array($author) ? ($author['id'] ?? '') : '';
            $authorSlug = strtolower(trim(preg_replace('/[^a-z0-9]+/i', '-', iconv('UTF-8','ASCII//TRANSLIT', (string)$authorName)), '-'));
            $authorPath = $authorId ? ($basePath . '/protagonisti/' . rawurlencode((string)$authorId) . '-' . $authorSlug) : ($authorSlug ? $basePath . '/protagonisti/' . $authorSlug : '');
            $authorHref = $authorSlug ? ($basePath . '/protagonisti/' . $authorSlug) : '';
            $cat = is_array($v['cat'] ?? null) && !empty($v['cat']) ? $v['cat'][0] : null;
            $subcatName = is_array($cat) ? ($cat['subcategory'] ?? '') : '';
            $catId = is_array($cat) ? ($cat['cat_id'] ?? ($v['cat_id'] ?? '')) : ($v['cat_id'] ?? '');
            $subcatId = is_array($cat) ? ($cat['subcat_id'] ?? ($v['subcat_id'] ?? '')) : ($v['subcat_id'] ?? '');
          ?>
          <div class="card">
            <div class="thumb-wrap">
              <img class="thumb" src="<?= vm_h($thumb) ?>" alt="" loading="lazy" decoding="async">
            </div>
            <div class="meta">
              <p class="title"><?= vm_h($title) ?></p>
              <p class="desc"><?= vm_h($summary) ?></p>
            </div>
            <div class="card-footer">
              <div class="author">
                <?php if ($authorImg && $authorHref): ?>
                  <a href="<?= vm_h($authorHref) ?>"><img src="<?= vm_h($authorImg) ?>" alt="" loading="lazy" decoding="async"></a>
                <?php endif; ?>
                <?php if ($authorName): ?>
                  <div class="author-tooltip"><?= vm_h($authorName) ?><?= $authorCount ? ' · ' . vm_h($authorCount) . ' video' : '' ?></div>
                <?php endif; ?>
              </div>
              <?php if ($subcatName): ?>
                <a class="tag" href="<?= vm_h($basePath . '/video/categoria/' . vm_slugify($subcatName)) ?>"><?= vm_h($subcatName) ?></a>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <div id="latestSkeletons" class="skeletons grid-4" style="display:none;"></div>
    </section>

    <section class="section" id="featuredSection" style="display:none;">
      <h2 class="section-title">Categorie in evidenza</h2>
      <div class="featured-wrap" id="featuredWrap">
        <div class="featured">
          <div class="featured-track" id="featuredTrack"></div>
        </div>
      </div>
    </section>

    <section class="section">
      <h2 class="section-title" id="contentTitle">Blog & Gallery</h2>
      <div id="grid" class="grid">
        <?php foreach ($mainItems as $v): ?>
          <?php
            $title = $v['title'] ?? $v['seo-title'] ?? 'Senza titolo';
            $thumb = $v['image'] ?? $v['thumbnail'] ?? $v['thumb'] ?? $v['poster'] ?? '';
            $summary = strip_tags((string)($v['summary'] ?? $v['seo-description'] ?? ''));
            $author = is_array($v['authors'] ?? null) && !empty($v['authors']) ? $v['authors'][0] : null;
            $authorImg = is_array($author) ? ($author['image'] ?? '') : '';
            $authorName = is_array($author) ? ($author['name'] ?? '') : '';
            $authorCount = is_array($author) ? ($author['num_video'] ?? '') : '';
            $authorId = is_array($author) ? ($author['id'] ?? '') : '';
            $authorSlug = strtolower(trim(preg_replace('/[^a-z0-9]+/i', '-', iconv('UTF-8','ASCII//TRANSLIT', (string)$authorName)), '-'));
            $authorPath = $authorId ? ($basePath . '/protagonisti/' . rawurlencode((string)$authorId) . '-' . $authorSlug) : ($authorSlug ? $basePath . '/protagonisti/' . $authorSlug : '');
            $authorHref = $authorSlug ? ($basePath . '/protagonisti/' . $authorSlug) : '';
            $cat = is_array($v['cat'] ?? null) && !empty($v['cat']) ? $v['cat'][0] : null;
            $subcatName = is_array($cat) ? ($cat['subcategory'] ?? '') : '';
            $catId = is_array($cat) ? ($cat['cat_id'] ?? ($v['cat_id'] ?? '')) : ($v['cat_id'] ?? '');
            $subcatId = is_array($cat) ? ($cat['subcat_id'] ?? ($v['subcat_id'] ?? '')) : ($v['subcat_id'] ?? '');
          ?>
          <div class="card">
            <div class="thumb-wrap">
              <img class="thumb" src="<?= vm_h($thumb) ?>" alt="" loading="lazy" decoding="async">
            </div>
            <div class="meta">
              <p class="title"><?= vm_h($title) ?></p>
              <p class="desc"><?= vm_h($summary) ?></p>
            </div>
            <div class="card-footer">
              <div class="author">
                <?php if ($authorImg && $authorHref): ?>
                  <a href="<?= vm_h($authorHref) ?>"><img src="<?= vm_h($authorImg) ?>" alt="" loading="lazy" decoding="async"></a>
                <?php endif; ?>
                <?php if ($authorName): ?>
                  <div class="author-tooltip"><?= vm_h($authorName) ?><?= $authorCount ? ' · ' . vm_h($authorCount) . ' video' : '' ?></div>
                <?php endif; ?>
              </div>
              <?php if ($subcatName): ?>
                <a class="tag" href="<?= vm_h($basePath . '/video/categoria/' . vm_slugify($subcatName)) ?>"><?= vm_h($subcatName) ?></a>
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
    </section>
  </div>

  <script>
    window.__SSR__ = <?= json_encode([
      'latest' => $latestItems,
      'featured' => $featuredItems,
      'items' => $mainItems,
      'offset' => $offset + count($mainItems),
      'limit' => $limit,
      'isHomeNoFilters' => $isHomeNoFilters,
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
    const aziendaId = parseInt(params.get('azienda_id') || window.APP_CONFIG?.aziendaId || '1', 10);
    const limit = parseInt(params.get('limit') || '50', 10);
    const BASE_PATH = String(window.APP_CONFIG?.basePath || '').replace(/\/+$/,'');
    const SITE_URL = String(window.APP_CONFIG?.siteUrl || window.location.origin).replace(/\/+$/,'');
    const SITE_BASE = SITE_URL + (BASE_PATH || '');
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
    const catId = params.get('cat_id') || '';
    const subcatId = params.get('subcat_id') || '';
    const featured = params.get('featured') || '';

    let offset = 0;
    let loading = false;
    let ended = false;
    let restoredScroll = false;
    let pendingTargetY = null;
    let searchLockActive = false;
    let searchLockY = 0;
    let searchUserScrolled = false;

    const grid = document.getElementById('grid');
    const latestSection = document.getElementById('latestSection');
    const latestGrid = document.getElementById('latestGrid');
    const latestSkeletons = document.getElementById('latestSkeletons');
    const status = document.getElementById('status');
    const skeletons = document.getElementById('skeletons');
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
    const contentTitle = document.getElementById('contentTitle');
    const banner = document.getElementById('banner');
    const bannerImg = document.getElementById('bannerImg');
    const bannerLink = document.getElementById('bannerLink');
    const bannerSkeleton = document.getElementById('bannerSkeleton');
    const featuredSection = document.getElementById('featuredSection');
    const featuredWrap = document.getElementById('featuredWrap');
    const featuredTrack = document.getElementById('featuredTrack');
    let bannerDesktopUrl = '';
    let bannerMobileUrl = '';
    let bannerWebsiteUrl = '';

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
          <div class="s-thumb"></div>
          <div class="s-body">
            <div class="s-line w1"></div>
          </div>
          <div class="s-footer">
            <div class="s-avatar-mini"></div>
            <div class="s-pill"></div>
          </div>
          <div class="s-spinner"></div>
        `;
        skeletons.appendChild(sk);
      }
    }
    function showLatestSkeletons(on, count = 8) {
      if (!latestSkeletons) return;
      if (!on) {
        latestSkeletons.style.display = 'none';
        latestSkeletons.innerHTML = '';
        return;
      }
      latestSkeletons.style.display = 'grid';
      latestSkeletons.innerHTML = '';
      for (let i = 0; i < count; i += 1) {
        const sk = document.createElement('div');
        sk.className = 's-card';
        sk.innerHTML = `
          <div class="s-thumb"></div>
          <div class="s-body">
            <div class="s-line w1"></div>
          </div>
          <div class="s-footer">
            <div class="s-avatar-mini"></div>
            <div class="s-pill"></div>
          </div>
          <div class="s-spinner"></div>
        `;
        latestSkeletons.appendChild(sk);
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
        pendingTargetY = targetY;
        // Se il contenuto non basta, continua a caricare
        if (document.body.scrollHeight < targetY + 200 && !ended && !searchTerm) {
          loadNextPage();
          return;
        }
        restoredScroll = true;
        setTimeout(() => window.scrollTo(0, targetY), 50);
        try { sessionStorage.removeItem(`scroll:pending:${location.pathname}`); } catch {}
      }
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
    function isHomeNoFilters() {
      return !searchTerm && !catId && !subcatId && !featured;
    }
    function showBannerSkeleton(on) {
      if (!bannerSkeleton) return;
      bannerSkeleton.style.display = on ? 'block' : 'none';
    }

    function updateHomeSectionsVisibility() {
      const showHome = isHomeNoFilters();
      if (latestSection) latestSection.style.display = showHome ? 'block' : 'none';
      if (featuredSection) featuredSection.style.display = 'none';
      if (!banner || !bannerImg || !bannerLink) return;
      const isMobile = window.matchMedia('(max-width: 900px)').matches;
      const src = isMobile && bannerMobileUrl ? bannerMobileUrl : bannerDesktopUrl;
      if (!src) {
        banner.style.display = 'none';
        return;
      }
      bannerLink.href = bannerWebsiteUrl || '#';
      bannerImg.src = src;
      bannerImg.loading = 'eager';
      banner.style.display = 'block';
      showBannerSkeleton(true);
    }
    const subcatNameById = new Map();
    function setContentTitle(text) {
      if (!contentTitle) return;
      contentTitle.textContent = text || 'Blog & Gallery';
    }
    function updateContentTitleDefault() {
      setContentTitle('Blog & Gallery');
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
    function lockSearchScroll() {
      if (!searchLockActive || searchUserScrolled) return;
      requestAnimationFrame(() => {
        if (!searchLockActive || searchUserScrolled) return;
        window.scrollTo(0, searchLockY);
      });
    }

    function setSearchActive(active) {
      if (!searchBar) return;
      searchBar.classList.toggle('active', active);
      if (navMenu) navMenu.classList.toggle('hidden', active);
      if (active) {
        document.body.classList.add('searching-mobile');
        const top = (grid.getBoundingClientRect().top + window.scrollY) - 80;
        const target = Math.max(0, top);
        searchLockActive = true;
        searchUserScrolled = false;
        searchLockY = target;
        lockSearchScroll();
      } else {
        document.body.classList.remove('searching-mobile');
        searchLockActive = false;
        searchUserScrolled = false;
      }
    }

    function restoreSearchFromQuery() {
      if (!searchBar || !searchInput) return;
      const initial = (searchTerm || '').trim();
      if (!initial) return;
      searchInput.value = initial;
      searchClear.classList.toggle('visible', initial.length > 0);
      setSearchActive(true);
    }


    function saveSearchState() {
      try {
        sessionStorage.setItem('vm:searchTerm', (searchTerm || '').trim());
        sessionStorage.setItem('vm:searchOpen', searchBar?.classList.contains('active') ? '1' : '0');
      } catch {}
    }

    function restoreSearchState() {
      try {
        const t = sessionStorage.getItem('vm:searchTerm') || '';
        const o = sessionStorage.getItem('vm:searchOpen') === '1';
        if (t) searchTerm = t;
        if (o || t) {
          searchInput.value = t;
          searchClear.classList.toggle('visible', t.length > 0);
          setSearchActive(true);
        }
      } catch {}
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

    function setAccent(color) {
      if (!color) return;
      document.documentElement.style.setProperty('--accent', color);
      const hex = color.replace('#','');
      const svg = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="${color}" stroke-width="2"><circle cx="12" cy="8" r="5"/><path d="M9 13v8l3-2 3 2v-8"/></svg>`;
      const encoded = encodeURIComponent(svg);
      document.documentElement.style.setProperty('--badge-url', `url("data:image/svg+xml,${encoded}")`);
    }

    function setBrandName(name) {
      if (!name) return;
      const safe = name.replace(/</g, '&lt;').replace(/>/g, '&gt;');
      const idx = safe.lastIndexOf('.');
      if (idx !== -1) {
        brandLogo.innerHTML = `${safe.slice(0, idx)}<span class="dot">.</span>${safe.slice(idx + 1)}`;
      } else {
        brandLogo.textContent = name;
      }
    }

    function setBanner(bannerUrl, bannerMobileUrl) {
      if (!bannerImg || !banner || !bannerLink) return;
      bannerDesktopUrl = bannerUrl || '';
      bannerMobileUrl = bannerMobileUrl || '';
      const isMobile = window.matchMedia('(max-width: 900px)').matches;
      const src = isMobile && bannerMobileUrl ? bannerMobileUrl : bannerUrl;
      if (!src) {
        banner.style.display = 'none';
        return;
      }
      bannerLink.href = bannerWebsiteUrl || '#';
      showBannerSkeleton(true);
      bannerImg.src = src;
      bannerImg.loading = 'eager';
      banner.style.display = 'block';
    }

    if (bannerImg) {
      bannerImg.addEventListener('load', () => {
        setTimeout(() => showBannerSkeleton(false), 200);
      });
      bannerImg.addEventListener('error', () => showBannerSkeleton(false));
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
      try {
        const res = await fetch(`${baseUrl('api/azienda.php')}?azienda_id=${encodeURIComponent(aziendaId)}`, {
          headers: { 'Accept': 'application/json' },
        });
        if (!res.ok) throw new Error(`HTTP ${res.status}`);
        const data = await res.json();
        const item = normalizeAzienda(data?.data ?? data);
        if (!item) return;
        setBrandName(item.name || item.url || '');
        setAccent(item.color_point || '');
        bannerWebsiteUrl = item.website || item.url || '';
        setBanner(item.banner || '', item.banner_mobile || '');
        window.addEventListener('resize', () => setBanner(item.banner || '', item.banner_mobile || ''));
      } catch (e) {
        console.error(e);
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
          caret.textContent = '▾';
          btn.appendChild(caret);
          navDynamic.appendChild(btn);

          const btnMobile = document.createElement('button');
          btnMobile.type = 'button';
          btnMobile.className = 'mobile-cat';
          btnMobile.dataset.catId = id;
          btnMobile.textContent = name;
          const caretMobile = document.createElement('span');
          caretMobile.className = 'caret';
          caretMobile.textContent = '▾';
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

    async function loadSubcategories(catId) {
      megaInner.innerHTML = 'Caricamento…';
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
          subcatNameById.set(String(sid), String(name));
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

    async function loadSubcatLabel() {
      if (!subcatId || !catId) {
        updateContentTitleDefault();
        return;
      }
      const cached = subcatNameById.get(String(subcatId));
      if (cached) {
        setContentTitle(cached);
        return;
      }
      try {
        const res = await fetch(`${baseUrl('api/subcategories.php')}?azienda_id=${encodeURIComponent(aziendaId)}&cat_id=${encodeURIComponent(catId)}`, {
          headers: { 'Accept': 'application/json' },
        });
        if (!res.ok) throw new Error(`HTTP ${res.status}`);
        const data = await res.json();
        const items = Array.isArray(data) ? data : (data.data ?? []);
        items.forEach(s => {
          const name = s.sub_categoria ?? s.subcategory ?? '';
          const sid = s.subcat_id ?? s.id ?? '';
          if (!name || !sid) return;
          subcatNameById.set(String(sid), String(name));
        });
        const label = subcatNameById.get(String(subcatId));
        if (label) {
          setContentTitle(label);
        } else {
          updateContentTitleDefault();
        }
      } catch (e) {
        console.error(e);
        updateContentTitleDefault();
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

    function stripHtml(html) {
      const div = document.createElement('div');
      div.innerHTML = html || '';
      return div.textContent || div.innerText || '';
    }

    const BLOG_FILTER = '1';
    const GALLERY_FILTER = '1';

    function toFlag(val) {
      return String(val ?? '0') === '1';
    }

    function typeIcon(type, label, svg) {
      return `<span class="type-icon ${type}" aria-label="${label}" title="${label}">${svg}</span>`;
    }

    const ICON_VIDEO = `<svg viewBox="0 0 24 24" fill="currentColor"><path d="M8 6l10 6-10 6V6z"></path></svg>`;
    const ICON_BLOG = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M8 3h6l4 4v14H8z"></path><path d="M14 3v5h5"></path><path d="M10 13h6M10 17h6"></path></svg>`;
    const ICON_GALLERY = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="5" width="18" height="14" rx="2"></rect><circle cx="9" cy="10" r="1.5"></circle><path d="M21 15l-5-5-6 6-3-3-4 4"></path></svg>`;

    function contentTypeIcons(v) {
      const isBlog = toFlag(v?.blog);
      const isGallery = toFlag(v?.gallery);
      if (isBlog || isGallery) {
        return [
          isBlog ? typeIcon('blog', 'Blog', ICON_BLOG) : '',
          isGallery ? typeIcon('gallery', 'Galleria', ICON_GALLERY) : '',
        ].filter(Boolean).join('');
      }
      return typeIcon('video', 'Video', ICON_VIDEO);
    }

    function shareUrlFromSlug(slug) {
      if (!slug) return '';
      return `${SITE_BASE}/video/${slug}`;
    }

    const latestCount = 8;
    let latestItems = [];
    let latestRawCount = 0;
    const latestIds = new Set();
    let featuredItems = [];
    let featuredIndex = 0;
    let featuredTimer = null;
    let featuredResizeBound = false;
    const featuredIds = new Set();
    let mainRenderCount = 0;

    function renderFeatured() {
      if (!featuredItems.length) {
        if (featuredSection) featuredSection.style.display = 'none';
        featuredWrap.style.display = 'none';
        return;
      }
      if (featuredSection) featuredSection.style.display = 'block';
      featuredWrap.style.display = 'block';
      featuredTrack.innerHTML = '';
      featuredItems.forEach((v, i) => {
        const title = v.title ?? v['seo-title'] ?? 'Video';
        const thumb = v.image ?? v.thumbnail ?? v.thumb ?? v.poster ?? '';
        const summary = stripHtml(v.summary ?? v['seo-description'] ?? '');
        const author = Array.isArray(v.authors) && v.authors.length ? v.authors[0] : null;
        const authorImg = author?.image ?? '';
        const authorName = author?.name ?? '';
        const authorCount = author?.num_video ?? '';
        const authorId = author?.id ?? '';
        const authorSlug = author?.slug ?? slugify(authorName);
        const authorHref = authorSlug ? baseUrl(`protagonisti/${authorSlug}`) : '';
        const cat = Array.isArray(v.cat) && v.cat.length ? v.cat[0] : null;
        const subcatName = cat?.subcategory ?? '';
        const catId = cat?.cat_id ?? v.cat_id ?? '';
        const subcatId = cat?.subcat_id ?? v.subcat_id ?? '';
        const shareUrl = shareUrlFromSlug(v.slug ?? '');
        const slide = document.createElement('div');
        slide.className = 'f-slide';
        const typeIcons = contentTypeIcons(v);
        slide.innerHTML = `
          <div class="thumb-wrap">
            <img class="f-thumb" src="${escapeHtml(thumb)}" alt="" loading="eager" decoding="async">
            <div class="thumb-overlay">${typeIcons}</div>
          </div>
          <div class="f-meta">
            <p class="f-title">${escapeHtml(title)}</p>
            <p class="f-desc">${escapeHtml(summary)}</p>
          </div>
          <div class="f-footer">
            <div class="f-author">
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
        slide.addEventListener('click', () => {
          const slug = v.slug ?? '';
          const base = location.href.split('#')[0];
          const from = `${base}#scroll=${window.scrollY || 0}`;
          if (slug) {
            try { sessionStorage.setItem('vm:from', from); } catch {}
            saveSearchState();
            location.href = baseUrl(`video/${encodeURIComponent(slug)}`);
          }
        });
        slide.addEventListener('mouseenter', () => { if (featuredTimer) clearInterval(featuredTimer); });
        slide.addEventListener('mouseleave', () => startFeaturedAutoplay());
        const shareBtn = slide.querySelector('.share-btn');
        const sharePanel = slide.querySelector('.share-panel');
        if (shareBtn && sharePanel) {
          shareBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            sharePanel.classList.toggle('open');
          });
          sharePanel.addEventListener('click', (e) => e.stopPropagation());
        }
        featuredTrack.appendChild(slide);
      });
      updateFeaturedPosition();
      if (!featuredResizeBound) {
        featuredResizeBound = true;
        window.addEventListener('resize', () => updateFeaturedPosition());
      }
    }

    function updateFeaturedPosition() {
      const slideEl = featuredTrack.firstElementChild;
      if (!slideEl) return;
      const slideWidth = slideEl.getBoundingClientRect().width + 16;
      const perView = window.matchMedia('(max-width: 900px)').matches ? 1 : 2;
      const maxIndex = Math.max(0, featuredItems.length - perView);
      if (featuredIndex > maxIndex) featuredIndex = 0;
      featuredTrack.style.transform = `translateX(${-featuredIndex * slideWidth}px)`;
    }

    function startFeaturedAutoplay() {
      if (featuredTimer) clearInterval(featuredTimer);
      const perView = window.matchMedia('(max-width: 900px)').matches ? 1 : 2;
      const maxIndex = Math.max(0, featuredItems.length - perView);
      if (maxIndex === 0) return;
      featuredTimer = setInterval(() => {
        if (!featuredItems.length) return;
        featuredIndex = featuredIndex >= maxIndex ? 0 : featuredIndex + 1;
        updateFeaturedPosition();
      }, 4000);
    }

    async function loadFeatured() {}

    async function loadLatest() {
      if (!latestGrid || !latestSection) return;
      latestGrid.innerHTML = '';
      showLatestSkeletons(true, latestCount);
      try {
        const qs = new URLSearchParams();
        if (aziendaId) qs.set('azienda_id', String(aziendaId));
        qs.set('limit', String(latestCount));
        qs.set('offset', '0');
        if (featured) qs.set('featured', featured);
        qs.set('blog', BLOG_FILTER);
        qs.set('gallery', GALLERY_FILTER);
        const res = await fetch(`${baseUrl('api/videos.php')}?${qs.toString()}`, {
          headers: { 'Accept': 'application/json' },
        });
        if (!res.ok) throw new Error(`HTTP ${res.status}`);
        const data = await res.json();
        const rawItems = extractItems(data) || [];
        latestRawCount = rawItems.length;
        const items = rawItems;
        latestItems = items;
        latestIds.clear();
        items.forEach(v => {
          const id = v.id ?? v.video_id;
          if (id) latestIds.add(String(id));
        });
        if (!items.length) {
          latestSection.style.display = 'none';
          showLatestSkeletons(false);
          return;
        }
        latestSection.style.display = 'block';
        renderItems(items, latestGrid, { skipFeatured: false, skipLatest: false, dimGrid: false });
        showLatestSkeletons(false);
      } catch (e) {
        console.error(e);
        latestSection.style.display = 'none';
        showLatestSkeletons(false);
      }
    }

    function applyLatestSSR() {
      if (!latestGrid || !latestSection || !SSR?.latest || !Array.isArray(SSR.latest)) return false;
      latestItems = SSR.latest;
      latestRawCount = latestItems.length;
      latestIds.clear();
      latestItems.forEach(v => {
        const id = v.id ?? v.video_id;
        if (id) latestIds.add(String(id));
      });
      if (!latestItems.length) {
        latestSection.style.display = 'none';
        showLatestSkeletons(false);
        return true;
      }
      latestSection.style.display = 'block';
      latestGrid.innerHTML = '';
      renderItems(latestItems, latestGrid, { skipFeatured: false, skipLatest: false, dimGrid: false });
      showLatestSkeletons(false);
      return true;
    }

    function applyFeaturedSSR() {
      if (!featuredWrap || !featuredSection || !SSR?.featured || !Array.isArray(SSR.featured)) return false;
      featuredItems = SSR.featured;
      featuredIds.clear();
      featuredItems.forEach(v => {
        const id = v.id ?? v.video_id;
        if (id) featuredIds.add(String(id));
      });
      renderFeatured();
      startFeaturedAutoplay();
      return true;
    }

    const schemaItems = [];
    function updateVideoSchema(items) {
      items.forEach((v) => {
        const slug = v.slug ?? '';
        const url = shareUrlFromSlug(slug);
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

    function renderItems(items, targetGrid = grid, options = {}) {
      const { skipFeatured = true, skipLatest = false, dimGrid = true, withInlineBanners = false } = options;
      const frag = document.createDocumentFragment();

      items.forEach(v => {
        const vid = String(v.id ?? v.video_id ?? '');
        if (skipFeatured && featuredIds.has(vid)) return;
        if (skipLatest && latestIds.has(vid)) return;
        // Mappatura campi da API Videometro
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
        const shareUrl = shareUrlFromSlug(v.slug ?? '');
        const cat = Array.isArray(v.cat) && v.cat.length ? v.cat[0] : null;
        const subcatName = cat?.subcategory ?? '';
        const catId = cat?.cat_id ?? v.cat_id ?? '';
        const subcatId = cat?.subcat_id ?? v.subcat_id ?? '';

        const card = document.createElement('div');
        card.className = 'card';
        const typeIcons = contentTypeIcons(v);
        card.innerHTML = `
          <div class="thumb-wrap">
            <img class="thumb" src="${escapeHtml(thumb)}" alt="" loading="lazy" decoding="async">
            <div class="thumb-overlay">${typeIcons}</div>
          </div>
          <div class="meta">
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
          const slug = v.slug ?? '';
          try {
            sessionStorage.setItem(`scroll:${location.pathname}`, String(window.scrollY || 0));
            sessionStorage.setItem(`scroll:pending:${location.pathname}`, '1');
          } catch {}
          const base = location.href.split('#')[0];
          const from = `${base}#scroll=${window.scrollY || 0}`;
          if (slug) {
            try { sessionStorage.setItem('vm:from', from); } catch {}
            saveSearchState();
            location.href = baseUrl(`video/${encodeURIComponent(slug)}`);
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
          if (dimGrid) targetGrid.classList.add('dim');
        };
        const closeDesc = () => {
          card.classList.remove('show-desc');
          if (dimGrid) targetGrid.classList.remove('dim');
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
        if (withInlineBanners && targetGrid === grid) {
          mainRenderCount += 1;
          if (mainRenderCount % 40 === 0) {
            const bannerEl = createInlineBanner();
            if (bannerEl) frag.appendChild(bannerEl);
          }
        }
      });

      targetGrid.appendChild(frag);
      restoreScrollIfNeeded();
      updateVideoSchema(items);
    }

    function resetAndLoad() {
      offset = isHomeNoFilters() ? (latestRawCount || 0) : 0;
      mainRenderCount = 0;
      ended = false;
      grid.innerHTML = '';
      loadNextPage();
    }

    function applyMainSSR() {
      if (!SSR?.items || !Array.isArray(SSR.items)) return false;
      grid.innerHTML = '';
      renderItems(SSR.items, grid, { skipFeatured: true, skipLatest: isHomeNoFilters(), dimGrid: true, withInlineBanners: true });
      offset = typeof SSR.offset === 'number' ? SSR.offset : (isHomeNoFilters() ? (latestRawCount || 0) : 0);
      ended = SSR.items.length < (SSR.limit || limit);
      showSkeletons(false);
      return true;
    }

    function extractItems(json) {
      if (Array.isArray(json)) return json;
      if (Array.isArray(json?.data)) return json.data;
      if (Array.isArray(json?.videos)) return json.videos;
      if (Array.isArray(json?.data?.data)) return json.data.data;
      return null;
    }

    function setPager(visible, page = 1, hasNext = false) {
      if (!pager) return;
      pager.style.display = visible ? 'flex' : 'none';
      if (pagerInfo) pagerInfo.textContent = visible ? `Pagina ${page}` : '';
      if (pagerPrev) pagerPrev.disabled = page <= 1;
      if (pagerNext) pagerNext.disabled = !hasNext;
    }

    async function loadPage(page) {
      if (loading) return;
      loading = true;
      showError(false);
      showLoading(false);
      clearInfo();
      showSkeletons(true, Math.min(12, limit));
      try {
        const qs = new URLSearchParams();
        if (aziendaId) qs.set('azienda_id', String(aziendaId));
        if (limit) qs.set('limit', String(limit));
        qs.set('page', String(page));
        if (searchTerm) qs.set('search_term', searchTerm);
        if (catId) qs.set('cat_id', catId);
        if (subcatId) qs.set('subcat_id', subcatId);
        if (featured) qs.set('featured', featured);
        else qs.set('featured', '0');

        const url = `${baseUrl('api/videos.php')}?${qs.toString()}`;
        const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
        let json = null;
        if (!res.ok) {
          try { json = await res.json(); } catch {}
          const detail = json?.error || json?.detail || `HTTP ${res.status}`;
          throw new Error(detail);
        }
        json = await res.json();
        const items = extractItems(json);
        if (!items) throw new Error('Risposta non valida: array di video non trovato');
        grid.innerHTML = '';
        renderItems(items, grid, { skipFeatured: true, skipLatest: isHomeNoFilters(), dimGrid: true, withInlineBanners: true });
        const hasNext = items.length >= limit;
        currentPage = page;
        setPager(true, currentPage, hasNext);
      } catch (e) {
        console.error(e);
        showError(true, e?.message || 'Errore di caricamento.');
      } finally {
        showSkeletons(false);
        loading = false;
      }
    }


    async function loadNextPage() {
      if (loading || ended) return;

      loading = true;
      showError(false);
      showLoading(false);
      clearInfo();
      showSkeletons(true, Math.min(8, limit));
      await new Promise(r => setTimeout(r, 250));

      try {
        const qs = new URLSearchParams();
        if (aziendaId) qs.set('azienda_id', String(aziendaId));
        if (limit) qs.set('limit', String(limit));
        qs.set('offset', String(offset));
        if (searchTerm) qs.set('search_term', searchTerm);
        if (catId) qs.set('cat_id', catId);
        if (subcatId) qs.set('subcat_id', subcatId);
        if (featured) qs.set('featured', featured);
        qs.set('blog', BLOG_FILTER);
        qs.set('gallery', GALLERY_FILTER);

        const url = `${baseUrl('api/videos.php')}?${qs.toString()}`;
        const res = await fetch(url, { headers: { 'Accept': 'application/json' } });

        let json = null;
        if (!res.ok) {
          try { json = await res.json(); } catch {}
          const detail = json?.error || json?.detail || `HTTP ${res.status}`;
          throw new Error(detail);
        }

        json = await res.json();
        const items = extractItems(json);
        if (!items) {
          throw new Error('Risposta non valida: array di video non trovato');
        }

        renderItems(items, grid, { skipFeatured: true, skipLatest: isHomeNoFilters(), dimGrid: true, withInlineBanners: true });

        // Stop se non arrivano più risultati
        if (items.length === 0 || items.length < limit) {
          ended = true;
          showLoading(false);
          showSkeletons(false);
          return;
        }

        offset += items.length;
        showLoading(false);
        showSkeletons(false);

        // Se dopo il render la pagina è ancora corta, continua a caricare
        if (!searchTerm) ensureFillViewport();
      } catch (e) {
        console.error(e);
        showLoading(false);
        showSkeletons(false);
        showError(true, e?.message || 'Errore di caricamento.');
      } finally {
        loading = false;
      }
    }

    // Infinite scroll con IntersectionObserver + scroll (sempre attivo)
    if ('IntersectionObserver' in window) {
      const io = new IntersectionObserver((entries) => {
        if (entries.some(e => e.isIntersecting)) {
          loadNextPage();
        }
      }, { root: null, rootMargin: '800px 0px', threshold: 0 });

      io.observe(sentinel);
    }

    const onScroll = () => {
      const nearBottom = window.innerHeight + window.scrollY >= document.body.offsetHeight - 800;
      if (nearBottom) loadNextPage();
    };
    window.addEventListener('scroll', onScroll, { passive: true });

    // Fallback: se la pagina è corta, carica subito altre pagine
    function ensureFillViewport() {
      if (ended || loading || searchTerm) return;
      const short = document.body.offsetHeight < window.innerHeight + 200;
      if (short) loadNextPage();
    }

    retryBtn.addEventListener('click', () => loadNextPage());


    let searchDebounce = null;
    function handleSearchInput(value) {
      searchTerm = value.trim();
      updateHomeSectionsVisibility();
      loadSubcatLabel();
      if (searchTerm.length === 0) {
        updateHomeSectionsVisibility();
        if (isHomeNoFilters()) {
          loadLatest().then(() => resetAndLoad());
          loadFeatured();
        } else {
          resetAndLoad();
        }
        return;
      }
      if (searchTerm.length < 3) {
        showInfo('Inserisci almeno 3 lettere per cercare.');
        lockSearchScroll();
        return;
      }
      window.scrollTo({ top: 0, behavior: 'smooth' });
      offset = 0;
      ended = false;
      grid.innerHTML = '';
      loadNextPage();
      lockSearchScroll();
    }

    function closeSearch() {
      searchBar.classList.remove('active');
      navMenu.classList.remove('hidden');
      searchInput.value = '';
      searchTerm = '';
      searchClear.classList.remove('visible');
      
      clearInfo();
      document.body.classList.remove('searching-mobile');
      loadSubcatLabel();
      updateHomeSectionsVisibility();
      if (isHomeNoFilters()) {
        loadLatest().then(() => resetAndLoad());
        loadFeatured();
      }
    }

    searchToggle.addEventListener('click', () => {
      const active = searchBar.classList.toggle('active');
      navMenu.classList.toggle('hidden', active);
      if (active) {
        searchInput.focus();
        document.body.classList.add('searching-mobile');
        const top = (grid.getBoundingClientRect().top + window.scrollY) - 80;
        const target = Math.max(0, top);
        window.scrollTo({ top: target, behavior: 'smooth' });
        searchLockActive = true;
        searchUserScrolled = false;
        searchLockY = target;
        lockSearchScroll();
      } else {
        searchInput.value = '';
        searchTerm = '';
        clearInfo();
        updateHomeSectionsVisibility();
        loadSubcatLabel();
        if (isHomeNoFilters()) {
          loadLatest().then(() => resetAndLoad());
          loadFeatured();
        } else {
          resetAndLoad();
        }
        document.body.classList.remove('searching-mobile');
        searchLockActive = false;
        searchUserScrolled = false;
        window.scrollTo({ top: 0, behavior: 'smooth' });
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
      searchClear.classList.remove('visible');
      if (!isHomeNoFilters()) resetAndLoad();
    });

    window.addEventListener('scroll', () => {
      if (!searchLockActive) return;
      const diff = Math.abs(window.scrollY - searchLockY);
      if (diff > 5) searchUserScrolled = true;
    }, { passive: true });


    mobileToggle.addEventListener('click', () => {
      mobileNav.classList.toggle('open');
    });
    mobileNav.addEventListener('click', (e) => {
      if (e.target && e.target.tagName === 'A') mobileNav.classList.remove('open');
    });

    // prima pagina
    updateHomeSectionsVisibility();
    loadSubcatLabel();
    if (isHomeNoFilters()) {
      const latestApplied = applyLatestSSR();
      const featuredApplied = applyFeaturedSSR();
      const mainApplied = applyMainSSR();
      const latestPromise = latestApplied ? Promise.resolve() : loadLatest();
      const featuredPromise = featuredApplied ? Promise.resolve() : loadFeatured();
      Promise.all([latestPromise, featuredPromise]).finally(() => {
        if (!mainApplied) {
          offset = latestRawCount || 0;
          loadNextPage().then(ensureFillViewport);
        } else {
          ensureFillViewport();
        }
      });
    } else {
      if (latestSection) latestSection.style.display = 'none';
      if (featuredSection) featuredSection.style.display = 'none';
      if (!applyMainSSR()) loadNextPage().then(ensureFillViewport);
      else ensureFillViewport();
    }
    loadCategories();
    loadAzienda();
    checkBlogMenu();

    if ('scrollRestoration' in history) history.scrollRestoration = 'manual';
  </script>
</body>
</html>
