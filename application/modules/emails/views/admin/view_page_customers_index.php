<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <form name="filter" method="get" action="<?php echo get_admin_url($module_slug); ?>" autocomplete="off">
            <nav class="search_bar navbar navbar-default" role="search">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#filter-bar-7adecd427b033de80d2a0e30cf74e735">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse" id="filter-bar-7adecd427b033de80d2a0e30cf74e735">
                    <div class="navbar-form">
                        <div class="form-group search_title">
                            Nhóm khách hàng
                        </div>
                        <div class="form-group search_input">
                            <select class="form-control input-sm" name="group_id" id="group_id">
                                <option value="">-- Tất cả nhóm --</option>
                                <?php echo display_option_select($group, 'id', 'name', isset($get['group_id']) ? $get['group_id'] : 0); ?>
                            </select>
                        </div>

                        <div class="form-group search_title">
                            Số dòng hiển thị
                        </div>
                        <div class="form-group search_input">
                            <select class="form-control input-sm" name="per_page">
                                <?php echo get_option_per_page(isset($get['per_page']) ? (int) $get['per_page'] : $this->config->item('item', 'admin_list')); ?>
                            </select>
                        </div>

                        <div class="form-group search_title">
                            Từ khóa tìm kiếm
                        </div>
                        <div class="form-group search_input">
                            <input class="form-control input-sm" type="text" value="<?php echo isset($get['q']) ? $get['q'] : ''; ?>" maxlength="64" name="q" placeholder="Từ khóa tìm kiếm">
                        </div>
                        <div class="form-group search_action pull-right">
                            <button type="submit" class="btn btn-primary btn-sm">Tìm kiếm</button>
                        </div>
                        <br>
                        <label><em>Từ khóa tìm kiếm không ít hơn 3 ký tự, không lớn hơn 64 ký tự, không dùng các mã html</em></label>
                    </div>
                </div>
            </nav>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><em class="fa fa-table">&nbsp;</em>Danh sách khách hàng</h3>
                <div class="pull-right">
                    <a class="btn btn-info" href="<?php echo get_admin_url($module_slug . '/' . 'export'); ?>"><i class="fa fa-cloud-download"></i> Xuất dữ liệu</a>
                    &nbsp;<a class="btn btn-primary" href="<?php echo get_admin_url($module_slug . '/' . 'import'); ?>"><i class="fa fa-cloud-upload"></i> Nhập dữ liệu</a>
                    &nbsp;<a class="btn btn-success" href="<?php echo get_admin_url($module_slug . '/' . 'content'); ?>"><i class="fa fa-plus"></i> Thêm</a>
                </div>
            </div>
            <div class="box-body">
                <?php if (empty($rows)): ?>
                    <div class="callout callout-warning">
                        <h4>Thông báo!</h4>
                        <p><b>Không</b> tìm thấy khách hàng nào!</p>
                    </div>
                <?php else: ?>
                    <form class="form-inline" name="main" method="post" action="<?php echo get_admin_url($module_slug . '/' . 'main'); ?>">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            <input class="flat-blue check-all" name="check_all[]" type="checkbox" value="yes">
                                        </th>
                                        <th>#ID</th>
                                        <th>Khách hàng</th>
                                        <th class="text-center">Nhóm khách hàng</th>
                                        <th>Địa chỉ</th>
                                        <th>Điện thoại</th>
                                        <th>Email</th>
                                        <th class="text-center" style="width: 130px;">Chức năng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($rows as $row): ?>
                                        <tr>
                                            <td class="text-center">
                                                <input type="checkbox" class="check flat-blue" value="<?php echo $row['id']; ?>" name="idcheck[]">
                                            </td>
                                            <td><?php echo $row['id']; ?></td>
                                            <td>
												<?php echo $row['full_name']; ?>
											</td>
                                            <td class="text-center"><?php echo display_label($row['group_name']); ?></td>
                                            <td><?php echo $row['address']; ?></td>
                                            <td><?php echo $row['phone']; ?></td>
                                            <td><?php echo $row['email']; ?></td>
                                            <td class="text-center">
                                                <em class="fa fa-edit fa-lg">&nbsp;</em> <a href="<?php echo get_admin_url($module_slug . '/content/' . $row['id'] . ((isset($current_page) && $current_page > 0) ? ('?current_page=' . $current_page ) : '')); ?>">Sửa</a>
                                                &nbsp;&nbsp; <em class="fa fa-trash-o fa-lg">&nbsp;</em> <a href="<?php echo get_admin_url($module_slug . '/delete?id=' . $row['id']); ?>" class="delete_bootbox">Xóa</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr class="text-left">
                                        <td colspan="6">
											<div class="input-group">
												<select class="form-control" name="action" id="action">
													<option value="delete">Xóa</option>
													<option value="content">Thêm</option>
												</select>
												<span class="input-group-btn">
													<button class="btn btn-primary" type="submit">Thực hiện</button>
												</span>
											</div>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
            <?php if ($pagination != ''): ?>
                <div class="box-footer clearfix">
                    <?php echo $pagination; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>