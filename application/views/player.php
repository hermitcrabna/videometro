<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!doctype html>
<html lang="it">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($title) ?></title>
  <meta name="description" content="<?= htmlspecialchars($desc) ?>">
  <link rel="canonical" href="<?= htmlspecialchars($canonical) ?>">
  <meta property="og:type" content="video.other">
  <meta property="og:title" content="<?= htmlspecialchars($title) ?>">
  <meta property="og:description" content="<?= htmlspecialchars($desc) ?>">
  <?php if ($ogImage): ?>
  <meta property="og:image" content="<?= htmlspecialchars($ogImage) ?>">
  <?php endif; ?>
  <script type="application/ld+json" id="schemaVideo"><?php
    $schema = [
      '@context' => 'https://schema.org',
      '@type' => 'VideoObject',
      'name' => $title,
      'description' => $desc,
      'thumbnailUrl' => $ogImage ?: null,
      'url' => $canonical,
    ];
    echo json_encode($schema);
  ?></script>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap');
    :root { --bg:#0f1115; --bar:#1f2740; --bar-border:#2b3554; --text:#fff; --muted:rgba(255,255,255,.72); --accent:<?= htmlspecialchars($aziendaColor) ?>; }
    body { margin:0; font-family: system-ui, Arial; background:var(--bg); color:var(--text); }
    .topbar { position: sticky; top: 0; z-index: 50; background: rgba(31,39,64,0.92); border-bottom: 1px solid var(--bar-border); backdrop-filter: blur(6px); }
    .topbar-inner { max-width: 1200px; margin: 0 auto; padding: 14px 16px; display:flex; align-items:center; gap: 14px; }
    .spacer { flex:1; }
    .back { color: var(--muted); text-decoration:none; font-size: 14px; padding: 8px 14px; border-radius: 999px; transition: background .2s ease, color .2s ease; }
    .brand { font-weight: 700; font-size: 26px; letter-spacing: .2px; text-decoration:none; color:#fff; font-family: 'Montserrat', system-ui, Arial, sans-serif; display:inline-flex; align-items:center; }
    .brand .dot { color: var(--accent); font-size: 1.1em; margin-left: 1px; }
    .brand-text { display:inline-flex; align-items:center; }
    .brand-skeleton { width: min(160px, 40vw); height: 24px; border-radius: 999px; background: linear-gradient(90deg, #2f3850 25%, #3a4563 50%, #2f3850 75%); background-size:200% 100%; animation: shimmer 1.2s infinite; display:none; }
    .brand.loading .brand-text { opacity: 0; visibility: hidden; }
    .brand.loading .brand-skeleton { display:inline-block; }
    @keyframes shimmer { 0% { background-position: 200% 0; } 100% { background-position: -200% 0; } }
    .wrap { max-width: 1200px; margin: 0 auto; padding: 18px 16px 28px; }
    .back { display:inline-block; color: var(--muted); text-decoration:none; margin-bottom:10px; }
    .back:hover { color: #fff; background: rgba(255,255,255,.08); }
    .player { width:100%; aspect-ratio: 16/9; background:#000; border-radius:14px; overflow:hidden; border:1px solid rgba(255,255,255,.06); }
    .audio-overlay { position:absolute; inset:0; display:grid; place-items:center; background:rgba(0,0,0,.35); }
    .audio-btn { padding:10px 14px; border-radius:999px; border:1px solid rgba(255,255,255,.2); background:#1f2740; color:#fff; cursor:pointer; font-weight:600; }
    .meta { margin-top:16px; display:flex; flex-direction:column; gap:8px; }
    .title { font-size: 24px; font-weight: 600; margin:0; }
    .desc { font-size: 14px; opacity:.8; margin:0; }
    .chips { display:flex; flex-wrap:wrap; gap:8px; margin-top:10px; }
    .chip { background: rgba(255,255,255,.08); border:1px solid rgba(255,255,255,.12); color:#fff; padding:4px 8px; border-radius:999px; font-size:12px; text-decoration:none; }
    .authors { display:flex; flex-wrap:wrap; gap:10px; margin-top:12px; }
    .author { display:flex; align-items:center; gap:8px; text-decoration:none; color:#fff; padding:6px 8px; border-radius:999px; background: rgba(255,255,255,.06); border:1px solid rgba(255,255,255,.08); }
    .author img { width:26px; height:26px; border-radius:999px; object-fit:cover; }
    .error { padding: 14px; opacity:.85; }
  </style>
</head>
<body>
  <header class="topbar">
    <div class="topbar-inner">
      <?php
        $brandHtml = htmlspecialchars($aziendaName);
        $dotPos = strrpos($aziendaName, '.');
        if ($dotPos !== false && $dotPos > 0 && $dotPos < strlen($aziendaName) - 1) {
          $left = substr($aziendaName, 0, $dotPos);
          $right = substr($aziendaName, $dotPos + 1);
          $brandHtml = htmlspecialchars($left) . '<span class="dot">.</span>' . htmlspecialchars($right);
        } else {
          $brandHtml = htmlspecialchars($aziendaName) . '<span class="dot">.</span>';
        }
      ?>
      <a class="brand loading" id="brandLogo" href="<?= htmlspecialchars($baseHref) ?>">
        <span class="brand-skeleton" id="brandSkeleton"></span>
        <span class="brand-text" id="brandText"><?= $brandHtml ?></span>
      </a>
      <div class="spacer"></div>
      <a class="back" id="backLink" href="<?= htmlspecialchars($baseHref) ?>">← Ritorna ai video</a>
    </div>
  </header>
  <div class="wrap">
    <div class="player" id="player"></div>
    <div class="meta">
      <h1 class="title" id="title">Caricamento…</h1>
      <p class="desc" id="desc"></p>
      <div class="chips" id="cats"></div>
      <div class="authors" id="authors"></div>
    </div>
    <div class="error" id="err" style="display:none;"></div>
  </div>

  <script>
    window.APP_CONFIG = {
      aziendaId: <?= (int)$aziendaId ?>,
      siteUrl: <?= json_encode($siteUrl) ?>,
      basePath: <?= json_encode($basePath) ?>,
    };
  </script>
  <script src="<?= htmlspecialchars($baseHref) ?>config.js"></script>
  <script>
    const slug = <?= json_encode($slug) ?>;
    const from = <?= json_encode($from) ?>;
    const aziendaId = parseInt(window.APP_CONFIG?.aziendaId || <?= (int)$aziendaId ?> || '1', 10);
    const player = document.getElementById('player');
    const titleEl = document.getElementById('title');
    const descEl = document.getElementById('desc');
    const catsEl = document.getElementById('cats');
    const authorsEl = document.getElementById('authors');
    const errEl = document.getElementById('err');
    const backLink = document.getElementById('backLink');
    const brandLogo = document.getElementById('brandLogo');
    const brandText = document.getElementById('brandText');

    const storedFrom = (() => {
      try { return sessionStorage.getItem('vm:from'); } catch { return null; }
    })();
    const backTarget = from || storedFrom || document.referrer || baseUrl('');
    if (backLink) backLink.href = backTarget;
    if (backLink) {
      backLink.addEventListener('click', (e) => {
        e.preventDefault();
        if (storedFrom || from) {
          location.href = backTarget;
        } else {
          history.back();
        }
      });
    }
    const BASE_PATH = String(window.APP_CONFIG?.basePath || '').replace(/\/+$/,'');
    function baseUrl(path = '') {
      const clean = String(path || '').replace(/^\/+/, '');
      if (!BASE_PATH) return '/' + clean;
      return clean ? `${BASE_PATH}/${clean}` : BASE_PATH || '/';
    }
    function withQuery(path, query) {
      const base = baseUrl(path);
      return query ? `${base}?${query}` : base;
    }

    function stripHtml(html) {
      const div = document.createElement('div');
      div.innerHTML = html || '';
      return div.textContent || div.innerText || '';
    }
    function slugify(value) {
      return String(value ?? '')
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '')
        .toLowerCase()
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/(^-|-$)+/g, '');
    }

    function renderPlayer(v) {
      if (v.type === 'vimeo') {
        const base = `https://player.vimeo.com/video/${encodeURIComponent(v.videolUrl)}`;
        player.innerHTML = `
          <iframe data-base="${base}" data-type="vimeo" src="${base}?autoplay=1&muted=1" width="100%" height="100%" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
          <div class="audio-overlay">
            <button class="audio-btn" id="audioBtn">Attiva audio</button>
          </div>
        `;
      } else if (v.type === 'youtube') {
        const base = `https://www.youtube.com/embed/${encodeURIComponent(v.videolUrl)}`;
        player.innerHTML = `
          <iframe data-base="${base}" data-type="youtube" src="${base}?autoplay=1&mute=1" width="100%" height="100%" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
          <div class="audio-overlay">
            <button class="audio-btn" id="audioBtn">Attiva audio</button>
          </div>
        `;
      } else {
        player.innerHTML = '';
      }
      const audioBtn = document.getElementById('audioBtn');
      if (audioBtn) {
        audioBtn.addEventListener('click', () => {
          const iframe = player.querySelector('iframe');
          if (!iframe) return;
          const base = iframe.getAttribute('data-base') || '';
          const type = iframe.getAttribute('data-type') || '';
          if (!base) return;
          const src = type === 'vimeo' ? `${base}?autoplay=1&muted=0` : `${base}?autoplay=1&mute=0`;
          iframe.src = src;
          const overlay = player.querySelector('.audio-overlay');
          if (overlay) overlay.remove();
        });
      }
    }

    function renderMeta(v) {
      titleEl.textContent = v.title || v['seo-title'] || 'Video';
      descEl.textContent = stripHtml(v.summary || v['seo-description'] || '');

      catsEl.innerHTML = '';
      (v.cat || []).forEach(c => {
        const text = `${c.category || ''}${c.subcategory ? ' • ' + c.subcategory : ''}`.trim();
        if (!text) return;
        const chip = document.createElement('a');
        chip.className = 'chip';
        const chipSlug = slugify(c.subcategory || c.category || '');
        chip.href = baseUrl(`video/categoria/${chipSlug}`);
        chip.textContent = text;
        catsEl.appendChild(chip);
      });

      authorsEl.innerHTML = '';
      (v.authors || []).forEach(a => {
        const link = document.createElement('a');
        link.className = 'author';
        const authorName = a.name || '';
        const authorSlug = a.slug || slugify(authorName);
        link.href = baseUrl(`protagonisti/${authorSlug}`);
        link.innerHTML = `${a.image ? `<img src="${a.image}" alt="">` : ''}<span>${a.name || ''}</span>`;
        authorsEl.appendChild(link);
      });
    }

    async function load() {
      loadAzienda();
      if (!slug) {
        errEl.style.display = 'block';
        errEl.textContent = 'Slug mancante.';
        return;
      }
      try {
        const res = await fetch(`${baseUrl('api/video_by_slug.php')}?slug=${encodeURIComponent(slug)}`, {
          headers: { 'Accept': 'application/json' },
        });
        if (!res.ok) throw new Error(`HTTP ${res.status}`);
        const v = await res.json();
        if (!v || !v.videolUrl) throw new Error('Video non trovato');
        renderPlayer(v);
        renderMeta(v);
      } catch (e) {
        errEl.style.display = 'block';
        errEl.textContent = e.message || 'Errore di caricamento.';
      }
    }

    async function loadAzienda() {
      if (brandLogo) brandLogo.classList.add('loading');
      try {
        const res = await fetch(`${baseUrl('api/azienda.php')}?azienda_id=${encodeURIComponent(String(aziendaId))}`, {
          headers: { 'Accept': 'application/json' },
        });
        if (!res.ok) return;
        const data = await res.json();
        let a = Array.isArray(data) ? data[0] : data;
        if (a && typeof a === 'object' && !a.name && a[0]) a = a[0];
        if (!a) return;
        if (a.color_point) {
          document.documentElement.style.setProperty('--accent', a.color_point);
        }
        const name = (a.name || '').trim();
        if (name) {
          if (brandText) brandText.innerHTML = renderLogo(name);
        }
      } catch {}
      if (brandLogo) brandLogo.classList.remove('loading');
    }

    function renderLogo(name) {
      const idx = name.lastIndexOf('.');
      if (idx > 0 && idx < name.length - 1) {
        const left = name.slice(0, idx);
        const right = name.slice(idx + 1);
        return `${escapeHtml(left)}<span class="dot">.</span>${escapeHtml(right)}`;
      }
      return `${escapeHtml(name)}<span class="dot">.</span>`;
    }

    function escapeHtml(str) {
      return String(str || '')
        .replaceAll('&', '&amp;')
        .replaceAll('<', '&lt;')
        .replaceAll('>', '&gt;')
        .replaceAll('"', '&quot;')
        .replaceAll("'", '&#39;');
    }

    load();
  </script>
</body>
</html>
