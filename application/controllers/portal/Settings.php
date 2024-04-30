<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Settings extends SUBADMIN_Controller
{
    public $data;
    public function __construct()
    {
        parent::__construct();
        $this->isLogged();
        $this->load->model('subadmin_model');
        // $this->load->model('LocationOperator_model', 'LocationOperator');
        $this->subadmin = $this->getActiveSubAdmin();
    }
    function index()
    {
        // pr($this->operator);
        // has_access();
        $this->data['page_title'] = 'Account Settings';
        $this->data['pageView'] = SUBADMIN . "/site_setting";
        $this->load->view(SUBADMIN . "/includes/siteMaster", $this->data);
    }
    function save()
    {
        if ($vals = $this->input->post()) {

            //Profile Image
            // if (isset($_FILES["p_image"]["name"]) && $_FILES["p_image"]["name"] != "") {
            //     $image1 = upload_file(UPLOADS . 'images/', 'p_image');
            //     $vals['p_image'] = $image1['file_name'];
            // } else {
            //     $vals['p_image'] = $this->subadmin->p_image;
            // }

            //Logo Image
            if (isset($_FILES["site_logo"]["name"]) && $_FILES["site_logo"]["name"] != "") {
                $image2 = upload_file(UPLOADS . 'images/', 'site_logo');
                $vals['site_logo'] = $image2['file_name'];
            } else {
                $vals['site_logo'] = $this->subadmin->site_logo;
            }

            //Fav Icon Image
            if (isset($_FILES["site_icon"]["name"]) && $_FILES["site_icon"]["name"] != "") {
                $image3 = upload_file(UPLOADS . 'images/', 'site_icon');
                $vals['site_icon'] = $image3['file_name'];
            } else {
                $vals['site_icon'] = $this->subadmin->site_icon;
            }

            //Thumb Image
            if (isset($_FILES["site_thumb"]["name"]) && $_FILES["site_thumb"]["name"] != "") {
                $image4 = upload_file(UPLOADS . 'images/', 'site_thumb');
                $vals['site_thumb'] = $image4['file_name'];
            } else {
                $vals['site_thumb'] = $this->subadmin->site_thumb;
            }

            $this->subadmin_model->save($vals, $this->subadmin->site_id);
            setMsg("success", "Settings have been updated successfully");
            redirect(SUBADMIN . "/settings");
        }
    }
    function change()
    {
        $this->data['page_title'] = 'Change Password';
        $this->data['adminsite_setting']->page_title = 'Change Password';
        $this->load->view(SUBADMIN . '/admin_change', $this->data);
    }
    function pass()
    {
        if ($data = $this->input->post()) {
            $row = $this->subadmin_model->authenticate($this->subadmin->email, $data['opwd']);
            // pr($row);
            // $row = $this->location->authenticate($this->input->post('username'), $this->input->post('password'));
            if ($row) {
                $this->master->save("add_domains", array('password' => md5($data['npwd'])), 'site_id', $this->session->subadmin_loged_in['site_id']);
                $res['login_status'] = "success";
                $res['redirect_url'] = site_url(SUBADMIN . '/dashboard');
            } else {
                $res['login_status'] = "invalid";
                $res['invalid_respnse'] = "Old Password Does not Match";
            }
            echo json_encode($res);
        }
    }
}
