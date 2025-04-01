<?php

class M_shops_order_details extends CI_Model {

    public $_table_name = 'shops_order_details';

    function __construst() {
        parent::__construst();
    }
    
    private function generate_where($args) {
        if (isset($args['id'])) {
            $this->db->where($this->_table_name . ".id", $args['id']);
        }
        
        if (isset($args['in_id'])) {
            $this->db->where_in($this->_table_name . ".id", $args['in_id']);
        }
        
        if (isset($args['not_in_id'])) {
            $this->db->where_not_in($this->_table_name . ".id", $args['not_in_id']);
        }
        
        if (isset($args['order'])) {
            $this->db->where($this->_table_name . ".order_id", $args['order']);
        }

        if (isset($args['product'])) {
            $this->db->where($this->_table_name . ".product_id", $args['product']);
        }
        
        if (isset($args['unit'])) {
            $this->db->where($this->_table_name . ".unit_id", $args['unit']);
        }
        
        if (isset($args['in_user_id'])) {
            //$this->db->where_in($this->_table_name . ".user_id", $args['in_user_id']);
            $this->db->where_in("shops_order.order_customer_id", $args['in_user_id']);
        }
        
        if (isset($args['user_id'])) {
            $this->db->where("shops_order.order_customer_id", $args['user_id']);
        }
        
        if (isset($args['transaction_status'])) {
            $this->db->where("shops_order.transaction_status", $args['transaction_status']);
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
        $this->db->select($this->_table_name . '.*, shops_order.order_code, shops_order.created, shops_order.transaction_status');
        $this->db->from($this->_table_name);
        $this->db->join('shops_order', $this->_table_name . '.order_id = shops_order.order_id', 'left');

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
        $this->db->join('shops_order', $this->_table_name . '.order_id = shops_order.order_id', 'left');

        $this->generate_where($args);

        $query = $this->db->get();

        return $query->num_rows();
    }

    public function get($args) {
        $this->db->select();
        $this->db->from($this->_table_name);
        $this->generate_where($args);

        $query = $this->db->get();

        return $query->row_array();
    }
    
    function get_total_commission_price($args) {
        $this->db->select_sum('price');
        $this->db->from($this->_table_name);
        $this->db->join('shops_order', $this->_table_name . '.order_id = shops_order.order_id', 'left');
        $this->generate_where($args);
        $query = $this->db->get();

        return $query->row_array();
    }

    function get_total_quantity() {
        $this->db->select_sum('quantity');
        $this->db->from($this->_table_name);
        $this->db->join('shops_order', $this->_table_name . '.order_id = shops_order.order_id', 'left');
        $query = $this->db->get();

        return $query->row_array();
    }

    function get_total_quantity_in_product_id($product_id) {
        $this->db->select_sum('quantity');
        $this->db->from($this->_table_name);
        $this->db->join('shops_order', $this->_table_name . '.order_id = shops_order.order_id', 'left');
        $this->db->where($this->_table_name . '.product_id', $product_id);
        $query = $this->db->get();

        return $query->row_array();
    }

    function get_data_in_order_id($order_id = 0) {
        $this->db->select('*');
        $this->db->where($this->_table_name . '.order_id', $order_id);
        $query = $this->db->get($this->_table_name);

        return $query->result_array();
    }

    function get_data_by_product_id($product_id) {
        $this->db->select();
        $this->db->where($this->_table_name . '.product_id', $product_id);
        $query = $this->db->get($this->_table_name);

        return $query->result_array();
    }

    /**
     * @Function: get_best_seller()
     * @author LeVanNhan <lenhan10th@gmail.com>
     * @Parameters: $top number
     * @return array Description: get product best seller
     */
    function get_best_seller($top) {
        $this->db->select('product_id');
        $this->db->select_sum('quantity');
        $this->db->from($this->_table_name);
        $this->db->group_by('product_id');
        $this->db->order_by('quantity', 'DESC');
        $this->db->limit($top);
        $query = $this->db->get();

        //echo $this->db->last_query();

        return $query->result_array();
    }

    function add($data = array()) {
        if (empty($data)) {
            return 0;
        }
        $query = $this->db->insert($this->_table_name, $data);
        $insert_id = $this->db->insert_id();
        return (isset($query)) ? $insert_id : 0;
    }

    function delete($order_id) {
        $this->db->where('order_id', $order_id);
        $query = $this->db->delete($this->_table_name);

        return (isset($query)) ? true : false;
    }

    function validate_product_id($product_id = 0) {
        $this->db->select();
        $this->db->from($this->_table_name);
        $this->db->where('product_id', $product_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}

/* End of file m_shops_order_details.php */
/* Location: ./application/modules/shops/models/m_shops_order_details.php */