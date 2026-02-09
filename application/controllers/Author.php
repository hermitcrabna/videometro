<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Author extends CI_Controller {
  public function index($id = null) {
    $this->load->library('vmapi');

    $aziendaId = (int)$this->config->item('azienda_id');
    $limit = 50;

    $searchTerm = trim((string)$this->input->get('search_term', true));
    $authorId = $id !== null ? (string)$id : trim((string)$this->input->get('id', true));
    $authorName = (string)$this->input->get('name', true);
    $authorImg = (string)$this->input->get('image', true);
    $authorCount = (string)$this->input->get('num_video', true);
    $authorFb = (string)$this->input->get('facebook', true);
    $authorLi = (string)$this->input->get('linkedin', true);

    $slug = (string)$this->uri->segment(2);
    if ($slug !== '') {
      if (preg_match('/^(\d+)-(.+)$/', $slug, $m)) {
        if ($authorId === '') $authorId = $m[1];
        $slug = $m[2];
      }
    }

    if ($authorId === '' && $slug !== '') {
      $query = [
        'azienda_id' => $aziendaId,
        'limit' => 50,
        'offset' => 0,
        'search_term' => str_replace('-', ' ', $slug),
      ];
      $authors = $this->vmapi->fetch_json($this->vmapi->api_base() . '/get_authors?' . http_build_query($query)) ?? [];
      foreach ($authors as $a) {
        $aSlug = $a['slug'] ?? '';
        if ($aSlug === '') {
          $aSlug = vm_slugify((string)($a['name'] ?? ''));
        }
        if ($aSlug === $slug) {
          $authorId = (string)($a['id'] ?? $a['author_id'] ?? '');
          $authorName = (string)($a['name'] ?? $authorName);
          $authorImg = (string)($a['image'] ?? $authorImg);
          $authorCount = (string)($a['num_video'] ?? $authorCount);
          $authorFb = (string)($a['facebook'] ?? $authorFb);
          $authorLi = (string)($a['linkedin'] ?? $authorLi);
          break;
        }
      }
    }

    if ($slug !== '' && $authorId === '') {
      show_404();
      return;
    }

    $authorSlug = $slug !== '' ? $slug : ($authorName !== '' ? vm_slugify($authorName) : '');

    $authorItems = [];
    if ($authorId !== '') {
      $query = [
        'azienda_id' => $aziendaId,
        'limit' => $limit,
        'offset' => 0,
      ];
      if ($searchTerm !== '') $query['search_term'] = $searchTerm;
      $authorItems = $this->vmapi->fetch_json($this->vmapi->api_base() . '/get_video_by_author_id/' . rawurlencode((string)$authorId) . '?' . http_build_query($query)) ?? [];
    }
    if ($authorId !== '' && $slug !== '' && empty($authorItems)) {
      $query = [
        'azienda_id' => $aziendaId,
        'limit' => 50,
        'offset' => 0,
        'search_term' => str_replace('-', ' ', $slug),
      ];
      $authors = $this->vmapi->fetch_json($this->vmapi->api_base() . '/get_authors?' . http_build_query($query)) ?? [];
      foreach ($authors as $a) {
        $aSlug = $a['slug'] ?? '';
        if ($aSlug === '') {
          $aSlug = vm_slugify((string)($a['name'] ?? ''));
        }
        if ($aSlug === $slug) {
          $authorId = (string)($a['id'] ?? $a['author_id'] ?? '');
          $authorName = (string)($a['name'] ?? $authorName);
          $authorImg = (string)($a['image'] ?? $authorImg);
          $authorCount = (string)($a['num_video'] ?? $authorCount);
          $authorFb = (string)($a['facebook'] ?? $authorFb);
          $authorLi = (string)($a['linkedin'] ?? $authorLi);
          break;
        }
      }
      if ($authorId !== '') {
        $query = [
          'azienda_id' => $aziendaId,
          'limit' => $limit,
          'offset' => 0,
        ];
        if ($searchTerm !== '') $query['search_term'] = $searchTerm;
        $authorItems = $this->vmapi->fetch_json($this->vmapi->api_base() . '/get_video_by_author_id/' . rawurlencode((string)$authorId) . '?' . http_build_query($query)) ?? [];
      }
    }
    if ($authorId !== '' && ($authorName === '' || $authorImg === '' || $authorCount === '')) {
      foreach ($authorItems as $item) {
        $authors = $item['authors'] ?? null;
        if (!is_array($authors)) continue;
        foreach ($authors as $a) {
          $aId = (string)($a['id'] ?? $a['author_id'] ?? '');
          if ($aId !== '' && $aId !== (string)$authorId) continue;
          if ($authorName === '' && isset($a['name'])) $authorName = (string)$a['name'];
          if ($authorImg === '' && isset($a['image'])) $authorImg = (string)$a['image'];
          if ($authorCount === '' && isset($a['num_video'])) $authorCount = (string)$a['num_video'];
          break 2;
        }
      }
    }

    $categoriesRaw = $this->vmapi->fetch_json($this->vmapi->api_base() . '/get_category?' . http_build_query([
      'azienda_id' => $aziendaId,
    ]));
    $categories = is_array($categoriesRaw) ? $categoriesRaw : (is_array($categoriesRaw['data'] ?? null) ? $categoriesRaw['data'] : []);

    $siteUrl = vm_site_url();
    $basePath = vm_base_path();
    $canonical = $siteUrl . $basePath . '/protagonisti/' . ($authorSlug ?: '');
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

    $title = $authorName ? ($aziendaName . ' - ' . $authorName) : ($aziendaName . ' - protagonista');
    $description = $authorName ? ('Video di ' . $authorName . ' su ' . $aziendaName . '.') : ("Contenuti dell'autore su " . $aziendaName . '.');
    $robots = ($searchTerm !== '') ? 'noindex, follow' : 'index, follow';

    $data = [
      'aziendaId' => $aziendaId,
      'basePath' => vm_base_path(),
      'baseHref' => vm_base_href(),
      'siteUrl' => vm_site_url(),
      'authorId' => $authorId,
      'authorName' => $authorName,
      'authorImg' => $authorImg,
      'authorCount' => $authorCount,
      'authorFb' => $authorFb,
      'authorLi' => $authorLi,
      'authorSlug' => $authorSlug,
      'authorItems' => $authorItems,
      'limit' => $limit,
      'categories' => $categories,
      'pageTitle' => $title,
      'pageDescription' => $description,
      'canonical' => $canonical,
      'robots' => $robots,
    ];

    $this->load->view('author', $data);
  }
}
