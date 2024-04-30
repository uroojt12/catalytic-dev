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
            <th width="10%" class="text-center">image</th>
            <th>Title</th>
            <th>Code</th>
            <th>Make</th>
            <th>Price</th>
            <th>New Price</th>
            <th>Status</th>
            <th>Add %</th>
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
                            <img src="<?= get_site_image_src('generics', $row->image); ?>" height="60" style="background-color:#eee">
                        </div>
                    </td>
                    <td><b><?= $row->title ?></b></td>
                    <td><b><?= $row->code ?></b></td>
                    <td><b><?= $row->make ?></b></td>
                    <?php $cal_price = calculatedPrice($mainadminsite_setting->site_o_pt_price, $mainadminsite_setting->site_live_pt_price, $mainadminsite_setting->site_o_pd_price, $mainadminsite_setting->site_live_pd_price, $mainadminsite_setting->site_o_rh_price, $mainadminsite_setting->site_live_rh_price, $row->o_price, $row->pt_price, $row->pd_price, $row->rh_price); ?>
                    <td><b><?= format_amount($cal_price, 4) ?></b></td>
                    <!-- <td><b><//?= format_amount($row->price, 2) ?></b></td> -->
                    <?php $chk_code = chk_code_price_percentage($this->subadmin->site_id, $row->id) ?>
                    <td><b><?= ($chk_code->percentage !== NULL && $chk_code->percentage > 0) ? format_amount($chk_code->new_price, 4) : format_amount($cal_price, 4) ?></b></td>
                    <td><?= getStatus($row->status); ?></td>
                    <form action="<?= site_url(SUBADMIN . '/generics/update_price/' . $row->id); ?>" method="POST">
                        <input type="hidden" name="new_price" value="<?= $cal_price ?>">
                        <td>
                            <input type="number" min="0" step="any" name="percentage" id="percentage" value="<?= (!empty($chk_code)) ? $chk_code->percentage : 0 ?>" class="form-control" />
                        </td>
                        <!-- <td>
                            <input type="number" min="0" step="any" name="new_price" id="new_price" value="<?= (!empty($chk_code)) ? $chk_code->new_price : $row->price ?>" class="form-control" />
                        </td> -->
                        <td class="text-center">
                            <div class="btn-group">
                                <button type="submit" class="btn btn-primary"> Update </button>

                            </div>
                        </td>
                    </form>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>