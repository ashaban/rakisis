<?php
include ("authentication.php");
if($_REQUEST["from"]=="process") {
	if (mysql_query("insert into units (name) values ('$_REQUEST[unit_name]')"))
	echo "Unit Imesajiliwa Kikamilifu";
	else
	echo "Unit Haijasajiliwa Kikamilifu,Rudia Tena";
	}	
?>