<main>
    <section class="marin_page noti_detail notification_sec">
        <div class="contain">
            <div class="inner">
                <div class="heading_1">
                    <h3>Notifications</h3>
                </div>
                <?php if (!empty($notifications)) { ?>
                    <?php foreach ($notifications as $notification) { ?>
                        <a href="<?= base_url('notifications-details/' . $notification->id) ?>" class="top_area">

                            <div class="flex">
                                <div class="photo">
                                    <div class="image">
                                        <img src="<?= base_url() ?>assets/images/email.png" alt="">
                                    </div>
                                </div>
                                <div class="content">
                                    <p><?= $notification->txt ?></p>
                                    <p><span><?= time_ago_date($notification->created_at) ?></span></p>
                                </div>
                            </div>
                        </a>
                    <?php } ?>
                <?php } else { ?>
                    <div class="flex">
                        <div class="alert alert-danger"><?= 'No Notifications' ?></div>
                    </div>
                <?php } ?>
                <!-- <a href="notification_detail.php" class="top_area">

                    <div class="flex">
                        <div class="photo">
                            <div class="image">
                                <img src="<?= base_url() ?>assets/images/request.png" alt="">
                            </div>
                        </div>
                        <div class="content">
                            <p>Meg Griffin has left you a review. Both of your reviews from this trip are now
                                public.</p>
                            <p><span>March 1, 2023</span></p>
                        </div>
                    </div>
                </a>
                <a href="notification_detail.php" class="top_area">

                    <div class="flex">
                        <div class="photo">
                            <div class="image">
                                <img src="<?= base_url() ?>assets/images/email.png" alt="">
                            </div>
                        </div>
                        <div class="content">
                            <p>Meg Griffin has left you a review. Both of your reviews from this trip are now
                                public.</p>
                            <p><span>March 1, 2023</span></p>
                        </div>
                    </div>
                </a>
                <a href="notification_detail.php" class="top_area">

                    <div class="flex">
                        <div class="photo">
                            <div class="image">
                                <img src="<?= base_url() ?>assets/images/email.png" alt="">
                            </div>
                        </div>
                        <div class="content">
                            <p>Meg Griffin has left you a review. Both of your reviews from this trip are now
                                public.</p>
                            <p><span>March 1, 2023</span></p>
                        </div>
                    </div>
                </a>
                <a href="notification_detail.php" class="top_area">

                    <div class="flex">
                        <div class="photo">
                            <div class="image">
                                <img src="<?= base_url() ?>assets/images/request.png" alt="">
                            </div>
                        </div>
                        <div class="content">
                            <p>Meg Griffin has left you a review. Both of your reviews from this trip are now
                                public.</p>
                            <p><span>March 1, 2023</span></p>
                        </div>
                    </div>
                </a>
                <a href="notification_detail.php" class="top_area">

                    <div class="flex">
                        <div class="photo">
                            <div class="image">
                                <img src="<?= base_url() ?>assets/images/email.png" alt="">
                            </div>
                        </div>
                        <div class="content">
                            <p>Meg Griffin has left you a review. Both of your reviews from this trip are now
                                public.</p>
                            <p><span>March 1, 2023</span></p>
                        </div>
                    </div>
                </a>
                <a href="notification_detail.php" class="top_area">

                    <div class="flex">
                        <div class="photo">
                            <div class="image">
                                <img src="<?= base_url() ?>assets/images/request.png" alt="">
                            </div>
                        </div>
                        <div class="content">
                            <p>Meg Griffin has left you a review. Both of your reviews from this trip are now
                                public.</p>
                            <p><span>March 1, 2023</span></p>
                        </div>
                    </div>
                </a>
                <a href="notification_detail.php" class="top_area">

                    <div class="flex">
                        <div class="photo">
                            <div class="image">
                                <img src="<?= base_url() ?>assets/images/email.png" alt="">
                            </div>
                        </div>
                        <div class="content">
                            <p>Meg Griffin has left you a review. Both of your reviews from this trip are now
                                public.</p>
                            <p><span>March 1, 2023</span></p>
                        </div>
                    </div>
                </a> -->


            </div>
        </div>
    </section>
</main>

<?php include_once('../includes/commonjs.php') ?>
<?php include_once('../includes/footer.php') ?>
</body>

</html>