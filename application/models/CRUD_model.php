<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class CRUD_model extends CI_Model
{
    protected $table_name = null;
    protected $field = null;
    
    function __construct()
    {
        $this->load->database();
    }

    function get_row($value, $field = '')
    {
        $field = $field == '' ? $this->field : $field;
        $this->db->where($field, $value);
        $query = $this->db->get($this->table_name);
        return $query->row();
    }
    
    function get_row_where($where)
    {
        $this->db->where($where);
        $query = $this->db->get($this->table_name);
        return $query->row();
    }
    
    function get_rows($where = '', $start = '', $offset = '', $order_by = '', $field = '')
    {
        
        $field = $field == '' ? $this->field : $field;
        if (!empty($where))
            $this->db->where($where);

        if (!empty($order_by))
            $this->db->order_by($field, $order_by);
        if (!empty($offset))
            $this->db->limit($offset, $start);

        $query = $this->db->get($this->table_name);
        return $query->result();
    }

    function get_last_row($value, $field = '')
    {
        $field = $field == '' ? $this->field : $field;
        $this->db->where($field, $value);
        $this->db->order_by('id', 'desc');
        $this->db->limit(1, 0);
        return $this->db->get($this->table_name)->row();
    }

    function is_exist($where, $value = 0, $field = '')
    {
        $field = $field == '' ? $this->field : $field;
        $this->db->where($where);
        $this->db->where($field.' <>', $value);
        return $this->db->get($this->table_name)->row();
    }

    function get_last_row_where($where)
    {
        $this->db->where($where);
        $this->db->order_by('id', 'desc');
        $this->db->limit(1, 0);
        return $this->db->get($this->table_name)->row();
    }
    
    function delete($value, $field = '')
    {
        $field = $field == '' ? $this->field : $field;
        $this->db->where($field, $value);
        $this->db->delete($this->table_name);
    }
    
    function delete_in($value, $field = '')
    {
        $field = $field == '' ? $this->field : $field;
        $this->db->where_in($field, $value);
        $this->db->delete($this->table_name);
    }

    function delete_where($where)
    {
        $this->db->where($where);
        $this->db->delete($this->table_name);
    }
    
    function save($vals, $value = '', $field = '')
    {
        $field = $field == '' ? $this->field : $field;
        $this->db->set($vals);
        if ($value != '') {
            $this->db->where($field, $value);
            $this->db->update($this->table_name);
            return $value;
        } else {
            $this->db->insert($this->table_name);
            return $this->db->insert_id();
        }
    }
    
    function update($vals, $where)
    {
        if (!empty($where)) {
            $this->db->set($vals);
            $this->db->where($where);
            $this->db->update($this->table_name);
            return true;
        }
        return false;
    }
    
    function query($query)
    {
        if (!empty($query))
            $this->db->query($query);
    }
    
    function fetch_row($query, $array = false)
    {
        $query = $this->db->query($query);
        if ($array)
            return $query->row_array();
        else
            return $query->row();
    }
    
    function fetch_rows($query, $array = false)
    {
        $query = $this->db->query($query);
        if ($array)
            return $query->result_array();
        else
            return $query->result();
    }
    
    function num_rows($where = '')
    {
        if (!empty($where))
            $this->db->where($where);
        $query = $this->db->get($this->table_name);
        return intval($query->num_rows());
    }

    function count_rows($value = '',$field = '')
    {
        $field = $field == '' ? $this->field : $field;
        $this->db->select("count($field) as total");
        if (!empty($value))
            $this->db->where($field, $value);
        /*
        $this->db->get($this->table_name)->row();
        print_query();
        */
        return intval($this->db->get($this->table_name)->row()->total);
    }

    function count_rows_where($where = '')
    {
        $this->db->select("count(*) as total");
        if (!empty($where))
            $this->db->where($where);
        return intval($this->db->get($this->table_name)->row()->total);
    }
}
?>