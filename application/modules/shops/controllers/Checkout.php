<?php
if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}
include_once APPPATH . '/modules/layout/controllers/Layout.php';

class Checkout extends Layout {

	function __construct() {
		parent::__construct();
		$this->_data['breadcrumbs_module_name'] = 'Giỏ hàng';
	}

	function site_index() {
		$this->_initialize();
		modules::run('users/require_logged_in');
		$cart = $this->cart->contents();
		if (!$cart) {
			redirect(site_url('gio-hang'));
		}
		// echo "<pre>";
		// print_r($cart);
		// echo "</pre>";
		// die();

		$user_id = 0;
		if (isset($this->_data['userid'])) {
			$user_id = $this->_data['userid'];
		}
		$customer_id = $user_id;
		$this->_data['user'] = $customer = modules::run('users/get', $user_id);

		$post = $this->input->post();
		if (!empty($post)) {
			// echo "<pre>";
			// print_r($post);
			// echo "</pre>";
			// die();
			$order_total = $this->cart->total();
			$time = time();

			$address_id = (int) $this->input->post('address_id');
			$address_args = array(
				'id' => $address_id,
				'user_id' => $user_id,
			);
			$row_address = modules::run('users/users_address/get', $address_args);
			if(!(is_array($row_address) && !empty($row_address))){
	        	$notify_type = 'danger';
	        	$notify_content = 'Địa chỉ không tồn tại!';
	        	$this->set_notify($notify_type, $notify_content);
	        	redirect(current_url());
            }

			$order_code = $this->get_max_code();
			if (!modules::run('shops/orders/check_order_code_availablity', $order_code)) {
				$order_code = $this->get_max_code();
			}
			$email = $this->input->post('email');

			$province = $row_address['province_id'];
			$district = $row_address['district_id'];
			$commune = $row_address['commune_id'];
			$no = $row_address['place_of_receipt'];
			$order_shipping = isset($row_address['cost']) ? $row_address['cost'] : 0;
			$address = get_full_address($row_address);

			$order_args = array(
				'order_customer_id' => $customer_id,
				'order_code' => $order_code,
				'order_amount' => $order_total,
				'coupon_code' => NULL,
				'coupon' => 0,
				'order_monetized' => $order_total + $order_shipping,
				'customer_full_name' => $this->input->post('full_name'),
				'customer_phone' => $this->input->post('phone'),
				'order_full_name' => $row_address['full_name'],
				'order_email' => $email,
				'order_phone' => $row_address['phone'],
				'order_note' => $this->input->post('order_note'),
				'order_province' => $province,
				'order_district' => $district,
				'order_commune' => $commune,
				'order_no' => $no,
				'order_address' => $address,
				'order_shipping' => $order_shipping,
				'forms_of_payment' => $this->input->post('forms_of_payment'),
				'post_ip' => $this->input->ip_address(),
				'transaction_status' => 0,
				'viewed' => 0,
				'created' => $time,
				'modified' => 0,
			);
			$order_id = modules::run('shops/orders/site_add', $order_args); // thêm đơn hàng

			if ($order_id != 0) {
				$history_container = array();
				$history_current = array();
				foreach ($cart as $item) {
					$product_id = $item['id'];
					$name = $item['name'];
					$price = $item['unit_price'];
					$promotion_price = $item['price'];
					$quantity = $item['qty'];
					$monetized = $item['subtotal'];

					$commission = 0;
					$commission_price = 0;
					$user_id = 0;
					if($this->cart->has_options($item['rowid'])){
						$product_options = $this->cart->product_options($item['rowid']);
						if(isset($product_options['user_id'])){
							$row_product = modules::run('shops/rows/get', $product_id);
							if(isset($row_product['commission']) && $row_product['commission'] != 0){
								$commission = (float) $row_product['commission'];
							}
							$commission_price = $monetized * $commission / 100;
							$user_id = (int) $product_options['user_id'];
						}
					}
					$order_detail_args = array(
						'order_id' => $order_id,
						'name' => $name,
						'product_id' => $product_id,
						'price' => $price,
						'promotion_price' => $promotion_price,
						'quantity' => $quantity,
						'monetized' => $monetized,
						'commission' => $commission,
						'commission_price' => $commission_price,
						'user_id' => $user_id,
					);
					$bool = modules::run('shops/order_details/site_add', $order_detail_args);
					if ($bool && $commission != 0) {
						$history = array();
	        			$payment = 'CREDIT_CARD';
	        			$action = 'SUB_BUY';
	        			$value_cost = $monetized;
	        			$percent = $commission;
	        			$value = $commission_price;
						$data_commission = array(
							'order_id' => $order_id,
							'product_id' => $product_id,
						    'user_id' => $user_id,
						    'extend_by' => NULL,
						    'action' => $action,
							'payment' => $payment,
							'value_cost' => $value_cost,
							'percent' => $percent,
							'value' => $value,
						    'message' => 'Người dùng được hưởng hoa hồng khi khách hàng mua sản phẩm',
						    'status' => 0,
						    'created' => $time
						);
						modules::run('users/users_commission/add', $data_commission);
						$history[] = $data_commission;
						$history_container[] = $history;
					}
				}
				$history_current[] = $history_container;
				$history_bool = $this->M_shops_orders->update($order_id, array('history' => serialize($history_current)));

				$site_name = $this->_data['site_name'];
				$subject = "Thông tin mua hàng - " . $this->_data['site_name'];

				$partial = array();
				$partial['order'] = $order_args;
				$order_items = modules::run('shops/order_details/get_data_in_order_id', $order_id); // lấy các sản phẩm có id giỏ hàng
				$products = array();
				foreach ($order_items as $value) {
					$arr = modules::run('shops/rows/get', $value['product_id']); // lấy thông tin chi tiết các sản phẩm có trong giỏ hàng
					$arr['name'] = (isset($arr['title']) && trim($arr['title']) != '') ? $arr['title'] : $value["name"];
					$arr['quantity'] = $value["quantity"];
					$arr['price'] = $value["price"];
					$arr['promotion_price'] = $value["promotion_price"];
					$arr['percent_discount'] = $value["percent_discount"];
					$arr['monetized'] = $value["monetized"];
					$products[] = $arr;
				}
				$partial['products'] = $products;
				$message = $this->load->view('layout/site/partial/html-template-order', $partial, true);

				//$message = modules::run('shops/orders/site_html_or_view', $order_id);
				$data_sendmail = array(
					'sender_email' => $this->_data['email'],
					'sender_name' => $site_name,
					'receiver_email' => array($email, $this->_data['email'], 'lenhan10th@gmail.com'),
					'subject' => $subject,
					'message' => $message,
				);
				modules::run('emails/send_mail', $data_sendmail); // gửi mail

				//unset session cart
				$this->cart->destroy();
				redirect(site_url('ket-qua-thanh-toan/' . $order_id));
			} else {
				$notify_type = 'danger';
				$notify_content = '<strong>Có lỗi xảy ra!</strong> Vui lòng thực hiện lại!';
				$this->set_notify($notify_type, $notify_content);
			}
		}
		$this->_data['provinces'] = modules::run('provinces/provinces/gets');

		$address_args = array();
		$address_args['user_id'] = $user_id;
		$order_by = array(
			'is_default' => 'DESC',
			'created' => 'ASC',
			'modified' => 'DESC',
		);
		$address_args['order_by'] = $order_by;
		$address = modules::run('users/users_address/gets', $address_args);

		$partial = array();
		$partial['data'] = $address;
		$this->_data['address_items'] = $this->load->view('layout/site/partial/address-checkout', $partial, true);

		$fee = 0;
		if(isset($address[0]['cost'])){
			$fee = $address[0]['cost'];
		}
		$this->_data['fee'] = $fee;

		$this->_breadcrumbs[] = array(
			'url' => site_url('thanh-toan'),
			'name' => 'Thanh toán',
		);
		$this->set_breadcrumbs();

		$this->_data['title_seo'] = 'Thanh toán' . ' - ' . $this->_data['title_seo'];
		$this->_data['main_content'] = 'layout/site/pages/checkout';
		$this->load->view('layout/site/layout', $this->_data);
	}

	function get_max_code() {
		return modules::run('shops/orders/get_max_code');
	}

}
/* End of file Checkout.php */
/* Location: ./application/modules/shops/controllers/Checkout.php */