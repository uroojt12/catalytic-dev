<?php
class Checkout extends MY_Controller
{
    private $mem_id = '';
    public function __construct()
    {
        parent::__construct();
        header('Content-Type: application/json');
        $this->load->model('Member_model', 'member');
        $this->load->model('Pages_model', 'page');
     
    }


    public function create_payment_intent()
    {

        // pr($this->input->post());
        $res = array();
        $res['hide_msg'] = 0;
        $res['scroll_top'] = 0;

        $this->form_validation->set_rules('fullname', 'Full Name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required');
        $this->form_validation->set_rules('plan_id', 'Plan', 'trim|required');
        $this->form_validation->set_rules('plan_type', 'Plan Type', 'trim|required');

        if($this->input->post('password')){
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]', ['min_length' => 'Password should be atleast 6 characters long.']);

        }
        
        if ($this->form_validation->run() === FALSE) {
            $res['msg'] = validation_errors();
            $res['status'] = 0;
            $res['scroll_top'] = 1;
        } else {
            $vals = $this->input->post();
            $tokenResponse = $this->verifyAuthToken($vals['token'], '192.168.1.0618');

            if (empty($vals['token'])) {

                $email_exsist = $this->member->emailExists($vals['email']);
                // pr($email_exsist);
                if (empty($email_exsist)) {

                    $six_digit_random_number = random_int(100000, 999999);
                    $expire_time = date('Y-m-d H:i:s', strtotime('+3 minutes'));
                                     

                    $save_data = [
                        'mem_type'  => $vals['mem_type'],
                        'mem_fname' => ucfirst($vals['fullname']),
                        'mem_email' => $vals['email'],
                        'mem_phone' => $vals['phone'],
                        'mem_pswd'  => md5($vals['password']),
                        'mem_verification_code'  => $six_digit_random_number,
                        'mem_code_expire'  => $expire_time,
                        'mem_status'        => 1,
                        'mem_last_login'    => date('Y-m-d h:i:s'),

                    ];
                    // pr($save_data);
                    $mem_id = $this->member->save($save_data);
                    if($mem_id > 0){
                        $row = $this->member->getMember($mem_id);
                    // pr($mem_id);
                        $mem_data = array('name' => ucfirst($vals['fullname']), "email" => $vals['email'], "code" => $six_digit_random_number);
                        $this->send_signup_code($mem_data);
                        $res['authToken'] = $this->createAuthToken($row, '192.168.1.0618');
                        $res['signup'] = true;
                        $res['mem_id'] = $mem_id;
                    }
                    
                  // pr($mem_id);
                    
                } else {
                    $res['msg'] = "You is already Registered. Please Login First with your email to continue.";
                    $res['toke_Validty'] = $tokenResponse;
                    $res['status'] = 0;
                    $res['login'] = true;
                    exit(json_encode($res));
                }
            } else {
                $mem_id = $tokenResponse['mem_id'];
            }
            $mem = $this->master->getRow('members', ['mem_id' => $mem_id]);


            $plan_id = intval($vals['plan_id']);
            $plan =  $this->master->getRow('plans', array('id' => $plan_id, 'status' => 1));

            if(empty($plan)){
                $res['msg'] = "Plan not found! Something went Wrong. Try Again or contact admin.";
                $res['status'] = 0;
                exit(json_encode($res));

            }

            $sub_exist = mem_subscription($plan->id, $mem->mem_id);

            if(!empty($sub_exist > 0)){
                $res['msg'] = "You are already subscribed to this plan!. Visit your professional Dashboard to manage your subscription.";
                $res['already_subscribed'] = true;
                $res['status'] = 0;
                exit(json_encode($res));
            }
            
            // pr($plan);        

            $this->load->library('My_stripe');

            $cus_info = [
                'name' => $mem->mem_fname,
                'email' => $mem->mem_email,
                "description" => $this->data['site_settings']->site_name . " Customer " . $mem->mem_fname . ' ' . $mem->mem_lname,
                'payment_method' => $vals['payment_method'],
                'invoice_settings' => ['default_payment_method' => $vals['payment_method']]
            ];


            if (empty($mem->mem_stripe_customer_id)) {
                $customer_id = $this->my_stripe->save_customer($cus_info);

                $this->member->save(['mem_stripe_customer_id' => $customer_id], $mem->mem_id);
            } else {
                $stripe_fetched_customer = $this->my_stripe->get_customer($mem->mem_stripe_customer_id);
                if (!empty($stripe_fetched_customer->id)) {
                    $customer_id = $stripe_fetched_customer->id;
                } else {
                    $customer_id = $this->my_stripe->save_customer($cus_info);

                    $this->member->save(['mem_stripe_customer_id' => $customer_id], $mem->mem_id);
                }
            }

            if($vals['plan_type'] == "monthly") {
                $price = $plan->monthly_price;
                $stripe_price_id = $plan->stripe_id_monthly;
                // $stripe_price_id = "price_1Or4BOIvAJ6oFndkZjBXWUnv";
            }
            if($vals['plan_type'] == "yearly") {
                $price = $plan->yearly_price;
                $stripe_price_id = $plan->stripe_id_yearly;
                // $stripe_price_id = "price_1Or4BOIvAJ6oFndkTm4DhhbJ";

            }

            $amount = $price;
            $cents = intval($amount * 100);
// pr($vals);
            // pr($stripe_price_id);
            $subscription = $this->my_stripe->subscribe_plan_new($customer_id, $stripe_price_id);

            // pr($subscription);
            
            if(!empty($subscription->id)){
                $this->member->save(['stripe_plan_charge_id'=> $customer_id], $stripe_price_id);  
                    $setupintent = $this->my_stripe->setupIntents([
                    	'customer' => $customer_id,
            		]);

                    // $payment_intent = $this->my_stripe->createPaymentIntent([
                    // 	'amount' => $cents,
                    //     'currency' => 'GBP'
            		// ]);

                    // pr($payment_intent);

                    $res['subscriptionId'] = $subscription->id;
					// $res['clientSecret'] = $subscription->latest_invoice->payment_intent->client_secret;
					// $res['clientSecret'] = $payment_intent->client_secret;
					$res['clientSecretSetup'] = $setupintent->client_secret;
					$res['customerId'] = $customer_id; 
                    $res['paymentMethodId'] = $vals['payment_method'];
                    $res['status'] =1;
                    exit(json_encode($res));

            } else {
                $res['msg'] = 'Technical Problem! Please contact to admin.';
                $res['status'] = 0;
                exit(json_encode($res));
            }
        }
        exit(json_encode($res));
    }

    public function subscribe_plan()
    {
        $tokenResponse = $this->verifyAuthToken($this->input->post('token'), '192.168.1.0618');
        if ($tokenResponse['error'] === 1) {
            http_response_code(400);
            echo json_encode($tokenResponse);
            exit;
        } else {
            $mem_id = $tokenResponse['mem_id'];
        }

        $res = array();
        $res['hide_msg'] = 0;
        $res['scroll_top'] = 0;

		$vals = $this->input->post();
        

		$mem = $this->master->getRow('members', ['mem_id'=> $mem_id]);
        

		$plan_id = intval($this->input->post('plan_id'));
		$plan = $this->master->getRow('plans', ['id'=> $plan_id]);
	
		$this->load->library('My_stripe');
		$subscription = $this->my_stripe->subscription_record($vals['subscriptionId']);
        // pr($subscription);
		if(!empty($subscription->id))
		{
            if($vals['plan_type'] == "monthly") {
                $price = $plan->monthly_price;
                $stripe_price_id = $plan->stripe_id_monthly;
            }
            if($vals['plan_type'] == "yearly") {
                $price = $plan->yearly_price;
                $stripe_price_id = $plan->stripe_id_yearly;

            }

            $payment_intent = json_decode($vals['paymentIntent']);

			$subArr = 
			[
				'mem_id'        => $mem->mem_id,
				'plan_id'       => $plan_id, 
                'plan_name' => $plan->plan_name,
				'stripe_subscription_id' => $subscription->id,
				'stripe_customer_id' => $subscription->customer,
				'stripe_price_id' => $stripe_price_id,
                'payment_method_id' => $vals['paymentMethodId'],
                'payment_intent_id' => $payment_intent->id,
				'mem_fullname'     => $vals['fullname'],
				'mem_email'     => $vals['email'],
				'mem_phone'     => $vals['phone'],
				'price'         => $price, 
				'start_date'    => date('Y-m-d H:i:s', $subscription->current_period_start),
				'end_date'      => date('Y-m-d H:i:s', $subscription->current_period_end),
				'status'        => '1',
				'created_date'  => date('Y-m-d'),
				'payment_method' =>'credit-card',
                'subscription_status' => $subscription->status,
               
			];
            // pr($subArr);

			$subscribe_id = $this->master->save('subscribed_plans', $subArr);
            
            if($subscribe_id > 0){
                $this->master->update('members', ['mem_type' => 'professional'], array('mem_id' => $mem->mem_id));
                $mem_data = array(
                    'name' => $mem->mem_fname, 
                    "email" => $mem->mem_email, 
                    'plan_price'=> $price, 
                    'plan_name'=> $plan->plan_name, 
                    'plan_interval'=> $vals['plan_type'], 
    
                );
                $mem_row = $this->member->getMemData($mem->mem_id);
                $this->send_subscription_plan_successful($mem_data);
                $this->send_subscription_plan_successful_admin($mem_data);
    
                // $res['subscription'] = $subscription;
                $res['signup'] = $vals['signup'];
                $res['msg'] = 'You successfully subscribed a plan.';
                $res['status'] =1;
                $res['memVerified'] = $mem_row->mem_verified ? true : false;
                $res['mem_type']  = $mem_row->mem_type;
                $res['redirect_url'] = base_url();
                exit(json_encode($res));
            }else{
                $res['msg'] = 'Something went wrong. Please try again.';
			$res['status'] = 0;
			exit(json_encode($res));
            }
              
			
		}
		else
		{
			$res['msg'] = 'Something went wrong. Please try again.';
			$res['status'] = 0;
			exit(json_encode($res));
		}
        exit(json_encode($res));
    }


    

}
