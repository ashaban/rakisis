<?php
include ("includes/connection.php");
include ("includes/functions/salesReport.php");

if($_REQUEST["from"]=="showBatch")
{
echo "Select Batch<select name='batch'>";
echo "<option value='all'>All Batches</option>";
if ($_REQUEST["id"]=="all")
$batches=mysql_query("select id,date from wholeStock order by date DESC");
else if($_REQUEST["id"]!="all")
$batches=mysql_query("select id,date from wholeStock where itemId='$_REQUEST[id]' order by date_stocked DESC");
while($row=mysql_fetch_array($batches))
{
$date = date_create($row["date"]);
$date=date_format($date,"jS F Y");
echo "<option value='$row[id]'>Batch $row[id] ($date)</option>";
}
}

if($_REQUEST["from"]=="showReport")
{
$itemId=$_REQUEST["item"];
$from=$_REQUEST["fromdate"];
$to=$_REQUEST["todate"];
$batch=$_REQUEST["batch"];

//whole sale report
salesReport("delete","whole",$from,$to,$itemId,$batch);

//Retail Sale Report
salesReport("delete","retail",$from,$to,$itemId,$batch);
}

if($_REQUEST["from"]=="delete")
{
$sales_id=$_REQUEST["id"];
list($stock_id,$quantity_sold)=mysql_fetch_array(mysql_query("select batchNumber,quantity from sales where id='$sales_id'"));
if($_REQUEST["sale_type"]=="whole")
list($available)=mysql_fetch_array(mysql_query("select available from wholeStock where id='$stock_id'"));
else if($_REQUEST["sale_type"]=="retail")
list($available)=mysql_fetch_array(mysql_query("select available from retailStock where id='$stock_id'"));
$available=$available+$quantity_sold;
if($_REQUEST["sale_type"]=="whole")
{
if(mysql_query("delete from sales where id='$sales_id'") and mysql_query("update 	wholeStock set available='$available' where id='$stock_id'"))
echo "deleted";
else
echo "failed";
}
else if($_REQUEST["sale_type"]=="retail")
{
if(mysql_query("delete from sales where id='$sales_id'") and mysql_query("update 	retailStock set available='$available' where id='$stock_id'"))
echo "deleted";
else
echo "failed";
}
}
?>