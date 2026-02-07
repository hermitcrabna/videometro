<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!doctype html>
<html lang="it">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="<?= htmlspecialchars($pageDescription ?? 'Post di VideoMetro.') ?>" />
  <link rel="canonical" href="<?= htmlspecialchars($canonical ?? ($siteUrl . $baseHref)) ?>" />
  <meta property="og:type" content="article">
  <meta property="og:title" content="<?= htmlspecialchars($pageTitle ?? 'VideoMetro – Blog') ?>">
  <meta property="og:description" content="<?= htmlspecialchars($pageDescription ?? 'Post di VideoMetro.') ?>">
  <meta property="og:url" content="<?= htmlspecialchars($canonical ?? ($siteUrl . $baseHref)) ?>">
  <?php if (!empty($ogImage)): ?>
  <meta property="og:image" content="<?= htmlspecialchars($ogImage) ?>">
  <?php endif; ?>
  <title><?= htmlspecialchars($pageTitle ?? 'VideoMetro – Blog') ?></title>
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
    #navDynamic { display: contents; }
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
    }

    .wrap { max-width: 1100px; margin: 0 auto; padding: 22px 16px 40px; }
    .hero { display:grid; grid-template-columns: 1.1fr 1fr; gap: 20px; align-items: stretch; }
    .hero-media { border-radius:18px; overflow:hidden; border:1px solid rgba(255,255,255,.08); background: #1a2034; }
    .hero-media img { width:100%; height:100%; object-fit:cover; display:block; opacity:0; transition: opacity .5s ease; }
    .hero-media img.is-loaded { opacity:1; }
    .hero-body { display:flex; flex-direction:column; gap: 14px; padding: 6px 4px; }
    .eyebrow { display:inline-flex; align-items:center; gap:8px; font-size: 12px; color: var(--muted); letter-spacing:.3px; text-transform: uppercase; }
    .title { font-size: 34px; line-height: 1.1; margin: 0; font-weight: 700; }
    .summary { font-size: 15px; opacity:.82; margin: 0; }
    .meta { display:flex; flex-wrap:wrap; gap:10px; margin-top: 4px; }
    .chip { background: rgba(255,255,255,.08); border:1px solid rgba(255,255,255,.12); color:#fff; padding:4px 10px; border-radius:999px; font-size:12px; text-decoration:none; }
    .content { margin-top: 26px; display:grid; grid-template-columns: 1fr 320px; gap: 22px; }
    .article { background: rgba(26,32,52,.7); border:1px solid rgba(255,255,255,.08); border-radius:16px; padding: 18px 20px; }
    .article h2, .article h3, .article h4 { margin-top: 1.2em; }
    .article p { line-height: 1.7; font-size: 15px; opacity:.9; }
    .aside { display:flex; flex-direction:column; gap: 14px; }
    .card { background: rgba(26,32,52,.7); border:1px solid rgba(255,255,255,.08); border-radius:16px; padding: 16px; }
    .card h3 { margin: 0 0 10px 0; font-size: 15px; }
    .kv { display:grid; grid-template-columns: 1fr; gap: 10px; font-size: 13px; color: var(--muted); }
    .kv span { color:#fff; font-weight:600; }
    details { margin-top: 8px; }
    details summary { cursor:pointer; color: var(--muted); }
    pre { white-space: pre-wrap; word-wrap: break-word; background: #101626; border-radius: 12px; padding: 12px; border:1px solid rgba(255,255,255,.08); font-size: 12px; color:#d8e1ff; }
    @media (max-width: 980px) {
      .hero { grid-template-columns: 1fr; }
      .content { grid-template-columns: 1fr; }
    }
    @keyframes shimmer { 0% { background-position: 200% 0; } 100% { background-position: -200% 0; } }
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
        <span class="brand-text" id="brandText"><?= htmlspecialchars($aziendaName ?? 'videometro.tv') ?></span>
      </a>
      <nav class="nav" id="navMenu">
        <a href="<?= htmlspecialchars($basePath . '/protagonisti') ?>">Protagonisti</a>
        <a href="<?= htmlspecialchars($basePath . '/blog') ?>">Blog</a>
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
      <a class="chip hide-mobile" href="<?= htmlspecialchars($basePath . '/blog') ?>">Torna al Blog</a>
    </div>
    <div class="mobile-nav" id="mobileNav">
      <a href="<?= htmlspecialchars($basePath . '/protagonisti') ?>">Protagonisti</a>
      <a href="<?= htmlspecialchars($basePath . '/blog') ?>">Blog</a>
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

  <?php
    $post = $post ?? [];
    $title = $post['title'] ?? $post['seo-title'] ?? 'Post';
    $summary = $post['summary'] ?? $post['seo-description'] ?? '';
    $image = $post['image'] ?? $post['thumbnail'] ?? $post['thumb'] ?? $post['poster'] ?? '';
    $content = $post['content'] ?? $post['description'] ?? $post['body'] ?? $post['text'] ?? '';
    $date = $post['date'] ?? $post['created_at'] ?? $post['data'] ?? '';
    $authors = $post['authors'] ?? [];
    $cat = '';
    if (!empty($post['cat']) && is_array($post['cat'])) {
      $cat = $post['cat'][0]['subcategory'] ?? $post['cat'][0]['sub_categoria'] ?? '';
    } elseif (!empty($post['subcategory'])) {
      $cat = $post['subcategory'];
    }
    $tags = $post['tags'] ?? $post['tag'] ?? [];
    $contentTrim = trim((string)$content);
    $hasHtml = $contentTrim !== strip_tags($contentTrim);
  ?>

  <main class="wrap">
    <section class="hero">
      <div class="hero-media">
        <?php if ($image): ?>
          <img src="<?= vm_h($image) ?>" alt="" id="heroImg" loading="eager" decoding="async">
        <?php endif; ?>
      </div>
      <div class="hero-body">
        <div class="eyebrow"><span class="badge"></span> Blog</div>
        <h1 class="title"><?= vm_h($title) ?></h1>
        <?php if ($summary): ?><p class="summary"><?= vm_h($summary) ?></p><?php endif; ?>
        <div class="meta">
          <?php if ($date): ?><span class="chip"><?= vm_h($date) ?></span><?php endif; ?>
          <?php if ($cat): ?><a class="chip" href="<?= htmlspecialchars($basePath . '/video/categoria/' . vm_slugify((string)$cat)) ?>"><?= vm_h($cat) ?></a><?php endif; ?>
          <?php if (is_array($tags)): ?>
            <?php foreach ($tags as $t): ?>
              <?php if ($t): ?><span class="chip"><?= vm_h($t) ?></span><?php endif; ?>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>
    </section>

    <section class="content">
      <article class="article">
        <?php if ($contentTrim): ?>
          <?php if ($hasHtml): ?>
            <?= $contentTrim ?>
          <?php else: ?>
            <p><?= nl2br(vm_h($contentTrim)) ?></p>
          <?php endif; ?>
        <?php else: ?>
          <p><?= $summary ? vm_h($summary) : 'Contenuto non disponibile.' ?></p>
        <?php endif; ?>
      </article>
      <aside class="aside">
        <div class="card">
          <h3>Dettagli</h3>
          <div class="kv">
            <?php if ($date): ?><div><span>Data</span><br><?= vm_h($date) ?></div><?php endif; ?>
            <?php if (!empty($authors) && is_array($authors)): ?>
              <?php foreach ($authors as $a): ?>
                <?php if (!empty($a['name'])): ?>
                  <div><span>Autore</span><br><?= vm_h($a['name']) ?></div>
                <?php endif; ?>
              <?php endforeach; ?>
            <?php endif; ?>
            <?php if (!empty($post['slug'])): ?><div><span>Slug</span><br><?= vm_h($post['slug']) ?></div><?php endif; ?>
          </div>
        </div>
        <div class="card">
          <h3>Dati completi</h3>
          <details>
            <summary>Mostra JSON API</summary>
            <pre><?= vm_h(json_encode($post, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)) ?></pre>
          </details>
        </div>
      </aside>
    </section>
  </main>

  <script>
    window.APP_CONFIG = {
      aziendaId: <?= (int)$aziendaId ?>,
      basePath: <?= json_encode($basePath) ?>,
    };
  </script>
  <script src="<?= htmlspecialchars($baseHref) ?>config.js"></script>
  <script>
    const aziendaId = parseInt(window.APP_CONFIG?.aziendaId || '1', 10);
    function normalizeBasePath(p) {
      const parts = String(p || '').split('/').filter(Boolean);
      if (parts.length >= 2 && parts[0] === parts[1]) parts.splice(1, 1);
      return parts.length ? '/' + parts.join('/') : '';
    }
    const BASE_PATH = normalizeBasePath(String(window.APP_CONFIG?.basePath || '').replace(/\/+$/,''));
    function baseUrl(path = '') {
      const clean = String(path || '').replace(/^\/+/, '');
      const baseSeg = BASE_PATH.replace(/^\/+/, '');
      const baseRoot = window.location.origin + (BASE_PATH || '');
      if (!clean) return baseRoot || '/';
      if (baseSeg && (clean === baseSeg || clean.startsWith(baseSeg + '/'))) return window.location.origin + '/' + clean;
      return `${baseRoot}/${clean}`;
    }
    const navMenu = document.getElementById('navMenu');
    const navDynamic = document.getElementById('navDynamic');
    const mobileNav = document.getElementById('mobileNav');
    const mobileNavDynamic = document.getElementById('mobileNavDynamic');
    const megaMenu = document.getElementById('megaMenu');
    const megaInner = document.getElementById('megaInner');
    const mobileToggle = document.getElementById('mobileToggle');
    const brandLogo = document.getElementById('brandLogo');
    const brandText = document.getElementById('brandText');
    const heroImg = document.getElementById('heroImg');

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
    function normalizeAzienda(data) {
      if (!data) return null;
      if (Array.isArray(data)) return data[0] || null;
      if (data.id || data.name || data.url || data.banner) return data;
      const vals = Object.values(data);
      return vals && vals.length ? vals[0] : null;
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
      } catch (e) {
        console.error(e);
        if (brandLogo) brandLogo.classList.remove('loading');
      }
    }
    function openMega() { megaMenu.classList.add('open'); }
    function closeMega() { megaMenu.classList.remove('open'); megaInner.innerHTML = ''; }
    function renderMegaSkeleton(count = 8) {
      let html = '<div class="mega-skeletons">';
      for (let i = 0; i < count; i += 1) html += '<span class="mega-pill"></span>';
      html += '</div>';
      return html;
    }
    async function loadSubcategories(catId) {
      if (!catId || !megaInner) return;
      megaInner.innerHTML = renderMegaSkeleton();
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
          const featured = String(s.featured ?? '0') === '1';
          if (!name) return;
          const slug = slugify(name);
          const link = document.createElement('a');
          link.href = baseUrl(`video/categoria/${slug}`);
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
      }
    }
    function bindMegaMenu() {
      if (!navDynamic) return;
      navDynamic.querySelectorAll('.nav-cat').forEach(btn => {
        btn.addEventListener('mouseenter', () => { openMega(); loadSubcategories(btn.dataset.catId); });
        btn.addEventListener('focus', () => { openMega(); loadSubcategories(btn.dataset.catId); });
      });
      navMenu.addEventListener('mouseleave', closeMega);
      megaMenu.addEventListener('mouseenter', openMega);
      megaMenu.addEventListener('mouseleave', closeMega);
      if (mobileNavDynamic) {
        mobileNavDynamic.querySelectorAll('.mobile-cat').forEach((btn) => {
          const sub = btn.nextElementSibling;
          btn.addEventListener('click', async () => {
            const open = sub.classList.toggle('open');
            if (!open) return;
            if (sub.childElementCount > 0) return;
            const catId = btn.dataset.catId || '';
            if (!catId) return;
            const res = await fetch(`${baseUrl('api/subcategories.php')}?azienda_id=${encodeURIComponent(aziendaId)}&cat_id=${encodeURIComponent(catId)}`, {
              headers: { 'Accept': 'application/json' },
            });
            if (!res.ok) return;
            const data = await res.json();
            const items = Array.isArray(data) ? data : (data.data ?? []);
            sub.innerHTML = '';
            items.forEach(s => {
              const name = s.sub_categoria ?? s.subcategory ?? '';
              if (!name) return;
              const slug = slugify(name);
              const a = document.createElement('a');
              a.href = baseUrl(`video/categoria/${slug}`);
              a.textContent = name;
              sub.appendChild(a);
            });
          });
        });
      }
    }

    if (heroImg) {
      if (heroImg.complete) heroImg.classList.add('is-loaded');
      heroImg.addEventListener('load', () => heroImg.classList.add('is-loaded'));
    }
    mobileToggle.addEventListener('click', () => mobileNav.classList.toggle('open'));
    loadAzienda();
    bindMegaMenu();
  </script>
</body>
</html>
