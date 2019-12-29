<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends CI_Controller {
	public function __construct() { 
		parent::__construct(); 
		//$this->load->library('mail');
		//$this->load->library('email'); //tambahkan dalam contruct pemanggil libarary mail
	}
	public function index(){

	}

	public function upload_attach(){
		$data = array();

		if(isset($_GET['files']))
		{  
			$filename = $_GET['number'];
		    $error = false;
		    $files = '';

		    if (!file_exists('./assets/customer_attach/')) {
    			mkdir('./assets/customer_attach/', 0777, true);
			}

		    $uploaddir = './assets/customer_attach/';
		    foreach($_FILES as $file)
		    {
		    	$ext = explode('.',basename($file['name']));
		        if(move_uploaded_file($file['tmp_name'], $uploaddir .$filename.'_'.date('d-m-Y').'.'.end($ext)))
			        {
			        	
			            $files = $filename.'_'.date('d-m-Y').'.'.end($ext);
			        }
		        else
			        {
			            $error = true;
			        }
		    }
		    $data = ($error) ? array('status'=>0,'message' => 'There was an error uploading your files') : array('status'=>1,'message' => $files);
		}
		else
		{
		    $data = array('success' => 'Form was submitted', 'formData' => $_POST);
		}

		echo json_encode($data);
	}
}

?>