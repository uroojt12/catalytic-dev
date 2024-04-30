<?php
class Photo_grade extends SUBADMIN_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->isLogged();
        $this->subadmin = $this->getActiveSubAdmin();
    }
    function index()

    {

        $this->data['enable_datatable'] = TRUE;
        $this->data['pageView'] = SUBADMIN . '/photo_grade';
        $this->data['rows'] = $this->master->getRows('add_photo_grade', array('site_id' => $this->subadmin->site_id), '', '', 'desc');
        $this->load->view(SUBADMIN . '/includes/siteMaster', $this->data);
    }


    function detail($id = 0)

    {

        $id = intval($id);

        if ($this->data['row'] = $this->master->getRow('add_photo_grade', array('id' => $id))) {
            $arr['view_status'] = 1;
            $this->master->save('add_photo_grade', $arr, 'id', $id);
            if ($this->input->post()) {
                $vals = $this->input->post();
                // pr($vals);
                if ($vals['price'] == '') {
                    $vals['price'] = NULL;
                }
                $grade_id = $this->master->save('add_photo_grade', $vals, 'id', $id);
                $member = get_member($this->data['row']->mem_id);
                $photo_data = array(
                    'email' => $member->mem_email,
                    'name' => ucfirst($member->mem_fname) . ' ' . ucfirst($member->mem_lname),
                    'photo' => $this->master->getRow('add_photo_grade', array('id' => $grade_id)),
                );

                send_grade_status_email($photo_data, $this->data['adminsite_setting']);

                $grade = $this->master->getRow('add_photo_grade', array('id' => $grade_id));
                // $product = get_list_product($grade->product_id);

                if ($grade->status == 'approved') {
                    $status = "Accepted";
                } elseif ($grade->status == 'rejected') {
                    $status = "Rejected";
                } else {
                    $status = "Pending";
                }

                $notify_arr = [
                    'sender_mem_id' => $this->subadmin->site_id,
                    'receiver_mem_id' => $member->mem_id,
                    'grade_id' => $grade->id,
                    'title' => 'Photo Grade Request',
                    'txt' => 'Your Photo Grade Request has been ' . $status . ' by Admin.',
                    'read_status' => 0,
                    'created_at' => date('Y-m-d h:i:s'),
                    'sender' => 'subadmin',
                    'receiver' => 'user',
                    'type' => 'photo_grade_subadmin_notification',
                ];

                $this->master->save('notifications', $notify_arr);


                setMsg('success', 'Photo grade status has been saved successfully.');
                redirect(SUBADMIN . '/photo_grade', 'refresh');
                exit;
            }

            $this->data['pageView'] = SUBADMIN . '/photo_grade';
            $this->load->view(SUBADMIN . '/includes/siteMaster', $this->data);
        } else

            show_404();
    }


    function delete()

    {
        // $this->remove_file($this->uri->segment('4'), 'cv');
        $this->master->delete('add_photo_grade', 'id', $this->uri->segment('4'));
        setMsg('success', 'Photo grade has been deleted successfully.');
        redirect(SUBADMIN . '/photo_grade', 'refresh');
    }
}
