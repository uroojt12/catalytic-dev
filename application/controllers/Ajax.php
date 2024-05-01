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
        // $this->isMemLogged($this->session->id);
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

    public function finish_lot_save($id)
    {
        $res = array();
        $res['status'] = 0;
        if ($this->input->post()) {
            $this->form_validation->set_rules('email', 'Email', 'required');
            $this->form_validation->set_rules('buisness_name', 'Buisness Name', 'required');
            $this->form_validation->set_rules('identification_file', 'File', 'required');

            if ($this->form_validation->run() === FALSE) {

                $res['msg'] = validation_errors();
            } else {
                $vals = html_escape($this->input->post());

                if (!empty($id) && $inventory_detail = $this->master->getRow('lot_name', array('id' => $id, 'mem_id' => $this->session->mem_id, 'site_id' => $this->session->web_id))) {
                    $inventory_codes = $this->master->getRows('add_code_to_lot', array('mem_id' => $this->session->mem_id, 'site_id' => $this->session->web_id, 'lot_id' => $inventory_detail->id));
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
                    $this->master->save("lot_name", $data, 'id', $inventory_detail->id);
                    $res['status'] = 1;
                    $res['msg'] = 'Submitted successfully!';
                    $res['redirect_url'] = base_url('inventory');
                } else {
                    $res['msg'] = 'Technical problem!';
                }
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

                    $inventory_codes = $this->master->getRows('add_code_to_lot', array('mem_id' => $this->session->mem_id, 'site_id' => $this->session->web_id, 'lot_id' => $inventory_code->lot_id));

                    $count_avg = count($inventory_codes);
                    $grand_total = 0;
                    $html_markup = '';

                    $sub_admin_row = $site_settings = $this->master->getRow("add_domains", array('site_id' => $this->session->web_id));
                    $admin_site_settings = $this->master->getRow("siteadmin", array('site_id' => '1'));
                    foreach ($inventory_codes as $inventory_code) {
                        if ($code_row = $this->master->getRow('code', array('id' => $inventory_code->inventory_id))) {
                            $price_pump = !empty($sub_admin_row->price_pump) ? $sub_admin_row->price_pump :  2;
                            $cal_price = calculatedPrice($admin_site_settings->site_o_pt_price, $admin_site_settings->site_live_pt_price, $admin_site_settings->site_o_pd_price, $admin_site_settings->site_live_pd_price, $admin_site_settings->site_o_rh_price, $admin_site_settings->site_live_rh_price, $code_row->o_price, $code_row->pt_price, $code_row->pd_price, $code_row->rh_price);
                            $cal_price = $cal_price + (($cal_price * $price_pump) / 100);
                            // $amount = $cal_price;
                            // pr($code_row);
                            $price = $cal_price * $inventory_code->qty;
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
                                        <li>
                                            <p><strong>Title</strong></p>
                                            <p>' . $code_row->title . '<br />' . $inventory_code->lot_type . '</p>
                                        </li>
                                        <li>
                                            <p><strong>Fullness</strong></p>
                                            <p>' . $inventory_code->fullness . '%</p>
                                        </li>
                                        <li>
                                            <p><strong>Price</strong></p>
                                            <p>' . format_amount(number_format($price, 2, '.', '')) . '</p>
                                        </li>
                                        <li>
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
                    $avg_price = $count_avg > 0 ? $grand_total / $count_avg : 0;
                    $res['html'] = $html_markup;
                    $res['grand_total'] = format_amount(number_format($grand_total, 2, '.', ''));
                    $res['average_price'] = format_amount(number_format($avg_price, 2, '.', ''));
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

                    $inventory_codes = $this->master->getRows('add_code_to_lot', array('mem_id' => $this->session->mem_id, 'site_id' => $this->session->web_id, 'lot_id' => $inventory_code->lot_id));

                    $count_avg = count($inventory_codes);
                    $grand_total = 0;
                    $html_markup = '';

                    $sub_admin_row = $site_settings = $this->master->getRow("add_domains", array('site_id' => $this->session->web_id));
                    $admin_site_settings = $this->master->getRow("siteadmin", array('site_id' => '1'));
                    foreach ($inventory_codes as $inventory_code) {
                        if ($code_row = $this->master->getRow('code', array('id' => $inventory_code->inventory_id))) {
                            $price_pump = !empty($sub_admin_row->price_pump) ? $sub_admin_row->price_pump :  2;
                            $cal_price = calculatedPrice($admin_site_settings->site_o_pt_price, $admin_site_settings->site_live_pt_price, $admin_site_settings->site_o_pd_price, $admin_site_settings->site_live_pd_price, $admin_site_settings->site_o_rh_price, $admin_site_settings->site_live_rh_price, $code_row->o_price, $code_row->pt_price, $code_row->pd_price, $code_row->rh_price);
                            $cal_price = $cal_price + (($cal_price * $price_pump) / 100);
                            // $amount = $cal_price;
                            // pr($code_row);
                            $price = $cal_price * $inventory_code->qty;
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
                                        <li>
                                            <p><strong>Title</strong></p>
                                            <p>' . $code_row->title . '<br />' . $inventory_code->lot_type . '</p>
                                        </li>
                                        <li>
                                            <p><strong>Fullness</strong></p>
                                            <p>' . $inventory_code->fullness . '%</p>
                                        </li>
                                        <li>
                                            <p><strong>Price</strong></p>
                                            <p>' . format_amount(number_format($price, 2, '.', '')) . '</p>
                                        </li>
                                        <li>
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
                    $avg_price = $count_avg > 0 ? $grand_total / $count_avg : 0;
                    $res['html'] = $html_markup;
                    $res['grand_total'] = format_amount(number_format($grand_total, 2, '.', ''));
                    $res['average_price'] = format_amount(number_format($avg_price, 2, '.', ''));
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
            $data = array(
                'mem_id' => $this->session->mem_id,
                'inventory_id' => $vals['inventory_id'],
                'lot_id' => $vals['lot_id'],
                'site_id' => $this->session->web_id,
                'fullness' => $vals['fullness'],
                'qty' => 1,
                'lot_type' => $vals['lot_type'],
                'created_date' => date('Y-m-d h:i:s'),
                'amount' => $total_price
            );

            $id = $this->master->save("add_code_to_lot", $data);

            if ($id > 0) {
                // Check lot_type for different messages and redirects
                if ($vals['lot_type'] === 'Code') {
                    $res['msg'] = "Code Added To Lot";
                    $res['redirect_url'] = base_url('code');
                    $res['status'] = 1;
                } elseif ($vals['lot_type'] === 'Generics') {
                    $res['msg'] = "Generic Added To Lot";
                    $res['redirect_url'] = base_url('generics');
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
                $cal_price = calculatedPrice($site_settings->site_o_pt_price, $site_settings->site_live_pt_price, $site_settings->site_o_pd_price, $site_settings->site_live_pd_price, $site_settings->site_o_rh_price, $site_settings->site_live_rh_price, $code_p->o_price, $code_p->pt_price, $code_p->pd_price, $code_p->rh_price);
                $cal_price = $cal_price + (($cal_price * $price_pump) / 100);
                $amount = $cal_price;
                $html .= '<div class="cols">
                <div class="inner">
                    
                    <div class="bottom_content">
                        <div class="image_2">
                        <img src="' . base_url('uploads/images/' . $this->data["site_settings"]->site_logo) . '" alt="' . $this->data['site_settings']->site_name . '" alt="">
                        </div>
                        <div class="content">
                            <h5><a href="' . base_url('code-detail/' . doEncode($code_p->id)) . '">' . $code_p->title . '</a></h5>
                            <p>' . $code_p->code . '</p>
                            
                            <div class="cta_price">
                                <h5><strong>' . format_amount(number_format($amount, 2, '.', '')) . '</strong></h5>
                                <div class="cta">
                                    <a href="javascript:void(0)" class="webBtn popBtn" data-lot_type="' . ($code_p->type) . '" data-inventory_id="' . ($code_p->id) . '" data-popup="add_code">Add</a>
                                </div>
                            </div>
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


        $per_page = 4;
        $total = $this->generics_model->num_rows(array('status' => 1));

        $page = intval($page);
        $start = ($page - 1) * $per_page;
        $sort_order = $this->input->post('sort_order');
        // Check if data is received from $vals
        if (!empty($this->input->get())) {
            $vals = $this->input->get();

            $this->data['find_generics'] = $this->generics_model->filter_generics($vals, $per_page, $start, $sort_order);
            // pr($this->data['find_generics']);
            $total = count($this->generics_model->filter_generics($vals));
            // pr($total);
        }
        // Check if data is received from $post
        elseif ($this->input->post()) {
            $post = html_escape($this->input->post());
            $this->data['find_generics'] = $this->generics_model->filter_generics($post, $per_page, $start, $sort_order);
            $query = $this->db->last_query();
            // pr($this->data['find_generics']);
            $total = count($this->generics_model->filter_generics($post));
        } else {
            $this->data['find_generics'] = $this->generics_model->get_rows(array('status' => 1), $per_page, $start);
        }

        $total_results = $total;
        $html = '';
        if (!empty($this->data['find_generics'])) {
            foreach ($this->data['find_generics'] as $generic) {
                $chk_price = chk_code_price($this->session->web_id, $generic->id);
                $amount = !empty($chk_price)  ? format_amount($chk_price->new_price) :  format_amount($generic->price);
                $html .= '
                <div class="cols">
                <div class="inner">
                    <div class="bottom_content">
                        <div class="image_2">
                        <img src="' . base_url('uploads/images/' . $this->data["site_settings"]->site_logo) . '" alt="' . $this->data['site_settings']->site_name . '" alt="">
                        </div>
                        <div class="content">
                            <h5><a href="' . base_url('generic-detail/' . doEncode($generic->id)) . '">' . $generic->title . '</a></h5>
                            <p>' . $generic->code . '</p>
                            <div class="cta_price">
                                <h5><strong>' . $amount . '</strong></h5>
                                <div class="cta">
                                    <a href="javascript:void(0)" class="webBtn popBtn" data-lot_type="' . ($generic->type) . '" data-inventory_id="' . ($generic->id) . '" data-popup="add_code">Add</a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                ';
            }
        } else {
            $html = '<div class="alert alert-danger">No Generics Available!!!</div>';
        }
        // pr($this->data['links']);
        echo json_encode([
            'vals_get' => $vals,
            'post' => $post,
            'status' => true,
            'html' => $html,
            'query' => $query,
            'sort_order' => $sort_order,
            'total_results' => $total_results,
            'links' => $links
        ]);
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

                $this->send_photo_grade_status_email($photo_data);

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
