<?php

class Add_domains extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->isLogged();
        $this->load->model('add_domains_model');
    }

    function index()
    {
        $this->data['enable_datatable'] = TRUE;
        $this->data['pageView'] = ADMIN . '/add_domains';
        $this->data['rows'] = $this->add_domains_model->get_rows(array());
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }

    function manage()
    {
        $this->data['enable_editor'] = TRUE;
        $this->data['pageView'] = ADMIN . '/add_domains';
        if ($this->input->post()) {
            $vals = $this->input->post();
            $mem_data = array(
                'domain_name' => $vals['domain_name'],
                'name' => $vals['name'],
                'email' => $vals['email'],
                'password' => $vals['password'],
            );
            $content_row = $this->master->getRow('add_domains', array('site_id' => $this->uri->segment('4')));
            if ($vals['password'] == '') {
                $vals['password'] = $content_row->password;
            } else {
                $vals['password'] = md5($vals['password']);
            }

            $vals['created_date'] = date('Y-m-d h:i:s');
            // pr($vals);
            if (isset($_FILES["site_logo"]["name"]) && $_FILES["site_logo"]["name"] != "") {
                $image2 = upload_file(UPLOADS . 'images/', 'site_logo');
                $vals['site_logo'] = $image2['file_name'];
            } else {
                $vals['site_logo'] = $content_row->site_logo;
            }
            $id = $this->add_domains_model->save($vals, $this->uri->segment(4));
            if ($id > 0) {

                $chk_row = $this->master->getRows('sitecontent', array('site_id' => $id));
                if (empty($chk_row)) {
                    $site_content = $this->master->getRows('sitecontent', array('site_id' => 1));
                    foreach ($site_content as $site_cont) {
                        $sitecode = unserialize($site_cont->code);

                        for ($i = 1; $i <= 20; $i++) {
                            $image = $sitecode['image' . $i];
                            $path = FCPATH . 'uploads/images/' . $image;
                            if (file_exists($path)) {
                                // $newFilename = $sitecode['image'.$i];
                                // pr($newFilename);
                                $newFilename = 'new_name_' . $i . '.jpg';
                                $destinationFolder = FCPATH . 'uploads/images/';
                                $destinationImagePath = $destinationFolder . $newFilename;

                                if (copy($path, $destinationImagePath)) {
                                    $sitecode['image' . $i] = $newFilename;
                                }
                            }
                        }

                        $serialized_code = serialize($sitecode);
                        // pr($serialized_code);
                        $data = array(
                            'site_id' => $id,
                            'ckey' => $site_cont->ckey,
                            'code' => $serialized_code,
                        );
                        $this->master->save("sitecontent", $data);
                    }
                }

                $chk_colors = $this->master->getRow('colors', array('site_id' => $id));
                if (empty($chk_colors)) {

                    $colors = $this->master->getRow('colors', array('site_id' => 1));
                    $data_colors = array(
                        'site_id' => $id,
                        'primary_color' => $colors->primary_color,
                        'secondary_color' => $colors->secondary_color,
                        'teritary_color' => $colors->teritary_color,
                        'dark_bg' => $colors->dark_bg,
                        'light_color' => $colors->light_color,
                        'section_bg' => $colors->section_bg,
                        'p_color' => $colors->p_color,
                        'dark_a' => $colors->dark_a,
                        'testi_linear_1' => $colors->testi_linear_1,
                        'testi_linear_2' => $colors->testi_linear_2,
                        'section_linear_1' => $colors->section_linear_1,
                        'textbox_bg' => $colors->textbox_bg,
                        'textbox_border' => $colors->textbox_border,
                        'light_btn_bg' => $colors->light_btn_bg,
                        'readBtn_bg' => $colors->readBtn_bg,
                        'dropdown_bg' => $colors->dropdown_bg,
                        'inner_bg' => $colors->inner_bg,
                        'qty_bg' => $colors->qty_bg,
                        'dark_color' => $colors->dark_color,
                    );
                    $this->master->save("colors", $data_colors);
                }

                send_domain_detail($mem_data, $this->data['adminsite_setting']);
                setMsg('success', 'Site Domain has been saved successfully.');
                redirect(ADMIN . '/add_domains', 'refresh');
                exit;
            }
        }
        $this->data['row'] = $this->add_domains_model->get_row_where(array('site_id' => $this->uri->segment('4')));
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }

    function delete($id)
    {
        $id = intval($id);
        if ($row = $this->add_domains_model->get_row($id)) {
            $this->add_domains_model->delete($this->uri->segment('4'));
            // $this->master->delete_where('sub_add_domains', array('ser_id' => $this->uri->segment('4')));

            setMsg('success', 'Site Domain has been deleted successfully.');
            redirect(ADMIN . '/add_domains', 'refresh');
            exit;
        } else
            show_404();
    }

    function remove_file($id)
    {
        $arr = $this->add_domains_model->get_row($id);

        $filepath = "./" . UPLOAD_PATH . "/add_domains/" . $arr->icon;
        $filepath_thumb = "./" . UPLOAD_PATH . "/add_domains/thumb_" . $arr->icon;
        if (is_file($filepath)) {
            unlink($filepath);
        }
        if (is_file($filepath_thumb)) {
            unlink($filepath_thumb);
        }
        return;
    }
}
