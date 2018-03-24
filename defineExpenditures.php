<?php
include('authentication.php');
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Define Expenditure Types</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="default.css" rel="stylesheet" type="text/css" media="screen" />
<!-- Beginning of compulsory code below -->

<link href="menu/css/dropdown/dropdown.css" media="screen" rel="stylesheet" type="text/css" />
<link href="menu/css/dropdown/themes/mtv.com/default.ultimate.css" media="screen" rel="stylesheet" type="text/css" />

<!--[if lt IE 7]>
<script type="text/javascript" src="menu/jquery.js"></script>
<script type="text/javascript" src="menu/jquery.dropdown.js"></script>
<![endif]-->

<!-- / END -->
<link rel="stylesheet" href="zebra/public/css/zebra_form.css">
        <script src="zebra/jquery.js"></script>
        <script src="zebra/public/javascript/zebra_form.js"></script>
</head>
<body style="background-color:white;">
<!-- start header -->
<div id="logo">
		<?php include ("logo.php"); ?>
</div>

<div id="menu">
<?php
include ("includes/menu.php");
?>
</div>
<!-- end header -->
<!-- start page -->
<div id="page">
	<!-- start content -->
	<div id="content">
	<center>
			<?php		
			
		require 'zebra/Zebra_Form.php';
function displayForm(){
	$form=new zebra_form("form");
	$form->add("label","label_type","type","Aina Ya Matumizi");
	$obj= & $form->add("text","type");
	$obj->set_rule(array(
	    'required'=>  array('error','Weka Aina Ya Matumizi'),

	    		    ));	

	$form->add("submit","save","Sajili Aina Ya Matumizi");
	return $form;
}

$form = displayForm();

if ($form->validate())
{
if(mysql_query("insert into expenditures (type) values ('$_POST[type]')") or die (mysql_error())){
	echo "<center><b>Aina Ya Matumizi Imesajiliwa Kikamilifu</b></center>";
	$form = displayForm();
}
else
echo "<center><b>Kumetokea Tatizo Wakati Wakusajili Aina Ya Matumizi,Rudia Tena</b></center>";
}
$form->render("*horizontal");
			?>
				</center>
		</div>
	<!-- end content -->
	<!-- start sidebars -->
	
	
	<!-- end sidebars -->
	<div style="clear: both;">&nbsp;</div>
</div>
<!-- end page -->
<?php
include("footer.html");
?>
</body>
</html>
