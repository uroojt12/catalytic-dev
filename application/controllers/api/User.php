<?php

class User extends MY_Controller
{

    private $mem_id = '';
    public function __construct()
    {
        parent::__construct();

        header('Content-Type: application/json');
        $this->load->model('Member_model', 'member');
        $this->load->model('Pages_model', 'page');
        $this->load->model('services_model');

    
        $tokenResponse = $this->verifyAuthToken($this->input->post('token'), '192.168.1.0618');
        if ($tokenResponse['error'] === 1) {
            http_response_code(400);
            echo json_encode($tokenResponse);
            exit;
        } else {
            $this->mem_id = $tokenResponse['mem_id'];
        }

        // pr($this->data['site_settings']);
        $this->api_output['site_settings'] = (Object)[
            'site_name' => $this->data['site_settings']->site_name,
            'site_email' => $this->data['site_settings']->site_email,
            'site_general_email' => $this->data['site_settings']->site_general_email,
            'site_logo' => $this->data['site_settings']->site_logo,
            'site_footer_logo' => $this->data['site_settings']->site_footer_logo,
            'site_icon' => $this->data['site_settings']->site_icon,
            'site_phone' => $this->data['site_settings']->site_phone,

            ];
    }

    function user_dashboard()
    {

        if ($this->input->post()) {
            $post = $this->input->post();
            $mem_id = $this->mem_id;
            $memData = $this->member->getMemData($mem_id);
            $this->api_output['page_title'] = 'Dashboard - ' . $this->data['site_settings']->site_name;
            $this->api_output['member'] = $memData;
       

            http_response_code(200);
            echo json_encode($this->api_output);
            exit;
        } else {
            http_response_code(404);
            exit;
        }
    }

    function user_profile_settings()
    {
        if ($this->input->post()) {
            $post = $this->input->post();
            $mem_id = $this->mem_id;
            $this->api_output['page_title'] = 'Manage Account - ' . $this->data['site_settings']->site_name;

            $this->api_output['member'] = $this->member->getMemData($mem_id);

            http_response_code(200);
            echo json_encode($this->api_output);
            exit;
        } else {
            http_response_code(404);
            exit;
        }
    }

    function save_user_profile_settings()
    {

        if ($this->input->post()) {
            $res = [];
            $res['status'] = 0;
            $res['validationErrors'] = '';
            $this->form_validation->set_rules('fname', 'Name', 'trim|required|min_length[2]|max_length[20]', ['min_length' => 'Name should contains atleast 2 letters.', 'max_length' => 'Name should not be greater than 20 letters.']);
            $this->form_validation->set_rules('phone', 'Phone', 'trim|required');
            $this->form_validation->set_rules('address', 'Address', 'trim|required');
            $this->form_validation->set_rules('mem_zip_code', 'Zip Code', 'trim|required');


            if ($this->form_validation->run() === FALSE) {
                $res['validationErrors'] = validation_errors();
            } else {
                $post = html_escape($this->input->post());
                $mem_id = $this->mem_id;
                $save_data = [
                    'mem_fname' => ucfirst($post['fname']),
                    'mem_phone' => $post['phone'],
                    'mem_address' => $post['address'],
                    'mem_bio' => $post['mem_bio'],
                    'mem_zip_code' => $post['mem_zip_code'],
                ];
                if (isset($_FILES["profile"]["name"]) && $_FILES["profile"]["name"] != "") {
                    $image = upload_file(UPLOAD_PATH . 'members', 'profile');
                    // generate_thumb(UPLOAD_PATH.'members/',UPLOAD_PATH.'members/',$image['file_name'],100,'thumb_');
                    // pr($image);
                    $save_data['mem_image'] = $image['file_name'];
                }
                $mem_id = $this->member->save($save_data, $mem_id);
                if ($mem_id) {
                    $res['status'] = 1;
                }
            }
            echo json_encode($res);
            exit;
        }
    }

    function change_password()
    {

        if ($this->input->post()) {
            $res = [];
            $res['status'] = 0;
            $res['validationErrors'] = '';
            $this->form_validation->set_rules('pass', 'Current Password', 'required');
            $this->form_validation->set_rules('new_pass', 'New Password', 'required');
            $this->form_validation->set_rules('confirm_pass', 'Confirm Password', 'required|matches[new_pass]');
            if ($this->form_validation->run() === FALSE) {
                $res['validationErrors'] = validation_errors();
            } else {
                $post = html_escape($this->input->post());
                // pr($post);
                $mem_id = $this->mem_id;
                $row = $this->member->oldPswdCheck($mem_id, $post['pass']);
                if (countlength((array)$row) > 0) {
                    $ary = array('mem_pswd' => doEncode($post['new_pass']));
                    $is_saved = $this->member->save($ary, $mem_id);
                    if ($is_saved) {
                        $mem_data = array('name' => $row->mem_fname, "email" => $row->mem_email);
                        $this->send_password_change_successful($mem_data);
                        // pr($mem_data);
                    }
                    $res['status'] = 1;
                } else {
                    $res['status'] = 0;
                    $res['validationErrors'] = '<p>Wrong current password.</p>';
                }
            }
            exit(json_encode($res));
        }
    }

    function professional_dashboard()
    {

        if ($this->input->post()) {
            $post = $this->input->post();
            $mem_id = $this->mem_id;
            $memData = $this->member->getMemData($mem_id);
            $this->api_output['page_title'] = 'Professional Dashboard - ' . $this->data['site_settings']->site_name;
            $this->api_output['member'] = $memData;
            
                          
            $this->api_output['notifications'] = $this->master->getRows('notifications', array('receiver_mem_id' => $mem_id, 'read_status' => 0, 'receiver' => 'professional' ), '', '', 'DESC');
            $this->api_output['notifications_count'] = countlength($this->api_output['notifications']);

            $this->api_output['evidence_count'] = countlength($this->master->getRows('work_evidences', array('mem_id' => $mem_id), '', '', ''));
            $this->api_output['service_count'] = countlength($this->master->getRows('selected_services', array('mem_id' => $mem_id), '', '', ''));


            // pr($this->api_output['received_sms']);
            http_response_code(200);
            echo json_encode($this->api_output);
            exit;
        } else {
            http_response_code(404);
            exit;
        }
    }

    function professional_profile_settings()
    {
        if ($this->input->post()) {
            $post = $this->input->post();
            $mem_id = $this->mem_id;
            $member = $this->member->getMemData($mem_id);
            $this->api_output['page_title'] = 'Manage Account - ' . $this->data['site_settings']->site_name;

            $this->api_output['member'] = $member;
            $this->api_output['categories'] = $this->services_model->get_rows(array('status' => 1));
            $this->api_output['mem_qualifications'] = $this->master->getRows('qualifications', array('mem_id' => $mem_id));
            $this->api_output['mem_experties'] = $this->master->getRows('experties', array('mem_id' => $mem_id));
            $this->api_output['selected_services'] = $this->master->getRows('selected_services', array('mem_id' => $mem_id));

            

            if(empty($member->mem_pro_title) || empty($member->mem_zip_code) || empty($member->mem_address) || empty($member->mem_bio) || empty($member->mem_latitude) || empty($member->mem_longitude) || empty($this->api_output['selected_services']) || empty($this->api_output['mem_experties']) || empty($this->api_output['mem_qualifications'])){

                $error_msg = "";
                $error_msg .= '<p>Please fill up the following details otherwise your profile will not come in searches. </p>' ;
                $error_msg .= '<ul>' ;
                if(empty($member->mem_pro_title)){
                    $error_msg .= '<li>Profile Title</li>';
                }
                if(empty($member->mem_zip_code)){
                    $error_msg .= '<li>Zip Code</li>';
                }
                if(empty($member->mem_address) || empty($member->mem_latitude) || empty($member->mem_longitude)){
                    $error_msg .= '<li>Address</li>';
                }
                if(empty($member->mem_bio)){
                    $error_msg .= '<li>Personal Bio</li>';
                }
                if(empty($this->api_output['selected_services'])){
                    $error_msg .= '<li>Select atleast 1 service</li>';
                }

                if(empty($this->api_output['mem_experties'])){
                    $error_msg .= '<li>Add Atleast 1 Experty</li>';
                }

                if(empty($this->api_output['mem_qualifications'])){
                    $error_msg .= '<li>Add atleast 1 qualification</li>';
                }
                $error_msg .= '</ul>' ;
                $this->api_output['error_msg'] = $error_msg;
                $this->api_output['profile_completed'] = false;
            }else{
                $this->api_output['profile_completed'] = true;
            }



            

            http_response_code(200);
            echo json_encode($this->api_output);
            exit;
        } else {
            http_response_code(404);
            exit;
        }
    }

    function professional_work_evidence()
    {
        if ($this->input->post()) {
            $post = $this->input->post();
            $mem_id = $this->mem_id;
            $this->api_output['page_title'] = 'Work Evidence - ' . $this->data['site_settings']->site_name;

            $this->api_output['member'] = $this->member->getMemData($mem_id);
            
            $this->api_output['work_evidences'] = $this->master->getRows('work_evidences', array('mem_id' => $mem_id));
           

            http_response_code(200);
            echo json_encode($this->api_output);
            exit;
        } else {
            http_response_code(404);
            exit;
        }
    }

    function save_professional_profile_settings()
    {
        // pr($this->input->post());

        if ($this->input->post()) {
            $res = [];
            $res['status'] = 0;
            $res['validationErrors'] = '';
            $this->form_validation->set_rules('mem_pro_title', 'Profile Title', 'trim|required');

            $this->form_validation->set_rules('fname', 'Name', 'trim|required');
            $this->form_validation->set_rules('phone', 'Phone', 'trim|required');
            $this->form_validation->set_rules('address', 'Address', 'trim|required');
            $this->form_validation->set_rules('mem_zip_code', 'Zip Code', 'trim|required');
            $this->form_validation->set_rules('mem_bio', 'Personal Bio', 'trim|required');
           
            if ($this->form_validation->run() === FALSE) {
                $res['validationErrors'] = validation_errors();
            } else {
                $post = html_escape($this->input->post());
                $mem_id = $this->mem_id;
                $save_data = [
                    'mem_pro_title' => ucfirst(($post['mem_pro_title'])),
                    'mem_fname' => ucfirst($post['fname']),
                    'mem_phone' => $post['phone'],
                    'mem_address' => $post['address'],
                    'mem_bio' => $post['mem_bio'],
                    'mem_zip_code' => $post['mem_zip_code'],
                    'trustpilot_code' => $post['trustpilot_code'],
                    'mem_latitude' => $post['mem_latitude'],
                    'mem_longitude' => $post['mem_longitude'],
                ];

                if (isset($_FILES["profile"]["name"]) && $_FILES["profile"]["name"] != "") {
                    $image = upload_file(UPLOAD_PATH . 'members', 'profile');
                    $save_data['mem_image'] = $image['file_name'];
                }
            
                $mem_id = $this->member->save($save_data, $mem_id);

                if ($mem_id) {                   
                    $res['status'] = 1;
                }
            }
            echo json_encode($res);
            exit;
        }
    }

    function save_professional_social_media()
    {
        // pr($this->input->post());

        if ($this->input->post()) {
            $res = [];
            $res['status'] = 0;
            $res['validationErrors'] = '';
            $this->form_validation->set_rules('fb', 'temp', 'trim|required');
            // $this->form_validation->set_rules('twitter', 'Twitter URL', 'trim|required');
            // $this->form_validation->set_rules('linkedin', 'LinkedIn URL', 'trim|required');
            // $this->form_validation->set_rules('instagram', 'Instagram URL', 'trim|required');
            // $this->form_validation->set_rules('website', 'Website URL', 'trim|required');
            // $this->form_validation->set_rules('trustpilot_link', 'Trust Pilot Link URL', 'trim|required');

           
            if ($this->form_validation->run() === FALSE) {
                $res['validationErrors'] = validation_errors();
            } else {
                $post = html_escape($this->input->post());
                $mem_id = $this->mem_id;
                $save_data = [
                    'mem_facebook' => $post['facebook'],
                    'mem_twitter' => $post['twitter'],
                    'mem_linkedin' => $post['linkedin'],
                    'mem_instagram' => $post['instagram'],
                    'mem_website' => $post['website'],
                    'trustpilot_link' => $post['trustpilot_link'],
                ];
            
                $mem_id = $this->member->save($save_data, $mem_id);

                if ($mem_id) {                   
                    $res['status'] = 1;
                }
            }
            echo json_encode($res);
            exit;
        }
    }

    function save_professional_services()
    {
        // pr($this->input->post());

        if ($this->input->post()) {
            $res = [];
            $res['status'] = 0;
            $res['validationErrors'] = '';
            
                $post = html_escape($this->input->post());
                $mem_id = $this->mem_id;

                if(empty($post['services'])){
                    $res['status'] = 0;
                    $res['msg'] = 'No Service is selected';
                    echo json_encode($res);
                    exit;
                }
                $id = 0;
                if (!empty($post['services'])) {

                    $this->master->delete('selected_services', 'mem_id', $mem_id);
                    foreach ($post['services'] as $ser) {
                        
                        $id = $this->master->save("selected_services", array('mem_id' => $mem_id, 'service_id' => intval($ser)));
                    }
                }
                

                if ($id > 0) {                   
                    $res['status'] = 1;
                    $res['msg'] = 'added';
                }
            
            echo json_encode($res);
            exit;
        }
    }
    



    function get_pro_mem_subscriptions()
    {
        if ($this->input->post()) {
            $post = $this->input->post();
            $mem_id = $this->mem_id;
            $this->api_output['page_title'] = 'My Subscriptions - ' . $this->data['site_settings']->site_name;

            $this->api_output['member'] = $this->member->getMemData($mem_id);
            // pr($this->api_output['member']);
    
            $this->api_output['mem_active_subscription'] = $this->master->getRow('subscribed_plans', array('mem_id' => $mem_id, 'subscription_status' => 'active'));
            // pr($this->db->last_query());
            // pr($this->api_output['mem_active_subscription']);

            $this->api_output['mem_subscriptions'] = $this->master->getRows('subscribed_plans', array('mem_id' => $mem_id), '', '', 'DESC');

            http_response_code(200);
            echo json_encode($this->api_output);
            exit;
        } else {
            http_response_code(404);
            exit;
        }
    }

    function save_qualification()
    {
        if ($this->input->post()) {
            $res = [];
            $res['status'] = 0;
            $res['validationErrors'] = '';
            $this->form_validation->set_rules('title', 'Title', 'trim|required');
            $this->form_validation->set_rules('duration', 'Phone', 'trim|required');
          

            if ($this->form_validation->run() === FALSE) {
                $res['validationErrors'] = validation_errors();
            } else {
                $post = html_escape($this->input->post());
                $mem_id = $this->mem_id;
                $save_data = [
                    'mem_id' => $mem_id,
                    'title' => ucfirst($post['title']),
                    'duration' => $post['duration'],
                    'status' => 1,

                ];
            
                $id = $this->master->save('qualifications', $save_data);

                if ($id > 0) {
                    $res['qualification'] = $this->master->getRow('qualifications', array('id' => $id, 'mem_id' => $mem_id));                   
                    $res['status'] = 1;
                }else{
                    $res['status'] = 0;
                }
            }
            echo json_encode($res);
            exit;
        }
    }

    function remove_qualification()
    {
        if ($this->input->post()) {
            $res = [];
            $res['status'] = 0;
            $res['validationErrors'] = '';
            $this->form_validation->set_rules('q_id', 'Qualification', 'trim|required');         

            if ($this->form_validation->run() === FALSE) {
                $res['validationErrors'] = validation_errors();
            } else {
                $post = html_escape($this->input->post());
                $mem_id = $this->mem_id;
               
                $id = $this->master->delete_where('qualifications', array('id' => intval($post['q_id']), 'mem_id' => $mem_id));

                if ($id > 0) {
                                       
                    $res['status'] = 1;
                }else{
                    $res['status'] = 0;
                }
            }
            echo json_encode($res);
            exit;
        }
    }


    function save_experty()
    {
        if ($this->input->post()) {
            $res = [];
            $res['status'] = 0;
            $res['validationErrors'] = '';
            $this->form_validation->set_rules('title', 'Title', 'trim|required');         

            if ($this->form_validation->run() === FALSE) {
                $res['validationErrors'] = validation_errors();
            } else {
                $post = html_escape($this->input->post());
                $mem_id = $this->mem_id;
                $save_data = [
                    'mem_id' => $mem_id,
                    'title' => ucfirst($post['title']),
                    'status' => 1,

                ];
            
                $id = $this->master->save('experties', $save_data);

                if ($id > 0) {
                    $res['experty'] = $this->master->getRow('experties', array('id' => $id, 'mem_id' => $mem_id));                   
                    $res['status'] = 1;
                }else{
                    $res['status'] = 0;
                }
            }
            echo json_encode($res);
            exit;
        }
    }

    function remove_experty()
    {
        if ($this->input->post()) {
            $res = [];
            $res['status'] = 0;
            $res['validationErrors'] = '';
            $this->form_validation->set_rules('e_id', 'Experty', 'trim|required');         

            if ($this->form_validation->run() === FALSE) {
                $res['validationErrors'] = validation_errors();
            } else {
                $post = html_escape($this->input->post());
                $mem_id = $this->mem_id;
               
                $id = $this->master->delete_where('experties', array('id' => intval($post['e_id']), 'mem_id' => $mem_id));

                if ($id > 0) {
                                       
                    $res['status'] = 1;
                }else{
                    $res['status'] = 0;
                }
            }
            echo json_encode($res);
            exit;
        }
    }

    function get_pro_mem_documents()
    {
        if ($this->input->post()) {
            $post = $this->input->post();
            $mem_id = $this->mem_id;
            $this->api_output['page_title'] = 'My Documents - ' . $this->data['site_settings']->site_name;

            $this->api_output['member'] = $this->member->getMemData($mem_id);
            // pr($this->api_output['member']);
    
            $this->api_output['requested_documents'] = $this->master->getRows('documents', array('mem_id' => $mem_id, 'status' => 'requested' ));
            $this->api_output['mem_documents'] = $this->master->getRows('documents', array('mem_id' => $mem_id, 'status !=' => 'requested' ));

            

            http_response_code(200);
            echo json_encode($this->api_output);
            exit;
        } else {
            http_response_code(404);
            exit;
        }
    }

    function upload_pro_document()
    {
        // pr($this->input->post());

        if ($this->input->post()) {
            $res = [];
            $res['status'] = 0;
            $res['validationErrors'] = '';
            $this->form_validation->set_rules('doc_id', 'Document Id', 'trim|required');
            

            if ($this->form_validation->run() === FALSE) {
                $res['validationErrors'] = validation_errors();
            } else {
                $post = html_escape($this->input->post());
                $mem_id = $this->mem_id;

                $doc_data = $this->master->getRow('documents', array('id' => intval($post['doc_id']), 'mem_id' =>$mem_id ));
                // pr($_FILES);
                $save_data = [
                    'status' => 'under_review'
                ];
                

                if (isset($_FILES["document_file"]["name"]) && $_FILES["document_file"]["name"] != "") {
                    $image = upload_file(UPLOAD_PATH . 'members/documents', 'document_file');
                    $save_data['document'] = $image['file_name'];
                }else{
                    $res['status'] = 0;
                    $res['msg'] = 'Please choose the document file ';
                    echo json_encode($res);
                exit;
                }
            
                $id = $this->master->update('documents', $save_data, array('id' => intval($post['doc_id']), 'mem_id' => $mem_id));

                if ($id) {
                    
                    $notify_arr = [
                        'sender_mem_id' => $mem_id,
                        'receiver_mem_id' => 0,
                        'txt' => get_mem_name($mem_id).' uploaded '. $doc_data->doc_name .' document. <a href="'.base_url("admin/members/manage/".$mem_id).'">Click Here</a> to review it.',
                        'read_status' => 0,
                        'created_at' => date('Y-m-d h:i:s'),
                        'sender' => 'professional',
                        'receiver' => 'admin',
                        'type' => 'document_uploaded',
                    ];

                    $this->master->save('notifications', $notify_arr);

                    $mem_data = [
                        'mem_id' => $mem_id,
                        'name' => get_mem_name($mem_id),
                        'email' => get_mem_email($mem_id),
                    ];
                    
                    $this->send_document_uploaded_email_to_admin($mem_data, $doc_data);

                    $res['requested_documents'] = $this->master->getRows('documents', array('mem_id' => $mem_id, 'status' => 'requested' ));
                    $res['mem_documents'] = $this->master->getRows('documents', array('mem_id' => $mem_id, 'status !=' => 'requested' ));          
                    $res['status'] = 1;
                }
            }
            echo json_encode($res);
            exit;
        }
    }

    function save_professional_work_evidence()
    {
        // pr($this->input->post());

        if ($this->input->post()) {
            $res = [];
            $res['status'] = 0;
            $res['validationErrors'] = '';
            $this->form_validation->set_rules('title', 'Evidence Title', 'trim|required');
            
            if ($this->form_validation->run() === FALSE) {
                $res['validationErrors'] = validation_errors();
            } else {
                $post = html_escape($this->input->post());
                $mem_id = $this->mem_id;
                $save_data = [
                    'mem_id' => $mem_id,
                    'evidence_title' => ucfirst($post['title']),
                    'status' => 1,
                    'created_date' => date('Y-m-d h:i:s'),
                    
                ];

                if (isset($_FILES["evidence_file"]["name"]) && $_FILES["evidence_file"]["name"] != "") {
                    $evidence_file = upload_file(UPLOAD_PATH . 'members/work-evidence', 'evidence_file');
                    $save_data['evidence_file'] = $evidence_file['file_name'];
                }
            
                $id = $this->master->save('work_evidences', $save_data);

                if ($id > 0) {                   
                    $res['status'] = 1;
                }
            }
            echo json_encode($res);
            exit;
        }


}

function notifications()
    {

        if ($this->input->post()) {
            $post = $this->input->post();
            $mem_id = $this->mem_id;
            $memData = $this->member->getMemData($mem_id);
            $this->api_output['page_title'] = 'Notifications - ' . $this->data['site_settings']->site_name;
            $this->api_output['member'] = $memData;

            // pr($memData);
             
            $notifis = $this->master->getRows('notifications', array('receiver_mem_id' => $mem_id, 'receiver' => 'professional' ), '', '', 'DESC');
            
            $this->api_output['notifications'] = null;
            foreach($notifis as $notif){
                // pr($notif);
                $this->api_output['notifications'][] = [
                    'sender_pic' => $notif->sender_mem_id > 0 ? get_mem_image($notif->sender_mem_id) : base_url('assets/images/no-user.svg'),
                    'txt' => $notif->txt,
                    'receiver_mem_id' => $notif->receiver_mem_id,
                    'read_status' => $notif->read_status,
                    'created_at' => $notif->created_at,
                    'sender' => $notif->sender,
                    'receiver' => $notif->receiver,
                    'type' => $notif->type,
                ];
            } 

            // pr($this->api_output['notifications']);
            
            $this->api_output['notifications_count'] = countlength($this->api_output['notifications']);


            // pr($this->api_output['received_sms']);
            http_response_code(200);
            echo json_encode($this->api_output);
            exit;
        } else {
            http_response_code(404);
            exit;
        }
    }


}
