<!DOCTYPE html>
<html lang="en">

<head>
	<?php include('includes/commonfile.php');?>
	<title><?=$table?> | POCHI Admin </title>
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
						<li>
							<a class="active" href="<?=base_url()?>process/sql/<?=$table?>"><?=$table?></a>
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
								<div class="titleAre"><i class="fas fa-database"></i> Table: <strong><?=$table?></strong></div>
								<div class="buttonAre">
									<button type="button" onClick="addEditTableData('<?=$table?>')" class="btn btn-primary"><i class="ace-icon fas fa-syringe bigger-110"></i> Run SQL Query</i></button>
									<button type="button" onClick="getTableRecord('<?=$table?>')" class="btn btn-primary"><i class="ace-icon fas fa-plus bigger-110"></i> Add Record</i></button>
								</div>
							</div>
							<div class="hr dotted hr-double"></div>
							<div class="table-responsive">
							<table class="table data_table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<?php
										foreach($column[0] as $key=>$value){
											echo '<th>'.$key.'</th>';
										}
										?>
										<th>Action</th>
									</tr>
								</thead>
							</table>
							</div>
						</div>
					</div>
					<!-- /.row -->
				</div>
				<!-- /.page-content -->
			</div>
		</div>
		<!-- /.main-content -->

		<!-- Modal:  Table Data  -  Modal -->
		<div id="addEditTableDataMod" data-backdrop="static" data-keyboard="false" class="modal fade" role="dialog">
			<div class="modal-dialog modal-lg">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><span class="acnlblNm"></span> <?=$table?></h4>
					</div>
					<form class="form-horizontal" id="editAddGroup" role="form">
						<input type="hidden" class="primaryKey" value="">
						<div class="modal-body">
							<table class="table table-bordered boxTablForm">
								<tbody> </tbody>
							</table>
						</div>
						<div class="modal-footer">
							<button  type="button" class="btn btn-sm btn-inverse" data-dismiss="modal"><span class="bigger-110">Close</span></button>
							<button type="submit" class="btn btn-sm btn-success"> <i class="ace-icon fas fa-save bigger-110"></i><span class="acnBtnNm"></span> Record</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<?php include('includes/footer.php')?>
	</div>
	<!-- /.main-container -->
	<?php include('includes/email_sms_template.php')?>
	<!-- basic scripts -->
	<?php include('includes/scripts.php')?>
	<script src="<?=$iURL_assets?>admin/js/custom.js"></script>
	<script>
		function filterRecord() {
			filterData = {
				"filter_table": '<?=$table?>',
			};
			ajaxPageTarget('data_table', 'database', 'table_data_list');
		}
		filterRecord();
		
		function getTableRecord(table,key, value){	
		var dataString = {
			table: table,
			key: key,
			value: value,
		};
		var htmlData, isRequired, isDefault, dataType, typeClass, maxLength, regExp, matches = ''
		$.ajax({
			url: admin_url + 'database/getTableRecord',
			dataType: 'json',
			type: 'POST',
			data: dataString,
			success: function(obj) {
				var i = 1;
				$.each(obj, function (column, data) {
					if(i == 1){					
						 htmlData += '<tr>';
					}
					isRequired = data.IS_NULLABLE == "NO" ? 'required' : '';
					isDefault = data.COLUMN_DEFAULT ? data.COLUMN_DEFAULT : '';
					
					if(data.COLUMN_KEY == 'PRI'){
						$('.primaryKey').val(data.COLUMN_NAME);	
					}				

					dataType = data.DATA_TYPE

					regExp = /\(([^)]+)\)/;
					matches = regExp.exec(data.COLUMN_TYPE);
					console.log(matches);
					if(matches){
						maxLength = matches[1];
					}
					
					if(dataType == 'int' || dataType == 'tinyint'){
						typeClass = 'numericOnly';						
					}else if(dataType == 'datetime'){
						maxLength = 20;
						typeClass = 'dateTimeOnly';					
					}else if(dataType == 'timestamp'){
						maxLength = 20;
						typeClass = 'currentDateTimeOnly';
					}
					
					if(isDefault == 'CURRENT_TIMESTAMP'){
						isDefault = moment().format('YYYY-MM-DD');
					}
					htmlData += '<th>'+data.COLUMN_NAME+'</th>';
					htmlData += '<td><input maxlength="'+maxLength+'" '+isRequired+' type="text" name="'+data.COLUMN_NAME+'" value="'+isDefault+'" class="form-control '+typeClass+'" /></td>';

					if(i == 0){
						htmlData += '</tr>';
						i = 4;
					}				
					i--;
				});
				$('.boxTablForm tbody').html(htmlData);
				$('.dateTimeOnly, .currentDateTimeOnly').datepicker({
					autoclose: true,
					format: 'yyyy-mm-dd'
				}).val();
				$("#addEditTableDataMod").modal();
			},
			error: function () {
				csrfError();
			}
		});

	}
	</script>
</body>

</html>