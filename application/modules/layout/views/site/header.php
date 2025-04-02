<header id="header" class="header d-flex align-items-center fixed-top1">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

        <a href="index.html" class="logo d-flex align-items-center me-auto">
            <!-- Uncomment the line below if you also wish to use an image logo -->

            <h1 class="sitename">Sports Zone</h1>
        </a>

        <nav id="navmenu" class="navmenu">
            <ul>
                <?php echo isset($html_menu_main) ? $html_menu_main : ''; ?>

                <!-- <li><a href="blog-details.html" class="active">Giới thiệu<br></a></li>

                <li class="dropdown"><a href="#"><span>Giải đấu</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                    <ul>
                        <li><a href="blog-details.html">Bóng đá</a></li>

                        <li><a href="blog-details.html">Chạy bộ</a></li>
                        <li><a href="blog-details.html">Khác</a></li>

                    </ul>
                </li>
                <li><a href="blog-details.html">Đăng ký tổ chức</a></li>
                <li><a href="blog.html">Tin tức</a></li>
                <li><a href="contact.html">Liên hệ</a></li> -->
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

        <a class="btn-getstarted flex-md-shrink-0" href="tel:<?php echo isset($info_hotline_none['content']) ? str_replace('.', '', strip_tags($info_hotline_none['content'])) : ''; ?>">
            <i class="fa fa-phone"></i> <?php echo isset($info_hotline_none['content']) ? strip_tags($info_hotline_none['content']) : ''; ?>
        </a>

    </div>
</header>
<nav id="navigation" class="white-nav shrink sticky hide-by-scroll modern" data-offset="0">
    <div class="columns container clearfix">
        <div class="logo">
            <a href="<?php echo site_url(); ?>">
                <img src="<?php echo base_url(get_module_path('logo') . $site_logo); ?>" width="150" alt="<?php echo isset($site_name) ? $site_name : ''; ?>" data-second-logo="<?php echo base_url(get_module_path('logo') . $site_logo); ?>">
            </a>
        </div>
        <div class="nav-elements">
            <ul class="clearfix nav no-ls normal">
                <li>
                    <a href="tel:<?php echo isset($info_hotline_none['content']) ? str_replace('.', '', strip_tags($info_hotline_none['content'])) : ''; ?>" class="external-btn bg-colored underline-hover white radius font-15 bold bs-hover click-effect"><i class="fa fa-phone"></i> <?php echo isset($info_hotline_none['content']) ? strip_tags($info_hotline_none['content']) : ''; ?></a>
                </li>
            </ul>
        </div>
        <div class="nav-menu">
            <ul class="nav clearfix uppercase">
                <?php echo isset($html_menu_main) ? $html_menu_main : ''; ?>
            </ul>
        </div>
    </div>
</nav>