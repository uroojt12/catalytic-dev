<?php if ($this->uri->segment(3) == 'manage') : ?>
    <?= showMsg(); ?>
    <?= getBredcrum(SUBADMIN, array('#' => 'Add/Update Newsletter')); ?>
    <div class="row margin-bottom-10">
        <div class="col-md-6">
            <h2 class="no-margin"><i class="entypo-list"></i> Add/Update <strong>Newsletter</strong></h2>
        </div>
        <div class="col-md-6 text-right">
            <a href="<?= site_url(SUBADMIN . '/newsletter'); ?>" class="btn btn-lg btn-default"><i class="fa fa-arrow-left"></i> Cancel</a>
        </div>
    </div>
    <div>
        <hr>
        <div class="row col-md-12">
            <form action="" name="frmNewsletter" role="form" class="form-horizontal" method="post" enctype="multipart/form-data">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="col-md-12">
                            <label class="control-label"> Name</label>
                            <input type="text" name="name" value="<?php if (isset($row->name)) echo $row->title; ?>" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="col-md-12">
                            <label class="control-label"> Text</label>
                            <textarea name="text" rows="8" class="form-control" required><?= $row->text ?></textarea>
                        </div>
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
                <br>
                <br>
            </form>
        </div>
        <div class="clearfix"></div>
    </div>
<?php else : ?>
    <?= showMsg(); ?>
    <?= getBredcrum(SUBADMIN, array('#' => 'Manage Newsletter')); ?>
    <div class="row margin-bottom-10">
        <div class="col-md-6">
            <h2 class="no-margin"><i class="entypo-list"></i> Manage <strong>Newsletter</strong></h2>
        </div>
        <div class="col-md-6 text-right">
            <a href="<?= site_url(SUBADMIN . '/newsletter/csv_export'); ?>" target="_blank" class="btn btn-lg btn-primary"><i class="fa fa-download"></i> CSV Export</a>
        </div>
    </div>
    <table class="table table-bordered datatable" id="table-1">
        <thead>
            <tr>
                <th width="5%" class="text-center">Sr#</th>
                <th>Newsletter Email</th>
                <th width="12%" class="text-center">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <?php if (countlength($rows) > 0) : $count = 0; ?>
                <?php foreach ($rows as $row) : ?>
                    <tr class="odd gradeX">
                        <td class="text-center"><?= ++$count; ?></td>
                        <td><?= $row->email; ?></td>
                        <td class="text-center">
                            <!-- <li><a href="<?= site_url(SUBADMIN . '/newsletter/manage/' . $row->id); ?>">Edit</a></li> -->
                            <a href="<?= site_url(SUBADMIN . '/newsletter/delete/' . $row->id); ?>" onclick="return confirm('Are you sure?');" class="btn btn-primary">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
<?php endif; ?>