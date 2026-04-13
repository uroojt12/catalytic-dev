<?php if ($this->uri->segment(3) == 'manage') : ?>
    <?= showMsg(); ?>
    <?= getBredcrum(ADMIN, array('#' => 'Add/Update Template')); ?>
    <div class="row margin-bottom-10">
        <div class="col-md-6">
            <h2 class="no-margin"><i class="entypo-list"></i> Add/Update <strong>Template</strong></h2>
        </div>
        <div class="col-md-6 text-right">
            <a href="<?= site_url(ADMIN . '/template'); ?>" class="btn btn-lg btn-default"><i class="fa fa-arrow-left"></i>
                Cancel</a>
        </div>
    </div>
    <div>
        <hr>
        <div class="row col-md-12">
            <form action="" name="frmTemplate" role="form" class="form-horizontal" method="post" enctype="multipart/form-data">
                <div class="form-group">

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


                    <div class="col-md-6">
                        <label class="control-label" for="title"> Title <span class="symbol required">*</span></label>
                        <input type="text" name="title" id="title" value="<?php if (isset($row->title)) echo $row->title; ?>" class="form-control" autofocus required>
                    </div>

                    <div class="clearfix"></div>
                    <br><br>
                    <div class="col-md-6">
                        <input type="file" id="selectedFile2" accept=".css" name="template_file" style="display: none;" <?php if (empty($row->template_file)) {
                                                                                                                            echo 'required=""';
                                                                                                                        } ?>>
                        <input type="button" value="Upload Template File" onclick="document.getElementById('selectedFile2').click();" class="btn btn-primary">
                        <span id="file-name2"></span>
                        <?php if (!empty($row->template_file)) { ?>
                            <a href="<?= base_url('uploads/templates/' . $row->template_file); ?>" target="_blank" class="btn btn-info">View Uploaded File</a>
                        <?php } ?>

                    </div>

                    <div class="clearfix"></div>

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
    <?= getBredcrum(ADMIN, array('#' => 'Manage Template')); ?>
    <div class="row margin-bottom-10 mobile_botton">
        <div class="col-md-6">
            <h2 class="no-margin"><i class="entypo-list"></i> Manage <strong>Template</strong></h2>
        </div>
        <div class="col-md-6 text-right mobile_botton_main" style="display: flex;justify-content: end;">
            <a href="<?= site_url(ADMIN . '/template/manage'); ?>" class="btn btn-lg btn-primary"><i class="fa fa-plus-circle"></i> Add New</a>
        </div>

    </div>

    <table class="table table-bordered datatable" id="table-1">
        <thead>
            <tr>
                <th width="5%" class="text-center">Sr#</th>
                <th>Title</th>
                <!-- <th>Calculated Price</th> -->
                <th class="text-center"> Status</th>
                <th class="text-center">Created Date</th>
                <th width="12%" class="text-center">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <?php if (countlength($rows) > 0) : $count = 0; ?>
                <?php foreach ($rows as $row) : ?>
                    <?php $time = strtotime($row->created_date); ?>
                    <tr class="odd gradeX">
                        <td class="text-center"><?= ++$count; ?></td>
                        <td><b><?= $row->title ?></b></td>
                        <td class="text-center"><?= getStatus($row->status); ?></td>
                        <td class="text-center"><?php echo date("D, d M Y", $time); ?></td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"> Action <span class="caret"></span></button>
                                <ul class="dropdown-menu dropdown-primary" role="menu">
                                    <li><a href="<?= site_url(ADMIN . '/template/manage/' . $row->id); ?>">Edit</a></li>
                                    <li><a href="<?= site_url(ADMIN . '/template/delete/' . $row->id); ?>" onclick="return confirm('Are you sure?');">Delete</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

<?php endif; ?>