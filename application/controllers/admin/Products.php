<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );

class Products extends CI_Controller {
	function __construct() {
		parent::__construct();
	}
	
	function index() {
	
		$where = array(
			'isDeleted'=>'1',
		);
		$status = $this->input->post('status');
		$filter = $this->input->post('filter');
		if($status && !isset($status[1])){
			if(isset($status[0])){
				$where['status'] = $status[0];
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
				$encriptedID = encode($value['product_id']);
				if($value['status'] == '1'){
					$ststbtn = 'Disable';
					$ststCls = 'btn-success';
				}else{
					$ststbtn = 'Enable';
					$ststCls = 'btn-default';
				}
				$fldTopBar = '';
				$fldLeftBar = '';
				$html .= '<li class="dd-item dd3-item" data-id="'.$value['product_id'].'" >
				<div class="dd-handle dd3-handle">Drag</div>
				<div class="dd3-content">
					<div class="disIndLs">'.$value['name'].'</div>
					<div class="actionIndLs">
						'.$fldTopBar.$fldLeftBar.'
						<a target="_blank" href="'.base_url().'admin/product/edit/'.$encriptedID.'" data-tooltip="tooltip" title="Edit" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i></a>
						<button type="button" data-tooltip="tooltip" data-status="'.$value['status'].'" onclick="changeStatus(this, \''.$encriptedID.'\', \'status\', \'product\')" title="Click to '.$ststbtn.'" class="btn '.$ststCls.' btn-xs"><i class="fa fa-power-off"></i></button>
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
		$catOption = $this->common_model->getAll('category_id, name, parent_id', 'category', array('isDeleted'=>'1','parent_id'=>'0'), 'sort_order asc');
		$proAray = array();
		$data['stateAry'] 			= $this->common_model->getAll('*', 'location_state', array('isDeleted'=>2));
		$data['relatedProductAry']  = $this->common_model->getAll('*', 'product', array('isDeleted'=>2,'status'=>1));
		$data['groupAry'] 	    	= $this->common_model->getAll('id, name', 'customer_group', array('isDeleted'=>'1', 'status'=>'1'));

		
		$data['proAray'] = $proAray;
		$data['parentArayList'] = $catOption;		
		$data['ePID'] = '';
		$this->load->view( 'admin/product_data', $data);
	}
	
	function edit($id=''){
		$ePID = $id;
		$id = decode($id);
		$catOption = $this->common_model->getAll('category_id, name, parent_id', 'category', array('isDeleted'=>'1','parent_id'=>'0'), 'sort_order asc');
		$proAray = $this->common_model->getAll('*', 'product', array('isDeleted'=>'1', 'product_id'=>$id));		
		$data['stateAry'] 			= $this->common_model->getAll('*', 'location_state', array('isDeleted'=>2));
		$data['relatedProductAry']  = $this->common_model->getAll('*', 'product', array('isDeleted'=>2,'status'=>1));
		$data['groupAry'] 	    	= $this->common_model->getAll('id, name', 'customer_group', array('isDeleted'=>'1', 'status'=>'1'));

		
		$data['proAray'] = $proAray;
		$data['parentArayList'] = $catOption;		
		$data['ePID'] = $ePID;
		$this->load->view( 'admin/product_add', $data);
	}
	
	function storeProduct(){
		if ( !$this->input->is_ajax_request() || !AID ) {
			exit( 'Unauthorized Access' );
		}
		echo '<pre>';print_r($this->input->post());die;
		$pid			= decode($this->input->post('pid'));
		$name 			= $this->input->post('name');
		$slug 			= $this->input->post('url_slug');
		$model 			= $this->input->post('model');
		$type_id		= $this->input->post('prd_type_id');
		$metaDesc 		= $this->input->post('meta_desc');
		$metaKey 		= $this->input->post('meta_keywords');
		$desc 			= $this->input->post('desc');
		$status 		= $this->input->post('isStatus') ? $this->input->post('isStatus') : '0';
		$sku 			= $this->input->post('sku');
		$sortOrder		= $this->input->post('sort_order');
		$state			= $this->input->post('state');
		$city			= $this->input->post('city');
		$area			= $this->input->post('area');
		$price 			= $this->input->post('price');
		$discntType 	= $this->input->post('discount_type');
		$discntVal 		= $this->input->post('discount_type') == 1 ? $this->input->post('Discount_val') : $this->input->post('discount_percent');
		$quentity 		= $this->input->post('quantity');
		$availDate		= $this->input->post('date_available');
		$stockStatus	= $this->input->post('stock_status');
		$length			= $this->input->post('length');
		$width			= $this->input->post('width');
		$height			= $this->input->post('height');
		$lengthClassId	= $this->input->post('length_class');
		$weight			= $this->input->post('weight');
		$weightClassId	= $this->input->post('weight_class_id');
				
		
		$data = array(
			//'parent_id' => $categoryID,
			'name' => $name,
			'url_slug' => $slug,
			'sku_code ' => $sku,
			'model' => $model,
			'type ' => $type_id,
			'meta_description' => $metaDesc,
			'meta_keyword' => $metaKey,
			'description' => $desc,
			'status' => $status,
			'state_id' => $state,
			'city_id ' => $city,
			'area_id  ' => $area,
			'price' => $price,
			'discount_type' => $discntType,
			'discount_value' => $discntVal,
			'quantity' => $quentity,
			'date_available' => convertData($availDate),
			'stock_status_id ' => $stockStatus,
			'length' => $length,
			'width' => $width,
			'height' => $height,
			'sort_order' => $sortOrder,
			'price' => $price,
			'weight' => $weight,
			'weight_class_id ' => $weightClassId,
			'lenght_class_id ' => $lengthClassId,
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
			$status = 'updated';
			$id = $this->input->post('pid');
		}else{
			//echo '<pre>';print_r($data);die;
			$data['created_date'] = date("Y-m-d H:i:s", time());
			$id = $this->common_model->saveData('product', $data);
			
			if($id){
				$categArr 		= $this->input->post('category');
				$relatedPrdArr 	= $this->input->post('related_product');
			
				foreach($categArr as $categId){
					$prdCatData['product_id']  = $id;
					$prdCatData['category_id'] = $categId;
					$this->common_model->saveData('product_to_category', $prdCatData);
				}
				
				foreach($relatedPrdArr as $prdctId){
					$prdRelatedData['product_id']  		   = $id;
					$prdRelatedData['product_related_id'] = $prdctId;
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