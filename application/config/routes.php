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

// Default Controller - Set to Auth (Login)
$route['default_controller'] = 'auth';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Authentication Routes
$route['login'] = 'auth/login';
$route['logout'] = 'auth/logout';

// Dashboard Routes
$route['dashboard'] = 'dashboard';

// Billing Routes
$route['billing'] = 'billing';
$route['billing/create'] = 'billing/create';
$route['billing/save'] = 'billing/save';
$route['billing/view/(:num)'] = 'billing/view/$1';
$route['billing/print/(:num)'] = 'billing/print/$1';
$route['billing/void/(:num)'] = 'billing/void/$1';
$route['billing/search'] = 'billing/search';

// Inventory Routes
$route['inventory'] = 'inventory';
$route['inventory/create'] = 'inventory/create';
$route['inventory/edit/(:num)'] = 'inventory/edit/$1';
$route['inventory/delete/(:num)'] = 'inventory/delete/$1';
$route['inventory/search'] = 'inventory/search';
$route['inventory/get_item/(:num)'] = 'inventory/get_item/$1';
$route['inventory/update_stock'] = 'inventory/update_stock';

// Reports Routes
$route['reports'] = 'reports';
$route['reports/sales'] = 'reports/sales';
$route['reports/inventory'] = 'reports/inventory';
$route['reports/generate/(:any)'] = 'reports/generate/$1';
$route['reports/export/(:any)'] = 'reports/export/$1';

// Settings Routes
$route['settings'] = 'settings';
$route['settings/update'] = 'settings/update';
$route['settings/profile'] = 'settings/profile';
$route['settings/update_profile'] = 'settings/update_profile';
$route['settings/change_password'] = 'settings/change_password';

// API Routes for AJAX Calls
$route['api/inventory/search'] = 'api/inventory_search';
$route['api/inventory/get_item/(:num)'] = 'api/get_item/$1';
$route['api/billing/get_bill/(:num)'] = 'api/get_bill/$1';
