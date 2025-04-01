<style type="text/css">
	.margin-top-10{
		margin-top: 10px;
	}
</style>
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
                    	<div class="row">
                    		<div class="col-md-12">
                    			<div class="form-group search_title">
		                            Ngày
		                        </div>
		                        <div class="form-group search_input">
		                            <div class="input-group input-append date" id="datePickerFromday">
		                                <?php $fromday = (isset($get['fromday']) && ($get['fromday'] != '') ? $get['fromday'] : '');?>
		                                <input type="text" class="form-control input-sm" name="fromday" value="<?php echo $fromday; ?>" />
		                                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
		                            </div>
		                        </div>
		                        <div class="form-group search_title">
		                            Đến ngày
		                        </div>
		                        <div class="form-group search_input">
		                            <div class="input-group input-append date" id="datePickerToday">
		                                <?php $today = (isset($get['today']) && ($get['today'] != '') ? $get['today'] : '');?>
		                                <input type="text" class="form-control input-sm" name="today" value="<?php echo $today; ?>" />
		                                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
		                            </div>
		                        </div>

		                        <div class="form-group search_title">
		                            Tình trạng
		                        </div>
		                        <div class="form-group search_input">
		                            <select class="form-control input-sm" name="status" id="f_status">
		                                <option value="-1">Tất cả</option>
		                                <?php echo get_option_select($this->config->item('email_send_status'), isset($get['status']) ? $get['status'] : '-1'); ?>
		                            </select>
		                        </div>
                    		</div>
                    	</div>
                    	<div class="row margin-top-10">
                    		<div class="col-md-12">
                    			<div class="form-group search_title">
		                            Số dòng hiển thị
		                        </div>
		                        <div class="form-group search_input">
		                            <select class="form-control input-sm" name="per_page">
		                                <?php
		                                $records_in_page = 50;
		                                for ($i = 1; $i <= 10; $i++) {
		                                    $per_page = $i * $records_in_page;
		                                    ?>
		                                    <?php if (isset($get['per_page']) && $get['per_page'] == $per_page) : ?>
		                                        <option selected="selected" value="<?php echo $per_page; ?>"><?php echo $per_page; ?></option>
		                                    <?php else : ?>
		                                        <option value="<?php echo $per_page; ?>"><?php echo $per_page; ?></option>
		                                    <?php endif; ?>
		                                    <?php
		                                }
		                                ?>
		                            </select>
		                        </div>

		                        <div class="form-group search_title">
		                            Từ khóa tìm kiếm
		                        </div>
		                        <div class="form-group search_input">
		                        	<div class="input-group">
										<input class="form-control input-sm" type="text" value="<?php echo isset($get['q']) ? $get['q'] : ''; ?>" maxlength="64" name="q" placeholder="Từ khóa tìm kiếm">
										<span class="input-group-btn">
											<button type="submit" class="btn btn-primary btn-sm">Tìm kiếm</button>
										</span>
									</div>
		                        </div>
                    		</div>
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
                <h3 class="box-title"><em class="fa fa-table">&nbsp;</em>Nhật ký gửi mail</h3>
            </div>
            <div class="box-body">
                <?php if (!empty($rows)): ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th>Email gửi</th>
                                    <th>Email nhận</th>
                                    <th>Tiêu đề</th>
                                    <th class="text-center">Ngày đăng ký</th>
                                    <th class="text-center">Ngày gửi</th>
                                    <th class="text-center">Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($rows as $row): ?>
                                    <tr>
                                        <td class="text-right">
                                            <?php echo $row['id']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['email']; ?>
                                            <?php echo trim($row['mailed_by']) != '' ? "<br>" . display_label($row['mailed_by']) : ''; ?>
                                        </td>
                                        <td><?php echo $row['to']; ?></td>
                                        <td><?php echo word_limiter($row['subject'], 30); ?></td>
                                        <td class="text-center"><?php echo display_date($row['created']); ?></td>
                                        <td class="text-center">
                                            <?php echo $row['sended'] > 0 ? display_date($row['sended']) : display_label('None', 'primary'); ?>
                                        </td>
                                        <td class="text-center">
                                            <?php echo display_label(display_value_array($this->config->item('email_send_status'), $row['status']), display_value_array($this->config->item('email_send_status_label'), $row['status'])); ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="callout callout-warning">
                        <h4>Thông báo!</h4>
                        <p><b>Không</b> có thông tin nào!</p>
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