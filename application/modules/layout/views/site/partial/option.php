<?php if(isset($not_display_first) && $not_display_first == 1): ?>
<?php else: ?>
<option value="0">-- Chọn <?php echo isset($option_name) ? $option_name : ''; ?> --</option>
<?php endif; ?>
<?php echo display_option_select($data, isset($data_key) ? $data_key : 'id', isset($data_value) ? $data_value : 'name', isset($option_selected) ? $option_selected : 0); ?>