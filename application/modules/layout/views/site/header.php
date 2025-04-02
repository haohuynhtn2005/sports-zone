<header id="header" class="header d-flex align-items-center fixed-top1">
  <div
    class="container-fluid container-xl position-relative d-flex align-items-center">
    <a href="<?php echo site_url(); ?>"
      class="logo d-flex align-items-center me-auto">
      <h1 class="sitename">
        <?= $site_name ?>
      </h1>
    </a>

    <nav id="navmenu" class="navmenu">
      <ul>
        <?php echo isset($html_menu_main) ? $html_menu_main : ''; ?>
      </ul>
      <i class="mobile-nav-toggle d-xl-none bi bi-list text-body"></i>
    </nav>

    <a class="btn-getstarted flex-md-shrink-0" href="tel:<?= isset(
        $info_hotline_none['content']
    )
        ? str_replace('.', '', strip_tags($info_hotline_none['content']))
        : '' ?>">
      <i class="fa fa-phone"></i>
      <?= isset($info_hotline_none['content'])
          ? strip_tags($info_hotline_none['content'])
          : '' ?>
    </a>
  </div>
</header>

<!-- Scroll Top -->
<a href="#" id="scroll-top"
  class="scroll-top d-flex align-items-center justify-content-center">
  <i class="bi bi-arrow-up-short"></i>
</a>