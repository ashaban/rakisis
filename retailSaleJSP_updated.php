<?php
session_start();
include ("includes/connection.php");
if ($_REQUEST["from"]=="showItems")
{
$name=$_REQUEST["name"];
$items=mysql_query("select id,name,description from items where name like '$name%' order by name");
?>
<select size="10" style="width:153" onchange="getName()" name="itemname" style="background-color:red">
<?php
if (mysql_num_rows($items)==0)
echo "<option style='color:red;font-weight:bold;'>Name Missmatch</option>";
while ($row=mysql_fetch_array($items))
{
echo "<option value='$row[id]'>".$row["name"]."</option>";
}
?>
</select>
<?php
}

if ($_REQUEST["from"]=="showBatch")
{
echo "Select Batch<select name='batch' onchange='showDescr(this.value)'>";
$results=mysql_query("select id from retailStock where itemId='$_REQUEST[id]' and available>0 order by date Asc");
$x=1;
while ($row=mysql_fetch_array($results))
{
if($x==1)
$batch=$row["id"];
echo "<option value='$row[id]'>Batch $row[id]</option>";
$x++;
}
echo "</select>";
echo "</td><td>Quantity(s)</td><td><input type='text' name='quantity' style='width:90'></td>";
list($sprice)=mysql_fetch_array(mysql_query("select sellingPriceBottle from items where id='$_REQUEST[id]'"));
$sprice=number_format($sprice);
?>
<td>Selling Price</td><td><select name='salePrice' onchange="checkSPrice(this.value)"><option><?php echo $sprice; ?></option><option value="diff">Different Price</option></select><label id="input"></label></td></tr>
<?php
}

else if($_REQUEST["from"]=="addQue")
{
if($_REQUEST["type"]=="removed")
$allarrays=$_SESSION["allarrays"];

else
{
$array=array($_REQUEST["item"],$_REQUEST["batch"],$_REQUEST["quantity"],$_REQUEST["salePrice"],$_REQUEST["date"]);

$lastkey=count($_SESSION["allarrays"]);
$allarrays=$_SESSION["allarrays"];
$allarrays[$lastkey]=$array;
}

echo "<b>Sale Que</b>";
echo "<table><tr style='background-color:#515151;color:white;font-family:Georgia, 'Times New Roman', Times, serif;font-weight:bold;font-size:14;'><td>&nbsp;</td><th>Item Name</th><th>Batch Number</th><th>Number Of Bottles(s)</th><th>Sale Price</th><th>Total Cash</th><th>Date To Sale</th></tr>";
$k=0;
foreach($allarrays as $values)
{
$date=explode("-",$values[4]);
$date=$date[2]."/".$date[1]."/".$date[0];
$remainder=$count%2;
if ($remainder==0)
$bgcolor='background-color:#A5E5E5;font-family:Geneva, Arial, Helvetica, sans-serif;';
else
$bgcolor='background-color:#E5E5E5;font-family:Geneva, Arial, Helvetica, sans-serif';
$count++;
$amount=$values[3]*$values[2];
$totalAmount=$totalAmount+$amount;
list($itemname)=mysql_fetch_array(mysql_query("select name from items where id='$values[0]'"));
echo "<tr style='$bgcolor' onmouseover='color=this.style.background;this.style.background=\"gold\";' onmouseout='this.style.background=color'><td align='right'><img src='images/close.jpg' height='30' onclick='remove($k)'></td><td align='center'>$itemname</td><td align='center'>$values[1]</td><td align='center'>$values[2]</td><td align='center'>$values[3]</td><td align='center'>".number_format($amount)."</td><td align='center'>$date</td></tr>";
$k++;
}
echo "<tr style='background-color:#515151;color:white;font-family:Georgia, Times New Roman, Times, serif;font-weight:bold;font-size:15;'><td colspan='7' align='center'><b>Total Sale=".number_format($totalAmount)."</b></td></tr>";
$_SESSION["allarrays"]=$allarrays;
echo "<tr><td colspan='6' align='center'><input type='submit' name='submit' value='Sale'></td></tr>";
echo "</table>";
}

else if($_REQUEST["from"]=="showDescr")
{
$quantities=Array();
$bgcolor='background-color:#A5E5E5;font-family:Geneva, Arial, Helvetica, sans-serif;';
list($id,$itemId,$quantity,$available,$price,$sprice,$date)=mysql_fetch_array(mysql_query("select * from retailStock where id='$_REQUEST[id]'"));
list($itemname)=mysql_fetch_array(mysql_query("select name from items where id='$itemId'"));
echo "<center><tr><td colspan='3' align='center'><br><b>Batch $id For $itemname Stock Decsriptions</b></td></tr>";
echo "<tr style='background-color:#515151;color:white;font-family:Georgia, 'Times New Roman', Times, serif;font-weight:bold;font-size:14;'><th>Item Name</th><th>Number Of Bottles Available</th><th>Price Bought Per Carton</th></tr>";
echo "<tr style='$bgcolor' onmouseover='color=this.style.background;this.style.background=\"gold\";' onmouseout='this.style.background=color'><td align='center'>$itemname</td><td align='center'>$available</td><td align='center'>".number_format($price)."</td></tr></center>";


list($itemname)=mysql_fetch_array(mysql_query("select name from items where id='$itemId'"));
echo "<center><tr><td colspan='4' align='center'><br><b>All Batches For $itemname Stock Decsriptions</b></td></tr>";
echo "<tr style='background-color:#515151;color:white;font-family:Georgia, 'Times New Roman', Times, serif;font-weight:bold;font-size:14;'><th>Item Name</th><th>Batch Number</th><th>Available Quantity</th><th>Price Bought Per Carton</th></tr>";
$results3=mysql_query("select * from retailStock where itemId='$itemId' and available>0");
$totalRows=mysql_num_rows($results3)+1;
echo "<tr style='$bgcolor' onmouseover='color=this.style.background;this.style.background=\"gold\";' onmouseout='this.style.background=color'><td rowspan='$totalRows' align='center'>$itemname</td>";
$x=1;
while($row=mysql_fetch_array($results3))
{
if ($x!=1)
echo "<tr style='$bgcolor' onmouseover='color=this.style.background;this.style.background=\"gold\";' onmouseout='this.style.background=color'>";
echo "<td align='center'>Batch $row[id]</td><td align='center'>$row[available]</td><td align='center'>".number_format($row["buyingPrice"])."</td></tr>";
$quantities=$_SESSION["quantities"];
if ($quantities[$row["id"]]=="")
{
$quantities[$row["id"]]=$row["available"];
$_SESSION["quantities"]=$quantities;
}
$totalAvailable=$row["available"]+$totalAvailable;
$x=2;
}

echo "<tr style='$bgcolor'><td colspan='4' align='center'><b>Total Available Bottle(s) $totalAvailable</b></td></tr></center>";
}

else if ($_REQUEST["from"]=="checkQuantity")
{
$getQuantity=$_REQUEST["quantityToCheck"];
$getBatch=$_REQUEST["batchToCheck"];
$quantities=$_SESSION["quantities"];
if ($quantities[$getBatch]<$getQuantity)
{
echo "<b><font color='red'>Error:You Have Only $quantities[$getBatch] Cartons And You Want To Sell $getQuantity Cartons</font></b>";
}
else
{
$quantities[$getBatch]=$quantities[$getBatch]-$getQuantity;
$_SESSION["quantities"]=$quantities;
}
}

else if ($_REQUEST["from"]=="remove")
{
$allarrays=$_SESSION["allarrays"];
unset($allarrays[$_REQUEST["id"]]);
$allarrays=array_values($allarrays);
$_SESSION["allarrays"]=$allarrays;
}
?>
