<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Text_model extends CI_Model
{

    private $table_name = "site_texts";
    public function __construct()
    {
        $this->load->database();
    }

    function getText($txt_id)
    {
        $this->db->where('txt_id', $txt_id);
        $query = $this->db->get($this->table_name);
        return $query->row();
    }

    function getTextValue($txt_key)
    {
        $this->db->select('txt_value');
        $this->db->where('txt_key', $txt_key);
        $query = $this->db->get($this->table_name);
        return $query->row()->txt_value;
    }

    function getTexts($txt_type = '', $where = '', $start = '', $offset = '')
    {
        if (!empty($txt_type)) {
            $this->db->where('txt_type', $txt_type);
        }
        if (!empty($where)) {
            $this->db->where($where);
        }
        if (!empty($offset)) {
            $this->db->limit($offset, $start);
        }
        $query = $this->db->get($this->table_name);
        return $query->result();
    }

    function changeStatus($txt_id)
    {
        $this->db->where('txt_id', $txt_id);
        $query = $this->db->get($this->table_name);
        $rs = $query->row();

        if ($rs->txt_status == '0') {
            $vals['txt_status'] = '1';
        } else {
            $vals['txt_status'] = '0';
        }
        $this->db->set($vals);
        $this->db->where('txt_id', $txt_id);
        $this->db->update($this->table_name);
        return $vals['txt_status'];
    }

    function save($vals, $txt_id = '')
    {
        $this->db->set($vals);
        if ($txt_id != '') {
            $this->db->where('txt_id', $txt_id);
            $this->db->update($this->table_name);
        } else {
            $this->db->insert($this->table_name);
        }
    }

    function delete($txt_id)
    {
        $this->db->where('txt_id', $txt_id);
        $this->db->delete($this->table_name);
    }

}

?>