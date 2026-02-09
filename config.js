window.APP_CONFIG = Object.assign({
  aziendaId: 10,
  // Base URL pubblico (senza slash finale) e sottocartella base (con slash iniziale, senza finale).
  siteUrl: 'https://videometro.tv',
  basePath: '/videometro',
  // Nota: aggiorna anche config.php per sitemap/robots.
}, window.APP_CONFIG || {});
