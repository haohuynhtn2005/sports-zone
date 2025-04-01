<article>
  <section>
    <div class="box-warpper">
      <div class="container">
        <div class="box-checkout">
          <h2>KẾT QUẢ THANH TOÁN</h2>
          <div class="row">
            <div class="col-xl-7 col-lg-7 col-md-8 col-sm-8">
              <div class="checkout-warpper">
                <div class="report-authe">
                  <div class="icon-order-success">
                    <svg xmlns="http://www.w3.org/2000/svg" width="72px" height="72px">
                      <g fill="none" stroke="#8EC343" stroke-width="2">
                        <circle cx="36" cy="36" r="35" style="stroke-dasharray:240px, 240px; stroke-dashoffset: 480px;"></circle>
                        <path d="M17.417,37.778l9.93,9.909l25.444-25.393" style="stroke-dasharray:50px, 50px; stroke-dashoffset: 0px;"></path>
                      </g>
                    </svg>
                  </div>
                  <div class="order-success-text">
                    <h3>Cảm ơn bạn đã đặt hàng. Mã đơn hàng của bạn là <strong><?php echo isset($order['order_code']) ? $order['order_code'] : ''; ?></strong></h3>
                    <p>
                      Một email xác nhận đã được gửi tới <strong><?php echo isset($order['order_email']) ? $order['order_email'] : ''; ?></strong>
                      <br>
                      Xin vui lòng kiểm tra email của bạn!
                    </p>
                  </div>
                  <div class="clearfix"></div>
                </div>
                <div class="detail-order">
                  <div class="card">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                          <h3>Thông tin thanh toán</h3>
                          <p>Họ tên: <?php echo isset($order['customer_full_name']) ? $order['customer_full_name'] : ''; ?></p>
                          <p>Email: <?php echo isset($order['order_email']) ? $order['order_email'] : ''; ?></p>
                          <p>Điện thoại: <?php echo isset($order['customer_phone']) ? $order['customer_phone'] : ''; ?></p>
                          <h3>Ngày đặt hàng: <strong><?php echo date('d/m/Y', $order['created']); ?> lúc <?php echo date('h:i A', $order['created']); ?></strong></h3>
                          <h3 style="margin-bottom: 2px;">Hình thức thanh toán: <strong><?php echo display_value_array($this->config->item($order['forms_of_payment'], 'forms_of_payment'), 'title'); ?></strong></h3>
                          <p style="font-style: italic;"><?php echo display_value_array($this->config->item($order['forms_of_payment'], 'forms_of_payment'), 'info'); ?></p>
                          <?php if (isset($order['order_note']) && trim($order['order_note']) != ''): ?>
                          <h3>Ghi chú</h3>
                          <p><?php echo nl2br($order['order_note']); ?></p>
                          <?php endif; ?>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                          <h3>Địa chỉ giao hàng</h3>
                          <p>Họ tên: <?php echo isset($order['order_full_name']) ? $order['order_full_name'] : ''; ?></p>
                          <p>Địa chỉ: <?php echo isset($order['order_address']) ? $order['order_address'] : ''; ?></p>
                          <p>Điện thoại: <?php echo isset($order['order_phone']) ? $order['order_phone'] : ''; ?></p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-5 col-lg-5 col-md-4 col-sm-4">
              <div class="block-totalcart">
                <h3 class="title">ĐƠN HÀNG CỦA BẠN</h3>
                <table cellspacing="0">
                  <thead>
                    <tr>
                      <th class="product-name">SẢN PHẨM</th>
                      <th class="product-total">TỔNG CỘNG</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($products as $product): ?>
                      <tr class="cart-item-checkout">
                        <td class="name-product-checkout"><?php echo isset($product['name']) ? $product['name'] : ''; ?><strong> x <?php echo $product['quantity']; ?></strong></td>
                        <td><span><?php echo formatRice($product['monetized']); ?>&nbsp;₫</span></td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                  <tfoot>
                    <tr class="cart-subtotal">
                      <th>Tạm tính</th>
                      <td><strong><span><?php echo formatRice($order['order_amount']); ?>&nbsp;₫</span></strong></td>
                    </tr>
                    <tr class="shipping">
                        <th>Phí vận chuyển</th>
                        <td><strong><span><?php echo $order['order_shipping'] > 0 ? formatRice($order['order_shipping']) . '&nbsp;₫' : 'Miễn phí'; ?></span></strong></td>
                    </tr>
                    <tr class="order-total">
                      <th>Thành tiền</th>
                      <td><strong><span><?php echo formatRice($order['order_monetized']); ?>&nbsp;₫</span></strong> </td>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</article>