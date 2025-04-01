<style type="text/css">
    .payment {
        color: #f00;
        font-weight: bold;
        display: block;
        margin-top: 10px;
        border: 1px solid #f00;
        padding: 3px;
        text-transform: uppercase;
    }
</style>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="box box-primary" id="element-print">
            <div class="box-header with-border">
                <h3 class="box-title"><em class="fa fa-table">&nbsp;</em>Xem đơn hàng: <?php echo $order['order_code']; ?></h3>
                <div class="pull-right noPrint">
                    <a class="btn btn-info" href="<?php echo get_admin_url($module_slug); ?>"><i class="fa fa-table"></i> Danh sách</a>
                </div>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td style="border-top: none;">
                                    <table>
                                        <tbody>
                                            <tr>
                                                <th colspan="2">Thông tin thanh toán</th>
                                            </tr>
                                            <tr>
                                                <td width="150px">Họ tên:</td>
                                                <td><?php echo isset($order['customer_full_name']) ? $order['customer_full_name'] : ''; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Email:</td>
                                                <td><?php echo isset($order['order_email']) ? $order['order_email'] : ''; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Điện thoại:</td>
                                                <td><?php echo isset($order['customer_phone']) ? $order['customer_phone'] : ''; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Hình thức thanh toán:</th>
                                                <td><strong><?php echo display_value_array($this->config->item($order['forms_of_payment'], 'forms_of_payment'), 'title'); ?></strong></td>
                                            </tr>

                                            <tr>
                                                <th colspan="2" style="padding-top: 15px;">Địa chỉ giao hàng</th>
                                            </tr>
                                            <tr>
                                                <td>Họ tên:</td>
                                                <td><?php echo isset($order['order_full_name']) ? $order['order_full_name'] : ''; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Địa chỉ:</td>
                                                <td><?php echo isset($order['order_address']) ? $order['order_address'] : ''; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Điện thoại:</td>
                                                <td><?php echo isset($order['order_phone']) ? $order['order_phone'] : ''; ?></td>
                                            </tr>
                                            <tr>
                                                <th style="padding-top: 15px;">Ngày đặt hàng:</th>
                                                <td style="padding-top: 15px;"><?php echo date('d/m/Y', $order['created']); ?> lúc <?php echo date('h:i A', $order['created']); ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                                <td style="border-top: none;" width="100px" valign="top" class="text-center">
                                    <div class="order_code">
                                        Mã đơn hàng
                                        <br>
                                        <span class="text_date"><strong><?php echo $order['order_code']; ?></strong></span>
                                        <br>
                                        <span class="payment">
                                            <?php
                                            if ($order['transaction_status'] == 0) {
                                                $transaction_status = 'Chờ thanh toán';
                                            }elseif ($order['transaction_status'] == -1) {
                                                $transaction_status = 'Đã hủy';
                                            }else {
                                                $transaction_status = 'Đã thanh toán';
                                            }
                                            echo $transaction_status;
                                            ?>
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <td width="30px">STT</td>
                                <td>Tên sản phẩm</td>
                                <td class="text-right">Giá sản phẩm (vnđ)</td>
                                <td class="text-right">Giảm giá (vnđ)</td>
                                <td class="text-right">Số lượng</td>
                                <td class="text-right">Thành tiền (vnđ)</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stt = 1;
                            foreach ($products as $product) {
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $stt; ?></td>
                                    <td><?php echo isset($product['name']) ? $product['name'] : ''; ?></td>
                                    <td class="text-right">
                                        <strong><?php echo formatRice($product['promotion_price']); ?></strong>
                                        <?php if($product['promotion_price'] != $product['price']): ?>
                                        <del style="display: block; color: #9c9696;"><?php echo formatRice($product['price']); ?></del>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-right"><strong><?php echo formatRice($product['percent_discount']); ?></strong></td>
                                    <td class="text-right"><?php echo $product['quantity']; ?></td>
                                    <td class="text-right"><strong><?php echo formatRice($product['monetized']); ?></strong></td>
                                </tr>
                                <?php
                                $stt++;
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="text-right" colspan="5">Tạm tính</td>
                                <td class="text-right"><strong style="color: #f00;"><?php echo formatRice($order['order_amount']); ?></strong></td>
                            </tr>
                            <tr>
                                <td class="text-right" colspan="5">Phí vận chuyển</td>
                                <td class="text-right"><strong style="color: #f00;"><?php echo $order['order_shipping'] > 0 ? formatRice($order['order_shipping']) : 'Miễn phí'; ?></strong></td>
                            </tr>
                            <tr>
                                <td class="text-right" colspan="5">Thành tiền</td>
                                <td class="text-right"><strong style="color: #f00;"><?php echo formatRice($order['order_monetized']); ?></strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <?php if (isset($order['order_note']) && trim($order['order_note']) != ''): ?>
                <div class="box-footer clearfix">
                    <i>Ghi chú:</i>
                    <br>
                    <?php echo nl2br($order['order_note']); ?>
                </div>
            <?php endif; ?>
            <div class="text-center noPrint" id="btn-group-action">
                <?php if ($order['transaction_status'] == 0): ?>
                    <button type="button" class="btn btn-success btn-group-action btn-confirm" data-id="<?php echo $order['order_id']; ?>">Xác nhận thanh toán</button>
                    &nbsp;<button type="button" class="btn btn-danger btn-group-action btn-cancel" data-id="<?php echo $order['order_id']; ?>">Hủy</button>
                <?php elseif ($order['transaction_status'] == -1): ?>
                    <button class="btn btn-danger" type="button">Đã hủy</button>
                <?php else: ?>
                    <button type="button" class="btn btn-success">Đã thanh toán</button>
                <?php endif; ?>
                &nbsp;<button type="button" class="btn btn-info btn-print"><span class="glyphicon glyphicon-print"></span>&nbsp;In</button>
            </div>
            <br>
        </div>
    </div>
</div>