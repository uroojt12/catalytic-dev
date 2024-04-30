<?php echo getBredcrum(ADMIN, array('#' => 'Contact Us')); ?>
<?php echo showMsg(); ?>
<div class="row margin-bottom-10">
    <div class="col-md-6">
        <h2 class="no-margin"><i class="entypo-window"></i> Update <strong>Contact Us</strong></h2>
    </div>
    <div class="col-md-6 text-right">
        <!--        <a href="<?php echo base_url('admin/services'); ?>" class="btn btn-lg btn-default"><i class="fa fa-arrow-left"></i> Cancel</a>-->
    </div>
</div>
<div>
    <hr>
    <div class="clearfix"></div>
    <div class="panel-body">
    <form role="form" method="post" class="form-horizontal form-groups-bordered validate" novalidate="novalidate" enctype="multipart/form-data">
            

            <h3>Main Section </h3>
            <div class="form-group">
                <div class="col-md-12">
                    <div class="form-group">

                        <div class="col-md-12">
                            <label for="heading" class="control-label"> Heading <span class="symbol required">*</span></label>
                            <input type="text" name="heading" value="<?= $row['heading'] ?>" class="form-control" required>
                        </div>

                                                <div class="clearfix"></div>

                            </div>
                </div>
            </div>

            <h3>Left Section</h3>
            <div class="form-group">
                <div class="col-md-12">
                    <div class="form-group">

                        <div class="col-md-12">
                            <label for="sec4_heading" class="control-label"> Heading <span class="symbol required">*</span></label>
                            <input type="text" name="sec4_heading" value="<?= $row['sec4_heading'] ?>" class="form-control" required>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-md-12">
                            <label for="sec4_detail" class="control-label"> Text Block <span class="symbol required">*</span></label>
                            <textarea name="sec4_detail" rows="3" class="form-control ckeditor" id="editor"><?= $row['sec4_detail'] ?></textarea>
                        </div>

                        

                    </div>
                </div>
            </div>

            <h3>Contact Form Section</h3>
            <div class="form-group">
                <div class="col-md-12">
                    <div class="form-group">

                        <div class="col-md-6">
                            <label for="form_heading" class="control-label"> Form Heading <span class="symbol required">*</span></label>
                            <input type="text" name="form_heading" value="<?= $row['form_heading'] ?>" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label for="form_btn" class="control-label"> Button Text <span class="symbol required">*</span></label>
                            <input type="text" name="form_btn" value="<?= $row['form_btn'] ?>" class="form-control" required>
                        </div>

                    </div>
                </div>
            </div>


            <div class="form-group">
                <label for="field-1" class="col-sm-2 control-label "></label>
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary btn-lg col-md-3 pull-right"><i class="fa fa-save"></i> Save</button>
                </div>
            </div>
        </form>
    </div>
</div>