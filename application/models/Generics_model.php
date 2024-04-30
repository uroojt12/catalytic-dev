<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Generics_model extends CRUD_model
{

    public function __construct()
    {
        parent::__construct();
        $this->table_name = "code";
        $this->field = "id";
    }


    function filter_generics($data, $limit = '', $start = '',$sort_order='')
    {
        $this->db->select("ser.*");
        $this->db->from("code ser");

        $this->db->where('ser.status', 1);

        $this->db->where('ser.type', 'Generics');

        if (!(empty($data['search_generics']))) {
            $this->db->group_start();

            $this->db->like('ser.code', $data['search_generics']);
            $this->db->or_like('ser.title', $data['search_generics']);

            // pr($this->db->last_query());

            // return $this->db->get($this->table_name)->result();

            $this->db->group_end();
        }
        if (!empty($sort_order)) {
            // Add sorting based on $sort_order (1 for Ascending, 2 for Descending)
            if (intval($sort_order) == 1) {
                $this->db->order_by('ser.id', 'ASC');
            } elseif (intval($sort_order) == 2) {
                $this->db->order_by('ser.id', 'DESC');
            }
        }





        $this->db->group_by('ser.id');
        if (!empty($limit)) {
            $this->db->limit($limit, $start);
        }
        return $this->db->get()->result();
    }
}
