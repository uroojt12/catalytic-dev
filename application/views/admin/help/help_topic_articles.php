<?php if ($this->uri->segment(3) == 'manage_help_topic_article') : ?>
    <?= showMsg(); ?>
    <?= getBredcrum(ADMIN, array('#' => 'Add/Update Topic Article of : Help Topic : ' . $help_topic->title)); ?>
    <div class="row margin-bottom-10">
        <div class="col-md-6">
            <h2 class="no-margin"><i class="entypo-list"></i> Add/Update <strong>Topic Article of : Help Topic : <?= $help_topic->title ?></strong></h2>
        </div>
        <div class="col-md-6 text-right">
            <a href="<?= site_url(ADMIN . '/help_topics/help_topic_articles/' . $this->uri->segment(4)); ?>" class="btn btn-lg btn-default"><i class="fa fa-arrow-left"></i> Cancel</a>
        </div>
    </div>
    <div>
        <hr>
        <div class="row col-md-12">
            <form action="" name="frmTestimonial" role="form" class="form-horizontal" method="post" enctype="multipart/form-data">

                <div class="row">
                    <div class="col-md-9">
                        <div class="row">
                            <div class="">
                                <div class="panel-heading col-md-12">
                                    <div class="panel-title">
                                        <h3>Meta Information</h3>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label class="control-label"> Meta Title <span class="symbol required">*</span></label>
                                                <input type="text" name="meta_title" value="<?= $row->meta_title ?>" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label class="control-label"> Meta Keywords <span class="symbol required">*</span></label>
                                                <input type="text" name="meta_keywords" value="<?= $row->meta_keywords ?>" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label class="control-label"> Meta Description <span class="symbol required">*</span></label>
                                                <textarea rows="8" class="form-control" name="meta_description" required><?= $row->meta_description ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label class="control-label">Open Graph Type(og:type) <span class="symbol required">*</span></label>&nbsp;
                                                <select name="og_type" id="og_type" class="form-control" required>
                                                    <!-- <option value="">-- Select --</option> -->
                                                    <option value="article" <?= ($row->og_type == 'article') ? 'selected' : '' ?>>Article</option>
                                                    <option value="website" <?= ($row->og_type == 'website') ? 'selected' : '' ?>>Website</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label class="control-label">Open Graph Title(og:title) <span class="symbol required">*</span></label>&nbsp;
                                                <input type="text" name="og_title" class="form-control" value="<?= $row->og_title ?>" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="clearfix"></div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label class="control-label"> Open Graph Description(og:description) <span class="symbol required">*</span></label>
                                                <textarea name="og_description" rows="8" class="form-control" required><?php if (isset($row->og_description)) echo $row->og_description; ?></textarea>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="clearfix"></div>
                                </div>
                                <div class="panel-heading col-md-12">
                                    <div class="panel-title">
                                        <h3>Article Information</h3>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-md-6">
                                                <label class="control-label"> Topic Article Title <span class="symbol required">*</span></label>
                                                <input type="text" name="article_name" value="<?= $row->article_name ?>" class="form-control" required>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="control-label">Slug</label>
                                                <input type="text" name="slug" value="<?= $row->slug ?>" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label class="control-label"> Detail <span class="symbol required">*</span></label>
                                                <textarea rows="8" class="form-control ckeditor" name="detail" required><?= $row->detail ?></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="clearfix"></div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="row">

                            <div class="panel panel-primary" data-collapsed="0">
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        Open Graph image(og:image)
                                    </div>
                                    <div class="panel-options">
                                        <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail" style="max-width: 310px; height: 110px;" data-trigger="fileinput">
                                            <img src="<?= get_site_image_src("images/", $row->og_image) ?>" alt="--">
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 320px; max-height: 160px; line-height: 6px;"></div>
                                        <div>
                                            <span class="btn btn-white btn-file">
                                                <span class="fileinput-new">Select image</span>
                                                <span class="fileinput-exists">Change</span>
                                                <input type="file" name="og_image" accept="image/*" <?php if (empty($row->og_image)) {
                                                                                                        echo 'required=""';
                                                                                                    } ?>>
                                            </span>
                                            <a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Remove</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <br>

                        <div class="row">
                            <div class="panel panel-default">
                                <div class="panel-heading col-md-12" style="padding: 5.5px 10px"><i class="fa fa-eye" aria-hidden="true"></i> Display Options</div>
                                <div class="panel-body" style="padding: 15.5px 0px">
                                    <div class="col-md-7">
                                        <h5>Active</h5>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="btn-group" id="status" data-toggle="buttons">
                                            <label class="btn btn-default btn-on btn-sm <?php if ($row->status == 1) {
                                                                                            echo 'active';
                                                                                        } ?>">
                                                <input type="radio" value="1" name="status" <?php if ($row->status == 1) {
                                                                                                echo 'checked';
                                                                                            } ?>><i class="fa fa-check" aria-hidden="true"></i></label>
                                            <label class="btn btn-default btn-off btn-sm <?php if ($row->status == 0) {
                                                                                                echo 'active';
                                                                                            } ?>">
                                                <input type="radio" value="0" name="status" <?php if ($row->status == 0) {
                                                                                                echo 'checked';
                                                                                            } ?>><i class="fa fa-times" aria-hidden="true"></i></label>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
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
            </form>
        </div>
        <div class="clearfix"></div>
    </div>
<?php else : ?>
    <?= showMsg(); ?>
    <?= getBredcrum(ADMIN, array('#' => 'Manage Topic Articles of : Help Topic : ' . $help_topic->title)); ?>
    <div class="row margin-bottom-10">
        <div class="col-md-6">
            <h2 class="no-margin"><i class="entypo-list"></i> Manage <strong>Topic Articles of : Help Topic : <?= $help_topic->title ?></strong></h2>
        </div>
        <div class="col-md-6 text-right">
            <a href="<?= site_url(ADMIN . '/help_topics/index/'.$help_topic->help_id); ?>" class="btn btn-lg btn-primary"><i class="fa fa-arrow-circle-left"></i> Back to Help Topics</a>

            <a href="<?= site_url(ADMIN . '/help_topics/manage_help_topic_article/' . $this->uri->segment(4) . '/' . $this->uri->segment(5)); ?>" class="btn btn-lg btn-success"><i class="fa fa-plus-circle"></i> Add New</a>
        </div>
    </div>

    <table class="table table-bordered datatable" id="table-1">
        <thead>
            <tr>
                <th width="5%" class="text-center">Sr#</th>
                <th width="15%">Help Topic Title</th>
                <th>Topic Article Title</th>
                <th>Status</th>
                <th width="12%" class="text-center">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <?php if (countlength($rows) > 0) : $count = 0; ?>
                <?php foreach ($rows as $row) : ?>
                    <tr class="odd gradeX">
                        <td class="text-center"><?= ++$count; ?></td>
                        <td><b><?= get_help_topic_title($row->topic_id) ?></b></td>
                        <td><b><?= $row->article_name ?></b></td>
                        <td class="text-center"><?= getStatus($row->status); ?></td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"> Action <span class="caret"></span></button>
                                <ul class="dropdown-menu dropdown-primary" role="menu">
                                    <li><a href="<?= site_url(ADMIN . '/help_topics/manage_help_topic_article/' . $row->topic_id . '/' . $row->id); ?>">Edit</a></li>
                                    <li><a href="<?= site_url(ADMIN . '/help_topics/delete_help_topic_article/' . $row->topic_id . '/' . $row->id); ?>" onclick="return confirm('Are you sure?');">Delete</a></li>
                                   
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