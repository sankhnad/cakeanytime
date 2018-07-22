<!DOCTYPE html>
<html lang="en">

<head>
	<?php include('includes/commonfile.php');?>
	<title>Contact Us Message List | POCHI Admin
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
						<li>
							<i class="ace-icon fa fa-home home-icon"></i>
							<a href="<?=base_url()?>">Home</a>
						</li>
						<li class="active">
							<a href="<?=base_url()?>contact/message">Support</a>
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
								<div class="titleAre"><i class="far fa-comments"></i> Manage Message</div>
								<div class="buttonAre">
									<button type="button" class="btn btnmarkAll <?=$ispendingContact ? '':'hide_now'?> btn-gray" onClick="markNotiasReadUnread(this,'all')"><i class="ace-icon far fa-envelope-open bigger-110"></i> Mark all as read</i></button>								
								</div>
							</div>
							<div class="hr dotted hr-double"></div>

							<div class="filterPageare">
								<div class="filterPanL">
									<select class="selectpicker filter_isRead" title="Select Status" data-live-search="true" data-width="fit" data-selected-text-format="count" data-size="5" multiple data-actions-box="true">
										<option value="1">Read</option>
										<option value="2">Unread</option>
									</select>
								</div>
								<div class="filterPanL" style="max-width: 20%;">
									<div class="input-group">
										<span class="input-group-addon">
											<i class="far fa-calendar-alt bigger-110"></i>
										</span>
										<input class="form-control filter_data" placeholder="Reg. Date Range" type="text" />
									</div>
								</div>
								<div class="filterPanL">
									<button type="button" title="Filter Record" onClick="filterRecord();" class="btn btn-warning btn-sm"><i class="fa fa-filter"></i> &nbsp;Filter</button>
								</div>
							</div>

							<table class="table data_table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<th>Email</th>
										<th>Phone</th>
										<th>Subject / Message</th>
										<th>IP Address</th>
										<th>Dated On</th>
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
	
	<!-- model -->
	<div id="contactQuickView" class="modal fade" role="dialog">
		<div class="modal-dialog modal-md">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Quick View</h4>
				</div>
				<form class="form-horizontal" id="adminUpdatePas" role="form">
					<div class="modal-body">
						<div class="text-center"><img width="20%" class="qUAAvtar" src="" /></div>
						<table class="table table-bordered bxCnWordBrek">
							<tbody>
								<tr class="qEmail">
									<th width="40%">Email</th>
									<td><span></span></td>
								</tr>
								<tr class="qPhone">
									<th>Phone</th>
									<td><span></span></td>
								</tr>								
								<tr class="qIp">
									<th>IP Address</th>
									<td><span></span></td>
								</tr>
								<tr class="qCreated">
									<th>Dated On</th>
									<td><span></span></td>
								</tr>
								<tr>
									<td colspan="2">
										<table width="100%">
											<tr>
												<td style="overflow-wrap: break-word; word-break: break-all" data-tooltip="tooltip" title="Subject" class="qSubCon"></td>
											</tr>
											<tr>
												<td style="overflow-wrap: break-word; word-break: break-all"  data-tooltip="tooltip" title="Message" class="qMsgCon"></td>
											</tr>
										</table>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-sm btn-inverse" data-dismiss="modal"><span class="bigger-110">Close</span></button>
						<a href="" class="btn btn-sm btn-primary replyModb"> <i class="ace-icon fas fa-pencil-alt bigger-110"></i> <span class="bigger-110"> Reply</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- basic scripts -->
	<?php include('includes/scripts.php')?>
	<script src="<?=$iURL_assets?>admin/js/custom.js"></script>
	<script>
		ajaxPageTarget('data_table', 'contact', 'contact_lst' );
		function filterRecord() {
			filterData = {
				"filter_isRead": $( 'select.filter_isRead' ).val(),
				"filter_data": $( 'input.filter_data' ).val(),
			};
			ajaxPageTarget('data_table', 'contact', 'contact_lst' );
		}
		
		$('.filter_data').daterangepicker({
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
		$('.filter_data').on('apply.daterangepicker', function(ev, picker) {
		  $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
		});
		$('.filter_data').on('cancel.daterangepicker', function(ev, picker) {
		  $(this).val('');
		});
	</script>
	<style>
		.data_table td:first-child {
		  white-space: nowrap;
		}
		#adminUpdatePas * {
		  overflow-wrap: break-word;
		}
	</style>
</body>

</html>