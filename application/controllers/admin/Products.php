<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );

class Products extends CI_Controller {
	function __construct() {
		parent::__construct();
	}
	
	function index() {
	
		$where = array(
			'fld_isDeleted'=>'2',
		);
		$status = $this->input->post('status');
		$filter = $this->input->post('filter');
		if($status && !isset($status[1])){
			if(isset($status[0])){
				$where['fld_status'] = $status[0];
			}
		}

		$records = getProductist($where);
		//echo '<pre>';print_r($records);die;
		$items = $records[0];
		//$items = $records[1];
		//echo '<pre>';print_r($items);

		function get_menu( $items, $class = 'dd-list' ) {
			$html = "<ol class=\"" . $class . "\" id=\"menu-id\">";
			foreach ( $items as $value ) {
				$encriptedID = encode($value['fld_product_id']);
				if($value['fld_status'] == '1'){
					$ststbtn = 'Disable';
					$ststCls = 'btn-success';
				}else{
					$ststbtn = 'Enable';
					$ststCls = 'btn-default';
				}
				$fldTopBar = '';
				$fldLeftBar = '';
				$html .= '<li class="dd-item dd3-item" data-id="'.$value['fld_product_id'].'" >
				<div class="dd-handle dd3-handle">Drag</div>
				<div class="dd3-content">
					<div class="disIndLs">'.$value['fld_name'].'</div>
					<div class="actionIndLs">
						'.$fldTopBar.$fldLeftBar.'
						<a target="_blank" href="'.base_url().'admin/product/edit/'.$encriptedID.'" data-tooltip="tooltip" title="Edit" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i></a>
						<button type="button" data-tooltip="tooltip" data-status="'.$value['fld_status'].'" onclick="changeStatus(this, \''.$encriptedID.'\', \'status\', \'product\')" title="Click to '.$ststbtn.'" class="btn '.$ststCls.' btn-xs"><i class="fa fa-power-off"></i></button>
						<button type="button" data-tooltip="tooltip" onclick="changeStatus(this, \''.$encriptedID.'\', \'delete\', \'product\')" title="Delete" class="btn btn-danger btn-xs btn-xs"><i class="fa fa-trash"></i></button>
					</div>
				</div>';
				if ( array_key_exists( 'child', $value ) ) {
					$html .= get_menu( $value[ 'child' ], 'child' );
				}
				$html .= "</li>";
			}
			$html .= "</ol>";
			return $html;
		}
		$data[ 'productLst' ] = get_menu($items);
		//echo '<pre>';print_r($data);die;
		
		if($filter){
			echo $data['productLst'];
		}else{
			$this->load->view( 'admin/product_list', $data);
		}
	}
	
	function add(){
		$catOption = $this->common_model->getAll('fld_category_id, fld_name, fld_parent_id', 'tbl_category', array('fld_isDeleted'=>'2','fld_parent_id'=>'0'), 'fld_sort_order asc');
		$proAray = array();
		$data['stateAry'] 			= $this->common_model->getAll('*', 'tbl_state', array('fld_isDeleted'=>2));
		$data['relatedProductAry']  = $this->common_model->getAll('*', 'tbl_product', array('fld_isDeleted'=>2,'fld_status'=>1));
		$data['groupAry'] 	    	= $this->common_model->getAll('fld_cgid, fld_name', 'tbl_customer_group', array('fld_isDeleted'=>'2', 'fld_status'=>'1'));

		
		$data['proAray'] = $proAray;
		$data['parentArayList'] = $catOption;		
		$data['ePID'] = '';
		$this->load->view( 'admin/product_add', $data);
	}
	
	function edit($id=''){
		$ePID = $id;
		$id = decode($id);
		$catOption = $this->common_model->getAll('fld_category_id, fld_name, fld_parent_id', 'tbl_category', array('fld_isDeleted'=>'2','fld_parent_id'=>'0'), 'fld_sort_order asc');
		$proAray = $this->common_model->getAll('*', 'tbl_product', array('fld_isDeleted'=>'2', 'fld_product_id'=>$id));		
		$data['stateAry'] 			= $this->common_model->getAll('*', 'tbl_state', array('fld_isDeleted'=>2));
		$data['relatedProductAry']  = $this->common_model->getAll('*', 'tbl_product', array('fld_isDeleted'=>2,'fld_status'=>1));
		$data['groupAry'] 	    	= $this->common_model->getAll('fld_cgid, fld_name', 'tbl_customer_group', array('fld_isDeleted'=>'2', 'fld_status'=>'1'));

		
		$data['proAray'] = $proAray;
		$data['parentArayList'] = $catOption;		
		$data['ePID'] = $ePID;
		$this->load->view( 'admin/product_add', $data);
	}
	
	function storeProduct(){
		if ( !$this->input->is_ajax_request() || !AID ) {
			exit( 'Unauthorized Access' );
		}
		//echo '<pre>';print_r($this->input->post());die;
		$pid			= decode($this->input->post('pid'));
		$name 			= $this->input->post('name');
		$slug 			= $this->input->post('url_slug');
		$model 			= $this->input->post('fld_model');
		$type_id		= $this->input->post('fld_prd_type_id');
		$metaDesc 		= $this->input->post('meta_desc');
		$metaKey 		= $this->input->post('meta_keywords');
		$desc 			= $this->input->post('desc');
		$status 		= $this->input->post('isStatus') ? $this->input->post('isStatus') : '0';
		$sku 			= $this->input->post('sku');
		$sortOrder		= $this->input->post('fld_sort_order');
		$state			= $this->input->post('state');
		$city			= $this->input->post('city');
		$area			= $this->input->post('area');
		$price 			= $this->input->post('fld_price');
		$discntType 	= $this->input->post('fld_discount_type');
		$discntVal 		= $this->input->post('fld_discount_type') == 1 ? $this->input->post('fld_Discount_val') : $this->input->post('fld_discount_percent');
		$quentity 		= $this->input->post('fld_quantity');
		$availDate		= $this->input->post('fld_date_available');
		$stockStatus	= $this->input->post('stock_status');
		$length			= $this->input->post('fld_length');
		$width			= $this->input->post('fld_width');
		$height			= $this->input->post('fld_height');
		$lengthClassId	= $this->input->post('length_class');
		$weight			= $this->input->post('fld_weight');
		$weightClassId	= $this->input->post('fld_weight_class_id');
				
		
		$data = array(
			//'fld_parent_id' => $categoryID,
			'fld_name' => $name,
			'fld_url_slug' => $slug,
			'fld_sku_code ' => $sku,
			'fld_model' => $model,
			'fld_type ' => $type_id,
			'fld_meta_description' => $metaDesc,
			'fld_meta_keyword' => $metaKey,
			'fld_description' => $desc,
			'fld_status' => $status,
			'fld_state_id' => $state,
			'fld_city_id ' => $city,
			'fld_area_id  ' => $area,
			'fld_price' => $price,
			'fld_discount_type' => $discntType,
			'fld_discount_value' => $discntVal,
			'fld_quantity' => $quentity,
			'fld_date_available' => convertData($availDate),
			'fld_stock_status_id ' => $stockStatus,
			'fld_length' => $length,
			'fld_width' => $width,
			'fld_height' => $height,
			'fld_sort_order' => $sortOrder,
			'fld_price' => $price,
			'fld_weight' => $weight,
			'fld_weight_class_id ' => $weightClassId,
			'fld_lenght_class_id ' => $lengthClassId,
		);
		$notId = '';
		if($pid){
			$notId = array('fld_product_id'=> array($pid));
		}
		
		$iCount = $this->common_model->getAll('count(fld_product_id) as totl', 'tbl_product', array('fld_isDeleted'=>'2','fld_url_slug'=>$slug), '', '', $notId);
		$iCount = $iCount[0]->totl;
		if($iCount > 0){
			echo json_encode(array('status'=> 'slug_error'));
			exit;
		}
		
		$avtar = $_FILES['img']['name'];
		if($avtar){
			$data['fld_image'] = uploadFiles('img', $path = 'uploads/product/', 'thumb', 360, 360 );
		}
		if($pid){
			$this->common_model->updateData('tbl_product', array('fld_product_id'=>$pid), $data);
			$status = 'updated';
			$id = $this->input->post('pid');
		}else{
			//echo '<pre>';print_r($data);die;
			$data['fld_created_date'] = date("Y-m-d H:i:s", time());
			$id = $this->common_model->saveData('tbl_product', $data);
			
			if($id){
				$categArr 		= $this->input->post('category');
				$relatedPrdArr 	= $this->input->post('fld_related_product');
			
				foreach($categArr as $categId){
					$prdCatData['fld_product_id']  = $id;
					$prdCatData['fld_category_id'] = $categId;
					$this->common_model->saveData('tbl_product_to_category', $prdCatData);
				}
				
				foreach($relatedPrdArr as $prdctId){
					$prdRelatedData['fld_product_id']  		   = $id;
					$prdRelatedData['fld_product_related_id'] = $prdctId;
					$this->common_model->saveData('tbl_product_to_related', $prdRelatedData);
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
			$notId = array('fld_product_id'=> array(decode($notId)));
		}
		$slug = slugify($catName);
		
		
		$iCount = $this->common_model->getAll('count(fld_product_id) as totl', 'tbl_product', array('fld_isDeleted'=>'2','fld_url_slug'=>$slug), '', '', $notId);
		$iCount = $iCount[0]->totl;
		
		if($iCount > 0 && $type == 'prd'){
			$iTotalAry = $this->manual_model->findDubliSlug($slug,'tbl_product');
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
			$result  = $this->common_model->getAll('fld_cid, fld_fname, fld_lname', 'tbl_customer', array('fld_status'=>'1','fld_isDeleted'=>'2','fld_cgid'=>$groupId), 'fld_cid asc');
		}
		
		if($this->input->post('id')){
			echo json_encode($result);
		}else{
			return($result);
		}		
	}

}