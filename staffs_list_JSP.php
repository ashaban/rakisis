<?php
include "authentication.php";
include("months.php");
if ($_REQUEST["from"]=="search_employees")
{
$name=$_REQUEST["name"];
$contract=$_REQUEST["contract"];

$result=mysql_query("select * from employees where firstname like '$name%' and status like '%$contract%'") or die(mysql_error());
if (mysql_num_rows($result)==0)
echo "No Employees Found";
else
{
echo "<div id='errmsg'></div>";
echo "<table><tr><td colspan='8' align='center'><h3>ORODHA YA WATUMISHI</h3></td></tr><tr style='background-color:#515151;color:white;font-family:Georgia, Times New Roman, Times, serif;font-weight:bold;font-size:13;'><th>SN</th><th>Jina Kamili</th><th>Cheo</th><th>Tarehe Ya Kuajiriwa</th><th>Mshahara Aloanzia</th><th>Mshahara Wa Sasa</th><th>Hali Ya Mkataba</th><th>Mawasiliano Ikitokea Dharula</th></tr>";
	while ($row=mysql_fetch_array($result)) {
		$remainder=$count%2;
		if ($remainder==0)
		$bgcolor='background-color:#A5E5E5;font-family:Geneva, Arial, Helvetica, sans-serif;';
		else
		$bgcolor='background-color:#E5E5E5;font-family:Geneva, Arial, Helvetica, sans-serif';
		$count++;
		if($row["status"]=="employee")
		$status="Mtumishi";
		if($row["status"]=="terminated")
		$status="Mkataba Umesitishwa";
		$date_hired=date("m-d-Y",strtotime($row["date_hired"]));
		list($designation)=mysql_fetch_array(mysql_query("select name from designation where id='$row[designation]'"));
	echo "<tr style='$bgcolor'><td>$count</td><td>$row[firstname] $row[middlename] $row[surname]</td><td>$designation</td><td>$date_hired</td><td>".number_format($row["salary"])."</td><td>".number_format($row["salary"])."</td><td>$status</td><td>Jina:<b>$row[emergency_name]</b></br>Uhusiano:<b>$row[emergency_relation]</b></br>Simu:<b>$row[emergency_phone]</b></br></td></tr>";
	}
}
}
?>