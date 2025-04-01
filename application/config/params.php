<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

$config['facebook'] = array(
    'app_id' => '124350198151002',
    'app_secret' => '5aa3c4ceea848e3a9bc9bec1d41525a0',
);
$config['site_per_page'] = array(
    'posts' => 12,
);
$config['admin_list'] = array(
    'item' => 10,
    'total' => 100,
);
$config['num_links'] = 9;
$config['ledu_user_id'] = 'ledu_user_id';
/*
$config['sms'] = array(
    'api_key' => 'F26C86EDB6D67F6E847FDF5C2A3698',
    'secret_key' => '9463FD47461066669D2C6F4C62FF92',
    'expired' => 120,
);
*/
$config['toolbar'] = array(
    'full' => array(
        array('Source', 'Undo', 'Redo', '-', 'Find', 'Replace', '-', 'SelectAll', 'RemoveFormat'),
        array('Bold', 'Italic', 'Underline', 'Strike', '-', 'Subscript', 'Superscript'),
        array('NumberedList', 'BulletedList', '-', 'Outdent', 'Indent'),
        array('JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'),
        array('Link', 'Unlink'),
        array('Image', 'Table', 'HorizontalRule'),
        array('Styles', 'Format', 'Font', 'FontSize'),
        array('TextColor', 'BGColor'),
    ),
    'mini' => array(
        array('Bold', 'Italic', 'Underline', 'Strike'),
        array('Link', 'Unlink'),
        array('Styles', 'Format', 'Font', 'FontSize'),
        array('TextColor', 'BGColor'),
    ),
);
$config['transaction_status'] = array(
    '-1' => 'Đã hủy',
    '0' => 'Chưa thanh toán',
    '1' => 'Đã thanh toán',
);
$config['per_page'] = 9;
$config['gender'] = array(
    'default' => 'N',
    'data' => array(
        "N" => "N/A",
        "M" => "Nam",
        "F" => "Nữ",
    ),
);
$config['oauth_provider'] = array(
    'system' => 'Hệ thống',
    'google' => 'Google',
    'facebook' => 'Facebook',
);
$config['delivery_method'] = array(
    '1' => 'Giao tận nhà',
    '2' => 'Khách nhận hàng tại công ty',
);
/*
$config['forms_of_payment'] = array(
'1' => 'Thanh toán tiền mặt',
'2' => 'Chuyển khoản',
);
 */
$config['forms_of_payment'] = array(
    // 'cod' => array(
    //  'title' => 'Thanh toán tiền mặt khi nhận hàng',
    //  'info' => 'Thanh toán trực tiếp cho người vận chuyển, ngay sau khi nhận được hàng',
    // ),
    // 'bacs' => array(
    //  'title' => 'Chuyển khoản ngân hàng',
    //  'info' => 'Số tài khoản: 19135781619012 <br>TRƯƠNG HUỲNH NGỌC ANH <br>
    //          Ngân hàng: Techcombank - Chi nhánh HCM <br> Nội dung: Mã Đơn hàng.... hoặc username'
    // ),
    // 'cheque' => array(
    //  'title' => 'Thanh toán tại cửa hàng',
    //  'info' => 'Địa chỉ: 145/3E Tô ký, P.Tân Chánh Hiệp, Q.12',
    // ),
);
$config['email_type'] = array(
    'post' => 'Tin tức',
    'page' => 'Trang tĩnh',
    'contact' => 'Liên hệ',
);
$config['images_modules'] = array(
    'slideshow' => 'Slide show',
    'about_us' => 'Về chúng tôi',
    'partner' => 'Đối tác tiêu biểu',
    'background_service' => 'Hình nền lĩnh vực hoạt động',
);
$config['info_modules'] = array(
    'hotline' => 'Hotline',
    'why_choose_us' => 'Tại sao lại chọn chúng tôi',
    'customer_experience' => 'Cảm nhận khách hàng',
    'collaboration' => 'Quy trình hợp tác',
    'projects_has_been_constructed' => 'Dự án đã thi công',
    'slogun' => 'Slogun khách hàng',
    'address' => 'Thông tin trang liên hệ',
    // 'copyright' => 'Copyright',
    'infomation' => 'Thông tin cuối trang',
);
$config['why_choose_us_icon'] = array(
    'icon-layers ',
    'icon-people ',
    'icon-wrench ',
    'icon-screen-desktop ',
    'icon-trophy ',
    'icon-badge ',
);
$config['menu_modules'] = array(
    'Main' => 'Menu chính',
    'Bottom' => 'Menu chính sách',
    'Left' => 'Menu chăm sóc khách hàng',
    'Right' => 'Menu tuyển dụng',
);
$config['menu_modules_display'] = array(
    'dropdown' => 'Mặc định',
    'mega' => 'Mega',
);
$config['search_price'] = array(
    '0-1000000' => 'Dưới 1 triệu',
    '1000000-2000000' => 'Từ 1 - 2 triệu',
    '2000000-3000000' => 'Từ 2 - 3 triệu',
    '3000000-4000000' => 'Từ 3 - 4 triệu',
    '4000000-5000000' => 'Từ 4 - 5 triệu',
    '5000000-10000000' => 'Từ 5 - 10 triệu',
    '10000000-0' => 'Trên 10 triệu'
);
$config['filter_shops'] = array(
    'sort' => array(
        'default' => 'Mặc định',
        'title_ascending' => 'Tên từ A &rarr; Z',
        'title_descending' => 'Tên từ Z &rarr; A',
        'price_ascending' => 'Giá thấp &rarr; cao',
        'price_descending' => 'Giá cao &rarr; thấp',
        'created_descending' => 'Sản phẩm cũ nhất',
        'created_ascending' => 'Sản phẩm mới nhất',
    ),
);
$config['stock_status'] = array(
    'instock' => 'Còn hàng',
    'outofstock' => 'Hết hàng',
    'onbackorder' => 'Chờ hàng'
);
$config['stock_status_display'] = array(
    'instock' => '<span class="instock">Còn hàng</span>',
    'outofstock' => '<span class="outofstock">Hết hàng</span>',
    'onbackorder' => '<span class="onbackorder">Chờ hàng</span>'
);
$config['role'] = array(
    'MEMBER' => 'Thành viên',
    'ADMIN' => 'Admin',
);
$config['role_label'] = array(
    'MEMBER' => 'default',
    'ADMIN' => 'danger',
);
$config['users_modules_commission'] = array(
    'SUB_BUY' => 'Nhận hoa hồng bán sản phẩm',
    'WITHDRAWAL' => 'Rút tiền',
);
$config['users_modules_commission_label'] = array(
    'SUB_BUY' => 'success',
    'WITHDRAWAL' => 'danger',
);
$config['meta_seo'] = array(
    'title_seo' => 60,
    'keywords' => 160,
    'description' => 155,
    'h1_seo' => 60,
);
$config['email_variables_label'] = array(
    'full_name' => 'Tên khách hàng',
    'address' => 'Địa chỉ'
);

$config['email_variables_name'] = array(
    'full_name' => '{full_name}',
    'address' => '{address}'
);

$config['email_status'] = array(
    '0' => 'Lưu nháp',
    '1' => 'Đã gửi',
);

$config['email_status_label'] = array(
    '0' => 'danger',
    '1' => 'success',
);

$config['email_send_status'] = array(
    '0' => 'Chưa gửi',
    '1' => 'Đã gửi',
    '2' => 'Đã xem',
);

$config['email_send_status_label'] = array(
    '0' => 'danger',
    '1' => 'primary',
    '2' => 'success',
);

$config['postcat_type'] = array(
    'SERVICE' => 'Dịch vụ',
    'QUOTATION' => 'Bảng giá',
    'NEWS' => 'Tin tức',
);