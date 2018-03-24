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
xmlhttp.open("GET","salesReportJSP.php?from=showBatch&id="+str,true);
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
    show_summary_report();
    }
  }
  var item=document.salereport.itemname.value;
  var batch=document.salereport.batch.value;
  var branch=document.salereport.branch.value;
  var from=document.salereport.from.value;
  var to=document.salereport.to.value;

xmlhttp.open("GET","salesReportJSP.php?from=showReport&item="+item+"&batch="+batch+"&fromdate="+from+"&todate="+to+"&branch="+branch,true);
xmlhttp.send();
}

function show_summary_report()
{
document.getElementById("summary_report").innerHTML="<center><font><img width=\"50\" height=\"50\" src=\"images/loading1.gif\">Loading Summary.... please wait.... </font></center>";
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
    document.getElementById("summary_report").innerHTML=xmlhttp.responseText; 
    }
  }

xmlhttp.open("GET","salesReportJSP.php?from=show_summary_report",true);
xmlhttp.send();
}

function changeView(view)
{
  if(view=="expand")
  {
  showReport();
  exit;
  }
  else
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
    show_summary_report();
    }
  }

  var item=document.salereport.itemname.value;
  var batch=document.salereport.batch.value;
  var branch=document.salereport.branch.value;
  var from=document.salereport.from.value;
  var to=document.salereport.to.value;  
xmlhttp.open("GET","salesReportJSP.php?from=changeView&item="+item+"&batch="+batch+"&fromdate="+from+"&todate="+to+"&view="+view+"&branch="+branch,true);
xmlhttp.send();
}
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
			
<form method="POST" name="salereport">
	<table>
	<tr><td>Chagua Bidhaa</td><td><select name="itemname" onchange="showBatch(this.value)">
	<option value='all'>Bidhaa Zote</option>
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
</td><td id="batch">
Chagua Batch<select name="batch">
<option value="all">Batch Zote</option>
<?php
$batches=mysql_query("select id from wholeStock");	
while ($row=mysql_fetch_array($batches))
{
$date = date_create($row["date"]);
$date=date_format($date,"jS F Y");
echo "<option value='$row[id]'>Batch $row[id] ($date)</option>";
}
 echo "</td><td>Chagua Tawi</td><td><select name='branch'><option value='-1'>---Chagua---</option>";
		$results=mysql_query("select id,name from branches");
		while($row=mysql_fetch_array($results)) {
			echo "<option value='$row[id]'>$row[name]</option>";
			}
		echo "</td>";
?>
		</tr>
</table>
<table>
<tr><td align='center'>Tarehe Kuanzia</td><td><script>DateInput('from', true, 'YYYY-MM-DD')</script></td><td>Hadi</td><td><script>DateInput('to', true, 'YYYY-MM-DD')</script></td><td id='button'><input type='button' name='report' value='Angalia Mauzo Report' onclick='showReport()'></td></tr>
</table>

<div id="summary_report">

</div>
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
