<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Code_model extends CRUD_model
{

    public function __construct()
    {
        parent::__construct();
        $this->table_name = "code";
        $this->field = "id";
    }


    function filter_code($data, $limit = '', $start = '', $sort_order = '')
    {
        $this->db->select("ser.*");
        $this->db->from("code ser");
        $this->db->where('ser.status', 1);
        $this->db->where('ser.type', 'Code');



        if (!(empty($data['search_code']))) {
            $this->db->group_start();
            $this->db->like('ser.code', $data['search_code']);
            $this->db->or_like('ser.title', $data['search_code']);
            $this->db->group_end();
        }


        if (!empty($sort_order)) {
            // Add sorting based on $sort_order (1 for Ascending, 2 for Descending)
            if ($sort_order == 1) {
                $this->db->order_by('ser.id', 'ASC');
            } elseif ($sort_order == 2) {
                $this->db->order_by('ser.id', 'DESC');
            }
        }


        $this->db->group_by('ser.id');

        if (!empty($limit)) {
            $this->db->limit($limit, $start);
        }

        return $this->db->get()->result();
    }

    function get_code_rows($where = '', $start = '', $offset = '', $order_by = '', $field = '', $wherein = '', $infield= '')
    {
        $field = $field == '' ? $this->field : $field;
        if (!empty($where))
            $this->db->where($where);

        if (!empty($order_by))
            $this->db->order_by($field, $order_by);
        if (!empty($offset))
            $this->db->limit($offset, $start);
        if (!empty($wherein))
            $this->db->where_in($infield, $wherein);
        $query = $this->db->get($this->table_name);
        return $query->result();
    }

}
