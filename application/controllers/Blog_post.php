<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog_post extends CI_Controller {
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

    $isBlog = (int)($video['blog'] ?? 0) === 1;
    $isGallery = (int)($video['gallery'] ?? 0) === 1;
    // Regola tipo contenuto:
    // - gallery=1 => sempre Gallery (anche se blog=1)
    // - blog=1 e gallery=0 => Blog
    // - altrimenti => Video
    if ($isGallery) {
      redirect('gallery/' . $slug, 'location', 302);
      return;
    }
    if (!$isBlog) {
      redirect('video/' . $slug, 'location', 302);
      return;
    }

    $categoriesRaw = $this->vmapi->fetch_json($this->vmapi->api_base() . '/get_category?' . http_build_query([
      'azienda_id' => $aziendaId,
    ]));
    $categories = is_array($categoriesRaw) ? $categoriesRaw : (is_array($categoriesRaw['data'] ?? null) ? $categoriesRaw['data'] : []);

    $siteUrl = vm_site_url();
    $basePath = vm_base_path();
    $canonical = $siteUrl . $basePath . '/blog/' . $slug;
    $title = $video['seo-title'] ?? $video['title'] ?? 'VideoMetro – Blog';
    $desc = strip_tags($video['seo-description'] ?? $video['summary'] ?? 'Post di VideoMetro.');
    $ogImage = $video['image'] ?? $video['thumbnail'] ?? $video['thumb'] ?? '';

    $data = [
      'slug' => $slug,
      'aziendaId' => $aziendaId,
      'aziendaName' => $aziendaName,
      'aziendaColor' => $aziendaColor,
      'post' => $video,
      'categories' => $categories,
      'pageTitle' => $title,
      'pageDescription' => $desc,
      'canonical' => $canonical,
      'ogImage' => $ogImage,
      'basePath' => $basePath,
      'baseHref' => vm_base_href(),
      'siteUrl' => $siteUrl,
    ];

    $this->load->view('blog_post', $data);
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
