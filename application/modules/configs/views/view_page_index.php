<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><em class="fa fa-edit">&nbsp;</em>Cấu hình chung</h3>
            </div>
            <div class="box-body">
                <form id="f-cat" role="form" action="<?php echo get_admin_url('settings'); ?>" method="post" autocomplete="off">
                    <div class="form-group required<?php echo form_error('site_email') != '' ? ' has-error' : ''; ?>">
                        <label for="site_email" class="control-label">Email của site</label>
                        <?php $configs_site_email = (set_value('site_email') != '') ? set_value('site_email') : $configs['site_email']; ?>
                        <input class="form-control" name="site_email" id="site_email" type="text" value="<?php echo $configs_site_email; ?>">
                        <?php echo form_error('site_email'); ?>
                    </div>

                    <div class="form-group">
                        <label for="fb_page" class="control-label">Facebook fanpage code</label>
                        <textarea class="form-control" data-autoresize name="fb_page" id="fb_page"><?php echo $configs['fb_page']; ?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="iframe_map" class="control-label">Iframe bản đồ trang liên hệ</label>
                        <textarea class="form-control" data-autoresize name="iframe_map" id="iframe_map"><?php echo $configs['iframe_map']; ?></textarea>
                    </div>

                    <div class="text-center">
                        <button class="btn btn-primary" type="submit">Lưu</button>
                    </div>
                </form>
            </div>
        </div><!-- /.box -->
    </div>
</div>