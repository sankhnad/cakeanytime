<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );

class Groups extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model( 'DataTblModel', 'datatablemodel' );
	}

	function index() {
		$data['activeMenu'] = 'groups';
		$this->load->view('admin/group_list', $data);
	}
	
	function addEditGroup() {
		if(!$this->input->is_ajax_request() || !AID ) {
			exit( 'Unauthorized Access!!' );
		}
		
		$id = decode($this->input->post('cgid'));
		$name = $this->input->post('name');
		$default = $this->input->post('default');
		$data = array(
			'name'=>$name,
			'isDefault'=>$default ? $default : '0',
		);
		
		if($default){
			$this->common_model->updateData('customer_group', array('isDefault'=>1), array('isDefault'=>2));
		}
		if($id){			
			$id = $this->common_model->updateData('customer_group', array('id'=>$id), $data);
		}else{
			$data['created_on'] = date("Y-m-d H:i:s", time());
			$id = $this->common_model->saveData( "customer_group", $data );
		}
		echo json_encode( array( 'status' => true ) );
	}
	
	
	function getData() {
		if(!$this->input->is_ajax_request() || !AID ) {
			exit( 'Unauthorized Access!!' );
		}
		$id = decode($this->input->post('id'));
		$type = $this->input->post('type');
		
		if($type == 'groups'){
			$select = 'id, name, isDefault';
			$table = 'customer_group';
			$where = array(
				'id'=>$id,
				'isDeleted'=>'1'
			);
			$objData = $this->common_model->getAll($select, $table, $where);
			$result = array(
				'name' => $objData[0]->name,
			);
		}
		
		echo json_encode($result);
	}

	function groups_lst() {
		if(!$this->input->is_ajax_request() || !AID) {
			exit('Unauthorized Access');
		}
		
		$iSQL = $sWhere = $sAnd = $inData = $notInData = $sOrder = $sLimit = '';
		
		
		if(isset($_REQUEST['filterData'])){
			foreach($_REQUEST['filterData'] as $inDataKey => $inDataVal){
				if ( $inDataKey == 'filter_status' ) {
					if($inDataVal){
						$inData .= ' AND status IN("'.implode('","', $inDataVal).'")';
					}
				}
				if($inDataKey == 'filter_date'){
					if($inDataVal){
						$tempDate = convertToSQLDate($inDataVal);
						$startDate = $tempDate[0];
						$endDate = isset($tempDate[1]) ? $tempDate[1] : '';
						$inData .= ' AND created_on BETWEEN "'.$startDate.'" AND "'.$endDate.'"';
					}
				}				
				
			}
		}	
		
		$recordsTotal = $this->common_model->countResults('customer_group', array('isDeleted'=>'1'));
		
		$aColumns=array(
			'id',
			'name',
			'(SELECT Count(*) FROM customer_group_member WHERE group_id = id) as totoal_member',
			'created_on',
			'status',
			'isDefault',
		);
		
	
		$iSQL = "FROM customer_group";
	
		
		$quryTmp = $this->datatablemodel->multi_tbl_list($aColumns, 2);
		$sWhere = $quryTmp['where'] ? $quryTmp['where'] : ' WHERE 1 = 1 ';
		$sOrder = $quryTmp['order'];
		$sLimit = $quryTmp['limit'];
		$sAnd 	= ' AND isDeleted="1"';
		
		
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
			$isDefault	= '';
			$id = encode($aRow['id']);
			
			$isActivCheck = '';
			if($aRow['status'] == '1'){
				$isActivCheck = 'checked';
			}
			
			$status = '<div data-gide="'.$id.'" onClick="changeStatus(this,\''.$id.'\',\'status\',\'groups\')" class="swithAraBoxBefre"><label class="switchS switchSCuStatus">
						  <input name="group_status" value="1" class="switchS-input" type="checkbox" '.$isActivCheck.' />
						  <span class="switchS-label" data-on="Active" data-off="Inactive"></span> <span class="switchS-handle"></span> </label></div>';

			$btnAra = '<a class="blue" data-tooltip="tooltip" onclick="editGroup(this,\''.$id.'\', \'groups\')" title="Edit" href="javascript:;"> <i class="ace-icon fas fa-pencil-alt bigger-130"></i></a>';
			$btnAra .= '<a class="red" data-tooltip="tooltip" onclick="changeStatus(this, \''.$id.'\', \'delete\', \'groups\')" title="Delete" href="javascript:;"> <i class="ace-icon far fa-trash-alt bigger-130"></i></a>';
			$btnAra .= '<a class="blue" data-tooltip="tooltip" title="Click to view in detail" href="'.admin_url().'groups/view/'.$id.'"> <i class="menu-icon fas fa-users bigger-130"></i></i></a>';

			
			if($aRow['isDefault'] == '1'){
				$isDefault = ' <span class="text-primary"> (Default)</span>';
			}

			
			$row = array();
			
			$row[] = $aRow['name'].$isDefault;
			$row[] = '<a target="_blank"  data-toggle="tooltip" title="Click here to view in detail" href="'.admin_url().'customer/groups/'.$id.'">'.$aRow['totoal_member'].'</a>';
			$row[] = date('jS M Y | h:i A',strtotime($aRow['created_on']));
			$row[] = $status;
			$row[] = $btnAra;
			$results[ 'data' ][] = $row;
		}
		$results["tempData"] = '';
		echo json_encode( $results );
	}
	
	function view($eID=''){
		$id = decode($eID);
		$assignCustAry = $this->common_model->getAll('customer_id', 'customer_group_member', array('group_id '=>$id,'member_status'=>0));
		$custIdArray = array();
		foreach($assignCustAry as $dataVal){
			$custIdArray[] = $dataVal->customer_id;
		}
		
		$data['groupDetailAry'] = $this->common_model->getAll('name,id', 'customer_group', array('id'=>$id));
		$data['customerAry'] 	= $this->common_model->getAll('fname,lname,id', 'customer', array('status'=>1,'isDeleted'=>1));
		$data['custIds'] 		= $custIdArray;
		if(!$data['groupDetailAry']){
			redirect(base_url() . 'error-500');
		}
		$data['eID'] = $eID;
		$data['gName'] = $data['groupDetailAry'][0]->name;
		$data['activeMenu'] = 'groups';
		$this->load->view('admin/group_data', $data);
	}
	
	
	function groups_data_lst() {
		if(!$this->input->is_ajax_request() || !AID) {
			exit('Unauthorized Access');
		}
		
		$iSQL = $sWhere = $sAnd = $inData = $notInData = $sOrder = $sLimit = '';
		$cgId = decode($_REQUEST['filterData']['id']);
		
		$recordsTotal = $this->common_model->countResults('customer_group_member', array('id'=>$cgId));
		
		$aColumns=array(
			'c.fname',
			'c.lname',
			'c.email',
			'c.mobile',
			'a.member_status',
			'a.id',
			'c.id as customer_id',
			'a.group_id',
			'a.modified_on',
			
		);
		
		$iSQL = "FROM customer_group_member as a 
				LEFT JOIN customer as c 
				ON c.id = a.customer_id";
		
		$quryTmp = $this->datatablemodel->multi_tbl_list($aColumns, 3);
		$sWhere = $quryTmp['where'] ? $quryTmp['where'] : ' WHERE 1 = 1 ';
		$sOrder = $quryTmp['order'];
		$sLimit = $quryTmp['limit'];
		$sAnd = " AND group_id = '".$cgId."'";
		
		
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
			$cid = encode($aRow['customer_id']);
			$id = encode($aRow['id']);
			$group_account = encode($aRow['id']);
			
			$isActivCheck = '';
			if($aRow['member_status'] == '1'){
				$isActivCheck = 'checked';
			}
			
			$status = '<div data-cide="'.$id.'" data-isadmin="'.$aRow['member_status'].'" onClick="changeGroupMemberStatus(this,\''.$id.'\',\'group_member\',\''.$aRow['email'].'\',\''.$aRow['mobile'].'\')" class="swithAraBoxBefre"><label class="switchS switchSCuStatus">
						  <input name="verifiedEmail" value="1" class="switchS-input" type="checkbox" '.$isActivCheck.' />
						  <span class="switchS-label" data-on="Active" data-off="Inactive"></span> <span class="switchS-handle"></span> </label></div>';
			
			$cDetail = '<ul class=\'popovLst\'>
							<li><strong>Username:</strong> '.$aRow['fname'].''.$aRow['lname'].'</li>
							<li><strong>Email:</strong> '.$aRow['email'].'</li>
							<li><strong>Phone:</strong> '.$aRow['mobile'].'</li>
					    </ul>';
			
			$fullName = '<a target="_blank" href="'.admin_url().'customers/view/'.$cid.'" title="'.$aRow['fname'].' '.$aRow['lname'].'" data-trigger="hover"  data-toggle="popover"  data-content="'.$cDetail.'">'.$aRow['fname'].' '.$aRow['lname'].'</a>';
			
			$row = array();
			$row[] = $fullName;
			$row[] = '<a data-mstatus="'.$aRow['member_status'].'" class="emailListing" href="mailTo:'.$aRow['email'].'">'.$aRow['email'].'</span>';
			$row[] = '<a data-mstatus="'.$aRow['member_status'].'" class="phoneListing" href="tel:'.$aRow['mobile'].'">'.$aRow['mobile'].'</span>';
			$row[] = date('jS M Y | h:i A',strtotime($aRow['modified_on']));
			$row[] = $status;
			$results[ 'data' ][] = $row;
		}
		$results["tempData"] = '';
		echo json_encode( $results );
	}
	
	
	function getmembersonly($account='', $isType='', $isActive=''){
		if(!$this->input->is_ajax_request() || !AID || !$account) {
			exit('Unauthorized Access');
		}
		
		$where = array('b.group_id'=>decode($account));

		if($isActive != ''){
			$where['b.member_status'] = $isActive;
		}
		$resultsAry = $this->manual_model->getFullGroupInfo('c.fname, c.lname, c.id', $where);
		$data = array();
		foreach($resultsAry as $results){
			$data[] = array(
				'name' => $results->fname.' '.$results->lname,
				'customer_id' => encode($results->id),
			);			
		}
		echo json_encode( $data );
		
	}
	
	
	function assignGroupMembers(){
		$customerArr = $this->input->post('customers');
		$groupId 	 = decode($this->input->post('groupAccount'));
		
		$this->common_model->deleteData('customer_group_member', array('group_id'=>$groupId));
		
		foreach($customerArr as $data){
			$data = array(
				'group_id'=>$groupId,
				'customer_id'=>$data,
				'member_status'=>'0',
				'modified_on'=>date("Y-m-d H:i:s", time())
			);
			$this->common_model->saveData( "customer_group_member", $data );
		 }

		echo json_encode(array('status'=>'success'));
	}
	
	function suspendGroupMemberReason(){
		$groupID = decode($this->input->post('groupID'));
		$comment = $this->input->post('comment');
		
		if($groupID){
			$this->common_model->updateData('customer_group', array('id'=>$groupID), array('comment'=>$comment));
		}else{
			$groupId = decode($this->input->post('gid'));
			$id = decode($this->input->post('mid'));
			
			$this->common_model->updateData('customer_group_member', array('group_id'=>$groupId, 'id'=>$id), array('comment'=>$comment));
		}
		
		echo json_encode(array('status'=>'success'));
	}
	
}

