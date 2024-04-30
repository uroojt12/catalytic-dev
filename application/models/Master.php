<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master extends CI_Model{
    public function __construct(){
        $this->load->database();
    }

    function get_data($table_name,$where=""){
		if(!empty($where)){
			$this->db->where($where);
			return $this->db->get($table_name)->row();
		}else{
			return $this->db->get($table_name)->result();
		}
	}

	function get_data_rows($table_name, $where='',$order='',$order_colum='id'){
		if(!empty($where)){
			$this->db->where($where);
		}
        if(!empty($order)){
			$this->db->order_by($order_colum,$order);
		}
		return $this->db->get($table_name)->result();
	}

	function get_data_row($table_name,$where=""){
		// pr($where);
		if(!empty($where)){
			$this->db->where($where);
			return $this->db->get($table_name)->row();
		}else{
			return $this->db->get($table_name)->row();
		}
	}

	function get_data_query($query){
		return $this->db->query($query)->result();
	}

	function insert_data($table_name,$vals,$field="",$id=""){
		$this->db->set($vals);
		// pr($where);
		if(!empty($id)){
			$this->db->where($field,$id);
			$this->db->update($table_name);
			return $id;
		}else{
			$this->db->insert($table_name);
			return $this->db->insert_id();
		}
	}

	function delete_row($table_name,$where){
		$this->db->where($where);
		$this->db->delete($table_name);
		// echo $this->db->last_query();
		return $where;

	}

	function delete_all_row($table_name){
		$query = "delete from ".$table_name;
		return $this->db->query($query);
	}

	

    public function getRow($table, $where = '', $array = false, $order_by = ''){

        if (!empty($where))
            $this->db->where($where);
             $query = $this->db->get($table);

            if ($array):
                if (!empty($order_by)):
                    $this->db->order_by("id", $order_by);
                endif;
                return (array) $query->row();

            else:
                if (!empty($order_by)):
                    $this->db->order_by("id", $order_by);
                endif;
                return $query->row();
            endif;     
    }

    public function getRows($table, $where = '', $start = '', $offset = '', $order_by = '', $field = 'id', $group_by = ''){
        if (!empty($where))
            $this->db->where($where);

        if (!empty($offset)):
            $this->db->limit($offset, $start);
        endif;

        if (!empty($order_by)):
            $this->db->order_by($field, $order_by);
        endif;

        if (!empty($group_by))
            $this->db->group_by($group_by);

        $query = $this->db->get($table);
        // die($this->db->last_query())
        return $query->result();

    }

    public function getRowsArray($table, $where = '', $offset = '', $start = ''){
        if (!empty($where))
            $this->db->where($where);

        if (!empty($offset))
            $this->db->limit($offset, $start);

        $query = $this->db->get($table);
        return $query->result_array();
    }



    public function save($table, $vals, $field = '', $id = ''){
        $this->db->set($vals);
        if (!empty($id)) {
            $this->db->where($field, $id);
            $this->db->update($table);
            return $id;
        } else {
            $query = $this->db->insert($table);
            return $this->db->insert_id();
        }
    } 



    public function update($table, $vals, $where){
        if (!empty($where)) {
            $this->db->set($vals);
            $this->db->where($where);
            $this->db->update($table);
            return true;
        }
        return false;
    }

    public function update__($table, $vals, $where){
        if (!empty($where)) {
            $this->db->set($vals);
            $this->db->where($where);
            $this->db->update($table);
            return true;
        }
        return false;
    }

    public function delete($table, $field = '', $where = ''){
        if (!empty($where)) {
            $this->db->where_in($field, $where);
        }
        $this->db->delete($table);
    }

    function delete_where($table, $where){
        if (!empty($where)) {
            $this->db->where($where);
            $this->db->delete($table);
            return 1;
        }
    }

    public function num_rows($table, $where = ''){
        if (!empty($where))
            $this->db->where($where);

        $query = $this->db->get($table);
        return $query->num_rows();
    }

    public function last_query(){
        return $this->db->last_query();
    }

    public function last_row($table, $where = ''){
        if (!empty($where)) {
            $this->db->where($where);
        }

        $this->db->order_by('id', "desc");
        $this->db->limit(1);
        $query = $this->db->get($table);

        return $query->row();
    }

    function query($query){
        if (!empty($query))
            return $this->db->query($query);
    }

    public function fetch_row($query, $array = false){
        $query = $this->db->query($query);
        if ($array)
            return $query->row_array();
        else
            return $query->row();
    }

    public function fetch_rows($query, $array = false){
        $query = $this->db->query($query);
        if ($array)
            return $query->result_array();
        else
            return $query->result();
    }
}

?>

