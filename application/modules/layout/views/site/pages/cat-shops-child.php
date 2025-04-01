<article>
    <section>
        <div class="box-wapper-shop">
            <div class="container">
                <div class="row">
                  <?php $this->load->view('block-left-shop'); ?>
                    <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12">
                        <div class="box-sort">
                            <div class="block-sort">
                                <div class="form-group">
                                    <label class="block-wapper--title">Sắp xếp : </label>
                                    <select class="form-control select--field" id="filter-sort">
                                        <option value="default">Mặc định</option>
                                        <option value="1">Hàng mới về</option>
                                        <option value="2">Hàng cũ nhất</option>
                                        <option value="3">Giá tăng dần</option>
                                        <option value="4">Giá giảm dần</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                          <?php echo isset($rows) ? $rows : ''; ?>
                        </div>
                        <?php if (isset($pagination) && $pagination != ''): ?>
                        <div class="box-pagination">
                            <nav>
                                <?php echo $pagination; ?>
                            </nav>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</article>