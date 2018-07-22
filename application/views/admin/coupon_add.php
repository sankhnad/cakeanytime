<?php
if($coupanDisAry){
	$name 			= $coupanDisAry[ 0 ]->name;
	$code 			= $coupanDisAry[ 0 ]->code;
	$type 			= $coupanDisAry[ 0 ]->type;
	$discount 		= $coupanDisAry[ 0 ]->discount;
	$total 			= $coupanDisAry[ 0 ]->total;
	$date_start  	= date( 'd/m/Y', strtotime( $coupanDisAry[ 0 ]->date_start ) );
	$date_end   	= date( 'd/m/Y', strtotime( $coupanDisAry[ 0 ]->date_end ) );
	$uses_total  	= $coupanDisAry[ 0 ]->uses_total ;
	$uses_customer  = $coupanDisAry[ 0 ]->uses_customer ;
	$status 		= $coupanDisAry[ 0 ]->status;
	
	$groupList = $categList = $productList =  '';	
	$typeLbl		= 'Update';
	$linkTopBrod 	= $name;
	$lngk 			= 'edit';	
}else{
	$name = $code = $type = $discount = $total = $date_start = $date_end = $uses_total = $uses_customer = $groupList = $categList = $productList =  '';
	$typeLbl 		= 'Create';
	$linkTopBrod 	= 'New Coupon';
	$lngk 			= 'add';
	$status = 1;

}

foreach($groupAry as $groupData){
	if(in_array($groupData->id,$groupIds)){
		$groupList .= '<option selected="selected" value="'.$groupData->id.'">'.$groupData->name.'</option>';
	}else{
		$groupList .= '<option value="'.$groupData->id.'">'.$groupData->name.'</option>';
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php include('includes/commonfile.php');?>
	<title>Manage Coupon | Admin</title>
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
						<li>
							<i class="ace-icon fa fa-home home-icon"></i>
							<a href="<?=base_url()?>">Home</a>
						</li>
						<li>
							Coupon
						</li>
						<li>
							<a href="<?=base_url()?>admin/coupons">Manage Coupons
						</li>
						<li class="active">
							<a href="<?=base_url()?>admin/coupons/<?=$lngk?>/<?=$cid?>"><?=$linkTopBrod?></a>
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
        				<div class="col-sm-12">
							<div class="headPageA">
								<div class="titleAre"><i class="fas fa-box-open"></i> <?=$typeLbl?> Coupan</div>
							</div>
							<div class="hr dotted hr-double"></div>	
          
							<form class="form-horizontal" id="editNewCoupon">
							  <input type="hidden" value="<?=$cid?>" name="cupId"/>
							  <div class="form-group row">
								<div class="col-sm-8">
								  <div class="row">
									<div class="col-sm-6">
									  <div class="form-group">
										<label class="col-md-12">Coupon Name *</label>
										<div class="col-md-12">
										  <input type="text" value="<?=$name?>" name="name" class="form-control" placeholder="Enter Coupon Name" required/>
										</div>
									  </div>
									</div>
									<div class="col-sm-6">
									  <div class="form-group">
										<label class="col-md-12">Code *</label>
										<div class="col-md-12">
										  <input type="text" value="<?=$code?>" name="code" class="form-control" placeholder="Enter Code"/>
										</div>
									  </div>
									</div>
									<div class="col-sm-6">
									  <div class="form-group">
										<label class="col-md-12">Discount *</label>
										<div class="col-md-12">
										  <input type="text" name="discount" value="<?=$discount?>"  class="form-control" placeholder="Enter Discount">
										</div>
									  </div>
									</div>
									<div class="col-sm-6">
									  <div class="form-group">
										<label class="col-md-12">Total Amount </label>
										<div class="col-md-12">
										  <input type="text" name="tAmnt" placeholder="Enter Total Amount" value="<?=$total?>" class="form-control" required>
										</div>
									  </div>
									</div>
									
									<div class="col-sm-6">
									  <div class="form-group">
										<label class="col-md-12">Date End * </label>
										<div class="col-md-12 input-group endDate">
											<input name="eDate" value="<?=$date_end?>" type="text" class="form-control" placeholder="dd/mm/yyyy" required>
											 </div>
										</div>
									</div>					
									
									
									<div class="col-sm-6">
									  <div class="form-group">
										<label class="col-md-12">Uses Per Coupon </label>
										<div class="col-md-12">
										  <input type="text" name="pCoupan" placeholder="Enter Uses Per Coupon " value="<?=$uses_total?>" class="form-control" required>
										</div>
									  </div>
									</div>
									<div class="col-sm-6">
									  <div class="form-group">
										<label class="col-md-12">Customer Group </label>
										<div class="col-md-12">
										 <select name="group[]" class="selectpicker" multiple title="Select Group" data-live-search="true" data-width="100%" >
											<?=$groupList?>
										  </select>
										</div>
									  </div>
									</div>
									<div class="col-sm-6">
									  <div class="form-group ">
										<label class="col-md-12">Product</label>
										<div class="col-md-12">
											<select name="product[]" class="selectpicker"  multiple title="Select Product" data-live-search="true" data-width="100%">
											<?=$productList?>
										  </select>
										</div>
									  </div>
									</div>
									<div class="col-sm-6">
									  <div class="form-group ">
										<label class="col-md-12">&nbsp;</label>
										<div class="col-md-12">
										  <div class="borderChexBx">
											<label>Status</label>
											<label class="switchS switchSCuStatus">
											<input name="status" value="1" class="switchS-input" type="checkbox" <?=$status == 1 ? 'checked' : ''?> />
											<span class="switchS-label" data-on="Active" data-off="Inactive"></span> <span class="switchS-handle"></span> </label>
										  </div>
										</div>
									  </div>
									</div>
								  </div>
								</div>
								<div class="col-sm-4">
								  <div class="form-group">
									<label class="col-md-12">Type </label>
									<div class="col-md-12">
									  <select class="selectpicker" name="type" title="Select Type" data-width="100%" required >
										<option value="1" <?=$type == 1 ? 'selected="selected"' : ''?> >Percentage</option>
										<option value="2" <?=$type == 2 ? 'selected="selected"' : ''?> >Fixed Amount</option>
									  </select>
									</div>
								  </div>
								  <div class="form-group">
									<label class="col-md-12">Date Start *</label>
									<div class="col-md-12 input-group startDate">
									  <input name="sDate" value="<?=$date_start?>" type="text" class="form-control" placeholder="dd/mm/yyyy" required>
											</span> 
									</div>
								  </div>
								  <div class="form-group">
									<label class="col-md-12">Uses Per Customer </label>
									<div class="col-md-12">
									  <input type="text" name="pCoustomer" placeholder="Enter Uses Per Customer" value="<?=$uses_customer?>" class="form-control" required>
									</div>
								  </div>
								  <div class="form-group">
									<label class="col-md-12">Parent</label>
									<div class="col-md-12 catPanLstng">
									  <?php
										$catHTML = '';
										$k = 0;
										foreach($parentArayList as $catOptionData){
											if($catOptionData){
												$catHTML .= '<select name="category[]" multiple onChange="getCategoryChieldCoupan(this, '.$k.')" class="selectpicker catLvl'.$k.'"  title="Select Parent Category" data-live-search="true" data-width="100%">';
												
										
												foreach($catOptionData as $catData){
													$isActive = '';
													if(isset($catSelctIDs[$k]['category_id'])){
														if($catSelctIDs[$k]['category_id'] == $catData->fld_category_id){
															$isActive = 'selected';
														}
													}
													$catHTML .= '<option '.$isActive.' value="'.$catData->category_id.'">'.$catData->name.'</option>';
												}
												$k++;
												$catHTML .= '</select>';
											}
										}
										echo $catHTML;
										?>
									</div>
								  </div>
								  <div class="col-sm-12">
									<div class="form-group">
									  <div class="col-md-12 text-right"> <a href="<?=base_url('dashboard/coupons')?>" class="btn btn-inverse waves-effect waves-light">Cancel</a>
										<button type="submit" class="btn btn-success waves-effect waves-light"><i class="fa fa-check"></i>
										<?=$typeLbl?>
										Coupon</button>
									  </div>
									</div>
								  </div>
								</div>
							  </div>
							</form>
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
	<!-- basic scripts -->
	<?php include('includes/scripts.php')?>
	<script src="<?=$iURL_assets?>admin/js/dropify/dist/js/dropify.min.js"></script>
	<script src="<?=$iURL_assets?>admin/js/custom.js"></script>
	<script>
		$( document ).ready( function () {
			$( '.dropify' ).dropify();
		} );
		
		$('.startDate input[name="sDate"]').daterangepicker({
			singleDatePicker: true,
			showDropdowns: true,
		});
		
		$('.endDate input[name="eDate"]').daterangepicker({
			singleDatePicker: true,
			showDropdowns: true,
		});
	</script>
</body>

</html>