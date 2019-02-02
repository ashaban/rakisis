<?php
include('authentication.php');
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript">
function checkPrice(str,requestor)
{
if (str==-1)
exit;
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
    if (requestor=="dispPrice")
    document.getElementById("price").innerHTML=xmlhttp.responseText; 
    else if(requestor=="diffPrice") 
    {
    document.getElementById("differentPrice").innerHTML="";  
    document.getElementById("differentPrice").innerHTML=xmlhttp.responseText;
    }
    }
  }
    if (requestor=="dispPrice")
xmlhttp.open("GET","addWholeSaleStockJSP.php?from=checkprice&id="+str,true);
    else if(requestor=="diffPrice")   
    {
xmlhttp.open("GET","addWholeSaleStockJSP.php?from=differentprice&id="+str,true);    
}
xmlhttp.send();
}

function process()
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
		document.getElementById("add_stock_btn").disabled = false;
		document.getElementById("infomsg").innerHTML=xmlhttp.responseText;
		document.getElementById("errmsg").innerHTML="";
		document.getElementById("item_name").selectedIndex=0;
		document.getElementById("price").innerHTML="";
		document.whole_stock.quantity.value="";		
    }
  }
  var item_name=document.whole_stock.item_name.value;
  var quantity=document.whole_stock.quantity.value;
  if(document.getElementById("diffPrice")!=null)
  var diffPrice=document.getElementById("diffPrice").value;
  else
  var diffPrice="";  
  var price=document.whole_stock.price.value;  
  var exp_date=document.whole_stock.exp_date.value;
  var date_stocked=document.whole_stock.date_stocked.value;
xmlhttp.open("GET","addWholeSaleStockJSP.php?from=process&item_name="+item_name+"&quantity="+quantity+"&diffPrice="+diffPrice+"&price="+price+"&exp_date="+exp_date+"&date_stocked="+date_stocked,true);
xmlhttp.send();
}

function verify() {	
	document.getElementById("add_stock_btn").disabled = true;
	if(document.getElementById("diffPrice")!=null) {
		if(document.getElementById("diffPrice").value=="" || document.getElementById("diffPrice").value=="Bei Mpya") {
			document.getElementById("add_stock_btn").disabled = false;
			document.getElementById("errmsg").innerHTML="<font style='color:red'><b><center>Lazima Uweke Bei Yakununulia</center></b></font>";
			return false;	
			}
		}
	if(document.whole_stock.quantity.value=="") {
		document.getElementById("add_stock_btn").disabled = false;
		document.getElementById("errmsg").innerHTML="<font style='color:red'><b><center>Idadi Ya Box Lazima Iwekwe</center></b></font>";
		return false;
		}
	if(isNaN(document.whole_stock.quantity.value)) {
		document.getElementById("add_stock_btn").disabled = false;
		document.getElementById("errmsg").innerHTML="<font style='color:red'><b><center>Idadi Ya Box Lazima Iwe Namba</center></b></font>";
		return false;
		}
	if(document.whole_stock.item_name.value=="-1") {
		document.getElementById("add_stock_btn").disabled = false;
		document.getElementById("errmsg").innerHTML="<font style='color:red'><b><center>Chagua Jina La Bidhaa</center></b></font>";
		return false;
		}	
process()
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
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
      <script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
      <link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
      <link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css">
       <script type="text/javascript" src="calendarDateInput.js">
</script>
</head>
<body style="background-color:white;font: normal 8pt/13pt verdana, arial,sans-serif;">
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
	<div id="infomsg"></div>
	<div id="errmsg"></div>
	<center>
	<form method="POST" name="whole_stock">
	<table>
	<tr><td colspan="2" align="center"><h3>Ongeza Mzigo Stock (Makao Makuu)</h3></td></tr>
	<tr style='background-color:#C0C0C0;'><td align="right">Jina La Bidhaa</td><td><select id="item_name" name="item_name" onchange="checkPrice(this.value,'dispPrice')">
	<option value='-1'>---Chagua---</option>
	<?php
	list($batch)=mysql_fetch_array(mysql_query("select max(id) from wholeStock"));
	$batch=$batch+1;
	$items=mysql_query("select id,name,unit,total_units from items order by name");
while($row=mysql_fetch_array($items))
{
list($unit_name)=mysql_fetch_array(mysql_query("select name from units where id='$row[unit]'"));
if($row["total_units"]==0)
$total_units="";
else
$total_units=$row["total_units"];
echo "<option value='$row[id]'>$row[name] $unit_name $total_units</option>";
}
?>
</td></tr>

<tr id="price" style='background-color:#C0C0C0;'></tr>

	<tr style='background-color:#BCC6CC;'><td align="right">Idadi Ya Pieces</td><td><span id="sprytextfield1">
        <label><input type="text" name="quantity"></label><span class="textfieldRequiredMsg">Idadi Ya Pieces Inahitajika.</span><span class="textfieldInvalidFormatMsg">Weka Namba Pekee.</span></span></td></tr>
	<tr style='background-color:#C0C0C0;'><td align="right">Batch Number</td><td><input type="text" readonly="true" name="batch" value="<?php echo 'Batch '.$batch;?>"></td></tr>	
	<tr style='background-color:#BCC6CC;'><td align="right">Expire Date</td><td><script>DateInput('exp_date', true, 'YYYY-MM-DD')</script></td></tr>		
	<tr style='background-color:#C0C0C0;'><td>Tarehe Ya Kuingiza Mzigo</td><td><script>DateInput('date_stocked', true, 'YYYY-MM-DD')</script></td></tr>	
	<tr style='background-color:#BCC6CC;'><td colspan="2" align="center"><input type="button" id="add_stock_btn" name="submit" onclick='return verify()' value="Ingiza Mzigo Stock"></td></tr>
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
	<p>&copy;2014 All Rights Reserved. &nbsp;&bull;&nbsp; Developed by Ally Shaban
</div>
      
</body>
</html>
