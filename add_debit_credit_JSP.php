	<?php
	include("authentication.php");
	if($_REQUEST["from"]=="process") {
		$debit_credit=$_REQUEST["debit_credit"];
		$amount=$_REQUEST["amount"];
		$customer_id=$_REQUEST["customer_id"];
		$descr=$_REQUEST["descr"];
		$date=date("Y-m-d",strtotime($_REQUEST["date"])); 
		if($debit_credit=="debit") {
			mysql_query("insert into debits (customer_id,amount,date_debited,description) values ('$customer_id','$amount','$date','$descr')") or die(mysql_error());
			}
		else if($debit_credit=="credit") {
			mysql_query("insert into credits (customer_id,amount,date_credited,description) values ('$customer_id','$amount','$date','$descr')") or die(mysql_error());
			}
		echo "Save Successfully";
		}
		
	else if($_REQUEST["from"]=="search_customer") {		
		$search=$_REQUEST["search_name"];
		$results=mysql_query("select id,name from customers where name like '%$search%'");
		if(mysql_num_rows($results)==0) {		
			echo "No Search Results Found";
			exit;
			}
		echo "<select name='customer' id='customer' size='5' style='width:250;position:relative;bottom:7px' onchange='get_selected_from_search()'>";
		while ($row=mysql_fetch_array($results)) {
			echo "<option value='$row[id]'>$row[name]</option>";	
			}
		echo "</select>";
		}
	?>