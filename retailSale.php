<?php
include('authentication.php');
unset($_SESSION["allarrays"]);
unset($_SESSION["quantities"]);

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript">
function showBatch()
{
if (document.sale.itemname.value==-1)
exit;
if(document.sale.branch.value==-1)
exit

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
    document.getElementById("button").innerHTML="<input type='button' name='que' value='Ongeza Kwenye Foleni Ya Mauzo' onclick='check_date_validity()'>";  
    showDescr(document.sale.batch.value);
    }
  }
var id=document.sale.itemname.value;
var branch=document.sale.branch.value;
xmlhttp.open("GET","retailSaleJSP.php?from=showBatch&id="+id+"&branch="+branch,true);
xmlhttp.send();
}

function showDescr(str)
{
document.getElementById("errmsg").innerHTML="";
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
var branch=document.sale.branch.value;
xmlhttp.open("GET","retailSaleJSP.php?from=showDescr&id="+str+"&branch="+branch,true);
xmlhttp.send();
}

function search_customer()
{
document.getElementById("search_name").innerHTML="<font><img width=\"50\" height=\"50\" src=\"images/icon_spinner.gif\">Loading Customers.... please wait.... </font>";
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
    document.getElementById("search_name").innerHTML=xmlhttp.responseText;
    document.getElementById("search_row").style.display="table-row";
    }
  }
var search_name=document.sale.search_name.value;
if(search_name=="") {
document.getElementById("search_name").innerHTML="";
document.sale.customer_id.value="";
exit;
}
xmlhttp.open("GET","retailSaleJSP.php?from=search_customer&search_name="+search_name,true);
xmlhttp.send();
}

function get_selected_from_search()
{
	var id=document.getElementById("customer");
	document.sale.search_name.value=id.options[id.selectedIndex].text;
	document.sale.customer_id.value=document.sale.customer.value;
	document.getElementById("search_name").innerHTML="";
}

function checkQuantity()
{
	var customer_id=document.sale.customer_id.value;
	if(customer_id=="") {
	if(!confirm("Huja Chagua Jina La Mteja,Endelea?"))
	exit
	}
	
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

function check_customer_selection() {
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
		 var str=xmlhttp.responseText;		 
		 if (str.substr(0,9)=="Hakikisha") {
	    document.getElementById("errmsg").innerHTML=xmlhttp.responseText;
	    exit;
	    }
	    process_sale();
	    }
	  }
	
	xmlhttp.open("GET","retailSaleJSP.php?from=check_customer_selection&mode="+document.sale.mode.value,true);
	xmlhttp.send();
	}
	
function process_sale()
{
	if(document.sale.mode.value=='advance' && document.sale.advance_amount.value=="") {
		document.getElementById("errmsg").innerHTML="Weka Kiasi Cha Fedha Kilichotangulizwa";
		exit
		}
		else if(document.sale.mode.value=='advance' && document.sale.advance_amount.value!=""){
			var advance_amount=document.sale.advance_amount.value;
			if(isNaN(advance_amount)) {
				document.getElementById("errmsg").innerHTML="Kiasi Cha Fedha Kilichotangulizwa Lazima Kiwe Namba";
				exit
				}
			}
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
    display_items_lists()
    document.getElementById("que").innerHTML="";
    document.getElementById("descr").innerHTML="";
    document.getElementById("batch").innerHTML="";
    }
  }  
var mode=document.sale.mode.value;
if(mode=="advance")
var advance_amount=document.sale.advance_amount.value;
var branch=document.sale.branch.value;
xmlhttp.open("GET","retailSaleJSP.php?from=process_sale&advance_amount="+advance_amount+"&pay_mode="+mode+"&branch="+branch,true);
xmlhttp.send();
}

function display_items_lists()
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
    document.getElementById("display_items_lists").innerHTML=xmlhttp.responseText;
    }
  }

xmlhttp.open("GET","retailSaleJSP.php?from=display_items_lists",true);
xmlhttp.send();
}

function addQue(type)
{
	var customer_id=document.sale.customer_id.value;
	document.sale.customer_id.value="";
	document.sale.search_name.value="";	
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
 var invoice_number=document.sale.invoice_number.value;
 var branch=document.sale.branch.value;
xmlhttp.open("GET","retailSaleJSP.php?from=addQue&item="+item+"&batch="+batch+"&quantity="+quantity+"&salePrice="+salePrice+"&date="+date+"&type="+type+"&customer_id="+customer_id+"&invoice_number="+invoice_number+"&branch="+branch,true);
xmlhttp.send();
}

function remove_this(id)
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
    addQue("removed");   
    }
  }

xmlhttp.open("GET","retailSaleJSP.php?from=remove&id="+id,true);
xmlhttp.send();
}

function checkSPrice(str)
{
if (str=="diff")
{
document.getElementById("input").innerHTML="<input type='text' name='diffPrice' value='Bei Mpya' onclick=\"if (this.value=='Bei Mpya') this.value=''\">"
}
else
document.getElementById("input").innerHTML="";
}

function check_date_validity()
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
    if(xmlhttp.responseText=="Invalid Sale")
    document.getElementById("errmsg").innerHTML="<b><font color='red'>Error:This Stock Didnt Exist During This Sale,Invalid Sale Date</font></b>";
    else
    check();
    }
  }
var sale_date=document.sale.date.value;
var batch=document.sale.batch.value;
xmlhttp.open("GET","retailSaleJSP.php?from=check_date_validity&sale_date="+sale_date+"&batch="+batch,true);
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

else if(isNaN (document.sale.quantity.value))
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
}

}

function check_pay_mode(mode) {
	if(mode=='advance')
	document.getElementById('advance_amount').innerHTML="Kiwango Kilichotangulizwa<font style='color:red'>*</font><input type='text' name='advance_amount'>";
	else
	document.getElementById('advance_amount').innerHTML=""
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
<body style="background-color:white;" onload="display_items_lists()">
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
<div id="errmsg" style="color:red;font-weight:bold"></div>
<form method="POST" name="sale">
<div id="que"></div>
<table id="descr">

</table>
<table>
<tr>
<td valign='top'>
<table id="display_items_lists">

</table>
</td>

<td valign='top'>
<table id="batch">

</table>
</td>
<td valign='top'>
<table width="100%">
<tr style="background-color:#C0C0C0;"><td align='right'>Tarehe Ya Mauzo</td><td align='left'><script>DateInput('date', true, 'YYYY-MM-DD')</script></td></tr>

</table>
</td>
</tr>
<tr><td id='button' colspan="3" align="center"></td></tr>
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
<?php
include("footer.html");
?>
</body>
</html>
