<main>
    <!-- ======= -->
    <section class="sec_login">
        <div class="contain">
            <div class="inner">
                <div class="inside">
                    <div class="logo">
                        <img src="<?= base_url() . 'uploads/images/' . $site_settings->site_logo . '?v-' . $site_settings->site_version ?>" alt="<?= $site_settings->site_name ?>">
                    </div>
                    <div class="up_cntent">
                        <h3><?= $site_content['sec_heading'] ?></h3>
                        <p><?= $site_content['sec_tagline'] ?></p>
                    </div>
                    <form action="<?= base_url('register/signin') ?>" method="POST" class="frmAjax">
                        <div class="row">

                            <div class="col-md-12">
                                <div class="txtGrp">
                                    <div class="icos">
                                        <img src="<?= base_url() ?>assets/images/mail.png" alt="">
                                    </div>
                                    <input type="email" class="txtBox" name="email" placeholder="Your Email">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="txtGrp">
                                    <div class="icos">
                                        <img src="<?= base_url() ?>assets/images/key.png" alt="">
                                    </div>
                                    <input type="password" class="txtBox" name="password" placeholder="Your Password" id="password">
                                    <div class="eye_ico toggle-password">
                                        <img src="<?= base_url() ?>assets/images/view.png" alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="txtGrp text-right">
                                    <p><a href="<?= base_url('forgot-password') ?>">Forget Password</a></p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="cta">
                                    <button class="webBtn">Sign In<i class="spinner hidden"></i></button>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="new_link">
                                    <p>Don’t have an account? <a href="<?= base_url('signup') ?>">Sign up</a></p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>