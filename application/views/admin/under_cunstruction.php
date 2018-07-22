<!DOCTYPE html>
<html lang="en">

<head>
	<?php include('includes/commonfile.php');?>
	<title>Under Construction | POCHI Admin
	</title>
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
						<li class="active">
							<i class="ace-icon fas fa-tachometer-alt home-icon"></i>
							<a href="<?=base_url()?>">Dashboard</a>
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
							<!-- PAGE CONTENT BEGINS -->

							<div class="error-container">
								<div class="well">
									<h1 class="grey lighter smaller">
											<span class="blue bigger-125"><i class="ace-icon fas fa-exclamation-triangle"></i></span>
											Under Construction
										</h1>
									<hr/>
									<h3 class="lighter smaller">
											We are working
											<i class="ace-icon fa fa-wrench icon-animated-wrench bigger-125"></i>
											on it!
										</h3>

									<div class="space"></div>

									<div>
										<h4 class="lighter smaller">Meanwhile, try one of the following:</h4>

										<ul class="list-unstyled spaced inline bigger-110 margin-15">
											<li>
												<a href="<?=base_url()?>customers"><i class="ace-icon far fa-hand-point-right blue"></i> Customer List</a>
											</li>
											<li>
												<a href="<?=base_url()?>others/manage_users/add"><i class="ace-icon far fa-hand-point-right blue"></i> Add New User</a>
											</li>
											<li>
												<a href="<?=base_url()?>profile"><i class="ace-icon far fa-hand-point-right blue"></i> Manage Profile</a>
											</li>
										</ul>
									</div>

									<hr/>
									<div class="space"></div>
									<div class="center">
										<a href="javascript:history.back()" class="btn btn-grey">
											<i class="ace-icon fa fa-arrow-left"></i>
											Go Back
										</a>
										<a href="<?=base_url()?>" class="btn btn-primary">
											<i class="ace-icon fa fa-tachometer"></i>
											Dashboard
										</a>
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

	<!-- basic scripts -->
	<?php include('includes/scripts.php')?>
	<script src="<?=$iURL_assets?>admin/js/custom.js"></script>
</body>

</html>