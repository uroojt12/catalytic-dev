<main>
    <!-- ====== -->
    <section class="small_banner sec_desktop_form" style="background-image:url('<?= get_site_image_src("images/", $site_content['image1']) ?>')">
        <div class="contain">
            <div class="inner">
                <div class="sec_heading">
                    <h2><?= $site_content['banner_heading'] ?></h2>
                </div>
                <div class="search">
                    <form action="" method="post" class="code_form filter-form">

                        <input type="text" name="search_code" placeholder="Search by Code" class="txtBox search_code">
                        <div class="button">
                            <button>
                                <div class="image"><img src="<?= base_url() ?>assets/images/search.svg" alt=""></div>
                            </button>

                        </div>
                        <div class="button">
                            <a href="javascript:void(0)" class="close-image remove-data hidden">
                                <div class="image"><img src="<?= base_url() ?>assets/images/close.svg" alt=""></div>
                            </a>
                        </div>

                        <!-- <select name="brands" id="select_brand" class="txtBox" style="width: 25%; margin-top: 10px;">
                            <option value="all_brands">All Brands</option>
                            <?php foreach ($all_categories as $category) { ?>
                                <option value="<?= $category->name ?>"><?= ucwords($category->name) ?></option>
                            <?php  } ?>

                        </select> -->
                        <div class="hidden search_items_code">
                    </form>
                </div>
                <div class="cta">
                    <a href="<?= base_url('generics') ?>" class="style_it"><?= $site_content['banner_btn_text'] ?></a>
                </div>

                <?php if ($member_data->mem_headge_prices == '1' && $member_data->mem_live_pt_price > 0 && $member_data->mem_live_pd_price > 0 && $member_data->mem_live_rh_price > 0) { ?>

                    <ul class="listing">
                        <li>
                            <a href="" class="inside">
                                <h3>Platinum</h3>
                                <h4><?= format_amount($member_data->mem_live_pt_price) ?> 
                                <!--<img src="<?= base_url() ?>assets/images/crt_down.svg" alt="">-->
                                </h4>
                                <!-- <p><strong>+90%</strong></p> -->

                            </a>
                        </li>
                        <li>
                            <a href="" class="inside">
                                <h3>Palladium</h3>
                                <h4><?= format_amount($member_data->mem_live_pd_price) ?> 
                                <!--<img src="<?= base_url() ?>assets/images/crt_up.svg" alt="">-->
                                </h4>
                                <!-- <p><strong>+100%</strong></p> -->

                            </a>
                        </li>
                        <li>
                            <a href="" class="inside">
                                <h3>Rhodium</h3>
                                <h4><?= format_amount($member_data->mem_live_rh_price) ?></h4>
                                <!-- <p><strong>+55%</strong></p> -->

                            </a>
                        </li>
                    </ul>
                    <div class="update">
                        <p>update <?= detectDay(); ?></p>
                    </div>
                <?php } elseif ($sub_site_settings->site_live_pt_price > 0 && $sub_site_settings->site_live_pd_price > 0 && $sub_site_settings->site_live_rh_price > 0) { ?>


                    <ul class="listing">
                        <li>
                            <a href="" class="inside">
                                <h3>Platinum</h3>
                                <h4><?= format_amount($sub_site_settings->site_live_pt_price) ?> 
                                <!--<img src="<?= base_url() ?>assets/images/crt_down.svg" alt="">-->
                                </h4>
                                <!-- <p><strong>+90%</strong></p> -->

                            </a>
                        </li>
                        <li>
                            <a href="" class="inside">
                                <h3>Palladium</h3>
                                <h4><?= format_amount($sub_site_settings->site_live_pd_price) ?> 
                                <!--<img src="<?= base_url() ?>assets/images/crt_up.svg" alt="">-->
                                </h4>
                                <!-- <p><strong>+100%</strong></p> -->

                            </a>
                        </li>
                        <li>
                            <a href="" class="inside">
                                <h3>Rhodium</h3>
                                <h4><?= format_amount($sub_site_settings->site_live_rh_price) ?></h4>
                                <!-- <p><strong>+55%</strong></p> -->

                            </a>
                        </li>

                    </ul>
                    <div class="update">
                        <p>update <?= detectDay(); ?></p>
                    </div>

                <?php } else { ?>


<ul class="listing">
    <li>
        <a href="" class="inside">
            <h3>Platinum</h3>
            <h4><?= format_amount($sup_site_settings->site_live_pt_price) ?></h4>
         <?php if (isset($pt_price_percent) && $pt_price_percent != 0): ?>
    <p>
        <?php if ($pt_price_percent > 0): ?>
            <span style="color:green;">▲ <?= number_format($pt_price_percent, 2) ?>%</span>
        <?php else: ?>
            <span style="color:red;">▼ <?= number_format(abs($pt_price_percent), 2) ?>%</span>
        <?php endif; ?>
    </p>
<?php endif; ?>

        </a>
    </li>

    <li>
        <a href="" class="inside">
            <h3>Palladium</h3>
            <h4><?= format_amount($sup_site_settings->site_live_pd_price) ?></h4>
         <?php if (isset($pd_price_percent) && $pd_price_percent != 0): ?>
    <p>
        <?php if ($pd_price_percent > 0): ?>
            <span style="color:green;">▲ <?= number_format($pd_price_percent, 2) ?>%</span>
        <?php else: ?>
            <span style="color:red;">▼ <?= number_format(abs($pd_price_percent), 2) ?>%</span>
        <?php endif; ?>
    </p>
<?php endif; ?>

        </a>
    </li>

    <li>
        <a href="" class="inside">
            <h3>Rhodium</h3>
            <h4><?= format_amount($sup_site_settings->site_live_rh_price) ?></h4>
        <?php if (isset($rh_price_percent) && $rh_price_percent != 0): ?>
    <p>
        <?php if ($rh_price_percent > 0): ?>
            <span style="color:green;">▲ <?= number_format($rh_price_percent, 2) ?>%</span>
        <?php else: ?>
            <span style="color:red;">▼ <?= number_format(abs($rh_price_percent), 2) ?>%</span>
        <?php endif; ?>
    </p>
<?php endif; ?>

        </a>
    </li>
</ul>


                    <!--<ul class="listing">-->
                    <!--    <li>-->
                    <!--        <a href="" class="inside">-->
                    <!--            <h3>Platinum</h3>-->
                    <!--            <h4><?= format_amount($sup_site_settings->site_live_pt_price) ?> -->
                                <!--<img src="<?= base_url() ?>assets/images/crt_down.svg" alt="">-->
                    <!--            </h4>-->
                    <!--             <p><strong>+90%</strong></p> -->

                    <!--        </a>-->
                    <!--    </li>-->
                    <!--    <li>-->
                    <!--        <a href="" class="inside">-->
                    <!--            <h3>Palladium</h3>-->
                    <!--            <h4><?= format_amount($sup_site_settings->site_live_pd_price) ?> -->
                                <!--<img src="<?= base_url() ?>assets/images/crt_up.svg" alt="">-->
                    <!--            </h4>-->
                                <!-- <p><strong>+100%</strong></p> -->

                    <!--        </a>-->
                    <!--    </li>-->
                    <!--    <li>-->
                    <!--        <a href="" class="inside">-->
                    <!--            <h3>Rhodium</h3>-->
                    <!--            <h4><?= format_amount($sup_site_settings->site_live_rh_price) ?></h4>-->
                                <!-- <p><strong>+55%</strong></p> -->

                    <!--        </a>-->
                    <!--    </li>-->

                    <!--</ul>-->
                    <div class="update">
                        <p>update <?= detectDay(); ?></p>
                    </div>
                <?php  } ?>

            </div>
            <div class="mobile_inner">

                <div class="search">
                    <form action="" method="post" class="code_form filter-form">

                        <input type="text" name="search_code" placeholder="Search by Code" class="txtBox search_code">
                        <div class="button">
                            <button type="button" id="code_btn">
                                <div class="image"><img src="<?= base_url() ?>assets/images/search.svg" alt=""></div>
                            </button>

                        </div>
                        <div class="button">
                            <a href="javascript:void(0)" class="close-image remove-data hidden">
                                <div class="image"><img src="<?= base_url() ?>assets/images/close.svg" alt=""></div>
                            </a>
                        </div>

                        <!-- <select name="brands" id="select_brand" class="txtBox" style="width: 25%; margin-top: 10px;">
                            <option value="all_brands">All Brands</option>
                            <?php foreach ($all_categories as $category) { ?>
                                <option value="<?= $category->name ?>"><?= ucwords($category->name) ?></option>
                            <?php  } ?>

                        </select> -->
                        <div class="hidden search_items_code">
                    </form>
                </div>


                <?php if ($member_data->mem_headge_prices == '1' && $member_data->mem_live_pt_price > 0 && $member_data->mem_live_pd_price > 0 && $member_data->mem_live_rh_price > 0) { ?>

                    <ul class="listing">
                        <li>
                            <a href="" class="inside">
                                <h3>Platinum</h3>
                                <h4><?= format_amount($member_data->mem_live_pt_price) ?></h4>
                                <!-- <p><strong>+90%</strong></p> -->

                            </a>
                        </li>
                        <li>
                            <a href="" class="inside">
                                <h3>Palladium</h3>
                                <h4><?= format_amount($member_data->mem_live_pd_price) ?></h4>
                                <!-- <p><strong>+100%</strong></p> -->

                            </a>
                        </li>
                        <li>
                            <a href="" class="inside">
                                <h3>Rhodium</h3>
                                <h4><?= format_amount($member_data->mem_live_rh_price) ?></h4>
                                <!-- <p><strong>+55%</strong></p> -->

                            </a>
                        </li>
                    </ul>

                <?php } elseif ($sub_site_settings->site_live_pt_price > 0 && $sub_site_settings->site_live_pd_price > 0 && $sub_site_settings->site_live_rh_price > 0) { ?>


                    <ul class="listing">
                        <li>
                            <a href="" class="inside">
                                <h3>Platinum</h3>
                                <h4><?= format_amount($sub_site_settings->site_live_pt_price) ?></h4>
                                <!-- <p><strong>+90%</strong></p> -->

                            </a>
                        </li>
                        <li>
                            <a href="" class="inside">
                                <h3>Palladium</h3>
                                <h4><?= format_amount($sub_site_settings->site_live_pd_price) ?></h4>
                                <!-- <p><strong>+100%</strong></p> -->

                            </a>
                        </li>
                        <li>
                            <a href="" class="inside">
                                <h3>Rhodium</h3>
                                <h4><?= format_amount($sub_site_settings->site_live_rh_price) ?></h4>
                                <!-- <p><strong>+55%</strong></p> -->

                            </a>
                        </li>

                    </ul>


                <?php } else { ?>

                    <ul class="listing">
                        <li>
                            <a href="" class="inside">
                                <h3>Platinum</h3>
                                <h4><?= format_amount($sup_site_settings->site_live_pt_price) ?></h4>
                                <!-- <p><strong>+90%</strong></p> -->

                            </a>
                        </li>
                        <li>
                            <a href="" class="inside">
                                <h3>Palladium</h3>
                                <h4><?= format_amount($sup_site_settings->site_live_pd_price) ?></h4>
                                <!-- <p><strong>+100%</strong></p> -->

                            </a>
                        </li>
                        <li>
                            <a href="" class="inside">
                                <h3>Rhodium</h3>
                                <h4><?= format_amount($sup_site_settings->site_live_rh_price) ?></h4>
                                <!-- <p><strong>+55%</strong></p> -->

                            </a>
                        </li>

                    </ul>

                <?php  } ?>

            </div>
        </div>
    </section>
    <!-- ======sec_sell_products======= -->
    <section class="sec_sell_products sec_code" id="result_data">
        <div class="contain">
            <div class="top_bar">
                <div class="searches">
                    <p><span><?= $total_active_codes; ?></span> searches found</p>
                    <!-- <p><span id="total_codes_count"></span> searches found</p> -->

                </div>
                <div class="order">
                    <div class="assc">
                        <span>Sort by :</span>
                        <form id="sortForm">
                            <select name="sort_order" id="sort_order">
                                <option value="1">Ascending</option>
                                <option value="2">Descending</option>
                            </select>
                        </form>
                    </div>
                    <ul>
                        <li><a href="#" class="toggle-horizontal horizontal-opt1"><img src="<?= base_url() ?>assets/images/opt1.png" alt=""></a></li>
                        <li class="active"><a href="#" class="toggle-horizontal horizontal-opt2"><img src="<?= base_url() ?>assets/images/opt2.png" alt=""></a></li>
                    </ul>
                </div>
            </div>
            <div class="flex" id="filter_code">

                <?php if (!empty($find_code)) : ?>

                    <?php foreach ($find_code as $code_p) :
                        // pr($code_p->total_price);
                    ?>
                        <div class="cols">
                            <div class="inner">
                                <div class="bottom_content">
                                    <div class="image_2 popBtn " data-code-name="<?= $code_p->code ?>"   data-images='<?=json_encode(getPictures($code_p->id,'code'))?>' data-popup="code_image" data-image-url="<?= get_site_code_image_src("code", $code_p->image, $site_settings) ?>">
                                        <img src="<?= get_site_code_image_src("code", $code_p->image, $site_settings) ?>" alt="<?= $site_settings->site_name ?>" alt="">
                                    </div>
                                    <div class="content">
                                        <h5><a href="<?= base_url('code-detail/' . doEncode($code_p->id)) ?>"><?= $code_p->title ?></a>
                                        </h5>
                                        <p><?= $code_p->code ?></p>
                                         <?php if (!empty($this->session->mem_id) && $member_data->mem_verified > 0 ) { ?>
                                        <div class="cta_price">
                                            <h5><strong><?= format_amount($code_p->total_price) ?></strong>
                                            </h5>
                                            <div class="cta">
                                                <a href="javascript:void(0)" class="webBtn popBtn" data-lot_type="<?= ($code_p->type) ?>" data-inventory_id="<?= ($code_p->id) ?>" data-options="get_lot_names" data-popup="add_code">Add</a>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>



                <?php else : ?>

                    <div class="alert alert-danger">No Code Available!!!</div>

                <?php endif; ?>

            </div>
            <div id="loading_codes" class="hidden">
                <div class="loadingio-spinner-rolling-2by998twmg8">
                    <div class="ldio-yzaezf3dcmj">
                        <div></div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</main>
<?php include_once('popups.php') ?>