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

    $categoriesRaw = $this->vmapi->fetch_json($this->vmapi->api_base() . '/get_category?' . http_build_query([
      'azienda_id' => $aziendaId,
    ]));
    $categories = is_array($categoriesRaw) ? $categoriesRaw : (is_array($categoriesRaw['data'] ?? null) ? $categoriesRaw['data'] : []);

    $siteUrl = vm_site_url();
    $basePath = vm_base_path();
    $canonical = $siteUrl . $basePath . '/protagonisti/' . ($authorSlug ?: '');
    $title = $authorName ? ('VideoMetro – ' . $authorName) : 'VideoMetro – Autore';
    $description = $authorName ? ('Video di ' . $authorName . ' su VideoMetro.') : "Contenuti dell'autore su VideoMetro.";
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
