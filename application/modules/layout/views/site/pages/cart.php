<article>
    <section>
        <div class="box-wapper-cart">
            <div class="container">
                <?php if (!$this->cart->contents()): ?>
                <div class="block--title">
                    <h3 class="main--title">Giỏ hàng trống</h3>
                </div>
                <?php else: ?>
                <form method="post" action="<?php echo base_url('cap-nhat-gio-hang'); ?>">
                    <div class="row">
                        <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 md-order-2">
							<div class="block--title">
								<h3 class="main--title">Giỏ hàng</h3>
							</div>
                            <div class="block-wapper-cart-table">
                                <div class="table-responsive table-borderless">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="title-product-name" colspan="2">Sản phẩm</th>
                                                <th class="title-product-price">Giá</th>
                                                <th class="title-product-quantity">Số lượng</th>
                                                <th class="title-product-subtotal">Thành tiền</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
													$i = 0;
													$cart = $this->cart->contents();
													$count = count($cart);
													foreach ($cart as $items):
                                                        $i++;
														?>
                                            <tr>
                                                <td class="product--image">
                                                    <a href="<?php echo $items['url']; ?>">
                                                        <img src="<?php echo $items['img']; ?>" alt=""
                                                            class="img-fluid">
                                                    </a>
                                                </td>
                                                <td class="product--name">
                                                    <input type="hidden" name="rowid[]" id="rowid"
                                                        value="<?php echo $items['rowid']; ?>" />
                                                    <h3><a
                                                            href="<?php echo $items['url']; ?>"><?php echo $items['name']; ?></a>
                                                    </h3>
                                                    <a href="<?php echo site_url('xoa-san-pham-gio-hang?rowid=' . $items['rowid']); ?>"
                                                        class="product--delete remove"><i class="far fa-trash-alt"></i>
                                                        Xóa sản phẩm
                                                    </a>
												</td>
                                                <td class="product--price">
                                                    <span
                                                        class="price--sale"><?php echo formatRice($items['price']); ?>₫</span>
                                                    <?php //if($items['price'] != $items['unit_price']): ?>
                                                    <!-- <span
                                                        class="price--origin"><?php //echo formatRice($items['unit_price']); ?>₫</span> -->
                                                    <?php //endif; ?>
                                                </td>
                                                <td class="product--quantity">
                                                    <div class="input-group">
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-default minus-btn" data-rowid="<?php echo $items['rowid']; ?>"
                                                                type="button">-</button>
                                                        </span>
                                                        <input type="number" step="1" min="1" name="quantity[]" data-rowid="<?php echo $items['rowid']; ?>"
                                                            value="<?php echo $items['qty']; ?>" title="Số lượng"
                                                            class="qty form-control" size="4">
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-default plus-btn" data-rowid="<?php echo $items['rowid']; ?>"
                                                                type="button">+</button>
                                                        </span>
                                                    </div>
                                                </td>
                                                <td class="product--subtotal">
                                                    <span class="price--sale">
                                                        <?php echo formatRice($items['subtotal']); ?>₫
                                                    </span>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="next-shop">
                                <a href="<?php echo site_url('san-pham'); ?>" class="btn btn--button btn--color">Tiếp tục mua hàng</a>
                            </div>
                            <br>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 pl-xl-0 md-order-1">
                            <div class="block-wapper-cart-bill">
								<div class="block--title">
									<h3 class="main--title">Tổng giỏ hàng</h3>
								</div>
								<div class="block-wapper-cart-bill--total">
									<span class="title">Thành tiền:</span>
									<span class="price"><?php echo formatRice($this->cart->total()); ?>₫</span>
								</div>
								<div class="block-wapper-cart-bill--button">
                                <button type="submit" class="btn btn--button btn--color">Cập nhật giỏ hàng</button>
                                <a href="<?php echo site_url('thanh-toan'); ?>" class="btn btn--button btn--hover-color">Thanh toán</a>
								</div>
                            </div>
                        </div>
                    </div>
                </form>
                <?php endif; ?>
            </div>
        </div>
    </section>
</article>