<!-- ==================footer-========== -->
<footer>
    <div class="contain">
        <div class="flexRow flex">
            <div class="col">
                <div class="logo">
                    <a href="index.php" style="display: block;">
                        <img src="<?= base_url() . 'uploads/images/' . $site_settings->site_logo . '?v-' . $site_settings->site_version ?>" alt="<?= $site_settings->site_name ?>">

                    </a>
                </div>
                <div class="content">
                    <p><?= $site_settings->site_about ?></p>
                </div>
            </div>
            <div class="col">
                <h4>Useful Links</h4>
                <ul class="lst">
                    <li class="<?php if ($page == "index") {
                                    echo 'active';
                                } ?>">
                        <a href="<?= base_url() ?>">Home</a>
                    </li>
                    <li class="<?php if ($page == "code") {
                                    echo 'active';
                                } ?>">
                        <a href="<?= base_url('code') ?>">Code</a>
                    </li>


                    <li class="<?php if ($page == "inventory") {
                                    echo 'active';
                                } ?>">
                        <a href="<?= base_url('inventory') ?>">Inventory</a>
                    </li>

                    <li class="<?php if ($page == "generics") {
                                    echo 'active';
                                } ?>">
                        <a href="<?= base_url('generics') ?>">Generics</a>
                    </li>

                </ul>
            </div>
            <div class="col">
                <h4>Contact info</h4>
                <ul class="infoLst">
                    <li>
                        <img src="<?= base_url() ?>assets/images/icon-map-marker.svg" alt="">
                        <a href=""><?= $site_settings->site_address ?></a>
                    </li>
                    <li>
                        <img src="<?= base_url() ?>assets/images/icon-envelope-fill-1.svg" alt="">
                        <a href="mailto:<?= $site_settings->site_email ?>"><?= $site_settings->site_email ?></a>
                    </li>
                    <li>
                        <img src="<?= base_url() ?>assets/images/icon-phone.svg" alt="">
                        <a href="tel:<?= $site_settings->site_phone ?>"><?= $site_settings->site_phone ?></a>
                    </li>
                </ul>
            </div>
            <div class="col">
                <h4>Join our mailing list</h4>
                <form action="<?= base_url('newsletter') ?>" method="post" autocomplete="off" class="frmAjax" id="" novalidate="novalidate">
                    <label for="email">Stay up to date with the latest news and deals!</label>
                    <div class="txtGrp relative">
                        <input type="email" name="email" id="email" class="txtBox" placeholder="@ your email address">
                        <button type="submit" class="style_it">Submit<i class="spinner hidden"></i></button>
                        <div class="alertMsg" style="display:none"></div>
                    </div>
                </form>
                <h5>Follow Us</h5>
                <ul class="social flex">
                    <?php
                    if (!empty($site_settings->site_facebook)) :
                    ?>
                        <li><a href="<?= $site_settings->site_facebook ?>" target="_blank"><img src="<?= base_url() ?>assets/images/social-facebook.svg" alt=""></a></li>
                    <?php
                    endif;
                    if (!empty($site_settings->site_twitter)) :
                    ?>
                        <li><a href="<?= $site_settings->site_twitter ?>" target="_blank"><img src="<?= base_url() ?>assets/images/social-twitter.svg" alt=""></a></li>
                    <?php
                    endif;
                    if (!empty($site_settings->site_instagram)) :
                    ?>
                        <li><a href="<?= $site_settings->site_instagram ?>" target="_blank"><img src="<?= base_url() ?>assets/images/social-instagram.svg" alt=""></a></li>
                    <?php
                    endif;
                    if (!empty($site_settings->site_linkedin)) :
                    ?>
                        <li><a href="<?= $site_settings->site_linkedin ?>" target="_blank"><img src="<?= base_url() ?>assets/images/social-linkedin.svg" alt=""></a></li>
                    <?php
                    endif;
                    ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="copyright relative">
        <div class="contain">
            <div class="inner">
                <p>Copyright © <?= date('Y') ?> <a href="<?= base_url() ?>" class="regular"><?= $site_settings->site_name ?></a>. <?= $site_settings->site_copyright ?></p>


            </div>
        </div>
    </div>
</footer>