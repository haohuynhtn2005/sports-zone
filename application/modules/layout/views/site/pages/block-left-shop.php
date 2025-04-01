<div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 ">
            <div class="box-list-categories">
                <div class="block-wapper--title">
                    <h3>Danh mục sản phẩm</h3>
                </div>
                <ul class="block-list-categories--content">
                    <?php echo isset($html_category_product) ? $html_category_product : ''; ?>
                </ul>
            </div>
        </div>
        <?php if(isset($filter) && is_array($filter) && !empty($filter)): ?>
        <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 md-order-1">
            <div class="box-filter">
                <div class="block-wapper--title">
                    <h3>Thương hiệu</h3>
                </div>
                <div class="block-filter-list">
                    <ul>
                        <?php 
                        $i = 0;
                        foreach ($filter as $value):
                        $i++; ?>
                        <li>
                            <div class="box-filter-item">
                                <input id="brand-<?php echo $i ;?>" type="checkbox" class="check-filter"
                                    value="<?php echo $value['id']; ?>" name="brands[]"
                                    <?php echo (isset($in_brands) && is_array($in_brands) && in_array($value['id'], $in_brands)) ? ' checked="checked"' : ''; ?>>
                                <label for="brand-<?php echo $i ;?>"><?php echo $value['name']; ?></label>
                            </div>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 md-order-2">
            <div class="box-filter">
                <div class="block-wapper--title">
                    <h3>Khoảng giá</h3>
                </div>
                <div class="block-filter-list">
                    <ul>
                        <li>
                            <div class="box-filter-item">
                                <input class="filter--input" type="checkbox" id="price-1">
                                <label for="price-1">Giá dưới 100.000đ</label><br>
                            </div>
                        </li>
                        <li>
                            <div class="box-filter-item">
                                <input class="filter--input" type="checkbox" id="price-2">
                                <label for="price-2">100.000đ - 200.000đ</label><br>
                            </div>
                        </li>
                        <li>
                            <div class="box-filter-item">
                                <input class="filter--input" type="checkbox" id="price-3">
                                <label for="price-3">200.000đ - 300.000đ</label><br>
                            </div>
                        </li>
                        <li>
                            <div class="box-filter-item">
                                <input class="filter--input" type="checkbox" id="price-4">
                                <label for="price-4">300.000đ - 500.000đ</label><br>
                            </div>
                        </li>
                        <li>
                            <div class="box-filter-item">
                                <input class="filter--input" type="checkbox" id="price-5">
                                <label for="price-5">500.000đ - 1.000.000đ</label><br>
                            </div>
                        </li>
                        <li>
                            <div class="box-filter-item">
                                <input class="filter--input" type="checkbox" id="price-6">
                                <label for="price-6">Giá trên 1.000.000đ</label><br>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 ">
            <?php echo isset($products_featured) ? $products_featured : ''; ?>
        </div>
    </div>
</div>