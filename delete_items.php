<?php
include('authentication.php');
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript">
function deleteItem(id, name) {
let conf = confirm("Unahakika unataka kufuta bidhaa " + name)
if(!conf)
return false


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
    document.getElementById("response").innerHTML= name + " imefutwa "; 
    }
  }

xmlhttp.open("GET","delete_items_JSP.php?id="+id,true);
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
<div id="msg"></div>
<div id="response"></div>
<?php
$results = mysql_query("select * from items");
echo "<table>
<tr style='background-color:#515151;color:white;font-family:Georgia, Times New Roman, Times, serif;font-weight:bold;font-size:13;'>
<th>SN</th><th>Name</th><th>Buying Price</th><th>Selling Price</th><th>Action</th>
</tr>";
$counter = 1;
while($row = mysql_fetch_array($results)) {
$remainder=$count%2;
if ($remainder==0)
$bgcolor='background-color:#A5E5E5;font-family:Geneva, Arial, Helvetica, sans-serif;';
else
$bgcolor='background-color:#E5E5E5;font-family:Geneva, Arial, Helvetica, sans-serif';
$count++;
$name= $row["name"];
$id = $row["id"];
echo "<tr style='$bgcolor'><td>$counter</td><td>$row[name]</td><td>$row[buying_price]</td><td>$row[selling_price]</td>";
echo "<td><input type='button' value='Delete' onclick='deleteItem(\"$id\",\"$name\")'></td></tr>";
$counter++;
}
echo "</table>";
?>
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
