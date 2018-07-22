<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );

class Contact  extends CI_Controller {
	public
	function __construct() {
		parent::__construct();
	}

	public
	function index() {
		$this->load->view('admin/contact_form');
	}
	
	function store_message() {
		$email = $this->input->post('email');
		$phone = $this->input->post('phone');
		$subject = $this->input->post('subject');
		$message = $this->input->post('message');
		if(!$message && !$email && !$phone){
			echo json_encode(array('status'=>'error'));
			exit;
		}
		$data = array(
			'email'=>$email,
			'phone'=>$phone,
			'subject'=>$subject,
			'message'=>$message,
			'ip'=> getHostByName(getHostName()),
			'created_on'=> date("Y-m-d H:i:s", time()),
		);
		$id = $this->common_model->saveData('admin_contact_us', $data);
		echo json_encode(array('status'=>'success'));
	}
	
	function message() {
		$data['activeMenu'] = 'contact_msg';
		if(!AID){
			redirect(base_url() . 'error-404');
		}
		$this->load->view('admin/contact_list', $data);
	}
	
	function contact_lst(){		
		if(!$this->input->is_ajax_request() || !AID) {
			exit('Unauthorized Access');
		}
		$this->load->model( 'DataTblModel', 'datatablemodel' );
		
		$iSQL = $sWhere = $sAnd = $inData = $notInData = $sOrder = $sLimit = '';
		
		
		if(isset($_REQUEST['filterData'])){
			foreach($_REQUEST['filterData'] as $inDataKey => $inDataVal){
				if($inDataKey == 'filter_isRead'){
					if($inDataVal){
						$inData .= ' AND isRead IN("'.implode('","', $inDataVal).'")';
					}
				}
				if($inDataKey == 'filter_data'){
					if($inDataVal){
						$inDataVal = explode("-",$inDataVal);
						$startDate = explode("/",trim($inDataVal[0]));
						$endDate = explode("/",trim($inDataVal[1]));
						$startDate = $startDate[2].'-'.$startDate[0].'-'.$startDate[1];
						$endDate = $endDate[2].'-'.$endDate[0].'-'.$endDate[1];
						
						$inData .= ' AND created_on BETWEEN "'.$startDate.'" AND "'.$endDate.'"';
					}
				}
			}
		}
		
		$recordsTotal = $this->common_model->countResults('admin_contact_us', array('isDeleted'=>'1'));
		
		$aColumns=array(
			'email',
			'phone',
			'subject',
			'ip',
			'created_on',
			'isRead',
			'message',
			'id',
		);

		$iSQL = "FROM admin_contact_us";
		$sAnd = " AND isDeleted = '1'";
		$quryTmp = $this->datatablemodel->multi_tbl_list($aColumns, 4);
		$sWhere = $quryTmp['where'] ? $quryTmp['where'] : ' WHERE 1 = 1 ';
		$sOrder = $quryTmp['order'];
		$sLimit = $quryTmp['limit'];

		$sQuery = "SELECT " . str_replace( " , ", " ", implode( ", ", $aColumns ) ) . " 
		$iSQL
		$sWhere
		$sAnd
		$inData
		$notInData
		$sOrder
		$sLimit
		";		
		$qtrAry = $this->common_model->customQuery($sQuery);
		
		$sQuery = "SELECT COUNT(".$aColumns[0].") AS iFiltered
		$iSQL
		$sWhere
		$sAnd
		$inData
		$notInData
		$sOrder
		";
		$iFilteredAry = $this->common_model->customQuery($sQuery);
		$recordsFiltered = $iFilteredAry[0]['iFiltered'];
		
		$sEcho = $this->input->get_post('draw',true );
		$results = array(
			"draw" => intval($sEcho),
			"recordsTotal" => $recordsTotal,
			"recordsFiltered" => $recordsFiltered,
			"data" => array(),
			"tempData" => $qtrAry
		);
		
		foreach ($results['tempData'] as $aKey => $aRow) {		
			$id = encode($aRow['id']);
			$btnAra = ' <a class="blue" data-tooltip="tooltip" title="Quick View" onClick="contactQuickView(\''.$id.'\');" href="javascript:;"> <i class="ace-icon fas fa-search-plus bigger-130"></i></a>';
			if($aRow['isRead'] == '1'){
				$btnAra .= ' <a class="green" data-isread="'.$aRow['isRead'].'" data-tooltip="tooltip" title="Mark as Read" onClick="markNotiasReadUnread(this, \''.$id.'\')" href="javascript:;"> <i class="ace-icon far fa-envelope bigger-130"></i> </a>';
			}else{
				$btnAra .= ' <a class="grey" data-isread="'.$aRow['isRead'].'" data-tooltip="tooltip" title="Mark as Unread" onClick="markNotiasReadUnread(this, \''.$id.'\')" href="javascript:;"> <i class="ace-icon far fa-envelope-open bigger-130"></i> </a>';
			}
			$btnAra .= ' <a class="red" data-tooltip="tooltip" title="Delete" onClick="deleteCommon(this,\''.$id.'\',\'contact\')" href="javascript:;"> <i class="ace-icon far fa-trash-alt bigger-130"></i> </a>';
			
			$emailURL = 'mailTo:'.$aRow['email'];
			$phoneURL = 'tel:'.$aRow['phone'];
			$lblTypeE = 'No record found associated to this email id';
			$lblTypeP = 'No record found associated to this number';
			$adminUser = $this->common_model->getAll('aid','admin_user', array('isDeleted'=>'1', 'email'=>$aRow['email']));
			if($adminUser){
				$emailURL = base_url('').'others/manage_users/edit/'.encode($adminUser[0]->aid);
				$lblTypeE = 'Admin record found associated to this mail id</br><b class=red>Click to view admin profile</b>';
			}else{
				$customerUser = $this->common_model->getAll('id', 'auth_user', array('email'=>$aRow['email']));
				if($customerUser){
					$emailURL = base_url('').'customers/view/'.encode($customerUser[0]->id);
					$lblTypeE = 'Customer record found associated to this mail id</br><b class=red>Click to view customer profile</b>';
				}
			}
			
			$adminUser = $this->common_model->getAll('aid','admin_user', array('isDeleted'=>'1', 'phone'=>$aRow['phone']));
			if($adminUser){
				$phoneURL = base_url('').'others/manage_users/edit/'.encode($adminUser[0]->aid);
				$lblTypeP = 'Admin record found associated to this phone</br><b class=red>Click to view admin profile</b>';
			}else{
				$customerUser = $this->manual_model->getFullCustomerData('b.user_id', array('b.msisdn'=>$aRow['phone']));
				if($customerUser){
					$phoneURL = base_url('').'customers/view/'.encode($customerUser[0]->user_id);
					$lblTypeP = 'Customer record found associated to this phone</br><b class=red>Click to view customer profile</b>';
				}
			}
			
			
			$row = array();
			$row[] = '<a target="_blank" data-tooltip="tooltip" title="'.$lblTypeE.'" href="'.$emailURL.'">'.$aRow['email'].'</span>';
			$row[] = '<a target="_blank" data-tooltip="tooltip" title="'.$lblTypeP.'" href="'.$phoneURL.'">'.$aRow['phone'].'</span>';
			$row[] = '<a data-tooltip="tooltip" title="'.trimData($aRow['message'], 150).'</br><b class=red>Click to view in detail</b>" href="javascript:;">'.trimData($aRow['subject'], 60).'</span>';
			$row[] = $aRow['ip'];
			$row[] = date('jS M Y | h:i A',strtotime($aRow['created_on']));
			$row[] = '<div class="action-buttons">'.$btnAra.'</div>';
			$results[ 'data' ][] = $row;
		}
		$results["tempData"] = '';
		echo json_encode( $results );
	}
	
	function markReadUnread(){
		if ( !$this->input->is_ajax_request() || !AID ) {
			exit('Unauthorized Access');
		}
		$id = $this->input->post('id');
		if($id == 'all'){
			$process = $this->common_model->updateData("admin_contact_us", array('isRead' => '1'), array('isRead' => '0'));
		}else{
			$id = decode($id);
			$data = array(
				'isRead' => $this->input->post('type')
			);
			$process = $this->common_model->updateData("admin_contact_us", array('id' => $id), $data);	
		}		
		echo json_encode( array( 'status' => $process ) );
	}
	
	function contactQuickView(){
		if(!$this->input->is_ajax_request() || !AID) {
			exit('Unauthorized Access');
		}
		$id = decode($this->input->post('id'));
		$data = $this->common_model->getAll('*','admin_contact_us', array('id'=>$id, 'isDeleted'=>'1'));
		if(!$data){
			echo json_encode(array('requestStatus'=>'error'));
			exit;
		}
		$email = $data[0]->email;
		$phone = $data[0]->phone;
		$emailURL = 'mailTo:'.$email;
		$phoneURL = 'tel:'.$phone;
		$lblTypeE = 'No record found associated to this email id';
		$lblTypeP = 'No record found associated to this number';
		$adminUser = $this->common_model->getAll('aid','admin_user', array('isDeleted'=>'1', 'email'=>$email));
		if($adminUser){
			$emailURL = base_url('').'others/manage_users/edit/'.encode($adminUser[0]->aid);
			$lblTypeE = 'Admin record found associated to this mail id</br><b class=red>Click to view admin profile</b>';
		}else{
			$customerUser = $this->common_model->getAll('id', 'auth_user', array('email'=>$email));
			if($customerUser){
				$emailURL = base_url('').'customers/view/'.encode($customerUser[0]->id);
				$lblTypeE = 'Customer record found associated to this mail id</br><b class=red>Click to view customer profile</b>';
			}
		}

		$adminUser = $this->common_model->getAll('aid','admin_user', array('isDeleted'=>'1', 'phone'=>$phone));
		if($adminUser){
			$phoneURL = base_url('').'others/manage_users/edit/'.encode($adminUser[0]->aid);
			$lblTypeP = 'Admin record found associated to this phone</br><b class=red>Click to view admin profile</b>';
		}else{
			$customerUser = $this->manual_model->getFullCustomerData('b.user_id', array('b.msisdn'=>$phone));
			if($customerUser){
				$phoneURL = base_url('').'customers/view/'.encode($customerUser[0]->user_id);
				$lblTypeP = 'Customer record found associated to this phone</br><b class=red>Click to view customer profile</b>';
			}
		}
		
		$result = array(
			'requestStatus'=>'success',
			'subject'=> $data[0]->subject,
			'message'=> $data[0]->message,
			'ip'=> $data[0]->ip,
			'emailOnly'=> $email,
			'email'=> '<a target="_blank" data-tooltip="tooltip" title="'.$lblTypeE.'" href="'.$emailURL.'">'.$email.'</span>',
			'phone'=> '<a target="_blank" data-tooltip="tooltip" title="'.$lblTypeP.'" href="'.$phoneURL.'">'.$phone.'</span>',
			'created_on'=> date('jS M Y | h:i A', strtotime($data[0]->created_on))
		);
		
		echo json_encode($result);
	
	}
}