<?php if (isset($data) && is_array($data) && !empty($data)):$i = 0;?>
    <?php foreach ($data as $value):
        $i++;
        $data_id = $value['id'];
        $data_title = word_limiter($value['title'], 15);
        $data_hometext = word_limiter($value['hometext'], 15);
        $data_link = site_url($value['categories']['alias'] . '/' . $value['alias'] . '-' . $data_id);
        $data_image = array(
        'src' => get_media('posts', $value['homeimgfile'], 'no-image-thumb.png', '336x224x1'),
        'alt' => $value['homeimgalt']
        );
    ?>
    <div class="col-md-4 xs-mb">
        <a href="<?php echo $data_link; ?>">
            <div class="item strip-btn-trigger">
                <div class="image-slider">
                    <div><img src="<?php echo $data_image['src']; ?>" alt="<?php echo $data_title; ?>"></div>
                </div>
                <h3 class="title dark bold font-18"><?php echo $data_title; ?></h3>
                <p class="desc"><?php echo $data_hometext; ?></p>
            </div>
        </a>
    </div>
    <?php endforeach; ?>
<?php endif; ?>