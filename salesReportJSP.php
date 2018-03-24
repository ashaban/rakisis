<?php
include ("authentication.php");
include ("includes/functions/salesReport.php");

if($_REQUEST["from"]=="showBatch")
{
echo "Select Batch<select name='batch'>";
echo "<option value='all'>All Batches</option>";
if ($_REQUEST["id"]=="all")
$batches=mysql_query("select id,date from stockBatches order by date DESC");
else if($_REQUEST["id"]!="all")
$batches=mysql_query("select id,date from stockBatches where itemId='$_REQUEST[id]' order by date DESC");
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
$branch_id=$_REQUEST["branch"];
//whole sale report
salesReport("report","whole",$from,$to,$itemId,$batch,$branch_id);

//Retail Sale Report
salesReport("report","retail",$from,$to,$itemId,$batch,$branch_id);
}

if ($_REQUEST["from"]=="changeView")
{
$itemId=$_REQUEST["item"];
$from=$_REQUEST["fromdate"];
$to=$_REQUEST["todate"];
$batch=$_REQUEST["batch"];
$view=$_REQUEST["view"];
$branch_id=$_REQUEST["branch"];
echo '<tr><td colspan="5" align="center">Compressed View<input type="radio" name="view" value="compress" checked onClick="changeView(this.value)"> Expanded View<input type="radio" name="view" value="expand" onClick="changeView(this.value)"></td></tr>';

//Whole Sale
echo "<table><tr><td valign='top'><table><tr><td colspan='5' align='center'><b>Whole Sale Report</b></td></tr><tr style='background-color:#515151;color:white;font-family:Georgia, Times New Roman, Times, serif;font-weight:bold;font-size:13;'><th>SN</th><th>Item Name</th><th>Quantity</th><th>Total Sale Amount</th><th>Total Margin</th></tr>";
$counter=1;

if ($itemId=="all" and $batch=="all")
$query=mysql_query("select id,name from items where id in (select distinct itemId from sales where type='whole' and date between '$from' AND '$to')");
else if($itemId=="all" and $batch!="all")
$query=mysql_query("select id,name from items where id in (select distinct itemId from sales where type='whole' and date between '$from' AND '$to' and batchNumber='$batch')");
else if($itemId!="all" and $batch=="all")
$query=mysql_query("select id,name from items where id in (select distinct itemId from sales where type='whole' and date between '$from' AND '$to' and itemId='$itemId')");
else if($itemId!="all" and $batch!="all")
$query=mysql_query("select id,name from items where id in (select distinct itemId from sales where type='whole' and date between '$from' AND '$to' and batchNumber='$batch' and itemId='$itemId')");

while ($row=mysql_fetch_array($query))
{
$remainder=$count%2;
if ($remainder==0)
$bgcolor='background-color:#A5E5E5;font-family:Geneva, Arial, Helvetica, sans-serif;';
else
$bgcolor='background-color:#E5E5E5;font-family:Geneva, Arial, Helvetica, sans-serif';
$count++;

$query1=mysql_query("select * from sales where type='whole' and itemId='$row[id]' and date between '$from' AND '$to'");
while($row1=mysql_fetch_array($query1))
{
list($bprice)=mysql_fetch_array(mysql_query("select buying_price from wholeStock where id='$row1[batchNumber]'"));//this one
$totalquantity=$totalquantity+$row1["quantity"];
$totalSalePrice=$totalSalePrice+($row1["price"]*$row1["quantity"]);
$totalBuyingPrice=$totalBuyingPrice+($bprice*$row1["quantity"]);
}
$margin=$totalSalePrice-$totalBuyingPrice;
$totalMargin=$margin+$totalMargin;
$sale=$sale+$totalSalePrice;

$totalSalePrice=number_format($totalSalePrice);
$margin=number_format($margin);

echo "<tr style='$bgcolor'><td>$counter</td><td align='center'>$row[name]</td><td align='center'>$totalquantity</td><td align='center'>$totalSalePrice</td><td align='center'>$margin</td></tr>";
$totalquantity=0;
$totalSalePrice=0;
$totalBuyingPrice=0;
$counter++;
}
$_SESSION["total_whole_margin"]=$totalMargin;
$totalMargin=number_format($totalMargin);
$_SESSION["total_whole_sale"]=$sale;
$sale=number_format($sale);
echo "<tr style='background-color:#515151;color:white;font-family:Georgia, Times New Roman, Times, serif;font-weight:bold;font-size:15;border-color:black'><td colspan='3' align='left'><b>Total Margin=$totalMargin</b></td><td colspan='3' align='right'><b>Total Sale=$sale</b></td></tr></table></td>";


//Retail Sale
$totalquantity=0;
$totalSalePrice=0;
$totalBuyingPrice=0;
$totalMargin=0;
$sale=0;
$itemId=$_REQUEST["item"];
$from=$_REQUEST["fromdate"];
$to=$_REQUEST["todate"];
$batch=$_REQUEST["batch"];
$view=$_REQUEST["view"];
echo "<td valign='top'><table><tr><td colspan='5' align='center'><b>Retail Sale Report</b></td><tr style='background-color:#515151;color:white;font-family:Georgia, Times New Roman, Times, serif;font-weight:bold;font-size:13;'><th>SN</th><th>Item Name</th><th>Quantity</th><th>Total Sale Amount</th><th>Total Margin</th></tr>";
$counter=1;

if ($itemId=="all" and $batch=="all")
$query=mysql_query("select id,name,total_units from items where id in (select distinct itemId from sales where type='retail' and date between '$from' AND '$to')") or die(mysql_error());
else if($itemId=="all" and $batch!="all")
$query=mysql_query("select id,name,total_units from items where id in (select distinct itemId from sales where type='retail' and date between '$from' AND '$to' and batchNumber='$batch')");
else if($itemId!="all" and $batch=="all")
$query=mysql_query("select id,name,total_units from items where id in (select distinct itemId from sales where type='retail' and date between '$from' AND '$to' and itemId='$itemId')");
else if($itemId!="all" and $batch!="all")
$query=mysql_query("select id,name,total_units from items where id in (select distinct itemId from sales where type='retail' and date between '$from' AND '$to' and batchNumber='$batch' and itemId='$itemId')");

while ($row=mysql_fetch_array($query))
{
$remainder=$count%2;
if ($remainder==0)
$bgcolor='background-color:#A5E5E5;font-family:Geneva, Arial, Helvetica, sans-serif;';
else
$bgcolor='background-color:#E5E5E5;font-family:Geneva, Arial, Helvetica, sans-serif';
$count++;

$query1=mysql_query("select * from sales where type='retail' and itemId='$row[id]' and date between '$from' AND '$to'");
while($row1=mysql_fetch_array($query1))
{
list($bprice)=mysql_fetch_array(mysql_query("select buyingPrice from retailStock where batch_number='$row1[batchNumber]'"));
$totalquantity=$totalquantity+$row1["quantity"];
$totalSalePrice=$totalSalePrice+($row1["price"]*$row1["quantity"]);
$totalBuyingPrice=$totalBuyingPrice+(($bprice/$row["total_units"])*$row1["quantity"]);
}
$margin=$totalSalePrice-$totalBuyingPrice;
$totalMargin=$margin+$totalMargin;
$sale=$sale+$totalSalePrice;

$totalSalePrice=number_format($totalSalePrice);
$margin=number_format($margin);

echo "<tr style='$bgcolor'><td>$counter</td><td align='center'>$row[name]</td><td align='center'>$totalquantity</td><td align='center'>$totalSalePrice</td><td align='center'>$margin</td></tr>";
$totalquantity=0;
$totalSalePrice=0;
$totalBuyingPrice=0;
$counter++;
}
$_SESSION["total_retail_margin"]=$totalMargin;
$totalMargin=number_format($totalMargin);
$_SESSION["total_retail_sale"]=$sale;
$sale=number_format($sale);
echo "<tr style='background-color:#515151;color:white;font-family:Georgia, Times New Roman, Times, serif;font-weight:bold;font-size:15;border-color:black'><td colspan='3' align='left'><b>Total Margin=$totalMargin</b></td><td colspan='3' align='right'><b>Total Sale=$sale</b></td></tr></table></td></tr></table>";

//Calculating Expenditures
$results=mysql_query("select amount from dailyExpenditures where date between '$from' and '$to'") or die(mysql_error());
while ($row=mysql_fetch_array($results))
{
$_SESSION["total_expenditures"]=$_SESSION["total_expenditures"]+$row["amount"];
}

$results=mysql_query("select amount,paid from credits where date_credited between '$from' and '$to' and status='notCleared'");
while($row=mysql_fetch_array($results)) {
	$_SESSION["total_credits"]=$_SESSION["total_credits"]+$row["amount"]-$row["paid"];
	}
	
	$from_date=date("Y-n-d",strtotime($from));
	$from_date=explode("-",$from_date);
	$from_month=$from_date[1];
	$from_year=$from_date[0];
	
	$to_date=date("Y-n-d",strtotime($to));
	$to_date=explode("-",$to_date);
	$to_month=$to_date[1];
	$to_year=$to_date[0];
	
	$results=mysql_query("select basic_salary,amount_deducted from salary_payments where salary_month between '$from_month' and '$to_month' and salary_year between '$from_year' and '$to_year'");
	while($row=mysql_fetch_array($results)) {
		$_SESSION["total_salary"]=$_SESSION["total_salary"]+($row["basic_salary"]-$row["amount_deducted"]);
		}
}

else if($_REQUEST["from"]=="show_summary_report") {
	$total_sales_incl=$_SESSION["total_whole_sale"]+$_SESSION["total_retail_sale"];
	$total_sales_excl=$total_sales_incl-$_SESSION["total_credits"]-$_SESSION["total_expenditures"];
	$total_margin_incl=$_SESSION["total_whole_margin"]+$_SESSION["total_retail_margin"];
	$total_margin_excl=$total_margin_incl-$_SESSION["total_salary"]-$_SESSION["total_expenditures"];
	echo "<table><tr><td colspan='5' align='center'><b>Over All Sales Report</b></td></tr>
<tr style='background-color:#515151;color:white;font-family:Georgia, Times New Roman, Times, serif;font-weight:bold;font-size:13;'><th>Total Whole Sales</th><th>Total Retail Sales</th><th>Whole Sale Margin</th><th>Retail Sale Margin</th><th>Total Expenditures</th><th>Total Salaries</th><th>Total Credits</th></tr>";
echo "<tr style='background-color:#BCC6CC;'><td align='center'>".number_format($_SESSION["total_whole_sale"])."</td><td align='center'>".number_format($_SESSION["total_retail_sale"])."</td><td align='center'>".number_format($_SESSION["total_whole_margin"])."</td><td align='center'>".number_format($_SESSION["total_retail_margin"])."</td><td align='center'>".number_format($_SESSION["total_expenditures"])."</td><td align='center'>".number_format($_SESSION["total_salary"])."</td><td align='center'>".number_format($_SESSION["total_credits"])."</td></tr>";

echo "<tr style='background-color:#A5E5E5;'><td colspan='2'><b><i>Total Sales (Including Expenditures and Credits) ".number_format($total_sales_incl)."</b></i></td><td colspan='2'><b><i>Total Margin (Expenditures & Salaries Included) ".number_format($total_margin_incl)."</b></i></td></tr>";
echo "<tr style='background-color:#A5E5E5;'><td colspan='2'><b><i>Total Sales (Excluding Expenditures and Credits) ".number_format($total_sales_excl)."</i></b></td><td colspan='2'><b><i>Total Margin (Expenditures & Salaries Excluded) ".number_format($total_margin_excl)."</b></i></td></tr></table>";
unset($_SESSION["total_whole_sale"]);
unset($_SESSION["total_retail_sale"]);
unset($_SESSION["total_expenditures"]);
unset($_SESSION["total_credits"]);
unset($_SESSION["total_salary"]);
unset($_SESSION["total_whole_margin"]);
unset($_SESSION["total_retail_margin"]);
	}
?>
