<?php
class Pages_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		// $this->table_name="sitecontent";
	}

	function savePageContent($vals, $page_slug = "")
	{
		$this->db->set($vals);
		if ($page_slug != "") {
			//die("here");
			$this->db->where("ckey", $page_slug);
			$this->db->update("sitecontent");
			return $page_slug;
		} else {
			$this->db->insert("sitecontent");
			return $this->db->insert_id();
		}
	}

	function saveMetaContent($vals, $page_slug = "")
	{
		$this->db->set($vals);
		if ($page_slug != "") {
			//die("here");
			$this->db->where("slug", $page_slug);
			$this->db->update('meta_info');
			return $page_slug;
		} else {
			$this->db->insert('meta_info');
			return $this->db->insert_id();
		}
	}

	function getPageContent($page_slug = "")
	{
		if ($page_slug != "") {
			$this->db->where("ckey", $page_slug);
			return $this->db->get("sitecontent")->row();
		} else {
			return $this->db->get("sitecontent")->result();
		}
	}

	function getMetaContent($page_slug = "")
	{
		if ($page_slug != "") {
			$this->db->where("slug", $page_slug);
			return $this->db->get('meta_info')->row();
		} else {
			return $this->db->get('meta_info')->result();
		}
	}

	function deletePage($page_slug = "")
	{
		$this->db->where("ckey", $page_slug);
		$this->db->delete("sitecontent");
		return $page_slug;
	}

	function getBlogsByCat($cat_id, $start, $offset)
	{
		$this->db->select('b.*, bc.category_id');
		$this->db->from('blogs b');
		$this->db->join('selected_blog_categories bc', 'b.id=bc.blog_id');
		$this->db->where(['bc.category_id' => $cat_id, 'b.status' => 1]);
		$this->db->limit($offset, $start);
		$this->db->order_by('b.id', 'DESC');
		return $this->db->get()->result();
	}
	function getBlogsByCatTotal($cat_id)
	{
		$this->db->select('b.*');
		$this->db->from('blogs b');
		$this->db->join('selected_blog_categories bc', 'b.id=bc.blog_id');
		$this->db->where(['bc.category_id' => $cat_id, 'b.status' => 1]);
		return $this->db->get()->num_rows();
	}

	function getPreviosNextRecord($table, $id, $type)
	{
		$this->db->from($table);
		$this->db->select('*');
		$this->db->where(['status' => 1]);
		if ($type == 'next') {
			$this->db->order_by('id', 'asc');
			$this->db->where(['id >' => $id]);
		} else {
			$this->db->order_by('id', 'desc');
			$this->db->where(['id <' => $id]);
		}
		$this->db->limit(1);
		return $this->db->get()->row();
	}


	function checkCategoryExist($val)
	{
		$this->db->where(['LOWER(name)' => $val, 'status' => 1]);
		$this->db->from('categories');
		$row = $this->db->get()->row();

		if (!empty($row)) {
			return $row->id;
		} else {
			$arr = [];
			$arr['name'] = $val;
			$arr['status'] = 1;
			$this->db->set($arr);
			$this->db->insert('categories');
			return $this->db->insert_id();
		}
	}
}
