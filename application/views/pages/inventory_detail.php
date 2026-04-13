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
                                        <img src="<?= base_url() . 'uploads/images/' . $site_settings->site_logo . '?v-' . $site_settings->site_version ?>" alt="<?= $site_settings->site_name ?>">
                                    </div>
                                    <div class="logo_detail">
                                        <!-- <p><?= $inventory_detail->lot_name ?></p> -->
                                    </div>
                                </div>

                            </div>
                            <br>
                            <?php if ($inventory_detail->status == 0) : ?>
                                <a href="javascript:void(0)" class="webBtn brightBtn popBtn" data-popup="custom_codes">Add
                                    Custom Codes</a>
                            <?php endif; ?>
                            <div class="img_grid" id="inventory_update">
                                <?php
                                // pr($codes_arr);
                                $count_avg = count($codes_arr);
                                // pr($count_avg);
                                $grand_total = 0; // Initialize grand total
                                // pr($count_avg);
                                if (!empty($codes_arr)) :
                                    // pr($codes_arr);

                                ?>
                                    <?php foreach ($codes_arr as $code_row) :
                                        if ($code_row->id) {
                                            $pump_cal_price = calculatedAllPrice($admin_site_settings->site_o_pt_price, $admin_site_settings->site_live_pt_price, $admin_site_settings->site_o_pd_price, $admin_site_settings->site_live_pd_price, $admin_site_settings->site_o_rh_price, $admin_site_settings->site_live_rh_price, $this->session->web_id, $code_row->id, $this->session->mem_id);
                                            // $amount = $pump_cal_price;
                                            $price = $code_row->amount * $code_row->qty;
                                            // $price = $code_row->amount;
                                            $grand_total += $price; // Add to grand total

                                            // pr($grand_total);
                                    ?>
                                            <div class="flex">
                                                <div class="content">
                                                    <ul class="in_listing custom_in_listing">
                                                        <li class="first_para">
                                                            <p class="none_p"><strong>Title</strong></p>
                                                            <?php $folder = $code_row->type === 'Code' ? 'code' : 'generics'; ?>
                                                            <div class="code_area mobile_accordian_custom">
                                                                <div class="image-2">
                                                                    <img src="<?= get_site_code_image_src($folder, $code_row->image, $site_settings) ?>" alt="<?= $site_settings->site_name ?>">
                                                                </div>
                                                                <p>

                                                                    <?= $code_row->code ?><span class="cell_show_imp"><?= format_amount($price) ?></span></p>
                                                            </div>
                                                        </li>
                                                        <li class="mobile_brand2 acc_ordian">
                                                            <p class="none_p"><strong>Type</strong></p>
                                                            <p class="brand_para2">
                                                                <?= (!empty($code_row->new_type)) ? strtoupper($code_row->new_type) : 'N/A' ?>
                                                            </p>
                                                        </li>
                                                        <li class="mobile_brand acc_ordian">
                                                            <p class="none_p"><strong>Brand</strong></p>
                                                            <p class="brand_para"><?= get_brand_name($code_row->cat_id) ?></p>
                                                        </li>
                                                        <li class="full-mobile acc_ordian">
                                                            <p><strong>Fullness</strong></p>
                                                            <p><?= $code_row->fullness ?>%</p>
                                                        </li>
                                                        <li class="acc_ordian">
                                                            <p><strong>Price</strong></p>
                                                            <p><?= format_amount($price) ?></p>
                                                        </li>
                                                        <li class="delete_list acc_ordian">
                                                            <p><strong>Quantity</strong></p>
                                                            <div class="qty_cart">
                                                                <div class="qtyBtn">
                                                                    <?php if ($inventory_detail->status == 0) : ?>
                                                                        <input type="button" value="-" class="qtyminus readBtn">
                                                                    <?php endif; ?>
                                                                    <input type="text" name="quantity" min="1" value="<?= $code_row->qty ?>" class="qty">
                                                                    <?php if ($inventory_detail->status == 0) : ?>
                                                                        <input type="button" value="+" class="qtyplus readBtn">
                                                                        <input type="hidden" name="row_id" class="row_id" value="<?= $code_row->row_id ?>">
                                                                    <?php endif; ?>
                                                                </div>
                                                                <?php if ($inventory_detail->status == 0) : ?>
                                                                    <!-- <a href="</?= base_url('delete-cart/' . $code_row->row_id . "/" . urlencode(doEncode($inventory_detail->id))) ?>" class="delete">
                                                                    <img src="</?= base_url() ?>assets/images/delete.svg" alt="">
                                                                </a> -->
                                                                    <a href="javascript:void(0)" class="delete" id="del_row" data-row_id="<?= $code_row->row_id ?>">
                                                                        <img src="<?= base_url() ?>assets/images/delete.svg" alt="">
                                                                    </a>
                                                                <?php endif; ?>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>

                                        <?php  } else {
                                            $price = $code_row->code_price * $code_row->qty;
                                            $grand_total += $price; // Add to grand total
                                        ?>
                                            <div class="flex">
                                                <div class="content">
                                                    <ul class="in_listing custom_in_listing">
                                                        <li class="first_para">
                                                            <p class="none_p"><strong>Title</strong></p>
                                                            <div class="code_area mobile_accordian_custom">
                                                                <div class="image-2">
                                                                    <img src="<?= get_site_code_image_src('code', $code_row->code_image, $site_settings) ?>" alt="<?= $site_settings->site_name ?>">
                                                                </div>
                                                                <p>

                                                                    <?= $code_row->code_name ?><span class="cell_show_imp"><?= format_amount($price) ?></span></p>
                                                            </div>
                                                        </li>
                                                        <li class="mobile_brand acc_ordian">
                                                            <p class="none_p"><strong>Type</strong></p>
                                                            <p class="brand_para">N/A</p>
                                                        </li>
                                                        <li class="mobile_brand acc_ordian">
                                                            <p class="none_p"><strong>Brand</strong></p>
                                                            <p class="brand_para">N/A</p>

                                                        </li>
                                                        <li class="full-mobile acc_ordian">
                                                            <p><strong>Fullness</strong></p>
                                                            <p><?= $code_row->fullness ?>%</p>
                                                        </li>
                                                        <li class="acc_ordian">
                                                            <p><strong>Price</strong></p>
                                                            <p><?= format_amount($price)  ?></p>
                                                        </li>
                                                        <li class="delete_list acc_ordian">
                                                            <p><strong>Quantity</strong></p>
                                                            <div class="qty_cart">
                                                                <div class="qtyBtn">
                                                                    <?php if ($inventory_detail->status == 0) : ?>
                                                                        <input type="button" value="-" class="qtyminus readBtn">
                                                                    <?php endif; ?>
                                                                    <input type="text" name="quantity" min="1" value="<?= $code_row->qty ?>" class="qty">
                                                                    <?php if ($inventory_detail->status == 0) : ?>
                                                                        <input type="button" value="+" class="qtyplus readBtn">
                                                                        <input type="hidden" name="row_id" class="row_id" value="<?= $code_row->row_id ?>">
                                                                    <?php endif; ?>
                                                                </div>
                                                                <?php if ($inventory_detail->status == 0) : ?>
                                                                    <!-- <a href="</?= base_url('delete-cart/' . $code_row->row_id . "/" . urlencode(doEncode($inventory_detail->id))) ?>" class="delete">
                                                                    <img src="</?= base_url() ?>assets/images/delete.svg" alt="">
                                                                </a> -->
                                                                    <a href="javascript:void(0)" class="delete" id="del_row" data-row_id="<?= $code_row->row_id ?>">
                                                                        <img src="<?= base_url() ?>assets/images/delete.svg" alt="">
                                                                    </a>
                                                                <?php endif; ?>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        <?php } ?>
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
                            <div><strong>TOTAL CONVERTERS:</strong></div>
                            <?php
                            $total_converters = 0;
                            foreach ($codes_arr as $code_row_qty) :
                                $total_converters += $code_row_qty->qty;
                            endforeach;
                            ?>
                            <div class="total_converters"><?= $total_converters ?></div>
                        </div>
                        <div class="total_flex">
                            <div><strong>AVERAGE PRICE:</strong></div>
                            <div class="average_price">
                                <?= format_amount_decimal($total_converters > 0 ? $grand_total / $total_converters : 0,2) ?></div>
                        </div>
                        <div class="total_flex">
                            <div><strong>GRAND TOTAL:</strong></div>
                            <div class="grand_total"><?= format_amount($grand_total) ?></div>
                        </div>
                        <div class="devide_line"></div>
                        <div class="new_count">
                            <?php foreach ($categories as $category) : ?>
                                <?php if (count_codes_for_cat_id($category->id, $inventory_detail->id) > 0) : ?>
                                    <div class="total_flex">
                                        <div><strong><?= $category->name ?></strong></div>
                                        <div><?= count_codes_for_cat_id($category->id, $inventory_detail->id) . ' __ ' . format_amount(sum_amount_for_cat_id($category->id, $inventory_detail->id)) ?></div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                        <div class="text-center">
                            <?php if ($inventory_detail->status == 0) : ?>
                                <a href="javascript:void(0)" class="webBtn brightBtn popBtn" data-popup="submit_lot">Submit</a>
                            <?php endif; ?>
                            <?php if ($inventory_detail->status == 1) : ?>
                                <a href="javascript:void(0)" class="webBtn brightBtn" id="inventory_export" data-id="<?= doEncode($inventory_detail->id) ?>"><i class="fa fa-download"></i> Export
                                    PDF <i class="spinner hidden"></i></a>
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