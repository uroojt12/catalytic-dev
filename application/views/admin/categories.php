<?php if ($this->uri->segment(3) == 'manage') : ?>
    <?= showMsg(); ?>
    <?= getBredcrum(ADMIN, array('#' => 'Add/Update  Category')); ?>
    <div class="row margin-bottom-10">
        <div class="col-md-6">
            <h2 class="no-margin"><i class="entypo-list"></i> Add/Update <strong>Category</strong> </h2>
        </div>
        <div class="col-md-6 text-right">
            <a href="<?= site_url(ADMIN . '/categories'); ?>" class="btn btn-lg btn-default"><i class="fa fa-arrow-left"></i> Cancel</a>
        </div>
    </div>
    <div>
        <hr>
        <div class="row col-md-12">
            <form action="" name="frmTestimonial" role="form" class="form-horizontal" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <div class="col-md-6">
                        <label class="control-label" for="name"> Category Name</label>
                        <input type="text" name="name" id="name" value="<?php if (isset($row->name)) echo $row->name; ?>" class="form-control" autofocus required>
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
    <?= getBredcrum(ADMIN, array('#' => 'Manage  Categories')); ?>
    <div class="row margin-bottom-10">
        <div class="col-md-6">
            <h2 class="no-margin"><i class="entypo-list"></i> Manage <strong>Categories</strong> </h2>
        </div>
        <div class="col-md-6 text-right">

            <a href="<?= site_url(ADMIN . '/categories/manage'); ?>" class="btn btn-lg btn-primary"><i class="fa fa-plus-circle"></i> Add New</a>
        </div>
    </div>
    <form name="updateFormOrder" id="updateFormOrder" action="<?php echo base_url('admin/categories/orderAll'); ?>" method="post">
        <table class="table table-bordered datatable" id="table-1">
            <thead>
                <tr>
                    <th width="5%" class="text-center">Sr#</th>

                    <th>Category Name</th>
                    <th>Status</th>


                    <th width="12%" class="text-center">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($rows) > 0) : $count = 0; ?>
                    <?php foreach ($rows as $row) : ?>
                        <tr class="odd gradeX">
                            <td class="text-center"><?= ++$count; ?></td>


                            <td><b><?= $row->name ?></b></td>
                            <td><b><?= getStatus($row->status) ?></b></td>



                            <td class="text-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"> Action <span class="caret"></span></button>
                                    <ul class="dropdown-menu dropdown-primary" role="menu">
                                        <li><a href="<?= site_url(ADMIN . '/categories/manage/' . $row->id); ?>">Edit</a></li>
                                        <li><a href="<?= site_url(ADMIN . '/categories/delete/' . $row->id); ?>" onclick="return confirm('Are you sure?');">Delete</a></li>
                                        <li class="divider"></li>
                                        <?php if ($row->status == 0) : ?>
                                            <li><a href="<?php echo base_url(ADMIN); ?>/categories/active/<?php echo $row->id; ?>">Active</a></li>
                                        <?php else : ?>
                                            <li><a href="<?php echo base_url(ADMIN); ?>/categories/inactive/<?php echo $row->id; ?>">Inactive</a></li>
                                        <?php endif; ?>

                                    </ul>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </form>
<?php endif; ?>