<?php

class Register extends MY_Controller

{





    public function __construct()

    {

        parent::__construct();

        //Do your magic here

        $this->load->model('Member_model');

        $this->member = $this->getActiveMem();
    }


    function signup()
    {

        if ($this->input->post()) {
            $res = array();
            $res['hide_msg'] = 0;
            $res['scroll_to_msg'] = 0;
            $res['frm_reset'] = 0;
            $res['status'] = 0;
            $this->form_validation->set_rules('fname', 'First Name', 'required');
            $this->form_validation->set_rules('lname', 'Last Name', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

            $this->form_validation->set_rules('password', 'Password', 'required');


            $this->form_validation->set_rules('cpswd', 'Confirm Password', 'required|matches[password]');
            // $this->form_validation->set_rules('confirm', 'Confirm', 'required', array('required' => 'Please accept our terms and conditions'));
            if ($this->form_validation->run() === FALSE) {
                $res['msg'] = validation_errors();
            } else {
                $post = html_escape($this->input->post());
                //  pr($post);
                $mem_row = [];
                $mem_row = (array)$this->Member_model->emailExists($post['email']);
                //$str = $this->db->last_query();
                //echo $str;
                //pr($mem_row); 
                // echo count($mem_row);

                //  $mem_row=(array)$mem_row;
                // var_dump($mem_row);
                if ((int)count($mem_row) == 0) {
                    $rando = doEncode(rand(99, 999) . '-' . $post['email']);
                    $rando = strlen($rando) > 225 ? substr($rando, 0, 225) : $rando;
                    $save_data = array(
                        'mem_type' => 'member', 'mem_fname' => ucfirst($post['fname']),
                        'mem_lname' => ucfirst($post['lname']),
                        'mem_email' => $post['email'],
                        'mem_pswd' => md5($post['password']),
                        'mem_code' => $rando,
                        'site_id' => $this->session->web_id,


                        'mem_status' => 1
                    );
                    // pr($save_data);
                    $mem_id = $this->Member_model->save($save_data);
                    $this->session->set_userdata('mem_id', $mem_id);
                    $this->session->set_userdata('mem_type', 'member');

                    $res['msg'] = '<div>We’ve sent link to the email address you entered to verify your account. If you don’t see the email, check your spam folder or email.</div>';
                    $verify_link = site_url('verification/' . $rando);
                    $mem_data = array('name' => ucfirst($post['fname']) . ' ' . ucfirst($post['lname']), "email" => $post['email'], "link" => $verify_link);
                    // pr($verify_link);
                    $q = $this->send_signup_code($mem_data);
                    // pr($q);
                    $res['email_notofication'] = $q;
                    $res['redirect_url'] = site_url('email-verification');

                    $res['status'] = 1;
                    $res['frm_reset'] = 1;
                } else {
                    $res['msg'] = 'E-mail Address Already In Use!';
                }
            }
            exit(json_encode($res));
        }
        //   else{
        //     $this->data['right_row'] = $this->master->getRow('sitecontent', array('ckey' => 'right_section'));

        //     $this->data['content_row'] = $this->master->getRow('sitecontent', array('ckey' => 'signup'));
        //     $this->data['site_content'] = unserialize($this->data['content_row']->code);
        //     $this->data['pageView']='pages/signup';
        //     $this->data['captcha']=true;
        //     $this->load->view("includes/site-master", $this->data);
        //   }
    }

    function signin()

    {

        $this->MemLogged();

        if ($this->input->post()) {
            $res = array();
            $res['frm_reset'] = 0;
            $res['hide_msg'] = 0;
            $res['scroll_to_msg'] = 0;
            $res['status'] = 0;
            $res['redirect_url'] = 0;

            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if ($this->form_validation->run() === FALSE) {


                $res['msg'] = validation_errors();
            } else {

                $data = html_escape($this->input->post());

                // pr(md5($data['password']));

                $row = $this->Member_model->authenticate($data['email'], $data['password']);

                // pr($row);

                // var_dump($row);

                if (!empty($row)) {

                    if ($row->mem_status == 0) {

                        $res['msg'] = 'Your account blocked!';
                        exit(json_encode($res));
                    } else {


                        $remember_token = '';

                        if (isset($data['remeberMe'])) {

                            $remember_token = doEncode('member-' . $row->mem_id);
                            $cookie = array('name'   => 'remember', 'value'  => $remember_token, 'expire' => (86400 * 7));

                            $this->input->set_cookie($cookie);
                        }


                        // $this->Member_model->update_last_login($row->id,$remember_token);


                        $this->session->set_userdata('mem_id', $row->mem_id);
                        $this->session->set_userdata('mem_type', $row->mem_type);

                        $res['redirect_url'] = site_url('dashboard');

                        $this->session->unset_userdata('redirect_url');

                        $res['msg'] = 'Sign in successful! Please wait.';
                        $res['status'] = 1;
                        $res['frm_reset'] = 1;
                        $res['hide_msg'] = 1;
                    }
                } else {
                    $res['msg'] = 'Invalid email or password';
                }
            }

            exit(json_encode($res));
        }

        // else{

        //     $this->data['right_row'] = $this->master->getRow('sitecontent', array('ckey' => 'right_section'));



        //     $this->data['content_row'] = $this->master->getRow('sitecontent', array('ckey' => 'signin'));

        //     $this->data['site_content'] = unserialize($this->data['content_row']->code);

        //     $this->data['pageView']='pages/signin';

        //     $this->load->view("includes/site-master", $this->data);

        // }

    }



    function verification($vcode = '')

    {
        // pr('asd');
        $row = $this->Member_model->getMemCode($vcode);
        // pr($row);

        if ($row = $this->Member_model->getMemCode($vcode)) {

            // pr($this->db->last_query());
            $this->Member_model->save(array('mem_verified' => 1, 'mem_email_verified' => 1, 'mem_code' => ''), $row->mem_id);

            setMsg('success', "Account has been verified!!!");

            redirect('dashboard', 'refresh');


            exit;
        } else {

            redirect('', 'refresh');



            exit;
        }
    }



    function forgot()

    {



        // $this->MemLogged();



        if ($this->input->post()) {

            $res = array();

            $res['hide_msg'] = 0;

            $res['scroll_to_msg'] = 0;

            $res['status'] = 0;

            $res['frm_reset'] = 0;

            $res['redirect_url'] = 0;

            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

            if ($this->form_validation->run() === FALSE) {

                $res['msg'] = validation_errors();

                $res['status'] = 0;
            } else {

                $post = html_escape($this->input->post());

                if ($mem = $this->Member_model->forgotEmailExists($post['email'])) {

                    // $settings = $this->data['site_settings'];

                    $rando = doEncode(randCode(rand(15, 20)));

                    $this->master->save('members', array('mem_code' => $rando), 'mem_id', $mem->mem_id);

                    $reset_link = site_url('reset/' . $rando);

                    $mem_data = array('name' => $mem->mem_fname . ' ' . $mem->mem_lname, "email" => $mem->mem_email, "link" => $reset_link);



                    send_site_email($mem_data, 'forgot_password');

                    $res['msg'] = 'We’ve sent a reset password link to the email address you entered to reset your password. If you don’t see the email, check your spam folder or email!';
                    $res['status'] = 1;
                    $res['frm_reset'] = 1;
                } else {

                    $res['msg'] = 'No such email address exists. Please try again!';
                    $res['status'] = 0;
                }
            }

            exit(json_encode($res));
        } else {

            $this->data['page_title'] = 'Forgot Password';
            $this->data['meta_keywords'] = '';
            $this->data['meta_description'] = '';
            // $this->data['site_content'] = $this->master->getRow('sitecontent', array('type' => 'forgot'));
            // $this->data['site_content'] =(array) json_decode($this->data['site_content']->code);
            $this->data['pageView'] = 'pages/forget_password';
            $this->load->view("includes/site-master", $this->data);
        }
    }



    function reset_password()

    {

        $reset_id = intval($this->session->userdata('reset_id'));

        if ($row = $this->Member_model->getMember($reset_id)) {


            if ($this->input->post()) {

                $res = array();
                $res['hide_msg'] = 0;
                $res['scroll_to_msg'] = 0;
                $res['status'] = 0;
                $res['frm_reset'] = 0;
                $res['redirect_url'] = 0;



                $reset_id = intval($this->session->userdata('reset_id'));


                if ($row = $this->Member_model->getMember($reset_id)) {

                    $this->form_validation->set_rules('password', 'New Password', 'required');
                    $this->form_validation->set_rules('cpswd', 'Confirm Password', 'required|matches[password]');

                    if ($this->form_validation->run() === FALSE) {


                        $res['msg'] = validation_errors();
                    } else {

                        $post = html_escape($this->input->post());

                        $this->Member_model->save(array('mem_pswd' => md5($post['password'])), $reset_id);

                        $this->session->unset_userdata('reset_id');

                        $res['msg'] = 'You have successfully reset your password!';
                        $res['redirect_url'] = site_url('signin');
                        $res['status'] = 1;
                        $res['frm_reset'] = 1;
                        $res['hide_msg'] = 1;
                    }
                } else {



                    $res['msg'] = 'Something is wrong, try again later!';
                }



                exit(json_encode($res));
            } else {

                $this->data['page_title'] = 'Reset Password';
                $this->data['meta_keywords'] = '';
                $this->data['meta_description'] = '';

                $this->data['pageView'] = 'pages/reset_password';
                // $this->load->view("includes/site-master", $this->data);
                $this->load->view('pages/reset_password', $this->data);
            }
        } else {

            redirect('signin', 'refresh');
            exit;
        }
    }




    function reset($vcode)

    {
        if ($row = $this->Member_model->getMemCode($vcode)) {
            $this->Member_model->save(array('mem_code' => ''), $row->mem_id);
            $this->session->set_userdata('reset_id', $row->mem_id);
            redirect('reset-password', 'refresh');
            exit;
        } else {

            redirect('signin', 'refresh');
            exit;
        }
    }
}
