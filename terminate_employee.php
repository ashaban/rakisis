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
    document.getElementById("terminate").innerHTML=xmlhttp.responseText;
    }
  }

search_name=document.terminate.search_name.value;
xmlhttp.open("GET","terminate_employee_JSP.php?name="+search_name+"&from=search_employees",true);
xmlhttp.send();
}

function save_data(id)
{
	if(!confirm("Unauhakika Unataka Kusitisha Mkataba Wa Mtumishi Huyu?"))
	exit
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
    search_employees(document.terminate.search_name.value);    
    }
  }
reason=document.getElementById("reason_"+id).value;
date=document.getElementById("date_terminated_"+id).value;

xmlhttp.open("GET","terminate_employee_JSP.php?from=save_data&emp_id="+id+"&reason="+reason+"&date="+date,true);
xmlhttp.send();
}
</script>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Contract Termination</title>
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
	<form name="terminate">
<table cellpadding="0" cellspacing="0">
<tr style='background-color:#C0C0C0;'>
<td><b>Tafuta Kwa Jina La Kwanza</b></td><td><input type="text" name="search_name" onkeyup="search_employees()" autocomplete="off" style="width:155"></td></tr>
</table>
<br>
<div id="info"></div>
<div id="terminate"></div>
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
