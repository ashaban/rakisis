<?php
session_start();
include "includes/connection.php";
if ($_REQUEST["from"]=="showNames")
{
$name=$_REQUEST["name"];
$result=mysql_query("select * from customers where name like '%$name%'") or die(mysql_error());
?>
<select size="10" style="width:153" onchange="getName()" name="namesPool" style="background-color:red">
<?php
if (mysql_num_rows($result)==0)
echo "<option style='color:red;font-weight:bold;'>Name Missmatch</option>";
while ($row=mysql_fetch_array($result))
{
$credits=mysql_query("select id from credits where customer_id='$row[id]' and status='notCleared'");
if(mysql_num_rows($credits)==0)
continue;
echo "<option value='$row[id]'>".$row["name"]."</option>";
}
?>
</select>
<?php
}

else if ($_REQUEST["from"]=="showCreditInfo")
{
$id=$_REQUEST["id"];
$results=mysql_query("select * from credits where customer_id='$id' and status='notCleared'");
echo "<div id='errmsg'></div>";
echo "<table><tr style='background-color:#515151;color:white;font-family:Georgia, Times New Roman, Times, serif;font-weight:bold;font-size:13;'><th>Jina</th><th>Kiasi Alichokopa</th><th>Kiasi Alicholipa</th><th>Kiasi Kilichobakia</th><th>Tarehe Aliyokopa</th><th>Maelezo Ya Ziada</th><th>Kiasi Anacholipa</th><th>Action</th></tr>";
while($row=mysql_fetch_array($results))
{
$date=date_create($row["date"]);
$date=date_format($date,"jS F Y");
$remainder=$row["amount"]-$row["paid"];
$remainder=number_format($remainder);
$cleared=number_format($row["paid"]);
list($customer_name)=mysql_fetch_array(mysql_query("select name from customers where id='$row[customer_id]'"));
echo "<tr style='background-color:#A5E5E5;font-family:Geneva, Arial, Helvetica, sans-serif'><td>$customer_name</td><td>".number_format($row["amount"])."</td><td>$cleared</td><td>$remainder</td></td><td>$date</td><td>$row[description]</td><td><input type='text' name='amount_cleared[$row[id]]' id='$row[id]'></td><td><input type='button' name='submit' value='Lipa' onclick='return check($row[id])'></td></tr>";

echo "<input type='hidden' name='id' value='$row[id]'>";
}
echo "</table>";
}

else if ($_REQUEST["from"]=="check")
{
list($amount,$paid)=mysql_fetch_array(mysql_query("select amount,paid from credits where id='$_REQUEST[id]'"));
$debt=$amount-$paid;
if($_REQUEST["amount_paid"]=="")
echo "<b><font color='red'>Error:Amount To Be Paid Has Not Been Filled</font></b>";
else if ($debt<$_REQUEST["amount_paid"])
echo "<b><font color='red'>Error:Amount Paid Is Greater Than The Debt</font></b>";
}

else if ($_REQUEST["from"]=="submit")
{
list($amount,$paid)=mysql_fetch_array(mysql_query("select amount,paid from credits where id='$_REQUEST[id]'"));
$debt=$amount-$paid;
$paid=$paid+$_REQUEST["amount_paid"];
if ($debt==$_REQUEST["amount_paid"])
{
mysql_query("update credits set paid='$paid',status='cleared' where id='$_REQUEST[id]'") or die(mysql_error());
echo "<b>credit Cleared By $_REQUEST[amount_paid]</b>";
}
else 
{
mysql_query("update credits set paid='$paid' where id='$_REQUEST[id]'") or die(mysql_error());
echo "<b>Debt Cleared By $_REQUEST[amount_paid]</b>";
}
}
?>
