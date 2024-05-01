<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller'] = 'index';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

# ADMIN

$route['admin/login']                   = 'admin/index/login';
$route['admin/logout']                  = 'admin/index/logout';
$route['admin/meta-info']               = 'admin/Meta_info/index';
$route['admin/meta-info/manage']        = 'admin/Meta_info/manage';
$route['admin/meta-info/manage/(:any)'] = 'admin/Meta_info/manage/$1';
$route['admin/meta-info/delete/(:any)'] = 'admin/Meta_info/delete/$1';

# SUBADMIN
$route['portal/login'] = 'portal/index/login';
$route['portal/logout'] = 'portal/index/logout';

# API ROUTES

$route['api/site-settings']    = 'api/pages/site_settings';
$route['code']                        = 'page/code';
$route['code/(:num)'] = 'page/code/$1';
$route['code-detail/(:any)']          = 'page/code_detail/$1';
$route['inventory']                   = 'page/inventory';
$route['inventory-detail/(:any)']     = 'page/inventory_detail/$1';
$route['delete-cart/(:any)/(:any)']     = 'ajax/delete_cart/$1/$2';
$route['generics']                    = 'page/generics';
$route['generics/(:num)'] = 'page/generics/$1';
$route['generic-detail/(:any)']       = 'page/generic_detail/$1';
$route['new-photo-grade']          = 'page/photo_grade_view';
$route['photo-grade']                 = 'page/photo_grade';
$route['photo-detail/(:any)']         = 'page/photo_detail/$1';
$route['newsletter']           = 'ajax/newsletter';


$route['signup']               = 'page/signup';
$route['login']                = 'page/login';
$route['signout']              = 'page/signout';

$route['resend-email'] = 'account/resend_email';
$route['verification/(:any)'] = 'Register/verification/$1';
$route['email-verification'] = 'account/email_verification';

$route['forgot-password'] = 'page/forgot_password';
$route['reset-password'] = 'page/reset_password';
$route['forgot-pass'] = 'Register/forgot';
$route['reset/(:any)'] = 'Register/reset/$1';
$route['reset-pass'] = 'Register/reset_password';

// $route['api/save-contact-message']      = 'api/pages/save_contact_message';
// $route['api/save-newsletter']           = 'api/pages/save_newsletter';




$route['dashboard'] = 'account/dashboard';
$route['profile_settings'] = 'account/profile_settings';
$route['notifications']                 = 'account/notifications';
$route['notifications-details/(:any)']                 = 'account/notifications_detail/$1';
