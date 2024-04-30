<main>
    <!-- ====== -->
    <!-- <section class="small_banner" style="background-image:url('<?= get_site_image_src("images/", $site_content['image1']) ?>')">
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
    </section> -->
    <!-- ======= -->
    <section class="sec_inventory_detail lot_inventory_details_page">
        <div class="contain">
            <div class="text-left">
                <h3><?= $inventory_detail->lot_name ?></h3>
            </div>
            <div class="flex">
                <div class="colr">
                    <div class="faqLst">
                        <div class="faqBlk active">
                            <div class="up_grid">
                                <div class="flex">
                                    <div class="logo_m">
                                        <img src="<?= base_url() ?>assets/images/logo-m.svg" alt="">
                                    </div>
                                    <div class="logo_detail">
                                        <!-- <p><?= $inventory_detail->lot_name ?></p> -->
                                    </div>
                                </div>
                            </div>
                            <div class="img_grid" id="inventory_update">
                                <?php
                                $count_avg = count($codes_arr);
                                $grand_total = 0; // Initialize grand total
                                // pr($count_avg);
                                if (!empty($codes_arr)) :
                                ?>
                                    <?php foreach ($codes_arr as $code_row) :
                                        // pr($code_row);
                                        $price_pump = !empty($sub_admin_row->price_pump) ? $sub_admin_row->price_pump :  2;
                                        $cal_price = calculatedPrice($admin_site_settings->site_o_pt_price, $admin_site_settings->site_live_pt_price, $admin_site_settings->site_o_pd_price, $admin_site_settings->site_live_pd_price, $admin_site_settings->site_o_rh_price, $admin_site_settings->site_live_rh_price, $code_row->o_price, $code_row->pt_price, $code_row->pd_price, $code_row->rh_price);
                                        $cal_price = $cal_price + (($cal_price * $price_pump) / 100);
                                        $amount = $cal_price;
                                        // pr($code_row);
                                        $price = $cal_price * $code_row->qty;
                                        $grand_total += $price; // Add to grand total

                                        // pr($grand_total);
                                    ?>
                                        <div class="flex">
                                            <div class="content">
                                                <ul class="in_listing">
                                                    <li>
                                                        <p><strong>Title</strong></p>
                                                        <p><?= $code_row->title ?><br /><?= $code_row->lot_type ?></p>
                                                    </li>
                                                    <li>
                                                        <p><strong>Fullness</strong></p>
                                                        <p><?= $code_row->fullness ?>%</p>
                                                    </li>
                                                    <li>
                                                        <p><strong>Price</strong></p>
                                                        <p><?= format_amount(number_format($price, 2, '.', '')) ?></p>
                                                    </li>
                                                    <li>
                                                        <p><strong>Quantity</strong></p>
                                                        <div class="qty_cart">
                                                            <div class="qtyBtn">
                                                                <?php if ($inventory_detail->status == 0) : ?>
                                                                    <input type="button" value="-" class="qtyminus readBtn">
                                                                <?php endif; ?>
                                                                <input type="text" name="quantity" value="<?= $code_row->qty ?>" class="qty">
                                                                <?php if ($inventory_detail->status == 0) : ?>
                                                                    <input type="button" value="+" class="qtyplus readBtn">
                                                                    <input type="hidden" name="row_id" class="row_id" value="<?= $code_row->row_id ?>">
                                                                <?php endif; ?>
                                                            </div>
                                                            <?php if ($inventory_detail->status == 0) : ?>
                                                                <a href="<?= base_url('delete-cart/' . $code_row->row_id . "/" . urlencode(doEncode($inventory_detail->id))) ?>" class="delete">
                                                                    <img src="<?= base_url() ?>assets/images/delete.svg" alt="">
                                                                </a>
                                                            <?php endif; ?>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <div class="alert alert-danger">No code added!</div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="coll">
                    <div class="total_blk">
                        <div class="total_flex">
                            <div><strong>Market Price</strong></div>
                            <div class="grand_total"><?= format_amount($grand_total) ?></div>
                        </div>
                        <div class="total_flex">
                            <div><strong>Average Price</strong></div>
                            <div class="average_price"><?= format_amount($count_avg > 0 ? $grand_total / $count_avg : 0) ?></div>
                        </div>
                        <div class="devide_line"></div>
                        <?php foreach ($categories as $category) : ?>
                            <?php if (count_codes_for_cat_id($category->id, $inventory_detail->id) > 0) : ?>
                                <div class="total_flex">
                                    <div><strong><?= $category->name ?></strong></div>
                                    <div><?= count_codes_for_cat_id($category->id, $inventory_detail->id) ?></div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <div class="text-center">
                            <?php if ($inventory_detail->status == 0) : ?>
                                <a href="javascript:void(0)" class="webBtn brightBtn popBtn" data-popup="submit_lot">Submit</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        </div>
    </section>
    <!-- =====sec_two_btn====== -->
    <!-- <section class="sec_two_btn">
        <div class="contain">
            <div class="flex">
                <div class="cols col1">
                    <div class="inner">
                        <ul class="listings">
                            <li>
                                <strong>Market Price</strong>
                                <p><?= format_amount($grand_total) ?></p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="cols col2">
                    <ul class="cta">
                        <?php if ($inventory_detail->status == 0) : ?>
                            <li>
                                <a href="javascript:void(0)" class="webBtn brightBtn popBtn" data-popup="submit_lot">Submit</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </section> -->
</main>
<?php include_once('popups.php') ?>