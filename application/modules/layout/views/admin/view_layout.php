<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <title><?php echo $title; ?></title>
        <link rel="icon" href="<?php echo base_url('assets/AdminLTE/favicon.ico'); ?>" />
        <link href="<?php echo base_url('assets/AdminLTE/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/AdminLTE/font-awesome-4.3.0/css/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/AdminLTE/dist/css/AdminLTE.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/AdminLTE/dist/css/skins/_all-skins.min.css'); ?>" rel="stylesheet" type="text/css" />
        <?php if(isset($plugins_css_admin) && is_array($plugins_css_admin) && !empty($plugins_css_admin)): ?>
			<?php foreach ($plugins_css_admin as $value):?>
            <link rel="stylesheet" href="<?php echo base_url() . 'assets/plugins/' . $value['folder'] . '/' . $value['name'] . '.css'; ?>" />
			<?php endforeach; ?>
        <?php endif; ?>
        <?php if(isset($modules_css) && is_array($modules_css) && !empty($modules_css)): ?>
            <?php foreach ($modules_css as $value):?>
            <link rel="stylesheet" href="<?php echo base_url() . 'assets/modules/' . $value['folder'] . '/css/' . $value['name'] . '.css'; ?>" />
            <?php endforeach; ?>
        <?php endif; ?>
        <link href="<?php echo base_url('assets/AdminLTE/style.css'); ?>" rel="stylesheet" type="text/css" />
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="skin-blue">
        <div class="wrapper">
            <?php $this->load->view('view_main_header'); ?>
            <?php $this->load->view('view_left_side'); ?>
            <?php $this->load->view('view_content_wrapper'); ?>
            <?php $this->load->view('view_main_footer'); ?>
        </div>

        <script src="<?php echo base_url('assets/AdminLTE/plugins/jQuery/jQuery-2.1.3.min.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/AdminLTE/bootstrap/js/bootstrap.min.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/AdminLTE/plugins/fastclick/fastclick.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/AdminLTE/dist/js/app.min.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/AdminLTE/dist/js/demo.js'); ?>"></script>
        <script type="text/javascript">
            base_url = '<?php echo base_url(); ?>';
            data_meta_seo = <?php echo json_encode($this->config->item('meta_seo')); ?>;
            var delay = (function () {
                var timer = 0;
                return function (callback, ms) {
                    clearTimeout(timer);
                    timer = setTimeout(callback, ms);
                };
            })();
            jQuery.each(jQuery('textarea[data-autoresize]'), function () {
                var offset = this.offsetHeight - this.clientHeight;

                var resizeTextarea = function (el) {
                    jQuery(el).css('height', 'auto').css('height', el.scrollHeight + offset);
                };
                jQuery(this).on('keyup input', function () {
                    resizeTextarea(this);
                }).removeAttr('data-autoresize');
            });
        </script>
		<script>
            if (($(window).height() + 100) < $(document).height()) {
                $('#top-link-block').removeClass('hidden').affix({
                    offset: {top: 100}
                });
            }
            function get_slug(str) {
                str = str.toLowerCase();
                str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a");
                str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e");
                str = str.replace(/ì|í|ị|ỉ|ĩ/g, "i");
                str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o");
                str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u");
                str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y");
                str = str.replace(/đ/g, "d");
                str = str.replace(/[\W_]+/g, "-"); //thay thế các kí tự không thuộc alpha characters thành -
                str = str.replace(/-+-/g, "-"); //thay thế x- thành 1-
                str = str.replace(/^\-+|\-+$/g, ""); //cắt bỏ ký tự - ở đầu và cuối chuỗi
                return str;
            }
            function render_meta_seo(el, text_max, bool = true){
                if(el.length){
                    var $this = el.closest('.form-group');
                    $this.find('label').append(' - Tối đa ' + text_max + ' ký tự');
                    $this.append('<span class="help-block"><strong class="count-characters">' + text_max + '</strong> ký tự còn lại</span>');
                    var text_length = el.val().length;
                    if(text_length > text_max){
                        $this.find('.count-characters').text(0);
                        $this.addClass('has-error');
                    }else{
                        $this.find('.count-characters').text(text_max - text_length);
                    }
                    if(bool){
                        el.attr('maxlength', text_max);
                    }
                }

            }
            $(document).ready(function () {
                $('#top-link-block').on('click', function () {
                    $('html,body').animate({scrollTop: 0}, 'slow');
                    return false;
                });

                render_meta_seo($('input[name=title_seo]'), data_meta_seo.title_seo);
                render_meta_seo($('textarea[name=keywords]'), data_meta_seo.keywords);
                render_meta_seo($('textarea[name=description]'), data_meta_seo.description);
                render_meta_seo($('input[name=h1_seo]'), data_meta_seo.h1_seo);
            });
            $(document).on('keyup blur', 'input[name=title_seo]', function() {
                var text_max = data_meta_seo.title_seo;
                var text_length = $(this).val().length;
                var text_remaining = text_max - text_length;
                var $this = $(this).closest('.form-group');
                if(text_remaining > 0){
                    $this.find('.count-characters').text(text_remaining);
                    $this.removeClass('has-error');
                }else{
                    $this.find('.count-characters').text(0);
                    $this.addClass('has-error');
                }
            });

            $(document).on('keyup blur', 'textarea[name=keywords]', function() {
                var text_max = data_meta_seo.keywords;
                var text_length = $(this).val().length;
                var text_remaining = text_max - text_length;
                var $this = $(this).closest('.form-group');
                if(text_remaining > 0){
                    $this.find('.count-characters').text(text_remaining);
                    $this.removeClass('has-error');
                }else{
                    $this.find('.count-characters').text(0);
                    $this.addClass('has-error');
                }
            });

            $(document).on('keyup blur', 'textarea[name=description]', function() {
                var text_max = data_meta_seo.description;
                var text_length = $(this).val().length;
                var text_remaining = text_max - text_length;
                var $this = $(this).closest('.form-group');
                if(text_remaining > 0){
                    $this.find('.count-characters').text(text_remaining);
                    $this.removeClass('has-error');
                }else{
                    $this.find('.count-characters').text(0);
                    $this.addClass('has-error');
                }
            });

            $(document).on('keyup blur', 'input[name=h1_seo]', function() {
                var text_max = data_meta_seo.h1_seo;
                var text_length = $(this).val().length;
                var text_remaining = text_max - text_length;
                var $this = $(this).closest('.form-group');
                if(text_remaining > 0){
                    $this.find('.count-characters').text(text_remaining);
                    $this.removeClass('has-error');
                }else{
                    $this.find('.count-characters').text(0);
                    $this.addClass('has-error');
                }
            });
        </script>
		<?php if(isset($plugins_script_admin) && is_array($plugins_script_admin) && !empty($plugins_script_admin)): ?>
			<?php foreach ($plugins_script_admin as $value):?>
            <script src="<?php echo base_url() . 'assets/plugins/' . $value['folder'] . '/' . $value['name'] . '.js'; ?>" type="text/javascript"></script>
			<?php endforeach; ?>
        <?php endif; ?>
		<?php if(isset($modules_script) && is_array($modules_script) && !empty($modules_script)): ?>
			<?php foreach ($modules_script as $value):?>
            <script src="<?php echo base_url() . 'assets/modules/' . $value['folder'] . '/js/' . $value['name'] . '.js'; ?>" type="text/javascript"></script>
			<?php endforeach; ?>
        <?php endif; ?>
    </body>
</html>