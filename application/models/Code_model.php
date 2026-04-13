<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Code_model extends CRUD_model
{
    protected $table_name;
    protected $field;
    protected $column_order;
    protected $column_search;
    protected $order;

    public function __construct()
    {
        parent::__construct();
        $this->table_name = "code";
        $this->field = "id";

        // Set orderable column fields
        $this->column_order = array('c.id');
        // Set searchable column fields
        $this->column_search = array('c.title', 'c.code', 'cat.name');
        // Set default order
        $this->order = array('c.id' => 'asc');
    }


    public function getdatatableRows($postData)
    {
        $this->_get_datatables_query($postData);
        if ($postData['length'] != -1) {
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }


    private function _get_datatables_query($postData)
    {

        $this->db->from($this->table_name . ' c');
        $this->db->join('categories cat', 'c.cat_id=cat.id');
        $this->db->select('c.*');

        $i = 0;
        // loop searchable columns 
        if (strtolower(trim($postData['search']['value'])) === 'inactive') {
            $this->db->group_start();
            $this->db->where('c.status', 0);
            $this->db->group_end();
        } else {

            foreach ($this->column_search as $item) {
                // if datatable send POST for search
                if ($postData['search']['value']) {
                    // first loop
                    if ($i === 0) {
                        // open bracket
                        $this->db->group_start();
                        $this->db->like($item, $postData['search']['value']);
                    } else {
                        $this->db->or_like($item, $postData['search']['value']);
                    }

                    // last loop
                    if (count($this->column_search) - 1 == $i) {
                        // close bracket
                        $this->db->group_end();
                    }
                }
                $i++;
            }
        }

        if (isset($postData['order'])) {
            $this->db->order_by($this->column_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function countAll()
    {
        $this->db->from($this->table_name);
        $this->db->where('type', 'Code');
        return $this->db->count_all_results();
    }

    public function countFiltered($postData)
    {
        $this->_get_datatables_query($postData);
        $query = $this->db->get();
        return $query->num_rows();
    }


    function filter_code($data, $limit = '', $start = '', $sort_order = '')
    {
        $this->db->select("ser.*, CONCAT(cat.name, ' ', ser.code) AS search_query");
        $this->db->from("code ser");
        $this->db->join("categories cat", "ser.cat_id = cat.id", "left"); // Joining categories table

        $this->db->where('ser.status', 1);
        $this->db->where('ser.type', 'Code');

        if (!(empty($data['search_code']))) {
            // if (strpos($data['search_code'], ":") !== false) {
            //     $search_code = explode(":", $data['search_code']);
            //     $this->db->group_start();
            //     $this->db->like('ser.code', trim($search_code[1]));
            //     $this->db->or_like('ser.title', trim($search_code[1]));
            //     $this->db->group_end();
            //     $this->db->like('cat.name', trim($search_code[0])); // Adjust column_name to the actual column name in categories table

            // } else {
            $this->db->group_start();
            // $this->db->like('ser.code', $data['search_code']);
            $this->db->where("CONCAT(cat.name, ' ', ser.code) LIKE '%" . str_replace(' ', '%', $data['search_code']) . "%'");
            $this->db->group_end();
            // }
        }

        if (!empty($data['select_brand']) && $data['select_brand'] != 'all_brands') {
            // pr($data['select_brand']);
            $this->db->group_start();
            $this->db->like('cat.name', $data['select_brand']);
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


    function get_code_rows($where = '', $start = '', $offset = '', $order_by = '', $field = '', $wherein = '', $infield = '')
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


    public function searchCodes($search_word)
    {
        $this->db->select("ser.*,cat.name as category_name, CONCAT(cat.name, ' ', ser.code) AS search_query");
        $this->db->from("code ser");
        $this->db->join("categories cat", "ser.cat_id = cat.id", "left");
        $this->db->where('ser.status', 1);
        $this->db->where('ser.type', 'Code');
        if (!(empty($search_word))) {
            $this->db->group_start();
            // $this->db->like('ser.code', $search_word);
            // $this->db->or_like('cat.name', $search_word); 
            $this->db->where("CONCAT(cat.name, ' ', ser.code) LIKE '%" . str_replace(' ', '%', $search_word) . "%'");
            $this->db->group_end();
        }
        return $this->db->get()->result();
    }
}
