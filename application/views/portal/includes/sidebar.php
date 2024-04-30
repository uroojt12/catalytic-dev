<div class="sidebar-menu fixed">
    <div class="sidebar-menu-inner ps-container ps-active-y">
        <header class="logo-env">
            <div class="logo">
                <a href="<?= site_url(SUBADMIN . '/dashboard') ?>">
                    <img src="<?= base_url() . SITE_IMAGES . 'images/' . $this->subadmin->site_logo ?>" width="120" alt="">
                </a>
            </div>

            <div class="sidebar-collapse">
                <a href="#" class="sidebar-collapse-icon">
                    <i class="entypo-menu"></i>
                </a>
            </div>

            <div class="sidebar-mobile-menu visible-xs">
                <a href="#" class="with-animation">
                    <i class="entypo-menu"></i>
                </a>
            </div>

        </header>

        <ul id="main-menu" class="main-menu">
            <li class="opened <?= ($this->uri->segment('2') == 'dashboard' && $this->uri->segment('3') == '') ? 'active' : '' ?>">
                <a href="<?= site_url(SUBADMIN . '/dashboard') ?>">
                    <i class="fa fa-list"></i>
                    <span class="title">Dashboard</span>
                </a>
            </li>
            <li class="opened <?= ($this->uri->segment('2') == 'members' && $this->uri->segment('3') == '') ? 'active' : '' ?>">
                <a href="<?= site_url(SUBADMIN . '/members') ?>">
                    <i class="fa fa-users"></i>
                    <span class="title">Manage Members</span>
                </a>
            </li>



            <li class=" <?= ($this->uri->segment(2) == 'sitecontent') ? ' opened  active' : '' ?>">
                <a href="javascript:void(0)">
                    <i class="entypo-doc-text"></i>
                    <span class="title">Manage Pages</span>
                </a>
                <ul>

                    <li class="opened <?= ($this->uri->segment(3) == 'home') ? ' active' : '' ?>">
                        <a href="<?= site_url(SUBADMIN . '/sitecontent/home') ?>">
                            <i class="entypo-doc-text  "></i>
                            <span class="title">Home</span>
                        </a>
                    </li>



                    <li class="opened <?= ($this->uri->segment(3) == 'code') ? ' active' : '' ?>">
                        <a href="<?= site_url(SUBADMIN . '/sitecontent/code') ?>">
                            <i class="entypo-doc-text  "></i>
                            <span class="title">Code</span>
                        </a>
                    </li>
                    <li class="opened <?= ($this->uri->segment(3) == 'code_detail') ? ' active' : '' ?>">
                        <a href="<?= site_url(SUBADMIN . '/sitecontent/code_detail') ?>">
                            <i class="entypo-doc-text  "></i>
                            <span class="title">Code Detail</span>
                        </a>
                    </li>
                    <li class="opened <?= ($this->uri->segment(3) == 'inventory') ? ' active' : '' ?>">
                        <a href="<?= site_url(SUBADMIN . '/sitecontent/inventory') ?>">
                            <i class="entypo-doc-text  "></i>
                            <span class="title">Inventory</span>
                        </a>
                    </li>
                    <li class="opened <?= ($this->uri->segment(3) == 'inventory_detail') ? ' active' : '' ?>">
                        <a href="<?= site_url(SUBADMIN . '/sitecontent/inventory_detail') ?>">
                            <i class="entypo-doc-text  "></i>
                            <span class="title">Inventory Detail</span>
                        </a>
                    </li>
                    <li class="opened <?= ($this->uri->segment(3) == 'generic') ? ' active' : '' ?>">
                        <a href="<?= site_url(SUBADMIN . '/sitecontent/generic') ?>">
                            <i class="entypo-doc-text  "></i>
                            <span class="title">Generic</span>
                        </a>
                    </li>
                    <li class="opened <?= ($this->uri->segment(3) == 'generic_detail') ? ' active' : '' ?>">
                        <a href="<?= site_url(SUBADMIN . '/sitecontent/generic_detail') ?>">
                            <i class="entypo-doc-text  "></i>
                            <span class="title">Generic Detail</span>
                        </a>
                    </li>
                    <li class="opened <?= ($this->uri->segment(3) == 'photo_grade') ? ' active' : '' ?>">
                        <a href="<?= site_url(SUBADMIN . '/sitecontent/photo_grade') ?>">
                            <i class="entypo-doc-text  "></i>
                            <span class="title">Photo Grade</span>
                        </a>
                    </li>
                    <li class="opened <?= ($this->uri->segment(3) == 'photo_detail') ? ' active' : '' ?>">
                        <a href="<?= site_url(SUBADMIN . '/sitecontent/photo_detail') ?>">
                            <i class="entypo-doc-text  "></i>
                            <span class="title">Photo Grade Detail</span>
                        </a>
                    </li>
                    <li class="opened <?= ($this->uri->segment(3) == 'close_detail') ? ' active' : '' ?>">
                        <a href="<?= site_url(SUBADMIN . '/sitecontent/close_detail') ?>">
                            <i class="entypo-doc-text  "></i>
                            <span class="title">Close Detail</span>
                        </a>
                    </li>

                    <!-- <li class="opened <?= ($this->uri->segment(3) == 'contact_us') ? ' active' : '' ?>">
                        <a href="<?= site_url(SUBADMIN . '/sitecontent/contact_us') ?>">
                            <i class="entypo-doc-text  "></i>
                            <span class="title">Contact Us</span>
                        </a>
                    </li> -->

                    <li class="opened <?= ($this->uri->segment(3) == 'signup') ? ' active' : '' ?>">
                        <a href="<?= site_url(SUBADMIN . '/sitecontent/signup') ?>">
                            <i class="entypo-doc-text  "></i>
                            <span class="title">Sign Up</span>
                        </a>
                    </li>

                    <li class="opened <?= ($this->uri->segment(3) == 'login') ? ' active' : '' ?>">
                        <a href="<?= site_url(SUBADMIN . '/sitecontent/login') ?>">
                            <i class="entypo-doc-text  "></i>
                            <span class="title">Login</span>
                        </a>
                    </li>


                    <li class="opened <?= ($this->uri->segment(3) == 'forgot_password') ? ' active' : '' ?>">
                        <a href="<?= site_url(SUBADMIN . '/sitecontent/forgot_password') ?>">
                            <i class="entypo-doc-text  "></i>
                            <span class="title">Forgot Password</span>
                        </a>
                    </li>

                    <li class="opened <?= ($this->uri->segment(3) == 'change_password') ? ' active' : '' ?>">
                        <a href="<?= site_url(SUBADMIN . '/sitecontent/change_password') ?>">
                            <i class="entypo-doc-text  "></i>
                            <span class="title">Reset Password</span>
                        </a>
                    </li>


                </ul>
            </li>

            <li class="opened <?= ($this->uri->segment('2') == 'code' && $this->uri->segment('3') == '') ? 'active' : '' ?>">
                <a href="<?= site_url(SUBADMIN . '/code') ?>">
                    <i class="fa fa-list"></i>
                    <span class="title">Manage Code</span>
                </a>
            </li>
            <li class="opened <?= ($this->uri->segment('2') == 'generics' && $this->uri->segment('3') == '') ? 'active' : '' ?>">
                <a href="<?= site_url(SUBADMIN . '/generics') ?>">
                    <i class="fa fa-list"></i>
                    <span class="title">Manage Generics</span>
                </a>
            </li>

            <li class="opened<?= $this->uri->segment('2') == 'testimonials' ? ' active' : '' ?>">
                <a href="<?= site_url(SUBADMIN . '/testimonials') ?>">
                    <i class="fa fa-quote-left"></i>
                    <span class="title">Manage Testimonials</span>
                </a>
            </li>


            <li class="opened<?= $this->uri->segment('2') == 'newsletter' ? ' active' : '' ?>">
                <a href="<?= site_url(SUBADMIN . '/newsletter') ?>">
                    <i class="fa fa-bell" aria-hidden="true"></i>
                    <span class="title">Manage Newsletter Subscriptions</span> <span class="badge badge-danger"><?= new_sub_admin_subscribers($this->subadmin->site_id) ?></span>
                </a>
            </li>

            <li class="opened<?= $this->uri->segment('2') == 'lot' ? ' active' : '' ?>">
                <a href="<?= site_url(SUBADMIN . '/lot') ?>">
                    <i class="fa fa-bell" aria-hidden="true"></i>
                    <span class="title"> Lots Inventory</span> <span class="badge badge-danger"><?= new_sub_admin_lots_invent($this->subadmin->site_id) ?></span>
                </a>
            </li>
            <li class="opened<?= $this->uri->segment('2') == 'photo_grade' ? ' active' : '' ?>">
                <a href="<?= site_url(SUBADMIN . '/photo_grade') ?>">
                    <i class="fa fa-bell" aria-hidden="true"></i>
                    <span class="title"> Photo Grades</span> <span class="badge badge-danger"><?= new_sub_admin_grades($this->subadmin->site_id) ?></span>
                </a>
            </li>

            <li class="opened<?= $this->uri->segment('2') == 'colors' ? ' active' : '' ?>">
                <a href="<?= site_url(SUBADMIN . '/colors') ?>">
                    <i class="fa fa-bell" aria-hidden="true"></i>
                    <span class="title"> Manage Colors</span>
                </a>
            </li>

            <li class="opened <?= ($this->uri->segment('2') == 'settings' && $this->uri->segment('3') == '') ? 'active' : '' ?>">
                <a href="<?= site_url(SUBADMIN . '/settings') ?>">
                    <i class="fa fa-cogs"></i>
                    <span class="title">Site Settings</span>
                </a>
            </li>
            <li class="opened">
                <a href="<?= site_url(SUBADMIN . '/settings/change') ?>">
                    <i class="fa fa-lock"></i>
                    <span class="title">Change Password</span>
                </a>
            </li>
        </ul>
    </div>
</div>