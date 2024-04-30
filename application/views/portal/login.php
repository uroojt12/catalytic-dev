<!DOCTYPE html>

<html lang="en">

<?php $this->load->view(SUBADMIN . "/includes/common-header"); ?>

<body class="page-body login-page login-form-fall">

    <div class="login-container">

        <div class="login-header login-caret">

            <div class="login-content">

                <a href="<?= base_url(SUBADMIN) ?>" class="logo">

                    <img src="<?= !empty($adminsite_setting->site_logo) ? get_site_image_src("images", $adminsite_setting->site_logo) : 'http://placehold.it/3000x1000' ?>" height="50" alt="">

                </a>
                <h1>SubAdmin Portal</h1>
                <p class="description">Dear user, log in to access the subadmin area!</p>

                <!-- progress bar indicator -->

                <div class="login-progressbar-indicator">

                    <h3>43%</h3>

                    <span>logging in...</span>

                </div>

            </div>

        </div>

        <div class="login-progressbar">

            <div></div>

        </div>



        <div class="login-form">

            <div class="login-content">

                <div class="form-login-error">

                    <h3>Authentication Error</h3>

                    <p>Username and Password my be wrong!</p>

                </div>

                <form method="post" role="form" id="form_login">

                    <div class="form-group">

                        <div class="input-group">

                            <div class="input-group-addon">

                                <i class="entypo-user"></i>

                            </div>

                            <input type="text" class="form-control" name="username" id="username" placeholder="Username" autocomplete="off" />

                        </div>

                    </div>

                    <div class="form-group">

                        <div class="input-group">

                            <div class="input-group-addon">

                                <i class="entypo-key"></i>

                            </div>

                            <input type="password" class="form-control" name="password" id="password" placeholder="Password" autocomplete="off" />

                        </div>

                    </div>

                    <div class="form-group">

                        <button type="submit" class="btn btn-primary btn-block btn-login">

                            <i class="entypo-login"></i>

                            Login In

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

    <script type="text/javascript">
        var baseurl = '<?= base_url(SUBADMIN) ?>';
    </script>

    <?php $this->load->view(SUBADMIN . "/includes/footer-jsfiles"); ?>

</body>

</html>