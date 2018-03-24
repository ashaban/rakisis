<?php
include("authentication.php");
if ($_REQUEST["from"]=="checkprice")
{
list($price)=mysql_fetch_array(mysql_query("select buying_price from items where id='$_REQUEST[id]'"));
$price=number_format($price);
echo "<td align='right'>Bei Ya Kununulia Kwa Piece</td><td>";
?>
<select name='price' id='price' onChange="checkPrice(this.value,'diffPrice')"><option><?php echo $price;?></option><option>Badili Bei</option></select>
<font id='differentPrice'></font></td>
<?php
}

else if ($_REQUEST["from"]=="differentprice")
{
if ($_REQUEST["id"]=="Badili Bei")
echo "<input type='text' id='diffPrice' name='diffPrice' value='Bei Mpya' onclick=\"if (this.value=='Bei Mpya') this.value=''\">";
}

else if($_REQUEST["from"]=="process") {
	list($branch_id) = mysql_fetch_array(mysql_query("select id from branches where type='hq'"));
	if ($_REQUEST["diffPrice"]=="") {	
	$price=str_replace(",","",$_REQUEST["price"]);
	if(mysql_query("insert into wholeStock (itemId,quantity,available,buying_price,date_stocked,expire_date,branch_id) values ('$_REQUEST[item_name]','$_REQUEST[quantity]','$_REQUEST[quantity]','$price','$_REQUEST[date_stocked]','$_REQUEST[exp_date]',$branch_id)") or die (mysql_error()))
	echo "<center><b>Bidhaa Imeongezwa Kwenye Stock Ya Jumla Kikamilifu</b></center>";
	else
	echo "<center><b>Kumetokea Tatizo Katika Kuingiza Bidhaa Kwenye Stock Ya Jumala,Jaribu Tena</b></center>";
	}

	else
	{
	$price=str_replace(",","",$_REQUEST["diffPrice"]);
	if(mysql_query("insert into wholeStock (itemId,quantity,available,buying_price,date_stocked,expire_date,branch_id) values ('$_REQUEST[item_name]','$_REQUEST[quantity]','$_REQUEST[quantity]','$price','$_REQUEST[date_stocked]','$_REQUEST[exp_date]',$branch_id)") or die (mysql_error()))
	echo "<center><b>Bidhaa Imeongezwa Kwenye Stock Kikamilifu</b></center>";
	else
	echo "<center><b>Kumetokea Tatizo Katika Kuingiza Bidhaa Kwenye Stock</b></center>";
	}
	}
?>
