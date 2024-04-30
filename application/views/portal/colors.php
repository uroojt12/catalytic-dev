<?php echo showMsg(); ?>
<?php echo getBredcrum(SUBADMIN, array('#' => 'Site Colors')); ?>
<div class="row margin-bottom-10">
    <div class="col-md-6">
        <!-- <h2 class="no-margin"><i class="entypo-window"></i> Update <strong>About Page</strong></h2> -->
        <h2 class="no-margin"><i class="fa fa-cogs"></i> Site <strong>Colors</strong></h2>
    </div>

</div>
<hr>
<div class="row col-md-12">
    <form role="form" class="form-horizontal" action="<?= base_url(SUBADMIN) ?>/colors/save" method="post" enctype="multipart/form-data">


        <div class="form-group">

            <div class="col-md-12">
                <div class="form-group">
                    <div class="col-md-2">
                        <label for="primary_color" class="control-label">primary_color <span class="symbol required">*</span></label>
                        <input type="color" name="primary_color" value="<?php if (isset($row->primary_color)) echo $row->primary_color; ?>" class="form-control" style="height: 60px;" required>
                    </div>
                    <div class="col-md-2">
                        <label for="secondary_color" class="control-label">secondary_color <span class="symbol required">*</span></label>
                        <input type="color" name="secondary_color" value="<?php if (isset($row->secondary_color)) echo $row->secondary_color; ?>" class="form-control" style="height: 60px;" required>
                    </div>
                    <div class="col-md-2">
                        <label for="teritary_color" class="control-label">teritary_color <span class="symbol required">*</span></label>
                        <input type="color" name="teritary_color" value="<?php if (isset($row->teritary_color)) echo $row->teritary_color; ?>" class="form-control" style="height: 60px;" required>
                    </div>
                    <div class="col-md-2">
                        <label for="dark_bg" class="control-label">dark_bg <span class="symbol required">*</span></label>
                        <input type="color" name="dark_bg" value="<?php if (isset($row->dark_bg)) echo $row->dark_bg; ?>" class="form-control" style="height: 60px;" required>
                    </div>
                    <div class="col-md-2">
                        <label for="light_color" class="control-label">light_color <span class="symbol required">*</span></label>
                        <input type="color" name="light_color" value="<?php if (isset($row->light_color)) echo $row->light_color; ?>" class="form-control" style="height: 60px;" required>
                    </div>
                    <div class="col-md-2">
                        <label for="section_bg" class="control-label">section_bg <span class="symbol required">*</span></label>
                        <input type="color" name="section_bg" value="<?php if (isset($row->section_bg)) echo $row->section_bg; ?>" class="form-control" style="height: 60px;" required>
                    </div>


                    <div class="clearfix"></div>

                    <div class="col-md-2">
                        <label for="p_color" class="control-label">p_color <span class="symbol required">*</span></label>
                        <input type="color" name="p_color" value="<?php if (isset($row->p_color)) echo $row->p_color; ?>" class="form-control" style="height: 60px;" required>
                    </div>
                    <div class="col-md-2">
                        <label for="dark_a" class="control-label">dark_a <span class="symbol required">*</span></label>
                        <input type="color" name="dark_a" value="<?php if (isset($row->dark_a)) echo $row->dark_a; ?>" class="form-control" style="height: 60px;" required>
                    </div>
                    <div class="col-md-2">
                        <label for="testi_linear_1" class="control-label">testi_linear_1 <span class="symbol required">*</span></label>
                        <input type="color" name="testi_linear_1" value="<?php if (isset($row->testi_linear_1)) echo $row->testi_linear_1; ?>" class="form-control" style="height: 60px;" required>
                    </div>
                    <div class="col-md-2">
                        <label for="testi_linear_2" class="control-label">testi_linear_2 <span class="symbol required">*</span></label>
                        <input type="color" name="testi_linear_2" value="<?php if (isset($row->testi_linear_2)) echo $row->testi_linear_2; ?>" class="form-control" style="height: 60px;" required>
                    </div>
                    <div class="col-md-2">
                        <label for="section_linear_1" class="control-label">section_linear_1 <span class="symbol required">*</span></label>
                        <input type="color" name="section_linear_1" value="<?php if (isset($row->section_linear_1)) echo $row->section_linear_1; ?>" class="form-control" style="height: 60px;" required>
                    </div>
                    <div class="col-md-2">
                        <label for="textbox_bg" class="control-label">textbox_bg <span class="symbol required">*</span></label>
                        <input type="color" name="textbox_bg" value="<?php if (isset($row->textbox_bg)) echo $row->textbox_bg; ?>" class="form-control" style="height: 60px;" required>
                    </div>
                    <div class="clearfix"></div>


                    <div class="col-md-2">
                        <label for="textbox_border" class="control-label">textbox_border <span class="symbol required">*</span></label>
                        <input type="color" name="textbox_border" value="<?php if (isset($row->textbox_border)) echo $row->textbox_border; ?>" class="form-control" style="height: 60px;" required>
                    </div>
                    <div class="col-md-2">
                        <label for="light_btn_bg" class="control-label">light_btn_bg <span class="symbol required">*</span></label>
                        <input type="color" name="light_btn_bg" value="<?php if (isset($row->light_btn_bg)) echo $row->light_btn_bg; ?>" class="form-control" style="height: 60px;" required>
                    </div>
                    <div class="col-md-2">
                        <label for="readBtn_bg" class="control-label">readBtn_bg <span class="symbol required">*</span></label>
                        <input type="color" name="readBtn_bg" value="<?php if (isset($row->readBtn_bg)) echo $row->readBtn_bg; ?>" class="form-control" style="height: 60px;" required>
                    </div>
                    <div class="col-md-2">
                        <label for="dropdown_bg" class="control-label">dropdown_bg <span class="symbol required">*</span></label>
                        <input type="color" name="dropdown_bg" value="<?php if (isset($row->dropdown_bg)) echo $row->dropdown_bg; ?>" class="form-control" style="height: 60px;" required>
                    </div>
                    <div class="col-md-2">
                        <label for="inner_bg" class="control-label">inner_bg <span class="symbol required">*</span></label>
                        <input type="color" name="inner_bg" value="<?php if (isset($row->inner_bg)) echo $row->inner_bg; ?>" class="form-control" style="height: 60px;" required>
                    </div>
                    <div class="col-md-2">
                        <label for="qty_bg" class="control-label">qty_bg <span class="symbol required">*</span></label>
                        <input type="color" name="qty_bg" value="<?php if (isset($row->qty_bg)) echo $row->qty_bg; ?>" class="form-control" style="height: 60px;" required>
                    </div>
                    <div class="clearfix"></div>

                    <div class="col-md-2">
                        <label for="dark_color" class="control-label">dark_color <span class="symbol required">*</span></label>
                        <input type="color" name="dark_color" value="<?php if (isset($row->dark_color)) echo $row->dark_color; ?>" class="form-control" style="height: 60px;" required>
                    </div>

                    <br>

                </div>
            </div>

            <div class="clearfix"></div>

        </div>



        <div class="clearfix"></div>
        <div class="col-md-12">
            <hr class="hr-short">
            <div class="form-group text-right">
                <div class="col-md-12">
                    <input type="submit" class="btn btn-green btn-lg" value="Update Colors">
                </div>
            </div>
        </div>
        <br><br>
    </form>
</div>