<?php
include('authentication.php');
require("months.php");
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript">
function search_employees(search_name)
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
    document.getElementById("pay_salary").innerHTML=xmlhttp.responseText;
    }
  }
from_date=document.salary_report.from_date.value;
to_date=document.salary_report.to_date.value;
search_name=document.salary_report.search_name.value;
contract=document.salary_report.contract.value;
salary_status=document.salary_report.salary_status.value;

xmlhttp.open("GET","salary_report_JSP.php?name="+search_name+"&from=search_employees&from_date="+from_date+"&to_date="+to_date+"&contract="+contract+"&salary_status="+salary_status,true);
xmlhttp.send();
}
</script>
<script type="text/javascript" src="calendarDateInput.js">
</script>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Salary Report</title>
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
</head>
<body style="background-color:white;" onload="search_employees()">
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
	<form name="salary_report">
<table cellpadding="0" cellspacing="0">
<tr><td colspan="11" align="center"><h3>RIPOTI YA MALIPO YA MISHAHARA</h3></td></tr>
<tr style='background-color:#C0C0C0;'>
<td><b>Tafuta Kwa Jina La Kwanza</b></td><td><input type="text" name="search_name" onkeyup="search_employees()" autocomplete="off" style="width:155"></td>
<td align='center'>Malipo Kuanzia Tarehe</td><td><script>DateInput('from_date', true, 'YYYY-MM-DD')</script></td><td>Hadi</td><td><script>DateInput('to_date', true, 'YYYY-MM-DD')</script></td><td>Aina Ya Mikataba</td><td><select name="contract" onchange="search_employees()"><option value="employee">Watumishi</option><option value="terminated">Waliositishiwa Mikataba</option></select></td>
<td>Hali Ya Mishahara</td><td><select name="salary_status" onchange="search_employees()"><option value="paid">Walolipwa</option><option value="not_paid">Wasiolipwa</option></select></td>
<td><input type="button" name="button" value="View Report" onClick="search_employees()"></td>
</tr>
</table>
<br>

<div id="pay_salary"></div>
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
