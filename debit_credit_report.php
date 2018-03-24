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
var search_name=document.debit_credit.search_name.value;
if(search_name=="") {
document.getElementById("search_name").innerHTML="";
document.debit_credit.customer_id.value="";
exit;
}
xmlhttp.open("GET","debit_credit_report_JSP.php?from=search_customer&search_name="+search_name,true);
xmlhttp.send();
}

function get_selected_from_search() {
	var id=document.getElementById("customer");
	document.debit_credit.search_name.value=id.options[id.selectedIndex].text;
	document.debit_credit.customer_id.value=document.debit_credit.customer.value;
	document.getElementById("search_name").innerHTML="";
}

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
  
  var from_date=document.debit_credit.from.value;
  var to_date=document.debit_credit.to.value;  
  var debits_credits=document.debit_credit.debits_credits.value;
  var statuses=document.debit_credit.statuses.value;
  var customer_id=document.debit_credit.customer_id.value;
xmlhttp.open("GET","debit_credit_report_JSP.php?from=showReport&from_date="+from_date+"&to_date="+to_date+"&debits_credits="+debits_credits+"&status="+statuses+"&customer_id="+customer_id,true);
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
			
<form method="POST" name="debit_credit">
	<table>
	<tr style='background-color:#C0C0C0;'><td align='center'>Kuanzia Tarehe</td><td><script>DateInput('from', true, 'YYYY-MM-DD')</script></td><td>Hadi Tarehe</td><td><script>DateInput('to', true, 'YYYY-MM-DD')</script></td><td>Madai/Madeni</td><td><select name="debits_credits"><option value="-1">---Select---</option><option value="debits">Madeni</option><option value="credits">Madai</option></select></td><td>Hali Ya Deni/Dai</td><td><select name="statuses"><option value="all">Yote</option><option value="cleared">Yaliyolipwa</option><option value="notcleared">Hayajalipwa</option></select></td><td align="right">Jina La Mdai/Mdaiwa</td><td><input type="text" name="search_name" onkeyup="search_customer()" style="width:250" autocomplete="off"><input type="hidden" name="customer_id"></td><td id='button'><input type='button' name='report' value='Get Report' onclick='showReport()'></td></tr><tr style="display:none;" id="search_row"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td id="search_name"></td></tr>
</table>

<table id="report" width="70%">

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
