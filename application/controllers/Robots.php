<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Robots extends CI_Controller {
  public function index() {
    $this->output->set_content_type('text/plain; charset=utf-8');
    $this->output->set_output("User-agent: *\nAllow: /\n\nSitemap: " . rtrim(vm_site_url(), '/') . "/sitemap.xml\n");
  }
}
