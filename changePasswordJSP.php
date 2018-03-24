<?php
session_start();
include('authentication.php');
$old=mysql_query("select passwd from users where id='$_SESSION[id]'") or die(mysql_error());
list($passwd)=mysql_fetch_array($old);
if($passwd!=md5($_REQUEST["old"]))
echo "Wrong Old Password";

else
{
$passwd=md5($_REQUEST["new1"]);
if (mysql_query("update users set passwd='$passwd' where id='$_SESSION[id]'"))
echo "Password Updated";
}

?>