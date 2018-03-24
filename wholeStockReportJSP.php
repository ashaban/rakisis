<?php
include ("authentication.php");
if ($_REQUEST["from"]=="showReport")
{
$beg_date=$_REQUEST["beg_date"];
$end_date=$_REQUEST["end_date"];
$source_branch=$_REQUEST["branch"];
if($_REQUEST["id"]=="All")
$results=mysql_query("select name,id,total_units,unit from items order by name asc");
else
$results=mysql_query("select name,id,total_units,unit from items where id='$_REQUEST[id]'");
$count=0;
echo "<tr><td colspan='12' align='center'><h3>RIPOTI YA STOCK</h3></td></tr><tr style='background-color:#515151;color:white;font-family:Georgia, Times New Roman, Times, serif;font-weight:bold;font-size:14;'><th>SN</td><th>Jina La Bidhaa</th><th colspan='2'>Kianzio</th><th colspan='2'>Kilichoingia</th><th colspan='2'>Kilichotoka</th><th colspan='2'>Kilichouzwa</th><th colspan='2'>Kilichobaki (Balance)</th></tr>";
echo "<tr style='background-color:green;color:white;font-family:Georgia, Times New Roman, Times, serif;font-weight:bold;font-size:14;font-style:italic'><th style='background-color:#515151;'>&nbsp;</th><th style='background-color:#515151;'>&nbsp;</th><th>Idadi</th><th>Cash</th><th>Idadi</th><th>Cash</th><th>Idadi</th><th>Cash</th><th>Idadi</th><th>Cash</th><th>Idadi</th><th>Cash</th></tr>";
while ($row=mysql_fetch_array($results))
{
//calculating opening balance
$op_query=mysql_query("select quantity,id,buying_price,date_stocked from wholeStock where itemId='$row[id]' and date_stocked<'$beg_date' and branch_id='$source_branch'");
while($op_row=mysql_fetch_array($op_query))
{
list($quantity_sold)=mysql_fetch_array(mysql_query("select sum(quantity) from sales where type='whole' and itemId='$row[id]' and batchNumber='$op_row[id]' and date>='$op_row[date]' and date<'$beg_date' and branch_id='$source_branch'"));
$opening_balance=$op_row["quantity"]-$quantity_sold+$opening_balance;
$opening_cash=$op_row["buying_price"]*($op_row["quantity"]-$quantity_sold)+$opening_cash;
$quantity_sold=0;
}
//end of calculating opening balance

//Calculating Inward Quantity
list($quantity_inward)=mysql_fetch_array(mysql_query("select sum(quantity) from wholeStock where itemId='$row[id]' and date_stocked between '$beg_date' and '$end_date' and branch_id='$source_branch'"));

//calculating Inward Cash
list($inward_cash)=mysql_fetch_array(mysql_query("select sum(buying_price*quantity) from wholeStock where itemId='$row[id]' and date_stocked between '$beg_date' and '$end_date' and branch_id='$source_branch'"));

//calculating outward quantity
list($quantity_outward)=mysql_fetch_array(mysql_query("select sum(quantity_transfered) from items_transfer where itemId='$row[id]' and date_transfered between '$beg_date' and '$end_date' and source_branch='$source_branch'"));

//calculating Outward Cash
$out=mysql_query("select * from items_transfer where itemId='$row[id]' and date_transfered between '$beg_date' and '$end_date' and source_branch='$source_branch'");
while($row_out=mysql_fetch_array($out)) {
	list($bprice)=mysql_fetch_array(mysql_query("select buying_price from wholeStock where id='$row_out[stock_id_from]'"));	
	$outward_cash=$outward_cash+($bprice*$row_out["quantity_transfered"]);
	}

//calculating Sales Quantity
list($quantity_sold)=mysql_fetch_array(mysql_query("select sum(quantity) from sales where itemId='$row[id]' and date between '$beg_date' and '$end_date' and type='whole' and branch_id='$source_branch' and batchNumber in(select id from wholeStock where  branch_id='$source_branch')"));

//calculating Sales Cash and total buying price of sold items
$sales_query=mysql_query("select batchNumber,quantity,(quantity*price) as cash from sales where itemId='$row[id]' and date between '$beg_date' and '$end_date' and type='whole' and branch_id='$source_branch' and batchNumber in(select id from wholeStock where branch_id='$source_branch')");
while($sales_row=mysql_fetch_array($sales_query))
{
$sales_cash=$sales_cash+$sales_row["cash"];
list($buying_price)=mysql_fetch_array(mysql_query("select buying_price from wholeStock where id='$sales_row[batchNumber]'"));
$buying_price_of_sold=($buying_price*$sales_row["quantity"])+$buying_price_of_sold;
}

//calculating closing cash
$closing_cash=$opening_cash+$inward_cash-$buying_price_of_sold-$outward_cash;
$closing_balance=$opening_balance+$quantity_inward-$quantity_sold-$quantity_outward;

$total_inward_quantity=$total_inward_quantity+$quantity_inward;
$total_outward_quantity=$total_outward_quantity+$quantity_outward;
$total_opening_balance=$total_opening_balance+$opening_balance;
$total_sales_quantity=$total_sales_quantity+$quantity_sold;
$total_closing_balance=$total_closing_balance+$closing_balance;

$total_sales_cash=$total_sales_cash+$sales_cash;
$total_inward_cash=$inward_cash+$total_inward_cash;
$total_outward_cash=$total_outward_cash+$outward_cash;
$total_opening_cash=$opening_cash+$total_opening_cash;
$total_closing_cash=$closing_cash+$total_closing_cash;

$opening_balance=number_format($opening_balance);
$quantity_inward=number_format($quantity_inward);
$quantity_outward=number_format($quantity_outward);
$quantity_sold=number_format($quantity_sold);
$closing_balance=number_format($closing_balance);

$sales_cash=number_format($sales_cash,2);
$inward_cash=number_format($inward_cash,2);
$outward_cash=number_format($outward_cash,2);
$opening_cash=number_format($opening_cash,2);
$closing_cash=number_format($closing_cash,2);

$remainder=$count%2;
if ($remainder==0)
$bgcolor='background-color:#A5E5E5;font-family:Geneva, Arial, Helvetica, sans-serif;';
else
$bgcolor='background-color:#E5E5E5;font-family:Geneva, Arial, Helvetica, sans-serif';
$count++;

echo "<tr style='$bgcolor'>";
echo "<td align='center'>$count</td><td align='center'>$row[name]</td><td align='center'>$opening_balance</td><td align='center'>$opening_cash</td><td align='center'>$quantity_inward</td><td align='center'>$inward_cash</td><td align='center'>$quantity_outward</td><td align='center'>$outward_cash</td><td align='center'>$quantity_sold</td><td align='center'>$sales_cash</td><td align='center'>$closing_balance</td><td align='center'>$closing_cash</td></tr>";

$opening_balance=0;
$inward_cash=0;
$opening_cash=0;
$sales_cash=0;
$buying_price_of_sold=0;
$closing_cash=0;
$closing_balance=0;
$outward_cash=0;
}
$total_sales_cash=number_format($total_sales_cash,2);
$total_opening_cash=number_format($total_opening_cash,2);
$total_inward_cash=number_format($total_inward_cash,2);
$total_outward_cash=number_format($total_outward_cash,2);
$total_closing_cash=number_format($total_closing_cash,2);

$total_opening_balance=number_format($total_opening_balance);
$total_inward_quantity=number_format($total_inward_quantity);
$total_closing_balance=number_format($total_closing_balance);
$total_sales_quantity=number_format($total_sales_quantity);

$remainder=$count%2;
if ($remainder==0)
$bgcolor='background-color:#A5E5E5;font-family:Geneva, Arial, Helvetica, sans-serif;';
else
$bgcolor='background-color:#E5E5E5;font-family:Geneva, Arial, Helvetica, sans-serif';

echo "<tr style='background-color:#515151;font-size:14;font-weight:bold;color:white;font-family:Georgia, 'Times New Roman', Times, serif;'>";
echo "<td colspan='2' align='right'><b>Total</b></td><td align='center'>$total_opening_balance</td><td align='center'>$total_opening_cash TSH</td><td align='center'>$total_inward_quantity</td><td align='center'>$total_inward_cash TSH</td><td align='center'>$total_outward_quantity</td><td align='center'>$total_outward_cash TSH</td><td align='center'>$total_sales_quantity</td><td align='center'><b>$total_sales_cash TSH</b></td><td align='center'>$total_closing_balance</td><td>$total_closing_cash TSH</td></tr>";
}
?>
