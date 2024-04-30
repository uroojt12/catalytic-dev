 <!DOCTYPE html>
 <html lang="en">

 <head>
     <title>Home</title>
     <?php include_once('../includes/site-master.php') ?>
 </head>

 <body>
     <?php include_once('../includes/header_2.php') ?>
     <main>
         <section class="inventory_new marin_page">
             <div class="contain">
                 <div class="inner">
                     <h3>Adjust Your Margin</h3>
                     <h5>Use the slider below to set your profit margin.</h5>
                     <p>A 10% margin displays the value 10% lower than the original price</p>
                     <div class="txtGrp">
                         <label for="">Item Fullness %</label>
                         <div class="inner_block">
                             <div class="first_value">
                                 <p>0</p>
                             </div>
                             <div class="example"></div>
                             <div class="last_value">
                                 <p>100</p>
                             </div>
                         </div>
                     </div>
                     <div class="margin_percentage">
                         <h3>0%</h3>
                         <p>Margin Percentage</p>
                     </div>
                     <div class="cta">
                         <a href="" class="webBtn">Save</a>
                     </div>
                 </div>
             </div>
         </section>
     </main>

     <?php include_once('../includes/commonjs.php') ?>
     <?php include_once('../includes/footer.php') ?>
 </body>

 </html>