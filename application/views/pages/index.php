<main>
    <!-- =========================banner=================== -->
    <section id="banner" class="two_cols">
        <div class="contain">
            <div class="flex">
                <div class="cols col1">
                    <div class="inner">
                        <div class="head">
                            <h1></h1>
                        </div>
                        <div class="sec_content">
                            <p><?= $site_content['banner_detail'] ?></p>
                        </div>
                        <div class="cta">
                            <a href="<?= $site_content['banner_btn_url'] ?>" class="webBtn"><?= $site_content['banner_btn_text'] ?></a>
                        </div>
                        <?php if ($member_data->mem_headge_prices == '1' && $member_data->mem_live_pt_price > 0 && $member_data->mem_live_pd_price > 0 && $member_data->mem_live_rh_price > 0) { ?>

                            <ul class="listing">
                                <li>
                                    <a href="" class="inside">
                                        <h3><?= $site_content['ban_title1'] ?></h3>
                                        <h4><?= format_amount($member_data->mem_live_pt_price) ?></h4>
                                        <p><strong>+<?= $site_content['ban_fullness1'] ?>%</strong></p>

                                    </a>
                                </li>
                                <li>
                                    <a href="" class="inside">
                                        <h3><?= $site_content['ban_title2'] ?></h3>
                                        <h4><?= format_amount($member_data->mem_live_pd_price) ?></h4>
                                        <p><strong>+<?= $site_content['ban_fullness2'] ?>%</strong></p>

                                    </a>
                                </li>
                                <li>
                                    <a href="" class="inside">
                                        <h3><?= $site_content['ban_title3'] ?></h3>
                                        <h4><?= format_amount($member_data->mem_live_rh_price) ?></h4>
                                        <p><strong>+<?= $site_content['ban_fullness3'] ?>%</strong></p>

                                    </a>
                                </li>
                            </ul>
                        <?php } elseif ($sub_site_settings->site_live_pt_price > 0 && $sub_site_settings->site_live_pd_price > 0 && $sub_site_settings->site_live_rh_price > 0) { ?>
                            <ul class="listing">
                                <li>
                                    <a href="" class="inside">
                                        <h3><?= $site_content['ban_title1'] ?></h3>
                                        <h4><?= format_amount($sub_site_settings->site_live_pt_price) ?></h4>
                                        <p><strong>+<?= $site_content['ban_fullness1'] ?>%</strong></p>

                                    </a>
                                </li>
                                <li>
                                    <a href="" class="inside">
                                        <h3><?= $site_content['ban_title2'] ?></h3>
                                        <h4><?= format_amount($sub_site_settings->site_live_pd_price) ?></h4>
                                        <p><strong>+<?= $site_content['ban_fullness2'] ?>%</strong></p>

                                    </a>
                                </li>
                                <li>
                                    <a href="" class="inside">
                                        <h3><?= $site_content['ban_title3'] ?></h3>
                                        <h4><?= format_amount($sub_site_settings->site_live_rh_price) ?></h4>
                                        <p><strong>+<?= $site_content['ban_fullness3'] ?>%</strong></p>

                                    </a>
                                </li>
                            </ul>
                        <?php } else { ?>
                            <ul class="listing">
                                <li>
                                    <a href="" class="inside">
                                        <h3><?= $site_content['ban_title1'] ?></h3>
                                        <h4><?= format_amount($sup_site_settings->site_live_pt_price) ?></h4>
                                        <p><strong>+<?= $site_content['ban_fullness1'] ?>%</strong></p>

                                    </a>
                                </li>
                                <li>
                                    <a href="" class="inside">
                                        <h3><?= $site_content['ban_title2'] ?></h3>
                                        <h4><?= format_amount($sup_site_settings->site_live_pd_price) ?></h4>
                                        <p><strong>+<?= $site_content['ban_fullness2'] ?>%</strong></p>

                                    </a>
                                </li>
                                <li>
                                    <a href="" class="inside">
                                        <h3><?= $site_content['ban_title3'] ?></h3>
                                        <h4><?= format_amount($sup_site_settings->site_live_rh_price) ?></h4>
                                        <p><strong>+<?= $site_content['ban_fullness3'] ?>%</strong></p>

                                    </a>
                                </li>
                            </ul>
                        <?php  } ?>
                    </div>
                </div>
                <div class="cols col2">
                    <div class="image">
                        <img src="<?= get_site_image_src("images/", $site_content['image1']) ?>" alt="">
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- ======sec_sell_products======= -->
    <section class="sec_sell_products">
        <div class="contain">
            <div class="sec_heading">
                <div class="title">
                    <div class="title_img"><img src="<?= base_url() ?>assets/images/title_img.svg" alt=""></div>
                    <p><strong><?= $site_content['sec2_title'] ?>T</strong></p>
                </div>
                <h2><?= $site_content['sec2_heading'] ?></h2>
            </div>
            <div class="sec_content">
                <p><?= $site_content['sec2_detail'] ?></p>
            </div>
            <div class="flex">
                <?php foreach ($top_code as $top) :
                ?>
                    <div class="cols">
                        <div class="inner">

                            <div class="image_2 popBtn" data-popup="code_image" data-image-url="<?= get_site_code_image_src("code", $top->image, $site_settings) ?>">
                                <img src="<?= get_site_code_image_src("code", $top->image, $site_settings) ?>" alt="<?= $site_settings->site_name ?>" alt="">
                            </div>
                            <div class="content">
                                <h5><?= $top->title ?></h5>
                                <p><?= $top->code ?></p>
                                
                                 <?php if (!empty($this->session->mem_id) && $member_data->mem_verified > 0 ) { ?>
                                <div class="cta_price">
                                    <h5><strong><?= format_amount($top->total_price) ?></strong>
                                    </h5>
                                    <div class="cta">
                                        <!-- <a href="javascript:void(0)" class="webBtn popBtn" data-popup="add_code">Add</a> -->
                                        <a href="javascript:void(0)" class="webBtn popBtn" data-lot_type="<?= ($top->type) ?>" data-inventory_id="<?= ($top->id) ?>" data-popup="add_code">Add</a>

                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
            <div class="cta_blow">
                <a href="<?= $site_content['sec2_btn_url'] ?>" class="webBtn"><?= $site_content['sec2_btn_text'] ?></a>
            </div>
        </div>
    </section>
    <!-- =====sec_cta===== -->
    <section class="sec_cta two_cols">
        <div class="image">
            <img src="<?= get_site_image_src("images/", $site_content['image5']) ?>" alt="">
        </div>
        <div class="flex">
            <div class="cols col1">

            </div>
            <div class="cols col2">
                <div class="inner">
                    <div class="sec_heading">
                        <h2><?= $site_content['sec3_heading'] ?></h2>
                    </div>
                    <div class="sec_content">
                        <p><?= $site_content['sec3_detail'] ?></p>
                    </div>
                    <ul class="cta">
                        <li>
                            <a href="<?= $site_content['sec3_btn_url'] ?>" class="webBtn"><?= $site_content['sec3_btn_text'] ?></a>
                        </li>
                        <li>
                            <a href="<?= $site_content['sec3_btn_url_2'] ?>" class="webBtn colorBtn"><?= $site_content['sec3_btn_text_2'] ?></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- ======sec_app======= -->
    <section class="sec_app">
        <div class="contain">
            <div class="sec_heading">
                <div class="title">
                    <div class="title_img"><img src="<?= base_url() ?>assets/images/title_img.svg" alt=""></div>
                    <p><strong><?= $site_content['sec4_title'] ?></strong></p>
                </div>
                <h2><?= $site_content['sec4_heading_1'] ?></h2>
            </div>
            <div class="sec_content">
                <p><?= $site_content['sec4_detail'] ?></p>
            </div>
            <div class="image">
                <img src="<?= get_site_image_src("images/", $site_content['image2']) ?>" alt="">
            </div>
            <ul class="cta">
                <li>
                    <a href="<?= $site_content['img_link3'] ?>"> <img src="<?= get_site_image_src("images/", $site_content['image3']) ?>" alt=""></a>
                </li>
                <li>
                    <a href="<?= $site_content['img_link4'] ?>"> <img src="<?= get_site_image_src("images/", $site_content['image4']) ?>" alt=""></a>
                </li>
            </ul>
        </div>
    </section>

    <!-- =====testimonials======= -->
    <section class="testimonials">
        <div class="contain">
            <div class="flex">
                <div class="cols col1">
                    <div class="sec_heading">
                        <h2><?= $site_content['sec5_heading'] ?></h2>
                    </div>
                    <div class="sec_content">
                        <p><?= $site_content['sec5_detail'] ?></p>
                    </div>
                    <div class="cta">
                        <a href="<?= $site_content['sec5_btn_url'] ?>" class="webBtn"><?= $site_content['sec5_btn_text'] ?></a>
                    </div>
                </div>
                <div class="col2">
                    <div class="owl-carousel testi-carousel">
                        <?php foreach ($testimonials as $testimonial) : ?>
                            <div class="item">
                                <div class="inside">
                                    <div class="inner">
                                        <div class="content">
                                            <div class="image">
                                                <img src="<?= get_site_image_src('testimonials', $testimonial->image, 'thumb_', true); ?>" alt="No Image">
                                            </div>
                                            <div class="name-profession">
                                                <span class="profession">
                                                    <p>
                                                        <?= $testimonial->detail ?>
                                                    </p>
                                                </span>
                                                <div class="lower">
                                                    <div class="lower-cntnt">
                                                        <span class="name"> <?= $testimonial->name ?></span>
                                                        <span class="scale"> <?= $testimonial->designation ?></span>
                                                    </div>
                                                    <div class="quote">
                                                        <img src="<?= base_url() ?>assets/images/quote.png" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>

            </div>
        </div>

    </section>
</main>

<?php include_once('popups.php') ?>