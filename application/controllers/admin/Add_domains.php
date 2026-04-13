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
            $exist = $this->master->getRow('add_domains', array('domain_name' => $vals['domain_name']));
            
            if ($exist && $exist->site_id != $this->uri->segment(4)) {
                setMsg('error', 'Domain name already exists.');
                redirect(ADMIN . '/add_domains', 'refresh');
                exit;
            }

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
            

            $vals['site_live_pt_price'] = $this->data['adminsite_setting']->site_live_pt_price;
            $vals['site_live_pd_price'] = $this->data['adminsite_setting']->site_live_pd_price;
            $vals['site_live_rh_price'] = $this->data['adminsite_setting']->site_live_rh_price;

            $vals['site_email'] = $vals['email'];
            $vals['site_noreply_email'] = $this->data['adminsite_setting']->site_noreply_email;
            $vals['site_phone'] = $this->data['adminsite_setting']->site_phone;
            $vals['site_copyright'] = $this->data['adminsite_setting']->site_copyright;
            $vals['site_address'] = $this->data['adminsite_setting']->site_address;
            $vals['site_about'] = $this->data['adminsite_setting']->site_about;


            $id = $this->add_domains_model->save($vals, $this->uri->segment(4));
            if ($id > 0) {

                $chk_row = $this->master->getRows('sitecontent', array('site_id' => $id));
                if (empty($chk_row)) {
                    $site_content = $this->master->getRows('sitecontent', array('site_id' => -1));
                    foreach ($site_content as $site_cont) {
                        $sitecode = unserialize($site_cont->code);
                        $imageMapping = array();
                        for ($i = 1; $i <= 40; $i++) {
                            $image = $sitecode['image' . $i];
                            $sourcePath = FCPATH . 'uploads/images/' . $image;
                            $extension = pathinfo($sourcePath, PATHINFO_EXTENSION);
                            if (file_exists($sourcePath)) {
                                $newFilename = $id . $site_cont->ckey . '_image_' . $i . '.' . $extension;
                                $destinationFolder = FCPATH . 'uploads/images/';
                                $destinationImagePath = $destinationFolder . $newFilename;
                                if (copy($sourcePath, $destinationImagePath)) {
                                    $imageMapping[$image] = $newFilename;
                                }
                              
                            } else {
                                echo "Image $image not found...\n";
                            }
                        }
                        foreach ($imageMapping as $oldImage => $newImage) {
                            $sitecode[array_search($oldImage, $sitecode)] = $newImage;
                        }

                        $serialized_code = serialize($sitecode);
                        $data = array(
                            'site_id' => $id,
                            'ckey' => $site_cont->ckey,
                            'code' => $serialized_code,
                        );

                        $this->master->save("sitecontent", $data);
                    }
                }


                send_domain_detail($mem_data, $this->data['adminsite_setting']);
                setMsg('success', 'Site Domain has been saved successfully.');
                redirect(ADMIN . '/add_domains', 'refresh');
                exit;
            }
        }
        $this->data['row'] = $this->add_domains_model->get_row_where(array('site_id' => $this->uri->segment('4')));
        $this->data['templates'] = $this->master->getRows('templates', array('status' => 1));

        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }

    function delete($id)
    {
        $id = intval($id);
        if ($row = $this->add_domains_model->get_row($id)) {
            $this->add_domains_model->delete($this->uri->segment('4'));
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
