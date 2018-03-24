<?php
include "authentication.php";
include("months.php");
if ($_REQUEST["from"]=="search_employees")
{
$name=$_REQUEST["name"];
$from_date=date("Y-n-d",strtotime($_REQUEST["from_date"]));
$to_date=date("Y-n-d",strtotime($_REQUEST["to_date"]));
$contract=$_REQUEST["contract"];
$salary_status=$_REQUEST["salary_status"];
$from_date=explode("-",$from_date);
$from_month=$from_date[1];
$from_year=$from_date[0];
$to_date=explode("-",$to_date);
$to_month=$to_date[1];
$to_year=$to_date[0];

if($salary_status=="paid")
$results=mysql_query("select * from salary_payments where salary_month between '$from_month' and '$to_month' and salary_year between '$from_year' and '$to_year' and employee_id in (select id from employees where firstname like '$name%' and status like '%$contract%')") or die(mysql_error());

else if($salary_status=="not_paid") {
$results=mysql_query("select * from employees where firstname like '$name%' and status like '%$contract%'") or die(mysql_error());
}
if (mysql_num_rows($results)==0)
echo "No Report Found";
else
{
echo "<table><tr style='background-color:#515151;color:white;font-family:Georgia, Times New Roman, Times, serif;font-weight:bold;font-size:13;'><th>SN</th><th>Jina Kamili</th><th>Cheo</th><th>Mshahara Ulolipwa</th><th>Mwezi</th><th>Makato</th><th>Sababu Za Makato</th></tr>";
	while ($row=mysql_fetch_array($results)) {
		if($salary_status=="paid") {
		$emp_id=$row["employee_id"];
		list($des_id,$fname,$mname,$surname)=mysql_fetch_array(mysql_query("select designation,firstname,middlename,surname from employees where id='$emp_id'"));
		$salary=$row["basic_salary"];
		$remainder=$count%2;
		if ($remainder==0)
		$bgcolor='background-color:#A5E5E5;font-family:Geneva, Arial, Helvetica, sans-serif;';
		else
		$bgcolor='background-color:#E5E5E5;font-family:Geneva, Arial, Helvetica, sans-serif';
		$count++;
		list($designation)=mysql_fetch_array(mysql_query("select name from designation where id='$des_id'"));
echo "<tr style='$bgcolor'><td align='center'>$count</td><td align='center'>$fname $mname $surname</td><td align='center'>$designation</td><td align='center'>$row[basic_salary]</td><td align='center'>".$month_array[$row["salary_month"]]." ".$row["salary_year"]."</td><td align='center'>$row[amount_deducted]</td><td align='center'>$row[deduction_descriptions]</td></tr>";		
		}
		else {
					$check_salary=mysql_query("select id from salary_payments where employee_id='$row[id]' and salary_month between '$from_month' and '$to_month' and salary_year between '$from_year' and '$to_year'") or die(mysql_error());
					$total_salary_rows = mysql_num_rows($check_salary);
					$total_no_salary_rows=$to_month-$total_salary_rows;
					
					if($total_no_salary_rows>0) {
					$count++;
					$remainder=$count%2;
					if ($remainder==0)
					$bgcolor='background-color:#E5E5E5;font-family:Geneva, Arial, Helvetica, sans-serif;';
					else
					$bgcolor='background-color:#A5E5E5;font-family:Geneva, Arial, Helvetica, sans-serif';	
					echo "<tr style='$bgcolor' onmouseover='color=this.style.background;this.style.background=\"gold\";' onmouseout='this.style.background=color'><td rowspan='$total_no_salary_rows' align='center'>$count</td><td rowspan='$total_no_salary_rows' align='center'>$row[firstname] $row[middlename] $row[surname]</td><td rowspan='$total_no_salary_rows' align='center'>$designation</td><td rowspan='$total_no_salary_rows' align='center'>0</td>";
						}
			$person_row=1;
			for($year_loop=$from_year;$year_loop<=$to_year;$year_loop++) {
				for($month_loop=$from_month;$month_loop<=$to_month;$month_loop++) {
					$check_salary=mysql_query("select id from salary_payments where employee_id='$row[id]' and salary_month='$month_loop' and salary_year='$year_loop'") or die(mysql_error());
					if(mysql_num_rows($check_salary)>0)
					continue;
					else {			
							list($designation)=mysql_fetch_array(mysql_query("select name from designation where id='$row[designation]'"));					
					$remainder=$person_row % 2;
					if ($remainder==0)
					$bgcolor='background-color:#F5F5DC;font-family:Geneva, Arial, Helvetica, sans-serif;';
					else
					$bgcolor='background-color:#CFECEC;font-family:Geneva, Arial, Helvetica, sans-serif';
echo "<td style='$bgcolor' align='center'>".$month_array[$month_loop]." ".$year_loop."</td>";
if($person_row==1)
echo "<td rowspan='$total_no_salary_rows' align='center'>0</td><td rowspan='$total_no_salary_rows' align='center'>-</td>";
echo "</tr>";
$person_row++;
						}
				}
			}
			$person_row=1;
			}
	}
}
}
?>