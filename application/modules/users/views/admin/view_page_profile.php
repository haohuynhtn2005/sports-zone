<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><em class="fa fa-file-text-o">&nbsp;</em>Cập nhật thông tin cá nhân</h3>
            </div>
            <div class="box-body">
                <?php
                $action = get_admin_url('users/profile');
                ?>
                <form id="f-user-add" role="form" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" autocomplete="off">
                    <?php
                    if (isset($row['userid'])) {
                        echo '<input type="hidden" value="' . $row['userid'] . '" id="userid" name="userid" class="form-control" />';
                    }
                    ?>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group required<?php echo form_error('username') != '' ? ' has-error' : ''; ?>">
                                <label for="username" class="control-label">Tài khoản</label>
                                <input class="form-control" name="username" id="username" type="text" value="<?php echo isset($row['username']) ? $row['username'] : ''; ?>">
                                <?php echo form_error('username'); ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group required<?php echo form_error('full_name') != '' ? ' has-error' : ''; ?>">
                                <label for="full_name" class="control-label">Họ tên</label>
                                <input class="form-control" name="full_name" id="full_name" type="text" value="<?php echo isset($row['full_name']) ? $row['full_name'] : ''; ?>">
                                <?php echo form_error('full_name'); ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group required<?php echo form_error('email') != '' ? ' has-error' : ''; ?>">
                                <label for="email" class="control-label">Email</label>
                                <input class="form-control" name="email" id="email" type="text" value="<?php echo isset($row['email']) ? $row['email'] : ''; ?>">
                                <?php echo form_error('email'); ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="phone" class="control-label">Điện thoại</label>
                                <input class="form-control" name="phone" id="phone" type="text" value="<?php echo isset($row['phone']) ? $row['phone'] : ''; ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="role" class="control-label">Quyền</label>
                                <select class="form-control" name="role" id="role">
                                    <?php echo display_option_select($groups, 'group_id', 'title', isset($row['group_id']) ? $row['group_id'] : 0); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group required<?php echo form_error('password') != '' ? ' has-error' : ''; ?>">
                                <label for="password" class="control-label">Mật khẩu</label>
                                <input class="form-control" name="password" id="password" type="password" value="">
                                <?php echo form_error('password'); ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group required<?php echo form_error('passconf') != '' ? ' has-error' : ''; ?>">
                                <label for="passconf" class="control-label">Lặp lại mật khẩu</label>
                                <input class="form-control" name="passconf" id="passconf" type="password" value="">
                                <?php echo form_error('passconf'); ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group required<?php echo form_error('commission') != '' ? ' has-error' : ''; ?>">
                                <label for="commission" class="control-label">Hoa hồng</label>
                                <input class="form-control" name="commission" type="text" value="<?php echo isset($row['commission']) ? $row['commission'] : ''; ?>">
                                <?php echo form_error('commission'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address" class="control-label">Địa chỉ</label>
                                <input class="form-control" name="address" type="text" value="<?php echo isset($row['address']) ? $row['address'] : ''; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="gender" class="control-label">Giới tính</label>
                                <select class="form-control" name="gender">
                                    <?php echo get_option_gender(isset($row['gender']) ? $row['gender'] : 'N'); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="birthday" class="control-label">Ngày tháng năm sinh</label>
                                <div class="input-group input-append date" id="datePicker">
                                    <?php $birthday = (isset($row['birthday']) && ($row['birthday'] != 0) ? date('d-m-Y', $row['birthday']) : ''); ?>
                                    <input type="text" class="form-control" name="birthday" value="<?php echo $birthday; ?>" />
                                    <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php $photo = (isset($row['photo']) && ($row['photo'] != '') ? $row['photo'] : 'no_avatar.jpg'); ?>
                        <label for="photo" class="control-label">Ảnh đại diện</label>
                        <input id="photo" name="photo[]" class="file" type="file">
                        <div id="current-photo" style="margin-top: 10px;">
                            <img id="img_avatar" src="<?php echo base_url(get_module_path('users') . $photo); ?>" width="100px" alt="" class="img-thumbnail">
                        </div>
                    </div>

                    <div class="text-center">
                        <button class="btn btn-primary" type="submit">Lưu thay đổi</button>
                    </div>
                </form>
            </div>
        </div><!-- /.box -->
    </div>
</div>