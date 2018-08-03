<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );

class Coupons extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model( 'DataTblModel', 'datatablemodel');

	}
	
	function index() {
		$data['couponInfoAry'] = $this->common_model->getAll('cid,name', 'coupon', array('isDeleted'=>'1', 'status'=>'1'));
		$this->load->view( 'admin/coupon_list', $data);
	}
	
	
	function add(){
		$coupanDisAry =  array();
		$catOption[]  = $this->common_model->getAll('category_id, name, parent_id', 'category', array('isDeleted'=>'1','status'=>'1','parent_id'=>'0'), 'sort_order asc');
		$data['parentArayList'] = $catOption;		
		$data['groupAry'] 		= $this->common_model->getAll('*', 'customer_group', array('isDeleted'=>'1', 'status'=>'1'));
		$data['productAry'] 	= $this->common_model->getAll('*', 'product', array('isDeleted'=>'1', 'status'=>'1'));

		$data['coupanDisAry'] 	= $coupanDisAry;
		$data['prdctIds'] 		= array();
		$data['catIds'] 		= array();
		$data['groupIds'] 		= array();
		$data['cid'] 			= '';
		$this->load->view( 'admin/coupon_add', $data);
	}

	function edit($id=''){
		$encriptedID 		= $id;
		$id 				= decode($id);
		
	
		$prdctArr 			= $this->common_model->getAll('target_id', 'coupon_cat', '', '', array('type'=> 0));
		$catArr 			= $this->common_model->getAll('target_id', 'coupon_cat', '', '', array('type'=> 1));
		$grouptArr 			= $this->common_model->getAll('target_id', 'coupon_cat', '', '', array('type'=> 2));

		foreach($prdctArr as $data){
					$prdctIds[] = $data->target_id;
		}
		foreach($catArr as $data){
					$catIds[] = $data->target_id;
		}
		foreach($grouptArr as $data){
					$groupIds[] = $data->target_id;
		}
		

		$coupanDisAry 		= $this->common_model->getAll('*', 'coupon', array('isDeleted'=>'1', 'cid'=>$id));
		$catOption[]  		= $this->common_model->getAll('category_id, name, parent_id', 'category', array('isDeleted'=>'1','status'=>'1','parent_id'=>'0'), 'sort_order asc');
		
		$data = array();
		$data['parentArayList'] = $catOption;		
		$data['groupAry'] 		= $this->common_model->getAll('*', 'customer_group', array('isDeleted'=>'1', 'status'=>'1'));
		$data['productAry'] 	= $this->common_model->getAll('*', 'product', array('isDeleted'=>'1', 'status'=>'1'));
		$data['coupanDisAry'] 	= $coupanDisAry;
		$data['cid'] 			= $encriptedID;
		$data['prdctIds'] 		= $prdctIds;
		$data['catIds'] 		= $catIds;
		$data['groupIds'] 		= $groupIds;
		$this->load->view( 'admin/coupon_add', $data);
	}

	function storeCoupon() {
	
		if(!$this->input->is_ajax_request() || !AID ) {
			exit( 'No direct script access allowed' );
		}
		$output = '';
		
		$cupId 		= decode($this->input->post('cid'));
		$name 		= $this->input->post('name');
		$code 		= $this->input->post('code');
		$type		= $this->input->post('type');
		$discount 	= $this->input->post('discount');
		$tAmnt 		= $this->input->post('tAmnt');
		$eDate 		= $this->input->post('eDate') ? convertData($this->input->post('eDate')) : NULL;
		$sDate 		= $this->input->post('sDate') ? convertData($this->input->post('sDate')) : NULL;
		$pCoupan 	= $this->input->post('pCoupan');
		
		$pCoustomer = $this->input->post('pCoustomer');
		$status 	= $this->input->post('status');
		
		$groupArr 		= $this->input->post('group');
		$productArr 	= $this->input->post('product');
		$categoryArr 	= $this->input->post('category');
		
		
		$data = array(
			'name'	=> $name,
			'code'	=> $code,
			'type'	=> $type,
			'discount'=> $discount,
			'total'=> $tAmnt,
			'date_start'=> $sDate,
			'date_end'=> $eDate,
			'uses_total'=> $pCoupan,
			'uses_customer'=> $pCoustomer,
			'status'=> $status ? $status : 1,
		);
		
		if($cupId){		
			$this->common_model->updateData('coupon', array('cid'=>$cupId), $data);
			$this->common_model->deleteData('coupon_cat', array('cid'=>$cupId));

			if(count($productArr) > 0){
				foreach($productArr as $pId){
						$pData['cid'] 		  = $cupId;
						$pData['target_id']   = $pId;
						$pData['type']        = 0;
						$this->common_model->saveData( "coupon_cat", $pData );
				}	
			}
		
			if(count($categoryArr) > 0){
				foreach($categoryArr as $cgId){
						$cData['cid'] 		 = $cupId;
						$cData['target_id']  = $cgId;
						$cData['type']       = 1;
						$this->common_model->saveData( "coupon_cat", $cData );
				}	
			}
			
			if(count($groupArr) > 0){
				foreach($groupArr as $groupId){
						$gData['cid'] 		= $cupId;
						$gData['target_id'] = $groupId;
						$gData['type']      = 2;
						$this->common_model->saveData( "coupon_cat", $gData );
				}	
			}
			
		}
		else{
			$data['created_on'] = date( "Y-m-d H:i:s", time() );
			
			$cupId = $this->common_model->saveData( "coupon", $data );
			
			if($cupId){
			
			if(count($productArr) > 0){
				foreach($productArr as $pId){
						$pData['cid'] 		  = $cupId;
						$pData['target_id']   = $pId;
						$pData['type']        = 0;
						$this->common_model->saveData( "coupon_cat", $pData );
				}	
			}			
			
			if(count($categoryArr) > 0){
				foreach($categoryArr as $cgId){
						$cData['cid'] 		 = $cupId;
						$cData['target_id']  = $cgId;
						$cData['type']       = 1;
						$this->common_model->saveData( "coupon_cat", $cData );
				}	
			}
			
			if(count($groupArr) > 0){
				foreach($groupArr as $groupId){
						$gData['cid'] 		= $cupId;
						$gData['target_id'] = $groupId;
						$gData['type']      = 2;
						$this->common_model->saveData( "coupon_cat", $gData );
				}
			}	
				
			}
			
		}
		echo json_encode( array( 'status' => true, 'cupId' => encode($cupId)) );
	}
	
	function coupon_lst(){		
		if(!$this->input->is_ajax_request() || !AID) {
			exit('Unauthorized Access');
		}

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
						
						$inData .= ' AND created_on BETWEEN "'.$startDate.'" AND "'.$endDate.'"';
					}
				}
				
			}
		}
		
		$recordsTotal = $this->common_model->countResults('coupon', array('isDeleted'=>'1'));
		
		$aColumns=array(
			'name',
			'code',
			'discount',
			'date_start',
			'date_end',
			'uses_total',
			'uses_customer',
			'cid',
			'status',
			'isDeleted',
			'type',
			'total',
			'discount',
		);

		$iSQL = "FROM coupon";
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
			$id = encode($aRow['cid']);
			
			
			$btnAra = ' <a class="green" data-tooltip="tooltip" title="Edit" href="'.base_url().'admin/coupons/edit/'.$id.'"> <i class="ace-icon fas fa-pencil-alt bigger-130"></i> </a>';
			
			$btnAra .= ' <a class="red" data-tooltip="tooltip" title="Delete" onClick="changeStatus(this, \''.$id.'\', \'delete\', \'coupon\');" href="javascript:;"> <i class="ace-icon far fa-trash-alt bigger-130"></i> </a>';
			
			$isActivCheck = '';
			$offLbl = 'Active';
			if($aRow['status'] == '1'){
				$isActivCheck = 'checked';
			}else if($aRow['status'] == '0'){
				$offLbl = 'Inactive';
			}
			
						  
			$status = '<div data-status="'.$aRow['status'].'" onClick="changeStatus(this, \''.$id.'\', \'status\', \'coupan\')" data-state="'.$offLbl.'" class="swithAraBoxBefre"><label class="switchS switchSCuStatus">
						  <input name="verifiedEmail" data-statusid="'.$id.'" value="1" class="switchS-input" type="checkbox" '.$isActivCheck.' />
						  <span class="switchS-label" data-on="Active" data-off="'.$offLbl.'"></span> <span class="switchS-handle"></span> </label></div>';

			
			if($aRow['type'] == '1'){
				$discountType = 'Percentage';
			}else {
				$discountType = 'Fixed Amount';
			}

			
			$cDetail = '<ul class=\'popovLst\'>
							<li><strong>Name:</strong> '.$aRow['name'].'</li>
							<li><strong>Total Amount: </strong> '.$aRow['total'].'</li>
							<li><strong>Discount Value: </strong> '.$aRow['discount'].'</li>
							<li><strong>Uses Per Coupon: </strong> '.$aRow['uses_total'].'</li>
							<li><strong>Uses Per Customer: </strong> '.$aRow['uses_customer'].'</li>
					    </ul>';
						
			$fullName = '<a href="javascript:;" onClick="vendorQuickView(\''.$id.'\')" title="'.$aRow['name'].'" data-trigger="hover"  data-toggle="popover"  data-content="'.$cDetail.'">'.$aRow['name'].'</a>';
			
			$row = array();
			$row[] = $fullName;
			$row[] = $aRow['code'];
			$row[] = $discountType;
			$row[] = date('jS M Y',strtotime($aRow['date_start']));
			$row[] = date('jS M Y',strtotime($aRow['date_end']));
			$row[] = $status;
			$row[] = '<div class="action-buttons">'.$btnAra.'</div>';
			$results[ 'data' ][] = $row;
		}
		$results["tempData"] = '';
		echo json_encode( $results );
	}
	
	function vendorQuickView(){
		if(!$this->input->is_ajax_request() || !AID) {
			exit('Unauthorized Access');
		}
		$aid = decode($this->input->post('aid'));
		$data = $this->common_model->getAll('*','vendor', array('vid'=>$aid, 'isDeleted'=>'1'));
		if(!$data){
			echo json_encode(array('requestStatus'=>'error'));
			exit;
		}
		$result = array(
			'requestStatus'=>'success',
			'fname'=> $data[0]->fname,
			'lname'=> $data[0]->lname,
			'email'=> $data[0]->email,
			'phone'=> $data[0]->mobile,
			'store'=> $data[0]->store_name,
			'created_on'=> date('jS M Y | h:i A', strtotime($data[0]->created_on)),
		);
		
		$iURL_profile = $this->config->item('default_path')['vendor'].'thumb/';
		$avtarURL = $iURL_profile;
		$avtarURL .= $data[0]->avtar ? $data[0]->avtar : 'user.png';
		$result['avtar'] = $avtarURL;
		
		
		if($data[0]->status == '0'){
			$result['status'] =  'Inactive';
		}else if($data[0]->status == '1'){
			$result['status'] =  'Active';
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
						
						$inData .= ' AND created_on BETWEEN "'.$startDate.'" AND "'.$endDate.'"';
					}
				}
				
			}
		}
		
		$recordsTotal = $this->common_model->countResults('admin_audittrail', array('userID'=>$aid));
		
		$aColumns=array(
			'action',
			'status',
			'ip',
			'created_on ',
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
			$row[] = date('jS M Y | h:i A',strtotime($aRow['created_on']));
			$results[ 'data' ][] = $row;
		}
		$results["tempData"] = '';
		echo json_encode( $results );
	}
	
	function getCategoryChield($cId = '0'){
		if (!AID) {
			exit( 'Unauthorized Access' );
		}
		
		$catId = $this->input->post('id') ? $this->input->post('id') : $cId;
		$notId = $this->input->post('notId');
		if($notId){
			$notId = array('category_id'=> array(decode($notId)));
		}
		$result = $this->common_model->getAll('category_id, name, parent_id', 'category', array('isDeleted'=>'1'), 'sort_order asc', array('parent_id'=>$catId), $notId);
		
		//$listAry = $this->common_model->getAll('*', 'tbl_city', '', '', array('fld_parent_id'=>$catId));
		if($this->input->post('id')){
			echo json_encode($result);
		}else{
			return($result);
		}		
	}

}