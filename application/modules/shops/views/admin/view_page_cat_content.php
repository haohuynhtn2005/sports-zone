<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <?php
                if (!isset($row['id'])) {
                    echo '<h3 class="box-title"><em class="fa fa-file-text-o">&nbsp;</em>Thêm danh mục sản phẩm</h3>';
                    $action = get_admin_url($module_slug . '/content');
                } else {
                    echo '<h3 class="box-title"><em class="fa fa-edit">&nbsp;</em>Cập nhật danh mục sản phẩm</h3>';
                    $action = get_admin_url($module_slug . '/content/' . $row['id']);
                }
                ?>
            </div>
            <div class="box-body">
                <form id="f-cat" role="form" action="<?php echo $action; ?>" method="post" autocomplete="off" enctype="multipart/form-data">
                    <?php
                    $parent = 0;
                    $id = 0;
                    if (isset($row['id'])) {
                        $parent = $row['parent'];
                        $id = $row['id'];
                        echo "<input type=\"hidden\" name=\"id\" id=\"id\" value=\"{$row['id']}\" />";
                    } elseif (isset($row_parent)) {
                        $parent = $row_parent;
                    }
                    ?>
                    <div class="form-group">
                        <label class="control-label">Thuộc danh mục sản phẩm</label>
                        <select class="form-control" name="parent">
                            <option value="0">Là danh mục sản phẩm chính</option>
                            <?php echo multilevel_option_parent(0, $data_list, $data_input, 0, $id, $parent); ?>
                        </select>
                    </div>

                    <div class="form-group required<?php echo form_error('name') != '' ? ' has-error' : ''; ?>">
                        <label for="name" class="control-label">Tên danh mục sản phẩm</label>
                        <input type="text" class="form-control" name="name" id="name" value="<?php echo isset($row['name']) ? html_escape($row['name']) : ''; ?>">
                        <?php echo form_error('name'); ?>
                    </div>

                    <div class="form-group required<?php echo form_error('alias') != '' ? ' has-error' : ''; ?>">
                        <label for="alias" class="control-label">Liên kết tĩnh</label>
                        <input type="text" class="form-control" name="alias" id="alias" value="<?php echo isset($row['alias']) ? html_escape($row['alias']) : ''; ?>">
                        <?php echo form_error('alias'); ?>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Slogun</label>
                        <input type="text" class="form-control" name="slogun" value="<?php echo isset($row['slogun']) ? html_escape($row['slogun']) : ''; ?>">
                    </div>

                    <div class="form-group">
                        <div class="checkbox">
                            <label for="inhome">
                                <input class="flat-blue" name="inhome" id="inhome" type="checkbox" value="1"<?php echo (isset($row['inhome']) && ($row['inhome'] == 1)) ? ' checked' : ''; ?>> <strong>Hiển thị trang chủ</strong>
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Chọn ảnh</label>
                        <input type="file" class="file" name="image[]">
                        <?php if(isset($row['image']) && trim($row['image']) != ''): ?>
                        <div style="margin-top: 10px;">
                            <img width="100" src="<?php echo get_image(get_module_path('shops_cat') . $row['image'], get_module_path('shops_cat') . 'no-image.png'); ?>" alt="" class="img-thumbnail img-responsive">
                        </div>
                        <?php endif; ?>
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

                    <div class="text-center">
                        <?php if (isset($row['id'])) : ?>
                            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                        <?php else : ?>
                            <button type="submit" class="btn btn-success">Thêm</button>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>