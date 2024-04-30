<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Texts extends SUBADMIN_Controller {

    public function __construct() {
        parent::__construct();
        $this->isLogged();
        $this->load->model('Location', 'location');
        $this->load->model('Text_model', 'text');
    }

    function index() {
        $this->data['pageView'] = LOCATION . "/site_texts";
        $this->data['enable_editor'] = TRUE;
        $this->data['page_title'] = 'Site Texts';

        if ($post = $this->input->post()) {
            if ($post['addnewForm'] == 'posted') {
                $vals = array(
                    'txt_type' => $post['txt_type'],
                    'txt_label' => $post['txt_label'],
                    'txt_key' => $post['txt_key'],
                    'txt_value' => $post['txt_value'],
                    'txt_subject' => $post['txt_subject']
                );
                $this->text->save($vals);
            } else {
                if (count($post['txt_value']) > 0):
                    foreach ($post['txt_value'] as $key => $val):
                        $this->text->save(array('txt_value' => $val,'txt_subject'=>$post['txt_subject'][$key]), $key);
                    endforeach;
                endif;
                setMsg('success', 'Text has been saved successfully.');
            }
        }
        //pr($this->master->getRows('site_texts'));
        $this->data['email_texts'] = $this->text->getTexts('email');
        //pr($this->data['email_texts']);
        //$this->data['alert_texts'] = $this->text->getTexts('alert');

        $this->load->view(LOCATION . "/includes/siteMaster", $this->data);
    }
    function delete($id){
        $q=$this->master->delete("site_texts",'txt_id',$id);
        pr($q);
    }

}

?>