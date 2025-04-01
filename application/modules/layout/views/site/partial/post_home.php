<?php if (isset($data) && is_array($data) && !empty($data)):$i = 0;?>
<?php foreach ($data as $value):
      $i++;
      $data_id = $value['id'];
      $data_title = word_limiter($value['title'], 15);
      $data_hometext = word_limiter($value['hometext'], 80);
      $data_link = site_url($value['categories']['alias'] . '/' . $value['alias'] . '-' . $data_id);
      $data_image = array(
        'src' => get_media('posts', $value['homeimgfile'], 'no-image-thumb.png', '1024x683x1'),
        'alt' => $value['homeimgalt']
      );
      $data_cat_name = $value['categories']['name'];
      $data_date = date('d', $value['addtime']) . '/' . date('m', $value['addtime']) . '/' . date('Y', $value['addtime']);
      ?>
<div>
    <div class="box-news-item">
        <div class="block-news--image">
            <a href="<?php echo $data_link ?>"><img src="<?php echo $data_image['src'] ?>" alt="<?php echo $data_image['alt'] ?>" class="img-fluid"></a>
        </div>
        <div class="block-news--content">
            <div class="block-news--title">
                <h3><a href="<?php echo $data_link ?>"><?php echo $data_title ?></a></h3>
            </div>
            <div class="block-news--postby">
                <span><i class="fas fa-user-tie"></i> Danh mục: <?php echo $data_cat_name ?> </span>
            </div>
            <div class="block-news--hometext">
                <span><?php echo $data_hometext ?></span>
            </div>
        </div>
        <div class="block-news--posttime">
            <span class="date"><?php echo substr($data_date,0,2) ?></span>
            <span class="month">Tháng <?php echo substr($data_date,3,2) ?></span>
        </div>
    </div>
</div>
<?php endforeach; ?>
<?php endif; ?>