<main>
    <!-- ====== -->
    <section class="small_banner">
        <div class="contain">
            <div class="inner">
                <div class="sec_heading">
                    <h2>Submit New Photos for Grading</h2>
                </div>
                <div class="content">
                    <p>Looking to have your photos graded for authenticity, quality, or other criteria? Our photo
                        grading service offers a convenient and efficient way to assess your images</p>
                </div>
            </div>
        </div>
    </section>
    <!-- ======= -->
    <section class="new_photo inventory_new">
        <div class="contain">
            <div class=" inside">
                <div class="content">
                    <h3>New Photo Grade</h3>
                    <form action="<?= base_url('ajax/add_photo_grade') ?>" method="POST" class="frmAjax" id="frmPhoto">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="txtGrp">
                                    <label for="">Add Photo</label>
                                    <button type="button" class="uploadImg">
                                        <i class="fa fa-cloud-upload" aria-hidden="true"></i>
                                        Upload Photo

                                    </button>
                                    <input type="file" name="grade_image" class="uploadFile" id="uploadPhotoGrade" required>
                                    <span class="hidden loder" style="margin: auto"><i class="fa fa-spinner fa-spin" style="font-size:48px;color:#6e6efd;"></i></span>
                                    <div class="uploaded-area flex"></div>
                                    <div class="progress p100" style="display: none;" id="progress-contain-vehicle">
                                        <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="" id="myBar1"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="txtGrp">
                                    <label for="">Item Fullness %</label>
                                    <div class="inner_block">
                                        <div class="first_value">
                                            <p>0</p>
                                        </div>
                                        <!-- <div class="example"></div> -->
                                        <input type="range" name="grade_fullness" id="grade_fullness" min="0" max="100" value="0" class="fullness-range">
                                        <div class="last_value">
                                            <p>100</p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="txtGrp">
                                    <label for="">Notes</label>
                                    <textarea name="grade_notes" id="grade_notes" placeholder="Enter any notes" class="txtBox txtArea" required></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="butn">
                                    <button type="submit" class="webBtn">Submit For Grading<i class="spinner hidden"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </section>

</main>
<?php include_once('popups.php') ?>