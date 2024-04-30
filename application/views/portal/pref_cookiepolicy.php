<?php echo getBredcrum(ADMIN, array('#' => 'Cookie Policy')); ?>
<?php echo showMsg(); ?>
<div class="row margin-bottom-10">
    <div class="col-md-6">
        <h2 class="no-margin"><i class="entypo-window"></i> Update <strong>Cookie Policy</strong></h2>
    </div>
    <div class="col-md-6 text-right">
        <!--        <a href="<?php echo base_url('admin/services'); ?>" class="btn btn-lg btn-default"><i class="fa fa-arrow-left"></i> Cancel</a>-->
    </div>
</div>
<div>
    <hr>
    <div class="clearfix"></div>
    <div class="panel-body">
        <form role="form"  method="post" class="form-horizontal form-groups-bordered validate" novalidate="novalidate" enctype="multipart/form-data">
            <div class="form-group">
                <div class="form-group col-sm-12 ">
                    <label for="field-1" class="control-label "> Title:</label>
                    <input type="text" name="pref_title" value="<?= $row->pref_title ?>" class="form-control" autofocus>
                </div>
            </div>
            <div class="form-group">
                <div class="form-group col-sm-12 ">
                    <label for="field-1" class="control-label "> Description</label>
                    <textarea name="pref_detail" rows="8" class="form-control ckeditor" ><?= $row->pref_detail ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="field-1" class="col-sm-2 control-label "></label>
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary btn-lg col-md-3 pull-right"><i class="fa fa-save"></i> Save</button>
                </div>
            </div>
            <hr class="hr-short">
        </form>
    </div>
    <div class="clearfix"></div>
</div>