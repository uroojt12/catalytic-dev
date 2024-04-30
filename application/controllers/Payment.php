
<?php

use function PHPSTORM_META\type;

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Payment extends MY_Controller
{

    function  __construct()
    {

        parent::__construct();

        $this->load->model('video_model');
    }
    public function create_payment()
    {
        // pr("hi");
        $json_obj = json_decode(file_get_contents('php://input'));
        $post = html_escape((array) $json_obj->data);
// pr($post);

        $card = $json_obj->card;
        $card_data = array(
            'card_brand' => $card->brand,
            'card_exp_month' => $card->exp_month,
            'card_exp_year' => $card->exp_year,
            'card_number' => $card->last4,
        );
        // pr($card_data);
        if (empty($post['fname']) && empty($post['lname']) && empty($post['email']) && empty($post['address']) && empty($post['country']) && empty($post['state']) && empty($post['city']) && empty($post['postal_code'])) {
            echo json_encode(['error' => 'Fill all the required fields!']);
            exit;
        }



        if(!empty($post['apply_promo']) && empty($post['promo_code_id'])){
            echo json_encode(['error' => "Please Apply Vaild Promo Code as you checked the box to apply promo code. If you don't have Valid Promo Code Please uncheck the Promocode checkbox!"]);
            exit;
        }

        $video_id = doDecode($post['video_id']);
        $video_id = intval($video_id);
        $video = $this->video_model->get_row_where(array('id' => $video_id, 'status' => 1));

        // pr($post);
        if (empty($video)) {
            echo json_encode(['error' => 'Please Choose valid Video']);
            exit;
        } 

        $cost = $video->price;
        $totalToPay = $cost;

        // echo($totalToPay);



        $amount = floatval($totalToPay);
        // echo($amount);
        if ($amount < 0.5) {
            echo json_encode(['error' => 'Order amount is too low to charge!']);
            exit;
        }
        $cents = intval($amount * 100);
        // pr($cents);
        if (!$json_obj) {
            die(json_encode("Could not parse JSON request"));
        }
        if (!isset($json_obj->payment_method_id)) {
            die(json_encode("No payment_method_id provided"));
        }
        include_once APPPATH . "libraries/vendor/autoload.php";
      
        $this->load->library('My_stripe');

        $cus_info = [
            'name' => ucfirst($post['fname']). ' '. ucfirst($post['lname']),
            'email' => $post['email'],
            'payment_method' => $json_obj->payment_method_id,
            
        ];

        $customer_id = $this->my_stripe->save_customer($cus_info);
        
        $this->session->set_userdata('customer_id', $customer_id);

        // pr($this->session->customer_id);
        $intent = $this->my_stripe->createPaymentIntent([
            'payment_method' => $json_obj->payment_method_id,
            'amount' => $cents,
            'currency' => 'EUR',
            'customer' => $customer_id,
            'confirmation_method' => 'manual',
            'confirm' => true,
            'off_session' => true
        ]);

        // pr($intent);
        $card_data['payment_method_id'] = $json_obj->payment_method_id;
        $card_data['payment_intent'] = $intent->id;

        $card_data['customer_id']=$customer_id;
        // pr($card_data);

        $this->session->set_userdata('payment_intent_id', $intent->id);


        // pr($this->session->payment_intent_id);

        if (
            $intent->status == 'requires_source_action' &&
            $intent->next_action->type == 'use_stripe_sdk'
        ) {

            // pr("requires_source_action");
            # Tell the client to handle the action
            echo json_encode([
                'requires_action' => true,
                'payment_intent_client_secret' => $intent->client_secret,
                'card' => $card_data,
            ]);
        } else if ($intent->status == 'requires_action') {

            // pr("requires_action");

            # Tell the client to handle the action
            echo json_encode([
                'requires_action' => true,
                'payment_intent_client_secret' => $intent->client_secret,
                'card' => $card_data
            ]);
        } else if ($intent->status == 'succeeded') {
            # The payment didn’t need any additional actions and completed!
            # Handle post-payment fulfillment
            // pr("succeed");

            echo json_encode([
                'success' => true,
                'card' => $card_data
            ]);
        } else {
            # Invalid status
            // pr("error");

            http_response_code(500);
            echo json_encode(['error' => 'Invalid PaymentIntent status']);
            exit;
        }
        // }
        // else{
        //     echo json_encode(['error' => 'No products found']);exit;
        // }

    }



    public function confirm_payment()
    {
        $json_obj = json_decode(file_get_contents('php://input'));
        // pr($json_obj);
        if (!$json_obj) {
            die(json_error("Could not parse JSON request"));
        }
        if (!isset($json_obj->payment_intent_id)) {
            die(json_error("No payment_intent_id provided"));
        }
        include_once APPPATH . "libraries/vendor/autoload.php";
        // \Stripe\Stripe::setApiKey( $this->data['site_settings']->site_stripe_type == 1 ? $this->data['site_settings']->site_stripe_testing_secret_key : $this->data['site_settings']->site_stripe_live_secret_key);
        $stripe = new \Stripe\StripeClient(
            $this->data['site_settings']->site_stripe_type == 1 ? $this->data['site_settings']->site_stripe_testing_secret_key : $this->data['site_settings']->site_stripe_live_secret_key
        );
        $intent = $stripe->paymentIntents->retrieve($json_obj->payment_intent_id);
        try {
            $intent->confirm();
        } catch (\Stripe\Error\InvalidRequest $err) {
            die(json_error($err->getMessage()));
        } catch (\Stripe\Error\Card $err) {
            die(json_error($err->getMessage()));
        }
        if (
            $intent->status == 'requires_action' &&
            $intent->next_action->type == 'use_stripe_sdk'
        ) {
            # Tell the client to handle the action
            echo json_encode([
                'requires_action' => true,
                'payment_intent_client_secret' => $intent->client_secret,
                'card' => $json_obj->card
            ]);
        } else if ($intent->status == 'succeeded') {
            # The payment didn’t need any additional actions and completed!
            # Handle post-payment fulfillment
            echo json_encode([
                'success' => true,
                'card' => $json_obj->card
            ]);
        } else {
            # Invalid status
            http_response_code(500);
            echo json_encode(['error' => 'Invalid PaymentIntent status']);
        }
    }
}
