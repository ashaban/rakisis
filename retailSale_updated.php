<?php
include('authentication.php');
if (!isset($_POST["submit"]))
unset($_SESSION["allarrays"]);
unset($_SESSION["quantities"]);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript">
function showItems(str)
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
    document.getElementById("display").innerHTML=xmlhttp.responseText;
    }
  }

xmlhttp.open("GET","retailSaleJSP.php?name="+str+"&from=showItems",true);
xmlhttp.send();
}

function getName()
{
var Name = document.sale.itemname.options[document.sale.itemname.selectedIndex].text;
document.sale.namesPool.value=Name;
showBatch(document.sale.itemname.value);
}

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
    document.getElementById("button").innerHTML="<input type='button' name='que' value='Add To Sale Que' onclick='check()'>";
    showDescr(document.sale.batch.value);
    }
  }
xmlhttp.open("GET","retailSaleJSP.php?from=showBatch&id="+str,true);
xmlhttp.send();
}

function showDescr(str)
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
    document.getElementById("descr").innerHTML=xmlhttp.responseText; 
    }
  }
xmlhttp.open("GET","retailSaleJSP.php?from=showDescr&id="+str,true);
xmlhttp.send();
}

function checkQuantity()
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
    document.getElementById("errmsg").innerHTML=xmlhttp.responseText;
    if (xmlhttp.responseText=="")
    addQue();
    }
  }

xmlhttp.open("GET","retailSaleJSP.php?from=checkQuantity&quantityToCheck="+document.sale.quantity.value+"&batchToCheck="+document.sale.batch.value,true);
xmlhttp.send();
}

function addQue(type)
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
    document.getElementById("que").innerHTML=xmlhttp.responseText;    
    }
  }
   
 if (document.sale.salePrice.value=="diff")
 {
 var salePrice=document.sale.diffPrice.value;

 }
 else
 var salePrice=document.sale.salePrice.value;
  
 var item=document.sale.itemname.value;
 var batch=document.sale.batch.value;
 var quantity=document.sale.quantity.value;
 
 var date=document.sale.date.value;
xmlhttp.open("GET","retailSaleJSP.php?from=addQue&item="+item+"&batch="+batch+"&quantity="+quantity+"&salePrice="+salePrice+"&date="+date+"&type="+type,true);
xmlhttp.send();
}

function remove(id)
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
    addQue("removed");   
    }
  }
xmlhttp.open("GET","retailSaleJSP.php?from=remove&id="+id,true);
xmlhttp.send();
}

function check()
{
if (document.sale.quantity.value=="")
{
document.getElementById("errmsg").innerHTML="<b><font color='red'>Error:Number Of Cartons Must Be Filled</font></b>";
return true;
}

else if (document.sale.salePrice.value=="")
{
document.getElementById("errmsg").innerHTML="<b><font color='red'>Error:Sale Price Must Be Filled</font></b>";
return true;
}

else if(isNaN (document.sale.quantity.value-0))
{
document.getElementById("errmsg").innerHTML="<b><font color='red'>Error:Quantity Must Be A Number</font></b>";
return true;
}

else if (document.sale.salePrice.value=="diff")
{
if (isNaN (document.sale.diffPrice.value-0))
{
document.getElementById("errmsg").innerHTML="<b><font color='red'>Error:Sale Price Must Be A Number With No Separator</font></b>";
return true;
}
else if (document.sale.diffPrice.value=="")
{
document.getElementById("errmsg").innerHTML="<b><font color='red'>Error:Sale Price Must Be Filled</font></b>";
return true;
}
else
checkQuantity();
}

else
{
checkQuantity();
//document.getElementById("errmsg").innerHTML="";
}

}

function checkSPrice(str)
{
if (str=="diff")
{
document.getElementById("input").innerHTML="<input type='text' name='diffPrice' value='Enter Price' onclick=\"if (this.value=='Enter Price') this.value=''\">"
}
else
document.getElementById("input").innerHTML="";
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
	<?php
	if (isset($_POST["submit"]))
	{	
	foreach($_SESSION["allarrays"] as $values)
	{
	list($available)=mysql_fetch_array(mysql_query("select available from retailStock where id='$values[1]'"));
	$available=$available-$values["2"];
	mysql_query("insert into sales (itemId,quantity,price,date,salerId,batchNumber,type) values ('$values[0]','$values[2]','$values[3]','$values[4]','$_SESSION[id]','$values[1]','retail')") or die(mysql_error());
	mysql_query("update retailStock set available='$available' where id='$values[1]'");
	}
	unset($_SESSION["allarrays"]);
	}
	?>
<div id="errmsg"></div>		
<form method="POST" name="sale">
	<table>
	<tr><td valign="top">Item Name</td><td valign="top"><input type="text" name="namesPool" onkeyup="showItems(this.value)" autocomplete="off" style="width:155"></td>

<td id="batch"> </td></tr>
<tr><td id="display"></td></tr>
</table>
<table>
<tr><td align='center' style="position:relative;">Sale Date</td><td><script>DateInput('date', true, 'YYYY-MM-DD')</script></td><td id='button'></td></tr>
</table>
<div id="que"></div>

<table id="descr">

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
