<?php

class Checkout extends MY_Controller{

	function __construct(){

		parent::__construct();
		$this->load->model('video_model');
	}

	function index($id){
        $id = doDecode($id);
        $id = intval($id);
        // pr($id);
        if (!empty($id) && $this->data['video'] = $this->video_model->get_row_where(array('id' => $id, 'status' => 1))) {

        //    pr($this->data['video']);
            $this->data['page_title'] = 'Checkout';
            $this->data['meta_keywords'] = 'Checkout';
            $this->data['meta_description'] = ucfirst($this->data['video']->detail);
            $this->data['pageView'] = 'pages/checkout';
            $this->data['footer'] = true;
            $this->data['checkout'] = true;
            $this->load->view("includes/site-master", $this->data);
        } else {
            show_404();
        } 
	}

   
    function buy_now(){
        $site_settings = $this->master->getRow('siteadmin');

        // pr($this->input->post());

        $res = array();
        $res['scroll_top'] = 0;
        if ($this->input->post()) {
            $vals = html_escape($this->input->post());

            $this->form_validation->set_rules('fname', 'First Name', 'required');
            $this->form_validation->set_rules('lname', 'Last Name', 'required');
            $this->form_validation->set_rules('email', 'Email Address', 'required|valid_email');
            $this->form_validation->set_rules('address', 'Address', 'required');
            $this->form_validation->set_rules('country', 'Country', 'required');
            $this->form_validation->set_rules('state', 'Country', 'required');
            $this->form_validation->set_rules('city', 'Country', 'required');
            $this->form_validation->set_rules('postal_code', 'Country', 'required');

            $this->form_validation->set_rules('payment_type', 'Payment Type', 'required');

            
            if ($this->form_validation->run() === FALSE) {

                $res['msg'] = validation_errors();
                $res['status'] = 0;
                $res['scroll_top'] = 1;

             exit(json_encode($res));

            } else {

                $video_id = doDecode($vals['video_id']);
                $video_id = intval($video_id);

                $video = $this->video_model->get_row_where(array('id' => $video_id, 'status' => 1));

                if($vals['payment_type'] == 'credit-card'){

                    $data = array(
                        
                        'video_id' => $video->id,
                        'fname' => $vals['fname'],
                        'lname' => $vals['lname'],
                        'email' => $vals['email'],
                        'address' => $vals['address'],
                        'country' => get_country_name($vals['country']),
                        'state' => get_state_name($vals['state']),
                        'city' => $vals['city'],
                        'postal_code' => $vals['postal_code'],
                        'payment_type' => $vals['payment_type'],
                        // 'card_holder_name' => $vals['card_holder_name'],
                        'payment_method_id' => $vals['payment_method_id'],
                        'payment_intent' => $vals['payment_intent'],
                        'stripe_customer_id' => $vals['customer_id'],
                        'total_price' =>    floatval($video->price),
                        'payment_status' => 'paid',
                        'status'=> 1,
                        'created_date'=> date('Y-m-d h:i:s'),
                        'trxn_id' => '',
                        'view_status' => 0,

                    );
                    // pr($data);

                    $o_id = $this->master->save('orders', $data);

                    if($o_id > 0 ){                      

                        if ($_SERVER['HTTP_HOST'] != 'localhost') {

                            $order = $this->master->getRow('orders', array('id' => $o_id));
                            // pr($order_detail);
                            // $this->send_order_email($order, $order_detail, 'Order has been done successfully! - ' . $this->data['site_settings']->site_name, 'Your Order Is Succesfully Completed', $order->email);
                            // $this->send_order_email($order, $order_detail, 'Order has been done - Admin Email - ' . $this->data['site_settings']->site_name, 'You received an Order', $this->data['site_settings']->site_email_send, true);

                        }

                        $res['msg'] = 'Your order has been completed successfully. You Successfully Purchased Tracks. For any Query Please Contact Admin';
                        $res['status'] = 1;
						$res['redirect_url'] = base_url();

                    }else{

                        $res['msg'] = 'Something Went Wrong';
                        $res['status'] = 0;
                    }

                }elseif($vals['payment_type'] == 'paypal'){

                    $data = array(
                        
                        'video_id' => $video->id,
                        'fname' => $vals['fname'],
                        'lname' => $vals['lname'],
                        'email' => $vals['email'],
                        'address' => $vals['address'],
                        'country' => get_country_name($vals['country']),
                        'state' => get_state_name($vals['state']),
                        'city' => $vals['city'],
                        'postal_code' => $vals['postal_code'],
                        'payment_type' => $vals['payment_type'],
                        // 'card_holder_name' => $vals['card_holder_name'],
                        // 'payment_method_id' => $vals['payment_method_id'],
                        // 'payment_intent' => $vals['payment_intent'],
                        // 'stripe_customer_id' => $vals['customer_id'],
                        'total_price' =>    floatval($video->price),
                        'payment_status' => 'pending',
                        'status'=> 0,
                        'created_date'=> date('Y-m-d h:i:s'),
                        'trxn_id' => '',
                        'view_status' => 0,

                    );
                    // pr($data);

                    $o_id = $this->master->save('orders', $data);

                    if($o_id > 0 ){                      

                        

                        $res['msg'] = 'Your order has been completed successfully. You Successfully Purchased Tracks. For any Query Please Contact Admin';
                        $res['status'] = 1;
						$res['redirect_url'] = site_url('paypal/'.doEncode($o_id).'/checkout');

                    }else{

                        $res['msg'] = 'Something Went Wrong';
                        $res['status'] = 0;
                    }



                }

                else{
                    $res['msg'] = 'Your order has not been completed successfully. Please try again';
                    $res['status'] = 0;
                }

           

            exit(json_encode($res));

        }

    }

}

function donations(){
    $site_settings = $this->master->getRow('siteadmin');

    // pr($this->input->post());

    $res = array();
    $res['scroll_top'] = 0;
    if ($this->input->post()) {
        $vals = html_escape($this->input->post());


        $this->form_validation->set_rules('payment_method', 'Payment Method', 'required');

        
        if ($this->form_validation->run() === FALSE) {

            $res['msg'] = validation_errors();
            $res['status'] = 0;
            $res['scroll_top'] = 1;

         exit(json_encode($res));

        } else {
            if($vals['payment_method'] == 'cashapp'){

                $data = array(
                    
                    'payment_method' => $vals['payment_method'],
                    // 'amount' => '',
                    'status'=> 1,
                    'created_date'=> date('Y-m-d h:i:s'),
                    'trxn_id' => '',
                );
                // pr($data);

                $id = $this->master->save('donations', $data);

                if($id > 0 ){                      

                   
                    $res['msg'] = 'Your donation submited';
                    $res['status'] = 1;
                    $res['redirect_url'] = base_url();

                }else{

                    $res['msg'] = 'Something Went Wrong';
                    $res['status'] = 0;
                }

            }elseif($vals['payment_method'] == 'paypal'){

                $data = array(
                    
                    'payment_method' => $vals['payment_method'],
                    'amount' =>    floatval($vals['amount']),
                    'status'=> 1,
                    'created_date'=> date('Y-m-d h:i:s'),
                    'trxn_id' => '',
                );
                // pr($data);

                $o_id = $this->master->save('donations', $data);

                if($o_id > 0 ){                      

                    

                    $res['msg'] = 'Your Donation is processing you are redirecting to paypal';
                    $res['status'] = 1;
                    $res['redirect_url'] = site_url('paypal/'.doEncode($o_id).'/donate');

                }else{

                    $res['msg'] = 'Something Went Wrong';
                    $res['status'] = 0;
                }



            }

            else{
                $res['msg'] = 'Your order has not been completed successfully. Please try again';
                $res['status'] = 0;
            }

       

        exit(json_encode($res));

    }

}

}

function order_success($o_id, $type){

        $o_id = doDecode($o_id);
        $o_id = intval($o_id);
        if(!empty($o_id)){
            $this->data['content_row'] = $this->master->getRow('sitecontent', array('ckey' => 'order_success'));
            $this->data['site_content'] = unserialize($this->data['content_row']->code);
            $this->data['order'] = $this->master->getRow('orders', array('id' => $o_id));
            $this->data['success']= true;
            $this->data['pageView'] = 'pages/success';
            $this->data['footer'] = false;
            $this->data['dashboard'] = true;

            $this->load->view("includes/site-master", $this->data);

            header( "refresh:15;url=". base_url('downloads') );
        }else{
            show_404();
        }

    }



}



?>