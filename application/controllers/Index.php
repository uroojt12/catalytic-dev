<?php

class Index extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        // $this->load->model('member_model');
        // $this->load->model('testimonial_model');
        // $this->load->model('pages_model', 'page');

        $this->load->model('page_model');
        $this->load->model('code_model');
        $this->load->model('generics_model');
        $this->load->library('pagination');
        // pr($this->session->web_id);
    }

    function index($page = '')
    {



      
        if ($this->session->mem_id) {


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

                // pr('hi');
                $row->total_price = $pump_cal_price;
                // pr($pump_cal_price);
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
            redirect('login');
        }
    }
}
