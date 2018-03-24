<?php
include "authentication.php";
include("months.php");
if ($_REQUEST["from"]=="search_employees")
{
$name=$_REQUEST["name"];
$result=mysql_query("select * from employees where firstname like '$name%' and status='employee'") or die(mysql_error());
if (mysql_num_rows($result)==0)
echo "There Is No Employees";
else
{
echo "<div id='errmsg'></div>";
echo "<table><tr><td colspan='7' align='center'><h3>SITISHA MKATABA WA MTUMISHI</h3></td></tr><tr style='background-color:#515151;color:white;font-family:Georgia, Times New Roman, Times, serif;font-weight:bold;font-size:13;'><th>SN</th><th>Jina Kamili</th><th>Cheo</th><th>Mshahara (Basic Salary)</th><th>Mshahara Wa Mwisho</th><th>Sababu Za Kusitisha Mkataba</th><th>Tarehe Ya Kusitisha Mkataba</th></tr>";
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
	echo "<tr style='$bgcolor'><td>$count</td><td>$row[firstname] $row[middlename] $row[surname]</td><td>$designation</td><td>".number_format($row["salary"])."</td><td>$last_month $last_year</td></td><td><textarea rows='5' name='reason[$row[id]]' id='reason_$row[id]'></textarea></td><td><input type='text' name='date_terminated_$row[id]' id='date_terminated_$row[id]'></td><td><input type='button' name='submit' value='Terminate Contract' onclick='return save_data($row[id])'></td></tr>";
	}
}
}

else if ($_REQUEST["from"]=="save_data")
{
$emp_id=$_REQUEST["emp_id"];
$reason=$_REQUEST["reason"];
$date=date("Y-m-d",strtotime($_REQUEST["date"]));
mysql_query("update employees set status='terminated' where id='$emp_id'") or die(mysql_error());
mysql_query("insert into contract_termination (employee_id,date_terminated,reason) values ('$emp_id','$date','$reason')") or die(mysql_error());
echo "<b>Employee Terminated Successfully</b>";
}
?>
