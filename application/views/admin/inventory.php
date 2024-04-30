<?php if ($this->uri->segment(3) == 'manage') : ?>
    <?= showMsg(); ?>
    <?= getBredcrum(ADMIN, array('#' => 'Add/Update Inventory')); ?>
    <div class="row margin-bottom-10">
        <div class="col-md-6">
            <h2 class="no-margin"><i class="entypo-list"></i> Add/Update <strong>Inventory</strong></h2>
        </div>
        <div class="col-md-6 text-right">
            <a href="<?= site_url(ADMIN . '/inventory'); ?>" class="btn btn-lg btn-default"><i class="fa fa-arrow-left"></i> Cancel</a>
        </div>
    </div>
    <div>
        <hr>
        <div class="row col-md-12">
            <form action="" name="frmTestimonial" role="form" class="form-horizontal" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <div class="col-md-6">
                        <label class="control-label" for="title"> Title <span class="symbol required">*</span></label>
                        <input type="text" name="title" id="title" value="<?php if (isset($row->title)) echo $row->title; ?>" class="form-control" autofocus required>
                    </div>
                    <div class="col-md-6">
                        <label class="control-label" for="code"> Code <span class="symbol required">*</span></label>
                        <input type="text" name="code" id="code" value="<?php if (isset($row->code)) echo $row->code; ?>" class="form-control" autofocus required>
                    </div>



                    <div class="col-md-6">
                        <label class="control-label" for="price">Market Price <span class="symbol required">*</span></label>
                        <input type="number" min="0" step="any" name="price" id="price" value="<?php if (isset($row->price)) echo $row->price; ?>" class="form-control" placeholder="Price" required />
                    </div>
                    <div class="col-md-6">
                        <label class="control-label" for="make"> Make <span class="symbol required">*</span></label>
                        <input type="text" name="make" id="make" value="<?php if (isset($row->make)) echo $row->make; ?>" class="form-control" autofocus required>
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

                    <!-- <div class="col-md-2">
                        <label for="featured" class="control-label"> Featured <span class="symbol required">*</span></label>
                        <select id="featured" name="featured" class="form-control">
                            <option value="0"</?= (isset($row->featured) && 0 == $row->featured ? ' selected' : '')?>>No</option>
                            <option value="1"</?= (isset($row->featured) && 1 == $row->featured ? ' selected' : '')?>>Yes</option>
                        </select>
                    </div> -->

                    <!-- <div class="col-md-2">
                        <label for="searched" class="control-label"> Most Searched <span class="symbol required">*</span></label>
                        <select id="searched" name="searched" class="form-control">
                            <option value="0"</?= (isset($row->searched) && 0 == $row->searched ? ' selected' : '')?>>No</option>
                            <option value="1"</?= (isset($row->searched) && 1 == $row->searched ? ' selected' : '')?>>Yes</option>
                        </select>
                    </div> -->

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
                                        <img src="<?= get_site_image_src("inventory", $row->image) ?>" alt="--">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 320px; max-height: 160px; line-height: 6px;"></div>
                                    <div>
                                        <span class="btn btn-white btn-file">
                                            <span class="fileinput-new">Select image</span>
                                            <span class="fileinput-exists">Change</span>
                                            <input type="file" name="image" accept="image/*" <?php if (empty($row->image)) {
                                                                                                    echo 'required=""';
                                                                                                } ?>>
                                        </span>
                                        <a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Remove</a>
                                    </div>
                                </div>
                            </div>
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
<?php else : ?>
    <?= showMsg(); ?>
    <?= getBredcrum(ADMIN, array('#' => 'Manage inventory')); ?>
    <div class="row margin-bottom-10">
        <div class="col-md-6">
            <h2 class="no-margin"><i class="entypo-list"></i> Manage <strong>inventory</strong></h2>
        </div>
        <div class="col-md-6 text-right">

            <a href="<?= site_url(ADMIN . '/inventory/manage'); ?>" class="btn btn-lg btn-primary"><i class="fa fa-plus-circle"></i> Add New</a>
        </div>
    </div>

    <table class="table table-bordered datatable" id="table-1">
        <thead>
            <tr>
                <th width="5%" class="text-center">Sr#</th>
                <th width="10%">image</th>
                <th>Title</th>
                <th>Status</th>
                <!-- <th>Featured</th> -->
                <!-- <th>Most Searched</th> -->

                <th width="12%" class="text-center">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <?php if (countlength($rows) > 0) : $count = 0; ?>
                <?php foreach ($rows as $row) : ?>
                    <tr class="odd gradeX">
                        <td class="text-center"><?= ++$count; ?></td>
                        <td class="text-center">
                            <div class="">
                                <img src="<?= get_site_image_src('inventory', $row->image, '', false); ?>" height="60" style="background-color:#eee">
                            </div>
                        </td>
                        <td><b><?= $row->title ?></b></td>
                        <td class="text-center"><?= getStatus($row->status); ?></td>
                        <!-- <td class="text-center"></?= getFeatured($row->featured); ?></td>
                        <td class="text-center"></?= getFeatured($row->searched); ?></td> -->
                        <td class="text-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"> Action <span class="caret"></span></button>
                                <ul class="dropdown-menu dropdown-primary" role="menu">
                                    <li><a href="<?= site_url(ADMIN . '/inventory/manage/' . $row->id); ?>">Edit</a></li>
                                    <li><a href="<?= site_url(ADMIN . '/inventory/delete/' . $row->id); ?>" onclick="return confirm('Are you sure?');">Delete</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

<?php endif; ?>