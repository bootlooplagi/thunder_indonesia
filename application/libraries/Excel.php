<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class excel {
    
    function wxcel()
    {
        $CI = & get_instance();
        log_message('Debug', 'mPDF class is loaded.');
    }
 
    function load($param=NULL)
    {
        include_once APPPATH.'/third_party/excel/PHPExcel.php';
         
        if ($params == NULL)
        {
            $param = '"en-GB-x","A4","","",0,0,0,0,0,0';          
        }
        
        return new mPDF($param);
    }
}