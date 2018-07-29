<?php
if ( $productAray ) {
	$catSelctIDs = array();
	$prdctName = $productAray[ 0 ]->name;
	$url_slug = $productAray[ 0 ]->url_slug;
	$tags = $productAray[ 0 ]->tags;
	$isStatus = $productAray[ 0 ]->status;
	$img = $productAray[ 0 ]->image;
	$model = $productAray[ 0 ]->model;
	$quentity = $productAray[ 0 ]->quantity;
	$outOfStockId = $productAray[ 0 ]->stock_status_id;
	$sku = $productAray[ 0 ]->sku_code;
	$subStock = $productAray[ 0 ]->subtract_stock;
	$availDate = date( 'd/m/Y', strtotime( $productAray[ 0 ]->date_available ) );
	$metaTDesc = $productAray[ 0 ]->meta_description;
	$metaTKey = $productAray[ 0 ]->meta_keyword;
	$description = $productAray[ 0 ]->description;
	$typeLbl = 'Update';
	$linkTopBrod = $prdctName;
	$lngk = 'edit';
} else {
	$prdctName = $url_slug = $tags = $img = $model = $dimWidth = $quentity = $outOfStockId = $sku = $subStock = $availDate = $metaTDesc = $metaTKey = $description = '';
	$catSelctIDs = array();
	$typeLbl = 'Create';
	$linkTopBrod = 'New Product';
	$lngk = 'add';
	$isStatus = 1;
}

$typeList = $relatedPrdctList = '';

if($typeSelectsAry){
	$typeSelectsAry = json_decode(json_encode($typeSelectsAry), true);
	$typeSelectsAry = array_column($typeSelectsAry, 'type_id');
}
foreach ( $typeAry as $data ) {
	$isTypSelt = in_array($data->type_id, $typeSelectsAry) ? 'selected' : '';
	$typeList .= '<option '.$isTypSelt.' value="' . $data->type_id . '">' . $data->name . '</option>';
}

if($productSelectsAry){
	$productSelectsAry = json_decode(json_encode($productSelectsAry), true);
	$productSelectsAry = array_column($productSelectsAry, 'product_related_id');
}
foreach($relatedProductAry as $data){
	$isTypSelt = in_array($data->product_id, $productSelectsAry) ? 'selected' : '';
	$relatedPrdctList .= '<option '.$isTypSelt.' value="' . $data->product_id . '">' . $data->name . '</option>';
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<?php include('includes/commonfile.php');?>
	<title>
		<?=$typeLbl?> Product | POCHI Admin</title>
	<link href="<?=$iURL_assets?>admin/js/dropify/dist/css/dropify.min.css" rel="stylesheet" type="text/css"/>
	<link rel="stylesheet" href="<?=$iURL_adminAssts?>js/zTreeStyle/zTreeStyle.css" type="text/css">
	<?php include('includes/styles.php'); ?>	
</head>

<body class="no-skin">
	<?php include('includes/header.php')?>
	<div class="main-container ace-save-state" id="main-container">
		<?php include('includes/sidebar.php')?>
		<div class="main-content">
			<div class="main-content-inner">
				<div class="breadcrumbs ace-save-state" id="breadcrumbs">
					<ul class="breadcrumb">
						<li>
							<i class="ace-icon fa fa-home home-icon"></i>
							<a href="<?=base_url()?>">Home</a>
						</li>
						<li>
							<a href="<?=admin_url()?>products">Products</a>
						</li>
						<li class="active">
							<a href="<?=admin_url()?>customers/<?=$lngk?>">
								<?=$typeLbl?>Product</a>
						</li>
					</ul>
					<!-- /.breadcrumb -->
					<div class="nav-search">
						<i>Last Login : <?=lastLogin(AID);?></i>
					</div>
					<!-- /.nav-search -->
				</div>
				<div class="page-content">
					<div class="row">
						<div class="col-xs-12">
							<div class="headPageA">
								<div class="titleAre"><i class="fas fa-shopping-cart"></i> <?=$typeLbl?>Product</div>
							</div>
							<div class="hr dotted hr-double"></div>
							<div class="tabbable">
								<ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
									<li class="active">
										<a data-toggle="tab" href="#GeneralTab"><i class="green ace-icon fas fa-user-circle bigger-120"></i> General</a>
									</li>
									<li>
										<a data-toggle="tab" href="#dataTab"><i class="green ace-icon far fa-id-card bigger-120"></i> Data</a>
									</li>
									<li>
										<a data-toggle="tab" href="#specialTab"><i class="green ace-icon fas fa-industry bigger-120"></i> Pricing</a>
									</li>
									<li>
										<a data-toggle="tab" href="#imagesTab"><i class="green ace-icon far fa-credit-card bigger-120"></i> Images</a>
									</li>
								</ul>
								<!-- Tab panes -->
								<form class="form-horizontal" id="editNewProduct">
									<div class="tab-content">
										<div id="GeneralTab" class="tab-pane in active">
											<div class="row">
												<input type="hidden" value="<?=$ePID?>" name="pid"/>
												<div class="col-sm-8">
													<div class="form-group col-md-6">
														<label class="required">Product Name </label>
														<input onBlur="generateURLSlug(this.value, 'prd')" type="text" name="name" class="form-control" value="<?=$prdctName;?>" placeholder="Enter Product Name" required/>
													</div>
													<div class="form-group col-md-6">
														<label class="required">URL Slug</label>
														<input onBlur="generateURLSlug(this.value, 'slug')" onKeyUp="$('.slugErr').hide()" data-toggle="tooltip" title="Do not use spaces instead replace spaces with - and make sure the keyword is globally unique." value="<?=$url_slug?>" type="text" name="url_slug" class="form-control" placeholder="Enter Uniqe URL Slug"/>
														<span class="help-block slugErr"> This URL slug is not available </span>
													</div>
													<div class="form-group col-md-6">
														<label>Meta Tag Description</label>
														<textarea name="meta_desc" class="form-control"><?=$metaTDesc?></textarea>
													</div>
													<div class="form-group col-md-6">
														<label>Meta Tag Keywords</label>
														<textarea name="meta_keywords" class="form-control"><?=$metaTKey?></textarea>
													</div>
													<div class="form-group col-md-12">
														<label>Description</label>
														<textarea name="desc" class="form-control"><?=$description?></textarea>
													</div>
													<div class="form-group col-md-6">
														<label>Product Tag</label>
														<input type="text" name="tag" class="form-control" value="<?=$tags?>" placeholder="Comma separated tag"/>
													</div>
													<div class="form-group col-md-6">
														<label>&nbsp;</label>
														<div class="borderChexBx">
															<label>Status</label>
															<label class="switchS switchSCuStatus">
															  <input name="isStatus" value="1" class="switchS-input" type="checkbox" <?=$isStatus == '1' ? 'checked' : ''?> />
															  <span class="switchS-label" data-on="Active" data-off="Inactive"></span> <span class="switchS-handle"></span> 
															</label>
														</div>
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form-group col-md-12">
														<label class="required">Type</label>
														<select class="selectpicker" name="type[]" multiple title="Select Type" data-live-search="true" data-size="5" required data-width="100%" required>
															<?=$typeList?>
														</select>
													</div>
													<div class="form-group col-md-12">
														<label>Category</label>
														<div class="catPanLstng">
															<div class="zTreeDemoBackground left">
																<ul id="treeDemo" class="ztree"></ul>
															</div>
														</div>
													</div>
													<div class="form-group dropyCHet col-sm-12">
														<label>Product Image</label>
														<input name="img" type="file" data-allowed-file-extensions="png jpg gif jpeg" class="dropify" data-max-file-size="2M" data-default-file="<?=$iURL_product?><?=$img ? $img : 'default.jpg'?>"/>
													</div>
												</div>
											</div>
										</div>
										<div id="dataTab" class="tab-pane ">
											<div class="row">
												<div class="col-md-12">
													<div class="form-group col-md-4">
														<label class="required">Model</label>
														<input type="text" name="model" class="form-control" value="<?=$model;?>" placeholder="Enter Product Model Name" required/>
													</div>
													<div class="form-group col-md-4">
														<label class="required">SKU</label>
														<input type="text" name="sku" class="form-control" value="<?=$sku?>" placeholder="Enter SKU Code" required/>
													</div>
													<div class="form-group col-md-4">
														<label class="required">Quantity</label>
														<input type="text" name="quantity" class="form-control" value="<?=$quentity?>" placeholder="Enter Product Quentity" required/>
													</div>
													<div class="form-group col-md-4">
														<label class="required">Subtract Stock</label>
														<input type="text" name="substact stock" value="<?=$subStock?>" class="form-control" placeholder="Enter Subtract Stock" required/>
													</div>
													<div class="form-group col-md-4">
														<label class="required">Out Of Stock Status</label>
														<select class="selectpicker" name="stock" data-width="100%">
															<option value="0" <?=$outOfStockId=='0' ? 'selected="Selected"': '';?>>2 - 3 Days</option>
															<option value="1" <?=$outOfStockId=='1' ? 'selected="Selected"': '';?>>In Stock</option>
															<option value="2" <?=$outOfStockId=='2' ? 'selected="Selected"': '';?>>Out Of Stock</option>
															<option value="3" <?=$outOfStockId=='3' ? 'selected="Selected"': '';?>>Pre-Order</option>
														</select>
													</div>
													<div class="form-group col-md-4">
														<label class="required">Date Available</label>
														<div class="input-group">
															<input name="date" class="form-control date-picker" value="<?=$availDate?>" type="text" placeholder="dd/mm/yyyy" data-date-format="dd/mm/yyyy"/>
															<span class="input-group-addon"> <i class="far fa-calendar-alt bigger-110"></i> </span>
														</div>
													</div>
													<div class="form-group col-md-4">
														<label class="required">Related Product</label>
														<select class="selectpicker" multiple name="relatedProducts[]" title="Select Producst" data-live-search="true" data-selected-text-format="count" data-size="5" multiple data-actions-box="true" data-width="100%">
															<?=$relatedPrdctList?>
														</select>
													</div>
												</div>
											</div>
										</div>
									</div>									
									<div class="row">
										<div class="col-sm-12 mt20">
											<div class="form-group">
												<div class="col-md-12 text-right">
													<a href="<?=admin_url('products')?>" class="btn btn-inverse">Cancel</a>
													<button type="submit" class="btn btn-success"><i class="fa fa-check"></i> <?=$typeLbl;?> Product</button>
												</div>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<!-- /.page-content -->
			</div>
		</div>
		<!-- /.main-content -->
		<?php include('includes/footer.php')?>
	</div>

	<!-- basic scripts -->
	<script src="<?=$iURL_assets?>admin/js/dropify/dist/js/dropify.min.js"></script>
	<?php include('includes/scripts.php')?>
	<script type="text/javascript" src="<?=$iURL_assets?>admin/js/zTreeStyle/jquery.ztree.all.min.js"></script>
	<script src="<?=$iURL_assets?>admin/js/custom.js"></script>
	<script>
		$( document ).ready( function () {
			$( '.dropify' ).dropify();
		} );

		$( '.date-picker' ).datepicker( {
			autoclose: true,
		} );

		$( '.datapicker' ).daterangepicker( {
			singleDatePicker: true,
			showDropdowns: true,
		} );

		$( '.datapicker' ).daterangepicker( {
			singleDatePicker: true,
			showDropdowns: true,
		} );
	</script>
	
	<script>		
		var setting = {
			check: {
				enable: true,
				chkboxType: { "Y" : "", "N" : "" }
			},
			data: {
				simpleData: {
					enable: true
				}
			}
		};
		
		$(document).ready(function(){
			var dataString = {
				pid: "<?=$ePID?>",
			};
			
			$.ajax({
				url: admin_url+"products/getCategoryList",
				dataType: 'json',
				type: "POST",
				data: dataString,
				beforeSend: function () {
					showLoader();
				},
				success: function (obj) {
					treeObj = $.fn.zTree.init($("#treeDemo"), setting, obj);
					var nodes = treeObj.getCheckedNodes(true);
					var parentNode = '';
					$.each(nodes, function( index, value ){
						parentNode = nodes[index].getParentNode();
						treeObj.expandNode(parentNode, true, false, false);
						if(parentNode){
							var i = 10;
							do{
								parentNode = parentNode.getParentNode();
								if(parentNode){
									treeObj.expandNode(parentNode, true, false, false);
								}
							}
							while (parentNode);
						}
					});

				},
				error: function () {
					csrfError();
				},
			});
		});
		
		
	</script>	
</body>
</html>