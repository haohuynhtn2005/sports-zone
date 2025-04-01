<?php if (isset($data) && is_array($data) && !empty($data)): ?>
    <section id="features" class="section features t-center sm-py">
        <div class="bg-parallax skrollr" data-bottom-top="transform:translate3d(0, -190px, 0px);" data-top-bottom="transform:translate3d(0px, 120px, 0px);" data-background="<?php echo get_media('images', isset($background_service_none['image']) ? $background_service_none['image'] : 'background-service.png', 'no-image.png'); ?>"></div>
        <div class="container t-center sm-pb">
            <h2 class="white uppercase">Lĩnh vực hoạt động</h2>
            <p class=" font-16 xxs-mt"></p>
            <div class="title-strips-over dark"></div>
        </div>
        <div class="container clearfix">
            <div class="row team-type-3">
                <?php foreach ($data as $key => $value):
                    $data_id = $value['id'];
                    $data_title = word_limiter($value['title'], 15);
                    $data_hometext = word_limiter($value['hometext'], 15);
                    $data_link = site_url($value['categories']['alias'] . '/' . $value['alias'] . '-' . $data_id);
                    $data_image = array(
                    'src' => get_media('posts', $value['homeimgfile'], 'no-image-thumb.png', '360x270x1'),
                    'alt' => $value['homeimgalt']
                    );
                ?>
                <div class="member col-md-4 col-xs-6 animated" data-animation="fadeInUp" data-animation-delay="<?php echo ($key * 100); ?>">
                    <div class="member-body">
                        <a href="<?php echo $data_link; ?>">
                            <img src="<?php echo $data_image['src']; ?>" alt="<?php echo $data_title; ?>">
                            <div class="team-progress">
                                <div class="progress-bar bg-colored t-left" data-value="90">
                                    <span class="nowrap normal bold font-16"><?php echo $data_title; ?></span>
                                </div>
                            </div>
                            <div class="member-description vertical-center">
                                <p class="fa fa-quote-left icon"></p>
                                <h2><?php echo $data_title; ?></h2>
                                <p class="description"><?php echo $data_hometext; ?></p>
                            </div>
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>