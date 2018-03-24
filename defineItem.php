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
    document.item_description.item_name.value="";
    document.item_description.bprice.value="";
    document.item_description.sprice.value="";
    document.item_description.total_units.value="";
    document.item_description.spriceunit.value="";
    document.getElementById("unit").selectedIndex=0;    
    }
  }

	xmlhttp.open("GET","define_item_JSP.php?from=process&item_name="+document.item_description.item_name.value+"&bprice="+document.item_description.bprice.value+"&sprice="+document.item_description.sprice.value+"&unit="+document.item_description.unit.value+"&total_units="+document.item_description.total_units.value+"&spriceunit="+document.item_description.spriceunit.value,true);
xmlhttp.send();	
	}
	
function verify() {
	document.getElementById("infomsg").innerHTML="";
	if(document.item_description.item_name.value=="") {
		document.getElementById("errmsg").innerHTML="<font color='red'><b>Jaza Jina La Bidhaa</b></font>";
		return false;
		}
	if(document.item_description.bprice.value=="") {
		document.getElementById("errmsg").innerHTML="<font color='red'><b>Jaza Bei Ya Kununulia</b></font>";
		return false;
		}
	if(isNaN(document.item_description.bprice.value)) {
		document.getElementById("errmsg").innerHTML="<font color='red'><b>Bei Ya Kununulia Sio Sahihi,Sio Namba</b></font>";
		return false;
		}
	if(document.item_description.sprice.value=="") {
		document.getElementById("errmsg").innerHTML="<font color='red'><b>Jaza Bei Ya Kuuzia</b></font>";
		return false;
		}
	if(isNaN(document.item_description.sprice.value)) {
		document.getElementById("errmsg").innerHTML="<font color='red'><b>Bei Ya Kuuzia Sio Sahihi,Sio Namba</b></font>";
		return false;
		}
	if(parseInt (document.item_description.sprice.value) < parseInt (document.item_description.bprice.value)) {
		document.getElementById("errmsg").innerHTML="<font color='red'><b>Bei Ya Kuuzia Ni Ndogo Kuliko Bei Ya Kununulia</b></font>";
		return false;		
		}
	if(document.item_description.unit.value!="-1" && document.item_description.total_units.value=="") {
		document.getElementById("errmsg").innerHTML="<font color='red'><b>Huja Jaza Idadi Ya Units</b></font>";
		return false;		
		}
	if(document.item_description.total_units.value!="" && document.item_description.unit.value=="-1") {
		document.getElementById("errmsg").innerHTML="<font color='red'><b>Huja Chagua Unit</b></font>";
		return false;		
		}
	if(document.item_description.spriceunit.value!="" && isNaN(document.item_description.spriceunit.value)) {
		document.getElementById("errmsg").innerHTML="<font color='red'><b>Bei Ya Kuuzia Unit Sio Sahihi,Sio Namba</b></font>";
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
<form name="item_description">
<table>
<tr><td colspan="2" align="center"><h3>Sajili Bidhaa Mpya</h3></td></tr>
<tr style='background-color:#C0C0C0;'><td align="right">Jina La Bidhaa<font color="red">*</font></td><td><input type="text" name="item_name"></td></tr>
<tr style='background-color:#BCC6CC;'><td align="right">Bei Ya Kununulia Kwa Piece Moja<font color="red">*</font></td><td><input type="text" name="bprice"></td></tr>
<tr style='background-color:#C0C0C0;'><td align="right">Bei Ya Kuuzia Piece<font color="red">*</font></td><td><input type="text" name="sprice"></td></tr>
<tr style='background-color:#BCC6CC;'><td align="right">Unit</td><td><select name="unit" id="unit">
<option value="-1">---Chagua---</option>
<?php
$results=mysql_query("select id,name from units");
while($row=mysql_fetch_array($results)) {
	echo "<option value='$row[id]'>$row[name]</option>";
	}
?>
</select></td></tr>
<tr style='background-color:#C0C0C0;'><td align="right">Idadi Ya Units Katika Piece</td><td><input type="text" name="total_units"></td></tr>
<tr style='background-color:#BCC6CC;'><td align="right">Bei Ya Kuuzia Unit</td><td><input type="text" name="spriceunit"></td></tr>
<tr style='background-color:#BCC6CC;'><td colspan="2" align="center"><input type="button" name="button" value="Sajili Bidhaa" onclick="verify()"></td></tr>
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
