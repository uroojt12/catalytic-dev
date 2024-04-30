<?php 

class Meta_info extends Admin_Controller
{
    function __construct()
	{
		parent::__construct();
		$this->isLogged();
		$this->load->model("pages_model",'page');
		$this->load->model('Master_model','master');
	}
	function index(){
		$this->data['pageView'] = ADMIN.'/meta-info';
		$this->data['rows'] = $this->master->get_data_rows('meta_info');
		$this->load->view(ADMIN.'/includes/siteMaster',$this->data);
	}
	function manage(){
		$this->data["pageView"] = ADMIN."/meta-info";
		$slug = $this->uri->segment(4);
		$raw_data = $this->page->getMetaContent($slug);

		$content=$this->clean($raw_data->content);
		$content = json_decode($raw_data->content);
		$this->data["row"] = $content;
		$this->data['page_name'] = $raw_data->page_name;
		$this->data['slug'] = $raw_data->slug;
		// pr($this->data["row"]);
		if($this->input->post()){
			$data = array();
			$vals=$this->input->post();

			if($_FILES['og_image']['name'] != ""){
				$this->removeImage($slug, "og_image", UPLOADIMAGE.'images/');
				$image = upload_image(UPLOADIMAGE.'images/', "og_image");
				$vals["og_image"] = $image["file_name"];
			}
			else{
				$vals['og_image'] = $this->data["row"]->og_image;
			}
			if($_FILES['twitter_image']['name'] != ""){
				$this->removeImage($slug,"twitter_image",UPLOADIMAGE.'images/');
				$image = upload_image(UPLOADIMAGE.'images/',"twitter_image");
				$vals["twitter_image"] = $image["file_name"];
			}
			else{
				$vals['twitter_image'] = $this->data["row"]->twitter_image;
			}
			// pr($vals);
			// pr($image);
			$data['page_name'] = $vals['page_name'];
			$data['slug'] = $vals['slug'];
			unset($vals['page_name'], $vals['slug']);				
			$raw_data = json_encode($vals);
			$data['content'] = $raw_data;
			// pr($data);
			$this->page->saveMetaContent($data,$slug);
			setMsg("success","Meta Information saved successfully!");
			redirect("admin/meta-info");
		}
		$this->load->view(ADMIN."/includes/siteMaster",$this->data); 
	}
	function delete(){
		$slug = $this->uri->segment(4);
		$this->master->delete_row('meta_info',array('slug'=>$slug));
		setMsg('success','Page info deleted successfully');
		redirect(ADMIN.'/meta-info','refresh');
	}
	function removeImage($page_slug,$field_name,$path){
		$raw_data = $this->page->getMetaContent($page_slug);
		$content=$this->clean($raw_data->content);
		$content = json_decode($raw_data->content);
		$path = './'.$path.'/'.$content->$field_name;
		if(is_file($path)){
			unlink($path);
		}
		return;
	}
	function clean($string) {
  		 $string = str_replace(' ', '-', $string); 
   		 $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); 
		 return preg_replace('/-+/', '-', $string);
	}
}

?>