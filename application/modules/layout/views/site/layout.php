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
    <title><?php echo $title_seo; ?></title>
    <link rel="icon" href="<?php echo base_url(get_module_path('logo') . $favicon); ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo get_asset('css_path'); ?>plugins.css" />
    <link rel="stylesheet" href="<?php echo get_asset('css_path'); ?>wdag.css" />
    <link rel="stylesheet" href="<?php echo get_asset('css_path'); ?>custom.css" />
    <script type="text/javascript">
        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                    m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
        ga('create', '<?php echo $analytics_UA_code; ?>', 'auto');
        ga('send', 'pageview');
    </script>
</head>

<body>
    <script>
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
    }(document, 'script', 'facebook-jssdk'));</script>
    <!-- <div class="page-loader bg-white">
        <div class="v-center">
            <div class="loader-square bg-colored"></div>
        </div>
    </div> -->
    <?php $this->load->view('header'); ?>
    <?php $this->load->view($main_content); ?>
    <?php $this->load->view('footer'); ?>
    <script type="text/javascript">
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
    </script>
</body>
</html>