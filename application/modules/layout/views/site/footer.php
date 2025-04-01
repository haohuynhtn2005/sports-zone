<?php if(isset($partner_none) && is_array($partner_none) && !empty($partner_none)): ?>
<section class="xs-py animated" data-animation="fadeInUp" data-animation-delay="220">
    <div class="container t-center">
        <h2 class="uppercase">Đối tác tiêu biểu</h2>
        <div class="title-strips-over dark"></div>
    </div>
    <div class="custom-slider container block-img qdr-controls c-grab" data-slick='{"dots": false, "arrows": true, "fade": false, "draggable":true, "slidesToShow": 6, "slidesToScroll": 2, "responsive":[{"breakpoint": 1024,"settings":{"slidesToShow": 2}},{"breakpoint": 600,"settings":{"slidesToShow": 2}}]}'>
        <?php foreach ($partner_none as $value): ?>
        <div class="gap-10"><img src="<?php echo get_media('images', $value['image'], 'no-image.png'); ?>" alt=""></div>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>
<footer id="footer" class="py gray3 font-14 bg-black gray3 xs-py white">
    <div class="footer-body container">
        <div class="row">
            <div class="col-md-4 col-sm-6 col-xs-12 sm-mb-mobile animated" data-animation="fadeInUp" data-animation-delay="220">
                <h4 class="xs-mb white"><?php echo isset($info_infomation_none['title']) ? $info_infomation_none['title'] : ''; ?></h4>
                <?php echo isset($info_infomation_none['content']) ? $info_infomation_none['content'] : ''; ?>
                <!-- <p class="mini-mt"><i class="fa fa-building mini-mr colored"></i> 575/24 Lê Văn Khương, P. Hiệp Thành, Q.12, HCM.</p>
                <p class="mini-mt"><i class="fa fa-phone mini-mr colored"></i> <a href="tel:0905 251 815" class="underline-hover colored-hover">0905 251 815 </a></p>
                <a href="mailto:gvietdaiphatgroup@gmail.com" class="underline-hover colored-hover"><i class="fa fa-envelope mini-mr colored"></i> vietdaiphatgroup@gmail.com</a>
                <p class="mini-mt"><i class="fa fa-globe mini-mr colored"></i> www.vietdaiphat.com</p> -->
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12 sm-mb-mobile animated" data-animation="fadeInUp" data-animation-delay="320">
                <h4 class="uppercase white no-pm xs-mb">Đăng Ký Tư Vấn</h4>
                <div class="footer-newsletter">
                    <form id="newsletter-signup" method="post">
                        <input type="email" name="signup_email" id="signup_email" required placeholder="Email" class="font-12 radius form-control" autocomplete="off">
                        <!-- <input type="text" name="phone" id="phone" required placeholder="Số điện thoại" class="font-12 radius form-control"> -->
                        <button type="submit" class="btn-lg fullwidth radius bg-colored border-colored qdr-hover-6 click-effect font-14">Đăng ký miễn phí</button>
                    </form>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12 sm-mb-mobile animated" data-animation="fadeInUp" data-animation-delay="420">
                <h4 class="uppercase white no-pm xs-mb">Fanpage Facebook</h4>
                <?php echo isset($fb_page) ? $fb_page : ''; ?>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="row clearfix t-center-xs">
                <div class="col-sm-6 col-xs-12 table-im height-auto-mobile t-center-xs xxs-mt-mobile" style="height: 36px;">
                    <p class="v-middle">© 2021 <a href="https://thietkewebuytin.vn" target="_blank" class="colored-hover underline-hover">Thiết kế web uy tín</a>
                        <img src="<?php echo get_asset('img_path'); ?>dmca.png" alt="">
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>
<?php $hotline = isset($info_hotline_none['content']) ? str_replace('.', '', strip_tags($info_hotline_none['content'])) : ''; ?>
<a href="tel:<?php echo $hotline; ?>">
    <div class="hotline">
        <span class="before-hotline"></span>
    </div>
</a>
<div class="sitechatzalo"> <a target="_blank" href="https://zalo.me/<?php echo $hotline; ?>" rel="nofollow"><span class="iczalo">&nbsp;</span></a></div>
<a id="back-to-top" href="#top"><i class="fa fa-angle-up"></i></a>