<?php if (isset($data) && is_array($data) && !empty($data)): ?>
  <?php
  foreach ($data as $value):
    $data_id = $value['id'];
    $data_title = $value['title'];
    $data_hometext = word_limiter($value['hometext'], 16);
    $data_link = site_url($this->config->item('url_shops_rows') . '/' . $value['cat_alias'] . '/' . $value['alias'] . '-' . $data_id);
    $data_image = array(
      'src' => get_media('shops', $value['homeimgfile'], 'no-image.png', '270x337x1'),
      'alt' => ''
    );
    $data_price = $value['product_price'];
    $data_sales_price = get_product_discounts($value['product_price'], $value['product_sales_price']);
    $data_is_new = ($value['is_new'] == 1) ? TRUE : FALSE;
    ?>
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-6 block-item-product">
      <a href="<?php echo $data_link; ?>"><img class="card-img-top img-fluid" src="<?php echo $data_image['src']; ?>" alt="Card image cap"></a>
      <div class="card-body">
        <h3><a href="<?php echo $data_link; ?>"><?php echo $data_title; ?></a></h3>
        <div class="price-product">
          <?php if ($data_sales_price > 0): ?>
            <?php if ($data_sales_price == $data_price): ?>
              <span class="price-sale"><?php echo formatRice($data_price); ?>VNĐ</span>
            <?php else: ?>
              <span class="price-sale"><?php echo formatRice($data_sales_price);?> VNĐ</span>
              <span class="price-original"><?php echo  formatRice($data_price);?> VNĐ</span>
            <?php endif; ?>
          <?php else: ?>
            <span class="price-sale">Liên hệ</span>
          <?php endif; ?>
        </div>
        <!-- <li class="price-original">Liên hệ</li> -->
        <button type="button" class="btn btn-sm btn-danger mt-3 btn-cart btn-add-to-cart" data-id="<?php echo $data_id; ?>"><i class="fas fa-shopping-cart"></i> Mua ngay</button>
      </div>
    </div>
  <?php endforeach; ?>
<?php endif; ?>
