<?php
include "authentication.php";
include("months.php");
if ($_REQUEST["from"]=="search_employees")
{
$name=$_REQUEST["name"];
$pay_month=$_REQUEST["pay_month"];
$pay_year=$_REQUEST["pay_year"];
$result=mysql_query("select * from employees where firstname like '$name%' and status='employee' and id not in (select employee_id from salary_payments where salary_month='$pay_month' and salary_year='$pay_year')") or die(mysql_error());
if (mysql_num_rows($result)==0)
echo "Watumishi Wote Wamelipwa Mshahara Wa ".$month_array[$pay_month]." ". $pay_year;
else
{
echo "<div id='errmsg'></div>";
echo "<table><tr><td colspan='8' align='center'><h3>MALIPO YA MSHAHARA KWA MWEZI $month_array[$pay_month] $pay_year</h3></td></tr><tr style='background-color:#515151;color:white;font-family:Georgia, Times New Roman, Times, serif;font-weight:bold;font-size:13;'><th>SN</th><th>Jina Kamili</th><th>Cheo</th><th>Mshahara (Basic Salary)</th><th>Mshahara Wa Mwisho</th><th>Kiasi Kilichokatwa</th><th>Sababu Ya Kukata Hicho Kiasi</th></tr>";
	while ($row=mysql_fetch_array($result)) {
		$remainder=$count%2;
		if ($remainder==0)
		$bgcolor='background-color:#A5E5E5;font-family:Geneva, Arial, Helvetica, sans-serif;';
		else
		$bgcolor='background-color:#E5E5E5;font-family:Geneva, Arial, Helvetica, sans-serif';
		$count++;
		list($last_month,$last_year)=mysql_fetch_array(mysql_query("select max(salary_month),max(salary_year) from salary_payments where salary_year in (select max(salary_year) from salary_payments where employee_id='$row[id]') and employee_id='$row[id]'"));
		if($last_month>0)
		$last_month=$month_array[$last_month];
		else {
			$last_month="No salary";
			}
		list($designation)=mysql_fetch_array(mysql_query("select name from designation where id='$row[designation]'"));
	echo "<tr style='$bgcolor'><td>$count</td><td>$row[firstname] $row[middlename] $row[surname]</td><td>$designation</td><td>".number_format($row["salary"])."</td><td>$last_month $last_year</td></td><td><input type='text' name='deduct[$row[id]]' id='deduct_$row[id]'></td><td><input type='text' name='deduct_reason[$row[id]]' id='deduct_reason_$row[id]'></td><td><input type='button' name='submit' value='Lipa' onclick='return check($row[id])'></td></tr>";
	}
}
}

else if ($_REQUEST["from"]=="check")
{
$emp_id=$_REQUEST["emp_id"];
$month=$_REQUEST["pay_month"];
$year=$_REQUEST["pay_year"];
$amount_deducted=$_REQUEST["amount_deducted"];
list($salary)=mysql_fetch_array(mysql_query("select salary from employees where id='$emp_id'"));
if($salary<$amount_deducted) {
	echo "Kiwango Cha Kupunguzwa Kina Zidi Mshahara Anaolipwa";
	exit();
	}

//check if this employee paid for this month
$results=mysql_query("select id from salary_payments where employee_id='$emp_id' and salary_month='$month' and salary_year='$year'");
if(mysql_num_rows($results)>0) {
	echo "This Employee Already Paid Salary For ".$month_array[$month];
	exit();
	}

//check if this employee wasnt paid for previous month
	$prev_month=$month-1;
	if($prev_month==0) {
		$prev_month=12;
		$year=$year-1;
		}

$results=mysql_query("select id from salary_payments where employee_id='$emp_id' and salary_month='$prev_month' and salary_year='$year'");
if(mysql_num_rows($results)==0) {
	//if you change this error msg please change the code at pay_salary.php on line 62 (javascript)
	echo "Mshahara Wa ".$month_array[$prev_month]." Haujalipwa,Endelea Hivyo Hivyo?";
	exit();
	}
}

else if ($_REQUEST["from"]=="submit")
{
$emp_id=$_REQUEST["emp_id"];
$amount_deducted=$_REQUEST["amount_deducted"];
$ded_reason=$_REQUEST["ded_reason"];
$month=$_REQUEST["pay_month"];
$year=$_REQUEST["pay_year"];
list($salary)=mysql_fetch_array(mysql_query("select salary from employees where id='$emp_id'"));
mysql_query("insert into salary_payments (employee_id,basic_salary,amount_deducted,deduction_descriptions,salary_month,salary_year) values ('$emp_id','$salary','$amount_deducted','$ded_reason','$month','$year')");
}
?>
