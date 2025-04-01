<?php if (isset($data) && is_array($data) && !empty($data)): ?>
    <?php
    $i = 0;
    foreach ($data as $row):
        $i++;
        if(isset($is_create) && $is_create){
            $i = -1;
        }
    ?>
    <li class="address-container">
        <div class="address-item<?php echo $i == 1 ? ' active' : ''; ?>">
            <label class="address-option">
                <input class="radio-address" type="radio" name="address_id" value="<?php echo $row['id']; ?>"<?php echo $i == 1 ? ' checked="checked"' : ''; ?>>
                <div class="box-address">
                    <p class="username"><?php echo $row['full_name']; ?></p>
                    <p class="address-shipping"><?php echo get_full_address($row); ?></p>
                    <p class="phone-number">Điện thoại di động: <?php echo $row['phone']; ?></p>
                </div>
            </label>
        </div>
    </li>
    <?php endforeach; ?>
<?php endif; ?>