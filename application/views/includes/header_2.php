<header class="dash_header">
    <div class="contain">
        <div class="logo">
            <a href="<?= base_url() ?>" style="display: block;">
                <img src="<?= base_url() . 'uploads/images/' . $site_settings->site_logo . '?v-' . $site_settings->site_version ?>" alt="<?= $site_settings->site_name ?>">
            </a>
        </div>
        <nav class="ease">
            <ul class="center pull-right" id="nav">

                <li class="<?php if ($page == "inventory") {
                                echo 'active';
                            } ?>">
                    <a href="<?= base_url('inventory') ?>">Inventory</a>
                </li>

                <!-- <li class="desk_view">
                    <a href="margin.php">Margin</a>
                </li> -->
                <li id="likeBtn" class="_dropDown">
                    <div class="iconBtn _dropBtn">
                        <a href="<?= base_url('notifications') ?>" class="inner">
                            <img src="<?= base_url() ?>assets/images/ringing.png" alt="">
                        </a>
                    </div>
                    <!-- <div class="_dropCnt lg_drop notification_listing">
                        <ul class="dropLst">
                            <li>
                                <div class="notify_header">
                                    <h5>Notifications</h5>
                                   <form action="</?= base_url('account/clear_all') ?>" method="POST" class="frmAjax"> 
                                    <a href="#" id="clear-all">Clear All</a>
                                   </form> 
                                </div>
                            </li>
                            <li>
                                <a href="</?= base_url('notifications') ?>" class="inner">
                                    <div class="user_sm_icon color_icon_notify">
                                        <img src="</?= base_url() ?>assets/images/email.png" alt="">
                                    </div>
                                    </?php $unread_notification = new_notifications($member->mem_id);
                                    // pr($unread_notification);
                                    if ($unread_notification > 0) {
                                    ?>
                                        <div class="notify_cntnt">
                                            <p>
                                                <strong></?= $unread_notification ?> new Messages</strong>
                                            </p>
                                            <div class="para">Photo Grade Request Status
                                            </div>
                                            <div class="time-ago">
                                                <i class="fa fa-clock-o" aria-hidden="true"></i> 1 hour ago
                                            </div>
                                        </div>
                                    </?php } else { ?>
                                        <div class="notify_cntnt">
                                            <p>
                                                <strong>2 new Messages</strong>
                                            </p>
                                            <div class="para">No Messages
                                            </div>
                                            <div class="time-ago">
                                                <i class="fa fa-clock-o" aria-hidden="true"></i> 1 hour ago
                                            </div>
                                        </div>

                                    </?php } ?>
                                </a>
                            </li>
                            <li>
                                <a href="notification.php" class="inner">
                                    <div class="user_sm_icon color_icon_notify">
                                        <img src="</?= base_url() ?>assets/images/comment.png" alt="">
                                    </div>
                                    <div class="notify_cntnt">
                                        <p>
                                            <strong>3 new Comments</strong>
                                        </p>
                                        <div class="para">Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                        </div>
                                        <div class="time-ago">
                                            <i class="fa fa-clock-o" aria-hidden="true"></i> 2 hour ago
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="notification.php" class="inner">
                                    <div class="user_sm_icon color_icon_notify">
                                        <img src="</?= base_url() ?>assets/images/request.png" alt="">
                                    </div>
                                    <div class="notify_cntnt">
                                        <p>
                                            <strong>2 Requests</strong>
                                        </p>
                                        <div class="para">Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                        </div>
                                        <div class="time-ago">
                                            <i class="fa fa-clock-o" aria-hidden="true"></i> 2 hour ago
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <div class="notify_footer">
                                    <a href="</?= base_url('notifications') ?>">View all notifications</a>
                                    <i class="fa fa-arrow-right"></i>
                                </div>
                            </li>
                        </ul>
                    </div> -->
                </li>
                <li>
                    <div class="proIco _dropDown">
                        <div class="ico _dropBtn">
                            <!-- <div class="image">
                                <img src="<?= base_url() ?>assets/images/team-1.jpeg" alt="">
                            </div> -->
                            <div class="name">
                                <h6><?= $member_data->mem_fname . " " . $member_data->mem_lname ?></h6>
                                <i class="fa fa-chevron-down"></i>
                            </div>
                        </div>
                        <div class="proDrop _dropCnt profileCnt">
                            <ul class="dropLst">
                                <li>
                                    <div class="user_header">
                                        <h5><?= $member_data->mem_fname . " " . $member_data->mem_lname ?></h5>
                                        <p></p>
                                    </div>
                                </li>
                                <li>
                                    <a class="" href="<?= base_url('dashboard') ?>">
                                        <span>Dashboard</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="" href="<?= base_url('inventory') ?>">
                                        <span>Inventory</span>
                                    </a>
                                </li>


                                <li><a href="<?= base_url('signout') ?>"> <span>Logout</span></a></li>


                            </ul>
                        </div>
                    </div>
                </li>
            </ul>

        </nav>
    </div>

</header>