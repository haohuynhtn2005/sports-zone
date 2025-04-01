<article>
    <section>
        <div class="box-warpper box-user">
            <div class="container">
                <div class="block-wapper--title">
                    <h2>Thay đổi mật khẩu</h2>
                </div>
                <div class="change-password">
                    <div class="row">
                        <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9">
                            <div class="block-user--form">
                                <?php $this->load->view('layout/notify'); ?>
                                <form action="<?php echo current_full_url(); ?>" method="post">
                                    <div class="row">
                                        <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12">
                                            <div class="form-group">
                                                <label for="current_password">Mật khẩu hiện tại:</label>
                                                <input type="password" class="form-control" name="current_password"
                                                    id="current_password">
                                            </div>
                                            <div class="form-group">
                                                <label for="password">Mật khẩu mới:</label>
                                                <input type="password" class="form-control" name="password"
                                                    id="password">
                                            </div>
                                            <div class="form-group">
                                                <label for="password_confirm">Nhập lại mật khẩu mới:</label>
                                                <input type="password" class="form-control" name="password_confirm"
                                                    id="password_confirm">
                                            </div>
                                        </div>
									</div>
									<button type="submit" class="btn btn--button btn--hover-color">Lưu thay đổi</button>
                                </form>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3">
                            <div class="box-slidebar-profile">
                                <div class="card">
                                    <div class="card-body">
                                        <h3>TÀI KHOẢN CỦA TÔI</h3>
                                        <p>Tên tài khoản:
                                            <span><?php echo isset($user['full_name']) ? $user['full_name'] : ''; ?>!</span>
                                        </p>
                                        <div class="block-content">
                                            <p>Địa chỉ: <span><?php echo isset($user['address']) ? $user['address'] : ''; ?></span>
                                            </p>
                                            <p>Điện thoại: <span><?php echo isset($user['phone']) ? $user['phone'] : ''; ?></span>
                                            </p>
                                            <p>Email: <span><?php echo isset($user['email']) ? $user['email'] : ''; ?></p></span>
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