<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends CI_Controller {
  public function index() {
    $this->load->library('vmapi');

    $aziendaId = (int)$this->config->item('azienda_id');
    $latestCount = 8;
    $limit = 50;

    $searchTerm = trim((string)$this->input->get('search_term', true));
    $catId = trim((string)$this->input->get('cat_id', true));
    $subcatId = trim((string)$this->input->get('subcat_id', true));
    $featured = trim((string)$this->input->get('featured', true));

    $blogFilter = '1';
    $galleryFilter = '1';
    $isHomeNoFilters = ($searchTerm === '' && $catId === '' && $subcatId === '' && $featured === '');

    $latestItems = [];
    $featuredItems = [];
    if ($isHomeNoFilters) {
      $latestItems = $this->vmapi->fetch_json($this->vmapi->api_base() . '/get_video?' . http_build_query([
        'azienda_id' => $aziendaId,
        'limit' => $latestCount,
        'offset' => 0,
        'featured' => 0,
        'blog' => $blogFilter,
        'gallery' => $galleryFilter,
      ])) ?? [];
      $featuredItems = $this->vmapi->fetch_json($this->vmapi->api_base() . '/get_video?' . http_build_query([
        'azienda_id' => $aziendaId,
        'limit' => 10,
        'offset' => 0,
        'featured' => 1,
        'blog' => $blogFilter,
        'gallery' => $galleryFilter,
      ])) ?? [];
    }

    $offset = $isHomeNoFilters ? $latestCount : 0;
    $query = [
      'azienda_id' => $aziendaId,
      'limit' => $limit,
      'offset' => $offset,
      'blog' => $blogFilter,
      'gallery' => $galleryFilter,
    ];
    if ($searchTerm !== '') $query['search_term'] = $searchTerm;
    if ($catId !== '') $query['cat_id'] = $catId;
    if ($subcatId !== '') $query['subcat_id'] = $subcatId;
    if ($featured !== '') $query['featured'] = $featured;

    $mainItems = $this->vmapi->fetch_json($this->vmapi->api_base() . '/get_video?' . http_build_query($query)) ?? [];

    $categoriesRaw = $this->vmapi->fetch_json($this->vmapi->api_base() . '/get_category?' . http_build_query([
      'azienda_id' => $aziendaId,
    ]));
    $categories = is_array($categoriesRaw) ? $categoriesRaw : (is_array($categoriesRaw['data'] ?? null) ? $categoriesRaw['data'] : []);

    $siteUrl = vm_site_url();
    $basePath = vm_base_path();
    $canonical = $siteUrl . $basePath . '/blog';
    $title = 'VideoMetro – Blog & Gallery';
    $description = 'Blog e gallery di VideoMetro.';
    $robots = ($searchTerm !== '' || $featured !== '') ? 'noindex, follow' : 'index, follow';

    $data = [
      'aziendaId' => $aziendaId,
      'basePath' => vm_base_path(),
      'baseHref' => vm_base_href(),
      'siteUrl' => vm_site_url(),
      'latestItems' => $latestItems,
      'featuredItems' => $featuredItems,
      'mainItems' => $mainItems,
      'offset' => $offset + count($mainItems),
      'limit' => $limit,
      'isHomeNoFilters' => $isHomeNoFilters,
      'categories' => $categories,
      'pageTitle' => $title,
      'pageDescription' => $description,
      'canonical' => $canonical,
      'robots' => $robots,
    ];

    $this->load->view('blog', $data);
  }
}
