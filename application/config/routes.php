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
| Please see the user guide for complete details:
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

$route['default_controller'] = "main";
$route['main/confirm-email'] = "main/confirm_email";
$route['main/confirm-email/(.*)'] = "main/confirm_email/$1";
$route['main/thank-you'] = "main/thank_you";
$route['main/confirm-registration'] = "main/confirm_reg";
$route['profile/add-feedback/(:any)'] = "profile/new_feedback/$1";
$route['forgot-password'] = "main/forgot_password";
$route['change-password/(:any)'] = "main/change_password/$1";
$route['post-ad'] = "main/post_ad";
$route['about'] = "main/about";
$route['disclaimers'] = "main/disclaimers";
$route['terms-and-conditions'] = "main/terms";
$route['edit-ad/(:any)'] = "products/edit/$1";
//$route['profile/(:any)'] = "profile/view/$1";
$route['404_override'] = ''; 


/* End of file routes.php */
/* Location: ./application/config/routes.php */