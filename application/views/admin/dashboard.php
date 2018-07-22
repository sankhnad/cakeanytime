<!DOCTYPE html>
<html lang="en">
<head>
	<?php include('includes/commonfile.php');?>
	<title>Dashboard | POCHI Admin
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
						<div class="space-6"></div>
						<div class="col-sm-12 infobox-container">
							<div class="infobox infobox-green">
								<a href="<?=base_url()?>customers">
									<div class="infobox-icon">
										<i class="ace-icon fas fa-users"></i>
									</div>
									<div class="infobox-data">
										<span class="infobox-data-number"><?=$totalCustomer?></span>
										<div class="infobox-content">Total Customers</div>
									</div>
								</a>
							</div>
							<div class="infobox infobox-red">
								<a href="<?=base_url()?>customers/kyc">
									<div class="infobox-icon">
										<i class="ace-icon fas fa-id-badge"></i>
									</div>
									<div class="infobox-data">
										<span class="infobox-data-number"><?=$totalPendingKyc?></span>
										<div class="infobox-content">Pending KYC</div>
									</div>
								</a>
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
	<!-- /.main-container -->
	
	<!-- basic scripts -->
	<?php include('includes/scripts.php')?>
	<script src="<?=$iURL_assets?>admin/js/custom.js"></script>
</body>
</html>