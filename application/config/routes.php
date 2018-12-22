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
|	https://codeigniter.com/user_guide/general/routing.html
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

$route['api/customers']['GET']          = 'UserController/get_all';
$route['api/customers']['POST']          = 'UserController/search';
$route['api/infoair']['POST'] = 'UserController/infoair';
$route['api/infononair']['POST'] = 'UserController/infononair';
$route['api/login']['POST'] = 'UserController/login';
$route['api/otentikasi']['POST'] = 'UserController/otentikasi';
$route['api/complain']['POST'] = 'UserController/complain';
$route['api/get_complain']['POST'] = 'UserController/get_complain';

//$route['api/customer/(:num)']['GET']    = 'UserController/get/$1';
//$route['api/register']['POST']      = 'UserController/register';
//$route['api/customer/(:num)']['PUT']    = 'UserController/update/$1';
//$route['api/customer/(:num)']['DELETE'] = 'UserController/delete/$1';
//$route['api/login']                 = 'UserController/login';


$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
