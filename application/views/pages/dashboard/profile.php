<main>
    <section class="sec_profile">
        <div class="contain">
            <div class="inner">
                <form action="<?= base_url('account/profile_settings') ?>" method="post" autocomplete="off" class="frmAjax" id="frmSetting">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="txtGrp">
                                <label for="">First Name</label>
                                <input type="text" name="fname" id="fname" value="<?= $this->member->mem_fname ?>" class="txtBox" placeholder="First Name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="txtGrp">
                                <label for="">Last Name</label>
                                <input type="text" name="lname" id="lname" value="<?= $this->member->mem_lname ?>" class="txtBox" placeholder="Last Name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="txtGrp">
                                <label for="">Phone Number</label>
                                <input type="text" name="phone" id="phone" value="<?= $this->member->mem_phone ?>" class="txtBox" placeholder="Phone">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="txtGrp">
                                <label for="">Email</label>
                                <input type="text" name="email" id="email" value="<?= $this->member->mem_email ?>" class="txtBox" placeholder="Email" readonly>
                            </div>
                        </div>
                        <div class="col-md-12">

                            <div class="txtGrp">
                                <label for="">Subject</label>
                                <textarea class="txtBox txtArea" name="cv" id="cv" placeholder="Write about yourself"><?= $this->member->mem_cv ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="butn">
                                <button class="webBtn">
                                    Save Changes
                                </button><i class="spinner hidden"></i>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>

<?php include_once('../includes/commonjs.php') ?>
<?php include_once('../includes/footer.php') ?>
</body>

</html>