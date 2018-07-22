<!DOCTYPE html>
<html lang="en">

<head>
	<?php include('includes/commonfile.php');?>
	<title>My Profile | POCHI Admin
	</title>
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
							Settings
						</li>
						<li class="active"><a href="<?=base_url()?>profile">Manage Profile</a></li>
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
							<div class="space-4"></div>
							<div class="user-profile row">
								<div class="col-xs-12 col-sm-3 center">
									<div>
										<input name="avtar" type="file" data-allowed-file-extensions="png jpg gif jpeg" class="dropify previewPrf hide_now" data-max-file-size="2M" data-default-file="<?=$iURL_profile?><?=$adminData[0]->avtar ? :'user.png'?>"/>
									</div>
									<div class="profile-contact-info">
										<div class="userRoalPanlM">
											Update Profile Image
										</div>
									</div>
								</div>
								<div class="col-sm-9">
									<div class="profile-user-info profile-user-info-striped">
										<div class="profile-info-row">
											<div class="profile-info-name"> Name </div>
											<div class="profile-info-value">
												<?=$adminData[0]->fname?>
												<?=$adminData[0]->lname?>
											</div>
										</div>
										<div class="profile-info-row">
											<div class="profile-info-name"> Username </div>
											<div class="profile-info-value">
												<?=$adminData[0]->username?>
											</div>
										</div>
										<div class="profile-info-row">
											<div class="profile-info-name"> Email </div>
											<div class="profile-info-value">
												<?=$adminData[0]->email?>
											</div>
										</div>
										<div class="profile-info-row">
											<div class="profile-info-name"> Joined </div>
											<div class="profile-info-value">
												<?=date('jS M Y | h:i A',strtotime($adminData[0]->created_date))?>
											</div>
										</div>
										<div class="profile-info-row">
											<div class="profile-info-name"> Last Online </div>
											<div class="profile-info-value">
												<?=lastLogin(AID);?>
											</div>
										</div>
										<div class="profile-info-row">
											<div class="profile-info-name"> Your Role </div>
											<div class="profile-info-value">
												<strong><?php
													if($adminData[0]->role == '1'){
														echo 'Super User';
													}else if($adminData[0]->role == '2'){
														echo 'Administrator';
													}else if($adminData[0]->role == '3'){
														echo 'Accountant';
													}
												?></strong>
											</div>
										</div>
									</div>
									<div class="space-6"></div>
									<div class="center">									
										<button type="button" data-toggle="modal" data-target="#updateUserMod" class="btn btn-white btn-primary btn-bold">
											<i class="ace-icon far fa-edit bigger-120 blue"></i> Edit Profile
										</button>
										<button type="button" data-toggle="modal" data-target="#changePassMod" class="btn btn-white btn-warning btn-bold">
											<i class="ace-icon fas fa-key bigger-120 orange"></i> Change Password
										</button>									
									</div>
								</div>
							</div>
							<!-- PAGE CONTENT ENDS -->
						</div>
						<!-- /.col -->
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
	<div id="updateUserMod" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Update Profile</h4>
				</div>
				<form class="form-horizontal" id="adminProfile" role="form">
					<input type="hidden" name="aid" value="<?=eAID?>">
					<div class="modal-body">
						<table class="table table-bordered">
							<tbody>
								<tr>
									<th class="text-right">First Name</th>
									<td>
										<input type="text" name="fname" value="<?=$adminData[0]->fname?>" class="form-control" placeholder="Enter last name" required>
									</td>
								</tr>
								<tr>
									<th class="text-right">Last Name</th>
									<td>
										<input type="text" name="lname" value="<?=$adminData[0]->lname?>" class="form-control" placeholder="Enter last name">
									</td>
								</tr>								
								<tr>
									<th class="text-right">Email</th>
									<td>
										<input type="email" onKeyPress="$('.eEror').hide();" onBlur="checkUserEmailAvlb(this.value, 'email')" name="email" value="<?=$adminData[0]->email?>" class="form-control validateEmail" placeholder="Enter email" required>
										<span class="text-danger hide_now eEror">This email address is not available</span>
										<span class="emailErrorMsg">Email is not formatted properly</span>
									</td>
								</tr>
								<tr>
									<th class="text-right">Username</th>
									<td>
										<input type="text" onKeyPress="$('.uEror').hide();" onBlur="checkUserEmailAvlb(this.value, 'username')" name="username" value="<?=$adminData[0]->username?>" class="form-control" placeholder="Enter username" required>
										<span class="text-danger hide_now uEror">This username is not available</span>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-sm btn-inverse" data-dismiss="modal"><span class="bigger-110">Close</span></button>
						<button type="submit" class="btn btn-sm btn-success"> <i class="ace-icon fas fa-save bigger-110"></i> <span class="bigger-110 no-text-shadow">Update</span>
					</div>
				</form>
			</div>
		</div>
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