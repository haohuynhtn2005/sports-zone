<?php
$image = get_media('shops' , $row['homeimgfile'], 'no-image.png','650x650x1');
$data_price = $row['product_price'];
$product_code = $row['product_code'];
$data_sales_price = get_promotion_price($row['product_price'], $row['product_sales_price']);
$stock_status = isset($row['stock_status']) ? $row['stock_status'] : '';
$data_colors = isset($row['colors']) ? $row['colors'] : null;
?>
<script type="text/javascript">
var product_init = JSON.parse('<?php echo json_encode($data_colors, JSON_FORCE_OBJECT); ?>');
</script>
<article>
    <section>
        <div class="box-single-product">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <div class="block-single-product--image">
                            <?php if (isset($row['options']) && is_array($row['options']) && !empty($row['options'])): ?>
                            <?php $image_option = get_media('shops', $row['options'][0]['image'],'no-image.png','650x650x1'); ?>
                            <div class="single-product-image--show">
                                <a id="Zoom-detail" class="item MagicZoom" href="<?php echo $image; ?>"
                                    title="<?php echo $title_seo; ?>">
                                    <img class="img-fluid" src="<?php echo $image; ?>"
                                        alt="<?php echo $title_seo; ?>">
                                </a>
                                <!-- <a id="Zoom-detail" class="item MagicZoom" href="<?php echo $image_option; ?>"
                                    title="<?php echo $title_seo; ?>">
                                    <img class="img-fluid" src="<?php echo $image_option; ?>"
                                        alt="<?php echo $title_seo; ?>">
                                </a> -->
                            </div>
                            <?php else: ?>
                            <div class="single-product-image--show">
                                <a id="Zoom-detail" class="item MagicZoom" href="<?php echo $image; ?>"
                                    title="<?php echo $title_seo; ?>">
                                    <img class="img-fluid" src="<?php echo $image; ?>"
                                        alt="<?php echo $title_seo; ?>">
                                </a>
                            </div>
                            <?php endif;?>
                            <div class="mr-10px">
                                <div class="single-product-image--slider">
                                    <?php if (isset($row['options']) && is_array($row['options']) && !empty($row['options'])): ?>
                                    <div>
                                        <div class="single-product-slider-item">
                                            
                                        <a data-zoom-id="Zoom-detail" href="<?php echo $image; ?>"
                                            title="<?php echo $title_seo; ?>" data-image="<?php echo $image; ?>">
                                            <img class="img-fluid" src="<?php echo $image; ?>"
                                                alt="<?php echo $title_seo; ?>">
                                        </a>
                                        </div>
                                    </div>
                                    <?php foreach ($row['options'] as $value): $image_option = get_media('shops', $value['image'],'no-image.png','650x650x1'); ?>
                                    <div>
                                        <div class="single-product-slider-item">
                                            <a data-zoom-id="Zoom-detail" href="<?php echo $image_option; ?>"
                                                title="<?php echo $value['alt']; ?>"
                                                data-image="<?php echo $image_option; ?>">
                                                <img src="<?php echo $image_option; ?>" class="img-fluid">
                                            </a>
                                        </div>
                                    </div>
                                    <?php endforeach;?>
                                    <?php else: ?>
                                    <div>
                                        <div class="single-product-slider-item">
                                            <a data-zoom-id="Zoom-detail" href="<?php echo $image; ?>"
                                                title="<?php echo $row['homeimgalt']; ?>"
                                                data-image="<?php echo $image; ?>">
                                                <img src="<?php echo $image; ?>" alt="<?php echo $row['homeimgalt']; ?>"
                                                    class="img-fluid">
                                            </a>
                                        </div>
                                    </div>
                                    <?php endif;?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <div class="block-single-product--content">
                            <div class="single-product--title">
                                <h3><?php echo isset($row['title']) ? $row['title'] : ''; ?></h3>
                            </div>
                            <div class="single-product--status">
                                <span class="status-item">
                                    <span class="title">Thương hiệu:</span>
                                    <span class="content">USA Store Salon</span>
                                </span>
                                <span class="status-item">
                                    <span class="title">Tình trạng:</span>
                                    <span class="content">Còn hàng</span>
                                </span>
                            </div>
                            <div class="single-product--rating">
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                            </div>
                            <div class="single-product--price">
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
                            <div class="single-product--hometext">
                                <?php if(isset($row['hometext'])): ?>
                                <?php echo $row['hometext']; ?>
                                <?php endif; ?>
                                Thông tin sản phẩm đang được cập nhật.
                            </div>
                            <div class="single-product--form">
                                <form action="#" method="get" id="f-add-to-cart" role="form">
                                    <div class="single-product-form--qualities">
                                        <div class="form--title">
                                            Số lượng:
                                        </div>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <button class="btn btn--value btn--down" type="button">-</button>
                                            </div>
                                            <input type="hidden" name="product_id" id="product_id"
                                                value="<?php echo $row['id']; ?>" />
                                            <?php if(isset($get['param']) && trim($get['param']) != ''): ?>
                                            <input type="hidden" name="param" value="<?php echo $get['param']; ?>">
                                            <?php endif; ?>
                                            <?php if(isset($get['access']) && trim($get['access']) != ''): ?>
                                            <input type="hidden" name="access" value="<?php echo $get['access']; ?>">
                                            <?php endif; ?>
                                            <input class="form-control input--qualities" type='number' name='qty'
                                                value='1' class='qty' min="1" id="qty " />
                                            <div class="input-group-append">
                                                <button class="btn btn--value btn--up" type="button">+</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="single-product-form--button">
                                        <button type="submit" name="add" value="Mua hàng"
                                            class="btn btn--add">Thêm vào giỏ hàng</button>
                                        <button type="button" class="btn btn--buy btn-buy-now">Mua ngay</button>
                                    </div>
                                </form>
                            </div>
                            <div class="single-product--share">
                                <?php $this->load->view('addthis'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="block-single-product--tabs">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#description">Mô tả
                                sản phẩm</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#comment">Khách hàng nhận
                                xét</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="description" role="tabpanel">
                            <?php if(isset($row['bodyhtml'])): ?>
                            <?php echo $row['bodyhtml']; ?>
                            <?php endif; ?>
                            Thông tin sản phẩm đang được cập nhật.
                        </div>
                        <div class="tab-pane fade" id="comment" role="tabpanel">
                            <fb:comments href="<?php echo current_url(); ?>" colorscheme="light" numposts="5"
                                width="100%"></fb:comments>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if (isset($related_products) && trim($related_products) != ''): ?>
        <div class="box-relative">
            <div class="container">
                <div class="block--title">
                    <h3 class="main--title">
                        Sản phẩm liên quan
                    </h3>
                </div>
                <div class="mr-15px">
                    <div class="block-relative--slider">
                        <?php echo $related_products; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </section>
</article>