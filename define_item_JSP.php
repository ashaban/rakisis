<?php
include ("authentication.php");
if($_REQUEST["from"]=="process") {
	if($_REQUEST["unit"]=="-1")
	$unit="";
	else
	$unit=$_REQUEST["unit"];
	if (mysql_query("insert into items (name,buying_price,selling_price,unit,total_units,selling_price_unit) values ('$_REQUEST[item_name]','$_REQUEST[bprice]','$_REQUEST[sprice]','$unit','$_REQUEST[total_units]','$_REQUEST[spriceunit]')"))
	echo "Bidhaa Imesajiliwa Kikamilifu";
	else
	echo "Bidhaa Haijasajiliwa Kikamilifu,Rudia Tena";
	}	
?>