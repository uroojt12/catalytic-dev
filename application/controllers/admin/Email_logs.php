<?php

class Email_logs extends Admin_Controller {

    private $table_name = "email_logs";

    public function __construct() {
        parent::__construct();
        $this->isLogged();
    }

    public function index() {
        $this->data['enable_datatable'] = TRUE;
        $this->data['pageView'] = ADMIN.'/email_logs';
        $this->data['rows'] = $this->master->getRows($this->table_name,'','','','DESC');;
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }
    function manage() {
        $this->data['enable_editor'] = TRUE;
        $this->data['pageView'] = ADMIN.'/email_logs';
        
        $this->data['row'] = $this->master->getRow($this->table_name, array('id' => $this->uri->segment(4)));
        $this->data['proof'] = $this->master->getRow('order_delivery_proof', array('proof_id' => $this->data['row']->proof_id));
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }

    function delete() {
        $this->master->delete($this->table_name, 'id', $this->uri->segment('4'));
        setMsg('success', 'Delete successfully !');
        redirect(ADMIN . '/email_logs', 'refresh');
    }
    function deleteAll(){
        $ids = $this->input->post('checkbox_id');
        if(!empty($ids)){
            $delete=$this->master->delete($this->table_name,'id',$ids);
            setMsg('success', 'Deleted successfully !');
        }
        else{
            setMsg('error', 'Please Select atleast 1 Record !');
        }
        redirect(ADMIN . '/email_logs', 'refresh');
    }
}

?>