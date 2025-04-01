<article>
    <section class="user-manager-page">
        <div class="bg-brea">
            <div class="box-wapper">
                <div class="container">
                    <?php //$this->load->view('breadcrumb'); ?>
                    <div class="users_commission">
                        <div class="row">
                            <?php $this->load->view('block-left-admin'); ?>
                            <div class="col-lg-9 col-md-9 col-sm-9">
                                <div class="account-structure-page_main-content">
                                    <div class="account-change-email">
                                        <h2 class="account-structure-page_title">Hoa hồng
                                            <a href="<?php echo site_url('hoa-hong/lich-su'); ?>"
                                                class="float-right btn btn--button btn--hover-color">Lịch sử</a>
                                            <a href="<?php echo site_url('rut-tien'); ?>"
                                                class="float-right mr-2 btn btn--button btn--color">Rút
                                                tiền</a>
                                        </h2>
                                        <div class="box-devision-col-mobile">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                    <div class="info-box">
                                                        <span class="info-box-icon bg-lightgreen">
                                                            <a href="javascript:void(0)"><i
                                                                    class="far fa-money-bill-alt"></i></a>
                                                        </span>
                                                        <div class="info-box-content">
                                                            <span class="info-box-text">Tổng số tiền</span>
                                                            <span
                                                                class="info-box-number ng-binding"><?php echo formatRice($balance); ?>
                                                                VNĐ</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                    <div class="info-box">
                                                        <span class="info-box-icon bg-lightgreen">
                                                            <a href="<?php echo site_url('rut-tien/lich-su'); ?>"
                                                                target="_blank"><i
                                                                    class="far fa-money-bill-alt"></i></a>
                                                        </span>
                                                        <div class="info-box-content">
                                                            <span class="info-box-text">Tiền đã rút</span>
                                                            <span
                                                                class="info-box-number ng-binding"><?php echo formatRice($total_withdrawal); ?>
                                                                VNĐ</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                    <div class="info-box">
                                                        <span class="info-box-icon bg-lightgreen">
                                                            <a href="javascript:void(0)"><i
                                                                    class="far fa-money-bill-alt"></i></a>
                                                        </span>
                                                        <div class="info-box-content">
                                                            <span class="info-box-text">Tiền khả dụng</span>
                                                            <span
                                                                class="info-box-number ng-binding"><?php echo formatRice($balance); ?>
                                                                VNĐ</span>
                                                        </div>
                                                    </div>
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