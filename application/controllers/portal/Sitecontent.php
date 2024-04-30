<?php
class Sitecontent extends SUBADMIN_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->isLogged();
        // has_access(21);
        $this->table_name = 'sitecontent';
        $this->load->model('page_model');
        $this->subadmin = $this->getActiveSubAdmin();
    }

    public function home()
    {
        $check = $this->page_model->num_rows(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
        // pr($this->db->last_query());
        if (!$check) {
            $this->page_model->save(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
        }
        $this->data['enable_editor'] = TRUE;
        $this->data['pageView'] = SUBADMIN . '/site_home';
        if ($vals = $this->input->post()) {
            $content_row = $this->page_model->get_row_where(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
            if ($content_row && $content_row->code !== null) {
                $content_row = unserialize($content_row->code);
            } else {
                $content_row = array();
            }


            if (!is_array($content_row))
                $content_row = array();
            for ($i = 1; $i <= 10; $i++) {

                if (isset($_FILES["image" . $i]["name"]) && $_FILES["image" . $i]["name"] != "") {

                    $image = upload_file(UPLOAD_PATH . 'images/', 'image' . $i);
                    // pr($image);
                    if (!empty($image['file_name'])) {
                        // pr($image);

                        // if ($i == 1) {
                        //     generate_thumb(UPLOAD_PATH . "images/", UPLOAD_PATH . "images/", $image['file_name'], 1000, 'thumb_');
                        // } else {
                        //     generate_thumb(UPLOAD_PATH . "images/", UPLOAD_PATH . "images/", $image['file_name'], 400, 'thumb_');
                        // }
                        // pr($image);


                        if (isset($content_row['image' . $i]))
                            $this->remove_file(UPLOAD_PATH . "images/" . $content_row['image' . $i]);
                        $vals['image' . $i] = $image['file_name'];
                    }
                }
            }

            $data = serialize(array_merge($content_row, $vals));
            $this->page_model->save(array('code' => $data, 'site_id' => $this->subadmin->site_id), 'ckey', $this->uri->segment(3), $this->subadmin->site_id);
            setMsg('success', 'Settings updated successfully !');
            redirect(SUBADMIN . "/sitecontent/" . $this->uri->segment(3));
            exit;
        }

        $this->data['row'] = $this->page_model->get_row_where(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
        if ($this->data['row'] && isset($this->data['row']->code) && $this->data['row']->code !== null) {
            $this->data['row'] = unserialize($this->data['row']->code);
        } else {
            $this->data['row'] = array();
        }
        // $this->data['row'] = unserialize($this->data['row']->code);
        $this->load->view(SUBADMIN . '/includes/siteMaster', $this->data);
    }



    public function contact_us()
    {
        $check = $this->page_model->num_rows(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
        // pr($this->db->last_query());
        if (!$check) {
            $this->page_model->save(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
        }
        $this->data['enable_editor'] = TRUE;
        $this->data['pageView'] = SUBADMIN . '/site_contact_us';
        if ($vals = $this->input->post()) {
            $content_row = $this->page_model->get_row_where(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
            if ($content_row && $content_row->code !== null) {
                $content_row = unserialize($content_row->code);
            } else {
                $content_row = array();
            }


            if (!is_array($content_row))
                $content_row = array();

            $data = serialize(array_merge($content_row, $vals));
            $this->page_model->save(array('code' => $data, 'site_id' => $this->subadmin->site_id), 'ckey', $this->uri->segment(3), $this->subadmin->site_id);
            setMsg('success', 'Settings updated successfully !');
            redirect(SUBADMIN . "/sitecontent/" . $this->uri->segment(3));
            exit;
        }

        $this->data['row'] = $this->page_model->get_row_where(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
        if ($this->data['row'] && isset($this->data['row']->code) && $this->data['row']->code !== null) {
            $this->data['row'] = unserialize($this->data['row']->code);
        } else {
            $this->data['row'] = array();
        }
        // $this->data['row'] = unserialize($this->data['row']->code);
        $this->load->view(SUBADMIN . '/includes/siteMaster', $this->data);
    }

    public function code()
    {

        $check = $this->page_model->num_rows(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
        // pr($this->db->last_query());
        if (!$check) {
            $this->page_model->save(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
        }
        $this->data['enable_editor'] = TRUE;
        $this->data['pageView'] = SUBADMIN . '/site_code';
        if ($vals = $this->input->post()) {
            $content_row = $this->page_model->get_row_where(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
            if ($content_row && $content_row->code !== null) {
                $content_row = unserialize($content_row->code);
            } else {
                $content_row = array();
            }


            if (!is_array($content_row))
                $content_row = array();
            for ($i = 1; $i <= 10; $i++) {

                if (isset($_FILES["image" . $i]["name"]) && $_FILES["image" . $i]["name"] != "") {

                    $image = upload_file(UPLOAD_PATH . 'images/', 'image' . $i);
                    // pr($image);
                    if (!empty($image['file_name'])) {
                        // pr($image);

                        // if ($i == 1) {
                        //     generate_thumb(UPLOAD_PATH . "images/", UPLOAD_PATH . "images/", $image['file_name'], 1000, 'thumb_');
                        // } else {
                        //     generate_thumb(UPLOAD_PATH . "images/", UPLOAD_PATH . "images/", $image['file_name'], 400, 'thumb_');
                        // }
                        // pr($image);


                        if (isset($content_row['image' . $i]))
                            $this->remove_file(UPLOAD_PATH . "images/" . $content_row['image' . $i]);
                        $vals['image' . $i] = $image['file_name'];
                    }
                }
            }

            $data = serialize(array_merge($content_row, $vals));
            $this->page_model->save(array('code' => $data, 'site_id' => $this->subadmin->site_id), 'ckey', $this->uri->segment(3), $this->subadmin->site_id);
            setMsg('success', 'Settings updated successfully !');
            redirect(SUBADMIN . "/sitecontent/" . $this->uri->segment(3));
            exit;
        }

        $this->data['row'] = $this->page_model->get_row_where(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
        if ($this->data['row'] && isset($this->data['row']->code) && $this->data['row']->code !== null) {
            $this->data['row'] = unserialize($this->data['row']->code);
        } else {
            $this->data['row'] = array();
        }
        // $this->data['row'] = unserialize($this->data['row']->code);
        $this->load->view(SUBADMIN . '/includes/siteMaster', $this->data);
    }
    public function inventory()
    {

        $check = $this->page_model->num_rows(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
        // pr($this->db->last_query());
        if (!$check) {
            $this->page_model->save(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
        }
        $this->data['enable_editor'] = TRUE;
        $this->data['pageView'] = SUBADMIN . '/site_inventory';
        if ($vals = $this->input->post()) {
            $content_row = $this->page_model->get_row_where(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
            if ($content_row && $content_row->code !== null) {
                $content_row = unserialize($content_row->code);
            } else {
                $content_row = array();
            }


            if (!is_array($content_row))
                $content_row = array();
            for ($i = 1; $i <= 10; $i++) {

                if (isset($_FILES["image" . $i]["name"]) && $_FILES["image" . $i]["name"] != "") {

                    $image = upload_file(UPLOAD_PATH . 'images/', 'image' . $i);
                    // pr($image);
                    if (!empty($image['file_name'])) {
                        // pr($image);

                        // if ($i == 1) {
                        //     generate_thumb(UPLOAD_PATH . "images/", UPLOAD_PATH . "images/", $image['file_name'], 1000, 'thumb_');
                        // } else {
                        //     generate_thumb(UPLOAD_PATH . "images/", UPLOAD_PATH . "images/", $image['file_name'], 400, 'thumb_');
                        // }
                        // pr($image);


                        if (isset($content_row['image' . $i]))
                            $this->remove_file(UPLOAD_PATH . "images/" . $content_row['image' . $i]);
                        $vals['image' . $i] = $image['file_name'];
                    }
                }
            }

            $data = serialize(array_merge($content_row, $vals));
            $this->page_model->save(array('code' => $data, 'site_id' => $this->subadmin->site_id), 'ckey', $this->uri->segment(3), $this->subadmin->site_id);
            setMsg('success', 'Settings updated successfully !');
            redirect(SUBADMIN . "/sitecontent/" . $this->uri->segment(3));
            exit;
        }

        $this->data['row'] = $this->page_model->get_row_where(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
        if ($this->data['row'] && isset($this->data['row']->code) && $this->data['row']->code !== null) {
            $this->data['row'] = unserialize($this->data['row']->code);
        } else {
            $this->data['row'] = array();
        }
        // $this->data['row'] = unserialize($this->data['row']->code);
        $this->load->view(SUBADMIN . '/includes/siteMaster', $this->data);
    }
    public function generic()
    {

        $check = $this->page_model->num_rows(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
        // pr($this->db->last_query());
        if (!$check) {
            $this->page_model->save(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
        }
        $this->data['enable_editor'] = TRUE;
        $this->data['pageView'] = SUBADMIN . '/site_generic';
        if ($vals = $this->input->post()) {
            $content_row = $this->page_model->get_row_where(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
            if ($content_row && $content_row->code !== null) {
                $content_row = unserialize($content_row->code);
            } else {
                $content_row = array();
            }


            if (!is_array($content_row))
                $content_row = array();
            for ($i = 1; $i <= 10; $i++) {

                if (isset($_FILES["image" . $i]["name"]) && $_FILES["image" . $i]["name"] != "") {

                    $image = upload_file(UPLOAD_PATH . 'images/', 'image' . $i);
                    // pr($image);
                    if (!empty($image['file_name'])) {
                        // pr($image);

                        // if ($i == 1) {
                        //     generate_thumb(UPLOAD_PATH . "images/", UPLOAD_PATH . "images/", $image['file_name'], 1000, 'thumb_');
                        // } else {
                        //     generate_thumb(UPLOAD_PATH . "images/", UPLOAD_PATH . "images/", $image['file_name'], 400, 'thumb_');
                        // }
                        // pr($image);


                        if (isset($content_row['image' . $i]))
                            $this->remove_file(UPLOAD_PATH . "images/" . $content_row['image' . $i]);
                        $vals['image' . $i] = $image['file_name'];
                    }
                }
            }

            $data = serialize(array_merge($content_row, $vals));
            $this->page_model->save(array('code' => $data, 'site_id' => $this->subadmin->site_id), 'ckey', $this->uri->segment(3), $this->subadmin->site_id);
            setMsg('success', 'Settings updated successfully !');
            redirect(SUBADMIN . "/sitecontent/" . $this->uri->segment(3));
            exit;
        }

        $this->data['row'] = $this->page_model->get_row_where(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
        if ($this->data['row'] && isset($this->data['row']->code) && $this->data['row']->code !== null) {
            $this->data['row'] = unserialize($this->data['row']->code);
        } else {
            $this->data['row'] = array();
        }
        // $this->data['row'] = unserialize($this->data['row']->code);
        $this->load->view(SUBADMIN . '/includes/siteMaster', $this->data);
    }
    public function photo_grade()
    {

        $check = $this->page_model->num_rows(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
        // pr($this->db->last_query());
        if (!$check) {
            $this->page_model->save(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
        }
        $this->data['enable_editor'] = TRUE;
        $this->data['pageView'] = SUBADMIN . '/site_photo_grade';
        if ($vals = $this->input->post()) {
            $content_row = $this->page_model->get_row_where(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
            if ($content_row && $content_row->code !== null) {
                $content_row = unserialize($content_row->code);
            } else {
                $content_row = array();
            }


            if (!is_array($content_row))
                $content_row = array();
            for ($i = 1; $i <= 10; $i++) {

                if (isset($_FILES["image" . $i]["name"]) && $_FILES["image" . $i]["name"] != "") {

                    $image = upload_file(UPLOAD_PATH . 'images/', 'image' . $i);
                    // pr($image);
                    if (!empty($image['file_name'])) {
                        // pr($image);

                        // if ($i == 1) {
                        //     generate_thumb(UPLOAD_PATH . "images/", UPLOAD_PATH . "images/", $image['file_name'], 1000, 'thumb_');
                        // } else {
                        //     generate_thumb(UPLOAD_PATH . "images/", UPLOAD_PATH . "images/", $image['file_name'], 400, 'thumb_');
                        // }
                        // pr($image);


                        if (isset($content_row['image' . $i]))
                            $this->remove_file(UPLOAD_PATH . "images/" . $content_row['image' . $i]);
                        $vals['image' . $i] = $image['file_name'];
                    }
                }
            }

            $data = serialize(array_merge($content_row, $vals));
            $this->page_model->save(array('code' => $data, 'site_id' => $this->subadmin->site_id), 'ckey', $this->uri->segment(3), $this->subadmin->site_id);
            setMsg('success', 'Settings updated successfully !');
            redirect(SUBADMIN . "/sitecontent/" . $this->uri->segment(3));
            exit;
        }

        $this->data['row'] = $this->page_model->get_row_where(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
        if ($this->data['row'] && isset($this->data['row']->code) && $this->data['row']->code !== null) {
            $this->data['row'] = unserialize($this->data['row']->code);
        } else {
            $this->data['row'] = array();
        }
        // $this->data['row'] = unserialize($this->data['row']->code);
        $this->load->view(SUBADMIN . '/includes/siteMaster', $this->data);
    }
    public function inventory_detail()
    {

        $check = $this->page_model->num_rows(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
        // pr($this->db->last_query());
        if (!$check) {
            $this->page_model->save(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
        }
        $this->data['enable_editor'] = TRUE;
        $this->data['pageView'] = SUBADMIN . '/site_inventory_detail';
        if ($vals = $this->input->post()) {
            $content_row = $this->page_model->get_row_where(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
            if ($content_row && $content_row->code !== null) {
                $content_row = unserialize($content_row->code);
            } else {
                $content_row = array();
            }


            if (!is_array($content_row))
                $content_row = array();
            for ($i = 1; $i <= 10; $i++) {

                if (isset($_FILES["image" . $i]["name"]) && $_FILES["image" . $i]["name"] != "") {

                    $image = upload_file(UPLOAD_PATH . 'images/', 'image' . $i);
                    // pr($image);
                    if (!empty($image['file_name'])) {
                        // pr($image);

                        // if ($i == 1) {
                        //     generate_thumb(UPLOAD_PATH . "images/", UPLOAD_PATH . "images/", $image['file_name'], 1000, 'thumb_');
                        // } else {
                        //     generate_thumb(UPLOAD_PATH . "images/", UPLOAD_PATH . "images/", $image['file_name'], 400, 'thumb_');
                        // }
                        // pr($image);


                        if (isset($content_row['image' . $i]))
                            $this->remove_file(UPLOAD_PATH . "images/" . $content_row['image' . $i]);
                        $vals['image' . $i] = $image['file_name'];
                    }
                }
            }

            $data = serialize(array_merge($content_row, $vals));
            $this->page_model->save(array('code' => $data, 'site_id' => $this->subadmin->site_id), 'ckey', $this->uri->segment(3), $this->subadmin->site_id);
            setMsg('success', 'Settings updated successfully !');
            redirect(SUBADMIN . "/sitecontent/" . $this->uri->segment(3));
            exit;
        }

        $this->data['row'] = $this->page_model->get_row_where(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
        if ($this->data['row'] && isset($this->data['row']->code) && $this->data['row']->code !== null) {
            $this->data['row'] = unserialize($this->data['row']->code);
        } else {
            $this->data['row'] = array();
        }
        // $this->data['row'] = unserialize($this->data['row']->code);
        $this->load->view(SUBADMIN . '/includes/siteMaster', $this->data);
    }
    public function code_detail()
    {

        $check = $this->page_model->num_rows(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
        // pr($this->db->last_query());
        if (!$check) {
            $this->page_model->save(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
        }
        $this->data['enable_editor'] = TRUE;
        $this->data['pageView'] = SUBADMIN . '/site_code_detail';
        if ($vals = $this->input->post()) {
            $content_row = $this->page_model->get_row_where(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
            if ($content_row && $content_row->code !== null) {
                $content_row = unserialize($content_row->code);
            } else {
                $content_row = array();
            }


            if (!is_array($content_row))
                $content_row = array();
            for ($i = 1; $i <= 10; $i++) {

                if (isset($_FILES["image" . $i]["name"]) && $_FILES["image" . $i]["name"] != "") {

                    $image = upload_file(UPLOAD_PATH . 'images/', 'image' . $i);
                    // pr($image);
                    if (!empty($image['file_name'])) {
                        // pr($image);

                        // if ($i == 1) {
                        //     generate_thumb(UPLOAD_PATH . "images/", UPLOAD_PATH . "images/", $image['file_name'], 1000, 'thumb_');
                        // } else {
                        //     generate_thumb(UPLOAD_PATH . "images/", UPLOAD_PATH . "images/", $image['file_name'], 400, 'thumb_');
                        // }
                        // pr($image);


                        if (isset($content_row['image' . $i]))
                            $this->remove_file(UPLOAD_PATH . "images/" . $content_row['image' . $i]);
                        $vals['image' . $i] = $image['file_name'];
                    }
                }
            }

            $data = serialize(array_merge($content_row, $vals));
            $this->page_model->save(array('code' => $data, 'site_id' => $this->subadmin->site_id), 'ckey', $this->uri->segment(3), $this->subadmin->site_id);
            setMsg('success', 'Settings updated successfully !');
            redirect(SUBADMIN . "/sitecontent/" . $this->uri->segment(3));
            exit;
        }

        $this->data['row'] = $this->page_model->get_row_where(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
        if ($this->data['row'] && isset($this->data['row']->code) && $this->data['row']->code !== null) {
            $this->data['row'] = unserialize($this->data['row']->code);
        } else {
            $this->data['row'] = array();
        }
        // $this->data['row'] = unserialize($this->data['row']->code);
        $this->load->view(SUBADMIN . '/includes/siteMaster', $this->data);
    }
    public function generic_detail()
    {

        $check = $this->page_model->num_rows(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
        // pr($this->db->last_query());
        if (!$check) {
            $this->page_model->save(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
        }
        $this->data['enable_editor'] = TRUE;
        $this->data['pageView'] = SUBADMIN . '/site_generic_detail';
        if ($vals = $this->input->post()) {
            $content_row = $this->page_model->get_row_where(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
            if ($content_row && $content_row->code !== null) {
                $content_row = unserialize($content_row->code);
            } else {
                $content_row = array();
            }


            if (!is_array($content_row))
                $content_row = array();
            for ($i = 1; $i <= 10; $i++) {

                if (isset($_FILES["image" . $i]["name"]) && $_FILES["image" . $i]["name"] != "") {

                    $image = upload_file(UPLOAD_PATH . 'images/', 'image' . $i);
                    // pr($image);
                    if (!empty($image['file_name'])) {
                        // pr($image);

                        // if ($i == 1) {
                        //     generate_thumb(UPLOAD_PATH . "images/", UPLOAD_PATH . "images/", $image['file_name'], 1000, 'thumb_');
                        // } else {
                        //     generate_thumb(UPLOAD_PATH . "images/", UPLOAD_PATH . "images/", $image['file_name'], 400, 'thumb_');
                        // }
                        // pr($image);


                        if (isset($content_row['image' . $i]))
                            $this->remove_file(UPLOAD_PATH . "images/" . $content_row['image' . $i]);
                        $vals['image' . $i] = $image['file_name'];
                    }
                }
            }

            $data = serialize(array_merge($content_row, $vals));
            $this->page_model->save(array('code' => $data, 'site_id' => $this->subadmin->site_id), 'ckey', $this->uri->segment(3), $this->subadmin->site_id);
            setMsg('success', 'Settings updated successfully !');
            redirect(SUBADMIN . "/sitecontent/" . $this->uri->segment(3));
            exit;
        }

        $this->data['row'] = $this->page_model->get_row_where(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
        if ($this->data['row'] && isset($this->data['row']->code) && $this->data['row']->code !== null) {
            $this->data['row'] = unserialize($this->data['row']->code);
        } else {
            $this->data['row'] = array();
        }
        // $this->data['row'] = unserialize($this->data['row']->code);
        $this->load->view(SUBADMIN . '/includes/siteMaster', $this->data);
    }
    public function photo_detail()
    {

        $check = $this->page_model->num_rows(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
        // pr($this->db->last_query());
        if (!$check) {
            $this->page_model->save(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
        }
        $this->data['enable_editor'] = TRUE;
        $this->data['pageView'] = SUBADMIN . '/site_photo_detail';
        if ($vals = $this->input->post()) {
            $content_row = $this->page_model->get_row_where(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
            if ($content_row && $content_row->code !== null) {
                $content_row = unserialize($content_row->code);
            } else {
                $content_row = array();
            }


            if (!is_array($content_row))
                $content_row = array();
            for ($i = 1; $i <= 10; $i++) {

                if (isset($_FILES["image" . $i]["name"]) && $_FILES["image" . $i]["name"] != "") {

                    $image = upload_file(UPLOAD_PATH . 'images/', 'image' . $i);
                    // pr($image);
                    if (!empty($image['file_name'])) {
                        // pr($image);

                        // if ($i == 1) {
                        //     generate_thumb(UPLOAD_PATH . "images/", UPLOAD_PATH . "images/", $image['file_name'], 1000, 'thumb_');
                        // } else {
                        //     generate_thumb(UPLOAD_PATH . "images/", UPLOAD_PATH . "images/", $image['file_name'], 400, 'thumb_');
                        // }
                        // pr($image);


                        if (isset($content_row['image' . $i]))
                            $this->remove_file(UPLOAD_PATH . "images/" . $content_row['image' . $i]);
                        $vals['image' . $i] = $image['file_name'];
                    }
                }
            }

            $data = serialize(array_merge($content_row, $vals));
            $this->page_model->save(array('code' => $data, 'site_id' => $this->subadmin->site_id), 'ckey', $this->uri->segment(3), $this->subadmin->site_id);
            setMsg('success', 'Settings updated successfully !');
            redirect(SUBADMIN . "/sitecontent/" . $this->uri->segment(3));
            exit;
        }

        $this->data['row'] = $this->page_model->get_row_where(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
        if ($this->data['row'] && isset($this->data['row']->code) && $this->data['row']->code !== null) {
            $this->data['row'] = unserialize($this->data['row']->code);
        } else {
            $this->data['row'] = array();
        }
        // $this->data['row'] = unserialize($this->data['row']->code);
        $this->load->view(SUBADMIN . '/includes/siteMaster', $this->data);
    }
    public function close_detail()
    {

        $check = $this->page_model->num_rows(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
        // pr($this->db->last_query());
        if (!$check) {
            $this->page_model->save(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
        }
        $this->data['enable_editor'] = TRUE;
        $this->data['pageView'] = SUBADMIN . '/site_close_detail';
        if ($vals = $this->input->post()) {
            $content_row = $this->page_model->get_row_where(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
            if ($content_row && $content_row->code !== null) {
                $content_row = unserialize($content_row->code);
            } else {
                $content_row = array();
            }


            if (!is_array($content_row))
                $content_row = array();
            for ($i = 1; $i <= 10; $i++) {

                if (isset($_FILES["image" . $i]["name"]) && $_FILES["image" . $i]["name"] != "") {

                    $image = upload_file(UPLOAD_PATH . 'images/', 'image' . $i);
                    // pr($image);
                    if (!empty($image['file_name'])) {
                        // pr($image);

                        // if ($i == 1) {
                        //     generate_thumb(UPLOAD_PATH . "images/", UPLOAD_PATH . "images/", $image['file_name'], 1000, 'thumb_');
                        // } else {
                        //     generate_thumb(UPLOAD_PATH . "images/", UPLOAD_PATH . "images/", $image['file_name'], 400, 'thumb_');
                        // }
                        // pr($image);


                        if (isset($content_row['image' . $i]))
                            $this->remove_file(UPLOAD_PATH . "images/" . $content_row['image' . $i]);
                        $vals['image' . $i] = $image['file_name'];
                    }
                }
            }

            $data = serialize(array_merge($content_row, $vals));
            $this->page_model->save(array('code' => $data, 'site_id' => $this->subadmin->site_id), 'ckey', $this->uri->segment(3), $this->subadmin->site_id);
            setMsg('success', 'Settings updated successfully !');
            redirect(SUBADMIN . "/sitecontent/" . $this->uri->segment(3));
            exit;
        }

        $this->data['row'] = $this->page_model->get_row_where(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
        if ($this->data['row'] && isset($this->data['row']->code) && $this->data['row']->code !== null) {
            $this->data['row'] = unserialize($this->data['row']->code);
        } else {
            $this->data['row'] = array();
        }
        // $this->data['row'] = unserialize($this->data['row']->code);
        $this->load->view(SUBADMIN . '/includes/siteMaster', $this->data);
    }



    public function signup()
    {

        $check = $this->page_model->num_rows(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
        // pr($this->db->last_query());
        if (!$check) {
            $this->page_model->save(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
        }
        $this->data['enable_editor'] = TRUE;
        $this->data['pageView'] = SUBADMIN . '/site_signup';
        if ($vals = $this->input->post()) {
            $content_row = $this->page_model->get_row_where(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
            if ($content_row && $content_row->code !== null) {
                $content_row = unserialize($content_row->code);
            } else {
                $content_row = array();
            }


            if (!is_array($content_row))
                $content_row = array();
            for ($i = 1; $i <= 10; $i++) {

                if (isset($_FILES["image" . $i]["name"]) && $_FILES["image" . $i]["name"] != "") {

                    $image = upload_file(UPLOAD_PATH . 'images/', 'image' . $i);
                    // pr($image);
                    if (!empty($image['file_name'])) {
                        // pr($image);

                        // if ($i == 1) {
                        //     generate_thumb(UPLOAD_PATH . "images/", UPLOAD_PATH . "images/", $image['file_name'], 1000, 'thumb_');
                        // } else {
                        //     generate_thumb(UPLOAD_PATH . "images/", UPLOAD_PATH . "images/", $image['file_name'], 400, 'thumb_');
                        // }
                        // pr($image);


                        if (isset($content_row['image' . $i]))
                            $this->remove_file(UPLOAD_PATH . "images/" . $content_row['image' . $i]);
                        $vals['image' . $i] = $image['file_name'];
                    }
                }
            }

            $data = serialize(array_merge($content_row, $vals));
            $this->page_model->save(array('code' => $data, 'site_id' => $this->subadmin->site_id), 'ckey', $this->uri->segment(3), $this->subadmin->site_id);
            setMsg('success', 'Settings updated successfully !');
            redirect(SUBADMIN . "/sitecontent/" . $this->uri->segment(3));
            exit;
        }

        $this->data['row'] = $this->page_model->get_row_where(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
        if ($this->data['row'] && isset($this->data['row']->code) && $this->data['row']->code !== null) {
            $this->data['row'] = unserialize($this->data['row']->code);
        } else {
            $this->data['row'] = array();
        }
        // $this->data['row'] = unserialize($this->data['row']->code);
        $this->load->view(SUBADMIN . '/includes/siteMaster', $this->data);
    }

    public function login()
    {

        $check = $this->page_model->num_rows(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
        // pr($this->db->last_query());
        if (!$check) {
            $this->page_model->save(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
        }
        $this->data['enable_editor'] = TRUE;
        $this->data['pageView'] = SUBADMIN . '/site_signin';
        if ($vals = $this->input->post()) {
            $content_row = $this->page_model->get_row_where(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
            if ($content_row && $content_row->code !== null) {
                $content_row = unserialize($content_row->code);
            } else {
                $content_row = array();
            }


            if (!is_array($content_row))
                $content_row = array();
            for ($i = 1; $i <= 10; $i++) {

                if (isset($_FILES["image" . $i]["name"]) && $_FILES["image" . $i]["name"] != "") {

                    $image = upload_file(UPLOAD_PATH . 'images/', 'image' . $i);
                    // pr($image);
                    if (!empty($image['file_name'])) {
                        // pr($image);

                        // if ($i == 1) {
                        //     generate_thumb(UPLOAD_PATH . "images/", UPLOAD_PATH . "images/", $image['file_name'], 1000, 'thumb_');
                        // } else {
                        //     generate_thumb(UPLOAD_PATH . "images/", UPLOAD_PATH . "images/", $image['file_name'], 400, 'thumb_');
                        // }
                        // pr($image);


                        if (isset($content_row['image' . $i]))
                            $this->remove_file(UPLOAD_PATH . "images/" . $content_row['image' . $i]);
                        $vals['image' . $i] = $image['file_name'];
                    }
                }
            }

            $data = serialize(array_merge($content_row, $vals));
            $this->page_model->save(array('code' => $data, 'site_id' => $this->subadmin->site_id), 'ckey', $this->uri->segment(3), $this->subadmin->site_id);
            setMsg('success', 'Settings updated successfully !');
            redirect(SUBADMIN . "/sitecontent/" . $this->uri->segment(3));
            exit;
        }

        $this->data['row'] = $this->page_model->get_row_where(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
        if ($this->data['row'] && isset($this->data['row']->code) && $this->data['row']->code !== null) {
            $this->data['row'] = unserialize($this->data['row']->code);
        } else {
            $this->data['row'] = array();
        }
        // $this->data['row'] = unserialize($this->data['row']->code);
        $this->load->view(SUBADMIN . '/includes/siteMaster', $this->data);
    }

    public function forgot_password()
    {
        $check = $this->page_model->num_rows(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
        // pr($this->db->last_query());
        if (!$check) {
            $this->page_model->save(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
        }
        $this->data['enable_editor'] = TRUE;
        $this->data['pageView'] = SUBADMIN . '/site_forgot_password';
        if ($vals = $this->input->post()) {
            $content_row = $this->page_model->get_row_where(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
            if ($content_row && $content_row->code !== null) {
                $content_row = unserialize($content_row->code);
            } else {
                $content_row = array();
            }


            if (!is_array($content_row))
                $content_row = array();
            for ($i = 1; $i <= 10; $i++) {

                if (isset($_FILES["image" . $i]["name"]) && $_FILES["image" . $i]["name"] != "") {

                    $image = upload_file(UPLOAD_PATH . 'images/', 'image' . $i);
                    // pr($image);
                    if (!empty($image['file_name'])) {
                        // pr($image);

                        // if ($i == 1) {
                        //     generate_thumb(UPLOAD_PATH . "images/", UPLOAD_PATH . "images/", $image['file_name'], 1000, 'thumb_');
                        // } else {
                        //     generate_thumb(UPLOAD_PATH . "images/", UPLOAD_PATH . "images/", $image['file_name'], 400, 'thumb_');
                        // }
                        // pr($image);


                        if (isset($content_row['image' . $i]))
                            $this->remove_file(UPLOAD_PATH . "images/" . $content_row['image' . $i]);
                        $vals['image' . $i] = $image['file_name'];
                    }
                }
            }

            $data = serialize(array_merge($content_row, $vals));
            $this->page_model->save(array('code' => $data, 'site_id' => $this->subadmin->site_id), 'ckey', $this->uri->segment(3), $this->subadmin->site_id);
            setMsg('success', 'Settings updated successfully !');
            redirect(SUBADMIN . "/sitecontent/" . $this->uri->segment(3));
            exit;
        }

        $this->data['row'] = $this->page_model->get_row_where(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
        if ($this->data['row'] && isset($this->data['row']->code) && $this->data['row']->code !== null) {
            $this->data['row'] = unserialize($this->data['row']->code);
        } else {
            $this->data['row'] = array();
        }
        // $this->data['row'] = unserialize($this->data['row']->code);
        $this->load->view(SUBADMIN . '/includes/siteMaster', $this->data);
    }

    public function email_verify()
    {
        $check = $this->page_model->num_rows(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
        // pr($this->db->last_query());
        if (!$check) {
            $this->page_model->save(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
        }
        $this->data['enable_editor'] = TRUE;
        $this->data['pageView'] = SUBADMIN . '/site_email_verify';
        if ($vals = $this->input->post()) {
            $content_row = $this->page_model->get_row_where(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
            if ($content_row && $content_row->code !== null) {
                $content_row = unserialize($content_row->code);
            } else {
                $content_row = array();
            }


            if (!is_array($content_row))
                $content_row = array();
            for ($i = 1; $i <= 10; $i++) {

                if (isset($_FILES["image" . $i]["name"]) && $_FILES["image" . $i]["name"] != "") {

                    $image = upload_file(UPLOAD_PATH . 'images/', 'image' . $i);
                    // pr($image);
                    if (!empty($image['file_name'])) {
                        // pr($image);

                        // if ($i == 1) {
                        //     generate_thumb(UPLOAD_PATH . "images/", UPLOAD_PATH . "images/", $image['file_name'], 1000, 'thumb_');
                        // } else {
                        //     generate_thumb(UPLOAD_PATH . "images/", UPLOAD_PATH . "images/", $image['file_name'], 400, 'thumb_');
                        // }
                        // pr($image);


                        if (isset($content_row['image' . $i]))
                            $this->remove_file(UPLOAD_PATH . "images/" . $content_row['image' . $i]);
                        $vals['image' . $i] = $image['file_name'];
                    }
                }
            }

            $data = serialize(array_merge($content_row, $vals));
            $this->page_model->save(array('code' => $data, 'site_id' => $this->subadmin->site_id), 'ckey', $this->uri->segment(3), $this->subadmin->site_id);
            setMsg('success', 'Settings updated successfully !');
            redirect(SUBADMIN . "/sitecontent/" . $this->uri->segment(3));
            exit;
        }

        $this->data['row'] = $this->page_model->get_row_where(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
        if ($this->data['row'] && isset($this->data['row']->code) && $this->data['row']->code !== null) {
            $this->data['row'] = unserialize($this->data['row']->code);
        } else {
            $this->data['row'] = array();
        }
        // $this->data['row'] = unserialize($this->data['row']->code);
        $this->load->view(SUBADMIN . '/includes/siteMaster', $this->data);
    }

    public function change_password()
    {

        $check = $this->page_model->num_rows(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
        // pr($this->db->last_query());
        if (!$check) {
            $this->page_model->save(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
        }
        $this->data['enable_editor'] = TRUE;
        $this->data['pageView'] = SUBADMIN . '/site_reset_password';
        if ($vals = $this->input->post()) {
            $content_row = $this->page_model->get_row_where(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
            if ($content_row && $content_row->code !== null) {
                $content_row = unserialize($content_row->code);
            } else {
                $content_row = array();
            }


            if (!is_array($content_row))
                $content_row = array();
            for ($i = 1; $i <= 10; $i++) {

                if (isset($_FILES["image" . $i]["name"]) && $_FILES["image" . $i]["name"] != "") {

                    $image = upload_file(UPLOAD_PATH . 'images/', 'image' . $i);
                    // pr($image);
                    if (!empty($image['file_name'])) {
                        // pr($image);

                        // if ($i == 1) {
                        //     generate_thumb(UPLOAD_PATH . "images/", UPLOAD_PATH . "images/", $image['file_name'], 1000, 'thumb_');
                        // } else {
                        //     generate_thumb(UPLOAD_PATH . "images/", UPLOAD_PATH . "images/", $image['file_name'], 400, 'thumb_');
                        // }
                        // pr($image);


                        if (isset($content_row['image' . $i]))
                            $this->remove_file(UPLOAD_PATH . "images/" . $content_row['image' . $i]);
                        $vals['image' . $i] = $image['file_name'];
                    }
                }
            }

            $data = serialize(array_merge($content_row, $vals));
            $this->page_model->save(array('code' => $data, 'site_id' => $this->subadmin->site_id), 'ckey', $this->uri->segment(3), $this->subadmin->site_id);
            setMsg('success', 'Settings updated successfully !');
            redirect(SUBADMIN . "/sitecontent/" . $this->uri->segment(3));
            exit;
        }

        $this->data['row'] = $this->page_model->get_row_where(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
        if ($this->data['row'] && isset($this->data['row']->code) && $this->data['row']->code !== null) {
            $this->data['row'] = unserialize($this->data['row']->code);
        } else {
            $this->data['row'] = array();
        }
        // $this->data['row'] = unserialize($this->data['row']->code);
        $this->load->view(SUBADMIN . '/includes/siteMaster', $this->data);
    }

    // public function terms_and_conditions()
    // {


    //     $check = $this->page_model->num_rows(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
    //     // pr($this->db->last_query());
    //     if (!$check) {
    //         $this->page_model->save(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
    //     }
    //     $this->data['enable_editor'] = TRUE;
    //     $this->data['pageView'] = SUBADMIN . '/site_terms_and_conditions';
    //     if ($vals = $this->input->post()) {
    //         $content_row = $this->page_model->get_row_where(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
    //         if ($content_row && $content_row->code !== null) {
    //             $content_row = unserialize($content_row->code);
    //         } else {
    //             $content_row = array();
    //         }


    //         if (!is_array($content_row))
    //             $content_row = array();

    //         $data = serialize(array_merge($content_row, $vals));
    //         $this->page_model->save(array('code' => $data, 'site_id' => $this->subadmin->site_id), 'ckey', $this->uri->segment(3), $this->subadmin->site_id);
    //         setMsg('success', 'Settings updated successfully !');
    //         redirect(SUBADMIN . "/sitecontent/" . $this->uri->segment(3));
    //         exit;
    //     }

    //     $this->data['row'] = $this->page_model->get_row_where(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
    //     if ($this->data['row'] && isset($this->data['row']->code) && $this->data['row']->code !== null) {
    //         $this->data['row'] = unserialize($this->data['row']->code);
    //     } else {
    //         $this->data['row'] = array();
    //     }
    //     // $this->data['row'] = unserialize($this->data['row']->code);
    //     $this->load->view(SUBADMIN . '/includes/siteMaster', $this->data);
    // }



    // public function chk_ckey()
    // {
    //     $check = $this->page_model->num_rows(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
    //     // pr($this->db->last_query());
    //     if (!$check) {
    //         $this->page_model->save(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
    //     }
    //     $this->data['enable_editor'] = TRUE;
    //     $this->data['pageView'] = SUBADMIN . '/site_chk_ckey';
    //     if ($vals = $this->input->post()) {
    //         $content_row = $this->page_model->get_row_where(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
    //         if ($content_row && $content_row->code !== null) {
    //             $content_row = unserialize($content_row->code);
    //         } else {
    //             $content_row = array();
    //         }


    //         if (!is_array($content_row))
    //             $content_row = array();
    //         for ($i = 1; $i <= 10; $i++) {

    //             if (isset($_FILES["image" . $i]["name"]) && $_FILES["image" . $i]["name"] != "") {

    //                 $image = upload_file(UPLOAD_PATH . 'images/', 'image' . $i);
    //                 // pr($image);
    //                 if (!empty($image['file_name'])) {
    //                     // pr($image);

    //                     // if ($i == 1) {
    //                     //     generate_thumb(UPLOAD_PATH . "images/", UPLOAD_PATH . "images/", $image['file_name'], 1000, 'thumb_');
    //                     // } else {
    //                     //     generate_thumb(UPLOAD_PATH . "images/", UPLOAD_PATH . "images/", $image['file_name'], 400, 'thumb_');
    //                     // }
    //                     // pr($image);


    //                     if (isset($content_row['image' . $i]))
    //                         $this->remove_file(UPLOAD_PATH . "images/" . $content_row['image' . $i]);
    //                     $vals['image' . $i] = $image['file_name'];
    //                 }
    //             }
    //         }

    //         $data = serialize(array_merge($content_row, $vals));
    //         $this->page_model->save(array('code' => $data, 'site_id' => $this->subadmin->site_id), 'ckey', $this->uri->segment(3), $this->subadmin->site_id);
    //         setMsg('success', 'Settings updated successfully !');
    //         redirect(SUBADMIN . "/sitecontent/" . $this->uri->segment(3));
    //         exit;
    //     }

    //     $this->data['row'] = $this->page_model->get_row_where(array('ckey' => $this->uri->segment(3), 'site_id' => $this->subadmin->site_id));
    //     if ($this->data['row'] && isset($this->data['row']->code) && $this->data['row']->code !== null) {
    //         $this->data['row'] = unserialize($this->data['row']->code);
    //     } else {
    //         $this->data['row'] = array();
    //     }
    //     // $this->data['row'] = unserialize($this->data['row']->code);
    //     $this->load->view(SUBADMIN . '/includes/siteMaster', $this->data);
    // }



    public function delete()
    {
        $arr = $this->input->post('delete');
        foreach ($arr as $key => $values) {
            $this->master->delete($this->table_name, 'id', $values);
        }
        redirect("admin/sitecontent/slider", 'refresh');
    }

    function remove_file($filepath)
    {
        if (is_file($filepath))
            unlink($filepath);
        return;
    }
}
