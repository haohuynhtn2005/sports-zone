<?php if (isset($data) && is_array($data) && !empty($data)): ?>
<div class="box-feature">
    <div class="block-wapper--title">
        <h3>Sản phẩm nổi bật</h3>
    </div>
    <div class="block-feature-list">
        <?php
          foreach ($data as $value):
            $data_id = $value['id'];
            $data_title = word_limiter($value['title'], 10);
            $data_link = site_url($this->config->item('url_shops_rows') . '/' . $value['cat_alias'] . '/' . $value['alias'] . '-' . $data_id);
            $data_image = array(
              'src' => get_image(get_module_path('shops') . $value['homeimgfile'], get_module_path('shops') . 'no-image-thumb.png'),
              'alt' => ''
            );
            $data_price = $value['product_price'];
            $data_sales_price = get_product_discounts($value['product_price'], $value['product_sales_price']);
            ?>
        <div class="block-feature-item">
            <div class="block-feature--image">
                <a href="<?php echo $data_link; ?>"><img src="./images/1274ecabd26e54bcabcb0050da454e.jpg"
                        alt="./images/1274ecabd26e54bcabcb0050da454e.jpg" class="img-fluid">
                </a>
            </div>
            <div class="block-feature--content">
                <div class="block-feature--title">
                    <h3>
                        <a href="<?php echo $data_link; ?>"><?php echo $data_title; ?></a>
                    </h3>
                </div>
                <div class="block-feature--price">
                    <?php if ($data_sales_price > 0): ?>
                    <?php if ($data_sales_price == $data_price): ?>
                    <span class="price--sale"><?php echo formatRice($data_price); ?>₫</span>
                    <?php else: ?>
                    <span class="price--sale"><?php echo  formatRice($data_sales_price);?>₫</span>
                    <span class="price--origin"><?php echo  formatRice($data_price);?>₫</span>
                    <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <div class="block-feature--button">
        <a href="#" class="btn btn--feature-button">
            Xem thêm <i class="fas fa-angle-right"></i>
        </a>
    </div>
</div>
<?php endif; ?>