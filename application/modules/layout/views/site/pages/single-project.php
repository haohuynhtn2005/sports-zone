<?php
$image = get_media('projects' , $row['image'], 'no-image.png','750x563x1');
?>
<section id="home" class="md-py t-center white fullwidth">
    <div class="bg-parallax skrollr" data-anchor-target="#home" data-0="transform:translate3d(0, 0px, 0px);" data-900="transform:translate3d(0px, 150px, 0px);" data-background="<?php echo isset($site_logo_footer) ? $site_logo_footer : ''; ?>"></div>
    <div class="container relative">
        <div class="colored skrollr" data-0="opacity:1; transform:translateY(0px);" data-700="opacity:0; transform:translateY(220px);">
            <h1 class="bold-title white mini-py lh-sm"><?php echo isset($row['name']) ? $row['name'] : ''; ?></h1>
            <?php $this->load->view('breadcrumb'); ?>
        </div>
    </div>
</section>
<section id="product" class="py">
    <div class="container">
        <div class="row clearfix">
            <div class="col-lg-4 col-12 xs-mt-mobile">
                <div>
                    <div class="row no-mx t-center-mobile">
                        <!-- Icon -->
                        <div class="col-md-1 col-12 no-pm">
                            <i class="icon-globe-alt h2 colored"></i>
                        </div>
                        <div class="col-md-11 col-12 xxs-mt-mobile no-pr">
                            <h4 class="bold-subtitle"><?php echo isset($row['name']) ? $row['name'] : ''; ?></h4>
                        </div>
                        <div class="col-12 xs-mt no-pm">
                            <div class="gray8 t-justify">
                                <?php echo isset($row['hometext']) ? filter_content($row['hometext']) : ''; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="xs-py">
                    <div class="row t-center-mobile no-mx">
                        <div class="col-md-1 col-12 no-pm">
                            <i class="icon-envelope-open h2 colored"></i>
                        </div>
                        <div class="col-md-11 col-12 xxs-mt-mobile no-pr">
                            <h4 class="bold-subtitle">Thông tin</h4>
                        </div>
                        <div class="col-12 xs-mt no-pm">
                            <p class="clearfix xxs-mb xxs-pb bb-1 border-gray2">
                                <strong class="f-left">Khách hàng:</strong>
                                <span class="gray8 mini-ml f-right"><?php echo isset($row['customer']) ? $row['customer'] : ''; ?></span>
                            </p>
                            <p class="clearfix xxs-mb xxs-pb bb-1 border-gray2">
                                <strong class="f-left">Địa chỉ:</strong>
                                <span class="gray8 mini-ml f-right"><?php echo isset($row['address']) ? $row['address'] : ''; ?></span>
                            </p>
                            <p class="clearfix xxs-mb xxs-pb bb-1 border-gray2">
                                <strong class="f-left">Thời gian:</strong>
                                <span class="gray8 mini-ml f-right"><?php echo isset($row['time']) ? $row['time'] : ''; ?></span>
                            </p>
                            <p class="mini-mt clearfix">
                                <strong class="f-left">Liên hệ tư vấn:</strong>
                                <span class="gray8 mini-ml f-right colored bold-subtitle"><?php echo isset($row['contact']) ? $row['contact'] : ''; ?></span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div id="product-images" class="col-lg-8 col-12 xs-mt-mobile block-img all-block-links">
                <div class="custom-slider block-img qdr-controls lightbox_gallery" data-slick='{"dots": false, "asNavFor": ".nav-to-custom-slider", "arrows": true, "fade": false, "draggable":true, "slidesToShow": 1, "slidesToScroll": 1, "responsive":[{"breakpoint": 1024,"settings":{"slidesToShow": 1}} ]}'>
                    <a href="<?php echo $image; ?>"><img src="<?php echo $image; ?>" alt="<?php echo isset($row['name']) ? $row['name'] : ''; ?>"></a>
                </div>
            </div>
            <div class="col-lg-12 xs-mt">
                <?php echo isset($row['content']) ? filter_content($row['content']) : ''; ?>
            </div>
        </div>
    </div>
</section>
<?php if (isset($related_rows) && trim($related_rows) != ''): ?>
<section id="project" class="t-center xs-py styled-portfolio bg-gray">
    <h2 class="gray8 uppercase">Sự kiện khác</h2>
    <div class="title-strips-over dark xs-mb"></div>
    <div class="custom-slider container block-img qdr-controls c-grab" data-slick='{"dots": false, "autoplay": true, "autoplaySpeed": 1500, "arrows": true, "fade": false, "draggable":true, "slidesToShow": 4, "slidesToScroll": 1}'>
        <?php echo $related_rows; ?>
    </div>
</section>
<?php endif; ?>
<?php $this->load->view('block-slogun'); ?>