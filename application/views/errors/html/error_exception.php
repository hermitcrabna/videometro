<?php
$script = $_SERVER['SCRIPT_NAME'] ?? '/';
$dir = rtrim(str_replace('\\', '/', dirname($script)), '/');
$home = $dir === '' ? '/' : $dir . '/';
?><!doctype html>
<html lang="it">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Errore applicazione – VideoMetro</title>
  <style>
    :root { --bg:#0f1115; --text:#fff; --muted:rgba(255,255,255,.72); --accent:#ff2d2d; }
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
      <div class="title">500</div>
      <div class="subtitle">Errore applicazione</div>
      <a class="home" href="<?php echo htmlspecialchars($home, ENT_QUOTES, 'UTF-8'); ?>">Ritorna alla home</a>
    </div>
  </div>
</body>
</html>
