<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Log_status {
	function add_log($id_pem=null,$status=null,$type=null){
		// echo $type;
		if($type=='pemesanan'){
			$stat[0]=array('color'=>'bg-red','status'=>'Waiting Approval'); //Order Received
			$stat[1]=array('color'=>'bg-darken-2','status'=>'Order Received');
			$stat[2]=array('color'=>'bg-yellow','status'=>'Courir Assigned'); //Courir Assigned
			$stat[3]=array('color'=>'bg-aqua','status'=>'Prepare Item'); //Packing Done
			$stat[4]=array('color'=>'bg-blue','status'=>'Courier On The Way'); //Courier On The Way
			$stat[5]=array('color'=>'btn-success','status'=>'Done');
			$stat[6]=array('color'=>'btn-danger','status'=>'Cancel');

			$log = array(
							'id_pemesanan'=>$id_pem,
							'jenis'=>$type,
							'status'=>$status,
							'status_txt'=>$stat[$status]['status'],
							'insert_by'=>$_SESSION['id_user'],
							'update_by'=>$_SESSION['id_user']
						);
			return $log;
			// echo "HIHI";
		}

		if($type=='penawaran'){
			$stat[0]=array('color'=>'bg-red','status'=>'Pending'); //Order Received
			$stat[1]=array('color'=>'bg-darken-2','status'=>'On Progress');
			$stat[2]=array('color'=>'bg-yellow','status'=>'Negotiation'); //Courir Assigned
			$stat[3]=array('color'=>'bg-aqua','status'=>'Success'); //Packing Done
			$stat[4]=array('color'=>'bg-blue','status'=>'Decline'); //Courier On The Way
			// $stat[5]=array('color'=>'btn-success','status'=>'Done');
			// $stat[6]=array('color'=>'btn-danger','status'=>'Cancel');

			$log = array(
							'id_pemesanan'=>$id_pem,
							'jenis'=>$type,
							'status'=>$status,
							'status_txt'=>$stat[$status]['status'],
							'insert_by'=>$_SESSION['id_user'],
							'update_by'=>$_SESSION['id_user']
						);
			return $log;
			// echo "HAHA";
		}
	}

}