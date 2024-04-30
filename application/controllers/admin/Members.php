<?php
class Members extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->isLogged();
        $this->load->model('Member_model','member');
        
    }

    public function index() {
        $this->data['enable_datatable'] = TRUE;
        $this->data['pageView'] = ADMIN . '/members';        
        $this->data['rows'] = $this->member->getMembers('', '', '', 'desc');
        $this->load->view(ADMIN.'/includes/siteMaster', $this->data);
    }

    function manage(){
        $this->data['pageView'] = ADMIN . '/members';     

        if ($this->input->post()) {
            $vals = $this->input->post();       

            if (($_FILES["mem_image"]["name"] != "")) {
                $this->remove_file($this->uri->segment(4), 'mem_image');
                $image = upload_file(UPLOAD_PATH . 'members', 'mem_image');
                if (!empty($image['file_name'])) {
                    $vals['mem_image'] = $image['file_name'];
                    generate_thumb(UPLOAD_PATH . "members/", UPLOAD_PATH . "members/", $image['file_name'], 100, 'thumb_');
                    generate_thumb(UPLOAD_PATH . "members/", UPLOAD_PATH . "members/", $image['file_name'], 300, '300p_');
                } else {
                    setMsg('error', 'Please upload a valid image file >> ' . strip_tags($image['error']));
                    redirect(ADMIN . '/members/manage/' . $this->uri->segment(4), 'refresh');
                }
            }
            $mem_id = $this->member->save($vals,$this->uri->segment(4));
            setMsg('success', 'Member has been saved successfully.');
            redirect(ADMIN . '/members', 'refresh');
        }
        $this->data['row'] = $this->member->getMember($this->uri->segment('4'));
       // $this->data['mem_qualifications'] = $this->master->getRows('qualifications', array('mem_id' => $this->uri->segment('4')));
       // $this->data['mem_experties'] = $this->master->getRows('experties', array('mem_id' => $this->uri->segment('4')));
       // $this->data['documents']=$this->master->getRows("documents",array("mem_id"=>$this->uri->segment(4)));
        // pr($this->data['pro_profile']);

        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }
    
    function manage_subscription(){
        $this->data['pageView'] = ADMIN . '/members';
        $this->data['mem_id'] = $mem_id = $this->uri->segment('4');
        $this->data['row'] = $row = $this->member->getMember($this->uri->segment('4'));
        $this->data['mem_subscriptions'] = $this->master->getRows('subscribed_plans', array('mem_id' => $this->uri->segment('4')), '', '', 'DESC' );

        $this->data['subscription'] = $subscription = $this->member->getMemberSubscription($this->uri->segment('4'));
        // pr($this->data['subscription']);
        $this->data['plans'] = $this->master->getRows('plans', ['status' => 1]);
        

        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }

    function manage_work_evidence(){
        $this->data['pageView'] = ADMIN . '/members';
        $this->data['mem_id'] = $mem_id = $this->uri->segment('4');
        $this->data['row'] = $row = $this->member->getMember($this->uri->segment('4'));
        $this->data['mem_work_evidences'] = $this->master->getRows('work_evidences', array('mem_id' => $this->uri->segment('4')), '', '', 'DESC' );
      

        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }
    
    function active(){
        $mem_id = $this->uri->segment(4);
        $vals['mem_status'] = '1';
        $this->member->save($vals,$mem_id);
        setMsg('success', 'Member has been activated successfully.');
        redirect(ADMIN . '/members', 'refresh');
    }

    function inactive(){
        $mem_id = $this->uri->segment(4);
        $vals['mem_status'] = '0';
        $this->member->save($vals,$mem_id );
        setMsg('success', 'Member has been deactivated successfully.');
        redirect(ADMIN . '/members', 'refresh');
    }   

    function featured(){
        $mem_id = $this->uri->segment(4);
        $vals['mem_featured'] = '1';
        $this->member->save($vals,$mem_id);
        setMsg('success', 'Member is marked as Featured.');
        redirect(ADMIN . '/members', 'refresh');
    }

    function unfeatured(){
        $mem_id = $this->uri->segment(4);
        $vals['mem_featured'] = '0';
        $this->member->save($vals,$mem_id );
        setMsg('success', 'Member is marked as un-featured.');
        redirect(ADMIN . '/members', 'refresh');
    }

    function delete(){
        $this->remove_file($this->uri->segment(4));
        $this->member->delete($this->uri->segment('4'), 'mem_id');

        $this->master->delete_where('subscribed_plans', array('mem_id' => $this->uri->segment('4')) );
        $this->master->delete_where('qualifications', array('mem_id' => $this->uri->segment('4')) );
        $this->master->delete_where('experties', array('mem_id' => $this->uri->segment('4')) );
        

        setMsg('success', 'Member has been deleted successfully.');
        redirect(ADMIN . '/members', 'refresh');
    }

    function add_document_requirements($mem_id) {
        
        $vals = $this->input->post();
        // pr($vals);
        $req = array(         
            'doc_name' => $vals['doc_name']
        );            
        $dat = saveDocsRequirement($req, $mem_id, 'requested');

        $docs_data = $this->master->getRows('documents', array('mem_id' => $mem_id, 'status' => 'requested'));
        // pr($docs_data);
        $mem = $this->master->getRow('members', array('mem_id' => $mem_id));
       
        $notify_arr = [
            'sender_mem_id' => 0,
            'receiver_mem_id' => $mem_id,
            'txt' => 'Admin added document requirements for your profile. Please upload the required documents to complete your profile.',
            'read_status' => 0,
            'created_at' => date('Y-m-d h:i:s'),
            'sender' => 'admin',
            'receiver' => 'professional',
            'type' => 'document_notification',
        ];
        $this->master->save('notifications', $notify_arr);

        $mem_data = [
            'mem_id' => $mem->mem_id,
            'name' => $mem->mem_fname,
            'email' => $mem->mem_email,
        ];
    
        send_document_reuquirements_email($mem_data, $docs_data, $this->data['adminsite_setting']);
        // pr($this->db->last_query());


        setMsg('success', 'Requiremnts Posted to user');
        redirect(ADMIN . '/members/manage/'.$mem_id, 'refresh');
    }

    function doc_status($doc_id, $mem_id) {
        
        $vals = $this->input->post();
        // pr($vals);
        $vals['mem_id'] = $mem_id;
        $this->master->update('documents', $vals, array('id' => $doc_id, 'mem_id' => $mem_id));
        // pr($this->db->last_query());
        setMsg('success', 'Document Status Saved');
        redirect(ADMIN . '/members/manage/'.$mem_id, 'refresh');
    }

    function remove_file($id, $type = ''){
        $arr = $this->member->getMember($id);
        $filepath = "./" . SITE_IMAGES . "/members/" . $arr->mem_image;
        $filepath_thumb = "./" . SITE_IMAGES . "/members/thumb_" . $arr->mem_image;
        $filepath_thumb2 = "./" . SITE_IMAGES . "/members/300p_" . $arr->mem_image;

        if (is_file($filepath)) {
            unlink($filepath);
        }

        if (is_file($filepath_thumb)) {
            unlink($filepath_thumb);
        }

        if (is_file($filepath_thumb2)) {
            unlink($filepath_thumb2);
        }
        return;
    }    
}

?>