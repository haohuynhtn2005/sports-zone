<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-name"><em class="fa fa-table">&nbsp;</em>Thông tin</h3>
            </div>
            <div class="box-body">
                <form id="f-content" action="<?php echo get_admin_url($module_slug . '/content' . (isset($row['id']) ? '/' . $row['id'] : '')); ?>" method="post" enctype="multipart/form-data" autocomplete="off">
                    <?php
                    if (isset($row['id'])) {
                        echo '<input type="hidden" value="' . $row['id'] . '" id="id" name="id" />';
                    }
                    ?>
					<div class="form-group required<?php echo form_error('protocol') != '' ? ' has-error' : ''; ?>">
						<label for="protocol" class="control-label">Protocol</label>
						<input class="form-control" type="text" name="protocol" id="protocol" value="<?php echo isset($row['protocol']) ? $row['protocol'] : ''; ?>" maxlength="255">
                        <?php echo form_error('protocol'); ?>
					</div>

					<div class="form-group required<?php echo form_error('smtp_host') != '' ? ' has-error' : ''; ?>">
						<label for="smtp_host" class="control-label">SMTP host</label>
						<input class="form-control" type="text" name="smtp_host" id="smtp_host" value="<?php echo isset($row['smtp_host']) ? $row['smtp_host'] : ''; ?>" maxlength="255">
                        <?php echo form_error('smtp_host'); ?>
					</div>

					<div class="form-group required<?php echo form_error('smtp_port') != '' ? ' has-error' : ''; ?>">
						<label for="smtp_port" class="control-label">SMTP port</label>
						<input class="form-control" type="text" name="smtp_port" id="smtp_port" value="<?php echo isset($row['smtp_port']) ? $row['smtp_port'] : ''; ?>" maxlength="255">
                        <?php echo form_error('smtp_port'); ?>
					</div>

					<div class="form-group required<?php echo form_error('smtp_user') != '' ? ' has-error' : ''; ?>">
                        <label for="smtp_user" class="control-label">Email</label>
                        <input class="form-control" name="smtp_user" id="smtp_user" type="text" value="<?php echo isset($row['smtp_user']) ? $row['smtp_user'] : ''; ?>">
                        <?php echo form_error('smtp_user'); ?>
                    </div>

                    <div class="form-group">
						<label for="smtp_pass" class="control-label">Password</label>
						<input class="form-control" type="password" name="smtp_pass" id="smtp_pass" value="" maxlength="255">
					</div>

                    <div class="form-group">
                        <div class="checkbox">
                            <label for="active">
                                <input class="flat-blue" name="active" id="active" type="checkbox" value="1"<?php echo (isset($row['active']) && ($row['active'] == 1)) ? ' checked' : ''; ?>> <strong>Kích hoạt</strong>
                            </label>
                        </div>
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