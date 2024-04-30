<?php if (!empty($find_code)) : ?>

    <?php foreach ($find_code as $code_p) : ?>
        <div class="cols">
            <div class="inner">
                <div class="photo">
                    <div class="image">
                        <img src="<?= get_site_image_src("code/", $code_p->image) ?>" alt="no_image">
                    </div>
                </div>
                <div class="bottom_content">
                    <div class="image_2">
                        <img src="<?= base_url() ?>assets/images/logo-2.svg" alt="">
                    </div>
                    <div class="content">
                        <h5><a href="<?= base_url('code-detail/' . doEncode($code_p->id)) ?>"><?= $code_p->title ?></a></h5>
                        <p><?= $code_p->code ?></p>
                        <?php $chk_price = chk_code_price($this->session->web_id, $code_p->id); ?>
                        <div class="cta_price">
                            <h5><strong><?= !empty($chk_price)  ? format_amount($chk_price->new_price) :  format_amount($code_p->price) ?></strong></h5>
                            <div class="cta">
                                <a href="javascript:void(0)" class="webBtn popBtn" data-lot_type="<?= ($code_p->type) ?>" data-inventory_id="<?= ($code_p->id) ?>" data-popup="add_code">Add</a>
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

    <div class="alert alert-danger">No Code Available!!!</div>

<?php endif; ?>