<?php
include('authentication.php');
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript">
function show_batches(id)
{
if (id==-1)
exit;
document.getElementById("batch_descriptions").innerHTML="";
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
    document.getElementById("batches").innerHTML=xmlhttp.responseText; 
    }
  }
xmlhttp.open("GET","addRetailSaleStockJSP.php?from=show_batches&id="+id,true);
xmlhttp.send();
}

function show_batch_descriptions(id) {
	if (id==-1)
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
	    document.getElementById("batch_descriptions").innerHTML=xmlhttp.responseText; 
	    }
	  }
	xmlhttp.open("GET","addRetailSaleStockJSP.php?from=show_batch_descriptions&id="+id,true);
	xmlhttp.send();
	}
	
	function make_transfer() {
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
		    document.getElementById("infomsg").innerHTML="<font style='color:red'><img src='images/information.jpg' width='30' height='30'>Bidhaa Zimehamishwa Kikamilifu</font>";
		    document.getElementById("errmsg").innerHTML="";
		     show_batch_descriptions(document.transfer.batch.value);
		     return true;
		    }
		  }
		 var batch=document.transfer.batch.value;
		 var quantity_transfer=document.transfer.quantity_transfer.value;
		 var branch=document.transfer.branch.value;
		 var date_transfered=document.transfer.date_transfered.value;
		xmlhttp.open("GET","addRetailSaleStockJSP.php?from=make_transfer&batch="+batch+"&quantity="+quantity_transfer+"&branch="+branch+"&date_transfered="+date_transfered,true);
		xmlhttp.send();
	}
	
	function validate_transfer() {
		var quantity_available=document.transfer.quantity_available.value;
		var quantity_transfer=document.transfer.quantity_transfer.value;
		document.getElementById("infomsg").innerHTML="";
		if(isNaN(quantity_transfer)) {
			document.getElementById("errmsg").innerHTML="Idadi Ya Kuhamisha Lazima Iwe Namba";
			return false;
			}
		else if(parseInt (quantity_transfer) > parseInt(quantity_available)) {
			document.getElementById("errmsg").innerHTML="Idadi Ya Kuhamisha Imezidi Idadi Iliyopo";
			return false;
			}
		else if(quantity_transfer=="") {
			document.getElementById("errmsg").innerHTML="Idadi Ya Kuhamisha Lazima Ijazwe";
			return false;
			}
		else if(document.transfer.branch.value=="-1") {
			document.getElementById("errmsg").innerHTML="Chagua Tawi La Kuhamishia Mzigo";
			return false;			
			}
		make_transfer();
		}
function show_units(quantity) {
	var batch=document.transfer.batch.value;
	quantity=parseInt(quantity);
	if(quantity=="") {
		document.getElementById("units_"+batch).innerHTML="";
		exit
		}
	if(isNaN(quantity)) {
		document.getElementById("units_"+batch).innerHTML="";
		exit
		}
	var total_units=quantity*document.getElementById("total_units_"+batch).value;
	var unit=document.getElementById("unit_"+batch).value;
	document.getElementById("units_"+batch).innerHTML=total_units+" "+unit
	}
</script>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
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
	<div id="errmsg" style="color:red;font-weight:bold;text-align:center"></div><div id="infomsg" style="color:black;font-weight:bold;text-align:center"></div>
	<center>
	<form method="POST" name="transfer">
	<table>
	<tr><td align="right">Jina La Bidhaa</td><td><select name="name" onchange="show_batches(this.value)">
	<option value='-1'>---Chagua---</option>
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
</select></td><td><span id="batches"></span></td><td>Tarehe Ya Kuhamisha</td><td><script>DateInput('date_transfered', true, 'YYYY-MM-DD')</script></td></tr></table>
<table id="batch_descriptions"></table>
</table>
	</form>
				</center>
		</div>
	<!-- end content -->
	<!-- start sidebars -->
	
	
	<!-- end sidebars -->
	<div style="clear: both;">&nbsp;</div>
</div>
<?php
include("footer.html");
?>
</body>
</html>
