<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
//include_once APPPATH . '/modules/layout/controllers/Layout.php';

class Users_online extends MX_Controller {

    public $session_id;
    public $time;
    public $time_check;

    function __construct() {
        parent::__construct();
        $this->time = time();
        $this->time_check = $this->time - 300;
        $this->session_id = session_id();

        $this->load->model('users/m_users_online', 'M_users_online');
        //$this->_data['breadcrumbs_module_name'] = 'Tài khoản';
    }

    function set_last_ip($userid) {
        $data = array('last_ip' => $this->input->ip_address());
        return $this->M_users->update($userid, $data);
    }

    function set_last_agent($userid) {
        $this->load->library('user_agent');

        if ($this->agent->is_browser()) {
            $agent = $this->agent->browser() . ' ' . $this->agent->version();
        } elseif ($this->agent->is_robot()) {
            $agent = $this->agent->robot();
        } elseif ($this->agent->is_mobile()) {
            $agent = $this->agent->mobile();
        } else {
            $agent = 'Unidentified User Agent';
        }

        $data = array('last_agent' => $agent);

        return $this->M_users->update($userid, $data);
    }

    function get_user_online($session = null) {
        $this->load->model('users/m_users_online', 'M_users_online');
        return $this->M_users_online->get_user_online($session);
    }
    
    function get_user_online_current() {
        $num_user_online = $this->get_user_online($this->session_id);
        
        if($num_user_online == 0){
            $this->add();
        }  else {
            $this->update();
        }
        
        //lay tat ca cac session_id hien tai
        $num_user_online_current = $this->get_user_online();
        
        //xóa các session_id da het han
        $this->delete();
        
        echo $num_user_online_current;
        
        return $num_user_online;
    }

    function add() {
        $this->load->model('users/m_users_online', 'M_users_online');
        $data = array(
            'session' => $this->session_id,
            'time' => $this->time
        );
        return $this->M_users_online->add($data);
    }

    function update() {
        $this->load->model('users/m_users_online', 'M_users_online');
        $data = array(
            'time' => $this->time
        );
        return $this->M_users_online->update($this->session_id, $data);
    }

    function delete() {
        $this->load->model('users/m_users_online', 'M_users_online');
        $this->M_users_online->delete($this->time_check);
    }

}

/* End of file users.php */
/* Location: ./application/modules/users/controllers/users.php */