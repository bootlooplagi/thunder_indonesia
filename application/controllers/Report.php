<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class report extends CI_Controller {
	function __construct(){
		parent::__construct();

	}

	public function index(){

	}

	public function report_driver(){
		

		$var['title'] = 'Report';
		$var['page_title'] = 'REPORT';
		$var['content']='view-report_driver';
		$var['s_active']='report_driver';
		$var['js'] = 'js-report_driver';
		$var['plugin'] = 'plugin_1';
		$var['user'] = $_SESSION['user_type'];
		$var['mode']='view';

		$this->load->model('model_report');
		
		$var['driver'] = $this->model_report->getDriver();
		

		$this->load->view('view-index',$var);
	}

	public function tb_driver(){
		$id_kurir = $_POST['id_kurir'];
		$month = $_POST['month'];
		$year = $_POST['year'];

		$var['mode']='post_tb';
		$var['status'] = [
			'Waiting Approval',
			'Order Received',
			'Courier Assigned',
			'Prepare Item',
			'Courier On The Way',
			'Done',
			'Cancel'
		];
		$this->load->model('model_report');
		$var['tb_report_driver'] = $this->model_report->getDataReportDriver($id_kurir,$month,$year);
		$var['jumlah_jobs']=count($var['tb_report_driver']);
		$var['success']=0;
		$var['progress']=0;

		if(!empty($var['tb_report_driver'])){
			foreach ($var['tb_report_driver'] as $key => $value) {
				if($value->status==5){
					$var['success']++;
				}

				if($value->status<5){
					$var['progress']++;
				}
			}
		}

		$this->load->view('view-report_driver',$var);
	}
}

?>