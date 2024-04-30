<?php

class Plans extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->isLogged();
    }

    function index()
    {
        $this->data['enable_datatable'] = TRUE;
        $this->data['pageView'] = ADMIN . '/plans';
        
        $this->data['rows'] = $this->master->getRows('plans');
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }
    
    function manage()
    {
        $this->data['enable_editor'] = TRUE;
        $this->data['pageView'] = ADMIN . '/plans';
        if ($this->input->post()) {
            $vals = $this->input->post();

            if ($vals['popular'] == 1) {
                // Mark the existing popular plan as non-popular
                $this->master->update('plans', ['popular' => 0], ['status' => 1]);
            }

            $this->master->save('plans', $vals, 'id', $this->uri->segment(4));
            setMsg('success', 'Plan has been saved successfully.');
            redirect(ADMIN . '/plans', 'refresh');
            exit;
        }
        $this->data['row'] = $this->master->getRow('plans', array('id' => $this->uri->segment('4')));
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }

    function delete($id) {
        $id = intval($id);
        if ($row = $this->mastere->getRow('plans', array('id' => $id))) {
            $this->master->delete_where('plans', array('id' => $this->uri->segment('4')));
            setMsg('success', 'Plan has been deleted successfully.');
            redirect(ADMIN . '/plans', 'refresh');
            exit;
        }
        else
            show_404();
    }

}

?>