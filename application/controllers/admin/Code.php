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
                } else {
                    setMsg('error', 'Please upload a valid image file >> ' . strip_tags($image['error']));
                    redirect(ADMIN . '/code/manage/' . $this->uri->segment(4), 'refresh');
                    exit;
                }
            }
            $vals['type'] = 'Code';
            $id=$this->code_model->save($vals, $this->uri->segment(4));
            if (isset($_FILES["upload_file"]["name"]) && count($_FILES["upload_file"]["name"]) > 0) {
                upload_multiple_images('./uploads/images/', $_FILES, 'upload_file', $id,'code');
            }
            setMsg('success', 'Code  has been saved successfully.');
            redirect(ADMIN . '/code', 'refresh');
            exit;
        }
        $this->data['row'] = $this->code_model->get_row_where(array('id' => $this->uri->segment('4')));
        $this->data['cats'] = $this->categories_model->get_rows();
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }

    public function fetch_codes()
    {
        $data = $row = array();
        $codes = $this->code_model->getdatatableRows($_POST);
        $i = $_POST['start'];
        foreach ($codes as $code) {
            $i++;
            $photo = '<div class="">' . '<img src="' . get_site_image_src('code', $code->image) . '" height="60" style="background-color:#eee">' . '</div>';
            $type = '<b>' . strtoupper($code->new_type) . '</b>';
            $code_name = '<b>' . strtoupper($code->code) . '</b>';
            $pump_cal_price = calculatedAllPrice($this->data['adminsite_setting']->site_o_pt_price, $this->data['adminsite_setting']->site_live_pt_price, $this->data['adminsite_setting']->site_o_pd_price, $this->data['adminsite_setting']->site_live_pd_price, $this->data['adminsite_setting']->site_o_rh_price, $this->data['adminsite_setting']->site_live_rh_price, '-1', $code->id);
            $price = '<b>' . format_amount($pump_cal_price) . '</b>';
            $chk_code = chk_code_price_percentage(-1, $code->id);
            $form = '<form action="' . site_url(ADMIN . '/code/update_price/' . $code->id) . '" method="POST">
                <input type="hidden" name="new_price" value="0">';

            $input = '<input type="number" step="any" name="percentage" id="percentage" value="' .
                (!empty($chk_code) ? $chk_code->percentage : $this->data['adminsite_setting']->price_pump) .
                '" class="form-control" style="margin-right: 10px;" />';

            $up_button = '<div class="btn-group">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
            </form>';

            $form .= $input . $up_button;
            $status = getStatus($code->status);
            $button = $this->load->view('admin/action_btn', ['id' => $code->id], TRUE);
            $data[] = [
                $i,
                $photo,
                $type,
                $code_name,
                $price,
                $form,
                $status,
                $button
            ];
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->code_model->countAll(),
            "recordsFiltered" => $this->code_model->countFiltered($_POST),
            "data" => $data,
        );

        echo json_encode($output);
    }


    // function upload_bulk()
    // {
    //     if (isset($_FILES) && !empty($_FILES['codesFile']['name'])) {
    //         $file = $_FILES['codesFile'];
    //         $extension = explode('.', $file['name']);
    //         if ($extension[1] === 'csv') {
    //             $row = 0;
    //             if (($handle = fopen($file['tmp_name'], "r")) !== FALSE) {
    //                 while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
    //                     if (++$row === 0) {
    //                         continue;
    //                     } else {
    //                         $insert = [];
    //                         // pr($data);
    //                         if (
    //                             !empty(trim($data[0]))
    //                             && !empty(trim($data[1]))
    //                             && !empty(trim($data[2]))
    //                             && !empty(trim($data[3]))
    //                             && !empty(trim($data[4]))
    //                             && !empty(trim($data[5]))

    //                         ) {

    //                             $category = $this->page->checkCategoryExist(strtolower($data[0]));
    //                             $insert['cat_id'] = (int)$category;
    //                             $insert['type']         = 'Code';
    //                             $insert['title']         = NULL;
    //                             $insert['code']         = trim(strtolower($data[1]));
    //                             $insert['o_price']         = trim($data[2]);
    //                             $insert['pt_price']         = trim($data[3]);
    //                             $insert['pd_price']         = trim($data[4]);
    //                             $insert['rh_price']         = trim($data[5]);
    //                             $insert['status'] = 1;
    //                             $insert['created_date'] = date('Y-m-d h:i:s');
    //                             // pr($insert);
    //                             $this->master->save('code', $insert);
    //                         }
    //                     }
    //                 }

    //                 setMsg('success', 'File uploaded successfully! Empty records will be ignored.');
    //                 redirect(ADMIN . '/code', 'refresh');
    //                 exit;
    //             }
    //         } else {
    //             setMsg('error', 'Please select only csv file.');
    //             redirect(ADMIN . '/code', 'refresh');
    //             exit;
    //         }
    //     } else {
    //         setMsg('error', 'No File was seleted.');
    //         redirect(ADMIN . '/code', 'refresh');
    //         exit;
    //     }
    // }


    function upload_bulk()
    {
        if (isset($_FILES) && !empty($_FILES['codesFile']['name'])) {
            $file = $_FILES['codesFile'];
            $extension = explode('.', $file['name']);
            if (strtolower(end($extension)) === 'csv') {
                $row = 0;
                if (($handle = fopen($file['tmp_name'], "r")) !== FALSE) {
                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        if ($row++ === 0) {
                            continue;
                        }

                        if (
                            !empty(trim($data[0])) &&
                            !empty(trim($data[1])) &&
                            !empty(trim($data[2])) &&
                            !empty(trim($data[3])) &&
                            !empty(trim($data[4])) &&
                            !empty(trim($data[5])) &&
                            !empty(trim($data[6]))
                        ) {
                            $code = trim(strtolower($data[1]));
                            $new_type = trim($data[6]);

                            $existing_code = $this->master->getRow('code', ['code' => $code]);

                            if ($existing_code) {
                                $update_data = [
                                    'new_type' => $new_type,
                                ];
                                $this->master->update('code', $update_data, ['code' => $code]);
                            } else {
                                $category = $this->page->checkCategoryExist(strtolower($data[0]));
                                $insert = [
                                    'cat_id' => (int)$category,
                                    'type' => 'Code',
                                    'title' => NULL,
                                    'code' => $code,
                                    'o_price' => trim($data[2]),
                                    'pt_price' => trim($data[3]),
                                    'pd_price' => trim($data[4]),
                                    'rh_price' => trim($data[5]),
                                    'new_type' => $new_type,
                                    'status' => 1,
                                    'created_date' => date('Y-m-d h:i:s')
                                ];
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
            setMsg('error', 'No File was selected.');
            redirect(ADMIN . '/code', 'refresh');
            exit;
        }
    }




    function update_price()
    {

        $this->data['enable_editor'] = TRUE;
        $this->data['pageView'] = ADMIN . '/code';
        if ($this->input->post()) {
            $vals = $this->input->post();
            $vals['site_id'] = '-1';
            $vals['code_id'] = $this->uri->segment(4);
            $vals['created_date'] = date('Y-m-d h:i:s');
            $id = $this->master->save('code_prices', $vals);
            setMsg('success', 'Code Price has been saved successfully.');
            redirect(ADMIN . '/code', 'refresh');
            exit;
        }
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }



    function delete($id)
    {
        $id = intval($id);
        if ($row = $this->code_model->get_row($id)) {
            $this->code_model->delete($this->uri->segment('4'));
            setMsg('success', 'Code Lot has been deleted successfully.');
            redirect(ADMIN . '/code', 'refresh');
            exit;
        } else
            show_404();
    }

    function delete_image($id)
    {
        $id = intval($id);
        if ($row = $this->code_model->get_row($id)) {
            $this->remove_file($id);
            $data['image'] = NULL;
            $this->code_model->save($data, $id);
            // $this->code_model->delete($this->uri->segment('4'));
            setMsg('success', 'Code Image has been deleted successfully.');
            redirect(ADMIN . '/code', 'refresh');
            exit;
        } else
            show_404();
    }

    function remove_file($id)
    {
        $arr = $this->code_model->get_row($id);

        $filepath = "./" . UPLOAD_PATH . "/code/" . $arr->image;
        $filepath_thumb = "./" . UPLOAD_PATH . "/code/thumb_" . $arr->image;
        if (is_file($filepath)) {
            unlink($filepath);
        }
        if (is_file($filepath_thumb)) {
            unlink($filepath_thumb);
        }
        return;
    }
     function delete_single_image(){
        $vals = $this->input->post();
        // pr($vals);
        if ($vals) {
            $this->master->delete('multiple_images','id',$vals['id']);
                echo json_encode(array('status'=>1));

            
        }
    }
}
