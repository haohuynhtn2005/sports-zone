<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><em class="fa fa-table">&nbsp;</em>Thông tin</h3>
            </div>
            <div class="box-body">
                <form id="f-content" action="<?php echo get_admin_url($module_slug . '/content' . (isset($row['id']) ? ('/' . $row['id']) : '')); ?>" method="post" enctype="multipart/form-data" autocomplete="off">
                    <?php if (isset($row['id'])): ?>
                    <input type="hidden" value="<?php echo $row['id']; ?>" id="id" name="id">
                    <?php endif;?>
                    <div class="form-group required<?php echo form_error('name') != '' ? ' has-error' : ''; ?>">
                        <label for="name" class="control-label">Tên sự kiện</label>
                        <input type="text" class="form-control" name="name" id="name" value="<?php echo isset($row['name']) ? html_escape($row['name']) : ''; ?>">
                        <?php echo form_error('name'); ?>
                    </div>

                    <div class="form-group required<?php echo form_error('alias') != '' ? ' has-error' : ''; ?>">
                        <label for="alias" class="control-label">Liên kết tĩnh</label>
                        <input type="text" class="form-control" name="alias" id="alias" value="<?php echo isset($row['alias']) ? html_escape($row['alias']) : ''; ?>" maxlength="255">
                        <?php echo form_error('alias'); ?>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Khách hàng</label>
                                <input type="text" class="form-control" name="customer" value="<?php echo isset($row['customer']) ? html_escape($row['customer']) : ''; ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Thời gian</label>
                                <input type="text" class="form-control" name="time" value="<?php echo isset($row['time']) ? html_escape($row['time']) : ''; ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Liên hệ tư vấn</label>
                                <input type="text" class="form-control" name="contact" value="<?php echo isset($row['contact']) ? html_escape($row['contact']) : ''; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <br>
                                <div class="checkbox">
                                    <label for="inhome">
                                        <input class="flat-blue" name="inhome" id="inhome" type="checkbox" value="1"<?php echo (isset($row['inhome']) && ($row['inhome'] == 1)) ? ' checked' : ''; ?>> <strong> Dự án đã thi công</strong>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Địa chỉ</label>
                        <input type="text" class="form-control" name="address" value="<?php echo isset($row['address']) ? html_escape($row['address']) : ''; ?>">
                    </div>

                    <div class="form-group">
                        <label for="image" class="control-label">Hình ảnh</label>
                        <input id="image" name="image[]" class="file" type="file">
                        <?php if(isset($row['image']) && trim($row['image']) != ''): ?>
                        <div style="margin-top: 10px;">
                            <img src="<?php echo get_image(get_module_path('projects') . $row['image'], get_module_path('projects') . 'no-image.png'); ?>" alt="" class="img-thumbnail">
                        </div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Mô tả</label> (Chỉ hiển thị khi xem chi tiết)
                        <?php
                        $hometext = isset($row['hometext']) ? $row['hometext'] : '';
                        $config_mini = array();
                        $config_mini['language'] = 'vi';
                        $config_mini['filebrowserBrowseUrl'] = base_url() . 'ckeditor/kcfinder/browse.php?opener=ckeditor&type=files';
                        $config_mini['filebrowserImageBrowseUrl'] = base_url() . 'ckeditor/kcfinder/browse.php?opener=ckeditor&type=images&dir=images/news';
                        $config_mini['filebrowserFlashBrowseUrl'] = base_url() . 'ckeditor/kcfinder/browse.php?opener=ckeditor&type=flash';
                        $config_mini['filebrowserUploadUrl'] = base_url() . 'ckeditor/kcfinder/upload.php?opener=ckeditor&type=files';
                        $config_mini['filebrowserImageUploadUrl'] = base_url() . 'ckeditor/kcfinder/upload.php?opener=ckeditor&type=images&dir=images/news';
                        $config_mini['filebrowserFlashUploadUrl'] = base_url() . 'ckeditor/kcfinder/upload.php?opener=ckeditor&type=flash';
                        echo $this->ckeditor->editor("hometext", $hometext, $config_mini);
                        ?>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Thông tin chi tiết</label> (Chỉ hiển thị khi xem chi tiết)
                        <?php
                        $content = isset($row['content']) ? $row['content'] : '';
                        $config_mini = array();
                        $config_mini['language'] = 'vi';
                        $config_mini['filebrowserBrowseUrl'] = base_url() . 'ckeditor/kcfinder/browse.php?opener=ckeditor&type=files';
                        $config_mini['filebrowserImageBrowseUrl'] = base_url() . 'ckeditor/kcfinder/browse.php?opener=ckeditor&type=images&dir=images/news';
                        $config_mini['filebrowserFlashBrowseUrl'] = base_url() . 'ckeditor/kcfinder/browse.php?opener=ckeditor&type=flash';
                        $config_mini['filebrowserUploadUrl'] = base_url() . 'ckeditor/kcfinder/upload.php?opener=ckeditor&type=files';
                        $config_mini['filebrowserImageUploadUrl'] = base_url() . 'ckeditor/kcfinder/upload.php?opener=ckeditor&type=images&dir=images/news';
                        $config_mini['filebrowserFlashUploadUrl'] = base_url() . 'ckeditor/kcfinder/upload.php?opener=ckeditor&type=flash';
                        echo $this->ckeditor->editor("content", $content, $config_mini);
                        ?>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Title (SEO)</label>
                        <input type="text" class="form-control" name="title_seo" value="<?php echo isset($row['title_seo']) ? html_escape($row['title_seo']) : ''; ?>">
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

                    <div class="text-center">
                        <?php if (isset($row['id'])): ?>
                            <input class="btn btn-primary" type="submit" value="Lưu thay đổi">
                        <?php else: ?>
                            <input class="btn btn-success" type="submit" value="Thêm">
                        <?php endif;?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>