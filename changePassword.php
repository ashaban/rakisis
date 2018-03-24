<?php
include('authentication.php');
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript">
function verify()
{
		var old=document.change_passwd.old.value;
		var new1=document.change_passwd.new1.value;
		var new2=document.change_passwd.new2.value;
		
		if(new1==new2 & (new1!="" | new2!=""))
		{
		verify_old(old,new1);
		return false;
		}
		
		else if(new1=="" | new2=="")
		{
			document.getElementById("errmsg").innerHTML="Make sure You Fill All Fields";
			return false;
		}
		
		else
		{
		document.getElementById("errmsg").innerHTML="New Passwords Mismatch";
		document.getElementById("new1").style.borderColor="red";
		document.getElementById("new2").style.borderColor="red";
		return false;
		}
}
	
function verify_old(old,new1)
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
    	var output=xmlhttp.responseText;   	
    	if(output.indexOf("Wrong Old Password")>0)
    	document.getElementById("errmsg").innerHTML="Wrong Old Password";
    
    	else if(output.indexOf("Password Updated")>0)
    	{
    	document.getElementById("errmsg").innerHTML="";
    	document.getElementById("changePasswd").innerHTML="Password Updated";
    	}
    }
  }
xmlhttp.open("GET","changePasswordJSP.php?old="+old+"&new1="+new1,true);
xmlhttp.send();
}
</script>
<title>Edit Item</title>
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
<center><div id="errmsg" style="color:red;font-weight:bold;"></div></center>
<form name="change_passwd" method="POST" action="#">
<table align="center" id="changePasswd">
<tr><td align="right">Old Password</td><td><input type="password" name="old" id="old"></td></tr>
<tr><td align="right">New Password</td><td><input type="password" name="new1" id="new1"></td></tr>
<tr><td align="right">Confirm New Password</td><td><input type="password" name="new2" id="new2"></td></tr>
<tr><td colspan="2" align='center'><input type="submit" onclick="return verify()" value="Update Password"></td></tr>
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
