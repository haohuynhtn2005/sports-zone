<?php if (isset($data) && is_array($data) && !empty($data)): ?>
    <?php foreach ($data as $row): $is_default = $row['is_default'] == 1 ? TRUE : FALSE; ?>
    <div class="block-address-item row-address-item-<?php echo $row['id']; ?>">
        <div class="book-address-box first-box">
            <div class="address-box-content">
                <div class="address-box-info">
                    <span class="block-info-name"><span class="address-full-name"><?php echo $row['full_name']; ?></span><?php echo $is_default ? ' <span class="address-default"><i class="far fa-check-circle"></i> Địa chỉ mặc định</span>' : ''; ?><br></span>
                    <span>Địa chỉ: </span> <span class="font-weight-bold address-full-address"><?php echo get_full_address($row); ?></span><br>
                    <span>Điện thoại: </span> <span class="font-weight-bold address-phone"><?php echo $row['phone']; ?></span><br>
                </div>
            </div>
            <?php if($is_default): ?>
            <div class="address-box-edit">
                <button type="button" class="btn btn--button btn--hover-color btn-address-edit" data-id="<?php echo $row['id']; ?>">Chỉnh sửa</button>
            </div>
            <?php else: ?>
            <div class="address-box-edit btn-group">
                <button type="button" class="btn btn-info btn-sm btn-address-edit ml-2" data-id="<?php echo $row['id']; ?>">Chỉnh sửa</button>
                <button type="button" class="btn btn-danger btn-sm btn-address-delete ml-2" data-id="<?php echo $row['id']; ?>">Xoá</button>
                <a href="<?php echo site_url('mac-dinh-dia-chi-giao-hang/' . $row['id']); ?>" class="btn btn-primary btn-sm btn-address-set-is-default ml-2">Mặc định</a>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endforeach; ?>
<?php endif; ?>