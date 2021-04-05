<?php

class Pdf {

    function index() {
        $CI = & get_instance();
        log_message('Debug', 'mPDF class is loaded.');
    }

    /* Create PDF and Show in a new tab */

    function write_pdf($para = NULL, $file_name = '') {
        include_once APPPATH . '/third_party/mpdf/vendor/autoload.php';
//        $file_name = date("Y_m_d_H_i_s") . '.pdf';
        $file_name = ((!empty($file_name)) ? $file_name : time()) . '.pdf';
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4']);
        $stylesheet = file_get_contents('assets/vendor/bootstrap/css/bootstrap.min.css');
        $stylesheet_1 = file_get_contents('assets/css/style.css');
        $mpdf->SetTitle('PDF');
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->WriteHTML($stylesheet_1, 1);
        $mpdf->WriteHTML($para);
//        $mpdf->Output(); // show the file
        $mpdf->Output($file_name, 'I'); // show the file and after download save the file as file name
//        $mpdf->Output($file_name, 'D'); // make it to download
    }

    /* Create PDF and save it */

    function save_pdf($para = NULL, $file_name = '') {
        include_once APPPATH . '/third_party/mpdf/vendor/autoload.php';
//        $file_name = date("Y_m_d_H_i_s") . '.pdf';
        $file_destination = '';
        $file_name = ((!empty($file_name)) ? $file_name : time()) . '.pdf';
        $ip_address_array = array('127.0.0.1', '::1');
        if (in_array($_SERVER['REMOTE_ADDR'], $ip_address_array)) {
            $file_destination = $_SERVER['DOCUMENT_ROOT'] . '/business_automation/assets/uploads/pdf/' . $file_name;
        } else {
            $file_destination = $_SERVER['DOCUMENT_ROOT'] . '/assets/uploads/pdf/' . $file_name;
        }
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4']);
        $stylesheet = file_get_contents('assets/vendor/bootstrap/css/bootstrap.min.css');
        $stylesheet_1 = file_get_contents('assets/css/style.css');
        $mpdf->SetTitle('PDF');
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->WriteHTML($stylesheet_1, 1);
        $mpdf->WriteHTML($para);
//        $mpdf->Output($file_name, 'D'); // make it to download
        $mpdf->Output($file_destination, 'F');
        return $file_destination;
    }

    /* Create PDF and download it autometically */

    function download_pdf($para = NULL, $file_name = '') {
        include_once APPPATH . '/third_party/mpdf/vendor/autoload.php';
//        $file_name = date("Y_m_d_H_i_s") . '.pdf';
        $file_name = ((!empty($file_name)) ? $file_name : time()) . '.pdf';
        $ip_address_array = array('127.0.0.1', '::1');
        if (in_array($_SERVER['REMOTE_ADDR'], $ip_address_array)) {
            $file_destination = $_SERVER['DOCUMENT_ROOT'] . '/business_automation/assets/uploads/pdf/' . $file_name;
        } else {
            $file_destination = $_SERVER['DOCUMENT_ROOT'] . '/assets/uploads/pdf/' . $file_name;
        }
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4']);
        $stylesheet = file_get_contents('assets/vendor/bootstrap/css/bootstrap.min.css');
        $stylesheet_1 = file_get_contents('assets/css/style.css');
        $mpdf->SetTitle('PDF');
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->WriteHTML($stylesheet_1, 1);
        $mpdf->WriteHTML($para);
        $mpdf->Output($file_destination, 'D'); // make it to download
        return $file_destination;
    }

}
