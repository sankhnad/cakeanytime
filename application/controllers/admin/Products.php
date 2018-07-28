<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );

class Products extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model( 'DataTblModel', 'datatablemodel');

	}
	
	function index() {
		$data['activeMenu'] = 'store';
		$data['activeSubMenu'] = 'products';
		$this->load->view( 'admin/product_list', $data);
	}
	
	function product_list() {
		if(!$this->input->is_ajax_request() || !AID ) {
			exit( 'No direct script access allowed' );
		}
		
		$iSQL = $sWhere = $sAnd = $inData = $notInData = $sOrder = $sLimit = '';
		$tbl = 'product';

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
			'sku_code',
			'type',
			'image',
			'model',
			'quantity',
			'status',
			'created_on',
			'product_id',
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
			$id = $aRow['product_id'];
			$encodedID = encode($id);
			
			$lastLogin = customerLastLogin($id);
			if($lastLogin){
				$lastLogin = date('jS M Y | h:i A', strtotime($lastLogin));
			}else{
				$lastLogin = 'Never Login';
			}
			$registeredOn = date('jS M Y | h:i A',strtotime($aRow['created_on']));
			
	
			$btnAra = ' <a class="blue" data-tooltip="tooltip" title="Edit" href="'.admin_url().'products/edit/'.$encodedID.'"> <i class="ace-icon fas fa-pencil-alt bigger-130"></i> </a>';
			
			$btnAra .= ' <a class="red" data-tooltip="tooltip" title="Delete" onClick="deleteCommon(this,\''.$encodedID.'\',\'product\')" href="javascript:;"> <i class="ace-icon far fa-trash-alt bigger-130"></i> </a>';
			
			
			
			$isActivCheck = '';
			$offLbl = 'Inactive';
			if($aRow['status'] == '1'){
				$isActivCheck = 'checked';
				$offLbl = 'Active';
			}
			
			$status = '<div data-status="'.$aRow['status'].'" onClick="changeStatus(this, \''.$encodedID.'\', \'status\', \'product\')" data-state="'.$offLbl.'" class="swithAraBoxBefre"><label class="switchS switchSCuStatus">
						  <input name="verifiedEmail" data-statusid="'.$encodedID.'" value="1" class="switchS-input" type="checkbox" '.$isActivCheck.' />
						  <span class="switchS-label" data-on="Active" data-off="'.$offLbl.'"></span> <span class="switchS-handle"></span> </label></div>';
			
			$iURL_product = $this->config->item('default_path')['product'];
			$avtarURL = $iURL_product.'thumb/';
			$avtarURL .= $aRow['image'] ? $aRow['image'] : 'user.png';
			
			$cDetail = '<ul class=\'popovLst\'>
							<li class=\'prvImgPoA\'><img src=\''.$avtarURL.'\' /></li>
					    </ul>';
			
			$fullName = '<a href="javascript:;"  data-trigger="hover"  data-toggle="popover"  data-content="'.$cDetail.'">'.$aRow['name'].'</a>';
			
			$row   = array();	
			$row[] = $fullName;
			$row[] = $aRow['model'];
			$row[] = $aRow['quantity'];
			$row[] = $aRow['sku_code'];
			
			$row[] = $status;			
			$row[] = '<div class="action-buttons">'.$btnAra.'</div>';
			$results[ 'data' ][] = $row;
		
		}
		$results[ "tempData" ] = '';
		echo json_encode( $results );
	}	

	
	function add(){
		$catOption[] = $this->common_model->getAll( 'category_id, name, parent_id', 'category', array( 'isDeleted' => '1', 'parent_id' => '0' ), 'sort_order asc' );
		$productAray = array();
		$data['typeAry'] 			= $this->common_model->getAll('*', 'type', array('isDeleted'=>1));
		$data['relatedProductAry']  = $this->common_model->getAll( '*', 'product', array( 'isDeleted' => '1', 'status' => '1' ) );
		$data['productSelectsAry']  = array();
		$data['categorySelectsAry'] = array();
	
		$data['productAray'] = $productAray;
		$data['parentArayList'] = $catOption;		
		$data['ePID'] = '';
		
		$this->load->view( 'admin/product_data', $data);
	}
	
	function edit($id=''){
		$ePID = $id;
		$id   = decode($id);
		
		$catOption 	 = $this->common_model->getAll('category_id, name, parent_id', 'category', array('isDeleted'=>'1','parent_id'=>'0'), 'sort_order asc');
		$productAray = $this->common_model->getAll('*', 'product', array('isDeleted'=>'1', 'product_id'=>$id));		
		
		$data['typeAry'] 			= $this->common_model->getAll('*', 'type', array('isDeleted'=>1));
		$data['relatedProductAry']  = $this->common_model->getAll( '*', 'product', array( 'isDeleted' => '1', 'status' => '1' ) );
		$data['productSelectsAry']  = $this->common_model->getAll( '*', 'product_to_related', array( 'product_id' => $id ) );
		$data['categorySelectsAry'] = $this->common_model->getAll( '*', 'product_to_category', array('product_id' => $id ) );

		
		$data['productAray'] = $productAray;
		$data['parentArayList'] = $catOption;	
			
		$data['ePID'] = $ePID;
		$this->load->view( 'admin/product_data', $data);
	}
	
	function storeProduct(){
		if ( !$this->input->is_ajax_request() || !AID ) {
			exit( 'Unauthorized Access' );
		}
		//echo '<pre>';print_r($this->input->post());die;
		$pid			= decode($this->input->post('pid'));
		$name 			= $this->input->post('name');
		$slug 			= $this->input->post('url_slug');
		$desc 			= $this->input->post('desc');
		$tag 			= $this->input->post('tag');
		$type 			= $this->input->post('type');
		$model 			= $this->input->post('model');
		$sku 			= $this->input->post('sku');
		$quentity		= $this->input->post('quantity');
		$substractCode	= $this->input->post('substact_stock');
		$stoke			= $this->input->post('stock');
		$availableDate	= $this->input->post('date') ? convertData($this->input->post('date')) : NULL;
		$metaDesc 		= $this->input->post('meta_desc');
		$metaKey 		= $this->input->post('meta_keywords');
		$status 		= $this->input->post( 'isStatus' ) ? $this->input->post( 'isStatus' ) : '0';
		
		$categoryArr		= $this->input->post('category');
		$relatedProductsArr	= $this->input->post('relatedProducts');
				
		
		$data = array(
			'name' => $name,
			'url_slug' => $slug,
			'tags' => $tag,
			'type' => $type,
			'model' => $model,
			'sku_code' => $sku,
			'quantity' => $quentity,
			'subtract_stock' => $substractCode,
			'stock_status_id' => $stoke,
			'date_available' => $availableDate,
			'status' => $status,
			'meta_description' => $metaDesc,
			'meta_keyword' => $metaKey,
			'description' => $desc,

		);
		$notId = '';
		if($pid){
			$notId = array('product_id'=> array($pid));
		}
		
		$iCount = $this->common_model->getAll('count(product_id) as totl', 'product', array('isDeleted'=>'1','url_slug'=>$slug), '', '', $notId);
		$iCount = $iCount[0]->totl;
		if($iCount > 0){
			echo json_encode(array('status'=> 'slug_error'));
			exit;
		}
		
		$avtar = $_FILES['img']['name'];
		if($avtar){
			$data['image'] = uploadFiles('img', $path = 'uploads/product/', 'thumb', 360, 360 );
		}
		if($pid){
			$this->common_model->updateData('product', array('product_id'=>$pid), $data);
			$this->common_model->deleteData('product_to_category', array('product_id'=>$pid));

			/*foreach($categoryArr as $categId){
					$prdCatData['product_id']  = $pid;
					$prdCatData['category_id'] = $categId;
					$this->common_model->saveData('product_to_category', $prdCatData);
			}*/
				
			$this->common_model->deleteData('product_to_related', array('product_id'=>$pid));
			//echo '<pre>';print_r($relatedProductsArr);die;
			foreach($relatedProductsArr as $prdctId){
					$prdRelatedData['product_id']  		   = $pid;
					$prdRelatedData['product_related_id']  = $prdctId;
					$this->common_model->saveData('product_to_related', $prdRelatedData);
			}
				
			$status = 'updated';
			$id = $this->input->post('pid');
		}else{
			//echo '<pre>';print_r($data);die;
			$data['created_on '] = date("Y-m-d H:i:s", time());
			$id = $this->common_model->saveData('product', $data);
			
			if($id){
			
				/*foreach($categoryArr as $categId){
					$prdCatData['product_id']  = $id;
					$prdCatData['category_id'] = $categId;
					$this->common_model->saveData('product_to_category', $prdCatData);
				}*/
				
				foreach($relatedProductsArr as $prdctId){
					$prdRelatedData['product_id']  		   = $id;
					$prdRelatedData['product_related_id']  = $prdctId;
					$this->common_model->saveData('product_to_related', $prdRelatedData);
				}
			}
			
		
			
			$status = 'added';
			$id = encode($id);
		}
		echo json_encode(array('status'=> $status, 'id' => $id));		
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
			$notId = array('product_id'=> array(decode($notId)));
		}
		$slug = slugify($catName);
		
		
		$iCount = $this->common_model->getAll('count(product_id) as totl', 'product', array('isDeleted'=>'1','url_slug'=>$slug), '', '', $notId);
		$iCount = $iCount[0]->totl;
		
		if($iCount > 0 && $type == 'prd'){
			$iTotalAry = $this->manual_model->findDubliSlug($slug,'product');
			$iTotal = $iTotalAry[0]->iTotal;			
			$slug = $slug.($iTotal);
		}
		if($type == 'slug'){
			echo json_encode(array('status'=> $iCount > 0 ? 'error':'success'));
		}else if($type == 'prd'){
			echo json_encode(array('slug'=> $slug));
		}
		
	}
	
	function getCustomerGroupId(){
		if (!AID) {
			exit( 'Unauthorized Access' );
		}
		
		if($this->input->post('id')){
			$groupId = $this->input->post('id');
			$result  = $this->common_model->getAll('cid, fname, lname', 'customer', array('status'=>'1','isDeleted'=>'1','id'=>$groupId), 'cid asc');
		}
		
		if($this->input->post('id')){
			echo json_encode($result);
		}else{
			return($result);
		}		
	}

}