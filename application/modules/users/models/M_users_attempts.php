<?phpclass M_users_attempts extends CI_Model {	public $_table_name = 'users_attempts';	function __construst() {		parent::__construst();	}    private function generate_select() {        return $this->_table_name . '.*';    }    private function generate_from() {        $this->db->from($this->_table_name);    }	private function generate_where($args) {		if (isset($args['q'])) {            $this->db->group_start();            $this->db->like("ip", $args['q']);            $this->db->group_end();        }        if (isset($args['id'])) {            $this->db->where($this->_table_name . ".id", $args['id']);        }		if (isset($args['in_id'])) {            $this->db->where_in($this->_table_name . ".id", $args['in_id']);        }		if (isset($args['not_in_id'])) {            $this->db->where_not_in($this->_table_name . ".id", $args['not_in_id']);        }        if (isset($args['when'])) {            $this->db->where($this->_table_name . ".when < ", $args['when']);        }        if (isset($args['ip'])) {            $this->db->where($this->_table_name . ".ip", $args['ip']);        }    }    private function generate_order_by($args) {        $allow_sort = array("DESC", "ASC");        if (isset($args['order_by']) && is_array($args['order_by']) && !empty($args['order_by'])) {            foreach ($args['order_by'] as $key => $value) {                $sort = in_array($value, $allow_sort) ? $value : "DESC";                $this->db->order_by($this->_table_name . '.' . $key, $sort);            }        }    }    public function gets($args) {        $this->db->select($this->generate_select());        $this->db->from($this->generate_from());        $this->generate_where($args);        $this->generate_order_by($args);        $query = $this->db->get();        return $query->result_array();    }    public function counts($args) {        $this->db->select();        $this->db->from($this->generate_from());        $this->generate_where($args);        $query = $this->db->get();        return $query->num_rows();    }    public function get($args) {         $this->db->select($this->generate_select());        $this->db->from($this->generate_from());        $this->generate_where($args);        $query = $this->db->get();        return $query->row_array();    }    function add($data = array()) {        if (empty($data)) {            return 0;        }        $query = $this->db->insert($this->_table_name, $data);        $insert_id = $this->db->insert_id();        return isset($query) ? $insert_id : 0;    }    public function update($args, $data) {        if (empty($args) || empty($data)) {            return false;        }        $this->generate_where($args);        $query = $this->db->update($this->_table_name, $data);        return isset($query) ? true : false;    }    function delete($args) {        if (empty($args)) {            return false;        }        $this->generate_where($args);        $query = $this->db->delete($this->_table_name);        return isset($query) ? true : false;    }}/* End of file M_users_attempts.php *//* Location: ./application/modules/users/models/M_users_attempts.php */