<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><em class="fa fa-cogs">&nbsp;</em>Cấu hình sự kiện</h3>
            </div>
            <div class="box-body">
                <form id="f-content" action="<?php echo current_url(); ?>" method="post" enctype="multipart/form-data" autocomplete="off">
                    <div class="form-group required<?php echo form_error('projects_title') != '' ? ' has-error' : ''; ?>">
                        <label class="control-label">Tiêu đề (SEO)</label>
                        <input type="text" class="form-control" name="projects_title" value="<?php echo isset($configs['projects_title']) ? $configs['projects_title'] : ''; ?>">
                        <?php echo form_error('projects_title'); ?>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Keywords (SEO)</label>
                        <textarea class="form-control" name="projects_keywords" data-autoresize><?php echo isset($configs['projects_keywords']) ? $configs['projects_keywords'] : ''; ?></textarea>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Description (SEO)</label>
                        <textarea class="form-control" name="projects_description" data-autoresize><?php echo isset($configs['projects_description']) ? $configs['projects_description'] : ''; ?></textarea>
                    </div>

                    <div class="form-group">
                        <?php $projects_image_share = (isset($configs['projects_image_share']) && ($configs['projects_image_share'] != '') ? $configs['projects_image_share'] : 'logo_default.png'); ?>
                        <label class="control-label">Ảnh share (Nên chọn PNG)</label>
                        <input type="file" class="file" name="projects_image_share[]">
                        <div style="margin-top: 10px;">
                            <img src="<?php echo base_url(get_module_path('projects') . $projects_image_share); ?>" width="100%" alt="" class="img-thumbnail">
                        </div>
                    </div>

                    <div class="text-center">
                        <button class="btn btn-primary" type="submit">Lưu</button>
                        &nbsp;<a class="btn btn-danger" href="<?php echo get_admin_url($module_slug); ?>">Hủy</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>