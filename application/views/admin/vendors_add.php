<?php
if($vendorDisAry){
	$fname 			= $vendorDisAry[ 0 ]->fname;
	$lname 			= $vendorDisAry[ 0 ]->lname;
	$email 			= $vendorDisAry[ 0 ]->email;
	$phone	 		= $vendorDisAry[ 0 ]->mobile;
	$storeName 		= $vendorDisAry[ 0 ]->store_name;
	$avtar 			= $vendorDisAry[ 0 ]->avtar;
	$typeLbl		= 'Update';
	$linkTopBrod 	= $fname.' '.$lname;
	$lngk 			= 'edit';
	
	$isEmail_verified 	= $vendorDisAry[ 0 ]->isEmail_verified;
	$isSMS_verified 	= $vendorDisAry[ 0 ]->isSMS_verified;
	$status 			= $vendorDisAry[ 0 ]->status;
	
	$statList = $cityList = $areaList =  '';
	
}else{
	$avtar 			= 'user.png';
	$fname = $lname = $email = $username = $phone = $role = $statList = $cityList = $areaList = $storeName = '';
	$typeLbl 		= 'Create';
	$linkTopBrod 	= 'New Vendor';
	$lngk 			= 'add';
	
	$status = $isSMS_verified = $isEmail_verified =  1;

}

//echo '<pre>';print_r($stateIds);die;

	foreach($states as $stateData){
		if(in_array($stateData->sid,$stateIds)){
			$statList .= '<option selected="selected" value="'.$stateData->sid.'">'.$stateData->stateName.'</option>';
		}else{
			$statList .= '<option value="'.$stateData->sid.'">'.$stateData->stateName.'</option>';
		}
	}
//echo '<pre>';print_r($city);die;
	foreach($city as $data){
		if(in_array($data->cid,$cityIds)){
			$cityList .= '<option selected="selected" value="'.$data->cid.'">'.$data->cityName.'</option>';
		}else{
			$cityList .= '<option value="'.$data->cid.'">'.$data->cityName.'</option>';
		}
	}
	
	if($typeId == 1){
		foreach($areas as $data){
			if(in_array($data->aid,$arearIds)){
				$areaList .= '<option selected="selected" value="'.$data->aid.'">'.$data->areaName.'</option>';
			}else{
				$areaList .= '<option value="'.$data->aid.'">'.$data->areaName.'</option>';
			}
		}
	}else{
	
		foreach($areas as $data){
			if(in_array($data->aid,$arearIds)){
				$areaList .= '<option selected="selected" value="'.$data->aid.'">'.$data->pin.'</option>';
			}else{
				$areaList .= '<option value="'.$data->aid.'">'.$data->pin.'</option>';
			}
		}
	}


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php include('includes/commonfile.php');?>
	<title>Create Vendor | POCHI Admin</title>
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
							Others
						</li>
						<li>
							<a href="<?=base_url()?>admin/vendors">Manage Vendors</a>
						</li>
						<li class="active">
							<a href="<?=base_url()?>others/manage_users/<?=$lngk?>/<?=$vid?>"><?=$linkTopBrod?></a>
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
								<div class="titleAre"><i class="fas fa-box-open"></i> <?=$typeLbl?> Vendor</div>
							</div>
							<div class="hr dotted hr-double"></div>	
					 
						<form class="form-horizontal" id="editNewVendor">
						  <input type="hidden" value="<?=$vid?>" name="vid"/>
						  <div class="form-group row">
							<div class="col-sm-8">
							  <div class="row">
								<div class="col-sm-6">
								  <div class="form-group">
									<label class="col-md-12">First Name *</label>
									<div class="col-md-12">
									  <input type="text" value="<?=$fname?>" name="fname" class="form-control" placeholder="Enter First Name" required/>
									</div>
								  </div>
								</div>
								<div class="col-sm-6">
								  <div class="form-group">
									<label class="col-md-12">Last Name</label>
									<div class="col-md-12">
									  <input type="text" value="<?=$lname?>" name="lname" class="form-control" placeholder="Enter Last Name"/>
									</div>
								  </div>
								</div>
								<div class="col-sm-6">
								  <div class="form-group">
									<label class="col-md-12">Email e.g. "example@website.com" *</label>
									<div class="col-md-12">
									  <input type="email" value="<?=$email?>"  name="email" class="form-control validateEmail" placeholder="Email e.g. - example@website.com" required>
									   </div>
								  </div>
								</div>
								<div class="col-sm-6">
								  <div class="form-group">
									<label class="col-md-12">Mobile *</label>
									<div class="col-md-12">
									  <input type="text" name="mobile" value="<?=$phone?>" data-mask="999 999 9999" class="form-control phoneOnly" placeholder="Mobile" maxlength="11">
									</div>
								  </div>
								</div>
								<div class="col-sm-6">
								  <div class="form-group">
									<label class="col-md-12">Store Name *</label>
									<div class="col-md-12">
									  <input type="text" name="storeName" placeholder="Enter Store Name" value="<?=$storeName;?>" class="form-control" required>
									</div>
								  </div>
								</div>
								<div class="col-sm-6">
								  <div class="form-group">
									<label class="col-md-12">Location Type *</label>
									<div class="col-md-12">
									  <select class="selectpicker" name="ltype" id="locId" title="Select Type" data-width="100%" required onChange="showType(this.value)">
									  
										<option value="1" <?=$typeId==1 ? 'selected="selected"' : ''?> >Area</option>
										<option value="2" <?=$typeId==2 ? 'selected="selected"' : ''?>>Pincode</option>
									  </select>
									</div>
								  </div>
								</div>
								<div class="col-sm-6">
								  <div class="form-group listLvlStateData <?=$typeId ?'':'hide';?>">
									<label class="col-md-12">State List*</label>
									<div class="col-md-12">
									  <select class="selectpicker" multiple title="Select State" data-live-search="true" data-size="5" data-width="100%"  onChange="listCityState(this, 'city');">
										<?=$statList?>
									  </select>
									</div>
								  </div>
								</div>
								<div class="col-sm-6">
								
								  <div class="form-group listLvlCityData <?=$cityIds ?'':'hide';?>">
									<label class="col-md-12">City List*</label>
									<div class="col-md-12">
									<select class="selectpicker"  multiple title="Select City" data-live-search="true" data-size="5" data-width="100%"  onChange="listCityState(this,'area');">
										<?=$cityList?>
									  </select>
									</div>
								  </div>
								</div>
							  </div>
							</div>
							<div class="col-sm-4">
							  <div class="form-group">
								<label class="col-md-12">Profile Image</label>
								<div class="col-md-12 ">
								  <input name="avtar" type="file" id="input-file-now-custom-1" data-allowed-file-extensions="png jpg gif jpeg" class="dropify" data-max-file-size="2M" data-default-file="<?=$iURL_vendor?><?=$avtar ? $avtar : 'user.png'?>"/>
								</div>
							  </div>
							  <div class="form-group listLvlAreaData <?=$arearIds ?'':'hide';?>">
								<label class="col-md-12 areaLabel <?=$typeId==1 ?'':'hide';?>">Area List</label>
								<label class="col-md-12 pinLabel <?=$typeId==2 ?'':'hide';?>">PinCode List</label>
								<div class="col-md-12 ">
									<select class="selectpicker" name="area[]" multiple data-size="5" title="Select Area/Pincode" data-live-search="true" data-width="100%"  >
									<?=$areaList?>
								  </select>
								</div>
							  </div>
							</div>
							<div class="col-sm-12">
							  <div class="row">
								<div class="col-sm-4">
								  <div class="form-group">
									<div class="col-md-12">
									  <div class="borderChexBx">
										<label>Email Verified</label>
										<label class="switchS">
										<input name="verifiedEmail" value="1" class="switchS-input" type="checkbox" <?=$isEmail_verified == 1 ? 'checked' : ''?> />
										<span class="switchS-label" data-on="Yes" data-off="No"></span> <span class="switchS-handle"></span> </label>
									  </div>
									</div>
								  </div>
								</div>
								<div class="col-sm-4">
								  <div class="form-group">
									<div class="col-md-12">
									  <div class="borderChexBx">
										<label>SMS Verified</label>
										<label class="switchS">
										<input name="verifiedSMS" value="1" class="switchS-input" type="checkbox" <?=$isSMS_verified == 1 ? 'checked' : ''?> />
										<span class="switchS-label" data-on="Yes" data-off="No"></span> <span class="switchS-handle"></span> </label>
									  </div>
									</div>
								  </div>
								</div>
								<div class="col-sm-4">
								  <div class="form-group">
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
								<!--<div class="col-sm-4">
														  <div class="form-group">
															<div class="col-md-12">
															  <div class="borderChexBx">
																<label>Send Login Credentials</label>
																<label class="switchS">
																  <input name="credentials" value="1" class="switchS-input" type="checkbox" />
																  <span class="switchS-label" data-on="Yes" data-off="No"></span> <span class="switchS-handle"></span> </label>
															  </div>
															</div>
														  </div>
														</div>-->
								<div class="col-sm-12">
								  <div class="form-group">
									<div class="col-md-12 text-right"> <a href="<?=admin_url()?>vendors" class="btn btn-inverse waves-effect waves-light">Cancel</a>
									  <button type="submit" class="btn btn-success waves-effect waves-light"><i class="fa fa-check"></i><?=$typeLbl?>
									  </button>
									</div>
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
	</script>
</body>

</html>