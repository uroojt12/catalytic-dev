<?php if ($this->uri->segment(3) == 'view'): ?>
    <?= showMsg(); ?>
    <?= getBredcrum(ADMIN, array('#' => 'View Closed Lot')); ?>
    <div class="row margin-bottom-10">
        <div class="col-md-6">
            <h2 class="no-margin"><i class="entypo-list"></i> View <strong>Closed Lot</strong></h2>
        </div>
        <div class="col-md-6 text-right">
            <a href="<?= site_url(ADMIN . '/lots'); ?>" class="btn btn-lg btn-default"><i class="fa fa-arrow-left"></i> Cancel</a>
        </div>
    </div>
    <div>
        <div class="clearfix"></div>
        <div class="panel-body">

            <div class="row">
                <table class="table table-hover">
                    <tbody>
                        <tr>
                            <td><strong>Lot Name : </strong></td>
                            <td><?php echo $row->lot_name; ?></td>
                        </tr>
                        <tr>
                            <td><strong>Email : </strong></td>
                            <td><?php echo $row->email; ?></td>
                        </tr>
                        <tr>
                            <td><strong>Buisness Name : </strong></td>
                            <td><?php echo $row->buisness_name; ?></td>
                        </tr>
                        <tr>
                            <td><strong>Total : </strong></td>
                            <td><?php echo format_amount($total_price); ?></td>
                        </tr>
                        <?php if(!empty($row->identification_file)): ?>
                        <tr>
                            <td><strong>Attachment : </strong></td>
                            <td><a href="<?=$row->site_row->domain_name."uploads/attachments/".$row->identification_file?>" class="btn btn-info" target="_blank"><?=$row->identification_file_name?></a></td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <br>
            <br>
            <br>
            <table class="table table-bordered datatable" id="table-1">
                <thead>
                    <tr>
                        <th width="5%" class="text-center">Sr#</th>
                        <th>Full</th>
                        <th>Price</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $count = 0; foreach($codes_arr as $code_row):?>
                        <tr>
                            <td><?= ++$count; ?></td>
                            <td><?= $code_row->code_fullness; ?></td>
                            <td><?= format_amount($code_row->amount); ?></td>
                            <td><?= $code_row->qty; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="clearfix"></div>
    </div>
<?php else: ?>
    <?= showMsg(); ?>
    <?= getBredcrum(ADMIN, array('#' => 'Manage Lots')); ?>
    <div class="row margin-bottom-10">
        <div class="col-md-6">
            <h2 class="no-margin"><i class="entypo-list"></i> Closed <strong>Lots</strong></h2>
        </div>
        <!-- <div class="col-md-6 text-right">
            <a href="<?= site_url(ADMIN . '/newsletter/csv_export'); ?>" target="_blank" class="btn btn-lg btn-primary"><i class="fa fa-download"></i> CSV Export</a>
        </div> -->
    </div>
    <table class="table table-bordered datatable" id="table-1">
        <thead>
            <tr>
                <th width="5%" class="text-center">Sr#</th>
                <th>Lot Name</th>
                <th>Email</th>
                <th>Buisness Name</th>
                <th width="12%" class="text-center">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <?php if (countlength($rows) > 0): $count = 0; ?>
                <?php foreach ($rows as $row): ?>
                    <tr class="odd gradeX">
                        <td class="text-center"><?= ++$count; ?></td>
                        <td><?= $row->lot_name; ?></td>
                        <td><?= $row->email; ?></td>
                        <td><?= $row->buisness_name; ?></td>
                        <td class="text-center">
                            <a href="<?= site_url(ADMIN.'/lots/view/'.$row->id); ?>" class="btn btn-info">View</a>
                            <a href="<?= site_url(ADMIN.'/lots/delete/'.$row->id); ?>" onclick="return confirm('Are you sure?');" class="btn btn-primary">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
<?php endif; ?>