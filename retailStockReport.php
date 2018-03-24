<?php
include('authentication.php');
if (!isset($_POST["submit"]))
unset($_SESSION["allarrays"]);
unset($_SESSION["quantities"]);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript">
function showReport(str)
{
if(document.stock.branch.value=="-1") {
	document.getElementById("report").innerHTML="<font color='red'><center><b>Chagua Tawi</b></center></font>";
	exit
	}
document.getElementById("report").innerHTML="<center><font><img width=\"50\" height=\"50\" src=\"images/loading1.gif\">Loading Data.... please wait.... </font></center>";
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
  var beg_date=document.stock.beg_date.value;
  var end_date=document.stock.end_date.value;
  var branch=document.stock.branch.value;
xmlhttp.open("GET","retailStockReportJSP.php?from=showReport&id="+str+"&beg_date="+beg_date+"&end_date="+end_date+"&branch="+branch,true);
xmlhttp.send();
}
</script>

<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Ripoti Ya Stock Ya RejaReja</title>
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
<form method="POST" name="stock">
	<table>
	<tr><td valign="top">Jina La Bidhaa</td><td valign="top"><select name="itemname">
	<option>All</option>
	<?php	
$items=mysql_query("select id,name,total_units,unit from items order by name");
while($row=mysql_fetch_array($items))
{
list($unit_name)=mysql_fetch_array(mysql_query("select name from units where id='$row[unit]'"));
if($row["total_units"]==0)
$total_units="";
else
$total_units=$row["total_units"];
echo "<option value='$row[id]'>$row[name] $unit_name $total_units</option>";
}
?>
</td>
<td>Chagua Tawi</td><td><select name='branch'><option value='-1'>---Chagua---</option>";
<?php
$results=mysql_query("select id,name from branches");
while($row=mysql_fetch_array($results)) {
	echo "<option value='$row[id]'>$row[name]</option>";
	}
?>
</td>
<td align='center'>Kuanzia Tarehe</td><td><script>DateInput('beg_date', true, 'YYYY-MM-DD')</script></td>
<td align='center'>Hadi Tarehe</td><td><script>DateInput('end_date', true, 'YYYY-MM-DD')</script></td>
<td id='button'><input type='button' value="Pata Ripoti" onclick='showReport(document.stock.itemname.value)'></td></tr>

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
