<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends MY_Controller
{

	function __construct()
    {
		parent::__construct();
        // $this->load->model('jobs_model');
	}
    function upload_editor_attach()
    {
        if($_FILES['upload']['name'] != '') {
            $image = upload_file(UPLOAD_PATH."blogs/", 'upload', 'att');
            if (!empty($image['file_name'])) {
                exit(json_encode(['file_name' => $_FILES['upload']['name'], 'uploaded' => 1, 'url' => base_url().'/uploads/blogs/'.$image['file_name']]));
            } else {
                exit(json_encode(['fileName' => $_FILES['upload']['name'], 'status' => 1, 'error' => strip_tags($image['error'])]));
            }
        }
    }
	
}

?>