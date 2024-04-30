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
    <section class="sec_inventory">
        <div class="contain">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a class="a" data-toggle="tab" href="#active">
                        Active</a>
                </li>

                <li>
                    <a class="b" data-toggle="tab" href="#closed">
                        Closed</a>
                </li>

            </ul>
            <div class="tab-content">
                <div id="active" class="tab-pane fade a active in">
                    <div class="flex">
                        <?php if(!empty($inventory)):?>
                        <?php foreach ($inventory as $invent) : ?>
                            <div class="cols">
                                <div class="inner">
                                    <div class="content">
                                        <h4><a href="<?= base_url('inventory-detail/' . urlencode(doEncode($invent->id))) ?>"><?= $invent->lot_name ?></a></h4>
                                        <p><?= format_date($invent->created_date, 'M d, Y') ?></p>
                                    </div>

                                </div>
                            </div>
                        <?php endforeach ?>
                    <?php else:?>
                        <div class="alert alert-danger">No active inventory added yet!</div>
                    <?php endif; ?>
                        
                    </div>
                    <div class="cta">
                        <a href="javascript:void(0)" class="webBtn popBtn" data-popup="inventory_new_lot">Create A
                            New Inventory
                            Lot</a>
                    </div>
                </div>
                <div id="closed" class="tab-pane fade b">
                    <div class="flex">
                    <?php if(!empty($closed_inventory)):?>
                    <?php foreach ($closed_inventory as $invent) : ?>
                            <div class="cols">
                                <div class="inner">
                                    <div class="content">
                                        <h4><a href="<?= base_url('inventory-detail/' . urlencode(doEncode($invent->id))) ?>"><?= $invent->lot_name ?></a></h4>
                                        <p><?= format_date($invent->created_date, 'M d, Y') ?></p>
                                    </div>

                                </div>
                            </div>
                        <?php endforeach ?>
                    <?php else:?>
                        <div class="alert alert-danger">No closed inventory added yet!</div>
                    <?php endif; ?>
                    </div>
                    <div class="cta">
                        <a href="javascript:void(0)" class="webBtn popBtn" data-popup="inventory_new_lot">Create A
                            New Inventory
                            Lot</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="popup inventory_new" data-popup="inventory_new_lot">

        <div class="tableDv">

            <div class="tableCell">

                <div class="contain">

                    <div class=" inside">
                        <div class="crosBtn"></div>
                        <div class="content">
                            <h3>Add new Lot</h3>
                            <form action="<?= base_url('ajax/add_lot_name') ?>" method="POST" class="frmAjax" id="frmLot">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="txtGrp">
                                            <label for="lot_name">Lot Name</label>
                                            <input type="text" name="lot_name" id="lot_name" class="txtBox" placeholder="123456778" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <ul class="btn_list">
                                            <!-- <li>
                                                <button class="webBtn lightBtn">Cancel</button>
                                            </li> -->
                                            <li>
                                                <button class="webBtn" type="submit">Create Lot<i class="spinner hidden"></i></button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>
</main>
<?php include_once('popups.php') ?>