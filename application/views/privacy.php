<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!doctype html>
<html lang="it">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="<?= htmlspecialchars($pageDescription ?? 'Privacy Policy') ?>" />
  <link rel="canonical" href="<?= htmlspecialchars($canonical ?? ($siteUrl . $baseHref)) ?>" />
  <meta property="og:type" content="article">
  <meta property="og:title" content="<?= htmlspecialchars($pageTitle ?? 'Privacy Policy') ?>">
  <meta property="og:description" content="<?= htmlspecialchars($pageDescription ?? 'Privacy Policy') ?>">
  <meta property="og:url" content="<?= htmlspecialchars($canonical ?? ($siteUrl . $baseHref)) ?>">
  <title><?= htmlspecialchars($pageTitle ?? 'Privacy Policy') ?></title>
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
    <div class="content" id="privacyContent">
      <h1>INFORMATIVA ESTESA SUI DATI PERSONALI</h1>
      <h2>AI SENSI DELL’ART.13 DEL REGOLAMENTO (UE) 2016/679 DEL PARLAMENTO EUROPEO “GDPR”</h2>
      <p> Gentile Signore/a, ai sensi dell’art. 13 del Regolamento UE 2016/679 ed in relazione alle informazioni di cui si entrerà in possesso, ai fini della tutela delle persone e altri soggetti in materia di trattamento di dati personali, si informa quanto segue:</p>
      <h5 style="text-transform:uppercase; font-weight:bold">1.0 Titolare, Responsabili del trattamento</h5>
      <p>Il titolare del trattamento è Consorzio Medianetwork con Sede Via Toledo 156 Napoli (Na). I diritti potranno essere da Lei esercitati anche mediante l’invio di comunicazioni al seguente indirizzo email privacy@videometro.tv  o pec thecreativeimage@pec.it
      <br/></p>
      <h5 style="text-transform:uppercase; font-weight:bold">2.0 Finalità e base legale del trattamento</h5>
      <p>I dati personali da lei forniti potranno essere trattati unicamente per le seguenti finalità:<br/>
        <ul>
          <li>gestione anagrafica</li>
          <li>esecuzione della prestazione da Voi richiesta</li>
          <li>invio di comunicazione di servizi</li>
          <li>adempiere ad obblighi di legge ed ottemperare alle richieste provenienti dall’autorità superiori</li>
          <li>•	attività di marketing e/o comunicazioni commerciali, compresa la comunicazione interattiva, indagini di mercato e studi statistici effettuati tramite e-mail, SMS e MMS, inviti ad attività di carattere ricreativo o culturale e/o ad eventi organizzati dalla Società per le quali è possibile dare il Tuo consenso</li>
        </ul>
      </p>
      <h5 style="text-transform:uppercase; font-weight:bold">3.0 Modalità di trattamento</h5>
      <p>Il trattamento dei Suoi dati personali è realizzato per mezzo delle operazioni indicate all’art. 4 Codice Privacy e all’art. 4 n. 2) GDPR e precisamente: raccolta, registrazione, organizzazione, conservazione, consultazione, elaborazione, modificazione, selezione, estrazione, raffronto, utilizzo, interconnessione, blocco, comunicazione, cancellazione e distruzione dei dati, tutte le operazioni sono eseguite mediante procedure informatizzate. il trattamento è necessario all'esecuzione di un contratto di cui l’interessato è parte o all’esecuzione di misure precontrattuali adottate su richiesta dello stesso. La invitiamo inoltre ad omettere dati sensibili e non pertinenti in relazione alle specifiche finalità per cui ci sono conferiti. I dati forniti potranno essere utilizzati dal Titolare Del Trattamento nell’ambito di società del gruppo e con le stesse condivisi in forza di accordi appositamente stipulati e di ciò se ne da espressamente atto. Il trattamento è necessario per il corretto espletamento dell’attività richiesta. Non sono previsti ulteriori trattamenti basati sui legittimi interessi perseguiti dal titolare del trattamento.
      </p>
      <h5 style="text-transform:uppercase; font-weight:bold">4.0 Tipi di dati trattati</h5>
      <p>
        Dati comuni, quali, a titolo esemplificativo:<br/>
        <ul>
          <li>dati contenuti nei form di iscrizione (nome, cognome, numero di telefono fisso e/o mobile, email e test messaggi);</li>
        </ul>
      </p>
      <h5 style="text-transform:uppercase; font-weight:bold">5.0 Comunicazione e diffusione dei dati</h5>
      <p>
        I dati personali saranno trattati dagli addetti interni alle nostra sede, autorizzati/incaricati al trattamento ed opportunamente istruiti in materia di sicurezza dei dati personali e del diritto alla Privacy, i dati personali potranno essere comunicati e trasferiti tutti o in parte a società del gruppo
      Detti soggetti tratteranno i dati nella loro qualità di autonomi titolari del trattamento. i Suoi dati non saranno diffusi e saranno utilizzati nei limiti di quanto indicato nella presente informativa.
      </p>

      <h5 style="text-transform:uppercase; font-weight:bold">6.0 Conservazione dei dati</h5>
      <p>I suoi dati verranno conservati per 10 anni. Saranno conservati oltre tale periodo esclusivamente fino a quando saranno indispensabili per le finalità del trattamento indicate e per la tutela nel suo interesse salvo sua esplicita richiesta di cancellazione. Potranno essere anonimizzati e conservati a discrezione della Società a tempo indeterminato. Accesso ai dati I Suoi dati potranno essere resi accessibili per le finalità di cui all’art. 2.A) e 2.B) ai Responsabili e agli Incaricati al trattamento;
      </p>
      <h5 style="text-transform:uppercase; font-weight:bold">7.0 Trasferimento all’Estero</h5>
      <p>
        Non è previsto il trasferimento dei suoi dati personali.
      </p>
      <h5 style="text-transform:uppercase; font-weight:bold">8.0 Diritti dell’interessato</h5>
      <p>
        In ogni momento, Lei potrà esercitare, ai sensi degli articoli dal 15 al 22 del Regolamento UE n. 2016/679, il diritto di:<br/>
        <ul>
          <li>chiedere la conferma dell’esistenza o meno di propri dati personali;</li>
          <li>ottenere le indicazioni circa le finalità del trattamento, le categorie dei dati personali, i destinatari o le categorie di destinatari a cui i dati personali sono stati o saranno comunicati e, quando possibile, il periodo di conservazione;</li>
          <li>ottenere la rettifica e la cancellazione dei dati (diritto all’oblio);</li>
          <li>ottenere la limitazione del trattamento; </li>
          <li>ottenere la portabilità dei dati, ossia riceverli da un titolare del trattamento, in un formato strutturato, di uso comune e leggibile da dispositivo automatico, e trasmetterli ad un altro titolare del trattamento senza impedimenti;</li>
          <li>opporsi al trattamento in qualsiasi momento ed anche nel caso di trattamento per finalità di marketing diretto;</li>
          <li>opporsi ad un processo decisionale automatizzato relativo alle persone fisiche, compresa la profilazione</li>
          <li>chiedere l’accesso ai dati personali e la rettifica o la cancellazione degli stessi o la limitazione del trattamento che la riguardano o di opporsi al loro trattamento, oltre al diritto alla portabilità dei dati;</li>
          <li>revocare il consenso in qualsiasi momento senza pregiudicare la liceità del trattamento basata sul consenso prestato prima della revoca;</li>
          <li>proporre reclamo a un’autorità di controllo.</li>
        </ul>
      </p>
      <h5 style="text-transform:uppercase; font-weight:bold">9.0 Diritto di rettifica</h5>
      <p>
        L'interessato ha il diritto di ottenere dal titolare del trattamento la rettifica dei dati personali inesatti che lo riguardano senza ingiustificato ritardo. Tenuto conto delle finalità del trattamento, l'interessato ha il diritto di ottenere l'integrazione dei dati personali incompleti, anche fornendo una dichiarazione
      </p>
      <h5 style="text-transform:uppercase; font-weight:bold">10 Modalità di esercizio del diritto all’oblio</h5>
      <p>
        L’interessato ha il diritto di ottenere la cancellazione dei dati personali che La riguardano senza ingiustificato ritardo e il titolare del trattamento ha l’obbligo di cancellare senza ingiustificato ritardo i dati personali, se sussiste uno dei seguenti motivi:<br/>
        <ul>
          <li>i dati non sono più necessari rispetto alle finalità per le quali furono raccolti o trattati</li>
          <li>l’interessato ha revocato il consenso e non sussiste altro fondamento giuridico per il trattamento;</li>
          <li>l’interessato si oppone al trattamento dei dati e non sussiste alcun motivo legittimo prevalente per proseguire tale trattamento oppure si oppone al trattamento ai sensi dell'articolo 21, paragrafo 2;</li>
          <li>i dati sono stati trattati illecitamente: in presenza di una qualsiasi violazione della normativa in tema di protezione di dati personali, il titolare non può continuare ad utilizzare tali informazioni e ciascun interessato può chiederne quindi la cancellazione.</li>
          <li>i dati personali devono essere cancellati per adempiere un obbligo legale previsto dal diritto dell'Unione o dello Stato membro cui è soggetto il titolare del trattamento;</li>
          <li>i dati personali sono stati raccolti relativamente all'offerta di servizi della società dell'informazione di cui all'articolo 8, paragrafo 1</li>
        </ul>
      </p>
      <h5 style="text-transform:uppercase; font-weight:bold">11 Diritto di limitazione di trattamento</h5>
      <p>
      L'interessato ha il diritto di ottenere dal titolare del trattamento la limitazione del trattamento quando ricorre una delle seguenti ipotesi:<br/>
      <ul>
        <li>l'interessato contesta l'esattezza dei dati personali, per il periodo necessario al titolare del trattamento per verificare l'esattezza di tali dati personali;</li>
        <li>il trattamento è illecito e l'interessato si oppone alla cancellazione dei dati personali e chiede invece che ne sia limitato l'utilizzo;</li>
        <li>benché il titolare del trattamento non ne abbia più bisogno ai fini del trattamento, i dati personali sono necessari all'interessato per l'accertamento, l'esercizio o la difesa di un diritto in sede giudiziaria;</li>
        <li>l'interessato si è opposto al trattamento ai sensi dell'articolo 21, paragrafo 1, in attesa della verifica in merito all'eventuale prevalenza dei motivi legittimi del titolare del trattamento rispetto a quelli dell'interessato.</li>
      </ul>
      Se il trattamento è limitato a norma del paragrafo 1, tali dati personali sono trattati, salvo che per la conservazione, soltanto con il consenso dell'interessato o per l'accertamento, l'esercizio o la difesa di un diritto in sede giudiziaria oppure per tutelare i diritti di un'altra persona fisica o giuridica o per motivi di interesse pubblico rilevante dell'Unione o di uno Stato membro.
      </p>
      <h5 style="text-transform:uppercase; font-weight:bold">12 Diritto alla portabilità dei dati</h5>
      <p>
        L'interessato ha il diritto di ricevere in un formato strutturato, di uso comune e leggibile da dispositivo automatico i dati personali che lo riguardano forniti a un titolare del trattamento e ha il diritto di trasmetterli ad un altro titolare del trattamento senza impedimenti da parte del titolare del trattamento cui li ha forniti qualora:<br/>
        <ul>
          <li>il trattamento si basi sul consenso ai sensi dell'articolo 6, paragrafo 1, lettera a), o dell'articolo 9,
      paragrafo 2, lettera a), o su un contratto ai sensi dell'articolo 6, paragrafo 1, lettera b); e
      il trattamento sia effettuato con mezzi automatizzati.
      </li>
          <li>Nell'esercitare i propri diritti relativamente alla portabilità dei dati a norma del paragrafo 1, l'interessato ha il diritto di ottenere la trasmissione diretta dei dati personali da un titolare del trattamento all'altro, se tecnicamente fattibile.</li>
          <li>L'esercizio del diritto di cui al paragrafo 1 del presente articolo lascia impregiudicato l'articolo 17. Tale diritto non si applica al trattamento necessario per l'esecuzione di un compito di interesse pubblico o connesso all'esercizio di pubblici poteri di cui è
      investito il titolare del trattamento.
      </li>
          <li>Il diritto di cui al paragrafo 1 non deve ledere i diritti e le libertà altrui.</li>
        </ul>
      </p>
      <h5 style="text-transform:uppercase; font-weight:bold">13 Diritto di opposizione</h5>
      <p>
        <ul>
          <li>L'interessato ha il diritto di opporsi in qualsiasi momento, per motivi connessi alla sua situazione particolare, al trattamento dei dati personali che lo riguardano ai sensi dell'articolo 6, paragrafo 1, lettere e) o f), compresa la profilazione sulla base di tali disposizioni. Il titolare del trattamento si astiene dal trattare ulteriormente i dati personali salvo che egli dimostri l'esistenza di motivi legittimi cogenti per procedere al trattamento che prevalgono sugli interessi, sui diritti e sulle libertà dell'interessato oppure per l'accertamento, l'esercizio o la difesa di un diritto in sede giudiziaria.</li>
          <li>Qualora i dati personali siano trattati per finalità di marketing diretto, l'interessato ha il diritto di opporsi in qualsiasi momento al trattamento dei dati personali che lo riguardano effettuato per tali finalità, compresa la profilazione nella misura in cui sia connessa a tale marketing diretto.</li>
          <li>Qualora l'interessato si opponga al trattamento per finalità di marketing diretto, i dati personali non sono più oggetto di trattamento per tali finalità.</li>
          <li>Il diritto di cui ai paragrafi 1 e 2 è esplicitamente portato all'attenzione dell'interessato ed è presentato chiaramente e separatamente da qualsiasi altra informazione al più tardi al momento della prima comunicazione con l'interessato.</li>
        </ul>
      </p>
      <h5 style="text-transform:uppercase; font-weight:bold">14 Diritto di revocare il consenso</h5>
        <p>Qualora il trattamento sia basato sul consenso dell'interessato egli ha diritto revocare il consenso in qualsiasi momento senza pregiudicare la liceità del trattamento basata sul consenso prestato prima della revoca.</p>
      <h5 style="text-transform:uppercase; font-weight:bold">15 Diritto di proporre reclamo alla autorità di controllo</h5>
      <p>
        <ul>
          <li>Fatto salvo ogni altro ricorso amministrativo o giurisdizionale, l'interessato che ritenga che il trattamento che lo riguarda violi il presente regolamento ha il diritto di proporre reclamo a un'autorità di controllo, segnatamente nello Stato membro in cui risiede
      abitualmente, lavora oppure del luogo ove si è verificata la presunta violazione.
      </li>
          <li>L'autorità di controllo a cui è stato proposto il reclamo informa il reclamante dello stato o dell'esito del reclamo, compresa la possibilità di un ricorso giurisdizionale ai sensi dell'articolo 78.</li>
        </ul>
      </p>
      <h5 style="text-transform:uppercase; font-weight:bold">16 Modalità di utilizzo del servizio</h5>
      <p>
        Inserendo i dati, l'utente garantisce di fornire informazioni esatte e complete e si impegna ad aggiornare queste informazioni quando necessario mediante la sua area personale. Qualora Consorzio Medianetwork dovesse verificare che i dati inseriti dall'utente sono inesatti, incompleti o non aggiornati, si riserva il diritto insindacabile di disabilitare l'uso del servizio all'utente. L'utente è responsabile della riservatezza della propria password d'accesso e di tutte le attività a questa collegata. L'utente è tenuto ad informare immediatamente Consorzio Medianetwork se viene a conoscenza dell'uso non autorizzato della propria password d'accesso. L'utente si impegna ad aderire a tutte le leggi locali ed internazionali. L'utente si impegna a non usare il servizio per comunicazioni illegali, inopportune, diffamatrici, abusive, minacciose, volgari o oscene. L'utente si impegna inoltre a non utilizzare materiale che in alcun modo invada, infranga o violi diritti personali o di proprietà intellettuale di altri assumendosene personalmente la responsabilità qualora questo avvenisse. A tale scopo, in ottemperanza con il codice privacy e cookie policy, Consorzio Medianetwork al momento della registrazione rileva l'IP address del computer da cui è partita la comunicazione, e sarà quindi possibile individuare l'autore di un qualsivoglia comportamento fraudolento riservandosi in tali casi di informare le autorità preposte. Consorzio Medianetwork non è responsabile per i contenuti, le informazioni ed i dati forniti sul sito che sono da ritenersi puramente indicativi e di link ad altri siti Web eventualmente presenti sul sito videometro.tv
      </p>
      <h5 style="text-transform:uppercase; font-weight:bold">17 Aggiornamento delle informazioni</h5>
      <p>
        Consorzio Medianetwork si riserva la possibilità di aggiornare i termini di utilizzo del sito. Per ulteriori informazioni non esitare a mandare una e-mail a: privacy@videometro.tv
      </p>
      <h5 style="text-transform:uppercase; font-weight:bold">18 Norme di utilizzo della newsletter</h5>
      <p>L'utente che aderisce al servizio informativo "Newsletter" via posta elettronica di Consorzio Medianetwork accetta di ricevere, secondo modalità e tempistiche stabilite dalla società scrivente, un'e-mail dal contenuto informativo a proposito delle ultime offerte di lavoro e offerte formative presenti sul sito o comunque informazioni valutate come aderenti alla mission di Consorzio Medianetwork</p>
      <h5 style="text-transform:uppercase; font-weight:bold">19 Riservatezza parametri di accesso</h5>
      <p>
        la User Id e la Password sono strettamente personali, non possono quindi essere cedute a terzi, e il possessore si assume la responsabilità della custodia accurata di questi parametri. Consorzio Medianetwork invierà all'indirizzo mail indicato in fase di registrazione la User Id e la Password indicate, il fruitore è quindi tenuto ad inserire un indirizzo mail al quale possa accedere in via esclusiva. Per una maggiore sicurezza nella custodia dei dati riservati, nella scelta della User Id e della Password Consorzio Medianetwork consiglia fortemente di non scegliere dei parametri che possano essere riconducibili al candidato che sta effettuando la registrazione.

      </p>
      <h5 style="text-transform:uppercase; font-weight:bold">19 Modalità di esercizio dei diritti</h5>
      <p>
        Potrà in qualsiasi momento esercitare i diritti inviando: una raccomandata a.r. a Consorzio Medianetwork con Sede Via Toledo 156 Napoli (Na) o una pec all’indirizzo: thecreativeimage@pec.it
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
