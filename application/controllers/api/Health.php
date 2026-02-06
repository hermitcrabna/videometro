<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Health extends CI_Controller {
  public function index() {
    $this->output->set_content_type('application/json; charset=utf-8');
    $this->output->set_output(json_encode([
      'ok' => true,
      'ts' => date('c'),
    ]));
  }
}
