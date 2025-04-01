<?php
$is_filters = isset($data_filters) && is_array($data_filters) && !empty($data_filters);
$is_filter_price = isset($data_filter_price) && trim($data_filter_price) != '';
?>
<div class="filter-checked">
    <?php if($is_filters || $is_filter_price): ?>
        <?php if($is_filters): ?>
            <?php foreach($data_filters as $key => $value): ?>
                <span><?php echo $value; ?> <a href="javascript:void(0);" class="btn-fieldter btn-clear-filter" data-id="<?php echo $key; ?>"><i class="fas fa-times"></i></a></span>
            <?php endforeach; ?>
        <?php endif; ?>
        <?php if($is_filter_price): ?>
            <span><?php echo $data_filter_price; ?> <a href="javascript:void(0);" class="btn-clear-price"><i class="fas fa-times"></i></a></span>
        <?php endif; ?>
        <a href="javascript:void(0);" class="btn btn--button btn--color clear-all btn-clear-all">Xoá tất cả</a>
    <?php endif; ?>
</div>
