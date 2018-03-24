<?php
include("authentication.php");
if($_REQUEST["from"]=="process") {
	if(mysql_query("insert into designation (name) values('$_REQUEST[des_name]')") or die(mysql_error()))
	echo "Cheo Kimesajiliwa Kikamilifu";
	else 
	echo "Kuna Tatizo Limetokea Wakati Wa Kusajili Cheo,Rudia Tena";
	}
?>