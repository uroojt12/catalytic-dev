<?php

class Dashboard extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->isLogged();
        $this->load->library('Sendinblue', 'sendinblue');
    }

    public function index()
    {
        $this->data['pageView']  = ADMIN . "/dashboard";
        $this->data['dashboard'] = "1";
        // $this->data['members'] = $this->master->num_rows('members', array('mem_type' => 'member'));
        // $this->data['pro_members'] = $this->master->num_rows('members', array('mem_type' => 'professional'));
        // $this->data['services'] = $this->master->num_rows('services', array('status' => 1));
        $this->data['contact'] = $this->master->num_rows('contact', ['status' => '0']);
        // $this->data['subscriptions'] = $this->master->num_rows('subscribed_plans', ['status'=> '1']);
        // $this->data['blogs'] = $this->master->num_rows('blogs');
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }

}
