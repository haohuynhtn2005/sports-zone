<article>
    <section>
        <div class="box-user">
            <div class="container">
                <div class="block-wapper--title">
                    <h2>Đăng nhập</h2>
                </div>
                <div class="block-user--form">
                    <?php $this->load->view('layout/notify'); ?>
                    <form id="f-login" action="<?php echo current_full_url(); ?>" method="post">
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <div
                                    class="form-group required<?php echo form_error('username') != '' ? ' has-error' : ''; ?>">
                                    <label for="username" class="control-label">Tên đăng nhập</label>
                                    <input type="text" name="username" class="form-control">
                                    <?php echo form_error('username'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <div
                                    class="form-group required<?php echo form_error('password') != '' ? ' has-error' : ''; ?>">
                                    <label for="password" class="control-label">Mật khẩu</label>
                                    <input type="password" name="password" class="form-control">
                                    <?php echo form_error('password'); ?>
                                </div>
                            </div>
                        </div>
                        <p class="note">Bạn quên mật khẩu? Bấm <a href="<?php echo site_url('quen-mat-khau'); ?>">vào
                                đây để lấy lại mật khẩu.</a></p>
                        <div class="block-user--button">
                            <button type="submit" class="btn btn--button btn--hover-color mr-2">Đăng nhập</button>
                            <a href="<?php echo site_url('dang-ky'); ?>" class="btn btn--button btn--color">Đăng ký tài
                                khoản</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</article>