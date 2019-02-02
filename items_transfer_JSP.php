	<?php
	include("authentication.php");
	if ($_REQUEST["from"]=="show_batches") {
		$item_id=$_REQUEST["id"];
		list($branch_id) = mysql_fetch_array(mysql_query("select id from branches where type='hq'"));
		echo "<td>Chagua Batch</td><td><select name='batch' onchange='show_batch_descriptions(this.value)'><option value='-1'>---Chagua Batch---</option>";		
		$results=mysql_query("select id from wholeStock where itemId='$item_id' and available>0 and branch_id=$branch_id order by expire_date,available DESC");
		while($row=mysql_fetch_array($results)) {
			echo "<option>$row[id]</option>";
			}
		echo "</select></td>";
		echo "<td>Chagua Tawi</td><td><select name='branch'><option value='-1'>---Chagua Tawi---</option>";
		$branches=mysql_query("select name,id from branches where id!=$branch_id");
		while($row=mysql_fetch_array($branches)) {
			echo "<option value='$row[id]'>$row[name]</option>";
			}
		echo "</select></td>";
		}
	
	else if($_REQUEST["from"]=="show_batch_descriptions") {
		$batch_id=$_REQUEST["id"];
		$bgcolor='background-color:#A5E5E5;font-family:Geneva, Arial, Helvetica, sans-serif;';
		list($id,$itemId,$quantity,$available,$price,$date_stocked,$exp_date)=mysql_fetch_array(mysql_query("select id,itemId,quantity,available,buying_price,date_stocked,expire_date from wholeStock where id='$batch_id'"));
		list($itemname,$total_units,$unit)=mysql_fetch_array(mysql_query("select name,total_units,unit from items where id='$itemId'"));
		list($unit_name)=mysql_fetch_array(mysql_query("select name from units where id='$unit'"));
		if($total_units==0)
		$total_units="";		
		echo "<tr><td colspan='5' align='center'><br><b>Ingiza Idadi Ya Pieces Kuhamishia Kwenda Tawi Jingine (Batch $id Ya $itemname $unit_name $total_units )</b></td></tr>";
		echo "<input type='hidden' name='quantity_available' value='$available'>";
		echo "<tr style='background-color:#515151;color:white;font-family:Georgia, 'Times New Roman', Times, serif;font-weight:bold;font-size:14;'><th>Jina La Bidhaa</th><th>Piece Zilizopo</th><th>Bei Iliyonunuliwa Kwa Piece</th><th>Expire Date</th><th>Idadi Ya Kuhamisha</th></tr>";
		echo "<tr style='$bgcolor'><td align='center'>$itemname</td><td align='center'>$available</td><td align='center'>".number_format($price)."</td><td>$exp_date</td><td><input type='text' name='quantity_transfer'></td><td><input type='button' id='transfer_btn' name='transfer' value='Hamisha' onclick='return validate_transfer()'></td></tr>";
		}
		
	else if($_REQUEST["from"]=="make_transfer") {
		$batch=$_REQUEST["batch"];
		$quantity=$_REQUEST["quantity"];
		$destination_branch=$_REQUEST["branch"];
		$date_transfered=$_REQUEST["date_transfered"];
		list($buying_price,$itemId,$whole_quantity,$whole_available,$source_branch,$exp_date)=mysql_fetch_array(mysql_query("select buying_price,itemId,quantity,available,branch_id,expire_date from wholeStock where id='$batch'"));		
		$whole_available=$whole_available-$quantity;
		mysql_query("update wholeStock set available='$whole_available' where id='$batch'");
		mysql_query("insert into wholeStock (itemId,quantity,available,buying_price,date_stocked,expire_date,branch_id) values ('$itemId','$quantity','$quantity','$buying_price','$date_transfered','$exp_date','$destination_branch')");
		$destination_id=mysql_insert_id();	
		mysql_query("insert into items_transfer (itemId,quantity_transfered,date_transfered,stock_id_from,stock_id_to,source_branch,destination_branch,transfer_type) values ('$itemId','$quantity','$date_transfered','$batch','$destination_id','$source_branch','$destination_branch','whole')");
		}
	?>
