<?php

class Lots extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->isLogged();
        has_access(20);
    }

    public function index()
    {
        $this->data['enable_datatable'] = TRUE;
        $this->data['pageView'] = ADMIN . '/lots';

        $this->data['rows'] = $this->master->getRows('lot_name',array('status'=>1), '', '', 'desc', 'id');
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }
    function view(){
        $this->data['pageView'] = ADMIN . '/lots';     
        if($this->data['row'] = $this->master->getRow('lot_name', array('id' => $this->uri->segment(4),'status'=>1))){
            $this->data['row']->site_row=$this->master->getRow('add_domains', array('site_id' => $this->data['row']->site_id));;
            $total_price=0;
            $inventory_codes=$this->master->getRows('add_code_to_lot',array('lot_id'=>$this->data['row']->id));
            $codes_arr=array();
            foreach($inventory_codes as $inventory_code){
                if($code_row=$this->master->getRow('code',array('id'=>$inventory_code->inventory_id))){
                    $total_price += $inventory_code->amount;
                    $code_row->amount = $inventory_code->amount;
                    $code_row->code_fullness=$inventory_code->fullness;
                    $code_row->created_date=$inventory_code->created_date;
                    $code_row->qty=$inventory_code->qty;
                    $code_row->lot_id=$inventory_code->id;
                   $codes_arr[]=$code_row; 
                }
                
            }
            $this->data['codes_arr']=$codes_arr;
            $this->data['total_price']=$total_price;
            $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
        }
        else{
            show_404();
        }
        
    }
    function delete()
    {
        $this->master->delete('lot_name', 'id', $this->uri->segment('4'));
        setMsg('success', 'Lot has been deleted successfully.');
        redirect(ADMIN . '/lots', 'refresh');
        exit;
    }


}

?>