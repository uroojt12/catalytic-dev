<?php
class Index extends SUBADMIN_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("subadmin_model");
    }
    function index()
    {
        if (!$this->session->userdata('subadmin_loged_in')) :
            redirect(SUBADMIN . '/login');
        else :
            redirect(SUBADMIN . '/dashboard');
        endif;
    }
    function login()
    {
        $this->logged();
        $this->data['settings'] = $this->master->getRow('siteadmin');
        $this->data['page_title'] = 'Login';
        $this->data['adminsite_setting']->page_title = 'Login';
        $this->load->view(SUBADMIN . '/login', $this->data);
    }
    function auth()
    {
        $res = array();
        $row = $this->subadmin_model->authenticate($this->input->post('username'), $this->input->post('password'));
        // pr($row);
        // pr($this->db->last_query());
        if (!$row->site_id) {
            $res['login_status'] = "invalid";
            $res['msg'] = 'Email and Password my be wrong!';
            exit(json_encode($res));
        } else {
            if ($row->status == 0) {
                $res['login_status'] = "invalid";
                $res['msg'] = 'Your account is blocked';
                exit(json_encode($res));
            } else {
                $sess_array = array(
                    'site_id' => $row->site_id,
                    'name' => $row->name,
                    'email' => $row->email,
                );

                // $perm_row=$this->master->fetch_row("select group_concat(permission_id) as perms from tbl_permissions_admin where admin_id=".$row->site_id,true);

                // if($row->site_admin_type!='admin' && (empty($perm_row['perms']) || $perm_row['perms']=='')){
                //     $res['msg']='Insufficient permissions, please contact administrator';
                //     $res['login_status'] = "invalid";
                //     exit(json_encode($res));
                // }
                // $perm_arr=explode(",",$perm_row['perms']);
                $this->session->set_userdata('subadmin_loged_in', $sess_array);
                // $this->session->set_userdata('permissions', $perm_arr);


                $res['login_status'] = "success";
                $res['redirect_url'] = (($this->session->userdata('subadmin_redirect_url') != "") ? $this->session->userdata('subadmin_redirect_url') : base_url(SUBADMIN . "/dashboard"));
                $this->session->unset_userdata('subadmin_redirect_url');
            }
            exit(json_encode($res));
        }
    }
    function page_404()
    {
        $this->data['adminsite_setting']->page_title = '404 Page Not Found';
        $this->load->view(SUBADMIN . '/404', $this->data);
    }
    function logout()
    {
        $this->session->unset_userdata('subadmin_loged_in');
        $this->session->unset_userdata('subadmin_redirect_url');
        // $this->session->unset_userdata('last_login');
        // $this->session->unset_userdata('permissions');
        redirect(SUBADMIN . '/login');
    }
}
