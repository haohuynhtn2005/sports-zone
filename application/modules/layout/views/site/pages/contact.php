<section id="boxes" class="sm-my ">
    <div class="container-sm">
        <div class="t-center row">
            <div class="col-sm-12 col-xs-12 sm-mt-mobile">
                <div data-toggle="modal" data-target="#modal1" class="c-pointer bg-gray1-hover border-1 border-gray2 slow sm-py click-effect dark-effect block">
                    <div class="inline-block">
                        <i class="icon-home text-lg2"></i>
                    </div>
                    <h3 class="xxs-mt uppercase fjalla"><?php echo isset($info_address['company']) ? $info_address['company'] : ''; ?></h3>
                    <p class="bold-subtitle lh-sm xxs-mt"><?php echo isset($info_address['address']) ? $info_address['address'] : ''; ?></p>
                    <a href="mailto:<?php echo isset($info_address['email']) ? $info_address['email'] : ''; ?>" class="bold-subtitle underline-hover xxs-mt block"><?php echo isset($info_address['email']) ? $info_address['email'] : ''; ?></a>
                    <h2 class="bold-subtitle underline-hover mini-mt block colored"><?php echo isset($info_address['phone']) ? $info_address['phone'] : ''; ?></h2>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="divider-1 font-14 dark uppercase container-sm extrabold sm-mt">
    <span>Liên hệ với chúng tôi</span>
</div>
<section id="contact" class="sm-mt">
    <div class="t-center contact container-sm contact-type-1 no-pt font-15 fjalla">
        <?php $this->load->view('layout/notify'); ?>
        <form id="contact_form" name="contact_form" method="post" action="<?php echo current_url(); ?>">
            <span class="border-effect">
                <input type="text" name="full_name" id="name" required placeholder="Họ và tên" class="no-mt">
                <span class="left-br"></span>
                <span class="right-br"></span>
                <span class="top-br"></span>
            </span>
            <span class="border-effect sm-mt">
                <input type="email" name="email" id="email" required placeholder="Email">
                <span class="left-br"></span>
                <span class="right-br"></span>
                <span class="top-br"></span>
            </span>
            <span class="border-effect sm-mt">
                <input type="text" name="subject" id="subject" required placeholder="Chủ đề">
                <span class="left-br"></span>
                <span class="right-br"></span>
                <span class="top-br"></span>
            </span>
            <span class="border-effect sm-mt">
                <textarea name="message" id="message" required placeholder="Thông tin yêu cầu" class="lg"></textarea>
                <span class="left-br"></span>
                <span class="right-br"></span>
                <span class="top-br"></span>
            </span>
            <span class="border-effect sm-mt">
                <input type="text" name="verify" id="verify" required placeholder="">
                <span class="left-br"></span>
                <span class="right-br"></span>
                <span class="top-br"></span>
            </span>
            <button type="submit" id="submit" class="xl-btn bg-colored underline-hover white radius font-12 bold bs-hover click-effect">GỬI THÔNG TIN</button>
        </form>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="box-maps">
                    <div class="embed-responsive embed-responsive-4by3">
                        <?php echo isset($iframe_map) ? $iframe_map : ''; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $this->load->view('block-slogun'); ?>