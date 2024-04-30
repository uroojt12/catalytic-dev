<main>
    <section class="marin_page noti_detail">
        <div class="contain">
            <div class="inner">
                <div class="heading_1">
                    <h3>Notifications</h3>
                    <!-- <div class="crosBtn"></div> -->
                </div>
                <div class="top_area">

                    <div class="flex">
                        <div class="photo">
                            <div class="image">
                                <img src="<?= base_url() ?>assets/images/email.png" alt="">
                            </div>
                        </div>
                        <div class="content">
                            <p><?= $notification_deatil->txt ?></p>
                            <p><span><?= time_ago_date($notification_deatil->created_at) ?></span></p>
                        </div>
                    </div>
                </div>
                <?php $photo_grade = get_photo_grade($notification_deatil->grade_id); ?>
                <?php if (!empty($photo_grade) && !empty($photo_grade->admin_notes)) { ?>
                    <div class="detail">
                        <p><?= $photo_grade->admin_notes ?></p>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
</main>

<?php include_once('../includes/commonjs.php') ?>
<?php include_once('../includes/footer.php') ?>
</body>

</html>