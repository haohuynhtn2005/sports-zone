<section id="home" class="md-py t-center white fullwidth">
    <div class="bg-parallax skrollr" data-anchor-target="#home" data-0="transform:translate3d(0, 0px, 0px);" data-900="transform:translate3d(0px, 150px, 0px);" data-background="<?php echo isset($site_logo_footer) ? $site_logo_footer : ''; ?>"></div>
    <div class="container-md skrollr" data-0="opacity:1; transform:translateY(0px);" data-700="opacity:0; transform:translateY(230px);">
        <div class="t-center dark">
            <h1 class="bold-title white lh-sm uppercase"><?php echo isset($row['title']) ? $row['title'] : ''; ?></h1>
            <?php $this->load->view('breadcrumb'); ?>
        </div>
    </div>
</section>
<section class="sm-py">
    <div class="boxes container t-left clearfix">
        <div class="row clearfix">
            <div class="col-sm-12 col-12 detail">
                <?php echo isset($row['bodyhtml']) ? $row['bodyhtml'] : ''; ?>
            </div>
        </div>
    </div>
</section>
<?php if (isset($related_rows) && trim($related_rows) != ''): ?>
<section class="sm-py t-center bg-gray">
    <div class="container sm-mt">
        <h2 class="gray8 uppercase"><?php echo isset($row['categories']['name']) ? $row['categories']['name'] : ''; ?> liên quan</h2>
        <div class="title-strips-over dark xs-mb"></div>
        <div class="row team-type-3">
            <div class="custom-slider container block-img qdr-controls c-grab" data-slick='{"dots": false, "autoplay": true, "autoplaySpeed": 1500, "arrows": true, "fade": false, "draggable":true, "slidesToShow": 3, "slidesToScroll": 1}'>
                <?php echo $related_rows; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>
<?php $this->load->view('block-slogun'); ?>