<?php
defined('BASEPATH') OR exit('No direct script access allowed');
#[AllowDynamicProperties]
class Member_model extends CRUD_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table_name = "members";
        $this->field = "mem_id";

        // Set orderable column fields
        $this->column_order = array('mem_id', 'mem_fname','mem_lname','mem_email','mem_phone','mem_verified','mem_status');
        // Set searchable column fields
        $this->column_search = array('mem_fname','mem_lname','mem_email','mem_phone','mem_verified','mem_status');
        // Set default order
        $this->order = array('mem_id' => 'desc');
    }

    public function getdatatableRows($postData){
        $this->_get_datatables_query($postData);
        if($postData['length'] != -1){
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function countAll(){
        $this->db->from($this->table_name);
        return $this->db->count_all_results();
    }

    public function countFiltered($postData){
        $this->_get_datatables_query($postData);
        $query = $this->db->get();
        return $query->num_rows();
    }

    private function _get_datatables_query($postData){
         
        $this->db->from($this->table_name);
 
        $i = 0;
        // loop searchable columns 
        foreach($this->column_search as $item){
            // if datatable send POST for search
            if($postData['search']['value']){
                // first loop
                if($i===0){
                    // open bracket
                    $this->db->group_start();
                    $this->db->like($item, $postData['search']['value']);
                }else{
                    $this->db->or_like($item, $postData['search']['value']);
                }
                
                // last loop
                if(count($this->column_search) - 1 == $i){
                    // close bracket
                    $this->db->group_end();
                }
            }
            $i++;
        }
         
        if(isset($postData['order'])){
            $this->db->order_by($this->column_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        }else if(isset($this->order)){
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function getMember($mem_id, $where = '')
    {
        if(!empty($where))
            $this->db->where($where);
        $this->db->where('mem_id', $mem_id);
        $query = $this->db->get($this->table_name);
        return $query->row();
    }

    function getMemData($mem_id)
    {
        $this->db->select('mem_id, mem_type, mem_fname, mem_lname, mem_email, mem_phone, mem_image, mem_address, mem_verified, mem_status, mem_specialization, mem_bio,mem_phone_verified, mem_zip_code, mem_facebook, mem_twitter, mem_linkedin, mem_instagram, mem_website, trustpilot_code, mem_latitude, mem_longitude, mem_pro_title, trustpilot_link');
        $this->db->from('members');
        $this->db->where('mem_id', $mem_id);
        return $this->db->get()->row();
    }

    // function getMemByCustomerCode($customer_code)
    // {
    //     $this->db->select('mem_id, mem_type, mem_fname, mem_lname, mem_display_name, mem_email, mem_phone, mem_image, mem_address, mem_verified, mem_status, mem_professionl_profile, mem_specialization, mem_bio,mem_phone_verified, mem_paystack_customer_code');
    //     $this->db->from('members');
    //     $this->db->where('mem_paystack_customer_code', $customer_code);
    //     return $this->db->get()->row();
    // }

    function member_total_earning($mem_id)
    {
        $this->db->select_sum('amount');
        $this->db->from('earnings');
        $this->db->where(['mem_id'=> $mem_id]);
        return $this->db->get()->row()->amount;
    }
    function member_total_pending($mem_id)
    {
        $this->db->select_sum('amount');
        $this->db->from('earnings');
        $this->db->where(['mem_id'=> $mem_id, 'status'=> 'pending']);
        return $this->db->get()->row()->amount;
    }
    function member_total_requested($mem_id)
    {
        $this->db->select_sum('amount');
        $this->db->from('earnings');
        $this->db->where(['mem_id'=> $mem_id, 'status'=> 'requested']);
        return $this->db->get()->row()->amount;
    }
    function total_earnings_of_users()
    {
        $this->db->select_sum('amount');
        $this->db->from('earnings');
        return $this->db->get()->row()->amount;
    }

    function search_member_data($service_id){
        $this->db->select('m.*');
        $this->db->from('tbl_members m');
        $this->db->join('tbl_professional_profile pp', 'm.mem_id = pp.mem_id');
        $this->db->where('pp.service_id', $service_id);

        $query = $this->db->get();

            $result = $query->result();
            return $result;
            // Process $result as needed
        
    }
    // public function get_records_within_distance($input_lat, $input_lon, $distance = 10) {
    //     $this->db->select('m.*');
    //     $this->db->select('(6371000 * ACOS(COS(RADIANS(' . $input_lat . ')) * COS(RADIANS(pp.latitude)) * COS(RADIANS(pp.longitude) - RADIANS(' . $input_lon . ')) + SIN(RADIANS(' . $input_lat . ')) * SIN(RADIANS(pp.latitude)))) AS distance', FALSE);
    //     $this->db->from('tbl_members m');
    //     $this->db->join('tbl_professional_profile pp', 'm.mem_id = pp.mem_id');

    //     $this->db->having('distance <=', $distance);
    //     $this->db->order_by('distance', 'ASC');

    //     $query = $this->db->get();

    //     return $query->result();
    // }
    public function get_records_within_distance($input_lat, $input_lon, $radius = 10) {
        $this->db->select('m.*');
        $this->db->select('(3959 * ACOS(COS(RADIANS(' . $input_lat . ')) * COS(RADIANS(pp.latitude)) * COS(RADIANS(pp.longitude) - RADIANS(' . $input_lon . ')) + SIN(RADIANS(' . $input_lat . ')) * SIN(RADIANS(pp.latitude)))) AS distance', FALSE);
        $this->db->from('members m');
        $this->db->join('professional_profile pp', 'm.mem_id = pp.mem_id');
        $this->db->having('distance <=', $radius);
        $this->db->order_by('distance', 'ASC');

        $query = $this->db->get();

        return $query->result();
    }
    function getMembers($where = '', $start = '', $offset = '', $order_by = '')
    {
        if (!empty($where))
            $this->db->where($where);
        if (!empty($order_by))
            $this->db->order_by("mem_id", $order_by);
        if (!empty($offset))
            $this->db->limit($offset, $start);

        $query = $this->db->get($this->table_name);
        return $query->result();
    }

    function getMembersFrontend($where = '', $start = '', $offset = '', $order_by = '')
    {
        $this->db->select('mem_id, mem_type, mem_fname, mem_lname, mem_display_name, mem_email, mem_phone, mem_image, mem_address, mem_verified, mem_status, mem_professionl_profile, mem_specialization, mem_bio,mem_phone_verified');

        if (!empty($where))
            $this->db->where($where);
        if (!empty($order_by))
            $this->db->order_by("mem_id", $order_by);
        if (!empty($offset))
            $this->db->limit($offset, $start);

        $query = $this->db->get($this->table_name);
        return $query->result();
    }



    function getSavedJobs($mem_id)
    {
        $this->db->select('j.*, sj.id as saved_id, sj.online_test, sj.interview, sj.second_round_interview, sj.final_round_interview, sj.offer');
        $this->db->from('jobs j');
        $this->db->join('saved_jobs sj', 'j.id=sj.job_id');
        $this->db->where(['sj.mem_id'=> $mem_id, 'j.status'=> '1']);
        $this->db->order_by('j.id', 'desc');
        $this->db->group_by('j.id');
        return $this->db->get()->result();
    }

    function clear_notifs()
    {
        $this->db->set(['status'=> 'seen']);
        $this->db->where(['mem_id'=> $this->session->mem_id]);
        $this->db->update('notifications');
        return true;
    }

    function get_members_by_order($where = '', $start = '', $offset = '', $order_field = 'mem_id', $order_by = '')
    {

        $this->db->select("*, (SELECT AVG(rating) FROM `tbl_reviews` `r` WHERE `r`.`mem_id`=`tbl_members`.`mem_id`) as rating");
        if (!empty($where))
            $this->db->where($where);
        if (!empty($order_by))
            $this->db->order_by($order_field, $order_by);
        if (!empty($offset))
            $this->db->limit($offset, $start);

        $query = $this->db->get($this->table_name);
        return $query->result();
    }

    function get_active_members($order_by)
    {

        $this->db->where(array('mem_status' => 1, 'mem_verified' => 1));
        $this->db->order_by("mem_id", $order_by);

        $query = $this->db->get($this->table_name);
        return $query->result();
    }


    function get_player($mem_id)
    {

        $this->db->where(array('mem_status' => 1, 'mem_verified' => 1, 'mem_player_verified' => 1, 'mem_type' => 'player'/*, 'mem_phone_verified' => '1'*/));
        $this->db->where("mem_id", $mem_id);

        $query = $this->db->get($this->table_name);
        return $query->row();
    }
    
    function oldPswdCheck($mem_id, $mem_pswd)
    {
        $mem_pswd = md5($mem_pswd);
        // pr($mem_pswd);
        $this->db->where('mem_id', $mem_id);
        $this->db->where('mem_pswd', $mem_pswd);
        $query = $this->db->get($this->table_name);
        return $query->row();
    }
    
    function getMembersInterviews()
    {
        $this->db->where(['mem_id <>'=> null]);
        $query = $this->db->get('video_interview');
        return $query->result();
    }


    function search_members($post)
    {
        // $this->db->select('mem.*, ms.price, s.price_label, (SELECT AVG(rating) FROM `tbl_reviews` where `tbl_reviews`.mem_id=mem.mem_id and parent_id is NULL) as mem_avg_rating');
        $this->db->from($this->table_name.' mem');
        $this->db->join('characters c', "FIND_IN_SET(c.id, mem.mem_characters) > 0");
        if (!empty($post['character'])) {
            $this->db->group_start()
            // ->where("subject_id in(select id from tbl_subjects where name like '".$this->db->escape_like_str($post['subject'])."%')")
            ->like('c.title', $post['character'], 'both')
            ->or_like('mem.mem_profile_heading', $post['character'], 'both')
            ->or_like('mem.mem_fname', $post['character'], 'both')
            ->or_like('mem.mem_lname', $post['character'], 'both')
            ->group_end();
        }

        if (!empty($post['price'])) {
            $ary = @explode(';', $post['price']);
            $min_rate = floatval(trim($ary[0]));
            $max_rate = floatval(trim($ary[1]));
            $this->db->where("( mem.mem_rate >= $min_rate AND mem.mem_rate <= $max_rate ) ", null, false);
        }
        
        /*
        if (isset($keywords['gender']) && count($keywords['gender']) > 0) {
            $genders = $keywords['gender'];

            foreach ($genders as $gen) {
                $where_type[] = " (gender LIKE '%$gen%')";
            }
            if (count($where_type) > 0) {
                $where_type_string = @implode(' OR ', $where_type);
            }
            $this->db->where(" ( " . $where_type_string . " ) ", null, false);
        }

        if (isset($keywords['gender']) && count($keywords['gender']) > 0) {
            $genders = $keywords['gender'];

            foreach ($genders as $gen) {
                $where_type[] = " (p.gender LIKE '%$gen%')";
            }
            if (count($where_type) > 0) {
                $where_type_string = @implode(' OR ', $where_type);
            }
            $this->db->where(" ( " . $where_type_string . " ) ", null, false);
        }
        */

        $this->db->where('mem.mem_type', 'player');
        $this->db->where('mem.mem_verified', 1);
        $this->db->where('mem.mem_status', 1);
        // $this->db->where('mem.mem_phone_verified', 1);
        $this->db->where('mem.mem_player_verified', 1);

        if (!empty($post['city']))
            $this->db->like('mem.mem_city', $post['city']);
        if (!empty($post['country']))
            $this->db->where("FIND_IN_SET('".$post['country']."', mem.mem_availability) >0");
            // $this->db->where('mem.mem_country_id', $post['country']);

        if (!empty($post['zip'])){
            $coordinates = get_location_detail($post['zip']);
            $post['lat'] = $coordinates->Latitude;
            $post['lng'] = $coordinates->Longitude;
        }
        
        /*if (!empty($post['lat']) && !empty($post['lng'])) {
            $d=intval($post['distance']);
            $this->db->select("mem.*, (69.0 * DEGREES(ACOS(COS(RADIANS({$post['lat']}))
                      * COS(RADIANS(mem.mem_map_lat))
                      * COS(RADIANS({$post['lng']}) - RADIANS(mem.mem_map_lng))
                        + SIN(RADIANS({$post['lat']}))
                      * SIN(RADIANS(mem.mem_map_lat))))) AS distance, (SELECT AVG(rating) FROM `tbl_reviews` where `tbl_reviews`.mem_id = mem.mem_id and parent_id is NULL) as mem_avg_rating
                        ");
            $this->db->having('mem.mem_travel_radius >= distance');
            $this->db->having('distance<=',  50);
        }
        else*/
            $this->db->select('mem.*, (SELECT AVG(rating) FROM `tbl_reviews` where `tbl_reviews`.mem_id = mem.mem_id and parent_id is NULL) as mem_avg_rating');

        /*if (!empty($post['sort']) && in_array($post['sort'], array('asc', 'desc'))) 
            $this->db->order_by('mem.mem_hourly_rate', $post['sort']);*/
        
        $this->db->group_by('mem.mem_id');
        // $this->db->order_by('mem.mem_membership_pref', 'desc');
        return $this->db->get()->result();

        /*$query = $this->db->get();
        $rows = array();
        foreach ($query->result() as $key => $row) {
            $rows[$key] = $row;
            $rows[$key]->total_favorites = $this->total_favorites($row->id);
        }
        return $rows;*/
    }


    function changeStatus($mem_id)
    {
        $this->db->where('mem_id', $mem_id);
        $query = $this->db->get($this->table_name);
        $rs = $query->row();

        if ($rs->mem_status == '0') {
            $vals['mem_status'] = '1';
        } else {
            $vals['mem_status'] = '0';
        }
        $this->db->set($vals);
        $this->db->where('mem_id', $mem_id);
        $this->db->update($this->table_name);
        return $vals['mem_status'];
    }


    function emailExists($mem_email, $mem_id = 0)
    {
        $this->db->where('mem_email', $mem_email);
        $this->db->where('mem_id <> ' . $mem_id);
        $query = $this->db->get($this->table_name);
        return $query->row();
    }

    function phoneExists($mem_phone, $mem_id = 0)
    {
        $this->db->where('mem_phone', $mem_phone);
        $this->db->where('mem_id <> ' . $mem_id);
        $query = $this->db->get($this->table_name);
        return $query->row();
    }

    function forgotEmailExists($mem_email)
    {
        $this->db->where('mem_email', $mem_email);
        $this->db->where('mem_status', '1');
        // $this->db->where('mem_verified', '1');
        $query = $this->db->get($this->table_name);
        return $query->row();
    }

    function memberExists($mem_keyword)
    {
        $this->db->where('mem_email', $mem_keyword);
        $this->db->or_where('mem_username', $mem_keyword);
        $query = $this->db->get($this->table_name);
        return $query->row();
    }

    function usernameExists($mem_username)
    {
        $this->db->where('mem_username', $mem_username);
        $query = $this->db->get($this->table_name);
        return $query->row();
    }

    function ipExists($mem_id, $mem_ip)
    {
        if (!empty($mem_ip)) {
            $this->db->where("mem_id <> " . $mem_id);
            $this->db->where('mem_ip', $mem_ip);
            $query = $this->db->get($this->table_name);
            if ($query->row())
                return true;
        }
        return false;
    }

    function socialIdExists($mem_type, $mem_id)
    {
        $this->db->where('mem_social_type', $mem_type);
        $this->db->where('mem_social_id', $mem_id);
        $query = $this->db->get($this->table_name);
        return $query->row();
    }

    function getMemCode($mem_code, $mem_id = 0)
    {
        if($mem_id>0)
            $this->db->where('mem_id', $mem_id);
        $this->db->where('mem_code', $mem_code);
        $query = $this->db->get($this->table_name);
        return $query->row();
    }

    function authenticate($mem_email, $mem_pswd, $mem_type = NULL) {
        $mem_pswd = md5($mem_pswd);
        if (!empty($mem_type))
            $this->db->where('mem_type', $mem_type);

        $this->db->where('mem_email', $mem_email);
        $this->db->where('mem_pswd', $mem_pswd);
        $query = $this->db->get($this->table_name);
        // return $this->db->last_query();
        return $query->row();
    }

    function authenticateEmail($mem_email) {
        $this->db->where('mem_email', $mem_email);
        $this->db->where('mem_verified', '1');
        $query = $this->db->get($this->table_name);
        // return $this->db->last_query();
        return $query->row();
    }

	function getMemberSubscription($mem_id)
	{
		$this->db->select('*');
		$this->db->from('subscribed_plans');
		$this->db->where("mem_id", $mem_id);
		$this->db->where("subscription_status", 'active');
 
		$this->db->order_by('id', 'desc');
		$this->db->limit(1);
		return $this->db->get()->row();
	}

	function getNonVerifiedUser($email)
	{
        $this->db->where('mem_email', $email);
        $this->db->where('mem_verified', 0);
        $query = $this->db->get($this->table_name);
        return $query->row();
	}

    function update_last_login($id, $token = '')
    {
        if(!empty($token))
            $vals['mem_remember'] = $token;
        $vals['mem_last_login'] = date('Y-m-d h:i:s');
        $this->save($vals, $id);
    }

    function get_max_rate()
    {
        $this->db->select_max('mem_rate');
        $query = $this->db->get('members');
        return floatval($query->row()->mem_rate);
    }

    function get_max_distance()
    {
        $this->db->select_max('mem_travel_radius');
        $query = $this->db->get($this->table_name);
        return floatval($query->row()->mem_travel_radius);
    }

    function getAllVerifiedProMemeber()
    {
        $this->db->select('m.mem_id, m.mem_type, m.mem_fname, m.mem_email, m.mem_phone, m.mem_image, m.mem_address, m.mem_verified, m.mem_status, m.mem_specialization, m.mem_bio, m.mem_phone_verified, m.mem_zip_code, m.mem_pro_title, m.mem_latitude, m.mem_longitude');
        $this->db->from('members m');
        $this->db->join('selected_services ss', 'm.mem_id = ss.mem_id');
        $this->db->where('m.mem_type', 'professional');
        $this->db->where('m.mem_verified', 1);

        $this->db->where('m.mem_latitude !=', null);
        $this->db->where('m.mem_longitude !=', null);

        $this->db->where('m.mem_pro_title !=', null);
        $this->db->where('m.mem_bio !=', null);
        $this->db->where('m.mem_zip_code !=', null);

       
        $this->db->group_by('m.mem_id');


        $query = $this->db->get();
        return $query->result();
    }
    
    function search_pro_members($data, $radius = 10){
        
        $this->db->select("m.mem_id, m.mem_type, m.mem_fname, m.mem_email, m.mem_phone, m.mem_image, m.mem_address, m.mem_verified, m.mem_status, m.mem_specialization, m.mem_bio, m.mem_phone_verified, m.mem_zip_code, m.mem_pro_title, m.mem_latitude, m.mem_longitude");
        $this->db->from('members m');
        $this->db->join('selected_services ss', 'm.mem_id = ss.mem_id');
        $this->db->where('m.mem_type', 'professional');
        $this->db->where('m.mem_verified', 1);

        $this->db->where('m.mem_latitude !=', null);
        $this->db->where('m.mem_longitude !=', null);

        $this->db->where('m.mem_pro_title !=', null);
        $this->db->where('m.mem_bio !=', null);
        $this->db->where('m.mem_zip_code !=', null);
   






        if(!empty($data['category_id'])){
            $this->db->group_start();

            $this->db->where('ss.service_id', intval($data['category_id']));

            $this->db->group_end();
        }

        if(!empty($data['zip_code'])){
            $this->db->group_start();

            $this->db->where('m.mem_zip_code', $data['zip_code']);

            $this->db->group_end();
        }

        if(!empty($data['latitude'] && !empty($data['longitude']))){
            $input_lat = $data['latitude'];
            $input_lon = $data['longitude'];
            $this->db->select('(3959 * ACOS(COS(RADIANS(' . $input_lat . ')) * COS(RADIANS(m.mem_latitude)) * COS(RADIANS(m.mem_longitude) - RADIANS(' . $input_lon . ')) + SIN(RADIANS(' . $input_lat . ')) * SIN(RADIANS(m.mem_latitude)))) AS distance', FALSE);
            $this->db->having('distance <=', $radius);
            $this->db->order_by('distance', 'ASC');
        }


        $this->db->group_by('m.mem_id');

     
        $query = $this->db->get();
        return $query->result();

    }
}
?>

