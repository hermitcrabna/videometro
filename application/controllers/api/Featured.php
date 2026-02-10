<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Featured extends CI_Controller {
  public function index() {
    $this->load->library('vmapi');

    $azienda_id = (int)$this->input->get('azienda_id', true);
    if (!$azienda_id) $azienda_id = (int)$this->config->item('azienda_id');

    $limit = (int)$this->input->get('limit', true);
    if ($limit <= 0) $limit = 10;
    if ($limit > 50) $limit = 50;

    $offset = $this->input->get('offset', true);
    $offset = $offset !== null ? max(0, (int)$offset) : 0;

    $featured = $this->input->get('featured', true);
    if ($featured === null || $featured === '') $featured = '1';

    $query = [
      'azienda_id' => $azienda_id,
      'featured' => $featured,
      'limit' => $limit,
      'offset' => $offset,
    ];

    $url = $this->vmapi->api_base() . '/get_video_featured?' . http_build_query($query);
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
