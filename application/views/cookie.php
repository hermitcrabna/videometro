<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!doctype html>
<html lang="it">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="<?= htmlspecialchars($pageDescription ?? 'Cookie Policy') ?>" />
  <link rel="canonical" href="<?= htmlspecialchars($canonical ?? ($siteUrl . $baseHref)) ?>" />
  <meta property="og:type" content="article">
  <meta property="og:title" content="<?= htmlspecialchars($pageTitle ?? 'Cookie Policy') ?>">
  <meta property="og:description" content="<?= htmlspecialchars($pageDescription ?? 'Cookie Policy') ?>">
  <meta property="og:url" content="<?= htmlspecialchars($canonical ?? ($siteUrl . $baseHref)) ?>">
  <title><?= htmlspecialchars($pageTitle ?? 'Cookie Policy') ?></title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap');
    :root {
      --bg: #0f1115;
      --bar: #1f2740;
      --bar-border: #2b3554;
      --text: #ffffff;
      --muted: rgba(255,255,255,.72);
      --accent: #ff2d2d;
    }
    body { min-height:100vh; display:flex; flex-direction:column; margin:0; font-family: system-ui, Arial; background:var(--bg); color:var(--text); }
    .topbar { position: sticky; top: 0; z-index: 50; background: rgba(31,39,64,0.92); border-bottom: 1px solid var(--bar-border); backdrop-filter: blur(6px); }
    .topbar-inner { max-width: 1200px; margin: 0 auto; padding: 14px 16px; display:flex; align-items:center; gap: 14px; }
    .brand { font-weight: 700; font-size: 26px; letter-spacing: .2px; text-decoration:none; color:#fff; font-family: 'Montserrat', system-ui, Arial, sans-serif; display:inline-flex; align-items:center; position: relative; transform: translateY(-3px); }
    .brand .dot { color: var(--accent); font-size: 1.1em; }
    .brand-text { display:inline-flex; align-items:center; }
    .brand-skeleton { width: min(160px, 40vw); height: 24px; border-radius: 999px; background: linear-gradient(90deg, #2f3850 25%, #3a4563 50%, #2f3850 75%); background-size:200% 100%; animation: shimmer 1.2s infinite; display:none; position:absolute; left:0; top:50%; transform: translateY(-50%); pointer-events:none; }
    .brand.loading .brand-text { opacity: 0; }
    .brand.loading .brand-skeleton { display:inline-block; }
    .spacer { flex: 1; }
    .back-btn { color: var(--muted); text-decoration:none; display:inline-flex; align-items:center; gap:8px; font-size:14px; padding: 8px 12px; border-radius: 999px; border:1px solid rgba(255,255,255,.12); background: rgba(255,255,255,.04); }
    .back-btn:hover { color:#fff; background: rgba(255,255,255,.08); }
    .wrap { flex:1; width:100%; max-width: 1200px; margin: 0 auto; padding: 28px 16px 40px; box-sizing: border-box; }
    .title { font-size: 30px; line-height: 1.1; margin: 0 0 16px; font-weight: 700; }
    .content { font-size: 15px; line-height: 1.7; color: rgba(255,255,255,.85); }
    .content a { color:#fff; font-weight:700; }
    @keyframes shimmer { 0% { background-position: 200% 0; } 100% { background-position: -200% 0; } }
  </style>
</head>
<body>
  <header class="topbar">
    <div class="topbar-inner">
      <a class="brand loading" id="brandLogo" href="<?= htmlspecialchars($baseHref) ?>">
        <span class="brand-skeleton" id="brandSkeleton"></span>
        <span class="brand-text" id="brandText">videometro.tv</span>
      </a>
      <div class="spacer"></div>
      <a class="back-btn" id="backBtn" href="<?= htmlspecialchars($baseHref) ?>" aria-label="Torna indietro">← Torna indietro</a>
    </div>
  </header>

  <main class="wrap">
    <div class="content" id="cookieContent">
      <h1>Cookies policy</h1>
      <h2>Video Metro TV </h2>
      <p>Questo sito utilizza cookie, anche di terze parti, per migliorarne l’esperienza di navigazione e consentire a chi naviga di usufruire dei nostri servizi online e di visualizzare pubblicità in linea con le proprie preferenze.</p>
                  <h5>COSA SONO I COOKIE</h5>
                  <p>I cookie sono frammenti di testo inviati all’utente dal sito web visitato. Vengono memorizzati sull’hard disk del computer, consentendo in questo modo al sito web di riconoscere gli utenti e memorizzare determinate informazioni su di loro, al fine di permettere o migliorare il servizio offerto. Esistono diverse tipologie di cookie. Alcuni sono necessari per poter navigare sul Sito, altri hanno scopi diversi come garantire la sicurezza interna, amministrare il sistema, effettuare analisi statistiche, comprendere quali sono le sezioni del Sito che interessano maggiormente gli utenti od offrire una visita personalizzata del Sito. Il presente Sito Web utilizza cookie tecnici e NON cookie di profilazione. Quanto precede si riferisce sia al computer dell’utente sia ad ogni altro dispositivo che l’utente può utilizzare per connettersi al Sito. Nello specifico i nostri cookie permettono di:
      <ul>
      	<li>memorizzare le preferenze inserite</li>
      	<li>evitare di reinserire le stesse informazioni pi&ugrave; volte durante la visita quali ad esempio nome utente e password</li>
      	<li>analizzare l’utilizzo dei servizi e dei contenuti forniti dal Sito per ottimizzarne l’esperienza di navigazione e i servizi offerti</li>
      	</ul>
      Ci riserviamo di modificare questa policy in qualsiasi momento. Qualunque cambiamento nella presente policy avr&agrave; effetto dalla data di pubblicazione sul Sito.
      </p>
      <h5>COME PRESTO IL MIO CONSENSO ALL’ACCETTAZIONE DEI COOKIE</h5>
      <p>Navigando il presente sito web, scorrendo la pagina o cliccando qualunque suo elemento acconsenti all’uso dei cookie da parte del presente sito web.</p>
      <h5>COME MODIFICO LE PREFERENZE SUI COOKIE</h5>
      <p>La maggior parte dei browser accetta automaticamente i cookie, ma l’utente normalmente pu&ograve; modificare le impostazioni per disabilitare tale funzione. &egrave; possibile bloccare tutte le tipologie di cookie, oppure accettare di riceverne soltanto alcuni e disabilitarne altri. La sezione “Opzioni” o “Preferenze” nel menu del browser permettono di evitare di ricevere cookie e altre tecnologie di tracciamento utente, e come ottenere notifica dal browser dell’attivazione di queste tecnologie. In alternativa, &egrave; anche possibile consultare la sezione “Aiuto” della barra degli strumenti presente nella maggior parte dei browser.
      &egrave; anche possibile selezionare il browser che utilizzate dalla lista di seguito e seguire le istruzioni:<br/>

      <ul>
      	<li>Internet Explorer: http://windows.microsoft.com/it-it/internet-explorer/delete-manage-cookies</li>
      	<li>Google Chrome: https://support.google.com/chrome/answer/95647</li>
      	<li>Apple Safari: https://support.apple.com/it-it/HT201265</li>
      	<li>Mozilla Firefox: https://support.mozilla.org/it/kb/Gestione%20dei%20cookie</li>
      	<li>Opera: http://help.opera.com/Windows/10.00/it/cookies.html</li>

      </ul>
      Da dispositivo mobile:
      <ul>
      	<li>Android: https://support.google.com/chrome/answer/95647</li>
      	<li>Safari: https://support.apple.com/it-it/HT201265</li>
      	<li>Windows Phone: http://windows.microsoft.com/it-it/internet-explorer/delete-manage-cookies</li>
      	</ul>
      Si ricorda per&ograve; che la disabilitazione dei cookie di navigazione o quelli funzionali pu&ograve; causare il malfunzionamento del Sito e/o limitare il servizio offerto.
      </p>
      <h5>COOKIE TECNICI</h5>
      <p>I cookie tecnici sono quelli utilizzati al solo fine di effettuare la trasmissione di una comunicazione su una rete di comunicazione elettronica, o nella misura strettamente necessaria al fornitore di un servizio della società dell’informazione esplicitamente richiesto dall’abbonato o dall’utente a erogare tale servizio. Essi non vengono utilizzati per scopi ulteriori e sono normalmente installati direttamente dal titolare o gestore del sito web.   Possono essere suddivisi in cookie di navigazione o di sessione, che garantiscono la normale navigazione e fruizione del sito web (permettendo, ad esempio, di realizzare un acquisto o autenticarsi per accedere ad aree riservate).
      <br/>
      I cookie tecnici previsti dal Sito sono:<br/>
      <ul>
      	<li>•	Cookie di sessione: Sono utilizzati per gestire il login e l’accesso alle funzioni riservate del sito. La loro disattivazione compromette l’utilizzo dei servizi accessibili da login.</li>
      </ul>
      </p>
      <h5>COOKIE DI PROFILAZIONE DI TERZE PARTI</h5> 
      <p>I cookie di terzi sono impostati da un dominio differente da quello visitato dall’utente. Se un utente visita un sito e una società diversa invia l’informazione sfruttando quel sito, si è in presenza di cookie di terze parti.<br/>
      I cookie di profilazione di terzi previsti dal Sito sono:<br/>
      <ul>
      	<li>Cookie di Google Analytics Le nostre pagine utilizzano i cookie di performance di terze parti di Google Analytics (servizio offerto da Google, Inc.) per consentirci di raccogliere in forma anonima ed esaminare il comportamento dei visitatori durante l’utilizzo del sito e di migliorare la sua fruibilit&agrave; e l’esperienza d’uso. Attraverso l’uso del pannello di Google Analytics, ci &egrave; possibile capire se le visite sono state effettuate da visitatori nuovi o di ritorno verificando la modalit&agrave; di navigazione delle pagine (link di ingresso, di uscita, spostamenti tra le pagine, tempi di permanenza, provenienza geografica, ecc…).<br/>
      Per ulteriori informazioni relative a Google Analytics &egrave; possibile consultare i siti:<br/>
      https://www.google.it/policies/privacy/partners/<br/>
      https://developers.google.com/analytics/devguides/collection/analyticsjs/cookie-usage<br/>
      &egrave; possibile disabilitare l’azione di Google Analytics attraverso gli strumenti forniti da Google.<br/>Per informazioni a riguardo consulare il sito: https://tools.google.com/dlpage/gaoptout</li>
      	<li>Cookie di widget social Alcuni widget messi a disposizione dai social network (ad esempio Facebook ,Twitter, YouTube, Google Maps, ecc.) possono utilizzare propri cookie di terze parti.<br/> La disattivazione non compromette l’utilizzo del sito, se non nelle sezioni in cui possono essere installati widget (ad esempio per integrazione di video o mappe) ed in alcuni casi la possibilit&agrave; di condivisione rapida dei contenuti o la possibilit&agrave; di commentare alcune aree del sito.<br/>
      AddThis – Informativa: http://www.addthis.com/privacy/privacy-policy<br/>
      AddThis – Configurazione: http://www.addthis.com/privacy/opt-out</li>
      	<li>Cookie di pubblicit&agrave;<br/> I cookie di pubblicit&agrave; vengono installati per mostrare ai visitatori del sito contenuti correlati alle loro preferenze. Possono essere quindi utilizzati per mostrare contenuti pubblicitari mirati agli interessi della persona. I cookie di questa tipologia funzionano in collaborazione con siti di terze parti e possono tenere traccia della navigazione passata su pagine presenti su domini differenti. I cookie di questo tipo tengono traccia solitamente dell’indirizzo IP dell’utente oltre ad altre informazioni, alcune delle quali possono essere personali.<br/>
      Google AdSense – Informativa: https://support.google.com/adsense/answer/48182<br/>
      Google AdSense – Configurazione: https://www.google.com/settings/ads/plugin<br/>
      Per maggiori informazioni sui cookie e per gestire le preferenze sui cookie di profilazione di terzi si invitano gli utenti a visitare anche la piattaforma www.youronlinechoices.com.</li>
      </ul>
      </p>
    </div>
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

    const brandLogo = document.getElementById('brandLogo');
    const brandText = document.getElementById('brandText');
    const backBtn = document.getElementById('backBtn');

    function normalizeAzienda(data) {
      if (!data) return null;
      if (Array.isArray(data)) return data[0] || null;
      if (data.id || data.name || data.url || data.banner) return data;
      const vals = Object.values(data);
      return vals && vals.length ? vals[0] : null;
    }

    function setAccent(color) {
      if (!color) return;
      document.documentElement.style.setProperty('--accent', color);
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

    if (document.referrer) {
      backBtn.href = document.referrer;
      backBtn.addEventListener('click', (e) => {
        e.preventDefault();
        window.location.href = document.referrer;
      });
    } else {
      backBtn.href = baseUrl('');
      backBtn.addEventListener('click', (e) => {
        e.preventDefault();
        window.location.href = baseUrl('');
      });
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
        if (!item) return;
        setBrandName(item.name || item.url || '');
        setAccent(item.color_point || '');
      } catch (e) {
        if (brandLogo) brandLogo.classList.remove('loading');
      } finally {
        if (brandLogo) brandLogo.classList.remove('loading');
      }
    }
    loadAzienda();
  </script>
</body>
</html>
