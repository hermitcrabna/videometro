<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Author_videos extends CI_Controller {
  public function index() {
    $this->load->library('vmapi');

    $author_id = (string)$this->input->get('author_id', true);
    if ($author_id === '') {
      $this->output->set_status_header(400);
      $this->output->set_content_type('application/json; charset=utf-8');
      $this->output->set_output(json_encode([
        'ok' => false,
        'error' => 'author_id mancante',
      ]));
      return;
    }

    $azienda_id = (int)$this->input->get('azienda_id', true);
    if (!$azienda_id) $azienda_id = (int)$this->config->item('azienda_id');

    $limit = (int)$this->input->get('limit', true);
    if ($limit <= 0) $limit = 20;
    if ($limit > 50) $limit = 50;

    $offset = $this->input->get('offset', true);
    $offset = $offset !== null ? max(0, (int)$offset) : null;

    $search_term = $this->input->get('search_term', true);

    $query = [
      'azienda_id' => $azienda_id,
      'limit' => $limit,
    ];
    if ($offset !== null) $query['offset'] = $offset;
    if ($search_term !== null && $search_term !== '') $query['search_term'] = $search_term;
    if ($author_id !== '') $query['author_id'] = $author_id;

    $url = $this->vmapi->api_base() . '/get_video_by_author_id/' . rawurlencode($author_id) . '?' . http_build_query($query);
    $res = $this->vmapi->fetch_raw($url);

    $raw = $res['raw'];
    $maybeJson = is_string($raw) ? json_decode($raw, true) : null;
    $isEmptyArray = is_array($maybeJson) && count($maybeJson) === 0;

    if ($isEmptyArray) {
      $fallbackQuery = $query;
      $fallbackQuery['author_id'] = $author_id;
      $fallbackUrl = $this->vmapi->api_base() . '/get_video?' . http_build_query($fallbackQuery);
      $fallback = $this->vmapi->fetch_raw($fallbackUrl);
      if ($fallback['raw'] !== false && $fallback['http'] >= 200 && $fallback['http'] < 300) {
        $res = $fallback;
        $raw = $fallback['raw'];
      }
    }

    if ($res['raw'] === false || $res['http'] < 200 || $res['http'] >= 300) {
      $this->output->set_status_header(502);
      $this->output->set_content_type('application/json; charset=utf-8');
      $this->output->set_output(json_encode([
        'ok' => false,
        'error' => 'Errore chiamata upstream',
        'http' => $res['http'],
        'detail' => $res['error'] ?: null,
        'errno' => $res['errno'] ?: null,
        'url' => $url,
      ]));
      return;
    }

    $this->output->set_content_type('application/json; charset=utf-8');
    $this->output->set_output($raw);
  }
}
