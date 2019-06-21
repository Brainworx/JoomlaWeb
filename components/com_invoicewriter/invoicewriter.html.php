<?php
/**
* Brainworx invoicewriter Component
* @package invoicewriter
* @copyright (C) 2007 Brainworx / All rights reserved
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @link http://www.Brainworx.com
*
* Based on the Mambotastic invoicewriters Component
* @copyright (C) 2005 Mark Stewart / All Rights Reserved
* @Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
* @author Mark Stewart / Mambotastic
**/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

require_once dirname(__FILE__) . '/../../administrator/components/com_invoicewriter/admin.invoicewriter.html.php';

global $mosConfig_live_site;
define("_CMN_PRINT","Print");

/**
* Utility class for writing the HTML for content
* @package Mambo
* @subpackage Content
*/

class HTML_invoicewriter_content {

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
function headerWithLinkToMainMenu($headertext, $fordate=null){
	$link = '<a title="invoicewriter Report Menu" href="./index.php?option=com_invoicewriter&task=mainDisplay">invoicewriter Menu</a>';
	HTML_invoicewriter_content::headerWithoutLink($headertext, $link);
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
	<link rel="stylesheet" type="text/css" href="./components/com_invoicewriter/images/invoicewriter.css" />
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
	 <input type="button" class="button" name="submitCancel" value="<?php echo $cancelButtonText; ?>" onclick="document.adminForm.task.value='<?php echo $cancelTarget; ?>'; document.adminForm.submit();return false;"> 
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
 * The first page loaded
*****************************************************************************/
function mainDisplay($option,$isadmin=0,$name){

	HTML_invoicewriter_content::printStylesheetIncludes();
	?>
<div class="content">
	<div style="text-align:right;text-decoration:underline">User <?php echo $name; ?></div>
<table width="100%" >
<tr><td style="vertical-align:top" width="50%">
	<table width="100%" >
		<tr><td style="height:20px;">&nbsp;</td></tr>    
		<tr>
			<td width="20%">&nbsp;</td>
			<td>
			<?php echo HTML_invoicewriter_content::headerWithoutLink("Incoming"); ?>
			<ul>
				<li><a title="Invoice Overview" style="text-decoration:none;" href="./index.php?option=com_invoicewriter&task=showIncomingInvoices">Incoming Invoices</a></li>
				<li><a title="Invoice Invoice" style="text-decoration:none;" href="./index.php?option=com_invoicewriter&task=newIncomingInvoiceByCompanyCriteria">New Incoming Invoices by Company</a></li>
				<li><a title="Invoice Invoice" style="text-decoration:none;" href="./index.php?option=com_invoicewriter&task=newIncomingInvoice">New Incoming Invoices manuel entry</a></li>
			</ul>
			<ul>
				<li><a title="Invoice Overview" style="text-decoration:none;" href="./index.php?option=com_invoicewriter&task=showInvests">Investments</a></li>
			</ul>
		</td></tr>
		<tr><td style="height:10px;">&nbsp;</td></tr>
		<tr>
			<td width="20%">&nbsp;</td>
			<td>
			<?php echo HTML_invoicewriter_content::headerWithoutLink("Expenses"); ?>
			<ul>
				<li><a title="Expense Overview" style="text-decoration:none;" href="./index.php?option=com_invoicewriter&task=showExpenses">Expenses Overview</a></li>
				<li><a title="Salary Overview" style="text-decoration:none;" href="./index.php?option=com_invoicewriter&task=showSalaries">Salary Overview</a></li>
				<li><a title="Tax Overview" style="text-decoration:none;" href="./index.php?option=com_invoicewriter&task=showTax">Tax Overview</a></li>
		
			</ul>
		</td></tr>
	</table>
	</td>
	<td style="vertical-align:top" width="50%">

	<table width="100%" >
		<tr><td style="height:20px;">&nbsp;</td></tr> 
		<tr>
			<td width="20%">&nbsp;</td>
			<td>
			<?php echo HTML_invoicewriter_content::headerWithoutLink("Report"); ?>
			<ul>
				<li><a title="Financial Overview" style="text-decoration:none;" href="./index.php?option=com_invoicewriter&task=showFinancialReportCriteria">Financial report</a></li>
		
			</ul>
		</td></tr>
		<tr><td style="height:10px;">&nbsp;</td></tr>
		<?php if($isadmin){ ?>
		<tr>
			<td width="20%">&nbsp;</td>
			<td>
			<?php echo HTML_invoicewriter_content::headerWithoutLink("Administator"); ?>
			<ul>
				<li><a title="User Overview" style="text-decoration:none;" href="./index.php?option=com_invoicewriter&task=showUsers">Manage Users</a></li>
				<li><a title="Staff Overview" style="text-decoration:none;" href="./index.php?option=com_invoicewriter&task=showStaff">Manage Staff</a></li>
			</ul><ul>
				<li><a title="Expense Type Overview" style="text-decoration:none;" href="./index.php?option=com_invoicewriter&task=showExpenseTypes">Manage Expense Type</a></li>
				<li><a title="Tax Type Overview" style="text-decoration:none;" href="./index.php?option=com_invoicewriter&task=showTaxTypes">Manage Tax Type</a></li>
			</ul><ul>
				<li><a title="Supplier Overview" style="text-decoration:none;" href="./index.php?option=com_invoicewriter&task=showSuppliers">Manage Supplier</a></li>
			</ul><ul>
				<li><a title="Company Overview" style="text-decoration:none;" href="./index.php?option=com_timewriter&task=adminShowCompanyList">TimeSheet Manage Company</a></li>
				<li><a title="Project Overview" style="text-decoration:none;" href="./index.php?option=com_timewriter&task=adminShowProjectList">TimeSheet Manage Project</a></li>
			</ul>
			<br />
			<br />
		</td></tr>
		<?php } ?>
	</table>
	</td></tr></table>
</div>
	
<?php 
	echo HTML_invoicewriter::copyrightFooter(); 
}
/*****************************************************************************
* 
******************************************************************************/
function newIncomingInvoiceByCompanyCriteria($option,$startdate,$enddate,$fordate, $lists){

HTML_invoicewriter_content::printDateIncludes();
HTML_invoicewriter_content::printStylesheetIncludes();
?>
  <script language="javascript" type="text/javascript">
    function validate() {
		if(trim(document.adminForm.start_date.value)==''){
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
        inputField     :    "for_date",     // id of the input field
        ifFormat       :    "%Y-%m-%d",      // format of the input field
        button         :    "for_date_img",  // trigger for the calendar (button ID)
        align          :    "Tl",           // alignment (defaults to "Bl")
        singleClick    :    true
    });});
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

	<form action="index.php" method="POST" name="adminForm" >

		<div class="content">
			<?php echo HTML_invoicewriter_content::headerWithLinkToMainMenu("New Invoice by Company", $startdate); ?>

			<table border="0" cellpadding="3" cellspacing="0" class="adminform">
				<tr>
				  <td>Invoice Date </td>
				  <td>
					<input type="text" name="for_date" id="for_date" size="25" maxlength="19" value="<?php if($fordate=='')echo date("Y-m-d"); else echo htmlspecialchars($fordate, ENT_QUOTES); ?>" class="inputbox" />
					<img class="calendar" src="./templates/system/images/calendar.png" alt="calendar" id="for_date_img" />
				  </td>
				 </tr>	
				<tr>
				  <td>Company</td>
				  <td><?php echo $lists['company_id']?></td>
				 </tr>
				 <tr>
				  <td>Start Date </td>
				  <td>
					<input type="text" name="start_date" id="start_date" size="25" maxlength="19" value="<?php echo htmlspecialchars($startdate, ENT_QUOTES); ?>" class="inputbox" />
					<img class="calendar" src="./templates/system/images/calendar.png" alt="calendar" id="start_date_img" />
				  </td>
				 </tr>
				 <tr>
				  <td>End Date </td>
				  <td>
					<input type="text" name="end_date" id="end_date" size="25" maxlength="19" value="<?php echo htmlspecialchars($enddate, ENT_QUOTES); ?>" class="inputbox" />
					<img class="calendar" src="./templates/system/images/calendar.png" alt="calendar" id="end_date_img" />
				  </td>
				 </tr>
			 </table>

			<table width="100%">
				<tr>
					<td width="98%">&nbsp;</td>
				<td>
					<input type="button" class="button" name="submitRun" value="Create Invoice" onclick="document.adminForm.task.value='newIncomingInvoiceByCompany'; if(validate()) document.adminForm.submit(); return false;">
				</td>
				<td width="1%">
					<input type="button" class="button" name="submitCancel" value="Cancel" onclick="document.adminForm.task.value='mainDisplay'; document.adminForm.submit();return false;"> 
				</td>
				</tr>
			</table>

		</div>

		<input type="hidden" name="option" value="com_invoicewriter" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="startdate" value="<?php echo $startdate;?>" />
		<input type="hidden" name="enddate" value="<?php echo $enddate;?>" />

	</form>
 <?php
 }
/*****************************************************************************
* Display a printable invoice
******************************************************************************/
function showIncomingInvoiceByCompany($option,$row,$invoicelines,$company,$pop=0){

global $database,$mosConfig_live_site;	
HTML_invoicewriter_content::includeDontPrintStyle(); 
HTML_invoicewriter_content::printDateIncludes();
HTML_invoicewriter_content::printStylesheetIncludes();

?>
<div class="content">
<?php if($pop == 0) HTML_invoicewriter_content::headerWithLinkToMainMenu("Invoice", 0); ?>	
<table border="0" cellpadding="3" cellspacing="3" class="adminform" width="100%">
<?php if($pop == 0){?>
	<tr><td>&nbsp;</td><td  class="buttonheading" align="right"><a href="#" onclick="window.open('<?php echo $mosConfig_live_site; ?>/index2.php?option=com_invoicewriter&amp;task=showIncomingInvoice&amp;iid=<?php echo($row->id); ?>&amp;pop=1','win2', 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=yes,resizable=yes,width=640,height=480,directories=no,location=no'); return false;" title="<?php echo _CMN_PRINT;?>">Print</a>&nbsp;</td>
	
	<?php if($row->period_start != "0000-00-00" && $row->period_end != "0000-00-00"){ ?>
	<td  class="buttonheading" align="right"><a href="#" onclick="window.open('<?php echo $mosConfig_live_site; ?>/index2.php?option=com_timewriter&amp;task=showProjectReportByCompany&amp;current_date=<?php echo $row->period_start;?>&amp;end_date=<?php echo $row->period_end;?>&amp;company_id=<?php echo $company->id;?>&amp;is_billable=1&amp;pop=1', 'win2', 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=yes,resizable=yes,width=640,height=480,directories=no,location=no'); return false;" title="<?php echo _CMN_PRINT;?>">TimeSheet</a>&nbsp;</td>
<?php } else { ?>
		    <td  class="buttonheading" align="right"><div class="dontprint"><a href="#" onclick="window.print(); return false;" title="<?php echo _CMN_PRINT;?>"><img
		    			src="<?php echo $mosConfig_live_site;?>/images/M_images/printButton.png" border="0" alt="<?php echo _CMN_PRINT;?>" /></a></div>&nbsp;</td>				
<?php } ?>
</tr>
<?php }?>
<?php if($pop==1){?>
<tr><td>&nbsp;</td></tr>
<tr><td>
		<table border="0" cellpadding="3" cellspacing="3" class="adminform" width="100%">
			<tr>
			  <td style="text-align:left"><img src="./components/com_invoicewriter/images/BW.gif"/> </td>

			  <td  style="text-align:right">
				<table border="0" cellpadding="3" cellspacing="3" class="adminform">
				<tr><td>BrainWorX bvba</td></tr>
				<tr><td>BTW BE 0820.393.336</td></tr>
				<tr><td>RPR TURNHOUT</td></tr>
				<tr><td>Wimpstraat 9, 2260 Westerlo</td></tr>
				<tr><td>0032(0)14/54.21.96</td></tr>
				<tr><td>info@brainworx.be</td></tr>
				</table>
			  </td>
			</tr>
		</table>
</td></tr>
<tr><td style="border-bottom:1px solid #0f0;text-align:right;text-decoration:bold;">FACTUUR | INVOICE&nbsp;</td></tr>
<tr><td>&nbsp;</td></tr>
<?php } ?>
<tr>
	<td>
		<table border="0" cellpadding="3" cellspacing="0" class="adminform" width="100%">
			 <tr>
			  <td>Nummer: </td>
			  <td><?php echo htmlspecialchars($row->iv_id, ENT_QUOTES); ?></td>
			  <td width="10%"/>
			  <td>IBAN: </td>
			  <td>BE75 7310 0656 4851</td>
			 </tr>
			  <tr>
			  <td>Factuurdatum: </td>
			  <td><?php echo htmlspecialchars($row->date, ENT_QUOTES); ?></td>
			   <td width="10%"/>
			  <td>BIC: </td>
			  <td>KREDBEBB
			  </td>
			 </tr>
			  <tr>
			  <td>Vervaldatum: </td>
			  <td><?php echo htmlspecialchars($row->due_date, ENT_QUOTES); ?> </td>
			   <td width="10%"/>
			   <td>ID/OGM: </td>
			  <td>
				<?php echo htmlspecialchars($row->ogm, ENT_QUOTES); ?>
			  </td>
			 </tr>
			 <tr><td>&nbsp;</td></tr>
		</table>
	</td>
</tr>
<tr ><td style="border-bottom:1px solid #0f0;">&nbsp;</td></tr>
<tr><td>&nbsp;</td></tr>
<tr>
	<td>
		<table border="0" cellpadding="3" cellspacing="5" class="adminform" >
			<tr>
			  <td>Klant: </td>
			  <td><?php echo $company->company_name;?></td>
			 </tr>
			  <tr>
			  <td>&nbsp;</td>
			  <td width="200px"><?php echo $company->address;?></td>
			 </tr>
			 <tr>
			  <td>&nbsp;</td>
			  <td>BTW <?php echo $company->vat_reg_no;?></td>
			 </tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
			  <td style="vertical-align:top">Omschrijving: </td>
			  <td width="400px"><?php echo $row->description;?></td>
			 </tr>
			 <?php if($row->period_start != "0000-00-00"){ ?>
				 <tr><td colspan="2">&nbsp;</td></tr>
				 <tr>
				  <td>Periode: </td>
				  <td>
					<?php echo htmlspecialchars($row->period_start, ENT_QUOTES);?> tot <?php if($row->period_end == "0000-00-00")echo ""; else echo htmlspecialchars($row->period_end, ENT_QUOTES); ?>
				 </td>
				 </tr>
			 <?php } ?>
		</table>
	 </td>
</tr>
<tr><td style="border-bottom:1px solid #0f0;">&nbsp;</td></tr>
<tr ><td >&nbsp;</td></tr>
<tr>
	<td >
 <?php 
 if(! empty($invoicelines)){
// if(count($invoicelines) > 0){ 
?>
	<table cellpadding="4" cellspacing="0" border="0" class="adminlist">
		   <tr>
			<th style="text-align:left"class="title" width="40%">Omschrijving</th>
			<th style="text-align:center"class="title" width="10%">Hoeveelheid</th>
			<th style="text-align:center"class="title" width="10%">Eenheid</th>
			<th style="text-align:center"class="title" width="20%">Prijs/eenheid</th>
			<th style="text-align:right"class="title" width="20%">Totaal</th>
		   </tr>


		<?php
		for($i=0;$i<count($invoicelines);$i++){ 
		?>
		
			<tr>
			 <td style="text-align:left"><?php echo htmlspecialchars($invoicelines[$i]->description,ENT_QUOTES); ?></td>
			 <td style="text-align:center"><?php  echo htmlspecialchars( $invoicelines[$i]->quantity,ENT_QUOTES); ?></td>
			 <td style="text-align:center"><?php  echo htmlspecialchars( $invoicelines[$i]->unit,ENT_QUOTES);?></td>
			 <td style="text-align:center"><?php  echo htmlspecialchars( round($invoicelines[$i]->amount_unit,2),ENT_QUOTES); echo " ".$row->currency;?></td>
			 <td style="text-align:right"><?php  echo htmlspecialchars( round($invoicelines[$i]->total_amount,2),ENT_QUOTES); echo " ".$row->currency;?></td>
			</tr>

		<?php }?>
			</table>
 <?php }?>
	</td>
</tr>
<tr><td>&nbsp;</td></tr>
<tr><td>&nbsp;</td></tr>
<tr>
	<td >
		<table border="0" cellpadding="4" cellspacing="0" class="adminform" width="100%"> 
			<tr><td width="60%">&nbsp;</td>
			<td width="40%" style="text-align:right">
				<table border="1" cellpadding="4" cellspacing="0" class="adminform" width="100%"> 
					 <tr>
					  <td width="20%" class="title">Bedrag / Amount </td>
					  <td width="20%"><?php echo htmlspecialchars(round($row->amount,2),ENT_QUOTES); echo " ".$row->currency;?></td>
					 </tr>
					 <tr>
					  <td width="20%" class="title">BTW <?php echo htmlspecialchars($row->tax_perc,ENT_QUOTES);?>%</>
					  <td width="20%"><?php echo htmlspecialchars(round($row->tax,2),ENT_QUOTES); echo " ".$row->currency;?></td>
					 </tr>
					 <tr>
					  <td width="20%"class="title">Totaal / Total </td>
					  <td width="20%"><?php echo htmlspecialchars(round($row->total_amount,2),ENT_QUOTES); echo " ".$row->currency;?></td>
					 </tr>
				</table>
			</td></tr>
		</table>
	</td>
</tr>
 </table>
<br><br><br>De Algemene Voorwaarden van BrainWorX bvba zijn van toepassing op alle facturen.<br> Een kopie van de Algemene Voorwaarden kan bekomen worden in onze kantoren te Westerlo of via email info@brainworx.be .<br>
<br>BrainWorX bvba General Conditions are applicable to all invoices.<br> A copy of the General Conditions can be obtained at our offices in Westerlo or requested by mail info@brainworx.be .<br>
</div>
 <?php
 }
/*****************************************************************************
* incoming invoice overview
******************************************************************************/
function showIncomingInvoices($option, $rows,$pageNav)
{
	HTML_invoicewriter_content::printDateIncludes();
	HTML_invoicewriter_content::printStylesheetIncludes();
	
	$total=0;
	$total_vat=0;
	$total_exvat=0;
?>

<script language="javascript" type="text/javascript">
function doPrintable() {
	if (document.adminForm.boxchecked.value == 0){
		alert('Nothing selected, nothing to do.');
	} else {
		
		document.adminForm.task.value='printInvoice';
		document.adminForm.submit();
		
	}
}
</script>
<form action="index.php" method="post" name="adminForm">
	<div class="content">
		<?php HTML_invoicewriter_content::headerWithLinkToMainMenu("Manage Invoices", 0); ?>
		<div style="text-align:right;">
			<a href="#" onClick="document.adminForm.task.value='newIncomingInvoice'; document.adminForm.submit(); return false;">New</a>
			&nbsp;|&nbsp;<a href="#" onClick="doPrintable(); return false;">Printable</a>
			&nbsp;
		</div>
			
		  <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
		   <tr>
			<th width="20"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($rows); ?>);" /></th>
			<th class="sectiontableentry">Date</th>
			<th class="sectiontableentry">Company</th>
			<th class="sectiontableentry">Amount</th>
			<th class="sectiontableentry">Vat/Tax</th>
			<th class="sectiontableentry">Total amount</th>
			<th class="sectiontableentry">Book date</th>
		   </tr>
		  <?php
			for($i=0; $i < count( $rows ); $i++) {
				$row = $rows[$i];
				$total += $rows[$i]->total_amount;
				$total_vat += $rows[$i]->tax;
				$total_exvat += $rows[$i]->amount;
			   ?>
				<tr>
				 <td width="20"><input type="checkbox" id="cb<?php echo $i;?>" name="cid[]" value="<?php echo $row->id; ?>" onclick="isChecked(this.checked);" /></td>
				 <td class="sectiontableentry2"><a href="./index.php?option=com_invoicewriter&task=editIncomingInvoice&iid=<?php echo $row->id?>"><?php echo htmlspecialchars($row->date, ENT_QUOTES); ?></a></td>
				 <td class="sectiontableentry2"><?php echo htmlspecialchars($row->company_name, ENT_QUOTES); ?></td>
				 <td class="sectiontableentry2"><?php echo round($row->amount,2)." EUR"; ?></td>
				 <td class="sectiontableentry2"><?php echo round($row->tax,2)." EUR"; ?></td>
				 <td class="sectiontableentry2"><?php echo round($row->total_amount,2)." EUR"; ?></td>
				 <td class="sectiontableentry2"><?php if($row->book_date == "0000-00-00")echo "<img src='./components/com_invoicewriter/images/publish_x.png' border='0' />&nbsp;&nbsp;"; else echo htmlspecialchars($row->book_date, ENT_QUOTES); ?></td>

				</tr>
		  <?php } ?>
				<tr><td colspan="7">&nbsp;</td></tr>
				<tr>
				 <td width="20"></td>
				 <td style="text-decoration:underline">Total</td>
				 <td />
				 <td class="sectiontableentry"><?php echo round($total_exvat,2); echo (" ".$row->currency);?></td>
				 <td class="sectiontableentry"><?php echo round($total_vat,2); echo (" ".$row->currency);?></td>
				 <td class="sectiontableentry"><?php echo round($total,2);echo (" ".$row->currency);?></td>
				 <td />
				</tr>
		  
		  </table>
		  <?php
			/*
			for this add following code in invoicewriter.php and add pagenav in this call!
			$limit = getSessionValue('limit', $mosConfig_list_limit);
			$limitstart = getSessionValue('limitstart', 0);
			require_once( $mosConfig_absolute_path .'/includes/pageNavigation.php' );
			$pageNav = new mosPageNav( $total, $limitstart, $limit );
			*/
			HTML_invoicewriter_content::paginateList($pageNav, "./index.php?option=com_invoicewriter&task=showIncomingInvoices");
		  ?>

		  <input type="hidden" name="option" value="<?php echo $option; ?>" />
		  <input type="hidden" name="task" value="showIncomingInvoices" />
		  <input type="hidden" name="boxchecked" value="0" />
	</div>
</form>
 <?php 
}
/******************************************************************************
*
*******************************************************************************/
function editIncomingInvoice($option,$row,$lists,$fprows,$updated=0){
global $mosConfig_live_site;
HTML_invoicewriter_content::printDateIncludes();
HTML_invoicewriter_content::printStylesheetIncludes();

?>
  <script language="javascript" type="text/javascript">
    function validate() {
		if(trim(document.adminForm.date.value)==''){
	  		alert("Date Is Required" );
	  		return false;
	  	}
		if(trim(document.adminForm.company_id.value)=='0'){
			alert("Please select the company" );
			return false;
		}
		if(isNaN(trim(document.adminForm.amount.value))){
			alert("Amount must be numeric" );
			return false;
		}	
		if((document.adminForm.amount.value)=='0'){
			alert("Please make sure to enter an amount or add lines to the invoice." );
		}	
		if(isNaN(trim(document.adminForm.tax.value))){
			alert("Amount must be numeric" );
			return false;
		}	
		if(isNaN(trim(document.adminForm.total_amount.value))){
			alert("Amount must be numeric" );
			return false;
		}	
      return true;
    }
	 
	function deleteInvoice() {
		if (confirm('Are you sure you want to delete selected items?')) {
			document.adminForm.task.value = 'adminDeleteInvoice'; 
			document.adminForm.submit(); 
		}
		return false; 
	}
	  
	function addLine() {
		if(document.adminForm.iid.value > 0){
			document.adminForm.task.value = 'newInvoiceFPLine'; 
			document.adminForm.submit(); 
		}
		else{
			alert("Save the invoice first." );
		}
	}

window.addEvent('domready', function() {Calendar.setup({
        inputField     :    "date",     // id of the input field
        ifFormat       :    "%Y-%m-%d",      // format of the input field
        button         :    "date_img",  // trigger for the calendar (button ID)
        align          :    "Tl",           // alignment (defaults to "Bl")
        singleClick    :    true
    });});
window.addEvent('domready', function() {Calendar.setup({
        inputField     :    "due_date",     // id of the input field
        ifFormat       :    "%Y-%m-%d",      // format of the input field
        button         :    "due_date_img",  // trigger for the calendar (button ID)
        align          :    "Tl",           // alignment (defaults to "Bl")
        singleClick    :    true
    });});
window.addEvent('domready', function() {Calendar.setup({
        inputField     :    "period_start",     // id of the input field
        ifFormat       :    "%Y-%m-%d",      // format of the input field
        button         :    "period_start_img",  // trigger for the calendar (button ID)
        align          :    "Tl",           // alignment (defaults to "Bl")
        singleClick    :    true
    });});
	window.addEvent('domready', function() {Calendar.setup({
        inputField     :    "period_end",     // id of the input field
        ifFormat       :    "%Y-%m-%d",      // format of the input field
        button         :    "period_end_img",  // trigger for the calendar (button ID)
        align          :    "Tl",           // alignment (defaults to "Bl")
        singleClick    :    true
    });});
window.addEvent('domready', function() {Calendar.setup({
        inputField     :    "book_date",     // id of the input field
        ifFormat       :    "%Y-%m-%d",      // format of the input field
        button         :    "book_date_img",  // trigger for the calendar (button ID)
        align          :    "Tl",           // alignment (defaults to "Bl")
        singleClick    :    true
    });});
  </script>

<form action="index.php" method="POST" name="adminForm" >

<div class="content">
<?php HTML_invoicewriter_content::headerWithLinkToMainMenu("Edit Invoice", 0);
if($updated ==0){ ?>	
  <div style="text-align:right;">
	&nbsp;|&nbsp;<a href="./index.php?option=com_invoicewriter&task=showIncomingInvoice&iid=<?php echo $row->id?>">Printable</a>&nbsp;|&nbsp;
</div>
<?php } ?>
<table border="0" cellpadding="3" cellspacing="0" class="adminform">
  <tr>
  <td>Invoice ID </td>
  <td colspan="3"><?php echo htmlspecialchars($row->iv_id, ENT_QUOTES); ?></td>
 </tr>
  <tr>
  <td>Company </td>
  <td colspan="3"><?php echo $lists['company_id']?></td>
 </tr>
  <tr>
  <td>Date </td>
  <td colspan="3">
	<input type="text" name="date" id="date" size="25" maxlength="19" value="<?php echo htmlspecialchars($row->date, ENT_QUOTES); ?>" class="inputbox" />
	<img class="calendar" src="./templates/system/images/calendar.png" alt="calendar" id="date_img" />
  </td>
 </tr>
  <tr>
  <td>Due Date </td>
  <td colspan="3">
	<input type="text" name="due_date" id="due_date" size="25" maxlength="19" value="<?php echo htmlspecialchars($row->due_date, ENT_QUOTES); ?>" class="inputbox" />
	<img class="calendar" src="./templates/system/images/calendar.png" alt="calendar" id="due_date_img" />
  </td>
 </tr>
 <tr>
  <td>Period start </td>
  <td colspan="3">
	<input type="text" name="period_start" id="period_start" size="25" maxlength="19" value="<?php if($row->period_start == "0000-00-00")echo ""; else echo htmlspecialchars($row->period_start, ENT_QUOTES);?>" class="inputbox" />
	<img class="calendar" src="./templates/system/images/calendar.png" alt="calendar" id="period_start_img" />
  </td>
 </tr>
 <tr>
  <td>Period end </td>
  <td colspan="3">
	<input type="text" name="period_end" id="period_end" size="25" maxlength="19" value="<?php if($row->period_end == "0000-00-00")echo ""; else echo htmlspecialchars($row->period_end, ENT_QUOTES); ?>" class="inputbox" />
	<img class="calendar" src="./templates/system/images/calendar.png" alt="calendar" id="period_end_img" />
  </td>
 </tr>
 <tr>
  <td>Book Date </td>
  <td colspan="3">
	<input type="text" name="book_date" id="book_date" size="25" maxlength="19" value="<?php if($row->book_date == "0000-00-00")echo ""; else echo htmlspecialchars($row->book_date, ENT_QUOTES);?>" class="inputbox" />
	<img class="calendar" src="./templates/system/images/calendar.png" alt="calendar" id="book_date_img" />
  </td>
 </tr>
 <?php if($row->ogm > ''){ ?>
 <tr>
  <td>Ogm </td>
  <td colspan="3">
	<input type="text" name="ogm" class="inputboxL" value="<?php echo htmlspecialchars($row->ogm, ENT_QUOTES);?>" />
  </td>
 </tr>
 <?php } ?>
  <tr>
  <td style="vertical-align:top;">Description </td>
  <td><textarea class="invoicewriterEntry" name="description" ><?php echo $row->description;?></textarea></td>
 </tr>
 </table>
 <br><br>
 <?php
 $total = 0;
 if($fprows != null)
{ ?>
	<table cellpadding="4" cellspacing="0" border="0" width="75%" class="adminlist">
	   <tr>
		<th class="title" style="text-align:center" width="40%">Description</th>
		<th class="title" style="text-align:center" width="10%">Quantity</th>
		<th class="title" style="text-align:center" width="20%">Price/Unit</th>
		<th class="title" style="text-align:center" width="20%">Total amount</th>
	   </tr>
	  <?php
		for($i=0; $i < count( $fprows ); $i++) 
		{
			$fprow = $fprows[$i];
		   ?>
			<tr class="row<?php echo ($i%2)-1; ?>">	
			 <td  style="text-align:center"><a style="text-decoration:underline" href="./index.php?option=com_invoicewriter&task=editInvoiceFPLine&ilid=<?php echo $fprow->id;?>"><?php echo $fprow->description; ?></a></td>
			 <td  style="text-align:center"><?php echo $fprow->quantity; ?></td>
			 <td  style="text-align:center"><?php echo round($fprow->amount_unit,2); ?></td>
			 <td  style="text-align:center"><?php echo round($fprow->total_amount,2); ?></td>
			</tr>
	  <?php } ?>
	  </table>
<?php }?>
<br>
<?php if($row->id > 0 && $row->book_date=='0000-00-00'){ ?>
  <div style="text-align:right;">
	&nbsp;|&nbsp;<a href="#"onClick="addLine(); return false;">Add line</a>&nbsp;|&nbsp;
</div>
<?php } ?>
<br>
<?php if($row->total_amount > 0) { ?>
	<table border="0" cellpadding="2" cellspacing="0" class="adminform">
		 <tr>
		  <td>Amount </td>
		  <td><input type="text" name="amount" class="inputbox" value="<?php echo round($row->amount,2);?>" /> </td>
		  <td><?php echo $row->currency; ?></td>
		 </tr>
		 <tr>
		  <td>Tax </td>
		  <td><input type="text" name="tax_perc" class="inputbox" value ="<?php echo $row->tax_perc; ?>"/></td>
		  <td>%</td>
		 </tr>
		 <tr>
		  <td>Tax/vat </>
		 <td><input type="text" name="tax" class="inputbox" value="<?php echo round($row->tax,2); ?>"/> </td>
		 <td><?php echo $row->currency; ?></td>
		 </tr>
		  <td>Total Amount </td>
		  <td><input type="text" name="total_amount" class="inputbox" value="<?php echo round($row->total_amount,2); ?>"> </td>
		  <td><?php echo $row->currency; ?> </td>
		 </tr>

	</table>
<?php } ?>
<table width="100%">
<tr>
<td width="97%"/>
<td width="1%">
<?php if($row->book_date == '0000-00-00'){ ?>
<td width="1%"><input type="submit" class="button" name="submitRun" value="<?php if($row->id > 0) echo "Save"; else echo "Add lines";?>" onclick="if(validate()) document.adminForm.submit();return false;"></td>
<?php } if($updated == 0) { ?>
<td width="1%"><input type="button" class="button" name="submitCancel" value="Cancel" onclick="window.location.href='./index.php?option=com_invoicewriter&task=showIncomingInvoices'"></td>
<?php } if($row->book_date=='0000-00-00'){ ?>
<td width="1%"><input type="button" class="button" name="submitDelete" value="Delete" onclick="window.location.href='./index.php?option=com_invoicewriter&task=adminDeleteInvoice&cid=<?php echo $row->id;?>'"></td>
<?php } ?>
</tr>
</table>

</div>

<input type="hidden" name="option" value="com_invoicewriter" />
<input type="hidden" name="task" value="saveIncomingInvoice" />
<input type="hidden" name="current_date" value="" />
<input type="hidden" name="user_id" value="<?php echo $row->user_id;?>" />
<input type="hidden" name="iid" value="<?php echo $row->id;?>" />
<input type="hidden" name="id" value="<?php echo $row->id;?>" />
<input type="hidden" name="iv_id" value="<?php echo $row->iv_id;?>" />
<input type="hidden" name="ogm" value="<?php echo $row->ogm;?>" />
</form>

<?php
}
/******************************************************************************
*
*******************************************************************************/
function editInvoiceFPLine($option,$row,$updateable=1){

HTML_invoicewriter_content::printDateIncludes();
HTML_invoicewriter_content::printStylesheetIncludes();

?>
  <script language="javascript" type="text/javascript">
    function validate() {
		if(trim(document.adminForm.invoice_id.value)=='0'){
  		alert("An error occurred, please retry or contact your administrator!" );
  		return;
		}
		if(isNaN(trim(document.adminForm.quantity.value))){
			alert("Quantity must be numeric" );
			return false;
		}	
		if((document.adminForm.quantity.value) == '0'){
			alert("Quantity must be greater then 0" );
			return false;
		}
		if(isNaN(trim(document.adminForm.amount_unit.value))){
			alert("Amount per unit must be numeric" );
			return false;
		}	
		if((document.adminForm.amount_unit.value) == '0'){
			alert("Amount per unit must be greater then 0" );
			return false;
		}
		if(isNaN(trim(document.adminForm.quantity.value))){
			alert("Quantity must be numeric" );
			return false;
		}	
      return true;
    }
  </script>

<form action="index.php" method="POST" name="adminForm" >

<div class="content">
<?php if($row->id > 0){HTML_invoicewriter_content::headerWithLinkToMainMenu("Edit Invoice Line", 0);}
		else{HTML_invoicewriter_content::headerWithLinkToMainMenu("New Invoice Line", 0);}?>	

<table border="0" cellpadding="3" cellspacing="0" class="adminform">
  <tr>
  <td style="vertical-align:top;">Description </td>
  <td><textarea class="invoicewriterEntry" name="description" ><?php echo $row->description;?></textarea></td>
 </tr>
   <tr>
  <td>Quantity </td>
  <td><input type="text" size="15" name="quantity" value="<?php echo htmlspecialchars($row->quantity, ENT_QUOTES);?>" /></td>
  </tr>
    <tr>
  <td>Amount per unit </td>
  <td><input type="text" size="15" name="amount_unit" value="<?php echo htmlspecialchars(round($row->amount_unit,2), ENT_QUOTES);?>" /></td>
  </tr>
   <tr>
  <td>Unit </td>
  <td><input type="text" size="15" name="unit" value="<?php echo htmlspecialchars($row->unit, ENT_QUOTES);?>" /></td>
  </tr>
  <tr>
  <td>Currency </td>
  <td><input type="text" size="15" name="currency" value="<?php echo htmlspecialchars($row->currency, ENT_QUOTES);?>" /></td>
  </tr>
</table>

<table width="100%">
<tr>
<td width="98%">&nbsp;</td>
<?php if($updateable == 1) { ?>
<td>
 <input type="submit" class="button" name="submitRun" value="Save" onclick="if(validate()) document.adminForm.submit();return false;">
</td>
<?php } ?>
<td width="1%">
 <input type="button" class="button" name="submitCancel" value="Cancel" onclick="window.location.href='./index.php?option=com_invoicewriter&task=editIncomingInvoice&iid=<?php echo $row->invoice_id;?>'">  
</td>
<?php if($updateable == 1) { ?>
<td width="1%">
 <input type="button" class="button" name="submitDelete" value="Delete" onclick="window.location.href='./index.php?option=com_invoicewriter&task=deleteInvoiceFPLine&ilid=<?php echo $row->id;?>&iid=<?php echo $row->invoice_id;?>'">  
</td>
<?php } ?>
</tr>
</table>
</div>

<input type="hidden" name="option" value="com_invoicewriter" />
<input type="hidden" name="task" value="saveInvoiceFPLine" />
<input type="hidden" name="total_amount" value="<?php echo htmlspecialchars(round(($row->quantity*$row->amount_unit),2), ENT_QUOTES); ?>" />
<input type="hidden" name="id" value="<?php echo $row->id;?>" />
<input type="hidden" name="invoice_id" value="<?php echo $row->invoice_id;?>" />
</form>

<?php
}
/*****************************************************************************
* expense overview
******************************************************************************/
function showExpenses($option, $rows,$pageNav,$booky)
{
	HTML_invoicewriter_content::printDateIncludes();
	HTML_invoicewriter_content::printStylesheetIncludes();
	
	$total = 0;
	$total_vat = 0;
	$total_exvat = 0;
?>

<script language="javascript" type="text/javascript">
function doDelete() {
	if (document.adminForm.boxchecked.value == 0){
		alert('Nothing selected, nothing to do.');
	} else {
		if (confirm('Are you sure you want to delete the selected Expenses?')) {
			document.adminForm.task.value='adminDeleteExpense';
			document.adminForm.submit();
		}
	}
}

</script>
<form action="index.php" method="post" name="adminForm">
	<div class="content">
		<?php HTML_invoicewriter_content::headerWithLinkToMainMenu("Manage Expenses - last bookdate $booky", 0); ?>
		<div style="text-align:right;">
			<a href="#" onClick="document.adminForm.task.value='newExpense'; document.adminForm.submit(); return false;">New</a>
			&nbsp;|&nbsp;<a href="#" onClick="doDelete(); return false;">Delete</a>
			&nbsp;
		</div>
			
		  <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
		   <tr>
			<th width="20"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($rows); ?>);" /></th>
			<th class="sectiontableentry">Date</th>
			<th class="sectiontableentry">Supplier</th>
			<th style="text-align:right" class="sectiontableentry">Amount</th>
			<th style="text-align:right" class="sectiontableentry">Vat/Tax</th>
			<th style="text-align:right" class="sectiontableentry">Total amount</th>
			<th style="text-align:center" class="sectiontableentry">Book date</th>
			<th style="text-align:center" class="sectiontableentry">Invoice?</th>
		   </tr>
		  <?php
			for($i=0; $i < count( $rows ); $i++) {
				$row = $rows[$i];
				$total += $rows[$i]->total_amount;
				$total_vat += $rows[$i]->tax;
				$total_exvat += $rows[$i]->amount;
			   ?>
				<tr>
				 <td width="20"><input type="checkbox" id="cb<?php echo $i;?>" name="cid[]" value="<?php echo $row->id; ?>" onclick="isChecked(this.checked);" /></td>
				 <td style="text-align:center" class="sectiontableentry2"><a href="./index.php?option=com_invoicewriter&amp;task=editExpense&amp;id=<?php echo $row->id?>"><?php echo htmlspecialchars($row->date, ENT_QUOTES); ?></a></td>
				 <td style="text-align:left" class="sectiontableentry2"><?php echo htmlspecialchars($row->supplier_name, ENT_QUOTES); ?></td>
				 <td style="text-align:right" class="sectiontableentry2"><?php echo round($row->amount,2); echo (" ".$row->currency);?></td>
				 <td style="text-align:right" class="sectiontableentry2"><?php echo round($row->tax,2); echo (" ".$row->currency);?></td>
				 <td style="text-align:right" class="sectiontableentry2"><?php echo round($row->total_amount,2);echo (" ".$row->currency);?></td>
				 <td style="text-align:center" class="sectiontableentry2"><?php 
				 if($row->book_date == "0000-00-00")echo "<img src='./components/com_invoicewriter/images/publish_x.png' border='0' />&nbsp;&nbsp;"; 
				 else echo (htmlspecialchars($row->book_date, ENT_QUOTES)."&nbsp;"); 
				 if(preg_match( "/^mc/i", $row->ogm ))echo "<img src='./components/com_invoicewriter/images/mastercard.png' border='0' />"; 
				 ?>
				 </td>
				 <td style="text-align:center" class="sectiontableentry2" ><?php if($row->invoice_received==1){?><img src="./components/com_invoicewriter/images/tick.png" border="0" /> <?php } else { ?><img src="./components/com_invoicewriter/images/publish_x.png" border="0" /><?php } ?></td>
				</tr>
		  <?php } ?>
				<tr><td colspan="8">&nbsp;</td></tr>
				<tr>
				 <td width="20"></td>
				 <td style="text-decoration:underline">Total</td>
				 <td />
				 <td style="text-align:right" class="sectiontableentry"><?php echo round($total_exvat,2); echo (" ".$row->currency);?></td>
				 <td style="text-align:right" class="sectiontableentry"><?php echo round($total_vat,2); echo (" ".$row->currency);?></td>
				 <td style="text-align:right" class="sectiontableentry"><?php echo round($total,2);echo (" ".$row->currency);?></td>
				  <td colspan="2" />
				</tr>
		  </table>
		  <?php
			/*
			for this add following code in invoicewriter.php and add pagenav in this call!
			$limit = getSessionValue('limit', $mosConfig_list_limit);
			$limitstart = getSessionValue('limitstart', 0);
			require_once( $mosConfig_absolute_path .'/includes/pageNavigation.php' );
			$pageNav = new mosPageNav( $total, $limitstart, $limit );
			*/
			HTML_invoicewriter_content::paginateList($pageNav, "./index.php?option=com_invoicewriter&task=showExpenses");
		  ?>

		  <input type="hidden" name="option" value="<?php echo $option; ?>" />
		  <input type="hidden" name="task" value="showExpenses" />
		  <input type="hidden" name="boxchecked" value="0" />
	</div>
</form>
 <?php 
}
/******************************************************************************
*
*******************************************************************************/
function editExpense($option,$row,$lists){
global $mosConfig_live_site;
HTML_invoicewriter_content::printDateIncludes();
HTML_invoicewriter_content::printStylesheetIncludes();

?>
  <script language="javascript" type="text/javascript">
    function validate() {
		if(trim(document.adminForm.date.value)==''){
	  		alert("Date Is Required" );
	  		return false;
	  	}
		if(trim(document.adminForm.supplier_id.value)=='0'){
			alert("Please select the supplier" );
			return false;
		}
		if(trim(document.adminForm.expensetype_id.value)=='0'){
			alert("Please select the expense type" );
			return false;
		}
		if(isNaN(trim(document.adminForm.amount.value))){
			alert("Amount must be numeric" );
			return false;
		}	
		if((document.adminForm.amount.value)=='0'){
			alert("Please make sure to enter an amount or add lines to the invoice." );
		}	
		if(isNaN(trim(document.adminForm.tax.value))){
			alert("Amount must be numeric" );
			return false;
		}	
		if(isNaN(trim(document.adminForm.total_amount.value))){
			alert("Amount must be numeric" );
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
window.addEvent('domready', function() {Calendar.setup({
        inputField     :    "book_date",     // id of the input field
        ifFormat       :    "%Y-%m-%d",      // format of the input field
        button         :    "book_date_img",  // trigger for the calendar (button ID)
        align          :    "Tl",           // alignment (defaults to "Bl")
        singleClick    :    true
    });});
  </script>

<form action="index.php" method="POST" name="adminForm" >

<div class="content">
<?php HTML_invoicewriter_content::headerWithLinkToMainMenu("Edit Expense", 0); ?>
<table border="0" cellpadding="3" cellspacing="0" class="adminform">
<?php if($row->id >0){ ?>
	  <tr>
	  <td>ID </td>
	  <td colspan="3">EXP00<?php echo htmlspecialchars($row->id, ENT_QUOTES); ?></td>
	 </tr> <tr><td colspan="4">&nbsp;</td></tr>
 <?php } ?>
      <tr>
  <td>Expense type </td>
  <td colspan="3"><?php echo $lists['expensetype_id']?></td>
 </tr>
   <tr>
  <td>Supplier </td>
  <td ><?php echo $lists['supplier_id']?> &nbsp;|&nbsp;<a href="./index.php?option=com_invoicewriter&amp;task=newSupplier&amp;redirectExpenseid=<?php if($row->id > 0) echo $row->id; else echo 'A'?> ">New Supplier</a>&nbsp;|&nbsp;</td>
 <td colspan="2">&nbsp;</td>
 </tr>
 <tr><td colspan="4">&nbsp;</td></tr>
  <tr>
  <td>Date </td>
  <td colspan="3">
	<input type="text" name="date" id="date" size="25" maxlength="19" value="<?php echo htmlspecialchars($row->date, ENT_QUOTES); ?>" class="inputbox" />
	<img class="calendar" src="./templates/system/images/calendar.png" alt="calendar" id="date_img" />
  </td>
 </tr>
 <tr>
  <td>Book Date </td>
  <td colspan="3">
	<input type="text" name="book_date" id="book_date" size="25" maxlength="19" value="<?php if($row->book_date == "0000-00-00")echo ""; else echo htmlspecialchars($row->book_date, ENT_QUOTES);?>" class="inputbox" />
	<img class="calendar" src="./templates/system/images/calendar.png" alt="calendar" id="book_date_img" />
  </td>
 </tr>
 <tr><td colspan="4">&nbsp;</td></tr>
  <tr>
  <td style="vertical-align:top;">Description </td>
  <td><textarea class="companyEdit" name="description" ><?php echo $row->description;?></textarea></td>
 </tr>
 <tr>
  <td style="vertical-align:top;">OGM </td>
  <td><input type="text" class="inputbox" name="ogm" value="<?php echo $row->ogm;?>"></input></td>
 </tr>
 <tr>
 <td>Invoice received </td>
 <td><input type="radio" name="invoice_received" value="1" <?php if($row->invoice_received==1) echo("checked")?>/>Yes
  <input type="radio" name="invoice_received" value="0" <?php if($row->invoice_received==0) echo("checked")?>/>No
	</td>  
</tr>
 </table>
<br><br>
<table border="0" cellpadding="2" cellspacing="0" class="adminform">
	 <tr>
	  <td>Amount (ex.vat) </td>
	  <td><input type="text" name="amount" class="inputbox" value="<?php echo round($row->amount,2);?>" /> </td>
	  <td>&nbsp;EUR </td>
	 </tr>
	 <tr>
	  <td>Tax/vat </>
	 <td><input type="text" name="tax" class="inputbox" value="<?php echo round($row->tax,2); ?>"/> </td>
	 <td>&nbsp;EUR </td>
	 </tr>
</table>
<table width="100%">
<tr>
<td width="98%"/>
<td width="1%"><input type="submit" class="button" name="submitRun" value="Save" onclick="if(validate()) document.adminForm.submit();return false;"></td>
<?php if($updated == 0) { ?>
<td width="1%"><input type="button" class="button" name="submitCancel" value="Cancel" onclick="window.location.href='./index.php?option=com_invoicewriter&task=showExpenses'"></td>
<?php } ?>
</tr>
</table>

</div>
<input type="hidden" name="option" value="com_invoicewriter" />
<input type="hidden" name="task" value="saveExpense" />
<input type="hidden" name="id" value="<?php echo $row->id ?>" />
</form>

<?php
}
/******************************************************************************
 * 
******************************************************************************/
function showSuppliers( $option, $rows, $pageNav) {

	HTML_invoicewriter_content::printDateIncludes();
	HTML_invoicewriter_content::printStylesheetIncludes();
?>
 <script language="javascript" type="text/javascript">
function doDelete() {
	if (document.adminForm.boxchecked.value == 0){
		alert('Nothing selected, nothing to do.');
	} else {
		if (confirm('Are you sure you want to delete the selected Supplier?')) {
			document.adminForm.task.value='adminDeleteSupplier';
			document.adminForm.submit();
		}
	}
}
</script>
<form action="index.php" method="post" name="adminForm">
<div class="content">
<?php 
	echo HTML_invoicewriter_content::headerWithLinkToMainMenu("Manage Suppliers"); 
	
?>
<div style="text-align:right;">
	<a href="#" onClick="window.location.href='./index.php?option=com_invoicewriter&task=newSupplier'">New</a>
	&nbsp;|&nbsp;<a href="#" onClick="doDelete(); return false;">Delete</a>
</div>
	  

<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
   <tr>
    <th width="20"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($rows); ?>);" /></th>
    <th class="title" width="25%">Supplier Name</th>
	<th class="title" width="30%">Description</th>
    <th class="title" width="20%">Telephone</th>
    <th class="title" width="20%">Contact</th>
	<th class="title" width="10%">Customer?</th>
   </tr>
  <?php
    for($i=0; $i < count( $rows ); $i++) {
    $row = $rows[$i];
   ?>
    <tr class="row<?php echo ($i%2)-1; ?>">
     <td style="text-align:center;"><input type="checkbox" id="cb<?php echo $i;?>" name="cid[]" value="<?php echo $row->id; ?>" onclick="isChecked(this.checked);" /></td>
     <td><a href="./index.php?option=com_invoicewriter&task=editSupplier&id=<?php echo $row->id?>"><?php echo htmlspecialchars($row->supplier_name, ENT_QUOTES); ?></a></td>
	 <td><?php echo htmlspecialchars($row->description, ENT_QUOTES); ?></td>
     <td><?php echo htmlspecialchars($row->telephone, ENT_QUOTES); ?></td>
     <td><?php echo htmlspecialchars($row->contact_name, ENT_QUOTES); ?></td>
	 <td><?php if($row->company_id >0){?><img src="./components/com_invoicewriter/images/tick.png" border="0" /> <?php } else { ?><img src="./components/com_invoicewriter/images/publish_x.png" border="0" /><?php } ?></td>
    </tr>
  <?php } ?>
</table>

  <?php
	HTML_invoicewriter_content::paginateList($pageNav, "./index.php?option=com_invoicewriter&task=showSuppliers");
  ?>
    
  <input type="hidden" name="option" value="<?php echo $option; ?>" />
  <input type="hidden" name="task" value="showSuppliers" />
  <input type="hidden" name="boxchecked" value="0" />
</div>
</form>
 <?php 
}

/******************************************************************************
 * 
******************************************************************************/
function editSupplier( $option, $row, &$lists, $redirectExpenseid=0 ) {

	HTML_invoicewriter_content::printDateIncludes();
	HTML_invoicewriter_content::printStylesheetIncludes();
?>
  <script language="javascript" type="text/javascript">

    function validate() {
    var form = document.adminForm;
  	if(trim(form.supplier_name.value)==''){
  		alert("Supplier Name Is Required" );
  		return false;
  	}
  	if(trim(form.vat_reg_no.value)==''){
  		alert("Tax id Is Required" );
  		return false;
  	}
	return true;
    }
  </script>

<form action="index.php" method="POST" name="adminForm" >

<div class="content">
<?php echo HTML_invoicewriter_content::headerWithLinkToMainMenu("Edit Supplier"); ?>	

<table border="0" cellpadding="3" cellspacing="2" class="adminform">
 <tr>
  <td>Supplier Name </td>
  <td><input type="text" size="50" maxsize="100" name="supplier_name" value="<?php echo htmlspecialchars($row->supplier_name, ENT_QUOTES); ?>" /></td>
  </tr>
 <tr>
  <td>Customer</td>
  <td colspan="3"><?php echo $lists['company_id']?></td>
  </tr>
  <tr>
  <td>Address </td>
  <td><textarea class="addressEdit" rows="2" cols="20" name="address" ><?php echo htmlspecialchars($row->address, ENT_QUOTES); ?></textarea></td>
 </tr>
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
</table>
<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
<input type="hidden" name="option" value="<?php echo $option; ?>" />
<input type="hidden" name="redirectExpenseid" value="<?php echo $redirectExpenseid; ?>" />
<input type="hidden" name="task" value="" />

<?php echo HTML_invoicewriter_content::printSubmitAndCancelButtons('saveSupplier', 'showSuppliers', 'Save'); ?>

</div>
</form>
 <?php 
}
/******************************************************************************
 * 
******************************************************************************/
function showStaff( $option, $rows, $pageNav) {

	HTML_invoicewriter_content::printDateIncludes();
	HTML_invoicewriter_content::printStylesheetIncludes();
?>
 <script language="javascript" type="text/javascript">
function doDelete() {
	if (document.adminForm.boxchecked.value == 0){
		alert('Nothing selected, nothing to do.');
	} else {
		if (confirm('Are you sure you want to delete the selected Staff Member?')) {
			document.adminForm.task.value='adminDeleteStaffMember';
			document.adminForm.submit();
		}
	}
}
</script>
 
<form action="index.php" method="post" name="adminForm">
<div class="content">
<?php 
	echo HTML_invoicewriter_content::headerWithLinkToMainMenu("Manage Staff Members"); 
	
?>
<div style="text-align:right;">
	<a href="#" onClick="window.location.href='./index.php?option=com_invoicewriter&task=newStaffMember'">New</a>
	&nbsp;|&nbsp;<a href="#" onClick="doDelete(); return false;">Delete</a>
</div>
	  

<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
   <tr>
    <th width="20"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($rows); ?>);" /></th>
    <th class="title" width="40%">Name</th>
	<th class="title" width="15%">Birth Date</th>
	<th class="title" width="15%">Job Title</th>
    <th class="title" width="15%">Date Hired</th>
    <th class="title" width="15%">Date Exit</th>
   </tr>
  <?php
    for($i=0; $i < count( $rows ); $i++) {
    $row = $rows[$i];
   ?>
    <tr class="row<?php echo ($i%2)-1; ?>">
     <td style="text-align:center;"><input type="checkbox" id="cb<?php echo $i;?>" name="cid[]" value="<?php echo $row->id; ?>" onclick="isChecked(this.checked);" /></td>
     <td><a href="./index.php?option=com_invoicewriter&task=editStaffMember&id=<?php echo $row->id?>"><?php echo htmlspecialchars($row->name, ENT_QUOTES); ?></a></td>
	 <td><?php echo htmlspecialchars($row->birth_date, ENT_QUOTES); ?></td>
     <td><?php echo htmlspecialchars($row->jobtitle, ENT_QUOTES); ?></td>
     <td><?php echo htmlspecialchars($row->start_date, ENT_QUOTES); ?></td>	 
     <td><?php echo htmlspecialchars($row->end_date, ENT_QUOTES); ?></td>
	 </tr>
  <?php } ?>
</table>

  <?php
	HTML_invoicewriter_content::paginateList($pageNav, "./index.php?option=com_invoicewriter&task=showStaff");
  ?>
    
  <input type="hidden" name="option" value="<?php echo $option; ?>" />
  <input type="hidden" name="task" value="showStaff" />
  <input type="hidden" name="boxchecked" value="0" />
</div>
</form>
 <?php 
}

/******************************************************************************
 * 
******************************************************************************/
function editStaffMember( $option, $row, &$lists ) {

	HTML_invoicewriter_content::printDateIncludes();
	HTML_invoicewriter_content::printStylesheetIncludes();
?>
  <script language="javascript" type="text/javascript">

    function validate() {
    var form = document.adminForm;
  	if(trim(form.user_id.value)=='0'){
  		alert("User Is Required" );
  		return false;
  	}
	if(trim(form.start_date.value)==''){
  		alert("Hire Date Is Required" );
  		return false;
  	}
	return true;
    }
	window.addEvent('domready', function() {Calendar.setup({
        inputField     :    "birth_date",     // id of the input field
        ifFormat       :    "%Y-%m-%d",      // format of the input field
        button         :    "birth_date_img",  // trigger for the calendar (button ID)
        align          :    "Tl",           // alignment (defaults to "Bl")
        singleClick    :    true
    });});
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

<form action="index.php" method="POST" name="adminForm" >

<div class="content">
<?php echo HTML_invoicewriter_content::headerWithLinkToMainMenu("Edit Staff Member"); ?>	

<table border="0" cellpadding="3" cellspacing="2" class="adminform">
 <tr>
  <td>Job title </td>
  <td><input type="text" size="50" maxsize="100" name="jobtitle" value="<?php echo htmlspecialchars($row->jobtitle, ENT_QUOTES); ?>" /></td>
  </tr>
 <tr>
  <td>User</td>
  <td colspan="3"><?php echo $lists['user_id']?></td>
  </tr>
  
  <?php if($row->user_id > 0){ ?>
  <tr>
   <td>&nbsp;</td>
   <td style="text-align:left">
	<a href="./index.php?option=com_invoicewriter&amp;task=editUser&amp;id=<?php echo $row->user_id; ?>&amp;redirectStaffid=<?php echo $row->id ?> ">Edit User Data</a>&nbsp;</td>
  </tr>
  <?php } ?>
   <tr>
  <td>Birth Date </td>
  <td colspan="3">
	<input type="text" name="birth_date" id="birth_date" size="25" maxlength="19" value="<?php if($row->birth_date == "0000-00-00")echo ""; else echo htmlspecialchars($row->birth_date, ENT_QUOTES);?>" class="inputbox" />
	<img class="calendar" src="./templates/system/images/calendar.png" alt="calendar" id="birth_date_img" />
  </td>
 </tr>
  <tr>
  <td>Address </td>
  <td><textarea class="addressEdit" rows="2" cols="20" name="address" ><?php echo htmlspecialchars($row->address, ENT_QUOTES); ?></textarea></td>
 </tr>
 <tr>
  <td>Telephone </td>
  <td><input type="text" size="20" maxsize="20" name="telephone" value="<?php echo htmlspecialchars($row->telephone, ENT_QUOTES); ?>" /></td>
  </tr>
 <tr>
 <tr>
  <td>Hire Date </td>
  <td colspan="3">
	<input type="text" name="start_date" id="start_date" size="25" maxlength="19" value="<?php if($row->start_date == "0000-00-00")echo ""; else echo htmlspecialchars($row->start_date, ENT_QUOTES);?>" class="inputbox" />
	<img class="calendar" src="./templates/system/images/calendar.png" alt="calendar" id="start_date_img" />
  </td>
 </tr>
  <tr>
  <td>Exit Date </td>
  <td colspan="3">
	<input type="text" name="end_date" id="end_date" size="25" maxlength="19" value="<?php if($row->end_date == "0000-00-00")echo ""; else echo htmlspecialchars($row->end_date, ENT_QUOTES);?>" class="inputbox" />
	<img class="calendar" src="./templates/system/images/calendar.png" alt="calendar" id="end_date_img" />
  </td>
 </tr>
</table>
<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
<input type="hidden" name="option" value="<?php echo $option; ?>" />
<input type="hidden" name="task" value="" />

<?php echo HTML_invoicewriter_content::printSubmitAndCancelButtons('saveStaffMember', 'showStaff', 'Save'); ?>

</div>
</form>
 <?php 
}
/******************************************************************************
 * 
******************************************************************************/
function showUsers( $option, $rows, $pageNav) {

	HTML_invoicewriter_content::printDateIncludes();
	HTML_invoicewriter_content::printStylesheetIncludes();
?>
 
<form action="index.php" method="post" name="adminForm">
<div class="content">
<?php 
	echo HTML_invoicewriter_content::headerWithLinkToMainMenu("Manage Users"); 
	
?>	  

<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
   <tr>
    <th width="20"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($rows); ?>);" /></th>
    <th class="title" width="25%">Name</th>	
    <th class="title" width="25%">User Type</th>
	<th class="title" width="25%">Username</th>
	<th class="title" width="25%">Email</th>
   </tr>
  <?php
    for($i=0; $i < count( $rows ); $i++) {
    $row = $rows[$i];
   ?>
    <tr class="row<?php echo ($i%2)-1; ?>">
     <td style="text-align:center;"><input type="checkbox" id="cb<?php echo $i;?>" name="cid[]" value="<?php echo $row->id; ?>" onclick="isChecked(this.checked);" /></td>
     <td><a href="./index.php?option=com_invoicewriter&task=editUser&id=<?php echo $row->id?>"><?php echo htmlspecialchars($row->name, ENT_QUOTES); ?></a></td>
	 <td><?php echo htmlspecialchars($row->usertype, ENT_QUOTES); ?></td>
     <td><?php echo htmlspecialchars($row->username, ENT_QUOTES); ?></td>
     <td><?php echo htmlspecialchars($row->email, ENT_QUOTES); ?></td>	 
	 </tr>
  <?php } ?>
</table>

  <?php
	HTML_invoicewriter_content::paginateList($pageNav, "./index.php?option=com_invoicewriter&task=showUsers");
  ?>
    
  <input type="hidden" name="option" value="<?php echo $option; ?>" />
  <input type="hidden" name="task" value="showUsers" />
  <input type="hidden" name="boxchecked" value="0" />
</div>
</form>
 <?php 
}

/******************************************************************************
 * 
******************************************************************************/
function editUser( $option, $row, &$lists,	$redirectStaffid=0 ) {

	HTML_invoicewriter_content::printDateIncludes();
	HTML_invoicewriter_content::printStylesheetIncludes();
?>
  <script language="javascript" type="text/javascript">

    function validate() {
    var form = document.adminForm;
  	if(trim(form.email.value)==''){
  		alert("Email Is Required" );
  		return false;
  	}
	if(trim(form.name.value)==''){
  		alert("Name Is Required" );
  		return false;
  	}
	if(trim(form.username.value)==''){
  		alert("Username Is Required" );
  		return false;
  	}
	return true;
    }
  </script>

<form action="index.php" method="POST" name="adminForm" >

<div class="content">
<?php echo HTML_invoicewriter_content::headerWithLinkToMainMenu("Edit User"); ?>	

<table border="0" cellpadding="3" cellspacing="2" class="adminform">

  <tr>
  <td>ID </td>
  <td>USR00<?php echo htmlspecialchars($row->id, ENT_QUOTES); ?></td>
  </tr>
 <tr>
  <td>User Type </td>
  <td><?php echo htmlspecialchars($row->usertype, ENT_QUOTES); ?>"</td>
  </tr>
     <tr>
  <td>User Name </td>
  <td><input type="text" size="20" maxsize="20" name="username" value="<?php echo htmlspecialchars($row->username, ENT_QUOTES); ?>" /></td>
  </tr>
  <tr>
  <td>Name </td>
  <td><input type="text" size="20" maxsize="20" name="name" value="<?php echo htmlspecialchars($row->name, ENT_QUOTES); ?>" /></td>
  </tr>
  <tr>
  <td>Email </td>
  <td><input type="text" size="20" maxsize="20" name="email" value="<?php echo htmlspecialchars($row->email, ENT_QUOTES); ?>" /></td>
  </tr>
</table>
<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
<input type="hidden" name="password" value="<?php echo $row->password; ?>" />
<input type="hidden" name="usertype" value="<?php echo $row->usertype; ?>" />
<input type="hidden" name="block" value="<?php echo $row->block; ?>" />
<input type="hidden" name="sendEmail" value="<?php echo $row->sendEmail; ?>" />
<input type="hidden" name="gid" value="<?php echo $row->gid; ?>" />
<input type="hidden" name="registerDate" value="<?php echo $row->registerDate; ?>" />
<input type="hidden" name="lastvisitDate" value="<?php echo $row->lastvisitDate; ?>" />
<input type="hidden" name="activation" value="<?php echo $row->activation; ?>" />
<input type="hidden" name="params" value="<?php echo $row->params; ?>" />
<input type="hidden" name="option" value="<?php echo $option; ?>" />
<input type="hidden" name="redirectStaffid" value="<?php echo $redirectStaffid; ?>" />
<input type="hidden" name="task" value="" />

<?php echo HTML_invoicewriter_content::printSubmitAndCancelButtons('saveUser', 'showUsers', 'Save'); ?>

</div>
</form>
 <?php 
}
/*****************************************************************************
*  
******************************************************************************/
function showSalaries($option, $rows,$pageNav)
{
	HTML_invoicewriter_content::printDateIncludes();
	HTML_invoicewriter_content::printStylesheetIncludes();
	
	$total=0;
?>

<script language="javascript" type="text/javascript">
function doDelete() {
	if (document.adminForm.boxchecked.value == 0){
		alert('Nothing selected, nothing to do.');
	} else {
		if (confirm('Are you sure you want to delete the selected Salaries?')) {
			document.adminForm.task.value='adminDeleteSalary';
			document.adminForm.submit();
		}
	}
}

</script>
<form action="index.php" method="post" name="adminForm">
	<div class="content">
		<?php HTML_invoicewriter_content::headerWithLinkToMainMenu("Manage Salaries", 0); ?>
		<div style="text-align:right;">
		
			<a href="#" onClick="window.location.href='./index.php?option=com_invoicewriter&task=newSalary'" >New</a>
			&nbsp;|&nbsp;<a href="#" onClick="doDelete(); return false;">Delete</a>
			&nbsp;
		</div>
			
		  <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
		   <tr>
			<th width="20"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($rows); ?>);" /></th>
			<th class="sectiontableentry">Date</th>
			<th class="sectiontableentry">Staff Member</th>			
			<th class="sectiontableentry">Description</th>
			<th class="sectiontableentry">Amount</th>
			<th class="sectiontableentry">Book date</th>
		   </tr>
		  <?php
			for($i=0; $i < count( $rows ); $i++) {
				$row = $rows[$i];
				$total += $row->amount;
			   ?>
				<tr>
				 <td width="20"><input type="checkbox" id="cb<?php echo $i;?>" name="cid[]" value="<?php echo $row->id; ?>" onclick="isChecked(this.checked);" /></td>
				 <td class="sectiontableentry2"><a href="./index.php?option=com_invoicewriter&task=editSalary&id=<?php echo $row->id?>"><?php echo htmlspecialchars($row->date, ENT_QUOTES); ?></a></td>
				 <td class="sectiontableentry2"><?php echo htmlspecialchars($row->name, ENT_QUOTES); ?></td>
				 <td class="sectiontableentry2"><?php echo $row->description; ?></td>
				 <td class="sectiontableentry2"><?php echo round($row->amount,2); ?>&nbsp;EUR</td>
				 <td class="sectiontableentry2"><?php if($row->book_date == "0000-00-00")echo "<img src='./components/com_invoicewriter/images/publish_x.png' border='0' />&nbsp;&nbsp;"; else echo htmlspecialchars($row->book_date, ENT_QUOTES); ?></td>
				</tr>
		  <?php } ?>
		  <tr><td colspan="6">&nbsp;</td></tr>
		  <tr>
			<td width="20">&nbsp;</td>
			<td style="text-decoration:underline">Total</td>
			<td colspan="2" />
			<td class="sectiontableentry"><?php echo round($total,2)." EUR"; ?> </td>
			<td/>
			</tr>
		  </table>
		  <?php
			HTML_invoicewriter_content::paginateList($pageNav, "./index.php?option=com_invoicewriter&task=showSalaries");
		  ?>

		  <input type="hidden" name="option" value="<?php echo $option; ?>" />
		  <input type="hidden" name="task" value="showSalaries" />
		  <input type="hidden" name="boxchecked" value="0" />
	</div>
</form>
 <?php 
}
/******************************************************************************
*
*******************************************************************************/
function editSalary($option,$row,$lists){
global $mosConfig_live_site;
HTML_invoicewriter_content::printDateIncludes();
HTML_invoicewriter_content::printStylesheetIncludes();

?>
  <script language="javascript" type="text/javascript">
    function validate() {
		if(trim(document.adminForm.date.value)==''){
	  		alert("Date Is Required" );
	  		return false;
	  	}
		if(trim(document.adminForm.staff_id.value)=='0'){
			alert("Please select the staff member" );
			return false;
		}
		if(isNaN(trim(document.adminForm.amount.value))){
			alert("Amount must be numeric" );
			return false;
		}	
		if((document.adminForm.amount.value)=='0'){
			alert("Amount is Required." );
		}	
      return true;
    }
	 
	function deleteSalary() {
		if (confirm('Are you sure you want to delete selected items?')) {
			document.adminForm.task.value = 'adminDeleteSalary'; 
			document.adminForm.submit(); 
		}
		return false; 
	}

window.addEvent('domready', function() {Calendar.setup({
        inputField     :    "date",     // id of the input field
        ifFormat       :    "%Y-%m-%d",      // format of the input field
        button         :    "date_img",  // trigger for the calendar (button ID)
        align          :    "Tl",           // alignment (defaults to "Bl")
        singleClick    :    true
    });});
window.addEvent('domready', function() {Calendar.setup({
        inputField     :    "book_date",     // id of the input field
        ifFormat       :    "%Y-%m-%d",      // format of the input field
        button         :    "book_date_img",  // trigger for the calendar (button ID)
        align          :    "Tl",           // alignment (defaults to "Bl")
        singleClick    :    true
    });});
  </script>

<form action="index.php" method="POST" name="adminForm" >

<div class="content">
<?php HTML_invoicewriter_content::headerWithLinkToMainMenu("Edit Salary", 0); ?>
<table border="0" cellpadding="3" cellspacing="0" class="adminform">
<?php if($row->id >0){ ?>
	  <tr>
	  <td>ID </td>
	  <td colspan="3">SAL00<?php echo htmlspecialchars($row->id, ENT_QUOTES); ?></td>
	 </tr>
 <?php } ?>
  <tr>
  <td>Date </td>
  <td colspan="3">
	<input type="text" name="date" id="date" size="25" maxlength="19" value="<?php echo htmlspecialchars($row->date, ENT_QUOTES); ?>" class="inputbox" />
	<img class="calendar" src="./templates/system/images/calendar.png" alt="calendar" id="date_img" />
  </td>
 </tr>
 <tr>
  <td>Book Date </td>
  <td colspan="3">
	<input type="text" name="book_date" id="book_date" size="25" maxlength="19" value="<?php if($row->book_date == "0000-00-00")echo ""; else echo htmlspecialchars($row->book_date, ENT_QUOTES);?>" class="inputbox" />
	<img class="calendar" src="./templates/system/images/calendar.png" alt="calendar" id="book_date_img" />
  </td>
 </tr>
  <tr>
  <td>Staff Member </td>
  <td colspan="3"><?php echo $lists['staff_id']?></td>
 </tr>
  <tr>
  <td style="vertical-align:top;">Description </td>
  <td><textarea class="invoicewriterEntry" name="description" ><?php echo $row->description;?></textarea></td>
 </tr>
 <tr>
  <td>Amount </td>
  <td><input type="text" name="amount" class="inputbox" value="<?php echo round($row->amount,2);?>" /> </td>
  </tr>
  <tr>
	<td>Currency </td>
  <td><input type="text" name="currency" class="inputbox" value ="<?php echo $row->currency; ?>"/> </td>
	 </tr>
 </table>
 <br><br>
<br>

<table width="100%">
<tr>
<td width="98%"/>
<td width="1%"><input type="submit" class="button" name="submitRun" value="Save" onclick="if(validate()) document.adminForm.submit();return false;"></td>
<?php if($updated == 0) { ?>
<td width="1%"><input type="button" class="button" name="submitCancel" value="Cancel" onclick="window.location.href='./index.php?option=com_invoicewriter&task=showSalaries'"></td>
<?php } ?>
</tr>
</table>

</div>

<input type="hidden" name="option" value="com_invoicewriter" />
<input type="hidden" name="task" value="saveSalary" />
<input type="hidden" name="id" value="<?php echo $row->id ?>" />
</form>

<?php
}
/*****************************************************************************
* 
******************************************************************************/
function showFinancialReportCriteria($option){

HTML_invoicewriter_content::printDateIncludes();
HTML_invoicewriter_content::printStylesheetIncludes();
?>
  <script language="javascript" type="text/javascript">
    function validate() {
		if(trim(document.adminForm.start_date.value)==''){
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

	<form action="index.php" method="POST" name="adminForm" >

		<div class="content">
			<?php echo HTML_invoicewriter_content::headerWithLinkToMainMenu("New Financial Report", $startdate); ?>
			<table border="0" cellpadding="3" cellspacing="0" class="adminform">
				<tr>
				  <td>Start Date </td>
				  <td>
					<input type="text" name="start_date" id="start_date" size="25" maxlength="19" value="<?php echo date("Y-m-d"); ?>" class="inputbox" />
					<img class="calendar" src="./templates/system/images/calendar.png" alt="calendar" id="start_date_img" />
				  </td>
				 </tr>
				 <tr>
				  <td>End Date </td>
				  <td>
					<input type="text" name="end_date" id="end_date" size="25" maxlength="19" value="<?php echo date("Y-m-d"); ?>" class="inputbox" />
					<img class="calendar" src="./templates/system/images/calendar.png" alt="calendar" id="end_date_img" />
				  </td>
				 </tr>
			 </table>

			<table width="100%">
				<tr>
				<td width="98%">&nbsp;</td>
				<td width="1%">
					<input type="button" class="button" name="submitRun" value="Create Report" onclick="document.adminForm.task.value='showFinancialReport'; if(validate()) document.adminForm.submit(); return false;">
				</td>
				<td width="1%">
					<input type="button" class="button" name="submitCancel" value="Cancel" onclick="document.adminForm.task.value='mainDisplay'; document.adminForm.submit();return false;"> 
				</td>
				</tr>
			</table>

		</div>

		<input type="hidden" name="option" value="com_invoicewriter" />
		<input type="hidden" name="task" value="" />

	</form>
 <?php
 }
 /*****************************************************************************
* 
******************************************************************************/
function  showFinancialReport($option,$date,$startdate,$enddate,$row_income,$row_expenses,$salaries,$saldo,$debits,$credits,$taxpaid,$vatpaid,$pop){

global $database,$mosConfig_live_site;	
HTML_invoicewriter_content::includeDontPrintStyle(); 
HTML_invoicewriter_content::printDateIncludes();
HTML_invoicewriter_content::printStylesheetIncludes();

$exp_B=0;
$exp_N=0;
$exp_T=0;
$cexp_N=0;
$cexp_T=0;

for($j=0;$j<count($row_expenses);$j++)
{
	$exp_B += $row_expenses[$j]->amount_B ;
	$exp_N += $row_expenses[$j]->amount_N ;
	$exp_T += $row_expenses[$j]->amount_T;
	
	$cexp_N += $row_expenses[$j]->amount_N * ($row_expenses[$j]->perc_deductable /100);
	$cexp_T += $row_expenses[$j]->amount_T * ($row_expenses[$j]->perc_deductable_tax / 100) ;
}
$exp_B += $salaries;
$exp_N += $salaries;
//subtotals
$brut = $row_income->amount_B - $exp_B;
$net = $row_income->amount_N - $exp_N;
$tax = $row_income->amount_T - $exp_T;
if(abs($brut-$net-$tax) > 0.01 ){	?><script language="javascript" type="text/javascript">alert("Check your invoices! Brutto <?php echo $brut; ?> != Netto <?php echo $net; ?> + Tax <?php echo $tax; ?>")</script><?php }
	

//corrected amounts
$cexp_N += $salaries;
$cnet = $row_income->amount_N - $cexp_N ;
$ctax = $row_income->amount_T - $cexp_T;
$cexp_B = $cexp_N + $cexp_T;
$cbrut = $row_income->amount_N - $exp_B + $cexp_T;//$row_income->amount_B - $cexp_N - $cexp_T;

//tax calc

//$brut -= $vatpaid;
$comptax = $cbrut * 0.34;
$endtotal = $cbrut - $comptax;



?>
<div class="content">
<?php if($pop == 0) HTML_invoicewriter_content::headerWithLinkToMainMenu("Financial report", 0); ?>	
<table border="0" cellpadding="3" cellspacing="3" class="adminform" width="100%">
<?php if($pop == 0){?>
	<div style="text-align:right;">
	<a href="./index.php?option=com_invoicewriter&amp;task=showFinancialReportCriteria" title="Edit report criteria">Revise</a>&nbsp;|&nbsp;
	<a href="#" onclick="window.open('<?php echo $mosConfig_live_site; ?>/index2.php?option=com_invoicewriter&amp;task=showFinancialReport&amp;start_date=<?php echo($startdate); ?>&amp;end_date=<?php echo($enddate); ?>&amp;pop=1','win2', 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=yes,resizable=yes,width=640,height=480,directories=no,location=no'); return false;" title="<?php echo _CMN_PRINT;?>">Print</a>
	&nbsp;
	</div>
<?php }?>

<?php if($pop==1){?>
<table border="0" cellpadding="3" cellspacing="3" class="adminform" width="100%">
	<tr>
	  <td ><img src="./components/com_invoicewriter/images/BW.gif"/> </td>
	  <td  style="text-align:right">
		<table border="0" cellpadding="3" cellspacing="3" class="adminform">
		<tr><td>BrainWorX bvba</td></tr>
		<tr><td>BTW BE 0820.393.336</td></tr>
		<tr><td>RPR TURNHOUT</td></tr>
		<tr><td>Wimpstraat 9, 2260 Westerlo</td></tr>
		<tr><td>0032(0)14/54.21.96</td></tr>
		<tr><td>info@brainworx.be</td></tr>
		</table>
	  </td>
	</tr>
</table>
<br><br>
<?php } ?>
<table border="0" cellpadding="1" cellspacing="3" class="adminform" width="100%">
	<tr><td>
		<table border="0" cellpadding="1" cellspacing="3" class="adminform" width="100%">
			<tr>
			  <td style="text-decoration:underline">Date: </td>
			  <td><?php echo $date;?></td>
			 </tr>
			 <tr>
			  <td style="text-decoration:underline" >Description: </td>
			  <td>Temporary Financial Report.</td>
			 <tr>
			  <td style="text-decoration:underline">Period start: </td>
			  <td>
				<?php echo htmlspecialchars($startdate, ENT_QUOTES);?>
			 </td>
			 </tr>
			 <tr>
			  <td style="text-decoration:underline">Period end: </td>
			  <td>
				<?php echo htmlspecialchars($enddate, ENT_QUOTES); ?>
			  </td>
			 </tr>
			 </table>
		 </td></tr>
	 <tr><td>&nbsp;</td></tr>
	 <tr><td>&nbsp;</td></tr>
	 <tr><td>&nbsp;</td></tr>
	<tr><td>
		<table border="0" cellpadding="1" cellspacing="3" class="adminform" width="100%">
			 <tr>
			  <td class="sectiontableentry" style="font-weight:bold">Total pre Taxes:</td>
			  <td class="sectiontableentry" style="text-align:right"><?php echo htmlspecialchars(round($cbrut,2),ENT_QUOTES);?> &nbsp;EUR</td>
			</tr>
			  <tr>
			   <td class="sectiontableentry" style="font-weight:bold">Tax 34%:</td>
			  <td class="sectiontableentry" style="text-align:right"><?php echo htmlspecialchars(round($comptax,2),ENT_QUOTES);?> &nbsp;EUR</td>
			</tr>
			  <tr>
			  <td class="sectiontableentry" style="font-weight:bold">EndTotal:</td>
			  <td class="sectiontableentry" style="text-align:right"><?php echo htmlspecialchars(round($endtotal,2),ENT_QUOTES);?> &nbsp;EUR</td>
			</tr>
			<tr>
			   <td class="sectiontableentry" style="font-weight:bold">Paid Taxes:</td>
			  <td class="sectiontableentry" style="text-align:right"><?php echo htmlspecialchars(round($taxpaid,2),ENT_QUOTES);?> &nbsp;EUR</td>
			</tr>
			<tr>
			   <td class="sectiontableentry" style="font-weight:bold">Expected Tax Saldo:</td>
			  <td class="sectiontableentry" style="text-align:right"><?php echo htmlspecialchars(round($comptax-$taxpaid,2),ENT_QUOTES);?> &nbsp;EUR</td>
			</tr>
		</table>
		</td>
		<td>
		<table border="0" cellpadding="1" cellspacing="3" class="adminform" width="100%">
			 <tr>
			  <td class="sectiontableentry" style="font-weight:bold">Saldo Vat:</td>
			  <td class="sectiontableentry" style="text-align:right"><?php echo htmlspecialchars(round($ctax-$vatpaid,2),ENT_QUOTES);?>&nbsp; EUR</td>
			</tr>
			<tr>
			  <td class="sectiontableentry" style="font-weight:bold">Debit Saldo:</td>
			  <td class="sectiontableentry" style="text-align:right"><?php echo htmlspecialchars(round($debits,2),ENT_QUOTES);?>&nbsp; EUR</td>
			</tr>
			<tr>
			  <td class="sectiontableentry" style="font-weight:bold">Credit Saldo:</td>
			  <td class="sectiontableentry" style="text-align:right"><?php echo htmlspecialchars(round($credits,2),ENT_QUOTES);?> &nbsp;EUR</td>
			</tr>
			<tr>
			  <td class="sectiontableentry" style="font-weight:bold">Investments:</td>
			  <td class="sectiontableentry" style="text-align:right"><?php echo htmlspecialchars(round($invests,2),ENT_QUOTES);?> &nbsp;EUR</td>
			</tr>
			<tr>
			  <td class="sectiontableentry" style="font-weight:bold">Current Account Saldo:</td>
			  <td class="sectiontableentry" style="text-align:right"><?php echo htmlspecialchars(round($saldo,2),ENT_QUOTES);?> &nbsp;EUR</td>
		  </tr>
		</table></td></tr>
</table>
<br><br><br>
<table><tr><td style="font-weight:bold;text-decoration:underline">Detailed overview:</td></tr></table>
<br>
	<table border="0" cellpadding="1" cellspacing="3" class="adminform" width="100%"> 
		 <tr>
			<th class="sectiontableentry" >&nbsp;</th>
			<th class="sectiontableentry" style="text-align:right">Amount</th>
			<th class="sectiontableentry" style="text-align:right">Tax/Vat</th>
			<th class="sectiontableentry" style="text-align:right">Total Amount</th>
			<th class="sectiontableentry" >&nbsp;</th>
		 </tr>
		 <tr>
		  <td class="sectiontableentry" style="font-weight:normal;text-decoration:underline">Received</td>
		  <td colspan="5" />
		 </tr>
		 <tr>
		  <td class="sectiontableentry" >Invoices</td>
		  <td class="sectiontableentry2" style="text-align:right"><?php echo htmlspecialchars(round($row_income->amount_N,2),ENT_QUOTES);?> &nbsp;EUR</td>
		  <td class="sectiontableentry2" style="text-align:right"><?php echo htmlspecialchars(round($row_income->amount_T,2),ENT_QUOTES);?> &nbsp;EUR</td>
		  <td class="sectiontableentry2" style="text-align:right"><?php echo htmlspecialchars(round($row_income->amount_B,2),ENT_QUOTES);?> &nbsp;EUR</td>
		  <td class="sectiontableentry2" >&nbsp;</td>
		 </tr>
		 <tr><td colspan="5">&nbsp;</td></tr>
		 <tr>
		  <td class="sectiontableentry" style="font-weight:normal;text-decoration:underline">Paid</td>
		  <td colspan="4" />
		 </tr>
		  <tr>
		  <td class="sectiontableentry">Salaries</td>
		  <td class="sectiontableentry2" style="text-align:right"><?php echo htmlspecialchars(round($salaries,2),ENT_QUOTES);?> &nbsp;EUR</td>
		  <td class="sectiontableentry2" style="text-align:right">-</td>
		  <td class="sectiontableentry2" style="text-align:right"><?php echo htmlspecialchars(round($salaries,2),ENT_QUOTES);?> &nbsp;EUR</td>
		  <td class="sectiontableentry2" >&nbsp;</td>
		 </tr>
		 <?php for($i=0;$i<count($row_expenses);$i++){ ?>
			 <tr>
			  <td class="sectiontableentry"><?php echo $row_expenses[$i]->description; ?></td>
			  <td class="sectiontableentry2" style="text-align:right"><?php echo htmlspecialchars(round($row_expenses[$i]->amount_N,2),ENT_QUOTES);?>&nbsp;EUR</td>
			  <td class="sectiontableentry2" style="text-align:right"><?php echo htmlspecialchars(round($row_expenses[$i]->amount_T,2),ENT_QUOTES);?> &nbsp;EUR</td>
			  <td class="sectiontableentry2" style="text-align:right"><?php echo htmlspecialchars(round($row_expenses[$i]->amount_B,2),ENT_QUOTES);?> &nbsp;EUR</td>
			  <td class="sectiontableentry2" >&nbsp;</td>
			 </tr>
		 <?php } ?>
		 <tr>
		  <td class="sectiontableentry" style="font-weight:bold;">Total paid</td>
		  <td class="sectiontableentry" style="text-align:right"> <?php echo htmlspecialchars(round($exp_N,2),ENT_QUOTES);?>&nbsp; EUR</td>
		  <td class="sectiontableentry" style="text-align:right"> <?php echo htmlspecialchars(round($exp_T,2),ENT_QUOTES);?> &nbsp;EUR</td>
		  <td class="sectiontableentry" style="text-align:right"> <?php echo htmlspecialchars(round($exp_B,2),ENT_QUOTES);?> &nbsp;EUR</td>
		  <td class="sectiontableentry2" >&nbsp;</td>
		 </tr>
		 <tr><td colspan="5">&nbsp;</td></tr>
		 <tr>
		  <td class="sectiontableentry" style="font-weight:normal;text-decoration:underline">Corrected Data for Tax</td>
		  <td colspan="4" />
		 </tr>
		 <tr>
		  <td class="sectiontableentry">Salaries</td>
		  <td class="sectiontableentry2" style="text-align:right"><?php echo htmlspecialchars(round($salaries,2),ENT_QUOTES);?> &nbsp;EUR</td>
		  <td class="sectiontableentry2" style="text-align:right">-</td>
		  <td class="sectiontableentry2" style="text-align:right"><?php echo htmlspecialchars(round($salaries,2),ENT_QUOTES);?> &nbsp;EUR</td>
		  <td class="sectiontableentry2" >&nbsp;</td>
		 </tr>
		 <?php for($i=0;$i<count($row_expenses);$i++){ 
				$n = $row_expenses[$i]->amount_N*($row_expenses[$i]->perc_deductable/100);
				$t = $row_expenses[$i]->amount_T*($row_expenses[$i]->perc_deductable_tax/100);
				$b = $n + $t;
		 ?>
			 <tr> 
			  <td class="sectiontableentry"><?php echo $row_expenses[$i]->description."(".$row_expenses[$i]->perc_deductable."--".$row_expenses[$i]->perc_deductable_tax.")"; ?></td>
			  <td class="sectiontableentry2" style="text-align:right"><?php echo htmlspecialchars(round($n,2),ENT_QUOTES);?>&nbsp; EUR</td>
			  <td class="sectiontableentry2" style="text-align:right"><?php echo htmlspecialchars(round($t,2),ENT_QUOTES);?> &nbsp;EUR</td>
			  <td class="sectiontableentry2" style="text-align:right"><?php echo htmlspecialchars(round($b,2),ENT_QUOTES);?> &nbsp;EUR</td>
			  <td class="sectiontableentry2" >&nbsp;</td>
			 </tr>
		 <?php } ?>
		  <tr>
		  <td class="sectiontableentry" style="font-weight:bold;">Total corrected</td>
		  <td class="sectiontableentry" style="text-align:right"> <?php echo htmlspecialchars(round($cexp_N,2),ENT_QUOTES);?> &nbsp;EUR</td>
		  <td class="sectiontableentry" style="text-align:right"> <?php echo htmlspecialchars(round($cexp_T,2),ENT_QUOTES);?> &nbsp;EUR</td>
		  <td class="sectiontableentry" style="text-align:right"> <?php echo htmlspecialchars(round($cexp_B,2),ENT_QUOTES);?> &nbsp;EUR</td>
		  <td class="sectiontableentry2" >&nbsp;</td>
		 </tr>
	</table>
<br><br><br><div style="text-align:center" >Brainworx bvba.</div><br><br>
</div>
 <?php
 }
/*****************************************************************************
* expensetype overview
******************************************************************************/
function showExpenseTypes($option, $rows,$pageNav)
{
	HTML_invoicewriter_content::printDateIncludes();
	HTML_invoicewriter_content::printStylesheetIncludes();
?>

<script language="javascript" type="text/javascript">
function doDelete() {
	if (document.adminForm.boxchecked.value == 0){
		alert('Nothing selected, nothing to do.');
	} else {
		if (confirm('Are you sure you want to delete the selected Expense Types?')) {
			document.adminForm.task.value='adminDeleteExpenseType';
			document.adminForm.submit();
		}
	}
}

</script>
<form action="index.php" method="post" name="adminForm">
	<div class="content">
		<?php HTML_invoicewriter_content::headerWithLinkToMainMenu("Manage Expense Types", 0); ?>
		<div style="text-align:right;">
			<a href="#" onClick="window.location.href='./index.php?option=com_invoicewriter&task=newExpensType'">New</a>
			&nbsp;|&nbsp;<a href="#" onClick="doDelete(); return false;">Delete</a>
			&nbsp;
		</div>
			
		  <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
		   <tr>
			<th width="20"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($rows); ?>);" /></th>
			<th class="sectiontableentry">Description</th>
			<th class="sectiontableentry">Deductable</th>
			<th class="sectiontableentry">Deductable Tax</th>
			<th class="sectiontableentry">Start Date</th>
			<th class="sectiontableentry">End Date</th>
		   </tr>
		  <?php
			for($i=0; $i < count( $rows ); $i++) {
				$row = $rows[$i];
			   ?>
				<tr>
				 <td width="20"><input type="checkbox" id="cb<?php echo $i;?>" name="cid[]" value="<?php echo $row->id; ?>" onclick="isChecked(this.checked);" /></td>
				 <td class="sectiontableentry2"><a href="./index.php?option=com_invoicewriter&task=editExpenseType&id=<?php echo $row->id?>"><?php echo htmlspecialchars($row->description, ENT_QUOTES); ?></a></td>
				 <td class="sectiontableentry2"><?php echo $row->perc_deductable; ?>%</td>
				 <td class="sectiontableentry2"><?php echo $row->perc_deductable_tax; ?>%</td>
				 <td class="sectiontableentry2"><?php echo $row->start_date; ?></td>
				 <td class="sectiontableentry2"><?php if($row->end_date == "0000-00-00")echo ""; else echo htmlspecialchars($row->end_date, ENT_QUOTES); ?></td>
				</tr>
		  <?php } ?>
		  
		  </table>
		  <?php
			HTML_invoicewriter_content::paginateList($pageNav, "./index.php?option=com_invoicewriter&task=showExpenseTypes");
		  ?>

		  <input type="hidden" name="option" value="<?php echo $option; ?>" />
		  <input type="hidden" name="task" value="showExpenseTypes" />
		  <input type="hidden" name="boxchecked" value="0" />
	</div>
</form>
 <?php 
}
/******************************************************************************
*
*******************************************************************************/
function editExpenseType($option,$row){
global $mosConfig_live_site;
HTML_invoicewriter_content::printDateIncludes();
HTML_invoicewriter_content::printStylesheetIncludes();

?>
  <script language="javascript" type="text/javascript">
    function validate() {
		if(trim(document.adminForm.start_date.value)==''){
	  		alert("Start Date Is Required" );
	  		return false;
	  	}
		if(trim(document.adminForm.description.value)==''){
			alert("Description is Required" );
			return false;
		}
		if(isNaN(trim(document.adminForm.perc_deductable.value))){
			alert("Percentage deductable must be numeric" );
			return false;
		}	
		if(!(document.adminForm.perc_deductable.value<=100 && document.adminForm.perc_deductable.value>=0 )){
			alert("Percentage deductable must 0 - 100" );
			return false;
		}	
		if(isNaN(trim(document.adminForm.perc_deductable_tax.value))){
			alert("Percentage deductable Tax must be numeric" );
			return false;
		}	
		if(!(document.adminForm.perc_deductable_tax.value<=100 && document.adminForm.perc_deductable_tax.value>=0 )){
			alert("Percentage deductable Tax must 0 - 100" );
			return false;
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

<form action="index.php" method="POST" name="adminForm" >

<div class="content">
<?php HTML_invoicewriter_content::headerWithLinkToMainMenu("Edit Expense Type", 0); ?>
<table border="0" cellpadding="3" cellspacing="0" class="adminform">
  <tr>
  <td>Start Date </td>
  <td >
	<input type="text" name="start_date" id="start_date" size="25" maxlength="19" value="<?php echo htmlspecialchars($row->start_date, ENT_QUOTES); ?>" class="inputbox" />
	<img class="calendar" src="./templates/system/images/calendar.png" alt="calendar" id="start_date_img" />
  </td>
 </tr>
 <tr>
  <td>End Date </td>
  <td >
	<input type="text" name="end_date" id="end_date" size="25" maxlength="19" value="<?php if($row->end_date == "0000-00-00")echo ""; else echo htmlspecialchars($row->end_date, ENT_QUOTES);?>" class="inputbox" />
	<img class="calendar" src="./templates/system/images/calendar.png" alt="calendar" id="end_date_img" />
  </td>
 </tr>
  <tr>
  <td style="vertical-align:top;">Description </td>
  <td ><textarea class="companyEdit" name="description" ><?php echo $row->description;?></textarea></td>
 </tr>
 <tr>
  <td>% Deductable </td>
  <td><input type="text" name="perc_deductable" class="inputbox" value="<?php echo $row->perc_deductable;?>" /> </td>
 </tr>
  <tr>
  <td>% Deductable Tax</td>
  <td><input type="text" name="perc_deductable_tax" class="inputbox" value="<?php echo $row->perc_deductable_tax;?>" /> </td>
 </tr>
</table>
<table width="100%">
<tr>
<td width="98%"/>
<td width="1%"><input type="submit" class="button" name="submitRun" value="Save" onclick="if(validate()) document.adminForm.submit();return false;"></td>
<td width="1%"><input type="button" class="button" name="submitCancel" value="Cancel" onclick="window.location.href='./index.php?option=com_invoicewriter&task=showExpenseTypes'"></td>
</tr>
</table>

</div>
<input type="hidden" name="option" value="com_invoicewriter" />
<input type="hidden" name="task" value="saveExpenseType" />
<input type="hidden" name="id" value="<?php echo $row->id ?>" />
</form>

<?php
}
/*****************************************************************************
* tax type overview
******************************************************************************/
function showTaxTypes($option, $rows,$pageNav)
{
	HTML_invoicewriter_content::printDateIncludes();
	HTML_invoicewriter_content::printStylesheetIncludes();
?>

<script language="javascript" type="text/javascript">
function doDelete() {
	if (document.adminForm.boxchecked.value == 0){
		alert('Nothing selected, nothing to do.');
	} else {
		if (confirm('Are you sure you want to delete the selected Tax Types?')) {
			document.adminForm.task.value='adminDeleteTaxType';
			document.adminForm.submit();
		}
	}
}

</script>
<form action="index.php" method="post" name="adminForm">
	<div class="content">
		<?php HTML_invoicewriter_content::headerWithLinkToMainMenu("Manage Tax Types", 0); ?>
		<div style="text-align:right;">
			<a href="#" onClick="window.location.href='./index.php?option=com_invoicewriter&task=newTaxType'">New</a>
			&nbsp;|&nbsp;<a href="#" onClick="doDelete(); return false;">Delete</a>
			&nbsp;
		</div>
			
		  <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
		   <tr>
			<th width="20"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($rows); ?>);" /></th>
			<th class="sectiontableentry">Description</th>
		   </tr>
		  <?php
			for($i=0; $i < count( $rows ); $i++) {
				$row = $rows[$i];
			   ?>
				<tr>
				 <td width="20"><input type="checkbox" id="cb<?php echo $i;?>" name="cid[]" value="<?php echo $row->id; ?>" onclick="isChecked(this.checked);" /></td>
				 <td class="sectiontableentry2"><a href="./index.php?option=com_invoicewriter&task=editTaxType&id=<?php echo $row->id?>"><?php echo htmlspecialchars($row->description, ENT_QUOTES); ?></a></td>
				</tr>
		  <?php } ?>
		  
		  </table>
		  <?php
			HTML_invoicewriter_content::paginateList($pageNav, "./index.php?option=com_invoicewriter&task=showTaxTypes");
		  ?>

		  <input type="hidden" name="option" value="<?php echo $option; ?>" />
		  <input type="hidden" name="task" value="showTaxTypes" />
		  <input type="hidden" name="boxchecked" value="0" />
	</div>
</form>
 <?php 
}
/******************************************************************************
*
*******************************************************************************/
function editTaxType($option,$row){
global $mosConfig_live_site;
HTML_invoicewriter_content::printDateIncludes();
HTML_invoicewriter_content::printStylesheetIncludes();

?>
  <script language="javascript" type="text/javascript">
    function validate() {
		if(trim(document.adminForm.description.value)==''){
			alert("Description is Required" );
			return false;
		}
      return true;
    }
  </script>

<form action="index.php" method="POST" name="adminForm" >

<div class="content">
<?php HTML_invoicewriter_content::headerWithLinkToMainMenu("Edit Tax Type", 0); ?>
<table border="0" cellpadding="3" cellspacing="0" class="adminform">
  <tr>
  <td style="vertical-align:top;">Description </td>
  <td ><textarea class="companyEdit" name="description" ><?php echo $row->description;?></textarea></td>
 </tr>
</table>
<table width="100%">
<tr>
<td width="98%"/>
<td width="1%"><input type="submit" class="button" name="submitRun" value="Save" onclick="if(validate()) document.adminForm.submit();return false;"></td>
<td width="1%"><input type="button" class="button" name="submitCancel" value="Cancel" onclick="window.location.href='./index.php?option=com_invoicewriter&task=showTaxTypes'"></td>
</tr>
</table>

</div>
<input type="hidden" name="option" value="com_invoicewriter" />
<input type="hidden" name="task" value="saveTaxType" />
<input type="hidden" name="id" value="<?php echo $row->id ?>" />
</form>

<?php
}

/*****************************************************************************
* tax overview
******************************************************************************/
function showTax($option, $rows,$pageNav)
{
	HTML_invoicewriter_content::printDateIncludes();
	HTML_invoicewriter_content::printStylesheetIncludes();

?>

<script language="javascript" type="text/javascript">
function doDelete() {
	if (document.adminForm.boxchecked.value == 0){
		alert('Nothing selected, nothing to do.');
	} else {
		if (confirm('Are you sure you want to delete the selected Taxes?')) {
			document.adminForm.task.value='adminDeleteTax';
			document.adminForm.submit();
		}
	}
}

</script>
<form action="index.php" method="post" name="adminForm">
	<div class="content">
		<?php HTML_invoicewriter_content::headerWithLinkToMainMenu("Manage Taxes", 0); ?>
		<div style="text-align:right;">
			<a href="#" onClick="window.location.href='./index.php?option=com_invoicewriter&task=newTax'">New</a>
			&nbsp;|&nbsp;<a href="#" onClick="doDelete(); return false;">Delete</a>
			&nbsp;
		</div>
			
		  <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
		   <tr>
			<th width="20"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($rows); ?>);" /></th>
			<th class="sectiontableentry">Date</th>			
			<th style="text-align:center" class="sectiontableentry">Global Description</th>
			<th style="text-align:right" class="sectiontableentry">Amount</th>
			<th style="text-align:center" class="sectiontableentry">Book date</th>
		   </tr>
		  <?php
			for($i=0; $i < count( $rows ); $i++) {
				$row = $rows[$i];
			   ?>
				<tr>
				 <td width="20"><input type="checkbox" id="cb<?php echo $i;?>" name="cid[]" value="<?php echo $row->id; ?>" onclick="isChecked(this.checked);" /></td>
				 <td style="text-align:center" class="sectiontableentry2"><a href="./index.php?option=com_invoicewriter&task=editTax&id=<?php echo $row->id?>"><?php echo htmlspecialchars($row->date, ENT_QUOTES); ?></a></td>
				 <td style="text-align:left" class="sectiontableentry2"><?php echo htmlspecialchars($row->global_description, ENT_QUOTES); ?></td>
				 <td style="text-align:right" class="sectiontableentry2"><?php echo round($row->amount,2); echo (" ".$row->currency);?></td>
				 <td style="text-align:center" class="sectiontableentry2"><?php 
				 if($row->book_date == "0000-00-00")echo "<img src='./components/com_invoicewriter/images/publish_x.png' border='0' />&nbsp;&nbsp;"; 
				 else echo (htmlspecialchars($row->book_date, ENT_QUOTES)."&nbsp;"); 
				 ?>
				 </td>
				</tr>
		  <?php } ?>
		  </table>
		  <?php
			/*
			for this add following code in invoicewriter.php and add pagenav in this call!
			$limit = getSessionValue('limit', $mosConfig_list_limit);
			$limitstart = getSessionValue('limitstart', 0);
			require_once( $mosConfig_absolute_path .'/includes/pageNavigation.php' );
			$pageNav = new mosPageNav( $total, $limitstart, $limit );
			*/
			HTML_invoicewriter_content::paginateList($pageNav, "./index.php?option=com_invoicewriter&task=showTax");
		  ?>

		  <input type="hidden" name="option" value="<?php echo $option; ?>" />
		  <input type="hidden" name="task" value="showTax" />
		  <input type="hidden" name="boxchecked" value="0" />
	</div>
</form>
 <?php 
}
/******************************************************************************
*
*******************************************************************************/
function editTax($option,$row,$lists){
global $mosConfig_live_site;
HTML_invoicewriter_content::printDateIncludes();
HTML_invoicewriter_content::printStylesheetIncludes();

?>
  <script language="javascript" type="text/javascript">
    function validate() {
		if(trim(document.adminForm.date.value)==''){
	  		alert("Date Is Required" );
	  		return false;
	  	}
		if(trim(document.adminForm.taxtype_id.value)=='0'){
			alert("Please select the expense type" );
			return false;
		}
		if(isNaN(trim(document.adminForm.amount.value))){
			alert("Amount must be numeric" );
			return false;
		}	
		if((document.adminForm.amount.value)=='0'){
			alert("Please make sure to enter an amount or add lines to the invoice." );
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
window.addEvent('domready', function() {Calendar.setup({
        inputField     :    "book_date",     // id of the input field
        ifFormat       :    "%Y-%m-%d",      // format of the input field
        button         :    "book_date_img",  // trigger for the calendar (button ID)
        align          :    "Tl",           // alignment (defaults to "Bl")
        singleClick    :    true
    });});
  </script>

<form action="index.php" method="POST" name="adminForm" >

<div class="content">
<?php HTML_invoicewriter_content::headerWithLinkToMainMenu("Edit Tax", 0); ?>
<table border="0" cellpadding="3" cellspacing="0" class="adminform">
<?php if($row->id >0){ ?>
	  <tr>
	  <td>ID </td>
	  <td colspan="3">TAX00<?php echo htmlspecialchars($row->id, ENT_QUOTES); ?></td>
	 </tr> <tr><td colspan="4">&nbsp;</td></tr>
 <?php } ?>
      <tr>
  <td>Tax type </td>
  <td colspan="3"><?php echo $lists['taxtype_id']?></td>
 </tr>
 <tr><td colspan="4">&nbsp;</td></tr>
  <tr>
  <td>Date </td>
  <td colspan="3">
	<input type="text" name="date" id="date" size="25" maxlength="19" value="<?php echo htmlspecialchars($row->date, ENT_QUOTES); ?>" class="inputbox" />
	<img class="calendar" src="./templates/system/images/calendar.png" alt="calendar" id="date_img" />
  </td>
 </tr>
  <tr>
  <td>Amount </td>
  <td colspan="2"><input type="text" name="amount" class="inputbox" value="<?php echo round($row->amount,2);?>" />&nbsp;EUR</td>
  <td colspan="2" style="text-align:left;">&nbsp;</td>
 </tr>
 <tr><td colspan="4">&nbsp;</td></tr>
  <tr>
  <td style="vertical-align:top;">Description </td>
  <td><textarea class="companyEdit" name="description" ><?php echo $row->description;?></textarea></td>
 </tr>
 <tr>
  <td>Book Date </td>
  <td colspan="3">
	<input type="text" name="book_date" id="book_date" size="25" maxlength="19" value="<?php if($row->book_date == "0000-00-00")echo ""; else echo htmlspecialchars($row->book_date, ENT_QUOTES);?>" class="inputbox" />
	<img class="calendar" src="./templates/system/images/calendar.png" alt="calendar" id="book_date_img" />
  </td>
 </tr>
 </table>
<br><br>

<table width="100%">
<tr>
<td width="98%"/>
<td width="1%"><input type="submit" class="button" name="submitRun" value="Save" onclick="if(validate()) document.adminForm.submit();return false;"></td>
<?php if($updated == 0) { ?>
<td width="1%"><input type="button" class="button" name="submitCancel" value="Cancel" onclick="window.location.href='./index.php?option=com_invoicewriter&task=showTax'"></td>
<?php } ?>
</tr>
</table>

</div>
<input type="hidden" name="option" value="com_invoicewriter" />
<input type="hidden" name="task" value="saveTax" />
<input type="hidden" name="id" value="<?php echo $row->id ?>" />
</form>

<?php
}
/*****************************************************************************
* Investments overview
******************************************************************************/
function showInvests($option, $rows,$pageNav)
{
	HTML_invoicewriter_content::printDateIncludes();
	HTML_invoicewriter_content::printStylesheetIncludes();

?>

<script language="javascript" type="text/javascript">
function doDelete() {
	if (document.adminForm.boxchecked.value == 0){
		alert('Nothing selected, nothing to do.');
	} else {
		if (confirm('Are you sure you want to delete the selected Investments?')) {
			document.adminForm.task.value='adminDeleteInvest';
			document.adminForm.submit();
		}
	}
}

</script>
<form action="index.php" method="post" name="adminForm">
	<div class="content">
		<?php HTML_invoicewriter_content::headerWithLinkToMainMenu("Manage Investments", 0); ?>
		<div style="text-align:right">
			<a href="#" onClick="window.location.href='./index.php?option=com_invoicewriter&task=newInvest'">New</a>
			&nbsp;|&nbsp;<a href="#" onClick="doDelete(); return false;">Delete</a>
			&nbsp;
		</div>
			
		  <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
		   <tr>
			<th width="20"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($rows); ?>);" /></th>	
			<th style="text-align:left" class="sectiontableentry">ID</th>
			<th style="text-align:center" class="sectiontableentry">Description</th>
			<th style="text-align:right" class="sectiontableentry">Amount</th>
			<th style="text-align:center" class="sectiontableentry">Book date</th>
			<th width="20">&nbsp;</td>
		   </tr>
		  <?php
			for($i=0; $i < count( $rows ); $i++) {
				$row = $rows[$i];
			   ?>
				<tr>
				 <td width="20"><input type="checkbox" id="cb<?php echo $i;?>" name="cid[]" value="<?php echo $row->id; ?>" onclick="isChecked(this.checked);" /></td>
				 <td style="text-align:left" class="sectiontableentry2"><a href="./index.php?option=com_invoicewriter&task=editExpense&id=<?php echo "INV00".$row->id?>"><?php echo $row->id; ?></a></td>
				 <td style="text-align:left" class="sectiontableentry2"><?php echo htmlspecialchars($row->description, ENT_QUOTES); ?></td>
				 <td style="text-align:right" class="sectiontableentry2"><?php echo round($row->amount,2); echo (" ".$row->currency);?></td>
				 <td style="text-align:center" class="sectiontableentry2"><?php 
				 if($row->book_date == "0000-00-00")echo "<img src='./components/com_invoicewriter/images/publish_x.png' border='0' />&nbsp;&nbsp;"; 
				 else echo (htmlspecialchars($row->book_date, ENT_QUOTES)."&nbsp;"); 
				 ?>
				 </td>
				 <td width="20">&nbsp;</td>
				</tr>
		  <?php } ?>
		  </table>
		  <?php
			/*
			for this add following code in invoicewriter.php and add pagenav in this call!
			$limit = getSessionValue('limit', $mosConfig_list_limit);
			$limitstart = getSessionValue('limitstart', 0);
			require_once( $mosConfig_absolute_path .'/includes/pageNavigation.php' );
			$pageNav = new mosPageNav( $total, $limitstart, $limit );
			*/
			HTML_invoicewriter_content::paginateList($pageNav, "./index.php?option=com_invoicewriter&task=showInvests");
		  ?>

		  <input type="hidden" name="option" value="<?php echo $option; ?>" />
		  <input type="hidden" name="task" value="showInvests" />
		  <input type="hidden" name="boxchecked" value="0" />
	</div>
</form>
 <?php 
}
/******************************************************************************
*
*******************************************************************************/
function editInvest($option,$row,$lists){
global $mosConfig_live_site;
HTML_invoicewriter_content::printDateIncludes();
HTML_invoicewriter_content::printStylesheetIncludes();

?>
  <script language="javascript" type="text/javascript">
    function validate() {
		if(trim(document.adminForm.description)==''){
			alert("Please enter a description!" );
			return false;
		}
		if(isNaN(trim(document.adminForm.amount.value))){
			alert("Amount must be numeric" );
			return false;
		}	
		if((document.adminForm.amount.value)=='0'){
			alert("Please make sure to enter an amount." );
		}	
      return true;
    }

window.addEvent('domready', function() {Calendar.setup({
        inputField     :    "book_date",     // id of the input field
        ifFormat       :    "%Y-%m-%d",      // format of the input field
        button         :    "book_date_img",  // trigger for the calendar (button ID)
        align          :    "Tl",           // alignment (defaults to "Bl")
        singleClick    :    true
    });});
  </script>

<form action="index.php" method="POST" name="adminForm" >

<div class="content">
<?php HTML_invoicewriter_content::headerWithLinkToMainMenu("Edit Investment", 0); ?>
<table border="0" cellpadding="3" cellspacing="0" class="adminform">
<?php if($row->id >0){ ?>
	  <tr>
	  <td>ID </td>
	  <td colspan="3">INV00<?php echo htmlspecialchars($row->id, ENT_QUOTES); ?></td>
	 </tr> <tr><td colspan="4">&nbsp;</td></tr>
 <?php } ?>
 <tr><td colspan="5">&nbsp;</td></tr>
  <tr>
  <td style="vertical-align:top;">Description </td>
  <td><textarea class="companyEdit" name="description" ><?php echo $row->description;?></textarea></td>
 </tr>
 <tr>
  <td>Book Date </td>
  <td colspan="3">
	<input type="text" name="book_date" id="book_date" size="25" maxlength="19" value="<?php if($row->book_date == "0000-00-00")echo ""; else echo htmlspecialchars($row->book_date, ENT_QUOTES);?>" class="inputbox" />
	<img class="calendar" src="./templates/system/images/calendar.png" alt="calendar" id="book_date_img" />
  </td>
 </tr>
  <tr>
  <td>Amount </td>
  <td><input type="text" name="amount" class="inputbox" value="<?php echo round($row->amount,2);?>" />&nbsp;<input type="text" name="currency" class="inputboxS" value="<?php echo $row->currency;?>" /></td>
  <td colspan="4" />
 </tr>
 </table>
<br><br>

<table width="100%">
<tr>
<td width="98%"/>
<td width="1%"><input type="submit" class="button" name="submitRun" value="Save" onclick="if(validate()) document.adminForm.submit();return false;"></td>
<?php if($updated == 0) { ?>
<td width="1%"><input type="button" class="button" name="submitCancel" value="Cancel" onclick="window.location.href='./index.php?option=com_invoicewriter&task=showInvests'"></td>
<?php } ?>
</tr>
</table>

</div>
<input type="hidden" name="option" value="com_invoicewriter" />
<input type="hidden" name="task" value="saveInvest" />
<input type="hidden" name="id" value="<?php echo $row->id ?>" />
</form>

<?php
}
// Class closing bracket
}