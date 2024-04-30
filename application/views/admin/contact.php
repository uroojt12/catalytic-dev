<?php if ($this->uri->segment(3) == 'manage'): ?>
    <?php echo getBredcrum(ADMIN, array('#' => 'Add/Update Contact')); ?>
    <div class="row margin-bottom-10">
        <div class="col-md-6">
            <h2 class="no-margin"><i class="entypo-chat "></i> Message </h2>
        </div>
        <div class="col-md-6 text-right">
            <a href="<?php echo base_url('admin/contact'); ?>" class="btn btn-lg btn-default"><i class="fa fa-arrow-left"></i> Cancel</a>
        </div>
    </div>
    <div>
        <div class="clearfix"></div>
        <div class="panel-body">

            <div class="row">
                <table class="table table-hover">
                    <tbody>
                        <tr>
                            <td><strong>Name : </strong></td>
                            <td><?php echo $row->full_name; ?></td>
                        </tr>
                        <tr>
                            <td><strong>Email : </strong></td>
                            <td><?php echo $row->email; ?></td>
                        </tr>
                        <tr>
                            <td><strong>Phone : </strong></td>
                            <td><?php echo $row->phone; ?></td>
                        </tr>
                        <!-- <tr>
                            <td><strong>Subject : </strong></td>
                            <td></?php echo $row->subject; ?></td>
                        </tr> -->
                        <tr>
                            <td><strong>Message : </strong></td>
                            <td><?php echo $row->msg; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <br>
            <br>
            <br>
        </div>
        <div class="clearfix"></div>
    </div>
<?php else: ?>
    <?php echo showMsg(); ?>
    <?php echo getBredcrum(ADMIN, array("#" => "Messages")); ?>

    <div class="row margin-bottom-10">
        <div class="col-md-6">
            <h2 class="no-margin"><i class="entypo-chat" aria-hidden="true"></i> Manage <strong> Messages</strong></h2>
        </div>
        <div class="col-md-6 text-right">
    <!--            <a href="<?php echo base_url('admin/what/manage'); ?>" class="btn btn-lg btn-primary"><i class="fa fa-plus-circle"></i> Add New</a>-->
        </div>
    </div>
    <br>
    <form method="post" action="<?=base_url('admin/contact/deleteAll')?>">
        <table class="table table-bordered datatable" id="table-1">
            <thead>
                <tr>
                    <th width="" class="text-center no_order" style="">
                        <button type="submit" onclick="return confirm('Are you sure to delete?');" name="delete_selected" class="btn btn-sm btn-danger">Delete</button>
                    </th>
                    <th width="5%" class="text-center">Sr#</th>
                    <th width="" class="text-center">Name</th>
                    <th width="" class="text-center">Email</th>
                    <th width="" class="text-center">Phone</th>
                    <!-- <th width="" class="text-center">Subject</th> -->
                    <th width="" class="text-center">Message</th>
                    <th width="" class="text-center">Date</th>
                    <th width="" class="text-center">Status</th>
                    <th width="" class="text-center">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php if (countlength($rows) > 0): $count = 0; ?>
                    <?php foreach ($rows as $row): ?>
                        <?php $time = strtotime($row->created_date); ?>
                        <tr  class="odd gradeX status_tr">
                            <td class="text-center">
                                <input type="checkbox" name="checkbox_id[]" class="select_checkbox" value="<?= $row->id ?>">
                            </td>
                            <td class="text-center"><?php echo ++$count; ?></td>
                            <td class="text-center"><?= $row->full_name ?></td>
                            <td class="text-center"><?= $row->email ?></td>
                            <td class="text-center"><?= $row->phone ?></td>
                            <!-- <td class="text-center"></?= $row->subject ?></td> -->
                            <td class="text-center"><?= substr($row->msg,0,70) ?>...</td>
                            <td class="text-center"><?php echo date("D, d M Y", $time); ?></td>
                            <td class="text-center"><?= get_contact_seen_status($row->status)?></td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary" data-toggle="dropdown"> Action <span class="caret"></span></button>
                                    <ul class="dropdown-menu dropdown-primary" role="menu" style="right:0 !important;left:inherit">
                                        <li><a href="<?php echo base_url(); ?>admin/contact/manage/<?php echo $row->id; ?>/<?php echo $row->slug; ?>">View</a></li>
                                        <li><a href="<?php echo base_url(); ?>admin/contact/delete/<?php echo $row->id; ?>" onclick="return confirm('Are you sure?');">Delete</a></li>
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