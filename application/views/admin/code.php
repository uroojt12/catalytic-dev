<?php if ($this->uri->segment(3) == 'manage') : ?>
    <?= showMsg(); ?>
    <?= getBredcrum(ADMIN, array('#' => 'Add/Update Code')); ?>
    <div class="row margin-bottom-10">
        <div class="col-md-6">
            <h2 class="no-margin"><i class="entypo-list"></i> Add/Update <strong>Code</strong></h2>
        </div>
        <div class="col-md-6 text-right">
            <a href="<?= site_url(ADMIN . '/code'); ?>" class="btn btn-lg btn-default"><i class="fa fa-arrow-left"></i>
                Cancel</a>
        </div>
    </div>
    <div>
        <hr>
        <div class="row col-md-12">
            <form action="" name="frmTestimonial" role="form" class="form-horizontal" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <div class="col-md-6">
                        <label class="control-label" for="title"> Title <span class="symbol required">*</span></label>
                        <input type="text" name="title" id="title" value="<?php if (isset($row->title)) echo $row->title; ?>" class="form-control" autofocus>
                    </div>
                    <div class="col-md-6">
                        <label class="control-label" for="cat_id">Category <span class="symbol required">*</span></label>
                        <select name="cat_id" id="cat_id" class="catSub form-control" required>
                            <option value=""> - Select - </option>
                            <?php foreach ($cats as $key => $cat) : ?>
                                <option value="<?= $cat->id ?>" <?= $cat->id == $row->cat_id ? ' selected' : '' ?>>
                                    <?= $cat->name ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-6">
                        <label class="control-label" for="code"> Code <span class="symbol required">*</span></label>
                        <input type="text" name="code" id="code" value="<?php if (isset($row->code)) echo $row->code; ?>" class="form-control" autofocus required>
                    </div>

                    <div class="col-md-6">
                        <label class="control-label" for="o_price"> Original Price <span class="symbol required">*</span></label>
                        <input type="number" min="0" step="any" name="o_price" id="o_price" value="<?php if (isset($row->o_price)) echo $row->o_price; ?>" class="form-control" placeholder="Price" required />
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-md-6">
                        <label class="control-label" for="pt_price"> PT Price <span class="symbol required">*</span></label>
                        <input type="number" min="0" step="any" name="pt_price" id="pt_price" value="<?php if (isset($row->pt_price)) echo $row->pt_price; ?>" class="form-control" placeholder="Price" required />
                    </div>

                    <div class="col-md-6">
                        <label class="control-label" for="pd_price"> PD Price <span class="symbol required">*</span></label>
                        <input type="number" min="0" step="any" name="pd_price" id="pd_price" value="<?php if (isset($row->pd_price)) echo $row->pd_price; ?>" class="form-control" placeholder="Price" required />
                    </div>
                    <div class="clearfix"></div>

                    <div class="col-md-6">
                        <label class="control-label" for="rh_price"> RH Price <span class="symbol required">*</span></label>
                        <input type="number" min="0" step="any" name="rh_price" id="rh_price" value="<?php if (isset($row->rh_price)) echo $row->rh_price; ?>" class="form-control" placeholder="Price" required />
                    </div>
                    <?php $cal_price = calculatedAllPrice($adminsite_setting->site_o_pt_price, $adminsite_setting->site_live_pt_price, $adminsite_setting->site_o_pd_price, $adminsite_setting->site_live_pd_price, $adminsite_setting->site_o_rh_price, $adminsite_setting->site_live_rh_price, '-1', $row->id) ?>

                    <div class="col-md-6">
                        <label class="control-label" for="price"> Calculated Price <span class="symbol required">*</span></label>
                        <input type="number" min="0" step="any" name="price" id="price" value="<?= number_format($cal_price, 2, '.', '') ?>" class="form-control" placeholder="Price" readonly />
                    </div>
                    <!-- <div class="col-md-6">
                        <label class="control-label" for="price"> Calculated Price <span class="symbol required">*</span></label>
                        <input type="number" min="0" step="any" name="price" id="price" value="<?php if (isset($row->price)) echo $row->price; ?>" class="form-control" placeholder="Price" required />
                    </div> -->
                    <div class="clearfix"></div>
                    <div class="col-md-6">
                        <label class="control-label" for="make"> Make <span class="symbol required">*</span></label>
                        <input type="text" name="make" id="make" value="<?php if (isset($row->make)) echo $row->make; ?>" class="form-control" autofocus>
                    </div>

                    <div class="col-md-6">
                        <label class="control-label" for="status"> Status <span class="symbol required">*</span></label>
                        <select name="status" id="status" class="form-control">
                            <option value="1" <?php
                                                if (isset($row->status) && '1' == $row->status) {
                                                    echo 'selected';
                                                }
                                                ?>>Active</option>
                            <option value="0" <?php
                                                if (isset($row->status) && '0' == $row->status) {
                                                    echo 'selected';
                                                }
                                                ?>>Inactive</option>
                        </select>
                    </div>


                    <div class="clearfix"></div>

                    <div class="col-md-6">
                        <label class="control-label" for="new_type"> Type <span class="symbol required">*</span></label>
                        <select name="new_type" id="new_type" class="form-control">
                            <option value="">---Select Type----</option>
                            <option value="DOMESTIC" <?php
                                                        if (isset($row->new_type) && 'DOMESTIC' == $row->new_type) {
                                                            echo 'selected';
                                                        }
                                                        ?>>DOMESTIC</option>
                            <option value="FOREIGN" <?php
                                                    if (isset($row->new_type) && 'FOREIGN' == $row->new_type) {
                                                        echo 'selected';
                                                    }
                                                    ?>>FOREIGN</option>
                            <option value="DIESEL" <?php
                                                    if (isset($row->new_type) && 'DIESEL' == $row->new_type) {
                                                        echo 'selected';
                                                    }
                                                    ?>>DIESEL</option>
                            <option value="WIRE" <?php
                                                    if (isset($row->new_type) && 'WIRE' == $row->new_type) {
                                                        echo 'selected';
                                                    }
                                                    ?>>WIRE</option>
                            <option value="AFTERMARKET" <?php
                                                        if (isset($row->new_type) && 'AFTERMARKET' == $row->new_type) {
                                                            echo 'selected';
                                                        }
                                                        ?>>AFTERMARKET</option>
                        </select>
                    </div>


                    <div class="clearfix"></div>



                </div>

                <div class="form-group">
                    <div class="col-md-3">
                        <div class="panel panel-primary" data-collapsed="0">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    image
                                </div>
                                <div class="panel-options">
                                    <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="max-width: 310px; height: 110px;background:#eee" data-trigger="fileinput">
                                        <img src="<?= get_site_image_src("code", $row->image) ?>" alt="--">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 320px; max-height: 160px; line-height: 6px;"></div>
                                    <div>
                                        <span class="btn btn-white btn-file">
                                            <span class="fileinput-new">Select image</span>
                                            <span class="fileinput-exists">Change</span>
                                            <input type="file" name="image" accept="image/*">
                                        </span>
                                        <a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Remove</a>
                                    </div>
                                </div>
                                <br>
                                <?php if (!empty($row->id) && !empty($row->image)) { ?>
                                    <a href="<?= site_url(ADMIN . '/code/delete_image/' . $row->id); ?>" onclick="return confirm('Are you sure?');" class="btn btn-danger">Delete Image</a>
                                <?php } ?>
                            </div>

                        </div>
                    </div>


                </div>
                <div class="row">
                        <div class="col-md-12 margin-bottom-10">
                            <input type="file" name="upload_file[]" id="upload_file" class="form-control file2 inline btn btn-primary" multiple data-label="<i class='fa fa-upload'></i> Upload Multiple Images" />
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <?php
                                $pics = getPictures($row->id,'code');
                                if (count($pics) > 0) {
                                    foreach ($pics as $pic) {
                                        ?>
                                        <div class="col-md-3 text-center margin-bottom-10">
                                            <div class="stickerPicBox">
                                                <img src="<?= get_site_image_src('images', $pic->image); ?>" style="height:100px;margin-bottom: 10px;"><br>

                                                <button type="button" class="deleteStickerPic btn btn-danger btn-sm" data-id="<?php echo $pic->id; ?>"><i class="fa fa-times"></i> Delete</button>

                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>  
                <div class="col-md-12">
                    <hr class="hr-short">
                    <div class="form-group text-right">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary btn-lg col-md-3 pull-right"><i class="fa fa-save"></i> Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="clearfix"></div>
    </div>
    <script>
        jQuery(document).on('click','.deleteStickerPic',function(e){
        var id = jQuery(this).data('id');
        var ref_id = <?= $this->uri->segment('4') ?>;
        var btn = jQuery(this);
        btn.parent('.stickerPicBox').find('btn-info').removeClass();
        jQuery.ajax({
            url:base_url+'admin/code/delete_single_image',
            data:{id:id,ref_id:ref_id},
            method:'POST',
            dataType:'JSON',
            error:function(er){
                console.log(er)
            },
            success:function(sc){
                console.log(sc);
                if(sc.status==1){
                    window.location.reload('<?= current_url()?>') ;
                }
            }
        })
    })
    </script>
<?php else : ?>
    <?= showMsg(); ?>
    <?= getBredcrum(ADMIN, array('#' => 'Manage code')); ?>
    <div class="row margin-bottom-10 mobile_botton">
        <div class="col-md-6">
            <h2 class="no-margin"><i class="entypo-list"></i> Manage <strong>code</strong></h2>
        </div>
        <div class="col-md-6 text-right mobile_botton_main" style="display: flex;justify-content: end;">
            <form action="<?= base_url() ?>admin/code/upload_bulk" method="POST" enctype="multipart/form-data" style="display: flex;">
                <input type="file" name="codesFile" class="btn btn-lg btn-default" accept=".csv" required>
                <button type="submit" class="btn btn-lg btn-info" style="margin: 0px 10px"><i class="fa fa-upload"></i> CSV
                    Upload</button>
            </form>
            <a href="<?= site_url(ADMIN . '/code/manage'); ?>" class="btn btn-lg btn-primary"><i class="fa fa-plus-circle"></i> Add New</a>
        </div>

    </div>

    <table class="table table-bordered" id="table-codes">
        <thead>
            <tr>
                <th width="5%" class="text-center">Sr#</th>
                <th width="10%">image</th>
                <th>Type</th>
                <th>Code</th>
                <th>Price</th>
                <th>Add %</th>
                <th>Status</th>
                <th width="12%" class="text-center">&nbsp;</th>
            </tr>
        </thead>
    </table>

<?php endif; ?>


<script>
    $j(document).ready(function() {
        $j('#table-codes').DataTable({
            // Processing indicator
            "processing": true,
            "language": {
                processing: '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i>'
            },
            // DataTables server-side processing mode
            "serverSide": true,
            // Initial no order.
            "order": [],
            // Load data from an Ajax source
            "ajax": {
                "url": base_url + 'admin/code/fetch_codes',
                "type": "POST"
            },
            "stateSave": true,
            //Set column definition initialisation properties
            "columnDefs": [{
                // "targets": [0,2,3],
                "orderable": false
            }]
        });
    });
</script>