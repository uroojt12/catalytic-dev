<?php

class Generics extends SUBADMIN_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->isLogged();
        $this->subadmin = $this->getActiveSubAdmin();
        $this->load->model('code_model');
    }

    function index()
    {
        $this->data['enable_datatable'] = TRUE;
        $this->data['pageView'] = SUBADMIN . '/generics';
        $this->data['rows'] = $this->code_model->get_rows(array('type'=>'Generics'));
        $this->load->view(SUBADMIN . '/includes/siteMaster', $this->data);
    }

    function update_price()
    {

        $this->data['enable_editor'] = TRUE;
        $this->data['pageView'] = SUBADMIN . '/generics';
        if ($this->input->post()) {
            $vals = $this->input->post();

            // pr($this->subadmin);
            $new_price = ($vals['percentage'] / 100) * $vals['new_price'];

            $vals['new_price'] = $vals['new_price'] + $new_price;
            $vals['site_id'] = $this->subadmin->site_id;
            $vals['code_id'] = $this->uri->segment(4);
            $vals['created_date'] = date('Y-m-d h:i:s');
            $id = $this->master->save('code_prices', $vals);
            // pr($vals);
            // $this->code_model->save($vals, $this->uri->segment(4));
            setMsg('success', 'Generic Lot has been saved successfully.');
            redirect(SUBADMIN . '/generics', 'refresh');
            exit;
        }
        // $this->data['row'] = $this->code_model->get_row_where(array('id' => $this->uri->segment('4')));
        $this->load->view(SUBADMIN . '/includes/siteMaster', $this->data);
    }
}
