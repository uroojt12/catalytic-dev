<div class="row">

    <!-- Profile Info and Notifications -->
    <div class="col-md-8 col-sm-8 clearfix">
        <!-- <h2>Administration <small style="font-size: 12px">Last Login: <?= format_date($this->session->userdata('last_login')['time_date'], 'M d Y h:i:s A') ?> from ip:: <?= $this->session->userdata('last_login')['ip'] ?></small></h2> -->
        <h2><?= ucwords($this->subadmin->name) ?></h2>
    </div>
    <!-- Raw Links -->
    <div class="col-md-4 col-sm-4 clearfix">
        <ul class="list-inline links-list pull-right">
            <li>
                <a href="<?php echo base_url(SUBADMIN . '/settings'); ?>">
                    <i class="fa fa-cogs"></i> Settings
                </a>
            </li>
            <li>
                <a href="<?php echo base_url(); ?>" target="_blank">
                    <i class="entypo-globe right"></i> Website Preview
                </a>
            </li>
            <li>
                <a href="<?php echo base_url(SUBADMIN . '/logout'); ?>">
                    <i class="entypo-logout right"></i> Logout

                </a>

            </li>

        </ul>

    </div>

</div>
<hr class="hr-short">