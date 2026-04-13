<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
// require_once APPPATH.'third_party/dompdf/autoload.inc.php';
use Dompdf\Dompdf;
class Dompdf_lib

{
    private $dompdf;
    
    public function __construct()

    {

        $this->dompdf = new Dompdf();

    }

    public function generate_pdf($html, $filename = '', $stream = TRUE)

    {

        // pr($this->dompdf);

        $this->dompdf->loadHtml($html);

        // $this->dompdf->setPaper('A4', 'potrait');
        $this->dompdf->setPaper(array(0, 0, 700, 2800), 'portrait');
        $this->dompdf->render();
        $output = $this->dompdf->output();
        if ($stream) {

            $this->dompdf->stream();

        } else {

            $file_path = FCPATH . 'uploads/pdf/' . $filename . '.pdf';
            // pr(FCPATH);
            $file_cont =  file_put_contents($file_path, $output);
            if (!empty($file_cont) && $file_cont > 0) {
                return $filename;
            } else {
                return 0;
            }
        }

    }

}

