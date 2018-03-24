<?php
include('authentication.php');
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript">
function process() {
	document.getElementById("infomsg").innerHTML="<center><font><img width=\"50\" height=\"50\" src=\"images/loading1.gif\">Saving Data.... please wait.... </font></center>";
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
    document.getElementById("infomsg").innerHTML="<font color='red'><img src='images/information.jpg' width='30' height='30'>"+xmlhttp.responseText+"</font>";
    document.getElementById("errmsg").innerHTML="";
    document.unit.unit_name.value="";   
    }
  }

	xmlhttp.open("GET","define_unit_JSP.php?from=process&unit_name="+document.unit.unit_name.value,true);
xmlhttp.send();	
	}
	
function verify() {
	document.getElementById("infomsg").innerHTML="";
	if(document.unit.unit_name.value=="") {
		document.getElementById("errmsg").innerHTML="<font color='red'><b>Jaza Jina La Unit</b></font>";
		return false;
		}
	process();
	}
</script>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Sajili Bidhaa</title>
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
<div id="errmsg"></div>
<div id="infomsg"></div>
<form name="unit">
<table>
<tr><td colspan="2" align="center"><h3>Sajili Unit Mpya</h3></td></tr>
<tr style='background-color:#C0C0C0;'><td align="right">Jina La Unit<font color="red">*</font></td><td><input type="text" name="unit_name"></td></tr>
<tr style='background-color:#BCC6CC;'><td colspan="2" align="center"><input type="button" name="button" value="Sajili Unit" onclick="verify()"></td></tr>
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
