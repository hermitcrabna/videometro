<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
  public function index($subcatSlug = null) {
    $this->load->library('vmapi');

    $aziendaId = (int)$this->config->item('azienda_id');
    $latestCount = 8;
    $limit = 12;
    $initialMainCount = 16;

    $searchTerm = trim((string)$this->input->get('search_term', true));
    $catId = trim((string)$this->input->get('cat_id', true));
    $subcatId = trim((string)$this->input->get('subcat_id', true));
    $featured = trim((string)$this->input->get('featured', true));

    $subcatSlug = $subcatSlug !== null ? trim((string)$subcatSlug) : '';
    $subcatName = '';

    // Resolve category slug to ids
    if ($subcatSlug !== '') {
      $subcats = $this->vmapi->fetch_json($this->vmapi->api_base() . '/get_subcategory?' . http_build_query([
        'azienda_id' => $aziendaId,
      ])) ?? [];
      foreach ($subcats as $s) {
        $name = $s['sub_categoria'] ?? $s['subcategory'] ?? '';
        $slug = $s['slug'] ?? vm_slugify((string)$name);
        if ($slug === $subcatSlug) {
          $subcatId = (string)($s['subcat_id'] ?? $s['id'] ?? '');
          $catId = (string)($s['cat_id'] ?? $s['category_id'] ?? '');
          $subcatName = (string)$name;
          break;
        }
      }
    }

    // Resolve ids from query to slug for canonical
    if ($subcatSlug === '' && $subcatId !== '') {
      $subcats = $this->vmapi->fetch_json($this->vmapi->api_base() . '/get_subcategory?' . http_build_query([
        'azienda_id' => $aziendaId,
      ])) ?? [];
      foreach ($subcats as $s) {
        $sid = (string)($s['subcat_id'] ?? $s['id'] ?? '');
        if ($sid !== $subcatId) continue;
        $name = $s['sub_categoria'] ?? $s['subcategory'] ?? '';
        $subcatSlug = $s['slug'] ?? vm_slugify((string)$name);
        $subcatName = (string)$name;
        $catId = (string)($s['cat_id'] ?? $s['category_id'] ?? $catId);
        break;
      }
    }

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

    $siteUrl = vm_site_url();
    $basePath = vm_base_path();
    $canonical = $siteUrl . ($basePath === '' ? '/' : $basePath . '/');

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
    $title = $aziendaName . ' - i nostri contenuti';
    $description = 'Video e contenuti di ' . $aziendaName;

    if ($subcatSlug !== '') {
      $canonical = $siteUrl . $basePath . '/video/categoria/' . $subcatSlug;
      if ($subcatName !== '') {
        $title = $aziendaName . ' - ' . $subcatName;
        $description = 'Video nella categoria ' . $subcatName . '.';
      }
    }

    $robots = 'index, follow';
    if ($searchTerm !== '' || $featured !== '') {
      $robots = 'noindex, follow';
    }

    $data = [
      'aziendaId' => $aziendaId,
      'basePath' => $basePath,
      'baseHref' => vm_base_href(),
      'siteUrl' => $siteUrl,
      'latestItems' => $latestItems,
      'featuredItems' => $featuredItems,
      'mainItems' => $mainItems,
      'offset' => count($mainItems),
      'limit' => $limit,
      'isHomeNoFilters' => $isHomeNoFilters,
      'categories' => $categories,
      'filters' => [
        'search_term' => $searchTerm,
        'cat_id' => $catId,
        'subcat_id' => $subcatId,
        'featured' => $featured,
        'subcat_slug' => $subcatSlug,
      ],
      'pageTitle' => $title,
      'pageDescription' => $description,
      'canonical' => $canonical,
      'robots' => $robots,
    ];

    $this->load->view('home', $data);
  }
}
