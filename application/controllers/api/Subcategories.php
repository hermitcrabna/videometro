<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subcategories extends CI_Controller {
  public function index() {
    $this->load->library('vmapi');

    $azienda_id = (int)$this->input->get('azienda_id', true);
    if (!$azienda_id) $azienda_id = (int)$this->config->item('azienda_id');
    $cat_id = (string)$this->input->get('cat_id', true);

    $query = [
      'azienda_id' => $azienda_id,
    ];
    if ($cat_id !== '') $query['cat_id'] = $cat_id;

    $url = $this->vmapi->api_base() . '/get_subcategory?' . http_build_query($query);

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
