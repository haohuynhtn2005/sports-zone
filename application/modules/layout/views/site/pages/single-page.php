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
                <h1><?php echo isset($row['h1_seo']) ? $row['h1_seo'] : ''; ?></h1>
                <div class="single-pages-content" style="box-sizing: border-box; color: rgb(33, 37, 41); font-family: -apple-system, BlinkMacSystemFont, ">
                    <?php echo isset($row['bodyhtml']) ? filter_content($row['bodyhtml']) : ''; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $this->load->view('block-slogun'); ?>