<?php

class Lot extends SUBADMIN_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->isLogged();
        $this->subadmin = $this->getActiveSubAdmin();

        // has_access(20);
    }

    public function index()
    {
        $this->data['enable_datatable'] = TRUE;
        $this->data['pageView'] = SUBADMIN . '/lot';

        $this->data['rows'] = $this->master->getRows('lot_name', array('site_id' => $this->subadmin->site_id, 'status' => 1), '', '', 'desc', 'id');
        $this->load->view(SUBADMIN . '/includes/siteMaster', $this->data);
    }
    function view($id = 0)
    {
        $id = intval($id);
        $this->data['pageView'] = SUBADMIN . '/lot';
        
        // if ($this->data['row'] = $this->master->getRow('lot_name', array('id' => $this->uri->segment(4), 'status' => 1))) {
        //     $arr['view_status'] = 1;
        //     $this->master->save('lot_name', $arr, 'id', $id);
        //     $this->data['row']->site_row = $this->master->getRow('add_domains', array('site_id' => $this->data['row']->site_id));;
        //     $total_price = 0;
        //     $inventory_codes = $this->master->getRows('add_code_to_lot', array('site_id' => $this->subadmin->site_id, 'lot_id' => $this->data['row']->id));
        //     $codes_arr = array();
        //     foreach ($inventory_codes as $inventory_code) {
        //         if ($code_row = $this->master->getRow('code', array('id' => $inventory_code->inventory_id))) {
        //             // pr($inventory_code);
        //             $total_price += $inventory_code->amount * $inventory_code->qty;
        //             $code_row->amount = $inventory_code->amount;
        //             $code_row->code_fullness = $inventory_code->fullness;
        //             $code_row->created_date = $inventory_code->created_date;
        //             $code_row->qty = $inventory_code->qty;
        //             $code_row->lot_id = $inventory_code->id;
        //             $codes_arr[] = $code_row;
        //         }
        //     }
        //     $this->data['codes_arr'] = $codes_arr;
        //     $this->data['total_price'] = $total_price;
        //     $this->load->view(SUBADMIN . '/includes/siteMaster', $this->data);
        // } else {
        //     show_404();
        // }
        
        if ($this->data['row'] = $this->master->getRow('lot_name', array('id' => $this->uri->segment(4), 'status' => 1))) {
            $arr['view_status'] = 1;
            $this->master->save('lot_name', $arr, 'id', $id);
            $this->data['row']->site_row = $this->master->getRow('add_domains', array('site_id' => $this->data['row']->site_id));;
            $total_price = 0;
            $inventory_codes = $this->master->getRows('add_code_to_lot', array('site_id' => $this->subadmin->site_id, 'lot_id' => $this->data['row']->id), '', '', 'DESC');
            $codes_arr = array();
            foreach ($inventory_codes as $inventory_code) {
                if ($code_row = $this->master->getRow('code', array('id' => $inventory_code->inventory_id))) {
                    
                    $total_price += $inventory_code->amount;
                    $code_row->amount = $inventory_code->amount;
                    $code_row->fullness = $inventory_code->fullness;
                    $code_row->created_date = $inventory_code->created_date;
                    $code_row->qty = $inventory_code->qty;
                    $code_row->row_id = $inventory_code->id;
                    $code_row->lot_type = $inventory_code->lot_type;
                    $code_row->mem_id = $inventory_code->mem_id;
                    $codes_arr[] = $code_row;
                }else{
                    $new_code_row = new stdClass(); // Creating a new standard class object
                    $total_price += $inventory_code->amount;
                    $new_code_row->amount = $inventory_code->amount;
                    $new_code_row->fullness = $inventory_code->fullness;
                    $new_code_row->qty = $inventory_code->qty;
                    $new_code_row->code_price = $inventory_code->code_price;
                    $new_code_row->row_id = $inventory_code->id;
                    $new_code_row->code_name = $inventory_code->code_name;
                    $new_code_row->code_image = $inventory_code->code_image;
                    $new_code_row->mem_id = $inventory_code->mem_id;
                    $new_code_row->created_date = $inventory_code->created_date;

                    // pr($new_code_row);
                    $codes_arr[] = $new_code_row;
                }
            }
            $this->data['codes_arr'] = $codes_arr;
            // $this->data['total_price'] = $total_price;
            $this->load->view(SUBADMIN . '/includes/siteMaster', $this->data);
        } else {
            show_404();
        }
    }
    function delete()
    {
        $this->master->delete('lot_name', 'id', $this->uri->segment('4'));
        setMsg('success', 'Lot has been deleted successfully.');
        redirect(SUBADMIN . '/lot', 'refresh');
        exit;
    }
}
