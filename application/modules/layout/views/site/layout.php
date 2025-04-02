<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="<?php echo html_escape($description); ?>" />
    <meta name="keywords" content="<?php echo html_escape($keywords); ?>" />
    <meta property="og:site_name" content="<?php echo html_escape($site_name); ?>" />
    <meta property="og:type" content="Website" />
    <meta property="og:title" content="<?php echo html_escape($title_seo); ?>" />
    <meta property="og:url" content="<?php echo current_full_url(); ?>" />
    <meta property="og:description" content="<?php echo html_escape($description); ?>" />
    <meta property="og:image" content="<?php echo $image; ?>" />
    <meta property="fb:app_id" content="<?php echo $this->config->item('app_id', 'facebook'); ?>" />
    <!-- google -->
    <meta itemprop="name" content="<?php echo html_escape($site_name); ?>">
    <meta itemprop="description" content="<?php echo html_escape($description); ?>">
    <meta itemprop="image" content="<?php echo $image; ?>">
    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="<?php echo html_escape($site_name); ?>">
    <meta name="twitter:title" content="<?php echo html_escape($title_seo); ?>">
    <meta name="twitter:description" content="<?php echo html_escape($description); ?>">
    <meta name="twitter:creator" content="@author_handle">
    <meta name="twitter:image:src" content="<?php echo $image; ?>">
    <title><?php echo $title; ?></title>
    <link rel="icon" href="<?php echo base_url(get_module_path('logo') . $favicon); ?>" type="image/x-icon">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/" rel="preconnect">
    <link href="https://fonts.gstatic.com/" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&amp;family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap"
        rel="stylesheet">
    <!-- Plugins CSS Files -->
    <link href="<?php echo base_url('assets/plugins/aos/aos.css'); ?>" rel="stylesheet" >
    <link href="<?php echo base_url('assets/plugins/bootstrap-5.3/css/bootstrap.min.css'); ?>" rel="stylesheet" >
    <link href="<?php echo base_url('assets/plugins/bootstrap-icons/bootstrap-icons.css'); ?>" rel="stylesheet" >
    <link href="<?php echo base_url('assets/plugins/glightbox/css/glightbox.min.css'); ?>" rel="stylesheet" >
    <link href="<?php echo base_url('assets/plugins/swiper/swiper-bundle.min.css'); ?>" rel="stylesheet" >
    <!-- Main CSS File -->
    <link rel="stylesheet" href="<?php echo get_asset('css_path'); ?>main.css" />
</head>

<body class="<?= base_url() == current_url() ? 'index-page' : '' ?>">
    <!-- <script>
        window.fbAsyncInit = function() {
            FB.init({
              appId      : '<?php echo $this->config->item('app_id', 'facebook'); ?>',
              xfbml      : true,
              version    : 'v2.11'
            });
        };
    </script>
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.11";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script> -->
    <!-- <div class="page-loader bg-white">
        <div class="v-center">
            <div class="loader-square bg-colored"></div>
        </div>
    </div> -->
    <?php $this->load->view('header'); ?>
    <?php $this->load->view($main_content); ?>
    <?php $this->load->view('footer'); ?>

    <!-- Plugins JS Files -->
    <script data-cfasync="false"
        src="<?php echo base_url('assets/plugins/cloudflare-static/email-decode.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/bootstrap-5.3/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/php-email-form/validate.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/aos/aos.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/glightbox/js/glightbox.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/purecounter/purecounter_vanilla.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/imagesloaded/imagesloaded.pkgd.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/isotope-layout/isotope.pkgd.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/swiper/swiper-bundle.min.js'); ?>"></script>
    <!-- Main JS File -->
    <script src="<?php echo get_asset('js_path'); ?>main.js"></script>

    <!-- <script type="text/javascript">
        base_url = '<?php echo base_url(); ?>';
    </script>
    <script type="text/javascript" src="<?php echo get_asset('js_path'); ?>jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo get_asset('js_path'); ?>newsletter.js"></script>
    <script type="text/javascript" src="<?php echo get_asset('js_path'); ?>scripts.js"></script>
    <script type="text/javascript" src="<?php echo get_asset('js_path'); ?>plugins.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        if ($(window).width() < 768) {
            $('img').each(function() {
                $(this).removeAttr('style');
            });
        }
    });
    </script> -->
</body>
</html>