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

    if ($authorId === '') {
      $path = uri_string();
      if (preg_match('#protagonisti/([^/]+)#', $path, $m)) {
        if (preg_match('/^(\d+)(?:-|$)/', $m[1], $idMatch)) {
          $authorId = $idMatch[1];
        }
      }
    }

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
      'authorItems' => $authorItems,
      'limit' => $limit,
      'categories' => $categories,
    ];

    $this->load->view('author', $data);
  }
}
