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
                    <?= $value['content'] ?>
                </p>
                <div class="d-flex flex-column flex-md-row" data-aos="fade-up" data-aos-delay="200">
                <a href="<?= $value[
                    'link'
                ] ?>" class="btn-get-started">Tìm hiểu thêm <i class="bi bi-arrow-right"></i></a>
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

<?php endif; ?>
<!-- /Hero Section -->

<!-- About Section -->
<section id="about" class="about section">
    <div class="container" data-aos="fade-up">
        <div class="row gx-0">
            <div class="col-lg-6 d-flex flex-column justify-content-center" data-aos="fade-up" data-aos-delay="200">
            <div class="content">
                    <h2>
                    <?php echo isset($about_us_none['title'])
                        ? $about_us_none['title']
                        : ''; ?>
                </h2>
                <p>
                    <?php echo isset($about_us_none['content'])
                        ? $about_us_none['content']
                        : ''; ?>
                </p>
                <div class="text-center text-lg-start">
                <a
                    href="<?php echo isset($about_us_none['link'])
                        ? $about_us_none['link']
                        : ''; ?>"
                    class="btn-read-more d-inline-flex align-items-center justify-content-center align-self-center">
                    <span>Xem chi tiết</span>
                    <i class="bi bi-arrow-right"></i>
                </a>
                </div>
            </div>
            </div>

            <div class="col-lg-6 d-flex align-items-center" data-aos="zoom-out" data-aos-delay="200">
                <img
                    src="<?php echo isset($about_us_none['image'])
                        ? get_media(
                            'images',
                            $about_us_none['image'],
                            'no-image.png'
                        )
                        : ''; ?>"
                    alt="<?php echo isset($about_us_none['alt'])
                        ? $about_us_none['alt']
                        : ''; ?>"
                    class="img-fluid" 
                    >
            </div>

        </div>
    </div>
</section>
<!-- /About Section -->

<!-- Stats Section -->
<section id="stats" class="stats section">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                <h4 class="mb-0 text-center">Còn lại</h4>
                </div>
                <div class="card-body">
                <div class="row text-center">
                    <div class="col-3">
                    <h3 id="days" class="display-4">00</h3>
                    <p>Days</p>
                    </div>
                    <div class="col-3">
                    <h3 id="hours" class="display-4">00</h3>
                    <p>Hours</p>
                    </div>
                    <div class="col-3">
                    <h3 id="minutes" class="display-4">00</h3>
                    <p>Minutes</p>
                    </div>
                    <div class="col-3">
                    <h3 id="seconds" class="display-4">00</h3>
                    <p>Seconds</p>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
    </div>

    <script>
        // Set the date we're counting down to (1 month from now)
        const countDownDate = new Date().getTime() + (30 * 24 * 60 * 60 * 1000);

        // Update the countdown every 1 second
        const x = setInterval(function () {
            // Get today's date and time
            const now = new Date().getTime();

            // Find the distance between now and the countdown date
            const distance = countDownDate - now;

            // Time calculations for days, hours, minutes and seconds
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Display the result
            document.getElementById("days").innerHTML = days.toString().padStart(2, '0');
            document.getElementById("hours").innerHTML = hours.toString().padStart(2, '0');
            document.getElementById("minutes").innerHTML = minutes.toString().padStart(2, '0');
            document.getElementById("seconds").innerHTML = seconds.toString().padStart(2, '0');

            // If the countdown is finished, write some text
            if (distance < 0) {
            clearInterval(x);
            document.getElementById("days").innerHTML = "00";
            document.getElementById("hours").innerHTML = "00";
            document.getElementById("minutes").innerHTML = "00";
            document.getElementById("seconds").innerHTML = "00";
            }
        }, 1000);
    </script>

</section>
<!-- /Stats Section -->

<!-- Event Posts Section -->
<section id="recent-posts" class="recent-posts section">

    <div class="container">
        <div class="row gy-5">

            <div class="col-xl-6 col-md-6">
            <div class="post-item position-relative h-100" data-aos="fade-up" data-aos-delay="100">

                <div class="post-img position-relative overflow-hidden">
                <img src="image/events.png" class="img-fluid" alt="">
                <span class="post-date">December 12</span>
                </div>

                <div class="post-content d-flex flex-column">

                <h3 class="post-title">Hòa mình vào không khí hào hùng.....</h3>

                <div class="meta d-flex align-items-center">
                    <div class="d-flex align-items-center">
                    <i class="bi bi-person"></i> <span class="ps-2">Julia Parker</span>
                    </div>
                    <span class="px-3 text-black-50">/</span>
                    <div class="d-flex align-items-center">
                    <i class="bi bi-folder2"></i> <span class="ps-2">Politics</span>
                    </div>
                </div>

                <hr>

                <a href="#" class="readmore stretched-link"><span>Read More</span><i class="bi bi-arrow-right"></i></a>

                </div>

            </div>
            </div><!-- End post item -->

            <div class="col-xl-6 col-md-6">
            <div class="post-item position-relative h-100" data-aos="fade-up" data-aos-delay="200">

                <div class="post-img position-relative overflow-hidden">
                <img src="image/events.png" class="img-fluid" alt="">
                <span class="post-date">July 17</span>
                </div>

                <div class="post-content d-flex flex-column">

                <h3 class="post-title">Hòa mình vào không khí hào hùng.....</h3>

                <div class="meta d-flex align-items-center">
                    <div class="d-flex align-items-center">
                    <i class="bi bi-person"></i> <span class="ps-2">Mario Douglas</span>
                    </div>
                    <span class="px-3 text-black-50">/</span>
                    <div class="d-flex align-items-center">
                    <i class="bi bi-folder2"></i> <span class="ps-2">Sports</span>
                    </div>
                </div>

                <hr>

                <a href="#" class="readmore stretched-link"><span>Read More</span><i class="bi bi-arrow-right"></i></a>

                </div>

            </div>
            </div><!-- End post item -->

        </div>
    </div>

</section>
<!-- /Events Posts Section -->

<!-- Values Section -->
<?php echo isset($posts_service) ? $posts_service : ''; ?>
<!-- /Values Section -->

<!-- Organize Section -->

<!-- /Organize Section -->

<?php if (
    isset($info_why_choose_us_none) &&
    is_array($info_why_choose_us_none) &&
    !empty($info_why_choose_us_none)
):
    $attributes = isset($info_why_choose_us_none['attributes'])
        ? @unserialize($info_why_choose_us_none['attributes'])
        : null; ?>
        
<section id="feature-details" class="feature-details section">
    <div class="container section-title" data-aos="fade-up">
    <h2>Vì sao nên chọn NKV</h2>
    <p>Quy trình tổ chức<br></p>
    </div><!-- End Section Title -->
    <div class="container">

        <div class="row gy-4 align-items-center features-item">
            <div class="col-md-5 d-flex align-items-center" data-aos="zoom-out" data-aos-delay="100">
            <img src="image/kh1.png" class="img-fluid" alt="">
            </div>
            <div class="col-md-7" data-aos="fade-up" data-aos-delay="100">
            <h3>Lập kế hoạch tổ chức (PLAN)</h3>

            <ul>
                <li><span> Xác định rõ mục tiêu của sự kiện: Bạn muốn đạt được điều gì?</span></li>
                <li> <span>Xác định phạm vi của sự kiện: Đối tượng tham gia là ai.</span></li>
                <li><span>Lập kế hoạch chi tiết: bao gồm lịch trình, địa điểm, ngân sách</span></li>
            </ul>
            </div>
        </div><!-- Features Item -->

        <div class="row gy-4 align-items-center features-item">
            <div class="col-md-5 order-1 order-md-2 d-flex align-items-center" data-aos="zoom-out" data-aos-delay="200">
            <img src="image/kh2.png" class="img-fluid" alt="">
            </div>
            <div class="col-md-7 order-2 order-md-1" data-aos="fade-up" data-aos-delay="200">
            <h3>Điều phối nhân sự và triển khai vận hành (DO)</h3>
            <ul>
                <li><span> Triển khai công việc theo kế hoạch</span></li>
                <li> <span>Phân bổ nguồn lực hợp lý</span></li>

            </ul>
            </div>
        </div><!-- Features Item -->

        <div class="row gy-4 align-items-center features-item">
            <div class="col-md-5 d-flex align-items-center" data-aos="zoom-out">
            <img src="image/kh3.png" class="img-fluid" alt="">
            </div>
            <div class="col-md-7" data-aos="fade-up">
            <h3>Truyền thông sự kiện</h3>

            <ul>
                <li><span>Xây dựng và thực hiện chiến lược truyền thông</span></li>
                <li><span> Xây dựng và thực hiện chiến lược truyền thông</span></li>

            </ul>
            </div>
        </div><!-- Features Item -->

        <div class="row gy-4 align-items-center features-item">
            <div class="col-md-5 order-1 order-md-2 d-flex align-items-center" data-aos="zoom-out">
            <img src="image/kh4.png" class="img-fluid" alt="">
            </div>
            <div class="col-md-7 order-2 order-md-1" data-aos="fade-up">
            <h3>Hậu sự kiện và đánh giá</h3>

            <ul>
                <li><span>Hậu sự kiện: Sau khi kết thúc sự kiện, chúng tôi tiếp tục hỗ trợ về các hạng mục bàn
                    giao.</span></li>
                <li><span> Hậu sự kiện: Sau khi kết thúc sự kiện, chúng tôi tiếp tục hỗ trợ về các hạng mục bàn
                    giao.</span></li>

            </ul>
            </div>
        </div><!-- Features Item -->

    </div>

</section>

<section id="about" class="t-center  container sm-py">
    <h2 class="gray8 uppercase"><?php
     echo isset(
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
                                    $key % count($why_choose_us_icon)
                                ); ?>h1 colored2"></i>
                            </div>
                            <div class="col-10 no-pm">
                                <h4 class="bold-subtitle font-19">
                                    <?php echo $attribute['label']; ?></h4>
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