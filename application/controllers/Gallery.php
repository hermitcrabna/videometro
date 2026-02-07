<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gallery extends CI_Controller {
  private $galleryDebug = [];
  public function index($slug = null) {
    $this->load->library('vmapi');

    $slug = $slug !== null ? (string)$slug : (string)$this->input->get('slug', true);
    if ($slug === '') {
      show_404();
      return;
    }

    $aziendaId = (int)$this->config->item('azienda_id');
    $aziendaName = 'videometro.tv';
    $aziendaColor = '#e52023';

    if ($aziendaId) {
      $urlA = $this->vmapi->api_base() . '/get_azienda?azienda_id=' . urlencode((string)$aziendaId);
      $aziendaData = $this->vmapi->fetch_json($urlA);
      if (is_array($aziendaData)) {
        $azienda = $aziendaData[0] ?? $aziendaData['0'] ?? null;
        if (is_array($azienda)) {
          if (!empty($azienda['name'])) $aziendaName = $azienda['name'];
          if (!empty($azienda['color_point'])) $aziendaColor = $azienda['color_point'];
        }
      }
    }

    $video = null;
    if (ctype_digit((string)$slug)) {
      $video = $this->fetchVideoById((string)$slug);
    }
    if (!is_array($video) || empty($video)) {
      $video = $this->vmapi->fetch_json($this->vmapi->api_base() . '/get_video_by_slug/' . rawurlencode($slug));
      if (is_array($video) && isset($video['data']) && is_array($video['data'])) $video = $video['data'];
      if (is_array($video) && isset($video[0]) && is_array($video[0])) $video = $video[0];
    }
    if (!is_array($video) || empty($video)) {
      show_404();
      return;
    }
    if (ctype_digit((string)$slug)) {
      $vid = (string)($video['post_id'] ?? $video['id'] ?? $video['video_id'] ?? '');
      if ($vid !== '' && $vid !== (string)$slug) {
        // Avoid showing wrong title/summary when API returns a different post.
        $video = [
          'post_id' => (string)$slug,
          'gallery' => 1,
          'blog' => 0,
          'title' => 'Gallery',
          'summary' => '',
        ];
      }
    }

    $isBlog = (int)($video['blog'] ?? 0) === 1;
    $isGallery = (int)($video['gallery'] ?? 0) === 1;
    if (ctype_digit((string)$slug)) {
      // For numeric slugs, trust the slug as the post_id to fetch gallery images.
      $video['post_id'] = (string)$slug;
      if (empty($video['id'])) $video['id'] = (string)$slug;
    }

    // Regola tipo contenuto:
    // - gallery=1 => sempre Gallery (anche se blog=1)
    // - blog=1 e gallery=0 => Blog
    // - altrimenti => Video
    if ($isBlog && !$isGallery) {
      redirect('blog/' . $slug, 'location', 302);
      return;
    }

    $categoriesRaw = $this->vmapi->fetch_json($this->vmapi->api_base() . '/get_category?' . http_build_query([
      'azienda_id' => $aziendaId,
    ]));
    $categories = is_array($categoriesRaw) ? $categoriesRaw : (is_array($categoriesRaw['data'] ?? null) ? $categoriesRaw['data'] : []);

    $siteUrl = vm_site_url();
    $basePath = vm_base_path();
    $canonical = $siteUrl . $basePath . '/gallery/' . $slug;
    $title = $video['seo-title'] ?? $video['title'] ?? 'VideoMetro – Gallery';
    $desc = strip_tags($video['seo-description'] ?? $video['summary'] ?? 'Gallery di VideoMetro.');
    $ogImage = $video['image'] ?? $video['thumbnail'] ?? $video['thumb'] ?? '';

    $galleryImages = $this->fetchGalleryImages($video, $slug);
    $data = [
      'slug' => $slug,
      'aziendaId' => $aziendaId,
      'aziendaName' => $aziendaName,
      'aziendaColor' => $aziendaColor,
      'post' => $video,
      'galleryImages' => $galleryImages,
      'galleryDebug' => null,
      'categories' => $categories,
      'pageTitle' => $title,
      'pageDescription' => $desc,
      'canonical' => $canonical,
      'ogImage' => $ogImage,
      'basePath' => $basePath,
      'baseHref' => vm_base_href(),
      'siteUrl' => $siteUrl,
    ];

    $this->load->view('gallery', $data);
  }

  private function fetchGalleryImages(array $video, string $slug): array {
    $images = [];

    $push = function($url) use (&$images) {
      $url = trim((string)$url);
      if ($url === '') return;
      // Skip base folder without filename
      if (preg_match('#/media/video/?$#i', $url)) return;
      if (stripos($url, 'undefined') !== false) return;
      if (!in_array($url, $images, true)) $images[] = $url;
    };

    $postId = null;
    if (ctype_digit($slug)) $postId = $slug;
    if ($postId === null || $postId === '') {
      $postId = $video['post_id'] ?? $video['id'] ?? $video['video_id'] ?? null;
    }
    $this->galleryDebug = [
      'postId' => $postId,
      'urls' => [],
      'count' => 0,
    ];
    if ($postId !== null && $postId !== '') {
      $siteUrl = rtrim((string)$this->config->item('site_url'), '/');
      $base = $siteUrl !== '' ? $siteUrl . '/api' : $this->vmapi->api_base();
      $url = $base . '/get_image_by_post_id?' . http_build_query([
        'post_id' => $postId,
      ]);
      $this->galleryDebug['urls'][] = $url;
      $res = $this->vmapi->fetch_raw($url);
      $this->galleryDebug['http'][] = ['url' => $url, 'status' => $res['http'], 'error' => $res['error'] ?: null];
      if ($res['raw'] && $res['http'] >= 200 && $res['http'] < 300) {
        $json = json_decode($res['raw'], true);
        if (is_array($json)) {
          foreach ($json as $item) {
            if (is_array($item) && !empty($item['image'])) $push($item['image']);
          }
        }
      }
      if (empty($images)) {
        $fallbackBase = $this->vmapi->api_base();
        $url = rtrim($fallbackBase, '/') . '/get_image_by_post_id?' . http_build_query([
          'post_id' => $postId,
        ]);
        $this->galleryDebug['urls'][] = $url;
        $res = $this->vmapi->fetch_raw($url);
        $this->galleryDebug['http'][] = ['url' => $url, 'status' => $res['http'], 'error' => $res['error'] ?: null];
        if ($res['raw'] && $res['http'] >= 200 && $res['http'] < 300) {
          $json = json_decode($res['raw'], true);
          if (is_array($json)) {
            foreach ($json as $item) {
              if (is_array($item) && !empty($item['image'])) $push($item['image']);
            }
          }
        }
      }
    }
    $this->galleryDebug['count'] = count($images);

    if (!empty($images)) return $images;

    $fallback = $video['image'] ?? $video['thumbnail'] ?? $video['thumb'] ?? $video['poster'] ?? '';
    if ($fallback) $push($fallback);
    return $images;
  }

  private function fetchVideoById(string $id): ?array {
    $base = $this->vmapi->api_base();
    $aziendaId = (int)$this->config->item('azienda_id');
    $query = [
      'post_id' => $id,
      'limit' => 1,
      'offset' => 0,
    ];
    if ($aziendaId) $query['azienda_id'] = $aziendaId;
    $url = $base . '/get_video?' . http_build_query($query);
    $res = $this->vmapi->fetch_json($url);
    if (is_array($res) && !empty($res)) return $res[0];
    $query = [
      'id' => $id,
      'limit' => 1,
      'offset' => 0,
    ];
    if ($aziendaId) $query['azienda_id'] = $aziendaId;
    $url = $base . '/get_video?' . http_build_query($query);
    $res = $this->vmapi->fetch_json($url);
    if (is_array($res) && !empty($res)) return $res[0];
    return null;
  }
}
