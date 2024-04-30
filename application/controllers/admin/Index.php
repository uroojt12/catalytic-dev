<?php
class Index extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Admin", "admin");
    }

    function index()
    {
        if (!$this->session->userdata('loged_in')):
            redirect(ADMIN.'/login');
        else:
            redirect(ADMIN.'/dashboard');
        endif;
    }

    function login()
    {
        $this->logged();
        $this->data['adminsite_setting']->page_title = 'Login';
        $this->load->view(ADMIN . '/login', $this->data);
    }

    function auth()
    {
        $res = array();
        $row = $this->admin->authenticate($this->input->post('username'), $this->input->post('password'));
        if (!$row->site_id) {
            $res['login_status'] = "invalid";
            $res['msg']='Username and Password my be wrong!';
            exit(json_encode($res));
        } else {
            $sess_array = array(
                'id' => $row->site_id,
                'name' => $row->site_username,
                'admin_name' => $row->site_admin_name,
                'admin_type' => $row->site_admin_type
            );

            $perm_row = $this->master->fetch_row("select group_concat(permission_id) as perms from tbl_permissions_admin where admin_id = ".$row->site_id,true);

            if($row->site_admin_type != 'admin' && (empty($perm_row['perms']) || $perm_row['perms'] == '')){
                $res['msg'] = 'Insufficient permissions, please contact administrator';
                $res['login_status'] = "invalid";
                exit(json_encode($res));
            }
            $perm_arr = @explode(",", $perm_row['perms']);
            $this->session->set_userdata('loged_in', $sess_array);
            $this->session->set_userdata('permissions', $perm_arr);


            $res['login_status'] = "success";
            $res['redirect_url'] = (($this->session->userdata('admin_redirect_url') != "") ? $this->session->userdata('admin_redirect_url') : site_url(ADMIN . "/dashboard"));
            $this->session->unset_userdata('admin_redirect_url');
            exit(json_encode($res));
        }
    }

    function page_404()
    {
        $this->data['adminsite_setting']->page_title = '404 Page Not Found';
        $this->load->view(ADMIN . '/404', $this->data);
    }

    function logout()
    {
        $this->session->unset_userdata('loged_in');
        $this->session->unset_userdata('admin_redirect_url');
        $this->session->unset_userdata('last_login');
        $this->session->unset_userdata('permissions');
        redirect(ADMIN . '/login');
        exit;
    }
}
?>