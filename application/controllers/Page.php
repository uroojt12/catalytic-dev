<?php
class Page extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('page_model');
        $this->load->model('code_model');
        $this->load->model('generics_model');
        $this->load->library('pagination');
    }




    function code($page = '')
    {
        
      
    
        if ($this->session->mem_id) {
            $this->member = $this->getActiveMem();
            if ($this->member->mem_verified > 0) {

                if ($page == '') {
                    $page = 1;
                }

                $page = intval($page);
                $per_page = 4;

                $this->data['total_active_codes'] = $this->code_model->num_rows(array('status' => 1, 'type' => 'Code'));
                $this->data['content_row'] = $this->master->getRow('sitecontent', array('ckey' => 'code', 'site_id' => $this->session->web_id));
                $this->data['site_content'] = unserialize($this->data['content_row']->code);
                $this->data['find_code'] = $this->code_model->get_rows(array('status' => 1, 'type' => 'Code'), 0, 16);
                $site_settings = $this->master->getRow("siteadmin", array('site_id' => '1'));
                foreach ($this->data['find_code'] as $row) {
                    $pump_cal_price = calculatedAllPrice($site_settings->site_o_pt_price, $site_settings->site_live_pt_price, $site_settings->site_o_pd_price, $site_settings->site_live_pd_price, $site_settings->site_o_rh_price, $site_settings->site_live_rh_price, $this->session->web_id, $row->id, $this->session->mem_id);
                    $row->total_price = $pump_cal_price;

                    // if (!empty($this->data['member_data']) && $this->data['member_data']->mem_margin > 0) {
                    //     $margin = $pump_cal_price * ($this->data['member_data']->mem_margin / 100);
                    //     $row->total_price = $pump_cal_price - $margin;
                    // } else {
                    //     $row->total_price = $pump_cal_price;
                    // }
                }

                $this->data['sub_site_settings'] = $this->master->getRow("add_domains", array('site_id' => $this->session->web_id));
                $this->data['sup_site_settings'] = $this->master->getRow("siteadmin", array('site_id' => '1'));
            
                $this->data['all_categories'] = $this->master->getRows("categories", array('status' => 1));



///// 22 july ///////
$metals = [
    'site_live_pt_price' => 'pt',
    'site_live_pd_price' => 'pd',
    'site_live_rh_price' => 'rh',
];

foreach ($metals as $metal_key => $short) {
    $this->db->select('price');
    $this->db->from('tbl_metal_price_history');
    $this->db->where('metal_key', $metal_key);
    $this->db->order_by('id', 'DESC');
    $this->db->limit(2);
    $query = $this->db->get();
    $prices = $query->result();

    $latest = isset($prices[0]->price) ? $prices[0]->price : 0;
    $previous = isset($prices[1]->price) ? $prices[1]->price : 0;

    $diff = $latest - $previous;
    $percent_change = ($previous != 0) ? ($diff / $previous) * 100 : 0;

    $this->data["{$short}_price_percent"] = $percent_change;
}
////////////////

                $this->data['pageView'] = 'pages/code';
                $this->data['footer'] = true;
                $this->data['code_page'] = true;
                $this->load->view("includes/site-master", $this->data);
            } else {
                redirect('email-verification', 'refresh');
            }
        } else {
            redirect('login', 'refresh');
        }
    }
    public function get_codes($offset = 16)
    {
        $limit = 16; // Number of posts per page
        $vals = $this->input->post();
        $sort_order = $this->input->post('sort_order');
        $codes = $this->code_model->filter_code($vals, $limit, $offset, $sort_order);
        $query = $this->db->last_query();
        $sub_admin_row = $site_settings = $this->master->getRow("add_domains", array('site_id' => $this->session->web_id));
        // $price_pump = !empty($sub_admin_row->price_pump) ? $sub_admin_row->price_pump :  2;
        $site_settings = $this->master->getRow("siteadmin", array('site_id' => '1'));

        $html = '';
        if (!empty($codes)) {
            foreach ($codes as $code_p) {
                // $cal_price = calculatedPrice($site_settings->site_o_pt_price, $site_settings->site_live_pt_price, $site_settings->site_o_pd_price, $site_settings->site_live_pd_price, $site_settings->site_o_rh_price, $site_settings->site_live_rh_price, $code_p->o_price, $code_p->pt_price, $code_p->pd_price, $code_p->rh_price);
                // $cal_price = $cal_price + (($cal_price * $price_pump) / 100);

                $pump_cal_price = calculatedAllPrice($site_settings->site_o_pt_price, $site_settings->site_live_pt_price, $site_settings->site_o_pd_price, $site_settings->site_live_pd_price, $site_settings->site_o_rh_price, $site_settings->site_live_rh_price, $this->session->web_id, $code_p->id, $this->session->mem_id);
                // if (!empty($this->data['member_data']) && $this->data['member_data']->mem_margin > 0) {
                //     $margin = $pump_cal_price * ($this->data['member_data']->mem_margin / 100);
                //     $amount = $pump_cal_price - $margin;
                // } else {
                //     $amount = $pump_cal_price;
                // }
                $amount = $pump_cal_price;
                //     $html .= '<div class="cols">
                //     <div class="inner">
                //         <div class="bottom_content">
                //             <div class="image_2 popBtn" data-popup="code_image" data-image-url="' . get_site_code_image_src("code", $code_p->image, $sub_admin_row) . '">
                //             <img src="' . get_site_code_image_src("code", $code_p->image, $sub_admin_row) . '" alt="' . $this->data['site_settings']->site_name . '" alt="">
                //             </div>
                //             <div class="content">
                //                 <h5><a href="' . base_url('code-detail/' . doEncode($code_p->id)) . '">' . $code_p->title . '</a></h5>
                //                 <p>' . $code_p->code . '</p>

                //                 <div class="cta_price">
                //                     <h5><strong>' . format_amount($amount) . '</strong></h5>
                //                     <div class="cta">
                //                         <a href="javascript:void(0)" class="webBtn popBtn" data-lot_type="' . ($code_p->type) . '" data-inventory_id="' . ($code_p->id) . '" data-popup="add_code">Add</a>
                //                     </div>
                //                 </div>
                //             </div>
                //         </div>
                //     </div>
                // </div>';

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
                    $html .= '<div class="cta_price">
                                <h5><strong>' . format_amount($amount) . '</strong></h5><div class="cta">
                                                <a href="javascript:void(0)" class="webBtn popBtn" data-lot_type="' . ($code_p->type) . '" data-inventory_id="' . ($code_p->id) . '" data-popup="add_code" data-options="get_lot_names">Add</a>
                                              </div></div>';
                }

                $html .= '        
                        </div>
                    </div>
                </div>
            </div>';
            }
        } else {
            $html = '<div class="alert alert-danger">No code(s) found!</div>';
        }
        echo json_encode(array('offset' => $offset, 'html' => $html, 'query' => $query, 'vals' => $vals, 'total' => count($codes)));
    }
    public function get_generics($offset = 16)
    {
        $limit = 16; // Number of posts per page
        $vals = $this->input->post();
        $sort_order = $this->input->post('sort_order');
        $codes = $this->generics_model->filter_generics($vals, $limit, $offset, $sort_order);
        $query = $this->db->last_query();
        $sub_admin_row = $site_settings = $this->master->getRow("add_domains", array('site_id' => $this->session->web_id));
        // $price_pump = !empty($sub_admin_row->price_pump) ? $sub_admin_row->price_pump :  2;
        $site_settings = $this->master->getRow("siteadmin", array('site_id' => '1'));

        $html = '';
        if (!empty($codes)) {
            foreach ($codes as $code_p) {
                // $cal_price = calculatedPrice($site_settings->site_o_pt_price, $site_settings->site_live_pt_price, $site_settings->site_o_pd_price, $site_settings->site_live_pd_price, $site_settings->site_o_rh_price, $site_settings->site_live_rh_price, $code_p->o_price, $code_p->pt_price, $code_p->pd_price, $code_p->rh_price);
                // $cal_price = $cal_price + (($cal_price * $price_pump) / 100);
                $pump_cal_price = calculatedAllPrice($site_settings->site_o_pt_price, $site_settings->site_live_pt_price, $site_settings->site_o_pd_price, $site_settings->site_live_pd_price, $site_settings->site_o_rh_price, $site_settings->site_live_rh_price, $this->session->web_id, $code_p->id, $this->session->mem_id);
                // if (!empty($this->data['member_data']) && $this->data['member_data']->mem_margin > 0) {
                //     $margin = $pump_cal_price * ($this->data['member_data']->mem_margin / 100);
                //     $amount = $pump_cal_price - $margin;
                // } else {
                //     $amount = $pump_cal_price;
                // }
                $amount = $pump_cal_price;
                //     $html .= '<div class="cols">
                //     <div class="inner">
                //         <div class="bottom_content">
                //             <div class="image_2 popBtn" data-popup="code_image" data-image-url="' . get_site_code_image_src("generics", $code_p->image, $sub_admin_row) . '">
                //                 <img src="' . get_site_code_image_src("generics", $code_p->image, $sub_admin_row) . '" alt="' . $this->data['site_settings']->site_name . '" alt="">
                //             </div>
                //             <div class="content">
                //                 <h5><a href="' . base_url('code-detail/' . doEncode($code_p->id)) . '">' . $code_p->title . '</a></h5>
                //                 <p>' . $code_p->code . '</p>

                //                 <div class="cta_price">
                //                     <h5><strong>' . format_amount($amount) . '</strong></h5>
                //                     <div class="cta">
                //                         <a href="javascript:void(0)" class="webBtn popBtn" data-lot_type="' . ($code_p->type) . '" data-inventory_id="' . ($code_p->id) . '" data-popup="add_code">Add</a>
                //                     </div>
                //                 </div>
                //             </div>
                //         </div>
                //     </div>
                // </div>';

                $html .= '<div class="cols">
                <div class="inner">
                    <div class="bottom_content">
                        <div class="image_2 popBtn" data-generic-name="' . $code_p->code . '" data-popup="generic_image" data-image-url="' . get_site_code_image_src("generics", $code_p->image, $sub_admin_row) . '">
                            <img src="' . get_site_code_image_src("generics", $code_p->image, $sub_admin_row) . '" alt="' . $this->data['site_settings']->site_name . '" alt="">
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
                                              </div> </div>';
                }

                $html .= '       
                        </div>
                    </div>
                </div>
            </div>';
            }
        } else {
            $html = '<div class="alert alert-danger">No generic found!</div>';
        }
        echo json_encode(array('offset' => $offset, 'html' => $html, 'query' => $query, 'vals' => $vals, 'total' => count($codes)));
    }
    function code_detail($id)
    {
        if ($this->session->mem_id) {
            // $id = urldecode($id);
            $id = doDecode($id);
            $id = intval($id);

            if (!empty($id) && $this->data['code_detail'] = $this->code_model->get_row_where(array("status" => 1, 'type' => 'Code', 'id' => $id))) {
                // pr($this->data['code_detail']);
                $this->data['content_row'] = $this->master->getRow('sitecontent', array('ckey' => 'code_detail', 'site_id' => $this->session->web_id));
                $this->data['site_content'] = unserialize($this->data['content_row']->code);

                $this->data['pageView'] = 'pages/code_detail';
                $this->data['footer'] = true;
                $this->load->view("includes/site-master", $this->data);
            } else {
                show_404();
            }
        } else {
            redirect('login');
        }
    }


    function inventory()
    {
        if ($this->session->mem_id) {

            $this->member = $this->getActiveMem();
            $q =   $this->isMemLogged($this->session->mem_type);

            $this->data['content_row'] = $this->master->getRow('sitecontent', array('ckey' => 'inventory', 'site_id' => $this->session->web_id));
            $this->data['site_content'] = unserialize($this->data['content_row']->code);

            // $this->data['inventory'] = $this->master->getRows('lot_name', array('mem_id' => $this->member->mem_id, 'site_id' => $this->session->web_id, 'status' => 0), '', '', 'desc', 'created_date');
            // $this->data['closed_inventory'] = $this->master->getRows('lot_name', array('mem_id' => $this->member->mem_id, 'site_id' => $this->session->web_id, 'status' => 1), '', '', 'desc', 'created_date');

            $this->data['inventory'] = $this->master->getRows('lot_name', array('mem_id' => $this->member->mem_id, 'site_id' => $this->session->web_id, 'status' => 0), '', '', 'desc', 'last_updated_date');
            $this->data['closed_inventory'] = $this->master->getRows('lot_name', array('mem_id' => $this->member->mem_id, 'site_id' => $this->session->web_id, 'status' => 1), '', '', 'desc', 'last_updated_date');


            $this->data['pageView'] = 'pages/inventory';
            $this->data['footer'] = true;
            $this->load->view("includes/site-master", $this->data);
        } else {
            redirect('login');
        }
    }

    function inventory_detail($id)
    {
        if ($this->session->mem_id) {
            // $id = urldecode($id);
            $id = doDecode($id);
            $id = intval($id);
            if (!empty($id) && $this->data['inventory_detail'] = $this->master->getRow('lot_name', array('id' => $id, 'mem_id' => $this->session->mem_id, 'site_id' => $this->session->web_id))) {
                $total_price = 0;
                $inventory_codes = $this->master->getRows('add_code_to_lot', array('mem_id' => $this->session->mem_id, 'site_id' => $this->session->web_id, 'lot_id' => $this->data['inventory_detail']->id), '', '', 'DESC');
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
                    // pr($codes_arr);
                    // }
                }
                $this->data['codes_arr'] = $codes_arr;
                // pr($this->data['codes_arr']);
                $this->data['total_price'] = $total_price;
                $this->data['sub_admin_row'] = $this->master->getRow("add_domains", array('site_id' => $this->session->web_id));
                $this->data['admin_site_settings'] = $this->master->getRow("siteadmin", array('site_id' => '1'));

                $this->data['content_row'] = $this->master->getRow('sitecontent', array('ckey' => 'inventory_detail'));
                $this->data['site_content'] = unserialize($this->data['content_row']->code);

                $this->data['page_title'] = $this->data['inventory_detail']->lot_name;
                $this->data['meta_keywords'] = $this->data['inventory_detail']->lot_name;
                $this->data['meta_description'] = $this->data['inventory_detail']->lot_name;

                $this->data['categories'] = $this->master->getRows('categories', array('status' => 1));

                $this->data['pageView'] = 'pages/inventory_detail';
                $this->data['footer'] = true;
                $this->load->view("includes/site-master", $this->data);
            } else {
                show_404();
            }
        } else {
            redirect('login');
        }
    }




    function generics($page = '')
    {
        if ($this->session->mem_id) {

            if ($page == '') {
                $page = 1;
            }

            $page = intval($page);
            $per_page = 4;

            $this->data['total_active_generics'] = $this->generics_model->num_rows(array('status' => 1, 'type' => 'Generics'));
            // pr($this->data['total_active_generics']);

            $this->data['content_row'] = $this->master->getRow('sitecontent', array('ckey' => 'generic', 'site_id' => $this->session->web_id));
            $this->data['site_content'] = unserialize($this->data['content_row']->code);



            $this->data['generics'] = $this->generics_model->get_rows(array('status' => 1, 'type' => 'Generics'), 0, 16);
            // pr($this->data['generics']);
            $sub_admin_row = $site_settings = $this->master->getRow("add_domains", array('site_id' => $this->session->web_id));
            // $price_pump = !empty($sub_admin_row->price_pump) ? $sub_admin_row->price_pump :  2;
            $site_settings = $this->master->getRow("siteadmin", array('site_id' => '1'));
            foreach ($this->data['generics'] as $row) {
                // $cal_price = calculatedPrice($site_settings->site_o_pt_price, $site_settings->site_live_pt_price, $site_settings->site_o_pd_price, $site_settings->site_live_pd_price, $site_settings->site_o_rh_price, $site_settings->site_live_rh_price, $row->o_price, $row->pt_price, $row->pd_price, $row->rh_price);
                // $cal_price = $cal_price + (($cal_price * $price_pump) / 100);
                $pump_cal_price = calculatedAllPrice($site_settings->site_o_pt_price, $site_settings->site_live_pt_price, $site_settings->site_o_pd_price, $site_settings->site_live_pd_price, $site_settings->site_o_rh_price, $site_settings->site_live_rh_price, $this->session->web_id, $row->id, $this->session->mem_id);
                // if (!empty($this->data['member_data']) && $this->data['member_data']->mem_margin > 0) {
                //     $margin = $pump_cal_price * ($this->data['member_data']->mem_margin / 100);
                //     $row->total_price = $pump_cal_price - $margin;
                // } else {
                //     $row->total_price = $pump_cal_price;
                // }

                $row->total_price = $pump_cal_price;
            }
            $this->data['pageView'] = 'pages/generics';
            $this->data['footer'] = true;
            $this->data['generics_page'] = true;
            $this->load->view("includes/site-master", $this->data);
        } else {
            redirect('login');
        }
    }
    function generic_detail($id)
    {
        if ($this->session->mem_id) {
            // $id = urldecode($id);
            $id = doDecode($id);
            $id = intval($id);

            if (!empty($id) && $this->data['generic_detail'] = $this->generics_model->get_row_where(array("status" => 1, 'type' => 'Generics', 'id' => $id))) {
                // pr($this->data['generic_detail']);
                $this->data['content_row'] = $this->master->getRow('sitecontent', array('ckey' => 'generic_detail'));
                $this->data['site_content'] = unserialize($this->data['content_row']->code);

                $this->data['pageView'] = 'pages/generic_detail';
                $this->data['footer'] = true;
                $this->load->view("includes/site-master", $this->data);
            } else {
                show_404();
            }
        } else {
            redirect('login');
        }
    }

    function photo_grade()
    {
        if ($this->session->mem_id) {

            $this->data['content_row'] = $this->master->getRow('sitecontent', array('ckey' => 'photo_grade', 'site_id' => $this->session->web_id));
            $this->data['site_content'] = unserialize($this->data['content_row']->code);
            $this->data['pend_photo_grade'] = $this->master->getRows('add_photo_grade', array('status' => 'pending', 'site_id' => $this->session->web_id, 'mem_id' => $this->session->mem_id), '', '', 'asc', '');
            $this->data['comp_photo_grade'] = $this->master->getRows('add_photo_grade', array('status' => 'approved', 'site_id' => $this->session->web_id, 'mem_id' => $this->session->mem_id), '', '', 'asc', '');
            $this->data['rej_photo_grade'] = $this->master->getRows('add_photo_grade', array('status' => 'rejected', 'site_id' => $this->session->web_id, 'mem_id' => $this->session->mem_id), '', '', 'asc', '');
            $this->data['pageView'] = 'pages/photo_grade';
            $this->data['footer'] = true;
            $this->load->view("includes/site-master", $this->data);
        } else {
            redirect('login');
        }
    }
    function photo_detail($id)
    {
        if ($this->session->mem_id) {
            // $id = urldecode($id);
            $id = doDecode($id);
            $id = intval($id);

            if (!empty($id) && $this->data['photo_detail'] = $this->master->getRow('photo_grade', array('status' => 1, 'id' => $id))) {
                // pr($this->data['photo_detail']);
                $this->data['content_row'] = $this->master->getRow('sitecontent', array('ckey' => 'photo_detail'));
                $this->data['site_content'] = unserialize($this->data['content_row']->code);

                $this->data['pageView'] = 'pages/photo_detail';
                $this->data['footer'] = true;
                $this->load->view("includes/site-master", $this->data);
            } else {
                show_404();
            }
        } else {
            redirect('login');
        }
    }

    function photo_grade_view()
    {
        if ($this->session->mem_id) {
            $this->data['content_row'] = $this->master->getRow('sitecontent', array('ckey' => 'new_photo_grade', 'site_id' => $this->session->web_id));
            $this->data['site_content'] = unserialize($this->data['content_row']->code);
            $this->data['pageView'] = 'pages/new_photo';
            $this->data['footer'] = true;
            $this->load->view("includes/site-master", $this->data);
        } else {
            redirect('login');
        }
    }


    function login()
    {
        $this->MemLogged();
        $this->data['content_row'] = $this->master->getRow('sitecontent', array('ckey' => 'login', 'site_id' => $this->session->web_id));
        $this->data['site_content'] = unserialize($this->data['content_row']->code);
        $this->data['pageView'] = 'pages/login';
        $this->data['footer'] = true;
        $this->load->view("includes/site-master", $this->data);
    }

    function signup()
    {
        $this->MemLogged();
        $this->data['content_row'] = $this->master->getRow('sitecontent', array('ckey' => 'signup', 'site_id' => $this->session->web_id));
        $this->data['site_content'] = unserialize($this->data['content_row']->code);
        $this->data['pageView'] = 'pages/signup';
        $this->data['footer'] = true;
        $this->load->view("includes/site-master", $this->data);
    }

    function signout()
    {
        $this->session->unset_userdata('mem_id');
        // session_destroy();
        redirect('');
    }


    // function email_verification()
    // {

    //     // pr('asd');
    //     $this->is_email_logged($this->session->mem_type);
    //     if ($this->data['member_data']->verified == '1') {
    //         redirect('dashboard');
    //     }
    //     $this->data['pageView'] = 'pages/verify-email';
    //     $this->data['page'] = 'verify_email';
    //     $this->data['page_title'] = 'Email Verification';
    //     $this->data['meta_keywords'] = 'Email Verification';
    //     $this->data['meta_description'] = 'Email Verification';
    //     $this->load->view("pages/dashboard/verify-email", $this->data);
    // }


    // function verification($vcode = '')
    // {


    //     // pr('asd');
    //     $this->isMemLogged($this->session->mem_type);
    //     $row = $this->member->getMemCode($vcode);
    //     if ($row = $this->member->getMemCode($vcode)) {
    //         $this->member->save(array('verified' => 1, 'code' => ''), $row->id);
    //         setMsg('success', "Account has been verified!");
    //         redirect('dashboard', 'refresh');
    //         exit;
    //     } else {
    //         redirect('', 'refresh');
    //         exit;
    //     }
    // }


    function forgot_password()
    {

        $this->data['content_row'] = $this->master->getRow('sitecontent', array('ckey' => 'forgot_password', 'site_id' => $this->session->web_id));
        $this->data['site_content'] = unserialize($this->data['content_row']->code);
        $this->data['pageView'] = 'pages/forgot-password';
        $this->data['footer'] = true;
        $this->load->view("includes/site-master", $this->data);
    }
    function reset_password()
    {

        $this->data['content_row'] = $this->master->getRow('sitecontent', array('ckey' => 'change_password', 'site_id' => $this->session->web_id));
        $this->data['site_content'] = unserialize($this->data['content_row']->code);
        $this->data['pageView'] = 'pages/reset-password';
        $this->data['footer'] = true;
        $this->load->view("includes/site-master", $this->data);
    }


    function error()
    {
        $this->data['page_404'] = true;
        $this->data['pageView'] = 'pages/404';
        $this->data['page_title'] = '404';
        $this->data['meta_title'] = '404';
        $this->data['meta_keywords'] = '404';
        $this->data['meta_description'] = '404';
        $this->load->view("includes/site-master", $this->data);
    }
}
