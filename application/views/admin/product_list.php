<!DOCTYPE html>
<html lang="en">

<head>
	<?php include('includes/commonfile.php');?>
	<title>Product List | Admin</title>
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
							<a href="<?=base_url()?>products">Products</a>
						</li>
						<li class="active">Products List</li>
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
								<div class="titleAre"><i class="fas fa-users"></i> Manage Products</div>
								<div class="buttonAre">
									<a href="javascript:;" data-toggle="modal" data-target="#addCustomr" class="btn btn-primary"><i class="ace-icon fas fa-user-plus bigger-110"></i> Add New Product</a>
								</div>
							</div>
							<div class="hr dotted hr-double"></div>

							<div class="filterPageare">
								<div class="filterPanL">
									<select class="selectpicker filter_type" title="Select Profile Type" data-live-search="true" data-width="fit" data-selected-text-format="count" data-size="5" multiple data-actions-box="true">
										<option value="I">Individual</option>
										<option value="C">Corporate</option>
									</select>
								</div>
								<div class="filterPanL">
									<select class="selectpicker filter_kyc" title="Select KYC Status" data-live-search="true" data-width="fit" data-selected-text-format="count" data-size="5" multiple data-actions-box="true">
										<option value="2">Pending</option>
										<option value="1">Verified</option>
										<option value="0">Rejected</option>
									</select>
								</div>
								<div class="filterPanL">
									<select class="selectpicker filter_status" title="Select Status" data-live-search="true" data-width="fit" data-selected-text-format="count" data-size="5" multiple data-actions-box="true">
										<option value="1">Active</option>
										<option value="0">Inactive</option>
									</select>
								</div>
								<div class="filterPanL" style="max-width: 20%;">
									<div class="input-group">
										<span class="input-group-addon">
											<i class="far fa-calendar-alt bigger-110"></i>
										</span>
									

										<input class="form-control filter_data" placeholder="Reg. Date Range" type="text"/>
									</div>
								</div>
								<div class="filterPanL">
									<button type="button" title="Filter Record" onClick="filterRecord();" class="btn btn-warning btn-sm"><i class="fa fa-filter"></i> &nbsp;Filter</button>
								</div>
							</div>

							<table class="table data_table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<th>POCHI ID</th>
										<th>Name</th>
										<th>Reg. Date</th>
										<th>KYC</th>
										<th>Status</th>
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

	<?php include('includes/email_sms_template.php')?>
	<!-- basic scripts -->
	<?php include('includes/scripts.php')?>
	<script src="<?=$iURL_assets?>admin/js/custom.js"></script>
	<script>
		ajaxPageTarget('data_table', 'customers', 'customers_lst');

		function filterRecord() {
			filterData = {
				"filter_kyc": $( 'select.filter_kyc' ).val(),
				"filter_status": $( 'select.filter_status' ).val(),
				"filter_type": $( 'select.filter_type' ).val(),
				"filter_data": $( 'input.filter_data' ).val(),
			};
			ajaxPageTarget( 'data_table', 'customers', 'customers_lst' );
		}
		$( '.summernote' ).summernote( {
			height: 200,
			codemirror: {
				theme: 'monokai'
			}
		} );

		$( '.filter_data' ).daterangepicker( {
				'applyClass': 'btn-sm btn-success',
				'cancelClass': 'btn-sm btn-info',
				'autoUpdateInput': false,
				locale: {
					applyLabel: 'Apply',
					cancelLabel: 'Clear'
				}
			} )
			.prev().on( ace.click_event, function () {
				$( this ).next().focus();
			} );
		$( '.filter_data' ).on( 'apply.daterangepicker', function ( ev, picker ) {
			$( this ).val( picker.startDate.format( 'MM/DD/YYYY' ) + ' - ' + picker.endDate.format( 'MM/DD/YYYY' ) );
		} );
		$( '.filter_data' ).on( 'cancel.daterangepicker', function ( ev, picker ) {
			$( this ).val( '' );
		} );
	</script>
</body>

</html>