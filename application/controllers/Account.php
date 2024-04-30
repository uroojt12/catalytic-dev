<?php

class Account extends MY_Controller

{



    function __construct()

    {

        parent::__construct();

        $this->load->model('member_model');

        $this->member = $this->getActiveMem();

        // $this->isMemLogged($this->session->id);
    }



    function dashboard()

    {
        $q =   $this->isMemLogged($this->session->mem_type);
        // pr($q);
        // exit;
        // $this->MemLogged();
        $this->data['member'] = $this->member_model->getMember($this->session->mem_id);

        // pr($this->data['member']);

        $this->data['dashboard'] = true;
        $this->data['page_title'] = "dashbooard";
        $this->data['meta_keywords'] = 'dashbooard';
        $this->data['meta_description'] = 'dashbooard';


        $this->data['pageView'] = 'pages/dashboard/profile';
        $this->data['footer'] = true;
        $this->load->view("includes/site-master", $this->data);
    }


    function change_pswd()

    {
        // $this->isMemLogged($this->session->mem_type);

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
    }



    // public function update_total_points($mem_id)

    // {

    //     $this->member_model->update_total_points($mem_id);

    // }





    function profile_settings()

    {

        // pr("asd");
        // $this->isMemLogged($this->session->mem_type);

        if ($this->session->mem_id) {

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



                    $data = array(

                        'mem_fname' => ucfirst($post['fname']),
                        'mem_lname' => ucfirst($post['lname']),
                        'mem_email' => ucfirst($post['email']),
                        'mem_phone' => $post['phone'],
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

                // pr($this->data);

                $this->data['dashboard'] = true;
                $this->data['page_title'] = "profile";
                $this->data['meta_keywords'] = 'profile';
                $this->data['meta_description'] = 'profile';


                $this->data['pageView'] = 'pages/dashboard/profile_settings';
                $this->data['footer'] = true;
                $this->load->view('includes/site-master', $this->data);
            }
        } else {

            redirect();
        }
    }





    function email_verification()
    {
        // pr('hello');
        // $this->is_email_logged($this->session->mem_type);
        // pr("hi ther");
        if ($this->input->post()) {

            $res = array();
            $res['frm_reset'] = 0;
            $res['hide_msg'] = 0;
            $res['scroll_to_msg'] = 0;
            $res['status'] = 0;
            $res['redirect_url'] = 0;

            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

            if ($this->form_validation->run() === FALSE) {

                $res['msg'] = validation_errors();
            } else {

                $post = html_escape($this->input->post());



                if (!$this->member_model->emailExists($post['email'], $this->session->id)) {

                    // $rando=doEncode(rand(111111, 999999));

                    $rando = doEncode($this->session->id . '-' . $post['email']);
                    $rando = strlen($rando) > 225 ? substr($rando, 0, 225) : $rando;


                    $this->member_model->save(array('code' => $rando, 'email' => $post['email']), $this->session->id);

                    $verify_link = site_url('verification/' . $rando);

                    $mem_data = array('name' => $this->data['mem_data']->fname . ' ' . $this->data['mem_data']->lname, "email" => $post['email'], "link" => $verify_link);

                    $this->send_site_email($mem_data, 'change_email');
                    $res['redirect_url'] = ' ';
                    $res['msg'] = 'Email has been changed successful! Please wait.';
                    setMsg('info', getSiteText('alert', 'verify_email'));

                    $res['status'] = 1;
                    $res['frm_reset'] = 1;
                    $res['hide_msg'] = 1;
                } else {

                    $res['msg'] = 'Email already exists!';
                }
            }
            exit(json_encode($res));
        } else {
            // pr('hi');
            // $this->data['site_content'] = $this->master->getRow('sitecontent', array('type' => 'email_verification'));
            $this->data['page_title'] = "Email Verification - " . $this->data['settings']->site_name;
            $this->data['meta_keywords'] = 'Email Verification';
            $this->data['meta_description'] = 'Email Verification';
            // $this->data['row'] = (array) json_decode($this->data['site_content']->text);
            $this->data['pageView'] = 'pages/dashboard/verify-email';
            $this->load->view("includes/site-master", $this->data);

            // $this->load->view('pages/dashboard/verify-email', $this->data);
        }
    }

    function resend_email()

    {

        $this->isMemLogged($this->session->mem_type, '', false);

        $res = array();
        $res['hide_msg'] = 0;
        $res['scroll_to_msg'] = 0;
        $res['status'] = 0;
        $res['frm_reset'] = 0;
        $res['redirect_url'] = 0;


        $rando = doEncode($this->session->mem_id . '-' . $this->data['mem_data']->mem_email);

        $rando = strlen($rando) > 225 ? substr($rando, 0, 225) : $rando;

        $this->member_model->save(array('mem_code' => $rando), $this->session->mem_id);


        $verify_link = site_url('verification/' . $rando);

        $mem_data = array('name' => $this->data['mem_data']->mem_fname . ' ' . $this->data['mem_data']->mem_lname, "email" => $this->data['mem_data']->mem_email, "link" => $verify_link);

        $ok = send_site_email($mem_data, 'signup');


        $res['msg'] = $ok ? 'Email sent successfully!' : 'There is an error occurred, Please try again later!';
        $res['status'] = 1;
        $res['hide_msg'] = 1;

        exit(json_encode($res));
    }

    function notifications()
    {
        $this->isMemLogged($this->session->mem_type);
        if ($this->session->mem_id) {

            $vals['read_status'] = 1;
            $this->master->update('notifications', $vals, array('receiver_mem_id' => $this->member->mem_id, 'read_status' => 0));

            $this->data['notifications'] = $this->master->getRows('notifications', array('receiver_mem_id' => $this->member->mem_id), '', '', 'DESC');

            $this->data['page_title'] = 'Notifications';
            $this->data['pageView'] = 'pages/dashboard/notification';
            $this->data['footer'] = true;
            $this->load->view("includes/site-master", $this->data);
        } else {
            redirect();
        }
    }
    function clear_all()
    {
        $this->isMemLogged($this->session->mem_type);
        if ($this->session->mem_id) {

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
            redirect();
        }
    }
    function notifications_detail($id)
    {
        $this->isMemLogged($this->session->mem_type);
        if ($this->session->mem_id) {
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
            redirect();
        }
    }
}
