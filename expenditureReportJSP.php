<?php
include ("includes/connection.php");

if($_REQUEST["from"]=="showReport")
{
$type=$_REQUEST["type"];
$from=$_REQUEST["fromdate"];
$to=$_REQUEST["todate"];

if($type=="all")
$results=mysql_query("select * from dailyExpenditures where date between '$from' and '$to'") or die(mysql_error());
else
$results=mysql_query("select * from dailyExpenditures where expId='$type' and date between '$from' and '$to'") or die(mysql_error());

if (mysql_num_rows($results)==0)
echo "<center><b>No Reports Found</b></center>";
else
{
echo "<tr style='background-color:#515151;color:white;font-family:Georgia, Times New Roman, Times, serif;font-weight:bold;font-size:13;'><th>SN</th><th>Expenditure Type</th><th>Description</th><th>Amount</th><th>Date</th></tr>";
$counter=1;
while ($row=mysql_fetch_array($results))
{
$remainder=$count%2;
if ($remainder==0)
$bgcolor='background-color:#A5E5E5;font-family:Geneva, Arial, Helvetica, sans-serif;';
else
$bgcolor='background-color:#E5E5E5;font-family:Geneva, Arial, Helvetica, sans-serif';
$count++;

if($row["expId"]==0)
$type=$row["others"];
else
list($type)=mysql_fetch_array(mysql_query("select type from expenditures where id='$row[expId]'"));

$amount=number_format($row["amount"]);
$date = date_create($row["date"]);
$date=date_format($date,"jS F Y");
echo "<tr style='$bgcolor'><td>$counter</td><td align='center'>$type</td><td align='center'>$row[description]</td><td align='center'>$amount</td><td align='center'>$date</td></tr>";
$counter++;
$totalExpenditure=$totalExpenditure+$row["amount"];
}
$totalExpenditure=number_format($totalExpenditure);
echo "<tr style='background-color:#515151;color:white;font-family:Georgia, Times New Roman, Times, serif;font-weight:bold;font-size:15;'><td colspan='5' align='center'><b>Total Expenditures $totalExpenditure</b></td></tr>";
}
}
?>
