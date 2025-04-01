<?php
if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}
include_once APPPATH . '/modules/layout/controllers/Layout.php';

class Emails_customers extends Layout {

	private $_module_slug = 'emails/customers';
	public $_path = '';

	function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('emails/m_emails_customers', 'M_emails_customers');
		$this->_path = get_module_path('customers');
		$this->_data['breadcrumbs_module_name'] = 'Khách hàng';
		$this->_data['module_slug'] = $this->_module_slug;
	}

	function default_args() {
		$order_by = array(
			'full_name' => 'ASC',
		);
		$args = array();
		$args['order_by'] = $order_by;

		return $args;
	}

	function gets($options = array()) {
		$default_args = $this->default_args();
		if (is_array($options) && !empty($options)) {
			$args = array_merge($default_args, $options);
		} else {
			$args = $default_args;
		}
		return $this->M_emails_customers->gets($args);
	}

	function counts($options = array()) {
		$default_args = $this->default_args();
		if (is_array($options) && !empty($options)) {
			$args = array_merge($default_args, $options);
		} else {
			$args = $default_args;
		}
		return $this->M_emails_customers->counts($args);
	}

	function get($id) {
		return $this->M_emails_customers->get($id);
	}

	function get_by($options = array()) {
		$default_args = $this->default_args();
		if (is_array($options) && !empty($options)) {
			$args = array_merge($default_args, $options);
		} else {
			$args = $default_args;
		}
		return $this->M_emails_customers->get_by($args);
	}

	function check_phone_availablity() {
		$post = $this->input->post();
		$this->_message_success = 'true';
		$this->_message_danger = 'false';

		if (!empty($post)) {
			if ($this->input->post('ajax') == '1') {
				$phone = $this->input->post('phone');
				$id = $this->input->post('id');
				if ($this->M_emails_customers->check_phone_availablity($phone, $id)) {
					$this->_status = "success";
					$this->_message = $this->_message_success;
				} else {
					$this->_status = "danger";
					$this->_message = $this->_message_danger;
				}

				$this->set_json_encode();
				$this->load->view('layout/json_data', $this->_data);
			} else {
				$phone = $this->input->post('phone');
				$id = $this->input->post('id');
				if ($this->M_emails_customers->check_phone_availablity($phone, $id)) {
					return TRUE;
				} else {
					return FALSE;
				}
			}
		} else {
			redirect(get_admin_url());
		}
	}

	function admin_export_excel() {
		$this->_initialize_admin();
        $this->redirect_admin();

		$this->load->library('excel');
		$this->excel->getProperties()->setCreator("Admin")
			->setLastModifiedBy("Admin")
			->setTitle("Danh sách khách hàng")
			->setSubject("Danh sách khách hàng")
			->setDescription("Quản lý danh sách khách hàng")
			->setKeywords("Quản lý danh sách khách hàng")
			->setCategory("Khách hàng");
		$this->excel->getActiveSheet()->setTitle('Danh sách khách hàng');

		$this->excel->setActiveSheetIndex(0)
			->setCellValue('A1', 'Nhóm KH')
			->setCellValue('B1', 'Người tạo')
			->setCellValue('C1', 'Khách hàng')
			->setCellValue('D1', 'Thành phố')
			->setCellValue('E1', 'Địa chỉ')
			->setCellValue('F1', 'Điện thoại')
			->setCellValue('G1', 'Email')
			->setCellValue('H1', 'Ghi chú')
			->setCellValue('I1', 'Hoạt động')
			->setCellValue('J1', 'Đã xóa')
			->setCellValue('K1', 'Ngày tạo')
			->setCellValue('L1', 'Ngày cập nhật')
			->setCellValue('M1', 'ID');
		$args = $this->default_args();
		$rows = $this->M_emails_customers->gets($args);
		$i = 2;
		foreach ($rows as $row) {
			$this->excel->setActiveSheetIndex(0)
				->setCellValue('A' . $i, $row['group_id'])
				->setCellValue('B' . $i, $row['created_by'])
				->setCellValue('C' . $i, $row['full_name'])
				->setCellValue('D' . $i, $row['city'])
				->setCellValue('E' . $i, $row['address'])
				->setCellValue('F' . $i, $row['phone'])
				->setCellValue('G' . $i, $row['email'])
				->setCellValue('H' . $i, $row['note'])
				->setCellValue('I' . $i, $row['active'])
				->setCellValue('J' . $i, $row['deleted'])
				->setCellValue('K' . $i, $row['created'] > 0 ? display_date($row['created'], true) : '')
				->setCellValue('L' . $i, $row['modified'] > 0 ? display_date($row['modified'], true) : '')
				->setCellValue('M' . $i, $row['id']);
			$i++;
		}
		$end_cell = 'M';
		$this->excel->getActiveSheet()->getStyle(
			'A1:' . $end_cell . '1'
		)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
		$this->excel->getActiveSheet()->getStyle(
			'A2:' . $end_cell . ($i - 1)
		)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

		$styleArray = array(
			'font' => array(
				'bold' => true,
				'color' => array('rgb' => '357CA5'),
				'size' => 11,
				'name' => 'Arial',
			),
		);
		$this->excel->getActiveSheet()->getStyle('A1:' . $end_cell . '1')->applyFromArray($styleArray);
		$styleArray = array(
			'font' => array(
				'size' => 11,
				'name' => 'Arial',
			),
		);
		$this->excel->getActiveSheet()->getStyle('A2:' . $end_cell . ($i - 1))->applyFromArray($styleArray);

		// $this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		// $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		// $this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		// $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		// $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		// $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		// $this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
		// $this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
		// $this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
		// $this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
		//PHPExcel_Shared_Font::setAutoSizeMethod(PHPExcel_Shared_Font::AUTOSIZE_METHOD_EXACT);
		foreach ($this->excel->getWorksheetIterator() as $worksheet) {
			$this->excel->setActiveSheetIndex($this->excel->getIndex($worksheet));
			$sheet = $this->excel->getActiveSheet();
			$cellIterator = $sheet->getRowIterator()->current()->getCellIterator();
			$cellIterator->setIterateOnlyExistingCells(true);
			foreach ($cellIterator as $cell) {
				$sheet->getColumnDimension($cell->getColumn())->setAutoSize(true);
			}
		}

		$filename = 'Danh-sach-khach-hang_' . date('Y-m-d_H-i-s') . '.xls';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
		$objWriter->save('php://output');
	}

	function admin_import_excel() {
		$this->_initialize_admin();
        $this->redirect_admin();

		$this->_plugins_css_admin[] = array(
			'folder' => 'bootstrap-fileinput/css',
			'name' => 'fileinput',
		);
		$this->_plugins_script_admin[] = array(
			'folder' => 'bootstrap-fileinput/js',
			'name' => 'fileinput.min',
		);

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
			'folder' => 'customers',
			'name' => 'admin-import',
		);
		$this->set_modules();

		$post = $this->input->post();
		if (!empty($post)) {
			$this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');
			$this->form_validation->set_rules('token', 'Don\'t hack to site', 'trim|required');
			if ($this->form_validation->run($this)) {
				$input_name = 'file';
				$file = $this->_upload_files($input_name, $this->_path, array('allowed_types' => 'xls|xlsx'));

				if (trim($file) != '') {
					$this->load->library('excel');
					$header = array();
					$data = array();
					$rows = array();

					$objPHPExcel = PHPExcel_IOFactory::load('./' . $this->_path . $file);
					$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
					foreach ($cell_collection as $cell) {
						$column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
						$row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
						$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
						if ($row == 1) {
							$header[$row][$column] = $data_value;
						} else {
							$rows[$row][$column] = $data_value;
						}
					}

					$data['header'] = $header;
					$data['values'] = $rows;

					$is_error = FALSE;
					if (is_array($data['values']) && !empty($data['values'])) {
						$group_id = (int) $this->input->post('group_id');
						$truncate = $this->input->post('truncate') ? TRUE : FALSE;
						$update_if_exist = $this->input->post('update_if_exist') ? TRUE : FALSE;
						if ($group_id != 0) {
							$this->M_emails_customers->delete_by(array('group_id' => $group_id));
						} elseif ($truncate) {
							$this->M_emails_customers->truncate();
						}
						foreach ($data['values'] as $value) {
							$data_row = array(
								'group_id' => $group_id != 0 ? $group_id : $value['A'],
								'created_by' => $value['B'],
								'full_name' => $value['C'],
								'city' => $value['D'],
								'address' => $value['E'],
								'phone' => $value['F'],
								'email' => $value['G'],
								'note' => $value['H'],
								'active' => $value['I'],
								'deleted' => $value['J'],
								'created' => $value['K'] != '' ? convert_date($value['K']) : time(),
								'modified' => $value['L'] != '' ? convert_date($value['L']) : 0,
							);
							if (isset($value['M']) && (int) $value['M'] != 0) {
								$data_row['id'] = (int) $value['M'];
							}

							if (!$this->M_emails_customers->add($data_row)) {
								$is_error = TRUE;
							}
						}
					}

					if (!$is_error) {
						@unlink(FCPATH . $this->_path . $file);

						$notify_type = 'success';
						$notify_content = 'Dữ liệu khách hàng đã nhập thành công!';
						$this->set_notify_admin($notify_type, $notify_content);
						redirect(get_admin_url($this->_module_slug));
					} else {
						$notify_type = 'danger';
						$notify_content = 'Có lỗi xảy ra! Vui lòng kiểm tra lại!';
						$this->set_notify_admin($notify_type, $notify_content);
					}
				}
			}
		}

		$customers_group = modules::run('customers/customers_group/gets');
		$this->_data['customers_group'] = $customers_group;

		$this->_data['breadcrumbs_module_func'] = 'Nhập dữ liệu khách hàng';
		$this->_data['title'] = 'Nhập dữ liệu khách hàng - ' . $this->_data['title'];
		$this->_data['main_content'] = 'customers/view_page_import';
		$this->load->view('layout/admin/view_layout', $this->_data);
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
			'folder' => 'emails',
			'name' => 'admin-customers-items',
		);
		$this->set_modules();

		$get = $this->input->get();
		$this->_data['get'] = $get;
		$allow_method = array(
			'full_name',
			'address',
			'phone',
		);

		$args = $this->default_args();
		if (isset($get['q']) && trim($get['q']) != '') {
			$args['q'] = $get['q'];
		}
		if (isset($get['group_id']) && (int)($get['group_id']) != 0) {
			$args['group_id'] = (int)($get['group_id']);
		}
		$total = $this->counts($args);
		$perpage = isset($get['per_page']) ? (int) $get['per_page'] : 10;
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
		$this->_data['pagination'] = $pagination;

		$offset = ($this->uri->segment($segment) == '') ? 0 : $this->uri->segment($segment); # Lấy offset
		$this->_data['current_page'] = (int) $offset;
		$rows = $this->M_emails_customers->gets($args, $perpage, $offset);
		$this->_data['rows'] = $rows;

		$this->_data['breadcrumbs_module_func'] = 'Danh sách khách hàng';
		$this->_data['group'] = modules::run('emails/emails_customers_group/gets');

		$this->_data['title'] = 'Danh sách khách hàng';
		$this->_data['main_content'] = 'emails/admin/view_page_customers_index';
		$this->load->view('layout/admin/view_layout', $this->_data);
	}

	function admin_content() {
		$this->_initialize_admin();
        $this->redirect_admin();

		$this->_plugins_css_admin[] = array(
			'folder' => 'bootstrap-datepicker/css',
			'name' => 'bootstrap-datepicker',
		);
		$this->_plugins_css_admin[] = array(
			'folder' => 'bootstrap-datepicker/css',
			'name' => 'bootstrap-datepicker3',
		);
		$this->_plugins_script_admin[] = array(
			'folder' => 'bootstrap-datepicker/js',
			'name' => 'bootstrap-datepicker',
		);
		$this->_plugins_script_admin[] = array(
			'folder' => 'bootstrap-datepicker/locales',
			'name' => 'bootstrap-datepicker.vi.min',
		);
		$this->_plugins_script_admin[] = array(
			'folder' => 'jquery-validation',
			'name' => 'jquery.validate',
		);
		$this->_plugins_script_admin[] = array(
			'folder' => 'jquery-validation/localization',
			'name' => 'messages_vi',
		);

		$this->_plugins_css_admin[] = array(
			'folder' => 'chosen',
			'name' => 'chosen',
		);
		$this->_plugins_script_admin[] = array(
			'folder' => 'chosen',
			'name' => 'chosen.jquery',
		);

		$this->set_plugins_admin();

		$this->_modules_script[] = array(
			'folder' => 'emails',
			'name' => 'admin-customers-content-validate',
		);
		$this->set_modules();

		$post = $this->input->post();
		if (!empty($post)) {
			$this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');
			$validations = array(
				array(
					'field' => 'full_name',
					'label' => 'Khách hàng',
					'rules' => 'trim|required',
				),
				array(
					'field' => 'phone',
					'label' => 'Số điện thoại',
					'rules' => 'trim|required',
				),
			);
			$this->form_validation->set_rules($validations);

			if ($this->form_validation->run($this)) {
				if ($this->input->post('id')) {
					$err = FALSE;
					$id = $this->input->post('id');
					if (!$this->admin_update($id)) {
						$err = TRUE;
					}
					if ($err === FALSE) {
						$current_page = $this->input->post('current_page');
						$notify_type = 'success';
						$notify_content = 'Cập nhật khách hàng thành công!';
						$this->set_notify_admin($notify_type, $notify_content);
						redirect(get_admin_url((isset($current_page) && $current_page > 0) ? ($this->_module_slug . '/' . $current_page) : $this->_module_slug));
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
						$notify_type = 'success';
						$notify_content = 'Khách hàng đã được thêm!';
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

		$title = 'Thêm khách hàng - ' . $this->_data['breadcrumbs_module_name']; // . ' - ' . $this->_data['title'];

		$segment = 5;
		$id = ($this->uri->segment($segment) == '') ? 0 : $this->uri->segment($segment);
		if ($id != 0) {
			$this->_data['current_page'] = (int) $this->input->get('current_page');
			$row = $this->get($id);
			$this->_data['row'] = $row;
			$title = 'Cập nhật khách hàng - ' . $this->_data['breadcrumbs_module_name']; // . ' - ' . $this->_data['title'];
		}
		$this->_data['group'] = modules::run('emails/emails_customers_group/gets');

		$this->_data['title'] = $title;
		$this->_data['main_content'] = 'emails/admin/view_page_customers_content';
		$this->load->view('layout/admin/view_layout', $this->_data);
	}

	function admin_add() {
		$data = array(
			'group_id' => (int) $this->input->post('group_id'),
			'user_id' => (int) $this->input->post('user_id'),
			'created_by' => $this->_data['userid'],
			'full_name' => $this->input->post('full_name'),
			'city' => $this->input->post('city'),
			'address' => $this->input->post('address'),
			'phone' => $this->input->post('phone'),
			'email' => $this->input->post('email'),
			'note' => $this->input->post('note'),
			'active' => $this->input->post('active') ? 1 : 0,
			'deleted' => 0,
			'created' => time(),
			'modified' => 0,
		);

		return $this->M_emails_customers->add($data);
	}

	function admin_update($id) {
		$data = array(
			'group_id' => (int) $this->input->post('group_id'),
			'user_id' => (int) $this->input->post('user_id'),
			'full_name' => $this->input->post('full_name'),
			'city' => $this->input->post('city'),
			'address' => $this->input->post('address'),
			'phone' => $this->input->post('phone'),
			'email' => $this->input->post('email'),
			'note' => $this->input->post('note'),
			'modified' => time(),
		);

		return $this->M_emails_customers->update($id, $data);
	}

	function admin_delete() {
		$this->_initialize_admin();
        $this->redirect_admin();

		$this->_message_success = 'Đã xóa khách hàng!';
		$this->_message_warning = 'Khách hàng này không tồn tại!';
		$id = (int) $this->input->get('id');
		if ($id != 0) {
			if ($this->M_emails_customers->delete($id)) {
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

	function admin_main() {
		$this->_initialize_admin();
        $this->redirect_admin();

		$post = $this->input->post();
		if (!empty($post)) {
			$action = $this->input->post('action');
			if ($action == 'delete') {
				$this->_message_success = 'Đã xóa các khách hàng được chọn!';
				$this->_message_warning = 'Bạn chưa chọn khách hàng nào!';
				$ids = $this->input->post('idcheck');

				if (is_array($ids) && !empty($ids)) {
					foreach ($ids as $id) {
						$row = $this->get($id);
						if ($this->M_emails_customers->delete($id)) {
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
			} elseif ($action == 'content') {
				redirect(get_admin_url($this->_module_slug . '/content'));
			}
		} else {
			redirect(get_admin_url($this->_module_slug));
		}
	}

	function _upload_files($input_name = 'file', $upload_path = '', $options = array('allowed_types' => 'gif|jpg|png|jpeg')) {
		$filename = '';
		$info = modules::run('files/index', $input_name, $upload_path, $options);
		if (isset($info['uploads'])) {
			$upload_images = $info['uploads']; // thông tin ảnh upload
			if ($_FILES[$input_name]['size'] != 0) {
				foreach ($upload_images as $value) {
					$filename = $value['file_name'];
				}
			}
		}

		return $filename;
	}
}
/* End of file Emails_customers.php */
/* Location: ./application/modules/emails/controllers/Emails_customers.php */