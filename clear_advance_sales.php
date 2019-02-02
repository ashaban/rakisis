<?php
include('authentication.php');
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript">
function showNames(str)
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

xmlhttp.open("GET","clear_advance_sales_JSP.php?name="+str+"&from=showNames",true);
xmlhttp.send();
}

function check(id)
{
document.getElementById("clear_debt_btn").disabled = true;
if (isNaN (document.getElementById(id).value-0))
{
document.getElementById("clear_debt_btn").disabled = false;
document.getElementById("errmsg").innerHTML="<b><font color='red'>Error:Kiasi Kinacholipwa Lazima Kiwe Namba</font></b>";
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
    document.getElementById("clear_debt_btn").disabled = false;
    document.getElementById("errmsg").innerHTML=xmlhttp.responseText;
    return false;
    }
    }
  }

xmlhttp.open("GET","clear_advance_sales_JSP.php?from=check&amount_paid="+document.getElementById(id).value+"&id="+id,true);
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
    document.getElementById("clear_debt_btn").disabled = false;
    document.getElementById("info").innerHTML="<font color='red'><img src='images/information.jpg' width='30' height='30'>"+xmlhttp.responseText+"</font>";
    showDebtInfo(document.form.namesPool.value);    
    }
  }

xmlhttp.open("GET","clear_advance_sales_JSP.php?from=submit&id="+id+"&amount_paid="+document.getElementById(id).value,true);
xmlhttp.send();
}

function showDebtInfo(customer_id)
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
    document.getElementById("debtInfo").innerHTML=xmlhttp.responseText;
    }
  }

xmlhttp.open("GET","clear_advance_sales_JSP.php?id="+customer_id+"&from=showDebtInfo",true);
xmlhttp.send();
}

function getName()
{
var Name = document.form.namesPool.options[document.form.namesPool.selectedIndex].text;
document.form.names.value=Name;
document.getElementById("button").innerHTML="<input type='button' value='Load Debt Details' onclick='showDebtInfo(document.form.namesPool.value)'>";
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
	<form name="form" action="" method="POST">
<table cellpadding="0" cellspacing="0">
<tr><td colspan="3" align="center"><h3>LIPIA MAUZO YENYE MADENI</h3></td></tr>
<tr style='background-color:#C0C0C0;'>
<td><b>Chagua Jina La Mteja</b></td><td><input type="text" name="names" onkeyup="showNames(this.value)" autocomplete="off" style="width:250"></td>
<td id="button"></td>
</tr>
<tr>
<td>&nbsp;</td>
<td id="display" style="position:relative;bottom:3;background-color:white"></td>
</tr>
</table>
</form>
<div id="info"></div>
<form name="debt" id="debtInfo">

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
