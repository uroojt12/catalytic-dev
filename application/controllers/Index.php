<?php

class Index extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        // $this->load->model('member_model');
        $this->load->model('testimonial_model');
        $this->load->model('pages_model', 'page');
        // pr($this->session->web_id);
    }

    function index()
    {
        $this->data['content_row'] = $this->master->getRow('sitecontent', array('ckey' => 'home', 'site_id' => $this->session->web_id));
        if ($this->data['content_row'] && $this->data['content_row']->code !== null) {
            $this->data['site_content'] = unserialize($this->data['content_row']->code);
        } else {
            $this->data['site_content'] = array();
        }
        $this->data['top_code'] = $this->master->getRows('code', array('status' => 1, 'type' => 'Code'), 0, 12, 'asc', '');
        $sub_admin_row=$site_settings=$this->master->getRow("add_domains", array('site_id' => $this->session->web_id));
        $price_pump=!empty($sub_admin_row->price_pump) ? $sub_admin_row->price_pump :  2;
        $site_settings=$this->master->getRow("siteadmin", array('site_id' => '1'));
        foreach($this->data['top_code'] as $row){
            $cal_price = calculatedPrice($site_settings->site_o_pt_price, $site_settings->site_live_pt_price, $site_settings->site_o_pd_price, $site_settings->site_live_pd_price, $site_settings->site_o_rh_price, $site_settings->site_live_rh_price, $row->o_price, $row->pt_price, $row->pd_price, $row->rh_price);
            $cal_price=$cal_price+(($cal_price*$price_pump)/100);
            $row->total_price=$cal_price;
        }
        // pr($this->data['top_code']);
        $this->data['testimonials'] = $this->testimonial_model->get_rows(array('status' => 1, 'site_id' => $this->session->web_id), '', '', 'desc');
        // pr($this->data['testimonials']);
        $this->data['pageView'] = 'pages/index';

        $this->data['footer'] = true;
        $this->load->view("includes/site-master", $this->data);
    }
}
