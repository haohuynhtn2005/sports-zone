<div class="row">    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">        <div class="box box-primary">            <div class="box-header with-border">                <h3 class="box-title"><em class="fa fa-table">&nbsp;</em>Danh sách danh mục sản phẩm</h3>                <a class="btn btn-success pull-right" href="<?php echo get_admin_url($module_slug . '/' . 'content'); ?>"><i class="fa fa-plus"></i> Thêm</a>            </div>            <div class="box-body">                <?php if (!empty($rows)): ?>                    <form class="form-inline" name="main" method="post" action="<?php echo get_admin_url($module_slug . '/main'); ?>" autocomplete="off">                        <div class="table-responsive">                            <table class="table table-striped table-bordered table-hover">                                <thead>                                    <tr>                                        <th class="text-center" style="width: 80px;">STT</th>                                        <th>Tên danh mục sản phẩm</th>                                        <th class="text-center">Hiển thị trang chủ</th>                                        <th class="text-center" style="width: 160px;">Chức năng</th>                                    </tr>                                </thead>                                <tbody>                                    <?php echo display_table_cat(0, $data_list, $data_input, 0); ?>                                </tbody>                                <tfoot>                                    <tr class="text-left">                                        <td colspan="3">											<div class="input-group">
												<select class="form-control" name="action" id="action">
													<option value="update">Cập nhật</option>
												</select>
												<span class="input-group-btn">													<button class="btn btn-primary" type="submit">Thực hiện</button>												</span>
											</div>                                        </td>                                    </tr>                                </tfoot>                            </table>                        </div>                    </form>                <?php else: ?>                    <?php echo show_alert_warning('Chưa có danh mục sản phẩm nào!'); ?>                <?php endif; ?>            </div>        </div>    </div></div>