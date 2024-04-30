<?php
class Sub_admin extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->isLogged();
        has_access();
        $this->load->model('Admin', 'admin');
    }

    public function index()
    {
        $this->data['enable_datatable'] = TRUE;
        $this->data['pageView'] = ADMIN . '/sub-admin';
        $this->data['rows'] = $this->admin->get_rows(array('site_admin_type'=>'subadmin'));
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }

    function manage()
    {
        $this->data['pageView'] = ADMIN . '/sub-admin';
        $this->data['row'] = $this->admin->get_row_where(array('site_id'=>$this->uri->segment('4'),'site_admin_type'=>'subadmin'));
        if ($this->input->post()) {
            $vals = $this->input->post();
            
            $vals['site_admin_name']=ucwords($vals['site_admin_name']);
            if ($vals['site_password']!='')
                $vals['site_password']=md5($vals['site_password']);
            else
                unset($vals['site_password']);
            $vals['site_admin_type']='subadmin';
            
            $this->admin->save($vals, $this->uri->segment(4));
            setMsg('success', 'Sub-Admin has been saved successfully.');
            redirect(ADMIN . '/sub-admin/manage/' . $this->uri->segment(4), 'refresh');
            exit;
        }
        
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }

    function permissions($id = 0)
    {
        $site_id = intval($id);
        $this->data['pageView'] = ADMIN . '/permissions';
        if ($this->data['row'] = $this->admin->get_row_where(array('site_id'=>$site_id,'site_admin_type'=>'subadmin'))) {
            if ($this->input->post()) {
                $res=array();
                $res['hide_msg']=0;
                $res['scroll_to_msg']=1;
                $res['status'] = 0;
                $res['frm_reset'] = 0;
                $res['redirect_url'] = 0;

                $this->form_validation->set_message('integer', 'Please select a valid {field}');
                
                $this->form_validation->set_rules('permissions[]','Permissions','required|integer',array('required'=>'Please select a {field}'));
                if($this->form_validation->run()===FALSE)
                {
                    $res['msg'] = validation_errors();
                }else{
                    $post = html_escape($this->input->post());
                    
                    $this->master->delete('permissions_admin','admin_id',$site_id);
                    foreach ($post['permissions'] as $key => $permission) {
                        $this->master->save('permissions_admin',array('admin_id'=>$site_id,'permission_id'=>intval($permission)));
                    }
                    $res['msg'] = showMsg('success','Permissions has been saved successfully!');
                    $res['redirect_url'] = site_url(ADMIN . '/sub-admin');
                    $res['status'] = 1;
                }
                exit(json_encode($res));
            }
            $this->data['permissions']=$this->master->getRows('permissions');
            $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
        }
        else
            show_404();
    }

    function active($id = 0)
    {
        $site_id = intval($id);
        if($this->admin->get_row_where(array('site_id' => $site_id, 'site_admin_type' => 'subadmin'))){
            $vals['site_status'] = '1';
            $this->admin->save($vals, $site_id);
            setMsg('success', 'Sub-Admin has been activated successfully.');
            redirect(ADMIN . '/sub-admin', 'refresh');
            exit;
        }
        else
            show_404();
    }

    function inactive($id = 0)
    {
        $site_id = intval($id);
        if($this->admin->get_row_where(array('site_id' => $site_id, 'site_admin_type' => 'subadmin'))) {

            $vals['site_status'] = '0';
            $this->admin->save($vals, $site_id);
            setMsg('success', 'Sub-Admin has been deactivated successfully.');
            redirect(ADMIN . '/sub-admin', 'refresh');
            exit;
        }
        else
            show_404();
    }

    function delete($id = 0)
    {
        $site_id = intval($id);
        if($this->admin->get_row_where(array('site_id' => $site_id, 'site_admin_type' => 'subadmin'))){
            $this->master->delete('permissions_admin', 'admin_id', $site_id);
            $this->admin->delete($site_id);
            setMsg('success', 'Sub-Admin has been deleted successfully.');
            redirect(ADMIN . '/sub-admin', 'refresh');
            exit;
        }
        else
            show_404();
    }
}
?>