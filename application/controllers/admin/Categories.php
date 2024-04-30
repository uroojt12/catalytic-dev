<?php

class Categories extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->isLogged();
        $this->load->model('categories_model');
    }
    ///////////////////////////// Shop Product categories Controller FUnctions//////////////////////////////////////////

    function index()
    {
        $this->data['enable_datatable'] = TRUE;
        $this->data['pageView'] = ADMIN . '/categories';
        $this->data['enable_ratings'] = TRUE;
        $this->data['rows'] = $this->categories_model->get_rows();
        // pr($this->data['rows']);
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }

    function manage()
    {
        $this->data['enable_ratings'] = TRUE;
        $this->data['enable_editor'] = TRUE;
        $this->data['settings'] = $this->master->getRow('siteadmin');
        $this->data['pageView'] = ADMIN . '/categories';
        $this->data['row'] = $this->categories_model->get_row_where(array('id' => $this->uri->segment('4')));
        if ($this->input->post()) {
            $vals = ($this->input->post());
            // $this->session->userdata('site_lang')=='fr' ?  $vals['frname']:  $vals['name'] 
            $exist = $this->master->num_rows('categories', array("slug" => url_title($vals['name'], '-', TRUE), 'id!=' => $this->uri->segment(4)));
            if ($exist > 0) {
                $vals['slug'] = url_title($vals['name'], '-', TRUE) . "_1";
            } else {
                $vals['slug'] = url_title($vals['name'], '-', TRUE);
            }


            $id = $this->categories_model->save($vals, $this->uri->segment(4));

            setMsg('success', 'Category has been saved successfully.');
            redirect(ADMIN . '/categories', 'refresh');
            exit;
        }

        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }

    function delete($id)
    {
        $id = intval($id);
        // pr($id);
        if ($row = $this->categories_model->get_row($id)) {


            $this->categories_model->delete($this->uri->segment('4'));
            $this->master->delete("categories", 'cat_id', $id);
            setMsg('success', 'Category has been deleted successfully.');
            redirect(ADMIN . '/categories', 'refresh');
            exit;
        } else
            show_404();
    }


    function active()
    {
        $vals['status'] = 1;
        $id = $this->categories_model->save($vals, $this->uri->segment(4));

        // pr($this->db->last_query());
        setMsg('success', 'Category Active successfully.');
        redirect(ADMIN . '/categories', 'refresh');
    }
    function inactive()
    {
        $vals['status'] = 0;
        $id = $this->categories_model->save($vals, $this->uri->segment(4));
        setMsg('success', 'Category InActive successfully.');
        redirect(ADMIN . '/categories', 'refresh');
    }
}
