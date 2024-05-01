<main>
    <!-- ====== -->
    <section class="small_banner gene_banner sec_desktop_form"
        style="background-image:url('<?= get_site_image_src("images/", $site_content['image1']) ?>')">
        <div class="contain">
            <div class="inner">
                <div class="sec_heading">
                    <h2><?= $site_content['banner_heading'] ?></h2>
                </div>
                <div class="search">
                    <form id="filter-form-gen" action="" method="post">
                        <input type="text" name="search_generics" id="search_generics" placeholder="Search Generics"
                            class="txtBox">
                        <div class="button">
                            <button>
                                <div class="image"><img src="<?= base_url() ?>assets/images/search.svg" alt=""></div>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- ======sec_sell_products======= -->
    <section class="sec_sell_products sec_code" id="result_data_gen">
        <div class="contain">
            <div class="top_bar">
                <div class="searches">
                    <!-- <p><strong><?= $total_active_generics; ?></strong> searches found</p> -->
                    <p><span id="total_gen_count"></span> searches found</p>

                </div>
                <div class="order">
                    <div class="assc">
                        <span>Sort by :</span>
                        <form action="">
                            <select name="generics_sort_order" id="generics_sort_order">
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
            <div class="flex" id="filter_generics">
                <?php foreach ($generics as $generic) : ?>
                <div class="cols">
                    <div class="inner">
                        <!-- <div class="photo">
                                <div class="image">
                                    <img src="<?= get_site_image_src('generics', $generic->image); ?>" alt="">
                                </div>
                            </div> -->
                        <div class="bottom_content">
                            <div class="image_2">
                                <img src="<?= base_url() . 'uploads/images/' . $site_settings->site_logo . '?v-' . $site_settings->site_version ?>"
                                    alt="<?= $site_settings->site_name ?>" alt="">
                            </div>
                            <div class="content">
                                <h5><a
                                        href="<?= base_url('generic-detail/' . urlencode(doEncode($generic->id))) ?>"><?= $generic->title ?></a>
                                </h5>
                                <p><?= $generic->code ?></p>
                                <div class="cta_price">
                                    <h5><strong><?= format_amount($generic->total_price) ?></strong></h5>
                                    <div class="cta">
                                        <!-- <a href="javascript:void(0)" class="webBtn popBtn" data-popup="add_code">Add</a> -->
                                        <a href="javascript:void(0)" class="webBtn popBtn"
                                            data-lot_type="<?= ($generic->type) ?>"
                                            data-inventory_id="<?= ($generic->id) ?>" data-popup="add_code">Add</a>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach ?>
            </div>
            <div id="loading_generics" class="hidden">
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