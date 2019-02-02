<?php
include ("includes/connection.php");
$id = $_REQUEST["id"];
mysql_query("delete from items where id=$id");
return
?>
