<?php
	/*
	 * This file is ready to run as standalone example. However, please do:
	 * 1. Add tags <html><head><body> to make a complete page
	 * 2. Change relative path in $KoolControlFolder variable to correctly point to KoolControls folder 
	 */

	$KoolControlsFolder = "../../../../KoolControls";//Relative path to "KoolPHPSuite/KoolControls" folder
	
	require $KoolControlsFolder."/KoolAjax/koolajax.php";
	$koolajax->scriptFolder = $KoolControlsFolder."/KoolAjax";

	require $KoolControlsFolder."/KoolGrid/koolgrid.php";
	require $KoolControlsFolder."/KoolCalendar/koolcalendar.php";
	
		
	$ds = new MySQLDataSource($db_con);//This $db_con link has been created inside KoolPHPSuite/Resources/runexample.php
	$ds->SelectCommand = "select orderNumber,orderDate,status,comments from orders";
	$ds->UpdateCommand = "update orders set orderDate='@orderDate', status='@status', comments='@comments' where orderNumber=@orderNumber";
	$ds->DeleteCommand = "delete from orders where orderNumber=@orderNumber";

	$grid = new KoolGrid("grid");
	$grid->scriptFolder = $KoolControlsFolder."/KoolGrid";
	$grid->styleFolder="sunset";

	$grid->AjaxEnabled = true;
	$grid->DataSource = $ds;
	$grid->MasterTable->Pager = new GridPrevNextAndNumericPager();
	$grid->Width = "655px";
	$grid->ColumnWrap = true;
	$grid->AllowEditing = true;
	$grid->AllowDeleting = true;
	$grid->AllowSorting = true;

	$column = new GridBoundColumn();
	$column->DataField = "orderNumber";
	$column->ReadOnly = true;
	$grid->MasterTable->AddColumn($column);

	$column = new GridDateTimeColumn();
	$column->DataField = "orderDate";
	$column->HeaderText = "orderDate";
	$column->FormatString = "M d, Y";
	//Assign datepicker for GridDateTimeColumn, this is optional.
	$column->Picker = new KoolDatePicker();
	$column->Picker->scriptFolder = $KoolControlsFolder."/KoolCalendar";
	$column->Picker->styleFolder = "sunset";	
	$column->Picker->DateFormat = "M d, Y";
	
	$grid->MasterTable->AddColumn($column);

	$column = new GridDropDownColumn();
	$column->DataField = "status";
	$column->HeaderText = "Status";
	$column->AddItem("In Process");
	$column->AddItem("On Hold");
	$column->AddItem("Disputed");
	$column->AddItem("Cancelled");	
	$column->AddItem("Resolved");	
	$column->AddItem("Shipped");
	$column->CssClass="status";
	$grid->MasterTable->AddColumn($column);

	$column = new GridTextAreaColumn();
	$column->DataField = "comments";
	$column->HeaderText = "Comments";
	$column->Width = "200px";
	$grid->MasterTable->AddColumn($column);

	$column = new GridEditDeleteColumn();
	$column->Align = "center";
	$grid->MasterTable->AddColumn($column);
	
	$grid->MasterTable->EditSettings->Mode = "Inline";//"Inline" is default value;
	
	
	class MyGridEventHandler extends GridEventHandler
	{
		function OnRowPreRender($row,$args)
		{
			switch($row->DataItem["status"])
			{
				case "In Process":
					$row->CssClass="css_inprocess";
					break;
				case "On Hold":
					$row->CssClass="css_onhold";
					break;
				case "Disputed":
					$row->CssClass="css_disputed";
					break;
				case "Cancelled":
					$row->CssClass="css_cancelled";
					break;
				case "Resolved":
					$row->CssClass="css_resolved";
					break;
				case "Shipped":
					$row->CssClass="css_shipped";					
					break;
				default:
			}
		}
	}
	$grid->EventHandler = new MyGridEventHandler();
	
	
	
	$grid->Process();
?>

<form id="form1" method="post">
	<style type="text/css">
		.sunsetKGR tr.css_inprocess td.kgrCell
		{
			background:#A6D8F0;
		}
		.sunsetKGR tr.css_resolved td.kgrCell
		{
			background:#9BFF9B;
		}
		.sunsetKGR tr.css_shipped td.kgrCell
		{
			background:#9BFF9B;
		}		
		.sunsetKGR tr.css_onhold td.kgrCell
		{
			background:#FFE88C;
		}
		.sunsetKGR tr.css_disputed td.kgrCell
		{
			background:#FF9D9D;
		}
		.sunsetKGR tr.css_cancelled td.kgrCell
		{
			background:#E0E0E0;
		}
		
	</style>
	<?php echo $koolajax->Render();?>
	<?php echo $grid->Render();?>
	<div style="margin-top:10px;"><i>* <u>Note</u>:</i>Generate your own grid with <a style="color:#B8305E;" target="_blank" href="http://codegen.koolphp.net/grid/">Code Generator</a></div>
	
</form>
