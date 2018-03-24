<?php
include("authentication.php");
if($_REQUEST["from"]=="showDescriptions")
{
$id=$_REQUEST["id"];
$results=mysql_query("select * from items where id='$id'");
echo "<table id='items'><tr style='background-color:#515151;color:white;font-family:Georgia, Times New Roman, Times, serif;font-weight:bold;font-size:14;'><th>&nbsp;</th><th>SN</th><th>Jina La Bidhaa</th><th>Bei Ya Kununulia Kwa Box</th><th>Bei Ya kuuzia Kwa Box (Jumla Jumla)</th><th>Bei Ya Kuuzia Kwa Piece Moja (Reja Reja)</th><th>Idadi Ya Piece Katika Box</th></tr>";
while($row=mysql_fetch_array($results))
{
$remainder=$count%2;
if ($remainder==0)
$bgcolor='background-color:#A5E5E5;font-family:Geneva, Arial, Helvetica, sans-serif;';
else
$bgcolor='background-color:#E5E5E5;font-family:Geneva, Arial, Helvetica, sans-serif';
$count++;
echo "<tr id='$row[id]' style='$bgcolor'><td><a href='#' onclick='inlineEdit($id,$count)'><img src='images/edit.png'>Inline Edit</a>&nbsp;&nbsp;<a href='#' onclick='delete_this($id,$count)'><img src='images/delete.png'>Delete</a></td><td>$count</td><td>$row[name]</td><td>$row[buying_price]</td><td>$row[selling_price]</td><td>$row[selling_price_unit]</td><td>$row[total_units]</td></tr>";
}
echo "</table>";
}

if($_REQUEST["from"]=="inlineEdit")
{
$id=$_REQUEST["id"];
$count=$_REQUEST["count"];
$bgcolor='background-color:CCCC33;font-family:Geneva, Arial, Helvetica, sans-serif;';
$results=mysql_query("select * from items where id='$id'");
while($row=mysql_fetch_array($results))
echo "<td style='$bgcolor'><a href='#' onclick='verify($id,$count)'><img src='images/save.png'>Sajili</a>&nbsp;&nbsp;<a href='#' onclick='showDescriptions($id)'><img src='images/close.png'>Ficha</a></td><td style='$bgcolor'>$count</td><td style='$bgcolor'><input type='text' name='itemName$count' value='$row[name]'></td><td style='$bgcolor'><input type='text' name='bprice$count' value='$row[buying_price]'></td><td style='$bgcolor'><input type='text' name='spricec$count' value='$row[selling_price]'></td><td style='$bgcolor'><input type='text' name='spriceb$count' value='$row[selling_price_unit]'></td><td style='$bgcolor'><input type='text' name='pieces$count' value='$row[total_units]'</td></tr>";
}

if($_REQUEST["from"]=="delete")
{
$id=$_REQUEST["id"];
$count=$_REQUEST["count"];
if(mysql_query("delete from items where id='$id'"))
echo "This Item Have Been Deleted Successfully";
else
echo "This Item Have Failed To Be Deleted";
}

if($_REQUEST["from"]=="save")
{
$itemname=$_REQUEST["itemname"];
$bprice=$_REQUEST["bprice"];
$spricec=$_REQUEST["spricec"];
$spriceb=$_REQUEST["spriceb"];
$pieces=$_REQUEST["pieces"];
$id=$_REQUEST["id"];
mysql_query ("update items set name='$itemname',buying_price='$bprice',selling_price='$spricec',selling_price_unit='$spriceb',total_units='$pieces' where id='$id'");
}
?>