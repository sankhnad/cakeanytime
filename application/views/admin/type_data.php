<?php
if ( $typeDisAry ) {
	$catName = $typeDisAry[ 0 ]->name;
	$url_slug = $typeDisAry[ 0 ]->url_slug;
	$img = $typeDisAry[ 0 ]->image;
	$icon = $typeDisAry[ 0 ]->icon;
	$isTop = $typeDisAry[ 0 ]->isTopBar;
	$isLeft = $typeDisAry[ 0 ]->isLeftBar;
	$sortOrder = $typeDisAry[ 0 ]->sort_order;
	$metaTDesc = $typeDisAry[ 0 ]->meta_description;
	$metaTKey = $typeDisAry[ 0 ]->meta_keyword;
	$description = $typeDisAry[ 0 ]->description;
	$isMobile = $typeDisAry[ 0 ]->mobile_display;
	$isStatus = $typeDisAry[ 0 ]->status;

	$typeLbl = 'Update';
	$linkTopBrod = $catName;
	$lngk = 'edit';



} else {
	$catName = $url_slug = $img = $icon = $isTop = $isLeft = $sortOrder = $metaTDesc = $metaTKey = $description = $isStatus = $sort = '';
	$isMobile = '1';

	$typeLbl = 'Create';
	$linkTopBrod = 'New Coupon';
	$lngk = 'add';
	$status = 1;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<?php include('includes/commonfile.php');?>
	<title><?=$typeLbl?> Category | POCHI Admin</title>
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
						<li  class="active">
							<a href="<?=admin_url()?>type">Type</a>
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
								<div class="titleAre"><i class="fas fa-box-open"></i> <?=$typeLbl?> Type</div>
							</div>
							<div class="hr dotted hr-double"></div>						
							<form class="form-horizontal" id="editNewType">
								<input type="hidden" value="<?=$eTID?>" name="tid"/>
								<div class="form-group row">
									<div class="col-sm-8">
										<div class="row">
											<div class="col-sm-6">
												<div class="form-group">
													<label class="col-md-12">Type Name &nbsp; <span class="required"></span></label>
													<div class="col-md-12">
														<input onBlur="generateURLSlug(this.value, 'type')" type="text" name="name" class="form-control" value="<?=$catName?>" placeholder="Enter Category Name" required/>
													</div>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label class="col-md-12">URL Slug</label>
													<div class="col-md-12">
														<input onBlur="generateURLSlug(this.value, 'slug')" onKeyUp="$('.slugErr').hide()" data-toggle="tooltip" title="Do not use spaces instead replace spaces with - and make sure the keyword is globally unique." value="<?=$url_slug?>" type="text" name="url_slug" class="form-control" placeholder="Enter Uniqe URL Slug"/>
														<span class="help-block slugErr"> This URL slug is not available </span>
													</div>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label class="col-md-12">Meta Tag Description</label>
													<div class="col-md-12">
														<textarea name="meta_desc" class="form-control"><?=$metaTDesc?></textarea>
													</div>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label class="col-md-12">Meta Tag Keywords</label>
													<div class="col-md-12">
														<textarea name="meta_keywords" class="form-control"><?=$metaTKey?></textarea>
													</div>
												</div>
											</div>
											<div class="col-sm-12">
												<div class="form-group">
													<label class="col-md-12">Description</label>
													<div class="col-md-12">
														<textarea name="desc" class="form-control"><?=$description?></textarea>
													</div>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<div class="col-md-12">
														<div class="borderChexBx" data-toggle="tooltip" title="Display in the top menu bar. Only works for the top parent categories.">
															<label>Top header</label>
															<label class="switchS">
																<input name="isTop" value="1" class="switchS-input" type="checkbox" <?=$isTop == '1' ? 'checked' : ''?> />
																<span class="switchS-label" data-on="Yes" data-off="No"></span>
																<span class="switchS-handle"></span> 
															</label>														
														</div>
													</div>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<div class="col-md-12">
														<div class="borderChexBx" data-toggle="tooltip" title="Display in the left menu panel. Only works for the top parent categories.">
															<label>Left Menu</label>
															<label class="switchS">
																<input name="isLeft" value="1" class="switchS-input" type="checkbox" <?=$isLeft == '1' ? 'checked' : ''?> />
																<span class="switchS-label" data-on="Yes" data-off="No"></span>
																<span class="switchS-handle"></span>
															</label>														
														</div>
													</div>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<div class="col-md-12">
														<div class="borderChexBx" data-toggle="tooltip" title="Display in the top menu bar. Only works for the top parent categories.">
															<label>Visible on mobile</label>
															<label class="switchS">
																<input name="isMobile" value="1" class="switchS-input" type="checkbox" <?=$isMobile == '1' ? 'checked' : ''?> />
																<span class="switchS-label" data-on="Yes" data-off="No"></span> <span class="switchS-handle"></span>
															</label>														
														</div>
													</div>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<div class="col-md-12">
														<div class="borderChexBx">
															<label>Status</label>
															<label class="switchS switchSCuStatus">
																<input name="isStatus" value="1" class="switchS-input" type="checkbox" <?=$isStatus == '1' ? 'checked' : ''?> />
																<span class="switchS-label" data-on="Active" data-off="Inactive"></span>
																<span class="switchS-handle"></span>
															</label>														
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
													<label class="col-md-12">Sort Number &nbsp;<span class="required"></span></label>
													<div class="col-md-12">
														<input type="text" name="sort" class="form-control" value="<?=$sort?>" placeholder="Enter Sort Number" required/>
													</div>
										</div>
										<div class="form-group dropyCHet col-sm-12">
											<label>Profile Image</label>
											<input name="img" type="file" data-allowed-file-extensions="png jpg gif jpeg" class="dropify" data-max-file-size="2M" data-default-file="<?=$iURL_type?><?=$img ? $img : 'default.jpg'?>"/>
										</div>

										<div class="form-group dropyCHet col-sm-12">
											<label>Icon Image</label>
											<input name="icon" type="file" data-allowed-file-extensions="png jpg gif jpeg" class="dropify" data-max-file-size="2M" data-default-file="<?=$iURL_type?><?=$icon ? $icon : 'default.jpg'?>"/>
										</div>
									</div>

									<div class="col-sm-12">
										<div class="col-sm-12">
											<div class="form-group">
												<div class="col-md-12 text-right">
													<a href="<?=base_url()?>admin/type" class="btn btn-inverse waves-effect waves-light">Cancel</a>
													<button type="submit" class="btn btn-success waves-effect waves-light"><i class="fa fa-check"></i> <?=$typeLbl?> Type</button>
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