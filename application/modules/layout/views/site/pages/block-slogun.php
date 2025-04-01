<?php if(isset($info_slogun_none) && is_array($info_slogun_none) && !empty($info_slogun_none)): ?>
<section class="bg-colored">
    <div class="container  white radius">
        <div class="row no-mx">
            <div class="col-lg-9 t-center sm-py xs-pl">
                <h2 class="lh-sm font-20"><?php echo isset($info_slogun_none['content']) ? $info_slogun_none['content'] : ''; ?></h2>
            </div>
            <div class="col-lg-3 col-12 t-center bottom-mobile-20">
                <div class="v-center v-normal-mb">
                    <a class="xl-btn radius border-btn qdr-hover-4 bs-hover border-dashed bg-white slow1 dark bold" href="<?php echo isset($info_slogun_none['link']) ? $info_slogun_none['link'] : ''; ?>" role="button">LIÊN HỆ NGAY</a>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>