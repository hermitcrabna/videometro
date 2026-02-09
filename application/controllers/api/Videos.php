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
    if ($featured !== null && $featured !== '' && $featured !== 'all') $query['featured'] = $featured;
    if ($author_id !== null && $author_id !== '') $query['author_id'] = $author_id;
    if ($blog !== null && $blog !== '') $query['blog'] = $blog;
    if ($gallery !== null && $gallery !== '') $query['gallery'] = $gallery;

    $extract_items = function($payload) {
      if (!is_array($payload)) return [];
      $keys = array_keys($payload);
      if ($keys === range(0, count($keys) - 1)) return $payload;
      if (isset($payload['data']) && is_array($payload['data'])) return $payload['data'];
      if (isset($payload['videos']) && is_array($payload['videos'])) return $payload['videos'];
      if (isset($payload['data']['data']) && is_array($payload['data']['data'])) return $payload['data']['data'];
      return [];
    };

    if ($featured === 'all') {
      $baseQuery = $query;
      $target = $offset !== null ? ($offset + $limit) : $limit;
      $chunk = $target > 0 ? min(50, $target) : 50;

      $fetch_list = function($flag) use ($baseQuery, $chunk, $target, $extract_items) {
        $items = [];
        $off = 0;
        $guard = 0;
        while ($target === 0 || count($items) < $target) {
          $q = $baseQuery;
          $q['featured'] = $flag;
          $q['limit'] = $chunk;
          $q['offset'] = $off;
          $url = $this->vmapi->api_base() . '/get_video?' . http_build_query($q);
          $res = $this->vmapi->fetch_raw($url);
          if ($res['raw'] === false || $res['http'] < 200 || $res['http'] >= 300) break;
          $json = json_decode($res['raw'], true);
          $batch = $extract_items($json);
          if (!$batch) break;
          $items = array_merge($items, $batch);
          if (count($batch) < $chunk) break;
          $off += count($batch);
          $guard += 1;
          if ($guard > 10) break;
        }
        return $items;
      };

      $items = array_merge($fetch_list('0'), $fetch_list('1'));

      $id_for = function($v) {
        if (!is_array($v)) return '';
        foreach (['video_id','id','post_id'] as $k) {
          if (!empty($v[$k])) return (string)$v[$k];
        }
        return '';
      };
      $ts_for = function($v) {
        if (!is_array($v)) return 0;
        foreach (['date','data','created_at','published_at','updated_at','timestamp','data_pub','pub_date'] as $k) {
          if (!empty($v[$k])) {
            $ts = strtotime((string)$v[$k]);
            if ($ts !== false) return $ts;
          }
        }
        return 0;
      };

      $seen = [];
      $merged = [];
      foreach ($items as $it) {
        $id = $id_for($it);
        if ($id !== '' && isset($seen[$id])) continue;
        if ($id !== '') $seen[$id] = true;
        $merged[] = $it;
      }

      usort($merged, function($a, $b) use ($ts_for, $id_for) {
        $ta = $ts_for($a);
        $tb = $ts_for($b);
        if ($ta !== $tb) return $tb <=> $ta;
        return strcmp($id_for($b), $id_for($a));
      });

      $slice = $limit > 0 ? array_slice($merged, $offset ?? 0, $limit) : $merged;
      $this->output->set_content_type('application/json; charset=utf-8');
      $this->output->set_output(json_encode($slice, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
      return;
    }

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
