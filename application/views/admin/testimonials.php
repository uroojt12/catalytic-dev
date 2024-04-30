<?php if ($this->uri->segment(3) == 'manage') : ?>
    <?= showMsg(); ?>
    <?= getBredcrum(ADMIN, array('#' => 'Add/Update Testimonial')); ?>
    <div class="row margin-bottom-10">
        <div class="col-md-6">
            <h2 class="no-margin"><i class="entypo-list"></i> Add/Update <strong>Testimonial</strong></h2>
        </div>

        <div class="col-md-6 text-right">
            <a href="<?= site_url(ADMIN . '/testimonials'); ?>" class="btn btn-lg btn-default"><i class="fa fa-arrow-left"></i> Cancel</a>
        </div>
    </div>

    <div>
        <hr>
        <div class="row col-md-12">
            <form action="" name="frmTestimonial" role="form" class="form-horizontal" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading col-md-12" style="padding: 5.5px 10px"><i class="fa fa-eye" aria-hidden="true"></i> Display Options</div>
                            <div class="panel-body" style="padding: 15.5px 0px">
                                <div class="col-md-3">
                                    <h5>Status</h5>
                                </div>
                                <div class="col-md-7">
                                    <div class="btn-group" id="status" data-toggle="buttons">
                                        <label class="btn btn-default btn-off btn-sm <?php if ($row->status == 0) {
                                                                                            echo 'active';
                                                                                        } ?>">
                                            <input type="radio" value="0" name="status" <?php if ($row->status == 0) {
                                                                                            echo 'checked';
                                                                                        } ?>><i class="fa fa-times" aria-hidden="true"></i></label>

                                        <label class="btn btn-default btn-on btn-sm <?php if ($row->status == 1) {
                                                                                        echo 'active';
                                                                                    } ?>">
                                            <input type="radio" value="1" name="status" <?php if ($row->status == 1) {
                                                                                            echo 'checked';
                                                                                        } ?>><i class="fa fa-check" aria-hidden="true"></i></label>

                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading col-md-12" style="padding: 5.5px 10px"><i class="fa fa-eye" aria-hidden="true"></i> Rating Options</div>
                        <div class="panel-body" style="padding: 15.5px 0px">
                            <div class="col-md-3">
                                <h5>Star Ratings</h5>
                            </div>

                            <div class="col-md-7" id="ratings">
                                <div id="rateYo"></div>
                            <input type="hidden" name="star_rating" id="rating_input" value="<?= $row->star_rating ?>">
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div> -->
                </div>

                <div style="margin:45px 0px" class="">
                    <div class="panel panel-primary" data-collapsed="0">
                        <div class="panel-heading">
                            <div class="panel-title">
                                Image
                            </div>
                            <div class="panel-options">
                                <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                            </div>
                        </div>
                        <?php
                        get_site_image_src("images", $row->image);
                        ?>
                        <div class="panel-body">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="max-width: 310px; height: 110px;" data-trigger="fileinput">
                                    <img src="<?= !empty($row->image) ? get_site_image_src("testimonials", $row->image) : base_url() . '/assets/images/no_user.png' ?>" alt="--">
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 320px; max-height: 160px; line-height: 6px;"></div>
                                <div>
                                    <span class="btn btn-black btn-file">
                                        <span class="fileinput-new">Select image</span>
                                        <span class="fileinput-exists">Change</span>
                                        <input type="file" name="image" accept="image/*" <?php if (empty($row->image)) {
                                                                                                echo 'required=""';
                                                                                            } ?>>
                                    </span>
                                    <a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Remove</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12">
                            <label for="image_alt_text" class="control-label"> Image Alt Text <span class="symbol required">*</span></label>
                            <input type="text" name="image_alt_text" value="<?php if (isset($row->image_alt_text)) echo $row->image_alt_text; ?>" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12">
                            <label class="control-label" for="name"> Name</label>
                            <input type="text" name="name" id="name" value="<?php if (isset($row->name)) echo $row->name; ?>" class="form-control" autofocus required>
                        </div>

                        <div class="col-md-12">
                            <label class="control-label" for="Place">Designation</label>
                            <input type="text" name="designation" id="designation" value="<?php if (isset($row->designation)) echo $row->designation; ?>" class="form-control" required>
                        </div>

                    </div>

                    <div class="form-group">
                        <div class="col-md-12">
                            <label class="control-label" for="detail"> Detail</label>
                            <textarea name="detail" id="detail" rows="8" class="form-control" required><?= $row->detail ?></textarea>
                        </div>
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
    <?= getBredcrum(ADMIN, array('#' => 'Manage Testimonials')); ?>
    <div class="row margin-bottom-10">
        <div class="col-md-6">
            <h2 class="no-margin"><i class="entypo-list"></i> Manage <strong>Testimonials</strong></h2>
        </div>
        <div class="col-md-6 text-right">
            <a href="<?= site_url(ADMIN . '/testimonials/manage'); ?>" class="btn btn-lg btn-primary"><i class="fa fa-plus-circle"></i> Add New</a>
        </div>
    </div>

    <table class="table table-bordered datatable" id="table-1">
        <thead>
            <tr>
                <th width="5%" class="text-center">Sr#</th>
                <!-- <th width="10%">Photo</th> -->
                <th>Image</th>
                <th>Name</th>
                <th>Review</th>
                <!-- <th>Rating</th> -->
                <th>Status</th>
                <th width="12%" class="text-center">&nbsp;</th>
            </tr>
        </thead>

        <tbody>
            <?php if (count($rows) > 0) : $count = 0; ?>
                <?php foreach ($rows as $row) : ?>
                    <tr class="odd gradeX">
                        <td class="text-center"><?= ++$count; ?></td>
                        <td class="text-center">
                            <div class="icoRound">
                                <img src="<?= get_site_image_src('testimonials', $row->image, 'thumb_', true); ?>" height="60">
                            </div>
                        </td>
                        <td class="text-center"><?= $row->name ?></td>
                        <td><b><?= $row->name; ?></b></br>&emsp;<?= short_text($row->detail); ?></td>
                        <!-- <td>
                            <div id="s_rating_<?= $row->id ?>"></div>
                        </td> -->
                        <td class="text-center"><?= get_member_active_status($row->status); ?></td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"> Action <span class="caret"></span></button>
                                <ul class="dropdown-menu dropdown-primary" role="menu">
                                    <li><a href="<?= site_url(ADMIN . '/testimonials/manage/' . $row->id); ?>">Edit</a></li>
                                    <li><a href="<?= site_url(ADMIN . '/testimonials/delete/' . $row->id); ?>" onclick="return confirm('Are you sure?');">Delete</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
<?php endif; ?>

<script type="text/javascript" src="<?= base_url('adminassets/js/jquery.rateyo.js') ?>"></script>
<script>
    jQuery(document).ready(function() {
        jQuery("#rateYo").rateYo({
            rating: <?= !empty($row->star_rating) ? $row->star_rating : 0 ?>,
            numStars: 5,
            spacing: "5px",
            fullStar: true,
            minValue: 0,
            maxValue: 5,
            precision: 1,
            ratedFill: "#fabd6b",
            normalFill: "#D3D3D3",

            onSet: function(rating, rateYoInstance) {
                // Set the value of the hidden input field to the selected rating
                jQuery("#rating_input").val(rating);
            }
        });

        <?php foreach ($rows as $row) { ?>
            jQuery('#s_rating_<?= $row->id ?>').rateYo({
                rating: <?= !empty($row->star_rating) ? $row->star_rating : 0 ?>,
                starWidth: "20px",
                ratedFill: "#fabd6b",
                normalFill: "#D3D3D3",
                fullStar: true,
                readOnly: true, // Optional, set to true if you want to make the stars read-only
                // Other options if needed
            });
        <?php } ?>
    });
</script>