<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><em class="fa fa-table">&nbsp;</em>Thông tin gửi mail</h3>
            </div>
            <div class="box-body">
                <form id="f-content" action="<?php echo get_admin_url($module_slug); ?>" method="post" enctype="multipart/form-data" autocomplete="off">
					<input type="hidden" name="status" id="status" value="1" />
					<?php if(isset($row['id'])): ?>
					<input type="hidden" name="id" id="id" value="<?php echo $row['id']; ?>" />
					<?php endif; ?>
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <?php $has_error = (form_error('full_name') != '' ? ' has-error' : ''); ?>
                            <div class="form-group required<?php echo $has_error; ?>">
                                <label for="full_name" class="control-label">Họ tên người gửi</label>
                                <input type="text" maxlength="255" value="<?php echo isset($row['full_name']) ? $row['full_name'] : (isset($site_name) ? $site_name : ''); ?>" name="full_name" id="full_name" class="form-control" required>
                                <?php echo form_error('full_name'); ?>
                            </div>

                            <?php $has_error = (form_error('email') != '' ? ' has-error' : ''); ?>
                            <div class="form-group required<?php echo $has_error; ?>">
                                <label for="email" class="control-label">Email người gửi</label>
                                <input type="email" maxlength="255" value="<?php echo isset($row['email']) ? $row['email'] : (isset($email) ? $email : ''); ?>" name="email" id="email" class="form-control" required>
                                <?php echo form_error('email'); ?>
                            </div>

                            <div class="form-group required<?php echo form_error('mailings_group') != '' ? ' has-error' : ''; ?>">
                                <label for="mailings_group" class="control-label">Nhóm người nhận</label>
                                <select class="form-control chosen-select" multiple="true" tabindex="1" data-placeholder="Chọn nhóm người nhận" name="mailings_group[]" id="mailings_group" required>
                                    <?php echo display_option_select($customers_group, 'id', 'name', isset($row['mailings_group']) ? @unserialize($row['mailings_group']) : ''); ?>
                                </select>
                                <?php echo form_error('mailings_group'); ?>
                            </div>

                            <div class="form-group">
                                <label class="control-label">Danh sách email nhận (nếu có)</label>
                                <textarea class="form-control" name="options_emails" data-autoresize rows="3" placeholder="kh01@gmail.com, kh02@gmail.com"><?php echo isset($row['options_emails']) ? $row['options_emails'] : ''; ?></textarea>
                            </div>

                            <!-- <div class="form-group required<?php echo form_error('mailings') != '' ? ' has-error' : ''; ?>">
                                <label for="mailings" class="control-label">Danh sách người nhận</label>
                                <select class="form-control chosen-select" multiple="true" tabindex="1" data-placeholder="Chọn người nhận" name="mailings[]" id="mailings" required>
                                    <?php echo display_option_select($customers, 'id', 'full_name', isset($row['mailings']) ? @unserialize($row['mailings']) : ''); ?>
                                </select>
                                <?php echo form_error('mailings'); ?>
                            </div> -->

							<div class="form-group">
								<label for="template" class="control-label">Template</label>
								<select class="form-control" name="template" id="template">
									<option value="0">---Chọn---</option>
									<?php echo display_option_select($template, 'id', 'name', 0); ?>
								</select>
							</div>

                            <?php $has_error = (form_error('subject') != '' ? ' has-error' : ''); ?>
                            <div class="form-group required<?php echo $has_error; ?>">
                                <label for="subject" class="control-label">Tiêu đề</label>
                                <input type="text" maxlength="255" value="<?php echo isset($row['subject']) ? $row['subject'] : ''; ?>" name="subject" id="subject" class="form-control" required>
                                <?php echo form_error('subject'); ?>
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
												<button class="btn btn-small btn-success" type="button" id="insert-code-tag" title="Chèn code vào nội dung"><i class="fa fa-plus"></i></button>
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
                        </div>
                    </div>
                    <div class="row">
                        <div class="text-center">
                            <input class="btn btn-primary" type="submit" id="send" value="Gửi">
                            <?php if(!(isset($row['status']) && $row['status'] == 1)): ?>
                            &nbsp;<input class="btn btn-success" type="submit" id="drap" value="Lưu nháp">
                            <?php endif; ?>
                            &nbsp;<a class="btn btn-danger" href="<?php echo get_admin_url('emails/repository'); ?>">Hủy</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>