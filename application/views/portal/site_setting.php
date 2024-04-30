<?php echo showMsg(); ?>
<?php echo getBredcrum(SUBADMIN, array('#' => 'Account Settings')); ?>
<div class="row margin-bottom-10">
    <div class="col-md-6">
        <!-- <h2 class="no-margin"><i class="entypo-window"></i> Update <strong>About Page</strong></h2> -->
        <h2 class="no-margin"><i class="fa fa-cogs"></i> Account <strong>Settings</strong></h2>
    </div>
    <!-- <div class="col-md-6 text-right">
        <a href="<?= site_url(SUBADMIN . '/settings/clear-cashe'); ?>" class="btn btn-lg btn-primary"><i class="fa fa-refresh"></i> Clear Cache</a>
    </div> -->
</div>
<hr>
<div class="row col-md-12">
    <form role="form" class="form-horizontal" action="<?= base_url(SUBADMIN) ?>/settings/save" method="post" enctype="multipart/form-data">

        <div class="col-md-6">
            <!-- <h3><i class="fa fa-bars"></i> Default Meta</h3>
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
            </div> -->
            <h3><i class="fa fa-bars"></i>Profile Details</h3>
            <hr class="hr-short">
            <div class="form-group">
                <div class="col-md-12">
                    <label class="control-label"> Name <span class="symbol required">*</span></label>
                    <input type="text" name="name" value="<?php if (isset($this->subadmin->name)) echo $this->subadmin->name; ?>" class="form-control" required>
                </div>
                <!-- <div class="clearfix"></div>
                <div class="col-md-12">
                    <label class="control-label"> Email <span class="symbol required">*</span></label>
                    <input type="email" name="email" value="<?php if (isset($this->subadmin->email)) echo $this->subadmin->email; ?>" class="form-control" required>
                </div> -->
            </div>

            <h3><i class="fa fa-bars"></i> Social Media</h3>
            <hr class="hr-short">
            <div class="form-group">
                <div class="col-md-12">
                    <label class="control-label"> Facebook Link <span class="symbol required"></span></label>
                    <input type="text" name="site_facebook" value="<?php if (isset($this->subadmin->site_facebook)) echo $this->subadmin->site_facebook; ?>" class="form-control">
                </div>
                <div class="clearfix"></div>
                <div class="col-md-12">
                    <label class="control-label"> Instagram Link <span class="symbol required"></span></label>
                    <input type="text" name="site_instagram" value="<?php if (isset($this->subadmin->site_instagram)) echo $this->subadmin->site_instagram; ?>" class="form-control">
                </div>
                <div class="clearfix"></div>
                <div class="col-md-12">
                    <label class="control-label"> Linkedin Link <span class="symbol required"></span></label>
                    <input type="text" name="site_linkedin" value="<?php if (isset($this->subadmin->site_linkedin)) echo $this->subadmin->site_linkedin; ?>" class="form-control">
                </div>
                <div class="clearfix"></div>
                <div class="col-md-12">
                    <label class="control-label"> X Link <span class="symbol required"></span></label>
                    <input type="text" name="site_twitter" value="<?php if (isset($this->subadmin->site_twitter)) echo $this->subadmin->site_twitter; ?>" class="form-control">
                </div>
                <div class="clearfix"></div>
            </div>

        </div>
        <div class="col-md-6">
            <h3><i class="fa fa-bars"></i> General Detail</h3>
            <hr class="hr-short">
            <!-- <div class="form-group">
                <div class="col-md-12">
                    <label class="control-label"> Site Domain <span class="symbol required"></span></label>
                    <input type="text" name="site_domain" value="<?php if (isset($this->subadmin->site_domain)) echo $this->subadmin->site_domain; ?>" class="form-control" required>
                </div>
            </div> -->
            <div class="form-group">
                <div class="col-md-12">
                    <label class="control-label"> Site Name <span class="symbol required"></span></label>
                    <input type="text" name="site_name" value="<?php if (isset($this->subadmin->site_name)) echo $this->subadmin->site_name; ?>" class="form-control" required>
                </div>
            </div>
            <!-- <div class="form-group">
                <div class="col-md-12">
                    <label class="control-label"> Copyright Message <span class="symbol required"></span></label>
                <input type="text" name="site_copyright" value="<?php if (isset($this->subadmin->site_copyright)) echo $this->subadmin->site_copyright; ?>" class="form-control" required>
                </div>
            </div> -->
            <div class="form-group">
                <div class="col-md-12">
                    <label class="control-label"> Site Admin Email <span class="symbol required"></span></label>
                    <input type="text" name="site_email" value="<?php if (isset($this->subadmin->site_email)) echo $this->subadmin->site_email; ?>" class="form-control" required>
                </div>
            </div>
            <!-- <div class="form-group">
                <div class="col-md-12">
                    <label class="control-label"> Site Events Email <span class="symbol required"></span></label>
                    <input type="text" name="site_events_email" value="<?php if (isset($this->subadmin->site_events_email)) echo $this->subadmin->site_events_email; ?>" class="form-control" required>
                </div>
            </div> -->
            <div class="form-group">
                <div class="col-md-12">
                    <label class="control-label"> Site Email <span class="symbol required"></span></label>
                    <input type="text" name="site_email" value="<?php if (isset($this->subadmin->site_email)) echo $this->subadmin->site_email; ?>" class="form-control" required>
                </div>
            </div>
            <!-- <div class="form-group">
                <div class="col-md-12">
                    <label class="control-label"> Site Order Related Inquiry Email <span class="symbol required"></span></label>
                    <input type="text" name="site_order_email" value="<?php if (isset($this->subadmin->site_order_email)) echo $this->subadmin->site_order_email; ?>" class="form-control" required>
                </div>
            </div> -->
            <!-- <div class="form-group">
                <div class="col-md-12">
                    <label class="control-label"> Site Recruitment Email <span class="symbol required"></span></label>
                    <input type="text" name="site_recruitment_email" value="<?php if (isset($this->subadmin->site_recruitment_email)) echo $this->subadmin->site_recruitment_email; ?>" class="form-control" required>
                </div>
            </div> -->
            <div class="form-group">
                <div class="col-md-12">
                    <label class="control-label"> Site No-Reply Email <span class="symbol required"></span></label>
                    <input type="text" name="site_noreply_email" value="<?php if (isset($this->subadmin->site_noreply_email)) echo $this->subadmin->site_noreply_email; ?>" class="form-control" required>
                </div>
            </div>

            <!-- <div class="form-group">
                <div class="col-md-12">
                    <label class="control-label"> Site No-Reply Email Password <span class="symbol required"></span></label>
                    <input type="text" name="site_noreply_email_password" value="<?php if (isset($this->subadmin->site_noreply_email_password)) echo $this->subadmin->site_noreply_email_password; ?>" class="form-control" required>
                </div>
            </div> -->
            <div class="form-group">
                <div class="col-md-12">
                    <label class="control-label"> Site Phone <span class="symbol required"></span></label>
                    <input type="text" name="site_phone" value="<?php if (isset($this->subadmin->site_phone)) echo $this->subadmin->site_phone; ?>" class="form-control" required>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <label class="control-label"> Address <span class="symbol required"></span></label>
                    <textarea rows="3" name="site_address" class="form-control"><?php if (isset($this->subadmin->site_address)) echo ($this->subadmin->site_address); ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <label class="control-label"> Footer Copyright Company <span class="symbol required"></span></label>
                    <textarea rows="2" name="site_copyright" class="form-control"><?php if (isset($this->subadmin->site_copyright)) echo ($this->subadmin->site_copyright); ?></textarea>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-12">
                    <label class="control-label"> Footer About <span class="symbol required"></span></label>
                    <textarea rows="2" name="site_about" class="form-control"><?php if (isset($this->subadmin->site_about)) echo ($this->subadmin->site_about); ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <label class="control-label"> Price Pump <span class="symbol required"></span></label>
                    <input type="number" name="price_pump" class="form-control" value="<?php if (isset($this->subadmin->price_pump)) echo ($this->subadmin->price_pump); ?>" />
                </div>
            </div>


        </div>

        <div class="clearfix"></div>
        <hr>
        <div class="col-md-12">
            <h3><i class="fa fa-bars"></i> Site Images</h3>
            <hr class="hr-short">
            <div class="form-group">
                <div class="col-md-4">
                    <div class="panel panel-primary" data-collapsed="0">
                        <div class="panel-heading">
                            <div class="panel-title">
                                Logo Image
                            </div>
                            <div class="panel-options">
                                <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="max-width: 310px; height: 110px;" data-trigger="fileinput">
                                    <img src="<?= get_site_image_src("images", $this->subadmin->site_logo) ?>" alt="--">
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 320px; max-height: 160px; line-height: 6px;"></div>
                                <div>
                                    <span class="btn btn-black btn-file">
                                        <span class="fileinput-new">Select image</span>
                                        <span class="fileinput-exists">Change</span>
                                        <input type="file" name="site_logo" accept="image/*" <?php if (empty($this->subadmin->site_logo)) {
                                                                                                    echo 'required=""';
                                                                                                } ?>>
                                    </span>
                                    <a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Remove</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
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
                                    <img src="<?= get_site_image_src("images", $this->subadmin->site_icon) ?>" alt="--">
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 320px; max-height: 160px; line-height: 6px;"></div>
                                <div>
                                    <span class="btn btn-black btn-file">
                                        <span class="fileinput-new">Select image</span>
                                        <span class="fileinput-exists">Change</span>
                                        <input type="file" name="site_icon" accept="image/*" <?php if (empty($this->subadmin->site_icon)) {
                                                                                                    echo 'required=""';
                                                                                                } ?>>
                                    </span>
                                    <a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Remove</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel panel-primary" data-collapsed="0">
                        <div class="panel-heading">
                            <div class="panel-title">
                                Thumb Image
                            </div>
                            <div class="panel-options">
                                <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="max-width: 310px; height: 110px;" data-trigger="fileinput">
                                    <img src="<?= get_site_image_src("images", $this->subadmin->site_thumb) ?>" alt="--">
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 320px; max-height: 160px; line-height: 6px;"></div>
                                <div>
                                    <span class="btn btn-black btn-file">
                                        <span class="fileinput-new">Select image</span>
                                        <span class="fileinput-exists">Change</span>
                                        <input type="file" name="site_thumb" accept="image/*" <?php if (empty($this->subadmin->site_thumb)) {
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


            </div>

        </div>

        <!-- <div class="col-md-6">
                    <div class="form-group">
                        <div class="col-md-12">
                            <label class="control-label"> Country</label>
                            <select id="loc_country" name="loc_country" class="form-control" required="required">
                                <option value="">- Select Country -</option>
                                <?= get_countries_options('id', $this->subadmin->loc_country) ?>
                                
                            </select>

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <label class="control-label"> State or City</label>
                            <input type="text" name="loc_city" value="<?php if (isset($this->subadmin->loc_city)) echo $this->subadmin->loc_city; ?>" class="form-control">
                        </div>
                    </div>
                </div> -->
        <!-- <div class="col-md-6">
                    <div class="form-group">
                        <div class="col-md-12">
                            <label class="control-label"> ZIP Code</label>
                            <input type="text" name="loc_zip" value="<?php if (isset($this->subadmin->loc_zip)) echo $this->subadmin->loc_zip; ?>" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <label class="control-label"> Address</label>
                            <input type="text" name="loc_address" value="<?php if (isset($this->subadmin->loc_address)) echo $this->subadmin->loc_address; ?>"  class="form-control">
                        </div>
                    </div> 
                </div> -->
        <div class="clearfix"></div>
        <div class="col-md-12">
            <hr class="hr-short">
            <div class="form-group text-right">
                <div class="col-md-12">
                    <input type="submit" class="btn btn-green btn-lg" value="Update Settings">
                </div>
            </div>
        </div>
        <br><br>
    </form>
</div>