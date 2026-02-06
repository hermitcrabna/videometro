<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
  public function index() {
    $this->load->library('vmapi');

    $aziendaId = (int)$this->config->item('azienda_id');
    $latestCount = 8;
    $limit = 12;
    $initialMainCount = 16;

    $searchTerm = trim((string)$this->input->get('search_term', true));
    $catId = trim((string)$this->input->get('cat_id', true));
    $subcatId = trim((string)$this->input->get('subcat_id', true));
    $featured = trim((string)$this->input->get('featured', true));

    $isHomeNoFilters = ($searchTerm === '' && $catId === '' && $subcatId === '' && $featured === '');

    $latestItems = [];
    $featuredItems = [];
    if ($isHomeNoFilters) {
      $latestItems = $this->vmapi->fetch_json($this->vmapi->api_base() . '/get_video?' . http_build_query([
        'azienda_id' => $aziendaId,
        'limit' => $latestCount,
        'offset' => 0,
        'featured' => 0,
      ])) ?? [];
      $featuredItems = $this->vmapi->fetch_json($this->vmapi->api_base() . '/get_video?' . http_build_query([
        'azienda_id' => $aziendaId,
        'limit' => 10,
        'offset' => 0,
        'featured' => 1,
      ])) ?? [];
    }

    $offset = 0;
    $mainLimit = $isHomeNoFilters ? $initialMainCount : $limit;
    $query = [
      'azienda_id' => $aziendaId,
      'limit' => $mainLimit,
      'offset' => $offset,
    ];
    if ($searchTerm !== '') $query['search_term'] = $searchTerm;
    if ($catId !== '') $query['cat_id'] = $catId;
    if ($subcatId !== '') $query['subcat_id'] = $subcatId;
    if ($featured !== '') $query['featured'] = $featured;
    else $query['featured'] = '0';

    $mainItems = $this->vmapi->fetch_json($this->vmapi->api_base() . '/get_video?' . http_build_query($query)) ?? [];

    $categoriesRaw = $this->vmapi->fetch_json($this->vmapi->api_base() . '/get_category?' . http_build_query([
      'azienda_id' => $aziendaId,
    ]));
    $categories = is_array($categoriesRaw) ? $categoriesRaw : (is_array($categoriesRaw['data'] ?? null) ? $categoriesRaw['data'] : []);

    $data = [
      'aziendaId' => $aziendaId,
      'basePath' => vm_base_path(),
      'baseHref' => vm_base_href(),
      'siteUrl' => vm_site_url(),
      'latestItems' => $latestItems,
      'featuredItems' => $featuredItems,
      'mainItems' => $mainItems,
      'offset' => count($mainItems),
      'limit' => $limit,
      'isHomeNoFilters' => $isHomeNoFilters,
      'categories' => $categories,
    ];

    $this->load->view('home', $data);
  }
}
