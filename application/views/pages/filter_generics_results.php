<section class="sec_sell_products sec_code" id="result_data_gen">
    <div class="contain">
        <div class="top_bar">
            <div class="searches">
                <p><?= $total_results ?> searches found</p>
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
                    <li><a href="#" class="toggle-horizontal horizontal-opt1"><img src="<?= base_url() ?>assets/images/opt1.png" alt=""></a></li>
                    <li class="active"><a href="#" class="toggle-horizontal horizontal-opt2"><img src="<?= base_url() ?>assets/images/opt2.png" alt=""></a></li>
                </ul>
            </div>
        </div>
        <div class="flex" id="filter_generics">
            <?php if (!empty($find_generics)) : ?>
                <?php foreach ($find_generics as $generic) : ?>
                    <div class="cols">
                        <div class="inner">
                            <div class="photo">
                                <div class="image">
                                    <img src="<?= get_site_image_src('generics', $generic->image); ?>" alt="">
                                </div>
                            </div>
                            <div class="bottom_content">
                                <div class="content">
                                    <h5><a href="<?= base_url('generic-detail/' . urlencode(doEncode($generic->id))) ?>"><?= $generic->title ?></a></h5>
                                    <p><?= $generic->code ?></p>
                                    <?php $chk_price = chk_code_price($this->session->web_id, $generic->id); ?>
                                    <div class="cta_price">
                                        <h5><strong><?= !empty($chk_price)  ? format_amount($chk_price->new_price) :  format_amount($generic->price) ?></strong></h5>
                                        <div class="cta">
                                            <!-- <a href="javascript:void(0)" class="webBtn popBtn" data-popup="add_code">Add</a> -->
                                            <a href="javascript:void(0)" class="webBtn popBtn" data-lot_type="<?= ($generic->type) ?>" data-inventory_id="<?= ($generic->id) ?>" data-popup="add_code">Add</a>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
                <ul id="pagination" class="pagination">

                    <?= $links ?>

                </ul>

            <?php else : ?>

                <div class="alert alert-danger">No Generics Available!!!</div>

            <?php endif; ?>
            <br>

        </div>
    </div>
</section>