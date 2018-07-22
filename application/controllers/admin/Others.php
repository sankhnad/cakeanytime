<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );

class Others extends CI_Controller {
	function __construct() {
		parent::__construct();
	}

	function manage_users($type='', $aid='') {
		$data['activeMenu'] = 'others';
		$data['activeSubMenu'] = 'manage_users';
		$id = decode($aid);
		if($type == 'add'){			
			$data['eId'] = $aid;
			$this->load->view('admin/manage_user', $data);
		}else if($type == 'edit'){
			$data['userInfoAry'] = $this->common_model->getAll('*', 'admin_user', array('aid'=>$id, 'isDeleted'=>'1'));
			if($data['userInfoAry'] && $id){
				$data['eId'] = $aid;
				$this->load->view('admin/manage_user', $data);
			}else{
				redirect(base_url() . 'error-500');
			}
		}else if($type == 'activity-log'){
			$data['userInfoAry'] = $this->common_model->getAll('*', 'admin_user', array('aid'=>$id, 'isDeleted'=>'1'));
			if($data['userInfoAry'] && $id){
				$data['eId'] = $aid;
				$this->load->view('admin/activity_log_list', $data);
			}else{
				redirect(base_url() . 'error-500');
			}
		}else{
			$this->load->view('admin/users_list', $data);
		}
	}
	
	function users_lst(){		
		if(!$this->input->is_ajax_request() || !AID) {
			exit('Unauthorized Access');
		}
		$this->load->model( 'DataTblModel', 'datatablemodel' );
		
		$iSQL = $sWhere = $sAnd = $inData = $notInData = $sOrder = $sLimit = '';
		
		
		if(isset($_REQUEST['filterData'])){
			foreach($_REQUEST['filterData'] as $inDataKey => $inDataVal){
				if($inDataKey == 'filter_role'){
					if($inDataVal){
						$inData .= ' AND role IN("'.implode('","', $inDataVal).'")';
					}
				}
				if($inDataKey == 'filter_status'){
					if($inDataVal){
						$inData .= ' AND status IN("'.implode('","', $inDataVal).'")';
					}
				}
				if($inDataKey == 'filter_data'){
					if($inDataVal){
						$inDataVal = explode("-",$inDataVal);
						$startDate = explode("/",trim($inDataVal[0]));
						$endDate = explode("/",trim($inDataVal[1]));
						$startDate = $startDate[2].'-'.$startDate[0].'-'.$startDate[1];
						$endDate = $endDate[2].'-'.$endDate[0].'-'.$endDate[1];
						
						$inData .= ' AND created_date BETWEEN "'.$startDate.'" AND "'.$endDate.'"';
					}
				}
				
			}
		}
		
		$recordsTotal = $this->common_model->countResults('admin_user', array('isDeleted'=>'1'));
		
		$aColumns=array(
			'fname',
			'email',
			'phone',
			'created_date',
			'role',
			'status',
			'status',
			'lname',
			'avtar',
			'username',
			'aid',
		);

		$iSQL = "FROM admin_user";
		$sAnd = " AND isDeleted = '1'";
		$quryTmp = $this->datatablemodel->multi_tbl_list($aColumns, 3);
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
			$id = encode($aRow['aid']);
			$lastLogin = adminLastLogin($aRow['aid']);
			if($lastLogin){
				$lastLogin = date('jS M Y | h:i A', strtotime($lastLogin));
			}else{
				$lastLogin = 'Never Login';
			}
			
			$btnAra = ' <a class="blue" data-tooltip="tooltip" title="Quick View" onClick="adminQuickView(\''.$id.'\')" href="javascript:;"> <i class="ace-icon fas fa-search-plus bigger-130"></i></a>';
			
			$btnAra .= ' <a class="grey" data-tooltip="tooltip" title="Last Login :<br> '.$lastLogin.' " href="'.base_url().'others/manage_users/activity-log/'.$id.'"> <i class="ace-icon fas fa-undo-alt bigger-130"></i> </a>';
			
			$btnAra .= ' <a class="green" data-tooltip="tooltip" title="Edit" href="'.base_url().'others/manage_users/edit/'.$id.'"> <i class="ace-icon fas fa-pencil-alt bigger-130"></i> </a>';
			
			$btnAra .= ' <a class="red" data-tooltip="tooltip" title="Delete" onClick="deleteCommon(this,\''.$id.'\',\'admin\')" href="javascript:;"> <i class="ace-icon far fa-trash-alt bigger-130"></i> </a>';
			
			$isActivCheck = '';
			$offLbl = 'Inactive';
			if($aRow['status'] == '1'){
				$isActivCheck = 'checked';
			}else if($aRow['status'] == '2'){
				$offLbl = 'Suspend';
			}
			
			$status = '<div onClick="changeStatus(this,\''.$id.'\',\'admin\')" data-state="'.$offLbl.'" class="swithAraBoxBefre"><label class="switchS switchSCuStatus">
						  <input name="verifiedEmail" value="1" class="switchS-input" type="checkbox" '.$isActivCheck.' />
						  <span class="switchS-label" data-on="Active" data-off="'.$offLbl.'"></span> <span class="switchS-handle"></span> </label></div>';
			
			if($aRow['role'] == '1'){
				$lblNameRol = 'Super User';
				$role = '<span class="label label-sm label-success arrowed-in">'.$lblNameRol.'</span>';
			}else if($aRow['role'] == '2'){
				$lblNameRol = 'Administrator';
				$role = '<span class="label label-sm label-warning arrowed-in">'.$lblNameRol.'</span>';
			}else if($aRow['role'] == '3'){
				$lblNameRol = 'Accountant';
				$role = '<span class="label label-sm label-inverse arrowed-in">'.$lblNameRol.'</span>';				
			}else{
				$lblNameRol = 'Not Defined';
				$role = '<span class="label label-sm label-danger">'.$lblNameRol.'</span>';
			}
			$iURL_profile = $this->config->item('default_path')['profile'];
			$avtarURL = $iURL_profile.'thumb/';
			$avtarURL .= $aRow['avtar'] ? $aRow['avtar'] : 'user.png';
			
			$cDetail = '<ul class=\'popovLst\'>
							<li class=\'prvImgPoA\'><img src=\''.$avtarURL.'\' /></li>
							<li><strong>User Role:</strong> '.$lblNameRol.'</li>
							<li><strong>Username:</strong> '.$aRow['username'].'</li>
							<li><strong>Email:</strong> '.$aRow['email'].'</li>
							<li><strong>Phone:</strong> '.$aRow['phone'].'</li>
							<li><strong>Last Login:</strong> '.$lastLogin.'</li>
					    </ul>';
			
			$fullName = '<a href="javascript:;" onClick="adminQuickView(\''.$id.'\')" title="'.$aRow['fname'].' '.$aRow['lname'].'" data-trigger="hover"  data-toggle="popover"  data-content="'.$cDetail.'">'.$aRow['fname'].' '.$aRow['lname'].'</a>';
			$row = array();
			$row[] = $fullName;
			$row[] = '<a href="mailTo:'.$aRow['email'].'">'.$aRow['email'].'</span>';
			$row[] = '<a href="tel:'.$aRow['phone'].'">'.$aRow['phone'].'</span>';
			$row[] = date('jS M Y',strtotime($aRow['created_date']));
			$row[] = $role;
			$row[] = $status;
			$row[] = '<div class="action-buttons">'.$btnAra.'</div>';
			$results[ 'data' ][] = $row;
		}
		$results["tempData"] = '';
		echo json_encode( $results );
	}
	
	function adminQuickView(){
		if(!$this->input->is_ajax_request() || !AID) {
			exit('Unauthorized Access');
		}
		$aid = decode($this->input->post('aid'));
		$data = $this->common_model->getAll('*','admin_user', array('aid'=>$aid, 'isDeleted'=>'1'));
		if(!$data){
			echo json_encode(array('requestStatus'=>'error'));
			exit;
		}
		$result = array(
			'requestStatus'=>'success',
			'fname'=> $data[0]->fname,
			'email'=> $data[0]->email,
			'phone'=> $data[0]->phone,
			'created_date'=> date('jS M Y | h:i A', strtotime($data[0]->created_date)),
			'username'=> $data[0]->username,
		);
		
		$iURL_profile = $this->config->item('default_path')['profile'];
		$avtarURL = $iURL_profile.'thumb/';
		$avtarURL .= $data[0]->avtar ? $data[0]->avtar : 'user.png';
		$result['avtar'] = $avtarURL;
		
		if($data[0]->role == '1'){
			$result['role'] =  'Super User';
		}else if($data[0]->role == '2'){
			$result['role'] =  'Administrator';
		}else if($data[0]->role == '3'){
			$result['role'] =  'Accountant';		
		}
		
		if($data[0]->status == '0'){
			$result['status'] =  'Inactive';
		}else if($data[0]->status == '1'){
			$result['status'] =  'Active';
		}else if($data[0]->status == '2'){
			$result['status'] =  'Suspend';		
		}
		
		$lastLogin = adminLastLogin($aid);
		if($lastLogin){
			$result['lastLogin'] =  date('jS M Y | h:i A', strtotime($lastLogin));
		}else{
			$result['lastLogin'] =  'Never Login';	
		}
		
		echo json_encode($result);
	}
	
	function activity_log_lst(){
		if(!$this->input->is_ajax_request() || !AID) {
			exit('Unauthorized Access');
		}
		$this->load->model( 'DataTblModel', 'datatablemodel' );
		
		$iSQL = $sWhere = $sAnd = $inData = $notInData = $sOrder = $sLimit = '';
		
		
		if(isset($_REQUEST['filterData'])){
			foreach($_REQUEST['filterData'] as $inDataKey => $inDataVal){
				if($inDataKey == 'filter_aid'){
					if($inDataVal){
						$aid = decode($inDataVal);
						$inData .= ' AND userID IN("'.$aid.'")';
					}
				}
					
				
				if($inDataKey == 'filter_data'){
					if($inDataVal){
						$inDataVal = explode("-",$inDataVal);
						$startDate = explode("/",trim($inDataVal[0]));
						$endDate = explode("/",trim($inDataVal[1]));
						$startDate = $startDate[2].'-'.$startDate[0].'-'.$startDate[1];
						$endDate = $endDate[2].'-'.$endDate[0].'-'.$endDate[1];
						
						$inData .= ' AND created_date BETWEEN "'.$startDate.'" AND "'.$endDate.'"';
					}
				}
				
			}
		}
		
		$recordsTotal = $this->common_model->countResults('admin_audittrail', array('userID'=>$aid));
		
		$aColumns=array(
			'action',
			'status',
			'ip',
			'created_date ',
		);

		$iSQL = "FROM admin_audittrail";
		$quryTmp = $this->datatablemodel->multi_tbl_list($aColumns, 3);
		$sWhere = $quryTmp['where'] ? $quryTmp['where'] : ' WHERE 1 = 1 ';
		$sOrder = $quryTmp['order'];
		$sLimit = $quryTmp['limit'];
		
		$sAnd = ' AND userID = '.$aid;
		
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
			$row = array();
			$row[] = $aRow['action'];
			$row[] = $aRow['status'];
			$row[] = $aRow['ip'];
			$row[] = date('jS M Y | h:i A',strtotime($aRow['created_date']));
			$results[ 'data' ][] = $row;
		}
		$results["tempData"] = '';
		echo json_encode( $results );
	}
	
	function templates($type='2', $id='') {
		$data['activeMenu'] = 'others';
		$data['activeSubMenu'] = 'templates';
		$data['smsTemplateAry'] = $this->common_model->getAll('*', 'admin_message_template', array('type'=>'1'), 'created_on desc', '', array('isDeleted'=>array('0')));
		$data['msgTemplateAry'] = $this->common_model->getAll('*', 'admin_message_template', array('type'=>'2'), 'created_on desc', '', array('isDeleted'=>array('0')));
		$data['tabID'] = decode($id);
		$data['tabType'] = $type;
		$this->load->view('admin/templates', $data);
	}
	
	function storeTemplate() {
		if(!$this->input->is_ajax_request() || !AID) {
			exit('Unauthorized Access');
		}
		$id = decode($this->input->post('templateID'));
		$type = $this->input->post('type');
		$title = $this->input->post('title');
		$subject = $this->input->post('subject');
		$message = $this->input->post('message', FALSE);
		if(!$message && !$subject && !$title && !$type){
			echo json_encode(array('status'=>'error'));
			exit;
		}
		$data = array(
			'type'=>$type,
			'title'=>$title,
			'subject'=>$subject,
			'message'=>$message,
		);
		if($id){
			$this->common_model->updateData('admin_message_template', array('id'=>$id), $data);
			$status = 'updated';
		}else{
			$data['created_on'] = date( "Y-m-d H:i:s", time() );
			$id = $this->common_model->saveData('admin_message_template', $data);
			$status = encode($id);
		}
		echo json_encode(array('status'=>$status, 'type'=>$data['type']));
	}
	
	function restoreDefault(){
		if(!$this->input->is_ajax_request() || !AID) {
			exit('Unauthorized Access');
		}
		$id = decode($this->input->post('id'));
		$data = $this->common_model->getAll('default_title, default_subject, default_msg', 'admin_message_template', array('id'=>$id));
		echo json_encode($data);
	}
	
	function getEmailSMSTemplate(){
		if(!$this->input->is_ajax_request() || !AID) {
			exit('Unauthorized Access');
		}
		$id = $this->input->post('id');
		
		$msgTemplate = $this->common_model->getAll('id, type, title, subject, message, default_title, default_subject, default_msg', 'admin_message_template', array('id'=>$id));
		if($msgTemplate){
			$msgTitle = $msgTemplate[0]->title ? $msgTemplate[0]->title : $msgTemplate[0]->default_title;
			$msgSubject = $msgTemplate[0]->subject ? $msgTemplate[0]->subject : $msgTemplate[0]->default_subject; 
			$msgMessage = $msgTemplate[0]->message ? $msgTemplate[0]->message : $msgTemplate[0]->default_msg;
			
			$data = array(
				'id' => $msgTemplate[0]->id,
				'title' => $msgTitle,
				'subject' => $msgSubject,
				'message' => $msgMessage,
			);
			echo json_encode($data);
		}		
	}
	function refreshTemplateList(){
		if(!$this->input->is_ajax_request() || !AID) {
			exit('Unauthorized Access');
		}
		$type = $this->input->post('type');
		$templtLstAry = getTemplateEnSList($type);
		$list = '';
		foreach ( $templtLstAry as $templtLst ) {
			$lblName = $templtLst->title ? $templtLst->title : $templtLst->default_title;
			$list .= '<option value="' .$templtLst->id. '">' . $lblName . '</option>';
		}
		echo json_encode(array('result'=>$list));		
	}
}