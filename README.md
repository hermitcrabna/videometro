# videometro

## Contenuti Blog/Gallery

Regola tipo contenuto:
- `gallery = 1` => sempre Gallery (anche se `blog = 1`)
- `blog = 1` e `gallery = 0` => Blog
- altrimenti => Video

Route:
- Blog: `/blog/:slug`
- Gallery: `/gallery/:slug`
- Fallback: `/video/:slug` (redirige a Blog/Gallery quando applicabile)

Gallery images:
- Endpoint: `/get_image_by_post_id?post_id=POST_ID`
- Risposta: `[{ id, image }, ...]`
