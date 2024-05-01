<?php if ($this->uri->segment(3) == 'manage') { ?>
<?php echo showMsg(); ?>
<?php echo getBredcrum(ADMIN, array('#' => 'Add/Edit Member')); ?>
<div class="row col-md-12 margin-bottom-10 ">
    <!-- <div class="col-md-12"> -->
    <div class="form-group">
        <div class="col-md-6">
            <h2 class="no-margin"><i class="entypo-users"></i> Add/Edit <strong> Member</strong></h2>
        </div>
        <div class="col-md-6 text-right">
            <a href="<?= base_url(ADMIN . '/members') ?>" class="btn btn-lg btn-default"><i
                    class="fa fa-arrow-left"></i> Cancel</a>
        </div>
    </div>
    <!-- </div> -->
</div>
<div>
    <div class="row col-md-12 members_data">
        <form action="" role="form" class="form-horizontal" method="post" enctype="multipart/form-data">

            <div class="col-md-12">
                <h3><i class="fa fa-bars"></i> Member Detail</h3>
                <hr class="hr-short">
                <div class="col-md-6">
                    <div style="margin:15px 0px" class="">
                        <div class="panel panel-primary" data-collapsed="0">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    Profile Image
                                </div>
                                <div class="panel-options">
                                    <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                </div>
                            </div>
                            <?php
                                get_site_image_src("members", $row->mem_image);
                                ?>
                            <div class="panel-body">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="max-width: 310px; height: 110px;"
                                        data-trigger="fileinput">
                                        <img src="<?= !empty($row->mem_image) ? get_site_image_src("members", $row->mem_image) : 'http://placehold.it/700x620' ?>"
                                            alt="--">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail"
                                        style="max-width: 320px; max-height: 160px; line-height: 6px;"></div>
                                    <div>
                                        <span class="btn btn-black btn-file">
                                            <span class="fileinput-new">Select image</span>
                                            <span class="fileinput-exists">Change</span>
                                            <input type="file" name="mem_image" accept="image/*">
                                        </span>
                                        <a href="#" class="btn btn-orange fileinput-exists"
                                            data-dismiss="fileinput">Remove</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label class="control-label"> Status</label>
                            <select name="mem_status" id="mem_status" class="form-control">
                                <option value="1" <?php
                                                        if (isset($row->mem_status) && '1' == $row->mem_status) {
                                                            echo 'selected';
                                                        }
                                                        ?>>Active</option>
                                <option value="0" <?php
                                                        if (isset($row->mem_status) && '0' == $row->mem_status) {
                                                            echo 'selected';
                                                        }
                                                        ?>>Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="control-label"> Verified</label>
                            <select name="mem_verified" id="mem_verified" class="form-control">
                                <option value="1" <?php
                                                        if (isset($row->mem_verified) && '1' == $row->mem_verified) {
                                                            echo 'selected';
                                                        }
                                                        ?>>Yes</option>
                                <option value="0" <?php
                                                        if (isset($row->mem_verified) && '0' == $row->mem_verified) {
                                                            echo 'selected';
                                                        }
                                                        ?>>No</option>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label class="control-label">Featured</label>
                            <select name="mem_featured" id="mem_featured" class="form-control">
                                <option value="1" <?php
                                                        if (isset($row->mem_featured) && '1' == $row->mem_featured) {
                                                            echo 'selected';
                                                        }
                                                        ?>>Yes</option>
                                <option value="0" <?php
                                                        if (isset($row->mem_featured) && '0' == $row->mem_featured) {
                                                            echo 'selected';
                                                        }
                                                        ?>>No</option>
                            </select>
                        </div>


                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="col-md-12">
                    <label class="control-label"> Full Name <span class="symbol required"
                            style="color: red">*</span></label>
                    <input type="text" name="mem_fname"
                        value="<?php if (isset($row->mem_fname)) echo $row->mem_fname; ?>" class="form-control"
                        autofocus required>
                </div>


                <div class="col-md-6">
                    <label class="control-label">Email <span class="symbol required" style="color: red">*</span></label>
                    <input type="text" name="mem_email" <?php if (isset($row->mem_email)) {
                                                                echo 'readonly';
                                                            } ?>
                        value="<?php if (isset($row->mem_email)) echo $row->mem_email; ?>" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="control-label">Phone No </label>
                    <input type="text" name="mem_phone"
                        value="<?php if (isset($row->mem_phone)) echo $row->mem_phone; ?>" class="form-control">
                </div>
                <div class="clearfix"></div>

                <div class="col-md-12">
                    <hr class="hr-short">
                    <div class="form-group text-right">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary btn-lg col-md-3 pull-right"><i
                                    class="fa fa-save"></i> Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <div class="clearfix"></div>
        <?php if ($row->mem_type == 'professional') : ?>
        <div class="col-md-12">
            <hr>
            <h3><i class="fa fa-bars"></i> Professioanl Profile Detail</h3>
            <hr class="hr-short">
            <table class="table table-bordered">

                <tbody>
                    <tr>
                        <th><b>Service Title</b></th>
                        <td><b><?= get_service_title($row->mem_specialization); ?></b></td>
                    </tr>

                </tbody>
            </table>

            <div class="form-group">
                <div class="col-md-6">
                    <h4><i class="fa fa-bars"></i> Qualifications</h4>
                    <hr class="hr-short">
                    <?php if (!empty($mem_qualifications)) : $qul_count = 0; ?>
                    <table class="table table-bordered">

                        <tbody>

                            <thead>
                                <tr>
                                    <th width="8%">Sr. No.</th>
                                    <th>Title</th>
                                    <th>Duration</th>

                                </tr>
                            </thead>
                        <tbody>
                            <?php foreach ($mem_qualifications as $qul) : ?>
                            <tr>
                                <td><?= ++$qul_count ?></td>
                                <td><?= $qul->title ?></td>
                                <td><?= $qul->duration ?></td>

                            </tr>
                            <?php endforeach; ?>
                        </tbody>


                        </tbody>
                    </table>
                    <?php else : ?>
                    <div class="alert alert-danger">No Qualification Provided</div>
                    <?php endif; ?>
                </div>

                <div class="col-md-6">
                    <h4><i class="fa fa-bars"></i> Experties</h4>
                    <hr class="hr-short">
                    <?php if (!empty($mem_experties)) : $exp_count = 0; ?>
                    <table class="table table-bordered">

                        <tbody>

                            <thead>
                                <tr>
                                    <th width="8%">Sr. No.</th>
                                    <th>Title</th>
                                </tr>
                            </thead>
                        <tbody>
                            <?php foreach ($mem_experties as $qul) : ?>
                            <tr>
                                <td><?= ++$exp_count ?></td>
                                <td><?= $qul->title ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>


                        </tbody>
                    </table>
                    <?php else : ?>
                    <div class="alert alert-danger">No Experties Provided</div>
                    <?php endif; ?>
                </div>
            </div>



            <div class="clearfix"></div>

            <hr>
            <h3><i class="fa fa-bars"></i> Documents</h3>
            <hr class="hr-short">
            <table class="table table-bordered">
                <thead>
                    <th width="5%">Sr#</th>
                    <th><b>Document name</b></th>
                    <th><b>Document Status</b></th>
                    <th>
                        <button type="button" class="btn btn-primary btn-md" data-toggle="modal"
                            data-target="#requir_modal">Add Requirements</button>
                    </th>
                </thead>
                <tbody>
                    <?php if (count($documents) > 0) : $count = 0;  ?>
                    <?php foreach ($documents as $doc) : ?>
                    <tr>
                        <td><?= ++$count; ?></td>
                        <td><?= $doc->doc_name ?></td>
                        <td>
                            <form
                                action="<?= base_url('admin/members/doc_status/' . $doc->id . '/' . $this->uri->segment(4)) ?>"
                                role="form" class="form-horizontal" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <div class="col-md-9">
                                        <label class="control-label"> Status</label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="requested" <?php if (isset($doc->status) && 'requested' == $doc->status) {
                                                                                            echo 'selected';
                                                                                        } ?>>Requested</option>
                                            <option value="under_review" <?php if (isset($doc->status) && 'under_review' == $doc->status) {
                                                                                                echo 'selected';
                                                                                            } ?>>Under Review</option>
                                            <option value="pending" <?php if (isset($doc->status) && 'pending' == $doc->status) {
                                                                                        echo 'selected';
                                                                                    } ?>>Pending</option>
                                            <option value="approved" <?php if (isset($doc->status) && 'approved' == $doc->status) {
                                                                                            echo 'selected';
                                                                                        } ?>>Approved</option>

                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary btn-sm"
                                                style="position: relative;top:25px"><i class="fa fa-save"></i>
                                                Save</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </td>
                        <?php if ($doc->status != 'requested') : ?>
                        <td><a href="<?= base_url('/uploads/documents/' . $doc->document) ?>" target="_blank"
                                class="btn btn-success btn-sm">Download Document</a></td>
                        <?php endif; ?>
                    </tr>

                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>



        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
</div>

<?php } elseif ($this->uri->segment(3) == 'manage_subscription') { ?>
<?= showMsg(); ?>
<?= getBredcrum(ADMIN, array('#' => 'Add/Update Member Subscription')); ?>
<div class="row margin-bottom-10">
    <div class="col-md-6">
        <h2 class="no-margin"><i class="entypo-users"></i> Add/Update <strong>Member Subscription</strong></h2>
    </div>
    <div class="col-md-6 text-right">
        <a href="<?= site_url(ADMIN . '/members'); ?>" class="btn btn-lg btn-default"><i class="fa fa-arrow-left"></i>
            Cancel</a>
    </div>
</div>
<div>
    <hr>
    <div class="row col-md-12">

        <div class="col-md-12">
            <h3><i class="fa fa-bars"></i> Active Subscription Detail</h3>
            <hr class="hr-short">
            <table class="table table-bordered">

                <tbody>
                    <tr>

                        <th>Plan ID</th>
                        <td><b><?= $subscription->stripe_price_id ?></b></td>
                        <th>Plan Name</th>
                        <td><b><?= $subscription->plan_name ?></b></td>

                    </tr>

                    <tr>
                        <th>Subscription ID</th>
                        <td><b><?= $subscription->stripe_subscription_id ?></b></td>
                        <th>Subscription Status</th>
                        <td><b><?= get_subscription_status($subscription->subscription_status) ?></b></td>
                    </tr>
                    <tr>
                        <th>Customer ID</th>
                        <td><b><?= $subscription->stripe_customer_id ?></b></td>
                        <th>Customer Name</th>
                        <td><b><?= $subscription->mem_fullname ?></b></td>
                    </tr>
                    <tr>

                        <th>Subscription Start Date</th>
                        <td><b><?= format_date($subscription->start_date, 'M d, Y h:i:s a'); ?></b></td>
                        <th>Subscription End Date</th>
                        <td><b><?= format_date($subscription->end_date, 'M d, Y h:i:s a'); ?></b></td>

                    </tr>

                    <tr>
                        <th>Payment Method ID</th>
                        <td><b><?= $subscription->payment_method_id ?></b></td>
                        <th>Payment Intent</th>
                        <td><b><?= $subscription->payment_intent_id ?></b></td>
                    </tr>

                    <tr>

                        <th>Amount Charged</th>
                        <td><b><?= format_amount($subscription->price, 2); ?></b></td>
                        <th>Interval</th>
                        <td><b><?= ucfirst($subscription->interval) ?> </b></td>

                    </tr>


                </tbody>
            </table>


        </div>

        <div class="col-md-12">
            <h3><i class="fa fa-bars"></i> Previous Subscriptions Detail</h3>
            <hr class="hr-short">
            <table class="table table-bordered">

                <thead>
                    <tr>
                        <th width="5%" class="text-center">Sr#</th>
                        <th>Plan ID</th>
                        <th>Subscription ID</th>
                        <th>Customer ID</th>
                        <th>Amount</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Subscription Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (countlength($mem_subscriptions) > 0) : $sub_count = 0; ?>
                    <?php foreach ($mem_subscriptions as $sub) :  ?>
                    <tr class="odd gradeX">
                        <td class="text-center"><?php echo ++$sub_count; ?></td>
                        <td><b><?= $sub->stripe_price_id ?></b></td>
                        <td><b><?= $sub->stripe_subscription_id ?></b></td>
                        <td><b><?= $sub->stripe_customer_id ?></b></td>
                        <td><b><?= format_amount($sub->price) ?></b></td>
                        <td><b><?= format_date($sub->start_date, 'M d, Y h:i:s a') ?></b></td>
                        <td><b><?= format_date($sub->end_date, 'M d, Y h:i:s a') ?></b></td>
                        <td><b><?= get_subscription_status($sub->subscription_status) ?></b></td>


                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>


        </div>

        <div class="clearfix"></div>
    </div>

    <?php } elseif ($this->uri->segment(3) == 'manage_work_evidence') { ?>
    <?= showMsg(); ?>
    <?= getBredcrum(ADMIN, array('#' => 'Add/Update Member Work Evidence')); ?>
    <div class="row margin-bottom-10">
        <div class="col-md-6">
            <h2 class="no-margin"><i class="entypo-users"></i> Add/Update <strong>Member Work Evidence</strong></h2>
        </div>
        <div class="col-md-6 text-right">
            <a href="<?= site_url(ADMIN . '/members'); ?>" class="btn btn-lg btn-default"><i
                    class="fa fa-arrow-left"></i> Cancel</a>
        </div>
    </div>
    <div>
        <hr>
        <div class="row col-md-12">

            <div class="col-md-12">
                <h3><i class="fa fa-bars"></i> Work Evidences</h3>
                <hr class="hr-short">

                <?php if (!empty($mem_work_evidences)) :
                        foreach ($mem_work_evidences as $work) :

                            $file_ext = getFileExtension($work->evidence_file);
                    ?>

                <div class="col-md-2">
                    <button type="button" data-toggle="modal" data-target="#workModal<?= $work->id ?>">
                        <div class="panel panel-primary">
                            <div class="panel-body">
                                <div class="fileinput fileinput-new">
                                    <div class="fileinput-new thumbnail" style="max-width: auto;">
                                        <?php if ($file_ext == 'pdf') : ?>
                                        <img src="<?= base_url('assets/images/file_icon/pdf.png') ?>" alt="--">
                                        <?php else : ?>
                                        <img width="100%"
                                            src="<?= get_site_image_src('members/work-evidence', $work->evidence_file, '', false) ?>"
                                            alt="--">
                                        <?php endif; ?>


                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer">
                                <div class="panel-title">
                                    <?= $work->evidence_title ?>
                                </div>
                            </div>
                        </div>
                    </button>

                </div>

                <!-- Modal -->
                <div id="workModal<?= $work->id ?>" class="modal fade" role="dialog">
                    <div class="modal-dialog ">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h3 class="modal-title"><?= $work->evidence_title ?></h3>
                            </div>
                            <div class="modal-body">
                                <?php if ($file_ext == 'pdf') : ?>
                                <iframe src="<?= base_url('uploads/members/work-evidence/' . $work->evidence_file) ?>"
                                    frameborder="0" style="width: 100%; height:500px"></iframe>
                                <?php else : ?>
                                <img width="100%"
                                    src="<?= get_site_image_src('members/work-evidence', $work->evidence_file, '', false) ?>"
                                    alt="--">
                                <?php endif; ?>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>

                    </div>
                </div>

                <?php endforeach;

                    else : ?>

                <div class="alert alert-danger text-center">No Work Evidences Uploaded yet.</div>
                <?php
                    endif;
                    ?>







            </div>



            <div class="clearfix"></div>
        </div>

        <?php } else { ?>
        <?php echo showMsg(); ?>
        <?php echo getBredcrum(ADMIN, array('#' => 'Manage Members')); ?>
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
                    <th width="10%">Photo</th>
                    <th width="20%">Name</th>
                    <th width="8%" class="text-center">Member Type</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th width="8%" class="text-center">Verified Status</th>
                    <th width="8%" class="text-center">Status</th>
                    <th width="8%" class="text-center">Is Featured?</th>

                    <th width="8%" class="text-center">Registered On</th>
                    <th width="12%" class="text-center">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php if (countlength($rows) > 0) : $count = 0; ?>
                <?php foreach ($rows as $row) :  ?>
                <tr class="odd gradeX">
                    <td class="text-center"><?php echo ++$count; ?></td>
                    <td class="text-center">
                        <img src="<?= get_site_image_src("members", $row->mem_image) ?>" height="40">
                    </td>
                    <td><?= get_mem_name($row->mem_id); ?></td>
                    <td><?= get_member_type($row->mem_type); ?></td>
                    <td><?= $row->mem_email; ?></td>
                    <td><?= $row->mem_phone; ?></td>
                    <td><?= get_member_verified_status($row->mem_verified); ?></td>
                    <td class="text-center"><?= get_member_active_status($row->mem_status); ?></td>
                    <td class="text-center"><?= get_mem_featured($row->mem_featured); ?></td>

                    <td><?= format_date($row->mem_date, 'M, d Y H:i A') ?></td>


                    <td class="text-center">
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"> Action
                                <span class="caret"></span></button>
                            <ul class="dropdown-menu dropdown-primary" role="menu">
                                <?php if ($row->mem_status == '0') : ?>
                                <li><a href="<?= base_url(ADMIN); ?>/members/active/<?= $row->mem_id; ?>">Active</a>
                                </li>
                                <?php else : ?>
                                <li><a href="<?= base_url(ADMIN); ?>/members/inactive/<?= $row->mem_id; ?>">Inactive</a>
                                </li>
                                <?php endif; ?>

                                <?php if ($row->mem_featured == '0') : ?>
                                <li><a href="<?= base_url(ADMIN); ?>/members/featured/<?= $row->mem_id; ?>">Mark
                                        Featured</a></li>
                                <?php else : ?>
                                <li><a href="<?= base_url(ADMIN); ?>/members/unfeatured/<?= $row->mem_id; ?>">Un-mark
                                        Featured</a></li>
                                <?php endif; ?>

                                <?php if ($row->mem_type == 'professional') :  ?>
                                <li><a href="<?= base_url(ADMIN); ?>/members/manage_subscription/<?= $row->mem_id; ?>">Manage
                                        Subscription</a></li>
                                <li><a href="<?= base_url(ADMIN); ?>/members/manage_work_evidence/<?= $row->mem_id; ?>">Manage
                                        Work Evidence</a></li>

                                <?php endif;  ?>


                                <li><a href="<?= base_url(ADMIN); ?>/members/manage/<?= $row->mem_id; ?>">View
                                        Member</a></li>

                                <li class="divider"></li>
                                <li><a href="<?= base_url(ADMIN); ?>/members/delete/<?= $row->mem_id; ?>"
                                        onclick="return confirm('Are you sure?');">Delete</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <?php } ?>


        <div id="requir_modal" class="modal fade" role="dialog">
            <div class="vertical-alignment-helper">
                <div class="modal-dialog vertical-align-center">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h3 class="modal-title"><i class="fa fa-file"></i> Add Document Requirements</h3>
                        </div>
                        <form
                            action="<?= base_url('admin/members/add_document_requirements/' . $this->uri->segment(4)) ?>"
                            method="POST">
                            <div class="modal-body">

                                <div class="col-md-12">
                                    <table class="table table-bordered newTable" id="newTable">
                                        <tr style="background-color: #eee">
                                            <th>Document Name</th>
                                            <th width="4%" class="text-center"><a href="javascript:void(0)"
                                                    id="addNewRowTbl" class="addNewRowTbl"><i class="fa fa-plus"
                                                        aria-hidden="true"></i></a></th>
                                        </tr>

                                        <tr>
                                            <td>
                                                <input type="text" name="doc_name[]" id="doc_name" value=""
                                                    class="form-control" placeholder="Document Name">
                                            </td>

                                            <td class="text-center">
                                            </td>
                                        </tr>
                                    </table>
                                </div>


                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary btn-sm  pull-right"><i
                                        class="fa fa-save"></i> Save</button>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>