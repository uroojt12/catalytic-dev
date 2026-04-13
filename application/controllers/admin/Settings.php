<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Settings extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->isLogged();
        $this->load->model('Admin', 'admin');
    }

    function index()
    {
  
        $this->data['enable_editor'] = TRUE;
        has_access();
        if ($vals = $this->input->post()) {
            if (($_FILES["logo_image"]["name"] != "")) {
                $image = upload_file(UPLOAD_PATH . "images/", 'logo_image', 'image');
                if (!empty($image['file_name'])) {
                    if (!empty($this->data['adminsite_setting']->site_logo))
                        $this->remove_file($this->data['adminsite_setting']->site_logo);
                    $vals['site_logo'] = $image['file_name'];
                } else {
                    setMsg('errorMsg', 'Please upload a valid logo image file >> ' . strip_tags($image['error']));
                    redirect(ADMIN . '/settings', 'refresh');
                    exit;
                }
            }
            if (($_FILES["footer_logo_image"]["name"] != "")) {
                $image = upload_file(UPLOAD_PATH . "images/", 'footer_logo_image', 'image');
                if (!empty($image['file_name'])) {
                    if (!empty($this->data['adminsite_setting']->site_footer_logo))
                        $this->remove_file($this->data['adminsite_setting']->site_footer_logo);
                    $vals['site_footer_logo'] = $image['file_name'];
                } else {
                    setMsg('errorMsg', 'Please upload a valid logo image file >> ' . strip_tags($image['error']));
                    redirect(ADMIN . '/settings', 'refresh');
                    exit;
                }
            }

            if (($_FILES["icon_image"]["name"] != "")) {
                $image = upload_file(UPLOAD_PATH . "images/", 'icon_image', 'image');
                // pr($image);
                if (!empty($image['file_name'])) {
                    $vals['site_icon'] = $image['file_name'];
                    if (!empty($this->data['adminsite_setting']->site_icon))
                        $this->remove_file($this->data['adminsite_setting']->site_icon);
                } else {
                    setMsg('errorMsg', 'Please upload a valid icon image file >> ' . strip_tags($image['error']));
                    redirect(ADMIN . '/settings', 'refresh');
                    exit;
                }
            }

            if (($_FILES["thumb_image"]["name"] != "")) {
                $image = upload_file(UPLOAD_PATH . "images/", 'thumb_image', 'image');
                if (!empty($image['file_name'])) {
                    if (!empty($this->data['adminsite_setting']->site_thumb))
                        $this->remove_file($this->data['adminsite_setting']->site_thumb);
                    $vals['site_thumb'] = $image['file_name'];
                } else {
                    setMsg('errorMsg', 'Please upload a valid thumb image file >> ' . strip_tags($image['error']));
                    redirect(ADMIN . '/settings', 'refresh');
                    exit;
                }
            }

            $vals['created_date'] = date('Y-m-d h:i:s');
            
            // /// 22 july test code ////
            
            
            // Get old values before saving
$old_settings = $this->data['adminsite_setting'];  // Already available

$metals = [
    'site_live_pt_price' => ['label' => 'Platinum'],
    'site_live_pd_price' => ['label' => 'Palladium'],
    'site_live_rh_price' => ['label' => 'Rhodium'],
];

// Load DB for insert
$this->load->database();

foreach ($metals as $key => $info) {
    $new_price = isset($vals[$key]) ? $vals[$key] : null;
    $old_price = isset($old_settings->$key) ? $old_settings->$key : null;

    if ($new_price !== null && $new_price != $old_price) {
        $this->db->insert('tbl_metal_price_history', [
            'metal_key'   => $key,
            'metal_label' => $info['label'],
            'price'       => $new_price,
            'created_at'  => date('Y-m-d H:i:s')
        ]);
    }
}

            
            //////////////////////////
            
            
            
            $this->admin->saveSettings($vals);
            setMsg("success", "Site Settings have been Changed");
            redirect(ADMIN . "/settings");
            exit;
        } else {
            $this->data['code_editor'] = true;
            
            
            ///////
      $metals = [
    'site_live_pt_price' => 'pt',
    'site_live_pd_price' => 'pd',
    'site_live_rh_price' => 'rh',
];

foreach ($metals as $metal_key => $short) {
    $this->db->select('price');
    $this->db->from('tbl_metal_price_history');
    $this->db->where('metal_key', $metal_key);
    $this->db->order_by('id', 'DESC');
    $this->db->limit(2);
    $query = $this->db->get();
    $prices = $query->result();

    $latest = isset($prices[0]->price) ? $prices[0]->price : 0;
    $previous = isset($prices[1]->price) ? $prices[1]->price : 0;

    $diff = $latest - $previous;
    $percent_change = ($previous != 0) ? ($diff / $previous) * 100 : 0;

    $this->data["{$short}_price_percent"] = $percent_change;
}

            
            
            
            $this->data['pageView'] = ADMIN . "/site_setting";
            $this->load->view(ADMIN . "/includes/siteMaster", $this->data);
        }
    }

    function clear_cashe()
    {
        has_access();
        $this->admin->saveSettings(array('site_version' => rand(1, 100)));
        setMsg("success", "Successfully Cashe Cleared!");
        redirect(ADMIN . "/settings");
        exit;
    }

    function change()
    {
        $this->data['adminsite_setting']->page_title = 'Change Password';
        $this->load->view(ADMIN . '/admin_change', $this->data);
    }

    function pass()
    {
        if ($data = $this->input->post()) {
            $row = $this->admin->authenticate($this->session->loged_in['name'], $data['opwd']);
            if ($row) {
                $this->admin->save(array('site_password' => md5($data['npwd'])), $this->session->loged_in['id']);
                // $this->admin->saveSettings(array('site_password' => md5($data['npwd'])));
                $res['login_status'] = "success";
                $res['redirect_url'] = site_url(ADMIN . '/dashboard');
            } else {
                $res['login_status'] = "invalid";
                $res['invalid_respnse'] = "Old Password Does not Match";
            }
            echo json_encode($res);
        }
    }

    function remove_file($file_name)
    {

        $filepath = UPLOAD_PATH . "/images/" . $file_name;
        if (is_file($filepath))
            unlink($filepath);
        return;
    }
}
