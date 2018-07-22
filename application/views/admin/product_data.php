<?php
if ($proAray) {
	$catSelctIDs = array();	

	$prdctName 		= $proAray[0]->fld_name;
	$url_slug 		= $proAray[0]->fld_url_slug;
	$model 			= $proAray[0]->fld_model;
	$quentity 		= $proAray[0]->fld_quantity;
	$price 			= $proAray[0]->fld_price;
	$stockStatus 	= $proAray[0]->fld_stock_status_id;
	$availDate 		= date( 'd/m/Y', strtotime( $proAray[0]->fld_date_available ) );
	$dimLenght 		= $proAray[0]->fld_length;
	$dimWidth 		= $proAray[0]->fld_weight;
	$dimHeight 		= $proAray[0]->fld_height;
	$lengthClass 	= $proAray[0]->fld_lenght_class_id;
	$weight 		= $proAray[0]->fld_weight;
	$weightClass 	= $proAray[0]->fld_weight_class_id;
	$sort			= $proAray[0]->fld_sort_order;
	$metaTDesc 		= $proAray[0]->fld_meta_description;
	$metaTKey 		= $proAray[0]->fld_meta_keyword;
	$description 	= $proAray[0]->fld_description;
	$isStatus 		= $proAray[0]->fld_status;
	$img 			= $proAray[0]->fld_image;

	$typeLbl = 'Update';
	$linkTopBrod = $catName;
	$lngk = 'edit';
} else {
	$isStatus = $img = $prdctName = $url_slug = $model = $quentity = $price = $stockStatus =  $availDate = $dimLenght = $dimWidth = $dimHeight =  $lengthClass = $weight = $weightClass = $metaTDesc = $metaTKey = $description = $sort = '';

	$catSelctIDs = array();
	$typeLbl = 'Create';
	$linkTopBrod = 'New Product';
	$lngk = 'add';
	$status = 1;

	
	
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php include('includes/commonfile.php');?>
	<title><?=$typeLbl?> Product | POCHI Admin</title>
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
			<div class="titleAre"><i class="fas fa-box-open"></i> <?=$typeLbl?> Product</div>
			<a onClick="$('form').submit()" class="btn btn-info pull-right m-l-15 waves-effect waves-light" href="<?=base_url('admin/products')?>"><span class="btn-label"><i class="fa fa-arrow-left"></i></span><?=$typeLbl?> Product</a>&nbsp;&nbsp;&nbsp;<a class="btn btn-inverse pull-right m-l-20 waves-effect waves-light" href="<?=base_url('admin/products')?>">Cancel</a>
		  </div>
          <div class="hr dotted hr-double"></div>
          <div class="row">
            <div class="col-sm-12">
              <div class="tabbable">
                <ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
                  <li  class="active"><a data-toggle="tab" href="#GeneralTab"><i class="green ace-icon fas fa-user-circle bigger-120"></i> General</a></li>
                  <li ><a data-toggle="tab" href="#dataTab"><i class="green ace-icon far fa-id-card bigger-120"></i> Data
                    
                    &nbsp; &nbsp; <i data-toggle="tooltip" title="Pending KYC Verification" class="fa fa-exclamation-triangle kycPenIcn red bigger-120"></i> </a></li>
                  <!--											<li > <a data-toggle="tab" href="#specialTab"><i class="green ace-icon fas fa-industry bigger-120"></i> Pricing</a> </li>
											
											<li > <a data-toggle="tab" href="#imagesTab"><i class="green ace-icon far fa-credit-card bigger-120"></i> Images</a> </li>
-->
                </ul>
				<!-- Tab panes -->
				<form class="form-horizontal" id="editNewProduct">
                <div class="tab-content">
                  <div id="GeneralTab" class="tab-pane in active">
                    <div class="row">
						<input type="hidden" value="<?=$ePID?>" name="pid"/>
                      <div class="form-group row">
                        <div class="col-sm-8">
                          <div class="row">
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label class="col-md-12">Product Name &nbsp; <span class="required"></span></label>
                                <div class="col-md-12">
								  <input onBlur="generateURLSlug(this.value, 'prd')" type="text" name="name" class="form-control" value="<?=$prdctName;?>" placeholder="Enter Product Name" required />

                                </div>
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label class="col-md-12">URL Slug</label>
                                <div class="col-md-12">
                                  <input onBlur="generateURLSlug(this.value, 'slug')" onKeyUp="$('.slugErr').hide()" data-toggle="tooltip" title="Do not use spaces instead replace spaces with - and make sure the keyword is globally unique." value="<?=$url_slug?>" type="text" name="url_slug" class="form-control" placeholder="Enter Uniqe URL Slug"/>
                                  <span class="help-block slugErr"> This URL slug is not available </span> </div>
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label class="col-md-12">Meta Tag Description</label>
                                <div class="col-md-12">
                                  <textarea name="meta_desc" class="form-control">
																	<?=$metaTDesc?>
																</textarea>
                                </div>
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label class="col-md-12">Meta Tag Keywords</label>
                                <div class="col-md-12">
                                  <textarea name="meta_keywords" class="form-control">
																	<?=$metaTKey?>
																</textarea>
                                </div>
                              </div>
                            </div>
                            <div class="col-sm-12">
                              <div class="form-group">
                                <label class="col-md-12">Description</label>
                                <div class="col-md-12">
                                  <textarea name="desc" class="form-control">
																	<?=$description?>
																</textarea>
                                </div>
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label class="col-md-12">Product Tag</label>
                                <div class="col-md-12">
                                  <input type="text" name="tag" class="form-control" value="" placeholder="Comma separated tag" required/>
                                </div>
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label class="col-md-12">&nbsp;</label>
                                <div class="col-md-12">
                                  <div class="borderChexBx">
                                    <label>Status</label>
                                    <label class="switchS switchSCuStatus">
                                    <input name="isStatus" value="1" class="switchS-input" type="checkbox" <?=$isStatus == '1' ? 'checked' : ''?> />
                                    <span class="switchS-label" data-on="Active" data-off="Inactive"></span> <span class="switchS-handle"></span> </label>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="form-group">
                            <label class="col-md-12">Type</label>
                            <div class="col-md-12">
                              <select class="selectpicker" name="type"  title="Select Type" data-live-search="true" data-size="5" required>
                                <option value="1">GIFT</option>
                                <option value="2">CAKE</option>
                              </select>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-md-12">Category</label>
                            <div class="col-md-12 catPanLstng">
                              <input type="hidden" class="catValID" name="category" value="<?=end($catSelctIDs)['category_id'] ? :0?>"/>
                              <?php
														/*$catHTML = '';
														$k = 0;
														foreach ( $parentArayList as $catOptionData ) {
															if ( $catOptionData ) {
																$catHTML .= '<select onChange="getCategoryChield(this.value, ' . $k . ')" class="selectpicker mb15 catLvl' . $k . '"  title="Select Parent Category" data-live-search="true" data-size="5">';
																foreach ( $catOptionData as $catData ) {
																	$isActive = '';
																	if ( isset( $catSelctIDs[ $k ][ 'category_id' ] ) ) {
																		if ( $catSelctIDs[ $k ][ 'category_id' ] == $catData->category_id ) {
																			$isActive = 'selected';
																		}
																	}
																	$catHTML .= '<option ' . $isActive . ' value="' . $catData->category_id . '">' . $catData->name . '</option>';
																}
																$k++;
																$catHTML .= '</select>';
															}
														}
														echo $catHTML;*/
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
                      <div class="col-md-4">
                        <div class="row">
                          <div class="col-sm-12">
                            <div class="form-group">
                              <label class="col-md-12">Model &nbsp; <span class="required"></span></label>
                              <div class="col-md-12">
									<input  type="text" name="fld_model" class="form-control" value="<?=$model;?>" placeholder="Enter Product Model Name" required />
                              </div>
                            </div>
                          </div>
                          <div class="col-sm-12">
                            <div class="form-group">
                              <label class="col-md-12">SKU &nbsp; <span class="required"></span></label>
                              <div class="col-md-12">
                                <input type="text" name="sku" class="form-control" placeholder="Enter SKU Code" required/>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="row">
                          <div class="col-sm-12">
                            <div class="form-group">
                              <label class="col-md-12">Quantity &nbsp; <span class="required"></span></label>
                              <div class="col-md-12">
                                <input type="text" name="fld_quantity" class="form-control" placeholder="Enter Product Quentity" required />
                              </div>
                            </div>
                          </div>
                          <div class="col-sm-12">
                            <div class="form-group">
                              <label class="col-md-12">Subtract Stock &nbsp; <span class="required"></span></label>
                              <div class="col-md-12">
                                <input type="text" name="substact stock" class="form-control" placeholder="Enter Subtract Stock" required/>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="row">
                          <div class="col-sm-12">
                            <div class="form-group">
                              <label class="col-md-12">Out Of Stock Status &nbsp; <span class="required"></span></label>
                              <div class="col-md-12">
                                <select class="selectpicker" name="stock">
                                  <option value="0">2 - 3 Days</option>
                                  <option value="1">In Stock</option>
                                  <option value="2">Out Of Stock</option>
                                  <option value="3">Pre-Order</option>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="col-sm-12">
                            <div class="form-group">
                              <label class="col-md-12">Date Available</label>
                              <div class="col-md-12 input-group">
                                <input name="date" type="text" class="form-control datapicker" placeholder="dd/mm/yyyy" data-date-format="dd/mm/yyyy">
								
                                <span class="input-group-addon"><i class="icon-calender"></i></span> </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!--<div id="specialTab" class="tab-pane">
												<div class="row">
													<ul class="spacalPriceW">
													</ul>
												</div>		
											</div>
											<div id="imagesTab" class="tab-pane">
												<div class="row"></div>
											</div>
											
										</div>-->
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
