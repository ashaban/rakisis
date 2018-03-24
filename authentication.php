<?php
@session_start();
if (!$_SESSION['id'])
{
echo '<style type="text/css">
<!--
.style4 {
	color: #FF0000;
	font-family: Arial, Helvetica, sans-serif;
}
-->
</style>';
echo "<table bgcolor='#CCCCCC' width='100%' border='0'  height='100%'align='center'>
<tr><td valign='top'>";
echo "<br><br><br><br><br><br><br><br><br><br><br><br><div align='center' class='style4'><b>Your not authorised to access this page!</b><br>
<a href='index.php' title='login first'>Login</a>
</div>";
echo "</td></tr>
</table>";
exit();
}
include ("includes/connection.php");
?>