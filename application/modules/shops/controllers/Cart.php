<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
include_once APPPATH . '/modules/layout/controllers/Layout.php';

class Cart extends Layout {

    function __construct() {
        parent::__construct();
        $this->cart->product_name_rules = '\d\D';
        $this->_data['breadcrumbs_module_name'] = 'Giỏ hàng';
    }

    function parse_param($param = '') {
        $data = array();
        $data['user_id'] = 0;
        $data['product_id'] = 0;
        if (trim($param) != '') {
            $param = base64_decode($param);
            $arr_param = explode('-', $param);
            $user_id = isset($arr_param[0]) ? $arr_param[0] : 0;
            $product_id = isset($arr_param[1]) ? $arr_param[1] : 0;

            $data['user_id'] = $user_id;
            $data['product_id'] = $product_id;
        }

        return $data;
    }

    function site_add_cart_ajax() {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $message = array();
        $message['status'] = 'warning';
        $message['content'] = null;
        $message['message'] = 'Kiểm tra thông tin nhập';

        $post = $this->input->post();
        if (!empty($post)) {
            $id = $this->input->post('product_id');
            $qty = $this->input->post('qty');
            $options = array();
            if($this->input->post('param')){
                $options['param'] = $this->input->post('param');
            }
            if($this->input->post('access')){
                $options['access'] = $this->input->post('access');
            }

            if ($this->validate_add_cart_item($id, $qty, $options)) {
                $message['status'] = 'success';
                $message['content'] = $this->load->view('layout/site/partial/mini-cart', null, true);
                $message['message'] = 'Thêm sản phẩm vào giỏ hàng thành công!';
            } else {
                $message['status'] = 'danger';
                $message['content'] = null;
                $message['message'] = 'Có lỗi xảy ra! Vui lòng thực hiện lại!';
            }
        }
        echo json_encode($message);
        exit();
    }

    function validate_add_cart_item($id, $qty, $options = array()) {
        $row = modules::run('shops/rows/get', $id);
        if (!empty($row)) {
            $insert_new = TRUE;
            $bag = $this->cart->contents();

            foreach ($bag as $item) {
                if ($item['id'] == $id) {
                    $data = array(
                        'rowid' => $item['rowid'],
                        'qty' => $item['qty'] + $qty
                    );
                    $this->cart->update($data);
                    $insert_new = FALSE;
                    break;
                }
            }

            if ($insert_new) {
                $unit_price = $row['product_price'];
                $price = get_product_discounts($row['product_price'], $row['product_sales_price']);
                $data = array(
                    'id' => $id,
                    'qty' => $qty,
                    'price' => $price,
                    'unit_price' => $unit_price,
                    'name' => $row['title'],
                    'img' => get_image(get_module_path('shops') . $row['homeimgfile'], get_module_path('shops') . 'no-image.png'),
                    //'url' => site_url($this->config->item('url_shops_rows') . '/' . $row['cat_alias'] . '/' . $row['alias'] . '-' . $row['id'])
                    'url' => site_url('san-pham' . '/' . $row['cat_alias'] . '/' . $row['alias'] . '-' . $row['id'])
                );
                if(isset($options['param']) && isset($options['access']) && trim($options['param']) != '' && trim($options['access']) != ''){
                    $data_options = parse_param($options['param']);
                    if(isset($data_options['user_id']) && isset($data_options['product_id']) && $data_options['user_id'] != 0 && $data_options['product_id'] != 0){
                        $args_validate_exist = array(
                            'user_id' => $data_options['user_id'],
                            'product_id' => $data_options['product_id']
                        );
                        $data_user_link = modules::run('users/users_link/get', $args_validate_exist);
                        if (is_array($data_user_link) && !empty($data_user_link)) {
                            $data['options'] = array(
                                'user_id' => $data_options['user_id'],
                                'product_id' => $data_options['product_id'],
                                'access' => $options['access']
                            );
                        }
                    }
                    $data['url'] .= '?param=' . $options['param'] . '&access=' . $options['access'];
                }
                $this->cart->insert($data);
            }
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function site_update_cart() {
        $item = $this->input->post('rowid');
        $qty = $this->input->post('quantity');
        $total = count($this->cart->contents());
        $result = TRUE;

        for ($i = 0; $i < $total; $i++) {
            $data = array(
                'rowid' => $item[$i],
                'qty' => $qty[$i] < 0 ? 1 : $qty[$i]
            );
            if (!$this->cart->update($data)) {
                $result = FALSE;
            }
        }

        redirect(site_url('gio-hang'));
    }

	function site_update_cart_ajax() {
		if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $message = array();
        $message['status'] = 'warning';
        $message['content'] = null;
        $message['message'] = 'Kiểm tra thông tin nhập';

        $post = $this->input->post();
        if (!empty($post)) {
            $rowid = $this->input->post('rowid');
			$qty = (int) $this->input->post('qty');

			$data = array(
				'rowid' => $rowid,
				'qty' => $qty < 0 ? 1 : $qty
			);
			if ($this->cart->update($data)) {
				$item = $this->cart->get_item($rowid);
				if(isset($item['subtotal'])){
					$item['subtotal'] = formatRice($item['subtotal']);
				}
				$message['status'] = 'success';
				$message['content'] = array('total' => formatRice($this->cart->total()), 'item' => $item);
				$message['message'] = 'Cập nhật dữ liệu thành công!';
			} else {
				$message['status'] = 'danger';
				$message['content'] = null;
				$message['message'] = 'Có lỗi xảy ra! Vui lòng thực hiện lại!';
			}
        }
        echo json_encode($message);
        exit();
    }

	function site_remove_cart_item_ajax() {
		if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $message = array();
        $message['status'] = 'warning';
        $message['content'] = null;
        $message['message'] = 'Kiểm tra thông tin nhập';

        $post = $this->input->post();
        if (!empty($post)) {
            $rowid = $this->input->post('rowid');
			$qty = 0;

			$data = array(
				'rowid' => $rowid,
				'qty' => $qty
			);
			if ($this->cart->update($data)) {
				$message['status'] = 'success';
				$message['content'] = $this->load->view('layout/site/partial/mini-cart', null, true);
				$message['message'] = 'Xóa dữ liệu thành công!';
			} else {
				$message['status'] = 'danger';
				$message['content'] = null;
				$message['message'] = 'Có lỗi xảy ra! Vui lòng thực hiện lại!';
			}
        }
        echo json_encode($message);
        exit();
    }

    function site_update_cart_item() {
        $item = $this->input->post('rowid');
        $qty = $this->input->post('quantity');

        if ($this->validate_add_cart_item($item, $qty)) {
            if ($this->input->post('ajax') != '1') {
                redirect(base_url('shops/cart'));
            } else {
                echo 'true';
            }
        }
        redirect(site_url('gio-hang'));
    }

    function validate_update_cart_item($item, $qty) {
        $total = count($this->cart->contents());

        $result = TRUE;

        for ($i = 0; $i < $total; $i++) {
            $data = array(
                'rowid' => $item[$i],
                'qty' => $qty[$i]
            );
            if (!$this->cart->update($data)) {
                $result = FALSE;
            }
        }

        return $result;
    }

    function site_remove_cart_item() {
        $item = $this->input->get('rowid');
        if ($this->validate_remove_cart_item($item)) {
            if ($this->input->post('ajax') != '1') {
                redirect(site_url('gio-hang'));
            } else {
                echo 'true';
            }
        }
    }

    function validate_remove_cart_item($item) {
        $result = FALSE;

        $data = array(
            'rowid' => $item,
            'qty' => 0
        );

        if ($this->cart->update($data)) {
            $result = TRUE;
        }

        return $result;
    }

    function show_cart() {
        $this->load->view('shops/cart', $this->_data);
    }

    function show_cart_page() {
        $this->load->view('layout/site/partial/mini-cart', $this->_data);
    }

    function show_cart_page_mobile() {
        $this->load->view('layout/site/partial/mini-cart-mobile', $this->_data);
    }

    function site_remove_cart() {
        $this->cart->destroy();
        redirect(site_url('gio-hang'));
    }

}
/* End of file Cart.php */
/* Location: ./application/modules/shops/controllers/Cart.php */