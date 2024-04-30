<!-- add Generics -->

<section class="popup inventory_new" data-popup="add_generics">

    <div class="tableDv">

        <div class="tableCell">

            <div class="contain">

                <div class=" inside">
                    <div class="crosBtn"></div>
                    <div class="content">
                        <h3>Add to Lot</h3>
                        <form action="<?= base_url('ajax/add_generics_to_lot') ?>" method="POST" class="frmAjax" id="frmContact">

                            <input type="hidden" name="generics_id" id="generics_id" value="">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="txtGrp">
                                        <label for="">Lot Name</label>
                                        <select name="lot_id" id="" class="txtBox">
                                            <option value=""> Select Lot </option>
                                            <?= get_lot_name_options('id') ?>

                                        </select>
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
                                            <input type="range" name="generics_fullness" id="generics_fullness" min="0" max="100" value="0" class="fullness-range">

                                            <div class="last_value">
                                                <p>100</p>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <ul class="btn_list">
                                        <!-- <li>
                                            <button class="webBtn lightBtn">Cencle</button>
                                        </li> -->
                                        <li>
                                            <button class="webBtn">Add to Lot</button>
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
<!--======= add generics to lot -->



<!-- =====add_code -->
<section class="popup inventory_new" data-popup="add_code">

    <div class="tableDv">

        <div class="tableCell">

            <div class="contain">

                <div class=" inside">
                    <div class="crosBtn"></div>
                    <div class="content">
                        <h3>Add to Lot</h3>
                        <form action="<?= base_url('ajax/add_code_to_lot') ?>" method="POST" class="frmAjax" id="frmContact">

                            <!-- <input type="hidden" name="code_id" id="code_id" value=""> -->
                            <input type="hidden" name="inventory_id" id="inventory_id" value="">
                            <input type="hidden" name="lot_type" id="lot_type" value="">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="txtGrp">
                                        <label for="">Lot Name</label>
                                        <select name="lot_id" id="" class="txtBox">
                                            <option value=""> Select Lot </option>
                                            <?= get_lot_name_options('id') ?>

                                        </select>
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
                                            <!-- <input type="range" name="code_fullness" id="code_fullness" min="0" max="100" value="0" class="fullness-range"> -->
                                            <input type="range" name="fullness" id="fullness" min="0" max="100" value="0" class="fullness-range">

                                            <div class="last_value">
                                                <p>100</p>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <ul class="btn_list">
                                        <!-- <li>
                                            <button class="webBtn lightBtn">Cencle</button>
                                        </li> -->
                                        <li>
                                            <button class="webBtn">Add to Lot</button>
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
<!-- ======add_code_lot -->
<section class="popup inventory_new" data-popup="add_code_lot">

    <div class="tableDv">

        <div class="tableCell">

            <div class="contain">

                <div class=" inside">
                    <div class="crosBtn"></div>
                    <div class="content">
                        <h3>Add a new Code and Add to Lot</h3>
                        <form action="">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="txtGrp">
                                        <label for="">Lot Name</label>
                                        <select name="" id="" class="txtBox">
                                            <option value="1">Select Lot</option>
                                            <option value="2">Lot 1</option>
                                            <option value="3">Lot 2</option>
                                            <option value="4">Lot 3</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="txtGrp">
                                        <label for="">Code</label>
                                        <input type="text" class="txtBox" placeholder="Input code name">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="txtGrp">
                                        <label for="">Item Price</label>
                                        <input type="text" class="txtBox" placeholder="0">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="txtGrp">
                                        <label for="">Item Fullness %</label>
                                        <div class="inner_block">
                                            <div class="first_value">
                                                <p>0</p>
                                            </div>
                                            <div class="example"></div>
                                            <div class="last_value">
                                                <p>100</p>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <ul class="btn_list">
                                        <li>
                                            <button class="webBtn lightBtn">Cencle</button>
                                        </li>
                                        <li>
                                            <button class="webBtn">Add to Lot</button>
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
<!-- =====add_fullness -->
<section class="popup inventory_new" data-popup="add_fullness">

    <div class="tableDv">

        <div class="tableCell">

            <div class="contain">

                <div class=" inside">
                    <div class="crosBtn"></div>
                    <div class="content">
                        <h3>Add Fullness</h3>
                        <form action="">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="txtGrp">
                                        <label for="">Quantity</label>
                                        <input type="text" class="txtBox" placeholder="Input quantity here">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="txtGrp">
                                        <label for="">Item Price</label>
                                        <input type="text" class="txtBox" placeholder="Input unit price">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="txtGrp">
                                        <label for="">Item Fullness %</label>
                                        <div class="inner_block">
                                            <div class="first_value">
                                                <p>0</p>
                                            </div>
                                            <div class="example"></div>
                                            <div class="last_value">
                                                <p>100</p>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <ul class="btn_list">
                                        <li>
                                            <button class="webBtn lightBtn">Cencle</button>
                                        </li>
                                        <li>
                                            <button class="webBtn">Add Fullness</button>
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
<!-- ======add_code_fullness -->
<section class="popup inventory_new" data-popup="add_code_fullness">

    <div class="tableDv">

        <div class="tableCell">

            <div class="contain">

                <div class=" inside">
                    <div class="crosBtn"></div>
                    <div class="content">
                        <h3>Add a Code</h3>
                        <form action="">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="txtGrp">
                                        <label for="">Code</label>
                                        <input type="text" class="txtBox" placeholder="Input code name">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="txtGrp">
                                        <label for="">Item Price</label>
                                        <input type="text" class="txtBox" placeholder="Input unit price">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="txtGrp">
                                        <label for="">Item Fullness %</label>
                                        <div class="inner_block">
                                            <div class="first_value">
                                                <p>0</p>
                                            </div>
                                            <div class="example"></div>
                                            <div class="last_value">
                                                <p>100</p>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <ul class="btn_list">
                                        <li>
                                            <button class="webBtn lightBtn">Cencle</button>
                                        </li>
                                        <li>
                                            <button class="webBtn">Add Fullness</button>
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
<!-- =====add_new_lot== -->
<section class="popup inventory_new" data-popup="add_new_lot">

    <div class="tableDv">

        <div class="tableCell">

            <div class="contain">

                <div class=" inside">
                    <div class="crosBtn"></div>
                    <div class="content">
                        <h3>Add new Lot</h3>
                        <form action="">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="txtGrp">
                                        <label for="">Choose Lot</label>
                                        <select name="" id="" class="txtBox">
                                            <option value="1">Select Lot</option>
                                            <option value="2">Lot 1</option>
                                            <option value="3">Lot 2</option>
                                            <option value="4">Lot 3</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <ul class="btn_list">
                                        <li>
                                            <button class="webBtn lightBtn">Cencle</button>
                                        </li>
                                        <li>
                                            <button class="webBtn">Add to Lot</button>
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
<!-- ===== submit_lot ==== -->
<section class="popup inventory_new" data-popup="submit_lot">

    <div class="tableDv">

        <div class="tableCell">

            <div class="contain">

                <div class=" inside">
                    <div class="crosBtn"></div>
                    <div class="content">
                        <h3>Add new Lot</h3>
                        <form action="<?= base_url('ajax/finish_lot_save/' . $inventory_detail->id) ?>" class="frmAjax" id="lot_finish_form">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="txtGrp">
                                        <label for="">Email</label>
                                        <input type="text" class="txtBox" name="email" placeholder="Your email">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="txtGrp">
                                        <label for="">Business Name</label>
                                        <input type="text" class="txtBox" placeholder="Your business name" name="buisness_name">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="txtGrp">
                                        <label for="">Identification</label>
                                        <button type="button" class="uploadImg">
                                            <i class="fa fa-cloud-upload" aria-hidden="true"></i>
                                            Upload Photo

                                        </button>
                                        <input type="file" class="uploadFile" id="uploadIdentification" />
                                        <span class="hidden loder" style="margin: auto"><i class="fa fa-spinner fa-spin" style="font-size:48px;color:#6e6efd;"></i></span>
                                        <div class="uploaded-area flex"></div>
                                        <div class="progress p100" style="display: none;" id="progress-contain-vehicle">
                                            <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="" id="myBar1"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <ul class="btn_list text-center">
                                        <li>
                                            <button class="webBtn" type="submit">Submit</button>
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