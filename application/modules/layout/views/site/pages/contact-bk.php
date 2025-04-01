<article>
        <section>
            <div class="box-contact">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12">
                                    <div class="block-contact-information">
                                        <ul>
                                            <li>
                                                <span class="icon--border"><i
                                                        class="fas fa-map-marker-alt"></i></span><?php echo isset($info_address_none['content']) ? $info_address_none['content'] : ''; ?>
                                            </li>
                                            <li>
                                                <span><i class="fas fa-mobile-alt"></i></span><?php echo isset($info_hotline_none['content']) ? $info_hotline_none['content'] : ''; ?>
                                            </li>
                                            <li>
                                                <span><i class="far fa-envelope"></i></span><?php echo isset($info_email_none['content']) ? $info_email_none['content'] : ''; ?>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12">
                                    <div class="block-contact-form">
										<h3>Liên hệ với chúng tôi</h3>
										<?php $this->load->view('layout/notify'); ?>
                                        <form action="<?php echo site_url('lien-he'); ?>" method="post">
                                            <div class="row">
                                                <div class="form-group col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                                    <input type="text" id="full_name" name="full_name" class="form-control input--field"
                                                        placeholder="Họ và tên">
                                                </div>
                                                <div class="form-group col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                                    <input type="email" id="email" name="email" class="form-control input--field"
                                                        placeholder="Email">
                                                </div>
                                                <div class="form-group col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                                    <textarea name="message" id="message"  class="form-control area--field" rows="3"
                                                        placeholder="Nhập nội dung"></textarea>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn--submit">Gửi liên hệ</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12">
                            <div class="box-maps">
                                <div class="embed-responsive embed-responsive-4by3">
									<?php echo isset($iframe_map) ? $iframe_map : ''; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </article>
