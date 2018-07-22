<!DOCTYPE html>
<html lang="en">

<head>
	<?php include('includes/commonfile.php');?>
	<title>Product Category | POCHI Admin </title>
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
							<a href="<?=admin_url()?>">Home</a>
						</li>
						<li>
							Manage Store
						</li>
						<li class="active">
							<a href="<?=admin_url()?>category">Product Category</a>
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
								<div class="titleAre"><i class="fas fa-box-open"></i> Product Category</div>
								<div class="buttonAre">
									<a href="<?=admin_url()?>category/add" class="btn btn-primary"><i class="ace-icon fas fa-plus"></i> Add Category</i></a>
								</div>
							</div>
							<div class="hr dotted hr-double"></div>
							<div class="filterPageare">
								<div class="filterPanL">
									<select data-width="fit" class="selectpicker bar_filter" title="Select Option" multiple>
									   <option value="top">Top Header</option>
									   <option value="left">Left Panel</option>
									</select>
								</div>
								<div class="filterPanL">
									<select data-width="fit" class="selectpicker status_filter" title="Select Status" multiple>
										<option value="1">Active</option>
										<option value="2">Inactive</option>
									</select>
								</div>
								<div class="filterPanL">
									<button type="button" title="Filter Record" onClick="filterCatList();" class="btn btn-warning fxFilBtn btn-sm"><i class="fa fa-filter"></i> &nbsp;Filter</button>
									<button type="button" title="Filter Record" onClick="location.reload();" class="btn btn-grey fxFilBtn btn-sm"><i class="fas fa-sync-alt"></i> &nbsp; Reset</button>
								</div>
								
								<div class="pull-right">
									<button type="button" class="btn btn-info expColBtn" data-action="expand-all"><i class="fa fa-expand"></i> Expand All</button>
									<input class="form-control searchTopBar form-cascade-control" placeholder="Search" type="text">
									<button type="button" onClick="storeCatSorting()" class="btn btn-danger updatIndOrd"><i class="fa fa-check" aria-hidden="true"></i> Update Changes</button>
								</div>
							</div>

							<div class="clearfix"></div>
							<div class="cf nestable-lists">
								<div class="dd" id="nestable">
									<?php print_r($categoryLst);?>
								</div>
							</div>
							<input type="hidden" id="nestable-output">
							<input type="hidden" id="id">
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
	<?php include('includes/scripts.php')?>
	<script src="<?=$iURL_adminAssts?>js/jquery.nestable.js"></script>
	<script src="<?=$iURL_adminAssts?>js/custom.js"></script>
	<script>
		function filterCatList() {
			var status = $( 'select.status_filter' ).val();
			var bar = $( 'select.bar_filter' ).val();
			var filterData = {
				"status": status,
				"bar": bar,
				"filter": '1'
			};
			$.post( admin_url+"category", filterData, function( data ) {
				$('#nestable').html(data);
			});
		}
		$( document ).ready( function () {
			var updateOutput = function ( e ) {
				var list = e.length ? e : $( e.target ),
					output = list.data( 'output' );
				if ( window.JSON ) {
					output.val( window.JSON.stringify( list.nestable( 'serialize' ) ) ); //, null, 2));
				} else {
					output.val( 'JSON browser support required for this demo.' );
				}
			};
			$('#nestable').nestable({
				group: 1
			}).on( 'change', updateOutput );
			$('.dd').nestable('collapseAll');
			updateOutput($('#nestable').data('output', $('#nestable-output')));
			$('.dd').on( 'change', function(){
				$('.updatIndOrd').show();
			});
		});
		$(document).keyup(function(e) {
			 if (e.keyCode == 27) {
				if($('#menu-id').html()){
					$('.searchTopBar').val('');
					inputSearchIndicLst();
				}
			}
		});

		$.extend($.expr[':'], {
		  'containsi': function(elem, i, match, array) {
			return (elem.textContent || elem.innerText || '').toLowerCase()
				.indexOf((match[3] || "").toLowerCase()) >= 0;
		  }
		});

		$('.searchTopBar').keyup(function() {
			inputSearchIndicLst();
		});

		function inputSearchIndicLst(){
			var query = $('.searchTopBar').val();
			if(query){
				$("div.disIndLs")
					.closest('.dd3-content').removeClass('filtrSearhFinl')
					.filter(':containsi("' + query + '")')
					.closest('.dd3-content').addClass('filtrSearhFinl');
				$( '.dd' ).nestable( 'expandAll' );
				$('.expColBtn').data( 'action', 'collapse-all' );
				$( '.expColBtn' ).html( '<i class="fa fa-compress"></i> Collapse All' );
			}else{
				$("div.disIndLs")
					.closest('.dd3-content').removeClass('filtrSearhFinl');
				$( '.dd' ).nestable( 'collapseAll' );
				$( '.expColBtn' ).data( 'action', 'expand-all' );
				$( '.expColBtn' ).html( '<i class="fa fa-expand"></i> Expand All' );
			}
			if($('.filtrSearhFinl:first').length) {
				$('html, body').animate({
				  scrollTop: $('.filtrSearhFinl:first').offset().top - 20
				}, 'noraml');
			}else{
				$('html, body').animate({
				  scrollTop: $('body').offset().top - 20
				}, 'noraml');
			}
		}
		$('.expColBtn').on('click', function () {
		var action = $( this ).data( 'action' );
		if ( action === 'expand-all' ) {
			$( '.dd' ).nestable( 'expandAll' );
			$( this ).data( 'action', 'collapse-all' );
			$( this ).html( '<i class="fa fa-compress"></i> Collapse All' );
		}
		if ( action === 'collapse-all' ) {
			$( '.dd' ).nestable( 'collapseAll' );
			$( this ).data( 'action', 'expand-all' );
			$( this ).html( '<i class="fa fa-expand"></i> Expand All' );
		}
	});
	</script>
</body>

</html>