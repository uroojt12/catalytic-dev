<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Ajax extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('page_model');
        $this->load->model('code_model');
        $this->load->model('generics_model');
        $this->load->library('pagination');

        $this->load->model('member_model');
        $this->member = $this->getActiveMem();
        $this->load->library('dompdf_lib');

        // $this->isMemLogged($this->session->id);
    }
    function test_data()
    {
        pr($this->session);
    }

    function upload_editor_attach()
    {
        if ($_FILES['upload']['name'] != '') {
            $image = upload_file(UPLOAD_PATH . "attachments/", 'upload', 'att');
            if (!empty($image['file_name'])) {
                exit(json_encode(['file_name' => $_FILES['upload']['name'], 'uploaded' => 1, 'url' => SITE_IMAGES . 'attachments/' . $image['file_name']]));
            } else {
                exit(json_encode(['fileName' => $_FILES['upload']['name'], 'status' => 1, 'error' => strip_tags($image['error'])]));
            }
        }
    }



    // /////lot name
    public function add_lot_name()
    {
        // pr("hi");
        $res = array();

        $this->data['member'] = $this->member_model->getMember($this->session->mem_id);


        if ($this->input->post()) {

            $vals = html_escape($this->input->post());
            // pr($vals);

            $data = array(
                'mem_id' => $this->session->mem_id,
                'lot_name' => $vals['lot_name'],
                'site_id' => $this->session->web_id,
                'created_date' => date('Y-m-d h:i:s'),
                'last_updated_date' => date('Y-m-d h:i:s'),

                'status' => 0
            );
            // pr($data);
            $id = $this->master->save("lot_name", $data);
            if ($id > 0) {

                $res['msg'] = "New Lot Created";
                $res['status'] = 1;
                $res['redirect_url'] = base_url('inventory/');
            } else {
                $res['msg'] = 'Technical problem!';
                $res['status'] = 0;
            }
        }
        exit(json_encode($res));
    }



    // ////// add code to lot inventory////
    function uploadLotIdentifications()
    {
        if ($_FILES['files']['name'] != "") {
            $res = array();
            $name = $_FILES['files']['name'];
            $image = upload_file(UPLOAD_PATH . "attachments", 'files', 'file');

            $res['file_name'] = $image['file_name'];

            if (!empty($image['file_name'])) {
                $res['name'] = $name;
                $res['file_path'] = get_site_image_src("attachments", $image['file_name']);
                $res['file_name'] = $image['file_name'];
                // pr($arr);
                // $this->member_model->save($arr, $this->session->mem_id);

                $res['upload_status'] = 1;
            } else {
                $res['upload_status'] = 0;
                $res['error'] = ' <div class="alert danger-alert cmn-alert"><span><i class="fi-cross"></i></span><em>Please upload a valid image file >> ' . strip_tags($image['error']) . '</em></div>';
            }
            exit(json_encode($res));
        }
    }


    // add code to lot ======


    public function add_code_to_lot()
    {
        if (empty($this->session->mem_id)) {
            $res['msg'] = "Please Signin first!";
            $res['status'] = 0;
            exit(json_encode($res));
        }

        $res = array();
        $this->data['member'] = $this->member_model->getMember($this->session->mem_id);

        if ($this->input->post()) {
            $vals = html_escape($this->input->post());
            $chk_code = chk_code_price_percentage($this->session->web_id, $vals['inventory_id']);
            $code_row = $this->master->getRow('code', array('id' => $vals['inventory_id']));
            $total_price = ($chk_code->percentage !== NULL && $chk_code->percentage > 0) ? floatval($chk_code->new_price) : floatval($code_row->price);


            $site_settings = $this->master->getRow("siteadmin", array('site_id' => '1'));
            $pump_cal_price = calculatedAllPrice($site_settings->site_o_pt_price, $site_settings->site_live_pt_price, $site_settings->site_o_pd_price, $site_settings->site_live_pd_price, $site_settings->site_o_rh_price, $site_settings->site_live_rh_price, $this->session->web_id, $code_row->id, $this->session->mem_id);
            $amount = $pump_cal_price;

            // if (!empty($this->data['member_data']) && $this->data['member_data']->mem_margin > 0) {
            //     $margin = $pump_cal_price * ($this->data['member_data']->mem_margin / 100);
            //     $amount = $pump_cal_price - $margin;
            // } else {
            //     $amount = $pump_cal_price;
            // }

            $percent = 100 - $vals['fullness'];
            $find_percent_amount = ($percent / 100) * $amount;
            $final_amount = $amount - $find_percent_amount;

            $data = array(
                'mem_id' => $this->session->mem_id,
                'inventory_id' => $vals['inventory_id'],
                'lot_id' => $vals['lot_id'],
                'site_id' => $this->session->web_id,
                'fullness' => $vals['fullness'],
                'qty' => 1,
                'lot_type' => $vals['lot_type'],
                'created_date' => date('Y-m-d h:i:s'),
                'amount' => $final_amount
            );

            $id = $this->master->save("add_code_to_lot", $data);

            if ($id > 0) {
                $this->master->save("lot_name", array('last_updated_date' => date('Y-m-d h:i:s')), 'id', $vals['lot_id']);

                // Check lot_type for different messages and redirects
                if ($vals['lot_type'] === 'Code') {
                    $res['msg'] = "Code Added To Lot";
                    // $res['redirect_url'] = base_url('code');
                    $res['status'] = 1;
                } elseif ($vals['lot_type'] === 'Generics') {
                    $res['msg'] = "Generic Added To Lot";
                    // $res['redirect_url'] = base_url('generics');
                    $res['status'] = 1;
                } else {
                    $res['msg'] = "Invalid type";
                }
            } else {
                $res['msg'] = 'Technical problem!';
                $res['status'] = 0;
            }
        }
        exit(json_encode($res));
    }

    public function update_cart()
    {
        $res = array();
        $res['status'] = 0;
        if ($this->input->post()) {
            $vals = html_escape($this->input->post());
            $row_id = $vals['row_id'];
            $res['vals'] = $vals;
            $qty = $vals['qty'];
            if ($inventory_code = $this->master->getRow('add_code_to_lot', array('mem_id' => $this->session->mem_id, 'site_id' => $this->session->web_id, 'id' => $row_id))) {
                $id = $this->master->save("add_code_to_lot", array('qty' => $qty), 'id', $inventory_code->id);
                if ($id > 0) {

                    $inventory_codes = $this->master->getRows('add_code_to_lot', array('mem_id' => $this->session->mem_id, 'site_id' => $this->session->web_id, 'lot_id' => $inventory_code->lot_id), '', '', 'DESC');
                    // pr($inventory_codes);

                    $count_avg = count($inventory_codes);
                    $grand_total = 0;
                    $html_markup = '';

                    $sub_admin_row = $site_settings = $this->master->getRow("add_domains", array('site_id' => $this->session->web_id));
                    $admin_site_settings = $this->master->getRow("siteadmin", array('site_id' => '1'));
                    foreach ($inventory_codes as $inventory_code) {
                        if ($code_row = $this->master->getRow('code', array('id' => $inventory_code->inventory_id))) {

                            // $pump_cal_price = calculatedAllPrice($admin_site_settings->site_o_pt_price, $admin_site_settings->site_live_pt_price, $admin_site_settings->site_o_pd_price, $admin_site_settings->site_live_pd_price, $admin_site_settings->site_o_rh_price, $admin_site_settings->site_live_rh_price, $this->session->web_id, $code_row->id, $this->session->mem_id);

                            $price = $inventory_code->amount * $inventory_code->qty;
                            $grand_total += $price;
                            if ($inventory_detail->status == 0) {
                                $minus_btn = '<input type="button" value="-" class="qtyminus readBtn">';
                                $plus_btn = '<input type="button" value="+" class="qtyplus readBtn">';
                                $anchor_tag = '<a href="javascript:void(0)" class="delete" id="del_row" data-row_id="' . $inventory_code->id . '">
                                <img src="' . base_url() . 'assets/images/delete.svg" alt="">
                            </a>';
                            }
                            $folder = $code_row->type === 'Code' ? 'code' : 'generics';
                            $html_markup .= '
                            <div class="flex">
                                <div class="content">
                                    <ul class="in_listing">                                      
                                         <li class="first_para">
                                            <p class="none_p"><strong>Title</strong></p>
                                            <div class="code_area">
                                                <div class="image-2">
                                                    <img src="' . get_site_code_image_src($folder, $code_row->image, $sub_admin_row) . '" alt="' . $sub_admin_row->site_name . '">
                                                </div>
                                                <p>' . $code_row->code . '</p>
                                            </div>
                                        </li>
                                        <li class="mobile_brand">
                                            <p class="none_p"><strong>Type</strong></p>
                                            <p class="brand_para">' . $code_row->new_type . '</p>
                                        </li>
                                        <li class="mobile_brand">
                                            <p class="none_p"><strong>Brand</strong></p>
                                            <p class="brand_para">' . get_brand_name($code_row->cat_id) . '</p>
                                        </li>
                                        <li class="full-mobile">
                                            <p><strong>Fullness</strong></p>
                                            <p>' . $inventory_code->fullness . '%</p>
                                        </li>
                                        <li>
                                            <p><strong>Price</strong></p>
                                            <p>' . format_amount($price) . '</p>
                                        </li>
                                       
                                         <li class="delete_list">
                                            <p><strong>Quantity</strong></p>
                                            <div class="qty_cart">
                                                <div class="qtyBtn">
                                                    ' . $minus_btn . '
                                                    <input type="text" name="quantity" value="' . $inventory_code->qty . '" class="qty">
                                                    ' . $plus_btn . '
                                                    <input type="hidden" name="row_id" class="row_id" value="' . $inventory_code->id . '">
                                                </div>
                                                ' . $anchor_tag . '
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            ';
                        } else {

                            $price = $inventory_code->code_price * $inventory_code->qty;
                            $grand_total += $price;
                            if ($inventory_detail->status == 0) {
                                $minus_btn = '<input type="button" value="-" class="qtyminus readBtn">';
                                $plus_btn = '<input type="button" value="+" class="qtyplus readBtn">';
                                $anchor_tag = '<a href="javascript:void(0)" class="delete" id="del_row" data-row_id="' . $inventory_code->id . '">
                                 <img src="' . base_url() . 'assets/images/delete.svg" alt="">
                             </a>';
                            }
                            $html_markup .= '
                             <div class="flex">
                                 <div class="content">
                                     <ul class="in_listing">                                      
                                          <li class="first_para">
                                             <p class="none_p"><strong>Title</strong></p>
                                             <div class="code_area">
                                                 <div class="image-2">
                                                     <img src="' . get_site_code_image_src('code', $inventory_code->code_image, $sub_admin_row) . '" alt="' . $sub_admin_row->site_name . '">
                                                 </div>
                                                 <p>' . $inventory_code->code_name . '</p>
                                             </div>
                                         </li>
                                          <li class="mobile_brand">
                                             <p class="none_p"><strong>Type</strong></p>
                                             <p class="brand_para">N/A</p>
                                         </li>
                                         <li class="mobile_brand">
                                             <p class="none_p"><strong>Brand</strong></p>
                                             <p class="brand_para">N/A</p>
                                         </li>
                                         <li class="full-mobile">
                                             <p><strong>Fullness</strong></p>
                                             <p>' . $inventory_code->fullness . '%</p>
                                         </li>
                                         <li>
                                             <p><strong>Price</strong></p>
                                             <p>' . format_amount($price) . '</p>
                                         </li>
                                        
                                          <li class="delete_list">
                                             <p><strong>Quantity</strong></p>
                                             <div class="qty_cart">
                                                 <div class="qtyBtn">
                                                     ' . $minus_btn . '
                                                     <input type="text" name="quantity" value="' . $inventory_code->qty . '" class="qty">
                                                     ' . $plus_btn . '
                                                     <input type="hidden" name="row_id" class="row_id" value="' . $inventory_code->id . '">
                                                 </div>
                                                 ' . $anchor_tag . '
                                             </div>
                                         </li>
                                     </ul>
                                 </div>
                             </div>
                             ';
                        }
                    }

                    $categories = $this->master->getRows('categories', array('status' => 1));
                    $count_html_output = '';
                    foreach ($categories as $category) {
                        // Check if the category has codes for the given lot_id
                        if (count_codes_for_cat_id($category->id, $inventory_code->lot_id) > 0) {
                            $count_html_output .= '
                            <div class="total_flex">
                                <div><strong>' . $category->name . '</strong></div>
                                <div>' . count_codes_for_cat_id($category->id, $inventory_code->lot_id) . ' __ ' . format_amount(sum_amount_for_cat_id($category->id, $inventory_code->lot_id)) . '</div>
                            </div>';
                        }
                    }


                    $res['html'] = $html_markup;
                    $res['grand_total'] = format_amount($grand_total);
                    $total_converters = 0;
                    foreach ($inventory_codes as $code_row_qty) :
                        $total_converters += $code_row_qty->qty;
                    endforeach;
                    $avg_price = $total_converters > 0 ? $grand_total / $total_converters : 0;
                    $res['average_price'] = format_amount_decimal($avg_price, 2);
                    $res['total_converters'] = $total_converters;
                    $res['count_html_output'] = $count_html_output;

                    $res['status'] = 1;
                    $res['msg'] = 'Updated successfully!';
                }
            } else {
                $res['msg'] = 'no inventory code';
            }
        } else {
            $vals = html_escape($this->input->post());
            $res['vals'] = $vals;
        }
        exit(json_encode($res));
    }

    public function delete_cart()
    {
        $res = array();
        $res['status'] = 0;
        if ($this->input->post()) {
            $vals = html_escape($this->input->post());
            $row_id = $vals['row_id'];
            $res['vals'] = $vals;
            if ($inventory_code = $this->master->getRow('add_code_to_lot', array('mem_id' => $this->session->mem_id, 'site_id' => $this->session->web_id, 'id' => $row_id))) {

                $id = $this->master->delete_where('add_code_to_lot', array('id' => $inventory_code->id));
                if ($id > 0) {

                    $inventory_codes = $this->master->getRows('add_code_to_lot', array('mem_id' => $this->session->mem_id, 'site_id' => $this->session->web_id, 'lot_id' => $inventory_code->lot_id), '', '', 'DESC');


                    // pr($inventory_codes);
                    $count_avg = count($inventory_codes);
                    // pr($count_avg);

                    $grand_total = 0;
                    $html_markup = '';

                    $sub_admin_row = $site_settings = $this->master->getRow("add_domains", array('site_id' => $this->session->web_id));
                    $admin_site_settings = $this->master->getRow("siteadmin", array('site_id' => '1'));
                    foreach ($inventory_codes as $inventory_code) {
                        if ($code_row = $this->master->getRow('code', array('id' => $inventory_code->inventory_id))) {

                            $price = $inventory_code->amount * $inventory_code->qty;
                            // $price = $inventory_code->amount;
                            $grand_total += $price;
                            if ($inventory_detail->status == 0) {
                                $minus_btn = '<input type="button" value="-" class="qtyminus readBtn">';
                                $plus_btn = '<input type="button" value="+" class="qtyplus readBtn">';
                                $anchor_tag = '<a href="javascript:void(0)" class="delete" id="del_row" data-row_id="' . $inventory_code->id . '">
                                <img src="' . base_url() . 'assets/images/delete.svg" alt="">
                            </a>';
                            }
                            $folder = $code_row->type === 'Code' ? 'code' : 'generics';
                            $html_markup .= '
                            <div class="flex">
                                <div class="content">
                                    <ul class="in_listing custom_in_listing">
                                        <li class="first_para">
                                            <p class="none_p"><strong>Title</strong></p>
                                            <div class="code_area mobile_accordian_custom">
                                                <div class="image-2">
                                                    <img src="' . get_site_code_image_src($folder, $code_row->image, $sub_admin_row) . '" alt="' . $sub_admin_row->site_name . '">
                                                </div>
                                                <p>' . $code_row->code . '</p>
                                            </div>
                                        </li>
                                         <li class="mobile_brand acc_ordian">
                                            <p class="none_p"><strong>Type</strong></p>
                                            <p class="brand_para">' . $code_row->new_type . '</p>
                                        </li>
                                        <li class="mobile_brand acc_ordian">
                                            <p class="none_p"><strong>Brand</strong></p>
                                            <p class="brand_para">' . get_brand_name($code_row->cat_id) . '</p>
                                        </li>
                                        <li class="full-mobile acc_ordian">
                                            <p><strong>Fullness</strong></p>
                                            <p>' . $inventory_code->fullness . '%</p>
                                        </li>
                                        <li class="acc_ordian">
                                            <p><strong>Price</strong></p>
                                            <p>' . format_amount($price) . '</p>
                                        </li>
                                         <li class="delete_list acc_ordian">
                                            <p><strong>Quantity</strong></p>
                                            <div class="qty_cart">
                                                <div class="qtyBtn">
                                                    ' . $minus_btn . '
                                                    <input type="text" name="quantity" value="' . $inventory_code->qty . '" class="qty">
                                                    ' . $plus_btn . '
                                                    <input type="hidden" name="row_id" class="row_id" value="' . $inventory_code->id . '">
                                                </div>
                                                ' . $anchor_tag . '
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            ';
                        } else {
                            $price = $inventory_code->code_price * $inventory_code->qty;
                            // $price = $inventory_code->amount;
                            $grand_total += $price;
                            if ($inventory_detail->status == 0) {
                                $minus_btn = '<input type="button" value="-" class="qtyminus readBtn">';
                                $plus_btn = '<input type="button" value="+" class="qtyplus readBtn">';
                                $anchor_tag = '<a href="javascript:void(0)" class="delete" id="del_row" data-row_id="' . $inventory_code->id . '">
                                <img src="' . base_url() . 'assets/images/delete.svg" alt="">
                            </a>';
                            }
                            $html_markup .= '
                            <div class="flex">
                                <div class="content">
                                    <ul class="in_listing custom_in_listing">
                                        <li class="first_para">
                                            <p class="none_p"><strong>Title</strong></p>
                                            <div class="code_area mobile_accordian_custom">
                                                <div class="image-2">
                                                    <img src="' . get_site_code_image_src('code', $inventory_code->code_image, $sub_admin_row) . '" alt="' . $sub_admin_row->site_name . '">
                                                </div>
                                                <p>' . $inventory_code->code_name . '</p>
                                            </div>
                                        </li>
                                          <li class="mobile_brand acc_ordian">
                                            <p class="none_p"><strong>Type</strong></p>
                                             <p class="brand_para">N/A</p>
                                        </li>
                                        <li class="mobile_brand acc_ordian">
                                            <p class="none_p"><strong>Brand</strong></p>
                                             <p class="brand_para">N/A</p>
                                        </li>
                                        <li class="full-mobile acc_ordian">
                                            <p><strong>Fullness</strong></p>
                                            <p>' . $inventory_code->fullness . '%</p>
                                        </li>
                                        <li class="acc_ordian">
                                            <p><strong>Price</strong></p>
                                            <p>' . format_amount($price) . '</p>
                                        </li>
                                         <li class="delete_list acc_ordian">
                                            <p><strong>Quantity</strong></p>
                                            <div class="qty_cart">
                                                <div class="qtyBtn">
                                                    ' . $minus_btn . '
                                                    <input type="text" name="quantity" value="' . $inventory_code->qty . '" class="qty">
                                                    ' . $plus_btn . '
                                                    <input type="hidden" name="row_id" class="row_id" value="' . $inventory_code->id . '">
                                                </div>
                                                ' . $anchor_tag . '
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            ';
                        }
                    }


                    $categories = $this->master->getRows('categories', array('status' => 1));
                    $count_html_output = '';
                    foreach ($categories as $category) {
                        // Check if the category has codes for the given lot_id
                        if (count_codes_for_cat_id($category->id, $inventory_code->lot_id) > 0) {
                            $count_html_output .= '
                        <div class="total_flex">
                            <div><strong>' . $category->name . '</strong></div>
                            <div>' . count_codes_for_cat_id($category->id, $inventory_code->lot_id) . ' __ ' . format_amount(sum_amount_for_cat_id($category->id, $inventory_code->lot_id)) . '</div>
                        </div>';
                        }
                    }


                    $res['html'] = $html_markup;
                    $res['grand_total'] = format_amount($grand_total);
                    $total_converters = 0;
                    foreach ($inventory_codes as $code_row_qty) :
                        $total_converters += $code_row_qty->qty;
                    endforeach;
                    $avg_price = $total_converters > 0 ? $grand_total / $total_converters : 0;
                    $res['average_price'] = format_amount_decimal($avg_price, 2);
                    $res['total_converters'] = $total_converters;
                    $res['count_html_output'] = $count_html_output;
                    // $res['total_converters'] = count($inventory_codes);

                    $res['status'] = 1;
                    $res['msg'] = 'Deleted successfully!';
                }
            } else {
                $res['msg'] = 'no inventory code';
            }
        } else {
            $vals = html_escape($this->input->post());
            $res['vals'] = $vals;
        }
        exit(json_encode($res));
    }

    public function add_custome_code_to_lot()
    {

        $res = array();
        if ($this->input->post()) {
            $vals = html_escape($this->input->post());

            $chk_grade = $this->master->getRow('add_photo_grade', array('id' => $vals['grade_id']));
            // pr($chk_grade);
            if (!empty($chk_grade)) {
                if (!empty($chk_grade->grade_image)) {
                    $source_image = FCPATH . 'uploads/photo_grade/' . $chk_grade->grade_image;
                    $destination_path = FCPATH . 'uploads/code/' . basename($chk_grade->grade_image);

                    if (file_exists($source_image)) {
                        if (copy($source_image, $destination_path)) {
                            $vals['code_image'] = basename($chk_grade->grade_image);
                        } else {
                            $vals['code_image'] = $chk_grade->grade_image;
                        }
                    }
                }

                $vals['fullness'] = $chk_grade->grade_fullness;
            }


            if (isset($_FILES["code_image"]["name"]) && $_FILES["code_image"]["name"] != "") {
                $code_image1 = upload_file(UPLOAD_PATH . 'code/', 'code_image');
                $vals['code_image'] = $code_image1['file_name'];
            }

            // $percent = 100 - $vals['fullness'];
            // $find_percent_amount = ($percent / 100) * $vals['code_price'];
            // $final_amount = $vals['code_price'] - $find_percent_amount;
            // // pr($final_amount);

            // $amount = $final_amount * $vals['quantity'];
            $amount = $vals['code_price'] * $vals['quantity'];





            $data = array(
                'mem_id' => $this->session->mem_id,
                'site_id' => $this->session->web_id,
                'lot_id' => $vals['lot_id'],
                'code_name' => $vals['code_name'],
                'fullness' => $vals['fullness'],
                // 'code_price' => $final_amount,
                'code_price' => $vals['code_price'],
                'qty' => $vals['quantity'],
                // 'cat_id' => $vals['brand_id'],
                'code_image' => $vals['code_image'],
                'created_date' => date('Y-m-d h:i:s'),
                'amount' => $amount
            );
            // pr($data);


            $id = $this->master->save("add_code_to_lot", $data);
            if ($id > 0) {
                $res['msg'] = "Custom Code Added Successfully";
                $res['redirect_url'] = base_url('inventory-detail/' . doEncode($data['lot_id']));
                $res['status'] = 1;
            } else {
                $res['msg'] = 'Technical problem!';
                $res['status'] = 0;
            }
            exit(json_encode($res));
        }
    }



    // public function add_custome_code_to_lot()
    // {

    //     $res = array();
    //     if ($this->input->post()) {
    //         $vals = html_escape($this->input->post());
    //         if (isset($_FILES["code_image"]["name"]) && $_FILES["code_image"]["name"] != "") {
    //             $code_image1 = upload_file(UPLOAD_PATH . 'code/', 'code_image');
    //             $vals['code_image'] = $code_image1['file_name'];
    //         }
    //         $price=$vals['code_price'];
    //         if(floatval($vals['fullness'])<100){
    //             $fullness=100 - floatval($vals['fullness']);
    //             $percent_price=(floatval($price) * $fullness)/100;
    //             $price=floatval($price) - $percent_price;
    //         }
    //         $amount = $price * $vals['quantity'];

    //         $data = array(
    //             'mem_id' => $this->session->mem_id,
    //             'site_id' => $this->session->web_id,
    //             'lot_id' => $vals['lot_id'],
    //             'code_name' => $vals['code_name'],
    //             'fullness' => $vals['fullness'],
    //             'code_price' => $price,
    //             'qty' => $vals['quantity'],
    //             // 'cat_id' => $vals['brand_id'],
    //             'code_image' => $vals['code_image'],
    //             'created_date' => date('Y-m-d h:i:s'),
    //             'amount' => $amount
    //         );

    //         $id = $this->master->save("add_code_to_lot", $data);
    //         if ($id > 0) {
    //             $res['msg'] = "Custom Code Added Successfully";
    //             $res['redirect_url'] = base_url('inventory-detail/' . doEncode($data['lot_id']));
    //             $res['status'] = 1;
    //         } else {
    //             $res['msg'] = 'Technical problem!';
    //             $res['status'] = 0;
    //         }
    //         exit(json_encode($res));
    //     }
    // }



    public function finish_lot_save($id)
    {
        $res = array();
        $res['status'] = 0;
        if ($this->input->post()) {
            $this->form_validation->set_rules('email', 'Email', 'required');
            $this->form_validation->set_rules('buisness_name', 'Buisness Name', 'required');
            // $this->form_validation->set_rules('identification_file', 'File', 'required');

            if ($this->form_validation->run() === FALSE) {

                $res['msg'] = validation_errors();
            } else {
                $vals = html_escape($this->input->post());

                if (!empty($id) && $inventory_detail = $this->master->getRow('lot_name', array('id' => $id, 'mem_id' => $this->session->mem_id, 'site_id' => $this->session->web_id))) {
                    $inventory_codes = $this->master->getRows('add_code_to_lot', array('mem_id' => $this->session->mem_id, 'site_id' => $this->session->web_id, 'lot_id' => $inventory_detail->id), '', '', 'DESC');
                    foreach ($inventory_codes as $inventory_code) {
                        $this->master->save("add_code_to_lot", array('status' => 1), 'id', $inventory_code->id);
                    }
                    $data = array(
                        'email' => $vals['email'],
                        'buisness_name' => $vals['buisness_name'],
                        'identification_file' => $vals['identification_file'],
                        'identification_file_name' => $vals['identification_file_name'],
                        'status' => 1
                    );
                    $id = $this->master->save("lot_name", $data, 'id', $inventory_detail->id);
                    if ($id > 0) {
                        $this->new_pdf_export(doEncode($inventory_detail->id));
                        $inventory_data = array(
                            'email' => $vals['email'],
                            'name' => get_mem_name($this->session->mem_id),
                            'inventory_detail_id' => $inventory_detail->id,
                        );

                        //$this->send_finish_lot_pdf_email($inventory_data);

                        $res['status'] = 1;
                        $res['msg'] = 'Submitted successfully!';
                        $res['redirect_url'] = base_url('inventory');
                    }
                } else {
                    $res['msg'] = 'Technical problem!';
                }
            }
        }
        exit(json_encode($res));
    }



    function newsletter()
    {
        // pr("hi");
        $res = array();
        if ($this->input->post()) {
            $this->form_validation->set_rules(
                'email',
                'Email',
                'required|valid_email|is_unique[newsletter.email]',
                array(
                    'required'      => 'You have not provided %s.',
                    'is_unique'     => 'This %s already joined.'
                )
            );
            if ($this->form_validation->run() === FALSE) {
                $res['msg'] = validation_errors();
            } else {

                $vals = html_escape($this->input->post());
                // pr($vals);
                // pr($vals['booking_date_format']);
                // print_r(date("Y-m-d H:i:s", strtotime($vals['booking_date_format'])));
                $data = array(
                    'email' => $vals['email'],
                    'status' => 0,
                    'site_id' =>  $this->session->web_id,
                );
                // pr($data);
                $id = $this->master->save("newsletter", $data);
                // pr($id);
                if ($id > 0) {

                    $this->send_query_successful($data);
                    $this->send_query_recieved_admin($data);
                    $res['msg'] = 'Subscribed successfully!';
                    $res['status'] = 1;
                } else {
                    $res['msg'] = 'Technical problem!';
                    $res['status'] = 0;
                }
            }
        }
        exit(json_encode($res));
    }
    // ///////////code page filter//////

    function code_filter($page = '1')
    {
        $per_page = 8;
        $total = $this->code_model->num_rows(array('status' => 1));

        $page = intval($page);
        $start = ($page - 1) * $per_page;

        $sort_order = $this->input->post('sort_order');

        if ($this->input->post()) {
            $post = html_escape($this->input->post());
            $this->data['find_code'] = $this->code_model->filter_code($post, $per_page, $start, $sort_order);
            $total = count($this->code_model->filter_code($post));
        } else {
            $this->data['find_code'] = $this->code_model->get_rows(array('status' => 1), $start, $per_page);
        }
        $query = $this->db->last_query();

        $total_results = $total;
        $sub_admin_row = $site_settings = $this->master->getRow("add_domains", array('site_id' => $this->session->web_id));
        $price_pump = !empty($sub_admin_row->price_pump) ? $sub_admin_row->price_pump :  2;
        $site_settings = $this->master->getRow("siteadmin", array('site_id' => '1'));
        // Load the view
        $html = '';
        if (!empty($this->data['find_code'])) {
            foreach ($this->data['find_code'] as $code_p) {
                $pump_cal_price = calculatedAllPrice($site_settings->site_o_pt_price, $site_settings->site_live_pt_price, $site_settings->site_o_pd_price, $site_settings->site_live_pd_price, $site_settings->site_o_rh_price, $site_settings->site_live_rh_price, $this->session->web_id, $code_p->id, $this->session->mem_id);

                // if (!empty($this->data['member_data']) && $this->data['member_data']->mem_margin > 0) {
                //     $margin = $pump_cal_price * ($this->data['member_data']->mem_margin / 100);
                //     $amount = $pump_cal_price - $margin;
                // } else {
                //     $amount = $pump_cal_price;
                // }

                $amount = $pump_cal_price;
                $html .= '<div class="cols">
                <div class="inner">
                    
                    <div class="bottom_content">
                        <div class="image_2 popBtn" data-code-name="' . $code_p->code . '" data-popup="code_image" data-image-url="' . get_site_code_image_src("code", $code_p->image, $sub_admin_row) . '">
                        <img src="' . get_site_code_image_src("code", $code_p->image, $sub_admin_row) . '" alt="' . $this->data['site_settings']->site_name . '" alt="">
                        </div>
                        <div class="content">
                            <h5><a href="' . base_url('code-detail/' . doEncode($code_p->id)) . '">' . $code_p->title . '</a></h5>
                            <p>' . $code_p->code . '</p>
                            ';
                if (!empty($this->session->mem_id)) {
                    $html .= ' <div class="cta_price">
                                    <h5><strong>' . format_amount($amount) . '</strong></h5>
                                    <div class="cta">
                                        <a href="javascript:void(0)" class="webBtn popBtn" data-lot_type="' . ($code_p->type) . '" data-inventory_id="' . ($code_p->id) . '" data-popup="add_code" data-options="get_lot_names">Add</a>
                                    </div>
                                </div>';
                }
                $html .= '                        
                        </div>
                    </div>
                </div>
            </div>';
            }
        } else {
            $html = '<div class="alert alert-danger">No Code Available!!!</div>';
        }
        echo json_encode(array(
            'html' => $html,
            'total_results' => $total_results,
            'links' => $links,
            'query' => $query
        ));
    }


    // /////////////////////////////////// generic page filter///////


    function generics_filter($page = '1')
    {


        $per_page = 8;
        $total = $this->generics_model->num_rows(array('status' => 1));

        $page = intval($page);
        $start = ($page - 1) * $per_page;
        $sort_order = $this->input->post('sort_order');


        if ($this->input->post()) {
            $post = html_escape($this->input->post());
            $this->data['find_generics'] = $this->generics_model->filter_generics($post, $per_page, $start, $sort_order);
            $total = count($this->generics_model->filter_generics($post));
        } else {
            $this->data['find_generics'] = $this->generics_model->get_rows(array('status' => 1), $start, $per_page);
        }

        // pr($this->data['find_generics']);
        $query = $this->db->last_query();

        $total_results = $total;
        $sub_admin_row = $site_settings = $this->master->getRow("add_domains", array('site_id' => $this->session->web_id));
        $price_pump = !empty($sub_admin_row->price_pump) ? $sub_admin_row->price_pump :  2;
        $site_settings = $this->master->getRow("siteadmin", array('site_id' => '1'));


        $html = '';
        if (!empty($this->data['find_generics'])) {
            foreach ($this->data['find_generics'] as $generic) {
                $pump_cal_price = calculatedAllPrice($site_settings->site_o_pt_price, $site_settings->site_live_pt_price, $site_settings->site_o_pd_price, $site_settings->site_live_pd_price, $site_settings->site_o_rh_price, $site_settings->site_live_rh_price, $this->session->web_id, $generic->id, $this->session->mem_id);

                // if (!empty($this->data['member_data']) && $this->data['member_data']->mem_margin > 0) {
                //     $margin = $pump_cal_price * ($this->data['member_data']->mem_margin / 100);
                //     $amount = $pump_cal_price - $margin;
                // } else {
                //     $amount = $pump_cal_price;
                // }

                $amount = $pump_cal_price;
                $html .= '<div class="cols">
                <div class="inner">
                    
                    <div class="bottom_content">
                        <div class="image_2 popBtn" data-generic-name="' . $generic->code . '" data-popup="generic_image" data-image-url="' . get_site_code_image_src("generics", $generic->image, $sub_admin_row) . '">
                        <img src="' . get_site_code_image_src("generics", $generic->image, $sub_admin_row) . '" alt="' . $this->data['site_settings']->site_name . '" alt="">
                        </div>
                        <div class="content">
                            <h5><a href="' . base_url('generic-detail/' . doEncode($generic->id)) . '">' . $generic->title . '</a></h5>
                            <p>' . $generic->code . '</p>
                             ';
                if (!empty($this->session->mem_id)) {

                    $html .= ' <div class="cta_price">
                                <h5><strong>' . format_amount($amount) . '</strong></h5>
                                <div class="cta">
                                    <a href="javascript:void(0)" class="webBtn popBtn" data-lot_type="' . ($generic->type) . '" data-inventory_id="' . ($generic->id) . '" data-popup="add_code" data-options="get_lot_names">Add</a>
                                </div>
                            </div>';
                }
                $html .= '                      
                        </div>
                    </div>
                </div>
            </div>';
            }
        } else {
            $html = '<div class="alert alert-danger">No Generic Available!!!</div>';
        }
        echo json_encode(array(
            'html' => $html,
            'total_results' => $total_results,
            'links' => $links,
            'query' => $query
        ));
    }


    /////////

    function add_photo_grade()
    {
        $res = array();

        if (empty($this->session->mem_id)) {
            $res['msg'] = "Please Signin first!";
            $res['status'] = 0;
            exit(json_encode($res));
        }

        if ($this->input->post()) {
            $vals = html_escape($this->input->post());
            if (isset($_FILES["grade_image"]["name"])) {

                $image1 = upload_file(UPLOAD_PATH . 'photo_grade/', 'grade_image');
                $vals['grade_image'] = $image1['file_name'];
            }

            $data =
                [
                    'mem_id' => $this->session->mem_id,
                    'site_id' => $this->session->web_id,
                    'grade_image'   =>  $vals['grade_image'],
                    'grade_fullness' => $vals['grade_fullness'],
                    'grade_notes'     => $vals['grade_notes'],
                    'created_date'     => date('Y-m-d h:i:s'),

                ];
            // pr($data);

            $id = $this->master->save('add_photo_grade', $data);

            if ($id > 0) {
                $subadmin = get_subadmin($this->session->web_id);
                $photo_data = array(
                    'email' => $subadmin->site_email,
                    // 'name' => ucfirst($member->mem_fname) . ' ' . ucfirst($member->mem_lname),
                    'photo' => $this->master->getRow('add_photo_grade', array('id' => $id)),
                );

                $this->send_photo_grade_status_email($photo_data, $photo_data['email']);
                // $this->send_photo_grade_status_email($photo_data,'abidaa.rehman@gmail.com');

                $res['msg'] = 'Photo grade submitted successfully.';
                $res['status'] = 1;
                $res['redirect_url'] = base_url('photo-grade');
                exit(json_encode($res));
            } else {
                $res['msg'] = 'Technical Problem';
                $res['status'] = 0;
                exit(json_encode($res));
            }
            // }
        } else {
            show_404();
        }
    }


    function uploadPhotoGrade()
    {
        if ($_FILES['files']['name'] != "") {
            $res = array();
            $name = $_FILES['files']['name'];
            $image = upload_file(UPLOAD_PATH . "photo_grade", 'files', 'file');

            $res['file_name'] = $image['file_name'];

            if (!empty($image['file_name'])) {
                $res['name'] = $name;
                $res['file_path'] = get_site_image_src("photo_grade", $image['file_name']);
                $res['file_name'] = $image['file_name'];
                // pr($arr);
                // $this->member_model->save($arr, $this->session->mem_id);

                $res['upload_status'] = 1;
            } else {
                $res['upload_status'] = 0;
                $res['error'] = ' <div class="alert danger-alert cmn-alert"><span><i class="fi-cross"></i></span><em>Please upload a valid image file >> ' . strip_tags($image['error']) . '</em></div>';
            }
            exit(json_encode($res));
        }
    }


    function get_search_generic_data()
    {

        $res = array();
        $vals = html_escape($this->input->post());


        // pr($vals);
        $generics = $this->generics_model->searchGenerics($vals['word']);
        $query = $this->db->last_query();
        $res['query'] = $query;

        $html = "";
        $html .= "<ul>";

        foreach ($generics as $gen) {
            $html .= "<li  data-generic='" . $gen->code . "'>" . $gen->code . "</li><br>";
        }
        $html .= "</ul>";

        if (!empty($generics)) {
            $res['data'] = $html;
            $res['status'] = true;
        } else {
            $res['status'] = false;
        }
        exit(json_encode($res));
    }


    function get_search_code_data()
    {

        $res = array();
        $vals = html_escape($this->input->post());


        // pr($vals);
        $codes = $this->code_model->searchCodes($vals['word']);
        $query = $this->db->last_query();
        $res['query'] = $query;
        $html = "";
        $html .= "<ul>";

        foreach ($codes as $code) {
            $html .= "<li data-brand='" . $code->category_name . "' data-code='" . $code->code . "'><b>" . strtoupper($code->category_name) . "</b> " . $code->code . "</li><br>";
        }
        $html .= "</ul>";

        if (!empty($codes)) {
            $res['data'] = $html;
            $res['status'] = true;
        } else {
            $res['status'] = false;
        }
        exit(json_encode($res));
    }



    public function update_member()
    {
        $res = array();
        $res['status'] = 0;
        if ($this->input->post()) {
            $vals = html_escape($this->input->post());
            if ($member = $this->master->getRow('members', array('mem_id' => $this->session->mem_id, 'site_id' => $this->session->web_id))) {
                $id = $this->master->save("members", array('mem_headge_prices' => $vals['isChecked']), 'mem_id', $member->mem_id);
                if ($id > 0) {
                    $getmember = $this->master->getRow('members', array('mem_id' => $id));
                    $res['status'] = 1;
                    if ($getmember->mem_headge_prices == '1') {
                        $res['msg'] = 'Your hedge prices ON successfully!';
                    } else {
                        $res['msg'] = 'Your hedge prices OFF successfully!';
                    }
                }
            } else {
                show_404();
            }
        }
        exit(json_encode($res));
    }


    public function generate_pdf($html, $filename = '', $stream = TRUE)
    {
        require_once APPPATH . 'vendor/autoload.php';

        // Create an instance of the class
        $mpdf = new \Mpdf\Mpdf([
            'format' => 'A4', // Set to A4 paper size
            'orientation' => 'P', // Portrait orientation
            'tempDir' => FCPATH . 'uploads/tmp' // Set the temporary directory
        ]);

        // Set the content
        $mpdf->WriteHTML($html);

        // Output the PDF
        if ($stream) {
            $mpdf->Output($filename . '.pdf', \Mpdf\Output\Destination::INLINE);
        } else {
            $file_path = FCPATH . 'uploads/pdf/' . $filename . '.pdf';
            $mpdf->Output($file_path, \Mpdf\Output\Destination::FILE);
            if (file_exists($file_path)) {
                return $filename;
            } else {
                return 0;
            }
        }
    }


    public function pdf_export($id)
    {
        $res['status'] = 0;
        $id = doDecode($id);
        $id = intval($id);
        if (!empty($id) && $this->data['inventory_detail'] = $this->master->getRow('lot_name', array('id' => $id, 'mem_id' => $this->session->mem_id, 'site_id' => $this->session->web_id))) {
            $total_price = 0;
            $inventory_codes = $this->master->getRows('add_code_to_lot', array('mem_id' => $this->session->mem_id, 'site_id' => $this->session->web_id, 'lot_id' => $this->data['inventory_detail']->id), '', '', 'DESC');
            $new_type_values = $this->master->getNewTypeFromInventoryDetails($this->data['inventory_detail']->id);

            $codes_arr = array();
            foreach ($inventory_codes as $inventory_code) {
                if ($code_row = $this->master->getRow('code', array('id' => $inventory_code->inventory_id))) {
                    $total_price += $inventory_code->amount;
                    $code_row->amount = $inventory_code->amount;
                    $code_row->fullness = $inventory_code->fullness;
                    $code_row->created_date = $inventory_code->created_date;
                    $code_row->qty = $inventory_code->qty;
                    $code_row->row_id = $inventory_code->id;
                    $code_row->lot_type = $inventory_code->lot_type;
                    $codes_arr[] = $code_row;
                } else {
                    $new_code_row = new stdClass();
                    $total_price += $inventory_code->amount;
                    $new_code_row->amount = $inventory_code->amount;
                    $new_code_row->fullness = $inventory_code->fullness;
                    $new_code_row->qty = $inventory_code->qty;
                    $new_code_row->code_price = $inventory_code->code_price;
                    $new_code_row->row_id = $inventory_code->id;
                    $new_code_row->code_name = $inventory_code->code_name;
                    $new_code_row->code_image = $inventory_code->code_image;
                    $new_code_row->created_date = $inventory_code->created_date;

                    // pr($new_code_row);
                    $codes_arr[] = $new_code_row;
                }
            }

            // $time = time();
            $data['new_type_values'] = $new_type_values;
            $data['codes_arr'] = $codes_arr;
            $data['inventory_detail'] = $this->data['inventory_detail'];
            $data['super_admin_settings'] = $this->master->getRow("siteadmin", array('site_id' => '1'));
            $data['sub_admin_row'] = $site_settings = $this->master->getRow("add_domains", array('site_id' => $this->session->web_id));
            // pr($data['codes_arr']);
            $html = $this->load->view('pages/inventory_pdf', $data, TRUE);
            // pr($html);
            try {
                $pdf = $this->generate_pdf($html, 'inventory_details-' . doEncode($id), false);

                // if ($pdf != 0) {
                $res['msg'] = "Your PDF download successfully";
                $res['status'] = 1;
                $res['pdf'] = base_url() . 'uploads/pdf/' . $pdf . '.pdf';
                // } else {
                //     $res['msg'] = "PDF generation failed";
                // }
            } catch (Exception $e) {
                $res['msg'] = "An error occurred: " . $e->getMessage();
            }
        } else {
            $res['msg'] = "Invalid ID";
        }
        exit(json_encode($res));
    }


public function delete_lot()
{
    $lot_id = $this->input->post('lot_id');
    if (empty($lot_id)) {
        echo json_encode([
            'status' => false,
            'message' => 'Invalid Lot ID'
        ]);
        return;
    }

    $this->db->trans_start();
    $this->master->delete('add_code_to_lot', 'lot_id', $lot_id);
    $this->master->delete('lot_name', 'id', $lot_id);
    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE) {
        echo json_encode([
            'status' => false,
            'message' => 'Failed to delete lot'
        ]);
    } else {
        echo json_encode([
            'status' => true,
            'message' => 'Lot deleted successfully'
        ]);
    }
}



    // function pdf_export($id)
    // {
    //     $res['status'] = 0;
    //     $id = doDecode($id);
    //     $id = intval($id);
    //     if (!empty($id) && $this->data['inventory_detail'] = $this->master->getRow('lot_name', array('id' => $id, 'mem_id' => $this->session->mem_id, 'site_id' => $this->session->web_id))) {
    //         $total_price = 0;
    //         $inventory_codes = $this->master->getRows('add_code_to_lot', array('mem_id' => $this->session->mem_id, 'site_id' => $this->session->web_id, 'lot_id' => $this->data['inventory_detail']->id), '', '', 'DESC');
    //         $codes_arr = array();
    //         foreach ($inventory_codes as $inventory_code) {
    //             if ($code_row = $this->master->getRow('code', array('id' => $inventory_code->inventory_id))) {
    //                 $total_price += $inventory_code->amount;
    //                 $code_row->amount = $inventory_code->amount;
    //                 $code_row->fullness = $inventory_code->fullness;
    //                 $code_row->created_date = $inventory_code->created_date;
    //                 $code_row->qty = $inventory_code->qty;
    //                 $code_row->row_id = $inventory_code->id;
    //                 $code_row->lot_type = $inventory_code->lot_type;
    //                 $codes_arr[] = $code_row;
    //             } else {
    //                 $new_code_row = new stdClass(); // Creating a new standard class object
    //                 $total_price += $inventory_code->amount;
    //                 $new_code_row->amount = $inventory_code->amount;
    //                 $new_code_row->fullness = $inventory_code->fullness;
    //                 $new_code_row->qty = $inventory_code->qty;
    //                 $new_code_row->code_price = $inventory_code->code_price;
    //                 $new_code_row->row_id = $inventory_code->id;
    //                 $new_code_row->code_name = $inventory_code->code_name;
    //                 $new_code_row->code_image = $inventory_code->code_image;
    //                 $new_code_row->created_date = $inventory_code->created_date;

    //                 // pr($new_code_row);
    //                 $codes_arr[] = $new_code_row;
    //             }
    //         }

    //         // $time = time();
    //         $data['codes_arr'] = $codes_arr;
    //         $data['inventory_detail'] = $this->data['inventory_detail'];
    //         $data['super_admin_settings'] = $this->master->getRow("siteadmin", array('site_id' => '1'));
    //         $data['sub_admin_row'] = $site_settings = $this->master->getRow("add_domains", array('site_id' => $this->session->web_id));
    //         // pr($data['codes_arr']);
    //         $html = $this->load->view('pages/inventory_pdf', $data, TRUE);
    //         // pr($html);
    //         try {
    //             $pdf = $this->dompdf_lib->generate_pdf($html, 'inventory_details-' . doEncode($id), false);

    //             // if ($pdf != 0) {
    //             $res['msg'] = "Your PDF download successfully";
    //             $res['status'] = 1;
    //             $res['pdf'] = base_url() . 'uploads/pdf/' . $pdf . '.pdf';
    //             // } else {
    //             //     $res['msg'] = "PDF generation failed";
    //             // }
    //         } catch (Exception $e) {
    //             $res['msg'] = "An error occurred: " . $e->getMessage();
    //         }
    //     } else {
    //         $res['msg'] = "Invalid ID";
    //     }
    //     exit(json_encode($res));
    // }


    function new_pdf_export($id)
    {

        $id = doDecode($id);
        $id = intval($id);
        if (!empty($id) && $this->data['inventory_detail'] = $this->master->getRow('lot_name', array('id' => $id, 'mem_id' => $this->session->mem_id, 'site_id' => $this->session->web_id))) {
            $total_price = 0;
            $inventory_codes = $this->master->getRows('add_code_to_lot', array('mem_id' => $this->session->mem_id, 'site_id' => $this->session->web_id, 'lot_id' => $this->data['inventory_detail']->id), '', '', 'DESC');
            $new_type_values = $this->master->getNewTypeFromInventoryDetails($this->data['inventory_detail']->id);

            $codes_arr = array();
            foreach ($inventory_codes as $inventory_code) {
                if ($code_row = $this->master->getRow('code', array('id' => $inventory_code->inventory_id))) {
                    $total_price += $inventory_code->amount;
                    $code_row->amount = $inventory_code->amount;
                    $code_row->fullness = $inventory_code->fullness;
                    $code_row->created_date = $inventory_code->created_date;
                    $code_row->qty = $inventory_code->qty;
                    $code_row->row_id = $inventory_code->id;
                    $code_row->lot_type = $inventory_code->lot_type;
                    $codes_arr[] = $code_row;
                } else {
                    $new_code_row = new stdClass(); // Creating a new standard class object
                    $total_price += $inventory_code->amount;
                    $new_code_row->amount = $inventory_code->amount;
                    $new_code_row->fullness = $inventory_code->fullness;
                    $new_code_row->qty = $inventory_code->qty;
                    $new_code_row->code_price = $inventory_code->code_price;
                    $new_code_row->row_id = $inventory_code->id;
                    $new_code_row->code_name = $inventory_code->code_name;
                    $new_code_row->code_image = $inventory_code->code_image;
                    $new_code_row->created_date = $inventory_code->created_date;

                    // pr($new_code_row);
                    $codes_arr[] = $new_code_row;
                }
            }

            // $time = time();
            $data['new_type_values'] = $new_type_values;
            $data['codes_arr'] = $codes_arr;
            $data['inventory_detail'] = $this->data['inventory_detail'];
            $data['super_admin_settings'] = $this->master->getRow("siteadmin", array('site_id' => '1'));
            $data['sub_admin_row'] = $site_settings = $this->master->getRow("add_domains", array('site_id' => $this->session->web_id));
            // pr($data['codes_arr']);
            $html = $this->load->view('pages/inventory_pdf', $data, TRUE);
            // pr($html);
            // $pdf = $this->dompdf_lib->generate_pdf($html, 'inventory_details-' . doEncode($id), false);
            $pdf = $this->generate_pdf($html, 'inventory_details-' . doEncode($id), false);
        } else {
            show_404();
        }
    }



    public function get_lot_name_options_ajax()
    {
        $contition = array(
            'mem_id' => $this->session->mem_id,
            'site_id' => $this->session->web_id,
            'status' => 0
        );

        $rows = $this->master->getRows("lot_name", $contition, '', '', 'desc', 'last_updated_date');

        $options = [];
        foreach ($rows as $row) {
            $options[] = [
                'id' => $row->id,
                'lot_name' => $row->lot_name,
            ];
        }

        echo json_encode($options);
    }

    // function test_email(){
    //     $data=array(
    //         'name'=>'Abida',
    //         'email'=>'abidaa.rehman@gmail.com',
    //         'code'=>12345
    //     );
    //     $email=$this->send_signup_code($data);
    //     pr($email);
    // }
    function get_states($country_id)
    {
        $output = '';
        $country_id = intval($country_id);

        if ($country_id > 0 && $states = $this->master->getRows('states', array('country_id' => $country_id), '', '', 'asc', 'name')) {
            $output .= '<option value="">Select State</option>';
            foreach ($states as $state) {
                $output .= '
						<option value="' . $state->id . '">' . ucfirst($state->name) . '</option>
				';
            }
        } else {
            $output .= '<option value="">No States found!</option>';
        }
        exit(json_encode($output));
    }
}
