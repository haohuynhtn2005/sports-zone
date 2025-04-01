<?php if (isset($data) && is_array($data) && !empty($data)): ?>
<section>
    <?php
  $i = 0;
  $count = count($data);
  foreach ($data as $data_cat):
    $i++;
    if (isset($data_cat['items']) && !empty($data_cat['items'])):
        $data_src = get_media('shops_cat', $data_cat['image'], 'no-image.png');
      $data_cat_link = site_url($this->config->item('url_shops_cat') . '/' . $data_cat['alias']);
      ?>
    <div class="box-categories">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12">
                    <div class="block-categories">
                        <div class="block-categories--image">
                            <img src="<?php echo $data_src?>"
                                alt="./images/bg_module_1.png" class="img-fluid">
                        </div>
                        <div class="block-categories--content">
                            <div class="block-categories--title">
                                <h3><a class="main--title"
                                        href="<?php echo $data_cat_link ?>"><?php echo $data_cat['name']; ?></a></h3>
                            </div>
                            <div class="block-categories-content--button">
                                <a href="<?php echo $data_cat_link ?>" class="btn btn--more">Xem thêm</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9 col-lg-9 col-md-8 col-sm-12">
                    <div class="mr-15px">
                        <div class="block-categories--slider">
                            <?php
                          foreach ($data_cat['items'] as $value):
                            $data_params = (isset($value['params']) && trim($value['params']) != '') ? $value['params'] : '';
                            $data_id = $value['id'];
                            $data_title = $value['title'];
                            $data_link = site_url($this->config->item('url_shops_rows') . '/' . $value['cat_alias'] . '/' . $value['alias'] . '-' . $data_id) . $data_params;
                            $data_image = array(
                              'src' => get_media('shops', $value['homeimgfile'], 'no-image.png', '480x480x1'),
                              'alt' => ''
                            );
                            $data_price = $value['product_price'];
                            $data_sales_price = get_promotion_price($value['product_price'], $value['product_sales_price']);
                            $data_is_new = ($value['is_new'] == 1) ? TRUE : FALSE;
                            ?>

                            <div>
                                <div class="box-product-item">
                                    <div class="block-product--image">
                                        <a href="<?php echo $data_link; ?>"><img src="<?php echo $data_image['src']; ?>"
                                                alt="<?php echo $data_image['alt']; ?>" class="img-fluid"></a>
                                        <div class="block-product--button">
                                            <button type="button" href="#" class="btn btn--add btn-add-to-cart"
                                                data-id="<?php echo $data_id; ?>" data-url="<?php echo $data_link; ?>">
                                                Thêm vào giỏ hàng
                                            </button>
                                        </div>
                                    </div>
                                    <div class="block-product--content">
                                        <div class="block-product--title">
                                            <h3><a href="<?php echo $data_link; ?>"><?php echo $data_title; ?></a></h3>
                                        </div>
                                        <div class="block-product--rating">
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                        </div>
                                        <div class="block-product--price">
                                            <?php if ($data_sales_price > 0): ?>
                                            <?php if ($data_sales_price == $data_price): ?>
                                            <span class="price--sale"><?php echo formatRice($data_price); ?>đ</span>
                                            <?php else: ?>
                                            <span class="price--sale"><?php echo formatRice($data_sales_price);?>đ</span>
                                            <span class="price--origin"><?php echo  formatRice($data_price);?>đ</span>
                                            <?php endif; ?>
                                            <?php else: ?>
                                            <span class="price--sale">Liên hệ</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?php if($data_sales_price != 0 && $data_sales_price != $data_price): ?>
                                    <div class="block-product--tag">
                                        <img src="<?php echo get_asset('img_path'); ?>label_sale.png"
                                            alt="./images/label_sale.png" class="img-fluid">
                                    </div>
                                    <?php endif ?>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php endforeach; ?>
</section>
<?php endif; ?>