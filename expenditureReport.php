<?php
include('authentication.php');
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript">

function showReport()
{
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("report").innerHTML=xmlhttp.responseText; 
    }
  }
  var type=document.expenditurereport.type.value;
  var from=document.expenditurereport.from.value;
  var to=document.expenditurereport.to.value;

xmlhttp.open("GET","expenditureReportJSP.php?from=showReport&type="+type+"&fromdate="+from+"&todate="+to,true);
xmlhttp.send();
}

</script>

<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Sale Item</title>
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
			
<form method="POST" name="expenditurereport">
	<table>
	<tr><td>Aina Ya Matumizi</td><td><select name="type">
	<option value='all'>Aina Zote</option>
	<?php	
	$type=mysql_query("select id,type from expenditures order by type");
while($row=mysql_fetch_array($type))
{
echo "<option value='$row[id]'>$row[type]</option>";
}
?>
</td><td align='center'>Tarehe Kuanzia</td><td><script>DateInput('from', true, 'YYYY-MM-DD')</script></td><td>Hadi</td><td><script>DateInput('to', true, 'YYYY-MM-DD')</script></td><td id='button'><input type='button' name='report' value='Pata Taarifa' onclick='showReport()'></td></tr>
</table>

<table id="report">

</table>
</form>	
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
