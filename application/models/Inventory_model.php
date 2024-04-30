<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Inventory_model extends CRUD_model
{

    public function __construct()
    {
        parent::__construct();
        $this->table_name = "inventory";
        $this->field = "id";
    }
}
