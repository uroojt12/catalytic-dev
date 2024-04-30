<?php

class Photo_grade extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->isLogged();
        $this->load->model('photo_grade_model');
    }

    function index()
    {
        $this->data['enable_datatable'] = TRUE;
        $this->data['pageView'] = ADMIN . '/photo_grade';
        $this->data['rows'] = $this->photo_grade_model->get_rows(array());
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }

    function manage()
    {
        $this->data['enable_editor'] = TRUE;
        $this->data['pageView'] = ADMIN . '/photo_grade';
        if ($this->input->post()) {
            $vals = $this->input->post();

            if (($_FILES["image"]["name"] != "")) {
                $image = upload_file(UPLOAD_PATH . "photo_grade/", 'image');

                if (!empty($image['file_name'])) {
                    $this->remove_file($this->uri->segment(4), 'image');
                    $vals['image'] = $image['file_name'];
                    // generate_thumb(UPLOAD_PATH . "photo_grade/", UPLOAD_PATH . "photo_grade/", $image['file_name'], 900, 'thumb_');
                } else {
                    setMsg('error', 'Please upload a valid image file >> ' . strip_tags($image['error']));
                    redirect(ADMIN . '/photo_grade/manage/' . $this->uri->segment(4), 'refresh');
                    exit;
                }
            }
            // pr($vals);
            $this->photo_grade_model->save($vals, $this->uri->segment(4));
            setMsg('success', 'photo_grade Lot has been saved successfully.');
            redirect(ADMIN . '/photo_grade', 'refresh');
            exit;
        }
        $this->data['row'] = $this->photo_grade_model->get_row_where(array('id' => $this->uri->segment('4')));
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }

    function delete($id)
    {
        $id = intval($id);
        if ($row = $this->photo_grade_model->get_row($id)) {
            $this->photo_grade_model->delete($this->uri->segment('4'));
            // $this->master->delete_where('sub_photo_grade', array('ser_id' => $this->uri->segment('4')));

            setMsg('success', 'photo_grade Lot has been deleted successfully.');
            redirect(ADMIN . '/photo_grade', 'refresh');
            exit;
        } else
            show_404();
    }

    function remove_file($id)
    {
        $arr = $this->photo_grade_model->get_row($id);

        $filepath = "./" . UPLOAD_PATH . "/photo_grade/" . $arr->icon;
        $filepath_thumb = "./" . UPLOAD_PATH . "/photo_grade/thumb_" . $arr->icon;
        if (is_file($filepath)) {
            unlink($filepath);
        }
        if (is_file($filepath_thumb)) {
            unlink($filepath_thumb);
        }
        return;
    }
}
