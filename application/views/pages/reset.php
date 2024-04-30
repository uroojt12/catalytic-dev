 <!DOCTYPE html>
 <html lang="en">

 <head>
     <title>Reset Password</title>
     <?php include_once('includes/site-master.php') ?>
 </head>

 <body>
     <?php include_once('includes/header.php') ?>
     <main>
         <!-- ======= -->
         <section class="sec_login sec_reset">
             <div class="contain">
                 <div class="inner">
                     <div class="inside">
                         <div class="logo">
                             <img src="images/logo.svg" alt="">
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
                                             <img src="images/key.png" alt="">
                                         </div>
                                         <input type="password" class="txtBox" name="Password"
                                             placeholder="New Password">
                                         <div class="eye_ico toggle-password">
                                             <img src="images/view.png" alt="">
                                         </div>
                                     </div>
                                 </div>
                                 <div class="col-md-12">
                                     <div class="txtGrp">
                                         <div class="icos">
                                             <img src="images/key.png" alt="">
                                         </div>
                                         <input type="password" class="txtBox" name="Password"
                                             placeholder="Confirm Password">
                                         <div class="eye_ico toggle-password">
                                             <img src="images/view.png" alt="">
                                         </div>
                                     </div>
                                 </div>
                                 <div class="col-md-12">
                                     <div class="cta">
                                         <button class="webBtn">Reset Password</button>
                                     </div>
                                 </div>
                             </div>
                         </form>


                     </div>
                 </div>
             </div>
         </section>
     </main>

     <?php include_once('includes/commonjs.php') ?>
     <?php include_once('includes/footer.php') ?>
 </body>

 </html>