<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['azienda_id'] = 1;
$config['site_url'] = 'https://videometro.tv';
// Base path of the app in the public URL ('' for root, '/videometro' for subfolder)
$config['base_path'] = '/videometro';
$config['video_path_prefix'] = '/video/';

$config['api_base'] = 'https://www.videometro.tv/Api';
$config['env'] = defined('ENVIRONMENT') ? ENVIRONMENT : 'production';
// In locale tieni la verifica TLS disattiva (come videometro_test). In produzione metti true.
$config['verify_tls'] = false;
$config['verify_host'] = $config['verify_tls'] ? 2 : 0;
