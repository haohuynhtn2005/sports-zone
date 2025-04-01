<?php
if (isset($data) && is_array($data) && !empty($data)):
    foreach ($data as $value):
        $data_id = $value['id'];
        $data_title = $value['title'];
        $data_hometext = word_limiter($value['hometext'], 40);
        $data_link = site_url($value['categories']['alias'] . '/' . $value['alias'] . '-' . $data_id);
        $data_image = array(
          'src' => get_media('posts', $value['homeimgfile'], 'no-image.png', '350x236x1'),
          'alt' => $value['homeimgalt']
        );
        ?>
        <div class="member col-md-4 col-xs-12">
            <div class="member-body">
                <a href="<?php echo $data_link; ?>">
                    <img src="<?php echo $data_image['src']; ?>" alt="<?php echo $data_title; ?>">
                    <div class="team-progress">
                        <div class="progress-bar bg-colored t-left" data-value="75">
                            <span class="nowrap normal"><?php echo $data_title; ?></span>
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
<?php endif; ?>