<?php if ($this->uri->segment(3) == 'manage') : ?>
    <?= showMsg(); ?>
    <?= getBredcrum(ADMIN, array('#' => 'Add/Update Sub Domains')); ?>
    <div class="row margin-bottom-10">
        <div class="col-md-6">
            <h2 class="no-margin"><i class="entypo-list"></i> Add/Update <strong>Sub Domains</strong></h2>
        </div>
        <div class="col-md-6 text-right">
            <a href="<?= site_url(ADMIN . '/add_domains'); ?>" class="btn btn-lg btn-default"><i class="fa fa-arrow-left"></i> Cancel</a>
        </div>
    </div>
    <div>
        <hr>
        <div class="row col-md-12">
            <form action="" name="frmTestimonial" role="form" class="form-horizontal" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <div class="col-md-6">
                        <label class="control-label" for="domain_name">Domain Name <span class="symbol required">*</span></label>
                        <input type="text" name="domain_name" id="domain_name" value="<?php if (isset($row->domain_name)) echo $row->domain_name; ?>" class="form-control" autofocus required>
                    </div>
                    <div class="col-md-6">
                        <label class="control-label" for="name"> Name <span class="symbol required">*</span></label>
                        <input type="text" name="name" id="name" value="<?php if (isset($row->name)) echo $row->name; ?>" class="form-control" autofocus required>
                    </div>

                    <div class="col-md-6">
                        <label class="control-label" for="password">User password <span class="symbol required">*</span></label>
                        <input type="text" name="password" id="password" value="<?php if (isset($row->password)) ?>" class="form-control" autofocus>
                    </div>


                    <div class="col-md-6">
                        <label class="control-label" for="email">User Email <span class="symbol required">*</span></label>
                        <input type="text" name="email" id="email" value="<?php if (isset($row->email)) echo $row->email; ?>" class="form-control" autofocus required>
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

                <div class="form-group">
                    <div class="col-md-3">
                        <div class="panel panel-primary" data-collapsed="0">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    Logo image
                                </div>
                                <div class="panel-options">
                                    <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="max-width: 310px; height: 110px;background:#eee" data-trigger="fileinput">
                                        <img src="<?= get_site_image_src("images", $row->site_logo) ?>" alt="--">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 320px; max-height: 160px; line-height: 6px;"></div>
                                    <div>
                                        <span class="btn btn-white btn-file">
                                            <span class="fileinput-new">Select image</span>
                                            <span class="fileinput-exists">Change</span>
                                            <input type="file" name="site_logo" accept="image/*" <?php if (empty($row->site_logo)) {
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
    <?= getBredcrum(ADMIN, array('#' => 'Manage add_domains')); ?>
    <div class="row margin-bottom-10">
        <div class="col-md-6">
            <h2 class="no-margin"><i class="entypo-list"></i> Manage <strong>add_domains</strong></h2>
        </div>
        <div class="col-md-6 text-right">

            <a href="<?= site_url(ADMIN . '/add_domains/manage'); ?>" class="btn btn-lg btn-primary"><i class="fa fa-plus-circle"></i> Add New</a>
        </div>
    </div>

    <table class="table table-bordered datatable" id="table-1">
        <thead>
            <tr>
                <th width="5%" class="text-center">Sr#</th>

                <th>Domain Name</th>
                <th> Name</th>
                <th class="text-center">Status</th>
                <th width="12%" class="text-center">Created Date</th>
                <th width="12%" class="text-center">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <?php if (countlength($rows) > 0) : $count = 0; ?>
                <?php foreach ($rows as $row) : ?>
                    <?php $time = strtotime($row->created_date); ?>
                    <tr class="odd gradeX">
                        <td class="text-center"><?= ++$count; ?></td>

                        <td><b><?= $row->domain_name ?></b></td>
                        <td><b><?= $row->name ?></b></td>
                        <td class="text-center"><?= getStatus($row->status); ?></td>
                        <td class="text-center"><?= date("D, d M Y", $time); ?></td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"> Action <span class="caret"></span></button>
                                <ul class="dropdown-menu dropdown-primary" role="menu">
                                    <li><a href="<?= site_url(ADMIN . '/add_domains/manage/' . $row->site_id); ?>">Edit</a></li>
                                    <li><a href="<?= site_url(ADMIN . '/add_domains/delete/' . $row->site_id); ?>" onclick="return confirm('Are you sure?');">Delete</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

<?php endif; ?>