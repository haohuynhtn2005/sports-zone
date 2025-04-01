<article>
    <section>
        <div class="box-wapper-post">
            <div class="container">
                <div class="block-wapper--title">
                    <h1>Tin tức</h1>
                </div>
                <div class="row">
                    <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 md-order-2">
                        <div class="block-wapper-post">
                            <div class="row">
                                <?php echo isset($rows) ? $rows : ''; ?>
                            </div>
                        </div>
                        <?php if (isset($pagination) && $pagination != ''): ?>
                        <div class="box-pagination">
                            <nav>
                                <?php echo $pagination; ?>
                            </nav>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php $this->load->view('block-right-post'); ?>
                </div>
            </div>
        </div>
    </section>
</article>