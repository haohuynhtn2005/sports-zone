<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

include_once APPPATH . '/modules/layout/controllers/Layout.php';

class Dashboard extends Layout {

    function __construct() {
        parent::__construct();
        $this->_data['breadcrumbs_module_name'] = 'Bảng điều khiển';
    }

    function index() {
		$this->_initialize_admin();
        $this->_data['num_contact_new'] = modules::run('contact/num_rows_new');
        $this->_data['num_contact'] = modules::run('contact/counts');

        $this->_data['num_pages'] = modules::run('pages/counts');
        $this->_data['num_posts'] = modules::run('posts/counts');
        $this->_data['num_projects'] = modules::run('projects/counts');

        $this->_data['title'] = 'Bảng điều khiển - ' . $this->_data['title'];
        $this->_data['main_content'] = 'dashboard/view_page_index';
        $this->load->view('layout/admin/view_layout', $this->_data);
    }

}