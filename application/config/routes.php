<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
| Please see the employee guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "web";
$route['404_override'] = '';
$route['p/(:any)/(:any)'] = 'web/p/$1/$2';
$route['c/(:any)/(:any)'] = 'web/c/$1/$2';
$route['c/(:any)/(:any)/(:any)'] = 'web/c/$1/$2/$3';
$route['c/(:any)/(:any)/(:any)/(:any)'] = 'web/c/$1/$2/$3/$4';
$route['checkout'] = 'web/checkout';
$route['cart'] = 'web/cart';
$route['payment'] = 'web/payment';
$route['delivery'] = 'web/delivery';
$route['confirmation'] = 'web/confirmation';


/* End of file routes.php */
/* Location: ./application/config/routes.php */