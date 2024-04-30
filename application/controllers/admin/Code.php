<?php

class Code extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->isLogged();
        $this->load->model('code_model');
        $this->load->model('categories_model');
        $this->load->model('Pages_model', 'page');
    }

    function index()
    {
        $this->data['enable_datatable'] = TRUE;
        $this->data['pageView'] = ADMIN . '/code';
        $this->data['rows'] = $this->code_model->get_rows(array('type' => 'Code'));
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }

    function manage()
    {
        $this->data['enable_editor'] = TRUE;
        $this->data['pageView'] = ADMIN . '/code';
        if ($this->input->post()) {
            $vals = $this->input->post();

            if (($_FILES["image"]["name"] != "")) {
                $image = upload_file(UPLOAD_PATH . "code/", 'image');

                if (!empty($image['file_name'])) {
                    $this->remove_file($this->uri->segment(4), 'image');
                    $vals['image'] = $image['file_name'];
                    // generate_thumb(UPLOAD_PATH . "code/", UPLOAD_PATH . "code/", $image['file_name'], 900, 'thumb_');
                } else {
                    setMsg('error', 'Please upload a valid image file >> ' . strip_tags($image['error']));
                    redirect(ADMIN . '/code/manage/' . $this->uri->segment(4), 'refresh');
                    exit;
                }
            }
            $vals['type'] = 'Code';

            // pr($vals);
            $this->code_model->save($vals, $this->uri->segment(4));
            setMsg('success', 'Code  has been saved successfully.');
            redirect(ADMIN . '/code', 'refresh');
            exit;
        }
        $this->data['row'] = $this->code_model->get_row_where(array('id' => $this->uri->segment('4')));
        $this->data['cats'] = $this->categories_model->get_rows();
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }


    function upload_bulk()
    {
        if (isset($_FILES) && !empty($_FILES['codesFile']['name'])) {
            $file = $_FILES['codesFile'];
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
                                && !empty(trim($data[5]))
                                // && !empty(trim($data[6]))

                            ) {

                                $category = $this->page->checkCategoryExist(strtolower($data[0]));
                                $insert['cat_id'] = (int)$category;
                                $insert['type']         = 'Code';
                                $insert['title']         = NULL;
                                $insert['code']         = trim(strtolower($data[1]));
                                $insert['o_price']         = trim($data[2]);
                                $insert['pt_price']         = trim($data[3]);
                                $insert['pd_price']         = trim($data[4]);
                                $insert['rh_price']         = trim($data[5]);
                                // $insert['price']         = trim($data[6]);
                                $insert['status'] = 1;
                                $insert['created_date'] = date('Y-m-d h:i:s');
                                // pr($insert);
                                $this->master->save('code', $insert);
                            }
                        }
                    }

                    setMsg('success', 'File uploaded successfully! Empty records will be ignored.');
                    redirect(ADMIN . '/code', 'refresh');
                    exit;
                }
            } else {
                setMsg('error', 'Please select only csv file.');
                redirect(ADMIN . '/code', 'refresh');
                exit;
            }
        } else {
            setMsg('error', 'No File was seleted.');
            redirect(ADMIN . '/code', 'refresh');
            exit;
        }
    }



    function delete($id)
    {
        $id = intval($id);
        if ($row = $this->code_model->get_row($id)) {
            $this->code_model->delete($this->uri->segment('4'));
            // $this->master->delete_where('sub_code', array('ser_id' => $this->uri->segment('4')));

            setMsg('success', 'Code Lot has been deleted successfully.');
            redirect(ADMIN . '/code', 'refresh');
            exit;
        } else
            show_404();
    }

    function remove_file($id)
    {
        $arr = $this->code_model->get_row($id);

        $filepath = "./" . UPLOAD_PATH . "/code/" . $arr->icon;
        $filepath_thumb = "./" . UPLOAD_PATH . "/code/thumb_" . $arr->icon;
        if (is_file($filepath)) {
            unlink($filepath);
        }
        if (is_file($filepath_thumb)) {
            unlink($filepath_thumb);
        }
        return;
    }
}
