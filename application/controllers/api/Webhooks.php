<?php
class Webhooks extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
		header('Content-Type: application/json');
		$this->load->library('My_stripe');

    }

		public function stripe_events()
		{
			$payload = @file_get_contents('php://input');
			$sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
			$endpoint_secret = STRIPE_WEBHOOK_SECRET_KEY;
			$is_verified_event = false;
			$is_verified_event  = $this->my_stripe->verify_webhook_event($payload, $sig_header, $endpoint_secret);
		
            writ_post_data('response', $payload);
			if($is_verified_event)
			{
				$event = json_decode($payload);
				if($event->type === 'invoice.payment_succeeded')
				{
					$data = $event->data->object; 
					if($data->billing_reason === 'subscription_cycle')
					{
						// GET UPDATED SUBSCRIPTION RECORD
						$subscription = $this->my_stripe->subscription_record($data->subscription);

						$subscription_id = $subscription->id; 
						$new_start_date = date('Y-m-d H:i:s', $subscription->current_period_start);
						$new_end_date = date('Y-m-d H:i:s', $subscription->current_period_end);
						
						// SUBSCRIPTION RECORD BEFORE RENEWAL
						$previous_subscription_record = $this->master->getRow('subscribed_plans', ['stripe_subscription_id'=> $subscription_id]);

						// UPDATE SUBSCRIPTION TIME PERIOD
						$this->master->save('subscribed_plans', ['start_date'=> $new_start_date, 'end_date'=> $new_end_date], 'stripe_subscription_id', $subscription_id);

						// CUSTOMER PAYMENT HISTORY
						$renewal_paid_amount = $data->amount_paid / 100;
						$this->master->save('customer_payment_history', 
							[	
								'description' => 'Renewal payment sucessfull',
								'amount' => $renewal_paid_amount,
								'transaction_date' => date('Y-m-d', $event->created),
								'transaction_time' => date('H:i:s', $event->created),
								'subscription_id' => $subscription_id,
								'mem_id' => $previous_subscription_record->mem_id
							]
						);

						$this->master->save('webhook_stripe_events', ['payload'=> $payload, 'sig_header'=> $sig_header, 'endpoint_secret'=> $endpoint_secret]);

						http_response_code(200);
						exit();
					}
				}
			}
		}

}
