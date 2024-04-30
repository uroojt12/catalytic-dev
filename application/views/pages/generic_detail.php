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
    <!-- =====sec_code_detail ====== -->
    <section class="sec_code_detail">
        <div class="contain">
            <div class="inner">
                <div class="top_heading">
                    <h3>Generics Detail</h3>
                </div>
                <div class="flex">
                    <div class="photo">
                        <div class="image">
                            <img src="<?= get_site_image_src('generics', $generic_detail->image); ?>" alt="no_image">
                        </div>
                    </div>
                    <div class="content">
                        <ul class="listings">
                            <li>
                                <strong>Code</strong>
                                <p><?= $generic_detail->title ?><?= $generic_detail->code ?></p>
                            </li>
                            <li>
                                <strong>Market Price</strong>
                                <p><?= format_amount($generic_detail->price) ?></p>
                            </li>
                            <li>
                                <strong>Make</strong>
                                <p><?= $generic_detail->make ?></p>
                            </li>
                        </ul>

                    </div>
                </div>
                <!-- <div class="cta">
                    <a href="" class="webBtn">Add To Inventory Lot</a>
                </div> -->
            </div>
        </div>
    </section>

</main>