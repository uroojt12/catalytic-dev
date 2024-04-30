<?php 
include_once APPPATH . "libraries/Zoom_Api.php";
if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Paypal extends MY_Controller

{

    

    function  __construct()

    {

        parent::__construct();

        $this->load->library('paypal_lib');
        // $this->load->model('cart_model','cart');
        // $this->load->model('member_model');


    }

    

    function success($encoded_id, $type){
        // pr($this->input->get());
        $payer_id=$this->input->get('PayerID');
        if($type == 'checkout'){
            
            $id = intval(doDecode($encoded_id));
            if ($row = $this->master->getRow('orders',['id' => $id])) {
                $this->master->save('orders', ['paypal_payer_id' => $payer_id, 'status' => 1, 'payment_status' => 'paid'], 'id', $row->id);
                // redirect(site_url('order-confirmed/'.doEncode($id)), "refresh");
                redirect(base_url(), "refresh");
    
            }
            else{
                show_404();
            }
        }elseif($type == 'donate'){
            $id = intval(doDecode($encoded_id));
            if ($row = $this->master->getRow('donations',['id' => $id])) {
                $this->master->save('donations', ['paypal_payer_id' => $payer_id, 'status' => 1, 'payment_status' => 'paid'], 'id', $row->id);
                // redirect(site_url('order-confirmed/'.doEncode($id)), "refresh");
                redirect(base_url(), "refresh");
    
            }
            else{
                show_404();
            }
        }else{
            show_404();
        }
        
    }
    
    function notify($type)

    {
        $raw_post_data = file_get_contents('php://input');      
        $raw_post_array = explode('&', $raw_post_data);

        $myPost = array();
        foreach ($raw_post_array as $keyval) {
            $keyval = explode ('=', $keyval);
            if (count($keyval) == 2)
             $myPost[$keyval[0]] = urldecode($keyval[1]);
        }
        $req = 'cmd=_notify-validate';      

        if (function_exists('get_magic_quotes_gpc')) {
                $get_magic_quotes_exists = true;
        }
        foreach ($myPost as $key => $value) {
            if ($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
                $value = urlencode(stripslashes($value));
            } else {
                $value = urlencode($value);
            }
            $req .= "&$key=$value";
        }
        if(!empty($this->data['site_settings']->site_paypal_sandox)):
            $ppurl = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
        else:
            $ppurl = 'https://www.paypal.com/cgi-bin/webscr';
        endif;
        $ch = curl_init($ppurl);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));

        if ( !($res = curl_exec($ch)) ) {
            error_log("Got " . curl_error($ch) . " when processing IPN data");
            curl_close($ch);
            exit;
        }

        curl_close($ch);
        $resArray = $_POST;
        if (strcmp ($res, "VERIFIED") == 0)
        {        
                        
            $resArray['Status'] = 'VERIFIED';
            $custom = $resArray['custom'];
            $txn_id = $resArray['txn_id'];
            $filename = 'order'.$txn_id.'-paid-('.date('Y-m-d-His').')';

            if($type == 'checkout'){
                if ($row = $this->master->getRow('orders',['id' => $custom, 'status' => 0])) {
                    $this->master->save('orders',array("status"=>1,'payment_status'=>'paid','txn_id'=>$txn_id),'id',$row->id);
                                   
                }
            }else{
                if ($row = $this->master->getRow('donations',['id' => $custom, 'status' => 1])) {
                    $this->master->save('donations',array("status"=>1,'payment_status'=>'paid','txn_id'=>$txn_id),'id',$row->id);
                                   
                }
            }
            

        } elseif (strcmp ($res, "INVALID") == 0) {
            $filename = 'INVALID ('.date('Y-m-d-His').')';
            $resArray['Status'] = 'INVALID';
        }

        $content = '';
        foreach($resArray as $key => $val):
            $content .= "\r\n";
            $content .= $key." = ".$val;
        endforeach;
        $filecontent = $content;
        $fp = fopen('./assets/paypal/'.$filename.".txt", "w");
        fwrite($fp, $filecontent);
        fclose($fp);
    }

    

    function cancel($id)

    {
        redirect(base_url(),'refresh');
        $id = intval(doDecode($id));
        if ($row = $this->master->getRow('orders',['id' => $id])) {
            // $this->order_model->delete_where(['id' => $id]);
            setMsg('error', "Your payment has been canceled!");
            redirect(base_url(),'refresh');
            exit;
        }
    }



    function pay_now($encoded_id, $type)
    {

        if($type == 'checkout'){
            $id = intval(doDecode($encoded_id));
            // pr($id);
            if($row = $this->master->getRow('orders',['id' => $id, 'status' => 0])) {
                $amount=$row->total_price;
                // exit('total='.$amount);
    
                $this->data['post'] = array(
                    "item_name" => "Paypal Payment",
                    "currency" => "EUR",
                    "amount" => $amount,
                    "custom" => $id
                );
                $this->data['setting'] = array(
                    "website_name" => $this->data['site_settings']->site_name,
                    "url" => site_url(),
                    "notify_url" => site_url("notify/checkout"),
                    "return_url" => site_url("success/".$encoded_id.'/checkout'),
                    "cancel_url" => site_url("cancel/".$encoded_id),
                    "sandbox" => !empty($this->data['site_settings']->site_paypal_sandox),
                    "sandbox_paypal" => $this->data['site_settings']->site_sandbox_paypal,
                    "live_paypal" => $this->data['site_settings']->site_live_paypal
                );
                // pr($this->data['setting']);
                $this->load->view("includes/processing", $this->data);
            }
            else{
               
                show_404();
            }
        }elseif($type == 'donate'){
            $id = intval(doDecode($encoded_id));
        // pr($id);
        if($row = $this->master->getRow('donations',['id' => $id, 'status' => 1])) {
            $amount=$row->amount;
            // exit('total='.$amount);

            $this->data['post'] = array(
                "item_name" => "Paypal Payment",
                "currency" => "EUR",
                "amount" => $amount,
                "custom" => $id
            );
            $this->data['setting'] = array(
                "website_name" => $this->data['site_settings']->site_name,
                "url" => site_url(),
                "notify_url" => site_url("notify/donate"),
                "return_url" => site_url("success/".$encoded_id.'/donate'),
                "cancel_url" => site_url("cancel/".$encoded_id),
                "sandbox" => !empty($this->data['site_settings']->site_paypal_sandox),
                "sandbox_paypal" => $this->data['site_settings']->site_sandbox_paypal,
                "live_paypal" => $this->data['site_settings']->site_live_paypal
            );
            // pr($this->data['setting']);
            $this->load->view("includes/processing", $this->data);
        }
        else{
           
            show_404();
        }
        }else{
            show_404();
        }

        
            
    }
    

}