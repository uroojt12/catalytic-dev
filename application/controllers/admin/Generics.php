<?php

class Generics extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->isLogged();
        $this->load->model('generics_model');
        $this->load->model('categories_model');
        $this->load->model('Pages_model', 'page');
    }

    function index()
    {
        $this->data['enable_datatable'] = TRUE;
        $this->data['pageView'] = ADMIN . '/generics';
        $this->data['rows'] = $this->generics_model->get_rows(array('type' => 'Generics'));
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }

    function manage()
    {
        $this->data['enable_editor'] = TRUE;
        $this->data['pageView'] = ADMIN . '/generics';
        if ($this->input->post()) {
            $vals = $this->input->post();

            if (($_FILES["image"]["name"] != "")) {
                $image = upload_file(UPLOAD_PATH . "generics/", 'image');

                if (!empty($image['file_name'])) {
                    $this->remove_file($this->uri->segment(4), 'image');
                    $vals['image'] = $image['file_name'];
                    // generate_thumb(UPLOAD_PATH . "generics/", UPLOAD_PATH . "generics/", $image['file_name'], 900, 'thumb_');
                } else {
                    setMsg('error', 'Please upload a valid image file >> ' . strip_tags($image['error']));
                    redirect(ADMIN . '/generics/manage/' . $this->uri->segment(4), 'refresh');
                    exit;
                }
            }
            $vals['type'] = 'Generics';

            // pr($vals);
            $this->generics_model->save($vals, $this->uri->segment(4));
            setMsg('success', 'Generics  has been saved successfully.');
            redirect(ADMIN . '/generics', 'refresh');
            exit;
        }
        $this->data['row'] = $this->generics_model->get_row_where(array('id' => $this->uri->segment('4')));
        $this->data['cats'] = $this->categories_model->get_rows();
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }

    function upload_bulk()
    {
        if (isset($_FILES) && !empty($_FILES['genericsFile']['name'])) {
            $file = $_FILES['genericsFile'];
            $extension = explode('.', $file['name']);
            if ($extension[1] === 'csv') {
                $row = 0;
                if (($handle = fopen($file['tmp_name'], "r")) !== FALSE) {
                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        if (++$row === 0) {
                            continue;
                        } else {
                            $insert = [];
                            // pr($data);
                            if (
                                !empty(trim($data[0]))
                                && !empty(trim($data[1]))
                                && !empty(trim($data[2]))
                                && !empty(trim($data[3]))
                                && !empty(trim($data[4]))
                                // && !empty(trim($data[5]))
                            ) {

                                // $category = $this->page->checkCategoryExist(strtolower($data[0]));
                                $insert['cat_id'] = NULL;
                                $insert['type']         = 'Generics';
                                $insert['title']         = NULL;
                                $insert['code']         = trim(strtolower($data[0]));
                                $insert['o_price']         = trim($data[1]);
                                $insert['pt_price']         = trim($data[2]);
                                $insert['pd_price']         = trim($data[3]);
                                $insert['rh_price']         = trim($data[4]);
                                // $insert['price']         = trim($data[5]);
                                $insert['status'] = 1;
                                $insert['created_date'] = date('Y-m-d h:i:s');
                                // pr($insert);
                                $this->master->save('code', $insert);
                            }
                        }
                    }

                    setMsg('success', 'File uploaded successfully! Empty records will be ignored.');
                    redirect(ADMIN . '/generics', 'refresh');
                    exit;
                }
            } else {
                setMsg('error', 'Please select only csv file.');
                redirect(ADMIN . '/generics', 'refresh');
                exit;
            }
        } else {
            setMsg('error', 'No File was seleted.');
            redirect(ADMIN . '/generics', 'refresh');
            exit;
        }
    }


    function delete($id)
    {
        $id = intval($id);
        if ($row = $this->generics_model->get_row($id)) {
            $this->generics_model->delete($this->uri->segment('4'));
            // $this->master->delete_where('sub_generics', array('ser_id' => $this->uri->segment('4')));

            setMsg('success', 'generics Lot has been deleted successfully.');
            redirect(ADMIN . '/generics', 'refresh');
            exit;
        } else
            show_404();
    }

    function remove_file($id)
    {
        $arr = $this->generics_model->get_row($id);

        $filepath = "./" . UPLOAD_PATH . "/generics/" . $arr->icon;
        $filepath_thumb = "./" . UPLOAD_PATH . "/generics/thumb_" . $arr->icon;
        if (is_file($filepath)) {
            unlink($filepath);
        }
        if (is_file($filepath_thumb)) {
            unlink($filepath_thumb);
        }
        return;
    }
}
