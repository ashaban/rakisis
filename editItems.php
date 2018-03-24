<?php
include('authentication.php');
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript">
function showDescriptions(id)
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
    document.getElementById("descriptions").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","editItemsJSP.php?from=showDescriptions&id="+id,true);
xmlhttp.send();
}

function inlineEdit(id,count)
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
    document.getElementById(id).innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","editItemsJSP.php?from=inlineEdit&id="+id+"&count="+count,true);
xmlhttp.send();
}

function delete_this(id,count)
{
if(!confirm("Unauhakika Unataka Kufuta Hii Bidhaa?"))
exit();
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
    document.getElementById("items").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","editItemsJSP.php?from=delete&id="+id+"&count="+count,true);
xmlhttp.send();
}

function save(id,count)
{
document.getElementById("errmsg").innerHTML="";
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
    document.getElementById("errmsg").innerHTML="<b><font color='red'><img src='images/information.jpg' width='30' height='30'>Mabadiliko Yamesajiliwa</font></b>";
    showDescriptions(id);
    }
  }
var itemname="itemName"+count
var bprice="bprice"+count
var spricec="spricec"+count
var spriceb="spriceb"+count
var pieces="pieces"+count
itemname=document.forms["updating"][itemname].value
bprice=document.forms["updating"][bprice].value
spriceb=document.forms["updating"][spriceb].value
spricec=document.forms["updating"][spricec].value
pieces=document.forms["updating"][pieces].value
xmlhttp.open("GET","editItemsJSP.php?from=save&id="+id+"&count="+count+"&itemname="+itemname+"&bprice="+bprice+"&spricec="+spricec+"&spriceb="+spriceb+"&pieces="+pieces,true);
xmlhttp.send();
}

function verify(id,count)
{
var itemname="itemName"+count
var bprice="bprice"+count
var spricec="spricec"+count
var spriceb="spriceb"+count
var pieces="pieces"+count
itemname=document.forms["updating"][itemname].value
bprice=document.forms["updating"][bprice].value
spriceb=document.forms["updating"][spriceb].value
spricec=document.forms["updating"][spricec].value
pieces=document.forms["updating"][pieces].value

if(itemname=="" || !isNaN(itemname))
{
document.getElementById("errmsg").innerHTML="<b><font color='red'><img src='images/error.jpg' width='30' height='30'>Jina La Bidhaa Lazima Lijazwe</font></b>";
exit;
}

if(bprice=="" || isNaN(bprice))
{
document.getElementById("errmsg").innerHTML="<b><font color='red'><img src='images/error.jpg' width='30' height='30'>Bei Yakununulia Lazime Ijazwe Na Iwe Namba</font></b>";
exit;
}

if(spricec=="" || isNaN(spricec))
{
document.getElementById("errmsg").innerHTML="<b><font color='red'><img src='images/error.jpg' width='30' height='30'>Bei Ya Kuuzia Kwa Box Lazima Ijazwe Na Iwe Namba</font></b>";
exit;
}

if(spriceb=="" || isNaN(spriceb))
{
document.getElementById("errmsg").innerHTML="<b><font color='red'><img src='images/error.jpg' width='30' height='30'>Bei Ya Kuuzia Kwa Piece Lazima Ijazwe Na Iwe Namba</font></b>";
exit;
}

if(pieces=="" || isNaN(pieces))
{
document.getElementById("errmsg").innerHTML="<b><font color='red'><img src='images/error.jpg' width='30' height='30'>Idadi Ya Pieces Katika Box Lazima Ijazwe Naiwe Namba</font></b>";
exit;
}
save(id,count)
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
<div id="errmsg"></div>
<form name="updating">	
<table>
	<tr><td valign="top">Jina La Bidhaa</td><td valign="top"><select name="itemname" onchange="showDescriptions(this.value)">
	<option value='-1'>---Chagua---</option>
	<?php	
	$items=mysql_query("select id,name from items order by name");
while($row=mysql_fetch_array($items))
{
echo "<option value='$row[id]'>$row[name]</option>";
}
?>
</td>
</tr>
</table>
<table>
<tr><td id="descriptions"></td></tr>
<table>
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
