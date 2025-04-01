<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Error404 extends MX_Controller {
    function __construct(){
        parent::__construct();
    }

    function index(){
        $this->output->set_status_header('404');
        $segment = 1;
        $action = ($this->uri->segment($segment) == '') ? 0 : $this->uri->segment($segment);
        // echo $action; die;
        $this->load->view('view_index');
    }
}
/* End of file Error404.php */
/* Location: ./application/modules/errors/controllers/Error404.php */