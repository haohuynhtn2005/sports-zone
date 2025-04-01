<?php
$cart_total = $this->cart->total();
$has_address = (isset($address_items) && trim($address_items) != '');
?>
<article>
	<section>
		<div class="box-warpper">
			<div class="container">
				<div class="box-checkout">
					<h2>THANH TOÁN</h2>
					<div class="address-message">
                        <?php $this->load->view('layout/notify'); ?>
                    </div>
					<form id="f-checkout" action="<?php echo current_url(); ?>" method="post">
						<div class="row">
							<div class="col-xl-7 col-lg-7 col-md-8 col-sm-8">
								<div class="checkout-warpper">
									<h3 class="title">THANH TOÁN VÀ GIAO HÀNG</h3>
									<div class="box-address-on-checkout">
										<h4>Chọn địa chỉ giao hàng</h4>
										<div class="box-choices-address">
											<ul class="block-address-content address-list<?php echo $has_address ? '' : ' d-none'; ?>">
												<?php echo $has_address ? $address_items : ''; ?>
											</ul>
											<div class="view-all-address d-flex flex-nowrap">
												<button type="button" class="btn btn-primary btn-sm btn-view-more-address order-1 mr-2<?php echo $has_address ? '' : ' d-none'; ?>">Xem thêm địa chỉ</button>
												<button type="button" class="btn btn-info btn-sm order-2" id="btn-address-add">Thêm địa chỉ khác</button>
												<button type="button" class="btn btn-primary btn-sm btn-view-less-address order-1 mr-2<?php echo $has_address ? '' : ' d-none'; ?>">Ẩn bớt địa chỉ</button>
											</div>
										</div>
									</div>
									<h3 class="title">THÔNG TIN THANH TOÁN</h3>
									<div class="row">
										<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
											<div class="form-group">
												<label>Họ và tên <abbr class="required" title="Bắt buộc">*</abbr></label>
												<input type="text" class="form-control" placeholder="Họ và tên" name="full_name" size="35" value="<?php echo isset($user['full_name']) ? $user['full_name'] : ''; ?>">
											</div>
										</div>
										<div class="clearfix"></div>
										<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
											<div class="form-group">
												<label>Địa chỉ email <abbr class="required" title="Bắt buộc">*</abbr></label>
												<input type="email" name="email" size="35" required class="form-control" placeholder="Địa chỉ email" value="<?php echo isset($user['email']) ? $user['email'] : ''; ?>">
											</div>
										</div>
										<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
											<div class="form-group">
												<label>Số điện thoại <abbr class="required" title="Bắt buộc">*</abbr></label>
												<input type="text" class="form-control" name="phone" size="35" required placeholder="Số điện thoại" value="<?php echo isset($user['phone']) ? $user['phone'] : ''; ?>">
											</div>
										</div>
										<div class="clearfix"></div>
									</div>
									<h3 class="title">THÔNG TIN THÊM</h3>
									<hr style="margin: 5px 0px 15px;">
									<div class="form-group">
										<label for="">Ghi chú đơn hàng</label>
										<textarea class="form-control" placeholder="Ghi chú đơn hàng" name="order_note" rows="3" cols="80"></textarea>
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
											<?php if ($this->cart->contents()): ?>
												<?php foreach ($this->cart->contents() as $items): ?>
													<tr class="cart-item-checkout">
														<td class="name-product-checkout"><?php echo $items['name']; ?> <strong>x<?php echo $items['qty']; ?></strong></td>
														<td><span><?php echo formatRice($items['subtotal']); ?>&nbsp;₫</span></td>
													</tr>
												<?php endforeach; ?>
											<?php endif; ?>
										</tbody>
										<tfoot>
											<tr class="cart-subtotal">
												<th>Tạm tính</th>
												<td><strong><span><?php echo formatRice($cart_total); ?> ₫</span></strong></td>
											</tr>
											<tr class="cart-subtotal">
												<th>Phí vận chuyển</th>
												<td><strong><span class="fee-value"><?php echo $fee > 0 ? formatRice($fee) . ' ₫' : 'Miễn phí'; ?></span></strong></td>
											</tr>
											<tr class="order-total">
												<th>Thành tiền</th>
												<td><strong><span class="total-value"><?php echo formatRice($cart_total + $fee); ?> ₫</span></strong> </td>
											</tr>
										</tfoot>
									</table>
									<?php $forms_of_payment = $this->config->item('forms_of_payment'); ?>
									<?php if(is_array($forms_of_payment) && !empty($forms_of_payment)): ?>
										<div class="box-payment">
											<ul>
												<?php $i=0; foreach($forms_of_payment as $key => $payment): $i++; ?>
													<li>
														<input id="payment_method_<?php echo $key; ?>" type="radio" value="<?php echo $key; ?>" name="forms_of_payment"<?php echo $i==1 ? ' checked="checked"' : ''; ?>>
														<label for="payment_method_<?php echo $key; ?>"><?php echo $payment['title']; ?></label>
														<div class="block-content" id="payment-<?php echo $key; ?>">
															<?php echo $payment['info']; ?>
														</div>
													</li>
												<?php endforeach; ?>
											</ul>
										</div>
									<?php endif; ?>
									<div class="place-order">
										<button type="submit" class="btn btn-primary">ĐẶT HÀNG</button>
									</div>
								</div>
								<br>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>
</article>
<div class="modal fade" id="addressModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addressModalLabel">Thêm địa chỉ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="f-address-checkout-content" action="#" method="post">
                <div class="modal-body">
                    <div class="address-modal-message"></div>
                    <div class="account-change-email">
                        <input type="hidden" name="id" value="0">
                        <div class="row form-group">
                            <div class="col-lg-3 col-md-3 col-sm-5">
                                <p class="account-change-email_header">Tên *</p>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-5">
                                <input class="form-control" type="text" name="full_name" value="">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-3 col-md-3 col-sm-5">
                                <p class="account-change-email_header">Địa chỉ nhận hàng (tầng, số nhà, đường) *</p>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-5">
                                <input class="form-control" type="text" name="place_of_receipt" value="">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-3 col-md-3 col-sm-5">
                                <p class="account-change-email_header">Tỉnh/Thành phố *</p>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-5">
                                <select class="form-control" name="province_id" id="el-province">
                                    <option value="0">-- Chọn tỉnh/thành phố --</option>
                                    <?php echo display_option_select($provinces, 'pId', 'pNameVi', 0); ?>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-3 col-md-3 col-sm-5">
                                <p class="account-change-email_header">Quận/huyện *</p>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-5">
                                <select class="form-control" name="district_id" id="el-district">
                                    <option value="0">-- Chọn quận/huyện --</option>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-3 col-md-3 col-sm-5">
                                <p class="account-change-email_header">Phường, xã *</p>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-5">
                                <select class="form-control" name="commune_id" id="el-commune">
                                    <option value="0">-- Chọn phường/xã --</option>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-lg-3 col-md-3 col-sm-5">
                                <p class="account-change-email_header">Số điện thoại *</p>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-5">
                                <input class="form-control" type="text" name="phone" value="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </form>
        </div>
    </div>
</div>