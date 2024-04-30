<?php if ($this->uri->segment(3) == 'manage_topic') : ?>
    <?= showMsg(); ?>
    <?= getBredcrum(ADMIN, array('#' => 'Add/Update Help Topic of : Help : ' . $help->title)); ?>
    <div class="row margin-bottom-10">
        <div class="col-md-6">
            <h2 class="no-margin"><i class="entypo-list"></i> Add/Update <strong>Help Topic of : Help : <?= $help->title ?></strong></h2>
        </div>
        <div class="col-md-6 text-right">
            <a href="<?= site_url(ADMIN . '/help_topics/index/' . $this->uri->segment(4)); ?>" class="btn btn-lg btn-default"><i class="fa fa-arrow-left"></i> Cancel</a>
        </div>
    </div>
    <div>
        <hr>
        <div class="row col-md-12">
            <form action="" name="frmTestimonial" role="form" class="form-horizontal" method="post" enctype="multipart/form-data">
                <div class="form-group">


                    <div class="col-md-10">
                        <label class="control-label" for="title"> Topic Titile <span class="symbol required">*</span></label>
                        <input type="text" name="title" id="title" value="<?php if (isset($row->title)) echo $row->title; ?>" class="form-control" autofocus required>
                    </div>


                    <div class="col-md-2">
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

                    <div class="clearfix"></div>

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
        <div class="clearfix"></div>
    </div>
<?php else : ?>
    <?= showMsg(); ?>
    <?= getBredcrum(ADMIN, array('#' => 'Manage Help Topics of : Help : ' . $help->title)); ?>
    <div class="row margin-bottom-10">
        <div class="col-md-6">
            <h2 class="no-margin"><i class="entypo-list"></i> Manage <strong>Help Topics of : Help : <?= $help->title ?></strong></h2>
        </div>
        <div class="col-md-6 text-right">
            <a href="<?= site_url(ADMIN . '/help'); ?>" class="btn btn-lg btn-primary"><i class="fa fa-arrow-circle-left"></i> Back to Helps</a>

            <a href="<?= site_url(ADMIN . '/help_topics/manage_topic/' . $this->uri->segment(4) . '/' . $this->uri->segment(5)); ?>" class="btn btn-lg btn-success"><i class="fa fa-plus-circle"></i> Add New</a>
        </div>
    </div>

    <table class="table table-bordered datatable" id="table-1">
        <thead>
            <tr>
                <th width="5%" class="text-center">Sr#</th>
                <th width="10%">Help Title</th>
                <th>Topic Title</th>
                <th>Status</th>
                <th width="12%" class="text-center">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <?php if (countlength($rows) > 0) : $count = 0; ?>
                <?php foreach ($rows as $row) : ?>
                    <tr class="odd gradeX">
                        <td class="text-center"><?= ++$count; ?></td>
                        <td><b><?= get_help_title($row->help_id) ?></b></td>
                        <td><b><?= $row->title ?></b></td>
                        <td class="text-center"><?= getStatus($row->status); ?></td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"> Action <span class="caret"></span></button>
                                <ul class="dropdown-menu dropdown-primary" role="menu">
                                    <li><a href="<?= site_url(ADMIN . '/help_topics/manage_topic/' . $row->help_id . '/' . $row->id); ?>">Edit</a></li>
                                    <li><a href="<?= site_url(ADMIN . '/help_topics/delete_topic/' . $row->help_id . '/' . $row->id); ?>" onclick="return confirm('Are you sure?');">Delete</a></li>
                                
                                    <li class="divider"></li>
                                    <li><a href="<?= site_url(ADMIN.'/help_topics/help_topic_articles/'.$row->id); ?>" class="btn btn-info"> Add / Manage Topic Articles </a></li>

                                
                                </ul>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    <!-- </form> -->
<?php endif; ?>