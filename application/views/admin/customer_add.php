<?php
if ( $customerData ) {	
	$actionBtn = 'Update';
	$lblNew = 'Edit';
	$fname = $customerData[ 0 ]->fname;
	$lname = $customerData[ 0 ]->lname;
	$email = $customerData[ 0 ]->email;
	$mobile = $customerData[ 0 ]->mobile;
	$gender = $customerData[0]->gender;
	$avtar = $customerData[ 0 ]->avtar;
	$dob = $customerData[0]->dob ? date( 'd/m/Y', strtotime($customerData[0]->dob )) : '';
	$doa = $customerData[0]->doa ? date( 'd/m/Y', strtotime($customerData[0]->doa)) : '';
	$isEmail_verified = $customerData[ 0 ]->isEmail_verified;
	$isSMS_verified = $customerData[ 0 ]->isSMS_verified;
	$status = $customerData[ 0 ]->status;
} else {
	$actionBtn = 'Save';
	$lblNew = 'New';
	$status = $isSMS_verified = $isEmail_verified = $gender = 1;
	$fname = $lname = $email = $username = $mobile = $avtar = $dob = $doa = '';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<?php include('includes/commonfile.php');?>
	<title><?=$lblNew?> Customer | Admin</title>
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
							<a href="<?=admin_url()?>customers">Customers</a>
						</li>
						<li class="active">
							<a href="<?=admin_url()?>customers/<?=$lblNew?>"><?=$lblNew?> Customer</a>
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
								<div class="titleAre"><i class="fas fa-users"></i> <?=$lblNew?> Customer</div>
							</div>
							<div class="hr dotted hr-double"></div>						
							<form class="form-horizontal customerAddEdit">
								<input type="hidden" value="<?=$cid?>" name="id"/>
								<div class="row">
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-4">
												<div class="form-group">
													<label class="col-md-12">First Name *</label>
													<div class="col-md-12">
														<input type="text" value="<?=$fname?>" name="fname" class="form-control" placeholder="Enter First Name" required/>
													</div>
												</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group">
													<label class="col-md-12">Last Name</label>
													<div class="col-md-12">
														<input type="text" value="<?=$lname?>" name="lname" class="form-control" placeholder="Enter Last Name"/>
													</div>
												</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group">
													<label class="col-md-12">Group</label>
													<div class="col-md-12">
														<select class="selectpicker" name="group[]" title="Select Group" data-live-search="true" data-selected-text-format="count" data-size="5" multiple data-actions-box="true">
														<?php 
														foreach($groupAry as $groupData){
															if ($customerData){
																$isGroupSlct = search_in_array($groupSelectedAry, 'group_id', $groupData->id);
																$isGroup = $isGroupSlct  ? 'selected':'';
															}else{
																$isGroup = $groupData->isDefault == '1' ? 'selected':'';
															}
														?>
														<option <?=$isGroup?> value="<?=$groupData->id?>"><?=$groupData->name?></option>
														<?php } ?>
														</select>
													</div>
												</div>
											</div>											
											<div class="col-sm-4">
												<div class="form-group">
													<label class="col-md-12">Email e.g. "abc@host.com" *</label>
													<div class="col-md-12">
														<input type="email" value="<?=$email?>" onBlur="checkCustEmailAvlb(this.value,'email')" onKeyPress="$('.emailErr').hide();" name="email" class="form-control" placeholder="Enter Email" required>
														<span class="help-block emailErr"> This email address is not available </span>
														<span class="help-block emailValidaErr"> Please enter a valid email </span>
													</div>
												</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group">
													<label class="col-md-12">Mobile e.g. "9999999999" *</label>
													<div class="col-md-12">
														<input onBlur="checkCustEmailAvlb(this.value,'mobile')" onKeyPress="$('.usernameErr').hide();" type="text" name="mobile" value="<?=$mobile?>" placeholder="Enter Phone Number" data-mask="0000000000" class="form-control" required>
														
														<span class="help-block usernameErr"> This phone is not available </span>
													</div>
												</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group">
													<label class="col-md-12">Gender</label>
													<div class="col-md-12">
														<div class="radio">
															<label>
																<input name="gender" type="radio" value="1" <?=$gender=='M' ? 'checked' : ''?> class="ace" />
																<span class="lbl"> Male</span>
															</label>
															<label>
																<input name="gender" type="radio" class="ace" value="2" <?=$gender=='F' ? 'checked' : ''?> />
																<span class="lbl"> Female</span>
															</label>
														</div>
													</div>
												</div>
											</div>
											
											<div class="clearfix"></div>
											
											<div class="col-sm-4">
												<div class="form-group">
													<label class="col-md-12">Date of Birth</label>
													<div class="col-md-12">
														<div class="input-group">
															<input name="dob" class="form-control date-picker" value="<?=$dob?>"  type="text" placeholder="dd/mm/yyyy" data-date-format="dd/mm/yyyy" />
															<span class="input-group-addon">
																<i class="far fa-calendar-alt bigger-110"></i>
															</span>
														</div>
													</div>
												</div>
											</div>
											
											<div class="col-sm-4">
												<div class="form-group">
													<label class="col-md-12">Date of Birth</label>
													<div class="col-md-12">
														<div class="input-group">
															<input name="doa" value="<?=$doa?>" class="form-control date-picker" type="text" placeholder="dd/mm/yyyy" data-date-format="dd/mm/yyyy" />
															<span class="input-group-addon">
																<i class="far fa-calendar-alt bigger-110"></i>
															</span>
														</div>
													</div>
												</div>
											</div>
											
											<div class="col-sm-4">
												<div class="form-group">
													<label class="col-md-12">Password</label>
													<div class="col-md-12">
														<input type="password" name="password" class="form-control" placeholder="Enter Password">
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-sm-3">
										<label for="input-file-now-custom-1">Profile Image</label>
										<input name="avtar" type="file" id="input-file-now-custom-1" data-allowed-file-extensions="png jpg gif jpeg" class="dropify" data-max-file-size="2M" data-default-file="<?=$iURL_profile?><?=$avtar ? $avtar : 'user.png'?>"/>
									</div>
									
									<div class="col-sm-12">
										<div class="row">
											<div class="col-sm-3">
												<div class="form-group">
													<div class="col-md-12">
														<div class="borderChexBx">
															<label>Email Verified</label>
															<label class="switchS">
															  <input name="verifiedEmail" value="1" class="switchS-input" type="checkbox" <?=$isEmail_verified == '1' ? 'checked' : ''?> />
															  <span class="switchS-label" data-on="Yes" data-off="No"></span> <span class="switchS-handle"></span> </label>
														</div>
													</div>
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
													<div class="col-md-12">
														<div class="borderChexBx">
															<label>SMS Verified</label>
															<label class="switchS">
															  <input name="verifiedSMS" value="1" class="switchS-input" type="checkbox" <?=$isSMS_verified == '1' ? 'checked' : ''?> />
															  <span class="switchS-label" data-on="Yes" data-off="No"></span> <span class="switchS-handle"></span> </label>
														</div>
													</div>
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
													<div class="col-md-12">
														<div class="borderChexBx">
															<label>Status</label>
															<label class="switchS switchSCuStatus">
															  <input name="status" value="1" class="switchS-input" type="checkbox" <?=$status == '1' ? 'checked' : ''?> />
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
													<div class="col-md-12 text-right">
														<button type="button" class="btn btn-primary pull-left waves-effect waves-light mangAdresBtn <?=$customerData ? '' : 'hide_now'?>" onClick="manageAddressPan()"><i class="fa fa-map-marker"></i> Manage Address</button>
														<a href="<?=base_url('dashboard/customer')?>" class="btn btn-inverse waves-effect waves-light">Cancel</a>
														<button type="submit" class="btn btn-success waves-effect waves-light"><i class="fa fa-check"></i> <?=$actionBtn?> Customer</button>
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