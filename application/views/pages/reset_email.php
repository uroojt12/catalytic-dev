 <!DOCTYPE html>
 <html lang="en">

 <head>
     <title>Reset Email</title>
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
                             <p>Don’t worry. Just enter the email address you registered with and we’ll email you
                                 instructions to reset your password.</p>
                         </div>
                         <form action="">
                             <div class="row">
                                 <div class="col-md-12">
                                     <div class="txtGrp">
                                         <div class="icos">
                                             <img src="images/mail.png" alt="">
                                         </div>
                                         <input type="email" class="txtBox" name="email" placeholder="Your Email">
                                     </div>
                                 </div>
                                 <div class="col-md-12">
                                     <div class="cta">
                                         <button class="webBtn">Submit</button>
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