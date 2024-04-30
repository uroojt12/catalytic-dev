<?php

class Inventory extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->isLogged();
        $this->load->model('inventory_model');
    }

    function index()
    {
        $this->data['enable_datatable'] = TRUE;
        $this->data['pageView'] = ADMIN . '/inventory';
        $this->data['rows'] = $this->inventory_model->get_rows(array());
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }

    function manage()
    {
        $this->data['enable_editor'] = TRUE;
        $this->data['pageView'] = ADMIN . '/inventory';
        if ($this->input->post()) {
            $vals = $this->input->post();

            if (($_FILES["image"]["name"] != "")) {
                $image = upload_file(UPLOAD_PATH . "inventory/", 'image');

                if (!empty($image['file_name'])) {
                    $this->remove_file($this->uri->segment(4), 'image');
                    $vals['image'] = $image['file_name'];
                    // generate_thumb(UPLOAD_PATH . "inventory/", UPLOAD_PATH . "inventory/", $image['file_name'], 900, 'thumb_');
                } else {
                    setMsg('error', 'Please upload a valid image file >> ' . strip_tags($image['error']));
                    redirect(ADMIN . '/inventory/manage/' . $this->uri->segment(4), 'refresh');
                    exit;
                }
            }
            // pr($vals);
            $this->inventory_model->save($vals, $this->uri->segment(4));
            setMsg('success', 'Inventory Lot has been saved successfully.');
            redirect(ADMIN . '/inventory', 'refresh');
            exit;
        }
        $this->data['row'] = $this->inventory_model->get_row_where(array('id' => $this->uri->segment('4')));
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }

    function delete($id)
    {
        $id = intval($id);
        if ($row = $this->inventory_model->get_row($id)) {
            $this->inventory_model->delete($this->uri->segment('4'));
            // $this->master->delete_where('sub_inventory', array('ser_id' => $this->uri->segment('4')));

            setMsg('success', 'Inventory Lot has been deleted successfully.');
            redirect(ADMIN . '/inventory', 'refresh');
            exit;
        } else
            show_404();
    }

    function remove_file($id)
    {
        $arr = $this->inventory_model->get_row($id);

        $filepath = "./" . UPLOAD_PATH . "/inventory/" . $arr->icon;
        $filepath_thumb = "./" . UPLOAD_PATH . "/inventory/thumb_" . $arr->icon;
        if (is_file($filepath)) {
            unlink($filepath);
        }
        if (is_file($filepath_thumb)) {
            unlink($filepath_thumb);
        }
        return;
    }
}
