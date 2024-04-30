 <!DOCTYPE html>
 <html lang="en">

 <head>
     <title>Change Password</title>
     <?php include_once('../includes/site-master.php') ?>
 </head>

 <body>
     <?php include_once('../includes/header_2.php') ?>
     <main>
         <!-- ======= -->
         <section class="sec_login sec_reset change_pass">
             <div class="contain">
                 <div class="inner">
                     <div class="inside">
                         <div class="logo">
                             <img src="<?=$baseurl?>/images/logo.svg" alt="">
                         </div>

                         <div class="up_cntent">
                             <h3>Reset your password here!</h3>
                             <p>Reset Your Password for Account Access</p>
                         </div>
                         <form action="">
                             <div class="row">
                                 <div class="col-md-12">
                                     <div class="txtGrp">
                                         <div class="icos">
                                             <img src="<?=$baseurl?>/images/key.png" alt="">
                                         </div>
                                         <input type="Password" class="txtBox" name="Password"
                                             placeholder="Old password" id="password1">
                                         <div class="eye_ico toggle-pass" data-icon="view"></div>
                                     </div>
                                 </div>
                                 <div class="col-md-12">
                                     <div class="txtGrp">
                                         <div class="icos">
                                             <img src="<?=$baseurl?>/images/key.png" alt="">
                                         </div>
                                         <input type="Password" class="txtBox" name="Password2"
                                             placeholder="New Password" id="password">
                                         <div class="eye_ico toggle-pass" data-icon="view"></div>
                                     </div>
                                 </div>
                                 <div class="col-md-12">
                                     <div class="txtGrp">
                                         <div class="icos">
                                             <img src="<?=$baseurl?>/images/key.png" alt="">
                                         </div>
                                         <input type="Password" class="txtBox" name="Password"
                                             placeholder="Confirm Password" id="password3">
                                         <div class="eye_ico toggle-pass" data-icon="view"></div>
                                     </div>
                                 </div>
                                 <div class="col-md-12">
                                     <div class="cta">
                                         <button class="webBtn">Reset Password</button>
                                     </div>
                                 </div>


                         </form>
                     </div>
                 </div>
             </div>
         </section>
     </main>

     <?php include_once('../includes/commonjs.php') ?>
     <?php include_once('../includes/footer.php') ?>
 </body>

 </html>