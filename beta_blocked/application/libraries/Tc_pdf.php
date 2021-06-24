<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'/libraries/tcpdf/tcpdf.php';

class Tc_pdf {

    public $pdf;

    public function __construct()
    {
        $this->pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    }

}