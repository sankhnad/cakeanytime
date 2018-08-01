<!DOCTYPE html>
<html lang="en">
<head>
	<?php include('includes/commonfile.php');?>
	<title>Manage Database | POCHI Admin</title>
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
							<a href="<?=base_url()?>process/sql">Manage Database</a>
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
								<div class="titleAre"><i class="fas fa-database"></i> Manage Database</div>
								<div class="buttonAre">
									<button type="button" class="btn btn-primary" onClick="addCustomSQLQuery('all')"><i class="ace-icon fas fa-syringe bigger-110"></i> Add Custom Query</i></button>
								</div>
							</div>
							<div class="hr dotted hr-double"></div>

							<table class="table data_table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<th>Table Name</th>
										<th>Total Record</th>
										<th>Action</th>
									</tr>
								</thead>
							</table>
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


	<!-- basic scripts -->
	<?php include('includes/scripts.php')?>
	<script src="<?=$iURL_assets?>admin/js/custom.js"></script>
	<script>
		function filterRecord() {
			filterData = {
				//"filter_kyc": $( 'select.filter_kyc' ).val(),
				//"filter_data": $( 'input.filter_data' ).val(),
			};
			ajaxPageTarget('data_table', 'database', 'table_list' );

		}
		filterRecord();
	</script>
</body>
</html>