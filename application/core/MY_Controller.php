<?php

defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends CI_Controller

{



    public $data = array();

    private $private_data = [];



    public function __construct()

    {

        parent::__construct();

        $this->data['site_settings'] = $this->getSiteSettings();

        $main_domain =  base_url();

        if ($main_domain == $this->data['site_settings']->site_domain) {

            $this->data['site_settings'] = $this->getSiteSettings();

            redirect(base_url());
        } else {



            $chk_domain = $this->master->getRow('add_domains', array('status' => 1, 'domain_name' => $main_domain));



            if (!empty($chk_domain)) {

                $this->session->set_userdata('web_id', $chk_domain->site_id);

                $this->data['site_settings'] = $this->getsubSiteSettings();
            } else {

                show_404();
            }
        }


        $this->data['site_colors']  = $this->master->getRow('colors', array('site_id' => $this->session->web_id));

        // $this->data['site_settings'] = $this->getSiteSettings();

        $this->data['page']          = $this->uri->segment(1);
        // $this->getActiveMem();
        $this->private_data['email_config'] = array(

            'protocol'   => 'smtp',

            'smtp_host'  => 'ssl://mail.herosolutions.com.pk',

            'smtp_port'  => 465,

            'smtp_user'  => trim($this->data['site_settings']->site_noreply_email),

            'smtp_pass'  => 'B2sBcS^##C1z',

            'mailtype'   => 'html',

            'charset'   => 'utf-8',

            'starttls'  => true

        );



        $this->private_data['email_from'] = trim($this->data['site_settings']->site_noreply_email);

        $this->private_data['admin_email'] = trim($this->data['site_settings']->site_email);



        $this->private_data['JWT_PRIVATE_KEY'] = 'my-safety_____jwt_private_key';

        $this->private_data['JWT_ALGO_METHOD'] = 'HS256';
        $this->data['member_data'] = $this->getActiveMem();
    }







    function getActiveMem()

    {

        $row = $this->master->getRow('members', array('mem_id' => $this->session->mem_id));

        // pr($row);

        return $row;
    }



    function getSiteSettings()

    {

        return $this->master->getRow("siteadmin", array('site_id' => '1'));
    }

    function getsubSiteSettings()

    {

        return $this->master->getRow("add_domains", array('site_id' => $this->session->web_id));
    }



    # RECAPTCHA

    public function verifyRECAPTCHA($token)

    {

        $response = json_decode(file_get_contents(

            "https://www.google.com/recaptcha/api/siteverify?secret=" . RECAPTCHA_SITE_SECRET_KEY . "&response=" . $token . "&remoteip=" . $_SERVER['REMOTE_ADDR']

        ));

        // if ((boolean) $response->success && (float) $response->score > 0.5)

        if ($response->success)

            return TRUE;

        return TRUE;
    }



    # JWT

    public function jwt()

    {

        return new JWT();
    }




    function send_photo_grade_status_email($mem_data)

    {

        $emailto  = $mem_data['email'];

        $subject  = $this->data['site_settings']->site_name . " - Photo Grade";

        $this->data['mem_data'] = $mem_data;

        $msg_body = $this->load->view('includes/emails/send_grade_email_template', $this->data, TRUE);

        $this->send_email($msg_body, $emailto, $subject);
    }


    # EMAILS

    function send_document_uploaded_email_to_admin($mem_data, $doc_data)

    {

        $emailto  = $this->private_data['admin_email'];

        $subject  = "Document Uploaded";

        $this->data['mem_data'] = $mem_data;

        $this->data['doc'] = $doc_data;



        $msg_body = $this->load->view('includes/send_document_uploaded_email_admin', $this->data, TRUE);

        // pr($msg_body);

        $this->send_email($msg_body, $emailto, $subject);
    }



    function send_subscription_cancellation_successful($mem_data)

    {

        $emailto  = $mem_data['email'];

        $subject  = $this->data['site_settings']->site_name . " - Subscription Cancellation Confirmation";

        $this->data['mem_data'] = $mem_data;

        $msg_body = $this->load->view('includes/send_subscription_cancellation_successful', $this->data, TRUE);

        $this->send_email($msg_body, $emailto, $subject);
    }



    function send_subscription_cancellation_successful_admin($mem_data)

    {

        $emailto  = $this->private_data['admin_email'];

        $subject  = "Subscription Cancellation Confirmation";

        $this->data['mem_data'] = $mem_data;

        $msg_body = $this->load->view('includes/send_subscription_cancellation_successful_admin', $this->data, TRUE);



        // pr($msg_body);

        $this->send_email($msg_body, $emailto, $subject);
    }



    function send_subscription_plan_successful($mem_data)

    {

        $emailto  = $mem_data['email'];

        $subject  = "Subscription Confirmation";

        $this->data['mem_data'] = $mem_data;

        $msg_body = $this->load->view('includes/send_subscription_plan_successful', $this->data, TRUE);

        // pr($msg_body);



        $this->send_email($msg_body, $emailto, $subject);
    }



    function send_subscription_plan_successful_admin($mem_data)

    {

        $emailto  = $this->private_data['admin_email'];

        $subject  = $this->data['site_settings']->site_name . " - New Subscription";

        $this->data['mem_data'] = $mem_data;

        $msg_body = $this->load->view('includes/send_subscription_plan_successful_admin', $this->data, TRUE);

        // pr($msg_body);



        $this->send_email($msg_body, $emailto, $subject);
    }



    function send_signup_code($mem_data)

    {

        $emailto  = $mem_data['email'];

        $subject  = $this->data['site_settings']->site_name . " - Email Verification";

        $this->data['mem_data'] = $mem_data;

        $msg_body = $this->load->view('includes/emails/email_verify_code', $this->data, TRUE);

        // pr($msg_body);

        $this->send_email($msg_body, $emailto, $subject);
    }



    function send_verification_confirmation($mem_data)

    {

        $emailto  = $mem_data['email'];

        $subject  = $this->data['site_settings']->site_name . " - Signup Successful";

        $this->data['mem_data'] = $mem_data;

        $msg_body = $this->load->view('includes/email_signup_success', $this->data, TRUE);

        $this->send_email($msg_body, $emailto, $subject);
    }



    function send_password_reset_link($mem_data)

    {

        $emailto  = $mem_data['email'];

        $subject  = $this->data['site_settings']->site_name . " - Password Reset";

        $this->data['mem_data'] = $mem_data;

        $msg_body = $this->load->view('includes/email_password_reset_link', $this->data, TRUE);

        // pr($msg_body);

        $this->send_email($msg_body, $emailto, $subject);
    }



    function send_password_reset_successful($mem_data)

    {

        $emailto  = $mem_data['email'];

        $subject  = $this->data['site_settings']->site_name . " - Password Reset Successful";

        $this->data['mem_data'] = $mem_data;

        $msg_body = $this->load->view('includes/email_password_reset_success', $this->data, TRUE);

        $this->send_email($msg_body, $emailto, $subject);
    }



    function send_password_change_successful($mem_data)

    {

        $emailto  = $mem_data['email'];

        $subject  = $this->data['site_settings']->site_name . " - Password Changed";

        $this->data['mem_data'] = $mem_data;

        $msg_body = $this->load->view('includes/email_password_changed_success', $this->data, TRUE);

        $this->send_email($msg_body, $emailto, $subject);
    }



    function send_query_successful($mem_data)

    {

        $emailto  = $mem_data['email'];

        $subject  = $this->data['site_settings']->site_name . " - Query Sent";

        $this->data['mem_data'] = $mem_data;

        $msg_body = $this->load->view('includes/emails/send_query_successful', $this->data, TRUE);

        $this->send_email($msg_body, $emailto, $subject);
    }



    function send_site_email($mem_data, $key, $template = 'email')

    {

        $CI = get_instance();

        $settings = $CI->master->getRow("siteadmin", array('site_id' => '1'));

        $data['site_settings'] = $CI->master->getRow("siteadmin", array('site_id' => '1'));

        // pr($data['site_settings']);

        extract($mem_data);

        $msg_body = addslashes(getSiteText('email', $key));

        eval("\$msg_body = \"$msg_body\";");

        $msg_body = stripslashes($msg_body);

        if (!empty($mem_data['link'])) {

            if ($key == 'forgot_password') {

                $msg_body .= "<p><a href='{$mem_data['link']}' style='background:#911153;color:#fff;padding:10px 20px;border-radius:4px; text-decoration: none;'>Reset Your Password</a></p>";
            } else {

                $msg_body .= "<p><a href='{$mem_data['link']}' style='background:#911153;color:#fff;padding:10px 20px;border-radius:4px; text-decoration: none;'>Activate Account</a></p>";
            }
        }



        $emailto = $mem_data['email'];

        $from = $settings->site_noreply_email;

        $subject = getSiteText('email', $key, 'subject');

        $CI->load->library('email');

        $CI->email->set_mailtype("html");

        $CI->email->set_newline("\r\n");

        $CI->email->from($from, $settings->site_name);

        $CI->email->to($emailto);

        $CI->email->cc($settings->site_email_cc);

        $CI->email->subject($subject);



        $data['mem_data'] = $mem_data;

        $data['email_body'] = $msg_body;

        $data['email_subject'] = $subject;

        $ebody = $CI->load->view('includes/template-' . $template, $data, TRUE);

        $CI->email->message($ebody);

        if ($CI->email->send()) {

            return true;
        } else {

            $error = $CI->email->print_debugger();

            print_r($CI->email->print_debugger());

            die;

            return $error;
        }
    }





    function send_query_recieved_admin($mem_data)

    {

        $emailto  = $this->private_data['admin_email'];

        $subject  = $this->data['site_settings']->site_name . " - Query Received";

        $this->data['mem_data'] = $mem_data;

        $msg_body = $this->load->view('includes/emails/send_query_recieved_admin', $this->data, TRUE);

        $this->send_email($msg_body, $emailto, $subject);
    }



    private function send_email($msg_body, $emailto, $subject)

    {

        $this->load->library('email');

        $this->email->initialize($this->private_data['email_config']);

        $this->email->set_mailtype("html");

        // $this->email->set_newline("\r\n");

        $this->email->from($this->private_data['email_from'], $this->data['site_settings']->site_name);

        $this->email->to($emailto);

        $this->email->subject($subject);

        $this->data['email_body'] = $msg_body;

        $this->data['email_subject'] = $subject;



        $message = $this->load->view('includes/emails/email_template_base', $this->data, TRUE);

        // pr($msg_body);

        $this->email->message($message);

        if ($this->email->send()) {

            return true;
        } else {

            return true;

            // $error=$this->email->print_debugger();

            // print_r($this->email->print_debugger());die;

            // return $error;

        }
    }





    public function is_email_logged($type, $member_type = '', $is_verified = true, $type_arr = array('member', 'guest'), $phone_verified = false)

    {

        // pr($this->session);

        if (!empty($member_type)) {

            if ($type != $member_type) {

                redirect('dashboard', 'refresh');

                exit;
            }
        }



        if (intval($this->session->mem_id) < 1 || !$this->session->has_userdata('mem_type')) {

            $remember_cookie = $this->input->cookie('ricoza_remember');

            if ($remember_cookie && $row = $this->master->getRow('members', array('mem_remember' => $remember_cookie))) {

                $this->session->set_userdata('mem_id', $row->mem_id);

                $this->session->set_userdata('mem_type', $row->mem_type);



                /*

                if(empty($row->mem_verified) || $row->mem_verified==0){

                    redirect('phone-verification', 'refresh');

                    exit;

                }

                */
            } else {

                $this->session->set_userdata('redirect_url', currentURL());

                redirect('signin', 'refresh');

                exit;
            }
        }

        // $this->type_logged_checked($type_arr);

        if ($is_verified)

            $this->is_email_verified();



        // if($phone_verified)

        //     $this->is_phone_verified();

    }



    function is_verified()

    {

        if (empty($this->data['mem_data']->mem_verified) || $this->data['mem_data']->mem_verified == 0) {

            redirect('dashboard', 'refresh');

            exit;
        }
    }





    function is_email_verified()

    {

        // pr("hi");

        if (!empty($this->data['mem_data']->mem_verified) || $this->data['mem_data']->mem_verified == 1) {

            redirect('dashboard', 'refresh');

            exit;
        }
    }



    // public function isMemLogged($type, $member_type = '', $is_verified = true, $type_arr = array('member', 'guest'), $phone_verified = false)

    // {

    //     if (!empty($member_type)) {

    //         if ($type != $member_type) {

    //             redirect('dashboard', 'refresh');

    //             exit;

    //         }

    //     }



    //     if (intval($this->session->mem_id) < 1 || !$this->session->has_userdata('mem_type')) {

    //         $remember_cookie = $this->input->cookie('ricoza_remember');

    //         if ($remember_cookie && $row = $this->master->getRow('members', array('mem_remember' => $remember_cookie))) {

    //             $this->session->set_userdata('mem_id', $row->mem_id);

    //             $this->session->set_userdata('mem_type', $row->mem_type);



    //             /*

    //             if(empty($row->mem_verified) || $row->mem_verified==0){

    //                 redirect('phone-verification', 'refresh');

    //                 exit;

    //             }

    //             */

    //         } else {

    //             $this->session->set_userdata('redirect_url', currentURL());

    //             redirect('login', 'refresh');

    //             exit;

    //         }

    //     }

    //     // $this->type_logged_checked($type_arr);

    //     if ($is_verified)

    //         $this->is_verified();



    //     // if($phone_verified)

    //     //     $this->is_phone_verified();

    // }





    public function isMemLogged($member_type = '', $is_verified = true, $type_arr = array('member', 'guest'), $phone_verified = false)

    {

        if (intval($this->session->mem_id) < 1 || !$this->session->has_userdata('mem_type')) {

            $remember_cookie = $this->input->cookie('ricoza_remember');

            if ($remember_cookie && $row = $this->master->getRow('members', array('mem_remember' => $remember_cookie))) {

                $this->session->set_userdata('mem_id', $row->mem_id);

                $this->session->set_userdata('mem_type', $row->mem_type);
            } else {

                $this->session->set_userdata('redirect_url', currentURL());

                redirect('login', 'refresh');

                exit;
            }
        }

        // if ($is_verified)

        //     $this->is_verified();









        if (!empty($member_type) && $this->session->mem_type != $member_type) {

            redirect('dashboard', 'refresh');

            exit;
        }



        // Other verification checks

    }





    public function MemLogged()

    {

        $remember_cookie = $this->input->cookie('ricoza_remember');

        if ($remember_cookie && $row = $this->master->getRow('members', array('mem_remember' => $remember_cookie))) {

            $this->session->set_userdata('mem_id', $row->mem_id);

            $this->session->set_userdata('mem_type', $row->mem_type);

            redirect('dashboard', 'refresh');

            exit;
        } elseif (($this->session->mem_id > 0) && $this->session->has_userdata('mem_type')) {

            redirect('dashboard', 'refresh');

            exit;
        }
    }
}



class Admin_Controller extends CI_Controller

{



    protected $data = array();

    public function __construct()

    {

        parent::__construct();

        $this->data['adminsite_setting'] = $this->getAdmineSettings();
    }



    public function isLogged()

    {

        if ($this->session->loged_in < 1) {

            $this->session->set_userdata('admin_redirect_url', currentURL());

            redirect(ADMIN . '/login', 'refresh');

            exit;
        }
    }



    public function logged()

    {

        if ($this->session->loged_in > 0) {

            redirect(ADMIN, 'refresh');

            exit;
        }
    }



    function getAdmineSettings()

    {

        return $this->master->getRow("siteadmin", array('site_id' => '1'));
    }
}





class SUBADMIN_Controller extends CI_Controller

{



    protected $data = array();



    public function __construct()

    {

        parent::__construct();

        $this->data['mainadminsite_setting'] = $this->getMainAdmineSettings();
        $this->data['adminsite_setting'] = $this->getAdmineSettings();
        $this->site_id = $this->session->subadmin_loged_in['site_id'];
        $this->subadmin = $this->getActiveSubAdmin();
    }


    function getMainAdmineSettings()

    {

        return $this->master->getRow("siteadmin", array('site_id' => '1'));
    }


    function getActiveSubAdmin()

    {

        return $this->master->getRow('add_domains', array('site_id' => $this->site_id));
    }

    public function isLogged()

    {
        if (empty($this->session->subadmin_loged_in['site_id'])) {

            $this->session->set_userdata('subadmin_redirect_url', currentURL());

            redirect(SUBADMIN . '/login', 'refresh');

            exit;
        } else {
            $row = $this->master->getRow('add_domains', array('site_id' => $this->site_id));
            if (empty($row)) {
                $this->session->unset_userdata('subadmin_loged_in');
                $this->session->unset_userdata('subadmin_redirect_url');

                redirect(SUBADMIN . '/login', 'refresh');

                exit;
            }
        }
    }



    public function logged()

    {

        if ($this->session->subadmin_loged_in['site_id'] > 0) {

            redirect(SUBADMIN, 'refresh');

            exit;
        }
    }



    function getAdmineSettings()

    {

        return $this->master->getRow("siteadmin", array('site_id' => '1'));
    }

    // function send_orderComplete_email($mem_data) {

    //     $name=$mem_data['name'];

    //     $settings = $this->getAdmineSettings();                     

    //     $emailto = $mem_data['email'];

    //     eval("\$msg_body = \"$msg_body\";"); 

    //     $msg_body.="<p><a href='{$mem_data['link']}' style='background:#e0ae2b;color:#fff;padding:5px 20px;border-radius:4px; text-decoration: none;'>View Order</a></p>";

    //     $subject = "Your order video completed on ".$settings->site_name." < ".$settings->site_email." > ";

    //     $from=$settings->site_noreply_email;

    //     $headers = "MIME-Version: 1.0\r\n";

    //     $headers .= "Content-type: text/html;charset=utf-8\r\n";

    //     $headers .= "From: " . $settings->site_name . " <" . $settings->site_noreply_email . ">" . "\r\n";

    //     $headers .= "Reply-To: " . $settings->site_name . " <" . $settings->site_noreply_email . ">" . "\r\n";

    //     $this->data['member'] = $mem_data;

    //     $this->data['email_body'] = $msg_body;

    //     $this->data['email_subject'] = $subject;

    //     $ebody = $this->load->view('includes/order_template', $this->data, TRUE);

    //     if (@mail($emailto, $subject, $ebody, $headers)) {

    //         return 1;

    //     } else {

    //         return 0;

    //     }

    // }



}
