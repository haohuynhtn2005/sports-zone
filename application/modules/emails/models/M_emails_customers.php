<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class M_emails_customers extends CI_Model {

    public $_table_name = 'emails_customers';

    function __construst() {
        parent::__construst();
    }

    private function generate_where($args) {
        if (isset($args['q'])) {
            $this->db->group_start();
            $this->db->like($this->_table_name . ".full_name", $args['q']);
            $this->db->or_like($this->_table_name . ".phone", $args['q']);
            $this->db->or_like($this->_table_name . ".address", $args['q']);
            $this->db->or_like($this->_table_name . ".email", $args['q']);
            $this->db->or_like($this->_table_name . ".id", $args['q']);
            $this->db->group_end();
        }

		if (isset($args['start_date']) && isset($args['end_date'])) {
			$this->db->group_start();
            $this->db->where($this->_table_name . ".created >=", $args['start_date']);
            $this->db->where($this->_table_name . ".created <=", $args['end_date']);
			$this->db->group_end();
        }

		if (isset($args['user_id'])) {
            $this->db->where($this->_table_name . ".user_id", $args['user_id']);
        }

        if (isset($args['group_id'])) {
            $this->db->where($this->_table_name . ".group_id", $args['group_id']);
        }

        if (isset($args['in_group_id'])) {
            $this->db->where_in($this->_table_name . ".group_id", $args['in_group_id']);
        }

		if (isset($args['created_by'])) {
            $this->db->where($this->_table_name . ".created_by", $args['created_by']);
        }

		if (isset($args['in_created_by'])) {
            $this->db->where_in($this->_table_name . ".created_by", $args['in_created_by']);
        }

        if (isset($args['deleted'])) {
            $this->db->where($this->_table_name . ".deleted", $args['deleted']);
        }

		if (isset($args['not_in_user_id'])) {
            $this->db->where_not_in($this->_table_name . ".user_id", $args['not_in_user_id']);
        }

		if (isset($args['in_user_id'])) {
            $this->db->where_in($this->_table_name . ".user_id", $args['in_user_id']);
        }

		if (isset($args['active'])) {
            $this->db->where($this->_table_name . ".active", $args['active']);
        }

        if (isset($args['not_in_id'])) {
            $this->db->where_not_in($this->_table_name . ".id", $args['not_in_id']);
        }
    }

    private function generate_order_by($args) {
        $allow_sort = array("DESC", "ASC");

        if (isset($args['order_by']) && is_array($args['order_by']) && !empty($args['order_by'])) {
            foreach ($args['order_by'] as $key => $value) {
                $sort = in_array($value, $allow_sort) ? $value : "DESC";
                $this->db->order_by($key, $sort);
            }
        }
    }

    public function gets($args, $perpage = 5, $offset = -1) {
        $this->db->select($this->_table_name . '.*, customers_group.name as group_name');
        $this->db->from($this->_table_name);
		$this->db->join('emails_customers_group as customers_group', $this->_table_name . '.group_id = customers_group.id', 'left');

        $this->generate_where($args);
        $this->generate_order_by($args);
        if ($offset >= 0) {
            $this->db->limit($perpage, $offset);
        }
        $query = $this->db->get();
		if (isset($args['group_id'])) {
			// echo $this->db->last_query(); die;
		}

        return $query->result_array();
    }

    public function counts($args) {
        $this->db->select();
        $this->db->from($this->_table_name);
		$this->db->join('emails_customers_group as customers_group', $this->_table_name . '.group_id = customers_group.id', 'left');

        $this->generate_where($args);

        $query = $this->db->get();

        return $query->num_rows();
    }

    public function get($id) {
        $this->db->select($this->_table_name . '.*, customers_group.name as group_name');
        $this->db->from($this->_table_name);
		$this->db->join('emails_customers_group as customers_group', $this->_table_name . '.group_id = customers_group.id', 'left');
        $this->db->where($this->_table_name . '.id', $id);

        $query = $this->db->get();

        return $query->row_array();
    }

	public function get_by($args) {
        $this->db->select($this->_table_name . '.*, customers_group.name as group_name');
        $this->db->from($this->_table_name);
		$this->db->join('emails_customers_group as customers_group', $this->_table_name . '.group_id = customers_group.id', 'left');

        $this->generate_where($args);
        $query = $this->db->get();

        return $query->row_array();
    }

	function check_phone_availablity($phone = '', $id = 0) {
        if (trim($phone) == '') {
            return FALSE;
        }
        $this->db->select();
        $this->db->from($this->_table_name);
        if ($id != 0) {
            $this->db->where('id', $id);
            $this->db->or_where('phone', $phone);
        } else {
            $this->db->where('phone', $phone);
        }
        $query = $this->db->get();
        if ($id != 0) {
            if ($query->num_rows() == 1) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if ($query->num_rows() > 0) {
                return FALSE;
            } else {
                return TRUE;
            }
        }
    }

    function add($data = array()) {
        if (empty($data)) {
            return 0;
        }
        $query = $this->db->insert($this->_table_name, $data);

        return isset($query) ? $this->db->insert_id() : 0;
    }

    function update($id, $data) {
        if (empty($data)) {
            return FALSE;
        }
        $this->db->where('id', $id);
        $query = $this->db->update($this->_table_name, $data);

        return isset($query) ? true : false;
    }

    function delete($id = 0) {
        $this->db->where('id', $id);
        $query = $this->db->delete($this->_table_name);

        return isset($query) ? true : false;
    }

    function truncate() {
        $query = $this->db->truncate($this->_table_name);

        return isset($query) ? true : false;
    }

}
/* End of file M_emails_customers.php */
/* Location: ./application/modules/emails/models/M_emails_customers.php */