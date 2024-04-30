<?php if ($this->uri->segment(3) == 'detail') : ?>
    <?= showMsg(); ?>
    <?= getBredcrum(SUBADMIN, array('#' => 'Photo Grade')); ?>
    <div class="row margin-bottom-10">
        <div class="col-md-6">
            <h2 class="no-margin"><i class="fa fa-bars"></i> Photo Grade <strong>Detail</strong></h2>
        </div>
        <div class="col-md-6 text-right">
            <a href="<?= site_url(SUBADMIN . '/photo_grade'); ?>" class="btn btn-lg btn-default"><i class="fa fa-arrow-left"></i> Cancel</a>
        </div>
    </div>
    <div>
        <div class="clearfix"></div>
        <div class="panel-body">

            <div class="row">
                <table class="table table-hover">
                    <tbody>

                        <tr>
                            <td><strong>Member Name: </strong></td>
                            <td><?= get_mem_name($row->mem_id) ?></td>
                        </tr>
                        <!-- <tr>
                            <td><strong>Photo Grade: </strong></td>
                            <td><img src="</?= get_site_image_src("photo_grade", $row->grade_image); ?>" width="100"></td>

                        </tr> -->
                        <?php if (!empty($row->grade_image)) : ?>
                            <tr>
                                <td><strong>Photo Grade : </strong></td>
                                <td><a href="<?= base_url() . "uploads/photo_grade/" . $row->grade_image ?>" class="btn btn-info" target="_blank"><?= $row->grade_image ?></a></td>
                            </tr>
                        <?php endif; ?>
                        <tr>
                            <td><strong>Fullness: </strong></td>
                            <td><?= $row->grade_fullness ?></td>
                        </tr>
                        <tr>
                            <td><strong>Notes: </strong></td>
                            <td><?= $row->grade_notes ?></td>
                        </tr>
                        <tr>
                            <td><strong>Status: </strong></td>
                            <td><?= get_grade_status($row->status) ?></td>
                        </tr>



                    </tbody>
                </table>

                <form action="" role="form" class="form-horizontal" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="col-md-4">
                            <label class="control-label"> Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="pending" <?php
                                                        if (isset($row->status) && 'pending' == $row->status) {
                                                            echo 'selected';
                                                        }
                                                        ?>>Pending</option>
                                <option value="rejected" <?php
                                                            if (isset($row->status) && 'rejected' == $row->status) {
                                                                echo 'selected';
                                                            }
                                                            ?>>Rejected</option>
                                <option value="approved" <?php
                                                            if (isset($row->status) && 'approved' == $row->status) {
                                                                echo 'selected';
                                                            }
                                                            ?>>Approved</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="control-label" for="price"> Price <span class="symbol required"></span></label>
                            <input type="number" min="0" step="any" name="price" id="price" value="<?php if (isset($row->price)) echo $row->price; ?>" class="form-control" placeholder="Price" />
                        </div>

                        <div class="col-md-4">
                            <label class="control-label" for="admin_notes"> Notes <span class="symbol required"></span></label>
                            <textarea name="admin_notes" id="admin_notes" rows="5" class="form-control"><?php if (isset($row->admin_notes)) echo $row->admin_notes; ?></textarea>
                        </div>
                    </div>
                    <div class="clearfix"></div>
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
            <br>
            <br>
            <br>
        </div>
        <div class="clearfix"></div>
    </div>
<?php else : ?>
    <?php echo showMsg(); ?>
    <?php echo getBredcrum(SUBADMIN, array("#" => "Photo Grade")); ?>

    <div class="row margin-bottom-10">
        <div class="col-md-6">
            <h2 class="no-margin"><i class="entypo-chat" aria-hidden="true"></i> Manage <strong> Photo Grade</strong></h2>
        </div>

    </div>
    <br>
    <table class="table table-bordered datatable" id="table-1">
        <thead>
            <tr>
                <th width="5%" class="text-center">Sr#</th>
                <th width="" class="text-center">Member Name</th>
                <!-- <th width="" class="text-center">Photo Grade</th> -->
                <th width="" class="text-center">Fullness</th>
                <th width="" class="text-center">Status</th>
                <th width="" class="text-center">View Status</th>
                <th width="" class="text-center">Created Date</th>
                <!-- <th width="" class="text-center">Status</th> -->
                <th width="" class="text-center">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($rows) > 0) : $count = 0; ?>
                <?php foreach ($rows as $row) : ?>
                    <?php $time = strtotime($row->created_date); ?>
                    <tr class="odd gradeX status_tr">
                        <td class="text-center"><?php echo ++$count; ?></td>
                        <td class="text-center"><?= get_mem_name($row->mem_id); ?></td>
                        <!-- <td><img src="</?= get_site_image_src("photo_grade", $row->grade_image); ?>" width="100"></td> -->
                        <td class="text-center"><?= $row->grade_fullness ?></td>
                        <td class="text-center"><?= get_grade_status($row->status) ?></td>
                        <td class="text-center"><?= get_view_status($row->view_status) ?></td>

                        <td class="text-center"><?php echo date("D, d M Y", $time); ?></td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary" data-toggle="dropdown"> Action <span class="caret"></span></button>
                                <ul class="dropdown-menu dropdown-primary" role="menu" style="right:0 !important;left:inherit">
                                    <li><a href="<?= site_url(SUBADMIN . '/photo_grade/detail/' . $row->id); ?>">View</a></li>
                                    <li><a href="<?= site_url(SUBADMIN . '/photo_grade/delete/' . $row->id); ?>" onclick="return confirm('Are you sure?');">Delete</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>


<?php endif; ?>