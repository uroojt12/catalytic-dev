<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CRUD_model
{

    // private $table_name= "siteadmin";
    public function __construct()
    {
        // $this->load->database();
        parent::__construct();
        $this->table_name = "siteadmin";
        $this->field = "site_id";
    }

    function getAdmin($admin_id)
    {
        $query = $this->db->get($this->table_name);
        return $query->row();
    }
    
    function authenticate($username = '', $password = '')
    {
        if(!empty($username) && !empty($password)){
            $this->db->where('site_username', $username);
            $this->db->where('site_password', md5($password));

            $query = $this->db->get($this->table_name);
            $rs = $query->row();
            if($rs)
                $this->updateStats();
            return $rs;
        }
        return false;
    }

    function saveSettings($vals)
    {
        $this->db->set($vals);
        $this->db->where('site_id', '1');
        $this->db->update($this->table_name);
    }
    
    function updateStats()
    {
        $this->db->where('site_id', '1');
        $query = $this->db->get($this->table_name);
        $rs = $query->row();

        $this->session->set_userdata('last_login', array('ip' => $rs->site_ip, 'time_date' => $rs->site_lastlogindate));

        $vals['site_ip'] = $_SERVER["REMOTE_ADDR"];
        $vals['site_lastlogindate'] = date('Y-m-d h:i:s');

        $this->saveSettings($vals);
    }
}
?>