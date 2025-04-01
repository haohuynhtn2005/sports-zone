<?php if (isset($data) && is_array($data) && !empty($data)): ?>
    <section id="news" class="t-center sm-py bg-dark">
        <div class="container-md t-center sm-pb">
            <h2 class="uppercase white">Tin tức & sự kiện</h2>
            <div class="title-strips-over dark"></div>
        </div>
        <div class="container clearfix">
            <div class="image-boxes custom-slider strip-dots dark-dots" data-slick='{"dots": true, "arrows": false, "fade": false, "slidesToShow": 3, "slidesToScroll": 2}'>
                <?php foreach ($data as $key => $value):
                    $data_id = $value['id'];
                    $data_title = word_limiter($value['title'], 15);
                    $data_hometext = word_limiter($value['hometext'], 15);
                    $data_link = site_url($value['categories']['alias'] . '/' . $value['alias'] . '-' . $data_id);
                    $data_image = array(
                    'src' => get_media('posts', $value['homeimgfile'], 'no-image-thumb.png', '356x237x1'),
                    'alt' => $value['homeimgalt']
                    );
                ?>
                <a href="<?php echo $data_link; ?>">
                    <div class="item strip-btn-trigger animated" data-animation="fadeInUp" data-animation-delay="<?php echo ($key * 100); ?>">
                        <div class="image-slider qdr-controls-2" data-slick='{"dots": true, "touchMove": false, "arrows": true, "fade": true, "slidesToShow": 1, "slidesToScroll": 1}'>
                            <div><img src="<?php echo $data_image['src']; ?>" alt="<?php echo $data_title; ?>"></div>
                        </div>
                        <h3 class="title extrabold-title font-18 white t-left"><?php echo $data_title; ?></h3>
                        <p class="desc font-14 t-left white t-justify"><?php echo $data_hometext; ?></p>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>