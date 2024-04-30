<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Add_domains_model extends CRUD_model
{

    public function __construct()
    {
        parent::__construct();
        $this->table_name = "add_domains";
        $this->field = "site_id";
    }
}
