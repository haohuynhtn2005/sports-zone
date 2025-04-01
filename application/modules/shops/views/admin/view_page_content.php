<style type="text/css">
    .container-price, .container-element{
        margin-bottom: 15px;
    }
</style>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><em class="fa fa-table">&nbsp;</em>Thông tin sản phẩm</h3>
            </div>
            <div class="box-body">
                <form id="f-content" action="<?php echo get_admin_url('shops/content' . (isset($row['id']) ? '/' . $row['id'] : '')); ?>" method="post" autocomplete="off" enctype="multipart/form-data">
                    <?php
                    if (isset($row['id'])) {
                        echo '<input type="hidden" value="' . $row['id'] . '" id="id" name="id" class="form-control" />';
                    }
                    ?>
                    <div class="row">
                        <div class="col-sm-12 col-md-9">
                            <div class="form-group required<?php echo form_error('title') != '' ? ' has-error' : ''; ?>">
                                <label for="title" class="control-label">Tên sản phẩm</label>
                                <input type="text" class="form-control" name="title" id="title" value="<?php echo isset($row['title']) ? html_escape($row['title']) : ''; ?>" maxlength="255">
                                <?php echo form_error('title'); ?>
                            </div>

                            <div class="form-group required<?php echo form_error('alias') != '' ? ' has-error' : ''; ?>">
                                <label for="alias" class="control-label">Liên kết tĩnh</label>
                                <input type="text" class="form-control" name="alias" id="alias" value="<?php echo isset($row['alias']) ? html_escape($row['alias']) : ''; ?>" maxlength="255">
                                <?php echo form_error('alias'); ?>
                            </div>

                            <div class="row">
                            	<div class="col-md-3">
                            		<div class="form-group required<?php echo form_error('product_price') != '' ? ' has-error' : ''; ?>">
                            		    <label class="control-label">Giá sản phẩm</label>
                            		    <input type="text" class="form-control text-right mask-price" name="product_price" value="<?php echo isset($row['product_price']) ? $row['product_price'] : ''; ?>">
                            		    <?php echo form_error('product_price'); ?>
                            		</div>
                            	</div>
                            	<div class="col-md-3">
		                            <div class="form-group required<?php echo form_error('product_discount_percent') != '' ? ' has-error' : ''; ?>">
		                                <label class="control-label">Phần trăm giảm giá</label>
		                                <input class="form-control text-right" type="text" name="product_discount_percent" value="<?php echo isset($row['product_discount_percent']) ? $row['product_discount_percent'] : ''; ?>" maxlength="3">
		                                <?php echo form_error('product_discount_percent'); ?>
		                            </div>
                            	</div>
                            	<div class="col-md-3">
                            		<div class="form-group">
		                                <label class="control-label">Giá khuyến mãi</label>
		                                <input type="text" class="form-control text-right mask-price" name="product_sales_price" value="<?php echo isset($row['product_sales_price']) ? $row['product_sales_price'] : ''; ?>">
		                            </div>
                            	</div>
                                <div class="col-md-3">
                                    <div class="form-group required<?php echo form_error('commission') != '' ? ' has-error' : ''; ?>">
                                        <label class="control-label">Hoa hồng</label>
                                        <input type="text" class="form-control text-right" name="commission" value="<?php echo isset($row['commission']) ? $row['commission'] : ''; ?>">
                                        <?php echo form_error('commission'); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                            	<div class="col-md-6">
                            		<div class="form-group">
		                                <label for="catid" class="control-label">Danh mục sản phẩm</label>
		                                <select class="form-control" name="catid" id="catid">
		                                    <?php echo multilevel_cat(0, $shops_cat['data_list'], $shops_cat['data_input'], 0, isset($row['listcatid']) ? $row['listcatid'] : 0); ?>
		                                </select>
		                            </div>
                            	</div>
                            	<div class="col-md-3">
                            		<div class="form-group">
		                                <label class="control-label">Mã sản phẩm</label>
		                                <input type="text" class="form-control" name="product_code" value="<?php echo isset($row['product_code']) ? html_escape($row['product_code']) : ''; ?>">
		                            </div>
                            	</div>
                            	<div class="col-md-3">
                            		<div class="form-group">
		                                <label class="control-label">Trạng thái kho hàng</label>
		                                <select class="form-control" name="stock_status">
		                                    <?php echo get_option_select($this->config->item('stock_status'), isset($row['stock_status']) ? $row['stock_status'] : ''); ?>
		                                </select>
		                            </div>
                            	</div>
                            </div>
                            <div class="form-group">
                                <label for="filter_id" class="control-label">Thương hiệu</label>
								<select class="form-control" name="filter_id" id="filter_id">
									<?php echo display_option_select($filter, 'id', 'name', isset($row['filter_id']) ? $row['filter_id'] : 0); ?>
								</select>
                            </div>
                            <div class="form-group<?php echo!isset($row['id']) ? ' required' : ''; ?>">
                                <label class="control-label">Hình minh họa</label>
                                <input type="file" class="file" name="homeimg[]"<?php echo isset($row['id']) ? '' : ' data-min-file-count="1"'; ?>>
                                <?php if(isset($row['homeimgfile']) && trim($row['homeimgfile']) != ''): ?>
								<div style="margin-top: 10px;">
                                    <img class="img-thumbnail img-responsive" src="<?php echo get_image(get_module_path('shops') . $row['homeimgfile'], get_module_path('shops') . 'no-image.png'); ?>" alt="" width="100">
                                </div>
								<?php endif; ?>
                            </div>

                            <div class="form-group">
                                <label class="control-label">Chú thích cho hình minh họa (phần chi tiết sản phẩm)</label>
                                <input type="text" class="form-control" name="homeimgalt" value="<?php echo isset($row['homeimgalt']) ? html_escape($row['homeimgalt']) : ''; ?>">
                            </div>

							<div class="form-group" id="remove-image">
								<label class="control-label" for="remove-image">Ảnh khác</label> (Chỉ hiển thị khi xem chi tiết)
								<?php if (isset($row['options']) && is_array($row['options']) && !empty($row['options'])): ?>
									<?php foreach ($row['options'] as $value): ?>
										<div class="row container-element">
											<input type="hidden" class="option-id" name="option_id[<?php echo $value['id']; ?>]" value="<?php echo $value['id']; ?>">
											<div class="col-md-2">
												<input type="text" class="form-control text-right order option-order" name="order[]" value="<?php echo $value['order']; ?>">
											</div>
											<div class="col-md-4">
												<img class="img-thumbnail img-responsive" src="<?php echo get_image(get_module_path('shops') . $value['image'], get_module_path('shops') . 'no-image.png'); ?>" alt="">
											</div>
											<div class="col-md-6">
												<div class="input-group">
													<input type="text" class="form-control option-alt" name="alt[]" value="<?php echo html_escape($value['alt']); ?>" placeholder="Mô tả" maxlength="255">
													<span class="input-group-btn">
														<button type="button" class="btn btn-danger remove-element option-delete"> <i class="fa fa-trash"></i></button>
													</span>
												</div>
											</div>
										</div>
									<?php endforeach;?>
								<?php endif;?>
							</div>

							<div class="form-group">
								<label class="btn btn-primary">
									<i class="fa fa-folder-open-o" aria-hidden="true"></i>&nbsp;Thêm &hellip; <input type="file" accept="image/png, image/jpeg, image/gif" style="display: none;" name="files" id="files" multiple>
								</label>
							</div>
							<div style="clear:both"></div>
							<div class="form-group progress-bar-upload hide">
								<div class="progress">
									<div class="progress-bar progress-bar-success myprogress" role="progressbar" style="width:0%">0%</div>
								</div>
								<div class="upload_msg"></div>
							</div>

							<div class="form-group">
                                <label class="control-label">Giới thiệu ngắn gọn</label>
                                <textarea name="hometext" data-autoresize rows="3" class="form-control"><?php echo isset($row['hometext']) ? $row['hometext'] : ''; ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="bodyhtml" class="control-label">Thông tin chi tiết</label> (Chỉ hiển thị khi xem chi tiết)
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
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <div>
                                <table class="table table-striped table-bordered table-hover">
                                    <tbody>
                                        <tr>
                                            <td style="line-height:16px">
                                                <strong>Từ khóa dành cho máy chủ tìm kiếm</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="background: #fff;">
                                                <?php $tags = isset($row['tags']) ? $row['tags'] : ''; ?>
                                                <input type="text" name="tags" placeholder="Tags" id="Tags" class="tm-input form-control" value="<?php echo $tags; ?>" />
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
								<table class="table table-striped table-bordered table-hover">
                                    <tbody>
                                        <tr>
                                            <td><strong>Tính năng mở rộng</strong></td>
                                        </tr>
                                        <tr>
                                            <td>
												<div style="margin-bottom: 2px;">
                                                    <input class="flat-blue" type="checkbox" value="1" name="is_bestseller"<?php echo (isset($row['is_bestseller']) && $row['is_bestseller'] == 1) ? ' checked="checked"' : ''; ?>>
                                                    <label>Bán chạy</label>
                                                </div>
												<div style="margin-bottom: 2px;">
                                                    <input class="flat-blue" type="checkbox" value="1" name="is_new"<?php echo (isset($row['is_new']) && $row['is_new'] == 1) ? ' checked="checked"' : ''; ?>>
                                                    <label>Mới nhất</label>
                                                </div>
												<!-- <div style="margin-bottom: 2px;">
                                                    <input class="flat-blue" type="checkbox" value="1" name="is_promotion"<?php echo (isset($row['is_promotion']) && $row['is_promotion'] == 1) ? ' checked="checked"' : ''; ?>>
                                                    <label>Khuyến mãi</label>
                                                </div>
												<div style="margin-bottom: 2px;">
                                                    <input class="flat-blue" type="checkbox" value="1" name="is_bestview"<?php echo (isset($row['is_bestview']) && $row['is_bestview'] == 1) ? ' checked="checked"' : ''; ?>>
                                                    <label>Xem nhiều</label>
                                                </div>
                                                <div style="margin-bottom: 2px;">
                                                    <input class="flat-blue" type="checkbox" value="1" name="inhome"<?php echo (isset($row['inhome']) && $row['inhome'] == 1) ? ' checked="checked"' : ''; ?>>
                                                    <label>Hiện trang chủ</label>
                                                </div> -->
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="text-center">
                            <?php if (isset($row['id'])) : ?>
                                <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                            <?php else : ?>
                                <button type="submit" class="btn btn-success">Đăng sản phẩm</button>
                            <?php endif; ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
