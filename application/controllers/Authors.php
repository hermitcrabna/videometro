<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Authors extends CI_Controller {
  public function index() {
    $this->load->library('vmapi');

    $aziendaId = (int)$this->config->item('azienda_id');
    $limit = 50;

    $searchTerm = trim((string)$this->input->get('search_term', true));
    $query = [
      'azienda_id' => $aziendaId,
      'limit' => $limit,
      'offset' => 0,
    ];
    if ($searchTerm !== '') $query['search_term'] = $searchTerm;

    $authorsItems = $this->vmapi->fetch_json($this->vmapi->api_base() . '/get_authors?' . http_build_query($query)) ?? [];

    $categoriesRaw = $this->vmapi->fetch_json($this->vmapi->api_base() . '/get_category?' . http_build_query([
      'azienda_id' => $aziendaId,
    ]));
    $categories = is_array($categoriesRaw) ? $categoriesRaw : (is_array($categoriesRaw['data'] ?? null) ? $categoriesRaw['data'] : []);

    $siteUrl = vm_site_url();
    $basePath = vm_base_path();
    $canonical = $siteUrl . $basePath . '/protagonisti';
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

    $title = $aziendaName . ' - i nostri protagonisti';
    $description = 'I protagonisti di ' . $aziendaName . '.';
    $robots = ($searchTerm !== '') ? 'noindex, follow' : 'index, follow';

    $data = [
      'aziendaId' => $aziendaId,
      'basePath' => vm_base_path(),
      'baseHref' => vm_base_href(),
      'siteUrl' => vm_site_url(),
      'authorsItems' => $authorsItems,
      'limit' => $limit,
      'categories' => $categories,
      'pageTitle' => $title,
      'pageDescription' => $description,
      'canonical' => $canonical,
      'robots' => $robots,
    ];

    $this->load->view('authors', $data);
  }
}
