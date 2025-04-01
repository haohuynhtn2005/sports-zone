<aside class="main-sidebar">
    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?php echo get_image(get_module_path('users') . $photo, get_module_path('users') . 'no-image.png'); ?>" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
                <p>Chào <?php echo $full_name; ?>!</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <ul class="sidebar-menu">
            <li class="header">MENU</li>
            <li<?php if ($menu_admin_active == '') echo ' class="active"'; ?>>
                <a href="<?php echo get_admin_url(); ?>">
                    <i class="fa fa-dashboard"></i> <span>Bảng điều khiển</span>
                </a>
            </li>
            <li class="treeview<?php if ($menu_admin_active == 'settings') echo ' active'; ?>">
                <a href="<?php echo get_admin_url('settings'); ?>">
                    <i class="fa fa-cogs"></i> <span>Cấu hình</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo get_admin_url('settings'); ?>"><i class="fa fa-angle-double-right"></i> Cấu hình chung</a></li>
                    <li><a href="<?php echo get_admin_url('settings/main'); ?>"><i class="fa fa-angle-double-right"></i> Cấu hình site</a></li>
                </ul>
            </li>
            <li class="treeview<?php if ($menu_admin_active == 'images') echo ' active'; ?>">
                <a href="<?php echo get_admin_url('images'); ?>"><i class="fa fa-photo"></i> Hình ảnh</a>
            </li>
            <li class="treeview<?php if ($menu_admin_active == 'info') echo ' active'; ?>">
                <a href="#">
                    <i class="fa fa-phone"></i>
                    <span>Thông tin</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo get_admin_url('info'); ?>"><i class="fa fa-angle-double-right"></i> Danh sách thông tin</a></li>
                    <li><a href="<?php echo get_admin_url('info/content'); ?>"><i class="fa fa-angle-double-right"></i> Thêm thông tin</a></li>
                </ul>
            </li>
            <li class="treeview<?php if ($menu_admin_active == 'emails') echo ' active'; ?>">
                <a href="#">
                    <i class="fa fa-envelope-o"></i>
                    <span>Email</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo get_admin_url('emails'); ?>"><i class="fa fa-angle-double-right"></i> Cấu hình mặc định</a></li>
                    <!-- <li><a href="<?php echo get_admin_url('emails/logs'); ?>"><i class="fa fa-angle-double-right"></i> Nhật ký</a></li>
                    <li><a href="<?php echo get_admin_url('emails/configs'); ?>"><i class="fa fa-angle-double-right"></i> Cấu hình</a></li>
                    <li><a href="<?php echo get_admin_url('emails/template'); ?>"><i class="fa fa-angle-double-right"></i> Giao diện</a></li>
                    <li><a href="<?php echo get_admin_url('emails/repository'); ?>"><i class="fa fa-angle-double-right"></i> Kho lưu trữ</a></li>
                    <li><a href="<?php echo get_admin_url('emails/sendmail'); ?>"><i class="fa fa-angle-double-right"></i> Gửi mail</a></li>
                    <li><a href="<?php echo get_admin_url('emails/customers'); ?>"><i class="fa fa-angle-double-right"></i> Khách hàng</a></li>
                    <li><a href="<?php echo get_admin_url('emails/customers/group'); ?>"><i class="fa fa-angle-double-right"></i> Nhóm khách hàng</a></li> -->
                </ul>
            </li>
            <li class="treeview<?php if ($menu_admin_active == 'menu') echo ' active'; ?>">
                <a href="#">
                    <i class="fa fa-bars"></i>
                    <span>Menu</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo get_admin_url('menu'); ?>"><i class="fa fa-angle-double-right"></i> Các menu</a></li>
                    <li><a href="<?php echo get_admin_url('menu/content'); ?>"><i class="fa fa-angle-double-right"></i> Thêm menu</a></li>
                </ul>
            </li>
            <li class="treeview<?php if ($menu_admin_active == 'pages') echo ' active'; ?>">
                <a href="<?php echo get_admin_url('pages'); ?>"><i class="fa fa-file"></i> Trang tĩnh</a>
            </li>
            <li class="treeview<?php if ($menu_admin_active == 'posts') echo ' active'; ?>">
                <a href="#">
                    <i class="fa fa-edit"></i>
                    <span>Nội dung</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo get_admin_url('posts/cat'); ?>"><i class="fa fa-angle-double-right"></i> Chủ đề</a></li>
                    <li><a href="<?php echo get_admin_url('posts'); ?>"><i class="fa fa-angle-double-right"></i> Bài viết</a></li>
                </ul>
            </li>
            <li class="treeview<?php echo in_array($menu_admin_active, array('projects')) ? ' active' : ''; ?>">
                <a href="#">
                    <i class="fa fa-cubes"></i> <span>Sự kiện</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo get_admin_url('projects'); ?>"><i class="fa fa-angle-double-right"></i> Danh sách sự kiện</a></li>
                    <li><a href="<?php echo get_admin_url('projects/content'); ?>"><i class="fa fa-angle-double-right"></i> Thêm sự kiện</a></li>
                    <li><a href="<?php echo get_admin_url('projects/setting'); ?>"><i class="fa fa-angle-double-right"></i> Cài đặt sự kiện</a></li>
                </ul>
            </li>
			<li class="treeview<?php echo ($menu_admin_active == 'newsletter') ? ' active' : ''; ?>">
                <a href="<?php echo get_admin_url('newsletter'); ?>"><i class="fa fa-envelope-o"></i> Đăng ký tư vấn</a>
            </li>
            <li<?php if ($menu_admin_active == 'contact' || $menu_admin_active == 'view_contact') echo ' class="active"'; ?>>
                <a href="<?php echo get_admin_url('contact'); ?>">
                    <i class="fa fa-envelope"></i> <span>Liên hệ</span>
                    <small class="badge pull-right bg-yellow"><?php echo $num_rows_contact; ?></small>
                </a>
            </li>
            <!-- <li class="treeview<?php echo ($menu_admin_active == 'sitemap') ? ' active' : ''; ?>">
                <a href="<?php echo get_admin_url('sitemap'); ?>"><i class="fa fa-sitemap"></i> Sitemap</a>
            </li> -->
        </ul>
    </section>
</aside>
