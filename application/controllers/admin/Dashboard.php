<?php

class Dashboard extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->isLogged();
        $this->load->library('Sendinblue', 'sendinblue');
    }

    public function index()
    {
        $this->data['pageView']  = ADMIN . "/dashboard";
        $this->data['dashboard'] = "1";
        // $this->data['members'] = $this->master->num_rows('members', array('mem_type' => 'member'));
        // $this->data['pro_members'] = $this->master->num_rows('members', array('mem_type' => 'professional'));
        // $this->data['services'] = $this->master->num_rows('services', array('status' => 1));



        $this->data['contact'] = $this->master->num_rows('contact', ['status' => '0']);
        // $this->data['subscriptions'] = $this->master->num_rows('subscribed_plans', ['status'=> '1']);
        // $this->data['blogs'] = $this->master->num_rows('blogs');
        $this->load->view(ADMIN . '/includes/siteMaster', $this->data);
    }

    // function upload_csv_clients()
    // {
    //     if (isset($_FILES) && !empty($_FILES['jobsFile']['name'])) {
    //         $file = $_FILES['jobsFile'];
    //         $extension = explode('.', $file['name']);
    //         if ($extension[1] === 'csv') {
    //             $row = 0;
    //             if (($handle = fopen($file['tmp_name'], "r")) !== FALSE) {
    //                 while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
    //                     if (++$row === 1) {
    //                         continue;
    //                     } else {
    //                         $insert = [];
    //                         if (!empty(trim($data[2]))
    //                             // && !empty(trim($data[3]))
    //                         ) {
    //                             $insert['mem_stripe_customer_id'] = trim($data[0]);
    //                             $insert['mem_email'] = trim($data[2]);

    //                             if (!empty(trim($data[3]))) {
    //                                 $nameIndex = explode(' ', $data[3]);
    //                                 $nameCount = countlength($nameIndex);
    //                                 $insert['mem_fname'] = '';
    //                                 $insert['mem_lname'] = '';
    //                                 if ($nameCount == 1) {
    //                                     $insert['mem_fname'] = ucfirst(trim($nameIndex[0]));
    //                                 } else if ($nameCount == 2) {
    //                                     $insert['mem_fname'] = ucfirst(trim($nameIndex[0]));
    //                                     $insert['mem_lname'] = ucfirst(trim($nameIndex[1]));
    //                                 } else if ($nameCount == 3) {
    //                                     $insert['mem_fname'] = ucfirst(trim($nameIndex[0])) . ' ' . trim($nameIndex[1]);
    //                                     $insert['mem_lname'] = ucfirst(trim($nameIndex[2]));
    //                                 } else if ($nameCount == 4) {
    //                                     $insert['mem_fname'] = ucfirst(trim($nameIndex[0])) . ' ' . trim($nameIndex[1]);
    //                                     $insert['mem_lname'] = ucfirst(trim($nameIndex[2])) . ' ' . trim($nameIndex[3]);
    //                                 } else {
    //                                     $insert['mem_fname'] = ucfirst(trim($nameIndex[0])) . ' ' . trim($nameIndex[1]) . ' ' . trim($nameIndex[2]);
    //                                     $insert['mem_lname'] = ucfirst(trim($nameIndex[3])) . ' ' . trim($nameIndex[4]);
    //                                 }
    //                             } else {
    //                                 $insert['mem_fname'] = trim($data[2]);
    //                             }

    //                             $insert['mem_date'] = db_format_date_csv_upload($data[4]);
    //                             $insert['stripe_plan_charge_id'] = $data[7];


    //                             $mem_status = strtolower(trim($data[8]));
    //                             if ($mem_status === 'active') {
    //                                 $insert['mem_status'] = 1;
    //                             } else if ($mem_status === 'past_due') {
    //                                 $insert['mem_status'] = 2;
    //                             } else {
    //                                 $insert['mem_status'] = 0;
    //                             }

    //                             $insert['payment_count'] = (int)$data[10];
    //                             $insert['refunded_volume'] = trim($data[11]) === '' ? (float)0.00 : trim($data[11]);
    //                             $insert['dispute_losses'] = trim($data[12]) === '' ? (float)0.00 : trim($data[12]);
    //                             $insert['mem_verified'] = 1;
    //                             $insert['mem_pswd'] = doEncode('123456@@');

    //                             $mem_id = $this->master->save('members', $insert);
    //                             $mem = $this->master->getRow('members', ['mem_id' => $mem_id]);

    //                             $saved = $this->sendinblue->create_contact($mem);
    //                             // pr($saved);
    //                         }
    //                     }
    //                 }
    //             } else {
    //                 setMsg('error', 'Please select only csv file.');
    //                 redirect(ADMIN . '/dashboard', 'refresh');
    //                 exit;
    //             }
    //         } else {
    //             setMsg('error', 'No File was seleted.');
    //             redirect(ADMIN . '/dashboard', 'refresh');
    //             exit;
    //         }
    //     }
    // }

    // function upload_csv_subscription()
    // {
    //     if (isset($_FILES) && !empty($_FILES['jobsFile']['name'])) {
    //         $file = $_FILES['jobsFile'];
    //         $extension = explode('.', $file['name']);
    //         if ($extension[1] === 'csv') {
    //             $row = 0;
    //             if (($handle = fopen($file['tmp_name'], "r")) !== FALSE) {
    //                 while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
    //                     if (++$row === 1) {
    //                         continue;
    //                     } else {
    //                         $insert = [];
    //                         if (
    //                             !empty(trim($data[0]))
    //                             && !empty(trim($data[1]))
    //                             && !empty(trim($data[3]))
    //                             && !empty(trim($data[5]))
    //                         ) {
    //                             $email = trim($data[3]);

    //                             $mem_id = null;
    //                             $member = $this->master->getRow('members', ['mem_email' => $email]);
    //                             if (!empty($member)) {
    //                                 $mem_id = $member->mem_id;
    //                             } else {

    //                                 $mem = [];
    //                                 $mem['mem_stripe_customer_id'] = $data[1];
    //                                 $mem['mem_email'] = $email;
    //                                 $mem['stripe_plan_charge_id'] = $data[4];
    //                                 $mem['mem_date'] = date('Y-m-d h:i:s');

    //                                 $mem['mem_fname'] = '';
    //                                 $mem['mem_lname'] = '';
    //                                 $fname = '';
    //                                 $lname = '';
    //                                 if (!empty(trim($data[25]))) {
    //                                     $nameIndex = explode(' ', trim($data[25]));
    //                                     $nameCount = countlength($nameIndex);
    //                                     if ($nameCount == 1) {
    //                                         $mem['mem_fname'] = $fname = ucfirst($nameIndex[0]);
    //                                     } else if ($nameCount == 2) {
    //                                         $mem['mem_fname'] = $fname = ucfirst($nameIndex[0]);
    //                                         $mem['mem_lname'] = $lname = ucfirst($nameIndex[1]);
    //                                     } else if ($nameCount == 3) {
    //                                         $mem['mem_fname'] = $fname = ucfirst($nameIndex[0]) . ' ' . $nameIndex[1];
    //                                         $mem['mem_lname'] = $lname = ucfirst($nameIndex[2]);
    //                                     } else if ($nameCount == 4) {
    //                                         $mem['mem_fname'] = $fname = ucfirst($nameIndex[0]) . ' ' . $nameIndex[1];
    //                                         $mem['mem_lname'] = $lname = ucfirst($nameIndex[2]) . ' ' . $nameIndex[3];
    //                                     } else {
    //                                         $mem['mem_fname'] = $fname = ucfirst($nameIndex[0]) . ' ' . $nameIndex[1] . ' ' . $nameIndex[2];
    //                                         $mem['mem_lname'] = $lname = ucfirst($nameIndex[3]) . ' ' . $nameIndex[4];
    //                                     }
    //                                 } else {
    //                                     $mem['mem_fname'] = $fname = $email;
    //                                 }

    //                                 $mem['mem_status'] = 1;
    //                                 $mem['mem_verified'] = 1;
    //                                 $mem['mem_pswd'] = doEncode('123456@@');
    //                                 $mem_id = $this->master->save('members', $mem);
    //                             }

    //                             $mem = $this->master->getRow('members', ['mem_id' => $mem_id]);
    //                             $this->sendinblue->create_contact($mem);

    //                             $insert['mem_id'] = $mem_id;
    //                             $planIndex = explode(' ', trim($data[5]));
    //                             $planName = strtolower($planIndex[0]);
    //                             if ($planName === 'quarterly') {
    //                                 $plan_id = 2;
    //                                 $price = 11.97;
    //                             } else if ($planName === 'biannually') {
    //                                 $plan_id = 3;
    //                                 $price = 17.94;
    //                             } else {
    //                                 $plan_id = 1;
    //                                 $price = 4.99;
    //                             }

    //                             $insert['plan_id'] = $plan_id;
    //                             $insert['stripe_subscription_id'] = trim($data[0]);
    //                             $insert['mem_fname'] = $fname;
    //                             $insert['mem_lname'] = $lname;
    //                             $insert['mem_email'] = $email;
    //                             // $insert['created_date'] = db_format_date_csv_upload_new($data[10]);
    //                             // $insert['start_date'] = db_format_date_csv_upload_new($data[13]);
    //                             // $insert['end_date'] = db_format_date_csv_upload_new($data[14]);
    //                             $insert['created_date'] = $data[10];
    //                             $insert['start_date'] = $data[13];
    //                             $insert['end_date'] = $data[14];
    //                             $insert['price'] = $price;
    //                             $insert['payment_method'] = 'credit-card';
    //                             $insert['view_status'] = '1';

    //                             $status = strtolower($data[9]);
    //                             if ($status === 'active') {
    //                                 $insert['status'] = '1';
    //                             } else if ($status === 'past_due') {
    //                                 $insert['status'] = '2';
    //                             } else {
    //                                 $insert['status'] = '0';
    //                             }

    //                             $this->master->save('subscribed_plans', $insert);

    //                             // pr('here');
    //                         }
    //                     }
    //                 }
    //             } else {
    //                 setMsg('error', 'Please select only csv file.');
    //                 redirect(ADMIN . '/dashboard', 'refresh');
    //                 exit;
    //             }
    //         } else {
    //             setMsg('error', 'No File was seleted.');
    //             redirect(ADMIN . '/dashboard', 'refresh');
    //             exit;
    //         }
    //     }
    // }
}
