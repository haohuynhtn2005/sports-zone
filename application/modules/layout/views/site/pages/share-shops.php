<article>
    <section>
        <div class="product">
            <div class="container">
                <?php $this->load->view('breadcrumb'); ?>
                <h1 class="d-none"><?php echo $h1_seo; ?></h1>
                <div class="row">
                    <div class="col-xl-9 col-lg-12 col-md-12 col-sm-12 col-12">
                        <section>
                            <div class="card section-product">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <span>Chia sẻ sản phẩm</span>
                                    </h5>
                                    <div class="block-padding-15">
                                        <div class="row">
                                            <?php echo isset($rows) ? $rows : ''; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <?php if (isset($pagination) && $pagination != ''): ?>
                        <div class="box-pagination">
                            <nav>
                                <?php echo $pagination; ?>
                            </nav>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php $this->load->view('block-right'); ?>
                </div>
            </div>
        </div>
    </section>
    <div id="get-link-modal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header p-2">
                    <h6 class="modal-title mb-0">Chia sẻ link sản phẩm</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-2">
                    <div class="form-group mb-0">
                        <label for="link-share-product">Vui lòng copy link này để chia sẻ cho mọi người</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="link-share-product" readonly>
                            <div class="input-group-append">
                                <button type="button" style="font-size: 0.875rem;" class="btn btn-primary btn-copy" data-clipboard-action="copy" data-clipboard-target="#link-share-product"><i class="fas fa-copy"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer p-2">
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
</article>