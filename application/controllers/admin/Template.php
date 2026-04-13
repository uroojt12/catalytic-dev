<?php

class Template extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->isLogged();
        
    }

    function index()
    {
        $this->data['enable_datatable'] = TRUE;
        $this->data['pageView'] = ADMIN . '/template';
        $this->data['rows'] = $this->master->getRows('templates', array(), '', '', 'DESC');
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }

    function manage()
    {
        $this->data['enable_editor'] = TRUE;
        $this->data['pageView'] = ADMIN . '/template';
        if ($this->input->post()) {
            $vals = $this->input->post();

            $content_row = $this->master->getRow('templates', array('id' => $this->uri->segment('4')));
          

            if (isset($_FILES["template_file"]["name"]) && $_FILES["template_file"]["name"] != "") {
                $this->remove_file($this->uri->segment(4));
                $template_file = upload_file(UPLOAD_PATH . 'templates/', 'template_file');
               
                $vals['template_file'] = $template_file['file_name'];
            } else {
                $vals['template_file'] = $content_row->template_file;
            }

            // pr($vals);
            $id = $this->master->save('templates', $vals, 'id', $this->uri->segment('4'));
            if ($id > 0) {
                setMsg('success', 'Template has been saved successfully.');
                redirect(ADMIN . '/template', 'refresh');
                exit;
            }
        }
        $this->data['row'] = $this->master->getRow('templates', array('id' => $this->uri->segment('4')));
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }


    function delete($id)
    {
        $id = intval($id);
        if ($id > 0) {
            $this->remove_file($this->uri->segment(4));
            $this->master->delete_where('templates', array('id' => $this->uri->segment('4')));
            setMsg('success', 'Template has been deleted successfully.');
            redirect(ADMIN . '/template', 'refresh');
            exit;
        } else
            show_404();
    }

    function remove_file($id)
    {
        $arr = $this->master->getRow('templates', array('id' => $id));

        $filepath = "./" . UPLOAD_PATH . "/templates/" . $arr->template_file;
        $filepath_thumb = "./" . UPLOAD_PATH . "/templates/thumb_" . $arr->template_file;
        if (is_file($filepath)) {
            unlink($filepath);
        }
        if (is_file($filepath_thumb)) {
            unlink($filepath_thumb);
        }
        return;
    }
}
