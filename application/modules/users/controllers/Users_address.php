<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
include_once APPPATH . '/modules/layout/controllers/Layout.php';

class Users_address extends Layout {

    function __construct() {
        parent::__construct();
        $this->load->model('users/m_users_address', 'M_users_address');
        $this->_data['breadcrumbs_module_name'] = 'Địa chỉ người dùng';
    }

    function ajax_get_cost() {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $message = array();
        $message['status'] = 'warning';
        $message['content'] = null;
        $message['message'] = show_alert_warning('Kiểm tra dữ liệu nhập');

        $post = $this->input->post();
        if (!empty($post)) {
            $this->_initialize_user();
            //if (!$this->session->has_userdata('logged_in')) {
            if (!isset($this->_data['userid'])) {
                $message['status'] = 'warning';
                $message['content'] = null;
                $message['message'] = show_alert_danger('Vui lòng đăng nhập để thực hiện chức năng này!');
                echo json_encode($message);
                exit();
            }
            $user_id = $this->_data['userid'];
            $id = $this->input->post('id');
            $args = array(
                'id' => $id,
                'user_id' => $user_id,
            );
            $row = $this->get($args);
            if(!(is_array($row) && !empty($row))){
                $message['status'] = 'error';
                $message['content'] = null;
                $message['message'] = show_alert_danger('Địa chỉ không tồn tại!');
                echo json_encode($message);
                exit();
            }
            $cost = isset($row['cost']) ? $row['cost'] : 0;
            $total = formatRice($this->cart->total() + $cost) . ' ₫';

            $message['status'] = 'success';
            $message['content'] = array(
                'cost' => $cost > 0 ? formatRice($cost) . ' ₫' : 'Miễn phí',
                'total' => $total,
            );
            $message['message'] = show_alert_success('Tải dữ liệu thành công!');
        }
        echo json_encode($message);
        exit();
    }

    function ajax_get() {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $message = array();
        $message['status'] = 'warning';
        $message['content'] = null;
        $message['message'] = show_alert_warning('Kiểm tra lại dữ liệu');

        $post = $this->input->post();
        if (!empty($post)) {
            $this->_initialize_user();
            if (!isset($this->_data['userid'])) {
                $message['status'] = 'warning';
                $message['content'] = null;
                $message['message'] = show_alert_danger('Vui lòng đăng nhập để thực hiện chức năng này!');
                echo json_encode($message);
                exit();
            }
            $user_id = $this->_data['userid'];
            $id = $this->input->post('id');
            $args = array(
                'id' => $id,
                'user_id' => $user_id,
            );
            $row = $this->get($args);
            if(!(is_array($row) && !empty($row))){
                $message['status'] = 'error';
                $message['content'] = null;
                $message['message'] = show_alert_danger('Địa chỉ không tồn tại!');
                echo json_encode($message);
                exit();
            }

            $districts = modules::run('provinces/districts/gets', array('in_pId' => $row['province_id']));
            $partial = array();
            $partial = array('option_name'=> 'quận/huyện', 'data_key'=> 'dId', 'data_value'=> 'dName', 'data' => $districts, 'option_selected' => $row['district_id']);
            $district = $this->load->view('layout/site/partial/option', $partial, true);

            $communes = modules::run('provinces/communes/gets', array('in_district_id' => $row['district_id']));
            $partial = array();
            $partial = array('option_name'=> 'phường/xã', 'data_key'=> 'id', 'data_value'=> 'name', 'data' => $communes, 'option_selected' => $row['commune_id']);
            $commune = $this->load->view('layout/site/partial/option', $partial, true);

            $message['status'] = 'success';
            $message['content'] = array(
            	'row' => $row,
            	'province' => $row['province_id'],
            	'district' => $district,
            	'commune' => $commune,
            );
            $message['message'] = show_alert_success('Tải dữ liệu thành công!');
        }
        echo json_encode($message);
        exit();
    }

    function ajax_content() {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $message = array();
        $message['status'] = 'warning';
        $message['content'] = null;
        $message['message'] = show_alert_warning('Kiểm tra lại dữ liệu');

        $post = $this->input->post();
        if (!empty($post)) {
            $this->_initialize_user();
            if (!isset($this->_data['userid'])) {
                $message['status'] = 'warning';
                $message['content'] = null;
                $message['message'] = show_alert_danger('Vui lòng đăng nhập để thực hiện chức năng này!');
                echo json_encode($message);
                exit();
            }
            $user_id = $this->_data['userid'];
            $id = (int) $this->input->post('id');
            $data = array(
            	'user_id' => $user_id,
            	'full_name' => $this->input->post('full_name'),
            	'place_of_receipt' => $this->input->post('place_of_receipt'),
            	'province_id' => $this->input->post('province_id'),
            	'district_id' => $this->input->post('district_id'),
            	'commune_id' => $this->input->post('commune_id'),
            	'phone' => $this->input->post('phone'),
            	'created' => time(),
            	'modified' => 0
            );
            if($id != 0){
            	$args = array(
            	    'id' => $id,
            	    'user_id' => $user_id,
            	);
            	$row = $this->get($args);
            	if(!(is_array($row) && !empty($row))){
            	    $message['status'] = 'error';
            	    $message['content'] = null;
            	    $message['message'] = show_alert_danger('Địa chỉ không tồn tại!');
            	    echo json_encode($message);
            	    exit();
            	}
            	$bool = $this->update($args, $data);
            	if ($bool) {
					$row = $this->get(array('id' => $id));

            	    $message['status'] = 'success';
            	    $message['content'] = array(
            	    	'full_name' => $row['full_name'],
            	    	'full_address' => get_full_address($row),
            	    	'phone' => $row['phone'],
            	    );
            	    $message['message'] = show_alert_success('Cập nhật địa chỉ thành công!');
            	} else {
            	    $message['status'] = 'error';
            	    $message['content'] = null;
            	    $message['message'] = show_alert_danger('Chưa cập nhật địa chỉ! Vui lòng thực hiện lại!');
            	}

            }else{
				$insert_id = $this->add($data);
				if($insert_id != 0){
					$row = $this->get(array('id' => $insert_id));
					$partial = array();
					$partial['data'] = array($row);

                    $message['status'] = 'success';
                    $message['content'] = $this->load->view('layout/site/partial/address', $partial, true);;
                    $message['message'] = show_alert_success('Tạo địa chỉ thành công!');
                } else {
                    $message['status'] = 'error';
	                $message['content'] = null;
	                $message['message'] = show_alert_danger('Địa chỉ chưa được tạo! Vui lòng thực hiện lại!');
                }
            }
        }
        echo json_encode($message);
        exit();
    }

    function ajax_create() {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $message = array();
        $message['status'] = 'warning';
        $message['content'] = null;
        $message['message'] = show_alert_warning('Kiểm tra lại dữ liệu');

        $post = $this->input->post();
        if (!empty($post)) {
            $this->_initialize_user();
            if (!isset($this->_data['userid'])) {
                $message['status'] = 'warning';
                $message['content'] = null;
                $message['message'] = show_alert_danger('Vui lòng đăng nhập để thực hiện chức năng này!');
                echo json_encode($message);
                exit();
            }
            $user_id = $this->_data['userid'];
            $data = array(
                'user_id' => $user_id,
                'full_name' => $this->input->post('full_name'),
                'place_of_receipt' => $this->input->post('place_of_receipt'),
                'province_id' => $this->input->post('province_id'),
                'district_id' => $this->input->post('district_id'),
                'commune_id' => $this->input->post('commune_id'),
                'phone' => $this->input->post('phone'),
                'created' => time(),
                'modified' => 0
            );
            $insert_id = $this->add($data);
            if($insert_id != 0){
                $row = $this->get(array('id' => $insert_id));
                $partial = array();
                $partial['data'] = array($row);
                $partial['is_create'] = TRUE;

                $message['status'] = 'success';
                $message['content'] = $this->load->view('layout/site/partial/address-checkout', $partial, true);;
                $message['message'] = show_alert_success('Tạo địa chỉ thành công!');
            } else {
                $message['status'] = 'error';
                $message['content'] = null;
                $message['message'] = show_alert_danger('Địa chỉ chưa được tạo! Vui lòng thực hiện lại!');
            }
        }
        echo json_encode($message);
        exit();
    }

    function ajax_delete() {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $message = array();
        $message['status'] = 'warning';
        $message['content'] = null;
        $message['message'] = show_alert_warning('Kiểm tra lại dữ liệu');

        $post = $this->input->post();
        if (!empty($post)) {
            $this->_initialize_user();
            if (!isset($this->_data['userid'])) {
                $message['status'] = 'warning';
                $message['content'] = null;
                $message['message'] = show_alert_danger('Vui lòng đăng nhập để thực hiện chức năng này!');
                echo json_encode($message);
                exit();
            }
            $user_id = $this->_data['userid'];
            $id = $this->input->post('id');
            $args = array(
                'id' => $id,
                'user_id' => $user_id,
            );
            $row = $this->get($args);
            if(!(is_array($row) && !empty($row))){
                $message['status'] = 'error';
                $message['content'] = null;
                $message['message'] = show_alert_danger('Địa chỉ không tồn tại!');
                echo json_encode($message);
                exit();
            }elseif(isset($row['is_default_checkout_address']) && $row['is_default_checkout_address'] == 1){
            	$message['status'] = 'error';
                $message['content'] = null;
                $message['message'] = show_alert_danger('Không thể xóa địa chỉ mặc định!');
                echo json_encode($message);
                exit();
            }
            $bool = $this->delete($args);
            if ($bool) {
                $message['status'] = 'success';
                $message['content'] = null;
                $message['message'] = show_alert_success('Đã xóa địa chỉ thành công!');
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
			'created' => 'ASC',
			'modified' => 'DESC',
		);
		$args = array();
		$args['order_by'] = $order_by;

		return $args;
	}

	function validate_exist($args) {
        $data = $this->get($args);

        if (is_array($data) && !empty($data)) {
            return TRUE;
        }

        return FALSE;
    }

	function counts($options = array()) {
		$default_args = $this->default_args();

		if(is_array($options) && !empty($options)){
			$args = array_merge($default_args, $options);
		}else{
			$args = $default_args;
		}

        return $this->M_users_address->counts($args);
    }

    function get($options = array()) {
		$default_args = $this->default_args();

		if(is_array($options) && !empty($options)){
			$args = array_merge($default_args, $options);
		}else{
			$args = $default_args;
		}
        return $this->M_users_address->get($args);
    }

    function gets($options = array()) {
		$default_args = $this->default_args();

		if(is_array($options) && !empty($options)){
			$args = array_merge($default_args, $options);
		}else{
			$args = $default_args;
		}

        return $this->M_users_address->gets($args);
    }

    function add($data = NULL) {
        if (empty($data)) {
            return 0;
        }
        return $this->M_users_address->add($data);
    }

    function update($args, $data) {
        return $this->M_users_address->update($args, $data);
    }

    function delete($args) {
        return $this->M_users_address->delete($args);
    }

	function site_address_set_is_default() {
		$this->_initialize();
        modules::run('users/require_logged_in');

        $id = ($this->uri->segment(2) == '') ? 0 : $this->uri->segment(2);
		if ($id == 0) {
			redirect(base_url());
		}
		$row = modules::run('users/users_address/get', array('user_id' => $this->_data['userid'], 'id' => $id));
		if(!(is_array($row) && !empty($row))){
			$notify_type = 'danger';
			$notify_content = 'Sổ địa chỉ không tồn tại!';
		}else{
			$update = modules::run('users/users_address/update', array('id' => $id), array('is_default' => 1));
			if($update){
				modules::run('users/users_address/update', array('user_id' => $this->_data['userid'], 'not_in_id' => $id), array('is_default' => 0));
				$notify_type = 'success';
				$notify_content = 'Sổ địa chỉ đã được đặt là địa chỉ thanh toán mặc định!';
			} else {
				$notify_type = 'danger';
				$notify_content = 'Sổ địa chỉ chưa được đặt là địa chỉ thanh toán mặc định! Vui lòng thực hiện lại!';
			}
		}
		$this->set_notify($notify_type, $notify_content);
		redirect(site_url('so-dia-chi'));
    }

	function site_address() {
		$this->_initialize();
        modules::run('users/require_logged_in');

		$args = $this->default_args();
		$args['user_id'] = $this->_data['userid'];
		$order_by = array(
			'is_default' => 'DESC',
			'created' => 'ASC',
			'modified' => 'DESC',
		);
		$args['order_by'] = $order_by;
		$rows = $this->M_users_address->gets($args);
		$partial = array();
		$partial['data'] = $rows;
		$this->_data['rows'] = $this->load->view('layout/site/partial/address', $partial, true);

        $this->_breadcrumbs[] = array(
            'url' => current_full_url(),
            'name' => 'Sổ địa chỉ'
        );
        $this->set_breadcrumbs();

        $this->_data['provinces'] = modules::run('provinces/provinces/gets');

        $this->_data['title_seo'] = 'Sổ địa chỉ' . ' - ' . $this->_data['title_seo'];
        $this->_data['main_content'] = 'layout/site/pages/user-address-book';
        $this->load->view('layout/site/layout', $this->_data);
    }
}

/* End of file Users_address.php */
/* Location: ./application/modules/users/controllers/Users_address.php */