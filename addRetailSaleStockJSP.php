	<?php
	include("authentication.php");
	if ($_REQUEST["from"]=="show_batches") {
		$item_id=$_REQUEST["id"];
		echo "<td>Chagua Batch</td><td><select name='batch' onchange='show_batch_descriptions(this.value)'><option value='-1'>---Chagua Batch---</option>";		
		$results=mysql_query("select id from wholeStock where itemId='$item_id' and available>0 order by expire_date DESC");
		while($row=mysql_fetch_array($results)) {
			echo "<option>$row[id]</option>";
			}
		echo "</select></td>";
		echo "<td>Chagua Tawi</td><td><select name='branch'><option value='-1'>---Chagua---</option>";
		$results=mysql_query("select id,name from branches");
		while($row=mysql_fetch_array($results)) {
			echo "<option value='$row[id]'>$row[name]</option>";
			}
		echo "</td>";
		}
	
	else if($_REQUEST["from"]=="show_batch_descriptions") {
		$batch_id=$_REQUEST["id"];
		$bgcolor='background-color:#A5E5E5;font-family:Geneva, Arial, Helvetica, sans-serif;';
		list($id,$itemId,$quantity,$available,$price,$date_stocked,$exp_date)=mysql_fetch_array(mysql_query("select id,itemId,quantity,available,buying_price,date_stocked,expire_date from wholeStock where id='$batch_id'"));
		list($itemname,$unit,$total_units)=mysql_fetch_array(mysql_query("select name,unit,total_units from items where id='$itemId'"));
		list($unit)=mysql_fetch_array(mysql_query("select name from units where id='$unit'"));
		echo "<tr><td colspan='5' align='center'><br><b>Ingiza Idadi Ya Pieces Kuhamishia Kwenye Stock Ya Reja Reja (Batch $id Ya $itemname)</b></td></tr>";
		echo "<input type='hidden' name='quantity_available' value='$available'>";
		echo "<tr style='background-color:#515151;color:white;font-family:Georgia, 'Times New Roman', Times, serif;font-weight:bold;font-size:14;'><th>Jina La Bidhaa</th><th>Pieces Zilizopo</th><th>Bei Iliyonunuliwa Kwa Piece</th><th>Expire Date</th><th>Idadi Ya Piece Za Kuhamisha</th></tr>";
		echo "<tr style='$bgcolor'><td align='center'>$itemname</td><td align='center'>$available</td><td align='center'>".number_format($price)."</td><td>$exp_date</td><td><input type='text' name='quantity_transfer' onkeyup='show_units(this.value)'><label id='units_$batch_id'></label></td><td><input type='button' name='transfer' id='transfer_btn' value='Hamisha' onclick='return validate_transfer()'></td></tr>";
		echo "<input type='hidden' name='total_units_$batch_id' id='total_units_$batch_id' value='$total_units'><input type='hidden' name='unit_$batch_id' id='unit_$batch_id' value='$unit'>";
		}
		
	else if($_REQUEST["from"]=="make_transfer") {
		$batch=$_REQUEST["batch"];
		$quantity=$_REQUEST["quantity"];
		$destination_branch=$_REQUEST["branch"];
		$date_transfered=$_REQUEST["date_transfered"];

		list($buying_price,$itemId,$whole_quantity,$whole_available,$exp_date,$source_branch)=mysql_fetch_array(mysql_query("select buying_price,itemId,quantity,available,expire_date,branch_id from wholeStock where id='$batch'"));
		list($total_units)=mysql_fetch_array(mysql_query("select total_units from items where id='$itemId'"));
		$total_units=$total_units*$quantity;
		
		//check if this batch already existing into the database and update it
		$check_batch=mysql_query("select id,quantity,available from retailStock where batch_number='$batch' and branch_id='$destination_branch'");
		if(mysql_num_rows($check_batch)>0) {
			list($id,$db_quantity,$db_available)=mysql_fetch_array($check_batch);
			$new_quantity=$db_quantity+$total_units;
			$new_available=$db_available+$total_units;
			mysql_query("update retailStock set quantity='$new_quantity',available='$new_available' where id='$id'");
			$destination_id=$id;
			}
		else {
		mysql_query("insert into retailStock (batch_number,itemId,quantity,available,buyingPrice,date,branch_id,expire_date) values ('$batch','$itemId','$total_units','$total_units','$buying_price','$date_transfered','$destination_branch','$exp_date')") or die(mysql_error());
		$destination_id=mysql_insert_id();
			}		
		$whole_available=$whole_available-$quantity;
		mysql_query("update wholeStock set available='$whole_available' where id='$batch'");		
		mysql_query("insert into items_transfer (itemId,quantity_transfered,date_transfered,stock_id_from,stock_id_to,source_branch,destination_branch,transfer_type) values ('$itemId','$quantity','$date_transfered','$batch','$destination_id','$source_branch','$destination_branch','retail')");
		}	
	?>
