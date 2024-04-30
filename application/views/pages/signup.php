<main>
    <!-- ======= -->
    <section class="sec_login sec_sign_up">
        <div class="contain">
            <div class="inner">
                <div class="inside">
                    <div class="logo">
                        <img src="<?= base_url() . 'uploads/images/' . $site_settings->site_logo . '?v-' . $site_settings->site_version ?>" alt="<?= $site_settings->site_name ?>">
                    </div>

                    <div class="up_cntent">
                        <h3>Let’s Get Started</h3>
                        <p>Register and Explore Limitless Opportunities</p>
                    </div>
                    <form action="<?= base_url('register/signup') ?>" method="POST" id="frmSignin" class="frmAjax" autocomplete="off">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="txtGrp">
                                    <div class="icos">
                                        <img src="<?= base_url() ?>assets/images/user.png" alt="">
                                    </div>
                                    <input type="text" class="txtBox" name="fname" placeholder="First Name">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="txtGrp">
                                    <div class="icos">
                                        <img src="<?= base_url() ?>assets/images/user.png" alt="">
                                    </div>
                                    <input type="text" class="txtBox" name="lname" placeholder="Last Name">
                                </div>
                            </div>
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
                                <div class="txtGrp">
                                    <div class="icos">
                                        <img src="<?= base_url() ?>assets/images/key.png" alt="">
                                    </div>
                                    <input type="password" class="txtBox" name="cpswd" placeholder="Confirm Password" id="password">
                                    <div class="eye_ico toggle-password">
                                        <img src="<?= base_url() ?>assets/images/view.png" alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="cta">
                                    <button class="webBtn">Sign Up<i class="spinner hidden"></i></button>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="new_link">
                                    <p>Already have an account? <a href="<?= base_url('login') ?>">Sign In</a></p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>