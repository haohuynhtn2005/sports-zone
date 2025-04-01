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
                                    <label class="block-wapper--title" for="filter-by">Sắp xếp : </label>
                                    <select class="form-control select--field" id="filter-by" name="filter">
                                        <?php echo get_option_select($this->config->item('sort', 'filter_shops'), isset($get['filter']) ? $get['filter'] : ''); ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <?php $this->load->view('block-filter-bar'); ?>
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
