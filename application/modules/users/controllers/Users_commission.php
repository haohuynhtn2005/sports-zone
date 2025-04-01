<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
include_once APPPATH . '/modules/layout/controllers/Layout.php';

class Users_commission extends Layout {

    private $_module_slug = 'commission';

    function __construct() {
        parent::__construct();
        $this->_data['module_slug'] = $this->_module_slug;
    }

    private function set_breadcrumbs_module($func = '') {
        $this->_data['breadcrumbs_module_name'] = 'Hoa hồng';
        $this->_data['breadcrumbs_module_func'] = $func;
    }

    function ajax_change_status() {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $message = array();
        $message['status'] = 'warning';
        $message['content'] = null;
        $message['message'] = show_alert_warning('Kiểm tra lại dữ liệu');

        $post = $this->input->post();
        if (!empty($post)) {
            $this->_initialize_admin();
            $err = FALSE;
            $id = $this->input->post('id');
            $row = $this->get(array(
                'id' => $id
            ));
            if(!(is_array($row) && !empty($row))){
                $message['status'] = 'error';
                $message['content'] = null;
                $message['message'] = show_alert_danger('Giao dịch không tồn tại!');
                echo json_encode($message);
                exit();
            }
            $status = (int)$this->input->post('status');
            $verify_by = $this->_data['userid'];
            $time = time();
            $args = array(
                'id' => $id
            );
            $data = array(
                'status' => $status,
                'verified' => $time,
                'verify_by' => $verify_by
            );
            $bool = $this->update($args, $data);
            if ($bool) {
                if($status == 1){
                    if(in_array($row['action'], array('WITHDRAWAL'))){
                        $user_id = (int) $row['user_id'];
                        $balance = get_balance_user($user_id, (int) $row['id']);
                        $amount = $row['value_cost'];
                        if($balance < $amount){
                            $args = array(
                                'id' => $id
                            );
                            $data = array(
                                'status' => 0,
                                'verified' => 0,
                                'verify_by' => NULL
                            );
                            $this->update($args, $data);
                            $message['status'] = 'error';
                            $message['content'] = NULL;
                            $message['message'] = show_alert_danger('Số dư tài khoản không đủ điều kiện thực hiện giao dịch!');
                            echo json_encode($message);
                            exit();
                        }
                    }
                    $message['status'] = 'success';
                    $message['content'] = display_label('Khả dụng');
                    $message['message'] = show_alert_success('Xác nhận yêu cầu thành công!');
                }else{
                    $message['status'] = 'success';
                    $message['content'] = display_label('Đã hủy yêu cầu', 'danger');
                    $message['message'] = show_alert_success('Hủy yêu cầu thành công!');
                }
            } else {
                $message['status'] = 'error';
                $message['content'] = null;
                $message['message'] = show_alert_danger('Có lỗi xảy ra! Vui lòng thực hiện lại!');
            }
        }
        echo json_encode($message);
        exit();
    }

	function default_args() {
		$order_by = array(
			'status' => 'ASC',
            'created' => 'DESC'
		);
		$args = array();
		$args['order_by'] = $order_by;

		return $args;
	}

    function counts($options = array()) {
        $default_args = $this->default_args();

        if (is_array($options) && !empty($options)) {
            $args = array_merge($default_args, $options);
        } else {
            $args = $default_args;
        }
        return $this->M_users_commission->counts($args);
    }

	function validate_exist($args) {
        $data = $this->get($args);

        if (is_array($data) && !empty($data)) {
            return TRUE;
        }

        return FALSE;
    }

    function get($args) {
        return $this->M_users_commission->get($args);
    }

    function gets($options = array()) {
		$default_args = $this->default_args();

		if (is_array($options) && !empty($options)) {
			$args = array_merge($default_args, $options);
		} else {
			$args = $default_args;
		}
        return $this->M_users_commission->gets($args);
    }

    function add($data = NULL) {
        if (empty($data)) {
            return 0;
        }
        return $this->M_users_commission->add($data);
    }

    function update($args, $data) {
        return $this->M_users_commission->update($args, $data);
    }

    function delete($args) {
        return $this->M_users_commission->delete($args);
    }

    function site_commission() {
        $this->_initialize();
        modules::run('users/require_logged_in');

        $this->output->cache(true);
        $user_id = $this->_data['userid'];
        $data = get_commission_user($user_id);
        $this->_data['balance'] = $data['balance'];
        $this->_data['total_withdrawal'] =  $data['total_withdrawal'];

        $this->_breadcrumbs[] = array(
            'url' => current_url(),
            'name' => 'Hoa hồng',
        );
        $this->set_breadcrumbs();

        $this->_data['title_seo'] = 'Hoa hồng - ' . $this->_data['title_seo'];
        $this->_data['main_content'] = 'layout/site/pages/user-commission';
        $this->load->view('layout/site/layout', $this->_data);
    }

    function site_commission_history() {
        $this->_initialize();
        modules::run('users/require_logged_in');

        $this->output->cache(true);
        $_module_slug = 'hoa-hong/lich-su';
        $user_id = $this->_data['userid'];

        $get = $this->input->get();
        $this->_data['get'] = $get;

        $args = $this->default_args();
        $args['status'] = 1;
        $args['user_id'] = $user_id;
        $args['in_action'] = array('SUB_BUY', 'SUB_BUY_TRAVEL');
        if (isset($get['q']) && trim($get['q']) != '') {
            $args['q'] = $get['q'];
        }
        $type = isset($get['type']) ? $get['type'] : '';
        if ($type == 'TRAVEL') {
            $args['in_action'] = array('SUB_BUY_TRAVEL');
        }elseif ($type == 'HOTEL') {
            $args['in_action'] = array('SUB_BUY');
        }

        $total = $this->M_users_commission->counts($args);
        $perpage = 5;
        $segment = 3;

        $this->load->library('pagination');
        $config['total_rows'] = $total;
        $config['per_page'] = $perpage;
        $config['num_links'] = $this->config->item('num_links');
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';

        $config['first_link'] = '&larr;';
        $config['first_tag_open'] = '<li class="prev page">';
        $config['first_tag_close'] = '</li>';

        $config['last_link'] = '&rarr;';
        $config['last_tag_open'] = '<li class="next page">';
        $config['last_tag_close'] = '</li>';

        $config['next_link'] = '&raquo;';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>';

        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="active"><a href="">';
        $config['cur_tag_close'] = '</a></li>';

        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>';

        $config['base_url'] = base_url($_module_slug);
        $config['first_url'] = site_url($_module_slug);
        $config['uri_segment'] = $segment;

        $this->pagination->initialize($config);
        $pagination = $this->pagination->create_links();
        $this->_data['pagination'] = $pagination;

        $offset = ($this->uri->segment($segment) == '') ? 0 : $this->uri->segment($segment);
        $rows = $this->M_users_commission->gets($args, $perpage, $offset);
        $this->_data['rows'] = $rows;

        $this->_breadcrumbs[] = array(
            'url' => current_url(),
            'name' => 'Lịch sử hoa hồng',
        );
        $this->set_breadcrumbs();

        $this->_data['title_seo'] = 'Lịch sử hoa hồng được hưởng - ' . $this->_data['title_seo'];
        $this->_data['main_content'] = 'layout/site/pages/user-commission-history';
        $this->load->view('layout/site/layout', $this->_data);
    }

    function site_withdrawal_history() {
        $this->_initialize();
        modules::run('users/require_logged_in');

        $this->output->cache(true);
        $_module_slug = 'rut-tien/lich-su';
        $user_id = $this->_data['userid'];

        $args = $this->default_args();
        $args['user_id'] = $user_id;
        $args['in_action'] = array('WITHDRAWAL');
        $args_success = $args_pending = $args;

        $args_success['status'] = 1;
        $total_success = $this->M_users_commission->get_total($args_success);
        $this->_data['total_success'] = $total_success;

        $args_pending['status'] = 0;
        $total_pending = $this->M_users_commission->get_total($args_pending);
        $this->_data['total_pending'] = $total_pending;

        $total = $this->M_users_commission->counts($args);
        $perpage = 5;
        $segment = 3;

        $this->load->library('pagination');
        $config['total_rows'] = $total;
        $config['per_page'] = $perpage;
        $config['num_links'] = $this->config->item('num_links');
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';

        $config['first_link'] = '&larr;';
        $config['first_tag_open'] = '<li class="prev page">';
        $config['first_tag_close'] = '</li>';

        $config['last_link'] = '&rarr;';
        $config['last_tag_open'] = '<li class="next page">';
        $config['last_tag_close'] = '</li>';

        $config['next_link'] = '&raquo;';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>';

        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="active"><a href="">';
        $config['cur_tag_close'] = '</a></li>';

        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>';

        $config['base_url'] = base_url($_module_slug);
        $config['first_url'] = site_url($_module_slug);
        $config['uri_segment'] = $segment;

        $this->pagination->initialize($config);
        $pagination = $this->pagination->create_links();
        $this->_data['pagination'] = $pagination;

        $offset = ($this->uri->segment($segment) == '') ? 0 : $this->uri->segment($segment);
        $rows = $this->M_users_commission->gets($args, $perpage, $offset);
        $this->_data['rows'] = $rows;

        $this->_breadcrumbs[] = array(
            'url' => site_url('rut-tien'),
            'name' => 'Rút tiền',
        );
        $this->_breadcrumbs[] = array(
            'url' => current_url(),
            'name' => 'Lịch sử',
        );
        $this->set_breadcrumbs();

        $this->_data['title_seo'] = 'Lịch sử rút tiền - ' . $this->_data['title_seo'];
        $this->_data['main_content'] = 'layout/site/pages/user-withdrawal-history';
        $this->load->view('layout/site/layout', $this->_data);
    }

    function admin_index() {
        $this->_initialize_admin();
        $this->redirect_admin();

        // $user_id = 322;
        // echo get_balance_user($user_id);
        // echo "<br/>" . get_balance_user($user_id, 1676);
        // die;

        $this->_plugins_css_admin[] = array(
            'folder' => 'bootstrap3-dialog/css',
            'name' => 'bootstrap-dialog',
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'bootstrap3-dialog/js',
            'name' => 'bootstrap-dialog',
        );
        $this->set_plugins_admin();

        $this->_modules_script[] = array(
            'folder' => 'users',
            'name' => 'admin-commission-items',
        );
        $this->set_modules();

        $get = $this->input->get();
        $this->_data['get'] = $get;

        $args = $this->default_args();
        $order_by = array(
            'id' => 'DESC',
            // 'status' => 'ASC',
            // 'created' => 'DESC'
        );
        $args['order_by'] = $order_by;

        if (isset($get['q']) && trim($get['q']) != '') {
            $args['q'] = $get['q'];
        }

        $total = $this->counts($args);
        $perpage = 50;
        $segment = 3;

        $this->load->library('pagination');
        $config['total_rows'] = $total;
        $config['per_page'] = $perpage;
        $config['full_tag_open'] = '<ul class="pagination no-margin pull-right">';
        $config['full_tag_close'] = '</ul>';

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

        $this->_data['rows'] = $this->M_users_commission->gets($args, $perpage, $offset);
        $this->_data['pagination'] = $pagination;

        $this->set_breadcrumbs_module('Danh sách');
        $this->_data['title'] = 'Danh sách hoa hồng - ' . $this->_data['title'];
        $this->_data['main_content'] = 'users/admin/view_page_commission_index';
        $this->load->view('layout/admin/view_layout', $this->_data);
    }

    function admin_delete() {
        $this->_initialize_admin();
        $this->redirect_admin();

        $this->_message_success = 'Đã xóa giao dịch!';
        $this->_message_warning = 'Giao dịch này không tồn tại!';
        $id = $this->input->get('id');
        $row = $this->get(array(
            'id' => $id
        ));
        if(is_array($row) && !empty($row)){
            if ($this->M_users_commission->delete(array('id' => $id))) {
                $notify_type = 'success';
                $notify_content = $this->_message_success;
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
}
/* End of file Users_commission.php */
/* Location: ./application/modules/users/controllers/Users_commission.php */