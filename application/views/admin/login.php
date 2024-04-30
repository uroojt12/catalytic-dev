<!DOCTYPE html>

<html lang="en">

    <?php $this->load->view(ADMIN."/includes/common-header"); ?>

    <body class="page-body login-page login-form-fall" >

        <div class="login-container">

            <div class="login-header login-caret">

                <div class="login-content">

                    <a href="#" class="logo">

                        <img src="<?= base_url().SITE_IMAGES.'images/'.$adminsite_setting->site_logo ?>" height="50" alt="">

                    </a>

                    <p class="description">Dear user, log in to access the admin area!</p>

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

                    <form method="post" role="form" id="form_login" >

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

                                Log In

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

        <script type="text/javascript">

            var baseurl = '<?= base_url(ADMIN) ?>';

        </script>

        <?php $this->load->view(ADMIN."/includes/footer-jsfiles"); ?>

    </body>

</html>