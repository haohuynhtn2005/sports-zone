<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Layout extends MX_Controller {
    protected $_data = array();
    protected $_status = '';
    protected $_message = '';
    protected $_message_success = '';
    protected $_message_warning = '';
    protected $_message_danger = 'Rất tiếc! Có lỗi kỹ thuật!';
    protected $_message_banned = 'Không có quyền truy cập vào khu vực này!';
    protected $_breadcrumbs = array();
    protected $_breadcrumbs_admin = array();
    protected $_add_css = array();
    protected $_add_js = array();
    protected $_plugins_css = array();
    protected $_plugins_script = array();
    protected $_plugins_css_admin = array();
    protected $_plugins_script_admin = array();
    protected $_modules_css = array();
    protected $_modules_script = array();

    function __construct() {
        parent::__construct();
    }

    public function _initialize_global($configs) {
        $this->config->set_item('url_posts_cat', modules::run('menu/menu_type/get_values_type', 'post_categories'));
        $this->config->set_item('url_posts_rows', modules::run('menu/menu_type/get_values_type', 'posts'));
        $this->config->set_item('url_contact', modules::run('menu/menu_type/get_values_type', 'contact'));
        $this->config->set_item('url_projects', modules::run('menu/menu_type/get_values_type', 'projects'));

        $parse = parse_url(base_url());
        $this->_data['host'] = $parse['host'];

        $this->_data['site_name'] = $configs['site_name'];
        $this->_data['title'] = $configs['site_name'];
        $this->_data['title_seo'] = $configs['title_seo'];
        $this->_data['other_seo'] = $configs['other_seo'];
        $this->_data['h1_seo'] = $configs['h1_seo'];
        $this->_data['h2_seo'] = $configs['h2_seo'];
        $this->_data['description'] = $configs['site_description'];
        $this->_data['keywords'] = $configs['site_keywords'];
        $this->_data['site_icon'] = $configs['site_icon'];
        $this->_data['email'] = $configs['site_email'];
        // $forms_of_payment = array();
        // $forms_of_payment['cod'] = @unserialize($configs['cod']);
        // $forms_of_payment['bacs'] = @unserialize($configs['bacs']);
        // $this->config->set_item('forms_of_payment', $forms_of_payment);
        // $this->_initialize_user();
    }

    public function _initialize_user() {
        $this->_data['logged_in'] = FALSE;
        if ($this->session->has_userdata('logged_in')) {
            $this->_data['logged_in'] = TRUE;
            $session_data = $this->session->userdata('logged_in');
            $this->_data['userid'] = $session_data['userid'];
            $this->_data['username'] = $session_data['username'];
            $this->_data['full_name'] = $session_data['full_name'];
            $this->_data['photo'] = $session_data['photo'];
            $this->_data['role'] = isset($session_data['role']) ? $session_data['role'] : '';
            $this->_data['created'] = isset($session_data['created']) ? $session_data['created'] : '';
        }
        if ($this->session->has_userdata('logged_in_by')) {
            $this->_data['logged_in'] = TRUE;
            $session_data = $this->session->userdata('logged_in_by');
            $this->_data['userid'] = $session_data['userid'];
            $this->_data['username'] = $session_data['username'];
            $this->_data['full_name'] = $session_data['full_name'];
            $this->_data['photo'] = $session_data['photo'];
            $this->_data['role'] = isset($session_data['role']) ? $session_data['role'] : '';
            $this->_data['created'] = isset($session_data['created']) ? $session_data['created'] : '';
        }
    }

    public function _initialize() {
        $configs = $this->get_configs();
        $this->_initialize_global($configs);

        // $shops_cat = modules::run('shops/cat/gets');
        // $this->_data['shops_cat_list'] = $shops_cat['data_list']; //mang chua quan he cha con
        // $this->_data['shops_cat_data'] = $shops_cat['data_input']; // mang chua du lieu tat ca cat (có link)
        // $this->_data['shops_cat_input'] = $shops_cat['data_input']; // mang chua du lieu tat ca cat (không link chi co gia tri va ten de dung cho input)

        $this->_data['postcat_list'] = modules::run('posts/postcat/get_menu_list');
        $this->_data['postcat_data'] = modules::run('posts/postcat/get_data');
        $this->_data['postcat_input'] = modules::run('posts/postcat/get_input');

        $main = 'Main';
        $this->_data['menu_main_list'] = modules::run('menu/get_menu_list', $main);
        $this->_data['menu_main_data'] = modules::run('menu/get_data', $main);
        $this->_data['menu_main_input'] = modules::run('menu/get_input', $main);

        // $bottom = 'Bottom';
        // $this->_data['menu_bottom_list'] = modules::run('menu/get_menu_list', $bottom);
        // $this->_data['menu_bottom_data'] = modules::run('menu/get_data', $bottom);
        // $this->_data['menu_bottom_input'] = modules::run('menu/get_input', $bottom);

        // $left = 'Left';
        // $this->_data['menu_left_list'] = modules::run('menu/get_menu_list', $left);
        // $this->_data['menu_left_data'] = modules::run('menu/get_data', $left);
        // $this->_data['menu_left_input'] = modules::run('menu/get_input', $left);

        // $right = 'Right';
        // $this->_data['menu_right_list'] = modules::run('menu/get_menu_list', $right);
        // $this->_data['menu_right_data'] = modules::run('menu/get_data', $right);
        // $this->_data['menu_right_input'] = modules::run('menu/get_input', $right);

        $this->_breadcrumbs[] = array(
            'url' => base_url(),
            'name' => 'Trang chủ',
        );
        $this->set_breadcrumbs();

        $this->_data['image'] = base_url(get_module_path('logo') . $configs['site_logo']);
        $this->_data['analytics_UA_code'] = $configs['analytics_UA_code'];
        $this->_data['display_copyright_developer'] = $configs['display_copyright_developer'];

        $this->_data['site_hotline'] = $configs['site_hotline'];
        $this->_data['site_address'] = $configs['site_address'];
        $this->_data['site_phone'] = $configs['site_phone'];

        $this->_data['favicon'] = $configs['favicon'];
        $this->_data['site_logo'] = $configs['site_logo'];
        $this->_data['site_logo_footer'] = base_url(get_module_path('logo') . $configs['site_logo_footer']);

        $this->_data['fb_page'] = $configs['fb_page'];
        $this->_data['iframe_map'] = $configs['iframe_map'];
        $this->_data['site_content_contact'] = $configs['site_content_contact'];
        $this->_data['iframe_video'] = $configs['iframe_video'];

        $this->_data['facebook_fanpage'] = $configs['facebook_fanpage'];
        $this->_data['google_plus'] = $configs['google_plus'];
        $this->_data['instagram_page'] = $configs['instagram_page'];
        $this->_data['youtube_page'] = $configs['youtube_page'];
        $this->_data['twitter_page'] = $configs['twitter_page'];
        $this->_data['skype_page'] = $configs['skype_page'];
        $this->_data['linkedin_page'] = $configs['linkedin_page'];

        $this->_load_menu_main();
        // $this->_load_category_product();
        // $this->_load_category_search();

        //search
        $this->_data['q'] = $this->input->get('q');

        $this->_modules_script[] = array(
            'folder' => 'newsletter',
            'name' => 'newsletter',
        );

        //hotline
        $info_hotline_none = modules::run('info/get_by_type', 'hotline', TRUE);
        $this->_data['info_hotline_none'] = $info_hotline_none;

        //slogun
        $info_slogun_none = modules::run('info/get_by_type', 'slogun', TRUE);
        $this->_data['info_slogun_none'] = $info_slogun_none;

        //address
        $info_address_none = modules::run('info/get_by_type', 'address', TRUE);
        $this->_data['info_address_none'] = $info_address_none;

        //copyright
        $info_copyright_none = modules::run('info/get_by_type', 'copyright', TRUE);
        $this->_data['info_copyright_none'] = $info_copyright_none;

        //infomation
        $info_infomation_none = modules::run('info/get_by_type', 'infomation', TRUE);
        $this->_data['info_infomation_none'] = $info_infomation_none;

        // //breadcrumb
        // $breadcrumb_none = modules::run('images/get_by_type', 'breadcrumb', TRUE);
        // $this->_data['breadcrumb_none'] = $breadcrumb_none;

        //partner
        $partner_none = modules::run('images/get_by_type', 'partner');
        $this->_data['partner_none'] = $partner_none;

        // if (!is_home()) {

        // }

        //set all css, js, plugins
        $this->add_css();
        $this->add_js();
        $this->set_plugins();
        $this->set_modules();
    }

    public function _initialize_admin() {
        $configs = $this->get_configs();
        $this->_initialize_global($configs);
        $this->_initialize_user();

        $this->_data['breadcrumbs_module_name'] = '';
        $this->_data['breadcrumbs_module_func'] = '';

        $this->_breadcrumbs_admin[] = array(
            'url' => '',
            'name' => '<i class="fa fa-dashboard"></i> Admin',
        );
        $this->set_breadcrumbs_admin();

        $this->_plugins_css_admin[] = array(
            'folder' => 'iCheck',
            'name' => 'all',
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'iCheck',
            'name' => 'icheck',
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'iCheck',
            'name' => 'app.icheck',
        );
        //set all css, js, plugins
        $this->set_plugins_admin();
        $this->set_modules();

        $this->_data['num_rows_contact'] = modules::run('contact/num_rows_new');
        $this->_data['num_rows_order'] = modules::run('shops/orders/counts', array('viewed' => 0));

        $this->_data['menu_admin_active'] = ($this->uri->segment(2) == '') ? '' : $this->uri->segment(2);
    }

    public function _load_category_product($parent = 0, $current_page = '') {
        if (trim($current_page) == '') {
            $current_page = current_url();
        }
        $data_category_product = modules::run('shops/cat/gets_data', array('parent' => $parent));
        $html_category_product = '';
        if (is_array($data_category_product) && !empty($data_category_product)) {
            $id = 0;
            foreach ($data_category_product as $key => $value) {
                $id++;
                $is_second = FALSE;
                $data_category_product_1 = modules::run('shops/cat/gets_data', array('parent' => $key));
                if (is_array($data_category_product_1) && !empty($data_category_product_1)) {
                    $is_second = TRUE;
                }
                $html_category_product .= '<li>';
                $html_category_product .= '<h3 class="title" data-toggle="collapse" href="#list-' . $id . '"><a href="' . $value['lurl'] . '">' . $value['lname'] . '</a><span class="plus--icon"><i class="fas fa-plus"></i></span></h3>';
                if ($is_second) {
                    $html_category_product .= '<ul id="list-' . $id . '" class="collapse" data-parent=".block-list-categories--content">';
                    foreach ($data_category_product_1 as $key1 => $value1) {
                        $html_category_product .= '<li><a href="' . $value1['lurl'] . '">' . $value1['lname'] . '</a></li>';
                    }
                    $html_category_product .= '</ul>';
                }
                $html_category_product .= "</li>";
            }
        }
        $this->_data['html_category_product'] = $html_category_product;
    }

    public function _load_category_search() {
        $search_param = 'all';
        $get = $this->input->get();
        if (isset($get['search_param']) && $get['search_param'] != 'all') {
            $search_param = $get['search_param'];
        }
        $data_category_search = modules::run('shops/cat/gets_data', array('parent' => 0));
        $html_category_search = '';
        if (is_array($data_category_search) && !empty($data_category_search)) {
            foreach ($data_category_search as $key => $value) {
                $html_category_search .= '<a href="#' . $value['lid'] . '" class="dropdown-item">' . $value['lname'] . '</a>';
            }
        }
        $this->_data['html_category_search'] = $html_category_search;
    }

    function _load_menu_main() {
        $main = 'Main';
        $data_menu_main = modules::run('menu/gets', $main, 0);
        $html_menu_main = '';
        if (is_array($data_menu_main) && !empty($data_menu_main)) {
            foreach ($data_menu_main as $key => $value) {
                $is_second = FALSE;
                $data_menu_main_1 = modules::run('menu/gets', $main, $key);
                if (is_array($data_menu_main_1) && !empty($data_menu_main_1)) {
                    $is_second = TRUE;
                }
                // <li class="dropdown"><a href="#"><span>Giải đấu</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                $html_menu_main .= 
                    "<li" . ($is_second ? ' class="dropdown"' : '') . ">" .
                        "<a" . ($value['lurl'] == current_url() ? '' : ' class="stay"') . " href=\"" . $value['lurl'] . "\">" . $value['lname']
                            . ($is_second ? '<i class="bi bi-chevron-down toggle-dropdown"></i>' : '')
                        . "</a>";
                if ($is_second) {
                    $html_menu_main .= '<ul class="dropdown-menu to-right">';
                    foreach ($data_menu_main_1 as $key1 => $value1) {
                        $html_menu_main .= '<li><a href="' . $value1['lurl'] . '" class="stay">' . $value1['lname'] . '</a></li>';
                    }
                    $html_menu_main .= '</ul>';
                }
                $html_menu_main .= "</li>";
            }
        }
        $this->_data['html_menu_main'] = $html_menu_main;
    }

    function _init_fancybox() {
        $this->_plugins_css_admin[] = array(
            'folder' => 'fancy-box/source',
            'name' => 'jquery.fancybox',
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'fancy-box/source',
            'name' => 'jquery.fancybox',
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'fancy-box/source',
            'name' => 'jquery.fancybox.pack',
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'fancy-box/lib',
            'name' => 'jquery.mousewheel-3.0.6.pack',
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'fancy-box',
            'name' => 'jquery-apps',
        );
        $this->set_plugins_admin();
    }

    function index_admin() {
        $this->load->module('users');
        $this->users->admin_index();
    }

    protected function set_breadcrumbs() {
        $this->_data['breadcrumbs'] = $this->_breadcrumbs;
    }

    protected function set_breadcrumbs_admin() {
        $this->_data['breadcrumbs_admin'] = $this->_breadcrumbs_admin;
    }

    protected function set_plugins() {
        $this->_data['plugins_css'] = $this->_plugins_css;
        $this->_data['plugins_script'] = $this->_plugins_script;
    }

    protected function set_plugins_admin() {
        $this->_data['plugins_css_admin'] = $this->_plugins_css_admin;
        $this->_data['plugins_script_admin'] = $this->_plugins_script_admin;
    }

    protected function set_modules() {
        $this->_data['modules_css'] = $this->_modules_css;
        $this->_data['modules_script'] = $this->_modules_script;
    }

    protected function add_css() {
        $this->_data['add_css'] = $this->_add_css;
    }

    protected function add_js() {
        $this->_data['add_js'] = $this->_add_js;
    }

    protected function get_configs() {
        $configs = $this->M_configs->get_configs();
        return $this->set_configs($configs);
    }

    private function set_configs($data) {
        $configs = array();
        if (is_array($data) && !empty($data)) {
            foreach ($data as $value) {
                $configs[$value['config_name']] = $value['config_value'];
            }
        }
        return $configs;
    }

    function index() {
        $this->_initialize();

        //slideshow none
        $slideshow_none = modules::run('images/get_by_type', 'slideshow');
        $this->_data['slideshow_none'] = $slideshow_none;

        //about_us
        $about_us_none = modules::run('images/get_by_type', 'about_us', TRUE);
        $this->_data['about_us_none'] = $about_us_none;

        //why_choose_us
        $info_why_choose_us_none = modules::run('info/get_by_type', 'why_choose_us', TRUE);
        $this->_data['info_why_choose_us_none'] = $info_why_choose_us_none;

        //customer_experience
        $info_customer_experience_none = modules::run('info/get_by_type', 'customer_experience');
        $this->_data['info_customer_experience_none'] = $info_customer_experience_none;

        //collaboration
        $info_collaboration_none = modules::run('info/get_by_type', 'collaboration', TRUE);
        $this->_data['info_collaboration_none'] = $info_collaboration_none;

        //posts service
        $posts_service = modules::run('posts/get_items_cat_type', 'service', 0);
        $partial = array();
        $partial['data'] = $posts_service;
        //background_service
        $background_service_none = modules::run('images/get_by_type', 'background_service', TRUE);
        $partial['background_service_none'] = $background_service_none;
        $this->_data['posts_service'] = $this->load->view('layout/site/partial/post_service', $partial, true);

        //projects_has_been_constructed
        $projects_has_been_constructed = modules::run('projects/gets', array('inhome' => 1));
        $partial = array();
        $partial['data'] = $projects_has_been_constructed;
        //projects_has_been_constructed
        $info_projects_has_been_constructed_none = modules::run('info/get_by_type', 'projects_has_been_constructed', TRUE);
        $partial['info_projects_has_been_constructed_none'] = $info_projects_has_been_constructed_none;
        $this->_data['projects_has_been_constructed'] = $this->load->view('layout/site/partial/project_has_been_constructed', $partial, true);

        //posts news
        $posts_news = modules::run('posts/get_items_cat_type', 'news', 0);
        $partial = array();
        $partial['data'] = $posts_news;
        $this->_data['posts_news'] = $this->load->view('layout/site/partial/post_news', $partial, true);

        $this->_data['main_content'] = 'layout/site/pages/main';
        $this->load->view('site/layout', $this->_data);
    }

    protected function logged_in() {
        if ($this->session->userdata('logged_in')) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    protected function redirect_register() {
        if (!$this->logged_in()) {
            redirect(site_url('register'));
        }
    }

    protected function redirect_login() {
        if (!$this->logged_in()) {
            redirect(site_url('login'));
        }
    }

    protected function redirect_admin() {
        if (!$this->session->userdata('logged_in')) {
            redirect(get_admin_url() . '?redirect_page=' . base64_encode(current_full_url()));
        } else {
            $access_role = $this->access_role();
            if ($access_role < 4) {
                redirect(base_url());
            }
        }
    }

    protected function access_role() {
        $this->load->model('users/m_groups_users', 'M_groups_users');
        $userid = isset($this->_data['userid']) ? $this->_data['userid'] : 0;
        $result = $this->M_groups_users->get_group_id($userid);
        return isset($result['group_id']) ? (int) $result['group_id'] : 2;
    }

    protected function set_notify($notify_type, $notify_content) {
        //set notify
        $sess_array = array(
            'notify_type' => $notify_type,
            'notify_content' => $notify_content,
        );
        $this->session->set_userdata('notify_current', $sess_array);
    }

    protected function set_notify_admin($notify_type, $notify_content) {
        //set notify
        $sess_array = array(
            'notify_type' => $notify_type,
            'notify_content' => $notify_content,
        );
        $this->session->set_userdata('notify_current_admin', $sess_array);
    }

    protected function set_message_success() {
        $sess_array = array(
            'notify_type' => 'success',
            'notify_content' => $this->_message_success,
        );
        $this->session->set_userdata('notify_current_admin', $sess_array);
    }

    protected function set_message_warning() {
        $sess_array = array(
            'notify_type' => 'warning',
            'notify_content' => $this->_message_warning,
        );
        $this->session->set_userdata('notify_current_admin', $sess_array);
    }

    protected function set_message_danger() {
        $sess_array = array(
            'notify_type' => 'danger',
            'notify_content' => $this->_message_danger,
        );
        $this->session->set_userdata('notify_current_admin', $sess_array);
    }

    protected function set_message_banned() {
        $sess_array = array(
            'notify_type' => 'danger',
            'notify_content' => $this->_message_banned,
        );
        $this->session->set_userdata('notify_current_admin', $sess_array);
    }

    protected function set_json_encode() {
        $this->_data['json_encode'] = array(
            'status' => $this->_status,
            'message' => $this->_message,
        );
    }

    function get_alias() {
        $str = $this->input->post('title');
        $this->_data['str'] = $str;
        $this->load->view('layout/admin/view_alias', $this->_data);
    }

    protected function show_message() {
        $this->_data['box'] = array(
            'status' => $this->input->post('status'),
            'message' => $this->input->post('message'),
        );
        $this->load->view('layout/message', $this->_data);
    }

    function load_language() {
        $this->lang->load('admin', $this->language);
        $this->lang->load('site', $this->language);
    }

    function set_current_url($url) {
        $this->session->set_userdata('url', base64_encode($url));
    }

    function redirect_after() {
        if ($this->session->userdata('url')) {
            $url = base64_decode($this->session->userdata('url'));
            $this->session->unset_userdata('url');
        } else {
            $url = base_url();
        }
        redirect($url);
    }
    function db_backup() {
        //date_default_timezone_set('Asia/Calcutta');
        // Load the DB utility class
        $this->load->dbutil();
        $prefs = array(
            'format' => 'zip', // gzip, zip, txt
            'filename' => 'backup_' . date('d_m_Y_H_i_s') . '.sql',
            // File name - NEEDED ONLY WITH ZIP FILES
            'add_drop' => TRUE,
            // Whether to add DROP TABLE statements to backup file
            'add_insert' => TRUE,
            // Whether to add INSERT data to backup file
            'newline' => "\n",
            // Newline character used in backup file
        );
        // Backup your entire database and assign it to a variable
        $backup = &$this->dbutil->backup($prefs);
        // Load the file helper and write the file to your server
        $this->load->helper('file');
        write_file('./uploads/' . 'dbbackup_' . date('d_m_Y_H_i_s') . '.zip', $backup);
        // Load the download helper and send the file to your desktop
        $this->load->helper('download');
        force_download('dbbackup_' . date('d_m_Y_H_i_s') . '.zip', $backup);
    }
}
/* End of file Layout.php */
/* Location: ./application/modules/layout/controllers/Layout.php */