<!DOCTYPE html>
<html lang="en">

<head>
	<?php include('includes/path.php');?>
	<title>500 | Error</title>
	<?php include('includes/styles.php')?>
	<link href="<?=$this->config->item('default_path')['assets']?>css/404.css" rel="stylesheet">
</head>

<body>
	<div class="row">
		<div class="centered text-center">
			<i class="fa fa-chain-broken text-warning fa-5"></i>
			<h1 class="page-header"> <label class="error404Head">500</label>  Something Went Wrong!!</h1>
			<p>  Sorry, the page you are looking for is not available. But we are working <i class="ace-icon fa fa-wrench icon-animated-wrench bigger-125"></i> on it!</p><br>
			<div class="center">
				<a href="javascript:history.back()" class="btn btn-grey"><i class="ace-icon fa fa-arrow-left"></i> Go Back </a>
				<a href="<?=base_url()?>" class="btn btn-primary"> <i class="ace-icon fas fa-home"></i> Home Page </a>			
			</div>
		</div>
	</div>
</body>

</html>
