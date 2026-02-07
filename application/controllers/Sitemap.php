<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sitemap extends CI_Controller {
  public function index() {
    $this->load->library('vmapi');

    $this->output->set_content_type('application/xml; charset=utf-8');

    $aziendaId = (int)$this->config->item('azienda_id');
    $siteUrl = rtrim(vm_site_url(), '/');
    $basePath = vm_base_path();
    $videoPrefix = $this->config->item('video_path_prefix') ?: '/video/';
    if ($videoPrefix === '' || $videoPrefix[0] !== '/') $videoPrefix = '/' . $videoPrefix;
    if ($basePath !== '') $videoPrefix = $basePath . $videoPrefix;

    $urls = [];
    $seen = [];
    $pushUrl = function($url) use (&$urls, &$seen) {
      if (!$url) return;
      if (isset($seen[$url])) return;
      $seen[$url] = true;
      $urls[] = $url;
    };
    $pushUrl($siteUrl . ($basePath === '' ? '/' : $basePath . '/'));
    $pushUrl($siteUrl . $basePath . '/protagonisti');
    $pushUrl($siteUrl . $basePath . '/blog');

    // Videos
    $limit = 50;
    for ($i = 0; $i < 2000; $i++) {
      $data = $this->vmapi->fetch_json($this->vmapi->api_base() . '/get_video?' . http_build_query([
        'azienda_id' => $aziendaId,
        'limit' => $limit,
        'offset' => $i * $limit,
        'featured' => 0,
      ])) ?? [];

      if (count($data) === 0) break;
      foreach ($data as $v) {
        $slug = $v['slug'] ?? null;
        if ($slug) $pushUrl($siteUrl . $videoPrefix . $slug);
      }
      if (count($data) < $limit) break;
    }

    // Blog + Gallery (blog=1)
    for ($i = 0; $i < 2000; $i++) {
      $data = $this->vmapi->fetch_json($this->vmapi->api_base() . '/get_video?' . http_build_query([
        'azienda_id' => $aziendaId,
        'limit' => $limit,
        'offset' => $i * $limit,
        'blog' => 1,
      ])) ?? [];
      if (count($data) === 0) break;
      foreach ($data as $v) {
        $isGallery = (int)($v['gallery'] ?? 0) === 1;
        $slug = $v['slug_post'] ?? $v['slug'] ?? $v['seo_slug'] ?? null;
        $id = $v['post_id'] ?? $v['id'] ?? $v['video_id'] ?? null;
        if ($isGallery) {
          $g = $id ? (string)$id : (string)$slug;
          if ($g !== '') $pushUrl($siteUrl . $basePath . '/gallery/' . rawurlencode($g));
        } else {
          $b = $slug ?: $id;
          if ($b) $pushUrl($siteUrl . $basePath . '/blog/' . rawurlencode((string)$b));
        }
      }
      if (count($data) < $limit) break;
    }

    // Gallery only (gallery=1, blog=0)
    for ($i = 0; $i < 2000; $i++) {
      $data = $this->vmapi->fetch_json($this->vmapi->api_base() . '/get_video?' . http_build_query([
        'azienda_id' => $aziendaId,
        'limit' => $limit,
        'offset' => $i * $limit,
        'gallery' => 1,
        'blog' => 0,
      ])) ?? [];
      if (count($data) === 0) break;
      foreach ($data as $v) {
        $slug = $v['slug_post'] ?? $v['slug'] ?? $v['seo_slug'] ?? null;
        $id = $v['post_id'] ?? $v['id'] ?? $v['video_id'] ?? null;
        $g = $id ? (string)$id : (string)$slug;
        if ($g !== '') $pushUrl($siteUrl . $basePath . '/gallery/' . rawurlencode($g));
      }
      if (count($data) < $limit) break;
    }

    // Authors
    for ($i = 0; $i < 2000; $i++) {
      $data = $this->vmapi->fetch_json($this->vmapi->api_base() . '/get_authors?' . http_build_query([
        'azienda_id' => $aziendaId,
        'limit' => $limit,
        'offset' => $i * $limit,
      ])) ?? [];

      if (count($data) === 0) break;
      foreach ($data as $a) {
        $slug = $a['slug'] ?? null;
        if (!$slug && !empty($a['name'])) $slug = vm_slugify((string)$a['name']);
        if ($slug) {
          $pushUrl($siteUrl . $basePath . '/protagonisti/' . $slug);
        }
      }
      if (count($data) < $limit) break;
    }

    // Categories (subcategories)
    $subcats = $this->vmapi->fetch_json($this->vmapi->api_base() . '/get_subcategory?' . http_build_query([
      'azienda_id' => $aziendaId,
    ])) ?? [];
    foreach ($subcats as $s) {
      $name = $s['sub_categoria'] ?? $s['subcategory'] ?? '';
      $slug = $s['slug'] ?? null;
      if (!$slug && $name) $slug = vm_slugify((string)$name);
      if ($slug) {
        $pushUrl($siteUrl . $basePath . '/video/categoria/' . $slug);
      }
    }

    $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
    $xml .= "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
    foreach ($urls as $u) {
      $xml .= "  <url><loc>" . htmlspecialchars($u, ENT_QUOTES, 'UTF-8') . "</loc></url>\n";
    }
    $xml .= "</urlset>\n";

    $this->output->set_output($xml);
  }
}
