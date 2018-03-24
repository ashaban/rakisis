<?php
include ("authentication.php");

	if($_REQUEST["from"]=="showReport") {
	$from=$_REQUEST["from_date"];
	$to=$_REQUEST["to_date"];
	
	if($_REQUEST["debits_credits"]=="debits") {
		$customer_id=$_REQUEST["customer_id"];
		$status=$_REQUEST["status"];
		if($customer_id=="" and $status=="cleared")
		$results=mysql_query("select * from debits where date_debited between '$from' and '$to' and status='cleared'") or die(mysql_error());
		else if($customer_id=="" and $status=="notcleared")
		$results=mysql_query("select * from debits where date_debited between '$from' and '$to' and status='notCleared'") or die(mysql_error());
		else if($customer_id=="" and $status=="all")
		$results=mysql_query("select * from debits where date_debited between '$from' and '$to'") or die(mysql_error());
		else if($customer_id!="" and $status=="cleared")
		$results=mysql_query("select * from debits where date_debited between '$from' and '$to' and status='cleared' and customer_id='$customer_id'") or die(mysql_error());
		else if($customer_id!="" and $status=="notcleared")
		$results=mysql_query("select * from debits where date_debited between '$from' and '$to' and status='notCleared'  and customer_id='$customer_id'") or die(mysql_error());
		else if($customer_id!="" and $status=="all")
		$results=mysql_query("select * from debits where date_debited between '$from' and '$to' and customer_id='$customer_id'") or die(mysql_error());
					
		if (mysql_num_rows($results)==0)
		echo "<center><b>Hakuna Ripoti</b></center>";
		else {
			$from = date_create($from);
			$from=date_format($from,"jS F Y");
			$to = date_create($to);
			$to=date_format($to,"jS F Y");
			echo "<tr><td colspan='7' align='center'><b><u>Taarifa Ya Madeni Kuanzia Tarehe $from Hadi Tarehe $to </u></b></td></tr>";
			echo "<tr style='background-color:#515151;color:white;font-family:Georgia, Times New Roman, Times, serif;font-weight:bold;font-size:15;'><th>SN</th><th>Jina</th><th>Kiasi Kilichokopwa</th><th>Kiasi Kilicholipwa</th><th>Kiasi Kilichobaki</th><th>Hali Ya Deni</th><th>Maelezo Ya Ziada</th><th>Tarehe Ya Deni</th></tr>";
			$counter=1;
			while ($row=mysql_fetch_array($results)) {
				$remainder=$count%2;
				if ($remainder==0)
				$bgcolor='background-color:#A5E5E5;font-family:Geneva, Arial, Helvetica, sans-serif;';
				else
				$bgcolor='background-color:#E5E5E5;font-family:Geneva, Arial, Helvetica, sans-serif';
				$count++;
				
				$amount=number_format($row["amount"]);
				$date = date_create($row["date_debited"]);
				$date=date_format($date,"jS F Y");
				$paid=number_format($row["paid"]);
				$pending=$row["amount"]-$row["paid"];
				$totalDebts=$totalDebts+$pending;
				$pending=number_format($pending);
				if($row["status"]=="cleared")
				$status="Cleared";
				else if($row["status"]=="notCleared")
				$status="Not Cleared";
				list($customer_name)=mysql_fetch_array(mysql_query("select name from customers where id='$row[customer_id]'"));
				echo "<tr style='$bgcolor' onmouseover='color=this.style.background;this.style.background=\"gold\";' onmouseout='this.style.background=color'><td align='center'>$counter</td><td align='center'>$customer_name</td><td align='center'>$amount</td><td align='center'>$paid</td><td align='center'>$pending</td><td>$status</td><td align='center'>$row[description]</td><td align='center'>$date</td></tr>";
				$counter++;				
				}
			$totalDebts=number_format($totalDebts);
			echo "<tr style='background-color:#515151;color:white;font-family:Georgia, Times New Roman, Times, serif;font-weight:bold;font-size:15;'><td colspan='8' align='center'><b>Jumla Ya Deni Lililobaki=$totalDebts</b></td></tr>";
			}
		}
		
	if($_REQUEST["debits_credits"]=="credits") {
		$customer_id=$_REQUEST["customer_id"];
		$status=$_REQUEST["status"];
		if($customer_id=="" and $status=="cleared")
		$results=mysql_query("select * from credits where date_credited between '$from' and '$to' and status='cleared'") or die(mysql_error());
		else if($customer_id=="" and $status=="notcleared")
		$results=mysql_query("select * from credits where date_credited between '$from' and '$to' and status='notCleared'") or die(mysql_error());
		else if($customer_id=="" and $status=="all")
		$results=mysql_query("select * from credits where date_credited between '$from' and '$to'") or die(mysql_error());
		else if($customer_id!="" and $status=="cleared")
		$results=mysql_query("select * from credits where date_credited between '$from' and '$to' and status='cleared' and customer_id='$customer_id'") or die(mysql_error());
		else if($customer_id!="" and $status=="notcleared")
		$results=mysql_query("select * from credits where date_credited between '$from' and '$to' and status='notCleared'  and customer_id='$customer_id'") or die(mysql_error());
		else if($customer_id!="" and $status=="all")
		$results=mysql_query("select * from credits where date_credited between '$from' and '$to' and customer_id='$customer_id'") or die(mysql_error());
					
		if (mysql_num_rows($results)==0)
		echo "<center><b>Hakuna Ripoti</b></center>";
		else {
			$from = date_create($from);
			$from=date_format($from,"jS F Y");
			$to = date_create($to);
			$to=date_format($to,"jS F Y");
			echo "<tr><td colspan='7' align='center'><b><u>Taarifa Ya Madai Kuanzia Tarehe $from Hadi Tarehe $to </u></b></td></tr>";
			echo "<tr style='background-color:#515151;color:white;font-family:Georgia, Times New Roman, Times, serif;font-weight:bold;font-size:15;'><th>SN</th><th>Jina</th><th>Kiasi Cha Dai</th><th>Kiasi Kilicholipwa</th><th>Kiasi Kilichobaki</th><th>Maelezo Ya Ziada</th><th>Tarehe Ya Kukopwa</th></tr>";
			$counter=1;
			while ($row=mysql_fetch_array($results)) {
				$remainder=$count%2;
				if ($remainder==0)
				$bgcolor='background-color:#A5E5E5;font-family:Geneva, Arial, Helvetica, sans-serif;';
				else
				$bgcolor='background-color:#E5E5E5;font-family:Geneva, Arial, Helvetica, sans-serif';
				$count++;
				
				$amount=number_format($row["amount"]);
				$date = date_create($row["date_credited"]);
				$date=date_format($date,"jS F Y");
				$paid=number_format($row["paid"]);
				$pending=$row["amount"]-$row["paid"];
				$total_credits=$total_credits+$pending;
				$pending=number_format($pending);
				if($row["status"]=="cleared")
				$status="Cleared";
				else if($row["status"]=="notCleared")
				$status="Not Cleared";
				list($customer_name)=mysql_fetch_array(mysql_query("select name from customers where id='$row[customer_id]'"));
				echo "<tr style='$bgcolor' onmouseover='color=this.style.background;this.style.background=\"gold\";' onmouseout='this.style.background=color'><td align='center'>$counter</td><td align='center'>$customer_name</td><td align='center'>$amount</td><td align='center'>$paid</td><td align='center'>$pending</td><td align='center'>$row[description]</td><td align='center'>$date</td></tr>";
				$counter++;
				}
			$total_credits=number_format($total_credits);
			echo "<tr style='background-color:#515151;color:white;font-family:Georgia, Times New Roman, Times, serif;font-weight:bold;font-size:15;'><td colspan='8' align='center'><b>Jumla Ya Dai Lililobaki=$total_credits</b></td></tr>";
			}
		}		
	}
	
	if ($_REQUEST["from"]=="search_customer") {		
		$name=$_REQUEST["search_name"];
		$result=mysql_query("select * from customers where name like '%$name%'") or die(mysql_error());
		if (mysql_num_rows($result)==0) {
		echo "No Search Results Found";
		exit;
		}
		echo "<select name='customer' id='customer' size='5' style='width:250;position:relative;bottom:7px' onchange='get_selected_from_search()'>";
		while ($row=mysql_fetch_array($result))
		{
		$debits=mysql_query("select id from debits where customer_id='$row[id]'");
		$credits=mysql_query("select id from credits where customer_id='$row[id]'");
		if(mysql_num_rows($debits)==0 and mysql_num_rows($credits)==0)
		continue;
		echo "<option value='$row[id]'>".$row["name"]."</option>";
		}
		echo "</select>";
		}
?>
