<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vmapi {
  protected $ci;
  protected $apiBase;
  protected $verifyTls;
  protected $verifyHost;

  public function __construct() {
    $this->ci =& get_instance();
    $this->apiBase = rtrim((string)$this->ci->config->item('api_base'), '/');
    $this->verifyTls = (bool)$this->ci->config->item('verify_tls');
    $this->verifyHost = (int)$this->ci->config->item('verify_host');
  }

  public function api_base(): string {
    return $this->apiBase;
  }

  public function fetch_raw(string $url): array {
    if (function_exists('curl_init')) {
      $ch = curl_init($url);
      curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 15,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_SSL_VERIFYHOST => $this->verifyHost,
        CURLOPT_SSL_VERIFYPEER => $this->verifyTls,
      ]);
      $raw = curl_exec($ch);
      $http = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
      $err = curl_error($ch);
      $errno = curl_errno($ch);
      curl_close($ch);
      return [
        'raw' => $raw,
        'http' => $http,
        'error' => $err,
        'errno' => $errno,
      ];
    }

    // Fallback senza cURL
    $context = stream_context_create([
      'http' => [
        'method' => 'GET',
        'timeout' => 15,
        'follow_location' => 1,
      ],
      'ssl' => [
        'verify_peer' => $this->verifyTls,
        'verify_peer_name' => $this->verifyTls,
      ],
    ]);
    $raw = @file_get_contents($url, false, $context);
    $http = 0;
    if (isset($http_response_header) && is_array($http_response_header)) {
      foreach ($http_response_header as $header) {
        if (preg_match('#^HTTP/\\S+\\s+(\\d+)#', $header, $m)) {
          $http = (int)$m[1];
          break;
        }
      }
    }
    return [
      'raw' => $raw,
      'http' => $http,
      'error' => $raw === false ? 'file_get_contents failed' : '',
      'errno' => $raw === false ? 1 : 0,
    ];

  }

  public function fetch_json(string $url): ?array {
    $res = $this->fetch_raw($url);
    if ($res['raw'] === false || $res['http'] < 200 || $res['http'] >= 300) return null;
    $data = json_decode($res['raw'], true);
    return is_array($data) ? $data : null;
  }
}
