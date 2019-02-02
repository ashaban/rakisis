<?php
include('authentication.php');
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript">
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
    document.getElementById("empl_btn").disabled = false;
    document.getElementById("info").innerHTML="<font color='red'><img src='images/information.jpg' width='30' height='30'>"+xmlhttp.responseText+"</font>";
    document.getElementById("errmsg").innerHTML="";
    document.hire.fname.value="";
    document.hire.other.value="";
    document.hire.surname.value="";
    document.hire.salary.value="";
    document.hire.ephone.value="";
    document.hire.emergency_phone.value="";
    document.hire.emergency_name.value="";
    document.hire.emergency_relation.value="";
    document.getElementById("designation").selectedIndex=0;    
    }
  }

xmlhttp.open("GET","add_employee_JSP.php?from=process&fname="+document.hire.fname.value+"&mname="+document.hire.other.value+"&surname="+document.hire.surname.value+"&salary="+document.hire.salary.value+"&designation="+document.hire.designation.value+"&date_hired="+document.hire.date_hired.value+"&ephone="+document.hire.ephone.value+"&emergency_phone="+document.hire.emergency_phone.value+"&emergency_name="+document.hire.emergency_name.value+"&emergency_relation="+document.hire.emergency_relation.value,true);
xmlhttp.send();
}

function verify_data() {
document.getElementById("empl_btn").disabled = true;
	if(document.hire.fname.value=="") {
		document.getElementById("empl_btn").disabled = false;
		document.getElementById("errmsg").innerHTML="<font color='red'><b>Jina La Kwanza La Mtumishi Halijajazwa</b></font>";
		return false;
		}
	if(document.hire.surname.value=="") {
		document.getElementById("empl_btn").disabled = false;
		document.getElementById("errmsg").innerHTML="<font color='red'><b>Jina La Mwishoa Halijajazwa</b></font>";
		return false;
		}
	if(document.hire.salary.value=="") {
		document.getElementById("empl_btn").disabled = false;
		document.getElementById("errmsg").innerHTML="<font color='red'><b>Mshahara Haujajazwa</b></font>";
		return false;
		}
	if(document.hire.designation.value=="-1") {
		document.getElementById("empl_btn").disabled = false;
		document.getElementById("errmsg").innerHTML="<font color='red'><b>Cheo Cha Mtumishi Hakijachaguliwa</b></font>";
		return false;
		}
	if(document.hire.ephone.value=="") {
		document.getElementById("empl_btn").disabled = false;
		document.getElementById("errmsg").innerHTML="<font color='red'><b>Simu Ya Mtumishi Haijajazwa</b></font>";
		return false;
		}
	if(document.hire.emergency_phone.value=="") {
		document.getElementById("empl_btn").disabled = false;
		document.getElementById("errmsg").innerHTML="<font color='red'><b>Simu Ya Mtu Wa Kuwasiliana Nae Panapodharula Haijajazwa</b></font>";
		return false;
		}
	if(document.hire.emergency_name.value=="") {
		document.getElementById("empl_btn").disabled = false;
		document.getElementById("errmsg").innerHTML="<font color='red'><b>Jina La Mtu Wakuwasiliana Nae Panapo Dharula Halijajazwa</b></font>";
		return false;
		}
	if(isNaN(document.hire.salary.value)) {
		document.getElementById("empl_btn").disabled = false;
		document.getElementById("errmsg").innerHTML="<font color='red'><b>Mshahara Lazima Uwe Namba</b></font>";
		return false;
		}
		
		process();
	}
</script>
<script type="text/javascript" src="calendarDateInput.js">
</script>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Add Employee</title>
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
	<div id="info"></div>
<form name="hire">
<table>
<tr><td colspan="2" align="center"><h3>Hire New Employee</h3></td></tr>
<tr style='background-color:#C0C0C0;'><td align="right">Jina La Kwanza<font style="color:red">*</font></td><td><input type="text" name="fname" size="30"></td></tr>
<tr style='background-color:#BCC6CC;'><td align="right">Jina La Kati</td><td><input type="text" name="other" size="30"></td></tr>
<tr style='background-color:#C0C0C0;'><td align="right">Jina La Mwisho<font style="color:red">*</font></td><td><input type="text" name="surname" size="30"></td></tr>
<tr style='background-color:#BCC6CC;'><td align="right">Mshahara (Basic Salary)<font style="color:red">*</font></td><td><input type="text" name="salary" size="10"></td></tr>
<tr style='background-color:#C0C0C0;'><td align="right">Cheo Cha Mtumishi<font style="color:red">*</font></td><td>
<select name="designation" id="designation">
<option value="-1">---Chagua---</option>
<?php
$results=mysql_query("select * from designation");
while($row=mysql_fetch_array($results)) {
	echo "<option value='$row[id]'>$row[name]</option>";
	}
?>
</select>
</td></tr>
<tr style='background-color:#BCC6CC;'><td align="right">Tarehe Ya Kuajiriwa<font style="color:red">*</font></td><td><script>DateInput('date_hired', true, 'YYYY-MM-DD')</script></td></tr>
<tr style='background-color:#C0C0C0;'><td align="right">Namba Ya Simu Ya Mtumishi<font style="color:red">*</font></td><td><input type="text" name="ephone"></td></tr>
<tr style='background-color:#BCC6CC;'><td align="right">Jina La Mtu Wa Kuwasiliana Nae Ikitokea Dharula<font style="color:red">*</font></td><td><input type="text" name="emergency_name" size="30"></td></tr>
<tr style='background-color:#C0C0C0;'><td align="right">Mahusiano Na Mtu Wa Kuwasiliana Nae Ikitokea Dharula</td><td><input type="text" name="emergency_relation"></td></tr>
<tr style='background-color:#BCC6CC;'><td align="right">Namba Ya Simu Ya Mtu Wa Kuwasiliana Nae Ikitokea Dharula<font style="color:red">*</font></td><td><input type="text" name="emergency_phone"></td></tr>
<tr style='background-color:#C0C0C0;'><td colspan="2" align="center"><input type="button" id='empl_btn' onclick="verify_data()" value="Ajiri"></td></tr>
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
