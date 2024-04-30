<main>
    <!-- ====== -->
    <section class="small_banner" style="background-image:url('<?= get_site_image_src("images/", $site_content['image1']) ?>')">
        <div class="contain">
            <div class="inner">
                <div class="sec_heading">
                    <h2><?= $site_content['banner_heading'] ?></h2>
                </div>
                <div class="content">
                    <p><?= $site_content['banner_detail'] ?></p>
                </div>
            </div>
        </div>
    </section>
    <!-- ======= -->
    <section class="sec_inventory sec_photo_grade">
        <div class="contain">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a class="a" data-toggle="tab" href="#active">
                        Pending</a>
                </li>

                <li>
                    <a class="b" data-toggle="tab" href="#closed">
                        Completed</a>
                </li>

                <li>
                    <a class="c" data-toggle="tab" href="#rejected">
                        Rejected</a>
                </li>

            </ul>
            <div class="tab-content">
                <div id="active" class="tab-pane fade a active in">
                    <div class="flex">
                        <?php foreach ($pend_photo_grade as $p_photo) : ?>
                            <div class="cols">
                                <div class="inner">
                                    <div class="image-1">
                                        <img src="<?= get_site_image_src('photo_grade', $p_photo->grade_image); ?>" alt="no_image">
                                    </div>
                                    <div class="content">
                                        <!-- <p><?= $photo->code ?></p> -->
                                        <h4>
                                             <?= $p_photo->status ?>
                                        </h4>
                                        <div class="total_flex">
                                            <div><strong>Fullness</strong></div>
                                             <div><?= $p_photo->grade_fullness ?></div>
                                        </div>
                                        
                                        <!-- <div class="cta-1">
                                            <a href="javascript:void(0)" class="style_it popBtn" data-popup="add_new_lot">Add</a>
                                        </div> -->
                                    </div>

                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>
                    <div class="cta">
                        <a href="<?= base_url('new-photo-grade') ?>" class="webBtn">New Photo Grade</a>
                    </div>
                </div>
                <div id="closed" class="tab-pane fade b">
                    <div class="flex">
                        <?php foreach ($comp_photo_grade as $c_photo) : ?>
                            <div class="cols">
                                <div class="inner">
                                    <div class="image-1">
                                        <img src="<?= get_site_image_src('photo_grade', $c_photo->grade_image); ?>" alt="no_image">
                                    </div>
                                    <div class="content">
                                        <!-- <p><?= $photo->code ?></p> -->
                                        <h4>
                                            <?= $c_photo->status ?>
                                        </h4>
                                        <div class="total_flex">
                                            <div><strong>Fullness</strong></div>
                                             <div><?= $c_photo->grade_fullness ?></div>
                                        </div>
                                        <div class="devide_line"></div>
                                        <div class="total_flex">
                                            <div><strong>Amount</strong></div>
                                             <div><?= format_amount($c_photo->price) ?></div>
                                        </div>
                                        <div class="devide_line"></div>
                                        <div class="total_flex">
                                            <div><strong>Notes</strong></div>
                                             <div><?= $c_photo->grade_notes ?></div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        <?php endforeach ?>

                    </div>
                    <div class="cta">
                        <a href="<?= base_url('new-photo-grade') ?>" class="webBtn">New Photo Grade</a>
                    </div>
                </div>
                <div id="rejected" class="tab-pane fade c">
                    <div class="flex">
                        <?php foreach ($rej_photo_grade as $r_photo) : ?>
                            <div class="cols">
                                <div class="inner">
                                    <div class="image-1">
                                        <img src="<?= get_site_image_src('photo_grade', $r_photo->grade_image); ?>" alt="no_image">
                                    </div>
                                    <div class="content">
                                        <!-- <p><?= $photo->code ?></p> -->
                                        <h4>
                                            <?= $r_photo->grade_fullness ?> | <?= $r_photo->status ?>
                                            <!-- <a href="<?= base_url('photo-detail/' . urlencode(doEncode($photo->id))) ?>"><?= format_amount($photo->price) ?> | <?= $photo->percentage ?>
                                            </a> -->
                                        </h4>
                                        <div class="total_flex">
                                            <div><strong>Fullness</strong></div>
                                             <div><?= $r_photo->grade_fullness ?></div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        <?php endforeach ?>

                    </div>
                    <div class="cta">
                        <a href="<?= base_url('new-photo-grade') ?>" class="webBtn">New Photo Grade</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>

<?php include_once('popups.php') ?>