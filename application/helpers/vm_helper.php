<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function vm_h($value): string {
  return html_escape((string)($value ?? ''));
}

function vm_base_path(): string {
  $ci = get_instance();
  $base = trim((string)$ci->config->item('base_path'));
  if ($base === '') return '';
  if ($base[0] !== '/') $base = '/' . $base;
  return rtrim($base, '/');
}

function vm_base_href(): string {
  $base = vm_base_path();
  return $base === '' ? '/' : $base . '/';
}

function vm_site_url(): string {
  $ci = get_instance();
  $site = rtrim((string)$ci->config->item('site_url'), '/');
  return $site !== '' ? $site : rtrim(site_url(), '/');
}

function vm_slugify(string $value): string {
  $value = iconv('UTF-8', 'ASCII//TRANSLIT', $value);
  $value = strtolower(trim(preg_replace('/[^a-z0-9]+/i', '-', $value), '-'));
  return $value;
}
