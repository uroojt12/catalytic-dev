<?php echo getBredcrum(ADMIN, array('#' => 'Home Page')); ?>
<?php echo showMsg(); ?>
<div class="row margin-bottom-10">
    <div class="col-md-6">
        <h2 class="no-margin"><i class="entypo-window"></i> Update <strong>Home Page</strong></h2>
    </div>
    <div class="col-md-6 text-right">
        <!--        <a href="<?php echo base_url('admin/services'); ?>" class="btn btn-lg btn-default"><i class="fa fa-arrow-left"></i> Cancel</a>-->
    </div>
</div>
<div>
    <hr>
    <div class="clearfix"></div>
    <div class="panel-body">
        <form role="form" method="post" class="form-horizontal form-groups-bordered validate" novalidate="novalidate" enctype="multipart/form-data">

            <div class="form-group">
                <div class="row">
                    <div class="col-md-12">
                        <label class="control-label">Page Title <span style="color: red">*</label>
                        <textarea name="page_title" class="form-control" required="required" rows="3"><?php echo $row['page_title']; ?></textarea>
                    </div>

                    <div class="clearfix"></div>
                    <div class="col-md-12">
                        <h3>Meta Tags</h3>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-6">
                        <label class="control-label">Meta Title <span style="color: red">*</label>
                        <textarea name="meta_title" class="form-control" required="required" rows="3"><?php echo $row['meta_title']; ?></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="control-label">Meta Keywords <span style="color: red">*</label>
                        <textarea name="meta_keywords" class="form-control" required="required" rows="3"><?php echo $row['meta_keywords']; ?></textarea>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-12">
                        <label class="control-label">Meta Description <span style="color: red">*</label>
                        <textarea name="meta_description" class="form-control" required="required" rows="3"><?php echo $row['meta_description']; ?></textarea>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>

            <div class="clearfix"></div>

            <h3> Main Banner</h3>

            <div class="form-group">
                <div class="col-md-2">
                    <div class="form-group">

                        <div class="panel panel-primary" data-collapsed="0">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    Image
                                </div>
                                <div class="panel-options">
                                    <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="max-width: 310px; height: 110px;" data-trigger="fileinput">
                                        <img src="<?= !empty($row['image1']) ? get_site_image_src("images/", $row['image1']) : base_url('assets/images/no-image.svg') ?>" alt="--">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 320px; max-height: 160px; line-height: 6px;"></div>
                                    <div>
                                        <span class="btn btn-white btn-file">
                                            <span class="fileinput-new">Select image</span>
                                            <span class="fileinput-exists">Change</span>
                                            <input type="file" name="image1" accept="image/*" <?php if (empty($row['image1'])) {
                                                                                                    echo 'required=""';
                                                                                                } ?>>
                                        </span>
                                        <a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Remove</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="form-group">

                        <div class="col-md-12">
                            <label for="banner_heading" class="control-label">Heading <span class="symbol required">*</span></label>
                            <input type="text" name="banner_heading" value="<?= $row['banner_heading'] ?>" class="form-control" required>
                        </div>
                        <div class="clearfix"></div>

                        <div class="col-md-12">
                            <label for="banner_detail" class="control-label"> Text Block <span class="symbol required">*</span></label>
                            <textarea name="banner_detail" rows="3" class="form-control ckeditor" id="editor"><?= $row['banner_detail'] ?></textarea>
                        </div>
                        <div class="clearfix"></div>

                        <div class="col-md-6">
                            <label for="banner_btn_text" class="control-label">Button text <span class="symbol required">*</span></label>
                            <input type="text" name="banner_btn_text" value="<?= $row['banner_btn_text'] ?>" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label for="banner_btn_url" class="control-label">Button text <span class="symbol required">*</span></label>
                            <input type="text" name="banner_btn_url" value="<?= $row['banner_btn_url'] ?>" class="form-control" required>
                        </div>
                        <div class="clearfix"></div>
                        <?php $sec_banner = 0;
                        for ($i = 1; $i <= 3; $i++) : ++$sec_banner; ?>
                            <div class="col-md-4">
                                <label for="ban_title<?= $i ?>" class="control-label"> Genere Title <?= $sec_banner ?><span class="symbol required">*</span></label>
                                <input type="text" name="ban_title<?= $i ?>" class="form-control" value="<?= $row['ban_title' . $i] ?>" />
                            </div>
                            <div class="col-md-4">
                                <label for="ban_price<?= $i ?>" class="control-label"> Price <?= $sec_banner ?><span class="symbol required">*</span></label>
                                <input type="text" name="ban_price<?= $i ?>" class="form-control" value="<?= $row['ban_price' . $i] ?>" />
                            </div>
                            <div class="col-md-4">
                                <label for="ban_fullness<?= $i ?>" class="control-label"> Fullness <?= $sec_banner ?><span class="symbol required">*</span></label>
                                <input type="text" name="ban_fullness<?= $i ?>" class="form-control" value="<?= $row['ban_fullness' . $i] ?>" />
                            </div>

                        <?php endfor ?>

                        <div class="clearfix"></div>

                        <br>



                    </div>
                </div>

                <div class="clearfix"></div>

            </div>


            <h3>Section 2</h3>
            <div class="form-group">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="col-md-12">
                            <label for="sec2_title" class="control-label"> Title <span class="symbol required">*</span></label>
                            <input type="text" name="sec2_title" value="<?= $row['sec2_title'] ?>" class="form-control" required>
                        </div>

                        <div class="col-md-12">
                            <label for="sec2_heading" class="control-label"> Heading <span class="symbol required">*</span></label>
                            <input type="text" name="sec2_heading" value="<?= $row['sec2_heading'] ?>" class="form-control" required>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-md-12">
                            <label for="sec2_detail" class="control-label"> Text Block <span class="symbol required">*</span></label>
                            <textarea name="sec2_detail" rows="3" class="form-control ckeditor" id="editor"><?= $row['sec2_detail'] ?></textarea>
                        </div>

                        <div class="clearfix"></div>
                        <div class="col-md-6">
                            <label for="sec2_btn_text" class="control-label"> Button Text <span class="symbol required">*</span></label>
                            <input type="text" name="sec2_btn_text" value="<?= $row['sec2_btn_text'] ?>" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label for="sec2_btn_url" class="control-label">Button text <span class="symbol required">*</span></label>
                            <input type="text" name="sec2_btn_url" value="<?= $row['sec2_btn_url'] ?>" class="form-control" required>
                        </div>

                    </div>
                </div>
            </div>

            <h3>Section 3</h3>
            <div class="form-group">
                <div class="col-md-2">
                    <div class="form-group">

                        <div class="panel panel-primary" data-collapsed="0">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    Image
                                </div>
                                <div class="panel-options">
                                    <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="max-width: 310px; height: 110px;" data-trigger="fileinput">
                                        <img src="<?= !empty($row['image5']) ? get_site_image_src("images/", $row['image5']) : base_url('assets/images/no-image.svg') ?>" alt="--">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 320px; max-height: 160px; line-height: 6px;"></div>
                                    <div>
                                        <span class="btn btn-white btn-file">
                                            <span class="fileinput-new">Select image</span>
                                            <span class="fileinput-exists">Change</span>
                                            <input type="file" name="image5" accept="image/*" <?php if (empty($row['image5'])) {
                                                                                                    echo 'required=""';
                                                                                                } ?>>
                                        </span>
                                        <a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Remove</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-12">
                    <div class="form-group">

                        <div class="col-md-12">
                            <label for="sec3_heading" class="control-label"> Heading <span class="symbol required">*</span></label>
                            <input type="text" name="sec3_heading" value="<?= $row['sec3_heading'] ?>" class="form-control" required>
                        </div>
                        <div class="col-md-12">
                            <label for="sec3_detail" class="control-label">Text Block <span class="symbol required">*</span></label>
                            <textarea name="sec3_detail" rows="3" class="form-control ckeditor" id="editor"><?= $row['sec3_detail'] ?></textarea>
                        </div>

                        <div class="clearfix"></div>
                        <div class="col-md-6">
                            <label for="sec3_btn_text" class="control-label"> Button Text <span class="symbol required">*</span></label>
                            <input type="text" name="sec3_btn_text" value="<?= $row['sec3_btn_text'] ?>" class="form-control" required>
                        </div>


                        <div class="col-md-6">
                            <label for="sec3_btn_url" class="control-label">Button text <span class="symbol required">*</span></label>
                            <input type="text" name="sec3_btn_url" value="<?= $row['sec3_btn_url'] ?>" class="form-control" required>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-6">
                            <label for="sec3_btn_text_2" class="control-label"> Button 2 Text <span class="symbol required">*</span></label>
                            <input type="text" name="sec3_btn_text_2" value="<?= $row['sec3_btn_text_2'] ?>" class="form-control" required>
                        </div>


                        <div class="col-md-6">
                            <label for="sec3_btn_url_2" class="control-label">Button text <span class="symbol required">*</span></label>
                            <input type="text" name="sec3_btn_url_2" value="<?= $row['sec3_btn_url_2'] ?>" class="form-control" required>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                </div>
            </div>
    </div>

    <h3>Section 4</h3>
    <div class="form-group">
        <div class="col-md-2">
            <div class="form-group">

                <div class="panel panel-primary" data-collapsed="0">
                    <div class="panel-heading">
                        <div class="panel-title">
                            Image
                        </div>
                        <div class="panel-options">
                            <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-new thumbnail" style="max-width: 310px; height: 110px;" data-trigger="fileinput">
                                <img src="<?= !empty($row['image2']) ? get_site_image_src("images/", $row['image2']) : base_url('assets/images/no-image.svg') ?>" alt="--">
                            </div>
                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 320px; max-height: 160px; line-height: 6px;"></div>
                            <div>
                                <span class="btn btn-white btn-file">
                                    <span class="fileinput-new">Select image</span>
                                    <span class="fileinput-exists">Change</span>
                                    <input type="file" name="image2" accept="image/*" <?php if (empty($row['image2'])) {
                                                                                            echo 'required=""';
                                                                                        } ?>>
                                </span>
                                <a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Remove</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-10">
            <div class="form-group">
                <div class="col-md-12">
                    <label for="sec4_title" class="control-label"> Title <span class="symbol required">*</span></label>
                    <input type="text" name="sec4_title" value="<?= $row['sec4_title'] ?>" class="form-control" required>
                </div>

                <div class="col-md-12">
                    <label for="sec4_heading" class="control-label">Heading <span class="symbol required">*</span></label>
                    <input type="text" name="sec4_heading_1" value="<?= $row['sec4_heading_1'] ?>" class="form-control" required>
                </div>

                <div class="clearfix"></div>


                <div class="col-md-12">
                    <label for="sec4_detail" class="control-label"> Text Block <span class="symbol required">*</span></label>
                    <textarea name="sec4_detail" rows="3" class="form-control ckeditor" id="editor"><?= $row['sec4_detail'] ?></textarea>
                </div>

                <div class="clearfix"></div>
                <br>
                <div class="col-md-12">
                    <h4>Available On</h4>

                </div>
                <?php $sec5_cards = 0;
                for ($i = 3; $i <= 4; $i++) : ++$sec5_cards; ?>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="panel panel-primary" data-collapsed="0">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            Icon <?= $sec5_cards ?>
                                        </div>
                                        <div class="panel-options">
                                            <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail" style="max-width: 310px; height: 110px;background:#ddd" data-trigger="fileinput">
                                                <img src="<?= get_site_image_src("images/", $row['image' . $i]) ?>" alt="--">
                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 320px; max-height: 160px; line-height: 6px;"></div>
                                            <div>
                                                <span class="btn btn-white btn-file">
                                                    <span class="fileinput-new">Select image</span>
                                                    <span class="fileinput-exists">Change</span>
                                                    <input type="file" name="image<?= $i ?>" accept="image/*" <?php if (empty($row['image' . $i])) {
                                                                                                                    echo 'required=""';
                                                                                                                } ?>>
                                                </span>
                                                <a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Remove</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="clearfix"></div>
                            <div class="col-md-12">
                                <label for="img_link<?= $i ?>" class="control-label"> Image Link <?= $counter_count ?><span class="symbol required">*</span></label>
                                <input type="text" name="img_link<?= $i ?>" class="form-control" value="<?= $row['img_link' . $i] ?>" />
                            </div>
                        </div>
                    </div>
                <?php endfor ?>

                <div class="clearfix"></div>


            </div>
        </div>

        <div class="clearfix"></div>

    </div>


    <h3>Section 5 (Testimonials)</h3>
    <div class="form-group">

        <div class="col-md-12">
            <div class="form-group">
                <div class="col-md-12">
                    <label for="sec5_heading" class="control-label">Heading <span class="symbol required">*</span></label>
                    <input type="text" name="sec5_heading" value="<?= $row['sec5_heading'] ?>" class="form-control" required>
                </div>
                <div class="clearfix"></div>


                <div class="col-md-12">
                    <label for="sec5_detail" class="control-label"> Text Block <span class="symbol required">*</span></label>
                    <textarea name="sec5_detail" rows="3" class="form-control ckeditor" id="editor"><?= $row['sec5_detail'] ?></textarea>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-6">
                    <label for="sec5_btn_text" class="control-label"> Button Text <span class="symbol required">*</span></label>
                    <input type="text" name="sec5_btn_text" value="<?= $row['sec5_btn_text'] ?>" class="form-control" required>
                </div>


                <div class="col-md-6">
                    <label for="sec5_btn_url" class="control-label">Button text <span class="symbol required">*</span></label>
                    <input type="text" name="sec5_btn_url" value="<?= $row['sec5_btn_url'] ?>" class="form-control" required>
                </div>

            </div>
        </div>

        <div class="clearfix"></div>

    </div>



    <div class="form-group">
        <label for="field-1" class="col-sm-2 control-label "></label>
        <div class="col-sm-10">
            <button type="submit" class="btn btn-primary btn-lg col-md-3 pull-right"><i class="fa fa-save"></i> Save</button>
        </div>
    </div>
    </form>
</div>
</div>