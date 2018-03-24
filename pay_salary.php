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
pay_month=document.pay_salary.pay_month.value;
pay_year=document.pay_salary.pay_year.value;
search_name=document.pay_salary.search_name.value;
xmlhttp.open("GET","pay_salary_JSP.php?name="+search_name+"&from=search_employees&pay_month="+pay_month+"&pay_year="+pay_year,true);
xmlhttp.send();
}

function check(id)
{
if ((document.getElementById("deduct_"+id).value!="") && isNaN (document.getElementById("deduct_"+id).value-0))
{
document.getElementById("errmsg").innerHTML="<b><font color='red'>Error:Kiasi Cha Kupunguzwa Lazima Kiwe Namba</font></b>";
return false;
exit;
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
    if(xmlhttp.responseText=="")
    {
    submit(id);
    }
    else
    {
    if(xmlhttp.responseText.substr(0,11)=="Mshahara Wa") {
    	if(!confirm(xmlhttp.responseText))
    	exit;
    	else
    	submit(id);
    	}

    document.getElementById("errmsg").innerHTML="<b><font color='red'>"+xmlhttp.responseText+"</font></b>";
    return false;
    }
    }
  }
pay_month=document.pay_salary.pay_month.value;
pay_year=document.pay_salary.pay_year.value;
amount_deducted=document.getElementById("deduct_"+id).value;
xmlhttp.open("GET","pay_salary_JSP.php?from=check&pay_month="+pay_month+"&pay_year="+pay_year+"&emp_id="+id+"&amount_deducted="+amount_deducted,true);
xmlhttp.send();
}

function submit(id)
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
    search_employees(document.pay_salary.search_name.value);    
    }
  }

amount_deducted=document.getElementById("deduct_"+id).value;
ded_reason=document.getElementById("deduct_reason_"+id).value;
pay_month=document.pay_salary.pay_month.value;
pay_year=document.pay_salary.pay_year.value;

xmlhttp.open("GET","pay_salary_JSP.php?from=submit&emp_id="+id+"&amount_deducted="+amount_deducted+"&ded_reason="+ded_reason+"&pay_month="+pay_month+"&pay_year="+pay_year,true);
xmlhttp.send();
}
</script>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Salary Payments</title>
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
	<form name="pay_salary">
<table cellpadding="0" cellspacing="0">
<tr><td colspan="6" align="center"><h3>LIPA MSHAHARA WA MWEZI WA WATUMISHI</h3></td></tr>
<tr style='background-color:#C0C0C0;'>
<td><b>Tafuta Kwa Jina La Kwanza</b></td><td><input type="text" name="search_name" onkeyup="search_employees()" autocomplete="off" style="width:155"></td>
<td>Chagua Mwezi</td><td><select name="pay_month" onchange="search_employees()">
<?php
foreach($month_array as $key=>$month) {
	if($key==date("n"))	
	echo "<option value='$key' selected>$month</option>";
	else
	echo "<option value='$key'>$month</option>";
}
?>
</select></td>
<td>Chagua Mwaka</td><td><select name="pay_year" onchange="search_employees()">
<?php
$year=date("Y");
echo "<option>$year</option>";
echo "<option>".($year-1)."</option>";
?>
</select></td>
</tr>
</table>
<br>
<div id="info"></div>
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
