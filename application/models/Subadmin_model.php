<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Subadmin_model extends CRUD_model
{

    // private $table_name= "siteadmin";
    public function __construct()
    {
        // $this->load->database();
        parent::__construct();
        $this->table_name = "add_domains";
        $this->field = "site_id";
    }

    function getSubAdmin($subadmin_id)
    {
        $query = $this->db->get($this->table_name);
        return $query->row();
    }

    function authenticate($username = '', $password = '')
    {
        if (!empty($username) && !empty($password)) {
            $this->db->where('email', $username);
            $this->db->where('password', md5($password));

            $query = $this->db->get($this->table_name);
            $rs = $query->row();
            // print_r($rs);
            // if($rs)
            //     $this->updateStats();
            return $rs;
        }
        return false;
    }

    // function saveSettings($vals)
    // {
    //     $this->db->set($vals);
    //     $this->db->where('site_id', '1');
    //     $this->db->update($this->table_name);
    // }

    // function updateStats()
    // {
    //     $this->db->where('site_id', '1');
    //     $query = $this->db->get($this->table_name);
    //     $rs = $query->row();

    //     $this->session->set_userdata('last_login', array('ip' => $rs->site_ip, 'time_date' => $rs->site_lastlogindate));

    //     $vals['site_ip'] = $_SERVER["REMOTE_ADDR"];
    //     $vals['site_lastlogindate'] = date('Y-m-d h:i:s');

    //     $this->saveSettings($vals);
    // }
}
