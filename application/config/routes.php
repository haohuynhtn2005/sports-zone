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
| example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
| http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
| $route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
| $route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
| $route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples: my-controller/index -> my_controller/index
|   my-controller/my-method -> my_controller/my_method
 */
$route['default_controller'] = "layout";
$route['404_override'] = 'errors/error404';
$route['translate_uri_dashes'] = FALSE;

/*
 * MODULES USERS
======================================================================================================
 */
$route['admin'] = 'layout/index_admin';
$route['admin/logout'] = 'users/logout';
$route['admin/db-backup'] = 'layout/db_backup';
/*
 * Kiểm tra tồn tại username, email tài khoản update (admin - ajax)
 */
$route['admin/users/check_current_username_availablity'] = 'users/check_current_username_availablity';
$route['admin/users/check_current_email_availablity'] = 'users/check_current_email_availablity';
$route['admin/users/check_current_identity_number_card_availablity'] = 'users/check_current_identity_number_card_availablity';
$route['admin/users/check_username_availablity'] = 'users/check_username_availablity';
$route['admin/users/check_email_availablity'] = 'users/check_email_availablity';
$route['admin/users/check_phone_availablity'] = 'users/check_phone_availablity';
$route['admin/users/check_identity_number_card_availablity'] = 'users/check_identity_number_card_availablity';
$route['admin/users/login-attempt-reset-ajax'] = 'users/ajax_login_attempt_reset';
$route['admin/users/active'] = 'users/active';
$route['admin/users'] = 'users/index';
$route['admin/users/(:num)'] = 'users/index/$1';
$route['admin/users/content'] = 'users/admin_content';
$route['admin/users/content/(:num)'] = 'users/admin_content/$1';
$route['admin/users/delete'] = 'users/admin_delete';
$route['admin/users/profile'] = 'users/admin_profile';
$route['admin/users/ref/setting/(:num)'] = "users/admin_ref_setting/$1";
$route['admin/users/qr/download'] = "users/download_qr";
$route['admin/login-by/(:num)'] = 'users/login_by/$1';

/*
 * USERS COMMISSION
======================================================================================================
 */
$route['admin/commission/change-status-ajax'] = "users/users_commission/ajax_change_status";
$route['admin/commission'] = "users/users_commission/admin_index";
$route['admin/commission/([0-9\-]+)'] = "users/users_commission/admin_index/$1";
$route['admin/commission/content'] = "users/users_commission/admin_content";
$route['admin/commission/delete'] = "users/users_commission/admin_delete";
$route['admin/commission/main'] = "users/users_commission/admin_main";

/*
 * MODULE BANKER
======================================================================================================
 */
$route['admin/banker'] = "banker/admin_index";
$route['admin/banker/([0-9\-]+)'] = "banker/admin_index/$1";
$route['admin/banker/content'] = "banker/admin_content";
$route['admin/banker/content/([0-9\-]+)'] = "banker/admin_content/$1";
$route['admin/banker/delete'] = "banker/admin_delete";
$route['admin/banker/main'] = "banker/admin_main";

/*
 * MODULE PROVINCES
======================================================================================================
 */
//provinces
$route['admin/provinces'] = "provinces/admin_index";
$route['admin/provinces/([0-9\-]+)'] = "provinces/admin_index/$1";
$route['admin/provinces/content'] = "provinces/admin_content";
$route['admin/provinces/content/([0-9\-]+)'] = "provinces/admin_content/$1";
$route['admin/provinces/delete'] = "provinces/admin_delete";
$route['admin/provinces/main'] = "provinces/admin_main";

//districts
$route['admin/provinces/districts'] = "provinces/districts/admin_index";
$route['admin/provinces/districts/([0-9\-]+)'] = "provinces/districts/admin_index/$1";
$route['admin/provinces/districts/content'] = "provinces/districts/admin_content";
$route['admin/provinces/districts/content/([0-9\-]+)'] = "provinces/districts/admin_content/$1";
$route['admin/provinces/districts/delete'] = "provinces/districts/admin_delete";
$route['admin/provinces/districts/main'] = "provinces/districts/admin_main";

//communes
$route['admin/provinces/communes'] = "provinces/communes/admin_index";
$route['admin/provinces/communes/([0-9\-]+)'] = "provinces/communes/admin_index/$1";
$route['admin/provinces/communes/content'] = "provinces/communes/admin_content";
$route['admin/provinces/communes/content/([0-9\-]+)'] = "provinces/communes/admin_content/$1";
$route['admin/provinces/communes/delete'] = "provinces/communes/admin_delete";
$route['admin/provinces/communes/main'] = "provinces/communes/admin_main";

/*
 * MODULES CONTACT
======================================================================================================
 */
$route['admin/contact'] = 'contact/admin_index';
$route['admin/contact/([0-9\-]+)'] = 'contact/admin_index/$1';
$route['admin/contact/view'] = 'contact/admin_view';
$route['admin/contact/delete'] = 'contact/admin_delete';
$route['admin/contact/main'] = 'contact/admin_main';

/*
 * MODULES POSTS
======================================================================================================
 */
$route['admin/posts/cat/check_alias_availablity'] = 'posts/postcat/check_alias_availablity';
$route['admin/posts/cat/change-field'] = 'posts/postcat/admin_ajax_change_field';
$route['admin/posts/change-field'] = 'posts/admin_ajax_change_field';
/*
 * Chủ đề
 */
$route['admin/posts/cat'] = "posts/postcat/admin_index";
$route['admin/posts/cat/content'] = "posts/postcat/admin_content";
$route['admin/posts/cat/content/([0-9\-]+)'] = "posts/postcat/admin_content/$1";
$route['admin/posts/cat/main'] = 'posts/postcat/admin_main';
$route['admin/posts/cat/delete/(:num)'] = 'posts/postcat/admin_delete/$1';

/*
 * Bài viết
 */
$route['admin/posts'] = 'posts/posts/index_admin';
$route['admin/posts/(:num)'] = 'posts/posts/index_admin/$1';
$route['admin/posts/content'] = 'posts/posts/admin_content';
$route['admin/posts/content/(:num)'] = 'posts/posts/admin_content/$1';
$route['admin/posts/delete'] = 'posts/posts/admin_delete';
$route['admin/posts/main'] = 'posts/posts/admin_main';

/*
 * MODULES PAGES (trang tĩnh)
======================================================================================================
 */
$route['admin/pages'] = 'pages/index_admin';
$route['admin/pages/([0-9\-]+)'] = 'pages/index_admin/$1';
$route['admin/pages/content'] = 'pages/admin_content';
$route['admin/pages/content/(:num)'] = 'pages/admin_content/$1';
$route['admin/pages/delete'] = "pages/admin_delete";
$route['admin/pages/main'] = 'pages/admin_main';

/*
 * MODULES CONFIGS
======================================================================================================
 */
$route['admin/settings'] = 'configs/index';
$route['admin/settings/main'] = 'configs/main';

/*
 * MODULES MENU
======================================================================================================
 */
$route['admin/menu'] = 'menu/admin_index';
$route['admin/menu/get_menu_position'] = 'menu/admin_get_menu_position';
$route['admin/menu/get_menu_type'] = 'menu/admin_get_menu_type';
$route['admin/menu/content'] = 'menu/admin_content';
$route['admin/menu/content/(:num)'] = 'menu/admin_content/$1';
$route['admin/menu/delete/(:num)'] = 'menu/admin_delete/$1';
$route['admin/menu/main'] = 'menu/admin_main';

/*
 * MODULES EMAILS
 ======================================================================================================
 */
$route['email/track'] = 'emails/emails_logs/site_track';
$route['admin/emails/ajax_get_code_tag'] = 'emails/ajax_get_code_tag';
$route['admin/emails'] = 'emails/emails_config/admin_config';
$route['admin/emails/repository/(:num)'] = 'emails/admin_repository/$1';
$route['admin/emails/repository'] = 'emails/admin_repository';
$route['admin/emails/logs/(:num)'] = 'emails/emails_logs/admin_index/$1';
$route['admin/emails/logs'] = 'emails/emails_logs/admin_index';
$route['admin/emails/sendmail'] = 'emails/admin_content_sendmail';
$route['admin/emails/sendmail/(:num)'] = 'emails/admin_content_sendmail/$1';

/*
 * EMAILS CONFIGS
======================================================================================================
 */
$route['admin/emails/configs/change-field'] = "emails/emails_configs/admin_ajax_change_field";
$route['admin/emails/configs/ajax-get'] = "emails/emails_configs/ajax_get";
$route['admin/emails/configs'] = "emails/emails_configs/admin_index";
$route['admin/emails/configs/([0-9\-]+)'] = "emails/emails_configs/admin_index/$1";
$route['admin/emails/configs/content'] = "emails/emails_configs/admin_content";
$route['admin/emails/configs/content/([0-9\-]+)'] = "emails/emails_configs/admin_content/$1";
$route['admin/emails/configs/delete'] = "emails/emails_configs/admin_delete";
$route['admin/emails/configs/main'] = "emails/emails_configs/admin_main";

/*
 * EMAILS CUSTOMERS
======================================================================================================
 */
$route['admin/emails/customers/check-phone-availablity'] = "emails/emails_customers/check_phone_availablity";
$route['admin/emails/customers'] = "emails/emails_customers/admin_index";
$route['admin/emails/customers/([0-9\-]+)'] = "emails/emails_customers/admin_index/$1";
$route['admin/emails/customers/content'] = "emails/emails_customers/admin_content";
$route['admin/emails/customers/content/([0-9\-]+)'] = "emails/emails_customers/admin_content/$1";
$route['admin/emails/customers/delete'] = "emails/emails_customers/admin_delete";
$route['admin/emails/customers/main'] = "emails/emails_customers/admin_main";

/*
 * EMAILS CUSTOMERS GROUP
======================================================================================================
 */
$route['admin/emails/customers/group/change-field'] = "emails/emails_customers_group/admin_ajax_change_field";
$route['admin/emails/customers/group/ajax-get'] = "emails/emails_customers_group/ajax_get";
$route['admin/emails/customers/group'] = "emails/emails_customers_group/admin_index";
$route['admin/emails/customers/group/([0-9\-]+)'] = "emails/emails_customers_group/admin_index/$1";
$route['admin/emails/customers/group/content'] = "emails/emails_customers_group/admin_content";
$route['admin/emails/customers/group/content/([0-9\-]+)'] = "emails/emails_customers_group/admin_content/$1";
$route['admin/emails/customers/group/delete'] = "emails/emails_customers_group/admin_delete";
$route['admin/emails/customers/group/main'] = "emails/emails_customers_group/admin_main";

/*
 * EMAILS TEMPLATE
======================================================================================================
 */
$route['admin/emails/template/ajax-get'] = "emails/emails_template/ajax_get";
$route['admin/emails/template'] = "emails/emails_template/admin_index";
$route['admin/emails/template/([0-9\-]+)'] = "emails/emails_template/admin_index/$1";
$route['admin/emails/template/content'] = "emails/emails_template/admin_content";
$route['admin/emails/template/content/([0-9\-]+)'] = "emails/emails_template/admin_content/$1";
$route['admin/emails/template/delete'] = "emails/emails_template/admin_delete";
$route['admin/emails/template/main'] = "emails/emails_template/admin_main";

/*
 * MODULES QUẢN LÝ ẢNH
======================================================================================================
 */
$route['admin/images/change-status'] = 'images/admin_ajax_change_status';
$route['admin/images/get-attribute-ajax'] = 'images/admin_get_attribute_ajax';
$route['admin/images'] = 'images/admin_index';
$route['admin/images/(:num)'] = 'images/admin_index/$1';
$route['admin/images/content'] = 'images/admin_content';
$route['admin/images/content/(:num)'] = 'images/admin_content/$1';
$route['admin/images/delete'] = 'images/admin_delete';
$route['admin/images/main'] = 'images/admin_main';

/*
 * MODULES INFO
======================================================================================================
 */
$route['admin/info/change-status'] = 'info/admin_ajax_change_status';
$route['admin/info/get-attribute-ajax'] = 'info/admin_get_attribute_ajax';
$route['admin/info'] = 'info/admin_index';
$route['admin/info/(:num)'] = 'info/admin_index/$1';
$route['admin/info/content'] = 'info/admin_content';
$route['admin/info/content/(:num)'] = 'info/admin_content/$1';
$route['admin/info/delete'] = 'info/admin_delete';
$route['admin/info/main'] = 'info/admin_main';

/*
 * MODULES CART
======================================================================================================
 */
//$route['products/ajax_get'] = 'package/ajax_get';
$route['products/ajax_get'] = 'shops/rows/ajax_get';
$route['users/ajax_get'] = 'users/ajax_get';
$route['admin/orders/confirm-ajax'] = 'shops/orders/admin_confirm_ajax';
$route['admin/orders/content-ajax'] = 'shops/orders/admin_content_ajax';
$route['admin/orders'] = "shops/orders/index";
$route['admin/orders/([0-9\-]+)'] = 'shops/orders/index/$1';
$route['admin/orders/content'] = 'shops/orders/admin_content';
$route['admin/orders/content/(:num)'] = 'shops/orders/admin_content/$1';
$route['admin/orders/view/([0-9\-]+)'] = 'shops/orders/admin_view/$1';
$route['admin/orders/delete/([0-9\-]+)'] = "shops/orders/delete/$1";

/*
 * Lọc sản phẩm
 */
$route['admin/shops/filter-get-ajax'] = "shops/filter/ajax_get";
$route['admin/shops/filter'] = "shops/filter/admin_index";
$route['admin/shops/filter/([0-9\-]+)'] = "shops/filter/admin_index/$1";
$route['admin/shops/filter/content'] = "shops/filter/admin_content";
$route['admin/shops/filter/content/([0-9\-]+)'] = "shops/filter/admin_content/$1";
$route['admin/shops/filter/delete'] = "shops/filter/admin_delete";
$route['admin/shops/filter/main'] = "shops/filter/admin_main";


/*
 * MODULES SHOPS
======================================================================================================
*/
$route['admin/shops/change-field'] = 'shops/rows/admin_ajax_change_field';
$route['admin/shops/upload-ajax'] = "shops/rows/ajax_upload";
$route['admin/shops/other/update-ajax'] = "shops/other/ajax_update";
$route['admin/shops/other/delete-ajax'] = "shops/other/ajax_delete";
/*
 * Thay đổi hiển thị loại sản phẩm trang chủ (admin - ajax)
 */
$route['admin/shops/cat/change-inhome'] = 'shops/cat/admin_ajax_change_inhome';
/*
 * Kiểm tra tồn tại mã sản phẩm (admin - ajax)
 */
$route['admin/shops/check_current_product_code_availablity'] = 'shops/rows/check_current_product_code_availablity';
$route['admin/shops/check_product_code_availablity'] = 'shops/rows/check_product_code_availablity';
/*
 * Kiểm tra tồn tại liên kết tĩnh loại sản phẩm (admin - ajax)
 */
$route['admin/shops/cat/check_current_alias_availablity'] = 'shops/cat/check_current_alias_availablity';
$route['admin/shops/cat/check_alias_availablity'] = 'shops/cat/check_alias_availablity';
$route['admin/shops/cat/check_alias_en_availablity'] = 'shops/cat/check_alias_en_availablity';

/*
 * Danh mục sản phẩm
 */
$route['admin/shops/cat/main'] = 'shops/cat/admin_main';
$route['admin/shops/cat/content'] = "shops/cat/admin_content";
$route['admin/shops/cat/content/([0-9\-]+)'] = 'shops/cat/admin_content/$1';
$route['admin/shops/cat'] = "shops/cat/admin_index";
$route['admin/shops/cat/delete/(:num)'] = 'shops/cat/admin_delete/$1';

$route['admin/shops/items'] = 'shops/rows/admin_index';
$route['admin/shops/items/([0-9\-]+)'] = 'shops/rows/admin_index/$1';
$route['admin/shops/content'] = 'shops/rows/admin_content'; //thêm
$route['admin/shops/content/(:num)'] = 'shops/rows/admin_content/$1';
$route['admin/shops/delete'] = "shops/rows/admin_delete";
$route['admin/shops/main'] = 'shops/rows/admin_main';
$route['admin/shops/config'] = 'shops/shops_config/admin_config';

/*
 * MODULES CUSTOMERS
======================================================================================================
 */
$route['admin/customers'] = "customers/admin_index";
$route['admin/customers/([0-9\-]+)'] = "customers/admin_index/$1";

/*
 * MODULE COMMENTS
 */
$route['admin/comments/change-verified-purchase'] = 'comments/admin_ajax_change_verified_purchase';
$route['admin/comments/change-status'] = 'comments/admin_ajax_change_status';
$route['admin/comments'] = 'comments/admin_index';
$route['admin/comments/([0-9\-]+)'] = 'comments/admin_index/$1';
$route['admin/comments/content/(:num)'] = 'comments/admin_content/$1'; //sửa
$route['admin/comments/reply/(:num)'] = 'comments/admin_reply/$1'; //tra loi
$route['admin/comments/delete/(:num)'] = "comments/admin_delete/$1"; //xóa
$route['admin/comments/main'] = 'comments/admin_main';

/*
 * MODULES NEWSLETTER
======================================================================================================
 */
$route['admin/newsletter'] = 'newsletter/admin_index';
$route['admin/newsletter/(:num)'] = 'newsletter/admin_index/$1';
$route['admin/newsletter/content'] = 'newsletter/admin_content';
$route['admin/newsletter/content/(:num)'] = 'newsletter/admin_content/$1';
$route['admin/newsletter/delete'] = 'newsletter/admin_delete';
$route['admin/newsletter/main'] = 'newsletter/admin_main';

/*
 * MODULES PACKAGE
======================================================================================================
 */
$route['admin/package'] = "package/admin_index";
$route['admin/package/([0-9\-]+)'] = "package/admin_index/$1";
$route['admin/package/content'] = "package/admin_content";
$route['admin/package/content/([0-9\-]+)'] = "package/admin_content/$1";
$route['admin/package/delete'] = "package/admin_delete";
$route['admin/package/main'] = "package/admin_main";

/*
 * MODULES PROJECTS
======================================================================================================
 */
$route['admin/projects'] = "projects/admin_index";
$route['admin/projects/([0-9\-]+)'] = "projects/admin_index/$1";
$route['admin/projects/content'] = "projects/admin_content";
$route['admin/projects/content/([0-9\-]+)'] = "projects/admin_content/$1";
$route['admin/projects/delete'] = "projects/admin_delete";
$route['admin/projects/main'] = "projects/admin_main";
$route['admin/projects/setting'] = "projects/admin_setting";

/*
 * MODULES SITEMAP
======================================================================================================
 */
$route['admin/sitemap-created-ajax'] = 'sitemap/ajax_created';
$route['admin/sitemap'] = 'sitemap/admin_index';

/*
 * SITE
======================================================================================================
 */
$route['newsletter'] = "newsletter/index";
$route['get-product-link-ajax'] = "shops/rows/get_link_share_ajax";
$route['gets-district-ajax'] = "provinces/districts/ajax_gets";
$route['gets-commune-ajax'] = "provinces/districts/ajax_get";

$route['users/check_username_availablity'] = "users/check_username_availablity";
$route['users/check_email_availablity'] = "users/check_email_availablity";
$route['users/check_phone_availablity'] = "users/check_phone_availablity";
$route['users/check_identity_number_card_availablity'] = "users/check_identity_number_card_availablity";
$route['users/get-new-OTP-ajax'] = "users/ajax_get_new_OTP";
$route['login-ajax'] = "users/site_login_ajax";
$route['register-ajax'] = "users/site_register_ajax";
$route['forget-password-ajax'] = "users/site_forget_password_ajax";
$route['xac-nhan-thanh-vien'] = "users/site_verify_email_address";
$route['dang-nhap'] = "users/site_login";
$route['dang-ky'] = "users/site_register";
$route['quen-mat-khau'] = "users/site_forget_password";
$route['dang-xuat'] = "users/logout";
$route['reset-mat-khau'] = "users/site_reset_password";
$route['trang-ca-nhan'] = "users/site_profile";
$route['doi-mat-khau'] = "users/site_changepass";

//comment, danh gia
$route['danh-gia-san-pham-ajax'] = "comments/index_ajax";

$route['shops/cart/add_cart_item'] = "shops/cart/site_add_cart_item";
$route['shops/cart/show_cart'] = "shops/cart/show_cart";

$route['gio-hang'] = "shops/orders/cart";
$route['cap-nhat-gio-hang'] = "shops/cart/site_update_cart";
$route['gio-hang-them-ajax'] = "shops/cart/site_add_cart_ajax";
$route['gio-hang-cap-nhat-ajax'] = "shops/cart/site_update_cart_ajax";
$route['gio-hang-xoa-san-pham-ajax'] = "shops/cart/site_remove_cart_item_ajax";
$route['xoa-gio-hang'] = "shops/cart/site_remove_cart";
$route['xoa-san-pham-gio-hang'] = "shops/cart/site_remove_cart_item";

$route['thanh-toan'] = "shops/checkout/site_index";
$route['ket-qua-thanh-toan/(:num)'] = "shops/orders/site_order_success/$1";

$route["danh-muc-san-pham/(:any)/(:num)"] = "shops/rows/site_items_in_listcatid/$1/$2";
$route["danh-muc-san-pham/(:any)"] = "shops/rows/site_items_in_listcatid/$1";

$route["loai-san-pham/(:any)/(:num)"] = "shops/rows/site_items_in_provider_id/$1/$2";
$route["loai-san-pham/(:any)"] = "shops/rows/site_items_in_provider_id/$1";

$route["san-pham/(:any)/(:any)"] = "shops/rows/site_details/$1/$2";
$route["san-pham/(:num)"] = "shops/rows/index/$1";
$route["san-pham"] = "shops/rows/index";

$route["du-an/(:any)"] = "projects/site_details/$1";
$route["du-an/(:num)"] = "projects/index/$1";
$route["du-an"] = "projects/index";

$route["thuong-hieu/(:any)"] = "shops/filter/site_details/$1";
$route["thuong-hieu/(:any)/(:any)"] = "shops/filter/site_details/$1/$2";

$route["chia-se-san-pham/(:num)"] = "shops/rows/site_link_share/$1";
$route["chia-se-san-pham"] = "shops/rows/site_link_share";

$route["rut-tien"] = "shops/rows/site_withdrawal";
$route["rut-tien/lich-su/(:num)"] = "users/users_commission/site_withdrawal_history/$1";
$route["rut-tien/lich-su"] = "users/users_commission/site_withdrawal_history";

$route["hoa-hong"] = "users/users_commission/site_commission";
$route["hoa-hong/lich-su/(:num)"] = "users/users_commission/site_commission_history/$1";
$route["hoa-hong/lich-su"] = "users/users_commission/site_commission_history";

$route["lich-su-mua-hang/(:num)"] = "users/users_commission/site_buy/$1";
$route["lich-su-mua-hang"] = "users/users_commission/site_buy";

$route['get-address-cost-ajax'] = "users/users_address/ajax_get_cost";
$route['get-address-ajax'] = "users/users_address/ajax_get";
$route['content-address-ajax'] = "users/users_address/ajax_content";
$route['create-address-ajax'] = "users/users_address/ajax_create";
$route['delete-address-ajax'] = "users/users_address/ajax_delete";
$route['so-dia-chi'] = "users/users_address/site_address";
$route['mac-dinh-dia-chi-giao-hang/(:num)'] = "users/users_address/site_address_set_is_default/$1";

$route['search'] = "search/index";
$route['search/(:num)'] = "search/index/$1";

$route["tin-tuc"] = "posts/index";
$route["tin-tuc/([0-9\-]+)"] = "posts/index/$1";

$route["danh-muc-bai-viet/(:any)/(:num)"] = "posts/site_items_in_cat/$1/$2";
$route["danh-muc-bai-viet/(:any)"] = "posts/site_items_in_cat/$1";

$route["lien-he"] = "contact/contact/index";

$route["(:any)/(:any)"] = "posts/site_details/$1";
$route["(:any)"] = "pages/site_details/$1";