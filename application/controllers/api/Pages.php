<?php
#[AllowDynamicProperties]
class Pages extends MY_Controller
{

    private $mem_id = '';
    public function __construct()
    {

        parent::__construct();
        header('Content-Type: application/json');
        $this->load->model('Pages_model', 'page');
        $this->load->model('Member_model', 'member');
        $this->load->model('services_model');


        if (!empty($this->input->post('token'))) {
            $tokenResponse = $this->verifyAuthToken($this->input->post('token'), '192.168.1.0618');
            if ($tokenResponse['error'] === 0) {
                $this->mem_id = $tokenResponse['mem_id'];
                // pr($this->mem_id);
            }
        }

        $this->api_output;
        
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

    function site_settings()
    {

        // pr($this->input->post('token'));
        $post = $this->input->post();
        if (empty($post['token'])) {
            $memData = null;
        } else {
            // pr('hi');
            $mem_id = $this->mem_id;
            // pr($mem_id);
            $memData = $this->member->getMemData($mem_id);
            // pr($memData);
        }


        $this->api_output['site_settings'] = siteSettingsData( $this->data['site_settings']);

        // pr($memData);
        // $this->api_output['site_settings']->memData = $memData;
        $this->api_output['memData'] = $memData;

        http_response_code(200);
        echo json_encode($this->api_output);
    }

    function home()
    {
        // $post = $this->input->post();
        // if (empty($post['token'])) {
        //     $memData = null;
        // } else {
        //     // pr('hi');
        //     $mem_id = $this->mem_id;
        //     $memData = $this->member->getMemData($mem_id);
        //     $this->api_output['memData'] = $memData;
        // }
        $meta = $this->page->getMetaContent('home');
        $this->api_output['page_title'] = $meta->page_name . ' - ' . $this->data['site_settings']->site_name;
        $this->api_output['slug'] = $meta->slug;
        $data = $this->page->getPageContent('home');
        // pr($data);
        if ($data) {
            $this->api_output['content'] = $content = unserialize($data->code);
            $this->api_output['meta_desc'] = json_decode($meta->content);
            $this->api_output['testimonials'] = $this->master->getRows('testimonials', ['status' => 1], '', '', 'desc', 'id');
            $this->api_output['categories'] = $this->services_model->get_rows(array('status' => 1));
            
            $members = $this->master->getRows('members', array('mem_featured' => 1, 'mem_verified' => 1, 'mem_status' => 1 ));
            
            $this->api_output['pro_featured'] = null;
            foreach($members as $mem){
                $sel_services = $this->master->getRows('selected_services', array('mem_id' => $mem->mem_id));
                $selected_services = [];
                foreach($sel_services as $srv) {
                    $selected_services[] = (Object)[
                        'id' => $srv->id,
                        'mem_id' => $srv->mem_id,
                        'service_id' => $srv->service_id,
                        'service_name' => get_service_title($srv->service_id),
                    ];
                    
                }

                $this->api_output['pro_featured'][] = (Object)[
                    'mem_id' => $mem->mem_id,
                    'category_title' => get_service_title($mem->mem_specialization),
                    'member' => $mem,
                    'selected_services' => $selected_services,
                ];
            }

            // pr($this->api_output['pro_featured']);


          
            http_response_code(200);
            echo json_encode($this->api_output);
        } else {
            http_response_code(404);
        }
    }

    function about()
    {
        $meta = $this->page->getMetaContent('about');
        $this->api_output['page_title'] = $meta->page_name . ' - ' . $this->data['site_settings']->site_name;
        $this->api_output['slug'] = $meta->slug;
        $data = $this->page->getPageContent('about');
        // pr($data);
        if ($data) {
            $this->api_output['content'] = $content = unserialize($data->code);
            // $this->api_output['details'] = ($data->full_code);
            $this->api_output['meta_desc'] = json_decode($meta->content);
            $this->api_output['why_choose'] = getMultiText('about-sec2');
            $this->api_output['testimonials'] = $this->master->getRows('testimonials', ['status' => 1], '', '', 'desc', 'id');
           
            http_response_code(200);
            echo json_encode($this->api_output);
        } else {
            http_response_code(404);
        }
    }

    function become_pro()
    {
        $meta = $this->page->getMetaContent('become_pro');
        $this->api_output['page_title'] = $meta->page_name . ' - ' . $this->data['site_settings']->site_name;
        $this->api_output['slug'] = $meta->slug;
        $data = $this->page->getPageContent('become_pro');
        // pr($data);
        if ($data) {
            
            $this->api_output['content'] = $content = unserialize($data->code);
            // $this->api_output['details'] = ($data->full_code);
            $this->api_output['meta_desc'] = json_decode($meta->content);
            $this->api_output['how_works'] = getMultiText('become-pro-sec3');
            $this->api_output['popular_plan'] = $this->master->getRow('plans', array('status' => 1, 'popular' => 1));

            $this->api_output['testimonials'] = $this->master->getRows('testimonials', ['status' => 1], '', '', 'desc', 'id');
            $this->api_output['services'] = $this->services_model->get_rows(array('status' => 1), '', 10);

            // pr($this->db->last_query());
            $members = $this->master->getRows('members', array('mem_featured' => 1, 'mem_verified' => 1, 'mem_status' => 1 ));
            
            $this->api_output['pro_featured'] = null;
            foreach($members as $mem){
                $sel_services = $this->master->getRows('selected_services', array('mem_id' => $mem->mem_id));
                $selected_services = [];
                foreach($sel_services as $srv) {
                    $selected_services[] = (Object)[
                        'id' => $srv->id,
                        'mem_id' => $srv->mem_id,
                        'service_id' => $srv->service_id,
                        'service_name' => get_service_title($srv->service_id),
                    ];
                    
                }

                $this->api_output['pro_featured'][] = (Object)[
                    'mem_id' => $mem->mem_id,
                    'category_title' => get_service_title($mem->mem_specialization),
                    'member' => $mem,
                    'selected_services' => $selected_services,
                ];
            }


            http_response_code(200);
            echo json_encode($this->api_output);
        } else {
            http_response_code(404);
        }
    }

    function contact_us()
    {
        $meta = $this->page->getMetaContent('contact_us');
        $this->api_output['page_title'] = $meta->page_name . ' - ' . $this->data['site_settings']->site_name;
        $this->api_output['slug'] = $meta->slug;
        $data = $this->page->getPageContent('contact_us');

        if ($data) {
            $this->api_output['content'] = unserialize($data->code);
            $this->api_output['details'] = ($data->full_code);
            $this->api_output['meta_desc'] = json_decode($meta->content);

            $this->api_output['site_settings'] = (object)[
                'site_name' => $this->data['site_settings']->site_name,
                'site_email' => $this->data['site_settings']->site_email,
                'site_general_email' => $this->data['site_settings']->site_general_email,
                'site_noreply_email' => $this->data['site_settings']->site_noreply_email,
                'site_phone' => $this->data['site_settings']->site_phone,
                'site_address' => $this->data['site_settings']->site_address,
                'site_facebook' => $this->data['site_settings']->site_facebook,
                'site_twitter' => $this->data['site_settings']->site_twitter,
                'site_google' => $this->data['site_settings']->site_google,
                'site_instagram' => $this->data['site_settings']->site_instagram,
                'site_linkedin' => $this->data['site_settings']->site_linkedin,
                'site_youtube' => $this->data['site_settings']->site_youtube,
            ];

            http_response_code(200);
            echo json_encode($this->api_output);
        } else {
            http_response_code(404);
        }
        exit;
    }

    function explore()
    {
        $meta = $this->page->getMetaContent('explore');
        $this->api_output['page_title'] = $meta->page_name . ' - ' . $this->data['site_settings']->site_name;
        $this->api_output['slug'] = $meta->slug;
        $data = $this->page->getPageContent('explore');

        if ($data) {
            $this->api_output['content'] = unserialize($data->code);
            $this->api_output['details'] = ($data->full_code);
            $this->api_output['meta_desc'] = json_decode($meta->content);


            http_response_code(200);
            echo json_encode($this->api_output);
        } else {
            http_response_code(404);
        }
        exit;
    }

    function signup()
    {
        $meta = $this->page->getMetaContent('signup');
        $this->api_output['page_title'] = $meta->page_name . ' - ' . $this->data['site_settings']->site_name;
        $this->api_output['slug'] = $meta->slug;
        $data = $this->page->getPageContent('signup');
        if ($data) {
            $this->api_output['content'] = unserialize($data->code);
            $this->api_output['details'] = ($data->full_code);
            $this->api_output['meta_desc'] = json_decode($meta->content);

            $this->api_output['site_settings'] = (object)[
                'site_name' => $this->data['site_settings']->site_name,
                'site_email' => $this->data['site_settings']->site_email,
                'site_logo' => $this->data['site_settings']->site_logo,
                'site_footer_logo' => $this->data['site_settings']->site_footer_logo,
                'site_icon' => $this->data['site_settings']->site_icon,
            ];

            http_response_code(200);
            echo json_encode($this->api_output);
        } else {
            http_response_code(404);
        }
        exit;
    }

    function login()
    {

        $meta = $this->page->getMetaContent('login');
        $this->api_output['page_title'] = $meta->page_name . ' - ' . $this->data['site_settings']->site_name;
        $this->api_output['slug'] = $meta->slug;
        $data = $this->page->getPageContent('login');
        if ($data) {
            $this->api_output['content'] = unserialize($data->code);
            $this->api_output['details'] = ($data->full_code);
            $this->api_output['meta_desc'] = json_decode($meta->content);

            $this->api_output['site_settings'] = (object)[
                'site_name' => $this->data['site_settings']->site_name,
                'site_email' => $this->data['site_settings']->site_email,
                'site_logo' => $this->data['site_settings']->site_logo,
                'site_footer_logo' => $this->data['site_settings']->site_footer_logo,
                'site_icon' => $this->data['site_settings']->site_icon,
            ];

            http_response_code(200);
            echo json_encode($this->api_output);
        } else {
            http_response_code(404);
        }
        exit;
    }
   
    function forgot_password_content()
    {

        $meta = $this->page->getMetaContent('forgot_password');
        $this->api_output['page_title'] = $meta->page_name . ' - ' . $this->data['site_settings']->site_name;
        $this->api_output['slug'] = $meta->slug;
        $data = $this->page->getPageContent('forgot_password');
        if ($data) {
            $this->api_output['content'] = unserialize($data->code);
            $this->api_output['details'] = ($data->full_code);
            $this->api_output['meta_desc'] = json_decode($meta->content);

            $this->api_output['site_settings'] = (object)[
                'site_name' => $this->data['site_settings']->site_name,
                'site_email' => $this->data['site_settings']->site_email,
                'site_logo' => $this->data['site_settings']->site_logo,
                'site_footer_logo' => $this->data['site_settings']->site_footer_logo,
                'site_icon' => $this->data['site_settings']->site_icon,
            ];

            http_response_code(200);
            echo json_encode($this->api_output);
        } else {
            http_response_code(404);
        }
        exit;
    }

    function reset_password_content()
    {
        $meta = $this->page->getMetaContent('change_password');
        $this->api_output['page_title'] = $meta->page_name . ' - ' . $this->data['site_settings']->site_name;
        $this->api_output['slug'] = $meta->slug;
        $data = $this->page->getPageContent('change_password');

        if ($data) {
            $this->api_output['content'] = unserialize($data->code);
            $this->api_output['details'] = ($data->full_code);
            $this->api_output['meta_desc'] = json_decode($meta->content);

            $this->api_output['site_settings'] = (object)[
                'site_name' => $this->data['site_settings']->site_name,
                'site_email' => $this->data['site_settings']->site_email,
                'site_logo' => $this->data['site_settings']->site_logo,
                'site_footer_logo' => $this->data['site_settings']->site_footer_logo,
                'site_icon' => $this->data['site_settings']->site_icon,
            ];

            http_response_code(200);
            echo json_encode($this->api_output);
        } else {
            http_response_code(404);
        }
        exit;
    }

    function membership()
    {
        $meta = $this->page->getMetaContent('membership');
        $this->api_output['page_title'] = $meta->page_name . ' - ' . $this->data['site_settings']->site_name;
        $this->api_output['slug'] = $meta->slug;
        $data = $this->page->getPageContent('membership');
        // pr($data);
        if ($data) {
            
            $this->api_output['content'] = $content = unserialize($data->code);
            // $this->api_output['details'] = ($data->full_code);
            $this->api_output['meta_desc'] = json_decode($meta->content);
            $this->api_output['plans'] = $this->master->getRows('plans', array('status' => 1), '', '', 'ASC', 'sort_order');

            $this->api_output['testimonials'] = $this->master->getRows('testimonials', ['status' => 1], '', '', 'desc', 'id');
   
            // pr($this->db->last_query());


            http_response_code(200);
            echo json_encode($this->api_output);
        } else {
            http_response_code(404);
        }
    }

    function terms_and_conditions()
    {

        $meta = $this->page->getMetaContent('terms_and_conditions');
        $this->api_output['page_title'] = $meta->page_name . ' - ' . $this->data['site_settings']->site_name;
        $this->api_output['slug'] = $meta->slug;
        $data = $this->page->getPageContent('terms_and_conditions');
        if ($data) {
            $this->api_output['content'] = unserialize($data->code);
            $this->api_output['details'] = ($data->full_code);
            $this->api_output['meta_desc'] = json_decode($meta->content);

            http_response_code(200);
            echo json_encode($this->api_output);
        } else {
            http_response_code(404);
        }
        exit;
    }

    function privacy_policy()
    {

        $meta = $this->page->getMetaContent('privacy_policy');
        $this->api_output['page_title'] = $meta->page_name . ' - ' . $this->data['site_settings']->site_name;
        $this->api_output['slug'] = $meta->slug;
        $data = $this->page->getPageContent('privacy_policy');

        if ($data) {
            $this->api_output['content'] = unserialize($data->code);
            $this->api_output['details'] = ($data->full_code);
            $this->api_output['meta_desc'] = json_decode($meta->content);

            http_response_code(200);
            echo json_encode($this->api_output);
        } else {
            http_response_code(404);
        }
        exit;
    }

    

    function email_verify_content()
    {
        $post = $this->input->post();
        
        if (empty($post['token'])) {
            $memData = null;
        } else {
            // pr('hi');
            $mem_id = $this->mem_id;
            $this->api_output['post'] = $this->mem_id;
            $memData = $this->member->getMemData($mem_id);
            $this->api_output['memData'] = $memData;
        }
        $meta = $this->page->getMetaContent('email_verify');
        $this->api_output['page_title'] = $meta->page_name . ' - ' . $this->data['site_settings']->site_name;
        $this->api_output['slug'] = $meta->slug;
        $data = $this->page->getPageContent('email_verify');

        if ($data) {
            $this->api_output['content'] = unserialize($data->code);
            $this->api_output['details'] = ($data->full_code);
            $this->api_output['meta_desc'] = json_decode($meta->content);

            $this->api_output['site_settings'] = (object)[
                'site_name' => $this->data['site_settings']->site_name,
                'site_email' => $this->data['site_settings']->site_email,
                'site_logo' => $this->data['site_settings']->site_logo,
                'site_footer_logo' => $this->data['site_settings']->site_footer_logo,
                'site_icon' => $this->data['site_settings']->site_icon,
                
            ];

            // $this->api_output['post'] = $post;

            http_response_code(200);
            echo json_encode($this->api_output);
        } else {
            http_response_code(404);
        }
        exit;
    }


    function checkout_page()
    {
        if($this->input->post()){
            $post = $this->input->post();
            $plan_id = intval($post['plan_id']);
            // $this->api_output['post'] = $plan_id;


            if (empty($post['token'])) {
                $memData = null;
            } else {
                // pr('hi');
                $mem_id = $this->mem_id;
                $memData = $this->member->getMemData($mem_id);
                $this->api_output['memData'] = $memData;
            }
            $meta = $this->page->getMetaContent('checkout');
            $this->api_output['page_title'] = $meta->page_name . ' - ' . $this->data['site_settings']->site_name;
            $this->api_output['slug'] = $meta->slug;
            $data = $this->page->getPageContent('checkout');
    
            if ($data) {
                $this->api_output['content'] = unserialize($data->code);
                $this->api_output['details'] = ($data->full_code);
                $this->api_output['meta_desc'] = json_decode($meta->content);

                $this->api_output['plan'] = $this->master->getRow("plans", array('id' => $plan_id, 'status' => 1));

    
                $this->api_output['site_settings'] = (object)[
                    'site_name' => $this->data['site_settings']->site_name,
                    'site_email' => $this->data['site_settings']->site_email,
                    'site_logo' => $this->data['site_settings']->site_logo,
                    'site_footer_logo' => $this->data['site_settings']->site_footer_logo,
                    'site_icon' => $this->data['site_settings']->site_icon,
                    
                ];
    
                // $this->api_output['post'] = $post;
    
                http_response_code(200);
                echo json_encode($this->api_output);
            } else {
                http_response_code(404);
            }
        }
       
        exit;
    }

    function save_contact_message()
    {
        if ($this->input->post()) {
            $res = [];
            $res['status'] = 0;
            $res['validationErrors'] = '';
            $this->form_validation->set_rules('full_name', 'Full Name', 'trim|required|min_length[4]|max_length[30]', ['min_length' => 'Please enter full name.', 'max_length' => 'Name too long.']);
            $this->form_validation->set_rules('phone', 'Phone Number', 'trim|required');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('msg', 'Message', 'trim|required|min_length[10]|max_length[1000]', ['min_length' => 'Please write a complete sentence of minimum 10 characters.', 'max_length' => '1000 character limit reached.']);
            if ($this->form_validation->run() === FALSE) {
                $res['validationErrors'] = validation_errors();
            } else {
                $post = html_escape($this->input->post());
                $is_added = $this->master->save('contact', $post);
                $name = $post['full_name'];
                $mem_data = [
                    'name' => $name,
                    "email" => $post['email'],
                    'msg' => trim($post['msg'])
                ];

                if ($is_added) {
                    // $this->send_query_successful($mem_data);
                    // $this->send_query_recieved_admin($mem_data);
                    $res['status'] = 1;
                    $res['msg'] = "Mesasage Sent Successfully!";
                } else {
                    $res['status'] = 0;
                    $res['msg'] = "Mesasage Not Sent!";
                }
            }
            echo json_encode($res);
            exit;
        }
    }

    function save_newsletter()
    {
        // pr("hi");
        $res = array();
        if ($this->input->post()) {
            $this->form_validation->set_rules(
                'email',
                'Email',
                'required|valid_email|is_unique[newsletter.email]',
                array(
                    'required'      => 'You have not provided %s.',
                    'is_unique'     => 'This %s already joined.'
                )
            );
            if ($this->form_validation->run() === FALSE) {
                $res['validation_error'] = validation_errors();
            } else {
                $vals = html_escape($this->input->post());
                $data = array(
                    'email' => $vals['email'],
                    'status' => 0
                );
                $id = $this->master->save("newsletter", $data);
                if ($id > 0) {
                    $res['msg'] = 'Subscribed successfully!';
                    $res['status'] = 1;
                } else {
                    $res['msg'] = 'Technical problem!';
                    $res['status'] = 0;
                }
            }
        }
        exit(json_encode($res));
    }



    function search_profession()
    {
        $post = $this->input->post();
        // pr($post);
        
        if (empty($post['token'])) {
            $memData = null;
        } else {
            // pr('hi');
            $mem_id = $this->mem_id;
            $memData = $this->member->getMemData($mem_id);
            $this->api_output['memData'] = $memData;
        }

        $final_data = array();
        if (!empty($post) && ($post['category_id'] !== "" || $post['latitude'] !== ""|| $post['longitude'] !== "")) {
            // $this->api_output['chk'] = $post;

            $data = $this->member->search_pro_members($post);
            // pr($this->db->last_query());

            if (!empty($data)) {

                foreach ($data as $mem) {                
                    $sel_services = $this->master->getRows('selected_services', array('mem_id' => $mem->mem_id));
                $selected_services = [];
                foreach($sel_services as $srv) {
                    $selected_services[] = (Object)[
                        'id' => $srv->id,
                        'mem_id' => $srv->mem_id,
                        'service_id' => $srv->service_id,
                        'service_name' => get_service_title($srv->service_id),
                    ];
                    
                }

                    $final_data[] = [
                    'mem_id' => $mem->mem_id,
                    'mem_type' => $mem->mem_type,
                    'mem_fname' => $mem->mem_fname,
                    'mem_email' => $mem->mem_email,
                    'mem_phone' => $mem->mem_phone,
                    'mem_image' => $mem->mem_image,
                    'mem_address' => $mem->mem_address,
                    'mem_verified' => $mem->mem_verified,
                    'mem_status' => $mem->mem_status,
                    'mem_specialization' => $mem->mem_specialization,
                    'mem_phone_verified' => $mem->mem_phone_verified,
                    'mem_latitude' => $mem->mem_latitude,
                    'mem_longitude' => $mem->mem_longitude,
                    'mem_pro_title' => $mem->mem_pro_title,
                    'selected_services' => $selected_services,

                    ];
                }
                if (!empty($post['category_id'])) {
                    $this->api_output['selected_category'] = $this->master->getRow('services', array('id' => $post['category_id']));;
                }
                
                $this->api_output['professions'] = $final_data;
                $this->api_output['status'] = true;
            } else {
                $this->api_output['status'] = false;
                $this->api_output['professions'] = (Object)[];
                $this->api_output['msg'] = 'No Professions Found';
            }
        } else {
            // $this->api_output['chk'] = 'no-=post';

            $data = $this->member->getAllVerifiedProMemeber();
            // pr($this->db->last_query());
            // pr($data);
            foreach ($data as $mem) {
                $sel_services = $this->master->getRows('selected_services', array('mem_id' => $mem->mem_id));
                $selected_services = [];
                foreach($sel_services as $srv) {
                    $selected_services[] = (Object)[
                        'id' => $srv->id,
                        'mem_id' => $srv->mem_id,
                        'service_id' => $srv->service_id,
                        'service_name' => get_service_title($srv->service_id),
                    ];
                    
                }

                    $final_data[] = [
                    'mem_id' => $mem->mem_id,
                    'mem_type' => $mem->mem_type,
                    'mem_fname' => $mem->mem_fname,
                    'mem_email' => $mem->mem_email,
                    'mem_phone' => $mem->mem_phone,
                    'mem_image' => $mem->mem_image,
                    'mem_address' => $mem->mem_address,
                    'mem_verified' => $mem->mem_verified,
                    'mem_status' => $mem->mem_status,
                    'mem_latitude' => $mem->mem_latitude,
                    'mem_longitude' => $mem->mem_longitude,
                    'mem_specialization' => $mem->mem_specialization,
                    'mem_phone_verified' => $mem->mem_phone_verified,
                    'mem_pro_title' => $mem->mem_pro_title,
                    'selected_services' => $selected_services,

                    ];
            }
            $this->api_output['status'] = false;
            $this->api_output['professions'] = $final_data;
        }

        $this->api_output['categories'] = $this->master->getRows('services', array('status' => 1));

        $meta = $this->page->getMetaContent('explore');
        $this->api_output['page_title'] = $meta->page_name . ' - ' . $this->data['site_settings']->site_name;
        $this->api_output['slug'] = $meta->slug;
        $data = $this->page->getPageContent('explore');

        
            $this->api_output['content'] = unserialize($data->code);
            $this->api_output['details'] = ($data->full_code);
            $this->api_output['meta_desc'] = json_decode($meta->content);


        

        http_response_code(200);
        echo json_encode($this->api_output);
        // } else {
        //     http_response_code(404);
        // }

    }

    function search_detail($pro_mem_id)
    {
        $pro_mem_id = intval($pro_mem_id);
        $post = $this->input->post();

        if (!empty($pro_mem_id) && !empty($pro_mem = $this->member->getMemData($pro_mem_id))) {
            if (!empty($post['token'])) {
                $mem_id = $this->mem_id;
                $memData = $this->member->getMemData($mem_id);
                $this->api_output['memData'] = $memData;
                
            }
                      
            $this->api_output['page_title'] = 'Profession Details' . ' - ' . $this->data['site_settings']->site_name;

            $sel_services = $this->master->getRows('selected_services', array('mem_id' => $pro_mem->mem_id));
            $this->api_output['selected_services'] = [];
                foreach($sel_services as $srv) {
                    $this->api_output['selected_services'][] = (Object)[
                        'id' => $srv->id,
                        'mem_id' => $srv->mem_id,
                        'service_id' => $srv->service_id,
                        'service_name' => get_service_title($srv->service_id),
                    ];
                    
                }

            $this->api_output['pro_mem_data'] = [
                        'mem_id' => $pro_mem->mem_id,
                        'mem_type' => $pro_mem->mem_type,
                        'mem_fname' => $pro_mem->mem_fname,
                        'mem_email' => $pro_mem->mem_email,
                        'mem_phone' => $pro_mem->mem_phone,
                        'mem_image' => $pro_mem->mem_image,
                        'mem_address' => $pro_mem->mem_address,
                        'mem_verified' => $pro_mem->mem_verified,
                        'mem_status' => $pro_mem->mem_status,
                        'mem_specialization' => $pro_mem->mem_specialization,
                        'mem_phone_verified' => $pro_mem->mem_phone_verified,
                        'category_title' => get_service_title($pro_mem->mem_specialization),
                        'mem_facebook' => $pro_mem->mem_facebook,
                        'mem_twitter' => $pro_mem->mem_twitter,
                        'mem_linkedin' => $pro_mem->mem_linkedin,
                        'mem_instagram' => $pro_mem->mem_instagram,
                        'mem_website' => $pro_mem->mem_website,
                        'mem_zip_code' => $pro_mem->mem_zip_code,
                        'mem_bio' => $pro_mem->mem_bio,

                        
            ];
            $this->api_output['mem_qualifications'] = $this->master->getRows('qualifications', array('mem_id' => $pro_mem->mem_id));
            $this->api_output['mem_experties'] = $this->master->getRows('experties', array('mem_id' => $pro_mem->mem_id));
           
            $this->api_output['meta_desc'] = [
                'meta_title' => 'Profession Detail - ' . $this->data['site_settings']->site_name,
                'meta_description' => 'Profession Detail - ' . $this->data['site_settings']->site_name,
                'meta_keywords' => 'Profession Detail - ' . $this->data['site_settings']->site_name,
                'og_type' => 'website',
                'og_title' => 'Profession Detail - ' . $this->data['site_settings']->site_name,
                'og_description' => 'Profession Detail - ' . $this->data['site_settings']->site_name,
                'og_image' => '',
                'twitter_image' => '',
            ];
           

            http_response_code(200);
            echo json_encode($this->api_output);
        } else {
            http_response_code(404);
        }
    }

    function upload_file()
    {
        if ($this->input->post()) {
            $res = [];
            $res['status'] = 0;
            $res['validationErrors'] = '';
            
                $post = html_escape($this->input->post());
                $mem_id = $this->mem_id;
                
                if (isset($_FILES["file"]["name"]) && $_FILES["file"]["name"] != "") {
                    // pr($_FILES["file"]["name"]);
                    $file = upload_file(UPLOAD_PATH . 'msg_attachments', 'file');
                    // pr($file);
                    if(!empty($file['file_name'])){
                        $res['status'] = 1;
                        $res['file_name_text'] = $_FILES["file"]["name"];
                        $res['file'] = $file['file_name'];
                    }else{
                        $res['status'] = 0;
                        $res['msg'] = "File Upload Failed";
                    }
                    
                }

            echo json_encode($res);
            exit;
        }
    }
}
