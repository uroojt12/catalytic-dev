<?php

class Orders extends SUBADMIN_Controller {

    public function __construct() {
        parent::__construct();
        $this->isLogged();
        $this->load->library('pagination');
        $this->load->model('orders_model');
        $this->operator=$this->getActiveOperator();
        // pr($this->operator);
    }

    public function index() {
        $this->data['pageView'] = LOCATION . '/orders';
        $this->data['page_title'] = 'Upcoming Orders';
		//$aRow =MessageEmail('PKVCDRW3',"Abida Rehman","abidaa.rehman@gmail.com");
		//pr($aRow);
        $search = '';
        $get = $this->input->get();
        if (isset($get['keyword']) && !empty($get['keyword']))
            $search = $get;
        $return2 = array();
        //$this->data['rows'] = $this->orders_model->searchOrders($search);
        $orders = $this->orders_model->orderOperatorsVideos($this->operator->loc_id);
        // pr($orders);
        foreach($orders as $order){
            $oID=$order->ord_id;
            $first = json_decode(json_encode($order),true);
            // pr($first);
            $second=$this->orders_model->get_order_timeslots($oID);
            // pr($second);
            // pr($this->db->last_query());
            $return2[] = array_merge($first,['timeslots'=>$second]);
            // pr($return2);
        }
        $this->data['rows'] = $return2;
        // pr($this->data['rows']);
        $this->load->view(LOCATION . '/includes/siteMaster', $this->data);
    }
    public function get_todayorders(){
        $output = '';
        $orders = $this->orders_model->getTodayVideosOperators($this->operator->loc_id);
        if(!empty($orders)){
            foreach($orders as $order){
                
                $output .='
                    <tr>
                        <td>'.setOrderNo($order->ord_id).'</td>
                        <td>'.get_member_name($order->mem_id).'</td>
                        <td>
                            <video controls class="prop_video" id="video_tag" style="width:150px">
                                 <source src="'.get_site_image_src("videos", $order->video).'" id="video_src">
                                         Your browser does not support HTML5 video.
                            </video>
                        </td>
                        <td>'.date("g:i A", strtotime($order->t_start_time)).'</td>
                    </tr>
                ';
            }
        }
        else{
            $output .=' <tr>
                    <td colspan="4">No order for today date</td>
                </tr>';

                // pr($output);
        }
        exit(json_encode($output));
    }
    public function updateVideoStartTime()
    {
        $vals=$this->input->post();
        // pr($vals);
        $row=$this->master->getRow("mem_timeslots",array("id"=>$vals['mem_t_id']));
        // pr($this->db->last_query());
        if(!empty($row)){
            $arr=array(
                'video_start_time'=>$vals['vid_st']
            );
            $id=$this->master->save("mem_timeslots",$arr,'id',$row->id);
            $res['status']=1;
            $res['msg']="Updated";
            exit(json_encode($res));
        }
    }
    function add_column_database(){
        $this->load->dbforge();
        $fields = array(
                'status' => array('type' => 'TINYINT','default' => '0')
        );
        $q=$this->dbforge->add_column('mem_timeslots', $fields);
        if($q){
            echo "success";
            pr($this->master->getRows('mem_timeslots'));
        }
        else{
            echo "error";
        }
    }
    public function updateTimeslotStatus(){
        $vals=$this->input->post();
        $row=$this->master->getRow("mem_timeslots",array("id"=>$vals['mem_t_id']));
        // pr($row);
        if(!empty($row)){
            $arr=array(
                'status'=>1,
                'video_end_time'=>$vals['end_time']
            );
            $id=$this->master->save("mem_timeslots",$arr,'id',$row->id);
            if($id>0){
                $order_timeslots=$this->orders_model->getRemainingTimeslots($row->ord_id);
                // pr($order_timeslots);
                if(empty($order_timeslots)){
                    $o_arr=array(
                        'order_status'=>'complete'
                    );
                    $this->master->save("orders",$o_arr,"ord_id",$row->ord_id);
                    $order=$this->orders_model->getOrder($row->ord_id);
                    $mem=getMemberData($order->mem_id);
                    $date = new DateTime('+1 day');
                    $expiry= $date->format('Y-m-d H:i:s');
                    $order_array=array(
                        'token'=>randCode(),
                        'order_id'=>$row->ord_id,
                        'mem_id'=>$mem->mem_id,
                        'expiry_date'=>$expiry,
                    );
                    $token = $this->master->save('order_tokens', $order_array);
                    if($token>0){
                            $w_row=$this->master->getRow('order_tokens', array('id' => $token));
                            $link  = base_url('orderDetails').'/'.$w_row->token;
                            $mem_data=array(
                                'name'=>get_member_name($mem->mem_id),
                                'email'=>$mem->mem_email,
                                'ord_id'=>$row->ord_id,
                                'link'=>$link
                            );
                            $q=$this->send_orderComplete_email($mem_data);
                    }
                    $res['email']=$q;
                    $res['order_id']=$mem_data['ord_id'];
                }
                $res['status']=1;
                $res['msg']="Updated";
            }
            else{
                $res['status']=0;
                $res['msg']="Not Updated";
            }
            exit(json_encode($res));
            
        }
    }
    public function play_all_videos(){
        $output = '';
        $orders = $this->orders_model->getTodayVideosOperators($this->operator->loc_id);
        // pr(date('Y-m-d'));
        // pr($this->db->last_query());
        exit(json_encode($orders));
    }
    public function today_orders() {
        $this->data['pageView'] = LOCATION . '/orders';
        $this->data['page_title'] = 'Today orders';
		//$aRow =MessageEmail('PKVCDRW3',"Abida Rehman","abidaa.rehman@gmail.com");
		//pr($aRow);
        $search = '';
        $get = $this->input->get();
        if (isset($get['keyword']) && !empty($get['keyword']))
            $search = $get;

        //$this->data['rows'] = $this->orders_model->searchOrders($search);
        $orders = $this->orders_model->getTodayOrdersOperators($this->operator->loc_id);
        foreach($orders as $order){
            $oID=$order->ord_id;
            $first = json_decode(json_encode($order),true);
            $second=$this->orders_model->get_order_timeslots($oID);
            $return2[] = array_merge($first,['timeslots'=>$second]);
        }
        $this->data['rows'] = $return2;
        $this->load->view(LOCATION . '/includes/siteMaster', $this->data);
    }

    function manage() {
        $this->data['pageView'] = LOCATION . '/orders';
        $this->data['row'] = $this->orders_model->getOrder($this->uri->segment('4'));
        $this->data['page_title'] = 'Order # '.setOrderNo($this->uri->segment('4'));
        $this->data['member'] = getMemberData($this->data['row']->mem_id);
        // pr($this->data['member']);
        $this->load->view(LOCATION . '/includes/siteMaster', $this->data);
    }

    function order_print() {
        $data['row'] = $this->orders_model->getOrder($this->uri->segment('4'));
        $data['products'] = $this->orders_products_model->getOrderProducts($this->uri->segment('4'));
        $data['checkout'] = unserialize($data['row']->o_checkout);
        if ($data['row']->o_type == 'register'):
            $data['member'] = getMemberData($data['row']->mem_id);
        else:
            $data['member'] = $data['checkout']['co_ship'];
        endif;

        $data['ship'] = $data['checkout']['co_ship'];
        $this->load->view('LOCATION/orders_print', $data);
    }

    function images_delete() {
        $this->orders_images_model->delete($this->uri->segment('4'));
        redirect('LOCATION/orders', 'refresh');
    }

    function update_status() {
        if ($this->uri->segment(4) != ''):
            if ($post = $this->input->post()):
                $order = $this->master->getRow('orders', array('ord_id' => $this->uri->segment(4)));
                $ar['mem_id'] = $order->mem_id;

                $v['order_status'] = $post['id'];				
				$member=get_mem_row($order->mem_id);
                $this->master->save('orders', $v, 'ord_id', $this->uri->segment(4));
                $txt = 'Your Order has been '.get_order_status($v['order_status']).'  <a href="'.site_url('order-detail/'.doEncode($order->ord_id)).'">View Order</a>';
                    save_notificaiton($member->mem_id,$this->data['LOCATIONsite_setting']->site_id,  $txt);				 
				// $this->send_shipment_email(intval($this->uri->segment(4)),$member,$post['id']);

                //$this->orders_model->update_status($this->uri->segment(4), $post['id']);
            endif;
        endif;
    }

    function chat($ord_id,$member_id){
        $this->data['member_row'] = $this->master->getRow('members', array('mem_id' => $member_id));
        $this->data['member_name'] = $this->data['member_row']->mem_fullname;
        $this->data['ord_id'] = $ord_id;
        $this->data['member_id'] = $member_id;
        $this->data['enable_datatable'] = "TRUE";
        $this->data['msgs'] = $this->master->query("SELECT * FROM (SELECT * FROM tbl_msgs WHERE (sender = ".$member_id." || receiver = ".$member_id.") AND ord_id = ".$ord_id." ORDER BY id DESC limit 0,7) as alias ORDER BY id ASC");
        $this->data['pageView'] = "LOCATION/chat";
        $this->load->view('LOCATION/includes/siteMaster', $this->data);
    }

    // function send_msg(){
    //     extract($_GET);
    //     $memberRow = $this->master->getRow('members', array('mem_id' => $user_id));
    //     $uPic =  ($memberRow->mem_image == '') ? DEFAULT_IMG : SITE_IMAGES.$memberRow->mem_image;
    //     $aPic = DEFAULT_IMG;
    //     $this->db->query("UPDATE tbl_msgs set status = 1 WHERE sender = ".$user_id." AND status = 0 and receiver = 0");
    //     $arr['sender'] = 0;
    //     $arr['receiver'] = $user_id;
    //     $arr['msg'] = htmlspecialchars($msg);
    //     $arr['ord_id'] = $ord_id;
    //     $arr['created_date'] = time();
    //     $this->master->save('msgs', $arr);
    //     echo "<li class='message left appeared'>
    //                 <div class='avatar'> <img src='".$aPic."'> </div>
    //                 <div class='text_wrapper'>
    //                     <div class='text-right'><span style='font-size:11px; color:#000'>(".date("d M Y - H:i:A", time()).")</span></div>
    //                     <div class='text'>".htmlspecialchars($msg)."</div>
    //                 </div>
    //             </li>";
    // }

    // function send_msg(){
    //     extract($_POST);
    //     $memberRow = $this->master->getRow('members', array('mem_id' => $user_id));
    //     $uPic =  ($memberRow->mem_image == '') ? DEFAULT_IMG : SITE_IMAGES.$memberRow->mem_image;
    //     $aPic = DEFAULT_IMG;
    //     $this->db->query("UPDATE tbl_msgs set status = 1 WHERE sender = ".$user_id." AND status = 0 and receiver = 0");
    //     $arr['sender'] = 0;
    //     $arr['receiver'] = $user_id;
    //     $arr['msg'] = htmlspecialchars($msg);
    //     $arr['ord_id'] = $ord_id;
    //     $arr['created_date'] = time();
    //     $lID = $this->master->save('msgs', $arr);

    //     if (isset($_FILES["uploadFile"]["name"]) && count($_FILES["uploadFile"]["name"]) > 0) {
    //         upload_product_images('./uploads/', $_FILES, 'uploadFile', $lID, 'chat');
    //     }
    //     $imgs = $this->master->getRows('pictures', array('pic_type_id' => $lID, 'pic_type' => 'chat'));
    //     if (count($imgs) > 0) {
    //         $h = '<div class="imgBlk">';
    //         foreach ($imgs as $img) {
    //             $h .= '<a href="'.getImageSrc('./uploads/' . $img->pic_image).'" download><img src="'.getImageSrc('./uploads/' . $img->pic_image).'"></a>';
    //         }
    //         $h .= '</div>';
    //     }

    //     echo "<li class='message left appeared'>
    //                 <div class='avatar'> <img src='".$aPic."'> </div>
    //                 <div class='text_wrapper'>
    //                     <div class='text-right'><span style='font-size:11px; color:#000'>(".date("d M Y - H:i:A", time()).")</span></div>
    //                     <div class='text'>".htmlspecialchars($msg)." ".$h."</div>
    //                 </div>
    //             </li>";
    //     exit();
    // }

    function send_msg(){
        extract($_POST);
        $memberRow = $this->master->getRow('members', array('mem_id' => $user_id));
        $uPic =  ($memberRow->mem_image == '') ? DEFAULT_IMG : base_url().SITE_IMAGES."members/".$memberRow->mem_image;
        $aPic = DEFAULT_IMG;
        $this->db->query("UPDATE tbl_msgs set status = 1 WHERE sender = ".$user_id." AND status = 0 and receiver = 0");
        $arr['sender'] = 0;
        $arr['receiver'] = $user_id;
        $arr['msg'] = htmlspecialchars($msg);
        $arr['ord_id'] = $ord_id;
        $arr['created_date'] = time();
        $lID = $this->master->save('msgs', $arr);
		if($lID>0){
			$date = new DateTime('+1 day');
			$expiry= $date->format('Y-m-d H:i:s');
			$work_array=array(
				'token'=>randCode(),
				'order_id'=>$ord_id,
				'user_id'=>$user_id,
				'expiry_date'=>$expiry,
			);
			$q = $this->master->save('workroom_tokens', $work_array);
			if($q>0){
				$w_row=$this->master->getRow('workroom_tokens', array('id' => $q));
				$member=getMemberData($user_id);
				// MessageEmail($w_row->token,ucwords($member->mem_fullname),$member->mem_email);
			}
		}
        for ($i=0; $i<count($img); $i++) { 
            $pico['pic_type_id'] = $lID;
            $pico['pic_type'] = 'chat';
            $pico['pic_image'] = $img[$i];
            $pico['pic_thumb'] = $img[$i];
            $this->master->save('pictures', $pico);
        }
        $imgs = $this->master->getRows('pictures', array('pic_type_id' => $lID, 'pic_type' => 'chat'));
        if (count($imgs) > 0) {
            $h = '<div class="imgBlk">';
            foreach ($imgs as $imgo) {
                $h .= '<a href="'.getImageSrc('./uploads/' . $imgo->pic_image).'" download><img src="'.getImageSrc('./uploads/' . $imgo->pic_image).'"></a>';
            }
            $h .= '</div>';
        }

        echo "<li class='message left appeared'>
                    <div class='avatar'> <img src='".$aPic."'> </div>
                    <div class='text_wrapper'>
                        <div class='text-right'><span style='font-size:11px; color:#000'>(".date("d M Y - H:i:A", time()).")</span></div>
                        <div class='text'>".htmlspecialchars($msg)." ".$h."</div>
                    </div>
                </li>";
        exit();
    }

    function retrieve_msg(){
        extract($_GET);
        $msgs = $this->master->getRows('msgs', array('ord_id' => $ord_id, 'sender' => $user_id, 'status' => 0));
        $memberRow = $this->master->getRow('members', array('mem_id' => $user_id));
        $uPic =  ($memberRow->mem_image == '') ? DEFAULT_IMG : base_url().SITE_IMAGES."members/".$memberRow->mem_image;
        if (count($msgs) > 0) {
            $h = '';
            foreach ($msgs as $msg){

                $im = '';
                $imgs = $this->master->getRows('pictures', array('pic_type_id' => $msg->id, 'pic_type' => 'chat'));
                if (count($imgs) > 0) {
                    $im = '<div class="imgBlk">';
                    foreach ($imgs as $img) {
                        $im .= '<a href="'.getImageSrc('./uploads/' . $img->pic_image).'" download><img src="'.getImageSrc('./uploads/' . $img->pic_image).'"></a>';
                    }
                    $im .= '</div>';
                }

                $h .= "<li class='message right appeared'>
                        <div class='avatar'> <img src='".$uPic."'> </div>
                        <div class='text_wrapper'>
                            <div class='text-right'><span style='font-size:11px; color:#000'>(".date("d M Y - H:i:A", $msg->created_date).")</span></div>
                            <div class='text'>".htmlspecialchars($msg->msg)." ".$im."</div>
                        </div>
                    </li>";

                $arr['status'] = 1;
                $this->master->save('msgs', $arr, 'id', $msg->id);
            }
            echo $h;
        }else{
            echo '0';
        }
    }

    public function retrieve_top_msg(){
        extract($_GET);
        $memberRow = $this->master->getRow('members', array('mem_id' => $user_id));
        $limit = 6;
        $offset = $limit * $page;
        $msgs = $this->master->query("SELECT * FROM (SELECT * FROM tbl_msgs WHERE (sender = ".$user_id." || receiver = ".$user_id.") AND ord_id = ".$ord_id." ORDER BY id DESC limit $offset,$limit) as alias ORDER BY id ASC");
        if (count($msgs) > 0) {
            $h = '';
            foreach ($msgs as $msg){
                $pos = ($msg->sender < 1) ? 'left' : 'right';
                if($msg->sender < 1){
                    $pico = DEFAULT_IMG;
                }else{
                    $pico = ($memberRow->mem_image == '') ? DEFAULT_IMG : base_url().SITE_IMAGES."members/".$memberRow->mem_image;
                }
                $im = '';
                $imgs = $this->master->getRows('pictures', array('pic_type_id' => $msg->id, 'pic_type' => 'chat'));
                if (count($imgs) > 0) {
                    $im = '<div class="imgBlk">';
                    foreach ($imgs as $img) {
                        $im .= '<a href="'.getImageSrc('./uploads/' . $img->pic_image).'" download><img src="'.getImageSrc('./uploads/' . $img->pic_image).'"></a>';
                    }
                    $im .= '</div>';
                }

                $h .= "<li class='message ".$pos." appeared'>
                        <div class='avatar'> <img src='".$pico."'> </div>
                        <div class='text_wrapper'>
                            <div class='text-right'><span style='font-size:11px; color:#000'>(".date("d M Y - H:i:A", $msg->created_date).")</span></div>
                            <div class='text'>".htmlspecialchars($msg->msg)." ".$im."</div>
                        </div>
                    </li>";
            }
            echo $h;
        }else{
            echo '0';
        }
    }

    public function upld_img(){
        extract($_POST);
		$res=array();
        if (isset($_FILES["uploadFile"]["name"]) && $_FILES["uploadFile"]["name"] != "") {
            $image = upload_image('./uploads/', 'uploadFile');
			
            if (!empty($image['file_name'])) {
				 $res['status'] = 1;
                $res['image'] = $image['file_name'];
            }
			 else {
				$res['status'] = 0;
				$res['msg']="Error >> ".$image['error'];
			  }
			  exit(json_encode($res));
			
        }
    }

    function delete() {
        $this->orders_model->delete($this->uri->segment('4'));
        $this->master->delete('cart', 'ord_id', $this->uri->segment('4'));
        $this->master->delete('shipping_info', 'ord_id', $this->uri->segment('4'));
        
        redirect('LOCATION/orders', 'refresh');
    }

    function status() {
        echo $this->orders_model->changeStatus($this->uri->segment('4'));
    }

}

?>