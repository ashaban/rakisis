<?php
include('authentication.php');
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript">
function showBatch(str)
{
if (str==-1)
exit;
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
    document.getElementById("batch").innerHTML=xmlhttp.responseText;     
    }
  }
xmlhttp.open("GET","deleteSalesJSP.php?from=showBatch&id="+str,true);
xmlhttp.send();
}

function showReport()
{
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
  var item=document.salereport.itemname.value;
  var batch=document.salereport.batch.value;
  var from=document.salereport.from.value;
  var to=document.salereport.to.value;

xmlhttp.open("GET","deleteSalesJSP.php?from=showReport&item="+item+"&batch="+batch+"&fromdate="+from+"&todate="+to,true);
xmlhttp.send();
}

function delete_this(id,sale_type)
{
if(!confirm("Are You Sure You Want Delete This Sale?"))
exit();

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
    if(xmlhttp.responseText=="deleted")
    {
    document.getElementById("msg").innerHTML="<b><font color='red'><img src='images/information.jpg' width='30' height='30'>Sales Deleted Successfully</font></b>";
    showReport()
    }
    else
    document.getElementById("msg").innerHTML="<b><font color='red'><img src='images/error.jpg' width='30' height='30'>Deletion Failed</font></b>";
    }
  }
xmlhttp.open("GET","deleteSalesJSP.php?from=delete&id="+id+"&sale_type="+sale_type,true);
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
<div id="msg"></div>
<form method="POST" name="salereport">
	<table>
	<tr><td valign="top">Select Product</td><td valign="top"><select name="itemname" onchange="showBatch(this.value)">
	<option value='all'>All Products</option>
	<?php	
	$items=mysql_query("select id,name,description from items order by name");
while($row=mysql_fetch_array($items))
{
echo "<option value='$row[id]'>$row[name]</option>";
}
?>
</td><td id="batch">
Select Batch<select name="batch">
<option value="all">All Batches</option>
<?php
$batches=mysql_query("select id,date_stocked from wholeStock");	
while ($row=mysql_fetch_array($batches))
{
$date = date_create($row["date_stocked"]);
$date=date_format($date,"jS F Y");
echo "<option value='$row[id]'>Batch $row[id] ($date)</option>";
}
?>
 </td></tr>
</table>
<table>
<tr><td align='center'>From</td><td><script>DateInput('from', true, 'YYYY-MM-DD')</script></td><td>To</td><td><script>DateInput('to', true, 'YYYY-MM-DD')</script></td><td id='button'><input type='button' name='report' value='View Sale Report' onclick='showReport()'></td></tr>
</table>

<div id="report">

</div>

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
