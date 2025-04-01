<?phpclass M_shops extends CI_Model {    public $_table_name = 'shops';    public function __construst() {        parent::__construst();    }    private function generate_where($args) {        if (isset($args['q'])) {            $this->db->group_start();            $this->db->like($this->_table_name . ".title", $args['q']);            $this->db->or_like($this->_table_name . ".hometext", $args['q']);			$this->db->group_end();        }        if (isset($args['cat_id'])) {            $this->db->where($this->_table_name . ".listcatid", $args['cat_id']);        }        if (isset($args['not_in_id'])) {            $this->db->where_not_in($this->_table_name . ".id", $args['not_in_id']);        }        if (isset($args['in_id'])) {            $this->db->where_in($this->_table_name . ".id", $args['in_id']);        }        if (isset($args['in_cat_id'])) {            $this->db->where_in($this->_table_name . ".listcatid", $args['in_cat_id']);        }        if (isset($args['price_start']) && isset($args['price_end'])) {//tu 5tr - 7tr            $this->db->group_start();            $this->db->where($this->_table_name . ".product_price >=", $args['price_start']);            $this->db->where($this->_table_name . ".product_price <=", $args['price_end']);            $this->db->group_end();        }elseif(isset($args['price_start'])){//tren 5tr            $this->db->where($this->_table_name . ".product_price >=", $args['price_start']);        }elseif(isset($args['price_end'])){//duoi 5tr            $this->db->where($this->_table_name . ".product_price <=", $args['price_end']);        }        if (isset($args['user_id'])) {            $this->db->where($this->_table_name . ".user_id", $args['user_id']);        }		if (isset($args['is_bestseller'])) {            $this->db->where($this->_table_name . ".is_bestseller", $args['is_bestseller']);        }        if (isset($args['is_featured'])) {            $this->db->where($this->_table_name . ".is_featured", $args['is_featured']);        }		if (isset($args['is_new'])) {            $this->db->where($this->_table_name . ".is_new", $args['is_new']);        }		if (isset($args['is_promotion'])) {            $this->db->where($this->_table_name . ".is_promotion", $args['is_promotion']);        }		if (isset($args['is_bestview'])) {            $this->db->where($this->_table_name . ".is_bestview", $args['is_bestview']);        }    }    private function generate_order_by($args) {        $allow_sort = array("DESC", "ASC", "RANDOM");        if (isset($args['order_by']) && is_array($args['order_by']) && !empty($args['order_by'])) {            foreach ($args['order_by'] as $key => $value) {                $sort = in_array($value, $allow_sort) ? $value : "DESC";                $this->db->order_by($this->_table_name . '.' . $key, $sort);            }        }    }    public function gets($args, $perpage = 5, $offset = -1) {        $this->db->select($this->_table_name . '.*,' . 'shops_rows.product_price as price, shops_cat.alias as cat_alias, shops_cat.name as cat_name, users.full_name as full_name');        $this->db->from($this->_table_name);        $this->db->join('shops_cat', 'shops_cat.id = ' . $this->_table_name . '.listcatid', 'left');        $this->db->join('users', 'users.userid = ' . $this->_table_name . '.user_id', 'left');        $this->generate_where($args);        $this->generate_order_by($args);        if ($offset >= 0) {            $this->db->limit($perpage, $offset);        }        $query = $this->db->get();        return $query->result_array();    }    public function counts($args) {        $this->db->select('*');        $this->db->from($this->_table_name);        $this->generate_where($args);        $query = $this->db->get();        return $query->num_rows();    }    public function get($id, $alias = '') {        $this->db->select($this->_table_name . '.*,' . 'shops_rows.product_price as price, shops_cat.alias as cat_alias, shops_cat.id as cat_id, shops_cat.name as cat_name, users.full_name as full_name');        $this->db->from($this->_table_name);        $this->db->join('shops_cat', 'shops_cat.id = ' . $this->_table_name . '.listcatid', 'left');        $this->db->join('users', 'users.userid = ' . $this->_table_name . '.user_id', 'left');        $this->db->where($this->_table_name . '.id', $id);        if (trim($alias) != '') {            $this->db->where($this->_table_name . '.alias', $alias);        }        $query = $this->db->get();        return $query->row_array();    }    function check_product_code_availablity($product_code) {        if (trim($product_code) == '') {            return false;        }        $this->db->select();        $this->db->where('product_code', $product_code);        $this->db->from($this->_table_name);        $query = $this->db->get();        if ($query->num_rows() > 0) {            return false;        } else {            return true;        }    }    function check_current_product_code_availablity($product_code, $id = 0) {        if (trim($product_code) == '') {            return false;        }        $this->db->select();        if ($id != 0) {            $this->db->where('id', $id);            $this->db->or_where('product_code', $product_code);        } else {            $this->db->where('product_code', $product_code);        }        $this->db->from($this->_table_name);        $query = $this->db->get();        if ($id != 0) {            if ($query->num_rows() == 1) {                return TRUE;            } else {                return false;            }        } else {            if ($query->num_rows() > 0) {                return false;            } else {                return true;            }        }    }    public function add($data = array()) {        if (empty($data)) {            return 0;        }        $query = $this->db->insert($this->_table_name, $data);        $insert_id = $this->db->insert_id();        return isset($query) ? $insert_id : 0;    }    public function update($id, $data) {        if (empty($data)) {            return false;        }        $this->db->where('id', $id);        $query = $this->db->update($this->_table_name, $data);        return isset($query) ? true : false;    }    public function delete($id) {        $this->db->where('id', $id);        $query = $this->db->delete($this->_table_name);        return isset($query) ? true : false;    }    public function delete_by($args = null) {        if (empty($args)) {            return false;        }        $this->generate_where($args);        $query = $this->db->delete($this->_table_name);        return isset($query) ? true : false;    }    public function truncate($args = null) {        $query = $this->db->truncate($this->_table_name);        return isset($query) ? true : false;    }}/* End of file M_shops.php *//* Location: ./application/modules/shops/models/M_shops.php */