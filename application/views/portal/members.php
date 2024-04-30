<?php if ($this->uri->segment(3) == 'manage') : ?>
    <?php echo showMsg(); ?>
    <?php echo getBredcrum(SUBADMIN, array('#' => 'Add/Edit Members')); ?>
    <div class="row margin-bottom-10">
        <div class="col-md-6">
            <h2 class="no-margin"><i class="entypo-users"></i> Add/Edit <strong>Member</strong></h2>
        </div>
        <div class="col-md-6 text-right">
            <a href="<?php echo base_url(SUBADMIN . '/members'); ?>" class="btn btn-lg btn-default"><i class="fa fa-arrow-left"></i> Cancel</a>
        </div>
    </div>
    <div>
        <hr>
        <div class="row col-md-12">
            <form action="" role="form" class="form-horizontal" method="post" enctype="multipart/form-data">

                <div class="col-md-6">
                    <h3><i class="fa fa-bars"></i> Profile Detail</h3>
                    <hr class="hr-short">
                    <div class="form-group">
                        <div class="col-md-12">
                            <label class="control-label"> Full Name <span class="symbol required">*</span></label>
                            <input type="text" name="mem_fullname" value="<?php if (isset($row->mem_fname)) echo get_mem_name($row->mem_id); ?>" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12">
                            <label class="control-label">Email <span class="symbol required">*</span></label>
                            <input type="text" name="mem_email" value="<?php if (isset($row->mem_email)) echo $row->mem_email; ?>" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <label class="control-label"> Phone Number</label>
                            <input type="text" name="mem_phone" value="<?php if (isset($row->mem_phone)) echo $row->mem_phone; ?>" class="form-control">
                        </div>
                    </div>
                </div>
                <!-- <div class="col-md-6">
                    <div class="form-group">
                        <div class="col-md-12">
                            <label class="control-label"> Country</label>
                            <select id="mem_country" name="mem_country" class="form-control" required="required">
                                <option value="">- Select Country -</option>
                                <?= get_countries_options('id', $row->mem_country) ?>

                            </select>

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <label class="control-label"> State or City</label>
                            <input type="text" name="mem_city" value="<?php if (isset($row->mem_city)) echo $row->mem_city; ?>" class="form-control">
                        </div>
                    </div>
                </div> -->
                <!-- <div class="col-md-6">
                    <div class="form-group">
                        <div class="col-md-12">
                            <label class="control-label"> ZIP Code</label>
                            <input type="text" name="mem_zip" value="<?php if (isset($row->mem_zip)) echo $row->mem_zip; ?>" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <label class="control-label"> Address</label>
                            <input type="text" name="mem_add1" value="<?php if (isset($row->mem_address)) echo $row->mem_address; ?>" class="form-control">
                        </div>
                    </div>
                </div> -->
                <div class="col-md-6">

                    <!-- <div class="form-group">
                        <div class="col-md-12">
                            <img src="<?php echo get_site_image_src('images', (isset($row->mem_image) ? $row->mem_image : '')); ?>" height="80"><br>
                        
                        </div>
                    </div> -->
                </div>
                <div class="clearfix"></div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="col-md-12">
                            <label class="control-label"> Status</label>
                            <select name="mem_status" id="mem_status" class="form-control">
                                <option value="0" <?php
                                                    if (isset($row->mem_status) && '0' == $row->mem_status) {
                                                        echo 'selected';
                                                    }
                                                    ?>>InActive</option>
                                <option value="1" <?php
                                                    if (isset($row->mem_status) && '1' == $row->mem_status) {
                                                        echo 'selected';
                                                    }
                                                    ?>>Active</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </form>
        </div>
        <div class="clearfix"></div>
    </div>
<?php else : ?>
    <?php echo showMsg(); ?>
    <?php echo getBredcrum(SUBADMIN, array('#' => 'Manage Members')); ?>
    <div class="row margin-bottom-10">
        <div class="col-md-6">
            <h2 class="no-margin"><i class="entypo-users"></i> Manage <strong>Members</strong></h2>
        </div>
        <div class="col-md-6 text-right">
        </div>
    </div>
    <table class="table table-bordered datatable" id="table-1">
        <thead>
            <tr>
                <th width="5%" class="text-center">Sr#</th>
                <!-- <th width="10%">Photo</th> -->
                <th width="15%">Name</th>
                <th>Email</th>
                <!-- <th width="15%">Password</th> -->
                <th width="5%" class="text-center">Status</th>
                <th width="12%" class="text-center">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($rows) > 0) : $count = 0; ?>
                <?php foreach ($rows as $row) : ?>
                    <tr class="odd gradeX">
                        <td class="text-center"><?php echo ++$count; ?></td>

                        <td><?php echo get_mem_name($row->mem_id); ?></td>
                        <td><?php echo $row->mem_email; ?></td>

                        <td class="text-center"><?php echo getStatus($row->mem_status); ?></td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"> Action <span class="caret"></span></button>
                                <ul class="dropdown-menu dropdown-primary" role="menu">
                                    <?php if ($row->mem_status == '0') : ?>
                                        <li><a href="<?php echo base_url(SUBADMIN); ?>/members/active/<?php echo $row->mem_id; ?>">Active</a></li>
                                    <?php else : ?>
                                        <li><a href="<?php echo base_url(SUBADMIN); ?>/members/inactive/<?php echo $row->mem_id; ?>">Inactive</a></li>
                                    <?php endif; ?>
                                    <li><a href="<?php echo base_url(SUBADMIN); ?>/members/manage/<?php echo $row->mem_id; ?>">Edit</a></li>

                                    <li class="divider"></li>
                                    <li><a href="<?php echo base_url(SUBADMIN); ?>/members/delete/<?php echo $row->mem_id; ?>" onclick="return confirm('Are you sure?');">Delete</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
<?php endif; ?>