<?php
include('authentication.php');
exec("mysql -uhil -phil haneinInvestment < customers.sql");
mysql_query("ALTER TABLE  `sales` ADD  `customer_id` INT NOT NULL AFTER  `itemId`");
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Add User</title>
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
		function displayForm() {
			$form=new zebra_form("form");
			$form->add("label","label_fname","fname","Jina La Kwanza");
			$obj= & $form->add("text","fname");
			$obj->set_rule(array(
			    'required'=>  array('error','Weka Jina La Kwanza'),

			    		    )); 

			$form->add("label","label_mname","mname","Jina La Kati");
			$obj= & $form->add("text","mname");

			$form->add("label","label_sname","sname","Jina La Mwisho");
			$obj= & $form->add("text","sname");
			$obj->set_rule(array(
			    'required'=>  array('error','Weka Jina La Mwisho'),

			    		    ));

			$form->add("label","label_uname","uname","Username");
			$obj= & $form->add("text","uname");
			$obj->set_rule(array(
			    'required'=>  array('error','Weka Username'),

			    		    ));
			$form->add("label","label_role","role","Role");
			$obj= & $form->add("select","role");
			$array = array("admin" => "Admin","sales" => "Sales","data_manager" => "Data Manager");
			$obj->add_options($array);
                        $obj->set_rule(array(
                            'required'=>  array('error','Chagua role'),

                                            ));

			$form->add("label","label_branch","branch","Aina Ya Tawi");
			$obj= & $form->add("select","branch");

			$branches = mysql_query("select * from branches") or die(mysql_error());

			$array = array();
			while($row=mysql_fetch_array($branches)) {
				$array[$row["id"]] = $row["name"];
			}
			$obj->add_options($array);
			$obj->set_rule(array(
			    'required'=>  array('error','Chagua aina ya tawi'),

			    		    ));

			$form->add("label","label_passwd","passwd","Password");
			$obj= & $form->add("password","passwd");
			$obj->set_rule(array(
			    'required'=>  array('error','Weka Password'),

			    		    ));

			$form->add("submit","save","Sajili Mteja");
			return $form;
		}

$form = displayForm();
if ($form->validate())
{
	$passwd=md5($_REQUEST["passwd"]);
if (mysql_query("insert into users (fname,lname,mname,passwd,uname,branch,role) values ('$_REQUEST[fname]','$_REQUEST[sname]','$_REQUEST[mname]','$passwd','$_REQUEST[uname]','$_REQUEST[branch]','$_REQUEST[role]')")){
	echo "<center><b>Mtumiaji kasajiliwa kikamilifu</b></center>";
	$form = displayForm();
}
else {
	echo "<center><b>Kumetokea Tatizo Wakati Wakusajili Mtumiaji</b></center>";
	$form->render("*horizontal");
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
