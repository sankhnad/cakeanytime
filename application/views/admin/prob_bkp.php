<?php
if ($productAray){
	$catSelctIDs = array();
	$prdctName 		= $productAray[0]->name;
	$url_slug 		= $productAray[0]->url_slug;
	$typeId 		= $productAray[0]->type;
	$tags 			= $productAray[0]->tags;
	$isStatus 		= $productAray[0]->status;
	$img 			= $productAray[0]->image;
	$model 			= $productAray[0]->model;
	$quentity 		= $productAray[0]->quantity;
	$outOfStockId 	= $productAray[0]->stock_status_id;
	$sku		 	= $productAray[0]->sku_code;
	$subStock	 	= $productAray[0]->subtract_stock;
	$availDate 		= date('d/m/Y', strtotime( $productAray[0]->date_available));
	$metaTDesc 		= $productAray[0]->meta_description;
	$metaTKey 		= $productAray[0]->meta_keyword;
	$description 	= $productAray[0]->description;
	$typeLbl 		= 'Update';
	$linkTopBrod 	= $prdctName;
	$lngk 			= 'edit';
}else{
	$prdctName = $url_slug = $typeId = $tags = $img =  $model = $dimWidth = $quentity =  $outOfStockId = $sku = $subStock = $availDate = $metaTDesc = $metaTKey = $description =  '';
	$catSelctIDs = array();
	$typeLbl = 'Create';
	$linkTopBrod = 'New Product';
	$lngk = 'add';
	$isStatus = 1;	
}

$typeList = ''; 
foreach($typeAry as $data){
	if($data->type_id == $typeId){
		$typeList .= '<option selected="Selected" value="'.$data->type_id.'">'.$data->name.'</option>';
	}else{
		$typeList .= '<option value="'.$data->type_id.'">'.$data->name.'</option>';	
	}
}

$assignRelatedProdcutArry = array();
foreach($productSelectsAry as $data){
	$assignRelatedProdcutArry[] = $data->product_related_id;
}

$relatedPrdctList = ''; 
foreach($relatedProductAry as $data){
	if(in_array($data->product_id,$assignRelatedProdcutArry)){
		$relatedPrdctList .= '<option selected="Selected" value="'.$data->product_id.'">'.$data->name.'</option>';
	}else{
		$relatedPrdctList .= '<option value="'.$data->product_id.'">'.$data->name.'</option>';	
	}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php include('includes/commonfile.php');?>
<title>
<?=$typeLbl?>
Product | POCHI Admin</title>
<link href="<?=$iURL_assets?>admin/js/dropify/dist/css/dropify.min.css" rel="stylesheet" type="text/css"/>
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
        <li> <i class="ace-icon fa fa-home home-icon"></i> <a href="<?=base_url()?>">Home</a> </li>
        <li> <a href="<?=base_url()?>products">Products</a> </li>
        <li class="active"> <a href="<?=admin_url()?>products/<?=$lngk?>">
          <?=$typeLbl?>
          Product</a> </li>
      </ul>
      <!-- /.breadcrumb -->
      <div class="nav-search"> <i>Last Login :
        <?=lastLogin(AID);?>
        </i> </div>
      <!-- /.nav-search -->
    </div>
    <div class="page-content">
      <div class="row">
        <div class="col-xs-12">
          <div class="headPageA">
            <div class="titleAre"><i class="fas fa-box-open"></i>
              <?=$typeLbl?>
              Product</div>
          </div>
          <div class="hr dotted hr-double"></div>
          <div class="row">
            <div class="col-sm-12">
              <div class="tabbable">
                <ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
                  <li  class="active"><a data-toggle="tab" href="#GeneralTab"><i class="green ace-icon fas fa-user-circle bigger-120"></i> General</a></li>
                  <li ><a data-toggle="tab" href="#dataTab"><i class="green ace-icon far fa-id-card bigger-120"></i> Data
                    
                    &nbsp; &nbsp; <i data-toggle="tooltip" title="Pending KYC Verification" class="fa fa-exclamation-triangle kycPenIcn red bigger-120"></i> </a></li>
					
					<li > <a data-toggle="tab" href="#specialTab"><i class="green ace-icon fas fa-industry bigger-120"></i> Pricing</a> </li>
											
					<li > <a data-toggle="tab" href="#imagesTab"><i class="green ace-icon far fa-credit-card bigger-120"></i> Images</a> </li>
                </ul>
                <!-- Tab panes -->
                <form class="form-horizontal" id="editNewProduct">
                  <div class="tab-content">
                    <div id="GeneralTab" class="tab-pane in active">
                      <div class="row">
                        <input type="hidden" value="<?=$ePID?>" name="pid"/>
                        <div class="form-group row">
                          <div class="col-sm-8">
                                <div class="form-group col-md-6">
									<label class="required">Product Name </label>
									<input onBlur="generateURLSlug(this.value, 'prd')" type="text" name="name" class="form-control" value="<?=$prdctName;?>" placeholder="Enter Product Name" required />
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
									<input type="text" name="tag" class="form-control" value="<?=$tags?>" placeholder="Comma separated tag" />
                                </div>
                                <div class="form-group col-md-6">
                                  <label>&nbsp;</label>
									<div class="borderChexBx">
                                      <label>Status</label>
                                      <label class="switchS switchSCuStatus">
                                      <input name="isStatus" value="1" class="switchS-input" type="checkbox" <?=$isStatus == '1' ? 'checked' : ''?> />
                                      <span class="switchS-label" data-on="Active" data-off="Inactive"></span> <span class="switchS-handle"></span> </label>
                                    </div>
                                </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group col-md-12">
                              <label class="required">Type</label>
                                <select class="selectpicker" name="type"  title="Select Type" data-live-search="true" data-size="5" required data-width="100%" required>
								  <?=$typeList?>							  
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                              <label>Category</label>
                              <div class="catPanLstng">
                                <input type="hidden" class="catValID" name="category" value="<?=end($catSelctIDs)['category_id'] ? :0?>"/>
                                <?php
									
									?>
                              </div>
                            </div>
                            <div class="form-group dropyCHet col-sm-12">
                              <label>Product Image</label>
                              <input name="img" type="file" data-allowed-file-extensions="png jpg gif jpeg" class="dropify" data-max-file-size="2M" data-default-file="<?=$iURL_product?><?=$img ? $img : 'default.jpg'?>"/>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div id="dataTab" class="tab-pane ">
                      <div class="row">
                        <div class="col-md-12">
                              <div class="form-group col-md-4">
                                <label class="required">Model</label>
								  <input  type="text" name="model" class="form-control" value="<?=$model;?>" placeholder="Enter Product Model Name" required />
                              </div>                            
							  <div class="form-group col-md-4">
                                <label class="required">SKU</label>
                                <input type="text" name="sku" class="form-control" value="<?=$sku?>" placeholder="Enter SKU Code" required/>
                              </div>
							  <div class="form-group col-md-4">
                                <label class="required">Quantity</label>
                                <input type="text" name="quantity" class="form-control" value="<?=$quentity?>" placeholder="Enter Product Quentity" required />
                              </div>
							  <div class="form-group col-md-4">
								<label class="required">Subtract Stock</label>
								<input type="text" name="substact stock" value="<?=$subStock?>" class="form-control" placeholder="Enter Subtract Stock" required/>
							  </div>
							  <div class="form-group col-md-4">
                                <label class="required">Out Of Stock Status</label>
                                <select class="selectpicker" name="stock" data-width="100%">
                                    <option value="0" <?=$outOfStockId == '0'?'selected="Selected"':'';?>>2 - 3 Days</option>
                                    <option value="1" <?=$outOfStockId == '1'?'selected="Selected"':'';?>>In Stock</option>
                                    <option value="2" <?=$outOfStockId == '2'?'selected="Selected"':'';?>>Out Of Stock</option>
                                    <option value="3" <?=$outOfStockId == '3'?'selected="Selected"':'';?>>Pre-Order</option>
                                  </select>
                              </div>
							  <div class="form-group col-md-4">
                                <label class="required">Date Available</label>
                                <div class="input-group">
								<input name="date" class="form-control date-picker" value="<?=$availDate?>"  type="text" placeholder="dd/mm/yyyy" data-date-format="dd/mm/yyyy" />
								<span class="input-group-addon"> <i class="far fa-calendar-alt bigger-110"></i> </span> </div>
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
					<div class="form-group">
                      <div class="col-md-12 text-right"> <a href="<?=base_url('admin/products')?>" class="btn btn-inverse waves-effect waves-light">Cancel</a>
                        <button type="submit" class="btn btn-success waves-effect waves-light"><i class="fa fa-check"></i>&nbsp;
                        <?=$typeLbl;?>
                        Product</button>
                      </div>
                    </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- /.row -->
      </div>
      <!-- /.page-content -->
    </div>
  </div>
  <!-- /.main-content -->
  <?php include('includes/footer.php')?>
</div>
</div>	
<!-- /.main-container -->
<!-- /Modal -->
<div class="hide priceClass">
  <div class="plsBtnBox">
    <button onClick="clonePricingProduct(0, this)" type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> </button>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label class="col-md-12">Class</label>
      <div class="col-md-12">
        <select class="selectpicker">
          <option value="0" selected>Kilogram</option>
          <option value="1">Gram</option>
          <option value="2">Leeter</option>
          <option value="3">Centimeter</option>
          <option value="4">Inch</option>
          <option value="5">Feet</option>
        </select>
      </div>
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label class="col-md-12">Weight &nbsp; <span class="required"></span></label>
      <div class="col-md-12">
        <input type="text" name="name" class="form-control" placeholder="" required/>
      </div>
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label class="col-md-12">Price &nbsp; <span class="required"></span></label>
      <div class="col-md-12">
        <input type="text" name="name" class="form-control" placeholder="Product Price" required/>
      </div>
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label class="col-md-12">Special Price &nbsp; <span class="required"></span></label>
      <div class="col-md-12">
        <input type="text" name="name" class="form-control" placeholder="Discounted Price" required/>
      </div>
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label class="col-md-12">Select State &nbsp; <span class="required"></span></label>
      <div class="col-md-12">
        <select class="selectpicker" data-style="form-control" title="Select State" data-live-search="true" data-size="5">
          <option value="1">West Bengal</option>
          <option value="10">Delhi</option>
          <option value="2">Rajesthan</option>
          <option value="3">Himanchal</option>
        </select>
      </div>
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label class="col-md-12">Select City &nbsp; <span class="required"></span></label>
      <div class="col-md-12">
        <select class="selectpicker" data-style="form-control" title="Select City" disabled data-live-search="true" data-size="5">
          <option value="1">West Bengal</option>
          <option value="10">Delhi</option>
          <option value="2">Rajesthan</option>
          <option value="3">Himanchal</option>
        </select>
      </div>
    </div>
  </div>
  <div class="lsBtnBox">
    <button onClick="clonePricingProduct(1)" type="button" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i> </button>
  </div>
</div>
<!-- basic scripts -->
<script src="<?=$iURL_assets?>admin/js/dropify/dist/js/dropify.min.js"></script>
<?php include('includes/scripts.php')?>
<script src="<?=$iURL_assets?>admin/js/custom.js"></script>
<script>
		$(document).ready(function(){
			$('.dropify').dropify();
		});

		$('.date-picker').datepicker({
			autoclose: true,
		});
		
		$('.datapicker').daterangepicker({
			singleDatePicker: true,
			showDropdowns: true,
		});

		$('.datapicker').daterangepicker({
			singleDatePicker: true,
			showDropdowns: true,
		});
	</script>
</body>
</html>
