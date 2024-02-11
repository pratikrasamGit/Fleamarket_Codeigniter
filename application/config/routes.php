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

// APIs:
$api_ver = 'api/v1/';
 //rudra_user API Routes
 $t_name = 'auto_scripts/Rudra_user_apis/';
 $route[$api_ver.'user/(:any)'] = $t_name.'rudra_rudra_user/$1';

 //rudra_market API Routes
 $t_name = 'auto_scripts/Rudra_market_apis/';
 $route[$api_ver.'market/(:any)'] = $t_name.'rudra_rudra_market/$1';
 
 //rudra_settings API Routes
 $t_name = 'auto_scripts/Rudra_settings_apis/';
 $route[$api_ver.'settings/(:any)'] = $t_name.'rudra_rudra_settings/$1';

 //rudra_settings API Routes
 $t_name = 'auto_scripts/Rudra_needhelp_apis/';
 $route[$api_ver.'needhelp/(:any)'] = $t_name.'rudra_rudra_needhelp/$1';

  //rudra_payment API Routes
 $t_name = 'auto_scripts/Rudra_payment_apis/';
 $route[$api_ver.'payment/(:any)'] = $t_name.'rudra_rudra_payment/$1';

  //rudra_notification API Routes
 $t_name = 'auto_scripts/Rudra_notification_apis/';
 $route[$api_ver.'notification/(:any)'] = $t_name.'rudra_rudra_notification/$1';

   //rudra_notification API Routes
 $t_name = 'auto_scripts/Rudra_rentspace_apis/';
 $route[$api_ver.'rentspace/(:any)'] = $t_name.'rudra_rudra_rentspace/$1';

$crm = 'crm/';
//Crud Master
$crud_master = $crm . "Crudmasterstatic/";
$route['crudmaster'] = $crud_master . 'index';
$route['crudmaster/index'] = $crud_master . 'index';
$route['crudmaster/list'] = $crud_master . 'list';
$route['crudmaster/post_actions/(:any)'] = $crud_master . 'post_actions/$1';

//Rudra_user_crtl ROUTES
$crud_master = $crm . "Rudra_user_crtl/";
$route['rudra_user'] = $crud_master . 'index';
$route['rudra_user/index'] = $crud_master . 'index';
$route['rudra_user/list'] = $crud_master . 'list';
$route['rudra_user/post_actions/(:any)'] = $crud_master.'post_actions/$1';

//Rudra_rent_space_crtl ROUTES
$crud_master = $crm . "Rudra_rent_space_crtl/";
$route['rudra_rent_space'] = $crud_master . 'index';
$route['rudra_rent_space/index'] = $crud_master . 'index';
$route['rudra_rent_space/list'] = $crud_master . 'list';
$route['rudra_rent_space/post_actions/(:any)'] = $crud_master.'post_actions/$1';

//Rudra_settings_crtl ROUTES
$crud_master = $crm . "Rudra_settings_crtl/";
$route['rudra_settings'] = $crud_master . 'index';
$route['rudra_settings/index'] = $crud_master . 'index';
$route['rudra_settings/list'] = $crud_master . 'list';
$route['rudra_settings/post_actions/(:any)'] = $crud_master.'post_actions/$1';

//Rudra_user_fav_markets_crtl ROUTES
$crud_master = $crm . "Rudra_user_fav_markets_crtl/";
$route['rudra_user_fav_markets'] = $crud_master . 'index';
$route['rudra_user_fav_markets/index'] = $crud_master . 'index';
$route['rudra_user_fav_markets/list'] = $crud_master . 'list';
$route['rudra_user_fav_markets/post_actions/(:any)'] = $crud_master.'post_actions/$1';

//Rudra_user_share_markets_crtl ROUTES
$crud_master = $crm . "Rudra_user_share_markets_crtl/";
$route['rudra_user_share_markets'] = $crud_master . 'index';
$route['rudra_user_share_markets/index'] = $crud_master . 'index';
$route['rudra_user_share_markets/list'] = $crud_master . 'list';
$route['rudra_user_share_markets/post_actions/(:any)'] = $crud_master.'post_actions/$1';

//Rudra_rent_space_purchased_crtl ROUTES
$crud_master = $crm . "Rudra_rent_space_purchased_crtl/";
$route['rudra_rent_space_purchased'] = $crud_master . 'index';
$route['rudra_rent_space_purchased/index'] = $crud_master . 'index';
$route['rudra_rent_space_purchased/list'] = $crud_master . 'list';
$route['rudra_rent_space_purchased/post_actions/(:any)'] = $crud_master.'post_actions/$1';

//Rudra_purchased_plan_crtl ROUTES
$crud_master = $crm . "Rudra_purchased_plan_crtl/";
$route['rudra_purchased_plan'] = $crud_master . 'index';
$route['rudra_purchased_plan/index'] = $crud_master . 'index';
$route['rudra_purchased_plan/list'] = $crud_master . 'list';
$route['rudra_purchased_plan/post_actions/(:any)'] = $crud_master.'post_actions/$1';

//Rudra_purchased_package_crtl ROUTES
$crud_master = $crm . "Rudra_purchased_package_crtl/";
$route['rudra_purchased_package'] = $crud_master . 'index';
$route['rudra_purchased_package/index'] = $crud_master . 'index';
$route['rudra_purchased_package/list'] = $crud_master . 'list';
$route['rudra_purchased_package/post_actions/(:any)'] = $crud_master.'post_actions/$1';

//Rudra_purchased_history_crtl ROUTES
$crud_master = $crm . "Rudra_purchased_history_crtl/";
$route['rudra_purchased_history'] = $crud_master . 'index';
$route['rudra_purchased_history/index'] = $crud_master . 'index';
$route['rudra_purchased_history/list'] = $crud_master . 'list';
$route['rudra_purchased_history/post_actions/(:any)'] = $crud_master.'post_actions/$1';

//Rudra_plan_crtl ROUTES
$crud_master = $crm . "Rudra_plan_crtl/";
$route['rudra_plan'] = $crud_master . 'index';
$route['rudra_plan/index'] = $crud_master . 'index';
$route['rudra_plan/list'] = $crud_master . 'list';
$route['rudra_plan/post_actions/(:any)'] = $crud_master.'post_actions/$1';

//Rudra_payment_method_crtl ROUTES
$crud_master = $crm . "Rudra_payment_method_crtl/";
$route['rudra_payment_method'] = $crud_master . 'index';
$route['rudra_payment_method/index'] = $crud_master . 'index';
$route['rudra_payment_method/list'] = $crud_master . 'list';
$route['rudra_payment_method/post_actions/(:any)'] = $crud_master.'post_actions/$1';

//Rudra_package_crtl ROUTES
$crud_master = $crm . "Rudra_package_crtl/";
$route['rudra_package'] = $crud_master . 'index';
$route['rudra_package/index'] = $crud_master . 'index';
$route['rudra_package/list'] = $crud_master . 'list';
$route['rudra_package/post_actions/(:any)'] = $crud_master.'post_actions/$1';

//Rudra_notification_crtl ROUTES
$crud_master = $crm . "Rudra_notification_crtl/";
$route['rudra_notification'] = $crud_master . 'index';
$route['rudra_notification/index'] = $crud_master . 'index';
$route['rudra_notification/list'] = $crud_master . 'list';
$route['rudra_notification/post_actions/(:any)'] = $crud_master.'post_actions/$1';

//Rudra_need_help_type_crtl ROUTES
$crud_master = $crm . "Rudra_need_help_type_crtl/";
$route['rudra_need_help_type'] = $crud_master . 'index';
$route['rudra_need_help_type/index'] = $crud_master . 'index';
$route['rudra_need_help_type/list'] = $crud_master . 'list';
$route['rudra_need_help_type/post_actions/(:any)'] = $crud_master.'post_actions/$1';

//Rudra_need_help_message_crtl ROUTES
$crud_master = $crm . "Rudra_need_help_message_crtl/";
$route['rudra_need_help_message'] = $crud_master . 'index';
$route['rudra_need_help_message/index'] = $crud_master . 'index';
$route['rudra_need_help_message/list'] = $crud_master . 'list';
$route['rudra_need_help_message/post_actions/(:any)'] = $crud_master.'post_actions/$1';

//Rudra_market_crtl ROUTES
$crud_master = $crm . "Rudra_market_crtl/";
$route['rudra_market'] = $crud_master . 'index';
$route['rudra_market/index'] = $crud_master . 'index';
$route['rudra_market/list'] = $crud_master . 'list';
$route['rudra_market/post_actions/(:any)'] = $crud_master.'post_actions/$1';

//Rudra_category_details_crtl ROUTES
$crud_master = $crm . "Rudra_category_details_crtl/";
$route['rudra_category_details'] = $crud_master . 'index';
$route['rudra_category_details/index'] = $crud_master . 'index';
$route['rudra_category_details/list'] = $crud_master . 'list';
$route['rudra_category_details/post_actions/(:any)'] = $crud_master.'post_actions/$1';

//Rudra_bank_account_crtl ROUTES
$crud_master = $crm . "Rudra_bank_account_crtl/";
$route['rudra_bank_account'] = $crud_master . 'index';
$route['rudra_bank_account/index'] = $crud_master . 'index';
$route['rudra_bank_account/list'] = $crud_master . 'list';
$route['rudra_bank_account/post_actions/(:any)'] = $crud_master.'post_actions/$1';

//Daddy Admin Codes
$route['crm/admin'] = 'crm/admin';
$route['admin-login'] = 'crm/admin/login';
$route['do-admin-login'] = 'crm/Admin/check_login_admin';
$route['admin'] = 'crm/Admin/index';
$route['dashboard-data'] = 'crm/Admin/get_dashboard_data';
$route['load-ajax-data'] = 'crm/Dashboard_ajax/get_data';
$route['logout'] = 'crm/Admin/logout';


// $route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['privacy_policy'] = 'welcome/privacy_policy';
$route['user_agreement'] = 'welcome/user_agreement';
$route['terms_of_use'] = 'welcome/terms_of_use';

$route['default_controller'] = 'home';
$route['explore'] = 'home/explore';
$route['market/(:any)'] = "home/market/$1";
$route['details'] = 'home/details';
$route['share-link/(:any)'] = 'home/share_link/$1';
$route['create-flea-market'] = 'home/create_flea_market';
$route['create-flea-market/(:any)'] = 'home/create_flea_market/$1';
$route['create-flea-market-step-2'] = 'home/create_flea_market_step2';
$route['create-flea-market-step-3'] = 'home/create_flea_market_step3';
$route['map-view'] = 'home/map_view';
$route['faqs'] = 'home/faqs';
$route['terms-and-conditions'] = 'home/terms_conditions';
$route['priacy-policy'] = 'home/priacy_policy';
$route['priacy-policy/(:any)'] = 'home/priacyPolicy/$1';
$route['about'] = 'home/about';
$route['recuring'] = 'home/recuring';
$route['reset-password/(:any)'] = 'home/resetPassword/$1';
$route['update-password'] = 'home/updatePassword';
$route['reset-password-link'] = 'home/resetPasswordLink';

$route['pj_privacy_policy'] = 'home/pj_privacy_policy';
$route['pj_terms'] = 'home/pj_terms';
$route['pj_user_data_policy'] = 'home/pj_user_data_policy';

$route['auth_google'] = 'users/auth_google';
$route['auth_facebook'] = 'users/auth_facebook';

$route['registration'] = 'users/registration';

$route['login'] = 'users/login';
$route['users/logout'] = 'users/logout';
$route['users'] = 'user/users';
$route['users/favorite'] = 'user/users/favorite';
$route['users/notification'] = 'user/users/notification';
$route['users/need-help'] = 'user/users/needHelp';
$route['users/profile_update'] = 'user/users/profileUpdate';

$route['users/plan'] = 'user/plan';

$route['users/my-market'] = 'user/market/myMarket';

$route['users/packages'] = 'user/packages';
$route['users/purchase-history'] = 'user/packages/purchaseHistory';

$route['users/rent-space'] = 'user/rentspace/list';
$route['users/rent-space/create-table'] = 'user/rentspace/createTable';

$route['users/getMarketData'] = 'user/rentspace/getMarketData';
$route['submit_favorite'] = 'home/submit_favorite';

$route['payment']  = 'user/plan/handlePayment';
$route['rentspace-payment'] = 'user/rentspace/handlePayment';

$route['users/rent-space/addbank'] = 'user/rentspace/addbank';

$route['user/cancel_package'] = 'user/packages/cancel_package';
$route['user/cancel_plan'] = 'user/plan/cancel_plan';

$route['test_realgame'] = 'users/test_realgame';

// $route['mobilepay/init'] = 'users/mobilepay_init';
$route['callback'] = 'users/callback';
$route['token'] = 'users/callback2';
$route['success-callback'] = 'users/success_callback';
$route['cancel-callback'] = 'users/cancel_callback';

$route['cron/checkMobilepayStatus'] = 'users/checkMobilepayStatus';
$route['cron/paymentRequest'] = 'users/paymentRequest';
$route['cron/test'] = 'users/crontest';

$route['delete_image'] = 'home/delete_gallery';


$route['get_purchase_rec'] = 'users/purchase_rec';
$route['get_rentspace_rec'] = 'users/rent_space_purchased';
