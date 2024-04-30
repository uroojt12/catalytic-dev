<main common logon index>
    <section class="blocks cmnSec" id="email_verification">

        <div class="contain">

            <div id="verifyEmail">

                <h3>Hello! <?= format_name($mem_data->mem_fname, $mem_data->mem_lname) ?>, Welcome to our website</h3>

                <div class="blk">

                    <div class="_header">

                        <h3>Email Verification</h3>

                    </div>

                    <div id="resndCntnt">

                        <?= showMsg() ?>

                        <p>We've sent you an email to the address given for verification. Please check your email to verify and activate your account.The email can take a few minutes to arrive. Please also check your spams</p>

                        <p>

                            <a href="javascript:void(0)" id="rsnd-email" class="webBtn">Resend Email</a>

                            <!--<a href="javascript:void(0)" class="popBtn" data-popup="change-email">Change Email</a>-->

                        </p>

                    </div>

                    <div class="appLoad hide">

                        <div class="appLoader"><span class="spiner"></span></div>

                    </div>

                </div>

                <div class="popup small-popup" data-popup="change-email">

                    <div class="tableDv">

                        <div class="tableCell">

                            <div class="contain">

                                <div class="_inner">

                                    <div class="crosBtn"></div>

                                    <h3>Change your Email</h3>

                                    <form action="" method="post" autocomplete="off" class="frmAjax" id="frmChangeEmail">

                                        <div class="txtGrp">

                                            <input type="email" id="email" name="email" class="txtBox" placeholder="Email" autofocus>

                                        </div>

                                        <div class="bTn text-center">

                                            <button type="submit" class="webBtn colorBtn lgBtn">Change your Email <i class="spinner hidden"></i></button>

                                        </div>

                                        <div class="alertMsg" style="display:none"></div>

                                    </form>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

    <!-- dash -->

</main>