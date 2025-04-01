<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
include_once APPPATH . '/modules/layout/controllers/Layout.php';

class Rows extends Layout {

    private $_path = '';
    private $_module_slug = 'shops/items';
    //private $_shops_size = '336x410';
    private $_shops_size = NULL;
    private $_tag = 'shop';
	private $_allowed_field = array('status', 'inhome', 'is_featured', 'is_new', 'is_bestseller', 'is_promotion', 'is_bestview');

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->_data['breadcrumbs_module_name'] = 'Sản phẩm';
        $this->_data['module_slug'] = $this->_module_slug;
        $this->_path = get_module_path('shops');
        $this->_shops_size = $this->config->item('shops_sizes');
        $shops_sizes = $this->config->item('shops_sizes');
        $this->_data['shops_size'] = $shops_sizes['thumb'];
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
			} else if ($this->M_shops_rows->update($id, $data)) {
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
			$rows = $this->M_shops_rows->gets($args, $number, 0);
		} else {
			$rows = $this->M_shops_rows->gets($args);
		}
        if (is_array($rows) && !empty($rows)) {
            $user_id = 0;
            $cookie_user_id = $this->get_cookie_user_id();
            if (isset($_COOKIE[$cookie_user_id])) {
                $user_id = (int) get_cookie($cookie_user_id);
            }
            $users_permision_product = array();
            if ($user_id != 0) {
                $users_permision_product_rows = modules::run('users/users_permision_product/gets', array('user_id' => $user_id));
                if (is_array($users_permision_product_rows) && !empty($users_permision_product_rows)) {
                    $users_permision_product = array_column($users_permision_product_rows, 'product_id');
                }
            }

            $type = 'DEFAULT';
            foreach ($rows as $key => $value) {
                $params = '';
                if (is_array($users_permision_product) && !empty($users_permision_product) && in_array($value['id'], $users_permision_product)) {
                    $args_validate_exist = array(
                        'user_id' => $user_id,
                        'product_id' => $value['id'],
                        'type' => $type,
                    );
                    $data_user_link = modules::run('users/users_link/get', $args_validate_exist);
                    if (is_array($data_user_link) && !empty($data_user_link)) {
                        $param = base64_encode_standardized($data_user_link['user_id'] . '-' . $data_user_link['product_id'] . '-' . $type);
                        $params = '?param=' . $param . '&access=' . $data_user_link['access_token'];
                    }
                }
                $rows[$key]['params'] = $params;
            }
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
        $message['message'] = 'Kiểm tra thông tin';

        $post = $this->input->post();
        if (!empty($post)) {
            $id = $this->input->post('id');
            $data = $this->M_shops_rows->get($id);
            if (is_array($data) && !empty($data)) {
                $message['status'] = 'success';
                $message['content'] = $data;
                $message['message'] = 'Tải dữ liệu thành công!';
            } else {
                $message['status'] = 'danger';
                $message['content'] = null;
                $message['message'] = 'Có lỗi xảy ra! Vui lòng kiểm tra lại!';
            }
        }
        echo json_encode($message);
        exit();
    }

    function get_link_share_ajax() {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        $this->_initialize();

        $message = array();
        $message['status'] = 'warning';
        $message['content'] = null;
        $message['message'] = 'Kiểm tra thông tin nhập';

        $post = $this->input->post();
        if (!empty($post)) {
            if (!$this->session->has_userdata('logged_in')) {
                $message['status'] = 'warning';
                $message['content'] = null;
                $message['message'] = 'Vui lòng đăng nhập để thực hiện chức năng này!';
            } else {
                $id = $this->input->post('id');
                $data = $this->get($id);
                if (is_array($data) && !empty($data)) {
                    $query_string = '';
                    $user_id = $this->_data['userid'];
                    $type = 'DEFAULT';
                    $args_validate_exist = array(
                        'user_id' => $user_id,
                        'product_id' => $id,
                        'type' => $type,
                    );
                    $data_user_link = modules::run('users/users_link/get', $args_validate_exist);
                    if (is_array($data_user_link) && !empty($data_user_link)) {
                        $param = base64_encode_standardized($data_user_link['user_id'] . '-' . $data_user_link['product_id'] . '-' . $type);
                        $query_string = '?param=' . $param . '&access=' . $data_user_link['access_token'];
                    } else {
                        $access_token = random_string('alnum', 30);
                        while (modules::run('users/users_link/validate_exist', array('access_token' => $access_token))) {
                            $access_token = random_string('alnum', 30);
                        }
                        $time = time();
                        $args_validate_exist['access_token'] = $access_token;
                        $args_validate_exist['created'] = $time;
                        if (modules::run('users/users_link/add', $args_validate_exist)) {
                            $param = base64_encode_standardized($user_id . '-' . $id . '-' . $type);
                            $query_string = '?param=' . $param . '&access=' . $access_token;
                        }
                    }
                    $message['status'] = 'success';
                    $message['content'] = site_url($this->config->item('url_shops_rows') . '/' . $data['cat_alias'] . '/' . $data['alias'] . '-' . $data['id']) . $query_string;
                    $message['message'] = 'Đã tải dữ liệu thành công!';
                } else {
                    $message['status'] = 'danger';
                    $message['content'] = null;
                    $message['message'] = 'Có lỗi xảy ra! Vui lòng thực hiện lại!';
                }
            }
        }
        echo json_encode($message);
        exit();
    }

    function default_args() {
        $order_by = array(
			'order' => 'ASC',
			'title' => 'ASC',
            'created' => 'DESC',
            'modified' => 'DESC',
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
        return $this->M_shops_rows->counts($args);
    }

    function get($id, $alias = '') {
		$row = $this->M_shops_rows->get($id, $alias);
		if (!empty($row) && isset($row['id'])) {
			$row['options'] = $this->get_options($row['id']);
		}
		return $row;
	}

    function gets($options = array()) {
        $default_args = $this->default_args();

        if (is_array($options) && !empty($options)) {
            $args = array_merge($default_args, $options);
        } else {
            $args = $default_args;
        }

        return $this->M_shops_rows->gets($args);
    }

	function get_options($id = 0) {
		return modules::run('shops/other/gets', array('product' => $id, 'is_temp' => 0));
	}

    function get_cookie_user_id() {
        return md5(base64_encode($this->config->item('ledu_user_id')));
    }

    function get_max_order() {
        $args = $this->default_args();
        $order_by = array(
            'order' => 'DESC'
        );
        $args['order_by'] = $order_by;
        $perpage = 1;
        $offset = 0;
        $rows = $this->M_shops_rows->gets($args, $perpage, $offset);
        $max_order = isset($rows[0]['order']) ? $rows[0]['order'] : 0;

        return (int) $max_order;
    }

    function re_order() {
        $args = $this->default_args();
        $rows = $this->M_shops_rows->gets($args);
        if (!empty($rows)) {
            $i = 0;
            foreach ($rows as $value) {
                $i++;
                $data = array(
                    'order' => $i
                );
                $this->M_shops_rows->update($value['id'], $data);
            }
        }
    }

    function _get_commission_by_user($user_id = 0) {
        $data = array();
        $pay_in = modules::run('users/users_commission/get_total_value', array(
            'user_id' => $user_id,
            'status' => 1,
            'in_action' => array('PAY_IN')
        ));
        $data['pay_in'] = abs($pay_in);

        $withdrawal = $this->M_users_commission->_get_total_value(array(
            'user_id' => $user_id,
            'status' => 1,
            'in_action' => array('WITHDRAWAL')
        ));
        $data['total_withdrawal'] = abs($withdrawal);

        $transfer = $this->M_users_commission->_get_total_value(array(
            'user_id' => $user_id,
            'status' => 1,
            'in_action' => array('TRANSFER')
        ));
        $data['total_transfer'] = abs($transfer);
        //echo $data['total_transfer']; die;

        $transfered = $this->M_users_commission->_get_total_value(array(
            'user_id' => $user_id,
            'status' => 1,
            'in_action' => array('TRANSFERED')
        ));
        $data['total_transfered'] = abs($transfered);

        $total_commission_buy = $this->M_users_commission->_get_total_value(array(
            'user_id' => $user_id,
            'status' => 1,
            'in_action' => array('SUB_BUY', 'SUB_BUY_ROOT')
        ));
        $data['total_commission_buy'] = abs($total_commission_buy);

        $total_buy = $this->M_users_commission->_get_total_value(array(
            'user_id' => $user_id,
            'status' => 1,
            'in_action' => array('BUY')
        ));
        $data['total_buy'] = abs($total_buy);

        $data['balance'] = abs($transfered) + $pay_in + $total_commission_buy - abs($withdrawal) - abs($transfer);
        // echo $transfered;
        // echo "<br/>" . $pay_in;
        // echo "<br/>" . $total_commission_buy;
        // echo "<br/>" . $withdrawal;
        // echo "<br/>" . $transfer;
        // echo "<br/>" . $data['balance'];
        // die;

        return $data;
    }

    function _get_balance_by_user($user_id = 0) {
        $data = $this->_get_commission_by_user($user_id);
        return isset($data['balance']) ? $data['balance'] : 0;
    }

	function site_commission() {
		$this->_initialize();
		modules::run('users/require_logged_in');

		$this->output->cache(true);
		$user_id = $this->_data['userid'];
		$this->_data['user_id'] = $user_id;
        //echo $user_id; die;
        //
        $pay_in = modules::run('users/users_commission/get_total_value', array(
            'user_id' => $user_id,
            'status' => 1,
            'in_action' => array('PAY_IN')
        ));
        $this->_data['total_pay_in'] = abs($pay_in);

		$withdrawal = modules::run('users/users_commission/get_total_value', array(
			'user_id' => $user_id,
			'status' => 1,
			'in_action' => array('WITHDRAWAL')
		));
		$this->_data['total_withdrawal'] = abs($withdrawal);

		$total_commission_buy = modules::run('users/users_commission/get_total_value', array(
			'user_id' => $user_id,
			'status' => 1,
			'in_action' => array('SUB_BUY', 'SUB_BUY_ROOT')
		));
		$this->_data['total_commission_buy'] = $total_commission_buy;

        $total_sub_buy = modules::run('users/users_commission/get_total_value', array(
            'user_id' => $user_id,
            'status' => 1,
            'in_action' => array('SUB_BUY')
        ));
        $this->_data['total_sub_buy'] = $total_sub_buy;

        $total_sub_buy_root = modules::run('users/users_commission/get_total_value', array(
            'user_id' => $user_id,
            'status' => 1,
            'in_action' => array('SUB_BUY_ROOT')
        ));
        $this->_data['total_sub_buy_root'] = $total_sub_buy_root;

		$total_buy = modules::run('users/users_commission/get_total_value', array(
			'user_id' => $user_id,
			'status' => 1,
			'in_action' => array('BUY')
		));
		$this->_data['total_buy'] = abs($total_buy);

        $total_buy_credit_card =  modules::run('users/users_commission/get_total_value', array(
            'user_id' => $user_id,
            'status' => 1,
            'in_action' => array('BUY'),
            'payment' => 'CREDIT_CARD',
        ));
        $this->_data['total_buy_credit_card'] = abs($total_buy_credit_card);

		$this->_data['total_revenue'] = $this->_get_balance_by_user($user_id);
        //echo $this->_data['total_revenue']; die;

		$this->_breadcrumbs[] = array(
			'url' => current_url(),
			'name' => 'Ví cá nhân',
		);
		$this->set_breadcrumbs();

		$this->_data['title_seo'] = 'Ví cá nhân - ' . $this->_data['title_seo'];
		$this->_data['main_content'] = 'layout/site/pages/user-commission';
		$this->load->view('layout/site/layout', $this->_data);
	}

	function site_withdrawal() {
		$this->_initialize();
		modules::run('users/require_logged_in');

		$this->output->cache(true);
		$user_id = $this->_data['userid'];
		$user = modules::run('users/get', $user_id);
        if(!(is_array($user) || !empty($user))){
            redirect(site_url('dang-nhap'));
        }
        $this->_data['user'] = $user;

        $balance = get_balance_user($user_id);
        $this->_data['balance'] = $balance;

        $this->_plugins_script[] = array(
            'folder' => 'jquery-validation',
            'name' => 'jquery.validate'
        );
        $this->_plugins_script[] = array(
            'folder' => 'jquery-validation/localization',
            'name' => 'messages_vi'
        );
        $this->_plugins_script[] = array(
            'folder' => 'jquery-mask',
            'name' => 'jquery.mask'
        );
        $this->set_plugins();

        $this->_modules_script[] = array(
            'folder' => 'users',
            'name' => 'withdrawal-validate'
        );
        $this->set_modules();

		$post = $this->input->post();
        if (!empty($post)) {
            $this->form_validation->set_error_delimiters('<p class="required">', '</p>');;
            $this->form_validation->set_rules('amount', 'Số tiền rút', 'trim|required');

            if ($this->form_validation->run($this)) {
                $amount = filter_var($this->input->post('amount'), FILTER_SANITIZE_NUMBER_FLOAT);
                if(($amount < 0) || ($amount % 1000 != 0)){
                    $notify_type = 'danger';
                    $notify_content = 'Rút tiền không hợp lệ! Vui lòng thực hiện lại!';
                    $this->set_notify($notify_type, $notify_content);
                    redirect(current_url());
                }elseif($balance < $amount){
                    $notify_type = 'danger';
                    $notify_content = 'Số dư tài khoản không đủ điều kiện thực hiện giao dịch!';
                    $this->set_notify($notify_type, $notify_content);
                    redirect(current_url());
                }elseif($user['account_holder'] == '' || $user['account_number'] == '' || $user['bank_branch'] == ''){
                    $notify_type = 'danger';
                    $notify_content = 'Thông tin ngân hàng chưa đủ điều kiện thực hiện giao dịch!';
                    $this->set_notify($notify_type, $notify_content);
                    redirect(current_url());
                }else{
                    $action = 'WITHDRAWAL';
                    $value_cost = $amount;
                    $percent = 0;
                    $value = $amount;
                    $data_commission = array(
                        'order_id' => NULL,
                        'user_id' => $user_id,
                        'extend_by' => $user['banker_id'],
                        'action' => $action,
                        'payment' => 'CREDIT_CARD',
                        'value_cost' => $value_cost,
                        'percent' => $percent,
                        'value' => $value,
                        'message' => 'Thành viên rút tiền từ tài khoản',
                        'status' => 0,
                        'created' => time()
                    );
                    $commission_id = $this->M_users_commission->add($data_commission);
                    if($commission_id != 0){
                        $full_name = isset($user['full_name']) ? $user['full_name'] : '';
                        $site_name = $this->_data['site_name'];
                        $receiver_email = $this->_data['email'];
                        $emails = explode(',', $receiver_email);
                        $site_email = get_first_element(array_map('trim', $emails));
                        $sender_email = $site_email;
                        $sender_name = $site_name;

                        $data_commission['id'] = $commission_id;
                        $data_commission['phone'] = isset($user['phone']) ? $user['phone'] : '';
                        $data_commission['email'] = isset($user['email']) ? $user['email'] : '';
                        $data_commission['full_name'] = $full_name;

                        $partial = array();
                        $partial['data'] = $data_commission;
                        $data_sendmail = array(
                            'sender_email' => $site_email,
                            'sender_name' => $sender_name . ' - ' . $site_email,
                            'receiver_email' => $receiver_email, //mail nhan thư
                            'subject' => 'Yêu cầu rút tiền - ' . $site_name,
                            'message' => $this->load->view('layout/site/partial/html-template-withdrawal', $partial, true)
                        );
                        modules::run('emails/send_mail', $data_sendmail);
                        $notify_type = 'success';
                        $notify_content = 'Rút tiền thành công! Vui lòng chờ xác nhận!';
                    } else {
                        $notify_type = 'danger';
                        $notify_content = 'Chưa rút được tiền! Vui lòng thực hiện lại!';
                    }
                    $this->set_notify($notify_type, $notify_content);
                    redirect(current_url());
                }
            }
        }
        $this->_data['banker'] = modules::run('banker/gets');
		$this->_breadcrumbs[] = array(
			'url' => site_url('rut-tien'),
			'name' => 'Rút tiền',
		);
		$this->set_breadcrumbs();

		$this->_data['title_seo'] = 'Rút tiền - ' . $this->_data['title_seo'];
		$this->_data['main_content'] = 'layout/site/pages/user-withdrawal';
		$this->load->view('layout/site/layout', $this->_data);
	}

    function site_pay_in() {
        $this->_initialize();
        modules::run('users/require_logged_in');

        $this->output->cache(true);
        $user_id = $this->_data['userid'];
        $user = modules::run('users/get', $user_id);
        if(!(is_array($user) || !empty($user))){
            redirect(site_url('dang-nhap'));
        }
        $this->_data['user'] = $user;

        $this->_plugins_script[] = array(
            'folder' => 'jquery-validation',
            'name' => 'jquery.validate'
        );
        $this->_plugins_script[] = array(
            'folder' => 'jquery-validation/localization',
            'name' => 'messages_vi'
        );
        $this->_plugins_script[] = array(
            'folder' => 'jquery-mask',
            'name' => 'jquery.mask'
        );
        $this->set_plugins();

        $this->_modules_script[] = array(
            'folder' => 'users',
            'name' => 'pay-in-validate'
        );
        $this->set_modules();

        $post = $this->input->post();
        if (!empty($post)) {
            $this->form_validation->set_error_delimiters('<p class="required">', '</p>');;
            $this->form_validation->set_rules('amount', 'Nhập số tiền cần nạp', 'trim|required');

            if ($this->form_validation->run($this)) {
                $amount = filter_var($this->input->post('amount'), FILTER_SANITIZE_NUMBER_FLOAT);
                if(($amount < 0) || ($amount % CASH_DRAWING_MULTIPLES != 0)){
                    $notify_type = 'danger';
                    $notify_content = 'Nạp tiền không hợp lệ! Vui lòng thực hiện lại!';
                    $this->set_notify($notify_type, $notify_content);
                    redirect(current_url());
                }else{
                    $action = 'PAY_IN';
                    $value_cost = $amount;
                    $percent = 0;
                    $value = $amount;
                    $data_commission = array(
                        'order_id' => NULL,
                        'user_id' => $user_id,
                        'extend_by' => NULL,
                        'action' => $action,
                        'value_cost' => $value_cost,
                        'percent' => $percent,
                        'value' => $value,
                        'message' => 'Thành viên nạp tiền vào tài khoản',
                        'status' => 0,
                        'created' => time()
                    );
                    $commission_id = $this->M_users_commission->add($data_commission);
                    if($commission_id != 0){
                        $full_name = isset($user['full_name']) ? $user['full_name'] : '';
                        $site_name = $this->_data['site_name'];
                        $receiver_email = $this->_data['email'];
                        $emails = explode(',', $receiver_email);
                        $site_email = get_first_element(array_map('trim', $emails));
                        $sender_email = $site_email;
                        $sender_name = $site_name;

                        $data_commission['id'] = $commission_id;
                        $data_commission['phone'] = isset($user['phone']) ? $user['phone'] : '';
                        $data_commission['email'] = isset($user['email']) ? $user['email'] : '';
                        $data_commission['full_name'] = $full_name;

                        $partial = array();
                        $partial['data'] = $data_commission;
                        $data_sendmail = array(
                            'sender_email' => $site_email,
                            'sender_name' => $sender_name . ' - ' . $site_email,
                            'receiver_email' => $receiver_email, //mail nhan thư
                            'subject' => 'Yêu cầu nạp tiền - ' . $site_name,
                            'message' => $this->load->view('layout/site/partial/html-template-pay-in', $partial, true)
                        );
                        modules::run('emails/send_mail', $data_sendmail);
                        $notify_type = 'success';
                        $notify_content = 'Yêu cầu nạp tiền thành công! Vui lòng chờ xác nhận!';
                    } else {
                        $notify_type = 'danger';
                        $notify_content = 'Chưa yêu cầu nạp tiền! Vui lòng thực hiện lại!';
                    }
                    $this->set_notify($notify_type, $notify_content);
                    redirect(current_url());
                }
            }
        }
        $this->_breadcrumbs[] = array(
            'url' => site_url('nap-tien'),
            'name' => 'Nạp tiền',
        );
        $this->set_breadcrumbs();

        $this->_data['title_seo'] = 'Nạp tiền - ' . $this->_data['title_seo'];
        $this->_data['main_content'] = 'layout/site/pages/user-pay-in';
        $this->load->view('layout/site/layout', $this->_data);
    }

    function site_transfer() {
        $this->_initialize();
        modules::run('users/require_logged_in');

        $this->output->cache(true);
        $user_id = $this->_data['userid'];
        $user = modules::run('users/get', $user_id);
        if(!(is_array($user) || !empty($user))){
            redirect(site_url('dang-nhap'));
        }
        $this->_data['user'] = $user;

        $this->_plugins_script[] = array(
            'folder' => 'jquery-validation',
            'name' => 'jquery.validate'
        );
        $this->_plugins_script[] = array(
            'folder' => 'jquery-validation/localization',
            'name' => 'messages_vi'
        );
        $this->_plugins_script[] = array(
            'folder' => 'jquery-mask',
            'name' => 'jquery.mask'
        );
        $this->set_plugins();

        $this->_modules_script[] = array(
            'folder' => 'users',
            'name' => 'transfer-validate'
        );
        $this->set_modules();

        $post = $this->input->post();
        if (!empty($post)) {
            $this->form_validation->set_error_delimiters('<p class="required">', '</p>');;
            $this->form_validation->set_rules('to_user_id', 'Người nhận', 'trim|required');
            $this->form_validation->set_rules('amount', 'Số tiền cần chuyển', 'trim|required');

            if ($this->form_validation->run($this)) {
                $from_user_id = $user_id;
                $to_user_id = (int) $this->input->post('to_user_id');
                $note = $this->input->post('note');
                if(trim($note) != ''){
                    $note = " ($note)";
                }
                $payment = 'CREDIT_CARD';
                $amount = filter_var($this->input->post('amount'), FILTER_SANITIZE_NUMBER_FLOAT);
                if(($amount < 0) || ($amount % CASH_DRAWING_MULTIPLES != 0)){
                    $notify_type = 'danger';
                    $notify_content = 'Chuyển tiền không hợp lệ! Vui lòng thực hiện lại!';
                    $this->set_notify($notify_type, $notify_content);
                    redirect(current_full_url());
                }
                $balance = $this->_get_balance_by_user($user_id);
                if($balance < $amount){
                    $notify_type = 'danger';
                    $notify_content = 'Số dư tài khoản không đủ điều kiện thực hiện giao dịch!';
                    $this->set_notify($notify_type, $notify_content);
                    redirect(current_full_url());
                }

                $time = time();
                $action = 'TRANSFER';
                $value_cost = (-1) * $amount;
                $percent = 0;
                $value = (-1) * $amount;
                $data_commission = array(
                    'order_id' => NULL,
                    'user_id' => $from_user_id,
                    'extend_by' => NULL,
                    'action' => $action,
                    'payment' => $payment,
                    'value_cost' => $value_cost,
                    'percent' => $percent,
                    'value' => $value,
                    'message' => 'Thành viên chuyển tiền cho thành viên khác' . $note,
                    'status' => 1,
                    'created' => $time,
                    'verified' => $time,
                    'verify_by' => $from_user_id
                );
                $commission_id_transfer = $this->M_users_commission->add($data_commission);

                $action = 'TRANSFERED';
                $value_cost = $amount;
                $percent = 0;
                $value = $amount;
                $data_commission = array(
                    'order_id' => NULL,
                    'user_id' => $to_user_id,
                    'extend_by' => NULL,
                    'action' => $action,
                    'payment' => $payment,
                    'value_cost' => $value_cost,
                    'percent' => $percent,
                    'value' => $value,
                    'message' => 'Thành viên nhận tiền từ thành viên khác chuyển' . $note,
                    'status' => 1,
                    'created' => $time,
                    'verified' => $time,
                    'verify_by' => $from_user_id
                );
                $commission_id_transfered = $this->M_users_commission->add($data_commission);
                if($commission_id_transfer != 0 && $commission_id_transfered != 0){
                    $full_name = isset($user['full_name']) ? $user['full_name'] : '';
                    $site_name = $this->_data['site_name'];
                    $receiver_email = $this->_data['email'];
                    $emails = explode(',', $receiver_email);
                    $site_email = get_first_element(array_map('trim', $emails));
                    $sender_email = $site_email;
                    $sender_name = $site_name;

                    $data_commission['id'] = $commission_id;
                    $data_commission['phone'] = isset($user['phone']) ? $user['phone'] : '';
                    $data_commission['email'] = isset($user['email']) ? $user['email'] : '';
                    $data_commission['full_name'] = $full_name;

                    $partial = array();
                    $partial['data'] = $data_commission;
                    $data_sendmail = array(
                        'sender_email' => $site_email,
                        'sender_name' => $sender_name . ' - ' . $site_email,
                        'receiver_email' => $receiver_email, //mail nhan thư
                        'subject' => 'Chuyển tiền - ' . $site_name,
                        'message' => $this->load->view('layout/site/partial/html-template-transfer', $partial, true)
                    );
                    modules::run('emails/send_mail', $data_sendmail);
                    $notify_type = 'success';
                    $notify_content = 'Chuyển tiền thành công!';
                } else {
                    $notify_type = 'danger';
                    $notify_content = 'Có lỗi xảy ra! Vui lòng thực hiện lại!';
                }
                $this->set_notify($notify_type, $notify_content);
                redirect(current_full_url());
            }
        }
        $this->_data['users'] = modules::run('users/gets', array('role' => 'AGENCY', 'not_in_id' => array($user_id)));

        $this->_breadcrumbs[] = array(
            'url' => current_full_url(),
            'name' => 'Chuyển tiền',
        );
        $this->set_breadcrumbs();

        $this->_data['title_seo'] = 'Chuyển tiền - ' . $this->_data['title_seo'];
        $this->_data['main_content'] = 'layout/site/pages/user-transfer';
        $this->load->view('layout/site/layout', $this->_data);
    }

    function check_product_code_availablity() {
        $this->load->model('shops/m_shops_rows', 'M_shops_rows');
        $post = $this->input->post();
        $this->_message_success = 'Bạn có thể sử dụng mã này!';
        $this->_message_danger = 'Mã này đã tồn tại!';

        if (!empty($post)) {
            if ($this->input->post('ajax') == '1') {
                $product_code = $this->input->post('product_code');
                if ($this->M_shops_rows->check_product_code_availablity($product_code)) {
                    $this->_status = "success";
                    $this->_message = $this->_message_success;
                } else {
                    $this->_status = "danger";
                    $this->_message = $this->_message_danger;
                }

                $this->set_json_encode();
                $this->load->view('layout/json_data', $this->_data);
            } else {
                $product_code = $this->input->post('product_code');
                if ($this->M_shops_rows->check_product_code_availablity($product_code)) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            }
        } else {
            redirect(base_url());
        }
    }

    function get_all_data() {
        return $this->M_shops_rows->gets(array());
    }

    function get_products_bestsellers($limit = 3) {
        $rows = $this->M_shops_order_details->get_best_seller($limit);
        $result = array();
        foreach ($rows as $value) {
            $arr = array();
            $arr = $this->get($value['product_id']);
            $result[] = $arr;
        }
        return $result;
    }

    function get_top_4_rows($number = 4) {
        $order_by = array(
            'created' => 'DESC'
        );
        $args['order_by'] = $order_by;
        return $this->M_shops_rows->gets($args, $number, 0);
    }

    function get_view_most($number = 4) {
        $order_by = array(
            'hitstotal' => 'DESC'
        );
        $args['order_by'] = $order_by;
        return $this->M_shops_rows->gets($args, $number, 0);
    }

    function get_items_is_featured($limit = 8) {
        $args = $this->default_args();
        $args['is_featured'] = 1;
        $args['status'] = 1;
		if($limit > 0){
			$rows = $this->M_shops_rows->gets($args, $limit, 0);
		}else{
			$rows = $this->M_shops_rows->gets($args);
		}

        return $rows;
    }

    function site_details() {
		$this->_initialize();
        $segment = 3;
        $uri = explode("-", ($this->uri->segment($segment) == '') ? '' : $this->uri->segment($segment));
        if (count($uri) <= 1) {
            show_404();
        }
        $id = (int) end($uri);
        array_pop($uri);
        $alias = implode("-", $uri);
        if ($id == 0 || $alias == '') {
            show_404();
        }
        $row = $this->get($id);

        if (!empty($row)) {
            $title_seo = trim($row['title_seo']) != '' ? $row['title_seo'] : $row['title'];
            $keywords = $row['keywords'];
            $description = $row['description'];
            $other_seo = $row['other_seo'];
            if (trim($title_seo) != '') {
                $this->_data['title_seo'] = $title_seo . ' - ' . $this->_data['title_seo'];
            }
            if (trim($keywords) != '') {
                $this->_data['keywords'] = $keywords;
            }
            if (trim($description) != '') {
                $this->_data['description'] = $description;
            }
            if (trim($other_seo) != '') {
                $this->_data['other_seo'] = $other_seo;
            }

            $comments = modules::run('comments/gets', array('product_id' => $row['id'], 'status' => 1), true);
            $comments_stars = array(
                1 => 0,
                2 => 0,
                3 => 0,
                4 => 0,
                5 => 0
            );
            $comments_total = $comments_average = 0;
            if(is_array($comments) && !empty($comments)){
                $stars = array_column($comments, 'val');
                $arr_stars = array_count_values($stars);
                foreach($comments_stars as $stars_key => $stars_value){
                    if(isset($arr_stars[$stars_key])){
                        $comments_stars[$stars_key] = $arr_stars[$stars_key];
                    }
                }
                $comments_total = array_sum($comments_stars);
                if($comments_total != 0){
                    $comments_average = round(array_sum($stars)/$comments_total, 0);
                }
            }
            $partial = array();
            $partial['data'] = $comments;
            $row['comments'] = $this->load->view('layout/site/partial/comment_item', $partial, true);

            $partial = array();
            $partial['data'] = $comments_stars;
            $row['comments_stars'] = $this->load->view('layout/site/partial/comment_star', $partial, true);

            $partial = array();
            $partial['row']['comments_total'] = $comments_total;
            $partial['row']['comments_average'] = $comments_average;
            $row['comments_statistics'] = $this->load->view('layout/site/partial/comment_statistics', $partial, true);
            //$row['comments_total'] = $comments_total;
            //$row['comments_average'] = $comments_average;
        } else {
            show_404();
        }
        $get = $this->input->get();
        $this->_data['get'] = $get;

        $param = $this->input->get('param');
        $access_token = $this->input->get('access');

        $arr_param = explode('-', base64_decode_standardized($param));
        $user_id = isset($arr_param[0]) ? (int) $arr_param[0] : 0;

        if ($user_id != 0) {
            $cookie_user_id = $this->get_cookie_user_id();
            if (isset($_COOKIE[$cookie_user_id])) {
                delete_cookie($cookie_user_id);
            }
            $parse = parse_url(base_url());
            $cookie = array(
                'name' => $cookie_user_id,
                'value' => $user_id,
                'expire' => 86400 * 1,
                'domain' => $parse['host'],
                'path' => '/',
            );
            set_cookie($cookie);
        }

        $this->_breadcrumbs[] = array(
            'url' => site_url($this->config->item('url_shops_rows')),
            'name' => 'Sản phẩm'
        );
        $this->_breadcrumbs[] = array(
            'url' => site_url($this->config->item('url_shops_cat') . '/' . $row['cat_alias']),
            'name' => $row['cat_name']
        );
        $this->_breadcrumbs[] = array(
            'url' => site_url($this->config->item('url_shops_rows') . '/' . $row['cat_alias'] . '/' . $row['alias'] . '-' . $row['id']),
            'name' => $row['title']
        );
        $this->set_breadcrumbs();

        //tags
        $tags = modules::run('tags/tags_relationship/get_data_by_object_id', $row['id'], $this->_tag);
        $row['tags'] = array_column($tags, 'name', 'alias');

        $this->_data['h1_seo'] = $row['h1_seo'];

        $hitstotal = (int) $row['hitstotal'] + 1;
        $this->site_update_view($row['id'], $hitstotal);

        $this->_data['row'] = $row;

        $rows = $this->M_shops_rows->gets(array(
            'cat_id' => $row['listcatid'],
            'not_in_id' => $row['id'],
        ), 12, 0);
        //render partial
        $partial = array();
        $partial['data'] = $rows;
        $this->_data['related_products'] = $this->load->view('layout/site/partial/product_related', $partial, true);

        /*
		$this->_add_js[] = 'custom-single-shop';
        $this->add_js();
		*/

        $this->_data['main_content'] = 'layout/site/pages/single-shop';
        $this->load->view('layout/site/layout', $this->_data);
    }

    function site_link_share() {
        $this->_initialize();
        modules::run('users/require_logged_in');

        $this->output->cache(true);
        $this->_plugins_script[] = array(
            'folder' => 'clipboard.js/dist',
            'name' => 'clipboard',
        );
        $this->_plugins_script[] = array(
            'folder' => 'clipboard.js',
            'name' => 'app',
        );
        $this->set_plugins();

        $args = $this->default_args();
        $userid = $this->_data['userid'];
        $data_users_permision_product = modules::run('users/users_permision_product/gets', array('user_id' => $userid));
        $args['in_id'] = (is_array($data_users_permision_product) && !empty($data_users_permision_product)) ? array_column($data_users_permision_product, 'product_id', 'id') : array(0);

        $get = $this->input->get();
        $this->_data['get'] = $get;

        $total = $this->counts($args);
        $perpage = 3;
        $segment = 2;

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

        $config['base_url'] = base_url('chia-se-san-pham');
        $config['first_url'] = site_url('chia-se-san-pham');
        $config['uri_segment'] = $segment;

        $this->pagination->initialize($config);

        $pagination = $this->pagination->create_links();
        $offset = ($this->uri->segment($segment) == '') ? 0 : $this->uri->segment($segment);

        $rows = $this->M_shops_rows->gets($args, $perpage, $offset);
        $this->_data['pagination'] = $pagination;

        $user_id = 0;
        $cookie_user_id = $this->get_cookie_user_id();
        if (isset($_COOKIE[$cookie_user_id])) {
            $user_id = (int) get_cookie($cookie_user_id);
        }
        $users_permision_product = array();
        if ($user_id != 0) {
            $users_permision_product_rows = modules::run('users/users_permision_product/gets', array('user_id' => $user_id));
            if (is_array($users_permision_product_rows) && !empty($users_permision_product_rows)) {
                $users_permision_product = array_column($users_permision_product_rows, 'product_id');
            }
        }
        $partial = array();
        $partial['data'] = null;
        if (is_array($rows) && !empty($rows)) {
            $type = 'DEFAULT';
            foreach ($rows as $value) {
                if (is_array($users_permision_product) && !empty($users_permision_product) && in_array($value['id'], $users_permision_product)) {
                    $args_validate_exist = array(
                        'user_id' => $user_id,
                        'product_id' => $value['id'],
                        'type' => $type,
                    );
                    $data_user_link = modules::run('users/users_link/get', $args_validate_exist);
                    if (is_array($data_user_link) && !empty($data_user_link)) {
                        $param = base64_encode_standardized($data_user_link['user_id'] . '-' . $data_user_link['product_id'] . '-' . $type);
                        $value['params'] = '?param=' . $param . '&access=' . $data_user_link['access_token'];
                    }
                } else {
                    $value['params'] = '';
                }
                $partial['data'][] = $value;
            }
        }
        $this->_data['rows'] = $this->load->view('layout/site/partial/product-share', $partial, true);

        $this->_breadcrumbs[] = array(
            'url' => site_url('chia-se-san-pham'),
            'name' => 'Chia sẻ sản phẩm',
        );
        $this->set_breadcrumbs();

        $this->_data['title_seo'] = 'Chia sẻ sản phẩm' . ' - ' . $this->_data['title_seo'];
        $this->_data['main_content'] = 'layout/site/pages/share-shops';
        $this->load->view('layout/site/layout', $this->_data);
    }

    function index() {
		$this->_initialize();

        $this->output->cache(true);
        $args = $this->default_args();
		$order_by = array(
			'order' => 'DESC',
			'title' => 'ASC',
        );
        $args['order_by'] = $order_by;
		$get = $this->input->get();
        $this->_data['get'] = $get;

        //filters
        $data_filters = NULL;
        //brands
        $brands = $this->input->get('brands');
        $in_brands = NULL;
        if(is_array($brands) && !empty($brands)){
            $in_brands = $brands;
        }elseif(trim($brands) != ''){
            $in_brands = explode(',', $brands);
        }
        if(is_array($in_brands) && !empty($in_brands)){
            $args['in_filter_id'] = $in_brands;
            $brands = modules::run('shops/filter/gets', array('in_id' => $in_brands));
            if(is_array($brands) && !empty($brands)){
                $data_filters = array_column($brands, 'name', 'id');
            }
        }
        $this->_data['in_brands'] = $in_brands;
        $this->_data['data_filters'] = $data_filters;

        //filter
        $filter = isset($get['filter']) ? $get['filter'] : '';
        $filter_data = array_keys($this->config->item('sort', 'filter_shops'));
        if (($filter != 'default') && in_array($filter, $filter_data)) {
            switch ($get['filter']) {
            case 'title_ascending':
                $order_by = array(
                    'title' => 'ASC',
                );
                $args['order_by'] = $order_by;
                break;

            case 'title_descending':
                $order_by = array(
                    'title' => 'DESC',
                );
                $args['order_by'] = $order_by;
                break;

            case 'price_ascending':
                $order_by = array(
                    'product_price' => 'ASC',
                );
                $args['order_by'] = $order_by;
                break;

            case 'price_descending':
                $order_by = array(
                    'product_price' => 'DESC',
                );
                $args['order_by'] = $order_by;
                break;
			case 'created_descending':
                $order_by = array(
                    'created' => 'DESC',
                );
                $args['order_by'] = $order_by;
                break;
			case 'created_ascending':
                $order_by = array(
                    'created' => 'ASC',
                );
                $args['order_by'] = $order_by;
                break;
            default:
                break;
            }
        }

        $total = $this->counts($args);
        $perpage = 12; //$this->config->item('per_page') ? $this->config->item('per_page') : 8;
        $segment = 2;

        $this->load->library('pagination');
        $config['total_rows'] = $total;
        $config['per_page'] = $perpage;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul><!--pagination-->';

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

        $config['base_url'] = base_url('san-pham');
        $config['uri_segment'] = $segment;

        $this->pagination->initialize($config);

        $pagination = $this->pagination->create_links();
        $this->_data['pagination'] = $pagination;

        $offset = ($this->uri->segment($segment) == '') ? 0 : $this->uri->segment($segment);
        $rows = $this->M_shops_rows->gets($args, $perpage, $offset);

        $user_id = 0;
        $cookie_user_id = $this->get_cookie_user_id();
        if (isset($_COOKIE[$cookie_user_id])) {
            $user_id = (int) get_cookie($cookie_user_id);
        }
        $users_permision_product = array();
        if ($user_id != 0) {
            $users_permision_product_rows = modules::run('users/users_permision_product/gets', array('user_id' => $user_id));
            if (is_array($users_permision_product_rows) && !empty($users_permision_product_rows)) {
                $users_permision_product = array_column($users_permision_product_rows, 'product_id');
            }
        }
        $partial = array();
        $partial['data'] = null;
        if (is_array($rows) && !empty($rows)) {
            $type = 'DEFAULT';
            foreach ($rows as $value) {
                if (is_array($users_permision_product) && !empty($users_permision_product) && in_array($value['id'], $users_permision_product)) {
                    $args_validate_exist = array(
                        'user_id' => $user_id,
                        'product_id' => $value['id'],
                        'type' => $type,
                    );
                    $data_user_link = modules::run('users/users_link/get', $args_validate_exist);
                    if (is_array($data_user_link) && !empty($data_user_link)) {
                        $param = base64_encode_standardized($data_user_link['user_id'] . '-' . $data_user_link['product_id'] . '-' . $type);
                        $value['params'] = '?param=' . $param . '&access=' . $data_user_link['access_token'];
                    }
                } else {
                    $value['params'] = '';
                }
                $partial['data'][] = $value;
            }
        }
        $this->_data['rows'] = $this->load->view('layout/site/partial/product', $partial, true);

        $filter = modules::run('shops/filter/gets');
        $this->_data['filter'] = $filter;

        $this->_breadcrumbs[] = array(
            'url' => site_url($this->config->item('url_shops_rows')),
            'name' => 'Sản phẩm'
        );
        $this->set_breadcrumbs();

        $this->_data['title_seo'] = 'Sản phẩm' . ' - ' . $this->_data['title_seo'];
        $this->_data['main_content'] = 'layout/site/pages/shops';
        $this->load->view('layout/site/layout', $this->_data);
    }

    function site_search() {
		$this->_initialize();

        $get = $this->input->get();
        if (!(isset($get['q']) && trim($get['q']) != '')) {
            redirect(base_url());
        }
        $this->_data['get'] = $get;

        $args = $this->default_args();
        if (isset($get['q']) && trim($get['q']) != '') {
            $args['q'] = $get['q'];
        }
        $total = $this->counts($args);
        $perpage = 12;
        $segment = 2;

        $this->load->library('pagination');
        $config['total_rows'] = $total;
        $config['per_page'] = $perpage;
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

        $config['base_url'] = base_url('search');
        $config['suffix'] = '?' . http_build_query($get, '', "&");
        $config['first_url'] = site_url('search') . '?' . http_build_query($get, '', "&");
        $config['uri_segment'] = $segment;

        $this->pagination->initialize($config);

        $pagination = $this->pagination->create_links();
        $this->_data['pagination'] = $pagination;

        $offset = ($this->uri->segment($segment) == '') ? 0 : $this->uri->segment($segment);
        $rows = $this->M_shops_rows->gets($args, $perpage, $offset);

        $user_id = 0;
        $cookie_user_id = $this->get_cookie_user_id();
        if (isset($_COOKIE[$cookie_user_id])) {
            $user_id = (int) get_cookie($cookie_user_id);
        }
        $users_permision_product = array();
        if ($user_id != 0) {
            $users_permision_product_rows = modules::run('users/users_permision_product/gets', array('user_id' => $user_id));
            if (is_array($users_permision_product_rows) && !empty($users_permision_product_rows)) {
                $users_permision_product = array_column($users_permision_product_rows, 'product_id');
            }
        }
        $partial = array();
        $partial['data'] = null;
        if (is_array($rows) && !empty($rows)) {
            $type = 'DEFAULT';
            foreach ($rows as $value) {
                if (is_array($users_permision_product) && !empty($users_permision_product) && in_array($value['id'], $users_permision_product)) {
                    $args_validate_exist = array(
                        'user_id' => $user_id,
                        'product_id' => $value['id'],
                        'type' => $type,
                    );
                    $data_user_link = modules::run('users/users_link/get', $args_validate_exist);
                    if (is_array($data_user_link) && !empty($data_user_link)) {
                        $param = base64_encode_standardized($data_user_link['user_id'] . '-' . $data_user_link['product_id'] . '-' . $type);
                        $value['params'] = '?param=' . $param . '&access=' . $data_user_link['access_token'];
                    }
                } else {
                    $value['params'] = '';
                }
                $partial['data'][] = $value;
            }
        }
        $this->_data['rows'] = $this->load->view('layout/site/partial/product', $partial, true);

		$this->_breadcrumbs[] = array(
            'url' => current_url(),
            'name' => 'Tìm kiếm'
        );
        $this->set_breadcrumbs();

        $this->_data['title_seo'] = 'Kết quả tìm kiếm' . ' - ' . $this->_data['title_seo'];
        $this->_data['main_content'] = 'layout/site/pages/search-shop';
        $this->load->view('layout/site/layout', $this->_data);
    }

    function counts_all() {
        return $this->counts(array());
    }

    function site_items_in_tags() {
		$this->_initialize();

        $segment = 2;
        $uri = explode("-", ($this->uri->segment($segment) == '') ? '' : $this->uri->segment($segment));
        if (count($uri) <= 1) {
            show_404();
        }
        $id = (int) end($uri);
        array_pop($uri);
        $alias = implode("-", $uri);
        if ($id == 0 || $alias == '') {
            show_404();
        }
        $row = modules::run('tags/get', $id);
        if (empty($row)) {
            show_404();
        }

        $data = modules::run('tags/tag_targets/get_by_tag_type', $id, $this->_tag_type_id);
        $in_id = array(0);
        if (empty($data)) {
            show_404();
        } else {
            foreach ($data as $value) {
                $in_id[] = $value['value'];
            }
        }
        $this->output->cache(true);


        $this->_data['title_seo'] = 'Kết quả  cho từ khóa: ' . $row['tag_name'] . ' - ' . $this->_data['title_seo'];

        $args = $this->default_args();
        $args['in_id'] = $in_id;
        $total = $this->counts($args);
        $perpage = $this->config->item('per_page') ? $this->config->item('per_page') : 10;

        $this->load->library('pagination');
        $config['total_rows'] = $total;
        $config['per_page'] = $perpage;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul><!--pagination-->';

        $config['first_link'] = '&laquo;';
        $config['first_tag_open'] = '<li class="prev page">';
        $config['first_tag_close'] = '</li>';

        $config['last_link'] = '&raquo;';
        $config['last_tag_open'] = '<li class="next page">';
        $config['last_tag_close'] = '</li>';

        $config['next_link'] = '&rarr;';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>';

        $config['prev_link'] = '&larr;';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="active"><a href="">';
        $config['cur_tag_close'] = '</a></li>';

        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>';

        $segment = 3;
        $config['base_url'] = base_url('tags/' . $row['tag_slug'] . '-' . $id);
        $config['uri_segment'] = $segment;
        $config['first_url'] = site_url('tags/' . $row['tag_slug'] . '-' . $id);

        $this->pagination->initialize($config);

        $pagination = $this->pagination->create_links();
        $this->_data['pagination'] = $pagination;

        $offset = ($this->uri->segment($segment) == '') ? 0 : $this->uri->segment($segment);
        $rows = $this->M_shops_rows->gets($args, $perpage, $offset);

        $user_id = 0;
        $cookie_user_id = $this->get_cookie_user_id();
        if (isset($_COOKIE[$cookie_user_id])) {
            $user_id = (int) get_cookie($cookie_user_id);
        }
        $users_permision_product = array();
        if ($user_id != 0) {
            $users_permision_product_rows = modules::run('users/users_permision_product/gets', array('user_id' => $user_id));
            if (is_array($users_permision_product_rows) && !empty($users_permision_product_rows)) {
                $users_permision_product = array_column($users_permision_product_rows, 'product_id');
            }
        }
        $partial = array();
        $partial['data'] = null;
        if (is_array($rows) && !empty($rows)) {
            $type = 'DEFAULT';
            foreach ($rows as $value) {
                if (is_array($users_permision_product) && !empty($users_permision_product) && in_array($value['id'], $users_permision_product)) {
                    $args_validate_exist = array(
                        'user_id' => $user_id,
                        'product_id' => $value['id'],
                        'type' => $type,
                    );
                    $data_user_link = modules::run('users/users_link/get', $args_validate_exist);
                    if (is_array($data_user_link) && !empty($data_user_link)) {
                        $param = base64_encode_standardized($data_user_link['user_id'] . '-' . $data_user_link['product_id'] . '-' . $type);
                        $value['params'] = '?param=' . $param . '&access=' . $data_user_link['access_token'];
                    }
                } else {
                    $value['params'] = '';
                }
                $partial['data'][] = $value;
            }
        }
        $this->_data['rows'] = $this->load->view('layout/site/partial/product', $partial, true);

        $this->_breadcrumbs[] = array(
            'url' => $config['first_url'],
            'name' => $row['tag_name']
        );
        $this->set_breadcrumbs();

        $this->_data['main_content'] = 'layout/site/pages/tags-shops';
        $this->load->view('layout/site/layout', $this->_data);
    }

    function site_items_in_listcatid() {
		$this->_initialize();

        $segment = 2;
        $cat_alias = ($this->uri->segment($segment) == '') ? '' : $this->uri->segment($segment);
        if (trim($cat_alias) == '') {
            show_404();
        }
        $data = modules::run('shops/cat/get_in_alias', $cat_alias);
        if (empty($data)) {
            show_404();
        }
        $this->output->cache(true);
		$title_seo = trim($data['title_seo']) != '' ? $data['title_seo'] : $data['name'];
        $keywords = $data['keywords'];
        $description = $data['description'];
        $other_seo = $data['other_seo'];

        if (trim($title_seo) != '') {
            $this->_data['title_seo'] = $title_seo . ' - ' . $this->_data['title_seo'];
        }
        if (trim($keywords) != '') {
            $this->_data['keywords'] = $keywords;
        }
        if (trim($description) != '') {
            $this->_data['description'] = $description;
        }
        if (trim($other_seo) != '') {
            $this->_data['other_seo'] = $other_seo;
        }
        $get = $this->input->get();
        $this->_data['get'] = $get;

        $cat_id = $data['id'];
		$childs = $this->M_shops_cat->get_child($cat_id);
		if(is_array($childs) && !empty($childs)){
			$main_content = 'cat-shops-child';
			foreach ($childs as $key => $value) {
				$childs[$key]['items'] = $this->get_items_in_cat_id($value['id'], 8);
			}
			$partial = array();
			$partial['data'] = $childs;
			$this->_data['rows'] = $this->load->view('layout/site/partial/cat-item', $partial, true);
		}else{
			$main_content = 'cat-shops';
			$in_cat_id[] = $cat_id;
			$cat = modules::run('shops/cat/gets');
			$in_cat_id = array_merge($in_cat_id, get_children($cat_id, $cat['data_list'], $cat['data_input']));

			$args = $this->default_args();
			$args['in_cat_id'] = $in_cat_id;
			$order_by = array(
				'order' => 'DESC',
				'title' => 'ASC',
			);
			$args['order_by'] = $order_by;

			//filter
			//$filter = isset($get['filter']) ? $get['filter'] : '';
			//$filter_data = array_keys($this->config->item('sort', 'filter_shops'));
			//if (($filter != 'default') && in_array($filter, $filter_data)) {
			//if (($filter != 'default')) {
				/*switch ($get['filter']) {
				case 'title_ascending':
					$order_by = array(
						'title' => 'ASC',
					);
					$args['order_by'] = $order_by;
					break;

				case 'title_descending':
					$order_by = array(
						'title' => 'DESC',
					);
					$args['order_by'] = $order_by;
					break;

				case 'price_ascending':
					$order_by = array(
						'product_price' => 'ASC',
					);
					$args['order_by'] = $order_by;
					break;

				case 'price_descending':
					$order_by = array(
						'product_price' => 'DESC',
					);
					$args['order_by'] = $order_by;
					break;
				case 'addtime_descending':
					$order_by = array(
						'created' => 'DESC',
					);
					$args['order_by'] = $order_by;
					break;
				case 'addtime_ascending':
					$order_by = array(
						'created' => 'ASC',
					);
					$args['order_by'] = $order_by;
					break;
				default:
					break;
				}
			}*/
			$total = $this->counts($args);
			$perpage = 12; //$this->config->item('per_page') ? $this->config->item('per_page') : 10;

			$this->load->library('pagination');
			$config['total_rows'] = $total;
			$config['per_page'] = $perpage;
			$config['full_tag_open'] = '<ul class="pagination">';
			$config['full_tag_close'] = '</ul><!--pagination-->';

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

			$segment++;
			$config['base_url'] = base_url($this->config->item('url_shops_cat') . '/' . $cat_alias);
			$config['uri_segment'] = $segment;
			$config['first_url'] = site_url($this->config->item('url_shops_cat') . '/' . $cat_alias);

			$this->pagination->initialize($config);

			$pagination = $this->pagination->create_links();
			$offset = ($this->uri->segment($segment) == '') ? 0 : $this->uri->segment($segment);

			$rows = $this->M_shops_rows->gets($args, $perpage, $offset);
			$this->_data['pagination'] = $pagination;

			$user_id = 0;
            $cookie_user_id = $this->get_cookie_user_id();
            if (isset($_COOKIE[$cookie_user_id])) {
                $user_id = (int) get_cookie($cookie_user_id);
            }
            $users_permision_product = array();
            if ($user_id != 0) {
                $users_permision_product_rows = modules::run('users/users_permision_product/gets', array('user_id' => $user_id));
                if (is_array($users_permision_product_rows) && !empty($users_permision_product_rows)) {
                    $users_permision_product = array_column($users_permision_product_rows, 'product_id');
                }
            }
            $partial = array();
            $partial['data'] = null;
            if (is_array($rows) && !empty($rows)) {
                $type = 'DEFAULT';
                foreach ($rows as $value) {
                    if (is_array($users_permision_product) && !empty($users_permision_product) && in_array($value['id'], $users_permision_product)) {
                        $args_validate_exist = array(
                            'user_id' => $user_id,
                            'product_id' => $value['id'],
                            'type' => $type,
                        );
                        $data_user_link = modules::run('users/users_link/get', $args_validate_exist);
                        if (is_array($data_user_link) && !empty($data_user_link)) {
                            $param = base64_encode_standardized($data_user_link['user_id'] . '-' . $data_user_link['product_id'] . '-' . $type);
                            $value['params'] = '?param=' . $param . '&access=' . $data_user_link['access_token'];
                        }
                    } else {
                        $value['params'] = '';
                    }
                    $partial['data'][] = $value;
                }
            }
            $this->_data['rows'] = $this->load->view('layout/site/partial/product', $partial, true);
		}
        $cat_title = $data['name'];
        $this->_data['row'] = $data;

        $this->_breadcrumbs[] = array(
            'url' => site_url($this->config->item('url_shops_rows')),
            'name' => 'Sản phẩm'
        );

        $this->_breadcrumbs[] = array(
            'url' => site_url($this->config->item('url_shops_cat') . '/' . $cat_alias),
            'name' => $cat_title
        );
        $this->set_breadcrumbs();

        $this->_data['main_content'] = 'layout/site/pages/' . $main_content;
        $this->load->view('layout/site/layout', $this->_data);
    }

    function get_items_in_cat_id($cat_id = 0, $limit = 8) {
        $in_cat_id[] = $cat_id;
        $cat = modules::run('shops/cat/gets');
        $in_cat_id = array_merge($in_cat_id, get_children($cat_id, $cat['data_list'], $cat['data_input']));

        $args = $this->default_args();
        $args['in_cat_id'] = $in_cat_id;

        if ($limit > 0) {
            $rows = $this->M_shops_rows->gets($args, $limit, 0);
        } else {
            $rows = $this->M_shops_rows->gets($args);
        }

        if (is_array($rows) && !empty($rows)) {
            $user_id = 0;
            $cookie_user_id = $this->get_cookie_user_id();
            if (isset($_COOKIE[$cookie_user_id])) {
                $user_id = (int) get_cookie($cookie_user_id);
            }
            $users_permision_product = array();
            if ($user_id != 0) {
                $users_permision_product_rows = modules::run('users/users_permision_product/gets', array('user_id' => $user_id));
                if (is_array($users_permision_product_rows) && !empty($users_permision_product_rows)) {
                    $users_permision_product = array_column($users_permision_product_rows, 'product_id');
                }
            }

            $type = 'DEFAULT';
            foreach ($rows as $key => $value) {
                $params = '';
                if (is_array($users_permision_product) && !empty($users_permision_product) && in_array($value['id'], $users_permision_product)) {
                    $args_validate_exist = array(
                        'user_id' => $user_id,
                        'product_id' => $value['id'],
                        'type' => $type,
                    );
                    $data_user_link = modules::run('users/users_link/get', $args_validate_exist);
                    if (is_array($data_user_link) && !empty($data_user_link)) {
                        $param = base64_encode_standardized($data_user_link['user_id'] . '-' . $data_user_link['product_id'] . '-' . $type);
                        $params = '?param=' . $param . '&access=' . $data_user_link['access_token'];
                    }
                }
                $rows[$key]['params'] = $params;
            }
        }

        return $rows;
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
        $this->_init_fancybox();

        $this->_modules_script[] = array(
            'folder' => 'shops',
            'name' => 'admin-items'
        );
        $this->set_modules();

        $get = $this->input->get();
        $this->_data['get'] = $get;

        $args = $this->default_args();
		$order_by = array(
			'order' => 'DESC',
			'title' => 'ASC',
        );
        $args['order_by'] = $order_by;

        $shops_cat = modules::run('shops/cat/gets');
        $this->_data['shops_cat'] = $shops_cat;
		if (isset($get['catid']) && ($get['catid'] != 0)) {
            $catid = $get['catid'];
            $listcatid[] = (int) $catid;
            $listcatid = array_merge($listcatid, get_children($catid, $shops_cat['data_list'], $shops_cat['data_input']));
            $args['in_cat_id'] = $listcatid;
        }
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

        $rows = $this->M_shops_rows->gets($args, $perpage, $offset);
        $this->_data['rows'] = $rows;
        $this->_data['pagination'] = $pagination;

        $this->_data['title'] = 'Danh sách sản phẩm - ' . $this->_data['title'];
        $this->_data['main_content'] = 'shops/admin/view_page_index';
        $this->load->view('layout/admin/view_layout', $this->_data);
    }

    function admin_add() {
        $data = array(
            'user_id' => $this->_data['userid'],
            'filter_id' => $this->input->post('filter_id'),
            'listcatid' => $this->input->post('catid'),
            'title' => $this->input->post('title'),
            'alias' => $this->input->post('alias'),
            'homeimgalt' => $this->input->post('homeimgalt'),
            'hometext' => $this->input->post('hometext'),
            'bodyhtml' => $this->input->post('bodyhtml'),
            'h1_seo' => $this->input->post('h1_seo'),
            'title_seo' => $this->input->post('title_seo'),
            'description' => $this->input->post('description'),
            'keywords' => $this->input->post('keywords'),
            'other_seo' => $this->input->post('other_seo'),
            'stock_status' => $this->input->post('stock_status'),
            'product_code' => $this->input->post('product_code'),
            'product_price' => filter_var($this->input->post('product_price'), FILTER_SANITIZE_NUMBER_INT),
            'product_discount_percent' => filter_var($this->input->post('product_discount_percent'), FILTER_SANITIZE_NUMBER_FLOAT),
            'product_sales_price' => filter_var($this->input->post('product_sales_price'), FILTER_SANITIZE_NUMBER_INT),
            'commission' => filter_var($this->input->post('commission'), FILTER_SANITIZE_NUMBER_FLOAT),
            'is_bestseller' => $this->input->post('is_bestseller') ? 1 : 0,
            'is_promotion' => $this->input->post('is_promotion') ? 1 : 0,
            'is_bestview' => $this->input->post('is_bestview') ? 1 : 0,
            'is_featured' => $this->input->post('is_featured') ? 1 : 0,
            'is_new' => $this->input->post('is_new') ? 1 : 0,
            'inhome' => $this->input->post('inhome') ? 1 : 0,
            'status' => 1,
            'order' => $this->get_max_order() + 1,
            'created' => time(),
            'modified' => 0,
        );

        return $this->M_shops_rows->add($data);
    }

    function site_update_view($id = 0, $view) {
        $data = array('hitstotal' => $view);
        return $this->M_shops_rows->update($id, $data);
    }

    function admin_update($id) {
        $data = array(
            'listcatid' => $this->input->post('catid'),
            'filter_id' => $this->input->post('filter_id'),
            'title' => $this->input->post('title'),
            'alias' => $this->input->post('alias'),
            'homeimgalt' => $this->input->post('homeimgalt'),
            'hometext' => $this->input->post('hometext'),
            'bodyhtml' => $this->input->post('bodyhtml'),
            'h1_seo' => $this->input->post('h1_seo'),
            'title_seo' => $this->input->post('title_seo'),
            'description' => $this->input->post('description'),
            'keywords' => $this->input->post('keywords'),
            'other_seo' => $this->input->post('other_seo'),
            'stock_status' => $this->input->post('stock_status'),
            'product_code' => $this->input->post('product_code'),
            'product_price' => filter_var($this->input->post('product_price'), FILTER_SANITIZE_NUMBER_INT),
			'product_discount_percent' => filter_var($this->input->post('product_discount_percent'), FILTER_SANITIZE_NUMBER_FLOAT),
            'product_sales_price' => filter_var($this->input->post('product_sales_price'), FILTER_SANITIZE_NUMBER_INT),
            'commission' => filter_var($this->input->post('commission'), FILTER_SANITIZE_NUMBER_FLOAT),
            'is_bestseller' => $this->input->post('is_bestseller') ? 1 : 0,
            'is_promotion' => $this->input->post('is_promotion') ? 1 : 0,
            'is_bestview' => $this->input->post('is_bestview') ? 1 : 0,
            'is_featured' => $this->input->post('is_featured') ? 1 : 0,
            'is_new' => $this->input->post('is_new') ? 1 : 0,
            'inhome' => $this->input->post('inhome') ? 1 : 0,
            'modified' => time(),
        );

        return $this->M_shops_rows->update($id, $data);
    }

    function admin_delete() {
		$this->_initialize_admin();
        $this->redirect_admin();

        $this->_message_success = 'Đã xóa sản phẩm!';
        $this->_message_warning = 'Sản phẩm này không tồn tại!';
		$id = $this->input->get('id');
		if ($id != 0) {
			$row = $this->get($id);
			if ($this->M_shops_rows->delete($id)) {
				@unlink(FCPATH . $this->_path . $row['homeimgfile']);
				if (isset($row['options']) && is_array($row['options']) && !empty($row['options'])){
					foreach ($row['options'] as $value){
						@unlink(FCPATH . $this->_path . $value['image']);
					}
					modules::run('shops/other/delete', array('product' => $id));
				}
				$this->re_order();
				modules::run('tags/delete', 'shops', $id);
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

    function admin_main() {
		$this->_initialize_admin();
        $this->redirect_admin();
        $post = $this->input->post();
        if (!empty($post)) {
            $action = $this->input->post('action');
            if ($action == 'delete') {
                $this->_message_success = 'Đã xóa các sản phẩm được chọn!';
                $this->_message_warning = 'Bạn chưa chọn sản phẩm nào!';
                $ids = $this->input->post('idcheck');

                if (is_array($ids) && !empty($ids)) {
                    foreach ($ids as $id) {
						$row = $this->get($id);
						if ($this->M_shops_rows->delete($id)) {
							@unlink(FCPATH . $this->_path . $row['homeimgfile']);
							if (isset($row['options']) && is_array($row['options']) && !empty($row['options'])){
								foreach ($row['options'] as $value){
									@unlink(FCPATH . $this->_path . $value['image']);
								}
								modules::run('shops/other/delete', array('product' => $id));
							}
                            modules::run('tags/delete', 'shops', $id);
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
                redirect(get_admin_url('shops/content'));
            } elseif ($action == 'update') {
                $this->_message_success = 'Đã cập nhật sản phẩm!';
                $this->_message_warning = 'Không có sản phẩm nào để cập nhật!';
                $ids = $this->input->post('ids');
                $orders = $this->input->post('order');
                $count = count($orders);
                if (!empty($ids) && !empty($orders)) {
                    for ($i = 0; $i < $count; $i++) {
                        $data = array(
                            'order' => $orders[$i]
                        );
                        $id = $ids[$i];
                        if ($this->M_shops_rows->update($id, $data)) {
                            $notify_type = 'success';
                            $notify_content = $this->_message_success;
                            $this->output->clearCache();
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
            'folder' => 'tagmanager',
            'name' => 'tagmanager'
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'tagmanager',
            'name' => 'tagmanager'
        );

        $this->_plugins_script_admin[] = array(
            'folder' => 'jquery-mask',
            'name' => 'jquery.mask'
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
            'folder' => 'shops',
            'name' => 'admin-content-validate'
        );
        $this->set_modules();

        $post = $this->input->post();
        if (!empty($post)) {
            $this->load->helper('language');
            $this->lang->load('form_validation', 'vietnamese');
            $this->lang->load('cat', 'vietnamese');

            $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');
            $this->form_validation->set_rules('title', 'Tên sản phẩm', 'trim|required');
            $this->form_validation->set_rules('alias', 'Liên kết tĩnh', 'trim|required');

            if ($this->form_validation->run($this)) {
                $data_filter = $this->input->post('filter');
                if ($this->input->post('id')) {
                    $err = FALSE;
                    $id = $this->input->post('id');
                    if (!$this->admin_update($id)) {
                        $err = TRUE;
                    } else {
                        //upload images
                        $this->_upload_images($id, 'homeimg');
                        $this->_upload_images_options($id);

                        // $this->_upload_images_1($id, 'homeimg_1');
						// $this->_upload_images_options_1($id);
                        //filter
						$data_filter_details = modules::run('shops/filter_details/gets', array('product_id' => $id));
						$data_filter_details_current = (is_array($data_filter_details) && !empty($data_filter_details)) ? array_column($data_filter_details, 'filter_id', 'id') : array(-1);

						$in_filter_id = array_diff((array)$data_filter_details_current, (array)$data_filter);
						if(empty($in_filter_id)){
							$in_filter_id = array(-1);
						}
						modules::run('shops/filter_details/delete', array('in_filter_id' => $in_filter_id));

						if(is_array($data_filter) && !empty($data_filter)){
							foreach($data_filter as $value){
								if($value != 0){
									$arr_validate_exist = array(
										'product_id' => $id,
										'filter_id' => $value,
									);
									if(modules::run('shops/filter_details/get', $arr_validate_exist)){
										modules::run('shops/filter_details/update', $arr_validate_exist, array(
											'modified' => time()
										));
									}else{
										$arr_validate_exist['created'] = time();
										$arr_validate_exist['modified'] = 0;
										modules::run('shops/filter_details/add', $arr_validate_exist);
									}
									unset($arr_validate_exist);
								}
							}
						}
                        //tags
                        $tags_value = $this->input->post('hidden-tags');
                        $arr_tags = explode(',', $tags_value);
                        if (is_array($arr_tags) && !empty($arr_tags)) {
                            $tags = modules::run('tags/tags_relationship/get_data_by_object_id', $id, $this->_tag);
                            $tags_id = array_column($tags, 'tag_id');
                            modules::run('tags/admin_delete', $tags_id);
                            modules::run('tags/tags_relationship/admin_delete_by_object_id', $id, $this->_tag);

                            foreach ($arr_tags as $value) {
                                $data_tags = array(
                                    'name' => $value,
                                    'alias' => strtolower(url_title(alias($value)))
                                );
                                $tag_id = modules::run('tags/admin_add', $data_tags);

                                //tags relationship
                                $data_tags_relationship = array(
                                    'tag_id' => $tag_id,
                                    'object_id' => $id,
                                    'module' => $this->_tag
                                );
                                modules::run('tags/tags_relationship/admin_add', $data_tags_relationship);
                            }
                        }
                    }
                    if ($err === FALSE) {
                        $this->output->clearCache();
                        $notify_type = 'success';
                        $notify_content = 'Cập nhật sản phẩm thành công!';
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
                    } else {
                        //upload images
                        $this->_upload_images($insert_id, 'homeimg');
                        $this->_upload_images_options($insert_id);

                        // $this->_upload_images_1($insert_id, 'homeimg_1');
						// $this->_upload_images_options_1($insert_id);
                        //upload data_filter
						if(is_array($data_filter) && !empty($data_filter)){
							foreach($data_filter as $value){
								if($value != 0){
									$arr_validate_exist = array(
										'product_id' => $insert_id,
										'filter_id' => $value,
									);
									if(modules::run('shops/filter_details/get', $arr_validate_exist)){
										modules::run('shops/filter_details/update', $arr_validate_exist, array(
											'modified' => time()
										));
									}else{
										$arr_validate_exist['created'] = time();
										$arr_validate_exist['modified'] = 0;
										modules::run('shops/filter_details/add', $arr_validate_exist);
									}
									unset($arr_validate_exist);
								}
							}
						}

                        //tags
                        $tags_value = $this->input->post('hidden-tags');
                        $arr_tags = explode(',', $tags_value);
                        if (is_array($arr_tags) && !empty($arr_tags)) {
                            foreach ($arr_tags as $value) {
                                $data_tags = array(
                                    'name' => $value,
                                    'alias' => strtolower(url_title(alias($value)))
                                );
                                $tag_id = modules::run('tags/admin_add', $data_tags);

                                //tags relationship
                                $data_tags_relationship = array(
                                    'tag_id' => $tag_id,
                                    'object_id' => $insert_id,
                                    'module' => $this->_tag
                                );
                                modules::run('tags/tags_relationship/admin_add', $data_tags_relationship);
                            }
                        }
                    }

                    if ($err === FALSE) {
                        $this->output->clearCache();
                        $notify_type = 'success';
                        $notify_content = 'Sản phẩm đã được thêm!';
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

        $this->load->library('ckeditor', array('instanceName' => 'CKEDITOR1', 'basePath' => base_url() . "ckeditor/", 'outPut' => true));
        $title = 'Thêm sản phẩm - ' . $this->_data['breadcrumbs_module_name'] . ' - ' . $this->_data['title'];

        $is_temp = modules::run('shops/other/gets', array('is_temp' => 1));
		if(is_array($is_temp) && !empty($is_temp)){
			foreach($is_temp as $value){
				@unlink(FCPATH . $this->_path . $value['image']);
			}
			modules::run('shops/other/delete', array('is_temp' => 1));
		}
        $segment = 4;
		$id = ($this->uri->segment($segment) == '') ? 0 : $this->uri->segment($segment);
        if ($id != 0) {
            $row = $this->get($id);
            $tags = modules::run('tags/tags_relationship/get_data_by_object_id', $row['id'], $this->_tag);
            $row['tags'] = implode(',', array_column($tags, 'name'));
            //filter
			$data_filter_details = modules::run('shops/filter_details/gets', array('product_id' => $id));
			$row['filter'] = array_column($data_filter_details, 'filter_id');

            $this->_data['row'] = $row;
            $title = 'Cập nhật sản phẩm - ' . $this->_data['breadcrumbs_module_name'] . ' - ' . $this->_data['title'];
        }
        $this->_data['shops_cat'] = modules::run('shops/cat/gets');

        $filter = modules::run('shops/filter/gets');
		$this->_data['filter'] = $filter;

        $this->_data['title'] = $title;
        $this->_data['main_content'] = 'shops/admin/view_page_content';
        $this->load->view('layout/admin/view_layout', $this->_data);
    }

    private function _upload_images($id, $input_name) {
		$watermark_image = get_module_path('logo') . modules::run('configs/get_config_value', 'watermark_image');
        $watermark_opacity = modules::run('configs/get_config_value', 'watermark_opacity');
        $row = $this->get($id);
        $info = modules::run('files/index', $input_name, $this->_path);
        if (isset($info['uploads'])) {
            $upload_images = $info['uploads']; // thông tin ảnh upload
            if ($_FILES[$input_name]['size'] != 0) {
                foreach ($upload_images as $value) {
                    $file_name = $value['file_name']; //tên ảnh
                    $data_images = array(
                        'homeimgfile' => $file_name
                    );
                    $this->M_shops_rows->update($id, $data_images);
					modules::run('files/watermark_overlay', './' . $this->_path . $file_name, './' . $watermark_image, array('wm_opacity' => $watermark_opacity));
                }
                @unlink(FCPATH . $this->_path . $row['homeimgfile']);
            }
        }
    }

	private function _upload_images_options($id) {
		$option_ids = $this->input->post('option_id');
		if(is_array($option_ids) && !empty($option_ids)){
			modules::run('shops/other/update', array('in_id' => $option_ids), array(
				'product' => $id,
				'is_temp' => 0,
				'edittime' => time(),
			));
		}
    }

    // private function _upload_images_1($id, $input_name) {
	// 	$watermark_image = get_module_path('logo') . modules::run('configs/get_config_value', 'watermark_image');
    //     $watermark_opacity = modules::run('configs/get_config_value', 'watermark_opacity');
    //     $row = $this->get($id);
    //     $info = modules::run('files/index', $input_name, $this->_path);
    //     if (isset($info['uploads'])) {
    //         $upload_images = $info['uploads']; // thông tin ảnh upload
    //         if ($_FILES[$input_name]['size'] != 0) {
    //             foreach ($upload_images as $value) {
    //                 $file_name = $value['file_name']; //tên ảnh
    //                 $data_images = array(
    //                     'homeimgfile_1' => $file_name
    //                 );
    //                 $this->M_shops_rows->update($id, $data_images);
	// 				modules::run('files/watermark_overlay', './' . $this->_path . $file_name, './' . $watermark_image, array('wm_opacity' => $watermark_opacity));
    //             }
    //             @unlink(FCPATH . $this->_path . $row['homeimgfile_1']);
    //         }
    //     }
    // }

	// private function _upload_images_options_1($id) {
	// 	$option_ids = $this->input->post('option_id');
	// 	if(is_array($option_ids) && !empty($option_ids)){
	// 		modules::run('shops/other/update', array('in_id' => $option_ids), array(
	// 			'product' => $id,
	// 			'is_temp' => 0,
	// 			'edittime' => time(),
	// 		));
	// 	}
	// }

	function ajax_upload() {
		$name_input = 'files';
		$dir = $this->_path;
		$options = array();
		$options['allowed_types'] = "gif|jpg|jpeg|png";
		$this->_upload($name_input, $dir, $options);
	}

	function _upload($name_input = 'file', $dir = 'uploads/', $options = array()) {
		if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        $message = array();
        $message['status'] = 'warning';
        $message['content'] = null;
        $message['message'] = 'Kiểm tra thông tin nhập';

		$data_success = array();
		$data_temp = array();
		$data_error = array();

        $watermark_image = get_module_path('logo') . modules::run('configs/get_config_value', 'watermark_image');
        $watermark_opacity = modules::run('configs/get_config_value', 'watermark_opacity');
		if (isset($_FILES[$name_input])) {
			$product = filter_var($this->input->post('product'), FILTER_SANITIZE_NUMBER_INT);
			$order = $this->input->post('order');
            $number_of_files = sizeof($_FILES[$name_input]['tmp_name']);
            $files = $_FILES[$name_input];

			$this->load->library('upload');
			$config['upload_path'] = FCPATH . $dir;
			$config['max_size'] = '1024*10';
			if (isset($options['allowed_types']) && trim($options['allowed_types']) != '') {
				$config['allowed_types'] = $options['allowed_types'];
			} else {
				$config['allowed_types'] = '*'; //default
			}
			for ($i = 0; $i < $number_of_files; $i++) {
				$_FILES[$name_input]['name'] = $files['name'][$i];
				$_FILES[$name_input]['type'] = $files['type'][$i];
				$_FILES[$name_input]['tmp_name'] = $files['tmp_name'][$i];
				$_FILES[$name_input]['error'] = $files['error'][$i];
				$_FILES[$name_input]['size'] = $files['size'][$i];
				$name = alias(pathinfo($files['name'][$i], PATHINFO_FILENAME));
				$config['file_name'] = $name;
				$ext = pathinfo($files['name'][$i], PATHINFO_EXTENSION);
				$this->upload->initialize($config);
				$file_name = $name . '.' . $ext;
				if ($this->upload->do_upload($name_input)) {
					$data_success[] = $file_name;
					$temp_id = modules::run('shops/other/add', array(
						'product' => $product,
						'image' => $file_name,
						'alt' => '',
						'order' => $order + $i + 1,
						'is_temp' => 1,
						'addtime' => time(),
						'edittime' => 0,
					));
					$data_temp[] = modules::run('shops/other/get', array('id' => $temp_id));
					modules::run('files/watermark_overlay', './' . $this->_path . $file_name, './' . $watermark_image, array('wm_opacity' => $watermark_opacity));
				} else {
					$data_error[] = strip_tags($file_name . " has error: " .$this->upload->display_errors());
				}
			}
			$status = FALSE;
			if(!empty($data_success)){
				$message['content']['success'] = $this->load->view('admin/view_image', array('data' => $data_temp, 'order' => $order), TRUE);
				$status = TRUE;
			}
			if(!empty($data_error)){
				$message['content']['error'] = implode(', ', $data_error);
				$status = TRUE;
			}
			if($status){
				$message['status'] = 'success';
				$message['message'] = 'Xử lý dữ liệu thành công!';
			}
        }
        echo json_encode($message);
		exit();
	}
}
/* End of file Rows.php */
/* Location: ./application/modules/shops/controllers/Rows.php */
