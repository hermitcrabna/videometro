<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// SSR pages
$route['blog'] = 'blog';
$route['blog/(:any)'] = 'blog_post/index/$1';
$route['gallery/(:any)'] = 'gallery/index/$1';
$route['protagonisti'] = 'authors';
$route['protagonisti/(:num)(:any)'] = 'author/index/$1';
$route['protagonisti/(:num)'] = 'author/index/$1';
$route['protagonisti/(:any)'] = 'author/index';
$route['video/categoria/(:any)'] = 'home/index/$1';
$route['video/(:any)'] = 'player/index/$1';
$route['sitemap.xml'] = 'sitemap/index';
$route['robots.txt'] = 'robots/index';
$route['privacy'] = 'privacy';
$route['cookie'] = 'cookie';

// API proxies (support .php and clean URLs)
$route['api/videos.php'] = 'api/videos/index';
$route['api/videos'] = 'api/videos/index';
$route['api/categories.php'] = 'api/categories/index';
$route['api/categories'] = 'api/categories/index';
$route['api/subcategories.php'] = 'api/subcategories/index';
$route['api/subcategories'] = 'api/subcategories/index';
$route['api/authors.php'] = 'api/authors/index';
$route['api/authors'] = 'api/authors/index';
$route['api/author_videos.php'] = 'api/author_videos/index';
$route['api/author_videos'] = 'api/author_videos/index';
$route['api/azienda.php'] = 'api/azienda/index';
$route['api/azienda'] = 'api/azienda/index';
$route['api/video_by_slug.php'] = 'api/video_by_slug/index';
$route['api/video_by_slug'] = 'api/video_by_slug/index';
$route['api/health.php'] = 'api/health/index';
$route['api/health'] = 'api/health/index';
