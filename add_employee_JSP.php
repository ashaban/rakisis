<?php
include("authentication.php");
if($_REQUEST["from"]=="process") {
	if(mysql_query("insert into employees (firstname,middlename,surname,salary,employee_phone,emergency_phone,emergency_name,emergency_relation,date_hired,designation) values('$_REQUEST[fname]','$_REQUEST[mname]','$_REQUEST[surname]','$_REQUEST[salary]','$_REQUEST[ephone]','$_REQUEST[emergency_phone]','$_REQUEST[emergency_name]','$_REQUEST[emergency_relation]','$_REQUEST[date_hired]','$_REQUEST[designation]')") or die(mysql_error()))
	echo "Mtumishi Kaajiriwa Kikamilifu";
	else 
	echo "Kuna Tatizo Limejitokeza Wakati Wakuajili Mtumishi,Rudia Tena";
	}
?>