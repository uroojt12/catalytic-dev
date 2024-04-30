<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Photo_grade_model extends CRUD_model
{

    public function __construct()
    {
        parent::__construct();
        $this->table_name = "photo_grade";
        $this->field = "id";
    }
}
