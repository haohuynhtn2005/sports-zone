<section id="home" class="md-py t-center white fullwidth">
    <div class="bg-parallax skrollr" data-anchor-target="#home" data-0="transform:translate3d(0, 0px, 0px);" data-900="transform:translate3d(0px, 150px, 0px);" data-background="<?php echo isset($site_logo_footer) ? $site_logo_footer : ''; ?>"></div>
    <div class="container-md skrollr" data-0="opacity:1; transform:translateY(0px);" data-700="opacity:0; transform:translateY(230px);">
        <div class="t-center dark">
            <h1 class="bold-title white lh-sm uppercase">Sự Kiện</h1>
            <?php $this->load->view('breadcrumb'); ?>
        </div>
    </div>
</section>
<section id="project" class="t-center xs-py styled-portfolio">
    <div id="portfolio-items" class="cbp cbp-l-grid-work container">
        <?php echo isset($rows) ? $rows : ''; ?>
    </div>
</section>
<?php $this->load->view('block-slogun'); ?>