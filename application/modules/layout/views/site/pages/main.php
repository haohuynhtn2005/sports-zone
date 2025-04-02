<main class="main">
<!-- Hero Section -->
<?php if (
    isset($slideshow_none) &&
    is_array($slideshow_none) &&
    !empty($slideshow_none)
): ?>

<?php foreach ($slideshow_none as $key => $value):
    $data_src = get_media('images', $value['image'], 'no-image.png'); ?>
    <section id="hero" class="hero section" style="background-image: url(<?= $data_src ?>);">
    <div class="container">
        <div class="row gy-4">
        <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center">
            <h1 data-aos="fade-up">
                <?= $value['title'] ?>
            </h1>
            <p data-aos="fade-up" data-aos-delay="100">
                Website cung cấp nhiều thông tin về các giải thể thao quy mô trên cả nước
            </p>
            <div class="d-flex flex-column flex-md-row" data-aos="fade-up" data-aos-delay="200">
            <a href="#about" class="btn-get-started">Tìm hiểu thêm <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
        <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-out">
            <img src="image/Group 1.png" class="img-fluid animated" alt="">
            <div class="img-fluid animated lh-1"
                style="
                    text-transform: uppercase;
                    font-size: 10em;
                    color: transparent;
                    -webkit-text-stroke-width: 2px;
                    -webkit-text-stroke-color: white;
                ">
                <b>
                    <?= $value['title'] ?>
                </b>
            </div>
        </div>
        </div>
    </div>
    </section>
<?php
endforeach; ?>

<section id="home" class="home white relative">
    <div class="hero-slider fullheight custom-slider" data-slick='{"dots": false, "arrows": true, "fade": true, "speed": 1200, "draggable":false, "autoplay":true, "autoplaySpeed": 5000, "slidesToShow": 1, "slidesToScroll": 1, "responsive":[{"breakpoint": 1024,"settings":{"slidesToShow": 1}}]}'>
        <?php foreach ($slideshow_none as $key => $value):
            $data_src = get_media('images', $value['image'], 'no-image.png'); ?>
        <div class="slide">
            <div class="slide-img skrollr" data-anchor-target="#home" data-0="transform:translate3d(0, 0px, 0px);" data-900="transform:translate3d(0px, 150px, 0px);" data-background="<?php echo $data_src; ?>" data-mobile-background="<?php echo $data_src; ?>"></div>
            <div class="details">
                <div class="container v-center v-normal-mobile t-left t-center-mobile">
                    <div class="skrollr" data-300="opacity:1;" data-450="opacity:0;">
                        <h3 class="home-title animated font-35" data-animation="fadeInUp" data-animation-delay="420">
                            <?php echo $value['title']; ?></h3>
                        <p class="font-22 font-16-mobile gray3 lh-lg lh-sm-mobile xxs-mt animated" data-animation="fadeInUp" data-animation-delay="520">
                            <?php echo $value['content']; ?>
                        </p>
                        <div class="xs-mt animated" data-animation="fadeInUp" data-animation-delay="620">
                            <a href="<?php echo $value[
                                'link'
                            ]; ?>l" class="bold font-13 bg-colored xl-btn radius uppercase">Xem chi tiết!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        endforeach; ?>
    </div>
</section>
<?php endif; ?>
<!-- /Hero Section -->

<section id="content" class="xs-pt xs-pb xxs-mb">
    <div class="container clearfix">
        <div class="row">
            <div class="col-md-6 col-12 hidden-xs">
                <a class=" block block-img">
                    <img data-original="<?php echo isset(
                        $about_us_none['image']
                    )
                        ? get_media(
                            'images',
                            $about_us_none['image'],
                            'no-image.png'
                        )
                        : ''; ?>" alt="<?php echo isset($about_us_none['alt'])
    ? $about_us_none['alt']
    : ''; ?>">
                </a>
            </div>
            <div class="col-md-6 col-12 xs-py t-justify animated" data-animation="fadeInUp" data-animation-delay="420">
                <h2 class="gray8 uppercase t-center xs-mb"><?php echo isset(
                    $about_us_none['title']
                )
                    ? $about_us_none['title']
                    : ''; ?></h2>
                <div class="about-us-des">
                    <?php echo isset($about_us_none['content'])
                        ? $about_us_none['content']
                        : ''; ?>
                </div>
                <div class="t-right">
                    <a href="<?php echo isset($about_us_none['link'])
                        ? $about_us_none['link']
                        : ''; ?>" class="lg-btn bg-colored radius bg-dark-hover white slow bs-lg-hover bold-subtitle font-12 qdr-hover-4 xxs-mt">
                        Xem chi tiết
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<?php echo isset($posts_service) ? $posts_service : ''; ?>
<?php if (
    isset($info_why_choose_us_none) &&
    is_array($info_why_choose_us_none) &&
    !empty($info_why_choose_us_none)
):
    $attributes = isset($info_why_choose_us_none['attributes'])
        ? @unserialize($info_why_choose_us_none['attributes'])
        : null; ?>
<section id="about" class="t-center  container sm-py">
    <h2 class="gray8 uppercase"><?php echo isset(
        $info_why_choose_us_none['title']
    )
        ? $info_why_choose_us_none['title']
        : ''; ?></h2>
    <div class="title-strips-over dark xs-mb"></div>
    <?php echo isset($info_why_choose_us_none['content'])
        ? $info_why_choose_us_none['content']
        : ''; ?>
    <div class="boxes container t-left xs-py">
        <div class="row">
            <?php if (is_array($attributes) && !empty($attributes)):
                $why_choose_us_icon = $this->config->item(
                    'why_choose_us_icon'
                ); ?>
                <?php foreach ($attributes as $key => $attribute): ?>
                    <div class="col-md-4 col-12 xs-mt-mobile animated" data-animation="fadeInUp" data-animation-delay="100">
                        <div class="row no-mx">
                            <div class="col-2 mini-pt no-pm">
                                <i class="<?php echo display_value_array(
                                    $why_choose_us_icon,
                                    $key
                                ); ?>h1 colored2"></i>
                            </div>
                            <div class="col-10 no-pm">
                                <h4 class="bold-subtitle font-19"><?php echo $attribute[
                                    'label'
                                ]; ?></h4>
                                <p class="mini-mt gray8 font-15"><?php echo $attribute[
                                    'content'
                                ]; ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php
            endif; ?>
        </div>
    </div>
</section>
<?php
endif; ?>
<?php $this->load->view('block-slogun'); ?>
<?php echo isset($projects_has_been_constructed)
    ? $projects_has_been_constructed
    : ''; ?>
<?php if (
    isset($info_customer_experience_none) &&
    is_array($info_customer_experience_none) &&
    !empty($info_customer_experience_none)
): ?>
<section class="testimonials bg-dark  sm-py md-pb">
    <div class="container t-center">
        <h2 class="extrabold-title white uppercase">Cảm nhận Khách Hàng</h2>
        <div class="title-strips-over dark xs-mb"></div>
    </div>
    <div class="container white c-grab t-center custom-slider qdr-controls-3 light" data-slick='{"dots": false, "arrows": true, "draggable":true, "slidesToShow": 3, "slidesToScroll": 3}'>
        <?php foreach ($info_customer_experience_none as $value):
            $attributes = isset($value['attributes'])
                ? @unserialize($value['attributes'])
                : null; ?>
        <div class="col-md-4 animated" data-animation="fadeInUp" data-animation-delay="100">
            <div class="m-auto">
                <i class="fa fa-quote-right fa-4x opacity-9"></i>
            </div>
            <h3 class="bold-subtitle no-pm xs-mt"><?php echo $value[
                'title'
            ]; ?></h3>
            <h5><?php echo isset($attributes[0]['label'])
                ? $attributes[0]['label']
                : ''; ?></h6>
            <h6 class="xxs-mt font-14 no-ls t-justify"><?php echo isset(
                $attributes[0]['content']
            )
                ? $attributes[0]['content']
                : ''; ?></h6>
        </div>
        <?php
        endforeach; ?>
    </div>
</section>
<?php endif; ?>
<?php if (
    isset($info_collaboration_none) &&
    is_array($info_collaboration_none) &&
    !empty($info_collaboration_none)
):
    $attributes = isset($info_collaboration_none['attributes'])
        ? @unserialize($info_collaboration_none['attributes'])
        : null; ?>
<section id="one" class="sm-py xs-py-mobile">
    <div class="container t-center">
        <h2 class="uppercase"><?php echo isset(
            $info_collaboration_none['title']
        )
            ? $info_collaboration_none['title']
            : ''; ?></h2>
        <div class="title-strips-over dark mini-mb"></div>
    </div>
    <div class="t-left">
        <div class="container">
            <div class="row">
                <?php if (is_array($attributes) && !empty($attributes)): ?>
                    <?php foreach ($attributes as $key => $attribute): ?>
                    <div class="col-md-4 col-12 sm-mt mini-mt-mobile qdr-hover-6-container animated" data-animation="fadeInUp" data-animation-delay="100">
                        <div class="row no-mx">
                            <div class="col-4 mxw-70 t-center-sm no-pm">
                                <div class="no-pm icon-lg icon-mobile-lg bg-colored circle font-35 white"><?php echo $key +
                                    1; ?></div>
                            </div>
                            <div class="col-8 no-pr lh-sm">
                                <h4 class="bold-subtitle font-18 xxs-mt-mobile"><?php echo $attribute[
                                    'label'
                                ]; ?></h4>
                                <p class="lh-md font-14 t-justify"><?php echo $attribute[
                                    'content'
                                ]; ?></p>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?php
endif; ?>
<?php echo isset($posts_news) ? $posts_news : ''; ?>
</main>