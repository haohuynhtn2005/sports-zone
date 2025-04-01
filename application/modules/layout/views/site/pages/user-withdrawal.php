<article>
    <section class="user-manager-page">
        <div class="bg-brea">
            <div class="box-wapper">
                <div class="container">
                    <div class="users_cash-drawing">
                        <div class="row">
                            <?php $this->load->view('block-left-admin'); ?>
                            <div class="col-lg-9 col-md-9 col-sm-9">
                                <div class="account-structure-page_main-content">
                                    <div class="account-change-email">
                                        <h2 class="account-structure-page_title">Thông tin rút tiền <a
                                                href="<?php echo site_url('rut-tien/lich-su'); ?>"
                                                class="float-right"><i class="fa fa-history" aria-hidden="true"></i>
                                                Lịch sử rút tiền</a></h2>
                                        <div class="box-devision-col-mobile">
                                            <?php $this->load->view('layout/notify'); ?>
                                            <div class="account-change-email">
                                                <form id="f-withdrawal" action="<?php echo current_full_url(); ?>"
                                                    method="post">
                                                    <div
                                                        class="row form-group<?php echo form_error('amount') != '' ? ' has-error' : ''; ?>">
                                                        <div class="col-lg-3 col-md-3 col-sm-5">
                                                            <p class="account-change-email_header">Số tiền rút *</p>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <input class="form-control mask-price" type="text"
                                                                name="amount" value=""
                                                                placeholder="Bội số của 1.000, ví dụ 1.000, 2.000, 100.000,...">
                                                            <?php echo form_error('amount'); ?>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3 col-md-3 col-sm-5">
                                                            <p class="account-change-email_header">Số điện thoại *</p>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <input class="form-control" type="text"
                                                                value="<?php echo isset($user['phone']) ? $user['phone'] : ''; ?>"
                                                                disabled="disabled">
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3 col-md-3 col-sm-5">
                                                            <p class="account-change-email_header">Tên chủ sở hữu *</p>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <input class="form-control" type="text"
                                                                value="<?php echo isset($user['account_holder']) ? $user['account_holder'] : ''; ?>"
                                                                disabled="disabled">
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3 col-md-3 col-sm-5">
                                                            <p class="account-change-email_header">Số tài khoản *</p>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <input class="form-control" type="text"
                                                                value="<?php echo isset($user['account_number']) ? $user['account_number'] : ''; ?>"
                                                                disabled="disabled">
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3 col-md-3 col-sm-5">
                                                            <p class="account-change-email_header">Tên ngân hàng *</p>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <select class="form-control" disabled="disabled">
                                                                <option value="">-- Chọn ngân hàng rút tiền --
                                                                </option>
                                                                <?php echo display_option_select($banker, 'id', 'name', isset($user['banker_id']) ? $user['banker_id'] : 0); ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-lg-3 col-md-3 col-sm-5">
                                                            <p class="account-change-email_header">Chi nhánh ngân hàng *
                                                            </p>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <input class="form-control" type="text"
                                                                value="<?php echo isset($user['bank_branch']) ? $user['bank_branch'] : ''; ?>"
                                                                disabled="disabled">
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div
                                                            class="col-lg-4 col-md-5 col-sm-5 offset-lg-3 offset-md-3 offset-sm-5">
                                                            <a href="<?php echo site_url('hoa-hong'); ?>"
                                                                class="btn btn-danger">Hủy</a>
                                                            <button type="submit"
                                                                class="btn btn-warning account-change-email_btn-last"
                                                                <?php echo (isset($balance) && $balance > 0) ? '' : ' disabled="disabled"'; ?>>Rút
                                                                tiền</button>
                                                        </div>
                                                    </div>
                                                </form>
                                                <div style="text-align:center; border: solid 1px grey;margin:20px;">
                                                    <p>(*)Lưu ý: Thành viên vui lòng nhập thông tin tài khoản ngân hàng
                                                        trong phần tài khoản cá nhân<br>
                                                        Thời gian nhận thanh toán từ 2 phút đến 12h<br>
                                                        Nếu sau 12h mà tài khoản chưa có tiền vui lòng liên hệ Bộ phần
                                                        kế toán: 090 823 4437 để được hỗ trợ.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
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