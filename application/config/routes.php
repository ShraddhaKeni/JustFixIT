<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| ----------------------------------------------------------------	---------
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
$route['default_controller'] = 'home';
$route['admin'] = 'admin/login';
$route['dashboard'] = 'admin/dashboard';
$route['map'] = 'admin/dashboard/map_list';
$route['map_lists'] = 'admin/dashboard/service_map_list';
$route['admin-profile'] = 'admin/profile';
$route['admin/logout'] = 'admin/login/logout';
$route['admin/wallet'] = 'admin/wallet';
$route['admin/wallet-history'] = 'admin/wallet/wallet_history';
/*booking report*/
$route['admin/total-report'] = 'admin/Booking/total_bookings';
$route['admin/pending-report'] = 'admin/Booking/pending_bookings';
$route['admin/inprogress-report'] = 'admin/Booking/inprogress_bookings';
$route['admin/complete-report'] = 'admin/Booking/completed_bookings';
$route['admin/reject-report'] = 'admin/Booking/rejected_bookings';
$route['admin/cancel-report'] = 'admin/Booking/cancel_bookings';
$route['reject-payment/(:num)'] = 'admin/Booking/reject_booking_payment';
$route['pay-reject'] = 'admin/Booking/update_reject_payment';

$route['admin-notification'] = 'admin/Dashboard/admin_notification';



/* Settings*/
$route['admin/emailsettings'] = 'admin/settings/emailsettings';
$route['admin/sms-settings'] = 'admin/settings/smssettings';
$route['admin/stripe_payment_gateway'] = 'admin/settings/stripe_payment_gateway';


$route['users'] = 'admin/dashboard/users';
$route['user-details/(:num)'] = 'admin/dashboard/user_details/$1';
$route['users_list'] = 'admin/dashboard/users_list';


$route['categories'] = 'admin/categories/categories';
$route['add-category'] = 'admin/categories/add_categories';
$route['categories/check_category_name'] = 'admin/categories/check_category_name';
$route['edit-category/(:num)'] = 'admin/categories/edit_categories/$1';

$route['subcategories'] = 'admin/categories/subcategories';
$route['add-subcategory'] = 'admin/categories/add_subcategories';
$route['categories/check_subcategory_name'] = 'admin/categories/check_subcategory_name';
$route['edit-subcategory/(:num)'] = 'admin/categories/edit_subcategories/$1';

$route['subscriptions'] = 'admin/service/subscriptions';

$route['add-subscription'] = 'admin/service/add_subscription';

$route['service/check_subscription_name'] = 'admin/service/check_subscription_name';

$route['service/save_subscription'] = 'admin/service/save_subscription';

$route['edit-subscription/(:num)'] = 'admin/service/edit_subscription/$1';

$route['service/update_subscription'] = 'admin/service/update_subscription';

$route['subscription-list'] = 'user/subscription/subscription_list';

$route['ratingstype'] = 'admin/ratingstype/ratingstype';
$route['review-reports'] = 'admin/ratingstype/review_report';

$route['add-ratingstype'] = 'admin/ratingstype/add_ratingstype';

$route['ratingstype/check_ratingstype_name'] = 'admin/ratingstype/check_ratingstype_name';

$route['edit-ratingstype/(:num)'] = 'admin/ratingstype/edit_ratingstype/$1';

$route['service-providers'] = 'admin/service/service_providers';
$route['add-service-providers'] = 'admin/service/add_service_providers';
$route['edit-service-providers/(:num)'] = 'admin/service/edit_service_providers/$1';
$route['delete-service-providers/(:num)'] = 'admin/service/delete_service_providers/$1';
$route['getSubcategory/(:num)'] = 'admin/service/getSubcategory/$1';
$route['save_provider'] = 'admin/service/save_provider';
$route['update_provider/(:num)'] = 'admin/service/update_provider/$1';
//$route['change_provider_status/(:num)'] = 'admin/service/change_Provider_Status/$1';
$route['change_provider_status'] = 'admin/service/change_Status';

$route['provider_list'] = 'admin/service/provider_list';
$route['service-list'] = 'admin/service/service_list';
$route['provider-details/(:num)'] = 'admin/service/provider_details/$1';
$route['admin/provider_list'] = 'admin/service/provider_list';
$route['payment_list'] = 'admin/payments/payment_list';
$route['admin-payment/(:any)'] = 'admin/payments/admin_payment/$1';
$route['service-details/(:num)'] = 'admin/service/service_details/$1';

/*web*/

$route['all-categories'] = 'categories';
$route['provider_subscription'] = 'user/service/provider_subscription';
$route['featured-category'] = 'user/categories/featured_categories';
$route['service-preview/(:any)'] = 'home/service_preview/$1';
$route['all-services'] = 'home/services';
$route['services/(:num)'] = 'home/show_service/$1';
$route['subcategory/(:num)'] = 'home/subcategory/$1';
//$route['subcategories'] = 'home/showAllSubcategory';
$route['featured-services'] = 'user/service/featured_services';  // Done
$route['popular-services'] = 'user/service/popular_services'; // Done
$route['search'] = 'home/services';
$route['about-us'] = 'user/about/about_us';
$route['verified'] = 'user/verified/verified';
$route['terms-conditions'] = 'user/terms/terms';
$route['contact'] = 'user/contact/contact';
$route['submitcontact'] = 'user/contact/submit_contact';
$route['search/(:any)'] = 'home/services/$1';
$route['privacy'] = 'user/privacy/privacy';
$route['faq'] = 'user/privacy/faq';
$route['help'] = 'user/privacy/help';

//my_service_pagination
$route['my-services']='user/myservice/index';
$route['my-services-inactive']='user/myservice/inactive_services';
//end

$route['add-service']='user/service/add_service';

$route['edit_service']='user/service/edit_service';
$route['notification-list']='user/service/notification_view';
$route['booking']='user/service/booking';
$route['update_bookingstatus']='user/service/update_bookingstatus';
$route['update_status_user']='user/service/update_status_user';
$route['update_booking/(:any)']='user/service/update_booking/$1';
$route['user_bookingstatus/(:any)']='user/service/user_bookingstatus/$1';
$route['book-service/(:any)']='user/service/book_service/$1';
$route['booking_service_submit']='user/booking/booking_service_submit';
$route['user-dashboard']='user/service/user_dashboard';
$route['provider-dashboard']='user/service/provider_dashboard';
$route['user-settings']='user/dashboard/user_settings';
$route['user-wallet']='user/dashboard/user_wallet';
$route['user_wallet_submit'] = 'user/dashboard/user_wallet_submit';
$route['user-payment']='user/dashboard/user_payment';
$route['user-accountdetails']='user/dashboard/user_accountdetails';
$route['user-reviews']='user/dashboard/user_reviews';
$route['provider-reviews']='user/dashboard/provider_reviews';
$route['booking-details/(:any)']='user/service/booking_details/$1';
$route['provider_payment_wallet'] = 'user/dashboard/provider_payment_wallet';
$route['provider_wallet_submit'] = 'user/dashboard/provider_wallet_submit';
$route['provider_return'] = 'user/dashboard/get_provider_return';
$route['provider_notify'] = 'user/dashboard/provider_notify';
$route['booking-details-user/(:any)']='user/service/booking_details_user/$1';

$route['provider-bookings']='user/dashboard/provider_bookings';
$route['provider-settings']='user/dashboard/provider_settings';
$route['provider-wallet']='user/dashboard/provider_wallet';
$route['add-wallet']='user/dashboard/add_wallet';
$route['provider-payment']='user/dashboard/provider_payment';
$route['provider-subscription']='user/dashboard/provider_subscription';
$route['provider_subscription_submit'] = 'user/dashboard/provider_subscription_submit';
$route['zero_subscribe_plan/(:any)'] = 'user/dashboard/zero_subscribe_plan/$1';
$route['provider-availability']='user/dashboard/provider_availability';
$route['provider-accountdetails']='user/dashboard/provider_accountdetails';
$route['create_availability']='user/dashboard/create_availability';
$route['user-bookings']='user/dashboard/user_bookings';
$route['logout']='user/login/logout';

/*api*/

/*chat api*/

$route['user-chat'] = 'user/Chat_ctrl';
$route['user-chat/booking-new-chat']='user/Chat_ctrl/booking_new_chat';
$route['user-chat/insert_chat']='user/Chat_ctrl/insert_message';
$route['user-chat/get_user_chat_lists']='user/Chat_ctrl/get_user_chat_lists';

$route['api/country_details'] = 'api/api/country_details'; //Done
$route['api/all_chat_detail'] = 'api/api/all_chat_detail'; //Done
$route['api/chat_details'] = 'api/api/chat_details'; //Done
$route['api/sender_last_msg'] = 'api/api/sender_last_msg'; //Done
$route['api/receiver_last_msg'] = 'api/api/receiver_last_msg'; //Done
$route['api/conversation_info/(:num)'] = 'api/api/conversation_info/$1'; //Done


//$route['api/chat_details'] = 'api/api/chat_details_post';
$route['api/chat'] = 'api/api/chat'; // Done Only pass Token, receiver token and content
$route['api/chat_storage'] = 'api/api/insert_message'; // Done
$route['api/get-chat-list'] = 'api/api/get_chat_list';
$route['api/get-chat-history'] = 'api/api/get_chat_history';
$route['api/flash-device-token'] = 'api/api/flash_device_token';
$route['api/get-notification-list'] = 'api/api/get_notification_list';
$route['api/home'] = 'api/api/home'; // Done
$route['api/demo-home'] = 'api/api/demo_home'; //Done
$route['api/service-details'] = 'api/api/service_details'; // Done
$route['api/all-services'] = 'api/api/all_services';   //Done
$route['api/category'] = 'api/api/category';  //Done
$route['api/subcategory'] = 'api/api/subcategory'; //Done
$route['api/generate_otp_provider'] = 'api/api/generate_otp_provider'; // Done
$route['api/generate_otp_user'] = 'api/api/generate_otp_user'; // Done
$route['api/provider_signin'] = 'api/api/provider_signin'; // Done
$route['api/provider_add'] = 'api/api/provider_add';  // Done
$route['api/provider_edit'] = 'api/api/provider_edit';  // Done
$route['api/subcategory_services'] = 'api/api/subcategory_services'; // Done
$route['api/profile'] = 'api/api/profile'; // Done 
$route['api/subscription'] = 'api/api/subscription'; // Done
$route['api/subscription_success'] = 'api/api/subscription_success';// Done
$route['api/add_service'] = 'api/api/add_service'; //Done
$route['api/update_service'] = 'api/api/update_service'; // Done
$route['api/delete_service'] = 'api/api/delete_service'; // Done
$route['api/update_provider'] = 'api/api/update_provider'; //Done
$route['api/delete_provider'] = 'api/api/delete_provider';
$route['api/my_service'] = 'api/api/my_service'; // Done
$route['api/edit_service'] = 'api/api/edit_service'; // Done
$route['api/existing_user'] = 'api/api/existing_user'; // Done
$route['api/delete_serviceimage'] = 'api/api/delete_serviceimage'; // Done
$route['api/add_availability'] = 'api/api/add_availability'; // Done
$route['api/update_availability'] = 'api/api/update_availability'; // Done
$route['api/availability'] = 'api/api/availability'; // Done
$route['api/user_signin'] = 'api/api/user_signin'; // Done
$route['api/generate_userotp'] = 'api/api/generate_userotp'; // Done
$route['api/logout'] = 'api/api/logout'; // Done
$route['api/logout_provider'] = 'api/api/logout_provider'; // Done
$route['api/update_user'] = 'api/api/update_user'; // Done
$route['api/user_profile'] = 'api/api/user_profile'; // Done
$route['api/service_availability'] = 'api/api/service_availability'; // Done
$route['api/book_service_wallet'] = 'api/api/book_service_wallet'; // Done pass user token and all fields
$route['api/service_book'] = 'api/api/service_book';
$route['api/service_book_response'] = 'api/api/service_book_response';
$route['api/book_service_response'] = 'api/api/book_service_response';
$route['api/book_service_option'] = 'api/api/book_service_option';
$route['api/search_services'] = 'api/api/search_services'; // Done 
$route['api/bookingdetail'] = 'api/api/bookingdetail'; // Done
$route['api/bookinglist_provider'] = 'api/api/bookinglist_provider';
$route['api/requestlist_provider'] = 'api/api/requestlist_provider'; // Done
$route['api/bookinglist_users'] = 'api/api/bookinglist_users'; // Done
$route['api/bookingdetail_user'] = 'api/api/bookingdetail_user'; // Done
$route['api/views'] = 'api/api/views'; 
$route['api/update_bookingstatus'] = 'api/api/update_bookingstatus'; // Done
$route['api/service_statususer'] = 'api/api/service_statususer'; // Done
$route['api/bookinglist'] = 'api/api/bookinglist'; // Done
$route['api/get_services_from_subid'] = 'api/api/get_services_from_subid';#get services belongs to sub category id
$route['api/get_provider_dashboard_infos'] = 'api/api/get_provider_dashboard_infos';#get provider dashboar infos
$route['api/delete_account'] = 'api/api/delete_account'; // Done
$route['api/rate_review'] = 'api/api/rate_review'; // Done
$route['api/review_type'] = 'api/api/review_type'; // Done
$route['api/update_booking'] = 'api/api/update_booking'; // Done
$route['api/generate_otp_provider'] = 'api/api/generate_otp_provider'; //Done
$route['api/generate_otp_user'] = 'api/api/generate_otp_user'; //Done
$route['api/stripe_account_details'] = 'api/api/stripe_account_details'; // Done
$route['api/details'] = 'api/api/details';  // Done
$route['api/account_details'] = 'api/api/account_details'; // Done
$route['api/update-myservice-status'] = 'api/api/update_myservice_status';

$route['api/get-chat-history'] = 'api/api/get_chat_history'; // Done
$route['api/get-wallet'] = 'api/api/get_wallet_amt'; // Done
$route['api/add-user-wallet'] = 'api/api/add_user_wallet';
$route['api/add-provider-wallet'] = 'api/api/add_provider_wallet';
$route['api/withdraw-provider'] = 'api/api/provider_wallet_withdrawal';
$route['api/customer-card-list'] = 'api/api/get_customer_saved_card';
$route['api/wallet-history'] = 'api/api/wallet_history';
$route['api/stripe_details'] = 'api/api/stripe_details';
$route['api/provider-card-info'] = 'api/api/provider_card_info';
$route['api/select_plan_api'] = 'api/api/select_plan_api';
$route['api/select_plan_response_api'] = 'api/api/select_plan_response_api';
$route['api/addtowallet_api'] = 'api/api/addtowallet_api';
$route['api/addtowalletresponse_api'] = 'api/api/addtowalletresponse_api';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
