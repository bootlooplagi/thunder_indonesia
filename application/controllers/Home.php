<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class home extends CI_Controller {

	function __construct(){
		parent::__construct();

		date_default_timezone_set('Asia/Jakarta');

	}

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		//HARUSNYA DIISI HALAMAN DASHBOARD
		$data['title'] = 'Dashboard';
		$data['s_active']='dashboard';
		$data['js'] = 'js-dashboard';
		$data['user'] = $_SESSION['user_type'];
		$data['content'] = 'view-dashboard';
		$data['plugin'] = 'plugin_1';

		$this->load->model('model_report');

		$data['tb_item_disewa'] = $this->model_report->tb_item_disewa();
		$data['tb_item_terlaris'] = $this->model_report->tb_item_terlaris();
		$data['tb_jumlah_driver'] = $this->model_report->tb_jumlah_driver();

		$data['total_driver']=empty($data['tb_jumlah_driver'])?0:count($data['tb_jumlah_driver']);
		$data['driver_assigned']=0;
		$data['driver_no_assigned']=0;

		if(!empty($data['tb_jumlah_driver'])){
			foreach ($data['tb_jumlah_driver'] as $key => $value) {
				if($value->total_jobs>0){
					$data['driver_assigned']++;
				}else{
					$data['driver_no_assigned']++;
				}
			}
		}
		

		$this->load->view('view-index',$data);

	}

	public function getEvent(){
		$reminder = $this->db->where(array('jenis'=>'penawaran','status'=>3,'is_delete'=>0))->group_by('date(tanggal_acara)')->order_by('tanggal_acara','asc')->select('*')->get('pemesanan');

		if($reminder->num_rows()>0){
			$rem = $reminder->result();
			$arrPenawaran = [];

			foreach ($rem as $key => $value) {
				array_push($arrPenawaran, array('tanggal'=>date_format(date_create($value->tanggal_acara),'m/d/Y'),'full_date'=>date_format(date_create($value->tanggal_acara),'d F Y, H:i:s'),'event'=>[]));

				$eventAdd = $this->db->query("select * from pemesanan where jenis='penawaran' and is_delete=0 and status=3 and date(tanggal_acara)=date('".$value->tanggal_acara."')");


				if($eventAdd->num_rows()>0){
					$arrEv = $eventAdd->result();
					foreach ($arrEv as $key1 => $value1) {
						array_push($arrPenawaran[$key]['event'],array('id'=>$value1->id,'no_pemesanan'=>$value1->no_pemesanan));
					}
				}
			}

			echo json_encode($arrPenawaran);
		}else{
			$data['reminder']=array();
		}
	}

	public function getEventDate(){
		$month=$_POST['month'];
		$year=$_POST['year'];
		$query = $this->db->query("select * from pemesanan where jenis='penawaran' and is_delete=0 and status=3 and (month(tanggal_acara)=".$month." and year(tanggal_acara)=".$year.")");

		if($query->num_rows()>0){
			echo json_encode($query->result());
		}
	}

	public function pos(){
		$data['s_active']='pos';
		$data['js'] = 'js-pos';
		$data['content']='view-pos';
		$this->load->view('view-index',$data);
	}
	public function logout(){
		session_destroy();
		redirect('login');
	}

	public function gen_ex(){
		/** Error reporting */
		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);

		define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

		date_default_timezone_set('Europe/London');


		include_once APPPATH.'/third_party/excel/PHPExcel/IOFactory.php';




		
		$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		
		$objPHPExcel = $objReader->load(APPPATH.'/third_party/excel/TEMPLATE_PENAWARAN.xlsx');


		$styleArray = array(
			    'font'  => array(
			        'bold'  => true,
			        'color' => array(
			        				'rgb' => '000000'
			        			)
			    	)
			);

			$styleArray1 = array(
			    'font'  => array(
			        'color' => array(
			        				'rgb' => '000000'
			        			)
			    	),
			    'borders' => array(
				   'outline' => array(
				      'style' => PHPExcel_Style_Border::BORDER_NONE
				   ),
				)
		);

		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E10:G10');
		$objPHPExcel->getActiveSheet()->setCellValue('E10',$list[0]->nama_pemesan);

		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E11:G11');
		$objPHPExcel->getActiveSheet()->setCellValue('E11',$list[0]->nama_perusahaan);


		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E13:G13');
		$objPHPExcel->getActiveSheet()->setCellValue('E13',$list[0]->fax);

		$baseRow = 17;
		$total_all = 0;
		$keyRow = $baseRow;

		foreach($list as $key => $value) {
			$row = $baseRow + $key;
			$total_all += $value->harga_akhir;
			
			// echo $row;
			$objPHPExcel->getActiveSheet()->insertNewRowBefore($row,1);
			$objPHPExcel->setActiveSheetIndex(0)->mergeCells('D'.$row.':'.'E'.$row);
			$objPHPExcel->setActiveSheetIndex(0)->mergeCells('F'.$row.':'.'I'.$row);

			$objPHPExcel->getActiveSheet()->setCellValue('C'.$row,$value->qty)
			                              ->setCellValue('D'.$row,$value->satuan)
			                              ->setCellValue('F'.$row,$value->item_name.' - ('.$value->name_durasi.')')
			                              ->setCellValue('J'.$row,$value->harga)
			                              ->setCellValue('K'.$row,$value->harga_akhir);

			
			        // 'size'  => 12,
			        // 'name'  => 'Verdana'
			    

			// $phpExcel->getActiveSheet()->getCell('A1')->setValue('Some text');
			$objPHPExcel->getActiveSheet()->getStyle('F'.$row)->applyFromArray($styleArray1);
			$objPHPExcel->getActiveSheet()->getStyle('J'.$row)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('K'.$row)->applyFromArray($styleArray);
			                              // ->setCellValue('C'.$row, $dataRow['price'])
			                              // ->setCellValue('D'.$row, $dataRow['quantity'])
			                              // ->setCellValue('E'.$row, '=C'.$row.'*D'.$row);
			$keyRow++;
		}

		$objPHPExcel->getActiveSheet()->insertNewRowBefore($keyRow,1);
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('D'.$keyRow.':'.'E'.$keyRow);
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('F'.$keyRow.':'.'I'.$keyRow);
		$keyRow++;

		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('J'.$keyRow.':'.'K'.$keyRow);
		$objPHPExcel->getActiveSheet()->setCellValue('J'.$keyRow,$total_all);

		$r_terbilang = $keyRow+8;
		$this->load->library('tambahan');
		
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('F'.$r_terbilang.':'.'K'.$r_terbilang);
		$objPHPExcel->getActiveSheet()->setCellValue('F'.$r_terbilang,$this->tambahan->terbilang($total_all).' Rupiah');


		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$file = APPPATH.'../assets/doc_penawaran/'.$type.'_'.$list[0]->no_pemesanan.'_'.date('Y-m-d H_i_s').'.xlsx';
		$objWriter->save(str_replace('.php', '.xlsx', $file));
	}

	
}

