<?php
include('authentication.php');
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript">
function expenditureType(str)
{
if (str=="Others")
{
document.getElementById("others").innerHTML="Define *<input type='text' name='others'>";
}

else
document.getElementById("others").innerHTML="";
}


function check()
{
document.getElementById("add_exp_btn").disabled = true;
if (document.expenditure.names.value=="Others")
{
if (document.expenditure.others.value=="")
{
document.getElementById("add_exp_btn").disabled = false;
document.getElementById("errmsg").innerHTML="<b><font color='red'>Error:Expenditure Type Must Be Defined</font></b>";
return false;
}
}

else if (document.expenditure.names.value==-1)
{
document.getElementById("add_exp_btn").disabled = false;
document.getElementById("errmsg").innerHTML="<b><font color='red'>Error:Expenditure Type Must Be Selected</font></b>";
return false;
}

else if (document.expenditure.amount.value=="")
{
document.getElementById("add_exp_btn").disabled = false;
document.getElementById("errmsg").innerHTML="<b><font color='red'>Error:Amount Must Be Filled</font></b>";
return false;
}

else if(isNaN (document.expenditure.amount.value-0))
{
document.getElementById("add_exp_btn").disabled = false;
document.getElementById("errmsg").innerHTML="<b><font color='red'>Error:Amount Must Be A Number</font></b>";
return false;
}

}

</script>
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
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
      <script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
      <link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
      <link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css">
       <script type="text/javascript" src="calendarDateInput.js">
</script>
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
	if (isset($_POST["submit"]))
	{
	if ($_POST["others"]=="")
	{
	if(mysql_query("insert into dailyExpenditures (expId,description,amount,date) values ('$_POST[names]','$_POST[description]','$_POST[amount]','$_POST[date]')") or die (mysql_error()))
	echo "	<center><b>Expenditure Recorded Successfully</b>	</center>";
	else
	echo "	<center><b>Failed To Record Expenditure Into The System</b>	</center>";
	}

	else
	{
	if(mysql_query("insert into dailyExpenditures (expId,others,description,amount,date) values (0,'$_POST[others]','$_POST[description]','$_POST[amount]','$_POST[date]')") or die (mysql_error()))
	echo "<center><b>Expenditure Recorded Successfully</b></center>";
	else
	echo "<center><b>Failed To Record Expenditure Into The System</b></center>";
	}
	}
	else
	{
	?>
	<div id="errmsg"></div>
	<form method="POST" name='expenditure'>
	<table>
	<tr><td align="right">Aina Ya Matumizi</td><td><select name="names" onchange="expenditureType(this.value)">
	<option value='-1'>---Chagua---</option>
	<?php
	$results=mysql_query("select type,id from expenditures");
while($row=mysql_fetch_array($results))
{
echo "<option value='$row[id]'>$row[type]</option>";
}
?>
<option>Others</option>
</td><td id='others' align="right"></td></tr>

<tr id="price"></tr>

	<tr><td align="right">Maelezo Ya Matumizi</td><td><textarea rows="5" cols='20' name="description"></textarea></td></tr>
	<tr><td align="right">Kiasi</td><td><input type="text" name="amount">Date Bought</td><td><script>DateInput('date', true, 'YYYY-MM-DD')</script></td></tr>	
	<tr><td colspan="2" align="right"><input type="submit" name="submit" id='add_exp_btn' value="Add Expenditure" onclick="return check()"></td></tr>
	</table>
	</form>	
	<?php
	}
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
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer", {validateOn:["change","blur"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "integer", {validateOn:["change","blur"]});
//-->
</script>
      
</body>
</html>
