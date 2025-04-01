<?php if (isset($data) && is_array($data) && !empty($data)):?>

<div class="box-feature">
    <div class="block-wapper--title">
        <h3>Tin tức nổi bật</h3>
    </div>
    <div class="block-feature-list">
        <?php
		$i = 0;
		$count = count($data);
		foreach ($data as $value):
			$i++;
			$data_id = $value['id'];
			$data_title = $value['title'];
			$data_hometext = $value['hometext'];
			$data_link = site_url($value['categories']['alias'] . '/' . $value['alias'] . '-' . $data_id);
			$data_image = array(
				'src' => get_media('posts', $value['homeimgfile'], 'no-image.png','1024x683x1'),
				'alt' => $value['homeimgalt']
			);
			$data_date = date('d', $value['addtime']) . '/' . date('m', $value['addtime']) . '/' . date('Y', $value['addtime']);
			?>
        <div class="block-feature-item">
            <div class="block-feature--image">
                <a href="<?php echo $data_link; ?>"><img src="<?php echo $data_image['src']; ?>"
                        alt="<?php echo $data_title; ?>" class="img-fluid">
                </a>
            </div>
            <div class="block-feature--content">
                <div class="block-feature--title">
                    <h3>
                        <a href="<?php echo $data_link; ?>"><?php echo $data_title; ?></a>
                    </h3>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>