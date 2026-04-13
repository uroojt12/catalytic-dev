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
                            <input type="hidden" name="generics_fullness" id="generics_fullness" value="">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="txtGrp">
                                        <label for="">Lot Name</label>
                                        <select name="lot_id" id="" class="txtBox" required>
                                            <option value=""> Select Lot </option>
                                            <?//= get_lot_name_options('id') ?>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="txtGrp">
                                        <label for="">Item Fullness % <span id="generic_slider_price">100</span></label>
                                        <div class="inner_block">
                                            <div class="first_value">
                                                <p>0</p>
                                            </div>
                                            <!-- <div class="example"></div> -->
                                            <!-- <div id="generic_price_slider"></div> -->
                                            <input type="range" name="generics_fullness" id="generics_fullness" min="0" max="100" value="100" class="fullness-range" step="25" style="width: 88%;" oninput="updateSliderValue(this.value)">

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
                            <input type="hidden" name="fullness" id="fullness" value="">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="txtGrp">
                                        <label for="">Lot Name</label>
                                        <select name="lot_id" id="" class="txtBox" required>
                                            <!--<option value=""> Select Lot </option>-->
                                            <?= get_lot_name_options('id') ?>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="txtGrp">
                                        <label for="">Item Fullness % <span id="code_slider_price">100</span></label>
                                        <div class="inner_block">
                                            <div class="first_value">
                                                <p>0</p>
                                            </div>
                                            <!-- <div id="code_price_slider"></div> -->
                                            <!-- <div class="example"></div> -->
                                            <input type="range" name="fullness" id="fullness" min="0" max="100" value="100" class="fullness-range" step="25" style="width: 88%;" oninput="updateSliderValue(this.value)">
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
                        <h3>Add details to closed your inventory</h3>
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
                                            <button class="webBtn closed-inventory-btn" type="submit">Submit<i class="spinner hidden"></i></button>
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



<!-- =====code_image== -->
<section class="popup generic_image new_pop_slider_img" data-popup="code_image">

    <div class="tableDv">

        <div class="tableCell">

            <div class="_inner">
                    <div class="crosBtn"></div>
                    <div class="content">
                        <h5 style="text-align: center;" class="popup_code_name"></h5>
                        <div class="pop_slider_images">
                            
                        
                        </div>
                    </div>

                </div>

        </div>

    </div>

</section>
<!-- ===== -->
<section class="popup generic_image new_pop_slider_img" data-popup="generic_image">

    <div class="tableDv">

        <div class="tableCell">

            <div class="contain">

                <div class=" inside">
                <div class="crosBtn_inner">
                                 <div class="crosBtn"></div>
                    </div>
                    <div class="content">
                        <h5 style="text-align: center;" class="popup_generic_name"></h5>
                        <div class="pop_slider_images">
                            
                        
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

</section>



<!-- ===== custom_codes ==== -->
<section class="popup inventory_new" data-popup="custom_codes">

    <div class="tableDv">

        <div class="tableCell">

            <div class="contain">

                <div class=" inside">
                    <div class="crosBtn"></div>
                    <div class="content">
                        <h3>Add Codes</h3>
                        <form action="<?= base_url('ajax/add_custome_code_to_lot') ?>" class="frmAjax">
                            <input type="hidden" name="lot_id" id="lot_id" value="<?= doDecode($this->uri->segment(2)) ?>">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="txtGrp">
                                        <label for="code_name">Code Name</label>
                                        <input type="text" class="txtBox" name="code_name" placeholder="Your Code Name" required>
                                    </div>
                                </div>
                                <!-- <div class="col-md-12">
                                    <div class="txtGrp">
                                        <label for="brand_id">Brands</label>
                                        <select class="txtBox" name="brand_id" id="brand_id" required>
                                            <option value="">---Select Brand---</option>
                                            <?php foreach ($brands as $brand) { ?>
                                                <option value="<?= $brand->id ?>"><?= get_brand_name($brand->id)  ?></option>

                                            <?php } ?>
                                        </select>
                                    </div>
                                </div> -->
                                <div class="col-md-12">
                                    <div class="txtGrp">
                                        <label for="code_price">Code Price</label>
                                        <input type="number" class="txtBox" min="1" step="any" name="code_price" id="code_price" placeholder="Price" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="txtGrp">
                                        <label for="">Fullness % <span id="custom_code_slider_price">100</span></label>
                                        <div class="inner_block">
                                            <div class="first_value">
                                                <p>0</p>
                                            </div>
                                            <input type="range" name="fullness" id="fullness" min="0" max="100" value="100" class="fullness-range" step="25" style="width: 88%;" oninput="updateSliderValue(this.value)">
                                            <div class="last_value">
                                                <p>100</p>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="txtGrp">
                                        <h4 class='item_price_custom_code'>Your Item price: <span></span></h4>
                                    </div>
                                </div>
                                

                                <div class="col-md-12">
                                    <div class="txtGrp">
                                        <label for="quantity">Quantity</label>
                                        <input type="number" class="txtBox" min="1" step="any" name="quantity" placeholder="Quantity" required>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="txtGrp">
                                        <label for="">Image</label>
                                        <button type="button" class="uploadImg">
                                            <i class="fa fa-cloud-upload" aria-hidden="true"></i>
                                            Upload Photo

                                        </button>
                                        <input type="file" class="uploadFile2" name="code_image" style="display: none;" />
                                        <span id="fileName" style="margin-top: 10px; display: block;"></span>
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

<!-- ===== custom_codes ==== -->
<section class="popup inventory_new" data-popup="custom_codes_grade">

    <div class="tableDv">

        <div class="tableCell">

            <div class="contain">

                <div class=" inside">
                    <div class="crosBtn"></div>
                    <div class="content">
                        <h3>Add Codes</h3>
                        <form action="<?= base_url('ajax/add_custome_code_to_lot') ?>" class="frmAjax">
                            <input type="hidden" name="grade_id" id="grade_id" >

                            <div class="row">

                                <div class="col-md-12">
                                    <div class="txtGrp">
                                        <label for="">Lot Name</label>
                                        <select name="lot_id" id="" class="txtBox" required>
                                            <option value=""> Select Lot </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="txtGrp">
                                        <label for="code_name">Code Name</label>
                                        <input type="text" class="txtBox" name="code_name" placeholder="Your Code Name" required>
                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <div class="txtGrp">
                                        <label for="code_price">Code Price</label>
                                        <input type="number" class="txtBox" min="1" step="any" name="code_price" id="grade_price" placeholder="Price" required>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="txtGrp">
                                        <label for="quantity">Quantity</label>
                                        <input type="number" class="txtBox" min="1" step="any" name="quantity" placeholder="Quantity" required>
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

<section class="popup custom_img_popup_view" data-popup="custum_buble_img">

    <div class="tableDv">

        <div class="tableCell">

            <div class="contain">

                <div class=" inside">
                <div class="crosBtn_inner">
                                 <div class="crosBtn"></div>
                    </div>
                    <div class="content">
                        <div class="images">
                            <img src="https://mastermindportal.org/uploads/photo_grade/3636638817772e42b59d74cff571fbb3_1717630616_9779.jpeg" alt="no_image">
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

</section>