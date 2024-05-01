<main>
    <!-- ====== -->
    <section class="small_banner sec_desktop_form"
        style="background-image:url('<?= get_site_image_src("images/", $site_content['image1']) ?>')">
        <div class="contain">
            <div class="inner">
                <div class="sec_heading">
                    <h2><?= $site_content['banner_heading'] ?></h2>
                </div>
                <div class="search">
                    <form id="filter-form" action="" method="post">
                        <input type="text" name="search_code" id="search_code" placeholder="Search by Code"
                            class="txtBox">
                        <div class="button">
                            <button>
                                <div class="image"><img src="<?= base_url() ?>assets/images/search.svg" alt=""></div>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="cta">
                    <a href="<?= $site_content['banner_btn_url'] ?>"
                        class="style_it"><?= $site_content['banner_btn_text'] ?></a>
                </div>
            </div>
        </div>
    </section>
    <!-- ======sec_sell_products======= -->
    <section class="sec_sell_products sec_code" id="result_data">
        <div class="contain">
            <div class="top_bar">
                <div class="searches">
                    <!-- <p><span><?= $total_active_codes; ?></span> searches found</p> -->
                    <p><span id="total_codes_count"></span> searches found</p>

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
                        <li><a href="#" class="toggle-horizontal horizontal-opt1"><img
                                    src="<?= base_url() ?>assets/images/opt1.png" alt=""></a></li>
                        <li class="active"><a href="#" class="toggle-horizontal horizontal-opt2"><img
                                    src="<?= base_url() ?>assets/images/opt2.png" alt=""></a></li>
                    </ul>
                </div>
            </div>
            <div class="flex" id="filter_code">

                <?php if (!empty($find_code)) : ?>

                <?php foreach ($find_code as $code_p) : 
                        ?>
                <div class="cols">
                    <div class="inner">
                        <!-- <div class="photo">
                                    <div class="image">
                                        <img src="<?= get_site_image_src("code/", $code_p->image) ?>" alt="no_image">
                                    </div>
                                </div> -->
                        <div class="bottom_content">
                            <div class="image_2">
                                <img src="<?= base_url() . 'uploads/images/' . $site_settings->site_logo . '?v-' . $site_settings->site_version ?>"
                                    alt="<?= $site_settings->site_name ?>" alt="">
                            </div>
                            <div class="content">
                                <h5><a
                                        href="<?= base_url('code-detail/' . doEncode($code_p->id)) ?>"><?= $code_p->title ?></a>
                                </h5>
                                <p><?= $code_p->code ?></p>
                                <div class="cta_price">
                                    <h5><strong><?= format_amount(number_format($code_p->total_price, 2, '.', '')) ?></strong>
                                    </h5>
                                    <div class="cta">
                                        <a href="javascript:void(0)" class="webBtn popBtn"
                                            data-lot_type="<?= ($code_p->type) ?>"
                                            data-inventory_id="<?= ($code_p->id) ?>" data-popup="add_code">Add</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach ?>

                <div class="bottom_content">
                    <div class="image_2">
                        <img src="<?= base_url() . 'uploads/images/' . $site_settings->site_logo . '?v-' . $site_settings->site_version ?>"
                            alt="<?= $site_settings->site_name ?>" alt="">
                    </div>
                    <div class="content">
                        <h5><a
                                href="<?= base_url('code-detail/' . urlencode(doEncode($code_p->id))) ?>"><?= $code_p->title ?></a>
                        </h5>
                        <p><?= $code_p->code ?></p>
                        <div class="cta_price">
                            <h5><strong><?= format_amount(number_format($code_p->total_price, 2, '.', '')) ?></strong>
                            </h5>
                            <div class="cta">
                                <a href="javascript:void(0)" class="webBtn popBtn"
                                    data-lot_type="<?= ($code_p->type) ?>" data-inventory_id="<?= ($code_p->id) ?>"
                                    data-popup="add_code">Add</a>
                            </div>
                        </div>
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