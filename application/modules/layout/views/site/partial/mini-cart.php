<?php $count = count($this->cart->contents()); ?>

<div class="block-minicart">
    <a href="<?php echo site_url('gio-hang'); ?>"><img src="<?php echo get_asset('img_path'); ?>shopping-cart.svg"
            alt="./images/shopping-cart.svg" class="img-fluid"></a>
    <div class="count-item"><?php echo $count; ?></div>
    <div class="box-cart-hidden">
        <?php if ($this->cart->contents()): ?>
        <ul class="block-cart-hidden-list">
            <?php foreach ($this->cart->contents() as $items):?>
            <li class="cart-item">
                <div class="cart--image">
                    <a href="<?php echo $items['url']; ?>"><img src="<?php echo $items['img']; ?>"
                            alt="<?php echo $items['name']; ?>" class="img-fluid"></a>
                </div>
                <div class="cart--content">
                    <h3><a href="<?php echo $items['url']; ?>" class="product--title"><?php echo $items['name']; ?></a>
                    </h3>
                    <p class="product--price"><?php echo formatRice($items['price']); ?>đ</p>
                    <div class="product--qualities">
                        <div class="input-group">
                            <input data-rowid="<?php echo $items['rowid']; ?>"
                                class="input--qualities form-control mini-cart-qty" type="number"
                                value="<?php echo $items['qty']; ?>" min="1" max="10" />
                        </div>
                    </div>
                </div>
                <div class="cart--button">
                    <button data-rowid="<?php echo $items['rowid']; ?>"
                        class="btn btn--delete  mini-cart-remove-item"><i class="fas fa-trash"></i></button>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
        <div class="block-cart-hidden--total">
            Tổng tiền: <span class="total--price" id="mini-cart-total"><?php echo formatRice($this->cart->total()); ?>
                ₫</span>
        </div>
        <div class="block-cart-hidden--button">
            <a href="<?php echo site_url('thanh-toan'); ?>" class="btn btn--payment">Tiến hành thanh toán</a>
            <a href="<?php echo site_url('gio-hang'); ?>" class="btn btn--cart">Đi đến giỏ hàng</a>
        </div>
        <?php else: ?>
        Chưa có sản phẩm trong giỏ hàng !
        <?php endif; ?>
    </div>
</div>