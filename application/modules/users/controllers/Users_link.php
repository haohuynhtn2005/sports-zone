<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
include_once APPPATH . '/modules/layout/controllers/Layout.php';

class Users_link extends Layout {

	public $_path = '';

    function __construct() {
        parent::__construct();
        $this->load->model('m_users_link', 'M_users_link');
        $this->_data['breadcrumbs_module_name'] = 'Sản phẩm';
		$this->_path = get_module_path('shops');
    }

	function default_args() {
		$order_by = array(
			'created' => 'ASC'
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

    function get($args) {
        return $this->M_users_link->get($args);
    }

    function gets($options = array()) {
		$default_args = $this->default_args();

		if (is_array($options) && !empty($options)) {
			$args = array_merge($default_args, $options);
		} else {
			$args = $default_args;
		}
        return $this->M_users_link->gets($args);
    }

    function add($data = NULL) {
        if (empty($data)) {
            return 0;
        }
        return $this->M_users_link->add($data);
    }

    function update($args, $data) {
        return $this->M_users_link->update($args, $data);
    }

    function delete($args) {
        return $this->M_users_link->delete($args);
    }
}

/* End of file Users_link.php */
/* Location: ./application/modules/users/controllers/Users_link.php */