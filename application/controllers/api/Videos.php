<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Videos extends CI_Controller {
  public function index() {
    $this->load->library('vmapi');

    $azienda_id = (int)$this->input->get('azienda_id', true);
    if (!$azienda_id) $azienda_id = (int)$this->config->item('azienda_id');

    $limit = (int)$this->input->get('limit', true);
    if ($limit <= 0) $limit = 20;
    if ($limit > 50) $limit = 50;

    $offset = $this->input->get('offset', true);
    $page = $this->input->get('page', true);
    $offset = $offset !== null ? max(0, (int)$offset) : null;
    $page = $page !== null ? max(1, (int)$page) : null;
    if ($offset === null && $page !== null) $offset = ($page - 1) * $limit;

    $search_term = $this->input->get('search_term', true);
    $cat_id = $this->input->get('cat_id', true);
    $subcat_id = $this->input->get('subcat_id', true);
    $featured = $this->input->get('featured', true);
    $author_id = $this->input->get('author_id', true);
    $blog = $this->input->get('blog', true);
    $gallery = $this->input->get('gallery', true);

    $query = [
      'azienda_id' => $azienda_id,
      'limit' => $limit,
    ];
    if ($offset !== null) $query['offset'] = $offset;
    if ($search_term !== null && $search_term !== '') $query['search_term'] = $search_term;
    if ($cat_id !== null && $cat_id !== '') $query['cat_id'] = $cat_id;
    if ($subcat_id !== null && $subcat_id !== '') $query['subcat_id'] = $subcat_id;
    if ($featured !== null && $featured !== '') $query['featured'] = $featured;
    if ($author_id !== null && $author_id !== '') $query['author_id'] = $author_id;
    if ($blog !== null && $blog !== '') $query['blog'] = $blog;
    if ($gallery !== null && $gallery !== '') $query['gallery'] = $gallery;

    $url = $this->vmapi->api_base() . '/get_video?' . http_build_query($query);
    $res = $this->vmapi->fetch_raw($url);

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
    $this->output->set_output($res['raw']);
  }
}
