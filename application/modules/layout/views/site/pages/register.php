<article>
    <section>
        <div class="box-user">
            <div class="container">
                <div class="block-wapper--title">
                    <h2>Tạo tài khoản mới</h2>
                </div>
				<p class="note">Bạn đã có tài khoản rồi. Nhấp 
				<a href="<?php echo site_url('dang-nhap'); ?>">vào đây</a> để đăng nhập.</p>
                <div class="block-user--form">
                    <?php $this->load->view('layout/notify'); ?>
                    <form id="f-register" action="<?php echo current_full_url(); ?>" method="post">
                        <div class="row">
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                                <div
                                    class="form-group required<?php echo form_error('full_name') != '' ? ' has-error' : ''; ?>">
                                    <label for="full_name">Họ và tên:</label>
                                    <input type="text" class="form-control" name="full_name">
                                    <?php echo form_error('full_name'); ?>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                                <div
                                    class="form-group required<?php echo form_error('username') != '' ? ' has-error' : ''; ?>">
                                    <label for="username">Username:</label>
                                    <input type="text" class="form-control" name="username" id="id_username">
                                    <?php echo form_error('username'); ?>
                                </div>
                            </div>						
							<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
								<div class="form-group">
									<label for="phone">Số điện thoại</label>
									<input type="text" class="form-control" name="phone">
								</div>
                			</div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                <div
                                    class="form-group required<?php echo form_error('password') != '' ? ' has-error' : ''; ?>">
                                    <label for="password">Mật khẩu:</label>
                                    <input type="password" class="form-control" name="password">
                                    <?php echo form_error('password'); ?>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                <div
                                    class="form-group required<?php echo form_error('password_confirm') != '' ? ' has-error' : ''; ?>">
                                    <label
                                        for="password_confirm">Nhập lại mật khẩu</label>
                                    <input type="password" class="form-control" name="password_confirm">
                                    <?php echo form_error('password_confirm'); ?>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                <div
                                    class="form-group required<?php echo form_error('email') != '' ? ' has-error' : ''; ?>">
                                    <label for="email">Email:</label>
                                    <input type="email" class="form-control" name="email" id="f-register-email">
                                    <?php echo form_error('email'); ?>
                                </div>
                            </div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
								<div class="form-group">
									<label for="address">Địa chỉ:</label>
									<input type="text" class="form-control" name="address">
								</div>
							</div>
                        </div>
						<button type="submit" class="btn btn--button btn--hover-color">Đăng ký tài khoản</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</article>