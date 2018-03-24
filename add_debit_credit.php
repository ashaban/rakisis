<?php
include('authentication.php');
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript">
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
var search_name=document.debts.search_name.value;
if(search_name=="") {
document.getElementById("search_name").innerHTML="";
document.debts.customer_id.value="";
document.getElementById("search_row").style.display="none";
exit;
}
xmlhttp.open("GET","add_debit_credit_JSP.php?from=search_customer&search_name="+search_name,true);
xmlhttp.send();
}

function get_selected_from_search()
{
	var id=document.getElementById("customer");
	document.debts.search_name.value=id.options[id.selectedIndex].text;
	document.debts.customer_id.value=document.debts.customer.value;
	document.getElementById("search_name").innerHTML="";
	document.getElementById("search_row").style.display="none";
}

function process()
{
document.getElementById("info").innerHTML="<center><font><img width=\"50\" height=\"50\" src=\"images/loading1.gif\">Saving Data.... please wait.... </font></center>";
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
    document.getElementById("info").innerHTML="<font color='red'><img src='images/information.jpg' width='30' height='30'>"+xmlhttp.responseText+"</font>";
    document.getElementById("errmsg").innerHTML=""
    document.debts.customer_id.value="";
    document.debts.search_name.value="";
    document.debts.amount.value="";
    var descr=document.debts.descr.value="";
    document.getElementById("debit_credit").selectedIndex=0;	 
    }
  }
  var customer_id=document.debts.customer_id.value;
  var amount=document.debts.amount.value;
  var descr=document.debts.descr.value;
  var debit_credit=document.debts.debit_credit.value;
  var date=document.debts.date.value;
xmlhttp.open("GET","add_debit_credit_JSP.php?from=process&customer_id="+customer_id+"&amount="+amount+"&descr="+descr+"&debit_credit="+debit_credit+"&date="+date,true);
xmlhttp.send();
}

function check()
{
if (document.debts.debit_credit.value=="-1") {
	document.getElementById("errmsg").innerHTML="<b><font color='red'>Error:Select If This Is The Debit/Credit</font></b>";
	return false;	
	}

else if (document.debts.customer_id.value=="")
{
document.getElementById("errmsg").innerHTML="<b><font color='red'>Error:You Must Enter The Full Name</font></b>";
return false;
}

else if (document.debts.amount.value=="")
{
document.getElementById("errmsg").innerHTML="<b><font color='red'>Error:You Must Enter The Amount Of Money</font></b>";
return false;
}

else if(isNaN (document.debts.amount.value-0))
{
document.getElementById("errmsg").innerHTML="<b><font color='red'>Error:Amount Must Be A Number With No Comma</font></b>";
return false;
}
process();
return true;
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
<link rel="stylesheet" href="zebra/public/css/zebra_form.css">
        <script src="zebra/jquery.js"></script>
        <script src="zebra/public/javascript/zebra_form.js"></script>
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
	<form name='debts' method="POST">
	<div id="errmsg">
	</div>
	<div id="info">
	</div>
	<table>
	<tr style='background-color:#C0C0C0;'><td align="right">Full Name</td><td><input type="text" name="search_name" onkeyup="search_customer()" style="width:250" autocomplete="off"><input type="hidden" name="customer_id"><a href="defineCustomer.php" target="_blank">Add New Customer</a></td></tr>
	<tr style="display:none;background-color:#C0C0C0;" id="search_row"><td>&nbsp;</td><td id="search_name"></td></tr>
	<tr style='background-color:#BCC6CC;'><td align="right">Amount Of Money</td><td><input type="text" name="amount"></td></tr>
	<tr style='background-color:#C0C0C0;'><td align="right">Description</td><td><textarea name="descr"></textarea></td></tr>
	<tr style='background-color:#BCC6CC;'><td align="right">Debt/Credit</td><td><select name="debit_credit" id="debit_credit"><option value="-1">---Select---</option><option value="debit">Debit</option><option value="credit">Credit</option></select></td></tr>
	<tr style='background-color:#C0C0C0;'><td align="right">Date Of Debt</td><td><script>DateInput('date', true, 'YYYY-MM-DD')</script></td></tr>
	<tr style='background-color:#BCC6CC;'><td>&nbsp;</td><td align="left"><input type="button" name="submit" value="Save" onclick="check()"></td></tr>
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
