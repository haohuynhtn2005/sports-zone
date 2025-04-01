<style type="text/css">
    .container-element{
        margin-bottom: 15px;
    }
    .margin-top-10{
        margin-top: 10px;
    }
</style>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><em class="fa fa-table">&nbsp;</em>Thông tin</h3>
            </div>
            <div class="box-body">
                <form id="f-content" action="<?php echo get_admin_url($module_slug . '/content' . (isset($row['id']) ? '/' . $row['id'] : '')); ?>" method="post" enctype="multipart/form-data" autocomplete="off">
                    <?php
                    if (isset($row['id'])) {
                    echo '<input type="hidden" value="' . $row['id'] . '" id="id" name="id" />';
                    }
                    ?>
                    <div class="form-group required<?php echo form_error('title') != '' ? ' has-error' : ''; ?>">
                        <label class="control-label">Tiêu đề</label>
                        <input type="text" class="form-control" name="title" value="<?php echo isset($row['title']) ? html_escape($row['title']) : ''; ?>">
                        <?php echo form_error('title'); ?>
                    </div>

                    <div class="form-group required">
                        <label class="control-label">Loại</label>
                        <select class="form-control" name="post_type">
                            <?php echo get_option_select($this->config->item('info_modules'), isset($row['post_type']) ? $row['post_type'] : ''); ?>
                        </select>
                    </div>

                    <?php
                    $attributes_field = array(
                        'attributes' => array(
                            'label' => 'Thuộc tính khác',
                            'label_des' => ' (Chỉ hiển thị khi xem chi tiết)',
                        ),
                    );
                    foreach ($attributes_field as $attribute => $attribute_field):
                        $attribute_slug = str_replace("_", "-", $attribute);
                        $attribute_label = $attribute_field['label'];
                        $attribute_label_des = $attribute_field['label_des'];
                        $attributes = isset($row[$attribute]) ? @unserialize($row[$attribute]) : null;
                    ?>
                    <div class="form-group" id="<?php echo $attribute_slug; ?>">
                        <label class="control-label" for="<?php echo $attribute_slug; ?>"><?php echo $attribute_label; ?></label><?php echo $attribute_label_des; ?>
                        <?php if (is_array($attributes) && !empty($attributes)): ?>
                            <?php foreach ($attributes as $value): ?>
                                <div class="row container-element">
                                    <div class="col-md-3">
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <button class="btn btn-danger remove-element" type="button"> <i class="fa fa-trash"></i></button>
                                            </span>
                                            <input type="text" class="form-control" name="<?php echo $attribute; ?>[label][]" value="<?php echo html_escape($value['label']); ?>" placeholder="Tiêu đề">
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <textarea class="form-control" name="<?php echo $attribute; ?>[content][]" data-autoresize rows="3" placeholder="Nội dung"><?php echo $value['content']; ?></textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <hr>
                                    </div>
                                </div>
                            <?php endforeach;?>
                        <?php endif;?>
                    </div>
                    <div class="form-group">
                        <a href="javascript:void(0)" id="more-<?php echo $attribute_slug; ?>" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Thêm <?php echo convert_to_lowercase($attribute_label); ?></a>
                    </div>
                    <?php endforeach;?>

                    <div class="form-group">
                        <label for="content" class="control-label">Nội dung</label>
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
                        <label class="control-label">Liên kết</label>
                        <input type="text" class="form-control" name="link" value="<?php echo isset($row['link']) ? html_escape($row['link']) : ''; ?>">
                    </div>

                    <div class="form-group">
                        <div class="checkbox">
                            <label for="status">
                                <input type="checkbox" class="flat-blue" name="status" id="status" value="1"<?php echo (isset($row['status']) && ($row['status'] == 0)) ? '' : ' checked'; ?>> <strong>Hiển thị</strong>
                            </label>
                        </div>
                    </div>

                    <div class="text-center">
                        <?php if (isset($row['id'])) : ?>
                            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                        <?php else : ?>
                            <button type="submit" class="btn btn-success">Thêm thông tin</button>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
