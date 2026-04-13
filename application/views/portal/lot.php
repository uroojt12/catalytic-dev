<?php if ($this->uri->segment(3) == 'view'): ?>
    <?= showMsg(); ?>
    <?= getBredcrum(SUBADMIN, array('#' => 'View Closed Lot')); ?>
    <div class="row margin-bottom-10">
        <div class="col-md-6">
            <h2 class="no-margin"><i class="entypo-list"></i> View <strong>Closed Lot</strong></h2>
        </div>
        <div class="col-md-6 text-right">
            <a href="<?= site_url(SUBADMIN . '/lot'); ?>" class="btn btn-lg btn-default"><i class="fa fa-arrow-left"></i> Cancel</a>
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
                        <!--<tr>-->
                        <!--    <td><strong>Total : </strong></td>-->
                        <!--    <td></?//php echo format_amount($total_price); ?></td>-->
                        <!--</tr>-->
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
                        <th>Fullness</th>
                        <th>Price</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $count = 0;
                    $count_avg = count($codes_arr);
                    $grand_total = 0;
                    foreach ($codes_arr as $code_row): ?>
                        <?php if ($code_row->id) {
                            // pr($code_row);
                            $pump_cal_price = calculatedAllPrice($mainadminsite_setting->site_o_pt_price, $mainadminsite_setting->site_live_pt_price, $mainadminsite_setting->site_o_pd_price, $mainadminsite_setting->site_live_pd_price, $mainadminsite_setting->site_o_rh_price, $mainadminsite_setting->site_live_rh_price, $this->subadmin->site_id, $code_row->id, $code_row->mem_id);
                            $price = $code_row->amount * $code_row->qty;
                            $grand_total += $price;
                        ?>
                            <tr>
                                <td><?= ++$count; ?></td>
                                <td><?= $code_row->fullness; ?>%</td>
                                <td><?= format_amount($price); ?></td>
                                <td><?= $code_row->qty; ?></td>
                            </tr>
                        <?php  } else {
                            $price = $code_row->code_price * $code_row->qty;
                            $grand_total += $price; // Add to grand total  
                        ?>
                            <tr>
                                <td><?= ++$count; ?></td>
                                <td><?= $code_row->fullness; ?>%</td>
                                <td><?= format_amount($price); ?></td>
                                <td><?= $code_row->qty; ?></td>
                            </tr>
                        <?php } ?>
                    <?php endforeach; ?>
                </tbody>
                <?php
                $total_converters = 0;
                foreach ($codes_arr as $code_row_qty) :
                    $total_converters += $code_row_qty->qty;
                endforeach;
                ?>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-right"><b>TOTAL CONVERTERS</b></th>
                        <td class="text-right"><b><?= $total_converters ?></b></td>
                    </tr>
                    <tr>
                        <th colspan="3" class="text-right"><b>AVERAGE PRICE</b></th>
                        <td class="text-right"><b><?= format_amount_decimal($total_converters > 0 ? $grand_total / $total_converters : 0,2) ?></b></td>
                    </tr>
                    <tr>
                        <th colspan="3" class="text-right"><b>GRAND TOTAL</b></th>
                        <td class="text-right"><b><?= format_amount($grand_total); ?></b></td>
                    </tr>
                </tfoot>
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
            <a href="<?= site_url(SUBADMIN . '/newsletter/csv_export'); ?>" target="_blank" class="btn btn-lg btn-primary"><i class="fa fa-download"></i> CSV Export</a>
        </div> -->
    </div>
    <table class="table table-bordered datatable" id="table-1">
        <thead>
            <tr>
                <th width="5%" class="text-center">Sr#</th>
                <th>Lot Name</th>
                <th>Email</th>
                <th>Buisness Name</th>
                <th width="15%" class="text-center">&nbsp;</th>
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
                            <a href="<?= site_url(SUBADMIN.'/lot/view/'.$row->id); ?>" class="btn btn-info">View</a>
                            <a href="<?= site_url(SUBADMIN.'/lot/delete/'.$row->id); ?>" onclick="return confirm('Are you sure?');" class="btn btn-primary">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
<?php endif; ?>