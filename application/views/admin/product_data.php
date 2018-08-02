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
										<a data-toggle="tab" href="#generalTab"><i class="green ace-icon fas fa-cube bigger-120"></i> General</a>
									</li>
									<li>
										<a data-toggle="tab" href="#dataTab"><i class="green ace-icon fas fa-table bigger-120"></i> Data</a>
									</li>
									<li>
										<a data-toggle="tab" href="#priceTab"><i class="green ace-icon fas fa-dollar-sign bigger-120"></i> Price</a>
									</li>
									<!--<li>
										<a data-toggle="tab" href="#discountTab"><i class="green ace-icon fas fa-hand-holding-usd bigger-120"></i> Discount</a>
									</li>-->
									
									<li>
										<a data-toggle="tab" href="#imageTab"><i class="green ace-icon fas fa-images bigger-120"></i> Image</a>
									</li>
									<li>
										<a data-toggle="tab" href="#rewardTab"><i class="green ace-icon fas fa-gift bigger-120"></i> Reward</a>
									</li>
									<li>
										<a data-toggle="tab" href="#SEOTab"><i class="green ace-icon fab fa-searchengin bigger-120"></i> SEO</a>
									</li>
								</ul>
								<!-- Tab panes -->
								<form class="form-horizontal" id="editNewProduct">
									<input type="hidden" value="<?=$ePID?>" name="pid"/>
									<div class="tab-content">
										<div id="generalTab" class="tab-pane in active">
											<div class="row">
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
													<div class="form-group col-md-12">
														<label>Description</label>
														<textarea name="desc" rows="8" class="summernote"><?=$description?></textarea>
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form-group col-md-12">
														<label class="required">Type</label>
														<select class="selectpicker" name="type[]" multiple title="Select Type" data-live-search="true" data-size="5"  data-width="100%" required>
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
										<div id="dataTab" class="tab-pane">
											<div class="row">
												<div class="col-md-12">
													<div class="form-group col-md-4">
														<label>Model</label>
														<input type="text" name="model" class="form-control" value="<?=$model;?>" placeholder="Enter Product Model Name"/>
													</div>
													<div class="form-group col-md-4">
														<label>SKU</label>
														<input type="text" name="sku" class="form-control" value="<?=$sku?>" placeholder="Enter SKU Code"/>
													</div>
													<div class="form-group col-md-4">
														<label class="required">Related Product</label>
														<select class="selectpicker" multiple name="relatedProducts[]" title="Select Producst" data-live-search="true" data-selected-text-format="count" data-size="5"  data-actions-box="true" data-width="100%">
															<?=$relatedPrdctList?>
														</select>
													</div>
													<div class="form-group col-md-4">
														<label class="required">Product Stock</label>
														<input type="text" name="quantity" class="form-control" value="<?=$quentity?>" placeholder="Enter Product Quentity" required/>
													</div>
													<div class="form-group col-md-4">
														<label class="required">Subtract Stock</label>
														<select class="selectpicker" name="stock" data-width="100%">
															<option value="1">Yes</option>
															<option value="0">No</option>
														</select>
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
														<label>Date Available</label>
														<div class="input-group">
															<input name="date" class="form-control date-picker" value="<?=$availDate?>" type="text" placeholder="dd/mm/yyyy" data-date-format="dd/mm/yyyy"/>
															<span class="input-group-addon"> <i class="far fa-calendar-alt bigger-110"></i> </span>
														</div>
													</div>
													
													<div class="form-group col-md-4">
														<label>Sort Order</label>
														<input type="text" name="quantity" class="form-control" value="<?=$quentity?>" placeholder="Enter Sort Order" />
													</div>
												</div>
											</div>
										</div>
										
										
										<div id="priceTab" class="tab-pane ">
											<table class="table table-striped table-bordered table-hover no-footer">
													<tr>
														<th>Quantity Type</th>
														<th>Quantity</th>
														<th>Product Price</th>
														<th>Discount Type</th>
														<th>Discounted Price</th>
														<th>Action</th>
													</tr>
													<tr>
														<td>
															<select class="selectpicker" name="XXXXXXX" title="Quantity Type" data-width="100%">
																<option>Leeter</option>
																<option>KG</option>
																<option>Graam</option>
															</select>
														</td>
														<td>
															<input type="text" class="form-control" placeholder="Quantity" name="default_reward_point" />
														</td>
														<td>
															<input type="text" class="form-control" placeholder="Product Price" name="default_reward_point" />
														</td>
														<td>
															<select class="selectpicker" name="XXXXXXX" title="Discount Type" data-width="100%">
																<option>Flat Rate (Rs.)</option>
																<option>Percentage (%)</option>
															</select>
														</td>
														<td>
															<input type="text" class="form-control" placeholder="Discounted Price" name="default_reward_point" />
														</td>
														<td>
															<button type="button" class="removeMoreTbl"><i class="fas fa-minus-circle"></i></button>
														</td>
													</tr>
													<tr>
														<td colspan="5">
														</td>
														<td>
															<button type="button" class="addMoreTbl"><i class="fa fa-plus-circle"></i></button>
														</td>
													</tr>
												</table>
											
											<div class="priceGropCon">
												<div data-toggle="tooltip" title="Remove Panel" class="removePriceGropBox"><i class="fas fa-times-circle"></i></div>
												<table class="table table-bordered no-footer">
													<tr>
														<th>State</th>
														<td>
															<select class="selectpicker" name="XXXXXXX" multiple title="Select State" data-live-search="true" data-size="5"  data-width="100%" required>
															<?=$typeList?>
															</select>
														</td>
														<th>City</th>
														<td>
															<select class="selectpicker" name="XXXXXXX" multiple title="Select City" data-live-search="true" data-size="5"  data-width="100%" required>
															<?=$typeList?>
															</select>
														</td>
													</tr>
													<tr>
														<table class="table table-bordered no-footer mb0">
															<tr>
																<th>Group</th>
																<th>Quantity Type</th>
																<th>Quantity</th>
																<th>Price</th>
																<th>Discount Type</th>
																<th>Discount</th>
																<th>Start Date</th>
																<th>End Date</th>
																<th class="text-center">Action</th>
															</tr>
															<tr>
																<td>
																	<select class="selectpicker" name="XXXXXXX" multiple title="Select Group" data-live-search="true" data-size="5"  data-width="100%" required>
																		<?=$typeList?>
																	</select>
																</td>
																<td>
																	<select class="selectpicker" name="XXXXXXX" multiple title="Select Quantity" data-live-search="true" data-size="5"  data-width="100%" required>
																		<option>KG</option>
																		<option>Litter</option>
																	</select>
																</td>
																<td>
																	<input type="text" class="form-control" placeholder="Price" name="XXXXXXX" />
																</td>
																<td>
																	<input type="text" class="form-control" placeholder="Price" name="XXXXXXX" />
																</td>
																<td>
																	<select class="selectpicker" name="XXXXXXX" title="Discount Type" data-width="100%" required>
																		<option>Flat Rate (Rs)</option>
																		<option>Percentage (%)</option>
																	</select>
																</td>
																<td>
																	<input type="text" class="form-control" placeholder="Discount" name="XXXXXXX" />
																</td>
																<td>
																	<div class="input-group">
																		<input name="XXXXXXXXX" class="form-control date-picker" type="text" placeholder="dd/mm/yyyy" data-date-format="dd/mm/yyyy" />
																		<span class="input-group-addon">
																			<i class="far fa-calendar-alt bigger-110"></i>
																		</span>
																	</div>
																</td>
																<td>
																	<div class="input-group">
																		<input name="XXXXXXXXX" class="form-control date-picker" type="text" placeholder="dd/mm/yyyy" data-date-format="dd/mm/yyyy" />
																		<span class="input-group-addon">
																			<i class="far fa-calendar-alt bigger-110"></i>
																		</span>
																	</div>
																</td>
																<td class="text-center">
																	<button type="button" class="removeMoreTbl"><i class="fas fa-minus-circle"></i></button>
																</td>
															</tr>
															<tr>
																<td colspan="8"></td>
																<td class="text-center">
																	<button type="button" class="addMoreTbl"><i class="fa fa-plus-circle"></i></button>
																</td>
															</tr>
														</table>
													</tr>
												</table>
											</div>
											
											<div class="text-center">
												<button type="button" class="btn btn-primary"><i class="fa fa-plus"></i> Add More</button>
											</div>
											<div class="clearfix"></div>
										</div>
										<!--<div id="discountTab" class="tab-pane ">
											<div class="clearfix"></div>
										</div>-->
										<div id="imageTab" class="tab-pane ">											
											<div class="col-sm-3">
												<div class="form-group">
													<label>Default Product Image <i data-toggle="tooltip" title="Number of points needed to buy this item. If you don't want this product to be purchased with points leave as 0." class="fas fa-question-circle helpIconT"></i></label>
													<div class="form-group dropyCHet mb0">
														<input name="img" type="file" data-allowed-file-extensions="png jpg gif jpeg" class="dropify" data-max-file-size="2M" data-default-file="<?=$iURL_product?><?=$img ? $img : 'default.jpg'?>"/>
													</div>
												</div>
											</div>											
											<div class="col-sm-3">
												<label>&nbsp;</label>
												<div class="addMoreImagePro"> <i class="fas fa-images"></i> <span>Add More</span> </div>
											</div>											
											<div class="clearfix"></div>
										</div>
										<div id="rewardTab" class="tab-pane">
											<div class="col-sm-6 boxDefulRewrrd col-sm-offset-3">
												<div class="form-group mb0">
													<label>Default Reward Point <i data-toggle="tooltip" title="Number of points needed to buy this item. If you don't want this product to be purchased with points leave as 0." class="fas fa-question-circle helpIconT"></i></label>
													<input type="text" class="form-control" placeholder="Add Default Reward Point" name="default_reward_point" />
												</div>
											</div>
											
											<div class="col-md-12">
												<table class="table table-striped table-bordered table-hover no-footer">
													<tr>
														<th width="35%">Group</th>
														<th  width="70%">Point</th>
														<th  width="5%" class="text-center">Action</th>
													</tr>
													<tr>
														<td>
															<select class="selectpicker" name="reward_group[]" multiple title="Select Group" data-live-search="true" data-size="5"  data-width="100%" required>
															<?=$typeList?>
															</select>
														</td>
														<td><input type="text" class="form-control" name="reward_point[]" /></td>
														<td class="text-center">
															<button type="button" class="removeMoreTbl"><i class="fas fa-minus-circle"></i></button>
														</td>
													</tr>
													<tr>
														<td colspan="2"></td>
														<td class="text-center">
															<button type="button" class="addMoreTbl"><i class="fa fa-plus-circle"></i></button>
														</td>
													</tr>
												</table>
											</div>											
											<div class="clearfix"></div>
										</div>
										<div id="SEOTab" class="tab-pane ">
											<div class="col-md-12">
												<div class="form-group">
													<label class="required">Meta Tag Title</label>
													<input type="text" class="form-control" name="meta_title" value="<?=$metaTDesc?>"  required />
												</div>
											</div>
											
											<div class="col-md-6">
												<div class="form-group">
													<label>Meta Tag Description</label>
													<textarea name="meta_desc" class="form-control"><?=$metaTDesc?></textarea>
												</div>
											</div>
											
											<div class="col-md-6">
												<div class="form-group">
													<label>Meta Tag Keywords</label>
													<textarea name="meta_keywords" class="form-control"><?=$metaTKey?></textarea>
												</div>
											</div>
											<div class="clearfix"></div>
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