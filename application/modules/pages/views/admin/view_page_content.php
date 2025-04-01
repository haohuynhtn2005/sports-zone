<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><em class="fa fa-table">&nbsp;</em>Thông tin bài viết</h3>
            </div>
            <div class="box-body">
                <?php
                $action_id = '';
                $input_id = '';
                if (isset($row['id'])) {
                    $action_id = '/' . $row['id'];
                    $input_id = '<input type="hidden" value="' . $row['id'] . '" id="id" name="id" class="form-control" />';
                }
                ?>
                <form id="f-content" action="<?php echo get_admin_url($module_slug . '/' . 'content' . $action_id); ?>" method="post" enctype="multipart/form-data" autocomplete="off">
                    <?php echo $input_id; ?>
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <div class="form-group required<?php echo form_error('title') != '' ? ' has-error' : ''; ?>">
                                <label for="title" class="control-label">Tiêu đề</label>
                                <input type="text" class="form-control" name="title" id="title" value="<?php echo isset($row['title']) ? html_escape($row['title']) : ''; ?>">
                                <?php echo form_error('title'); ?>
                            </div>

                            <div class="form-group required<?php echo form_error('alias') != '' ? ' has-error' : ''; ?>">
                                <label for="alias" class="control-label">Liên kết tĩnh</label>
                                <input type="text" class="form-control" name="alias" id="alias" value="<?php echo isset($row['alias']) ? html_escape($row['alias']) : ''; ?>">
                                <?php echo form_error('alias'); ?>
                            </div>

                            <div class="form-group">
                                <label class="control-label">Hình minh họa cho phần giới thiệu</label>
                                <input type="file" class="file" name="homeimg[]">
								<?php if(isset($row['homeimgfile']) && trim($row['homeimgfile'])!= ''): ?>
								<div style="margin-top: 10px;">
									<img width="100" src="<?php echo get_image(get_module_path('posts') . $row['homeimgfile'], get_module_path('posts') . 'no-image.png'); ?>" alt="" class="img-thumbnail img-responsive">
								</div>
								<?php endif; ?>
                            </div>

                            <div class="form-group">
                                <label class="control-label">Chú thích cho hình minh họa (phần chi tiết bài viết)</label>
                                <input type="text" class="form-control" name="homeimgalt" value="<?php echo isset($row['homeimgalt']) ? html_escape($row['homeimgalt']) : ''; ?>" maxlength="255">
                            </div>

                            <div class="form-group">
                                <label class="control-label">Giới thiệu ngắn gọn</label>
                                <textarea class="form-control" name="hometext" data-autoresize rows="3"><?php echo isset($row['hometext']) ? $row['hometext'] : ''; ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="bodyhtml" class="control-label">Nội dung chi tiết</label>
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

                            <div class="form-group">
                                <label class="control-label">Title (SEO)</label>
                                <input type="text" class="form-control" name="title_seo" value="<?php echo isset($row['title_seo']) ? html_escape($row['title_seo']) : ''; ?>" maxlength="255">
                            </div>

                            <div class="form-group">
                                <label class="control-label">Keywords (SEO)</label>
                                <textarea class="form-control" name="keywords" data-autoresize><?php echo isset($row['keywords']) ? $row['keywords'] : ''; ?></textarea>
                            </div>

                            <div class="form-group">
                                <label class="control-label">Description (SEO)</label>
                                <textarea class="form-control" name="description" data-autoresize><?php echo isset($row['description']) ? $row['description'] : ''; ?></textarea>
                            </div>

                            <div class="form-group">
                                <label class="control-label">Other (SEO)</label>
                                <textarea class="form-control" name="other_seo" data-autoresize><?php echo isset($row['other_seo']) ? $row['other_seo'] : ''; ?></textarea>
                            </div>

                            <div class="form-group">
                                <label class="control-label">H1 (SEO)</label>
                                <input type="text" class="form-control" name="h1_seo" value="<?php echo isset($row['h1_seo']) ? html_escape($row['h1_seo']) : ''; ?>" maxlength="255">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="text-center">
                            <?php if (isset($row['id'])) : ?>
                                <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                            <?php else : ?>
                                <button type="submit" class="btn btn-success">Đăng trang tĩnh</button>
                            <?php endif; ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>