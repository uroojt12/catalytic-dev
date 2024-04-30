<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Colors extends SUBADMIN_Controller
{
    public $data;
    public function __construct()
    {
        parent::__construct();
        $this->isLogged();
        $this->load->model('subadmin_model');
        $this->subadmin = $this->getActiveSubAdmin();
    }
    function index()
    {

        $this->data['page_title'] = 'Site Colors';
        $this->data['pageView'] = SUBADMIN . "/colors";
        $this->data['row'] = $this->master->getRow('colors', array('site_id' => $this->subadmin->site_id));
        $this->load->view(SUBADMIN . "/includes/siteMaster", $this->data);
    }
    function save()
    {
        if ($vals = $this->input->post()) {

            $vals['site_id'] = $this->subadmin->site_id;
            $id = $this->master->save("colors", $vals, 'site_id', $this->subadmin->site_id);
            // pr($id);
            setMsg("success", "Site Colors have been updated successfully");
            redirect(SUBADMIN . "/colors");
        }
    }
}
