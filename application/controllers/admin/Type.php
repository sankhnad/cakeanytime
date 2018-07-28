<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );

class Type extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model( 'DataTblModel', 'datatablemodel');
	}
	
	function index() {
		$data['activeMenu'] = 'store';
		$data['activeSubMenu'] = 'type';
		$this->load->view( 'admin/type_list', $data);
	}
	
	function type_list() {
		if(!$this->input->is_ajax_request() || !AID ) {
			exit( 'No direct script access allowed' );
		}
		
		$iSQL = $sWhere = $sAnd = $inData = $notInData = $sOrder = $sLimit = '';
		$tbl = 'type';

		if(isset($_REQUEST['filterData'])){			
			foreach($_REQUEST['filterData'] as $inDataKey => $inDataVal){
				if($inDataKey == 'status_filter'){
					if($inDataVal){
						$filterData .= ' AND status IN("'.implode('","', $inDataVal).'")';
					}
				}
				if ( $inDataKey == 'filter_date' ) {
					if ( $inDataVal ) {
						$inDataVal = explode( "-", $inDataVal );
						$startDate = explode( "/", trim( $inDataVal[ 0 ] ) );
						$endDate = explode( "/", trim( $inDataVal[ 1 ] ) );
						$startDate = $startDate[ 2 ] . '-' . $startDate[ 0 ] . '-' . $startDate[ 1 ];
						$endDate = $endDate[ 2 ] . '-' . $endDate[ 0 ] . '-' . $endDate[ 1 ];
						$inData .= ' AND created_on BETWEEN "' . $startDate . '" AND "' . $endDate . '"';
					}
				}
			}
		}

		$recordsTotal = $this->common_model->countResults($tbl, array('isDeleted'=>'1'));

		$aColumns=array(
			'name',
			'url_slug',
			'image',
			'sort_order',
			'status',
			'created_on',
			'type_id',
		);
		
		$iSQL = " FROM ".$tbl;

		$quryTmp = $this->datatablemodel->multi_tbl_list( $aColumns, 0 );
		$sWhere = $quryTmp[ 'where' ] ? $quryTmp[ 'where' ] : ' WHERE 1 = 1 ';
		$sOrder = $quryTmp[ 'order' ];
		$sLimit = $quryTmp[ 'limit' ];		
		
		$sAnd =  ' AND isDeleted = "1"';
		
		$sQuery = "SELECT " . str_replace( " , ", " ", implode( ", ", $aColumns ) ) . " 
		$iSQL
		$sWhere
		$sAnd
		$inData
		$notInData
		$sOrder
		$sLimit
		";
		
		$qtrAry = $this->common_model->customQuery( $sQuery );

		$sQuery = "SELECT COUNT(".$aColumns[1].") AS iFiltered
		$iSQL
		$sWhere
		$sAnd
		$inData
		$notInData
		";
		
		$iFilteredAry = $this->common_model->customQuery( $sQuery );
		$recordsFiltered = $iFilteredAry[ 0 ][ 'iFiltered' ];

		$sEcho = $this->input->get_post( 'draw', true );
		$results = array(
			"draw" => intval( $sEcho ),
			"recordsTotal" => $recordsTotal,
			"recordsFiltered" => $recordsFiltered,
			"data" => array(),
			"tempData" => $qtrAry
		);
		
		foreach ( $results['tempData'] as $aKey => $aRow ) {		
			$id = $aRow['type_id'];
			$encodedID = encode($id);
			
			$lastLogin = customerLastLogin($id);
			if($lastLogin){
				$lastLogin = date('jS M Y | h:i A', strtotime($lastLogin));
			}else{
				$lastLogin = 'Never Login';
			}
			$registeredOn = date('jS M Y | h:i A',strtotime($aRow['created_on']));
			

		
			$btnAra = ' <a class="blue" data-tooltip="tooltip" title="Edit" href="'.admin_url().'type/edit/'.$encodedID.'"> <i class="ace-icon fas fa-pencil-alt bigger-130"></i> </a>';
			
			$btnAra .= ' <a class="red" data-tooltip="tooltip" title="Delete" onClick="deleteCommon(this,\''.$encodedID.'\',\'type\')" href="javascript:;"> <i class="ace-icon far fa-trash-alt bigger-130"></i> </a>';
			
			
			
			$isActivCheck = '';
			$offLbl = 'Inactive';
			if($aRow['status'] == '1'){
				$isActivCheck = 'checked';
				$offLbl = 'Active';
			}
			
			$status = '<div data-status="'.$aRow['status'].'" onClick="changeStatus(this, \''.$encodedID.'\', \'status\', \'type\')" data-state="'.$offLbl.'" class="swithAraBoxBefre"><label class="switchS switchSCuStatus">
						  <input name="verifiedEmail" data-statusid="'.$encodedID.'" value="1" class="switchS-input" type="checkbox" '.$isActivCheck.' />
						  <span class="switchS-label" data-on="Active" data-off="'.$offLbl.'"></span> <span class="switchS-handle"></span> </label></div>';
			
			$iURL_type = $this->config->item('default_path')['type'];
			$avtarURL = $iURL_type.'thumb/';
			$avtarURL .= $aRow['image'] ? $aRow['image'] : 'user.png';
			
			$cDetail = '<ul class=\'popovLst\'>
							<li class=\'prvImgPoA\'><img src=\''.$avtarURL.'\' /></li>
					    </ul>';
			
			$fullName = '<a href="javascript:;" data-trigger="hover"  data-toggle="popover"  data-content="'.$cDetail.'">'.$aRow['name'].'</a>';
			

			$row = array();	
			$row[] = $fullName;
			$row[] = $aRow['sort_order'];
			$row[] = $status;			
			$row[] = '<div class="action-buttons">'.$btnAra.'</div>';
			$results[ 'data' ][] = $row;
		
		}
		$results[ "tempData" ] = '';
		echo json_encode( $results );
	}	
	
	
	
	function add(){
		$typeDisAry  = array();
		$data['typeDisAry'] = $typeDisAry;
		$data['eTID'] = '';
		$data['activeMenu'] = 'type';
		$data['activeMenu'] = 'store';
		$data['activeSubMenu'] = 'type';

		$this->load->view( 'admin/type_data', $data);
	}
	
	function edit($id=''){
		if(!AID ) {
			exit( 'No direct script access allowed' );
		}
		$encriptedID = $id;
		$id = decode($id);
		if(!$id){
			$this->load->view('admin/404');
			return(false);
		}
		$typeDisAry = $this->common_model->getAll('*', 'type', array('isDeleted'=>'1', 'type_id'=>$id));
		
		if(!$typeDisAry){
			$this->load->view('admin/404');
			return(false);
		}
		
		$data['typeDisAry'] = $typeDisAry;
		$data['eTID'] = $encriptedID;
		$data['activeMenu'] = 'type';
		$data['activeMenu'] = 'store';
		$data['activeSubMenu'] = 'type';

		$this->load->view( 'admin/type_data', $data);
	}
	
	function storeType() {
		if(!$this->input->is_ajax_request() || !AID ) {
			exit( 'No direct script access allowed' );
		}
		

		$tid 		= decode($this->input->post('tid'));
		$name 		= $this->input->post( 'name' );
		$slug 		= $this->input->post( 'url_slug' );
		$sort 		= $this->input->post( 'sort' );
		$metaDesc 	= $this->input->post( 'meta_desc' );
		$metaKey 	= $this->input->post( 'meta_keywords' );
		$desc 		= $this->input->post( 'desc' );
		$categoryID = $this->input->post( 'category' ) ? $this->input->post( 'category' ) : '0';
		$isTop 		= $this->input->post( 'isTop' ) ? $this->input->post( 'isTop' ) : '0';
		$isLeft 	= $this->input->post( 'isLeft' ) ? $this->input->post( 'isLeft' ) : '0';
		$mobileViwe = $this->input->post( 'isMobile' ) ? $this->input->post( 'isMobile' ) : '0';
		$status 	= $this->input->post( 'isStatus' ) ? $this->input->post( 'isStatus' ) : '0';
		$data = array(
			'name' => trim($name),
			'url_slug' => trim($slug),
			'sort_order' => $sort,
			'isTopBar' => trim($isTop),
			'isLeftBar' => trim($isLeft),
			'meta_description' => trim($metaDesc),
			'meta_keyword' => trim($metaKey),
			'description' => trim($desc),
			'mobile_display' => trim($mobileViwe),
			'status' => $status,
		);
		
		
		$avtar = $_FILES['img']['name'];
		$icon  = $_FILES['icon']['name'];
		if($avtar){
			$data['image'] = uploadFiles('img', $path = 'uploads/type/', 'thumb', 360, 360 );
		}	
			
		if($icon){
			$data['icon'] = uploadFiles('img', $path = 'uploads/type/', 'thumb', 360, 360 );
		}	
		
			
		if($tid){		
			$this->common_model->updateData('type', array('type_id'=>$tid), $data);
		}else{
			$data['created_on'] = date( "Y-m-d H:i:s", time() );
			$cid = $this->common_model->saveData( "type", $data );
		}
		
		echo json_encode( array( 'status' => true, 'tid' => encode($tid)) );
	}
	
	
	function generateURLSlug(){
		if ( !$this->input->is_ajax_request() || !AID ) {
			exit( 'Unauthorized Access' );
		}
		//echo '<pre>';print_r($this->input->post());die;
		$catName = $this->input->post('data');
		$type = $this->input->post('type');
		$notId = $this->input->post('notId');
		if($notId){
			$notId = array('type_id'=> array(decode($notId)));
		}
		$slug = slugify($catName);
		
		
		$iCount = $this->common_model->getAll('count(type_id) as totl', 'type', array('isDeleted'=>'1','url_slug'=>$slug), '', '', $notId);
		$iCount = $iCount[0]->totl;
		
		if($iCount > 0 && $type == 'type'){
			$iTotalAry = $this->manual_model->findDubliSlug($slug,'type');
			$iTotal = $iTotalAry[0]->iTotal;			
			$slug = $slug.($iTotal);
		}
		if($type == 'slug'){
			echo json_encode(array('status'=> $iCount > 0 ? 'error':'success'));
		}else if($type == 'type'){
			echo json_encode(array('slug'=> $slug));
		}
		
	}

	
	function checkCustEmailAvlb( $data = '', $type = '', $cid='' ) {
		if ( !$this->input->is_ajax_request() || !AID ) {
			exit( 'No direct script access allowed' );
		}
		$data = $data == '' ? $_REQUEST[ 'data' ] : $data;
		$type = $type == '' ? $_REQUEST[ 'type' ] : $type;
		if(isset($_REQUEST['id']) || $cid){
			$cid = $cid == '' ? decode($_REQUEST['id']) : $cid;
		}
		if ( $type == 'email' ) {
			$where = array( 'email' => $data );
		} elseif ( $type == 'mobile' ) {
			$where = array( 'mobile' => $data );
		} else {
			return false;
		}
		if($cid !=''){
			$notinData = array('id'=> array($cid));
		}else{
			$notinData = array();
		}
		
		$data = $this->common_model->getAll('id', 'customer', $where, '', '', $notinData);
		if ( count( $data ) > 0 ) {
			$status =  'error';
		} else {
			$status =  'valid';
		}
		if(isset($_REQUEST['data'])){
			echo json_encode( array( 'status' => $status ) );
		}else{
			return($status);
		}
	}
		
	function changeStatus() {
		if(!$this->input->is_ajax_request() || !AID ) {
			exit( 'No direct script access allowed' );
		}
		$id = decode($this->input->post('cid'));
		$status = $this->input->post('status');
		$type = $this->input->post('type');
		
		if($type == 'delete'){
			$data = array(
				'isDeleted'=> $status,
			);
		}else{
			$data = array(
				'status'=> $status,
			);
		}
		$this->common_model->updateData('tbl_customer', array('cid'=>$id), $data);
		echo json_encode( array( 'status' => true ) );
	}
	
	
	
	function editNewAddress(){
		if(!$this->input->is_ajax_request() || !AID ) {
			exit( 'No direct script access allowed' );
		}
		$aid = decode($this->input->post('aid'));
		$cid = decode($this->input->post('cid'));
		$name = trim($this->input->post('name'));
		$mobile = $this->input->post('mobile');
		$pin = $this->input->post('pin');
		$addresline1 = trim($this->input->post('addresline1'));
		$addresline2 = trim($this->input->post('addresline2'));
		$landmark = trim($this->input->post('landmark'));
		$city = trim($this->input->post('city'));
		$state = $this->input->post('state');
		$isDefault = $this->input->post('isDefault');
		$type = $this->input->post('type');
		if($type == '3'){
			$type = $this->input->post('otherTypVal');
		}
		
		$data = array(
			'fld_cid'		=> $cid,
			'fld_name'		=> rtrim($name,','),
			'fld_mobile'	=> str_replace(' ', '', $mobile),
			'fld_pin'		=> $pin,
			'fld_address_line_1'=> rtrim($addresline1,','),
			'fld_address_line_2'=> rtrim($addresline2,','),
			'fld_landmark'	=> rtrim($landmark,','),
			'fld_city'		=> rtrim($city,','),
			'fld_stateCode'	=> $state,
			'fld_type'	=> $type,
		);
		if($isDefault){
			$this->common_model->updateData('tbl_address', array('fld_isDefault'=>2, 'fld_cid'=>$cid), array('fld_isDefault'=>1));
			$data['fld_isDefault'] = '1';
		}else{
			$data['fld_isDefault'] = '2';
		}
		if($aid){		
			$this->common_model->updateData('tbl_address', array('fld_aid'=>$aid), $data);
		}else{
			$data['fld_created_date'] = date( "Y-m-d H:i:s", time() );
			$aid = $this->common_model->saveData( "tbl_address", $data );
		}
		echo json_encode( array('aid' => encode($aid)) );
	}
	
	function getAddress(){
		$output = '';
		$aid = decode($this->input->post('aid'));
		$cid = decode($this->input->post('cid'));
		$where = array(
			'fld_cid'		=> $cid,
			'fld_aid'		=> $aid,
			'fld_isDeleted'		=> '2',
		);
		$data = $this->common_model->getAll('*', 'tbl_address', $where);
		if($data){
			$output = array(
				'name'		=> $data[0]->fld_name,
				'mobile'	=> $data[0]->fld_mobile,
				'pin'		=> $data[0]->fld_pin,
				'address_line_1'=> $data[0]->fld_address_line_1,
				'address_line_2'=> $data[0]->fld_address_line_2,
				'landmark'	=> $data[0]->fld_landmark,
				'city'		=> $data[0]->fld_city,
				'sid'	=> $data[0]->fld_stateCode,
				'type'	=> $data[0]->fld_type,
				'isDefault'	=> $data[0]->fld_isDefault,
			);
		}
		echo json_encode($output);
	}
	
	function setDefaultAddress(){
		$tbl = 'tbl_address';
		$aid = decode($this->input->post('aid'));
		$cid = decode($this->input->post('cid'));
		$this->common_model->updateData($tbl, array('fld_isDefault'=>1), array('fld_isDefault'=>2, 'fld_cid'=>$cid));
		
				
		$aid = decode($this->input->post('aid'));
		$where = array('fld_aid'=>$aid);
		$data = array(
			'fld_isDefault'=> '1',
		);
		
		$this->common_model->updateData($tbl, $where, $data);
		echo json_encode( array( 'status' => true ) );
	}
}