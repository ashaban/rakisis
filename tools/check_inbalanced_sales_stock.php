<?php
mysql_connect("localhost","root","tajiri");
mysql_select_db("haneinInvestment");
echo"<table><tr><th>stock id</th><th>stocked</th><th>sold</th><th>date stocked</th><th>available</th></tr>";
$results=mysql_query("select * from stockBatches");
while($row=mysql_fetch_array($results))
{
list($quantity_sold)=mysql_fetch_array(mysql_query("select sum(quantity) from sales where type='whole' and batchNumber='$row[id]'"));
$quantity_sold_db=$row["quantity"]-$row["available"];
if($quantity_sold!=$quantity_sold_db)
echo "<tr><td>$row[id]</td><td>$row[quantity]</td><td>$quantity_sold</td><td>$row[date]</td><td>$row[available]</td></tr>";
}
?>
