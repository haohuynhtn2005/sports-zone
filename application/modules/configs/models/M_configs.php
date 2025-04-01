<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_configs extends CI_Model {

    public $_table_name = 'configs';

    function __construst() {
        parent::__construst();
    }

    function get_configs() {
        $this->db->select();
        $query = $this->db->get($this->_table_name);

        return $query->result_array();
    }

    function set_configs($data = null) {
        $configs = null;
        if(is_array($data) && !empty($data)){
            foreach ($data as $value) {
                $configs[$value['config_name']] = $value['config_value'];
            }
        }
        return $configs;
    }

    function gets($config_names = array()) {
        if(empty($config_names)){
            return null;
        }
        $this->db->select();
        $this->db->where_in('config_name', $config_names);
        $query = $this->db->get($this->_table_name);

        $rows = $query->result_array();
        
        return $this->set_configs($rows);
    }
    
    function get($config_name = '') {
        $this->db->select();
        $this->db->where('config_name', $config_name);
        $query = $this->db->get($this->_table_name);

        return $query->row_array();
    }

    function update($config_name, $data = array()) {
        if (empty($data)) {
            return FALSE;
        }
        $this->db->where('config_name', $config_name);
        $query = $this->db->update($this->_table_name, $data);

        return isset($query) ? true : false;
    }

    function delete($id) {
        $this->db->where('id', $id);
        $query = $this->db->delete($this->_table_name);

        return isset($query) ? true : false;
    }

}

/* End of file M_configs.php */
/* Location: ./application/modules/configs/models/M_configs.php */