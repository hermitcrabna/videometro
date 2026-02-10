<?php
$script = $_SERVER['SCRIPT_NAME'] ?? '/';
$dir = rtrim(str_replace('\\', '/', dirname($script)), '/');
$home = $dir === '' ? '/' : $dir . '/';
?><!doctype html>
<html lang="it">
<head>
  <link rel="icon" href="https://www.videometro.tv/icon/icon-videometro-touch.png" type="png"/>
  <link rel="apple-touch-icon" href="https://www.videometro.tv/icon/icon-videometro-touch.png">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pagina non trovata – VideoMetro</title>
  <style>
    :root { --bg:#05061e; --text:#fff; --muted:rgba(255,255,255,.72); --accent:#ff2d2d; }
    body { margin:0; font-family: system-ui, Arial, sans-serif; background:var(--bg); color:var(--text); }
    .wrap { min-height:100vh; display:flex; align-items:center; justify-content:center; text-align:center; padding:24px; }
    .box { max-width:720px; }
    .title { font-size:120px; font-weight:700; letter-spacing:2px; margin:0; line-height:1; }
    .subtitle { margin:14px 0 22px; font-size:20px; color:var(--muted); }
    .home { display:inline-block; padding:12px 18px; border-radius:999px; border:1px solid rgba(255,255,255,.2); color:#fff; text-decoration:none; font-weight:600; }
    .home:hover { background: rgba(255,255,255,.08); }
    @media (max-width: 600px) { .title { font-size:72px; } }
  </style>
</head>
<body>
  <div class="wrap">
    <div class="box">
      <div class="title">404</div>
      <div class="subtitle">Pagina non trovata</div>
      <a class="home" href="<?php echo htmlspecialchars($home, ENT_QUOTES, 'UTF-8'); ?>">Ritorna alla home</a>
    </div>
  </div>
</body>
</html>
