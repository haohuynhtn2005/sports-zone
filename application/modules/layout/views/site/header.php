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