<?= showMsg(); ?>
<?= getBredcrum(SUBADMIN, array('#' => 'Manage Generics')); ?>
<div class="row margin-bottom-10">
    <div class="col-md-6">
        <h2 class="no-margin"><i class="entypo-list"></i> Manage <strong>Generics</strong></h2>
    </div>

</div>

<table class="table table-bordered datatable" id="table-1">
    <thead>
        <tr>
            <th width="5%" class="text-center">Sr#</th>
            <th>Code</th>
            <th>Price</th>
            <th>Tier Margin</th>
            <!-- <th width="12%" class="text-center">&nbsp;</th> -->
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php if (countlength($rows) > 0) : $count = 0; ?>
            <?php foreach ($rows as $row) : ?>
                <tr class="odd gradeX">
                    <td class="text-center"><?= ++$count; ?></td>
                    <!-- <td class="text-center">
                        <div class="">
                            <img src="<?= get_site_image_src('generics', $row->image); ?>" height="60" style="background-color:#eee">
                        </div>
                    </td> -->
                    <!-- <td><b><?= $row->title ?></b></td> -->
                    <td><b><?= $row->code ?></b></td>
                    <!-- <td><b><?= $row->make ?></b></td> -->
                    <?php $pump_cal_price = calculatedAllPrice($mainadminsite_setting->site_o_pt_price, $mainadminsite_setting->site_live_pt_price, $mainadminsite_setting->site_o_pd_price, $mainadminsite_setting->site_live_pd_price, $mainadminsite_setting->site_o_rh_price, $mainadminsite_setting->site_live_rh_price, $this->subadmin->site_id, $row->id) ?>
                    <td><b><?= format_amount($pump_cal_price) ?></b></td>
                    <?php $chk_code = chk_code_price_percentage($this->subadmin->site_id, $row->id) ?>
                    <form action="<?= site_url(SUBADMIN . '/generics/update_price/' . $row->id); ?>" method="POST">
                        <input type="hidden" name="new_price" value="0">
                        <td>
                            <input type="number" step="any" name="percentage" id="percentage" value="<?= (!empty($chk_code)) ? $chk_code->percentage : $this->subadmin->price_pump ?>" class="form-control" style="margin-right: 10px;" />
                            <div class="btn-group">
                                <button type="submit" class="btn btn-primary"> Update </button>

                            </div>

                        </td>

                        <td><?= getStatus($row->status); ?></td>

                    </form>

                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>