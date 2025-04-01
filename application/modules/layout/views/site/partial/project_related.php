<?php if (isset($data) && is_array($data) && !empty($data)): ?>
    <?php
    foreach ($data as $value):
        $data_id = $value['id'];
        $data_title = $value['name'];
        $data_address = $value['address'];
        $data_link = site_url($this->config->item('url_projects') . '/' . $value['alias'] . '-' . $data_id);
        $data_image = array(
          'src' => get_media('projects', $value['image'], 'no-image.png', '275x206x1'),
          'alt' => ''
        );
    ?>
    <div class="cbp-item">
        <a href="<?php echo $data_link; ?>" class="cbp-caption">
            <div class="cbp-caption-defaultWrap">
                <img src="<?php echo $data_image['src']; ?>" alt="<?php echo $data_title; ?>">
            </div>
            <div class="cbp-caption-activeWrap"></div>
        </a>
        <a href="<?php echo $data_link; ?>" class="no-lightbox cbp-l-grid-work-title"><?php echo $data_title; ?></a>
        <div class="cbp-l-grid-work-desc font-15 mini-mt"><?php echo $data_address; ?></div>
    </div>
    <?php endforeach; ?>
<?php endif; ?>