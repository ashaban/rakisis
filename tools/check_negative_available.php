<?php
mysql_connect("localhost","root","tajiri");
mysql_select_db("haneinInvestment");
echo"<table><tr><th>stock id</th><th>Stocked</th><th>Sold</th><th>date stocked</th><th>available</th></tr>";
$results=mysql_query("select * from stockBatches where available<0");
while($row=mysql_fetch_array($results))
{
list($total_sold)=mysql_fetch_array(mysql_query("select sum(quantity) from sales where batchNumber='$row[id]' and type='whole'"));
echo "<tr><td>$row[id]</td><td>$row[quantity]</td><td>$total_sold</td><td>$row[date]</td><td>$row[available]</td></tr>";
}
?>
