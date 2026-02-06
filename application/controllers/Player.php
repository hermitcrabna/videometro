<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Player extends CI_Controller {
  public function index($slug = null) {
    $this->load->library('vmapi');

    $slug = $slug !== null ? (string)$slug : (string)$this->input->get('slug', true);
    $from = (string)$this->input->get('from', true);

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
    if ($slug !== '') {
      $url = $this->vmapi->api_base() . '/get_video_by_slug/' . rawurlencode($slug);
      $video = $this->vmapi->fetch_json($url);
    }

    $hasVideo = is_array($video) && !empty($video['videolUrl']);
    if ($slug !== '' && !$hasVideo) {
      show_404();
      return;
    }

    $siteUrl = vm_site_url();
    $basePath = vm_base_path();
    $title = $video['seo-title'] ?? $video['title'] ?? 'VideoMetro – Player';
    $desc = $video['seo-description'] ?? $video['summary'] ?? 'Video di VideoMetro.';
    $desc = strip_tags($desc);
    $canonical = ($video && !empty($video['slug'])) ? $siteUrl . $basePath . '/video/' . $video['slug'] : $siteUrl . $basePath . '/video';
    $ogImage = $video['image'] ?? '';

    $data = [
      'slug' => $slug,
      'from' => $from,
      'aziendaId' => $aziendaId,
      'aziendaName' => $aziendaName,
      'aziendaColor' => $aziendaColor,
      'video' => $video,
      'title' => $title,
      'desc' => $desc,
      'canonical' => $canonical,
      'ogImage' => $ogImage,
      'basePath' => $basePath,
      'baseHref' => vm_base_href(),
      'siteUrl' => $siteUrl,
    ];

    $this->load->view('player', $data);
  }
}
