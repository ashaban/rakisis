<?php
include('authentication.php');
if ($_REQUEST["from"]=="showBatch")
{
$branch_id=$_REQUEST["branch"];
echo "<tr style='background-color:#C0C0C0;'><td align='right'>Chagua Batch</td><td align='left'><select name='batch' onchange='showDescr(this.value)'>";
$results=mysql_query("select id,batch_number from retailStock where itemId='$_REQUEST[id]' and available>0 and branch_id='$branch_id' order by  expire_date DESC");
$x=1;
while ($row=mysql_fetch_array($results))
{
if($x==1)
$batch=$row["batch_number"];
echo "<option value='$row[id]'>Batch $row[batch_number]</option>";
$x++;
}
echo "</select></td></tr>";
list($unit)=mysql_fetch_array(mysql_query("select unit from items where id='$_REQUEST[id]'"));
list($unit_name)=mysql_fetch_array(mysql_query("select name from units where id='$unit'"));
echo "<tr style='background-color:#C0C0C0;'></td><td align='right'>Idadi Ya Units ";
if($unit_name!="")echo "($unit_name) ";
echo "</td><td align='left'><input type='text' name='quantity' style='width:90'></td></tr>";
echo "<tr style='background-color:#C0C0C0;'></td><td align='right'>Invoice Number</td><td align='left'><input type='text' name='invoice_number' style='width:90'></td></tr>";
list($sprice)=mysql_fetch_array(mysql_query("select selling_price_unit from items where id='$_REQUEST[id]'"));
$sprice=number_format($sprice);
?>
<tr style='background-color:#C0C0C0;' width='100%'><td align='right'>Bei Ya Kuuzia</td><td align='left'><select name='salePrice' onchange="checkSPrice(this.value)"><option><?php echo $sprice; ?></option><option value="diff">Badili Bei</option></select><label id="input"></label></td></tr>
<?php
}

else if($_REQUEST["from"]=="addQue")
{
if($_REQUEST["type"]=="removed")
$allarrays=$_SESSION["allarrays"];

else
{
$sprice=str_replace(",","",$_REQUEST["salePrice"]);
$array=array("customer_id"=>$_REQUEST["customer_id"],"item"=>$_REQUEST["item"],"batch"=>$_REQUEST["batch"],"quantity"=>$_REQUEST["quantity"],"sprice"=>$sprice,"date"=>$_REQUEST["date"],'invoice_number'=>$_REQUEST["invoice_number"],'branch_id'=>$_REQUEST["branch"]);

$lastkey=count($_SESSION["allarrays"]);
$allarrays=$_SESSION["allarrays"];
$allarrays[$lastkey]=$array;
}

if(count($allarrays)>0)
{
echo "<b>Sale Que</b>";
echo "<table><tr style='background-color:#515151;color:white;font-family:Georgia, 'Times New Roman', Times, serif;font-weight:bold;font-size:14;'><th>&nbsp;</th><th>Mteja</th><th>Jina La Bidhaa</th><th>Batch Number</th><th>Idadi Ya Piece</th><th>Bei Ya Kuuzia</th><th>Jumla Ya Fedha</th><th>Tarehe Ya Kuuzia</th><th>Invoice Number</th><th>Expire Date</th><th>Tawi</th></tr>";
}

$k=0;
foreach($allarrays as $values)
{
list($customer_name)=mysql_fetch_array(mysql_query("select name from customers where id='$values[customer_id]'"));
list($branch_name)=mysql_fetch_array(mysql_query("select name from branches where id='$values[branch_id]'"));
$date=explode("-",$values["date"]);
$date=$date[2]."-".$date[1]."-".$date[0];
$remainder=$count%2;
if ($remainder==0)
$bgcolor='background-color:#A5E5E5;font-family:Geneva, Arial, Helvetica, sans-serif;';
else
$bgcolor='background-color:#E5E5E5;font-family:Geneva, Arial, Helvetica, sans-serif';
$count++;
$amount=$values["sprice"]*$values["quantity"];
$totalAmount=$totalAmount+$amount;
list($itemname)=mysql_fetch_array(mysql_query("select name from items where id='$values[item]'"));
list($exp_date)=mysql_fetch_array(mysql_query("select expire_date from retailStock where id='$values[batch]'"));
$exp_date=date("d-m-Y",strtotime($exp_date));
echo "<tr style='$bgcolor'><td align='right'><img src='images/close.jpg' height='30' onclick='remove_this($k)'></td><td>$customer_name</td><td align='center'>$itemname</td><td align='center'>$values[batch]</td><td align='center'>$values[quantity]</td><td align='center'>".number_format($values["sprice"])."</td><td align='center'>".number_format($amount)."</td><td align='center'>$date</td><td>$values[invoice_number]</td><td align='center'>$exp_date</td><td>$branch_name</td></tr>";
$k++;
}
if(count($allarrays)>0)
{
echo "<tr style='background-color:#515151;color:white;font-family:Georgia, Times New Roman, Times, serif;font-weight:bold;font-size:15;'><td colspan='11' align='center'><b>Jumla Ya Fedha=".number_format($totalAmount)."</b></td></tr>";
$_SESSION["allarrays"]=$allarrays;
echo "<tr style='background-color:#C0C0C0;'><td colspan='7' align='center'>Namna Ya Malipo<font style='color:red'>*</font><select name='mode' onchange='check_pay_mode(this.value)'><option value='full'>Pesa Yote Inalipwa</option><option value='advance'>Baadhi Ya Pesa Inatangulizwa</option></select><span id='advance_amount'><span></td><td colspan='4' align='right'><input type='button' name='sale' value='Uza' onclick='check_customer_selection()'></td></tr>";
echo "</table>";
}

}

else if($_REQUEST["from"]=="showDescr")
{
$quantities=array();
$branch_id=$_REQUEST["branch"];
$bgcolor='background-color:#A5E5E5;font-family:Geneva, Arial, Helvetica, sans-serif;';
list($id,$itemId,$quantity,$available,$price,$date_stocked,$exp_date,$batch_number)=mysql_fetch_array(mysql_query("select id,itemId,quantity,available,buyingPrice,date,expire_date,batch_number from retailStock where id='$_REQUEST[id]'"));
list($itemname,$unit,$total_units,$sale_price)=mysql_fetch_array(mysql_query("select name,unit,total_units,selling_price_unit from items where id='$itemId'"));
list($unit)=mysql_fetch_array(mysql_query("select name from units where id='$unit'"));
if($total_units==0)
$total_units="";
$sale_price=number_format($sale_price);
$exp_date=date("m-d-Y",strtotime($exp_date));
echo "<center><tr><td colspan='3' align='center'><br><b>Maelezo Ya $itemname $unit $total_units Kwa Batch Namba $batch_number</b></td></tr>";
echo "<tr style='background-color:#515151;color:white;font-family:Georgia, 'Times New Roman', Times, serif;font-weight:bold;font-size:14;'><th>Jina La Bidhaa</th><th>Idadi ";
if($unit!="")echo "($unit) ";
echo " Iliyopo</th><th>Bei Iliyonunuliwa Kwa Piece ";
if($unit!="")echo "($unit $total_units) ";
echo "</th><th>Bei Yakuuzia Kwa Unit</th><th>Expire Date</th></tr>";
echo "<tr style='$bgcolor'><td align='center'>$itemname</td><td align='center'>$available</td><td align='center'>".number_format($price)."</td><td align='center'>$sale_price</td><td align='center'>$exp_date</td></tr></center>";

echo "<center><tr><td colspan='4' align='center'><br><b>Maelezo Ya $itemname $unit $total_units Kwa Batch Zote</b></td></tr>";
echo "<tr style='background-color:#515151;color:white;font-family:Georgia, 'Times New Roman', Times, serif;font-weight:bold;font-size:14;'><th>Jina La Bidhaa</th><th>Batch Number</th><th>Idadi ";
if($unit!="")echo "($unit) ";
echo "Iliyopo</th><th>Bei Iliyonunuliwa Kwa Piece ";
if($unit!="")echo "($unit $total_units) ";
echo "</th><th>Tarehe Yakuingia Mzigo</th><th>Expire Date</th></tr>";
$results3=mysql_query("select * from retailStock where itemId='$itemId' and available>0 and branch_id='$branch_id' order by expire_date DESC");
$totalRows=mysql_num_rows($results3)+1;
echo "<tr style='$bgcolor'><td rowspan='$totalRows' align='center'>$itemname</td>";
$x=1;
while($row=mysql_fetch_array($results3))
{
if ($x!=1)
echo "<tr style='$bgcolor'>";
$date_stocked=date("d-m-Y",strtotime($row["date_stocked"]));
$exp_date=date("d-m-Y",strtotime($row["expire_date"]));
echo "<td align='center'>Batch $row[batch_number]</td><td align='center'>$row[available]</td><td align='center'>".number_format($row["buyingPrice"])."</td><td align='center'>$date_stocked</td><td align='center'>$exp_date</td></tr>";
$quantities=$_SESSION["quantities"];

if(!is_array($quantities))
{
$quantities[$row["id"]]=$row["available"];
$_SESSION["quantities"]=$quantities;	
}

else if (!array_key_exists($row["id"],$quantities))
{
$quantities[$row["id"]]=$row["available"];
$_SESSION["quantities"]=$quantities;
}

$totalAvailable=$row["available"]+$totalAvailable;
$x=2;
}

echo "<tr style='$bgcolor'><td colspan='5' align='center'><b>Jumla Ya Box Zote $totalAvailable</b></td></tr></center>";
}

else if ($_REQUEST["from"]=="checkQuantity")
{
$getQuantity=$_REQUEST["quantityToCheck"];
$getBatch=$_REQUEST["batchToCheck"];
$quantities=$_SESSION["quantities"];
if ($quantities[$getBatch]<$getQuantity)
{
echo "<b><font color='red'>Error:Una Unit $quantities[$getBatch] Tuu Na Unataka Kuuza Unit $getQuantity,Mauzo Hayawezekani</font></b>";
}
else
{
$quantities[$getBatch]=$quantities[$getBatch]-$getQuantity;
$_SESSION["quantities"]=$quantities;
}
}

else if($_REQUEST["from"]=="check_date_validity")
{
$sale_date=$_REQUEST["sale_date"];
$batch=$_REQUEST["batch"];
list($stock_date)=mysql_fetch_array(mysql_query("select date_stocked from retailStock where id='$batch'"));
if($stock_date>$sale_date)
echo "Invalid Sale";
}

else if($_REQUEST["from"]=="display_items_lists")
{
	echo "<tr style='background-color:#C0C0C0;'><td>Chagua Tawi</td><td><select name='branch' onchange='showBatch()'><option value='-1'>---Chagua---</option>";
		$results=mysql_query("select id,name from branches");
		while($row=mysql_fetch_array($results)) {
			echo "<option value='$row[id]'>$row[name]</option>";
			}
		echo "</td></tr>";
	echo '<tr style="background-color:#C0C0C0;"><td valign="top" align="right">Jina La Bidhaa</td><td valign="top"><select name="itemname" onchange="showBatch()">
	<option value="-1">---Chagua---</option>';
	$items=mysql_query("select id,name,total_units,unit from items order by name");
while($row=mysql_fetch_array($items))
{
list($unit_name)=mysql_fetch_array(mysql_query("select name from units where id='$row[unit]'"));
if($row["total_units"]==0)
$total_units="";
else
$total_units=$row["total_units"];
echo "<option value='$row[id]'>$row[name] $unit_name $total_units</option>";
}
echo '</select></td></tr><tr style="background-color:#C0C0C0;"><td align="right">Jina La Mteja</td><td><input type="text" name="search_name" onkeyup="search_customer()" style="width:250" autocomplete="off"><input type="hidden" name="customer_id"><a href="defineCustomer.php" target="_blank">Sajili Mteja Mpya</a></td></tr><tr style="display:none;background-color:#C0C0C0;" id="search_row"><td>&nbsp;</td><td id="search_name"></td></tr>';
}

else if ($_REQUEST["from"]=="remove")
{
$allarrays=$_SESSION["allarrays"];
$batch=$allarrays[$_REQUEST["id"]]["batch"];
$quantity_tosell=$allarrays[$_REQUEST["id"]]["quantity"];
$quantities=$_SESSION["quantities"];
$quantities[$batch]=$quantities[$batch]+$quantity_tosell;
$_SESSION["quantities"]=$quantities;
unset($allarrays[$_REQUEST["id"]]);
$allarrays=array_values($allarrays);
$_SESSION["allarrays"]=$allarrays;
}

else if($_REQUEST["from"]=="search_customer")
{
	$search=$_REQUEST["search_name"];
	$results=mysql_query("select id,name from customers where name like '%$search%'");
	if(mysql_num_rows($results)==0)
	{
	echo "No Search Results Found";
	exit;
	}
	echo "<select name='customer' id='customer' size='5' style='width:250;position:relative;bottom:7px' onchange='get_selected_from_search()'>";
	while ($row=mysql_fetch_array($results))
	{
	echo "<option value='$row[id]'>$row[name]</option>";	
	}
	echo "</select>";
}

	else if($_REQUEST["from"]=="check_customer_selection") {
		if($_REQUEST["mode"]=="full")
		exit();
		foreach ($_SESSION["allarrays"] as $values) {
			if($values["customer_id"]=="") {
			echo "Hakikisha Kila Mauzo Yana Jina La Mteja";
			exit();
			}
			}
		}
	
else if($_REQUEST["from"]=="process_sale")
{
	$advance_amount=$_REQUEST["advance_amount"];
	$pay_mode=$_REQUEST["pay_mode"];
	foreach($_SESSION["allarrays"] as $values)
	{
		if($pay_mode=="advance") {
			$this_price=$values["quantity"]*$values["sprice"];
			if($this_price<=$advance_amount) {
				$advance_amount=$advance_amount-$this_price;
				$pay_mode_save="full";
				}
			else if($this_price > $advance_amount) {
				$pay_mode_save="advance";				
				}
			}
		else {
			$pay_mode_save="full";
			}
	list($available,$batch_number)=mysql_fetch_array(mysql_query("select available,batch_number from retailStock where id='$values[batch]'"));
	$available=$available-$values["quantity"];	
	if(mysql_query("insert into sales (itemId,customer_id,quantity,price,date,salerId,batchNumber,type,pay_mode,branch_id,invoice_number) values ('$values[item]','$values[customer_id]','$values[quantity]','$values[sprice]','$values[date]','$_SESSION[id]','$batch_number','retail','$pay_mode_save','$values[branch_id]','$values[invoice_number]')") or die(mysql_error())) {
		if($pay_mode_save=="advance") {
			$sales_id=mysql_insert_id();
			mysql_query("insert into advance_payments (sales_id,items,amount_paid,date_paid) values ('$sales_id','','$advance_amount','$values[date]')");
			$advance_amount=$advance_amount-$advance_amount;
			}
		mysql_query("update retailStock set available='$available' where id='$values[batch]'");
	}
	}
	echo "<center><b>Mauzo Yamefanyika Kikamilifu</b></center>";
	unset($_SESSION["allarrays"]);
	unset($_SESSION["quantities"]);	
}
?>