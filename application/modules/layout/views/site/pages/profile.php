<style type="text/css">
.file {
	visibility: hidden;
	position: absolute;
}
</style>
<article>
	<section>
		<div class="bg-brea">
			<div class="box-warpper box-wapper-profile">
				<div class="container">
					<?php //$this->load->view('breadcrumb'); ?>
					<div class="profile-main">
						<div class="row">
							<div class="col-xl-9 col-lg-9 col-md-9 col-sm-9">
								<div class="row">
									<?php $this->load->view('block-left-admin'); ?>
									<div class="col-xl-9 col-lg-9 col-md-9 col-sm-9">
										<div class="box-profile">
											<?php $this->load->view('layout/notify'); ?>
											<form id="f-profile" action="<?php echo current_full_url(); ?>" method="post" enctype="multipart/form-data" autocomplete="off">
												<div class="block-wapper--title">
													<h2>Thay đổi thông tin cá nhân</h2>
												</div>
												<div class="row form-group">
													<div class="col-lg-4 col-md-4 col-sm-12">
														<p class="account-change-email_header">Địa chỉ email</p>
													</div>
													<div class="col-lg-8 col-md-8 col-sm-12">
														<input class="form-control" type="text" name="email" value="<?php echo isset($row['email']) ? $row['email'] : ''; ?>" readonly>
													</div>
												</div>
												<div class="form-group row<?php echo form_error('full_name') != '' ? ' has-error' : ''; ?>">
													<div class="col-lg-4 col-md-4 col-sm-12">
														<p class="account-change-email_header">Họ và tên*</p>
													</div>
													<div class="col-lg-8 col-md-8 col-sm-8">
														<input type="text" class="form-control form-control-sm" name="full_name" value="<?php echo isset($row['full_name']) ? $row['full_name'] : ''; ?>" placeholder="Nhập họ và tên">
														<?php echo form_error('full_name'); ?>
													</div>
												</div>
												<div class="form-group row<?php echo form_error('address') != '' ? ' has-error' : ''; ?>">
													<div class="col-lg-4 col-md-4 col-sm-12">
														<p class="account-change-email_header">Địa chỉ*</p>
													</div>
													<div class="col-lg-8 col-md-8 col-sm-8">
														<input type="text" class="form-control form-control-sm" name="address" value="<?php echo isset($row['address']) ? $row['address'] : ''; ?>" placeholder="Nhập địa chỉ">
														<?php echo form_error('address'); ?>
													</div>
												</div>
												<div class="form-group row<?php echo form_error('phone') != '' ? ' has-error' : ''; ?>">
													<div class="col-lg-4 col-md-4 col-sm-12">
														<p class="account-change-email_header">Điện thoại*</p>
													</div>
													<div class="col-lg-8 col-md-8 col-sm-8">
														<input type="text" class="form-control form-control-sm" name="phone" value="<?php echo isset($row['phone']) ? $row['phone'] : ''; ?>" placeholder="Nhập số điện thoại">
														<?php echo form_error('phone'); ?>
													</div>
												</div>
												<div class="form-group row">
													<div class="col-lg-4 col-md-4 col-sm-12">
														<p class="account-change-email_header">Chọn ảnh đại diện</p>
													</div>
													<div class="col-lg-8 col-md-8 col-sm-8">
														<input type="file" id="photo" name="photo[]" class="file" accept="image/*">
														<div class="input-group">
															<input type="text" class="form-control" disabled placeholder="Chọn ảnh" id="file">
															<div class="input-group-append">
																<button type="button" class="browse btn btn-primary">Chọn ảnh...</button>
															</div>
														</div>
														<img src="<?php echo get_image(get_module_path('users') . $photo, get_module_path('users') . 'no-image.png'); ?>" id="preview" class="img-thumbnail my-3">
													</div>
												</div>
												<div class="block-wapper--title">
													<h2>Thông tin tài khoản ngân hàng</h2>
												</div>
												<div class="row form-group">
													<div class="col-lg-4 col-md-4 col-sm-12">
														<p class="account-change-email_header">Tên chủ sở hữu</p>
													</div>
													<div class="col-lg-8 col-md-8 col-sm-12">
														<input class="form-control" type="text" name="account_holder" value="<?php echo isset($row['account_holder']) ? $row['account_holder'] : ''; ?>">
													</div>
												</div>
												<div class="row form-group">
													<div class="col-lg-4 col-md-4 col-sm-12">
														<p class="account-change-email_header">Số tài khoản</p>
													</div>
													<div class="col-lg-8 col-md-8 col-sm-12">
														<input class="form-control" type="text" name="account_number" value="<?php echo isset($row['account_number']) ? $row['account_number'] : ''; ?>">
													</div>
												</div>
												<div class="row form-group">
													<div class="col-lg-4 col-md-4 col-sm-12">
														<p class="account-change-email_header">Tên ngân hàng</p>
													</div>
													<div class="col-lg-8 col-md-8 col-sm-12">
														<select class="form-control" name="banker_id">
															<?php echo display_option_select($banker, 'id', 'name', isset($row['banker_id']) ? $row['banker_id'] : 0); ?>
														</select>
													</div>
												</div>
												<div class="row form-group">
													<div class="col-lg-4 col-md-4 col-sm-12">
														<p class="account-change-email_header">Chi nhánh ngân hàng</p>
													</div>
													<div class="col-lg-8 col-md-8 col-sm-12">
														<input class="form-control" type="text" name="bank_branch" value="<?php echo isset($row['bank_branch']) ? $row['bank_branch'] : ''; ?>">
													</div>
												</div>
												<div class="row form-group">
													<div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 offset-xl-4 offset-lg-4 offset-md-4 offset-sm-4">
														<button type="submit" class="btn btn-sm btn-success btn-block">Lưu</button>
													</div>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-3 col-lg-3 col-md-3 col-sm-3">
								<div class="box-slidebar-profile">
									<div class="card-image pb-4">
										<img src="<?php echo get_image(get_module_path('users') . $photo, get_module_path('users') . 'no-image.png'); ?>" alt="" class="img-fluid rounded-circle">
									</div>
									<div class="card">
										<div class="card-body">
											<h3>TÀI KHOẢN CỦA TÔI</h3>
											<p>Tên tài khoản: <span><?php echo isset($row['full_name']) ? $row['full_name'] : ''; ?>!</span></p>
											<div class="block-content">
												<p>Địa chỉ: <span><?php echo isset($row['address']) ? $row['address'] : ''; ?></span></p>
												<p>Điện thoại: <span><?php echo isset($row['phone']) ? $row['phone'] : ''; ?></span></p>
												<p>Email: <span><?php echo isset($row['email']) ? $row['email'] : ''; ?></span></p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</article>