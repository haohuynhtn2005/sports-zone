<article>
    <section class="user-manager-page">
        <div class="bg-brea">
            <div class="box-wapper">
                <div class="container">
                    <?php //$this->load->view('breadcrumb'); ?>
                    <div class="users_cash-drawing">
                        <div class="row">
                            <?php $this->load->view('block-left-admin'); ?>
                            <div class="col-lg-9 col-md-9 col-sm-9">
                                <div class="account-structure-page_main-content">
                                    <div class="account-change-email">
                                        <div class="block-wapper--title">
                                            <h2 class="account-structure-page_title">Sổ địa chỉ</h2>
                                        </div>
                                        <div class="address-message">
                                            <?php $this->load->view('layout/notify'); ?>
                                        </div>
                                        <div class="address-add">
                                            <a type="button" id="btn-address-add">
                                                <i class="fa fa-plus-circle" aria-hidden="true"></i> Thêm địa chỉ mới
                                            </a>
                                        </div>
                                        <div class="box-devision-col-mobile address-list">
                                            <?php echo isset($rows) ? $rows : ''; ?>
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
<div class="modal fade modal-user-manager-page" id="addressModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="block-wapper--title">
                    <h2 class="modal-title" id="addressModalLabel">Thêm địa chỉ</h2>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="f-address-content" action="#" method="post">
                <div class="modal-body">
                    <div class="address-modal-message"></div>
                    <div class="account-change-email">
                        <input type="hidden" name="id" value="0">
                        <div class="row form-group">
                            <div class="col-lg-3 col-md-3 col-sm-5">
                                <p class="account-change-email_header">Tên *</p>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-5">
                                <input class="form-control" type="text" name="full_name" value="">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-3 col-md-3 col-sm-5">
                                <p class="account-change-email_header">Địa chỉ nhận hàng (tầng, số nhà, đường) *</p>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-5">
                                <input class="form-control" type="text" name="place_of_receipt" value="">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-3 col-md-3 col-sm-5">
                                <p class="account-change-email_header">Tỉnh/Thành phố *</p>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-5">
                                <select class="form-control" name="province_id" id="el-province">
                                    <option value="0">-- Chọn tỉnh/thành phố --</option>
                                    <?php echo display_option_select($provinces, 'pId', 'pNameVi', 0); ?>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-3 col-md-3 col-sm-5">
                                <p class="account-change-email_header">Quận/huyện *</p>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-5">
                                <select class="form-control" name="district_id" id="el-district">
                                    <option value="0">-- Chọn quận/huyện --</option>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-3 col-md-3 col-sm-5">
                                <p class="account-change-email_header">Phường, xã *</p>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-5">
                                <select class="form-control" name="commune_id" id="el-commune">
                                    <option value="0">-- Chọn phường/xã --</option>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-3 col-md-3 col-sm-5">
                                <p class="account-change-email_header">Số điện thoại *</p>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-5">
                                <input class="form-control" type="text" name="phone" value="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </form>
        </div>
    </div>
</div>