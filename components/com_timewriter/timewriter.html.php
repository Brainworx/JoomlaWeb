<?php
/**
* BrainWorX TimeWriter Component
* @package TimeWriter
* @copyright (C) 2010 BrainWorX/ All rights reserved
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @link http://www.brainworx.be
*
* Based on the Mambotastic Timesheets Component, ObjectClarity TimeWriter component
* @copyright (C) 2007 Objectclarity / All Rights Reserved
* @copyright (C) 2005 Mark Stewart / All Rights Reserved
* @Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
**/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

require_once dirname(__FILE__) . '/../../administrator/components/com_timewriter/admin.timewriter.html.php';

global $mosConfig_live_site;

/**
* Utility class for writing the HTML for content
* @package Mambo
* @subpackage Content
*/

class HTML_timesheet_content {

/*****************************************************************************
 *
*****************************************************************************/
function buildUrl($objectid, $param) {
	// Build the URL of selected objects 
	$url = "";
	if (is_array($objectid)) {
		for($i=0; $i < count($objectid); $i++) {
			$url .= "&" . $param . "[]=" . $objectid[$i];
		}
	} else {
		$url .= "&" . $param . "[]=" . $objectid;	
	}
	return $url;  
}

/*****************************************************************************
 *
*****************************************************************************/
function printDateIncludes() {
// <script type="text/javascript" src="./includes/js/calendar/calendar.js"></script>
// <script type="text/javascript" src="./includes/js/calendar/lang/calendar-en.js"></script>
// <script type="text/javascript" src="./includes/js/joomla.javascript.js"></script>
// <script type="text/javascript" src="./media/system/js/mootools.js"></script>
?>
	<link rel="stylesheet" type="text/css" media="all" href="./includes/js/calendar/calendar-mos.css" title="green" />
	
	
	
	<script type="text/javascript" src="./media/system/js/calendar.js"></script>
	<script type="text/javascript" src="./media/system/js/calendar-setup.js"></script>
	<script type="text/javascript" src="./media/system/js/modal.js"></script>
<script type="text/javascript" src="./includes/js/joomla.javascript.js"></script>	
<script type="text/javascript" src="./media/system/js/mootools.js"></script>
	
<script type="text/javascript" >
Calendar._DN = new Array ("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");Calendar._SDN = new Array ("Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"); Calendar._FD = 0;	Calendar._MN = new Array ("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");	Calendar._SMN = new Array ("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");Calendar._TT = {};Calendar._TT["INFO"] = "About the Calendar";
 		Calendar._TT["ABOUT"] =
 "DHTML Date/Time Selector\n" +
 "(c) dynarch.com 2002-2005 / Author: Mihai Bazon\n" +
"For latest version visit: http://www.dynarch.com/projects/calendar/\n" +
"Distributed under GNU LGPL.  See http://gnu.org/licenses/lgpl.html for details." +
"\n\n" +
"Date selection:\n" +
"- Use the \xab, \xbb buttons to select year\n" +
"- Use the " + String.fromCharCode(0x2039) + ", " + String.fromCharCode(0x203a) + " buttons to select month\n" +
"- Hold mouse button on any of the above buttons for faster selection.";
Calendar._TT["ABOUT_TIME"] = "\n\n" +
"Time selection:\n" +
"- Click on any of the time parts to increase it\n" +
"- or Shift-click to decrease it\n" +
"- or click and drag for faster selection.";

		Calendar._TT["PREV_YEAR"] = "Click to move to the previous year. Click and hold for a list of years.";Calendar._TT["PREV_MONTH"] = "Click to move to the previous month. Click and hold for a list of the months.";	Calendar._TT["GO_TODAY"] = "Go to today";Calendar._TT["NEXT_MONTH"] = "Click to move to the next month. Click and hold for a list of the months.";Calendar._TT["NEXT_YEAR"] = "Click to move to the next year. Click and hold for a list of years.";Calendar._TT["SEL_DATE"] = "Select a date.";Calendar._TT["DRAG_TO_MOVE"] = "Drag to move";Calendar._TT["PART_TODAY"] = " (Today)";Calendar._TT["DAY_FIRST"] = "Display %s first";Calendar._TT["WEEKEND"] = "0,6";Calendar._TT["CLOSE"] = "Close";Calendar._TT["TODAY"] = "Today";Calendar._TT["TIME_PART"] = "(Shift-)Click or Drag to change the value.";Calendar._TT["DEF_DATE_FORMAT"] = "%Y-%M-%D"; Calendar._TT["TT_DATE_FORMAT"] = "%A, %B %e";Calendar._TT["WK"] = "wk";Calendar._TT["TIME"] = "Time:";
</script>
	
<?php	
}

/*****************************************************************************
 *
*****************************************************************************/
function printStylesheetIncludes() {
?>
	<link rel="stylesheet" type="text/css" href="./components/com_timewriter/images/timewriter.css" />
<?php	
}

/*****************************************************************************
 *
*****************************************************************************/
function printSubmitAndCancelButtons($runTarget, $cancelTarget, $runButtonText='Run Report', $cancelButtonText='Cancel') {
?>
	<table width="100%">
	<tr>
	<td width="98%">&nbsp;</td>
	<td>
	 <input type="submit" class="button" name="submitRun" value="<?php echo $runButtonText; ?>" onclick="document.adminForm.task.value='<?php echo $runTarget; ?>'; if(validate()) document.adminForm.submit(); return false;">
	</td>
	<td>
	 <input type="button" class="button" name="submitCancel" value="<?php echo $cancelButtonText; ?>" onclick="window.location.href='./index.php?option=com_timewriter&task=<?php echo $cancelTarget; ?>'"> 
	</td>
	</tr>
	</table>
<?php	
}

/*****************************************************************************
 *
*****************************************************************************/
function fmtDate($fordate, $fmtString="j-M-Y") {

	$bits = explode("-", $fordate);
	$year = $bits[0];
	$month = $bits[1];
	$day = $bits[2];
	$timestamp = mktime (0, 0, 0, $month, $day, $year);
	return date($fmtString, $timestamp);  
}

/*****************************************************************************
 *
*****************************************************************************/
function mainDisplay($option, $fordate, &$tablerows, $billableDateHours, $nonbillableDateHours, $dateMileage){
/*
$query="select month($currentdate) as month,
year($currentdate) as year, 
year($currentdate + interval 1 month) as next_year, 
year($currentdate - interval 1 month) as last_year,
lpad(month($currentdate),2,'0') as monthnum,
concat(lpad(year($currentdate + interval 1 month),4,'0'),'-',lpad(month($currentdate + interval 1 month),2,'0'),'-01') as next_month_date,
concat(lpad(year($currentdate - interval 1 month),4,'0'),'-',lpad(month($currentdate - interval 1 month),2,'0'),'-01') as last_month_date,
concat(lpad(year($currentdate),4,'0'),'-',lpad(month($currentdate),2,'0'),'-01') as this_month_date,
weekday(concat(year($currentdate),'-',lpad(month($currentdate),2,'0'),'-01'))+1 as first_day_num,
week(concat(year($currentdate),'-',lpad(month($currentdate),2,'0'),'-01')) as weeknumstart;";
*/

	$currentdate = isset($fordate)?$fordate:NULL;
	
	if($currentdate==NULL || $currentdate == ''){

		$currentdate=date("Y-m-d",mktime(0,0,0,date('m'),date('d'),date('Y'))); 

	}
	//echo "debug". $currentdate;
	$bits = explode("-", $currentdate);
	$yr = $bits[0];
	$mnth = $bits[1];
	
	$mnth = HTML_timesheet_content::switchMonth($mnth);

	$months = array('Unknown', 
				'January', 
				'February', 
				'March', 
				'April', 
				'May', 
				'June', 
				'July', 
				'August', 
				'September', 
				'October', 
				'November', 
				'December');
	$month = $months[$mnth];

	$daycount = date('t', mktime(0, 0, 1, $mnth, 1, (int)$yr));
	
	// September, April, June, November
	if($mnth == 4 || $mnth == 6 || $mnth == 9 || $mnth == 11){
		$daycount = 30;
	// February
	}else if($mnth == 2){
		$daycount = 28;
		if(intval($yr)%4 == 0) {
			$daycount = 29;
		}
	}
	if($mnth == 12){
		$linknextmnth = 1;
		$linknextyr = $yr + 1;
	}
	else{
		$linknextmnth = $mnth + 1;
		$linknextyr = $yr;
	}

	$linknext = date("Y-m-d",mktime (0, 0, 0, $linknextmnth, 1, (int)$linknextyr));

	if($mnth == 1){
		$linklastmnth = 12;
		$linklastyr = $yr - 1;
	}
	else{
		$linklastmnth = $mnth - 1;
		$linklastyr = $yr;
	}
	$linklast = date("Y-m-d",mktime (0, 0, 0, $linklastmnth, 1, (int)$linklastyr));	
	
	HTML_timesheet_content::printStylesheetIncludes();
	?>
	<div class="content">
	<form action="index.php" method="POST" name="timeSheetForm" id="timeSheetForm">
	
	<?php HTML_timesheet_content::headerWithLinkToReportsMenu("Timesheet Calendar", $tablerows->this_month_date); ?>
	<center>
	<div class="calendar-content">
	<div class="calendar-background">
	<table id="calendar" align="center" width="100%" border="0" cellpadding="0" cellspacing="1" >
	<tr>
		<th class="sectiontableheader" ><a href="./index.php?option=com_timewriter&fordate=<?php echo $linklast;?>" style="font-size:14pt;"  title="Previous Month">&nbsp;&laquo;&nbsp;</a></th>
		<th class="sectiontableheader" align="center" colspan="7"><a href="./index.php?option=com_timewriter&fordate=<?php echo $currentdate;?>" style="font-size:12pt;" title="Basic Timesheet for Current Month" ><?php echo $months[$mnth] . ' ' .$yr?></a></th>
		<th class="sectiontableheader" align="right"><a href="./index.php?option=com_timewriter&fordate=<?php echo $linknext;?>" style="font-size:14pt;"   title="Next Month">&nbsp;&raquo;&nbsp;</a></th>
	</tr>
	<tr valign="middle">
		<th class="sectiontableheader" >&nbsp;</th>
		<th class="sectiontableheader" width="10%">Sun</th>
		<th class="sectiontableheader" width="10%">Mon</th>
		<th class="sectiontableheader" width="10%">Tue</th>
		<th class="sectiontableheader" width="10%">Wed</th>
		<th class="sectiontableheader" width="10%">Thu</th>
		<th class="sectiontableheader" width="10%">Fri</th>
		<th class="sectiontableheader" width="10%">Sat</th>
		<th class="sectiontableheader" >&nbsp;</th>
	</tr>

	<?php
	$dcnt=0;
	$daycnt=1;

	$rws=5;

	$billablemonthtotal = 0;
	$nonbillablemonthtotal = 0;
	
	if($tablerows->first_day_num==7){
		$tablerows->first_day_num=0;
		// $tablerows->weeknumstart;
	}
	if(($daycount+$tablerows->first_day_num+1)>36) {
	 $rws=6;
	}
	$cnt=0;
	for($cnt;$cnt<$rws;$cnt++){
		$weekn = $tablerows->weeknumstart+$cnt;
		if($weekn > 52) {
			$weekn = $weekn - 52;
		}
		// Start at zero each week
		$billableweektotal = 0;
		$nonbillableweektotal = 0;
		?>
		<tr>
			<td class="sectiontableheader" align="center" width="5%" height="40"><?php echo ($weekn);?></td>
			<?php echo HTML_timesheet_content::getCell($cnt, 1, $daycnt, $dcnt,$mnth,$yr, $tablerows, $daycount, $billableweektotal, $nonbillableweektotal, $billableDateHours, $nonbillableDateHours, $dateMileage);?>
			<?php echo HTML_timesheet_content::getCell($cnt, 2, $daycnt, $dcnt,$mnth,$yr, $tablerows, $daycount, $billableweektotal, $nonbillableweektotal, $billableDateHours, $nonbillableDateHours, $dateMileage);?>
			<?php echo HTML_timesheet_content::getCell($cnt, 3, $daycnt, $dcnt,$mnth,$yr, $tablerows, $daycount, $billableweektotal, $nonbillableweektotal, $billableDateHours, $nonbillableDateHours, $dateMileage);?>
			<?php echo HTML_timesheet_content::getCell($cnt, 4, $daycnt, $dcnt,$mnth,$yr, $tablerows, $daycount, $billableweektotal, $nonbillableweektotal, $billableDateHours, $nonbillableDateHours, $dateMileage);?>
			<?php echo HTML_timesheet_content::getCell($cnt, 5, $daycnt, $dcnt,$mnth,$yr, $tablerows, $daycount, $billableweektotal, $nonbillableweektotal, $billableDateHours, $nonbillableDateHours, $dateMileage);?>
			<?php echo HTML_timesheet_content::getCell($cnt, 6, $daycnt, $dcnt,$mnth,$yr, $tablerows, $daycount, $billableweektotal, $nonbillableweektotal, $billableDateHours, $nonbillableDateHours, $dateMileage);?>
			<?php echo HTML_timesheet_content::getCell($cnt, 7, $daycnt, $dcnt,$mnth,$yr, $tablerows, $daycount, $billableweektotal, $nonbillableweektotal, $billableDateHours, $nonbillableDateHours, $dateMileage);?>
			<td class="sectiontableheader" align="right" valign="bottom" width="5%" height="40">
				<table border='0' cellspacing='0' cellpadding='0' width='100%' height='100%'>
				<tr><td style="text-align:right;" class='calendar-billable-subtotal' ><?php printf("%01.2f", $billableweektotal); ?></td></tr>
				<tr><td style="text-align:right;" class='calendar-nonbillable-subtotal' ><u><?php printf("%01.2f", $nonbillableweektotal); ?></u></td></tr>
				<tr><td style="text-align:right;" class='calendar-subtotal' ><?php printf("%01.2f", ($billableweektotal + $nonbillableweektotal)); ?></td></tr></table>
			</td>
		</tr>

		<?php
		$billablemonthtotal += $billableweektotal;
		$nonbillablemonthtotal += $nonbillableweektotal;
	}?>
	</table>
	</div>
		<table width="100%" border="0" cellpadding="0" cellspacing="1" >
		<tr >
			<td width="50%">&nbsp;</td>
			<td width="40%" >Total Billable Hours:</td>
			<td width="10%" style="text-align:right;"  class='calendar-billable-total' ><?php printf("%01.2f", $billablemonthtotal); ?></td>
		</tr>
		<tr >
			<td >&nbsp;</td>
			<td >Total Non-Billable Hours:</td>
			<td style="text-align:right;"  class='calendar-nonbillable-total' ><?php printf("%01.2f", $nonbillablemonthtotal); ?></td>
		</tr>
		</table>
	</div>
	</center>

<?php echo HTML_timesheet::copyrightFooter(); ?>
	<input type="hidden" name="task" value="">
	<input type="hidden" name="current_date" value="">
	<input type="hidden" name="end_date" value="">
	<input type="hidden" name="fordate" value="">
	<input type="hidden" name="option" value="com_timewriter">
	</form>
	</div>
<?php
}
/*****************************************************************************
 *
 ****************************************************************************/
function switchMonth($mnth)
{
switch ($mnth)
	{
		case 01:
		case 1:
			$mnth = 1;
			break;
		case 02:
		case 2:
			$mnth = 2;
			break;
		case 03:
		case 3:
			$mnth = 3;
			break;
		case 04:
		case 4:
			$mnth = 4;
			break;
		case 05:
		case 5:
			$mnth = 5;
			break;
		case 06:
		case 6:
			$mnth = 6;
			break;
		case 07:
		case 7:
			$mnth = 7;
			break;
		case 08:
		case 8:
			$mnth = 8;
			break;
		case 09:
		case 9:
			$mnth = 9;
			break;
	}
	return $mnth;
}
/*****************************************************************************
 *
*****************************************************************************/
function getCell(&$cnt, $num, &$daycnt, &$dcnt,$mnth,$yr, &$tablerows, $daycount, &$billableweektotal, &$nonbillableweektotal, $billableDateHours, $nonbillableDateHours, $dateMileage){

	$dayString = date("l",mktime(0,0,0,$mnth,1,$yr));
	$bbdd = 1;
	switch ($dayString)
	{
		case "Monday":
			$bbdd=1;
			break;
		case "Tuesday":
			$bbdd=2;
			break;
		case "Wednesday":
			$bbdd=3;
			break;
		case "Thursday":
			$bbdd=4;
			break;
		case "Friday":
			$bbdd=5;
			break;
		case "Saturday":
			$bbdd=6;
			break;
		case "Sunday":
			$bbdd=0;
			break;
		}
//echo "debug:daycnt".$daycnt."daycount:".$daycount."dcnt".$dcnt."bbdd:".$bbdd;
	if($daycnt<=$daycount && ($dcnt++)>=$bbdd) {
		$day = $daycnt;
		if(strlen($day) == 1) {
			$day = "0$day";
		}

		if($mnth < 10 )
			$month = "0".$mnth;
		else
			$month = $mnth; //monthnum
	
		$year = $yr;

		$billable = "&nbsp;";
		$nonbillable = "&nbsp;"; 
		$mileage = $dateMileage[$year."-".$month."-".$day];

		if ($billableDateHours[$year."-".$month."-".$day] 
				|| $nonbillableDateHours[$year."-".$month."-".$day]) {
		  // Has entries
		  $hrefstring = "<a style='text-decoration:none' href='./index.php?option=com_timewriter&task=showTimesheet&fordate=$year-$month-$day' ><span style='font-size:14pt;font-weight:bold;'>".($daycnt++)."</span></a>";
		  $billable = $billableDateHours[$year."-".$month."-".$day];
		  $nonbillable = $nonbillableDateHours[$year."-".$month."-".$day];
		  $billableweektotal += $billable;
		  $nonbillableweektotal += $nonbillable;
		  if ($billable == 0) {
			$billable = "&nbsp;";
		  } else {
			$billable = sprintf("%01.2f", $billable);
		  }
		  if ($nonbillable == 0) {
			$nonbillable = "&nbsp;";
		  } else {
			$nonbillable = sprintf("%01.2f", $nonbillable);
		  }
		}else{
			 $hrefstring = "<a style='text-decoration:none' href='./index.php?option=com_timewriter&task=showTimesheet&fordate=$year-$month-$day' ><span style='font-size:14pt;font-weight:bold;'>".($daycnt++)."</span></a>";
		 
			// No entries
			//$hrefstring = "<a style='text-decoration:none;' href='./index.php?option=com_timewriter&task=newProjectTimesheets&redirecttask=showTimesheet&fordate=$year-$month-$day' ><span style='font-size:14pt;font-weight:bold;'>".($daycnt++)."</span></a>";
		}
	
		if ($mileage == 0) {
			$mileage = "<img src='./components/com_timewriter/images/small-car.png' border=0 width=15 height=8>";
			$hrefmileage = "<a class='smallcar' style='text-decoration:none;' title='Mileage on $year-$month-$day' href='./index.php?option=com_timewriter&task=newMileage&redirecttask=&fordate=$year-$month-$day'>$mileage</a>";
		} else {
			$hrefmileage = "<a style='text-decoration:none;font-weight:normal;font-size:x-small;' title='Mileage on $year-$month-$day' href='./index.php?option=com_timewriter&task=showMileage&redirecttask=showMileage&fordate=$year-$month-$day'>$mileage</a>";
		}
		
		$cellstring = "<table border='0' cellspacing='0' cellpadding='0' width='100%' height='100%'>"
			."<tr><td >".$hrefstring."</td><td style='text-align:right;' valign='top' >".$hrefmileage."</td></tr>"
			."<tr><td style='text-align:right;' colspan='2' class='calendar-billable' >".$billable."</td></tr>"
			."<tr><td style='text-align:right;' colspan='2' class='calendar-nonbillable' >".$nonbillable."</td></tr></table>";

		//   Possible TD Id's include "today", "weekend" & "todayweekend"
		$cellstyle = "";
		$includeCellStyle = 0;
		if (date("Y-m-d") == $year."-".$month."-".$day) {
			// Today indicator
		  $cellstyle .= "today";
		  $includeCellStyle++;
		}
		if ($num == 1 || $num == 7) {
			// Saturday & Sunday
		  $cellstyle .= "weekend";
		  $includeCellStyle++;
		}
		if ($includeCellStyle) {
			$cellstyle = "id='".$cellstyle."'";
		}
		$cellstringall = "<td $cellstyle class='sectiontableentry1' width='10%' height='40px'>".$cellstring."</td>";
	}else{
		$cellstringall = "<td class='sectiontableentry2' width='10%' >&nbsp;</td>";
	}
	return $cellstringall;
}

/*****************************************************************************
 *
*****************************************************************************/
function showTimesheetForDate($option, &$rows, $fordate, $next, $prev, $title){
	global $database;
	
	mosCommonHTML::loadOverlib();
	HTML_timesheet_content::printStylesheetIncludes();
	$currentdate = isset($_POST['current_date'])?$_POST['current_date']:NULL;
	
?>
	<div class="content">
	<form action="index.php" method="POST" name="adminForm" id="timeSheetForm">	
	<?php HTML_timesheet_content::headerWithLinkToCalendar("Timesheet Entries", $fordate); ?>
		
    <table width="100%" border="0" cellspacing="0" >
    <tr>
     <th class="sectiontableheader" ><a style="text-decoration:none;font-size:20px;" title="Previous Day" href="./index.php?option=com_timewriter&task=showTimesheet&fordate=<?php echo $prev;?>">&nbsp;&laquo;&nbsp;</a></th>
     <th class="sectiontableheader" align="center" ><?php echo $title; ?></th>
     <th class="sectiontableheader" align="right" ><a style="text-decoration:none;font-size:20px;" title="Next Day" href="./index.php?option=com_timewriter&task=showTimesheet&fordate=<?php echo $next;?>">&nbsp;&raquo;&nbsp;</a></th>
    </tr>
    </table>
    <table width="100%" border="0" cellspacing="1" >
    <tr>
     <th class="sectiontableheader" width="10" height="20" style="text-align:left;"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($rows); ?>);" /></th>
     <th class="sectiontableheader" align="center" width="12%">Date</th>
     <th class="sectiontableheader" align="center" width="18%">Company</th>
     <th class="sectiontableheader" align="center" width="35%"Project</th>
     <th class="sectiontableheader" align="center" width="12%">Billable</th>
	 <th class="sectiontableheader" align="center" width="15%">At Customer</th>
     <th class="sectiontableheader" align="center" width="8%">Hours</th>
    </tr>

  <?php
    $totalBillable = 0;
    $totalNonbillable = 0;
    $k = 0;
    for($i=0; $i < count( $rows ); $i++) {
    $row = $rows[$i];
   ?>

    <tr>
     <td class="sectiontableentry2" width="10" height="20" style="text-align:left;"><input type="checkbox" id="cb<?php echo $i;?>" name="id[]" value="<?php echo $row->id; ?>" onclick="isChecked(this.checked);" /></td>
     <td class="sectiontableentry2" nowrap align="center"><a style="text-decoration:none" href="./index.php?option=com_timewriter&fordate=<?php echo $fordate;?>&task=editProjectTimesheets&redirecttask=showTimesheet&uid=<?php echo $row->id?>"><?php echo HTML_timesheet_content::fmtDate($row->date); ?></a></td>
     <td class="sectiontableentry2" nowrap style="text-align:left;" ><?php if($row->company_name==NULL) echo("-No Company-"); else echo htmlspecialchars($row->company_name, ENT_QUOTES); ?></td>
     <td class="sectiontableentry2" nowrap style="text-align:left;"><?php if($row->project_name==NULL) echo("-No Project-"); else echo htmlspecialchars($row->project_name, ENT_QUOTES); ?></td>
     <td class="sectiontableentry2" style="text-align:center;"><?php echo ($row->is_billable?"Yes":"No"); ?></td>
	 <td class="sectiontableentry2" style="text-align:center;"><?php echo ($row->at_customer?"Yes":"No"); ?></td>
     <td class="sectiontableentry2" style="text-align:center;"><?php printf("%01.2f", $row->total_hours); ?></td>
     <?php 
      if ($row->is_billable) {
		$totalBillable += $row->total_hours;	 
	  } else {
 		$totalNonbillable += $row->total_hours;	
	  }
      $k = 1 - $k; 
	 ?>
    </tr>
    <tr>
     <td >&nbsp;</td>
	 <td style="text-align:right;vertical-align:top">Descripion:</td>
     <td colspan="2"><?php echo htmlspecialchars($row->description, ENT_QUOTES); ?></td>
     <td colspan="2">&nbsp;</td>
    </tr>
  <?php } ?>
    <tr>
     <td colspan="3">&nbsp;</td>
     <td style="text-align:right;"colspan="2">Total Billable Hours:</td>
     <td style="text-align:center;"><?php printf("%01.2f", $totalBillable); ?></td>
    </tr>
	<?php if($totalNonbillable != 0){?>
    <tr>
     <td colspan="3">&nbsp;</td>
     <td style="text-align:right;" colspan="2">Total Non-Billable Hours:</td>
     <td style="text-align:center;"><?php printf("%01.2f", $totalNonbillable); ?></td>
    </tr>
	<?php } ?>
  	</table>
  	<br />
  	<center>
  	<table border="0">
  	  <tr>
		<td width="50" >
			<a title="New Timesheet Entry" style="text-decoration:none" href=" ./index.php?option=com_timewriter&task=editProjectTimesheets&redirecttask=showTimesheet&fordate=<?php echo $fordate;?>">New</a>
		</td>
		<td width="50" >
			<a title="Delete Timesheet Entry" style="text-decoration:none" href="#" onClick="document.adminForm.option.value='com_timewriter';document.adminForm.task.value='deleteProjectTimesheets';document.adminForm.fordate.value='<?php echo $fordate;?>';if (document.adminForm.boxchecked.value == 0){ alert('Please make a selection from the list to delete'); } else if (confirm('Are you sure you want to delete selected items?')) document.adminForm.submit(); return false;">Delete</a>
		</td>
	  </tr>
    </table>
    </center>

<?php HTML_timesheet::copyrightFooter(); ?>
    
    <input type="hidden" name="boxchecked" value="0" />
    <input type="hidden" name="fordate" value="<?php echo $fordate;?>" />
    <input type="hidden" name="option" value="com_timewriter" />
    <input type="hidden" name="task" value="showTimesheet" />
    <input type="hidden" name="redirecttask" value="showTimesheet" />
    <input type="hidden" name="current_date" value=""/>
    </form>
	</div>

<?php
}


/*****************************************************************************
 *
*****************************************************************************/
function showVehicles($option, $fordate, $userid, &$rows){
	global $database;
	
	HTML_timesheet_content::printStylesheetIncludes();
?>
<form action="index.php" method="POST" name="adminForm" id="timeSheetForm">	

	<div class="content">

	<?php HTML_timesheet_content::headerWithLinkToReportsMenu("My Vehicles", $fordate); ?>
		
    <table width="100%" border="0" cellspacing="1" >
    <tr>
     <th class="sectiontableheader" width="10" height="20" align="left"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($rows); ?>);" /></th>
     <th class="sectiontableheader" align="center" width="20%">Name</th>
     <th class="sectiontableheader" align="center" width="50%">Description</th>
     <th class="sectiontableheader" align="center" width="10%">Units</th>
     <th class="sectiontableheader" align="center" width="10%">Published</th>
    </tr>
  <?php
    for($i=0; $i < count( $rows ); $i++) {
    $row = $rows[$i];
   ?>
    <tr>
     <td class="sectiontableentry2" style="text-align:left;"><input type="checkbox" id="cb<?php echo $i;?>" name="id[]" value="<?php echo $row->id; ?>" onclick="isChecked(this.checked);" /></td>
     <td class="sectiontableentry2" ><a style="text-decoration:none" href="./index.php?option=com_timewriter&fordate=<?php echo $fordate;?>&task=editVehicle&uid=<?php echo $row->id?>"><?php echo htmlspecialchars($row->vehicle_name, ENT_QUOTES); ?></a></td>
     <td class="sectiontableentry2" ><?php echo htmlspecialchars($row->description, ENT_QUOTES); ?></td>
     <td class="sectiontableentry2" style="text-align:center;"><?php echo htmlspecialchars($row->units, ENT_QUOTES); ?></td>
     <td class="sectiontableentry2" style="text-align:center;"><?php echo ($row->published?"Yes":"No"); ?></td>
    </tr>
  <?php } ?>
    <tr>
  	</table>
  	<br />
  	<center>
  	<table border="0">
  	  <tr>
		<td width="50" >
			<a href="./index.php?option=com_timewriter&task=editVehicle&uid=-1&fordate=<?php echo $fordate; ?>" style="text-decoration:none" title="Add new Vehicle">New</a>
		</td>
		<td width="50" >
			<a title="Delete Vehicle" style="text-decoration:none" href="#" onClick="document.adminForm.task.value='deleteVehicle';if (document.adminForm.boxchecked.value == 0){ alert('Please make a selection from the list to delete'); } else if (confirm('Are you sure you want to delete selected items?')) document.adminForm.submit(); return false;">Delete</a>
		</td>
	  </tr>
    </table>
    </center>

<?php HTML_timesheet::copyrightFooter(); ?>
    
    <input type="hidden" name="boxchecked" value="0" />
    <input type="hidden" name="fordate" value="<?php echo $fordate; ?>" />
    <input type="hidden" name="option" value="com_timewriter" />
    <input type="hidden" name="task" value="" />

</div>
</form>

<?php
}


/*****************************************************************************
 *
*****************************************************************************/
function showMileage($option, $fordate, $next, $prev, $userid, &$rows, $title){
	global $database;

	HTML_timesheet_content::printStylesheetIncludes();
?>
<form action="index.php" method="POST" name="adminForm" id="timeSheetForm">	

	<div class="content">

	<?php HTML_timesheet_content::headerWithLinkToCalendar("Mileage Entries", $fordate); ?>
		
    <table width="100%" border="0" cellspacing="0" >
    <tr>
     <th class="sectiontableheader" ><a style="text-decoration:none;font-size:20px;" title="Previous Day" href="./index.php?option=com_timewriter&task=showMileage&fordate=<?php echo $prev;?>">&nbsp;&laquo;&nbsp;</a></th>
     <th class="sectiontableheader" align="center" ><?php echo $title; ?></th>
     <th class="sectiontableheader" align="right" ><a style="text-decoration:none;font-size:20px;" title="Next Day" href="./index.php?option=com_timewriter&task=showMileage&fordate=<?php echo $next;?>">&nbsp;&raquo;&nbsp;</a></th>
    </tr>
    </table>		
    <table width="100%" border="0" cellspacing="1" >
    <tr>
     <th class="sectiontableheader" width="10" height="20"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($rows); ?>);" /></th>
     <th class="sectiontableheader" align="center" width="10%">Date</th>
     <th class="sectiontableheader" align="center" width="10%">Vehicle</th>
     <th class="sectiontableheader" align="center" width="40%">Location</th>
     <th class="sectiontableheader" align="center" width="10%">Parking</th>
     <th class="sectiontableheader" align="center" width="20%">Company</th>
     <th class="sectiontableheader" align="center" width="10%">Billable</th>
    </tr>
    <tr>
     <th class="sectiontableheader" colspan="3">&nbsp;</th>
     <th class="sectiontableheader" align="center">Odometer</th>
     <th class="sectiontableheader" colspan="3">&nbsp;</th>
    </tr>
  <?php
	$start = -1;
	$end = -1;
	$warning = 0;
    for($i=0; $i < count( $rows ); $i++) {
		$row = $rows[$i];	
		if ($start > -1) {
			if ($start <= $row->start_odometer && $row->start_odometer < $end) {
				$warning = 1;
			}
		}
   ?>
    <tr>
     <td class="sectiontableentry2"><input type="checkbox" id="cb<?php echo $i;?>" name="id[]" value="<?php echo $row->id; ?>" onclick="isChecked(this.checked);" /></td>
     <td class="sectiontableentry2" nowrap align="center"><a style="text-decoration:none" href="./index.php?option=com_timewriter&fordate=<?php echo $row->date;?>&task=editMileage&redirecttask=showMileage&uid=<?php echo $row->id;?>"><?php echo HTML_timesheet_content::fmtDate($row->date);?></a></td>
     <td class="sectiontableentry2" nowrap align="center"><?php echo htmlspecialchars($row->vehicle_name, ENT_QUOTES); ?></td>
     <td class="sectiontableentry2" nowrap align="center"><?php echo htmlspecialchars($row->start_location, ENT_QUOTES); ?><b>&nbsp;&raquo;&nbsp;</b><?php echo htmlspecialchars($row->end_location, ENT_QUOTES); ?></td>
     <td class="sectiontableentry2" nowrap align="center"><?php printf("%01.2f", $row->parking); ?></td>
     <td class="sectiontableentry2" nowrap align="center"><?php echo ($row->company_id?htmlspecialchars($row->company_name, ENT_QUOTES):"-"); ?></td>
     <td class="sectiontableentry2" align="center"><?php echo ($row->is_billable?"Yes":"No"); ?></td>
    </tr>
    <tr>
     <th class="sectiontableentry1" colspan="3">&nbsp;</th>
     <td class="sectiontableentry1" nowrap align="center" <?php echo ($warning?"id='warning'":"")?> ><?php echo htmlspecialchars($row->start_odometer, ENT_QUOTES); ?><b>&nbsp;&raquo;&nbsp;</b><?php echo htmlspecialchars($row->end_odometer, ENT_QUOTES); ?></td>
     <th class="sectiontableentry1" colspan="3">&nbsp;</th>
    </tr>
  <?php 
		$start = $row->start_odometer;
		$end = $row->end_odometer;
		$warning = 0;
	}     ?>
    <tr>
  	</table>
  	<br />
  	<center>
  	<table border="0">
  	  <tr>
		<td width="50" >
			<a href="./index.php?option=com_timewriter&task=editMileage&redirecttask=showMileage&uid=-1&fordate=<?php echo $fordate; ?>" style="text-decoration:none" title="Add Mileage">New</a>
		</td>
		<td width="50" >
			<a title="Delete Mileage" style="text-decoration:none" href="#" onClick="document.adminForm.task.value='deleteMileage';if (document.adminForm.boxchecked.value == 0){ alert('Please make a selection from the list to delete'); } else if (confirm('Are you sure you want to delete selected items?')) document.adminForm.submit(); return false;">Delete</a>
		</td>
	  </tr>
    </table>
    </center>

<?php HTML_timesheet::copyrightFooter(); ?>
    
    <input type="hidden" name="boxchecked" value="0" />
    <input type="hidden" name="fordate" value="<?php echo $fordate; ?>" />
    <input type="hidden" name="option" value="com_timewriter" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="redirecttask" value="showMileage" />

</div>
</form>

<?php
}

/*****************************************************************************
 *
*****************************************************************************/
function showSimpleTimesheetReport($option, &$rows, $fordate, $monthname, $username, $pop='0'){
	global $database, $mosConfig_live_site;	
	HTML_timesheet_content::includeDontPrintStyle(); 
	HTML_timesheet_content::printStylesheetIncludes();
?>

	<div class="content">
    <table border="0" width="100%">
    	<tr>
			<td class="componentheading" ><?php echo ("$monthname");?> Timesheet Report for <?php echo("$username");?></td>
<?php  if ($pop == 0) {  ?>
		    <td  class="buttonheading" align="right"><a href="#" onclick="window.open('<?php echo $mosConfig_live_site; ?>/index2.php?option=com_timewriter&amp;task=showSimpleTimesheetReport&amp;fordate=<?php echo($fordate); ?>&amp;pop=1', 'win2', 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=yes,resizable=yes,width=640,height=480,directories=no,location=no'); return false;" title="<?php echo _CMN_PRINT;?>"><img
		    			src="<?php echo $mosConfig_live_site;?>/images/M_images/printButton.png" border="0" alt="<?php echo _CMN_PRINT;?>" /></a>&nbsp;</td>				
<?php } else { ?>
		    <td  class="buttonheading" align="right"><div class="dontprint"><a href="#" onclick="window.print(); return false;" title="<?php echo _CMN_PRINT;?>"><img
		    			src="<?php echo $mosConfig_live_site;?>/images/M_images/printButton.png" border="0" alt="<?php echo _CMN_PRINT;?>" /></a></div>&nbsp;</td>				
<?php } ?>
		</tr>
    </table>
    <br>
    <table width="100%" border="0" cellspacing="1" >
    <tr>
     <th class="sectiontableheader" align="center" width="12%">Date</th>
     <th class="sectiontableheader" align="center" width="18%">Company</th>
     <th class="sectiontableheader" align="center" width="37%"Project</th>
     <th class="sectiontableheader" align="center" width="10%">Billable</th>
	 <th class="sectiontableheader" align="center" width="13%">At Customer</th>
     <th class="sectiontableheader" align="center" width="10%">Hours</th>
    </tr>
  <?php
    $totalBillable = 0;
    $totalNonbillable = 0;
    $k = 0;
    for($i=0; $i < count( $rows ); $i++) {
    $row = $rows[$i];
   ?>

    <tr>
<?php  if ($pop == 0) {  ?>
     <td class="sectiontableentry2" nowrap align="center"><a style="text-decoration:none" href="./index.php?option=com_timewriter&fordate=<?php echo $row->date;?>&task=editProjectTimesheets&redirecttask=showSimpleTimesheetReport&uid=<?php echo $row->id?>"><?php echo $row->date; ?></a></td>
<?php } else { ?>
     <td class="sectiontableentry2" nowrap align="center"><?php echo $row->date; ?></td>
<?php } ?>
     <td class="sectiontableentry2" nowrap><?php if($row->company_name==NULL) echo("-No Company-"); else echo htmlspecialchars($row->company_name, ENT_QUOTES); ?></td>
     <td class="sectiontableentry2" nowrap><?php if($row->project_name==NULL) echo("-No Project-"); else echo htmlspecialchars($row->project_name, ENT_QUOTES); ?></td>
     <td class="sectiontableentry2" align="center"><?php echo ($row->is_billable?"Yes":"No"); ?></td>
	 <td class="sectiontableentry2" align="center"><?php echo ($row->at_customer?"Yes":"No"); ?></td>
     <td class="sectiontableentry2" align="center"><?php printf("%01.2f", $row->total_hours); ?></td>
     <?php 
      if ($row->is_billable) {
		$totalBillable += $row->total_hours;	 
	  } else {
 		$totalNonbillable += $row->total_hours;	
	  }
      $k = 1 - $k; 
	 ?>
    </tr>
    <tr>
     <td class="sectiontableentry1" colspan="2">&nbsp;</td>
     <td class="sectiontableentry1" ><u>Description:</u> <?php echo htmlspecialchars($row->description, ENT_QUOTES); ?></td>
     <td class="sectiontableentry1" colspan="2">&nbsp;</td>
    </tr>
  <?php } ?>
    <tr>
     <td class="sectiontableentry2" colspan="2">&nbsp;</td>
     <td class="sectiontableentry2" style="text-align:right;" colspan="2">Total Billable Hours:</td>
     <td class="sectiontableentry2" align="center"><?php printf("%01.2f", $totalBillable); ?></td>
    </tr>
	<?php if( $totalNonbillable != 0){ ?>
    <tr>
     <td class="sectiontableentry2" colspan="2">&nbsp;</td>
     <td style="text-align:right;" class="sectiontableentry2" colspan="2">Total Non-Billable Hours:</td>
     <td class="sectiontableentry2" align="center"><?php printf("%01.2f", $totalNonbillable); ?></td>
    </tr>
	<?php } ?>
  	</table>
  	<br>

</div>

<?php
}

/*****************************************************************************
 *
*****************************************************************************/
function showTotalHoursPerProject( $option, $prows, $startdate, $enddate, $isbillable, $criteria, $pop,$subinpage=0,$hoursaday=8) {
	global $database, $mosConfig_live_site;	

	HTML_timesheet_content::includeDontPrintStyle(); 
	HTML_timesheet_content::printStylesheetIncludes();

	$title = "Total Hours by Project";
	$task = "showTotalHoursPerProject";
	$criteriaTask = "showTotalHoursPerProjectCriteria";
	
?>

	<div class="content">
    <table border="0" width="100%">
    	<tr>
			<td class="componentheading" ><?php echo $title; ?></td>
<?php  
	if ($pop == 0) {  
		$projecturl = HTML_timesheet_content::buildUrl($projectid, "project_id");
?>
		    <td  class="buttonheading" align="right"><a href="./index.php?option=com_timewriter&amp;task=<?php echo $criteriaTask; ?>&amp;current_date=<?php echo $startdate;?>&amp;end_date=<?php echo $enddate;?>&amp;is_billable=<?php echo $isbillable;?><?php echo $projecturl;?>" title="Edit report criteria">Revise</a>&nbsp;</td>
		    <td  class="buttonheading" align="right"><a href="#" onclick="window.open('<?php echo $mosConfig_live_site; ?>/index2.php?option=com_timewriter&amp;task=<?php echo $task; ?>&amp;current_date=<?php echo $startdate;?>&amp;end_date=<?php echo $enddate;?>&amp;is_billable=<?php echo("$isbillable");?><?php echo $projecturl;?>&amp;pop=1', 'win2', 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=yes,resizable=yes,width=640,height=480,directories=no,location=no'); return false;" title="<?php echo _CMN_PRINT;?>"><img
		    			src="<?php echo $mosConfig_live_site;?>/images/M_images/printButton.png" border="0" alt="<?php echo _CMN_PRINT;?>" /></a>&nbsp;</td>				
<?php } else if($subinpage==0){ ?>
		    <td  class="buttonheading" align="right"><div class="dontprint"><a href="#" onclick="window.print(); return false;" title="<?php echo _CMN_PRINT;?>"><img
		    			src="<?php echo $mosConfig_live_site;?>/images/M_images/printButton.png" border="0" alt="<?php echo _CMN_PRINT;?>" /></a></div>&nbsp;</td>				
<?php 
	} 
?>
		</tr>
    </table>
    <?php echo $criteria;?>
    <table width="100%" border="0" cellspacing="1" >	
    <tr>
	<th width="10%">&nbsp;</th>
     <th class="sectiontableheader" align="left" width="25%">Company</th>
     <th class="sectiontableheader" align="left" width="32%">Project</th>
     <th class="sectiontableheader" align="center" width="10%">Hours</th>
    </tr>
  <?php
    $totalBillable = 0;
    $totalNonbillable = 0;
    $k = 0;
    for($i=0; $i < count( $prows ); $i++) {
    $row = $prows[$i];
   ?>

    <tr>
	<td >&nbsp;</td>
     <td class="sectiontableentry2" nowrap><?php if($row->company_name==NULL) echo("-No Company-"); else echo htmlspecialchars($row->company_name, ENT_QUOTES); ?></td>
     <td class="sectiontableentry2" nowrap><?php if($row->project_name==NULL) echo("-No Project-"); else echo htmlspecialchars($row->project_name, ENT_QUOTES); ?></td>
     <td class="sectiontableentry2" align="center"><?php printf("%01.2f", $row->total_hours); ?></td>
     <?php 
      if ($row->is_billable) {
		$totalBillable += $row->total_hours;	 
	  } else {
 		$totalNonbillable += $row->total_hours;	
	  }
      $k = 1 - $k; 
	 ?>
    </tr>
  <?php } ?>
    <tr>
     <td colspan="2">&nbsp;</td>
    </tr>
	<tr>
     <td >&nbsp;</td>
     <td style="text-align:right;" colspan="2">Total Billable Hours:</td>
     <td align="center"><?php printf("%01.2f", $totalBillable); ?></td>
    </tr>
	<?php if($hoursaday > 0){ ?>
		<tr>
		 <td >&nbsp;</td>
		 <td style="text-align:right;" colspan="2">Total Billable Days:</td>
		 <td align="center"><?php printf("%01.2f", $totalBillable/8); ?></td>
		</tr>
	<?php } ?>
	<?php if($totalNonbillable != 0) { ?>
    <tr>
     <td >&nbsp;</td>
     <td style="text-align:right;" colspan="2">Total Non-Billable Hours:</td>
     <td align="center"><?php printf("%01.2f", $totalNonbillable); ?></td>
    </tr>
	<?php } ?>
  	</table>
  	<br>
</div>

<?php
}

/*****************************************************************************
 *
*****************************************************************************/
function showMileageLogForm( $option, $title, $username, $numberOfRows) {

	HTML_timesheet_content::printStylesheetIncludes();
?>
<div class="content">

<?php 
	$print = '<div class="dontprint"><a href="#" onclick="window.print(); return false;" title="' 
		. _CMN_PRINT 
		. '"><img src="./images/M_images/printButton.png" border="0" alt="'
		. _CMN_PRINT 
		. '"/></a></div>';
	
	HTML_timesheet_content::headerWithoutLink($username . " - " . $title, $print); 
	HTML_timesheet_content::includeDontPrintStyle(); 
?>

<table border="1" cellpadding="3" cellspacing="0" class="adminform"  width="100%">
 <tr>
  <th colspan="3">&nbsp;</th>
  <th colspan="2" align="center">Odometer</th>
 </tr>
 <tr>
  <th width="20%">Date</th>
  <th width="20%">Origin</th>
  <th width="20%">Destination</th>
  <th width="20%">Start</th>
  <th width="20%">Finish</th>
 </tr>
<?php for ($i = 0; $i < $numberOfRows; $i++) {	?>
	 <tr>
	  <td height="28px">&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	 </tr>
<?php 	}	?>
</table>
</div>	

<?php
}

/*****************************************************************************
 *
*****************************************************************************/
function showTotalMileageReport( $option, $rows, $startdate, $enddate, $isbillable, $companyid, $vehicleid, $userid, $criteria, $pop) {
	global $database, $mosConfig_live_site;
	HTML_timesheet_content::includeDontPrintStyle(); 
	HTML_timesheet_content::printStylesheetIncludes();
?>

	<div class="content">
    <table border="0" width="100%">
    	<tr>
			<td class="componentheading" >Total Mileage Report</td>
<?php  if ($pop == 0) {  ?>
		    <td  class="buttonheading" align="right"><a href="./index.php?option=com_timewriter&amp;task=showTotalMileageCriteria&amp;current_date=<?php echo("$startdate");?>&amp;end_date=<?php echo("$enddate");?>&amp;company_id=<?php echo("$companyid");?>&amp;vehicle_id=<?php echo("$vehicleid");?>&amp;is_billable=<?php echo("$isbillable");?>" title="Edit report criteria">Revise</a>&nbsp;</td>
		    <td  class="buttonheading" align="right"><a href="#" onclick="window.open('<?php echo $mosConfig_live_site; ?>/index2.php?option=com_timewriter&amp;task=showTotalMileageReport&amp;current_date=<?php echo("$startdate");?>&amp;end_date=<?php echo("$enddate");?>&amp;company_id=<?php echo("$companyid");?>&amp;vehicle_id=<?php echo("$vehicleid");?>&amp;is_billable=<?php echo("$isbillable");?>&amp;pop=1', 'win2', 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=yes,resizable=yes,width=640,height=480,directories=no,location=no'); return false;" title="<?php echo _CMN_PRINT;?>"><img
		    			src="<?php echo $mosConfig_live_site;?>/images/M_images/printButton.png" border="0" alt="<?php echo _CMN_PRINT;?>" /></a>&nbsp;</td>				
<?php } else { ?>
		    <td  class="buttonheading" align="right"><div class="dontprint"><a href="#" onclick="window.print(); return false;" title="<?php echo _CMN_PRINT;?>"><img
		    			src="<?php echo $mosConfig_live_site;?>/images/M_images/printButton.png" border="0" alt="<?php echo _CMN_PRINT;?>" /></a></div>&nbsp;</td>				
<?php } ?>
		</tr>
    </table>
    <?php echo $criteria; ?>
    <table width="100%" border="0" cellspacing="1" >
    <tr>
     <th class="sectiontableheader" align="center" width="10%">Date</th>
     <th class="sectiontableheader" align="center" width="10%">Vehicle</th>
     <th class="sectiontableheader" align="center" width="30%">Location</th>
     <th class="sectiontableheader" align="center" width="20%">Company</th>
     <th class="sectiontableheader" align="center" width="10%">Billable</th>
     <th class="sectiontableheader" align="center" width="10%">Parking</th>
     <th class="sectiontableheader" align="center" width="10%">Distance</th>
    </tr>
    <tr>
     <th class="sectiontableheader" colspan="2">&nbsp;</th>
     <th class="sectiontableheader" align="center">Odometer</th>
     <th class="sectiontableheader" colspan="4">&nbsp;</th>
    </tr>
  <?php
    $totalBillableMileage = 0;
    $totalNonbillableMileage = 0;
    $totalBillableParking = 0;
    $totalNonbillableParking = 0;
	$end = -1;
	$endVehicle = 0; // vehicle_id
	$warning = 0;
    for($i=0; $i < count( $rows ); $i++) {
		$row = $rows[$i];	
		if ($end > -1 && $row->start_odometer < $end && $endVehicle == $row->vehicle_id) {
			$warning = 1;
		}
		$tripDistance = $row->end_odometer - $row->start_odometer;
   ?>
    <tr>
     <td class="sectiontableentry2" nowrap align="center"><?php echo HTML_timesheet_content::fmtDate($row->date);?></td>
     <td class="sectiontableentry2" nowrap align="center"><?php echo htmlspecialchars($row->vehicle_name, ENT_QUOTES); ?></td>
     <td class="sectiontableentry2" nowrap align="center"><?php echo htmlspecialchars($row->start_location, ENT_QUOTES); ?><b>&nbsp;&raquo;&nbsp;</b><?php echo htmlspecialchars($row->end_location, ENT_QUOTES); ?></td>
     <td class="sectiontableentry2" nowrap align="center"><?php echo ($row->company_id ? htmlspecialchars($row->company_name, ENT_QUOTES) : "-"); ?></td>
     <td class="sectiontableentry2" align="center"><?php echo ($row->is_billable?"Yes":"No"); ?></td>
     <td class="sectiontableentry2" nowrap align="center"><?php printf("%01.2f", $row->parking); ?></td>
     <td class="sectiontableentry2" nowrap align="center"><?php echo ($tripDistance); ?></td>
    </tr>
    <tr>
     <th class="sectiontableentry1" colspan="2">&nbsp;</th>
     <td class="sectiontableentry1" nowrap align="center" <?php echo ($warning?"id='warning'":"")?> ><?php echo $row->start_odometer; ?><b>&nbsp;&raquo;&nbsp;</b><?php echo $row->end_odometer; ?></td>
     <th class="sectiontableentry1" colspan="4">&nbsp;</th>
    </tr>
  <?php 
		if ($row->is_billable) {
			$totalBillableMileage += $tripDistance;
			$totalBillableParking += sprintf("%01.2f", $row->parking);
		} else {
			$totalNonbillableMileage += $tripDistance;	
			$totalNonbillableParking += sprintf("%01.2f", $row->parking);
		}
		$end = $row->end_odometer;
		$warning = 0;
		$endVehicle = $row->vehicle_id;
	}     
	?>
    <tr>
     <td colspan="2">&nbsp;</td>
     <td colspan="4">Total Billable Mileage:</td>
     <td align="right"><?php echo $totalBillableMileage; ?></td>
    </tr>
    <tr>
     <td colspan="2">&nbsp;</td>
     <td colspan="4">Total Non-Billable Mileage:</td>
     <td align="right"><?php echo $totalNonbillableMileage; ?></td>
    </tr>
    <tr>
     <td colspan="2">&nbsp;</td>
     <td colspan="4">Total Billable Parking:</td>
     <td align="right"><?php printf("$%01.2f", $totalBillableParking); ?></td>
    </tr>
    <tr>
     <td colspan="2">&nbsp;</td>
     <td colspan="4">Total Non-Billable Parking:</td>
     <td align="right"><?php printf("$%01.2f", $totalNonbillableParking); ?></td>
    </tr>
  	</table>
  	<br>
</div>

<?php
}

/*****************************************************************************
 * 
*****************************************************************************/
function multiUserTotalMileageReport( $option, $rows, $startdate, $enddate, $isbillable, $companyid, $userids, $criteria, $pop) {
	global $mosConfig_live_site;
	
	HTML_timesheet_content::includeDontPrintStyle(); 
	HTML_timesheet_content::printStylesheetIncludes();
?>

	<div class="content">

    <table border="0" width="100%">
    	<tr>
			<td class="componentheading" >Multi-User Total Mileage Report</td>
<?php  if ($pop == 0) {  
		$selected_userids = HTML_timesheet_content::buildUrl($userids, "user_ids");
?>
		    <td  class="buttonheading" align="right"><a href="./index.php?option=com_timewriter&amp;task=multiUserTotalMileageCriteria&amp;current_date=<?php echo("$startdate");?>&amp;end_date=<?php echo("$enddate");?>&amp;company_id=<?php echo("$companyid");?><?php echo $selected_userids;?>&amp;is_billable=<?php echo("$isbillable");?>" title="Edit report criteria">Revise</a>&nbsp;</td>
		    <td  class="buttonheading" align="right"><a href="#" onclick="window.open('<?php echo $mosConfig_live_site; ?>/index2.php?option=com_timewriter&amp;task=multiUserTotalMileageReport&amp;current_date=<?php echo("$startdate");?>&amp;end_date=<?php echo("$enddate");?>&amp;company_id=<?php echo("$companyid");?><?php echo $selected_userids;?>&amp;is_billable=<?php echo("$isbillable");?>&amp;pop=1', 'win2', 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=yes,resizable=yes,width=640,height=480,directories=no,location=no'); return false;" title="<?php echo _CMN_PRINT;?>"><img
		    			src="<?php echo $mosConfig_live_site;?>/images/M_images/printButton.png" border="0" alt="<?php echo _CMN_PRINT;?>" /></a>&nbsp;</td>				
<?php } else { ?>
		    <td  class="buttonheading" align="right"><div class="dontprint"><a href="#" onclick="window.print(); return false;" title="<?php echo _CMN_PRINT;?>"><img
		    			src="<?php echo $mosConfig_live_site;?>/images/M_images/printButton.png" border="0" alt="<?php echo _CMN_PRINT;?>" /></a></div>&nbsp;</td>				
<?php } ?>
		</tr>
    </table>
    <?php echo $criteria; ?>
    <table width="100%" border="0" cellspacing="1" >
    <tr>
     <th class="sectiontableheader" align="center" width="10%">Date</th>
     <th class="sectiontableheader" align="center" width="10%">Vehicle</th>
     <th class="sectiontableheader" align="center" width="30%">Location</th>
     <th class="sectiontableheader" align="center" width="20%">Company</th>
     <th class="sectiontableheader" align="center" width="10%">Billable</th>
     <th class="sectiontableheader" align="center" width="10%">Parking</th>
     <th class="sectiontableheader" align="center" width="10%">Distance</th>
    </tr>
    <tr>
     <th class="sectiontableheader" colspan="2">&nbsp;</th>
     <th class="sectiontableheader" align="center">Odometer</th>
     <th class="sectiontableheader" align="center">User</th>
     <th class="sectiontableheader" colspan="3">&nbsp;</th>
    </tr>
  <?php
  
	// TODO:  The Warning indicator will only work on side-by-side rows of the same vehicle.	
    $totalBillableMileage = 0;
    $totalNonbillableMileage = 0;
    $totalBillableParking = 0;
    $totalNonbillableParking = 0;
	$end = -1;
	$endVehicle = 0; // vehicle_id
	$warning = 0;
    for($i=0; $i < count( $rows ); $i++) {
		$row = $rows[$i];	
		if ($end > -1 && $row->start_odometer < $end && $endVehicle == $row->vehicle_id) {
			$warning = 1;
		}
		$tripDistance = $row->end_odometer - $row->start_odometer;
   ?>
    <tr>
     <td class="sectiontableentry2" nowrap align="center"><?php echo HTML_timesheet_content::fmtDate($row->date);?></td>
     <td class="sectiontableentry2" nowrap align="center"><?php echo htmlspecialchars($row->vehicle_name, ENT_QUOTES); ?></td>
     <td class="sectiontableentry2" nowrap align="center"><?php echo htmlspecialchars($row->start_location, ENT_QUOTES); ?><b>&nbsp;&raquo;&nbsp;</b><?php echo htmlspecialchars($row->end_location, ENT_QUOTES); ?></td>
     <td class="sectiontableentry2" nowrap align="center"><?php echo ($row->company_id?htmlspecialchars($row->company_name, ENT_QUOTES):"-"); ?></td>
     <td class="sectiontableentry2" align="center"><?php echo ($row->is_billable?"Yes":"No"); ?></td>
     <td class="sectiontableentry2" nowrap align="center"><?php printf("%01.2f", $row->parking); ?></td>
     <td class="sectiontableentry2" nowrap align="center"><?php echo ($tripDistance); ?></td>
    </tr>
    <tr>
     <th class="sectiontableentry1" colspan="2">&nbsp;</th>
     <td class="sectiontableentry1" nowrap align="center" <?php echo ($warning?"id='warning'":"")?> ><?php echo htmlspecialchars($row->start_odometer, ENT_QUOTES); ?><b>&nbsp;&raquo;&nbsp;</b><?php echo htmlspecialchars($row->end_odometer, ENT_QUOTES); ?></td>
     <td class="sectiontableentry1" align="center" ><?php echo $row->name; ?></td>
     <th class="sectiontableentry1" colspan="4">&nbsp;</th>
    </tr>
  <?php 
		if ($row->is_billable) {
			$totalBillableMileage += $tripDistance;
			$totalBillableParking += sprintf("%01.2f", $row->parking);
		} else {
			$totalNonbillableMileage += $tripDistance;	
			$totalNonbillableParking += sprintf("%01.2f", $row->parking);
		}
		$end = $row->end_odometer;
		$endVehicle = $row->vehicle_id;
		$warning = 0;
	}    
	?>
    <tr>
     <td colspan="2">&nbsp;</td>
     <td colspan="4">Total Billable Mileage:</td>
     <td align="right"><?php echo $totalBillableMileage; ?></td>
    </tr>
    <tr>
     <td colspan="2">&nbsp;</td>
     <td colspan="4">Total Non-Billable Mileage:</td>
     <td align="right"><?php echo $totalNonbillableMileage; ?></td>
    </tr>
    <tr>
     <td colspan="2">&nbsp;</td>
     <td colspan="4">Total Billable Parking:</td>
     <td align="right"><?php printf("$%01.2f", $totalBillableParking); ?></td>
    </tr>
    <tr>
     <td colspan="2">&nbsp;</td>
     <td colspan="4">Total Non-Billable Parking:</td>
     <td align="right"><?php printf("$%01.2f", $totalNonbillableParking); ?></td>
    </tr>
  	</table>
  	<br>
</div>

<?php
}


/*****************************************************************************
 *
*****************************************************************************/
function showProjectReportByCompany( $option, $rows, $startdate, $enddate, $isbillable, $companyid, $criteria, $pop,$prows,$pcriteria,$hoursaday=8) {
	global $database, $mosConfig_live_site;
	
	HTML_timesheet_content::includeDontPrintStyle();
	HTML_timesheet_content::printStylesheetIncludes();
?>
<div class="content">

    <table border="0" width="100%">
    	<tr>
			<td class="componentheading" >Timesheet Report By Company</td>
<?php  if ($pop == 0) {  ?>
		    <td  class="buttonheading" align="right"><a href="./index.php?option=com_timewriter&amp;task=showTimesheetReportByCompanyCriteria&amp;current_date=<?php echo("$startdate");?>&amp;end_date=<?php echo("$enddate");?>&amp;company_id=<?php echo("$companyid");?>&amp;is_billable=<?php echo("$isbillable");?>" title="Edit report criteria">Revise</a>&nbsp;</td>
		    <td  class="buttonheading" align="right"><a href="#" onclick="window.open('<?php echo $mosConfig_live_site; ?>/index2.php?option=com_timewriter&amp;task=showProjectReportByCompany&amp;current_date=<?php echo("$startdate");?>&amp;end_date=<?php echo("$enddate");?>&amp;company_id=<?php echo("$companyid");?>&amp;is_billable=<?php echo("$isbillable");?>&amp;pop=1', 'win2', 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=yes,resizable=yes,width=640,height=480,directories=no,location=no'); return false;" title="<?php echo _CMN_PRINT;?>"><img
		    			src="<?php echo $mosConfig_live_site;?>/images/M_images/printButton.png" border="0" alt="<?php echo _CMN_PRINT;?>" /></a>&nbsp;</td>				
<?php } else { ?>
		    <td  class="buttonheading" align="right"><div class="dontprint"><a href="#" onclick="window.print(); return false;" title="<?php echo _CMN_PRINT;?>"><img
		    			src="<?php echo $mosConfig_live_site;?>/images/M_images/printButton.png" border="0" alt="<?php echo _CMN_PRINT;?>" /></a></div>&nbsp;</td>				
<?php } ?>
		</tr>
    </table>
	<?php echo HTML_timesheet_content::showProjectReportContent($criteria, $rows,$hoursaday); ?>
	<?php echo HTML_timesheet_content::showTotalHoursPerProject( $option, $prows, $startdate, $enddate, $isbillable, "", 1, $multiuser,1,$hoursaday); ?>
</div>

<?php
}
/*****************************************************************************
 *
*****************************************************************************/
function showFlextimeReportByCompany( $option, $rows, $startdate, $enddate, $isbillable, $companyid, $criteria, $pop,$prows,$pcriteria,$hoursaday=8) {
	global $database, $mosConfig_live_site;
	
	HTML_timesheet_content::includeDontPrintStyle();
	HTML_timesheet_content::printStylesheetIncludes();
?>
<div class="content">

    <table border="0" width="100%">
    	<tr>
			<td class="componentheading" >Flextime Report By Company</td>
<?php  if ($pop == 0) {  ?>
		    <td  class="buttonheading" align="right"><a href="./index.php?option=com_timewriter&amp;task=showFlextimeReportByCompanyCriteria&amp;current_date=<?php echo("$startdate");?>&amp;end_date=<?php echo("$enddate");?>&amp;company_id=<?php echo("$companyid");?>&amp;is_billable=<?php echo("$isbillable");?>" title="Edit report criteria">Revise</a>&nbsp;</td>
		    <td  class="buttonheading" align="right"><a href="#" onclick="window.open('<?php echo $mosConfig_live_site; ?>/index2.php?option=com_timewriter&amp;task=showFlextimeReportByCompany&amp;period=<?php echo("$startdate");?>&amp;company_id=<?php echo("$companyid");?>&amp;pop=1', 'win2', 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=yes,resizable=yes,width=640,height=480,directories=no,location=no'); return false;" title="<?php echo _CMN_PRINT;?>"><img
		    			src="<?php echo $mosConfig_live_site;?>/images/M_images/printButton.png" border="0" alt="<?php echo _CMN_PRINT;?>" /></a>&nbsp;</td>				
<?php } else { ?>
		    <td  class="buttonheading" align="right"><div class="dontprint"><a href="#" onclick="window.print(); return false;" title="<?php echo _CMN_PRINT;?>"><img
		    			src="<?php echo $mosConfig_live_site;?>/images/M_images/printButton.png" border="0" alt="<?php echo _CMN_PRINT;?>" /></a></div>&nbsp;</td>				
<?php } ?>
		</tr>
    </table>
	<?php 
	echo $criteria;
	?>
    <table width="100%" border="0" cellspacing="1" >
		<tr>
		 <th class="sectiontableheader" align="center" width="20%">Date</th>
		 <th class="sectiontableheader" align="center" width="25%">Company</th>
		 <th class="sectiontableheader" align="center" width="40%">Project</th>
		 <th class="sectiontableheader" align="center" width="15%">Hours</th>
		</tr>
  <?php
    $totalhours = 0;
    $k = 0;
    for($i=0; $i < count( $rows ); $i++) {
		$row = $rows[$i];
	   ?>		

		<tr>
		 <td class="sectiontableentry2" nowrap align="center"><?php echo $row->date; ?></td>
		 <td class="sectiontableentry2" nowrap><?php if($row->company_name==NULL) echo("-No Company-"); else echo htmlspecialchars($row->company_name, ENT_QUOTES);?></td>
		 <td class="sectiontableentry2" nowrap><?php if($row->project_name==NULL) echo("-No Project-"); else echo htmlspecialchars($row->project_name, ENT_QUOTES); ?></td>
		 <td class="sectiontableentry2" align="center"><?php printf("%01.2f", $row->total_hours); ?></td>
		</tr>
		<tr>
		 <td class="sectiontableentry1" colspan="2">&nbsp;</td>
		 <td class="sectiontableentry1" ><u>Description:</u> <?php echo htmlspecialchars($row->description, ENT_QUOTES); ?></td>
		 <td class="sectiontableentry1" colspan="2">&nbsp;</td>
		</tr>
		 <?php 
			$totalhours += $row->total_hours;	
			$k = 1 - $k; 
	} 
  ?>
	<tr>
	 <td colspan="5">&nbsp;</td>
	</tr>
	<tr>
	 <td >&nbsp;</td>
	 <td colspan="2" style="text-align:right;">Total Hours:</td>
	 <td align="center"><?php printf("%01.2f", $totalhours); ?></td>
	 </tr><tr>
	 <td >&nbsp;</td>
	 <td colspan="2"style="text-align:right;" >Total Days:</td>
	 <td align="center"><?php printf("%01.2f", $totalhours/$hoursaday); ?></td>
	</tr>
  	</table>
  	<br>   
   <?php if(count($prows)>1){ ?>
   <br>Project Overview:<br>
    <table width="100%" border="0" cellspacing="1" >	
    <tr>
		 <th class="sectiontableheader" align="center" width="40%">Company</th>
		 <th class="sectiontableheader" align="center" width="45%">Project</th>
		 <th class="sectiontableheader" align="center" width="15%">Hours</th>
    </tr>
  <?php
    $k = 0;
    for($i=0; $i < count( $prows ); $i++) {
		$row = $prows[$i];
	   ?>

		<tr>
		 <td class="sectiontableentry2" nowrap><?php if($row->company_name==NULL) echo("-No Company-"); else echo htmlspecialchars($row->company_name, ENT_QUOTES); ?></td>
		 <td class="sectiontableentry2" nowrap><?php if($row->project_name==NULL) echo("-No Project-"); else echo htmlspecialchars($row->project_name, ENT_QUOTES); ?></td>
		 <td class="sectiontableentry2" align="center"><?php printf("%01.2f", $row->total_hours); ?></td>
		 <?php 
		  $k = 1 - $k; 
		 ?>
		</tr>
  <?php } ?>
  	</table>
	<?php } ?>
  	<br>
</div>

<?php
}


/*****************************************************************************
 *
*****************************************************************************/
function multiUserWeeklyReportByCompany( $option, $rows, $startdate, $enddate, $isbillable, $companyid, $userids, $criteria, $pop) {

	global $database, $mosConfig_live_site;
	
	HTML_timesheet_content::includeDontPrintStyle();
	HTML_timesheet_content::printStylesheetIncludes();
?>
<div class="content">

    <table border="0" width="100%">
    	<tr>
			<td class="componentheading" >Multi-User Weekly Report By Company</td>
<?php  if ($pop == 0) {  
			$selected_userids = HTML_timesheet_content::buildUrl($userids, "user_ids");

?>
		    <td  class="buttonheading" align="right"><a href="./index.php?option=com_timewriter&amp;task=multiUserWeeklyReportByCompanyCriteria&amp;current_date=<?php echo("$startdate");?>&amp;end_date=<?php echo("$enddate");?>&amp;company_id=<?php echo("$companyid");?><?php echo $selected_userids;?>&amp;is_billable=<?php echo("$isbillable");?>" title="Edit report criteria">Revise</a>&nbsp;</td>
		    <td  class="buttonheading" align="right"><a href="#" onclick="window.open('<?php echo $mosConfig_live_site; ?>/index2.php?option=com_timewriter&amp;task=multiUserWeeklyReportByCompany&amp;current_date=<?php echo("$startdate");?>&amp;end_date=<?php echo("$enddate");?>&amp;company_id=<?php echo("$companyid");?><?php echo $selected_userids;?>&amp;is_billable=<?php echo("$isbillable");?>&amp;pop=1', 'win2', 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=yes,resizable=yes,width=640,height=480,directories=no,location=no'); return false;" title="<?php echo _CMN_PRINT;?>"><img
		    			src="<?php echo $mosConfig_live_site;?>/images/M_images/printButton.png" border="0" alt="<?php echo _CMN_PRINT;?>" /></a>&nbsp;</td>				
<?php } else { ?>
		    <td  class="buttonheading" align="right"><div class="dontprint"><a href="#" onclick="window.print(); return false;" title="<?php echo _CMN_PRINT;?>"><img
		    			src="<?php echo $mosConfig_live_site;?>/images/M_images/printButton.png" border="0" alt="<?php echo _CMN_PRINT;?>" /></a></div>&nbsp;</td>				
<?php } ?>
		</tr>
    </table>
	<?php echo HTML_timesheet_content::showWeeklyReportContent($criteria, $rows, $isbillable); ?>
</div>

<?php
}

/*****************************************************************************
 *
*****************************************************************************/
function showProjectReportByProject( $option, $rows, $startdate, $enddate, $isbillable, $projectid, $criteria, $pop, $hoursaday) {
	global $database, $mosConfig_live_site;
	
	HTML_timesheet_content::includeDontPrintStyle(); 
	HTML_timesheet_content::printStylesheetIncludes();
?>
<div class="content">
    <table border="0" width="100%">
    	<tr>
			<td class="componentheading" >Timesheet Report by Project</td>
<?php  if ($pop == 0) {  
		$projectUrl = HTML_timesheet_content::buildUrl($projectid, "project_id");
		$prid = $projectid[0];
?>
		    <td  class="buttonheading" align="right"><a href="./index.php?option=com_timewriter&amp;task=showTimesheetReportByProjectCriteria&amp;current_date=<?php echo("$startdate");?>&amp;end_date=<?php echo("$enddate");?><?php echo("$projectUrl");?>&amp;is_billable=<?php echo("$isbillable");?>" title="Edit report criteria">Revise</a>&nbsp;</td>
		    <td  class="buttonheading" align="right"><a href="#" onclick="window.open('<?php echo $mosConfig_live_site; ?>/index2.php?option=com_timewriter&amp;task=showProjectReportByProject&amp;current_date=<?php echo("$startdate");?>&amp;project_id=<?php echo("$prid");?>&amp;end_date=<?php echo("$enddate");?>&amp;is_billable=<?php echo("$isbillable");?>&amp;pop=1', 'win2', 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=yes,resizable=yes,width=640,height=480,directories=no,location=no'); return false;" title="<?php echo _CMN_PRINT;?>"><img
		    			src="<?php echo $mosConfig_live_site;?>/images/M_images/printButton.png" border="0" alt="<?php echo _CMN_PRINT;?>" /></a>&nbsp;</td>				
<?php } else { ?>
		    <td  class="buttonheading" align="right"><div class="dontprint"><a href="#" onclick="window.print(); return false;" title="<?php echo _CMN_PRINT;?>"><img
		    			src="<?php echo $mosConfig_live_site;?>/images/M_images/printButton.png" border="0" alt="<?php echo _CMN_PRINT;?>" /></a></div>&nbsp;</td>				
<?php } ?>
		</tr>
    </table>
	<?php echo HTML_timesheet_content::showProjectReportContent($criteria, $rows, $hoursaday); ?>
</div>
<?php
}

/*****************************************************************************
 * schrijven pdf content list
*****************************************************************************/
function showProjectReportContent($criteria, $rows,$hoursaday=8) {
?>

    <?php 
	echo $criteria;
	?>
    <table width="100%" border="0" cellspacing="1" >
		<tr>
		 <th class="sectiontableheader" align="center" width="12%">Date</th>
		 <th class="sectiontableheader" align="center" width="18%">Company</th>
		 <th class="sectiontableheader" align="center" width="37%">Project</th>
		 <th class="sectiontableheader" align="center" width="10%">Billable</th>
		 <th class="sectiontableheader" align="center" width="13%">At Customer</th>
		 <th class="sectiontableheader" align="center" width="10%">Hours</th>
		</tr>
  <?php
    $totalBillable = 0;
    $totalNonbillable = 0;
    $k = 0;
    for($i=0; $i < count( $rows ); $i++) {
		$row = $rows[$i];
	   ?>		

		<tr>
		 <td class="sectiontableentry2" nowrap align="center"><?php echo $row->date; ?></td>
		 <td class="sectiontableentry2" nowrap><?php if($row->company_name==NULL) echo("-No Company-"); else echo htmlspecialchars($row->company_name, ENT_QUOTES);?></td>
		 <td class="sectiontableentry2" nowrap><?php if($row->project_name==NULL) echo("-No Project-"); else echo htmlspecialchars($row->project_name, ENT_QUOTES); ?></td>
		 <td class="sectiontableentry2" align="center"><?php echo ($row->is_billable?"Yes":"No"); ?></td>
		 <td class="sectiontableentry2" align="center"><?php echo ($row->at_customer?"Yes":"No"); ?></td>
		 <td class="sectiontableentry2" align="center"><?php printf("%01.2f", $row->total_hours); ?></td>
		</tr>
		<tr>
		 <td class="sectiontableentry1" colspan="2">&nbsp;</td>
		 <td class="sectiontableentry1" ><u>Description:</u> <?php echo htmlspecialchars($row->description, ENT_QUOTES); ?></td>
		 <td class="sectiontableentry1" colspan="2">&nbsp;</td>
		</tr>
		 <?php 
		  if ($row->is_billable) {
			$totalBillable += $row->total_hours;	 
		  } else {
			$totalNonbillable += $row->total_hours;	
		  }
		  $k = 1 - $k; 
	} 
  ?>
	<tr>
	 <td colspan="5">&nbsp;</td>
	</tr>
	
	<tr>
	 <td colspan="2">&nbsp;</td>
	 <td colspan="2"style="text-align:right;" >Total Billable Hours:</td>
	 <td align="center"><?php printf("%01.2f", $totalBillable); ?></td>
	</tr>
	<tr>
	 <td colspan="2">&nbsp;</td>
	 <td colspan="2"style="text-align:right;" >Total Billable Days:</td>
	 <td align="center"><?php printf("%01.2f", $totalBillable/$hoursaday); ?></td>
	</tr>
	<?php if($totalNonbillable != 0) {?>
		<tr>
		 <td colspan="2">&nbsp;</td>
		 <td colspan="2" style="text-align:right;">Total Non-Billable Hours:</td>
		 <td align="center"><?php printf("%01.2f", $totalNonbillable); ?></td>
		</tr>
	<?php } ?>
  	</table>
  	<br>
<?php
}

/*****************************************************************************
 *
*****************************************************************************/
function showWeeklyReportContentFooter($label, $isbillable, $totalBillableHrs, $totalNonBillableHrs) {
  ?>
    <tr>
     <td colspan="4"><?php echo $label; ?></td>
<?php
		for($day=0; $day < count($totalBillableHrs); $day++) {
			if ($isbillable == 1) {
				echo "<td class='sectiontableentry1' align='center'>" . sprintf("%01.2f", $totalBillableHrs[$day]) . "</td>";
			} else if ($isbillable == 0) {
				echo "<td class='sectiontableentry1' align='center'>" . sprintf("%01.2f", $totalNonBillableHrs[$day]) . "</td>";
			} else {
				echo "<td class='sectiontableentry1' nowrap align='center'>" . sprintf("%01.2f", $totalBillableHrs[$day]) . "/" . sprintf("%01.2f", $totalNonBillableHrs[$day]) . "</td>";
			}		
		}
		// Make up the end-of-week subtotals
		$b = 0;
		$n = 0;
		for($day=0; $day < count($totalBillableHrs); $day++) {
			$b += $totalBillableHrs[$day];
			$n += $totalNonBillableHrs[$day];
		}
		if ($isbillable == 1 || $isbillable == -1) {
			echo "<td class='sectiontableentry2' align='right'>" . sprintf("%01.2f", $b) . "</td>";
		}
		if ($isbillable == 0 || $isbillable == -1) {
			echo "<td class='sectiontableentry2' align='right'>" . sprintf("%01.2f", $n) . "</td>";
		}		
?>
    </tr>
    <tr>
     <td colspan="13">&nbsp;</td>
    </tr>
	
<?php
}
/*****************************************************************************
 *
*****************************************************************************/
function showWeeklyReportContent($criteria, $rows, $isbillable) {

	echo $criteria;
?>
	
    <table width="100%" border="0" cellspacing="1" >
    <tr>
     <th class="sectiontableheader" align="center" width="5%">Week</th>
     <th class="sectiontableheader" align="center" width="10%">User</th>
     <th class="sectiontableheader" align="center" width="20%">Company</th>
     <th class="sectiontableheader" align="center" width="20%">Project</th>
     <th class="sectiontableheader" align="center" width="5%">Mon</th>
     <th class="sectiontableheader" align="center" width="5%">Tue</th> 
     <th class="sectiontableheader" align="center" width="5%">Wed</th>
     <th class="sectiontableheader" align="center" width="5%">Thu</th>
     <th class="sectiontableheader" align="center" width="5%">Fri</th>
     <th class="sectiontableheader" align="center" width="5%">Sat</th>
      <th class="sectiontableheader" align="center" width="5%">Sun</th>
     
	 <!-- 13 cols -->
  <?php
  
	if ($isbillable == 1 || $isbillable == -1) {
		echo "<th class='sectiontableheader' align='center' width='5%'>Billable</th>";
	}
	if ($isbillable == 0 || $isbillable == -1) {
		echo "<th class='sectiontableheader' align='center' width='5%'>Non-Billable</th>";
	}	
	echo "</tr>";
  
  
    $totalBillable = 0;
    $totalNonbillable = 0;
	$totalBillableHrs = array (0, 0, 0, 0, 0, 0, 0);
	$totalNonBillableHrs = array (0, 0, 0, 0, 0, 0, 0);

	$subBillable = 0;
    $subNonbillable = 0;
	$subBillableHrs = array (0, 0, 0, 0, 0, 0, 0);
	$subNonBillableHrs = array (0, 0, 0, 0, 0, 0, 0);

	$lastCo = "dummy";
	$lastPr = "dummy";
	$lastNm = "dummy";

    for($i=0; $i < count( $rows ); $i++) {
		$row = $rows[$i];
		if ($i > 0 && ($lastCo != $row->company_name || $lastPr != $row->project_name || $lastNm != $row->name)) {
			HTML_timesheet_content::showWeeklyReportContentFooter("Subtotal Hours:", $isbillable, $subBillableHrs, $subNonBillableHrs);
			$subBillable = 0;
		    $subNonbillable = 0;
			$subBillableHrs = array (0, 0, 0, 0, 0, 0, 0);
			$subNonBillableHrs = array (0, 0, 0, 0, 0, 0, 0);
		}
		?>
		<tr>
		     <td class="sectiontableentry2" align="center" ><?php echo $row->weeknum; ?></td>
		     <td class="sectiontableentry2" nowrap><?php if($row->name==NULL) echo("-No User-"); else echo htmlspecialchars($row->name, ENT_QUOTES); ?></td>
		     <td class="sectiontableentry2" nowrap><?php if($row->company_name==NULL) echo("-No Company-"); else echo htmlspecialchars($row->company_name, ENT_QUOTES); ?></td>
		     <td class="sectiontableentry2" nowrap><?php if($row->project_name==NULL) echo("-No Project-"); else echo htmlspecialchars($row->project_name, ENT_QUOTES); ?></td>

		<?php
		
		$billableHrs = array ($row->sunday_billable_hours, $row->monday_billable_hours, 
							$row->tuesday_billable_hours,$row->wednesday_billable_hours, 
							$row->thursday_billable_hours, $row->friday_billable_hours, 
							$row->saturday_billable_hours);
		$nonBillableHrs = array ($row->sunday_non_billable_hours, $row->monday_non_billable_hours, 
							$row->tuesday_non_billable_hours, $row->wednesday_non_billable_hours, 
							$row->thursday_non_billable_hours, $row->friday_non_billable_hours, 
							$row->saturday_non_billable_hours);
		
		for($day=0; $day < count($billableHrs); $day++) {
			if ($isbillable == 1) {
				echo "<td class='sectiontableentry2' align='center'>" . sprintf("%01.2f", $billableHrs[$day]) . "</td>";
			} else if ($isbillable == 0) {
				echo "<td class='sectiontableentry2' align='center'>" . sprintf("%01.2f", $nonBillableHrs[$day]) . "</td>";
			} else {
				echo "<td class='sectiontableentry2' nowrap align='center'>" . sprintf("%01.2f", $billableHrs[$day]) . "/" . sprintf("%01.2f", $nonBillableHrs[$day]) . "</td>";
			}
			// Total Hours
			$totalBillable += $billableHrs[$day];
			$totalNonBillable += $nonBillableHrs[$day];
			// Total hours for each weekday
			$subBillableHrs[$day] += $billableHrs[$day];
			$subNonBillableHrs[$day] += $nonBillableHrs[$day];
			$totalBillableHrs[$day] += $billableHrs[$day];
			$totalNonBillableHrs[$day] += $nonBillableHrs[$day];
		}
		// Make up the end-of-week subtotals
		$b = 0;
		$n = 0;
		for($day=0; $day < count($billableHrs); $day++) {
			$b += $billableHrs[$day];
			$n += $nonBillableHrs[$day];
		}
		if ($isbillable == 1 || $isbillable == -1) {
			echo "<td class='sectiontableentry2' align='right'>" . sprintf("%01.2f", $b) . "</td>";
		}
		if ($isbillable == 0 || $isbillable == -1) {
			echo "<td class='sectiontableentry2' align='right'>" . sprintf("%01.2f", $n) . "</td>";
		}	
		echo "</tr>";
		$lastCo = $row->company_name;
		$lastPr = $row->project_name;
		$lastNm = $row->name;
	}
	HTML_timesheet_content::showWeeklyReportContentFooter("Subtotal Hours:", $isbillable, $subBillableHrs, $subNonBillableHrs);

	HTML_timesheet_content::showWeeklyReportContentFooter("Total Hours:", $isbillable, $totalBillableHrs, $totalNonBillableHrs);
	
  ?>
  	</table>
  	<br>
<?php
}

/*****************************************************************************
 * 
*****************************************************************************/
function showUserPreferencesCriteria( $option, $lists) {

	HTML_timesheet_content::printDateIncludes();
	HTML_timesheet_content::printStylesheetIncludes();
?>
  <script language="javascript" type="text/javascript">
    function validate() {
    return true;
    }

  </script>

<form action="index.php" method="POST" name="adminForm" >

<div class="content">
<?php echo HTML_timesheet_content::headerWithLinkToReportsMenu("User preferences", ''); ?>

<table border="0" cellpadding="3" cellspacing="0" class="adminform">
 <tr>
  <td>User</td>
  <td><?php echo $lists['user_id_fp']?></td>
 </tr>
</table>

<table width="100%">
<tr>
<td width="98%">&nbsp;</td>
<td>
 <input type="button" class="button" name="submitRun" value="Show preferences" onclick="document.adminForm.task.value='showUserPreferences'; if(validate()) document.adminForm.submit(); return false;">
</td>
<td width="1%">
 <input type="button" class="button" name="submitCancel" value="Cancel" onclick="window.location.href='./index.php?option=com_timewriter&task=showReportMenu'"> 
</td>
</tr>
</table>

</div>

<input type="hidden" name="option" value="com_timewriter" />
<input type="hidden" name="task" value="" />

</form>


<?php
}
/*****************************************************************************
 *
*****************************************************************************/
function showUserPreferences( $option, &$lists, &$fordate, $userid, &$row) {

	HTML_timesheet_content::printStylesheetIncludes();
?>
  <script language="javascript" type="text/javascript">
    function validate() {
  	if(trim(document.adminForm.user_id.value)=='0'){
  		alert("User Is Required" );
  		return;
  	}
	if(isNaN(trim(document.adminForm.parking.value))){
		alert("Parking amount must be numeric" );
		return false;
	}	
    return true;
    }
  </script>

<form action="index.php" method="POST" name="adminForm" >

<div class="content">
<?php HTML_timesheet_content::headerWithLinkToCalendar("Edit User Preferences", $fordate); ?>	

<table border="0" cellpadding="3" cellspacing="0" class="adminform">
 <tr>
  <td>Default Timesheet Project </td>
  <td><?php echo $lists['project_id']?></td>
  </tr>
  <tr>
  <td>Default Timesheet Billable </td>
  <td><input type="radio" name="is_billable" value="1" <?php if($row->is_billable==1) echo("checked")?>/>Yes
  <input type="radio" name="is_billable" value="0" <?php if($row->is_billable==0) echo("checked")?>/>No
	</td>  
 </tr>
  <tr>
  <td>Default Hours per day</td>
  <td><input type="text" size="15" name="hours_day" value="<?php echo htmlspecialchars($row->hours_day, ENT_QUOTES);?>" /></td>
  </tr>
<tr>
  <td>Default Rate per hour in Euro</td>
  <td><input type="text" size="15" name="rate_hour" value="<?php echo htmlspecialchars($row->rate_hour, ENT_QUOTES);?>" /></td>
  </tr>
  <tr>
  <td>Default Tax rate</td>
  <td><input type="text" size="15" name="tax_rate" value="<?php echo htmlspecialchars($row->tax_rate, ENT_QUOTES);?>" /></td>
  </tr>
  <tr>
  <td>Default Mileage rate</td>
  <td><input type="text" size="15" name="mileage_rate" value="<?php echo htmlspecialchars($row->mileage_rate, ENT_QUOTES);?>" /></td>
  </tr>
 <tr>
  <td>Default Vehicle</td>
  <td><?php echo $lists['vehicle_id']?></td>
  </tr>
 <tr>
  <td>Default Start Location</td>
  <td ><input type="text" size="15" name="start_location" value="<?php echo htmlspecialchars($row->start_location, ENT_QUOTES);?>" /></td>
  </tr>
 <tr>
  <td>Default End Location</td>
  <td ><input type="text" size="15" name="end_location" value="<?php echo htmlspecialchars($row->end_location, ENT_QUOTES);?>" /></td>
  </tr>
  <tr>
  <td>Default Mileage Billable </td>
  <td><input type="radio" name="mileage_is_billable" value="1" <?php if($row->mileage_is_billable==1) echo("checked")?>/>Yes
  <input type="radio" name="mileage_is_billable" value="0" <?php if($row->mileage_is_billable==0) echo("checked")?>/>No
	</td>  
 </tr>
 <tr>
  <td>Default Parking</td>
  <td ><input type="text" size="15" name="parking" style="text-align:right;" value="<?php echo htmlspecialchars($row->parking, ENT_QUOTES);?>" /></td>
  </tr>
</table>

<table width="100%">
<tr>
<td width="98%">&nbsp;</td>
<td>
 <input type="submit" class="button" name="submitRun" value="Save" onclick="if(validate()) document.adminForm.submit();return false;">
</td>
<td width="1%">
 <input type="button" class="button" name="submitCancel" value="Cancel" onclick="window.location.href='./index.php?option=com_timewriter&task=showReportMenu&fordate=&fordate=<?php echo $fordate;?>'"> 

</td>
</tr>
</table>

</div>

<input type="hidden" name="option" value="com_timewriter" />
<input type="hidden" name="task" value="saveUserPreferences" />
<input type="hidden" name="fordate" value="<?php echo $fordate;?>" />
<input type="hidden" name="current_date" value="" />
<input type="hidden" name="user_id" value="<?php echo $userid;?>" />
<input type="hidden" name="id" value="<?php echo $row->id;?>" />
</form>

<?php
}


/*****************************************************************************
 *
*****************************************************************************/
function editVehicle( $option, &$lists, &$fordate, &$row) {

	HTML_timesheet_content::printStylesheetIncludes();
?>
  <script language="javascript" type="text/javascript">
    function validate() {
      return true;
    }
  </script>

<form action="index.php" method="POST" name="adminForm" >

<div class="content">
<?php HTML_timesheet_content::headerWithLinkToReportsMenu("Edit Vehicle", $fordate); ?>	

<table border="0" cellpadding="3" cellspacing="0" class="adminform">
  <tr>
  <td>Name</td>
  <td><input type="text" size="15" name="vehicle_name" value="<?php echo $row->vehicle_name;?>" /></td>
 </tr>
  <tr>
  <td>Description </td>
  <td><textarea class="timesheetEntry" name="description" ><?php echo $row->description;?></textarea></td>
 </tr>
 <tr>
  <td>Units</td>
  <td><?php echo $lists['units']?></td>
  </tr>
 <tr>
  <td>Is Published</td>
  <td><input type="radio" name="published" value="1" <?php if($row->published==1) echo("checked")?>/>Yes
  <input type="radio" name="published" value="0" <?php if($row->published==0) echo("checked")?>/>No
	</td>  
 </tr>
</table>

<table width="100%">
<tr>
<td width="98%">&nbsp;</td>
<td>
 <input type="submit" class="button" name="submitRun" value="Save" onclick="if(validate()) document.adminForm.submit();return false;">
</td>
<td width="1%">
 <input type="button" class="button" name="submitCancel" value="Cancel" onclick="window.location.href='./index.php?option=com_timewriter&task=showVehicles&fordate=<?php echo $fordate;?>'">  
</td>
</tr>
</table>

</div>

<input type="hidden" name="option" value="com_timewriter" />
<input type="hidden" name="task" value="saveVehicle" />
<input type="hidden" name="fordate" value="<?php echo $fordate;?>" />
<input type="hidden" name="current_date" value="" />
<input type="hidden" name="user_id" value="<?php echo $row->user_id;?>" />
<input type="hidden" name="id" value="<?php echo $row->id;?>" />
</form>

<?php
}

/*****************************************************************************
 *
*****************************************************************************/
function editMileage( $option, &$lists, &$fordate, &$row, $redirecttask) {

global $mosConfig_live_site; 

	HTML_timesheet_content::printStylesheetIncludes();
?>
  <script language="javascript" type="text/javascript">
    function validate() {
	  	if(trim(document.adminForm.date.value)==''){
	  		alert("Date Is Required" );
	  		return false;
	  	}
	  	if(trim(document.adminForm.vehicle_id.value)=='0'){
	  		alert("Vehicle Is Required" );
	  		return false;
	 	}
	  	if(trim(document.adminForm.start_location.value)==''){
	  		alert("Start Location Is Required" );
	  		return false;
	  	}
	  	if(trim(document.adminForm.start_odometer.value)==''){
	  		alert("Start Odometer Is Required" );
	  		return false;
	  	}
	  	if(trim(document.adminForm.end_location.value)==''){
	  		alert("End Location Is Required" );
	  		return false;
	  	}
	  	if(trim(document.adminForm.end_odometer.value)==''){
	  		alert("End Odometer Is Required" );
			document.adminForm.end_odometer.focus();
	  		return false;
	  	}
	  	if((document.adminForm.end_odometer.value - document.adminForm.start_odometer.value) < 1){
	  		alert("Trip length must be greater than zero" );
			document.adminForm.end_odometer.focus();
	  		return false;
	  	}
	  	if(isNaN(trim(document.adminForm.parking.value))){
		  		alert("Parking amount must be numeric" );
				return false;
	  	}	
		return true;
    }
  </script>

<?php echo HTML_timesheet_content::printDateIncludes(); ?>

<form action="index.php" method="POST" name="adminForm" >

<div class="content">
<?php HTML_timesheet_content::headerWithLinkToCalendar("Edit Mileage", $fordate); ?>	

<table border="0" cellpadding="3" cellspacing="0" class="adminform">
  <tr>
  <td width="10%">Date </td>
  <td colspan=3>
        <input class="text_area" type="text" name="date" id="date" size="25" maxlength="19" value="<?php echo $row->date;?>" />
        <input type="reset" class="button" value="..." onClick="return showCalendar('date', 'dd-mm-yyyy');">
  </td>
  </tr>
  <tr>
  <td>Vehicle</td>
  <td colspan=3><?php echo $lists['vehicle_id']?></td>
  </tr>
  <tr>
  <td nowrap>Start Location</td>
  <td width="10%"><input type="text" size="15" name="start_location" value="<?php echo htmlspecialchars($row->start_location, ENT_QUOTES);?>" /></td>
  <td nowrap width="10%">Odometer</td>
  <td width="80%"><input type="text" style="text-align:right;" size="15" name="start_odometer" value="<?php echo htmlspecialchars($row->start_odometer, ENT_QUOTES);?>" /></td>
 </tr>
  <tr>
  <td nowrap>End Location</td>
  <td width="10%"><input type="text" size="15" name="end_location" value="<?php echo htmlspecialchars($row->end_location, ENT_QUOTES);?>" /></td>
  <td nowrap width="10%">Odometer</td>
  <td><input type="text" style="text-align:right;" size="15" name="end_odometer" value="<?php echo htmlspecialchars($row->end_odometer, ENT_QUOTES);?>" /></td>
 </tr>
  <tr>
  <td nowrap>Parking Cost</td>
  <td colspan=3><input type="text" style="text-align:right;" size="15" name="parking" value="<?php echo htmlspecialchars($row->parking, ENT_QUOTES);?>" /></td>
 </tr>
 <tr>
  <td nowrap>Company</td>
  <td colspan=3><?php echo $lists['company_id']?></td>
  </tr>
 <tr>
  <td nowrap>Is Billable</td>
  <td colspan=3><input type="radio" name="is_billable" value="1" <?php if($row->is_billable==1) echo("checked")?>/>Yes
   <input type="radio" name="is_billable" value="0" <?php if($row->is_billable==0) echo("checked")?>/>No
  </td>  
 </tr>
  <tr>
  <td nowrap>Notes </td>
  <td colspan=3><textarea rows=3 cols=40 name="notes" ><?php echo htmlspecialchars($row->notes, ENT_QUOTES);?></textarea></td>
 </tr>
</table>
<table width="100%">
<tr>
<td width="98%"><a style="text-decoration:none" href="#" onClick="document.adminForm.task.value='saveMileageWithReturn';if(validate()) document.adminForm.submit(); return false;">Save & Create Return Trip</a></td>
<td> 
 <input type="submit" class="button" name="submitRun" value="Save" onclick="if(validate()) document.adminForm.submit();return false;">
</td>
<td width="1%">
 <input type="button" class="button" name="submitCancel" value="Cancel" onclick="window.location.href='./index.php?option=com_timewriter&task=<?php echo $redirecttask;?>&fordate=<?php echo $fordate;?>'">
</td>
</tr>
</table>

</div>

<input type="hidden" name="option" value="com_timewriter" />
<input type="hidden" name="task" value="saveMileage" />
<input type="hidden" name="redirecttask" value="<?php echo $redirecttask;?>" />
<input type="hidden" name="fordate" value="<?php echo $fordate;?>" />
<input type="hidden" name="current_date" value="" />
<input type="hidden" name="user_id" value="<?php echo $row->user_id;?>" />
<input type="hidden" name="id" value="<?php echo $row->id;?>" />

</form>

<?php
}

/*****************************************************************************
 *
*****************************************************************************/
function editProjectTimesheets( $option, &$lists, &$fordate, $userid, &$row, $redirecttask) {
	global $mosConfig_live_site;

	HTML_timesheet_content::printDateIncludes();
	HTML_timesheet_content::printStylesheetIncludes();
?>
  <script language="javascript" type="text/javascript">
    function validate() {
  	if(trim(document.adminForm.date.value)==''){
  		alert("Date Is Required" );
  		return false;
  	}
  	if(trim(document.adminForm.project_id.value)=='0'){
  		alert("Project Is Required" );
  		return false;
 	}
  	if(trim(document.adminForm.user_id.value)=='0'){
  		alert("User Is Required" );
  		return false;
  	}
  	if(trim(document.adminForm.total_hours.value)==''){
  		alert("Total Hours Is Required" );
  		return false;
  	}
  	if(isNaN(trim(document.adminForm.total_hours.value))){
	  	alert("Invalid Total Hours" );
  		return false;
  	}
    return true;
    }

window.addEvent('domready', function() {Calendar.setup({
        inputField     :    "date",     // id of the input field
        ifFormat       :    "%Y-%m-%d",      // format of the input field
        button         :    "date_img",  // trigger for the calendar (button ID)
        align          :    "Tl",           // alignment (defaults to "Bl")
        singleClick    :    true
    });});

  </script>

<form action="index.php" method="POST" name="adminForm" >

<div class="content">
<?php echo HTML_timesheet_content::headerWithLinkToCalendar("Edit Timesheet Entry For ".HTML_timesheet_content::fmtDate($fordate), $fordate); ?>	

<table border="0" cellpadding="3" cellspacing="0" class="adminform">
 <tr>
  <td>Date </td>
  <td colspan="3">
	<input type="text" name="date" id="date" size="25" maxlength="19" value="<?php echo htmlspecialchars($row->date, ENT_QUOTES); ?>" class="inputbox" />
	<img class="calendar" src="./templates/system/images/calendar.png" alt="calendar" id="date_img" />
  </td>
 </tr>
 <tr>
  <td>Project </td>
  <td colspan="3"><?php echo $lists['project_id']?></td>
 </tr>
 <tr>
  <td>Description </td>
  <td colspan="3"><textarea class="timesheetEntry" name="description" ><?php echo $row->description;?></textarea></td>
 </tr>
 <tr>
  <td>Total Hours </td>
  <td><input type="text" style="text-align:right;" size="5" maxsize="5" name="total_hours" value="<?php echo $row->total_hours;?>" /></td>
  </tr><tr><td>&nbsp;</td></tr>
  <tr>
  <td>&nbsp;</td><td>Is Billable&nbsp;<input type="radio" name="is_billable" value="1" <?php if($row->is_billable==1) echo("checked")?>/>Yes
    <input type="radio" name="is_billable" value="0" <?php if($row->is_billable==0) echo("checked")?>/>No
  </td><td>&nbsp;</td><td>At Customer&nbsp;<input type="radio" name="at_customer" value="1" <?php if($row->at_customer==1) echo("checked")?>/>Yes
    <input type="radio" name="at_customer" value="0" <?php if($row->at_customer==0) echo("checked")?>/>No
  </td>  
 </tr>
</table>

<table width="100%">
	<tr><td width="98%">&nbsp;</td>
	<td>
	 <input type="submit" class="button" name="submitRun" value="Save" onclick="document.adminForm.option.value='com_timewriter';document.adminForm.current_date.value='';document.adminForm.task.value='saveProjectTimesheets';document.adminForm.redirecttask.value='<?php echo $redirecttask;?>';document.adminForm.fordate.value='<?php echo $fordate?>'; if(validate()) document.adminForm.submit();return false;">
	</td>
	<td>
	 <input type="button" class="button" name="submitCancel" value="Cancel" onclick="window.location.href='./index.php?option=com_timewriter&task=<?php echo $redirecttask;?>&current_date=&fordate=<?php echo $fordate;?>'"> 
	</td>
	</tr>
</table>

</div>

<input type="hidden" name="option" value="com_timewriter" />
<input type="hidden" name="task" value="showTimesheet" />
<input type="hidden" name="redirecttask" value="<?php echo $redirecttask;?>" />
<input type="hidden" name="published" value="1" />
<input type="hidden" name="fordate" value="<?php echo $fordate;?>" />
<input type="hidden" name="current_date" value="" />
<input type="hidden" name="user_id" value="<?php echo $userid;?>" />
<input type="hidden" name="id" value="<?php echo $row->id;?>" />
</form>

<?php
}


/*****************************************************************************
 * 
*****************************************************************************/
function multiUserWeeklyReportByCompanyCriteria( $option, $lists, $userid, $startdate, $enddate) {

	HTML_timesheet_content::printDateIncludes();
	HTML_timesheet_content::printStylesheetIncludes();
?>
  <script language="javascript" type="text/javascript">
    function validate() {
  	if(trim(document.adminForm.current_date.value)==''){
  		alert("Start Date Is Required" );
  		return false;
  	}
  	if(trim(document.adminForm.end_date.value)==''){
  		alert("End Date Is Required" );
  		return false;
  	}
    return true;
    }
	
	/**
	* This function is used by javascript that's attached to the Company Select list's onchange event.
	**/
	function getCheckboxValue(cbox) {
		var b = null;
		for (var i=0; i < cbox.length; i++) {
			if (cbox[i].checked) {
				b = cbox[i].value;
				break;
			}
		}
		return b;
	}	
	
window.addEvent('domready', function() {Calendar.setup({
        inputField     :    "current_date",     // id of the input field
        ifFormat       :    "%Y-%m-%d",      // format of the input field
        button         :    "current_date_img",  // trigger for the calendar (button ID)
        align          :    "Tl",           // alignment (defaults to "Bl")
        singleClick    :    true
    });});
	
window.addEvent('domready', function() {Calendar.setup({
        inputField     :    "end_date",     // id of the input field
        ifFormat       :    "%Y-%m-%d",      // format of the input field
        button         :    "end_date_img",  // trigger for the calendar (button ID)
        align          :    "Tl",           // alignment (defaults to "Bl")
        singleClick    :    true
    });});
	
  </script>

<form action="index.php" method="POST" name="adminForm" >

<div class="content">
<?php echo HTML_timesheet_content::headerWithLinkToReportsMenu("Weekly Report by Company", $startdate); ?>

<table border="0" cellpadding="3" cellspacing="0" class="adminform">
 <tr>
  <td>Company</td>
  <td><?php echo $lists['company_id']?></td>
 </tr>
 <tr>
  <td>Users</td>
  <td><?php echo $lists['user_ids']?></td>
 </tr>
 <tr>
  <td>Start Date </td>
  <td>
	<input type="text" name="current_date" id="current_date" size="25" maxlength="19" value="<?php echo htmlspecialchars($startdate, ENT_QUOTES); ?>" class="inputbox" />
	<img class="calendar" src="./templates/system/images/calendar.png" alt="calendar" id="current_date_img" />
  </td>
 </tr>
 <tr>
  <td>End Date </td>
  <td>
	<input type="text" name="end_date" id="end_date" size="25" maxlength="19" value="<?php echo htmlspecialchars($enddate, ENT_QUOTES); ?>" class="inputbox" />
	<img class="calendar" src="./templates/system/images/calendar.png" alt="calendar" id="end_date_img" />
  </td>
 </tr>
 <tr>
  <td>Billable</td>
	<td><?php echo $lists['is_billable']?></td>  
 </tr>
</table>

<table width="100%">
<tr>
<td width="98%">&nbsp;</td>
<td>
 <input type="button" class="button" name="submitRun" value="Run Report" onclick="document.adminForm.task.value='multiUserWeeklyReportByCompany'; if(validate()) document.adminForm.submit(); return false;">
</td>
<td width="1%">
 <input type="button" class="button" name="submitCancel" value="Cancel" onclick="window.location.href='./index.php?option=com_timewriter&task=showReportMenu'"> 
</td>
</tr>
</table>

</div>

<input type="hidden" name="option" value="com_timewriter" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="fordate" value="<?php echo $startdate;?>" />

</form>


<?php
}

/*****************************************************************************
 * 
*****************************************************************************/
function showTimesheetReportByCompanyCriteria( $option, $lists, $userid, $startdate, $enddate) {

	HTML_timesheet_content::printDateIncludes();
	HTML_timesheet_content::printStylesheetIncludes();
?>
  <script language="javascript" type="text/javascript">
    function validate() {
  	if(trim(document.adminForm.current_date.value)==''){
  		alert("Start Date Is Required" );
  		return false;
  	}
  	if(trim(document.adminForm.end_date.value)==''){
  		alert("End Date Is Required" );
  		return false;
  	}
	if(trim(document.adminForm.company_id.value)=='0'){
			alert("Please select the company" );
			return false;
		}
    return true;
    }
	
window.addEvent('domready', function() {Calendar.setup({
        inputField     :    "current_date",     // id of the input field
        ifFormat       :    "%Y-%m-%d",      // format of the input field
        button         :    "current_date_img",  // trigger for the calendar (button ID)
        align          :    "Tl",           // alignment (defaults to "Bl")
        singleClick    :    true
    });});

window.addEvent('domready', function() {Calendar.setup({
        inputField     :    "end_date",     // id of the input field
        ifFormat       :    "%Y-%m-%d",      // format of the input field
        button         :    "end_date_img",  // trigger for the calendar (button ID)
        align          :    "Tl",           // alignment (defaults to "Bl")
        singleClick    :    true
    });});

  </script>

<form action="index.php" method="POST" name="adminForm" >

<div class="content">
<?php echo HTML_timesheet_content::headerWithLinkToReportsMenu("Timesheet Report by Company", $startdate); ?>

<table border="0" cellpadding="3" cellspacing="0" class="adminform">
 <tr>
  <td>Company</td>
  <td><?php echo $lists['company_id']?></td>
 </tr>
 <tr>
  <td>Start Date </td>
  <td>
	<input type="text" name="current_date" id="current_date" size="25" maxlength="19" value="<?php echo htmlspecialchars($startdate, ENT_QUOTES); ?>" class="inputbox" />
	<img class="calendar" src="./templates/system/images/calendar.png" alt="calendar" id="current_date_img" />
  </td>
 </tr>
 <tr>
  <td>End Date </td>
  <td>
	<input type="text" name="end_date" id="end_date" size="25" maxlength="19" value="<?php echo htmlspecialchars($enddate, ENT_QUOTES); ?>" class="inputbox" />
	<img class="calendar" src="./templates/system/images/calendar.png" alt="calendar" id="end_date_img" />
  </td>
 </tr>
 <tr>
  <td>Billable</td>
	<td><?php echo $lists['is_billable']?></td>  
 </tr>
</table>

<table width="100%">
<tr>
<td width="98%">&nbsp;</td>
<td>
 <input type="button" class="button" name="submitRun" value="Run Report" onclick="document.adminForm.option.value='com_timewriter';document.adminForm.task.value='showProjectReportByCompany';if(validate()) document.adminForm.submit(); return false;">
</td>
<td width="1%">
 <input type="button" class="button" name="submitCancel" value="Cancel" onclick="window.location.href='./index.php?option=com_timewriter&task=showReportMenu'"> 
</td>
</tr>
</table>

</div>

<input type="hidden" name="option" value="com_timewriter" />
<input type="hidden" name="task" value="showProjectReportByCompany" />
<input type="hidden" name="fordate" value="<?php echo $startdate;?>" />

</form>


<?php
}

/*****************************************************************************
 * 
*****************************************************************************/
function showFlextimeReportByCompanyCriteria( $option, $lists, $userid, $period) {

	HTML_timesheet_content::printDateIncludes();
	HTML_timesheet_content::printStylesheetIncludes();
?>
  <script language="javascript" type="text/javascript">
    function validate() {
  	if(trim(document.adminForm.company_id.value)=='0'){
			alert("Please select the company" );
			return false;
		}
	if(trim(document.adminForm.period.value)==''){
  		alert("Period Is Required" );
  		return false;
  	}
    return true;
    }

window.addEvent('domready', function() {Calendar.setup({
        inputField     :    "period",     // id of the input field
        ifFormat       :    "%Y-%m-%d",      // format of the input field
        button         :    "period_img",  // trigger for the calendar (button ID)
        align          :    "Tl",           // alignment (defaults to "Bl")
        singleClick    :    true
    });});

  </script>

<form action="index.php" method="POST" name="adminForm" >

<div class="content">
<?php echo HTML_timesheet_content::headerWithLinkToReportsMenu("Flextime Report by Company", ''); ?>

<table border="0" cellpadding="3" cellspacing="0" class="adminform">
 <tr>
  <td>Company</td>
  <td><?php echo $lists['company_id']?></td>
 </tr>
 <tr>
  <td>Date </td>
  <td>
	<input type="text" name="period" id="period" size="25" maxlength="19" value="<?php echo htmlspecialchars($period, ENT_QUOTES); ?>" class="inputbox" />
	<img class="calendar" src="./templates/system/images/calendar.png" alt="calendar" id="period_img" />
  </td>
 </tr>
</table>

<table width="100%">
<tr>
<td width="98%">&nbsp;</td>
<td>
 <input type="button" class="button" name="submitRun" value="Run Report" onclick="document.adminForm.task.value='showFlextimeReportByCompany'; if(validate()) document.adminForm.submit(); return false;">
</td>
<td width="1%">
 <input type="button" class="button" name="submitCancel" value="Cancel" onclick="window.location.href='./index.php?option=com_timewriter&task=showReportMenu'"> 
</td>
</tr>
</table>

</div>

<input type="hidden" name="option" value="com_timewriter" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="fordate" value="<?php echo date("Y-m-d");?>" />

</form>


<?php
}
/*****************************************************************************
 * 
*****************************************************************************/
function showTimesheetReportByProjectCriteria( $option, $lists, $userid, $startdate, $enddate) {

	HTML_timesheet_content::printDateIncludes();
	HTML_timesheet_content::printStylesheetIncludes();
?>
<script language="javascript" type="text/javascript">
function validate() {
	if(trim(document.adminForm.project_id.value)=='0'){
			alert("Please select the project" );
			return false;
		}
  	if(trim(document.adminForm.current_date.value)==''){
  		alert("Start Date Is Required" );
  		return false;
  	}
  	if(trim(document.adminForm.end_date.value)==''){
  		alert("End Date Is Required" );
  		return false;
  	}
    return true;
}

window.addEvent('domready', function() {Calendar.setup({
        inputField     :    "current_date",     // id of the input field
        ifFormat       :    "%Y-%m-%d",      // format of the input field
        button         :    "current_date_img",  // trigger for the calendar (button ID)
        align          :    "Tl",           // alignment (defaults to "Bl")
        singleClick    :    true
    });});

window.addEvent('domready', function() {Calendar.setup({
        inputField     :    "end_date",     // id of the input field
        ifFormat       :    "%Y-%m-%d",      // format of the input field
        button         :    "end_date_img",  // trigger for the calendar (button ID)
        align          :    "Tl",           // alignment (defaults to "Bl")
        singleClick    :    true
    });});


</script>

<form action="index.php" method="POST" name="adminForm" >

<div class="content">
<?php echo HTML_timesheet_content::headerWithLinkToReportsMenu("Timesheet Report by Project", $startdate); ?>

<table border="0" cellpadding="3" cellspacing="0" class="adminform">
 <tr>
  <td style="vertical-align:top;">Projects</td>
  <td><?php echo $lists['project_id']?></td>
 </tr>
 <tr>
  <td>Start Date </td>
  <td>
  	<input type="text" name="current_date" id="current_date" size="25" maxlength="19" value="<?php echo htmlspecialchars($startdate, ENT_QUOTES); ?>" class="inputbox" />
	<img class="calendar" src="./templates/system/images/calendar.png" alt="calendar" id="current_date_img" />
  </td>
 </tr>
 <tr>
  <td>End Date </td>
  <td>
	<input type="text" name="end_date" id="end_date" size="25" maxlength="19" value="<?php echo htmlspecialchars($enddate, ENT_QUOTES); ?>" class="inputbox" />
	<img class="calendar" src="./templates/system/images/calendar.png" alt="calendar" id="end_date_img" />
  </td>
 </tr>
 <tr>
  <td>Billable</td>
	<td><?php echo $lists['is_billable']?></td>  
 </tr>
</table>

<table width="100%">
<tr>
<td width="98%">&nbsp;</td>
<td>
 <input type="button" class="button" name="submitRun" value="Run Report" onclick="document.adminForm.task.value='showProjectReportByProject'; if(validate()) document.adminForm.submit(); return false;">
</td>
<td width="1%">
 <input type="button" class="button" name="submitCancel" value="Cancel" onclick="window.location.href='./index.php?option=com_timewriter&task=showReportMenu'"> 
</td>
</tr>
</table>

</div>

<input type="hidden" name="option" value="com_timewriter" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="fordate" value="<?php echo $startdate;?>" />

</form>

<?php
}

/*****************************************************************************
 * 
*****************************************************************************/
function showTotalHoursPerProjectCriteria ( $option, $lists, $userid, $startdate, $enddate) {

	HTML_timesheet_content::printDateIncludes();
	HTML_timesheet_content::printStylesheetIncludes();

	$title = "Total Hours by Project";
	$task = "showTotalHoursPerProject";
?>
  <script language="javascript" type="text/javascript">
function validate() {
	/*
	var selCounter = 0;
	var proj = document.adminForm.elements['project_id[]'];
	for (var i = 0; i < proj.length; i++) {
		if (proj.options[i].selected) {
			selCounter++;
		}
	}
  	if (selCounter < 1){
  		alert("Project Selection Is Required" );
  		return false;
  	}
	*/
  	if (trim(document.adminForm.current_date.value)==''){
  		alert("Start Date Is Required" );
  		return false;
  	}
  	if (trim(document.adminForm.end_date.value)==''){
  		alert("End Date Is Required" );
  		return false;
  	}
    return true;
}

window.addEvent('domready', function() {Calendar.setup({
        inputField     :    "current_date",     // id of the input field
        ifFormat       :    "%Y-%m-%d",      // format of the input field
        button         :    "current_date_img",  // trigger for the calendar (button ID)
        align          :    "Tl",           // alignment (defaults to "Bl")
        singleClick    :    true
    });});
	
window.addEvent('domready', function() {Calendar.setup({
        inputField     :    "end_date",     // id of the input field
        ifFormat       :    "%Y-%m-%d",      // format of the input field
        button         :    "end_date_img",  // trigger for the calendar (button ID)
        align          :    "Tl",           // alignment (defaults to "Bl")
        singleClick    :    true
    });});

  </script>

<form action="index.php" method="POST" name="adminForm" >

<div class="content">
<?php echo HTML_timesheet_content::headerWithLinkToReportsMenu($title, $startdate); ?>

<table border="0" cellpadding="3" cellspacing="0" class="adminform">
 <tr>
  <td>Start Date </td>
  <td>
	<input type="text" name="current_date" id="current_date" size="25" maxlength="19" value="<?php echo htmlspecialchars($startdate, ENT_QUOTES); ?>" class="inputbox" />
	<img class="calendar" src="./templates/system/images/calendar.png" alt="calendar" id="current_date_img" />
  </td>
 </tr>
 <tr>
  <td>End Date </td>
  <td>
	<input type="text" name="end_date" id="end_date" size="25" maxlength="19" value="<?php echo htmlspecialchars($enddate, ENT_QUOTES); ?>" class="inputbox" />
	<img class="calendar" src="./templates/system/images/calendar.png" alt="calendar" id="end_date_img" />
  </td>
 </tr>
 <tr>
  <td>Billable</td>
   <td><?php echo $lists['is_billable']?></td>
 </tr>
</table>

<table width="100%">
<tr>
<td width="98%">&nbsp;</td>
<td>
 <input type="button" class="button" name="submitRun" value="Run Report" onclick="document.adminForm.task.value='<?php echo $task; ?>'; if(validate()) document.adminForm.submit(); return false;">
</td>
<td width="1%">
 <input type="button" class="button" name="submitCancel" value="Cancel" onclick="window.location.href='./index.php?option=com_timewriter&task=showReportMenu'"> 
</td>
</tr>
</table>

</div>

<input type="hidden" name="option" value="com_timewriter" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="fordate" value="<?php echo $startdate;?>" />

</form>

<?php
}

/*****************************************************************************
 * 
*****************************************************************************/
function showTotalMileageCriteria ( $option, $lists, $userid, $startdate, $enddate) {

	HTML_timesheet_content::printDateIncludes();
	HTML_timesheet_content::printStylesheetIncludes();
?>
  <script language="javascript" type="text/javascript">
    function validate() {
  	if(trim(document.adminForm.current_date.value)==''){
  		alert("Start Date Is Required" );
  		return false;
  	}
  	if(trim(document.adminForm.end_date.value)==''){
  		alert("End Date Is Required" );
  		return false;
  	}
    return true;
    }
	
window.addEvent('domready', function() {Calendar.setup({
        inputField     :    "current_date",     // id of the input field
        ifFormat       :    "%Y-%m-%d",      // format of the input field
        button         :    "current_date_img",  // trigger for the calendar (button ID)
        align          :    "Tl",           // alignment (defaults to "Bl")
        singleClick    :    true
    });});
	
window.addEvent('domready', function() {Calendar.setup({
        inputField     :    "end_date",     // id of the input field
        ifFormat       :    "%Y-%m-%d",      // format of the input field
        button         :    "end_date_img",  // trigger for the calendar (button ID)
        align          :    "Tl",           // alignment (defaults to "Bl")
        singleClick    :    true
    });});

  </script>

<form action="index.php" method="POST" name="adminForm" >

<div class="content">
<?php echo HTML_timesheet_content::headerWithLinkToReportsMenu("Total Mileage Report", $startdate); ?>

<table border="0" cellpadding="3" cellspacing="0" class="adminform">
 <tr>
  <td>Vehicle</td>
  <td><?php echo $lists['vehicle_id']?></td>
 </tr>
 <tr>
  <td>Company</td>
  <td><?php echo $lists['company_id']?></td>
 </tr>
 <tr>
  <td>Start Date </td>
  <td>
	<input type="text" name="current_date" id="current_date" size="25" maxlength="19" value="<?php echo htmlspecialchars($startdate, ENT_QUOTES); ?>" class="inputbox" />
	<img class="calendar" src="./templates/system/images/calendar.png" alt="calendar" id="current_date_img" />
  </td>
 </tr>
 <tr>
  <td>End Date </td>
  <td>

	<input type="text" name="end_date" id="end_date" size="25" maxlength="19" value="<?php echo htmlspecialchars($enddate, ENT_QUOTES); ?>" class="inputbox" />
	<img class="calendar" src="./templates/system/images/calendar.png" alt="calendar" id="end_date_img" />
  </td>
 </tr>
 <tr>
  <td>Billable</td>
   <td><?php echo $lists['is_billable']?></td>
 </tr>
</table>

	<?php echo HTML_timesheet_content::printSubmitAndCancelButtons("showTotalMileageReport", "showReportMenu"); ?>

</div>

<input type="hidden" name="option" value="com_timewriter" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="fordate" value="<?php echo $startdate;?>" />

</form>

<?php
}

/*****************************************************************************
 * 
*****************************************************************************/
function multiUserTotalMileageCriteria ( $option, $lists, $userid, $startdate, $enddate) {

	HTML_timesheet_content::printDateIncludes();
	HTML_timesheet_content::printStylesheetIncludes();
?>
  <script language="javascript" type="text/javascript">
    function validate() {
  	if(trim(document.adminForm.current_date.value)==''){
  		alert("Start Date Is Required" );
  		return false;
  	}
  	if(trim(document.adminForm.end_date.value)==''){
  		alert("End Date Is Required" );
  		return false;
  	}
    return true;
    }

	/**
	* This function is used by javascript that's attached to the Company Select list's onchange event.
	**/
	function getCheckboxValue(cbox) {
		var b = null;
		for (var i=0; i < cbox.length; i++) {
			if (cbox[i].checked) {
				b = cbox[i].value;
				break;
			}
		}
		return b;
	}	
  </script>

<form action="index.php" method="POST" name="adminForm" >

<div class="content">
<?php echo HTML_timesheet_content::headerWithLinkToReportsMenu("Multi-User Total Mileage Report", $startdate); ?>

<table border="0" cellpadding="3" cellspacing="0" class="adminform">
 <tr>
  <td>Company</td>
  <td><?php echo $lists['company_id']?></td>
 </tr>
 <tr>
  <td>Users</td>
  <td><?php echo $lists['user_ids']?></td>
 </tr>
 <tr>
  <td>Start Date </td>
  <td>
        <input class="text_area" type="text" name="current_date" id="current_date" size="25" maxlength="19" value="<?php echo $startdate;?>" />
        <input type="reset" class="button" value="..." onClick="return showCalendar('current_date', 'dd-mm-yyyy');">
  </td>
 </tr>
 <tr>
  <td>End Date </td>
  <td>
        <input class="text_area" type="text" name="end_date" id="end_date" size="25" maxlength="19" value="<?php echo $enddate;?>" />
        <input type="reset" class="button" value="..." onClick="return showCalendar('end_date', 'dd-mm-yyyy');">
  </td>
 </tr>
 <tr>
  <td>Billable</td>
   <td><?php echo $lists['is_billable']?></td>
 </tr>
</table>

	<?php echo HTML_timesheet_content::printSubmitAndCancelButtons("multiUserTotalMileageReport", "showReportMenu"); ?>

</div>

<input type="hidden" name="option" value="com_timewriter" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="fordate" value="<?php echo $startdate;?>" />

</form>

<?php
}


/******************************************************************************
 * 
******************************************************************************/
function adminShowCompanyList( $option, $rows, $pageNav, $lists) {

	HTML_timesheet_content::printDateIncludes();
	HTML_timesheet_content::printStylesheetIncludes();
?>
 
<form action="index.php" method="post" name="adminForm">
<div class="content">
<?php 
	echo HTML_timesheet_content::headerWithLinkToReportsMenu("Manage Companies"); 
	
?>
<div style="text-align:right;">
	<a href="#" onClick="document.adminForm.task.value='adminNewCompany';document.adminForm.submit(); return false;">New</a>
	&nbsp;|&nbsp;<a href="#" onClick="if(document.adminForm.boxchecked.value == 0){alert('Nothing selected, nothing to do.');}else{document.adminForm.task.value='adminPublishCompany';document.adminForm.submit();} return false;">Publish</a>
	&nbsp;|&nbsp;<a href="#" onClick="if(document.adminForm.boxchecked.value == 0){alert('Nothing selected, nothing to do.');}else{document.adminForm.task.value='adminUnpublishCompany';document.adminForm.submit();} return false;">Unpublish</a>
	&nbsp;|&nbsp;<a href="#" onClick="if(document.adminForm.boxchecked.value == 0){alert('Nothing selected, nothing to do.');}else{document.adminForm.task.value='adminDeleteCompany';document.adminForm.submit();} return false;">Delete</a>
</div>
	  
<table>
<tr>
	<td valign="middle">Published</td>
	<td width="right" valign="middle">
	<?php echo $lists['company_published_filter'];?>
	</td>
</tr>
</table>

<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
   <tr>
    <th width="20" style="text-align:left;" ><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($rows); ?>);" /></th>
    <th class="title" width="25%">Company Name</th>
	<th class="title" width="35%">Description</th>
    <th class="title" width="20%">Telephone</th>
    <th class="title" width="20%">Contact</th>
    <th class="title" width="5%">Published</th>
   </tr>
  <?php
    for($i=0; $i < count( $rows ); $i++) {
    $row = $rows[$i];
   ?>
    <tr class="row<?php echo ($i%2)-1; ?>">
     <td style="text-align:left;"><input type="checkbox" id="cb<?php echo $i;?>" name="id[]" value="<?php echo $row->id; ?>" onclick="isChecked(this.checked);" /></td>
     <td><a href="./index.php?option=com_timewriter&task=adminEditCompany&uid=<?php echo $row->id?>"><?php echo htmlspecialchars($row->company_name, ENT_QUOTES); ?></a></td>
	 <td><?php echo htmlspecialchars($row->description, ENT_QUOTES); ?></td>
     <td><?php echo htmlspecialchars($row->telephone, ENT_QUOTES); ?></td>
     <td><?php echo htmlspecialchars($row->contact_name, ENT_QUOTES); ?></td>
     <td style="text-align:center;">
      <?php if ($row->published) { ?>
         <a href="./index.php?option=com_timewriter&task=adminUnpublishCompany&id=<?php echo $row->id; ?>" ><img src="./components/com_timewriter/images/tick.png" border="0" /></a>
      <?php } else { ?>
         <a href="./index.php?option=com_timewriter&task=adminPublishCompany&id=<?php echo $row->id; ?>" ><img src="./components/com_timewriter/images/publish_x.png" border="0" /></a>
      <?php } ?>
     </td>
    </tr>
  <?php } ?>
</table>

  <?php
	HTML_timesheet_content::paginateList($pageNav, "./index.php?option=com_timewriter&task=adminShowCompanyList");
  ?>
    
  <input type="hidden" name="option" value="<?php echo $option; ?>" />
  <input type="hidden" name="task" value="adminShowCompanyList" />
  <input type="hidden" name="boxchecked" value="0" />
</div>
</form>
 <?php 
}

/******************************************************************************
 * 
******************************************************************************/
function adminEditCompany( $option, $row, &$lists ) {

	HTML_timesheet_content::printDateIncludes();
	HTML_timesheet_content::printStylesheetIncludes();
?>
  <script language="javascript" type="text/javascript">

    function validate() {
    var form = document.adminForm;
  	if(trim(form.company_name.value)==''){
  		alert("Company Name Is Required" );
  		return false;
  	}
  	if(trim(form.telephone.value)==''){
  		alert("Telephone Is Required" );
  		return false;
  	}
  	if(trim(form.contact_name.value)==''){
  		alert("Contact Name Is Required" );
  		return false;
  	}
  	if(trim(form.email.value)==''){
  		alert("Email Is Required" );
  		return false;
  	}
	return true;
    }
  </script>

<form action="index.php" method="POST" name="adminForm" >

<div class="content">
<?php echo HTML_timesheet_content::headerWithLinkToReportsMenu("Edit Company"); ?>	

<table border="0" cellpadding="3" cellspacing="2" class="adminform">
 <tr>
  <td>Company Name </td>
  <td><input type="text" size="50" maxsize="100" name="company_name" value="<?php echo htmlspecialchars($row->company_name, ENT_QUOTES); ?>" /></td>
  </tr>
 <tr>
  <td>General Contractor</td>
  <td colspan="3"><?php echo $lists['general_contractor_id']?></td>
  </tr>
  <tr>
  <td>Address </td>
  <td><textarea class="addressEdit" rows="2" cols="20" name="address" ><?php echo htmlspecialchars($row->address, ENT_QUOTES); ?></textarea></td>
 </tr>
 <tr>
  <tr>
  <td>Description </td>
  <td><textarea class="companyEdit" rows="5" cols="40" name="description" ><?php echo htmlspecialchars($row->description, ENT_QUOTES); ?></textarea></td>
 </tr>
 <tr>
  <td>Telephone </td>
  <td><input type="text" size="20" maxsize="20" name="telephone" value="<?php echo htmlspecialchars($row->telephone, ENT_QUOTES); ?>" /></td>
  </tr>
 <tr>
  <td>Contact Name </td>
  <td><input type="text" size="50" maxsize="100" name="contact_name" value="<?php echo htmlspecialchars($row->contact_name, ENT_QUOTES); ?>" /></td>
  </tr>
 <tr>
  <td>Email </td>
  <td><input type="text" size="50" maxsize="255" name="email" value="<?php echo htmlspecialchars($row->email, ENT_QUOTES); ?>" /></td>
  </tr>
 <tr>
 <tr>
  <td>Website </td>
  <td><input type="text" size="50" maxsize="255" name="website" value="<?php echo htmlspecialchars($row->website, ENT_QUOTES); ?>" /></td>
  </tr>
 <tr>
  <td>Tax Id </td>
  <td><input type="text" size="20" maxsize="25" name="vat_reg_no" value="<?php echo htmlspecialchars($row->vat_reg_no, ENT_QUOTES); ?>" /></td>
  </tr>
 <tr>
  <td>Company No </td>
  <td><input type="text" size="20" maxsize="25" name="company_no" value="<?php echo htmlspecialchars($row->company_no, ENT_QUOTES); ?>" /></td>
  </tr>
  <tr>
  <td>Published </td>
  <td>	<input type="radio" name="published" value="0" <?php if($row->published==0) echo("checked")?>/>No
	<input type="radio" name="published" value="1" <?php if($row->published==1) echo("checked")?>  />Yes</td>
 </tr>
</table>
<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
<input type="hidden" name="option" value="<?php echo $option; ?>" />
<input type="hidden" name="task" value="" />

<?php echo HTML_timesheet_content::printSubmitAndCancelButtons('adminSaveCompany', 'adminShowCompanyList', 'Save'); ?>

</div>
</form>
 <?php 
}


/*****************************************************************************
 *
*****************************************************************************/
function adminShowProjectList($option, $rows, $pageNav, $lists) {

	HTML_timesheet_content::printDateIncludes();
	HTML_timesheet_content::printStylesheetIncludes();
?>

<script language="javascript" type="text/javascript">
function doDelete() {
	if (document.adminForm.boxchecked.value == 0){
		alert('Nothing selected, nothing to do.');
	} else {
		if (confirm('Are you sure you want to delete the selected Projects?')) {
			document.adminForm.task.value='adminDeleteProject';
			document.adminForm.submit();
		}
	}
}
</script>
<form action="index.php" method="post" name="adminForm">
<div class="content">
<?php 
	HTML_timesheet_content::headerWithLinkToReportsMenu("Manage Projects"); 	
?>
<div style="text-align:right;">
	<a href="#" onClick="document.adminForm.task.value='adminNewProject'; document.adminForm.submit(); return false;">New</a>
	&nbsp;|&nbsp;<a href="#" onClick="if(document.adminForm.boxchecked.value == 0){alert('Nothing selected, nothing to do.');}else{document.adminForm.task.value='adminPublishProject';document.adminForm.submit();} return false;">Publish</a>
	&nbsp;|&nbsp;<a href="#" onClick="if(document.adminForm.boxchecked.value == 0){alert('Nothing selected, nothing to do.');}else{document.adminForm.task.value='adminUnpublishProject';document.adminForm.submit();}; return false;">Unpublish</a>
	&nbsp;|&nbsp;<a href="#" onClick="doDelete(); return false;">Delete</a>
	&nbsp;
</div>

<table>
<tr>
	<td valign="middle">Company</td>
	<td width="right" valign="middle">
	<?php echo $lists['project_company_filter'];?>
	</td>
	<td valign="middle">Published</td>
	<td width="right" valign="middle">
	<?php echo $lists['project_published_filter'];?>
	</td>
</tr>
</table>

  <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
   <tr>
    <th width="20" style="text-align:left;"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($rows); ?>);" /></th>
    <th class="title" width="30%">Project Name</th>
    <th class="title" width="30%">Company</th>
    <th class="title" width="10%">Start Date</th>
    <th class="title" width="10%">End Date</th>
	<th class="title" width="10%">Summary<a href="#" title="Assigned Users - Published Users - Project Managers">?</a></th>
    <th class="title" style="text-align:center;" width="5%">Assign</th>
    <th class="title" style="text-align:center;" width="5%">Published</th>
   </tr>
  <?php
    for($i=0; $i < count( $rows ); $i++) {
    $row = $rows[$i];
   ?>
    <tr class="row<?php echo ($i%2)-1; ?>">
     <td style="text-align:left;"><input type="checkbox" id="cb<?php echo $i;?>" name="id[]" value="<?php echo $row->id; ?>" onclick="isChecked(this.checked);" /></td>
     <td><a href="./index.php?option=com_timewriter&task=adminEditProject&uid=<?php echo $row->id?>"><?php echo htmlspecialchars($row->project_name, ENT_QUOTES); ?></a></td>
     <td><?php echo htmlspecialchars($row->company_name, ENT_QUOTES); ?></td>
     <td><?php echo $row->start_date; ?></td>
     <td><?php echo $row->end_date; ?></td>
	 <td style="text-align:center;"><?php echo ($row->ttl?$row->ttl:0) . "&nbsp;" . ($row->pubs?$row->pubs:0) . "&nbsp;" . ($row->mgrs?$row->mgrs:0); ?></td>
     <td style="text-align:center;"> 
		<a href="./index.php?option=com_timewriter&task=adminShowProjectUserList&uid=<?php echo $row->id?>&limitstart=0"><img src="./components/com_timewriter/images/users.png" border="0" /></a>
	 </td>
     <td style="text-align:center;">
      <?php if ($row->published) { ?>
         <a href="./index.php?option=com_timewriter&task=adminUnpublishProject&id=<?php echo $row->id; ?>" ><img src="./components/com_timewriter/images/tick.png" border="0" /></a>
      <?php } else { ?>
         <a href="./index.php?option=com_timewriter&task=adminPublishProject&id=<?php echo $row->id; ?>" ><img src="./components/com_timewriter/images/publish_x.png" border="0" /></a>
      <?php } ?>
     </td>
    </tr>
  <?php } ?>
  
  </table>
  <?php
	HTML_timesheet_content::paginateList($pageNav, "./index.php?option=com_timewriter&task=adminShowProjectList");
  ?>

  <input type="hidden" name="option" value="<?php echo $option; ?>" />
  <input type="hidden" name="task" value="adminShowProjectList" />
  <input type="hidden" name="boxchecked" value="0" />
</div>
</form>
 <?php 
 }

/******************************************************************************
 * 
******************************************************************************/
function adminEditProject( $option, &$row, &$lists) {

	HTML_timesheet_content::printDateIncludes();
	HTML_timesheet_content::printStylesheetIncludes();

	HTML_Timesheet::printAdminHeading("Project", "Edit");
?>
  <script language="javascript" type="text/javascript">

    function validate() {
    var form = document.adminForm;
  	if(trim(form.project_name.value)==''){
  		alert("Project Name Is Required" );
  		return false;
  	}
  	if(trim(form.description.value)==''){
  		alert("Project Description Is Required" );
  		return false;
  	}
  	if(trim(form.company_id.value)=='0'){
  		alert("Company Is Required" );
  		return false;
  	}
  	if(trim(form.start_date.value)==''){
  		alert("Start Date Is Required" );
  		return false;
  	}
  	if(trim(form.end_date.value)==''){
  		form.end_date.value='9999-12-31'
  	}
    return true;
    }
	
window.addEvent('domready', function() {Calendar.setup({
        inputField     :    "start_date",     // id of the input field
        ifFormat       :    "%Y-%m-%d",      // format of the input field
        button         :    "start_date_img",  // trigger for the calendar (button ID)
        align          :    "Tl",           // alignment (defaults to "Bl")
        singleClick    :    true
    });});
window.addEvent('domready', function() {Calendar.setup({
        inputField     :    "end_date",     // id of the input field
        ifFormat       :    "%Y-%m-%d",      // format of the input field
        button         :    "end_date_img",  // trigger for the calendar (button ID)
        align          :    "Tl",           // alignment (defaults to "Bl")
        singleClick    :    true
    });});

  </script>
  
  

<form action="index.php" method="post" name="adminForm" >

<div class="content">
<table border="0" cellpadding="3" cellspacing="0" class="adminform">
 <tr>
  <td>Project Name </td>
  <td><input type="text" size="50" maxsize="100" name="project_name" value="<?php echo htmlspecialchars($row->project_name, ENT_QUOTES); ?>" /></td>
  </tr>
  <tr>
  <td>Description </td>
  <td><textarea class="projectEdit" name="description" ><?php echo htmlspecialchars($row->description, ENT_QUOTES); ?></textarea></td>
 </tr>
 <tr>
  <td>Company </td>
  <td><?php echo $lists['company_id']?></td>
  </tr>
 <tr>
  <td>Start Date </td>
  <td>
	<input type="text" name="start_date" id="start_date" size="25" maxlength="19" value="<?php echo htmlspecialchars($row->start_date, ENT_QUOTES); ?>" class="inputbox" />
	<img class="calendar" src="./templates/system/images/calendar.png" alt="calendar" id="start_date_img" />
  </td>
  </tr>
    <tr>
  <td>End Date </td>
  <td>
	<input type="text" name="end_date" id="end_date" size="25" maxlength="19" value="<?php echo htmlspecialchars($row->end_date, ENT_QUOTES); ?>" class="inputbox" />
	<img class="calendar" src="./templates/system/images/calendar.png" alt="calendar" id="end_date_img" />
  </td>
  </tr>
  <tr>
  <td>Rate/hour (in Euro) </td>
  <td><input type="text" size="50" maxsize="100" name="rate_hour" value="<?php echo htmlspecialchars($row->rate_hour, ENT_QUOTES); ?>" /></td>
  </tr>
  <tr>
  <td>Hours/day </td>
  <td><input type="text" size="50" maxsize="100" name="hours_day" value="<?php echo htmlspecialchars($row->hours_day, ENT_QUOTES); ?>" /></td>
  </tr>
  <tr>
  <td>Published </td>
  <td>	<input type="radio" name="published" value="0" <?php if($row->published==0) echo("checked")?>/>No
	<input type="radio" name="published" value="1" <?php if($row->published==1) echo("checked")?>  />Yes</td>
 </tr>
</table>
<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
<input type="hidden" name="option" value="<?php echo $option; ?>" />
<input type="hidden" name="task" value="" />

<?php echo HTML_timesheet_content::printSubmitAndCancelButtons('adminSaveProject', 'adminShowProjectList', 'Save'); ?>
</div>
</form>

<?php
}


/*****************************************************************************
 *
*****************************************************************************/
function adminShowProjectUserList( $option, $rows , $pageNav, $project, $users) {
	global $mosConfig_live_site;

	HTML_timesheet_content::printStylesheetIncludes();
 ?>
 <script type="text/javascript">
 function addUsers() {	
	var count = 0;
	var selObj = document.adminForm.elements['user_ids[]'];
	for (var i = 0; i < selObj.options.length; i++) {
		if (selObj.options[i].selected) {
			count++;
		}
	}
	if (count == 0) {
		alert("Select the users you would like to add to this project.");
		return;
	}
	document.adminForm.task.value = "adminAddProjectUsers";
	document.adminForm.submit();
 }
 
 function deleteUsers() {
	if (document.adminForm.boxchecked.value == 0) {
		alert('Please make a selection from the list to delete'); 
	} else if (confirm('Are you sure you want to delete selected items?')) {
		document.adminForm.task.value = 'adminDeleteProjectUser'; 
		document.adminForm.submit(); 
	}
	return false; 
 }

 function toggleUsers(promote) {
	var promoteText = (promote == 1?'promote':'demote');
	if (document.adminForm.boxchecked.value == 0) {
		alert('Please make a selection from the list to ' + promoteText + '.'); 
	} else {
		if (promote == 1) {
			document.adminForm.task.value = 'adminPromoteProjectUserManager'; 
		} else {
			document.adminForm.task.value = 'adminDemoteProjectUserManager'; 
		}
		document.adminForm.submit(); 
	}
	return false; 
 }

 function publishUsers(promote) {
	var promoteText = (promote == 1?'publish':'unpublish');
	if (document.adminForm.boxchecked.value == 0) {
		alert('Please make a selection from the list to ' + promoteText + '.'); 
	} else {
		if (promote == 1) {
			document.adminForm.task.value = 'adminPublishProjectUser'; 
		} else {
			document.adminForm.task.value = 'adminUnpublishProjectUser'; 
		}
		document.adminForm.submit(); 
	}
	return false; 
 }
 
 </script>
<form action="index.php" method="post" name="adminForm">
<div class="content">
<?php 
	HTML_timesheet_content::headerWithLinkToReportsMenu("Manage Project Users - " . htmlspecialchars($project->project_name, ENT_QUOTES)); 	
?>
<div style="text-align:right;">
	<a href="index.php?option=com_timewriter&task=adminShowProjectList&limitstart=0">Manage Projects</a>&nbsp;|&nbsp;
	<a href="#" onClick="deleteUsers(); return false;">Delete</a>&nbsp;|&nbsp;
	<a href="#" onClick="toggleUsers(1); return false;">Promote PM</a>&nbsp;|&nbsp;
	<a href="#" onClick="toggleUsers(0); return false;">Demote PM</a>&nbsp;|&nbsp;
	<a href="#" onClick="publishUsers(1); return false;">Publish</a>&nbsp;|&nbsp;
	<a href="#" onClick="publishUsers(0); return false;">Unpublish</a>
	&nbsp;
</div>
 
<table border="0" width="100%">
<tr><td valign="top">
  <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
   <tr>
    <th width="20" style="text-align:left;"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($rows); ?>);" /></th>
    <th class="title" width="40%">User Name</th>
    <th class="title" width="30%" style="text-align:center;">Project Manager</th>
    <th class="title" width="30%" style="text-align:center;">Published</th>
   </tr>
  <?php
    for($i=0; $i < count( $rows ); $i++) {
    $row = $rows[$i];
   ?>
    <tr class="row<?php echo ($i%2)-1; ?>">	
     <td style="text-align:left;"><input type="checkbox" id="cb<?php echo $i;?>" name="id[]" value="<?php echo $row->id; ?>" onclick="isChecked(this.checked);" /></td>
     <td><?php echo $row->name; ?></td>
     <td style="text-align:center;">
      <?php
       if ($row->is_project_mgr) {
         echo '<a href="./index.php?option=com_timewriter&task=adminDemoteProjectUserManager&id=' . $row->id . '&uid=' . $project->id . '" ><img src="./components/com_timewriter/images/tick.png" border="0" />';
       } else {
         echo '<a href="./index.php?option=com_timewriter&task=adminPromoteProjectUserManager&id=' . $row->id . '&uid=' . $project->id . '" ><img src="./components/com_timewriter/images/publish_x.png" border="0" />';
       }
      ?>
     </td>
     <td style="text-align:center;">
      <?php
       if ($row->published) {
         echo '<a href="./index.php?option=com_timewriter&task=adminUnpublishProjectUser&id=' . $row->id . '&uid=' . $project->id . '" ><img src="./components/com_timewriter/images/tick.png" border="0" />';
       } else {
         echo '<a href="./index.php?option=com_timewriter&task=adminPublishProjectUser&id=' . $row->id . '&uid=' . $project->id . '" ><img src="./components/com_timewriter/images/publish_x.png" border="0" />';
       }
      ?>
     </td>
    </tr>
  <?php } ?>	
  </table>
</td>
<td width="10%" style="text-align:center;vertical-align:top;">
    <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
		<tr><th class="title">Unassigned Users</th></tr>
		<tr><td>
		  <select name="user_ids[]" multiple size="15" WIDTH="200" STYLE="width:200px;">
		  <?php
		    if (count( $users ) == 0) {
				echo '<option value="-1" selected>(None)</option>';
			} else {
			    for($i=0; $i < count( $users ); $i++) {
				    $row = $users[$i];
					echo '<option value="' . $row->id . '">'.$row->name.' (' . $row->username . ')</option> \n';
				} 
			}
		  ?>
		  </select>
		</td></tr>
		<tr><td style="text-align:center;">
		  <input type="button" value="Add" class="button" onclick="addUsers();">
		</td></tr>
	</table>
</td></tr>
<tr>
	<td colspan="2">
	  
	  <?php    
		HTML_timesheet_content::paginateList($pageNav, "./index.php?option=com_timewriter&task=adminShowProjectUserList&uid=" . $project->id);
	  ?>
	</td>
</tr>
</table>

</div>
  <input type="hidden" name="option" value="<?php echo $option; ?>" />
  <input type="hidden" name="task" value="adminShowProjectUserList" />
  <input type="hidden" name="boxchecked" value="0" />
  <input type="hidden" name="uid" value="<?php echo $project->id; ?>" />
</form>
<?php
}

/*****************************************************************************
 *
*****************************************************************************/
function showReportMenu($option, $fordate, $admin=0, $isProjectManager=0){
?>
	<div class="content">
	<?php echo HTML_timesheet_content::headerWithLinkToCalendar("Timesheet Report Menu", $fordate); ?>
	<table width="100%">
			<tr><td style="height:20px;">&nbsp;</td></tr>    
			<tr><td width="20%">&nbsp;</td><td>
	<?php echo HTML_timesheet_content::headerWithoutLink("Reports"); ?>
		<ul>
			<li><a title="Timesheet Report by Company" style="text-decoration:none;" href="./index.php?option=com_timewriter&task=showTimesheetReportByCompanyCriteria&fordate=<?php echo $fordate;?>">Timesheet Report by Company</a></li>
			<li><a title="Timesheet Report by Project" style="text-decoration:none;" href="./index.php?option=com_timewriter&task=showTimesheetReportByProjectCriteria&fordate=<?php echo $fordate;?>">Timesheet Report by Project</a></li>
			<li><a title="Total Hours by Project" style="text-decoration:none" href="./index.php?option=com_timewriter&task=showTotalHoursPerProjectCriteria&fordate=<?php echo $fordate;?>">Total Hours by Project</a></li>
			<li><a title="Total Mileage" style="text-decoration:none;" href="./index.php?option=com_timewriter&task=showTotalMileageCriteria&fordate=<?php echo $fordate;?>">Total Mileage</a></li>
			<li><a title="Flex-time Report by Company" style="text-decoration:none;" href="./index.php?option=com_timewriter&task=showFlextimeReportByCompanyCriteria&fordate=<?php echo $fordate;?>">Flex-time Report by Company</a></li>
		</ul>
		<br />
		<br />
	<?php 
	/* Multi user block disabled
	if ($isProjectManager) {
		echo HTML_timesheet_content::headerWithoutLink("Multi-User Reports"); 


		// <li><a title="Multi-User Timesheet by Company" style="text-decoration:none" href="./index.php?option=com_timewriter&task=showUserPreferences&fordate=xxx">Multi-User Timesheet by Company</a></li>
		?>
		<ul>
			<li><a title="Multi-User Total Hours by Project" style="text-decoration:none" href="./index.php?option=com_timewriter&task=multiUserTotalHoursPerProjectCriteria&fordate=<?php echo $fordate;?>">Multi-User Total Hours by Project</a></li>
			<li><a title="Multi-User Weekly Report by Company" style="text-decoration:none;" href="./index.php?option=com_timewriter&task=multiUserWeeklyReportByCompanyCriteria&fordate=<?php echo $fordate;?>">Multi-User Weekly Report by Company</a></li>
			<li><a title="Multi-User Total Mileage" style="text-decoration:none;" href="./index.php?option=com_timewriter&task=multiUserTotalMileageCriteria&fordate=<?php echo $fordate;?>">Multi-User Total Mileage</a></li>
		</ul>
		<br />
		<br />		
	<?php 
	}
	*/
		echo HTML_timesheet_content::headerWithoutLink("Options"); 
	?>
		<ul>
			<li><a title="User Preferences" style="text-decoration:none" href="./index.php?option=com_timewriter&task=showUserPreferencesCriteria">User Preferences</a></li>
			<li><a title="Vehicles" style="text-decoration:none" href="./index.php?option=com_timewriter&task=showVehicles&fordate=<?php echo $fordate;?>">Show Vehicles</a></li>
			<li><a title="Mileage Log Form" style="text-decoration:none" href="#" onClick="window.open('./index2.php?option=com_timewriter&amp;task=showMileageLogForm', 'win2', 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=yes,resizable=yes,width=640,height=480,directories=no,location=no'); return false;">Mileage Log Form</a></li>						
		</ul>
		<br />
		<br />
	<?php 
	if ($admin) {
		echo HTML_timesheet_content::headerWithoutLink("Timesheet Administrator"); 
	?>
		<ul>
			<li><a title="Manage Companies" style="text-decoration:none" href="./index.php?option=com_timewriter&task=adminShowCompanyList&limitstart=0">Manage Companies</a></li>
			<li><a title="Manage Projects" style="text-decoration:none" href="./index.php?option=com_timewriter&task=adminShowProjectList&limitstart=0">Manage Projects</a></li>
		</ul>
		<br />
		<br />
	<?php 
	}
	?>
		</td></tr>
		<tr><td style="height:20px;">&nbsp;</td></tr>
	</table>
	</div>
	
<?php 
	echo HTML_timesheet::copyrightFooter(); 
}


/*****************************************************************************
 *  Print the pagination elements
*****************************************************************************/
function paginateList($pageNav, $link) {
?>
  <table cellpadding="4" cellspacing="2" border="0" class="adminlist">
    <tr>
      <td  style="text-align:center;" colspan="3"> <?php echo $pageNav->writePagesLinks($link); ?></td>
    </tr>
    <tr>
      <td style="text-align:right;" width="48%">Display #</td>
      <td> <?php echo $pageNav->writeLimitBox($link); ?> </td>
      <td width="48%"><?php echo $pageNav->writePagesCounter($link)."\n"; ?></td>
    </tr>
  </table>
<?php
}


/*****************************************************************************
 *
*****************************************************************************/
function headerWithoutLink($headertext, $arbitrary=null){
?>
	<table border="0" width="100%" cellpadding="0" cellspacing="0">
		<tr><td class="componentheading" style="padding-left:2px;"><?php echo $headertext;?></td>
		<td class="componentheading" style="text-align:right;padding-right:2px;" ><?php echo $arbitrary;?></td></tr>
	</table>
	<br />
<?php
}

/*****************************************************************************
 *
*****************************************************************************/
function headerWithLinkToCalendar($headertext, $fordate){
	$link = '<a title="Timesheet Calendar" style="text-decoration:none" href="./index.php?option=com_timewriter&fordate='
		.$fordate
		.'">'._OC_CALENDAR.'</a>';
	HTML_timesheet_content::headerWithoutLink($headertext, $link);
}

/*****************************************************************************
 *
*****************************************************************************/
function headerWithLinkToReportsMenu($headertext, $fordate=null){
	$link = '<a title="Timesheet Report Menu" href="./index.php?option=com_timewriter&task=showReportMenu&fordate='
		.$fordate
		.'">Timesheet Menu</a>';
	HTML_timesheet_content::headerWithoutLink($headertext, $link);
}

/*****************************************************************************
 *
*****************************************************************************/
function includeDontPrintStyle(){
?>
<style>
@media print {
   div.dontprint {
     display:none;
   }
}
</style>
<?php
}

// Class closing bracket
}
?>