<?php
include('authentication.php');
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Define Item</title>
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
$form->add("label","label_name","bname","Jina La Tawi");
$obj= & $form->add("text","bname");
$obj->set_rule(array(
    'required'=>  array('error','Weka Jina La Tawi'),

    		    ));

$form->add("label","label_type","type","Aina Ya Tawi");
$obj= & $form->add("select","type");
$obj->add_options(array(
												    'hq'=>'Makao Makuu',
												    'branch'=>'Tawi',
												));
$obj->set_rule(array(
    'required'=>  array('error','Chagua aina ya tawi'),

    		    ));
    		    
$form->add("label","label_location","location","Maeneo Tawi Lilipo");
$obj= & $form->add("text","location");
$obj->set_rule(array(
    'required'=>  array('error','Weka Eneo La Tawi'),

    		    ));    		      		    
$form->add("submit","save","Sajili Tawi");
return $form;
		}

$form = displayForm();

if ($form->validate())
{
	$check1 = mysql_query("select id from branches where type='hq'");
	$check2 = mysql_query("select id from branches where name='$_POST[bname]'");
	if(mysql_num_rows($check1)>0 and $_POST["type"] == "hq") {
		echo "<center><b><font style='color:red'>Huruhusiwi kusajili tawi zaidi ya moja ambalo ni aina ya Makao Makuu</font></b></center>";
	}
	else if(mysql_num_rows($check2)>0) {
		echo "<center><b><font style='color:red'>Tawi lenye jina $_POST[bname] tayari limesajiliwa</font></b></center>";
	}
	else {
		if(mysql_query("insert into branches (name,type,location) values ('$_POST[bname]','$_POST[type]','$_POST[location]')") or die (mysql_error())){
			echo "<center><b>Tawi Limesajiliwa Kikamilifu</b></center>";
			$form = displayForm();
		}
		else
		echo "<center><b><font style='color:red'>Kumetokea Tatizo Wakati Wakusajili Tawi,Rudia Tena Tafadhali</font></b></center>";
	}
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
<div id="footer">
	<p>&copy;2012 All Rights Reserved. &nbsp;&bull;&nbsp; Developed by Ally Shaban
</div>
</body>
</html>
