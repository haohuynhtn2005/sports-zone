<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class M_email_logs extends CI_Model {

    public $_table_name = 'email_logs';

    function __construst() {
        parent::__construst();
    }

    private function generate_where($args) {
        if (isset($args['q'])) {
            $this->db->group_start();
            $this->db->like($this->_table_name . ".subject", $args['q']);
            $this->db->or_like($this->_table_name . ".to", $args['q']);
            $this->db->or_like($this->_table_name . ".email", $args['q']);
            $this->db->or_like($this->_table_name . ".subject", $args['q']);
            $this->db->or_like($this->_table_name . ".content", $args['q']);
            $this->db->group_end();
        }

        if (isset($args['id'])) {
            $this->db->where($this->_table_name . ".id", $args['id']);
        }

        if (isset($args['in_id'])) {
            $this->db->where_in($this->_table_name . ".id", $args['in_id']);
        }

        if (isset($args['not_in_id'])) {
            $this->db->where_not_in($this->_table_name . ".id", $args['not_in_id']);
        }

        if (isset($args['email_id'])) {
            $this->db->where($this->_table_name . ".email_id", $args['email_id']);
        }

        if (isset($args['mailed_by'])) {
            $this->db->where($this->_table_name . ".mailed_by", $args['mailed_by']);
        }

        if (isset($args['status'])) {
            $this->db->where($this->_table_name . ".status", $args['status']);
        }

        if (isset($args['not_in_status'])) {
            $this->db->where_not_in($this->_table_name . ".status", $args['not_in_status']);
        }

        if (isset($args['start_date_start'])) {
            $this->db->where($this->_table_name . ".sended >", $args['start_date_start']);
        }

        if (isset($args['start_date_end'])) {
            $this->db->where($this->_table_name . ".sended <", $args['start_date_end']);
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
        $this->db->select();
        $this->db->from($this->_table_name);

        $this->generate_where($args);
        $this->generate_order_by($args);
        if ($offset >= 0) {
            $this->db->limit($perpage, $offset);
        }
        $query = $this->db->get();

        return $query->result_array();
    }

    public function counts($args) {
        $this->db->select();
        $this->db->from($this->_table_name);

        $this->generate_where($args);

        $query = $this->db->get();

        return $query->num_rows();
    }

    public function get($id) {
        $this->db->select();
        $this->db->from($this->_table_name);
        $this->db->where($this->_table_name . '.id', $id);

        $query = $this->db->get();

        return $query->row_array();
    }

    public function add($args = array()) {
        if (empty($args)) {
            return 0;
        }
        $query = $this->db->insert($this->_table_name, $args);

        $insert_id = $this->db->insert_id();

        return (isset($query)) ? $insert_id : 0;
    }

    public function update($id, $args) {
        if (empty($args)) {
            return false;
        }
        $this->db->where('id', $id);
        $query = $this->db->update($this->_table_name, $args);

        return (isset($query)) ? true : false;
    }

    public function delete($id) {
        $this->db->where('id', $id);
        $query = $this->db->delete($this->_table_name);

        return (isset($query)) ? true : false;
    }
}

/* End of file M_email_logs.php */
/* Location: ./application/modules/emails/models/M_email_logs.php */