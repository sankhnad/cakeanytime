<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );

class Vendors extends CI_Controller {
	function __construct() {
		parent::__construct();
	}

	function index() {
		$data[ 'vendorInfoAry' ] = $this->common_model->getAll( 'vid,fname', 'vendor', array( 'isDeleted' => '1', 'status' => '1' ) );
		$data[ 'activeMenu' ] = 'vendors';
		$this->load->view( 'admin/vendors_list', $data );
	}


	function add() {
		$vendorDisAry = array();
		$pincodeArr = array();
		$data[ 'vendorDisAry' ] = $vendorDisAry;
		$data[ 'arearIds' ] = array();
		$data[ 'cityIds' ] = array();
		$data[ 'stateIds' ] = array();
		$data[ 'typeId' ] = '';
		$data[ 'vid' ] = '';
		$data[ 'city' ] = $this->common_model->getAll( '*', 'location_city', array( 'isDeleted' => 1, 'status' => 0 ) );
		$data[ 'states' ] = $this->common_model->getAll( '*', 'location_state', array( 'isDeleted' => 1 ) );
		$data[ 'areas' ] = array();

		$this->load->view( 'admin/vendors_add', $data );
	}

	function edit( $id = '' ) {
		$encriptedID = $id;
		$id = decode( $id );
		$vendorDisAry = $this->common_model->getAll( '*', 'vendor', array( 'isDeleted' => '1', 'vid' => $id ) );
		$areaArr = $this->common_model->getAll( '*', 'vendor_location', array( 'vendor_id' => $id ) );
		$areaIds = array();
		$typeId = '';
		foreach ( $areaArr as $data ) {
			$areaIds[] = $data->location_id;
			$typeId = $data->type_id;
		}

		$cityIds = array();
		$stateIds = array();

		if ( $typeId == 1 ) {
			$araeIdAry = $this->common_model->getAll( '*', 'location_area', '', '', array( 'aid' => $areaIds ) );
			$pinCodesArr = array();
			foreach ( $araeIdAry as $data ) {
				$pinCodesArr[] = $data->pin;
			}

			$cityArr = $this->common_model->getAll( '*', 'location_pin', '', '', array( 'pin' => $pinCodesArr ) );
		} else {
			if ( count( $areaIds ) > 0 ) {
				$cityArr = $this->common_model->getAll( '*', 'location_pin', '', '', array( 'pid' => $areaIds ) );
			} else {
				$cityArr = array();
			}

		}

		foreach ( $cityArr as $data ) {
			$cityIds[] = $data->cid;
		}

		$stateArr = $this->common_model->getAll( 'sid', 'location_city', '', '', array( 'cid' => $cityIds ) );

		foreach ( $stateArr as $data ) {
			$stateIds[] = $data->sid;
		}


		$data = array();
		$data[ 'stateAry' ] = $this->common_model->getAll( '*', 'location_state', array( 'isDeleted' => 1 ) );
		$data[ 'vendorDisAry' ] = $vendorDisAry;
		$data[ 'arearIds' ] = $areaIds;
		$data[ 'cityIds' ] = $cityIds;
		$data[ 'stateIds' ] = $stateIds;
		$data[ 'typeId' ] = $typeId;
		$data[ 'city' ] = $this->common_model->getAll( '*', 'location_city', array( 'isDeleted' => 1, 'status' => 1 ), '', array( 'sid' => $stateIds ) );
		$data[ 'states' ] = $this->common_model->getAll( '*', 'location_state', array( 'isDeleted' => 1 ) );
		$data[ 'areas' ] = $this->common_model->getAll( '*', 'location_area', array( 'isDeleted' => 1, 'status' => 1 ) );
		$data[ 'vid' ] = $encriptedID;


		$this->load->view( 'admin/vendors_add', $data );
	}

	function getCityAreaData() {
		if ( !$this->input->is_ajax_request() || !AID ) {
			exit( 'No direct script access allowed' );
		}
		$type = $this->input->post( 'type' );
		$ids = $this->input->post( 'ids' );
		$target = $this->input->post( 'target' );

		if ( $target == 'city' ) {
			$listAry = $this->common_model->getAll( '*', 'location_city', array( 'isDeleted' => 1, 'status' => 1 ), '', array( 'sid' => $ids ) );
		}
		if ( $target == 'area' ) {
			if ( $type == 1 ) {
				$pinAry = $this->common_model->getAll( '*', 'location_pin', array( 'isDeleted' => 1, 'status' => 1 ), '', array( 'cid' => $ids ) );
				$pinCodesArr = array();
				$listAry = array();
				foreach ( $pinAry as $data ) {
					$pinCodesArr[] = $data->pin;
				}
				if ( count( $pinCodesArr ) > 0 ) {
					$listAry = $this->common_model->getAll( '*', 'location_area', array( 'isDeleted' => 1, 'status' => 1 ), '', array( 'pin' => $pinCodesArr ) );
				}

			} else {
				$listAry = $this->common_model->getAll( '*', 'location_pin', array( 'isDeleted' => 1, 'status' => 1 ), '', array( 'cid' => $ids ) );
			}

		}
		echo json_encode( $listAry );
	}


	function storeVendor() {
		if ( !$this->input->is_ajax_request() || !AID ) {
			exit( 'No direct script access allowed' );
		}
		$output = '';
		$vid = decode( $this->input->post( 'vid' ) );
		$fname = $this->input->post( 'fname' );
		$lname = $this->input->post( 'lname' );
		$email = $this->input->post( 'email' );
		$mobile = $this->input->post( 'mobile' );
		$stoteName = $this->input->post( 'storeName' );

		$locationType = $this->input->post( 'ltype' );
		$areaArr = $this->input->post( 'area' );

		$verifiedEmail = $this->input->post( 'verifiedEmail' );
		$verifiedSMS = $this->input->post( 'verifiedSMS' );
		$status = $this->input->post( 'status' );




		$data = array(
			'fname' => $fname,
			'lname' => $lname,
			'email' => $email,
			'mobile' => str_replace( ' ', '', $mobile ),
			'store_name' => $stoteName,
			'status' => $status ? $status : 1,
			'isEmail_verified' => $verifiedEmail ? $verifiedEmail : 1,
			'isSMS_verified' => $verifiedSMS ? $verifiedSMS : 1,
		);

		$avtar = $_FILES[ 'avtar' ][ 'name' ];
		if ( $avtar ) {
			$data[ 'avtar' ] = uploadFiles( 'avtar', $path = 'uploads/vendor/', 'thumb', 360, 360 );
		}


		if ( $vid ) {
			$data[ 'modified_on' ] = date( "Y-m-d H:i:s", time() );
			$this->common_model->updateData( 'vendor', array( 'vid' => $vid ), $data );
			$this->common_model->deleteData( 'vendor_location', array( 'vendor_id' => $vid ) );


			foreach ( $areaArr as $areaId ) {
				$areaData[ 'vendor_id' ] = $vid;
				$areaData[ 'location_id' ] = $areaId;
				$areaData[ 'type_id' ] = $locationType;
				$this->common_model->saveData( "vendor_location", $areaData );
			}

		} else {
			$data[ 'created_on' ] = date( "Y-m-d H:i:s", time() );
			$vid = $this->common_model->saveData( "vendor", $data );

			if ( $vid ) {
				foreach ( $areaArr as $areaId ) {
					$areaData[ 'vendor_id' ] = $vid;
					$areaData[ 'location_id' ] = $areaId;
					$areaData[ 'type_id' ] = $locationType;
					$this->common_model->saveData( "vendor_location", $areaData );
				}
			}

		}
		echo json_encode( array( 'status' => true, 'vid' => encode( $vid ) ) );
	}

	function vendor_lst() {
		if ( !$this->input->is_ajax_request() || !AID ) {
			exit( 'Unauthorized Access' );
		}

		$iSQL = $sWhere = $sAnd = $inData = $notInData = $sOrder = $sLimit = '';


		if ( isset( $_REQUEST[ 'filterData' ] ) ) {
			foreach ( $_REQUEST[ 'filterData' ] as $inDataKey => $inDataVal ) {
				if ( $inDataKey == 'filter_role' ) {
					if ( $inDataVal ) {
						$inData .= ' AND role IN("' . implode( '","', $inDataVal ) . '")';
					}
				}
				if ( $inDataKey == 'filter_status' ) {
					if ( $inDataVal ) {
						$inData .= ' AND status IN("' . implode( '","', $inDataVal ) . '")';
					}
				}
				if ( $inDataKey == 'filter_data' ) {
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

		$recordsTotal = $this->common_model->countResults( 'vendor', array( 'isDeleted' => '1' ) );

		$aColumns = array(
			'fname',
			'lname',
			'email',
			'mobile',
			'avtar',
			'store_name',
			'isEmail_verified',
			'status',
			'isDeleted',
			'created_on',
			'vid',
		);

		$iSQL = "FROM vendor";
		$sAnd = " AND isDeleted = '1'";
		$quryTmp = $this->datatablemodel->multi_tbl_list( $aColumns, 3 );
		$sWhere = $quryTmp[ 'where' ] ? $quryTmp[ 'where' ] : ' WHERE 1 = 1 ';
		$sOrder = $quryTmp[ 'order' ];
		$sLimit = $quryTmp[ 'limit' ];

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

		$sQuery = "SELECT COUNT(" . $aColumns[ 0 ] . ") AS iFiltered
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

		foreach ( $results[ 'tempData' ] as $aKey => $aRow ) {
			$id = encode( $aRow[ 'vid' ] );

			$btnAra = ' <a class="blue" data-tooltip="tooltip" title="Quick View" onClick="vendorQuickView(\'' . $id . '\')" href="javascript:;"> <i class="ace-icon fas fa-search-plus bigger-130"></i></a>';

			$btnAra .= ' <a class="green" data-tooltip="tooltip" title="Edit" href="' . base_url() . 'admin/vendor/edit/' . $id . '"> <i class="ace-icon fas fa-pencil-alt bigger-130"></i> </a>';

			$btnAra .= ' <a class="red" data-tooltip="tooltip" title="Delete" onClick="changeStatus(this, \'' . $id . '\', \'delete\', \'vendor\');" href="javascript:;"> <i class="ace-icon far fa-trash-alt bigger-130"></i> </a>';

			$isActivCheck = '';
			$offLbl = 'Active';
			if ( $aRow[ 'status' ] == '1' ) {
				$isActivCheck = 'checked';
			} else if ( $aRow[ 'status' ] == '0' ) {
				$offLbl = 'Inactive';
			}

			$status = '<div onClick="changeStatus(this,\'' . $id . '\',\'admin\')" data-state="' . $offLbl . '" class="swithAraBoxBefre"><label class="switchS switchSCuStatus">
						  <input name="verifiedEmail" value="1" class="switchS-input" type="checkbox" ' . $isActivCheck . ' />
						  <span class="switchS-label" data-on="Active" data-off="' . $offLbl . '"></span> <span class="switchS-handle"></span> </label></div>';

			$avtarURL = $this->config->item( 'default_path' )[ 'vendor' ] . 'thumb/';
			$avtarURL .= $aRow[ 'avtar' ] ? $aRow[ 'avtar' ] : 'user.png';

			$cDetail = '<ul class=\'popovLst\'>
							<li class=\'prvImgPoA\'><img src=\'' . $avtarURL . '\' /></li>
							<li><strong>Name:</strong> ' . $aRow[ 'fname' ] . '</li>
							<li><strong>Email:</strong> ' . $aRow[ 'email' ] . '</li>
							<li><strong>Phone:</strong> ' . $aRow[ 'mobile' ] . '</li>
							<li><strong>Store Name: </strong> ' . $aRow[ 'store_name' ] . '</li>
					    </ul>';

			$fullName = '<a href="javascript:;" onClick="vendorQuickView(\'' . $id . '\')" title="' . $aRow[ 'fname' ] . ' ' . $aRow[ 'lname' ] . '" data-trigger="hover"  data-toggle="popover"  data-content="' . $cDetail . '">' . $aRow[ 'fname' ] . ' ' . $aRow[ 'lname' ] . '</a>';
			$row = array();
			$row[] = $fullName;
			$row[] = '<a href="mailTo:' . $aRow[ 'email' ] . '">' . $aRow[ 'email' ] . '</span>';
			$row[] = '<a href="tel:' . $aRow[ 'mobile' ] . '">' . $aRow[ 'mobile' ] . '</span>';
			$row[] = date( 'jS M Y', strtotime( $aRow[ 'created_on' ] ) );
			$row[] = $status;
			$row[] = '<div class="action-buttons">' . $btnAra . '</div>';
			$results[ 'data' ][] = $row;
		}
		$results[ "tempData" ] = '';
		echo json_encode( $results );
	}

	function vendorQuickView() {
		if ( !$this->input->is_ajax_request() || !AID ) {
			exit( 'Unauthorized Access' );
		}
		$aid = decode( $this->input->post( 'aid' ) );
		$data = $this->common_model->getAll( '*', 'vendor', array( 'vid' => $aid, 'isDeleted' => '1' ) );
		if ( !$data ) {
			echo json_encode( array( 'requestStatus' => 'error' ) );
			exit;
		}
		$result = array(
			'requestStatus' => 'success',
			'fname' => $data[ 0 ]->fname,
			'lname' => $data[ 0 ]->lname,
			'email' => $data[ 0 ]->email,
			'phone' => $data[ 0 ]->mobile,
			'store' => $data[ 0 ]->store_name,
			'created_on' => date( 'jS M Y | h:i A', strtotime( $data[ 0 ]->created_on ) ),
		);

		$iURL_profile = $this->config->item( 'default_path' )[ 'vendor' ] . 'thumb/';
		$avtarURL = $iURL_profile;
		$avtarURL .= $data[ 0 ]->avtar ? $data[ 0 ]->avtar : 'user.png';
		$result[ 'avtar' ] = $avtarURL;


		if ( $data[ 0 ]->status == '0' ) {
			$result[ 'status' ] = 'Inactive';
		} else if ( $data[ 0 ]->status == '1' ) {
			$result[ 'status' ] = 'Active';
		}

		echo json_encode( $result );
	}

	function activity_log_lst() {
		if ( !$this->input->is_ajax_request() || !AID ) {
			exit( 'Unauthorized Access' );
		}
		$this->load->model( 'DataTblModel', 'datatablemodel' );

		$iSQL = $sWhere = $sAnd = $inData = $notInData = $sOrder = $sLimit = '';


		if ( isset( $_REQUEST[ 'filterData' ] ) ) {
			foreach ( $_REQUEST[ 'filterData' ] as $inDataKey => $inDataVal ) {
				if ( $inDataKey == 'filter_aid' ) {
					if ( $inDataVal ) {
						$aid = decode( $inDataVal );
						$inData .= ' AND userID IN("' . $aid . '")';
					}
				}


				if ( $inDataKey == 'filter_data' ) {
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

		$recordsTotal = $this->common_model->countResults( 'admin_audittrail', array( 'userID' => $aid ) );

		$aColumns = array(
			'action',
			'status',
			'ip',
			'created_on ',
		);

		$iSQL = "FROM admin_audittrail";
		$quryTmp = $this->datatablemodel->multi_tbl_list( $aColumns, 3 );
		$sWhere = $quryTmp[ 'where' ] ? $quryTmp[ 'where' ] : ' WHERE 1 = 1 ';
		$sOrder = $quryTmp[ 'order' ];
		$sLimit = $quryTmp[ 'limit' ];

		$sAnd = ' AND userID = ' . $aid;

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

		$sQuery = "SELECT COUNT(" . $aColumns[ 0 ] . ") AS iFiltered
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

		foreach ( $results[ 'tempData' ] as $aKey => $aRow ) {
			$row = array();
			$row[] = $aRow[ 'action' ];
			$row[] = $aRow[ 'status' ];
			$row[] = $aRow[ 'ip' ];
			$row[] = date( 'jS M Y | h:i A', strtotime( $aRow[ 'created_on' ] ) );
			$results[ 'data' ][] = $row;
		}
		$results[ "tempData" ] = '';
		echo json_encode( $results );
	}

}