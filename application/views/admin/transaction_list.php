<?php
$accountInfoAry;
$custInfoAry;
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<?php include('includes/commonfile.php');?>
	<title>Transaction Report | POCHI Admin </title>	
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
							<a href="<?=base_url()?>account_statement">Account Statement</a>
						</li>
						<li class="active">Transaction Report</li>
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
								<div class="titleAre"><i class="far fa-copy"></i> Transaction Report</div>
								<div class="buttonAre">
									<!--<button class="btn btn-xs btn-primary"><i class="ace-icon fas fa-user-plus bigger-110"></i> Add New Customer</i></button>-->
								</div>
							</div>
							<div class="hr dotted hr-double"></div>

							<div class="filterPageare">
								<input type="hidden" value="<?=$eAccount;?>" class="filter_account" />
								<div class="filterPanL" style="max-width: 20%;">
									<div class="input-group">
										<span class="input-group-addon">
											<i class="far fa-calendar-alt bigger-110"></i>
										</span>
										<input class="form-control filter_date" placeholder="Date Range" type="text" />
									</div>
								</div>
								<div class="filterPanL">
									<button type="button" title="Filter Record" onClick="filterRecord();" class="btn btn-warning btn-sm"><i class="fa fa-filter"></i> &nbsp;Filter</button>
								</div>
							</div>

							<table class="table data_table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<th data-tooltip="tooltip" title="Transaction Date and Time">Dated / Time</th>
										<th data-tooltip="tooltip" title="Transaction Number">Transaction No.</th>
										<th data-tooltip="tooltip" title="Transaction Type">Type</th>
										<th data-tooltip="tooltip" title="Reference Number">Channel</th>
										<th data-tooltip="tooltip" title="Payment Mode">Mode</th>
										<th data-tooltip="tooltip" title="Available O Balance">Dst Account</th>
										<th data-tooltip="tooltip" title="Transaction Total">Amount</th>
										<th data-tooltip="tooltip" title="Available C Balance">Charges</th>
										<th data-tooltip="tooltip" title="Current O Balance">Reference No.</th>
										<th data-tooltip="tooltip" title="Current C Balance">Status</th>
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
	<script>$('#sidebar-collapse').click()</script>
	<script src="<?=$iURL_assets?>admin/js/custom.js"></script>
	<script>
		
		function filterRecord() {
			filterData = {
				"filter_account": $( 'input.filter_account' ).val(),
				"filter_date": $( 'input.filter_date' ).val(),
			};
			ajaxPageTarget('data_table', 'accounts', 'transaction_lst' );
		}
		filterRecord();
		$('.filter_date').daterangepicker({
			'applyClass' : 'btn-sm btn-success',
			'cancelClass' : 'btn-sm btn-info',
			'autoUpdateInput':false,
			locale: {
				applyLabel: 'Apply',
				cancelLabel: 'Clear'
			}
		})
		.prev().on(ace.click_event, function(){
			$(this).next().focus();
		});
		$('.filter_date').on('apply.daterangepicker', function(ev, picker) {
		  $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
		});
		$('.filter_date').on('cancel.daterangepicker', function(ev, picker) {
		  $(this).val('');
		});
	</script>
</body>

</html>