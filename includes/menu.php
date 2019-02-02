<div style="background-color:#386679;height:30">
<?php
ini_set('error_reporting', E_ALL & ~E_NOTICE);        
?>
<ul id="nav" class="dropdown dropdown-horizontal">
<?php
if($_SESSION["role"] == "admin") {
?>
<li class="first"><a href="#" style="font-size:13;margin-left:60">Sajili</a>
		<ul>
		<li><a href="defineItem.php" style="font-size:11;">Sajili Bidhaa</a></li>
		<li><a href="define_unit.php" style="font-size:11;">Sajili Unit</a></li>
		<li><a href="defineCustomer.php" style="font-size:11;">Sajili Mteja</a></li>
		<li><a href="defineExpenditures.php" style="font-size:11;">Sajili Aina Ya Matumizi</a></li>
		<li><a href="editItems.php">Badili Taarifa Za Bidhaa</a></li>
		<li><a href="add_branch.php">Tawi</a></li>
		<li><a href="addUser.php">Mtumiaji Wa Mfumo</a></li>
		</ul>
</li>
<?php
}
if($_SESSION["role"] != "admin")
echo '<li class="first"><a href="#" style="font-size:13;margin-left:60">Mauzo</a>';
else
echo '<li class="first"><a href="#" style="font-size:13">Mauzo</a>';
?>
		<ul>
		<li><a href="wholeSale.php" ><b style="font-size:11;">Uza Bidhaa</a></li>
		<li><a href="retailSale.php">Uza Bidhaa Za Reja Reja</b></a></li>
		<li><a href="clear_advance_sales.php" style="font-size:11;">Lipa Mauzo Yenye Madeni</a></li>
<?php
if($_SESSION["role"] == "admin")
?>
		<li><a href="deleteSales.php" style="font-size:11;">Futa Mauzo</a></li>
		<li><a href="salesReport.php" style="font-size:11;">Ripoti Za Mauzo</a></li>		
		</ul>
</li>
	
<li class="first"><a href="#" style="font-size:13">Stock Management</a>
		<ul>
<?php
if($_SESSION["role"] == "admin") {
?>
		<li><a href="addWholeSaleStock.php" ><b style="font-size:11;">Ingiza Mzigo Stock</a></li>
		<li><a href="addRetailSaleStock.php">Hamisha Mzigo Uuzwe Rejareja</b></a></li>
		<li><a href="items_transfer.php">Hamisha Bidhaa Tawi Jingine</b></a></li>
<?php
}
?>
		<li><a href="wholeStockReport.php" style="font-size:11;">Ripoti Ya Stock</a></b></li>
		<li><a href="retailStockReport.php" style="font-size:11;">Ripoti Ya Stock Za Reja Reja</a></b></li>		
		</li>
		</ul>
</li>	

<li class="first"><a href="#" style="font-size:13">Matumizi</a>
		<ul>
		<li><a href="addExpenditures.php" style="font-size:11;">Ongeza Matumizi</a></li>
		<li><a href="expenditureReport.php" style="font-size:11;">Taarifa Ya Matumizi</a></li>	
		</ul>
</li>	

<li class="first"><a href="#" style="font-size:13">Madeni/Madai</a>
		<ul>
		<li><a href="add_debit_credit.php" style="font-size:11;">Sajili Deni/Dai</a></li>
		<li><a href="clear_debit.php" style="font-size:11;">Lipa Deni</a></li>
		<li><a href="clear_credit.php" style="font-size:11;">Lipa Dai</a></li>
		<li><a href="debit_credit_report.php" style="font-size:11;">Ripoti Ya Madeni Na Madai</a></li>
		</ul>
</li>

<li class="first"><a href="#" style="font-size:13">Watumishi</a>
		<ul>
<?php
if($_SESSION["role"] == "admin") {
?>
		<li><a href="add_employee.php" style="font-size:11;">Ajiri Mtumishi Mpya</a></li>
		<li><a href="terminate_employee.php" style="font-size:11;">Sitisha Mkataba Wa Mtumishi</a></li>
		<li><a href="add_designation.php" style="font-size:11;">Sajili Cheo</a></li>
<?php
}
?>
		<li><a href="pay_salary.php" style="font-size:11;">Lipa Mishahara</a></li>			
		<li><a href="salary_report.php" style="font-size:11;">Ripoti Ya Malipo Ya Mishahara</a></li>
		<li><a href="staffs_list.php" style="font-size:11;">Orodha Ya Watumishi</a></li>
		</ul>
</li>
<?php
if($_SESSION["role"] == "admin") {
?>
<li class="first"><a href="#" style="font-size:13">Futa</a>
                <ul>
                <li><a href="delete_items.php" style="font-size:11;">Futa Bidhaa</a></li>
                </ul>
</li>
<?php
}
?>
<li class="first"><a href="changePassword.php" style="font-size:13">Change Password</a>
</li>
<li><a href="logout.php" style="font-size:13">Logout</a></li>					
				
</ul>
</div>
