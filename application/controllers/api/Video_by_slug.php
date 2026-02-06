<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Video_by_slug extends CI_Controller {
  public function index() {
    $this->load->library('vmapi');

    $slug = (string)$this->input->get('slug', true);
    if ($slug === '') {
      $this->output->set_status_header(400);
      $this->output->set_content_type('application/json; charset=utf-8');
      $this->output->set_output(json_encode([
        'ok' => false,
        'error' => 'slug mancante',
      ]));
      return;
    }

    $url = $this->vmapi->api_base() . '/get_video_by_slug/' . rawurlencode($slug);
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
