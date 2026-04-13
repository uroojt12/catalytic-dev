<?php

class Account extends MY_Controller

{

    function __construct()

    {
        parent::__construct();
        $this->load->model('member_model');
        $this->load->model('code_model');

        $this->member = $this->getActiveMem();
    }
    function code($page = '')
    {
        if ($this->session->mem_id) {
            $this->member = $this->getActiveMem();
            if ($this->member->mem_verified > 0) {
                // pr('hello');

                if ($page == '') {
                    $page = 1;
                }

                $page = intval($page);
                $per_page = 4;

                $this->data['total_active_codes'] = $this->code_model->num_rows(array('status' => 1, 'type' => 'Code'));
                $this->data['content_row'] = $this->master->getRow('sitecontent', array('ckey' => 'code', 'site_id' => $this->session->web_id));
                $this->data['site_content'] = unserialize($this->data['content_row']->code);
                $this->data['find_code'] = $this->code_model->get_rows(array('status' => 1, 'type' => 'Code'), 0, 16);
                $site_settings = $this->master->getRow("siteadmin", array('site_id' => '1'));
                foreach ($this->data['find_code'] as $row) {
                    $pump_cal_price = calculatedAllPrice($site_settings->site_o_pt_price, $site_settings->site_live_pt_price, $site_settings->site_o_pd_price, $site_settings->site_live_pd_price, $site_settings->site_o_rh_price, $site_settings->site_live_rh_price, $this->session->web_id, $row->id, $this->session->mem_id);
                    // pr($pump_cal_price);
                    $row->total_price = $pump_cal_price;
                    // pr($row->total_price);
                    // if (!empty($this->data['member_data']) && $this->data['member_data']->mem_margin > 0) {
                    //     // pr($this->data['member_data']->mem_margin);
                    //     $margin = $pump_cal_price * ($this->data['member_data']->mem_margin / 100);
                    //     // pr($margin);
                    //     $row->total_price = $pump_cal_price - $margin;
                    //     // pr($row->total_price);
                    // } else {
                    //     // pr($pump_cal_price);
                    //     $row->total_price = $pump_cal_price;
                    //     // pr($row->total_price);

                    // }
                }

                $this->data['sub_site_settings'] = $this->master->getRow("add_domains", array('site_id' => $this->session->web_id));
                $this->data['sup_site_settings'] = $this->master->getRow("siteadmin", array('site_id' => '1'));
                $this->data['all_categories'] = $this->master->getRows("categories", array('status' => 1));

                $this->data['pageView'] = 'pages/code';
                $this->data['footer'] = true;
                $this->data['code_page'] = true;
                $this->load->view("includes/site-master", $this->data);
            } else {
                redirect('email-verification', 'refresh');
            }
        } else {
            redirect('login', 'refresh');
        }
    }
    function dashboard()

    {
        // $q =   $this->isMemLogged($this->session->mem_type);
        if ($this->session->mem_id) {
            if ($this->member->mem_verified > 0) {
                $this->data['member'] = $this->member_model->getMember($this->session->mem_id);
                $this->data['dashboard'] = true;
                $this->data['page_title'] = "dashbooard";
                $this->data['meta_keywords'] = 'dashbooard';
                $this->data['meta_description'] = 'dashbooard';
                $this->data['pageView'] = 'pages/dashboard/profile';
                $this->data['footer'] = true;
                $this->load->view("includes/site-master", $this->data);
            } else {
                redirect('email-verification', 'refresh');
            }
        } else {
            redirect('login', 'refresh');
        }
    }

    function margin()

    {
        // $this->isMemLogged($this->session->mem_type);
        if ($this->session->mem_id) {
            if ($this->member->mem_verified > 0) {
                $this->data['member'] = $this->member_model->getMember($this->session->mem_id);
                $this->data['page_title'] = 'Margin';
                $this->data['meta_keywords'] = 'Margin';
                $this->data['meta_description'] = 'Margin';
                $this->data['pageView'] = 'pages/dashboard/margin';
                $this->data['footer'] = true;
                $this->load->view("includes/site-master", $this->data);
            } else {
                redirect('email-verification', 'refresh');
            }
        } else {
            redirect('login', 'refresh');
        }
    }


    function change_pswd()

    {
        if ($this->session->mem_id) {
            if ($this->member->mem_verified > 0) {
                if ($this->input->post()) {

                    $res = array();
                    $res['hide_msg'] = 0;
                    $res['scroll_to_msg'] = 1;
                    $res['redirect_url'] = 0;
                    $res['status'] = 0;
                    $res['frm_reset'] = 0;

                    $this->form_validation->set_rules('pswd', 'Current Password', 'required');
                    $this->form_validation->set_rules('npswd', 'New Password', 'required');
                    $this->form_validation->set_rules('cpswd', 'Confirm Password', 'required|matches[npswd]');

                    if ($this->form_validation->run() === FALSE) {

                        $res['msg'] = validation_errors();
                    } else {

                        $post = html_escape($this->input->post());
                        $row = $this->member_model->oldPswdCheck($this->member->mem_id, $post['pswd']);

                        if (count($row) > 0) {
                            $ary = array('mem_pswd' => md5($post['npswd']));
                            $this->member_model->save($ary, $this->member->mem_id);
                            $res['msg'] = 'Password successfully updated!';
                            $res['status'] = 1;
                            $res['frm_reset'] = 1;
                            $res['hide_msg'] = 1;
                        } else {

                            $res['msg'] = 'Old Password Does Not Match!';
                        }
                    }

                    exit(json_encode($res));
                }
            } else {
                redirect('email-verification', 'refresh');
            }
        } else {
            redirect('login', 'refresh');
        }
    }


    function profile_settings()

    {

        if ($this->session->mem_id) {
            if ($this->member->mem_verified > 0) {
                if ($this->input->post()) {
                    $res = array();
                    $res['hide_msg'] = 0;
                    $res['scroll_to_msg'] = 1;
                    $res['status'] = 0;
                    $res['frm_reset'] = 0;
                    $res['redirect_url'] = 0;

                    $this->form_validation->set_message('integer', 'Please select a valid {field}');
                    $this->form_validation->set_rules('fname', 'First Name', 'required');
                    $this->form_validation->set_rules('lname', 'Last Name', 'required');
                    // $this->form_validation->set_rules('email', 'Email', 'required');
                    $this->form_validation->set_rules('phone', 'Phone', 'required');
                    if ($this->form_validation->run() === FALSE) {
                        $res['msg'] = validation_errors();
                    } else {

                        $post = html_escape($this->input->post());
                        $chk_member  = $this->member_model->getMember($this->session->mem_id);

                        if (($_FILES["mem_image"]["name"] != "")) {
                            $this->remove_file($this->session->mem_id, 'mem_image');
                            $image = upload_file(UPLOAD_PATH . 'members', 'mem_image');
                            if (!empty($image['file_name'])) {
                                $post['mem_image'] = $image['file_name'];
                            }
                        } else {
                            $post['mem_image'] = $chk_member->mem_image;
                        }
                        $data = array(

                            'mem_fname' => ucfirst($post['fname']),
                            'mem_lname' => ucfirst($post['lname']),
                            // 'mem_email' => ucfirst($post['email']),
                            'mem_phone' => $post['phone'],
                            'mem_image' => $post['mem_image'],
                            'mem_cv' => $post['cv'],

                        );
                        // pr($data);
                        $this->member_model->save($data, $this->session->mem_id);
                        $res['msg'] = 'Profile update successfully!';
                        $res['redirect_url'] = base_url('dashboard');
                        $res['status'] = 1;
                        $res['hide_msg'] = 1;
                    }
                    exit(json_encode($res));
                } else {
                    $this->data['member'] = $this->member_model->getMember($this->session->mem_id);
                    $this->data['dashboard'] = true;
                    $this->data['page_title'] = "profile";
                    $this->data['meta_keywords'] = 'profile';
                    $this->data['meta_description'] = 'profile';
                    $this->data['pageView'] = 'pages/dashboard/profile_settings';
                    $this->data['footer'] = true;
                    $this->load->view('includes/site-master', $this->data);
                }
            } else {
                redirect('email-verification', 'refresh');
            }
        } else {

            redirect('login', 'refresh');
        }
    }

    function remove_file($id, $type = '')
    {
        $arr = $this->member_model->getMember($id);
        $filepath = "./" . SITE_IMAGES . "/members/" . $arr->mem_image;
        if (is_file($filepath)) {
            unlink($filepath);
        }

        return;
    }





    function email_verification()
    {
        // $this->MemLogged();
        if ($this->session->mem_id) {
            if ($this->member->mem_verified == 0) {
                // if ($this->input->post()) {

                //     $res = array();
                //     $res['frm_reset'] = 0;
                //     $res['hide_msg'] = 0;
                //     $res['scroll_to_msg'] = 0;
                //     $res['status'] = 0;
                //     $res['redirect_url'] = 0;
                //     $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
                //     if ($this->form_validation->run() === FALSE) {

                //         $res['msg'] = validation_errors();
                //     } else {

                //         $post = html_escape($this->input->post());
                //         if (!$this->member_model->emailExists($post['email'], $this->session->id)) {
                //             $rando = doEncode($this->session->id . '-' . $post['email']);
                //             $rando = strlen($rando) > 225 ? substr($rando, 0, 225) : $rando;
                //             $this->member_model->save(array('code' => $rando, 'email' => $post['email']), $this->session->id);
                //             $verify_link = site_url('verification/' . $rando);
                //             $mem_data = array('name' => $this->member->fname . ' ' . $this->member->lname, "email" => $post['email'], "link" => $verify_link);
                //             $this->send_site_email($mem_data, 'change_email');
                //             $res['redirect_url'] = ' ';
                //             $res['msg'] = 'Email has been changed successful! Please wait.';
                //             setMsg('info', getSiteText('alert', 'verify_email'));
                //             $res['status'] = 1;
                //             $res['frm_reset'] = 1;
                //             $res['hide_msg'] = 1;
                //         } else {

                //             $res['msg'] = 'Email already exists!';
                //         }
                //     }
                //     exit(json_encode($res));
                // } else {

                $this->data['page_title'] = "Email Verification - " . $this->data['settings']->site_name;
                $this->data['meta_keywords'] = 'Email Verification';
                $this->data['meta_description'] = 'Email Verification';
                $this->data['pageView'] = 'pages/dashboard/verify-email';
                $this->load->view("includes/site-master", $this->data);
                // }
            } else {
                redirect('dashboard', 'refresh');
            }
        } else {
            redirect('login', 'refresh');
        }
    }

    function resend_email()

    {

        // $this->isMemLogged($this->session->mem_type, '', false);

        if ($this->session->mem_id) {

            $res = array();
            $res['hide_msg'] = 0;
            $res['scroll_to_msg'] = 0;
            $res['status'] = 0;
            $res['frm_reset'] = 0;
            $res['redirect_url'] = 0;

            $rando = doEncode($this->session->mem_id . '-' . $this->member->mem_email);
            $rando = strlen($rando) > 225 ? substr($rando, 0, 225) : $rando;
            $this->member_model->save(array('mem_code' => $rando), $this->session->mem_id);
            $verify_link = site_url('verification/' . $rando);

            $mem_data = array('name' => $this->member->mem_fname . ' ' . $this->member->mem_lname, "email" => $this->member->mem_email, "link" => $verify_link);

            $ok = send_site_email($mem_data, 'signup');
            // pr($ok);
            $res['msg'] = $ok ? 'Email sent successfully!' : 'There is an error occurred, Please try again later!';
            $res['status'] = 1;
            $res['hide_msg'] = 1;

            exit(json_encode($res));
        } else {
            redirect('login', 'refresh');
        }
    }

    function notifications()
    {
        // $this->isMemLogged($this->session->mem_type);
        if ($this->session->mem_id) {
            if ($this->member->mem_verified > 0) {
                $vals['read_status'] = 1;
                $this->master->update('notifications', $vals, array('receiver_mem_id' => $this->member->mem_id, 'read_status' => 0));
                $this->data['notifications'] = $this->master->getRows('notifications', array('receiver_mem_id' => $this->member->mem_id), '', '', 'DESC');
                $this->data['page_title'] = 'Notifications';
                $this->data['pageView'] = 'pages/dashboard/notification';
                $this->data['footer'] = true;
                $this->load->view("includes/site-master", $this->data);
            } else {
                redirect('email-verification', 'refresh');
            }
        } else {
            redirect('login', 'refresh');
        }
    }
    function clear_all()
    {
        // $this->isMemLogged($this->session->mem_type);
        if ($this->session->mem_id) {
            if ($this->member->mem_verified > 0) {
                $res = array();
                $notifications = $this->master->getRows('notifications', array('read_status' => 0, 'receiver_mem_id' => $this->member->mem_id));
                if (!empty($notifications)) {
                    foreach ($notifications as $notification) {
                        $vals['read_status'] = 1;
                        $this->master->update('notifications', $vals, array('id' => $notification->id));
                    }
                    $res['status'] = true;
                    exit(json_encode($res));
                }
            } else {
                redirect('email-verification', 'refresh');
            }
        } else {
            redirect('login', 'refresh');
        }
    }
    function notifications_detail($id)
    {
        // $this->isMemLogged($this->session->mem_type);
        if ($this->session->mem_id) {
            if ($this->member->mem_verified > 0) {
                $id = intval($id);

                if (!empty($id) && $this->data['notification_deatil'] = $this->master->getRow('notifications', array('id' => $id))) {
                    // pr($this->data['notification_deatil']);
                    $this->data['page_title'] = 'Notifications Details';
                    $this->data['pageView'] = 'pages/dashboard/notification_detail';
                    $this->data['footer'] = true;
                    $this->load->view("includes/site-master", $this->data);
                } else {
                    show_404();
                }
            } else {
                redirect('email-verification', 'refresh');
            }
        } else {
            redirect('login', 'refresh');
        }
    }


    function add_user_margin()

    {
        $res = array();
        if ($this->session->mem_id) {
            if ($this->member->mem_verified > 0) {
                if ($this->input->post()) {
                    if ($member = $this->master->getRow('members', array('mem_id' => $this->session->mem_id, 'site_id' => $this->session->web_id))) {
                        $this->form_validation->set_rules('mem_margin', 'Margin', 'required');
                        if ($this->form_validation->run() === FALSE) {

                            $res['msg'] = validation_errors();
                        } else {
                            $vals = html_escape($this->input->post());
                            $id = $this->master->save("members", array('mem_margin' => $vals['mem_margin']), 'mem_id', $member->mem_id);
                            if ($id > 0) {
                                $res['msg'] = 'Your Margin has been saved successfully!';
                                $res['status'] = 1;
                                $res['redirect_url'] = base_url('margin');
                            } else {
                                $res['msg'] = 'Technical problem!';
                                $res['status'] = 0;
                            }
                        }
                    } else {
                        show_404();
                    }
                }
                exit(json_encode($res));
            } else {
                redirect('email-verification', 'refresh');
            }
        } else {

            redirect('login', 'refresh');
        }
    }

    // public function margin_check($value)
    // {
    //     if ($value > 0) {
    //         return TRUE;
    //     } else {
    //         $this->form_validation->set_message('margin_check', 'The {field} field must be greater than 0.');
    //         return FALSE;
    //     }
    // }
}
