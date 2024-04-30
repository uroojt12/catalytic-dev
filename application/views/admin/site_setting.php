<?= showMsg(); ?>
<?= getBredcrum(ADMIN, array('#' => 'Site Settings')); ?>
<div class="row margin-bottom-10">
    <div class="col-md-6">
        <!-- <h2 class="no-margin"><i class="entypo-window"></i> Update <strong>About Page</strong></h2> -->
        <h2 class="no-margin"><i class="fa fa-cogs"></i> Site <strong>Settings</strong></h2>
    </div>
    <div class="col-md-6 text-right">
        <a href="<?= site_url(ADMIN . '/settings/clear_cashe'); ?>" class="btn btn-lg btn-primary"><i class="fa fa-refresh"></i> Clear Cache</a>
    </div>
</div>
<hr>
<div class="row col-md-12">
    <form role="form" class="form-horizontal" action="" method="post" enctype="multipart/form-data">
        <div class="col-md-6">
            <h3><i class="fa fa-bars"></i> Default Meta</h3>
            <hr class="hr-short">
            <div class="form-group">
                <div class="col-md-12">
                    <label class="control-label"> Meta Description <span class="symbol required"></span></label>
                    <textarea rows="5" name="site_meta_desc" class="form-control" required autofocus=""><?php if (isset($adminsite_setting->site_meta_desc)) echo ($adminsite_setting->site_meta_desc); ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <label class="control-label"> Meta Keywords <span class="symbol required"></span></label>
                    <textarea rows="5" name="site_meta_keyword" class="form-control" required><?php if (isset($adminsite_setting->site_meta_keyword)) echo ($adminsite_setting->site_meta_keyword); ?></textarea>
                </div>
            </div>
            <h3><i class="fa fa-bars"></i> Social Media</h3>
            <hr class="hr-short">
            <div class="form-group">
                <div class="col-md-12">
                    <label class="control-label"> Instagram Link</label>
                    <input type="text" name="site_instagram" value="<?php if (isset($adminsite_setting->site_instagram)) echo $adminsite_setting->site_instagram; ?>" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <label class="control-label"> Facebook Link</label>
                    <input type="text" name="site_facebook" value="<?php if (isset($adminsite_setting->site_facebook)) echo $adminsite_setting->site_facebook; ?>" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <label class="control-label"> Linked Link</label>
                    <input type="text" name="site_linkedin" value="<?php if (isset($adminsite_setting->site_linkedin)) echo $adminsite_setting->site_linkedin; ?>" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <label class="control-label"> X Link</label>
                    <input type="text" name="site_twitter" value="<?php if (isset($adminsite_setting->site_twitter)) echo $adminsite_setting->site_twitter; ?>" class="form-control">
                </div>
            </div>
            <!-- <div class="form-group">
                <div class="col-md-12">
                    <label class="control-label"> Youtube Link</label>
                    <input type="text" name="site_youtube" value="<?php if (isset($adminsite_setting->site_youtube)) echo $adminsite_setting->site_youtube; ?>" class="form-control">
                </div>
            </div> -->
        </div>
        <div class="col-md-6">
            <h3><i class="fa fa-bars"></i> General Detail</h3>
            <hr class="hr-short">
            <div class="form-group">
                <div class="col-md-12">
                    <label class="control-label"> Site Domain <span class="symbol required"></span></label>
                    <input type="text" name="site_domain" value="<?php if (isset($adminsite_setting->site_domain)) echo $adminsite_setting->site_domain; ?>" class="form-control" required>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <label class="control-label"> Site Name <span class="symbol required"></span></label>
                    <input type="text" name="site_name" value="<?php if (isset($adminsite_setting->site_name)) echo $adminsite_setting->site_name; ?>" class="form-control" required>
                </div>
            </div>
            <!-- <div class="form-group">
                <div class="col-md-12">
                    <label class="control-label"> Copyright Message <span class="symbol required"></span></label>
                <input type="text" name="site_copyright" value="<?php if (isset($adminsite_setting->site_copyright)) echo $adminsite_setting->site_copyright; ?>" class="form-control" required>
                </div>
            </div> -->
            <div class="form-group">
                <div class="col-md-12">
                    <label class="control-label"> Site Admin Email <span class="symbol required"></span></label>
                    <input type="text" name="site_email" value="<?php if (isset($adminsite_setting->site_email)) echo $adminsite_setting->site_email; ?>" class="form-control" required>
                </div>
            </div>
            <!-- <div class="form-group">
                <div class="col-md-12">
                    <label class="control-label"> Site Events Email <span class="symbol required"></span></label>
                    <input type="text" name="site_events_email" value="<?php if (isset($adminsite_setting->site_events_email)) echo $adminsite_setting->site_events_email; ?>" class="form-control" required>
                </div>
            </div> -->
            <div class="form-group">
                <div class="col-md-12">
                    <label class="control-label"> Site Email <span class="symbol required"></span></label>
                    <input type="text" name="site_general_email" value="<?php if (isset($adminsite_setting->site_general_email)) echo $adminsite_setting->site_general_email; ?>" class="form-control" required>
                </div>
            </div>
            <!-- <div class="form-group">
                <div class="col-md-12">
                    <label class="control-label"> Site Order Related Inquiry Email <span class="symbol required"></span></label>
                    <input type="text" name="site_order_email" value="<?php if (isset($adminsite_setting->site_order_email)) echo $adminsite_setting->site_order_email; ?>" class="form-control" required>
                </div>
            </div> -->
            <!-- <div class="form-group">
                <div class="col-md-12">
                    <label class="control-label"> Site Recruitment Email <span class="symbol required"></span></label>
                    <input type="text" name="site_recruitment_email" value="<?php if (isset($adminsite_setting->site_recruitment_email)) echo $adminsite_setting->site_recruitment_email; ?>" class="form-control" required>
                </div>
            </div> -->
            <div class="form-group">
                <div class="col-md-12">
                    <label class="control-label"> Site No-Reply Email <span class="symbol required"></span></label>
                    <input type="text" name="site_noreply_email" value="<?php if (isset($adminsite_setting->site_noreply_email)) echo $adminsite_setting->site_noreply_email; ?>" class="form-control" required>
                </div>
            </div>

            <!-- <div class="form-group">
                <div class="col-md-12">
                    <label class="control-label"> Site No-Reply Email Password <span class="symbol required"></span></label>
                    <input type="text" name="site_noreply_email_password" value="<?php if (isset($adminsite_setting->site_noreply_email_password)) echo $adminsite_setting->site_noreply_email_password; ?>" class="form-control" required>
                </div>
            </div> -->
            <div class="form-group">
                <div class="col-md-12">
                    <label class="control-label"> Site Phone <span class="symbol required"></span></label>
                    <input type="text" name="site_phone" value="<?php if (isset($adminsite_setting->site_phone)) echo $adminsite_setting->site_phone; ?>" class="form-control" required>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <label class="control-label"> Address <span class="symbol required"></span></label>
                    <textarea rows="3" name="site_address" class="form-control"><?php if (isset($adminsite_setting->site_address)) echo ($adminsite_setting->site_address); ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <label class="control-label"> Footer Copyright Company <span class="symbol required"></span></label>
                    <textarea rows="2" name="site_copyright" class="form-control"><?php if (isset($adminsite_setting->site_copyright)) echo ($adminsite_setting->site_copyright); ?></textarea>
                </div>
            </div>


        </div>

        <!-- <div class="clearfix"></div>
        <h3><i class="fa fa-bars"></i> Pre Footer Settings</h3>
        <hr class="hr-short">
        <div class="col-md-12">
            <div class="form-group">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="col-md-6">
                            <label class="control-label" for="site_pre_footer_heading">Pre Footer Heading<span class="symbol required">*</span></label>
                            <input type="text" name="site_pre_footer_heading" value="<?php if (isset($adminsite_setting->site_pre_footer_heading)) echo $adminsite_setting->site_pre_footer_heading; ?>"  class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="control-label" for="site_pre_footer_tagline">Pre Footer Tagline<span class="symbol required">*</span></label>
                            <input type="text" name="site_pre_footer_tagline" value="<?php if (isset($adminsite_setting->site_pre_footer_tagline)) echo $adminsite_setting->site_pre_footer_tagline; ?>"  class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="control-label" for="site_pre_footer_field_text">Pre Footer Field Heading<span class="symbol required">*</span></label>
                            <input type="text" name="site_pre_footer_field_text" value="<?php if (isset($adminsite_setting->site_pre_footer_field_text)) echo $adminsite_setting->site_pre_footer_field_text; ?>"  class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="control-label" for="site_pre_footer_button_text">Pre Footer Field Button Text<span class="symbol required">*</span></label>
                            <input type="text" name="site_pre_footer_button_text" value="<?php if (isset($adminsite_setting->site_pre_footer_button_text)) echo $adminsite_setting->site_pre_footer_button_text; ?>"  class="form-control" required>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->


        <div class="clearfix"></div>
        <h3><i class="fa fa-bars"></i> Footer Settings</h3>
        <hr class="hr-short">
        <div class="col-md-12">

            <div class="form-group">
                <div class="col-md-12">
                    <label class="control-label" for="site_footer_text">Footer Text<span class="symbol required">*</span></label>

                    <textarea rows="5" name="site_footer_text" class="form-control"><?php if (isset($adminsite_setting->site_footer_text)) echo ($adminsite_setting->site_footer_text); ?></textarea>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-3">
                    <div class="form-group">
                        <div class="col-md-12">
                            <label class="control-label" for="site_first_section_heading">First Section Heading<span class="symbol required">*</span></label>
                            <input type="text" name="site_first_section_heading" value="<?php if (isset($adminsite_setting->site_first_section_heading)) echo $adminsite_setting->site_first_section_heading; ?>" class="form-control" required>
                        </div>
                        <!-- <div class="col-md-12">
                            <label class="control-label" for="site_first_section_sub_1">Address<span class="symbol required">*</span></label>
                            <input type="text" name="site_first_section_sub_1" value="<?php if (isset($adminsite_setting->site_first_section_sub_1)) echo $adminsite_setting->site_first_section_sub_1; ?>"  class="form-control" required>
                        </div> -->
                        <!-- <div class="col-md-12">
                            <label class="control-label" for="site_first_section_sub_2">Email<span class="symbol required">*</span></label>
                            <input type="text" name="site_first_section_sub_2" value="<?php if (isset($adminsite_setting->site_first_section_sub_2)) echo $adminsite_setting->site_first_section_sub_2; ?>"  class="form-control" required>
                        </div> -->
                        <!-- <div class="col-md-12">
                            <label class="control-label" for="site_first_section_sub_3">Phone<span class="symbol required">*</span></label>
                            <input type="text" name="site_first_section_sub_3" value="<?php if (isset($adminsite_setting->site_first_section_sub_3)) echo $adminsite_setting->site_first_section_sub_3; ?>"  class="form-control" required>
                        </div> -->
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <div class="col-md-12">
                            <label class="control-label" for="site_second_section_heading">Second Section Heading<span class="symbol required">*</span></label>
                            <input type="text" name="site_second_section_heading" value="<?php if (isset($adminsite_setting->site_second_section_heading)) echo $adminsite_setting->site_second_section_heading; ?>" class="form-control" required>
                        </div>

                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <div class="col-md-12">
                            <label class="control-label" for="site_third_section_heading">Third Section Heading<span class="symbol required">*</span></label>
                            <input type="text" name="site_third_section_heading" value="<?php if (isset($adminsite_setting->site_third_section_heading)) echo $adminsite_setting->site_third_section_heading; ?>" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <div class="col-md-12">
                            <label class="control-label" for="site_fourth_section_heading">Fourth Section Heading<span class="symbol required">*</span></label>
                            <input type="text" name="site_fourth_section_heading" value="<?php if (isset($adminsite_setting->site_fourth_section_heading)) echo $adminsite_setting->site_fourth_section_heading; ?>" class="form-control" required>
                        </div>
                        <div class="col-md-12">
                            <label class="control-label" for="site_fourth_section_sub_1">Field Heading<span class="symbol required">*</span></label>
                            <input type="text" name="site_fourth_section_sub_1" value="<?php if (isset($adminsite_setting->site_fourth_section_sub_1)) echo $adminsite_setting->site_fourth_section_sub_1; ?>" class="form-control" required>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="form-group">
                <div class="col-md-12">
                    <textarea rows="5" name="site_footer_text" class="form-control"><?php if (isset($adminsite_setting->site_footer_text)) echo ($adminsite_setting->site_footer_text); ?></textarea>
                </div>
            </div> -->
        </div>

        <div class="clearfix"></div>
        <h3><i class="fa fa-bars"></i> Site Prices</h3>
        <hr class="hr-short">
        <div class="col-md-12">
            <div class="form-group">

                <div class="col-md-6">
                    <label class="control-label" for="site_o_pt_price">Original PT price<span class="symbol required">*</span></label>
                    <input type="number" min="0" step="any" name="site_o_pt_price" value="<?php if (isset($adminsite_setting->site_o_pt_price)) echo $adminsite_setting->site_o_pt_price; ?>" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="control-label" for="site_live_pt_price">Live PT Price<span class="symbol required">*</span></label>
                    <input type="number" min="0" step="any" name="site_live_pt_price" value="<?php if (isset($adminsite_setting->site_live_pt_price)) echo $adminsite_setting->site_live_pt_price; ?>" class="form-control" required>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-6">
                    <label class="control-label" for="site_o_pd_price">Original PD Price<span class="symbol required">*</span></label>
                    <input type="number" min="0" step="any" name="site_o_pd_price" value="<?php if (isset($adminsite_setting->site_o_pd_price)) echo $adminsite_setting->site_o_pd_price; ?>" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="control-label" for="site_live_pd_price">Live PD Price<span class="symbol required">*</span></label>
                    <input type="number" min="0" step="any" name="site_live_pd_price" value="<?php if (isset($adminsite_setting->site_live_pd_price)) echo $adminsite_setting->site_live_pd_price; ?>" class="form-control" required>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-6">
                    <label class="control-label" for="site_o_rh_price">Original RH Price<span class="symbol required">*</span></label>
                    <input type="number" min="0" step="any" name="site_o_rh_price" value="<?php if (isset($adminsite_setting->site_o_rh_price)) echo $adminsite_setting->site_o_rh_price; ?>" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="control-label" for="site_live_rh_price">Live RH Price<span class="symbol required">*</span></label>
                    <input type="number" min="0" step="any" name="site_live_rh_price" value="<?php if (isset($adminsite_setting->site_live_rh_price)) echo $adminsite_setting->site_live_rh_price; ?>" class="form-control" required>
                </div>
            </div>

        </div>


        <div class="clearfix"></div>
        <div class="col-md-12">
            <hr class="hr-short">
            <div class="form-group">
                <div class="col-md-3">
                    <div class="panel panel-primary" data-collapsed="0">
                        <div class="panel-heading">
                            <div class="panel-title">
                                Fav Icon
                            </div>
                            <div class="panel-options">
                                <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="max-width: 310px; height: 110px;" data-trigger="fileinput">
                                    <img src="<?= get_site_image_src("images/", $adminsite_setting->site_icon) ?>" alt="--">
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 320px; max-height: 160px; line-height: 6px;"></div>
                                <div>
                                    <span class="btn btn-white btn-file">
                                        <span class="fileinput-new">Select image</span>
                                        <span class="fileinput-exists">Change</span>
                                        <input type="file" name="icon_image" accept="image/*" <?php if (empty($adminsite_setting->site_icon)) {
                                                                                                    echo 'required=""';
                                                                                                } ?>>
                                    </span>
                                    <a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Remove</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="panel panel-primary" data-collapsed="0">
                        <div class="panel-heading">
                            <div class="panel-title">
                                Website Logo
                            </div>
                            <div class="panel-options">
                                <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="max-width: 310px; height: 110px;" data-trigger="fileinput">
                                    <img src="<?= get_site_image_src("images/", $adminsite_setting->site_logo) ?>" alt="--">
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 320px; max-height: 160px; line-height: 6px;"></div>
                                <div>
                                    <span class="btn btn-white btn-file">
                                        <span class="fileinput-new">Select image</span>
                                        <span class="fileinput-exists">Change</span>
                                        <input type="file" name="logo_image" accept="image/*" <?php if (empty($adminsite_setting->site_logo)) {
                                                                                                    echo 'required=""';
                                                                                                } ?>>
                                    </span>
                                    <a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Remove</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-md-3">
                    <div class="panel panel-primary" data-collapsed="0">
                        <div class="panel-heading">
                            <div class="panel-title">
                                Footer Logo
                            </div>
                            <div class="panel-options">
                                <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="max-width: 310px; height: 110px;" data-trigger="fileinput">
                                    <img src="</?= get_site_image_src("images/", $adminsite_setting->site_footer_logo) ?>" alt="--">
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 320px; max-height: 160px; line-height: 6px;"></div>
                                <div>
                                    <span class="btn btn-white btn-file">
                                        <span class="fileinput-new">Select image</span>
                                        <span class="fileinput-exists">Change</span>
                                        <input type="file" name="footer_logo_image" accept="image/*" </?php if (empty($adminsite_setting->site_footer_logo)) {
                                                                                                            echo 'required=""';
                                                                                                        } ?>>
                                    </span>
                                    <a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Remove</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
                <div class="col-md-3">
                    <div class="panel panel-primary" data-collapsed="0">
                        <div class="panel-heading">
                            <div class="panel-title">
                                Email Logo (*use png)
                            </div>
                            <div class="panel-options">
                                <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="max-width: 310px; height: 110px;" data-trigger="fileinput">
                                    <img src="<?= get_site_image_src("images/", $adminsite_setting->site_thumb) ?>" alt="--">
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 320px; max-height: 160px; line-height: 6px;"></div>
                                <div>
                                    <span class="btn btn-white btn-file">
                                        <span class="fileinput-new">Select image</span>
                                        <span class="fileinput-exists">Change</span>
                                        <input type="file" name="thumb_image" accept="image/*" <?php if (empty($adminsite_setting->site_thumb)) {
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
            <div class="form-group text-right">
                <div class="col-md-12">
                    <input type="submit" class="btn btn-green btn-lg" value="Update Settings">
                </div>
            </div>
        </div>
        <br><br>
    </form>
</div>