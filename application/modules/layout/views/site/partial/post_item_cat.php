<?php
if (isset($data) && is_array($data) && !empty($data)):
  $i = 0;
  foreach ($data as $value):
    $i++;
    $data_id = $value['id'];
    $data_title = $value['title'];
    $data_hometext = word_limiter($value['hometext'], 80);
    $data_link = site_url($value['categories']['alias'] . '/' . $value['alias'] . '-' . $data_id);
    $data_cat_link = site_url($this->config->item('url_posts_cat') . '/' . $value['categories']['alias']);
    $data_cat_name = $value['categories']['name'];
    $data_viewed = $value['hitstotal'];
    $data_image = array(
      'src' => get_media('posts', $value['homeimgfile'], 'no-image.png','400x300x1'),
      'alt' => $value['homeimgalt']
    );
    $data_date = date('d', $value['addtime']) . '/' . date('m', $value['addtime']) . '/' . date('Y', $value['addtime']);
    ?>
    <div class="block-item-post col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
      <div class="row">
        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-12">
          <a href="<?php echo $data_link; ?>"><img src="<?php echo $data_image['src']; ?>" alt="<?php echo $data_title; ?>" class="img-fluid w-100"></a>
        </div>
        <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 col-12">
          <h3 class="card-title"><a href="<?php echo $data_link; ?>"><?php echo $data_title; ?></a></h3>
          <div class="post-meta">
            <span class="date"><i class="far fa-calendar-alt"></i> <?php echo $data_date; ?></span>
            <span class="view"><i class="fas fa-eye"></i> <?php echo $data_viewed; ?> lượt xem</span>
          </div>
          <div class="block-hometext">
            <p><?php echo $data_hometext; ?></p>
          </div>
          <span class="readmore"><a href="<?php echo $data_link; ?>">Đọc tiếp</a></span>
        </div>
      </div>
      <hr>
    </div>
  <?php endforeach; ?>
<?php endif; ?>
