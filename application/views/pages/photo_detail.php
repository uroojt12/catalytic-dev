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
    <section class="sec_photo_details">
        <div class="contain">
            <div class="inner">
                <div class="flex">
                    <div class="col1">
                        <div class="image">
                            <img src="<?= get_site_image_src('photo_grade', $photo_detail->image); ?>" alt="no_image">
                        </div>
                    </div>
                    <div class="col2">
                        <div class="content">
                            <ul class="list">
                                <li>
                                    <strong>Code</strong>
                                    <p> <?= $photo_detail->title ?><?= $photo_detail->code ?></p>
                                </li>
                                <li>
                                    <strong>Notes</strong>
                                    <p><?= $photo_detail->notes ?></p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>