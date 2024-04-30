<?php

class Dashboard extends SUBADMIN_Controller {

    public function __construct() {
        parent::__construct();
        $this->isLogged();
    }
    
    public function index() {
        $this->data['pageView'] = SUBADMIN."/dashboard";
        $this->data['dashboard'] = "1";
        // $this->data['total_providers']=intval($this->master->num_rows('providers'));
        // $this->data['total_services']=intval($this->master->num_rows('services'));

        //$this->data['total_members']=intval($this->master->num_rows('members'));
        $this->load->view(SUBADMIN.'/includes/siteMaster', $this->data);
    }
    
}

?>  