<?php
$message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
<title>Full Screen</title>
<style>
div, p, a, li, td {
	-webkit-text-size-adjust: none;
}
* {
 -webkit-font-smoothing:;
	-moz-osx-font-smoothing: grayscale;
}
.ReadMsgBody {
	width: 100%;
	background-color: #ffffff;
}
.ExternalClass {
	width: 100%;
	background-color: #ffffff;
}
body {
	width: 100%;
	height: 100%;
	background-color: #ffffff;
	margin: 0;
	padding: 0;
 -webkit-font-smoothing:;
}
html {
	width: 100%;
	background-color: #ffffff;
}
p {
	padding: 0!important;
	margin-top: 0!important;
	margin-right: 0!important;
	margin-bottom: 0!important;
	margin-left: 0!important;
}
.hover:hover {
	opacity: 0.85;
	filter: alpha(opacity=85);
}

@media only screen and (max-width: 479px) {
body {
	width: auto!important;
}
table[class=full] {
	width: 100%!important;
	clear: both;
}
table[class=mobile] {
	width: 100%!important;
	padding-left: 30px;
	padding-right: 30px;
	clear: both;
}
table[class=fullCenter] {
	width: 100%!important;
	text-align: center!important;
	clear: both;
}
td[class=fullCenter] {
	width: 100%!important;
	text-align: center!important;
	clear: both;
}
*[class=erase] {
	display: none;
}
*[class=buttonScale] {
	float: none!important;
	text-align: center!important;
	display: inline-block!important;
	clear: both;
}
.image400 img {
	width: 100%!important;
	height: auto;
}
}
body {
	background: none !important;
}
</style>
</head>
<body marginwidth="0" marginheight="0" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0; width: 100%; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%;" offset="0" topmargin="0" leftmargin="0">
<table class="mobile" width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
  <tr>
    <td width="100%" align="center" height="100"><!-- Space -->
      
      <table class="full" object="drag-module-small" width="400" cellspacing="0" cellpadding="0" border="0" align="center">
        <tr>
          <td width="100%" height="50"></td>
        </tr>
      </table>
      
      <!-- End Space --> 
      <!-- Logo -->
      
      <table class="fullCenter" object="drag-module-small" cellspacing="0" cellpadding="0" border="0" align="center">
        <tr>
          <td style="width:80px; height:auto;" width="100%"><a href="'.base_url().'" style="text-decoration: none;"> <img src="'.$logoPath.'" alt="" class="hover" width="150" border="0"> </a></td>
        </tr>
      </table>
      
      <!-- End Logo --> 
      <!-- Space -->
      
      <table class="full" object="drag-module-small" width="400" cellspacing="0" cellpadding="0" border="0" align="center">
        <tr>
          <td width="100%" height="5"></td>
        </tr>
      </table>
      
      <!-- End Space --> 
      <!-- Shadow -->
      
      '.$msgText.'
      
      <!-- End Shadow --> 
      <!-- CopyRight -->
      
      <table class="full" object="drag-module-small" width="352" cellspacing="0" cellpadding="0" border="0" align="center">
        <tr>
          <td style="font-size: 1px; line-height: 1px;" width="100%" height="25">&nbsp;</td>
        </tr>
        <tr>
          <td style="text-align: center; font-family: \'Lato\', Helvetica, Arial, sans-serif; color: rgb(165, 168, 174); font-size: 12px; font-weight: 400; line-height: 18px;" class="fullCenter" width="100%" valign="middle"><i>By '.SITE_NAME.': Admin Portal</i> <br>
            Copyright '.SITE_NAME.' '.date('Y').' </td>
        </tr>
      </table>
      <table class="full" object="drag-module-small" width="352" cellspacing="0" cellpadding="0" border="0" align="center">
        <tr>
          <td style="font-size: 1px; line-height: 1px;" width="100%" height="60">&nbsp;</td>
        </tr>
      </table>
      
      <!-- End CopyRight --></td>
  </tr>
</table>
</body>
</html>';
?>
