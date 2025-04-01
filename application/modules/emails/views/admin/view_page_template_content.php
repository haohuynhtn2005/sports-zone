<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-name"><em class="fa fa-table">&nbsp;</em>Thông tin</h3>
            </div>
            <div class="box-body">
                <form id="f-content" action="<?php echo get_admin_url($module_slug . '/content'); ?>" method="post" enctype="multipart/form-data" autocomplete="off">
                    <?php
                    if (isset($row['id'])) {
                        echo '<input type="hidden" value="' . $row['id'] . '" id="id" name="id" />';
                    }
                    ?>
					<div class="form-group required<?php echo form_error('name') != '' ? ' has-error' : ''; ?>">
                        <label for="name" class="control-label">Tên giao diện email</label>
                        <input class="form-control" name="name" id="name" type="text" value="<?php echo isset($row['name']) ? $row['name'] : ''; ?>">
                        <?php echo form_error('name'); ?>
                    </div>

					<div class="form-group">
						<label for="description" class="control-label">Mô tả</label>
						<input class="form-control" type="text" name="description" id="description" value="<?php echo isset($row['description']) ? $row['description'] : ''; ?>" maxlength="255">
					</div>

					<div class="form-group">
						<label for="subject" class="control-label">Chủ đề</label>
						<input class="form-control" type="text" name="subject" id="subject" value="<?php echo isset($row['subject']) ? $row['subject'] : ''; ?>" maxlength="255">
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="variable_label" class="control-label">Biến giá trị</label>
								<select class="form-control" name="variable_label" id="variable_label">
									<option value="">---Chọn---</option>
									<?php echo get_option_select($this->config->item('email_variables_label'), ''); ?>
								</select>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label for="variable_name" class="control-label">Code</label>
								<div class="input-group">
									<input type="text" maxlength="255" value="" name="variable_name" id="variable_name" class="form-control">
									<span class="input-group-btn">
										<button class="btn btn-small btn-success" type="button" id="insert-code-tag"><i class="fa fa-plus"></i></button>
									</span>
								</div>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label for="bodyhtml" class="control-label">Nội dung gửi mail</label>
						<?php
						$bodyhtml = isset($row['bodyhtml']) ? $row['bodyhtml'] : '';
						$config_mini = array();
						$config_mini['language'] = 'vi';
						$config_mini['filebrowserBrowseUrl'] = base_url() . 'ckeditor/kcfinder/browse.php?opener=ckeditor&type=files';
						$config_mini['filebrowserImageBrowseUrl'] = base_url() . 'ckeditor/kcfinder/browse.php?opener=ckeditor&type=images&dir=images/news';
						$config_mini['filebrowserFlashBrowseUrl'] = base_url() . 'ckeditor/kcfinder/browse.php?opener=ckeditor&type=flash';
						$config_mini['filebrowserUploadUrl'] = base_url() . 'ckeditor/kcfinder/upload.php?opener=ckeditor&type=files';
						$config_mini['filebrowserImageUploadUrl'] = base_url() . 'ckeditor/kcfinder/upload.php?opener=ckeditor&type=images&dir=images/news';
						$config_mini['filebrowserFlashUploadUrl'] = base_url() . 'ckeditor/kcfinder/upload.php?opener=ckeditor&type=flash';
						echo $this->ckeditor->editor("bodyhtml", $bodyhtml, $config_mini);
						?>
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