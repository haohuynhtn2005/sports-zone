<section id="home" class="md-py t-center white fullwidth">
    <div class="bg-parallax skrollr" data-anchor-target="#home" data-0="transform:translate3d(0, 0px, 0px);" data-900="transform:translate3d(0px, 150px, 0px);" data-background="<?php echo isset($site_logo_footer) ? $site_logo_footer : ''; ?>"></div>
    <div class="container-md skrollr" data-0="opacity:1; transform:translateY(0px);" data-700="opacity:0; transform:translateY(230px);">
        <div class="t-center dark">
            <h1 class="bold-title white lh-sm uppercase"><?php echo isset($data_cat['name']) ? $data_cat['name'] : ''; ?></h1>
            <?php $this->load->view('breadcrumb'); ?>
        </div>
    </div>
</section>
<section id="news" class="t-center sm-py">
    <div class="container clearfix">
        <div class="row image-boxes">
            <?php echo isset($rows) ? $rows : ''; ?>
        </div>
    </div>
</section>
<?php $this->load->view('block-slogun'); ?>