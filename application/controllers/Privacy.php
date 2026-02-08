<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Privacy extends CI_Controller {
  public function index() {
    $this->load->library('vmapi');

    $aziendaId = (int)$this->config->item('azienda_id');
    $siteUrl = vm_site_url();
    $basePath = vm_base_path();

    $aziendaRaw = $this->vmapi->fetch_json($this->vmapi->api_base() . '/get_azienda?' . http_build_query([
      'azienda_id' => $aziendaId,
    ]));
    if (is_array($aziendaRaw) && array_key_exists('', $aziendaRaw) && is_array($aziendaRaw[''])) {
      $azienda = $aziendaRaw[''];
    } elseif (is_array($aziendaRaw) && isset($aziendaRaw['data']) && is_array($aziendaRaw['data'])) {
      $azienda = $aziendaRaw['data'];
    } elseif (is_array($aziendaRaw)) {
      $azienda = $aziendaRaw;
    } else {
      $azienda = [];
    }
    $aziendaName = trim((string)($azienda['denominazione'] ?? $azienda['name'] ?? 'VideoMetro'));

    $data = [
      'aziendaId' => $aziendaId,
      'basePath' => $basePath,
      'baseHref' => vm_base_href(),
      'siteUrl' => $siteUrl,
      'pageTitle' => $aziendaName . ' - Privacy Policy',
      'pageDescription' => 'Informativa privacy di ' . $aziendaName . '.',
      'canonical' => $siteUrl . $basePath . '/privacy',
    ];

    $this->load->view('privacy', $data);
  }
}
