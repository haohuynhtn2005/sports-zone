<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><em class="fa fa-info-circle">&nbsp;</em>Thông tin</h3>
                <div class="pull-right">
                    <a class="btn btn-info" href="<?php echo get_admin_url($module_slug); ?>"><i class="fa fa-table"></i> Danh sách</a>
                </div>
            </div>
            <div class="box-body">
                <form id="f-content" action="<?php echo get_admin_url($module_slug . '/content' . (isset($row['id']) ? '/' . $row['id'] : '')); ?>" method="post" enctype="multipart/form-data" autocomplete="off">
                    <?php
                    if (isset($row['id'])) {
                        echo '<input type="hidden" value="' . $row['id'] . '" id="id" name="id" />';
                        echo '<input type="hidden" value="' . (isset($current_page) ? $current_page : 0) . '" id="current_page" name="current_page" />';
                    }
                    ?>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group required">
                                <label for="full_name" class="control-label">Khách hàng</label>
                                <?php $full_name = (isset($row['full_name']) ? $row['full_name'] : ''); ?>
                                <input class="form-control" name="full_name" id="full_name" type="text" value="<?php echo $full_name; ?>">
                                <?php echo form_error('full_name'); ?>
                            </div>
                        </div>

						<div class="col-md-4">
                            <div class="form-group">
                                <label for="group_id" class="control-label">Nhóm khách hàng</label>
                                <select class="form-control" name="group_id" id="group_id">
                                    <?php echo display_option_select($group, 'id', 'name', isset($row['group_id']) ? $row['group_id'] : 0); ?>
                                </select>
                            </div>
                        </div>

						<div class="col-md-4">
                           <div class="form-group required<?php echo form_error('phone') != '' ? ' has-error' : ''; ?>">
								<label for="phone" class="control-label">Điện thoại</label>
                                <input class="form-control" name="phone" id="phone" type="text" value="<?php echo isset($row['phone']) ? $row['phone'] : ''; ?>">
								<?php echo form_error('phone'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
						<div class="col-md-4">
                            <div class="form-group">
                                <label for="email" class="control-label">Email</label>
                                <input class="form-control" name="email" id="email" type="text" value="<?php echo isset($row['email']) ? $row['email'] : ''; ?>">
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="address" class="control-label">Địa chỉ</label>
                                <?php $address = (isset($row['address']) ? $row['address'] : ''); ?>
                                <input class="form-control" name="address" id="address" type="text" value="<?php echo $address; ?>">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="note" class="control-label">Ghi chú</label>
                        <textarea id="note" name="note" data-autoresize rows="3" class="form-control"><?php echo isset($row['note']) ? $row['note'] : ''; ?></textarea>
                    </div>

                    <div class="text-center">
                        <?php if (isset($row['id'])) : ?>
                            <input class="btn btn-primary" type="submit" value="Lưu thay đổi">
                        <?php else : ?>
                            <input class="btn btn-success" type="submit" value="Thêm">
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>