<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// ini_set('display_errors',1);
// error_reporting(E_ALL);
require_once (APPPATH . 'vendor/stripe/stripe-php/init.php');
class My_stripe
{

	private $secert_key = null;
	public function __construct()
	{
		$this->secert_key = API_SECRET_KEY;
		\Stripe\Stripe::setApiKey(API_SECRET_KEY);
	}


	/*** start customer ***/

	function save_customer($parms, $customer_id = '')
	{
		try {

			if(empty($customer_id)){
				$customer = \Stripe\Customer::create($parms);
				if($customer)
					return $customer->id;
				return false;
			}else{
				$customer = \Stripe\Customer::update($customer_id, $parms);
				if($customer)
					return $customer->id;
				return false;
			}
		} catch (Exception $e) {
			// echo $e->getMessage();
			return false;
		}
	}

	function delete_customer($customer_id)
	{
		try {
			$customer = \Stripe\Customer::retrieve($customer_id);
			if($customer)
				$customer->delete();
			return false;	
		} catch (Exception $e) {
			// echo $e->getMessage();
			return false;
		}
	}

	function get_customer($customer_id)
	{
		$stripe = $this->create_stripe_clinet();
		try {
			$customer = $stripe->customers->retrieve(
				$customer_id,
				[]
			  );
			return $customer;	
		} catch (Exception $e) {
			// exit($e->getMessage());
			return false;
		}
	}

	function make_defualt_payment_method($customer_id, $card_id)
	{
		try {
			$customer = \Stripe\Customer::update($customer_id,
				[
					'default_source' => $card_id
				]
			);
			// pr($customer);
			if($customer)
				return $customer->id;
			return false;
		} catch (Exception $e) {
			// echo $e->getMessage();
			return false;
		}
	}

	/*** end customer ***/

	/*** start Payment Method ***/

	function create_payment_method($customer_id, $nonce)
	{
		try {
			$card = \Stripe\Customer::createSource(
				$customer_id,
				[
					'source' => $nonce,
				]
			);
			if($card)
				return $card;
			return false;
		} catch (Exception $e) {
			exit($e->getMessage());
			return false;
		}
	}

	function delete_payment_method($customer_id, $card_id)
	{
		try {
			$card = \Stripe\Customer::deleteSource($customer_id, $card_id);
			if($card->deleted)
				return true;
			return false;
		} catch (Exception $e) {
			// echo $e->getMessage();
			return false;
		}
	}

	/*** end Payment Method ***/

	function generate_client_token()
	{
		return $this->gateway->clientToken()->generate();
	}

	/*** start Charge ***/

	function charge_customer($amount, $customer_id, $description = '')
	{
		try {
			$cents = floatval($amount*100);
			$charge = \Stripe\Charge::create([
				"amount" => $cents,
				"currency" => "EUR",
				'customer' => $customer_id,
                "description" => $description
			]);

			if($charge)
				return $charge->id;
				// return $result->transaction->id;
			return false;
		} catch (Exception $e) {
			// echo $e->getMessage();
			return false;
		}
	}

	function charge($customer_id, $card_id, $amount, $description = '')
	{
		try {
			$cents = floatval($amount*100);
			$charge = \Stripe\Charge::create([
				"amount" => $cents,
				"currency" => "EUR",
				'customer' => $customer_id,
				'source' => $card_id,
                "description" => $description
			]);
			if($charge)
				return $charge->id;
				// return $charge->transaction->id;
			return false;
		} catch (Exception $e) {
			exit($e->getMessage());
			return false;
		}
	}

	function charge_by_nonce($nonce, $amount, $description = '')
	{
		try {
			$cents = floatval($amount*100);
			$charge = \Stripe\Charge::create([
				"amount" => $cents,
				"currency" => "EUR",
				'source' => $nonce,
                "description" => $description
			]);
			if($charge)
				return $charge->id;
			return false;
		} catch (Exception $e) {
			// exit($e->getMessage());
			return false;
		}
	}

	/*** start refund ***/


	function partial_refund($charge_id, $amount, $description = '')
	{
		try {
			$cents=floatval($amount * 100);
			$refund = \Stripe\Refund::create([
				'charge' => $charge_id,
				'amount' => $cents
			]);
			// $refund_array = serialize($refund->__toArray(true));
			
			if($refund)
				return $refund->id;
				// return $refund->transaction->id;
			return false;
		} catch (Exception $e) {
			// exit($e->getMessage());
			return false;
		}
	}

	function refund($charge_id, $description = '')
	{
		try {
			$cents=floatval($amount*100);
			$refund = \Stripe\Refund::create([
				'charge' => $charge_id
			]);
			// $refund_array = serialize($refund->__toArray(true));
			
			if($refund)
				return $refund->id;
				// return $refund->transaction->id;
			return false;
		} catch (Exception $e) {
			exit($e->getMessage());
			return false;
		}
	}

	/*** end refund ***/

	/*** start subscription ***/

	function subscrib_customer($customer_id, $price_id, $description = '')
	{
		try {
			$subscription = \Stripe\Subscription::create([
				'customer' => $customer_id,
				'items' => [
					['price' => $price_id],
				],
			]);

			return $subscription;
			if($subscription->status == 'active')
				pr($subscription);
				return $subscription->id;
				// return $result->transaction->id;
			return false;
		} catch (Exception $e) {
			exit($e->getMessage());
			return false;
		}
	}

	function subscription_update($sub_id,$price_id,$subscriptionItemId){
		try {
		    $subscription = \Stripe\Subscription::update(
		        $sub_id,
		        [
		            'items' => [
		                [
		                	'id'=>$subscriptionItemId,
		                    'price' => $price_id, // Replace with the ID of the new price you want to apply
		                ],
		            ],
		            // Other subscription parameters you want to update
		        ]
		    );

		    if(!empty($subscription) && !empty($subscription->id)){
		    	return $subscription;
		    }
		    else{
		    	return array(
		    		'subscription'=>$subscription,
		    		'status'=>0
		    	);
		    }
		} catch (\Stripe\Exception\ApiErrorException $e) {
		    return array(
		    		'error'=>$e->getMessage(),
		    		'status'=>0
		    );
		}
	}
	function subscription_cancel($sub_id)
	{
		try {
			// $subscription = \Stripe\Subscription::update(
			// 	$sub_id,
			// 	[
			// 		'cancel_at_period_end' => true,
			// 	]
			// );
			$subscription = \Stripe\Subscription::retrieve($sub_id);
			$subscription->cancel();
			// if($subscription)
			// 	return $subscription->id;
			return true;
		} catch (Exception $e) {
			exit($e->getMessage());
			return false;
		}
	}

	function subscription_record($sub_id)
	{
		try {
			$subscription = \Stripe\Subscription::retrieve($sub_id);
			// $subscription->cancel();
			if($subscription)
				return $subscription;
		} catch (Exception $e) {
			exit($e->getMessage());
			return false;
		}
	}


//added
	function create_plan($info)
	{
		$stripe = $this->create_stripe_clinet();
		try{
			$plan = $stripe->prices->create($info);
			return $plan;
		}catch(Exception $e){
			setMsg('error', $e->getMessage());
			return array("error"=>$e->getMessage());
		}
	}

	function createPaymentIntent($info)
	{
		$stripe = $this->create_stripe_clinet();
		try{
			$paymentIntent = $stripe->paymentIntents->create($info);
			return $paymentIntent;
		}catch(Exception $e){
			
			return array("error" => $e->getMessage());
		}
	}

	function setupIntents($info)
	{
		$stripe = $this->create_stripe_clinet();
		try{
			$paymentIntent = $stripe->setupIntents->create($info);
			return $paymentIntent;
		}catch(Exception $e){

			return array("error" => $e->getMessage());
		}
	}

	function get_plan ($plan_id)
	{
		$stripe = $this->create_stripe_clinet();
		try{
			$plan=$stripe->prices->retrieve(
				$plan_id,
				[]
			  );
			
			return $plan;
		}catch(Exception $e){
			setMsg('error', $e->getMessage());
			return array("error"=>$e->getMessage());
		}
	}
	function retrieve_subscription ($subscriptionId)
	{
		$stripe = $this->create_stripe_clinet();
		try{
			$subscription=$stripe->subscriptions->retrieve($subscriptionId);
			
			return $subscription;
		}catch(Exception $e){
			setMsg('error', $e->getMessage());
			return array("error"=>$e->getMessage());
		}
	}

	// function subscribe_plan_new($customer_id, $plan_id)
	// {

	// 	$currentTimestamp = time(); // Get the current timestamp
	// 	$futureTimestamp = strtotime('+90 days', $currentTimestamp);

	// 	$stripe = $this->create_stripe_clinet();
	// 	try{
	// 		$subscribe = $stripe->subscriptions->create([
	// 		  'customer' => $customer_id,
	// 		  'items' => [['price' => $plan_id]],
	// 		  'trial_end' => $futureTimestamp,
	// 		  'payment_behavior' => 'default_incomplete', 
	// 		  'expand' => ['latest_invoice.payment_intent']
	// 		]);
	// 		return $subscribe;
	// 	}catch(Exception $e){
	// 		exit(json_encode(['status' =>0, 'error' => $e->getMessage()]));
	// 		return false;
	// 	}
	// }
	function subscribe_plan_new($customer_id, $plan_id)
	{
		$currentTimestamp = time(); // Get the current timestamp
		$futureTimestamp = strtotime('+90 days', $currentTimestamp);
	    $stripe = $this->create_stripe_clinet();
	    try {
	        $subscribe = $stripe->subscriptions->create([
	            'customer' => $customer_id,
	            'items' => [['price' => $plan_id]],
	            'payment_behavior' => 'default_incomplete',
	            'trial_end' => $futureTimestamp, 
	            'expand' => ['latest_invoice.payment_intent']
	        ]);
	        return $subscribe;
	    } catch (Exception $e) {
	        exit(json_encode(['status' => 0, 'error' => $e->getMessage()]));
	        return false;
	    }
	}


	public function verify_webhook_event($payload, $sig_header, $endpoint_secret)
	{
		try {
			$event = \Stripe\Webhook::constructEvent(
			  $payload, $sig_header, $endpoint_secret
			);
			return true;
		  } catch(\UnexpectedValueException $e) {
			// exit(json_encode(['status' =>0, 'error' => $e->getMessage()]));
			return false;
		} catch(\Stripe\Exception\SignatureVerificationException $e) {
			// exit(json_encode(['status' =>0, 'error' => $e->getMessage()]));
			return false;
		  }
	}

	private function create_stripe_clinet(){
		return  new \Stripe\StripeClient($this->secert_key);	
	}




}
