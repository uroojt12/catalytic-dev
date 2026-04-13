<header class="dash_header">
    <div class="contain">
        <div class="header_bg">
            <div class="logo">
                <a href="<?= base_url() ?>" style="display: block;">
                    <img src="<?= base_url() . 'uploads/images/' . $site_settings->site_logo . '?v-' . $site_settings->site_version ?>" alt="<?= $site_settings->site_name ?>">

                </a>
            </div>
            <?php if (empty($this->session->mem_id)): ?>
                <div class="toggle"><span></span></div>
            <?php endif; ?>
            <nav class="ease" nav="">
                <ul id="nav">
                    <!-- <li class="<?php if ($page == "index") {
                                        echo 'active';
                                    } ?>">
                        <a href="<?= base_url() ?>">Home</a>
                    </li> -->
                    <li class="<?php if ($page == "code") {
                                    echo 'active';
                                } ?>">
                        <a href="<?= base_url('code') ?>">Code</a>
                    </li>




                    <!-- <li class="<?php if ($page == "generics") {
                                        echo 'active';
                                    } ?>">
                        <a href="<?= base_url('generics') ?>">Generics</a>
                    </li> -->
                    <?php if (!empty($this->session->mem_id) && $member_data->mem_verified > 0) { ?>
                        <li class="<?php if ($page == "photo_grade") {
                                        echo 'active';
                                    } ?>">
                            <a href="<?= base_url('photo-grade') ?>">Photo Grade</a>
                        </li>
                    <?php } ?>
                    <?php if (!empty($this->session->mem_id) && $member_data->mem_verified > 0) { ?>
                        <li class="<?php if ($page == "inventory") {
                                        echo 'active';
                                    } ?>">
                            <a href="<?= base_url('inventory') ?>">Inventory</a>
                        </li>
                    <?php } ?>
                    <?php if (!empty($this->session->mem_id) && $member_data->mem_verified > 0) { ?>
                        <li class="<?php if ($page == "margin") {
                                        echo 'active';
                                    } ?>">
                            <a href="<?= base_url('margin') ?>">Margin</a>
                        </li>
                    <?php } ?>

                    <?php if (!empty($this->session->mem_id) && $member_data->mem_verified > 0) { ?>
                        <li>
                            <div class="form-check form-switch">
                                <input class="form-check-input flexSwitchCheckDefault" type="checkbox" role="switch" id="flexSwitchCheckDefault" <?= $member_data->mem_headge_prices == '1' ? 'checked' : '' ?>>
                                <label class="form-check-label" for="flexSwitchCheckDefault">Hedge Prices</label>
                            </div>
                        </li>
                    <?php } ?>

                    <!--<div class="user_dp_drop ">-->
                    <!--      <div class="proIco _dropDown">-->
                    <!--          <div class=" _dropBtn">-->
                    <!--             <div class="image">-->
                    <!--          <img src="<?= base_url() ?>assets/images/team-1.jpeg" alt="">-->
                    <!--      </div> -->
                    <!--<div class="name">-->
                    <!--    <h6><?= $member_data->mem_fname . " " . $member_data->mem_lname ?></h6>-->
                    <!--    <i class="fa fa-chevron-down"></i>-->
                    <!--</div>-->
                    <!--          </div>-->
                    <!--          <div class="proDrop _dropCnt profileCnt">-->
                    <!--              <ul class="dropLst">-->
                    <!--                  <li>-->
                    <!--                      <div class="user_header">-->
                    <!--                          <h5><?= $member_data->mem_fname . " " . $member_data->mem_lname ?></h5>-->
                    <!--                          <p></p>-->
                    <!--                      </div>-->
                    <!--                  </li>-->

                    <!--                  <li>-->
                    <!--                      <a class="" href="<?= base_url('dashboard') ?>">-->
                    <!--                          <span>Dashboard</span>-->
                    <!--                      </a>-->
                    <!--                  </li>-->

                    <!--                  <li><a href="<?= base_url('signout') ?>"> <span>Logout</span></a></li>-->


                    <!--              </ul>-->
                    <!--          </div>-->
                    <!--      </div>-->
                    <!--  </div>-->

                    <?php if (!empty($this->session->mem_id) && $member_data->mem_verified > 0): ?>
                        <div class="user_dp_drop">
                            <div class="proIco _dropDown">
                                <div class="_dropBtn">
                                    <div class="image">
                                        <img src="<?= get_site_image_src("members/", $member_data->mem_image) ?>" alt="">
                                    </div>
                                    <!--<div class="name">-->
                                    <!--    <h6><?= $member_data->mem_fname . " " . $member_data->mem_lname ?></h6>-->
                                    <!--    <i class="fa fa-chevron-down"></i>-->
                                    <!--</div>-->
                                </div>
                                <div class="proDrop _dropCnt profileCnt">
                                    <ul class="dropLst">
                                        <li>
                                            <div class="user_header">
                                                <h5><?= $member_data->mem_fname . " " . $member_data->mem_lname ?></h5>
                                                <p></p>
                                            </div>
                                        </li>
                                        <li>
                                            <a href="<?= base_url('dashboard') ?>">
                                                <span>Dashboard</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?= base_url('signout') ?>"> <span>Logout</span></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($this->session->mem_id) && $member_data->mem_verified > 0) { ?>

                    <?php } else { ?>

                        <li class="<?php if ($page == "login") {
                                        echo 'active';
                                    } ?>">
                            <a href="<?= base_url('login') ?>" class="webBtn">Login</a>
                        </li>
                        <!-- <li class="<?php if ($page == "signup") {
                                            echo 'active';
                                        } ?>">
                            <a class="webBtn" href="<?= base_url('signup') ?>">Sign up</a>
                        </li>-->
                    <?php } ?>

                </ul>

            </nav>
            <?php if (!empty($this->session->mem_id) && $member_data->mem_verified > 0) { ?>
                <div class="user_dp_drop mobile_drop">
                    <div class="proIco _dropDown">
                        <div class=" _dropBtn">
                            <div class="image">
                                <img src="<?= get_site_image_src("members/", $member_data->mem_image) ?>" alt="">
                            </div>
                            <!--<div class="name">-->
                            <!--    <h6><?= $member_data->mem_fname . " " . $member_data->mem_lname ?></h6>-->
                            <!--    <i class="fa fa-chevron-down"></i>-->
                            <!--</div>-->
                        </div>
                        <div class="proDrop _dropCnt profileCnt">
                            <ul class="dropLst">
                                <li>
                                    <div class="user_header">
                                        <h5><?= $member_data->mem_fname . " " . $member_data->mem_lname ?></h5>
                                        <p></p>
                                    </div>
                                </li>
                                <li class="<?php if ($page == "code") {
                                                echo 'active';
                                            } ?>">
                                    <a href="<?= base_url('code') ?>">Code</a>
                                </li>

                                <li class="<?php if ($page == "photo_grade") {
                                                echo 'active';
                                            } ?>">
                                    <a href="<?= base_url('photo-grade') ?>">Photo Grade</a>
                                </li>

                                <li class="<?php if ($page == "inventory") {
                                                echo 'active';
                                            } ?>">
                                    <a href="<?= base_url('inventory') ?>">Inventory</a>
                                </li>

                                <li>
                                    <a href="<?= base_url('margin') ?>">Margin</a>
                                </li>
                                <li>
                                    <a class="" href="<?= base_url('dashboard') ?>">
                                        <span>Dashboard</span>
                                    </a>
                                </li>

                                <li><a href="<?= base_url('signout') ?>"> <span>Logout</span></a></li>

                                <?php if (!empty($this->session->mem_id) && $member_data->mem_verified > 0) { ?>
                                    <li>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input flexSwitchCheckDefault" type="checkbox" role="switch" <?= $member_data->mem_headge_prices == '1' ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="flexSwitchCheckDefault">Hedge Prices</label>
                                        </div>
                                    </li>
                                <?php } ?>
                                <!--<li>-->
                                <!--        <div class="form-check form-switch">-->
                                <!--            <input class="form-check-input" type="checkbox" role="switch" <?= $member_data->mem_headge_prices == '1' ? 'checked' : '' ?>>-->
                                <!--            <label class="form-check-label" for="flexSwitchCheckDefault">Hedge Prices</label>-->
                                <!--        </div>-->
                                <!--    </li>-->

                            </ul>
                        </div>
                    </div>
                </div>

            <?php } ?>
        </div>

        <div class="clearfix"></div>
    </div>
</header>