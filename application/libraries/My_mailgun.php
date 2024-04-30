<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(dirname(__FILE__, 3) . '/vendor/autoload.php');
use Mailgun\Mailgun;

class My_mailgun
{    
    // private $mgClient = new Mailgun('YOUR_API_KEY');
    // private $domain = "YOUR_DOMAIN_NAME";
    private $mg = '';
    private $domain = 'ukvisajobs.com';
    private $from = '';
    public function __construct()
    {
        $this->mg = Mailgun::create(MAILGUN_API_KEY, 'https://api.eu.mailgun.net');
    }

    public function send_mailgun_email($emailto, $message, $subject, $settings)
    {
        $this->from = $settings->site_name . ' <' . $settings->site_noreply_email .'>';
        if(isset($settings->email_attachemnts) && !empty($settings->email_attachemnts))
        {
            $this->mg->messages()->send($this->domain, [
                'from'    => $this->from,
                'to'      => $emailto,
                'subject' => $subject,
                'html'    => $message,
                'attachment' => $settings->email_attachemnts
              ]);
        }
        else
        {
            $this->mg->messages()->send($this->domain, [
                'from'    => $this->from,
                'to'      => $emailto,
                'subject' => $subject,
                'html'    => $message
              ]);
        }

        return TRUE;
    }
}