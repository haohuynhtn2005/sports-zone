<?php if (isset($data) && is_array($data) && !empty($data)): ?>
<?php
    foreach ($data as $value):
        $data_params = (isset($value['params']) && trim($value['params']) != '') ? $value['params'] : '';
        $data_id = $value['id'];
        $data_title = $value['title'];
        $data_hometext = word_limiter($value['hometext'], 16);
        $data_link = site_url($this->config->item('url_shops_rows') . '/' . $value['cat_alias'] . '/' . $value['alias'] . '-' . $data_id) . $data_params;
        $data_image = array(
          'src' => get_media('shops', $value['homeimgfile'], 'no-image.png', '480x480x1'),
          'alt' => ''
        );
        $data_price = $value['product_price'];
        $data_sales_price = get_product_discounts($value['product_price'], $value['product_sales_price']);
        $data_is_new = ($value['is_new'] == 1) ? TRUE : FALSE;
    ?>
<div>
    <div class="box-product-item">
        <div class="block-product--image">
            <a href="<?php echo $data_link; ?>"><img src="<?php echo $data_image['src']; ?>"
                    alt="<?php echo $data_title; ?>" class="img-fluid">
            </a>
            <div class="block-product--button">
                <button data-id="<?php echo $data_id; ?>" data-url="<?php echo $data_link; ?>" type="button"
                    class="btn btn--add btn-add-to-cart">Thêm vào giỏ hàng</button>
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
                <span class="price--sale"><?php echo formatRice($data_sales_price);?> đ</span>
                <span class="price--origin"><?php echo  formatRice($data_price);?> đ</span>
                <?php endif; ?>
                <?php else: ?>
                <span class="price--sale">Liên hệ</span>
                <?php endif; ?>
            </div>
        </div>
        <?php if($data_sales_price != 0 && $data_sales_price != $data_price): ?>
        <div class="block-product--tag">
            <img src="<?php echo get_asset('img_path'); ?>label_sale.png" alt="./images/label_sale.png"
                class="img-fluid">
        </div>
        <?php endif ?>
    </div>
</div>
<?php endforeach; ?>
<?php endif; ?>