<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
include_once APPPATH . '/modules/layout/controllers/Layout.php';
class Emails extends Layout {

	private $_module_slug = 'emails';

    function __construct() {
        parent::__construct();
        $this->load->library('encrypt');
        $this->_data['breadcrumbs_module_name'] = 'Email';
		$this->_data['module_slug'] = $this->_module_slug;
		$this->load->model('emails/m_emails', 'M_emails');
    }

    function send_mail($data_sendmail = null, $configs_emails = null) {
        if ($data_sendmail == NULL) {
            return FALSE;
        } else {
            $this->load->library('encrypt');
            if(!$configs_emails){
                $configs_emails = modules::run('emails/emails_config/get_configs_emails');
            }

            // Configure email library
            $config['protocol'] = $configs_emails['protocol'];
            $config['smtp_host'] = $configs_emails['smtp_host'];
            $config['smtp_port'] = $configs_emails['smtp_port'];
            $config['smtp_user'] = $configs_emails['smtp_user'];
            $config['smtp_pass'] = $this->encrypt->decode($configs_emails['smtp_pass']);

            $config['mailtype'] = 'html';
            $config['charset'] = 'utf-8';
            $config['newline'] = '\r\n';
            $config['wordwrap'] = TRUE;

            // Load email library and passing configured values to email library
            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");

            // Sender email address
            $this->email->from($configs_emails['smtp_user'], $data_sendmail['sender_name']);
            // Receiver email address
            $this->email->to($data_sendmail["receiver_email"]);
            $this->email->reply_to($data_sendmail["sender_email"], $data_sendmail['sender_name']);
            // Subject of email
            $this->email->subject($data_sendmail["subject"]);
            // Message in email
            $this->email->message($data_sendmail["message"]);

            if ($this->email->send()) {
                $this->email->clear(TRUE);
                return TRUE;
            } else {
                $this->email->clear(TRUE);
                return FALSE;
            }
        }
    }

	function default_args() {
        $order_by = array(
            'modified' => 'DESC',
            'created' => 'DESC'
        );
        $args = array();
        $args['order_by'] = $order_by;

        return $args;
    }

    function counts($options = array()) {
        $default_args = $this->default_args();

        if(is_array($options) && !empty($options)){
            $args = array_merge($default_args, $options);
        }else{
            $args = $default_args;
        }
        return $this->M_emails->counts($args);
    }

    function gets($options = array()) {
		$default_args = $this->default_args();

		if(is_array($options) && !empty($options)){
			$args = array_merge($default_args, $options);
		}else{
			$args = $default_args;
		}

        return $this->M_emails->gets($args);
    }

    function get($id) {
        return $this->M_emails->get($id);
    }

	function add($data) {
		if(!is_array($data) && empty($data)){
			return 0;
		}

        return $this->M_emails->add($data);
    }

	function update($id, $data) {
		if(!is_array($data) && empty($data)){
			return FALSE;
		}

        return $this->M_emails->update($id, $data);
    }

    function admin_repository() {
        $this->_initialize_admin();
        $this->redirect_admin();
        $this->_module_slug = 'emails/repository';
        $this->_data['module_slug'] = $this->_module_slug;

        $this->_plugins_css_admin[] = array(
            'folder' => 'bootstrap3-dialog/css',
            'name' => 'bootstrap-dialog'
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'bootstrap3-dialog/js',
            'name' => 'bootstrap-dialog'
        );
        $this->set_plugins_admin();

        $this->_modules_script[] = array(
            'folder' => 'emails',
            'name' => 'admin-repository-items'
        );
        $this->set_modules();

        $get = $this->input->get();
        $this->_data['get'] = $get;

        $args = $this->default_args();
        if (isset($get['status']) && (int) $get['status'] != -1) {
            $args['status'] = (int) $get['status'];
        }
        if (isset($get['q']) && trim($get['q']) != '') {
            $args['q'] = $get['q'];
        }

        $total = $this->counts($args);
        $perpage = isset($get['per_page']) ? $get['per_page'] : $this->config->item('per_page');
        $segment = 4;

        $this->load->library('pagination');
        $config['total_rows'] = $total;
        $config['per_page'] = $perpage;
        $config['full_tag_open'] = '<ul class="pagination no-margin pull-right">';
        $config['full_tag_close'] = '</ul><!--pagination-->';

        $config['first_link'] = '&laquo;';
        $config['first_tag_open'] = '<li class="prev page">';
        $config['first_tag_close'] = '</li>';

        $config['last_link'] = '&raquo;';
        $config['last_tag_open'] = '<li class="next page">';
        $config['last_tag_close'] = '</li>';

        $config['next_link'] = 'Trang trước &rarr;';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>';

        $config['prev_link'] = '&larr; Trang sau';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="active"><a href="">';
        $config['cur_tag_close'] = '</a></li>';

        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>';

        if (!empty($get)) {
            $config['base_url'] = get_admin_url($this->_module_slug);
            $config['suffix'] = '?' . http_build_query($get, '', "&");
            $config['first_url'] = get_admin_url($this->_module_slug . '?' . http_build_query($get, '', "&"));
            $config['uri_segment'] = $segment;
        } else {
            $config['base_url'] = get_admin_url($this->_module_slug);
            $config['uri_segment'] = $segment;
        }

        $this->pagination->initialize($config);

        $pagination = $this->pagination->create_links();
        $offset = ($this->uri->segment($segment) == '') ? 0 : $this->uri->segment($segment);

        $this->_data['rows'] = $this->M_emails->gets($args, $perpage, $offset);
        $this->_data['pagination'] = $pagination;

        $this->_data['title'] = 'Kho lưu trữ email - ' . $this->_data['title'];
        $this->_data['main_content'] = 'emails/admin/view_page_repository';
        $this->load->view('layout/admin/view_layout', $this->_data);
    }

    function get_configs_emails(){
    	define('MAX_SENDED', 100);
    	//define('MAX_SENDED', 3);
        $configs_emails = null;
        $email_configs = modules::run('emails/emails_configs/gets', array('active' => 1));
        // echo "<pre>";
        // print_r($email_configs);
        // echo "</pre>";
        // https://daveismyname.blog/quick-way-to-add-hours-and-minutes-with-php
        $current_date = date('d-m-Y');
        $start_date_start = get_start_date($current_date);
        $start_date_end = get_end_date($current_date);
        //var_dump(time());

        // $start_date_start = strtotime('-1 hour');
        // $start_date_end = strtotime('+1 hour');
        // var_dump(date('Y-m-d H:i:s', $start_date_start));
        // var_dump(date('Y-m-d H:i:s', $start_date_end));
        // die;
		if (is_array($email_configs) && !empty($email_configs)) {
			foreach ($email_configs as $email_config) {
				$args_email_logs = array(
					'start_date_start' => $start_date_start,
            		'start_date_end' => $start_date_end,
            		'mailed_by' => $email_config['smtp_user'],
            		'not_in_status' => array(0)
            	);
				$email_logs_count = modules::run('emails/emails_logs/counts', $args_email_logs);
				if($email_logs_count < MAX_SENDED){
					$configs_emails = $email_config;
					// echo "<pre>";
			  //       print_r($configs_emails);
			  //       echo "</pre>";
					break;
				}
				// echo "<pre>";
		  //       print_r($email_logs_count);
		  //       echo "</pre>";
			}
		}
		// echo "<pre>";
  //       print_r($configs_emails);
  //       echo "</pre>";
		// die;
		return $configs_emails;
    }

	function admin_content_sendmail() {
        $this->_initialize_admin();
        $this->redirect_admin();

		$this->_module_slug = 'emails/sendmail';
		$this->_data['module_slug'] = $this->_module_slug;

        $this->_plugins_script_admin[] = array(
            'folder' => 'jquery-validation',
            'name' => 'jquery.validate'
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'jquery-validation/localization',
            'name' => 'messages_vi'
        );

        $this->_plugins_css_admin[] = array(
            'folder' => 'chosen',
            'name' => 'chosen'
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'chosen',
            'name' => 'chosen.jquery'
        );
        $this->set_plugins_admin();

        $this->_modules_script[] = array(
            'folder' => 'emails',
            'name' => 'admin-content-validate'
        );
        $this->set_modules();

        // $configs_emails = $this->get_configs_emails();

        $post = $this->input->post();
        if (!empty($post)) {
            $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');
            $this->form_validation->set_rules('full_name', 'Họ tên người gửi', 'trim|required|xss_clean');
            $this->form_validation->set_rules('email', 'Email người gửi', 'trim|required|xss_clean');
            $this->form_validation->set_rules('subject', 'Tiêu đề', 'trim|required|xss_clean');
            $this->form_validation->set_rules('bodyhtml', 'Nội dung gửi mail', 'trim|required');

            if ($this->form_validation->run($this)) {
                $err = FALSE;
				/* $content = $this->input->post('bodyhtml');
				$replacements = array(
					'({full_name})' => 'KH ABC',//ten kh
					'({address})' => 'An Giang',//dia chi
				);
				$message = preg_replace(array_keys($replacements), array_values($replacements), $content);
				echo "<pre>";
				print_r($message);
				echo "</pre>";
				die(); */
				$id = (int) $this->input->post('id');
				$full_name = $this->input->post('full_name');
				$email = $this->input->post('email');
				$subject = $this->input->post('subject');
				$content = $this->input->post('bodyhtml');
				$status = $this->input->post('status');
                $options_emails = $this->input->post('options_emails');
                //$mailings = $this->input->post('mailings');
                $arr_options_emails = NULL;
                $receiver_emails = NULL;
                $mailings = NULL;
                $mailings_group = $this->input->post('mailings_group');
                if (is_array($mailings_group) && !empty($mailings_group)) {
                    $customers = modules::run('emails/emails_customers/gets', array('in_group_id' => $mailings_group));
                    if (is_array($customers) && !empty($customers)) {
                        $mailings = array_column($customers, 'id');
                        $receiver_emails = array_column($customers, 'email');
                    }
                }
                if(trim($options_emails) != ''){
                    $arr_options_emails = explode(',', $options_emails);
                    $arr_options_emails = array_map('trim', $arr_options_emails);
                }
                $is_options_emails = false;
                if(is_array($arr_options_emails) && !empty($arr_options_emails)){
                    $receiver_emails = array_merge($receiver_emails, $arr_options_emails);
                    $is_options_emails = true;
                }
                // echo "<pre>";
                // print_r($mailings_group);
                // print_r($mailings);
                // print_r($arr_options_emails);
                // print_r($receiver_emails);
                // echo "</pre>";
                // die();

				if($status == 1){
					if (is_array($mailings) && !empty($mailings)) {
						$data_email = array(
							'subject' => $subject,
							'full_name' => $full_name,
							'email' => $email,
							'bodyhtml' => $content,
                            'mailings_group' => serialize($mailings_group),
							'mailings' => serialize($mailings),
                            'options_emails' => $options_emails,
                            'receiver_emails' => serialize($receiver_emails),
							'status' => 1
						);
						$email_id = 0;
						if($id != 0){
							$data_email['modified'] = time();
							if($this->update($id, $data_email)){
								$email_id = $id;
							}
						}else{
							$data_email['sended'] = time();
							$data_email['created'] = time();
							$data_email['modified'] = 0;
							$email_id = $this->add($data_email);
						}

						if($email_id != 0){
							foreach ($mailings as $value) {
								$configs_emails = $this->get_configs_emails();
								$row = modules::run('emails/emails_customers/get', $value);

								//replace content code tags
								$replacements = array(
									'({full_name})' => isset($row['full_name']) ? $row['full_name'] : '',//ten kh
									'({address})' => isset($row['address']) ? $row['address'] : '',//dia chi
								);
                                $message = preg_replace(array_keys($replacements), array_values($replacements), $content);
								//$message = htmlspecialchars_decode($message);
                                //$message = $this->load->view('layout/site/partial/html-template-email', array('title'=> $subject, 'body' => $message), true);

                                $data_sendmail = array(
									'sender_email' => $email,
                                    //'sender_name' => $full_name . ' - ' . $email,
									'sender_name' => $full_name,
									'receiver_email' => $row['email'], //mail nhan thư
									'subject' => $subject,
									'message' => $message
								);

                                $data = array(
									'email_id' => $email_id,
									'mailed_by' => $configs_emails['smtp_user'],
									'to' => $row['email'],
									'email' => $email,
									'subject' => $subject,
									'content' => $message,
									'data' => serialize($data_sendmail),
									'status' => 0,
									'created' => time(),
									'viewed' => 0,
									'sended' => 0
								);
								$email_logs_id = modules::run('emails/emails_logs/add', $data);

								//update message attack track
								$message .= "<img border='0' src='" . base_url('email/track') . "?id=" . $email_logs_id . "&email=" . $data['to'] . "' width='1' height='1' alt=''/>";
								$data_sendmail['message'] = $message;
								$email_logs_data = array(
									'content' => $message,
									'data' => serialize($data_sendmail)
								);

								$is_sendmail = $this->send_mail($data_sendmail, $configs_emails);
                                //$is_sendmail = $this->send_mail($data_sendmail);
								if($is_sendmail == 1){
									$email_logs_data['status'] = 1;
									$email_logs_data['sended'] = time();
								}
								modules::run('emails/emails_logs/update', $email_logs_id, $email_logs_data);
								$usleep = rand(200, 1500) * 1000;
								usleep($usleep);
							}
							//die();
                            if($is_options_emails){
                                foreach ($arr_options_emails as $receiver_email) {
                                    $configs_emails = $this->get_configs_emails();
                                    $replacements = array(
                                        '({full_name})' => '',
                                        '({address})' => '',
                                    );
                                    $message = preg_replace(array_keys($replacements), array_values($replacements), $content);

                                    $data_sendmail = array(
                                        'sender_email' => $email,
                                        'sender_name' => $full_name,
                                        'receiver_email' => $receiver_email,
                                        'subject' => $subject,
                                        'message' => $message
                                    );

                                    $data = array(
                                        'email_id' => $email_id,
                                        'mailed_by' => $configs_emails['smtp_user'],
                                        'to' => $receiver_email,
                                        'email' => $email,
                                        'subject' => $subject,
                                        'content' => $message,
                                        'data' => serialize($data_sendmail),
                                        'status' => 0,
                                        'created' => time(),
                                        'viewed' => 0,
                                        'sended' => 0
                                    );
                                    $email_logs_id = modules::run('emails/emails_logs/add', $data);

                                    $message .= "<img border='0' src='" . base_url('email/track') . "?id=" . $email_logs_id . "&email=" . $data['to'] . "' width='1' height='1' alt=''/>";
                                    $data_sendmail['message'] = $message;
                                    $email_logs_data = array(
                                        'content' => $message,
                                        'data' => serialize($data_sendmail)
                                    );

                                    $is_sendmail = $this->send_mail($data_sendmail, $configs_emails);
                                    //$is_sendmail = $this->send_mail($data_sendmail);
                                    if($is_sendmail == 1){
                                        $email_logs_data['status'] = 1;
                                        $email_logs_data['sended'] = time();
                                    }
                                    modules::run('emails/emails_logs/update', $email_logs_id, $email_logs_data);
                                    $usleep = rand(200, 1500) * 1000;
                                    usleep($usleep);
                                }
                            }

							if ($err === FALSE) {
								$notify_type = 'success';
								$notify_content = 'Email đã được gửi!';
							} else {
								$notify_type = 'danger';
								$notify_content = 'Có lỗi xảy ra!';
							}
							$this->set_notify_admin($notify_type, $notify_content);
							redirect(get_admin_url($this->_module_slug));
						}else {
							$notify_type = 'danger';
							$notify_content = 'Có lỗi xảy ra. Chưa gửi mail!';
							$this->set_notify_admin($notify_type, $notify_content);
							redirect(get_admin_url($this->_module_slug));
						}
					} else {
						$notify_type = 'danger';
						$notify_content = 'Chưa chọn danh sách khách hàng nhận mail!';
						$this->set_notify_admin($notify_type, $notify_content);
						redirect(get_admin_url($this->_module_slug));
					}
				}else{
					$data_email = array(
						'subject' => $subject,
						'full_name' => $full_name,
						'email' => $email,
						'bodyhtml' => $content,
                        'mailings_group' => serialize($mailings_group),
						'mailings' => serialize($mailings),
                        'options_emails' => $options_emails,
                        'receiver_emails' => serialize($receiver_emails),
						'status' => 0,
						'sended' => 0
					);
					if($id != 0){
						$data_email['modified'] = time();
						$email_id = intval($this->update($id, $data_email));
					}else{
						$data_email['created'] = time();
						$data_email['modified'] = 0;
						$email_id = $this->add($data_email);
					}
					if($email_id != 0){
						$notify_type = 'success';
						$notify_content = 'Email đã được lưu!';
					}else{
						$notify_type = 'danger';
						$notify_content = 'Email chưa được lưu!';
					}
					$this->set_notify_admin($notify_type, $notify_content);
					redirect(get_admin_url($this->_module_slug));
				}
            }
        }

        $this->_data['breadcrumbs_module_name'] = 'Email';
        $this->_data['breadcrumbs_module_func'] = 'Gửi mail';
        $this->load->library('ckeditor', array('instanceName' => 'CKEDITOR1', 'basePath' => base_url() . "ckeditor/", 'outPut' => true));

		$segment = 4;
        $id = ($this->uri->segment($segment) == '') ? 0 : $this->uri->segment($segment);
        if ($id != 0) {
            $row = $this->get($id);
            $this->_data['row'] = $row;
        }

        $this->_data['customers_group'] = modules::run('emails/emails_customers_group/gets');
        $this->_data['customers'] = modules::run('emails/emails_customers/gets');
        $this->_data['template'] = modules::run('emails/emails_template/gets');

        $this->_data['title'] = 'Gửi mail - ' . $this->_data['breadcrumbs_module_name'] . ' - ' . $this->_data['title'];;
        $this->_data['main_content'] = 'emails/admin/view_page_content';
        $this->load->view('layout/admin/view_layout', $this->_data);
    }

	function ajax_get_code_tag() {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $message = array();
        $message['status'] = 'warning';
        $message['content'] = null;
        $message['message'] = 'Kiểm tra thông tin nhập';

        $post = $this->input->post();
        if (!empty($post)) {
			$key = $this->input->post('key');
			$content = display_value_array($this->config->item('email_variables_name'), $key);

            $message['status'] = 'success';
            $message['content'] = $content;
            $message['message'] = 'Đã tải dữ liệu thành công!';
        }
        echo json_encode($message);
        exit();
    }

}

/* End of file Emails.php */
/* Location: ./application/modules/emails/controllers/Emails.php */