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
    $urls[] = $siteUrl . ($basePath === '' ? '/' : $basePath . '/');
    $urls[] = $siteUrl . $basePath . '/protagonisti';
    $urls[] = $siteUrl . $basePath . '/blog';

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
        if ($slug) $urls[] = $siteUrl . $videoPrefix . $slug;
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
        $id = $a['id'] ?? ($a['author_id'] ?? null);
        if ($id && $slug) {
          $urls[] = $siteUrl . $basePath . '/protagonisti/' . $id . '-' . $slug;
          continue;
        }
        if ($id) {
          $urls[] = $siteUrl . $basePath . '/protagonisti/' . $id;
          continue;
        }
        if ($slug) {
          $urls[] = $siteUrl . $basePath . '/protagonisti/' . $slug;
        }
      }
      if (count($data) < $limit) break;
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
