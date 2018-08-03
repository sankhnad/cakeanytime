ssss
<?php
defined( 'BASEPATH' )OR exit( 'Unauthorized Access!!' );

class Location extends CI_Controller {

	function index() {
		$data['activeMenu'] = 'location';
		$data['activeSubMenu'] = 'state';
		$this->load->view('admin/state_list', $data);
	}


	function state(){
		$this->index();
	}

	function state_list() {
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

		$recordsTotal = $this->common_model->countResults('location_state', array('isDeleted'=>'1'));

		$aColumns=array(
			'stateName',
			'(SELECT COUNT(*) FROM location_city WHERE sid = location_state.sid AND isDeleted = 1) AS totalCity',
			'created_on',
			'status',
			'sid',
		);

		$iSQL = "FROM location_state";

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
			$id = encode($aRow['sid']);

			$isActivCheck = '';
			if($aRow['status'] == '1'){
				$isActivCheck = 'checked';
			}

			$status = '<div data-statusid="'.$id.'" onClick="changeLocationStatus(this,\''.$id.'\',\'state\')" class="swithAraBoxBefre"><label class="switchS switchSCuStatus">
						  <input name="group_status" value="1" class="switchS-input" type="checkbox" '.$isActivCheck.' />
						  <span class="switchS-label" data-on="Active" data-off="Inactive"></span> <span class="switchS-handle"></span> </label></div>';

			$btnAra = '<a class="blue" data-tooltip="tooltip" onclick="editLocation(this,\''.$id.'\', \'state\')" title="Edit" href="javascript:;"> <i class="ace-icon fas fa-pencil-alt bigger-130"></i></a>';
			$btnAra .= '<a class="red" data-tooltip="tooltip" onclick="deleteLocation(this,\''.$id.'\', \'state\')" title="Delete" href="javascript:;"> <i class="ace-icon far fa-trash-alt bigger-130"></i></a>';

			$row = array();
			$row[] = $aRow['stateName'];
			$row[] = '<a target="_blank"  data-toggle="tooltip" title="Click here to view in detail" href="'.admin_url().'location/city/'.$id.'">'.$aRow['totalCity'].' Cities</a>';
			$row[] = date('jS M Y | h:i A',strtotime($aRow['created_on']));
			$row[] = $status;
			$row[] = '<span data-id="'.$id.'" class="btnAreaAction">'.$btnAra.'</span>';
			$results['data'][] = $row;
		}
		$results["tempData"] = '';
		echo json_encode( $results );
	}

	function addEditState() {
		if(!$this->input->is_ajax_request() || !AID ) {
			exit( 'Unauthorized Access!!' );
		}
		$id = decode($this->input->post('sid'));
		$name = $this->input->post('name');


		if($id){
			$data = array(
				'stateName'=>$name[0],
			);
			$id = $this->common_model->updateData('location_state', array('sid'=>$id), $data);
		}else{

			foreach($name as $nameData){
				$data[]= array(
					'stateName' => $nameData,
					'created_on' => date("Y-m-d H:i:s", time()),
				);
			}
			$this->common_model->bulkSaveData('location_state', $data);

		}
		echo json_encode( array( 'status' => true ) );
	}

	function city($eID=''){
		$data['activeMenu'] = 'location';
		$data['activeSubMenu'] = 'city';
		$data['eID'] = $eID;
		$data['stateAry'] = $this->common_model->getAll('stateName, sid', 'location_state', array('isDeleted'=>'1'));
		$this->load->view('admin/city_list', $data);
	}

	function city_list() {
		if(!$this->input->is_ajax_request() || !AID) {
			exit('Unauthorized Access');
		}

		$iSQL = $sWhere = $sAnd = $inData = $notInData = $sOrder = $sLimit = '';

		if(isset($_REQUEST['filterData'])){
			foreach($_REQUEST['filterData'] as $inDataKey => $inDataVal){
				if ( $inDataKey == 'filter_status' ) {
					if($inDataVal){
						$inData .= ' AND a.status IN("'.implode('","', $inDataVal).'")';
					}
				}
				if ( $inDataKey == 'filter_sid' ) {
					if($inDataVal){
						$inData .= ' AND a.sid  = "'.decode($inDataVal).'"';
					}
				}
				if($inDataKey == 'filter_date'){
					if($inDataVal){
						$tempDate = convertToSQLDate($inDataVal);
						$startDate = $tempDate[0];
						$endDate = isset($tempDate[1]) ? $tempDate[1] : '';
						$inData .= ' AND a.created_on BETWEEN "'.$startDate.'" AND "'.$endDate.'"';
					}
				}
			}
		}

		$recordsTotal = $this->common_model->countResults('location_city', array('isDeleted'=>'1'));

		$aColumns=array(
			'a.cityName',
			'b.stateName',
			'(SELECT COUNT(pid) FROM location_pin as c WHERE c.cid = a.cid AND isDeleted = 1) AS totalPin',
			'a.created_on',
			'a.status',
			'a.cid',
		);

		$iSQL = " FROM location_city AS a LEFT JOIN location_state as b ON a.sid = b.sid ";

		$quryTmp = $this->datatablemodel->multi_tbl_list($aColumns, 1);
		$sWhere = $quryTmp['where'] ? $quryTmp['where'] : ' WHERE 1 = 1 ';
		$sOrder = $quryTmp['order'];
		$sLimit = $quryTmp['limit'];
		$sAnd 	= ' AND a.isDeleted="1"';


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

			$isActivCheck = '';
			if($aRow['status'] == '1'){
				$isActivCheck = 'checked';
			}

			$status = '<div data-statusid="'.$id.'" onClick="changeLocationStatus(this,\''.$id.'\',\'city\')" class="swithAraBoxBefre"><label class="switchS switchSCuStatus">
						  <input name="group_status" value="1" class="switchS-input" type="checkbox" '.$isActivCheck.' />
						  <span class="switchS-label" data-on="Active" data-off="Inactive"></span> <span class="switchS-handle"></span> </label></div>';

			$btnAra = '<a class="blue" data-tooltip="tooltip" onclick="editLocation(this,\''.$id.'\', \'city\')" title="Edit" href="javascript:;"> <i class="ace-icon fas fa-pencil-alt bigger-130"></i></a>';
			$btnAra .= '<a class="red" data-tooltip="tooltip" onclick="deleteLocation(this,\''.$id.'\', \'city\')" title="Delete" href="javascript:;"> <i class="ace-icon far fa-trash-alt bigger-130"></i></a>';

			$row = array();
			$row[] = '<a class="blue" data-tooltip="tooltip" onclick="editLocation(this,\''.$id.'\', \'city\')" title="Edit" href="javascript:;">'.$aRow['cityName'].'</a>';
			$row[] = $aRow['stateName'];
			$row[] = '<a target="_blank"  data-toggle="tooltip" title="Click here to view in detail" href="'.admin_url().'location/pin/'.$id.'">'.$aRow['totalPin'].'  PIN Codes</a>';
			$row[] = date('jS M Y | h:i A',strtotime($aRow['created_on']));
			$row[] = $status;
			$row[] = '<span data-id="'.$id.'" class="btnAreaAction">'.$btnAra.'</span>';
			$results['data'][] = $row;
		}
		$results["tempData"] = '';
		echo json_encode( $results );
	}

	function addEditCity() {
		if(!$this->input->is_ajax_request() || !AID ) {
			exit( 'Unauthorized Access!!' );
		}
		$id = decode($this->input->post('cid'));
		$sid = decode($this->input->post('sid'));
		$name = $this->input->post('name');

		if($id){
				$data = array(
					'cityName'=>$name[0],
					'sid'=>$sid
				);
			$id = $this->common_model->updateData('location_city', array('cid'=>$id), $data);
		}else{

			foreach($name as $nameData){
					$data[]= array(
						'cityName' => $nameData,
						'sid'=>$sid,
						'created_on' => date("Y-m-d H:i:s", time())
					);
			}
			$this->common_model->bulkSaveData('location_city', $data);
		}
		echo json_encode( array( 'status' => true ) );
	}

	function pin($eID=''){
		$data['activeMenu'] = 'location';
		$data['activeSubMenu'] = 'pin';
		$data['cityAry'] = $this->common_model->getAll('cityName, cid', 'location_city', array('isDeleted'=>'1','status'=>'1'));

		$this->load->view('admin/pin_list', $data);
	}

	function pin_list() {
		if(!$this->input->is_ajax_request() || !AID) {
			exit('Unauthorized Access');
		}

		$iSQL = $sWhere = $sAnd = $inData = $notInData = $sOrder = $sLimit = '';

		if(isset($_REQUEST['filterData'])){
			foreach($_REQUEST['filterData'] as $inDataKey => $inDataVal){
				if ( $inDataKey == 'filter_status' ) {
					if($inDataVal){
						$inData .= ' AND a.status IN("'.implode('","', $inDataVal).'")';
					}
				}
				if($inDataKey == 'filter_date'){
					if($inDataVal){
						$tempDate = convertToSQLDate($inDataVal);
						$startDate = $tempDate[0];
						$endDate = isset($tempDate[1]) ? $tempDate[1] : '';
						$inData .= ' AND a.created_on BETWEEN "'.$startDate.'" AND "'.$endDate.'"';
					}
				}
			}
		}

		$recordsTotal = $this->common_model->countResults('location_pin', array('isDeleted'=>'1'));

		$aColumns=array(
			'a.pin',
			'b.cityName',
			'c.stateName',
			'(SELECT COUNT(pin) FROM location_area as d WHERE d.pin = a.pin) AS totalArea',
			'a.created_on',
			'a.status',
			'a.pid',
		);

		$iSQL = " FROM location_pin AS a LEFT JOIN location_city as b ON a.cid = b.cid LEFT JOIN location_state as c ON b.sid = c.sid ";

		$quryTmp = $this->datatablemodel->multi_tbl_list($aColumns, 1);
		$sWhere = $quryTmp['where'] ? $quryTmp['where'] : ' WHERE 1 = 1 ';
		$sOrder = $quryTmp['order'];
		$sLimit = $quryTmp['limit'];
		$sAnd 	= ' AND a.isDeleted="1"';


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
			$id = encode($aRow['pin']);

			$isActivCheck = '';
			if($aRow['status'] == '1'){
				$isActivCheck = 'checked';
			}

			$status = '<div data-statusid="'.$id.'" onClick="changeLocationStatus(this,\''.$id.'\',\'pin\')" class="swithAraBoxBefre"><label class="switchS switchSCuStatus">
						  <input name="group_status" value="1" class="switchS-input" type="checkbox" '.$isActivCheck.' />
						  <span class="switchS-label" data-on="Active" data-off="Inactive"></span> <span class="switchS-handle"></span> </label></div>';

			$btnAra = '<a class="blue" data-tooltip="tooltip" onclick="editLocation(this,\''.$id.'\', \'pin\')" title="Edit" href="javascript:;"> <i class="ace-icon fas fa-pencil-alt bigger-130"></i></a>';
			$btnAra .= '<a class="red" data-tooltip="tooltip" onclick="deleteLocation(this,\''.$id.'\', \'pin\')" title="Delete" href="javascript:;"> <i class="ace-icon far fa-trash-alt bigger-130"></i></a>';

			$row = array();
			$row[] = '<a class="blue" data-tooltip="tooltip" onclick="editLocation(this,\''.$id.'\', \'pin\')" title="Edit" href="javascript:;">'.$aRow['pin'].'</a>';
			$row[] = $aRow['cityName'];
			$row[] = $aRow['stateName'];
			$row[] = '<a target="_blank"  data-toggle="tooltip" title="Click here to view in detail" href="'.admin_url().'location/area/'.$id.'">'.$aRow['totalArea'].'  Areas</a>';
			$row[] = date('jS M Y | h:i A',strtotime($aRow['created_on']));
			$row[] = $status;
			$row[] = '<span data-id="'.$id.'" class="btnAreaAction">'.$btnAra.'</span>';
			$results['data'][] = $row;
		}
		$results["tempData"] = '';
		echo json_encode( $results );
	}

	function addEditPin() {
		if(!$this->input->is_ajax_request() || !AID ) {
			exit( 'Unauthorized Access!!' );
		}
		$id = decode($this->input->post('pid'));
		$cid = decode($this->input->post('cid'));
		$name = $this->input->post('name');

		if($id){
				$data = array(
					'pin'=>$name[0],
					'cid'=>$cid
				);

			$id = $this->common_model->updateData('location_pin', array('pid'=>$id), $data);
		}else{
			foreach($name as $nameData){
					$data[]= array(
						'pin' => $nameData,
						'cid'=>$cid,
						'created_on' => date("Y-m-d H:i:s", time())
					);
			}
			$this->common_model->bulkSaveData('location_pin', $data);

		}
		echo json_encode( array( 'status' => true ) );
	}

	function area($eID=''){
		$data['activeMenu'] = 'location';
		$data['activeSubMenu'] = 'area';
		$data['pinAry'] = $this->common_model->getAll('pin', 'location_pin', array('isDeleted'=>'1','status'=>'1'));


		$this->load->view('admin/area_list', $data);
	}

	function area_list() {
		if(!$this->input->is_ajax_request() || !AID) {
			exit('Unauthorized Access');
		}

		$iSQL = $sWhere = $sAnd = $inData = $notInData = $sOrder = $sLimit = '';

		if(isset($_REQUEST['filterData'])){
			foreach($_REQUEST['filterData'] as $inDataKey => $inDataVal){
				if($inDataKey == 'filter_date'){
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

		$recordsTotal = $this->common_model->countResults('location_area');

		$aColumns=array(
			'pin',
			'areaName',
			'status',
			'created_on',
			'aid',
		);

		$iSQL = "FROM location_area";

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
			$id = encode($aRow['aid']);

			$isActivCheck = '';
			if($aRow['status'] == '1'){
				$isActivCheck = 'checked';
			}

			$status = '<div data-gide="'.$id.'" onClick="changeGroupStatus(this,\''.$id.'\',\'group\')" class="swithAraBoxBefre"><label class="switchS switchSCuStatus">
						  <input name="group_status" value="1" class="switchS-input" type="checkbox" '.$isActivCheck.' />
						  <span class="switchS-label" data-on="Active" data-off="Suspend"></span> <span class="switchS-handle"></span> </label></div>';


			$btnAra = '<a class="blue" data-tooltip="tooltip" onclick="editLocation(this,\''.$id.'\', \'area\')" title="Edit" href="javascript:;"> <i class="ace-icon fas fa-pencil-alt bigger-130"></i></a>';
			$btnAra .= '<a class="red" data-tooltip="tooltip" onclick="deleteLocation(this,\''.$id.'\', \'area\')" title="Delete" href="javascript:;"> <i class="ace-icon far fa-trash-alt bigger-130"></i></a>';



			$row = array();
			$row[] = $aRow['areaName'];
			$row[] = $aRow['pin'];
			$row[] = date('jS M Y | h:i A',strtotime($aRow['created_on']));
			$row[] = $status;
			$row[] = $btnAra;
			$results[ 'data' ][] = $row;
		}
		$results["tempData"] = '';
		echo json_encode( $results );
	}

	function addEditArea() {
		if(!$this->input->is_ajax_request() || !AID ) {
			exit( 'Unauthorized Access!!' );
		}
		$id = decode($this->input->post('aid'));
		$pin = decode($this->input->post('pin'));
		$name = $this->input->post('name');

		if($id){
				$data = array(
					'areaName'=>$name[0],
					'pin'=>$pin
				);

			$id = $this->common_model->updateData('location_area', array('aid'=>$id), $data);
		}else{
			foreach($name as $nameData){
					$data[]= array(
						'areaName' => $nameData,
						'pin'=>$pin,
						'created_on' => date("Y-m-d H:i:s", time())
					);
			}
			$this->common_model->bulkSaveData('location_area', $data);

		}
		echo json_encode( array( 'status' => true ) );
	}


	function deleteData() {
		if(!$this->input->is_ajax_request() || !AID ) {
			exit( 'Unauthorized Access!!' );
		}

		$id = decode($this->input->post('id'));
		$type = $this->input->post('type');
		$data = array('isDeleted'=>'0');

		if($type == 'state'){
			$recordsTotal = $this->common_model->countResults('location_city', array('isDeleted'=>'1', 'sid'=>$id));
			if($recordsTotal > 0){
				echo json_encode( array( 'status' => 'child' ) );
				exit;
			}

			$where = array('sid'=>$id);
			$tbl = 'location_state';

		}else if($type == 'city'){
			$recordsTotal = $this->common_model->countResults('location_pin', array('isDeleted'=>'1', 'cid'=>$id));
			if($recordsTotal > 0){
				echo json_encode( array( 'status' => 'child' ) );
				return;
			}

			$where = array('cid'=>$id);
			$tbl = 'location_city';

		}else if($type == 'pin'){
			$recordsTotal = $this->common_model->countResults('location_area', array('isDeleted'=>'1', 'pin'=>$id));
			if($recordsTotal > 0){
				echo json_encode( array( 'status' => 'child' ) );
				return;
			}

			$where = array('pid'=>$id);
			$tbl = 'location_pin';

		}else if($type == 'address'){
			$where = array('aid'=>$id);
			$tbl = 'location_area';
		}else if($type == 'area'){
			$where = array('aid'=>$id);
			$tbl = 'location_area';
		}
		$this->common_model->updateData($tbl, $where, $data);
		echo json_encode( array( 'status' => 'success' ) );
	}

	function getData() {
		if(!$this->input->is_ajax_request() || !AID ) {
			exit( 'Unauthorized Access!!' );
		}
		$id = decode($this->input->post('id'));
		$type = $this->input->post('type');

		if($type == 'state'){
			$select = 'sid, stateName';
			$table = 'location_state';
			$where = array(
				'sid'=>$id,
				'isDeleted'=>'1'
			);
			$objData = $this->common_model->getAll($select, $table, $where);
			$result = array(
				'stateName' => $objData[0]->stateName,
			);
		}
		else if($type == 'city'){
			$select = 'b.cid, b.sid, b.cityName';
			$table = 'location_city';
			$where = array(
				'b.cid'=>$id,
				'b.isDeleted'=>'1'
			);
			$objData = $this->manual_model->getLocationData($select, $where, 'state');
			$result = array(
				'cid' => encode($objData[0]->cid),
				'sid' => encode($objData[0]->sid),
				'cityName' => $objData[0]->cityName,
			);
		}
		else if($type == 'pin'){
			$select = 'c.pid, b.cid, a.sid, c.pin';
			$table = 'location_pin';
			$where = array(
				'c.pin'=>$id,
				'c.isDeleted'=>'1'
			);
			$objData = $this->manual_model->getLocationData($select, $where, 'pin');
			$result = array(
				'sid' => encode($objData[0]->sid),
				'cid' => encode($objData[0]->cid),
				'pid' => encode($objData[0]->pid),
				'pin' => $objData[0]->pin,
			);

		}
		else if($type == 'area'){
			$select = 'a.aid, a.pin, a.areaName';
			$table = 'location_area';
			$where = array(
				'a.aid'=>$id,
				'a.isDeleted'=>'1'
			);
			$objData =  $this->manual_model->getLocationData($select, $where, 'area');
			//echo '<pre>';print_r($objData);die;
			$result = array(
				'aid' => encode($objData[0]->aid),
				'pin' => $objData[0]->pin,
				'area' => $objData[0]->areaName,
			);

		}



		echo json_encode($result);
	}

	function changeStatus() {
		if(!$this->input->is_ajax_request() || !AID ) {
			exit( 'Unauthorized Access!!' );
		}

		$id = decode($this->input->post('id'));
		$type = $this->input->post('type');
		$value = $this->input->post('value');
		$data = array('status'=>$value);

		if($type == 'state'){
			$where = array('sid'=>$id);
			$tbl = 'location_state';
		}else if($type == 'city'){
			$where = array('cid'=>$id);
			$tbl = 'location_city';
		}else if($type == 'pin'){
			$where = array('pin'=>$id);
			$tbl = 'location_pin';
		}else if($type == 'area'){
			$where = array('aid'=>$id);
			$tbl = 'location_area';
		}
		$this->common_model->updateData($tbl, $where, $data);
		echo json_encode( array( 'status' => 'success' ) );
	}

	function getPINCodeData(){
		$pinCode = $this->input->post('pinCode');
		$output = '';
		$select = 'a.areaName, b.pin, c.cityName, d.stateName, a.aid, c.cid, d.sid';
		$where = array('a.pin' => $pinCode);
		$result = $this->manual_model->getFullLocationData($select, $where);
		if($result){
			$output = array(
				'area' => $result[0]->areaName,
				'city' => $result[0]->cityName,
				'state' => $result[0]->stateName,
				'aid' => $result[0]->aid,
				'cid' => $result[0]->cid,
				'sid' => $result[0]->sid,
			);
		}
		echo json_encode($output);
	}
}
