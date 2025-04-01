<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
include_once APPPATH . '/modules/layout/controllers/Layout.php';

class Emails_configs extends Layout {

    private $_module_slug = 'emails/configs';
    private $_allowed_field = array('active');

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('emails/m_email_configs', 'M_email_configs');
        $this->_data['module_slug'] = $this->_module_slug;
        $this->_data['breadcrumbs_module_name'] = 'Email configs';
    }

    function admin_ajax_change_field() {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        $post = $this->input->post();
        if (!empty($post)) {
            $value = $this->input->post('value');
            $id = $this->input->post('id');
            $field = $this->input->post('field');
            $massage_success = $this->input->post('massage_success');
            $massage_warning = $this->input->post('massage_warning');
            $data = array(
                $field => $value,
            );
            if (!in_array($field, $this->_allowed_field)) {
                $notify_type = 'danger';
                $notify_content = 'Trường này không tồn tại!';
            } else if ($this->M_email_configs->update($id, $data)) {
                if ($value == 1) {
                    $notify_type = 'success';
                    $notify_content = $massage_success;
                } else {
                    $notify_type = 'warning';
                    $notify_content = $massage_warning;
                }
            } else {
                $notify_type = 'danger';
                $notify_content = 'Dữ liệu chưa lưu!';
            }
            $this->set_notify_admin($notify_type, $notify_content);
            $this->load->view('layout/notify-ajax', NULL);
        } else {
            redirect(base_url());
        }
    }

    public function gets_item_field($field = '', $number = 3) {
        if ((trim($field) == '') || !in_array($field, $this->_allowed_field)) {
            return null;
        }
        $args = $this->default_args();
        $args[$field] = 1;
        if ($number > 0) {
            $rows = $this->M_email_configs->gets($args, $number, 0);
        } else {
            $rows = $this->M_email_configs->gets($args);
        }

        return $rows;
    }

    function ajax_get() {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $message = array();
        $message['status'] = 'warning';
        $message['content'] = null;
        $message['message'] = 'Kiểm tra thông tin nhập';

        $post = $this->input->post();
        if (!empty($post)) {
            $id = $this->input->post('id');
            $content = $this->get($id);

            $message['status'] = 'success';
            $message['content'] = $content;
            $message['message'] = 'Đã tải dữ liệu thành công!';
        }
        echo json_encode($message);
        exit();
    }

    function default_args() {
        $order_by = array(
            'order' => 'ASC',
            'modified' => 'DESC',
            'created' => 'ASC'
        );
        $args = array();
        $args['order_by'] = $order_by;

        return $args;
    }

    function counts($options = array()) {
        $default_args = $this->default_args();

        if(is_array($options) && !empty($options)){
            $args = array_merge($default_args, $options);
        }else{
            $args = $default_args;
        }
        return $this->M_email_configs->counts($args);
    }

    function gets($options = array()) {
		$default_args = $this->default_args();

		if(is_array($options) && !empty($options)){
			$args = array_merge($default_args, $options);
		}else{
			$args = $default_args;
		}

        $this->load->model('emails/m_email_configs', 'M_email_configs');
        return $this->M_email_configs->gets($args);
    }

    function get($id) {
        $this->load->model('emails/m_email_configs', 'M_email_configs');
        return $this->M_email_configs->get($id);
    }

    function get_max_order() {
        $args = $this->default_args();
        $order_by = array(
            'order' => 'DESC'
        );
        $args['order_by'] = $order_by;
        $perpage = 1;
        $offset = 0;
        $rows = $this->M_email_configs->gets($args, $perpage, $offset);
        $max_order = isset($rows[0]['order']) ? $rows[0]['order'] : 0;

        return (int) $max_order;
    }

    function re_order() {
        $args = $this->default_args();
        $order_by = array(
            'order' => 'ASC'
        );
        $args['order_by'] = $order_by;
        $rows = $this->gets($args);
        if (is_array($rows) && !empty($rows)) {
            $i = 0;
            foreach ($rows as $value) {
                $i++;
                $data = array(
                    'order' => $i
                );
                $this->M_email_configs->update($value['id'], $data);
            }
        }
    }

    function admin_index() {
        $this->_initialize_admin();
        $this->redirect_admin();
        $this->_plugins_css_admin[] = array(
            'folder' => 'bootstrap3-dialog/css',
            'name' => 'bootstrap-dialog'
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'bootstrap3-dialog/js',
            'name' => 'bootstrap-dialog'
        );
        $this->set_plugins_admin();

        $this->_modules_script[] = array(
            'folder' => 'emails',
            'name' => 'admin-email-configs-items'
        );
        $this->set_modules();

        $get = $this->input->get();
        $this->_data['get'] = $get;

        $args = $this->default_args();
        $args['deleted'] = 0;

        if (isset($get['q']) && trim($get['q']) != '') {
            $args['q'] = $get['q'];
        }

        $total = $this->counts($args);
        $perpage = isset($get['per_page']) ? $get['per_page'] : $this->config->item('per_page');
        $segment = 4;

        $this->load->library('pagination');
        $config['total_rows'] = $total;
        $config['per_page'] = $perpage;
        $config['full_tag_open'] = '<ul class="pagination no-margin pull-right">';
        $config['full_tag_close'] = '</ul><!--pagination-->';

        $config['first_link'] = '&laquo;';
        $config['first_tag_open'] = '<li class="prev page">';
        $config['first_tag_close'] = '</li>';

        $config['last_link'] = '&raquo;';
        $config['last_tag_open'] = '<li class="next page">';
        $config['last_tag_close'] = '</li>';

        $config['next_link'] = 'Trang trước &rarr;';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>';

        $config['prev_link'] = '&larr; Trang sau';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="active"><a href="">';
        $config['cur_tag_close'] = '</a></li>';

        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>';

        if (!empty($get)) {
            $config['base_url'] = get_admin_url($this->_module_slug);
            $config['suffix'] = '?' . http_build_query($get, '', "&");
            $config['first_url'] = get_admin_url($this->_module_slug . '?' . http_build_query($get, '', "&"));
            $config['uri_segment'] = $segment;
        } else {
            $config['base_url'] = get_admin_url($this->_module_slug);
            $config['uri_segment'] = $segment;
        }

        $this->pagination->initialize($config);

        $pagination = $this->pagination->create_links();
        $offset = ($this->uri->segment($segment) == '') ? 0 : $this->uri->segment($segment);

        $this->_data['rows'] = $this->M_email_configs->gets($args, $perpage, $offset);
        $this->_data['pagination'] = $pagination;

        $this->_data['title'] = 'Danh sách cấu hình email - ' . $this->_data['title'];
        $this->_data['main_content'] = 'emails/admin/view_page_configs_index';
        $this->load->view('layout/admin/view_layout', $this->_data);
    }

    function admin_config1() {
        die('sadsadsa');
        $this->_initialize_admin();
        $this->redirect_admin();
        
        $this->_plugins_script_admin[] = array(
            'folder' => 'jquery-validation',
            'name' => 'jquery.validate'
        );

        $this->set_plugins_admin();

        $this->_modules_script[] = array(
            'folder' => 'emails',
            'name' => 'admin-configs-validate'
        );
        $this->set_modules();
        
        $this->load->library('encrypt');

        $post = $this->input->post();
        if (!empty($post)) {            
            $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');
            $this->form_validation->set_rules('protocol', 'Protocol', 'trim|required|xss_clean');
            $this->form_validation->set_rules('smtp_host', 'SMTP Host', 'trim|required|xss_clean');
            $this->form_validation->set_rules('smtp_port', 'SMTP Port', 'trim|required|xss_clean');
            $this->form_validation->set_rules('smtp_user', 'SMTP User', 'trim|required|xss_clean');

            if ($this->form_validation->run($this)) {                
                $edit_time = time();
                $data = array(
                    'protocol' => array(
                        'content' => $this->input->post('protocol'),
                        'edit_time' => $edit_time
                    ),
                    'smtp_host' => array(
                        'content' => $this->input->post('smtp_host'),
                        'edit_time' => $edit_time
                    ),
                    'smtp_port' => array(
                        'content' => $this->input->post('smtp_port'),
                        'edit_time' => $edit_time
                    ),
                    'smtp_user' => array(
                        'content' => $this->input->post('smtp_user'),
                        'edit_time' => $edit_time
                    )
                );

                if (trim($this->input->post('smtp_pass')) != '') {
                    $data['smtp_pass'] = array(
                        'content' => $this->encrypt->encode($this->input->post('smtp_pass')),
                        'edit_time' => $edit_time
                    );
                }

                $this->update_systems_emails($data);

                $notify_type = 'success';
                $notify_content = 'Email configuration saved!';
                $this->set_notify_admin($notify_type, $notify_content);
                redirect(get_admin_url('emails'));
            }
        }

        $configs = $this->get_configs_emails();
        $this->_data['configs'] = $configs;
        
        $this->_data['breadcrumbs_module_func'] = 'Email settings';
        $this->_breadcrumbs_admin[] = array(
            'url' => 'emails',
            'name' => $this->_data['breadcrumbs_module_func']
        );
        $this->set_breadcrumbs_admin();
        
        $this->_data['title'] = 'Email settings - ' . $this->_data['title'] . ' Admin';
        $this->_data['main_content'] = 'emails/admin/view_page_config';
        $this->load->view('layout/admin/view_layout', $this->_data);
    }

    function admin_add() {
        $data = array(
            'protocol' => $this->input->post('protocol'),
			'smtp_host' => $this->input->post('smtp_host'),
			'smtp_port' => $this->input->post('smtp_port'),
            'smtp_user' => $this->input->post('smtp_user'),
			'smtp_pass' => $this->encrypt->encode($this->input->post('smtp_pass')),
            'active' => $this->input->post('active') ? 1 : 0,
            'order' => $this->get_max_order() + 1,
            'created' => time(),
            'modified' => 0
        );

        return $this->M_email_configs->add($data);
    }

    function admin_update($id) {
        $data = array(
            'protocol' => $this->input->post('protocol'),
            'smtp_host' => $this->input->post('smtp_host'),
            'smtp_port' => $this->input->post('smtp_port'),
            'smtp_user' => $this->input->post('smtp_user'),
            'active' => $this->input->post('active') ? 1 : 0,
            'modified' => time()
        );
        $smtp_pass = $this->input->post('smtp_pass');
        if(trim($smtp_pass) != ''){
            $data['smtp_pass'] = $this->encrypt->encode($smtp_pass);
        }
        return $this->M_email_configs->update($id, $data);
    }

    function admin_delete() {
        $this->load->module('users');

        $this->_message_success = 'Đã xóa thông tin!';
        $this->_message_warning = 'Thông tin này không tồn tại!';
        if ($this->users->validate_admin_logged_in() == TRUE) {
            if ($this->input->post('ajax') == '1') {
                $id = $this->input->post('id');
                if ($id != 0) {
                    if ($this->M_email_configs->delete($id)) {
                        $this->_status = "success";
                        $this->_message = $this->_message_success;
                    } else {
                        $this->_status = "danger";
                        $this->_message = $this->_message_danger;
                    }
                } else {
                    $this->_status = "warning";
                    $this->_message = $this->_message_warning;
                }

                $this->set_json_encode();
                $this->load->view('layout/json_data', $this->_data);
            } else {
                $id = $this->input->get('id');
                if ($id != 0) {
                    if ($this->M_email_configs->delete($id)) {
                        $notify_type = 'success';
                        $notify_content = $this->_message_success;
                        $this->re_order();
                    } else {
                        $notify_type = 'danger';
                        $notify_content = $this->_message_danger;
                    }
                } else {
                    $notify_type = 'warning';
                    $notify_content = $this->_message_warning;
                }
                $this->set_notify_admin($notify_type, $notify_content);
                redirect(get_admin_url($this->_module_slug));
            }
        } else {
            if ($this->input->post('ajax') == '1') {
                $this->_status = "danger";
                $this->_message = $this->_message_banned;

                $this->set_json_encode();
                $this->load->view('layout/json_data', $this->_data);
            } else {
                $notify_type = 'danger';
                $notify_content = $this->_message_banned;
                $this->set_notify_admin($notify_type, $notify_content);
                redirect(get_admin_url($this->_module_slug));
            }
        }
    }

    function admin_main() {
        $this->_initialize_admin();
        $this->redirect_admin();
        $post = $this->input->post();
        if (!empty($post)) {
            $action = $this->input->post('action');
            if ($action == 'update') {
                $this->_message_success = 'Đã cập nhật cấu hình email!';
                $this->_message_warning = 'Không có cấu hình email nào để cập nhật!';
                $ids = $this->input->post('ids');
                $orders = $this->input->post('order');
                $count = count($orders);
                if (!empty($ids) && !empty($orders)) {
                    for ($i = 0; $i < $count; $i++) {
                        $data = array(
                            'order' => $orders[$i]
                        );
                        $id = $ids[$i];

                        if ($this->M_email_configs->update($id, $data)) {
                            $notify_type = 'success';
                            $notify_content = $this->_message_success;
                        } else {
                            $notify_type = 'danger';
                            $notify_content = $this->_message_danger;
                        }
                    }
                } else {
                    $notify_type = 'warning';
                    $notify_content = $this->_message_warning;
                }
                $this->set_notify_admin($notify_type, $notify_content);
                redirect(get_admin_url($this->_module_slug));
            } elseif ($action == 'delete') {
                $this->_message_success = 'Đã xóa các cấu hình email được chọn!';
                $this->_message_warning = 'Bạn chưa chọn cấu hình email nào!';
                $ids = $this->input->post('idcheck');

                if (is_array($ids) && !empty($ids)) {
                    foreach ($ids as $id) {
                        $row = $this->get($id);
                        if (!empty($row) && $this->M_email_configs->delete($id)) {
                            $notify_type = 'success';
                            $notify_content = $this->_message_success;
                        } else {
                            $notify_type = 'danger';
                            $notify_content = $this->_message_danger;
                        }
                    }
                    $this->re_order();
                } else {
                    $notify_type = 'warning';
                    $notify_content = $this->_message_warning;
                }
                $this->set_notify_admin($notify_type, $notify_content);
                redirect(get_admin_url($this->_module_slug));
            } elseif ($action == 'content') {
                redirect(get_admin_url($this->_module_slug . '/content'));
            }
        } else {
            redirect(get_admin_url($this->_module_slug));
        }
    }

    function admin_content() {
        $this->_initialize_admin();
        $this->redirect_admin();

        $this->_plugins_script_admin[] = array(
            'folder' => 'jquery-validation',
            'name' => 'jquery.validate'
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'jquery-validation/localization',
            'name' => 'messages_vi'
        );

        $this->_plugins_css_admin[] = array(
            'folder' => 'bootstrap-fileinput/css',
            'name' => 'fileinput'
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'bootstrap-fileinput/js',
            'name' => 'fileinput.min'
        );

        $this->set_plugins_admin();

        $this->_modules_script[] = array(
            'folder' => 'emails',
            'name' => 'admin-email-configs-validate'
        );
        $this->set_modules();

        $this->load->library('encrypt');
        $post = $this->input->post();
        if (!empty($post)) {
            $this->load->helper('language');
            $this->lang->load('form_validation', 'vietnamese');

            $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');
            $this->form_validation->set_rules('protocol', 'Nhập protocol', 'trim|required');
            $this->form_validation->set_rules('smtp_host', 'Nhập SMTP host', 'trim|required');
            $this->form_validation->set_rules('smtp_port', 'Nhập SMTP port', 'trim|required');
            $this->form_validation->set_rules('smtp_user', 'Nhập email', 'trim|required');

            if ($this->form_validation->run($this)) {
                if ($this->input->post('id')) {
                    $err = FALSE;
                    $id = $this->input->post('id');
                    if (!$this->admin_update($id)) {
                        $err = TRUE;
                    }

                    if ($err === FALSE) {
                        $notify_type = 'success';
                        $notify_content = 'Cập nhật thông tin thành công!';
                        $this->set_notify_admin($notify_type, $notify_content);

                        redirect(get_admin_url($this->_module_slug));
                    } else {
                        $notify_type = 'danger';
                        $notify_content = 'Có lỗi xảy ra!';
                        $this->set_notify_admin($notify_type, $notify_content);
                    }
                } else {
                    $err = FALSE;
                    $insert_id = $this->admin_add();
                    if ($insert_id == 0) {
                        $err = TRUE;
                    }

                    if ($err === FALSE) {
                        $notify_type = 'success';
                        $notify_content = 'Thông tin đã được thêm!';
                        $this->set_notify_admin($notify_type, $notify_content);

                        redirect(get_admin_url($this->_module_slug));
                    } else {
                        $notify_type = 'danger';
                        $notify_content = 'Có lỗi xảy ra!';
                        $this->set_notify_admin($notify_type, $notify_content);
                    }
                }
            }
        }

        $title = 'Thêm thông tin - ' . $this->_data['breadcrumbs_module_name'] . ' - ' . $this->_data['title'];

        $segment = 5;
        $id = ($this->uri->segment($segment) == '') ? 0 : $this->uri->segment($segment);
        if ($id != 0) {
            $row = $this->get($id);
            $this->_data['row'] = $row;
            $title = 'Cập nhật thông tin - ' . $this->_data['breadcrumbs_module_name'] . ' - ' . $this->_data['title'];
        }

        $this->_data['title'] = $title;
        $this->_data['main_content'] = 'emails/admin/view_page_configs_content';
        $this->load->view('layout/admin/view_layout', $this->_data);
    }

}
/* End of file Email_configs.php */
/* Location: ./application/modules/emails/controllers/Email_configs.php */