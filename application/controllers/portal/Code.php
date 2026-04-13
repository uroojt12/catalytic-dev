<?php

class Code extends SUBADMIN_Controller
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
        $this->data['pageView'] = SUBADMIN . '/code';
        $this->data['rows'] = $this->code_model->get_rows(array('type' => 'Code'));
        $this->load->view(SUBADMIN . '/includes/siteMaster', $this->data);
    }

    function update_price()
    {

        $this->data['enable_editor'] = TRUE;
        $this->data['pageView'] = SUBADMIN . '/code';
        if ($this->input->post()) {
            $vals = $this->input->post();
            $vals['site_id'] = $this->subadmin->site_id;
            $vals['code_id'] = $this->uri->segment(4);
            $vals['created_date'] = date('Y-m-d h:i:s');
            $id = $this->master->save('code_prices', $vals);

            setMsg('success', 'Code Lot has been saved successfully.');
            redirect(SUBADMIN . '/code', 'refresh');
            exit;
        }
        $this->load->view(SUBADMIN . '/includes/siteMaster', $this->data);
    }


    public function portal_fetch_codes()
    {
        $data = $row = array();
        // Fetch member's records
        $codes = $this->code_model->getdatatableRows($_POST);

        $i = $_POST['start'];
        foreach ($codes as $code) {
            $i++;
            // $photo = '<div class="">' . '<img src="' . get_site_image_src('code', $code->image) . '" height="60" style="background-color:#eee">' . '</div>';
            $code_name = '<b>' . strtoupper($code->code) . '</b>';
            $pump_cal_price = calculatedAllPrice($this->data['mainadminsite_setting']->site_o_pt_price, $this->data['mainadminsite_setting']->site_live_pt_price, $this->data['mainadminsite_setting']->site_o_pd_price, $this->data['mainadminsite_setting']->site_live_pd_price, $this->data['mainadminsite_setting']->site_o_rh_price, $this->data['mainadminsite_setting']->site_live_rh_price, $this->subadmin->site_id, $code->id);
            $price = '<b>' . format_amount($pump_cal_price) . '</b>';
            $chk_code = chk_code_price_percentage($this->subadmin->site_id, $code->id);

            // Concatenate the form properly
            $form = '<form action="' . site_url(SUBADMIN . '/code/update_price/' . $code->id) . '" method="POST">
                <input type="hidden" name="new_price" value="0">';

            $input = '<input type="number" step="any" name="percentage" id="percentage" value="' .
                (!empty($chk_code) ? $chk_code->percentage : $this->subadmin->price_pump) .
                '" class="form-control" style="margin-right: 10px;" />';

            $up_button = '<div class="btn-group">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
            </form>';

            $form .= $input . $up_button;
            $status = getStatus($code->status);
            // $button = $this->load->view('admin/action_btn', ['id' => $code->id], TRUE);
            $data[] = [
                $i,
                // $photo,
                $code_name,
                $price,
                $form, // Use the combined form
                $status
                // $button
            ];
        }


        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->code_model->countAll(),
            "recordsFiltered" => $this->code_model->countFiltered($_POST),
            "data" => $data,
        );

        // Output to JSON format
        echo json_encode($output);
    }
}
