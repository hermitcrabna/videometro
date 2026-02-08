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
    body { min-height:100vh; display:flex; flex-direction:column; margin:0; font-family: system-ui, Arial; background:var(--bg); color:var(--text); }
    .topbar { position: sticky; top: 0; z-index: 50; background: rgba(31,39,64,0.92); border-bottom: 1px solid var(--bar-border); backdrop-filter: blur(6px); }
    .topbar-inner { max-width: 1200px; margin: 0 auto; padding: 14px 16px; display:flex; align-items:center; gap: 14px; }
    .spacer { flex:1; }
    .back { color: var(--muted); text-decoration:none; font-size: 14px; padding: 8px 14px; border-radius: 999px; transition: background .2s ease, color .2s ease; }
    .brand { font-weight: 700; font-size: 26px; letter-spacing: .2px; text-decoration:none; color:#fff; font-family: 'Montserrat', system-ui, Arial, sans-serif; display:inline-flex; align-items:center; position: relative; transform: translateY(-3px); }
    .brand .dot { color: var(--accent); font-size: 1.1em; margin-left: 1px; }
    .brand-text { display:inline-flex; align-items:center; }
    .brand-skeleton { width: min(160px, 40vw); height: 24px; border-radius: 999px; background: linear-gradient(90deg, #2f3850 25%, #3a4563 50%, #2f3850 75%); background-size:200% 100%; animation: shimmer 1.2s infinite; display:none; position:absolute; left:0; top:50%; transform: translateY(-50%); pointer-events:none; }
    .brand.loading .brand-text { opacity: 0; }
    .brand.loading .brand-skeleton { display:inline-block; }
    
    .site-footer { margin-top: 46px; padding: 28px 16px 40px; background: #0d1018; border-top: 1px solid rgba(255,255,255,.06); }
    .footer-inner { max-width: 1200px; margin: 0 auto; display:grid; grid-template-columns: 1fr 1fr; gap: 26px; }
    .footer-brand { font-weight: 700; font-size: 22px; letter-spacing: .2px; color:#fff; font-family: 'Montserrat', system-ui, Arial, sans-serif; display:inline-flex; align-items:center; }
    .footer-brand .dot { color: var(--accent); font-size: 1.05em; margin-left: 1px; }
    .footer-col { color: rgba(255,255,255,.82); line-height: 1.6; font-size: 14px; }
    .footer-col a { color:#fff; font-weight:700; text-decoration:none; }
    @media (max-width: 900px) { .footer-inner { grid-template-columns: 1fr; } }
    @keyframes shimmer { 0% { background-position: 200% 0; } 100% { background-position: -200% 0; } }
    .wrap { flex:1; width:100%; max-width: 1200px; margin: 0 auto; padding: 25px 16px 28px; box-sizing: border-box; }
    .back { display:inline-block; color: var(--muted); text-decoration:none; margin-bottom:10px; }
    .back:hover { color: #fff; background: rgba(255,255,255,.08); }
    .player { width:100%; aspect-ratio: 16/9; background: rgba(31,39,64,0.92); border-radius:14px; overflow:hidden; border:1px solid rgba(255,255,255,.06); position:relative; }
    .vm-embed { position:absolute; inset:0; }
    .vm-embed iframe { width:100%; height:100%; display:block; }
    .player.is-youtube { overflow: hidden; }
    .player.is-youtube #vmEmbed { position:absolute; left:50%; top:50%; width:100% !important; height:100% !important; transform: translate(-50%, -50%); }
    .vm-controls { position:absolute; left:10px; right:10px; bottom:10px; display:flex; align-items:center; gap:10px; padding:10px 12px; border-radius:12px; background: linear-gradient(180deg, rgba(15,17,21,0.2), rgba(15,17,21,0.75)); border:1px solid rgba(255,255,255,.08); backdrop-filter: blur(8px); }
    .vm-btn { width:34px; height:34px; border-radius:10px; border:1px solid rgba(255,255,255,.12); background: rgba(255,255,255,.06); color:#fff; display:grid; place-items:center; cursor:pointer; }
    .vm-btn svg { width:18px; height:18px; display:block; }
    .vm-time { font-size:12px; color: rgba(255,255,255,.75); min-width: 80px; text-align:center; }
    .vm-range { -webkit-appearance:none; appearance:none; height:6px; border-radius:999px; background: rgba(255,255,255,.18); outline:none; }
    .vm-range::-webkit-slider-thumb { -webkit-appearance:none; appearance:none; width:14px; height:14px; border-radius:50%; background:#fff; border:2px solid rgba(0,0,0,.2); }
    .vm-range::-moz-range-thumb { width:14px; height:14px; border-radius:50%; background:#fff; border:2px solid rgba(0,0,0,.2); }
    .vm-progress { flex:1; }
    .vm-volume { width:90px; }
    .vm-unmute { position:absolute; left:12px; top:12px; z-index:2; width:auto; height:auto; padding:8px 12px; border-radius:999px; display:inline-flex; align-items:center; gap:8px; font-size:13px; background: rgba(31,39,64,0.55); border-color: rgba(255,255,255,.35); color:#fff; text-shadow: 0 1px 2px rgba(0,0,0,.6); }
    .vm-unmute.hidden { display:none; }
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
  <script src="https://player.vimeo.com/api/player.js"></script>
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
    const siteFooter = document.getElementById('siteFooter');
    const footerLogo = document.getElementById('footerLogo');
    const footerLeft = document.getElementById('footerLeft');
    const footerRight = document.getElementById('footerRight');

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

    let ytReadyPromise = null;
    function loadYouTubeAPI() {
      if (ytReadyPromise) return ytReadyPromise;
      ytReadyPromise = new Promise((resolve) => {
        if (window.YT && window.YT.Player) return resolve(window.YT);
        const tag = document.createElement('script');
        tag.src = 'https://www.youtube.com/iframe_api';
        document.head.appendChild(tag);
        window.onYouTubeIframeAPIReady = () => resolve(window.YT);
      });
      return ytReadyPromise;
    }

    function formatTime(seconds) {
      if (!Number.isFinite(seconds)) return '0:00';
      const s = Math.max(0, Math.floor(seconds));
      const m = Math.floor(s / 60);
      const r = s % 60;
      return `${m}:${String(r).padStart(2,'0')}`;
    }

    function renderPlayer(v) {
      if (!v || !v.type) {
        player.innerHTML = '';
        return;
      }
      player.classList.toggle('is-youtube', v.type === 'youtube');
      player.innerHTML = `
        <div class="vm-embed" id="vmEmbed"></div>
        <button class="vm-btn vm-unmute" id="vmUnmute" aria-label="Attiva audio">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
            <path d="M3 9v6h4l5 4V5L7 9H3z"></path>
            <path d="M16 9a4 4 0 0 1 0 6"></path>
            <path d="M19 6a7 7 0 0 1 0 12"></path>
          </svg>
          <span>Attiva audio</span>
        </button>
        <div class="vm-controls" id="vmControls">
          <button class="vm-btn" id="vmPlay" aria-label="Play/Pausa">
            <svg id="vmPlayIcon" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
              <path d="M8 5l11 7-11 7z"></path>
            </svg>
          </button>
          <button class="vm-btn" id="vmMute" aria-label="Mute">
            <svg id="vmMuteIcon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
              <path d="M3 9v6h4l5 4V5L7 9H3z"></path>
              <path d="M16 9a4 4 0 0 1 0 6"></path>
            </svg>
          </button>
          <input class="vm-range vm-volume" id="vmVolume" type="range" min="0" max="100" value="0" aria-label="Volume">
          <div class="vm-time"><span id="vmCur">0:00</span> / <span id="vmDur">0:00</span></div>
          <input class="vm-range vm-progress" id="vmProgress" type="range" min="0" max="1000" value="0" aria-label="Avanzamento">
          <button class="vm-btn" id="vmFull" aria-label="Schermo intero">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
              <path d="M4 9V4h5"></path>
              <path d="M20 9V4h-5"></path>
              <path d="M4 15v5h5"></path>
              <path d="M20 15v5h-5"></path>
            </svg>
          </button>
        </div>
      `;

      const embedEl = document.getElementById('vmEmbed');
      const unmuteBtn = document.getElementById('vmUnmute');
      const playBtn = document.getElementById('vmPlay');
      const playIcon = document.getElementById('vmPlayIcon');
      const muteBtn = document.getElementById('vmMute');
      const muteIcon = document.getElementById('vmMuteIcon');
      const volumeEl = document.getElementById('vmVolume');
      const progressEl = document.getElementById('vmProgress');
      const curEl = document.getElementById('vmCur');
      const durEl = document.getElementById('vmDur');
      const fullBtn = document.getElementById('vmFull');

      let isMuted = true;
      let isPlaying = true;
      let duration = 0;
      let updating = null;

      const updatePlayIcon = () => {
        playIcon.innerHTML = isPlaying ? '<path d="M6 5h4v14H6zM14 5h4v14h-4z"></path>' : '<path d="M8 5l11 7-11 7z"></path>';
      };
      const updateMuteIcon = () => {
        muteIcon.innerHTML = isMuted
          ? '<path d="M3 9v6h4l5 4V5L7 9H3z"></path><path d="M16 9a4 4 0 0 1 0 6"></path><path d="M19 5l-8 14"></path>'
          : '<path d="M3 9v6h4l5 4V5L7 9H3z"></path><path d="M16 9a4 4 0 0 1 0 6"></path>';
      };
      const updateTimeUI = (current) => {
        curEl.textContent = formatTime(current);
        durEl.textContent = formatTime(duration);
        if (!progressEl.matches(':active') && duration > 0) {
          progressEl.value = String(Math.min(1000, Math.max(0, Math.round((current / duration) * 1000))));
        }
      };

      const setupCommonHandlers = (api) => {
        playBtn.addEventListener('click', async () => {
          if (isPlaying) {
            await api.pause();
            isPlaying = false;
          } else {
            await api.play();
            isPlaying = true;
          }
          updatePlayIcon();
        });
        muteBtn.addEventListener('click', async () => {
          if (isMuted) {
            if (volumeEl.value === '0') volumeEl.value = '70';
            await api.setVolume(parseInt(volumeEl.value, 10));
            await api.setMuted(false);
            isMuted = false;
            unmuteBtn.classList.add('hidden');
          } else {
            await api.setMuted(true);
            isMuted = true;
            unmuteBtn.classList.remove('hidden');
          }
          updateMuteIcon();
        });
        unmuteBtn.addEventListener('click', async () => {
          const targetVol = parseInt(volumeEl.value, 10) || 70;
          volumeEl.value = String(targetVol);
          try { await api.setVolume(targetVol); } catch {}
          try { await api.setMuted(false); } catch {}
          if (api.restart) {
            await api.restart();
          } else if (api.playStrong) {
            await api.playStrong();
          } else {
            try { await api.play(); } catch {}
            setTimeout(() => { try { api.play(); } catch {} }, 200);
          }
          isMuted = false;
          isPlaying = true;
          updatePlayIcon();
          unmuteBtn.classList.add('hidden');
          updateMuteIcon();
        });
        volumeEl.addEventListener('input', async () => {
          const val = parseInt(volumeEl.value, 10);
          if (val === 0) {
            await api.setMuted(true);
            isMuted = true;
            unmuteBtn.classList.remove('hidden');
          } else {
            await api.setVolume(val);
            await api.setMuted(false);
            isMuted = false;
            unmuteBtn.classList.add('hidden');
          }
          updateMuteIcon();
        });
        progressEl.addEventListener('input', async () => {
          if (!duration) return;
          const pct = parseInt(progressEl.value, 10) / 1000;
          await api.seek(duration * pct);
        });
        fullBtn.addEventListener('click', () => {
          const el = player;
          if (!document.fullscreenElement) {
            el.requestFullscreen?.();
          } else {
            document.exitFullscreen?.();
          }
        });
      };

      const startUpdating = (getCurrent) => {
        if (updating) clearInterval(updating);
        updating = setInterval(async () => {
          const current = await getCurrent();
          updateTimeUI(current);
        }, 300);
      };

      if (v.type === 'vimeo') {
        const vimeoOpts = {
          autoplay: true,
          muted: true,
          controls: false,
          title: false,
          byline: false,
          portrait: false,
        };
        const rawVimeo = String(v.videolUrl || '');
        if (rawVimeo.includes('/')) vimeoOpts.url = rawVimeo;
        else vimeoOpts.id = rawVimeo;
        const vmPlayer = new Vimeo.Player(embedEl, vimeoOpts);
        const api = {
          play: () => vmPlayer.play(),
          pause: () => vmPlayer.pause(),
          setMuted: (m) => vmPlayer.setMuted(m),
          setVolume: (val) => vmPlayer.setVolume(Math.max(0, Math.min(1, val / 100))),
          seek: (t) => vmPlayer.setCurrentTime(t),
          restart: async () => {
            try { await vmPlayer.setCurrentTime(0); } catch {}
            try { await vmPlayer.play(); } catch {}
          },
          playStrong: async () => {
            try { await vmPlayer.play(); return; } catch {}
            try {
              const t = await vmPlayer.getCurrentTime();
              await vmPlayer.setCurrentTime(Math.max(0, t - 0.05));
              await vmPlayer.play();
            } catch {}
          },
        };
        vmPlayer.on('loaded', async () => {
          duration = await vmPlayer.getDuration();
          updatePlayIcon();
          updateMuteIcon();
          setupCommonHandlers(api);
          startUpdating(() => vmPlayer.getCurrentTime());
          try {
            const muted = await vmPlayer.getMuted();
            const vol = await vmPlayer.getVolume();
            isMuted = muted || vol === 0;
            volumeEl.value = String(Math.round((vol || 0) * 100));
            unmuteBtn.classList.toggle('hidden', !isMuted);
            updateMuteIcon();
          } catch {}
        });
        vmPlayer.on('play', () => { isPlaying = true; updatePlayIcon(); });
        vmPlayer.on('pause', () => { isPlaying = false; updatePlayIcon(); });
        vmPlayer.on('volumechange', async () => {
          try {
            const muted = await vmPlayer.getMuted();
            const vol = await vmPlayer.getVolume();
            isMuted = muted || vol === 0;
            volumeEl.value = String(Math.round((vol || 0) * 100));
            unmuteBtn.classList.toggle('hidden', !isMuted);
            updateMuteIcon();
          } catch {}
        });
      } else if (v.type === 'youtube') {
        loadYouTubeAPI().then((YT) => {
          const ytPlayer = new YT.Player(embedEl, {
            videoId: String(v.videolUrl || ''),
            playerVars: {
              autoplay: 1,
              mute: 1,
              controls: 0,
              rel: 0,
              modestbranding: 1,
              playsinline: 1,
              iv_load_policy: 3,
            },
            events: {
              onReady: () => {
                duration = ytPlayer.getDuration() || 0;
                updatePlayIcon();
                updateMuteIcon();
                setupCommonHandlers({
                  play: () => ytPlayer.playVideo(),
                  pause: () => ytPlayer.pauseVideo(),
                  setMuted: (m) => m ? ytPlayer.mute() : ytPlayer.unMute(),
                  setVolume: (val) => ytPlayer.setVolume(val),
                  seek: (t) => ytPlayer.seekTo(t, true),
                  restart: async () => {
                    ytPlayer.seekTo(0, true);
                    ytPlayer.playVideo();
                  },
                });
                startUpdating(() => Promise.resolve(ytPlayer.getCurrentTime()));
                try {
                  const muted = ytPlayer.isMuted();
                  const vol = ytPlayer.getVolume();
                  isMuted = muted || vol === 0;
                  volumeEl.value = String(vol || 0);
                  unmuteBtn.classList.toggle('hidden', !isMuted);
                  updateMuteIcon();
                } catch {}
              },
              onStateChange: (e) => {
                if (e.data === YT.PlayerState.PAUSED) { isPlaying = false; updatePlayIcon(); }
                if (e.data === YT.PlayerState.PLAYING) { isPlaying = true; updatePlayIcon(); }
              },
            },
          });
        });
      } else {
        player.innerHTML = '';
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
