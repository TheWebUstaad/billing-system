<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pdf {
    public $param;
    public $pdf;

    public function __construct() {
        // Load Composer's autoloader if using Composer
        if (file_exists(FCPATH . 'vendor/autoload.php')) {
            require_once FCPATH . 'vendor/autoload.php';
        }
        
        // If TCPDF is in third_party directory
        if (file_exists(APPPATH . 'third_party/tcpdf/tcpdf.php')) {
            require_once APPPATH . 'third_party/tcpdf/tcpdf.php';
        }
    }

    public function load($param = []) {
        $this->param = $param;
        $this->pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        
        // Set document information
        $this->pdf->SetCreator('Billing System');
        $this->pdf->SetAuthor('Billing System');
        $this->pdf->SetTitle(isset($param['title']) ? $param['title'] : 'PDF Document');
        
        // Remove header/footer
        $this->pdf->setPrintHeader(false);
        $this->pdf->setPrintFooter(false);
        
        // Set margins
        $this->pdf->SetMargins(15, 15, 15);
        
        // Set auto page breaks
        $this->pdf->SetAutoPageBreak(TRUE, 15);
        
        // Set image scale factor
        $this->pdf->setImageScale(1.25);
        
        // Enable Unicode support for Urdu/Arabic text
        $this->pdf->setRTL(false);
        
        // Set font that supports Urdu/Arabic - use DejaVu fonts that come with TCPDF
        $this->pdf->SetFont('dejavusans', '', 10);
        
        return $this;
    }

    public function generate($content, $filename = 'document.pdf', $stream = true) {
        $this->pdf->AddPage();
        $this->pdf->writeHTML($content, true, false, true, false, '');
        
        if ($stream) {
            $this->pdf->Output($filename, 'I');
        } else {
            $this->pdf->Output($filename, 'D');
        }
    }
} 