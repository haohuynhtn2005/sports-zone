<?php
if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}
include_once APPPATH . '/modules/layout/controllers/Layout.php';

class Projects extends Layout {

	private $_module_slug = 'projects';
	private $_path = '';
	private $_allowed_field = array('status', 'inhome');

	function __construct() {
		parent::__construct();
		$this->load->model('projects/m_projects', 'M_projects');
		$this->_data['module_slug'] = $this->_module_slug;
		$this->_data['breadcrumbs_module_name'] = 'Sự kiện';
		$this->_path = get_module_path('projects');
	}

	function admin_ajax_change_field() {
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
		$post = $this->input->post();
		if (!empty($post)) {
			$value = $this->input->post('value');
			$id = $this->input->post('id');
			$field = $this->input->post('field');
			$massage_success = $this->input->post('massage_success');
			$massage_warning = $this->input->post('massage_warning');
			$data = array(
				$field => $value,
			);
			if (!in_array($field, $this->_allowed_field)) {
				$notify_type = 'danger';
				$notify_content = 'Trường này không tồn tại!';
			} else if ($this->M_projects->update($id, $data)) {
				if ($value == 1) {
					$notify_type = 'success';
					$notify_content = $massage_success;
				} else {
					$notify_type = 'warning';
					$notify_content = $massage_warning;
				}
			} else {
				$notify_type = 'danger';
				$notify_content = 'Dữ liệu chưa lưu!';
			}
			$this->set_notify_admin($notify_type, $notify_content);
			$this->load->view('layout/notify-ajax', NULL);
		} else {
			redirect(base_url());
		}
	}

	function default_args() {
		$order_by = array(
			'order' => 'ASC',
			'name' => 'ASC',
		);
		$args = array();
		$args['order_by'] = $order_by;

		return $args;
	}

	function counts($options = array()) {
		$default_args = $this->default_args();

		if (is_array($options) && !empty($options)) {
			$args = array_merge($default_args, $options);
		} else {
			$args = $default_args;
		}
		return $this->M_projects->counts($args);
	}

	function gets($options = array()) {
		$default_args = $this->default_args();

		if (is_array($options) && !empty($options)) {
			$args = array_merge($default_args, $options);
		} else {
			$args = $default_args;
		}

		return $this->M_projects->gets($args);
	}

	function get($id) {
		return $this->M_projects->get($id);
	}

	function get_max_order() {
		$args = $this->default_args();
		$order_by = array(
			'order' => 'DESC',
		);
		$args['order_by'] = $order_by;
		$rows = $this->M_projects->gets($args);
		$max_order = isset($rows[0]['order']) ? $rows[0]['order'] : 0;

		return (int) $max_order;
	}

	function re_order() {
		$args = $this->default_args();
		$order_by = array(
			'order' => 'ASC',
		);
		$args['order_by'] = $order_by;
		$rows = $this->gets($args);
		if (is_array($rows) && !empty($rows)) {
			$i = 0;
			foreach ($rows as $value) {
				$i++;
				$data = array(
					'order' => $i,
				);
				$this->M_projects->update($value['id'], $data);
			}
		}
	}

	function index() {
		$this->_initialize();

        $this->output->cache(true);
        $config_names = array(
            'projects_title',
            'projects_description',
            'projects_keywords',
            'projects_image_share',
        );
        $configs = $this->M_configs->gets($config_names);

        $title_seo = trim($configs['projects_title']) != '' ? $configs['projects_title'] : 'Sự kiện';
        $description = $configs['projects_description'];
        $keywords = $configs['projects_keywords'];
        $image = $configs['projects_image_share'];
        if (trim($title_seo) != '') {
            $this->_data['title_seo'] = $title_seo . ' - ' . $this->_data['title_seo'];
        }
        if (trim($keywords) != '') {
            $this->_data['keywords'] = $keywords;
        }
        if (trim($description) != '') {
            $this->_data['description'] = $description;
        }
        if (trim($image) != '') {
            $this->_data['image'] = get_media('projects', $image, 'no-image.png');
        }

        $args = $this->default_args();

        $total = $this->counts($args);
        $perpage = 12;
        $segment = 2;

        $this->load->library('pagination');
        $config['total_rows'] = $total;
        $config['per_page'] = $perpage;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';

        $config['first_link'] = '&larr;';
        $config['first_tag_open'] = '<li class="prev page">';
        $config['first_tag_close'] = '</li>';

        $config['last_link'] = '&rarr;';
        $config['last_tag_open'] = '<li class="next page">';
        $config['last_tag_close'] = '</li>';

        $config['next_link'] = '&raquo;';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>';

        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="active"><a href="">';
        $config['cur_tag_close'] = '</a></li>';

        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>';

        $config['base_url'] = base_url($this->config->item('url_projects'));
        $config['uri_segment'] = $segment;

        $this->pagination->initialize($config);

        $pagination = $this->pagination->create_links();
        $this->_data['pagination'] = $pagination;

        $offset = ($this->uri->segment($segment) == '') ? 0 : $this->uri->segment($segment);
        $rows = $this->M_projects->gets($args, $perpage, $offset);

        $partial = array();
        $partial['data'] = $rows;
        $this->_data['rows'] = $this->load->view('layout/site/partial/project', $partial, true);

        $this->_breadcrumbs[] = array(
            'url' => site_url($this->config->item('url_projects')),
            'name' => 'Sự kiện'
        );
        $this->set_breadcrumbs();

        $this->_data['title_seo'] = $title_seo . ' - ' . $this->_data['title_seo'];
        $this->_data['main_content'] = 'layout/site/pages/projects';
        $this->load->view('layout/site/layout', $this->_data);
    }

	function site_details() {
		$this->_initialize();
        $segment = 2;
        $uri = explode("-", ($this->uri->segment($segment) == '') ? '' : $this->uri->segment($segment));
        if (count($uri) <= 1) {
            show_404();
        }
        $id = (int) end($uri);
        array_pop($uri);
        $alias = implode("-", $uri);
        if ($id == 0 || $alias == '') {
            show_404();
        }
        $row = $this->get($id);

        if (!empty($row)) {
            $title_seo = trim($row['title_seo']) != '' ? $row['title_seo'] : $row['name'];
            $keywords = $row['keywords'];
            $description = $row['description'];
            $other_seo = $row['other_seo'];
            $h1_seo = $row['h1_seo'];
            $image = $row['image'];
            if (trim($title_seo) != '') {
                $this->_data['title_seo'] = $title_seo . ' - ' . $this->_data['title_seo'];
            }
            if (trim($keywords) != '') {
                $this->_data['keywords'] = $keywords;
            }
            if (trim($description) != '') {
                $this->_data['description'] = $description;
            }
            if (trim($other_seo) != '') {
                $this->_data['other_seo'] = $other_seo;
            }
            if (trim($h1_seo) != '') {
                $this->_data['h1_seo'] = $h1_seo;
            }
            if (trim($image) != '') {
                $this->_data['image'] = get_media('projects', $image, 'no-image.png', '360x236x1');
            }
        } else {
            show_404();
        }
        $this->_data['row'] = $row;

        $this->_breadcrumbs[] = array(
            'url' => site_url($this->config->item('url_projects')),
            'name' => 'Sự kiện'
        );
        $this->_breadcrumbs[] = array(
            'url' => current_url(),
            'name' => $row['name']
        );
        $this->set_breadcrumbs();

        $rows = $this->M_projects->gets(array(
            'not_in_id' => $row['id'],
        ), 12, 0);
        $partial = array();
        $partial['data'] = $rows;
        $this->_data['related_rows'] = $this->load->view('layout/site/partial/project_related', $partial, true);

        $this->_data['main_content'] = 'layout/site/pages/single-project';
        $this->load->view('layout/site/layout', $this->_data);
    }

	function admin_index() {
		$this->_initialize_admin();
		$this->redirect_admin();
		$this->_plugins_css_admin[] = array(
			'folder' => 'bootstrap3-dialog/css',
			'name' => 'bootstrap-dialog',
		);
		$this->_plugins_script_admin[] = array(
			'folder' => 'bootstrap3-dialog/js',
			'name' => 'bootstrap-dialog',
		);
		$this->set_plugins_admin();

		$this->_modules_script[] = array(
			'folder' => 'projects',
			'name' => 'admin-items',
		);
		$this->set_modules();

		$get = $this->input->get();
		$this->_data['get'] = $get;

		$args = $this->default_args();
		if (isset($get['q']) && trim($get['q']) != '') {
			$args['q'] = $get['q'];
		}

		$total = $this->counts($args);
		$perpage = isset($get['per_page']) ? $get['per_page'] : $this->config->item('per_page');
		$segment = 3;

		$this->load->library('pagination');
		$config['total_rows'] = $total;
		$config['per_page'] = $perpage;
		$config['full_tag_open'] = '<ul class="pagination no-margin pull-right">';
		$config['full_tag_close'] = '</ul>';

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

		$this->_data['rows'] = $this->M_projects->gets($args, $perpage, $offset);
		$this->_data['pagination'] = $pagination;

		$this->_data['title'] = 'Danh sách sự kiện - ' . $this->_data['title'];
		$this->_data['main_content'] = 'projects/admin/view_page_index';
		$this->load->view('layout/admin/view_layout', $this->_data);
	}

	function admin_content() {
		$this->_initialize_admin();
		$this->redirect_admin();

		$this->_plugins_script_admin[] = array(
			'folder' => 'jquery-validation',
			'name' => 'jquery.validate',
		);
		$this->_plugins_script_admin[] = array(
			'folder' => 'jquery-validation/localization',
			'name' => 'messages_vi',
		);

		$this->_plugins_css_admin[] = array(
			'folder' => 'bootstrap-fileinput/css',
			'name' => 'fileinput',
		);
		$this->_plugins_script_admin[] = array(
			'folder' => 'bootstrap-fileinput/js',
			'name' => 'fileinput.min',
		);

		$this->set_plugins_admin();

		$this->_modules_script[] = array(
			'folder' => 'projects',
			'name' => 'admin-content-validate',
		);
		$this->set_modules();

		$post = $this->input->post();
		if (!empty($post)) {
			$this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');
			$this->form_validation->set_rules('name', 'Nhập tên sự kiện', 'trim|required|xss_clean');

			if ($this->form_validation->run($this)) {
				if ($this->input->post('id')) {
					$err = FALSE;
					$id = $this->input->post('id');
					if (!$this->admin_update($id)) {
						$err = TRUE;
					}

					if ($err === FALSE) {
						$this->_upload_images($id, 'image');
						$notify_type = 'success';
						$notify_content = 'Cập nhật thông tin thành công!';
						$this->set_notify_admin($notify_type, $notify_content);

						redirect(get_admin_url($this->_module_slug));
					} else {
						$notify_type = 'danger';
						$notify_content = 'Có lỗi xảy ra!';
						$this->set_notify_admin($notify_type, $notify_content);
					}
				} else {
					$err = FALSE;
					$insert_id = $this->admin_add();
					if ($insert_id == 0) {
						$err = TRUE;
					}

					if ($err === FALSE) {
						$this->_upload_images($insert_id, 'image');
						$notify_type = 'success';
						$notify_content = 'Thông tin đã được thêm!';
						$this->set_notify_admin($notify_type, $notify_content);

						redirect(get_admin_url($this->_module_slug));
					} else {
						$notify_type = 'danger';
						$notify_content = 'Có lỗi xảy ra!';
						$this->set_notify_admin($notify_type, $notify_content);
					}
				}
			}
		}
		$this->load->library('ckeditor', array('instanceName' => 'CKEDITOR1', 'basePath' => base_url() . "ckeditor/", 'outPut' => true));
		$title = 'Thêm thông tin - ' . $this->_data['breadcrumbs_module_name'] . ' - ' . $this->_data['title'];

		$segment = 4;
		$id = ($this->uri->segment($segment) == '') ? 0 : $this->uri->segment($segment);
		if ($id != 0) {
			$row = $this->get($id);
			$this->_data['row'] = $row;
			$title = 'Cập nhật thông tin - ' . $this->_data['breadcrumbs_module_name'] . ' - ' . $this->_data['title'];
		}

		$this->_data['title'] = $title;
		$this->_data['main_content'] = 'projects/admin/view_page_content';
		$this->load->view('layout/admin/view_layout', $this->_data);
	}

    function admin_setting() {
        $this->_initialize_admin();
        $this->redirect_admin();

        $this->_plugins_css_admin[] = array(
            'folder' => 'bootstrap-datepicker/css',
            'name' => 'bootstrap-datepicker'
        );
        $this->_plugins_css_admin[] = array(
            'folder' => 'bootstrap-datepicker/css',
            'name' => 'bootstrap-datepicker3'
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'bootstrap-datepicker/js',
            'name' => 'bootstrap-datepicker'
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'bootstrap-datepicker/locales',
            'name' => 'bootstrap-datepicker.vi.min'
        );

        $this->_plugins_script_admin[] = array(
            'folder' => 'jquery-validation',
            'name' => 'jquery.validate',
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'jquery-validation/localization',
            'name' => 'messages_vi',
        );

        $this->_plugins_script_admin[] = array(
            'folder' => 'jquery-mask',
            'name' => 'jquery.mask'
        );

        $this->_plugins_css_admin[] = array(
            'folder' => 'bootstrap-fileinput/css',
            'name' => 'fileinput'
        );
        $this->_plugins_script_admin[] = array(
            'folder' => 'bootstrap-fileinput/js',
            'name' => 'fileinput.min'
        );

        $this->set_plugins_admin();

        $this->_modules_script[] = array(
            'folder' => 'projects',
            'name' => 'admin-setting',
        );
        $this->set_modules();

        $post = $this->input->post();
        if (!empty($post)) {
            $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');
            $this->form_validation->set_rules('projects_title', 'Tiêu đề (SEO)', 'trim|required');

            if ($this->form_validation->run($this)) {
                $err = FALSE;
                $data = array(
                    'projects_title' => $this->input->post('projects_title'),
                    'projects_description' => $this->input->post('projects_description'),
                    'projects_keywords' => $this->input->post('projects_keywords'),
                );
                $this->update_systems($data);

                $this->_upload_image_systems('projects_image_share', $this->_path);

                $notify_type = 'success';
                $notify_content = 'Đã lưu cấu hình sự kiện!';
                $this->set_notify_admin($notify_type, $notify_content);

                redirect(get_admin_url($this->_module_slug));
            }
        }
        $this->_data['breadcrumbs_module_name'] = 'Sự kiện';

        $config_names = array(
            'projects_title',
            'projects_description',
            'projects_keywords',
            'projects_image_share',
        );
        $this->_data['configs'] = $this->M_configs->gets($config_names);

        $this->_data['title'] = 'Cấu hình' . ' - ' . $this->_data['breadcrumbs_module_name'] . ' - ' . $this->_data['title'];
        $this->_data['main_content'] = 'projects/admin/view_page_setting';
        $this->load->view('layout/admin/view_layout', $this->_data);
    }

    function update_systems($data) {
        foreach ($data as $key => $value) {
            $this->M_configs->update($key, array('config_value' => $value));
        }
    }

    function _upload_image_systems($input_name = 'watermark_image', $upload_path = '', $options = array('allowed_types' => 'gif|jpg|png|jpeg')) {
        $config_value = get_config_value($input_name);
        $info = modules::run('files/index', $input_name, $upload_path, $options);
        if (isset($info['uploads'])) {
            $upload_images = $info['uploads'];
            if ($_FILES[$input_name]['size'] != 0) {
                foreach ($upload_images as $value) {
                    $this->update_systems(array($input_name => $value['file_name']));
                }
                @unlink(FCPATH . $upload_path . $config_value);
            }
        }
    }

	function admin_main() {
		$this->_initialize_admin();
		$this->redirect_admin();
		$post = $this->input->post();
		if (!empty($post)) {
			$action = $this->input->post('action');
			if ($action == 'update') {
				$this->_message_success = 'Đã cập nhật sự kiện!';
				$this->_message_warning = 'Không có sự kiện nào để cập nhật!';
				$ids = $this->input->post('ids');
				$orders = $this->input->post('order');
				$count = count($orders);
				if (!empty($ids) && !empty($orders)) {
					for ($i = 0; $i < $count; $i++) {
						$data = array(
							'order' => $orders[$i],
						);
						$id = $ids[$i];
						if ($this->M_projects->update($id, $data)) {
							$notify_type = 'success';
							$notify_content = $this->_message_success;
						} else {
							$notify_type = 'danger';
							$notify_content = $this->_message_danger;
						}
					}
				} else {
					$notify_type = 'warning';
					$notify_content = $this->_message_warning;
				}
				$this->set_notify_admin($notify_type, $notify_content);
				redirect(get_admin_url($this->_module_slug));
			} elseif ($action == 'delete') {
				$this->_message_success = 'Đã xóa các sự kiện được chọn!';
				$this->_message_warning = 'Bạn chưa chọn sự kiện nào!';
				$ids = $this->input->post('idcheck');

				if (is_array($ids) && !empty($ids)) {
					foreach ($ids as $id) {
						$row = $this->get($id);
						if (!empty($row) && $this->M_projects->delete($id)) {
							$notify_type = 'success';
							$notify_content = $this->_message_success;
						} else {
							$notify_type = 'danger';
							$notify_content = $this->_message_danger;
						}
					}
					$this->re_order();
				} else {
					$notify_type = 'warning';
					$notify_content = $this->_message_warning;
				}
				$this->set_notify_admin($notify_type, $notify_content);
				redirect(get_admin_url($this->_module_slug));
			} elseif ($action == 'content') {
				redirect(get_admin_url($this->_module_slug . '/content'));
			}
		} else {
			redirect(get_admin_url($this->_module_slug));
		}
	}

	function admin_add() {
		$data = array(
			'name' => $this->input->post('name'),
			'alias' => $this->input->post('alias'),
			'customer' => $this->input->post('customer'),
			'address' => $this->input->post('address'),
			'time' => $this->input->post('time'),
			'contact' => $this->input->post('contact'),
			'hometext' => $this->input->post('hometext'),
			'content' => $this->input->post('content'),
            'title_seo' => $this->input->post('title_seo'),
            'description' => $this->input->post('description'),
            'keywords' => $this->input->post('keywords'),
            'other_seo' => $this->input->post('other_seo'),
            'h1_seo' => $this->input->post('h1_seo'),
            'inhome' => $this->input->post('inhome') ? 1 : 0,
			'order' => $this->get_max_order() + 1,
			'status' => 1,
			'created' => time(),
			'modified' => 0,
		);

		return $this->M_projects->add($data);
	}

	function admin_update($id) {
		$data = array(
			'name' => $this->input->post('name'),
			'alias' => $this->input->post('alias'),
			'customer' => $this->input->post('customer'),
			'address' => $this->input->post('address'),
			'time' => $this->input->post('time'),
			'contact' => $this->input->post('contact'),
			'hometext' => $this->input->post('hometext'),
			'content' => $this->input->post('content'),
            'title_seo' => $this->input->post('title_seo'),
            'description' => $this->input->post('description'),
            'keywords' => $this->input->post('keywords'),
            'other_seo' => $this->input->post('other_seo'),
            'h1_seo' => $this->input->post('h1_seo'),
            'inhome' => $this->input->post('inhome') ? 1 : 0,
			'modified' => time(),
		);
		return $this->M_projects->update($id, $data);
	}

	function admin_delete() {
		$this->_initialize_admin();
		$this->redirect_admin();

		$this->_message_success = 'Đã xóa thông tin!';
		$this->_message_warning = 'Thông tin này không tồn tại!';
		$id = $this->input->get('id');
		if ($id != 0) {
			if ($this->M_projects->delete($id)) {
				$this->re_order();
				$notify_type = 'success';
				$notify_content = $this->_message_success;
			} else {
				$notify_type = 'danger';
				$notify_content = $this->_message_danger;
			}
		} else {
			$notify_type = 'warning';
			$notify_content = $this->_message_warning;
		}
		$this->set_notify_admin($notify_type, $notify_content);
		redirect(get_admin_url($this->_module_slug));
	}

	private function _upload_images($id, $input_name) {
      	$row = $this->get($id);
      	$info = modules::run('files/index', $input_name, $this->_path);
      	if (isset($info['uploads'])) {
        	$upload_images = $info['uploads']; // thông tin ảnh upload
        	if ($_FILES[$input_name]['size'] != 0) {
          		foreach ($upload_images as $value) {
            		$file_name = $value['file_name']; //tên ảnh
            		$data_images = array(
              			$input_name => $file_name
            		);
            		$this->M_projects->update($id, $data_images);
          		}
          		@unlink(FCPATH . $this->_path . $row[$input_name]);
        	}
    	}
    }
}
/* End of file Projects.php */
/* Location: ./application/modules/projects/controllers/Projects.php */