<?php
session_start();
include "includes/connection.php";
if ($_REQUEST["from"]=="showNames")
{
$name=$_REQUEST["name"];
$result=mysql_query("select * from customers where name like '%$name%'") or die(mysql_error());
echo "<select size='10' style='width:250' onchange='getName()' name='namesPool' style='background-color:red'>";
if (mysql_num_rows($result)==0)
echo "<option style='color:red;font-weight:bold;'>Jina La Mteja Huyu Halipo</option>";
while ($row=mysql_fetch_array($result))
{
$advance=mysql_query("select s.id from sales s,advance_payments ap where s.customer_id='$row[id]' and s.pay_mode='advance' and s.id=ap.sales_id and (s.quantity*s.price)!=ap.amount_paid");
if(mysql_num_rows($advance)==0)
continue;
echo "<option value='$row[id]'>".$row["name"]."</option>";
}
echo "</select>";
}

else if ($_REQUEST["from"]=="showDebtInfo")
{
$id=$_REQUEST["id"];
$results=mysql_query("select * from sales s,advance_payments ap where s.customer_id='$id' and s.pay_mode='advance' and s.id=ap.sales_id and (s.quantity*s.price)!=ap.amount_paid");
echo "<div id='errmsg'></div>";
echo "<table><tr style='background-color:#515151;color:white;font-family:Georgia, Times New Roman, Times, serif;font-weight:bold;font-size:13;'><th>Jina La Mteja</th><th>Bidhaa</th><th>Jumla Ya Fedha</th><th>Kiasi Kilicholipwa</th><th>Kiasi Kilichobaki</th><th>Tarehe Ya Mauzo</th><th>Kiasi Anacholipa</th><th>Action</th></tr>";
while($row=mysql_fetch_array($results))
{
$date=date_create($row["date"]);
$date=date_format($date,"jS F Y");
$total_amount=$row["price"]*$row["quantity"];
$remainder=$total_amount-$row["amount_paid"];
$remainder=number_format($remainder);
$cleared=number_format($row["amount_paid"]);
$total_amount=number_format($total_amount);
list($customer_name)=mysql_fetch_array(mysql_query("select name from customers where id='$row[customer_id]'"));
list($item_name)=mysql_fetch_array(mysql_query("select name from items where id='$row[itemId]'"));
echo "<tr style='background-color:#A5E5E5;font-family:Geneva, Arial, Helvetica, sans-serif'><td align='center'>$customer_name</td><td align='center'>$item_name</td><td align='center'>$total_amount</td><td align='center'>$cleared</td><td align='center'>$remainder</td><td align='center'>$date</td><td align='center'><input type='text' name='amount_cleared[$row[sales_id]]' id='$row[sales_id]'></td><td align='center'><input type='button' name='submit' value='Lipia' onclick='return check($row[sales_id])'></td></tr>";

echo "<input type='hidden' name='id' value='$row[id]'>";
}
echo "</table>";
}

else if ($_REQUEST["from"]=="check")
{
list($paid,$amount)=mysql_fetch_array(mysql_query("select ap.amount_paid,(s.price*s.quantity) from advance_payments ap,sales s where ap.sales_id='$_REQUEST[id]' and ap.sales_id=s.id"));
$debt=$amount-$paid;

if($_REQUEST["amount_paid"]=="")
echo "<b><font color='red'>Error:Fedha Zinazolipwa Hazijajazwa</font></b>";
else if ($debt<$_REQUEST["amount_paid"])
echo "<b><font color='red'>Error:Kiasi Kinacholipwa Nikikubwa Kuliko Kiasi Kinachodaiwa</font></b>";
}

else if ($_REQUEST["from"]=="submit")
{
list($paid,$amount)=mysql_fetch_array(mysql_query("select ap.amount_paid,(s.price*s.quantity) from advance_payments ap,sales s where ap.sales_id='$_REQUEST[id]' and ap.sales_id=s.id"));
$debt=$amount-$paid;
$paid=$paid+$_REQUEST["amount_paid"];
if ($debt==$_REQUEST["amount_paid"])
{
mysql_query("update advance_payments set amount_paid='$paid' where sales_id='$_REQUEST[id]'") or die(mysql_error());
echo "<b>Deni Limepunguzwa Kwa $_REQUEST[amount_paid]</b>";
}
else 
{
mysql_query("update advance_payments set amount_paid='$paid' where sales_id='$_REQUEST[id]'") or die(mysql_error());
echo "<b>Deni Limepunguzwa Kwa $_REQUEST[amount_paid]</b>";
}
}
?>