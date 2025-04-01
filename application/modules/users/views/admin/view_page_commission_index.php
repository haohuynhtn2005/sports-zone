<?php $is_admin = isset($role) && in_array($role, array('ADMIN')); ?>
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
                        <label><em>Từ khóa tìm kiếm không dùng các mã html</em></label>
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
                <h3 class="box-title"><em class="fa fa-table">&nbsp;</em>Danh sách hoa hồng</h3>
            </div>
            <div class="box-body">
                <?php if (!empty($rows)): ?>
                    <form class="form-inline" name="main" method="post" action="<?php echo get_admin_url($module_slug . '/' . 'main'); ?>" autocomplete="off">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            <input class="flat-blue check-all" name="check_all[]" type="checkbox" value="yes">
                                        </th>
                                        <th>#ID</th>
                                        <th>Người dùng</th>
                                        <th>Hoạt động</th>
                                        <th class="text-right">Giá trị</th>
                                        <th class="text-right">Phần trăm</th>
                                        <th class="text-right">Hoa hồng</th>
                                        <th class="text-center">Thời gian</th>
                						<th class="text-center">Trạng thái</th>
                						<th>Ghi chú</th>
                                        <?php if($is_admin): ?>
                                        <th class="text-center">Chức năng</th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $this->config->set_item('role', array(
                                        'MEMBER' => 'Thành viên',
                                        'ADMIN' => 'Hệ thống',
                                    ));
                                    ?>
                                    <?php foreach ($rows as $row): ?>
                                        <tr>
                                            <td class="text-center">
                                                <input type="checkbox" class="check flat-blue" value="<?php echo $row['id']; ?>" name="idcheck[]">
                                            </td>
                                            <td><?php echo $row['id']; ?></td>
                                            <td>
                                                <?php echo $row['full_name']; ?>
                                                <?php echo display_label(display_value_array($this->config->item('role'), $row['role']), display_value_array($this->config->item('role_label'), $row['role'])); ?>
                                            </td>
                                            <td>
                                                <?php echo display_label(display_value_array($this->config->item('users_modules_commission'), $row['action']), display_value_array($this->config->item('users_modules_commission_label'), $row['action'])); ?>
                                                <?php if(in_array($row['action'], array('SUB_BUY', 'SUB_BUY_ROOT', 'SYSTEM', 'BUY_SYSTEM', 'SELL', 'BUY_REFERRED_PARTNER'))): ?>
                                                <p>
                                                    <?php echo display_label('#ID-' . $row['order_id'] . '-' . $row['order_code'], 'info'); ?>
                                                </p>
                                                <?php endif; ?>
                                                <?php
                                                if(isset($row['note']) && trim($row['note']) != ''){
                                                    echo "<br/>" . display_label($row['note'], 'warning');
                                                }
                                                ?>
                                            </td>
                                            <td class="text-right"><?php echo ($row['value_cost'] > 0 ? '+' : '') . formatRice($row['value_cost']); ?></td>
                                            <td class="text-right"><?php echo in_array($row['action'], array('WITHDRAWAL')) ? '' : $row['percent']; ?></td>
                                            <td class="text-right"><?php echo in_array($row['action'], array('WITHDRAWAL')) ? '' : ($row['value'] > 0 ? '+' : '') . formatRice($row['value']); ?></td>
                                            <td class="text-center"><?php echo display_date($row['created']); ?></td>
                                            <td class="text-center">
                                                <?php
                                                if($row['status'] == 1){
                                                    echo display_label('Khả dụng');
                                                }elseif($row['status'] == 0){
                                                    echo display_label('Đã yêu cầu', 'warning');
                                                    if(in_array($row['action'], array('WITHDRAWAL'))){
                                                        echo ' <span class="label label-primary btn-status-confirm" data-id="' . $row['id'] . '" style="cursor: pointer;">Xác nhận</span> <span class="label label-danger btn-status-cancel" data-id="' . $row['id'] . '" style="cursor: pointer;">Hủy</span>';
                                                    }
                                                }else{
                                                    echo display_label('Đã hủy yêu cầu', 'danger');
                                                }
                                                ?>
                                            </td>
                                            <td><?php echo $row['message']; ?></td>
                                            <?php if($is_admin): ?>
                                            <td class="text-center">
                                                <em class="fa fa-trash-o fa-lg">&nbsp;</em> <a href="<?php echo get_admin_url($module_slug . '/delete?id=' . $row['id']); ?>" class="btn-delete-confirm">Xóa</a>
                                            </td>
                                            <?php endif; ?>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </form>
                <?php else: ?>
                    <div class="callout callout-warning">
                        <h4>Thông báo!</h4>
                        <p><b>Không</b> có giao dịch nào!</p>
                    </div>
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