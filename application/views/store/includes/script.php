<!-- JavaScripts --> 
<script src="<?=$iURL_storeAssts?>js/vendors/jquery-3.2.1.min.js"></script>
<script src="<?=$iURL_storeAssts?>js/vendors/sweetalert2/dist/sweetalert2.min.js"></script>
<script src="<?=$iURL_storeAssts?>js/vendors/wow.min.js"></script>
<script src="<?=$iURL_storeAssts?>js/vendors/bootstrap.min.js"></script>
<script src="<?=$iURL_storeAssts?>js/vendors/own-menu.js"></script>
<script src="<?=$iURL_storeAssts?>js/vendors/jquery.sticky.js"></script>
<script src="<?=$iURL_storeAssts?>js/vendors/owl.carousel.min.js"></script>

<!-- SLIDER REVOLUTION 4.x SCRIPTS  --> 
<script type="text/javascript" src="<?=$iURL_storeAssts?>rs-plugin/js/jquery.tp.t.min.js"></script>
<script type="text/javascript" src="<?=$iURL_storeAssts?>rs-plugin/js/jquery.tp.min.js"></script>
<script type="text/javascript" src="<?=$iURL_storeAssts?>js/main.js"></script>
<script>
<?php
if(!CITY){
?>
	$( document ).ready(function() {
		$('#changeCity').modal('show');
		$('#wrap').addClass();
	});
	
<?php } ?>
</script>