<!DOCTYPE html>

<html lang="en">

    <?php $this->load->view(ADMIN."/includes/common-header"); ?>

    <body class="page-body login-page login-form-fall">

        <!-- This is needed when you send requests via Ajax -->

        <script type="text/javascript">

            var baseurl = '<?= base_url() ?>';

        </script>

        <div class="login-container">

            <div class="login-header login-caret">

                <div class="login-content">

                    <a href="#" class="logo">

                    <img src="<?= base_url().SITE_IMAGES.'images/'.$adminsite_setting->site_logo ?>" height="50" alt="">

                      <h3 style="color:#fff">Change Password</h3>

                    </a>

<!--                    <p class="description">Dear user, log in to access the admin area!</p>-->

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

                    <div id="msg" class="form-login-error">

                        <h3></h3>

                        <p class="text_msg"></p>

                    </div>

                    <form method="post" role="form" id="form_reset" >

                        <div class="form-group">

                            <div class="input-group">

                                <div class="input-group-addon">

                                    <i class="entypo-key"></i>

                                </div>

                                <input type="password" class="form-control" name="opwd" id="opwd" placeholder="old password" autocomplete="off" required  autofocus="" />

                            </div>

                        </div>

                        <div class="form-group">

                            <div class="input-group">

                                <div class="input-group-addon">

                                    <i class="entypo-key"></i>

                                </div>

                                <input type="password" class="form-control" name="npwd" id="npwd" placeholder="password" autocomplete="off"  required/>

                            </div>

                        </div>

                        <div class="form-group">

                            <div class="input-group">

                                <div class="input-group-addon">

                                    <i class="entypo-key"></i>

                                </div>

                                <input type="password" class="form-control" name="cpwd" id="cpwd" placeholder="confirm password" autocomplete="off"  required/>

                            </div>

                        </div>           

                        <div class="form-group">

                            <button type="submit" name="cmd" value="change" class="btn btn-primary btn-block btn-login">

                                <i class="entypo-login"></i>

                                Change Now

                            </button>

                        </div>

                    </form>

                    <div class="login-bottom-links">

                        <a href="<?=base_url(ADMIN)?>/dashboard" class="link">Return To Admin Panel?</a>

                        <br />

<!--                        <a href="#">ToS</a>  - <a href="#">Privacy Policy</a>-->

                    </div>

                </div>



            </div>

        </div>

        <?php $this->load->view(ADMIN."/includes/footer-jsfiles"); ?>

    </body>

</html>