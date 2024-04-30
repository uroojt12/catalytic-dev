<main>
    <!-- ======= -->
    <section class="sec_login sec_reset">
        <div class="contain">
            <div class="inner">
                <div class="inside">
                    <div class="logo">
                        <img src="<?= base_url() . 'uploads/images/' . $site_settings->site_logo . '?v-' . $site_settings->site_version ?>" alt="<?= $site_settings->site_name ?>">
                    </div>

                    <div class="up_cntent">
                        <h3><?= $site_content['sec_heading'] ?></h3>
                        <p><?= $site_content['sec_tagline'] ?>.</p>
                    </div>
                    <form action="<?= base_url('forgot-pass') ?>" method="POST" id="frmSignin" class="frmAjax">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="txtGrp">
                                    <div class="icos">
                                        <img src="<?= base_url() ?>assets/images/mail.png" alt="">
                                    </div>
                                    <input class="txtBox" type="email" name="email" id="email" placeholder="Your Email">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="cta">
                                    <button class="webBtn"><?= $site_content['submit_text'] ?><i class="spinner hidden"></i></button>
                                </div>
                            </div>


                    </form>
                </div>
            </div>
        </div>
    </section>
</main>