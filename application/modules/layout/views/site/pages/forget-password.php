<article>
    <section>
        <div class="box-user">
            <div class="container">
                <div class="block-wapper--title">
                    <h2>Bạn quên mật khẩu ?</h2>
                </div>
                <p class="note">Bạn quên mật khẩu? Nhập địa chỉ email để lấy lại mật khẩu qua email.</p>
                <div class="block-user--form">
                    <form id="f-forget-password" action="<?php echo current_full_url(); ?>" method="post">
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <div
                                    class="form-group required<?php echo form_error('email') != '' ? ' has-error' : ''; ?>">
                                    <label for="email">Email:</label>
                                    <input type="email" class="form-control" name="email" id="id_email">
                                    <?php echo form_error('email'); ?>
                                </div>
                            </div>
						</div>
						<button type="submit" class="btn btn--button btn--hover-color">Gửi yêu cầu</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</article>