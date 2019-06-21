<?php
/**
* BrainWorX Invoicewriter Component
* @package Invoicewriter
* @copyright (C) 2010 BrainWorX / All rights reserved
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @link http://www.BrainWorX.be
*
* @Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
* @author Stijn Heylen / BrainWorX
**/


defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

// Various PHP error logging levels for testing.
// error_reporting(E_ALL ^ E_NOTICE);
// error_reporting(E_ALL);

require_once dirname(__FILE__) . '/invoicewriter.html.php';
require_once dirname(__FILE__) . '/../../administrator/components/com_invoicewriter/class.invoicewriter.php';
require_once dirname(__FILE__) . '/../../administrator/components/com_invoicewriter/admin.invoicewriter.html.php';


require_once( $mainframe->getPath( 'admin_html' ) );

// Include the language file.
 if (file_exists(dirname(__FILE__) . '/language/' . $mosConfig_lang . '.php')) {
	require_once dirname(__FILE__) . '/language/' . $mosConfig_lang . '.php';
} else {
	require_once dirname(__FILE__) . '/language/english.php';
}


global $database, $mainframe;

$task = trim( mosGetParam( $_REQUEST, 'task', '' ) );
$startdate = trim( mosGetParam( $_REQUEST, 'start_date', '' ) );
$enddate = trim( mosGetParam( $_REQUEST, 'end_date', '' ) );
$companyid = trim( mosGetParam( $_REQUEST, 'company_id', '' ) );
$fordate = trim( mosGetParam( $_REQUEST, 'for_date', '' ) );
$incomingid = mosGetParam( $_REQUEST, 'incoming_id', array() );
$userids = mosGetParam( $_REQUEST, 'user_ids', array() );  
$user = $mainframe->getUser();
$userid	= $user->id;
$username = $user->name;
$cid = mosGetParam( $_REQUEST, 'cid', '' );

$iid = mosGetParam( $_REQUEST, 'iid', '' );
$pop = mosGetParam( $_REQUEST, 'pop', '' );
$ilid = mosGetParam( $_REQUEST, 'ilid', '' );
$ivid = mosGetParam( $_REQUEST, 'ivid', '' );
$sid = mosGetParam( $_REQUEST, 'sid', '' );
$id = mosGetParam( $_REQUEST, 'id', '' );
$redirectExpenseid = mosGetParam( $_REQUEST, 'redirectExpenseid', '' );
$redirectStaffid = mosGetParam( $_REQUEST, 'redirectStaffid', '' );
$uid = mosGetParam( $_REQUEST, 'uid', '' );
$updated = mosGetParam( $_REQUEST, 'updated', '' );

if (!is_array( $ivid )) {
	$ivid = array($ivid);
}
if (!is_array( $cid )) {
	$cid = array($cid);
}

if($userid == NULL){
	mosRedirect( "index.php","You need to be logged in to view this resource");
	return;
}

// ********************************************************************
if (preg_match( "/^admin/i", $task )) {
	if(! preg_match( "/admin/i", $user->usertype ))
		mosRedirect( "index.php?option=$option&amp;task=mainDisplay","You are not authorised to perform this operation, contact the administrator.");
}
// ********************************************************************

switch($task){

	/*******
	* Incoming invoices
	**/
	case 'printInvoice':
		showIncomingInvoicePrint($option,$cid);
		break;
	case 'showIncomingInvoice':
		showIncomingInvoice($option,$iid,$pop);
		break;
	case 'showIncomingInvoices':
		showIncomingInvoices($option);
		break;
	case 'editIncomingInvoice':
		editIncomingInvoice($option,$iid,$updated);
		break;
	case 'newIncomingInvoice':
		editIncomingInvoice($option,0,0);
		break;
	case 'newIncomingInvoiceByCompanyCriteria':
		newIncomingInvoiceByCompanyCriteria($option,$startdate,$enddate,$fordate,$companyid);
		break;
	case 'newIncomingInvoiceByCompany':
		newIncomingInvoiceByCompany($option,$companyid,$startdate,$enddate,$fordate);
		break;
	case 'saveIncomingInvoice':
		saveIncomingInvoice($option);
		break;
	case 'editInvoiceFPLine':
		editInvoiceFPLine($option,$iid,$ilid);
		break;
	case 'deleteInvoiceFPLine':
		deleteInvoiceFPLine($option,$iid,$ilid);
		break;
	case 'newInvoiceFPLine':
		editInvoiceFPLine($option,$iid,0);
		break;
	case 'saveInvoiceFPLine':
		saveInvoiceFPLine($option);
		break;	
	case 'adminDeleteInvoice':
		adminDeleteInvoice($option,$cid);
		break;	
	/*******
	* Expenses
	**/
	case 'showExpenses':
		showExpenses($option);
		break;
	case 'editExpense':
		editExpense($option,$id);
		break;
	case 'newExpense':
		editExpense($option,0);
		break;
	case 'saveExpense':
		saveExpense($option);
		break;
	case 'adminDeleteExpense':
		adminDeleteExpense($option,$cid);
		break;
	/*******
	* Expense type
	**/
	case 'showExpenseTypes':
		showExpenseTypes($option);
		break;
	case 'editExpenseType':
		editExpenseType($option,$id);
		break;
	case 'newExpenseType':
		editExpenseType($option,0);
		break;
	case 'saveExpenseType':
		saveExpenseType($option);
		break;
	case 'adminDeleteExpenseType':
		adminDeleteExpenseType($option,$cid);
		break;
	/*******
	* Tax
	**/
	case 'showTax':
		showTax($option);
		break;
	case 'editTax':
		editTax($option,$id);
		break;
	case 'newTax':
		editTax($option,0);
		break;
	case 'saveTax':
		saveTax($option);
		break;
	case 'adminDeleteTax':
		adminDeleteTax($option,$cid);
		break;
	/*******
	* Tax type
	**/
	case 'showTaxTypes':
		showTaxTypes($option);
		break;
	case 'editTaxType':
		editTaxType($option,$id);
		break;
	case 'newTaxType':
		editTaxType($option,0);
		break;
	case 'saveTaxType':
		saveTaxType($option);
		break;
	case 'adminDeleteTaxType':
		adminDeleteTaxType($option,$cid);
		break;
	/*******
	* Suppliers
	**/
	case 'showSuppliers':
		showSuppliers($option);
		break;
	case 'newSupplier':
		editSupplier($option,0,$redirectExpenseid);
		break;
	case 'editSupplier':
		editSupplier($option,$id);
		break;
	case 'saveSupplier':
		saveSupplier($option,$redirectExpenseid);
		break;
	case 'adminDeleteSupplier':
		adminDeleteSupplier($option,$cid);
		break;
	/*******
	* Staff
	**/
	case 'showStaff':
		showStaff($option);
		break;
	case 'newStaffMember':
		editStaffMember($option,0);
		break;
	case 'editStaffMember':
		editStaffMember($option,$id);
		break;
	case 'saveStaffMember':
		saveStaffMember($option);
		break;
	case 'adminDeleteStaffMember':
		adminDeleteStaffMember($option,$cid);
		break;
	/*******
	* Users
	**/
	case 'showUsers':
		showUsers($option);
		break;
	case 'editUser':
		editUser($option,$id,$redirectStaffid);
		break;
	case 'saveUser':
		saveUser($option,$redirectStaffid);
		break;
	/*******
	* Salary
	**/
	case 'showSalaries':
		showSalaries($option);
		break;
	case 'editSalary':
		editSalary($option,$id);
		break;
	case 'newSalary':
		editSalary($option,0);
		break;
	case 'saveSalary':
		saveSalary($option);
		break;
	case 'adminDeleteSalary':
		adminDeleteSalary($option,$cid);
		break;
	/*******
	* Investments
	**/
	case 'showInvests':
		showInvests($option);
		break;
	case 'editInvest':
		editInvest($option,$id);
		break;
	case 'newInvest':
		editInvest($option,0);
		break;
	case 'saveInvest':
		saveInvest($option);
		break;
	case 'adminDeleteInvest':
		adminDeleteInvest($option,$cid);
		break;
	/*******
	* Report
	**/
	case 'showFinancialReportCriteria':
		showFinancialReportCriteria($option);
		break;
	case 'showFinancialReport':
		showFinancialReport($option,$startdate,$enddate,$pop);
		break;
	// ********************************************************************
	case "fallback":
	default:
		mainDisplay($option, $fordate);
		break;
}

/******************************************************************************
 *  Used to set and get session variables on the Front end.
******************************************************************************/
function getSessionValue($limit='limitstart', $default=0) {

	$returnValue = $default;
    if (isset($_GET[$limit]) || isset($_POST[$limit])) {
		if (isset($_GET[$limit])) {
			$returnValue = $_GET[$limit];	  
		} else {
			$returnValue = $_POST[$limit];	  
		}
		// echo $limit ."=".$returnValue;	
		setcookie($limit, $returnValue);
	} else {
		if (isset($_COOKIE[$limit])) {
			$returnValue = mosGetParam( $_COOKIE, $limit);
		}
		// echo $limit .":".$returnValue;
	}
	return $returnValue;
}


/******************************************************************************
 *  Cast each element of an Array as Integer before appending it to the output.
******************************************************************************/
function implodeIntArray($intArr, $delim=",") {
	$output = "";

	// echo "count:".count($intArr);
	for($i=0; $i < count( $intArr ); $i++) {
		if (strlen(trim($intArr[$i])) > 0) { 
			$output .= ($i>0?$delim:"") . (int)$intArr[$i];
		}
	}
	return $output;
}

/******************************************************************************
 * 
******************************************************************************/
function prevTitleNext($fordate) {
/*  
	// PHP 5.2+ only
	$pdate = new DateTime($fordate);
	$pdate->modify("-1 day");
	$date = new DateTime($fordate);
	$ndate = new DateTime($fordate);
	$ndate->modify("+1 day");

	return array("prev" => $pdate->format("Y-m-d"),
				 "title" => $date->format("l, F j, Y"),
				 "next" => $ndate->format("Y-m-d"));
*/
	global $database;

	// Calculate next and previous dates
	$query = "SELECT concat(lpad(YEAR(".$database->Quote($fordate)." + INTERVAL 1 DAY),4,'0'),'-',lpad(MONTH(".$database->Quote($fordate)." + INTERVAL 1 DAY),2,'0'),'-',lpad(day(".$database->Quote($fordate)." + INTERVAL 1 DAY),2,'0')) AS next_day," 
		   ." concat(lpad(YEAR(".$database->Quote($fordate)." - INTERVAL 1 DAY),4,'0'),'-',lpad(MONTH(".$database->Quote($fordate)." - INTERVAL 1 DAY),2,'0'),'-',lpad(day(".$database->Quote($fordate)." - INTERVAL 1 DAY), 2,'0')) AS prev_day";

	$database -> setQuery($query);
	$tablerows = $database->loadObjectList();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}
	return array("prev" => $tablerows[0]->prev_day, 
				 "title" => HTML_invoicewriter_content::fmtDate($fordate, "l, F j, Y"), 
				 "next" => $tablerows[0]->next_day);

}


/******************************************************************************
 * 
******************************************************************************/
function buildDateCriteria($startdate, $enddate) {
	$criteria = "";
	if ($startdate == $enddate) {
		$criteria .= "<li>Date: ".$startdate."</li>";
	} else {
		$criteria .= "<li>Start Date: ".$startdate."</li><li>End Date: ".$enddate."</li>";
	}
	return $criteria;
}
/******************************************************************************
 * 
******************************************************************************/
function mainDisplay( $option, $fordate) {
	global $database, $mainframe;
	$user=$mainframe->getUser();
	$userid=$user->id;
	$name = $user->name;
	$isadmin=(preg_match( "/admin/i", $user->usertype )?1:0);
	
	HTML_invoicewriter_content::mainDisplay($option,$isadmin,$name);
	
}
/******************************************************************************
 * 
******************************************************************************/
function newIncomingInvoiceByCompanyCriteria($option,$startdate,$enddate,$fordate,$companyid){
	global $database;

	//var2 is de var waarin de form in html de selectedvalue submit
	$lists['company_id'] = HTML_invoicewriter::companyselect( 'company_id', $companyid, 1, '', 'company_name', '- No Company -', 1, $userid);
	 
	HTML_invoicewriter_content::newIncomingInvoiceByCompanyCriteria($option,$startdate,$enddate,$fordate,$lists);
}
/******************************************************************************
 * 
******************************************************************************/
function newIncomingInvoiceByCompany($option,$companyid,$startdate,$enddate,$fordate){
	global $database;
	//check general contractor
	$query = "SELECT count(1) FROM f9ko_oc_company WHERE general_contractor_id = ".$companyid;
	$database->setQuery($query);
	$found = $database->loadResult();
	if ($found > 0) {
		$where_company = " AND pc.general_contractor_id = ".$companyid." AND pc.id = p.company_id ";
	}
	else {
		$general_contractor = false;
		$where_company = " AND p.company_id = ".$companyid;
	}

	//get total hours
	$query = "SELECT sum(pt.total_hours) as total_hours"
						. " FROM f9ko_oc_timesheets AS pt"
						. " LEFT JOIN f9ko_users AS u ON (pt.user_id = u.id)"
						. " LEFT JOIN f9ko_oc_project AS p ON (pt.project_id = p.id)"
						. " LEFT JOIN f9ko_oc_company AS pc ON (p.company_id = pc.id)"
						. " WHERE pt.date >= ".$database->Quote($startdate)
						. " AND pt.date <= ".$database->Quote($enddate)
						. $where_company
						. " AND pt.is_billable = 1";
	$database->setQuery($query);
	$total = $database->loadResult();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}

	if($total > 0){
		$row = new josIVIncome( $database );
		// Setup new entry defaults
		$row->id = 0;
		$row->company_id = $companyid;
		$row->date = $fordate;
		//create unique invoice id
		
		$row->iv_id = createInvoiceKey($fordate);
		$row->ogm = createInvoiceOGM($row->iv_id,$row->company_id);
		
		$row->period_start = $startdate;
		$row->period_end = $enddate;
		$row->description = "IT Consulting";
		$row->currency = "EUR";
		$row->book_date = "";
		
		// Get the description 
		$descrip = "";

		$query = "SELECT count(1) FROM f9ko_oc_project WHERE company_id = ".$companyid;
		$database->setQuery($query);
		$contracts = $database->loadResult();
		if ($contracts > 0) {
			$query = "SELECT description FROM f9ko_oc_project WHERE company_id = ".$companyid ." AND start_date <= ".$database->Quote($startdate)
					. " AND end_date >= ".$database->Quote($startdate);

			$database -> setQuery($query);
			if($generalcontracts >1){
				$rows = $database->loadObjectList();
				if ($database->getErrorNum()) {
					echo $database->stderr();
					exit();
				}
				for($i=0 ; $i < count($rows) ; $i++){
					$descrip = $descrip." - ".$rows[$i]->description;
				}
			}
			else{
				$descrip = $database->loadResult();
				if ($database->getErrorNum()) {
					echo $database->stderr();
				}
			}
		}
		$row->description=$descrip;
		

		if($found > 0){
			$query = "SELECT count(1) FROM f9ko_oc_company WHERE general_contractor_id = ".$companyid;
			$database->setQuery($query);
			$generalcontracts = $database->loadResult();
			if ($generalcontracts > 0) {
				$query = "SELECT company_name FROM f9ko_oc_company WHERE general_contractor_id = ".$companyid;
				$database -> setQuery($query);
				$descrip = $descrip." at ";
				if($generalcontracts >1){
					$rows = $database->loadObjectList();
					if ($database->getErrorNum()) {
						echo $database->stderr();
						exit();
					}
					for($i=0 ; $i < count($rows) ; $i++){
						$descrip = $descrip." - ".$rows[$i]->company_name;
					}
				}
				else{
					$descrip = $database->loadResult();
					if ($database->getErrorNum()) {
						echo $database->stderr();
					}
				}
				$row->description=$row->description." at ".$descrip;
			}
			
		}


		// Save basic invoice
		if (!$row->store()) {
			echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>";
			exit();
		}
		$iid = $row->id;
		
		// Save lines
		$netInvAmount = 0;
		
		if($found>1){
			$query = "SELECT id FROM f9ko_oc_company WHERE general_contractor_id = ".$companyid;
			$database -> setQuery($query);
			$rows = $database->loadObjectList();
			if ($database->getErrorNum()) {
				echo $database->stderr();
				exit();
			}
			for($i=0 ; $i < count($rows) ; $i++){
				$where_company = " AND p.company_id = ".$rows[i]->id;
				$query = "SELECT sum(pt.total_hours) as total_hours"
						. " FROM f9ko_oc_timesheets AS pt"
						. " LEFT JOIN f9ko_users AS u ON (pt.user_id = u.id)"
						. " LEFT JOIN f9ko_oc_project AS p ON (pt.project_id = p.id)"
						. " LEFT JOIN f9ko_oc_company AS pc ON (p.company_id = pc.id)"
						. " WHERE pt.date >= ".$database->Quote($startdate)
						. " AND pt.date <= ".$database->Quote($enddate)
						. $where_company
						. " AND pt.is_billable = 1";
				$database->setQuery($query);
				$total = $database->loadResult();
				if ($database->getErrorNum()) {
					echo $database->stderr();
					return false;
				}
				if($total > 0){
					$netInvAmount += saveFPLine($total,$rows[i],$iid,true,$startdate,$enddate);
				}
			}
		}
		else {
			if($found == 1){
				$query = "SELECT id FROM f9ko_oc_company WHERE general_contractor_id = ".$companyid;
				$database->setQuery($query);
				$companyid = $database->loadResult();
				if ($database->getErrorNum()) {
					echo $database->stderr();
				}
				$netInvAmount = saveFPLine($total,$companyid,$iid,true,$startdate,$enddate);
			}else{
			//No subcontract - get rate and add line
				$netInvAmount = saveFPLine($total,$companyid,$iid,false,$startdate,$enddate);
			}
		}
		//update invoice with total amount
		$row->amount = $netInvAmount;
		$row->tax_perc = 21;
		$row->tax = $row->amount * $row->tax_perc /100;
		$row->total_amount = $row->amount + $row->tax;
		/*$paymentid = date("Y")."00".$row->id;
		$row->ogm=(int)$paymentid;*/
		$row->due_date=date("Y-m-d",strtotime($row->date . " +30 days"));
		if (!$row->store()) {
			echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>";
			exit();
		}
		 
		
		showIncomingInvoice($option,$row->id);
		
	}else{
		//no hours done
		mosRedirect( "index.php?option=$option&amp;task=mainDisplay");
	}
}
/************************************************************************
create an unique key for invoices
************************************************************************/
function createInvoiceKey($fordate){
	global $database;
//create unique invoice id
//get the year from a date
		$year =  date("Y", strtotime($fordate)); 
		$query = "SELECT count(*)"
						. " FROM f9ko_iv_income"
						. " WHERE iv_id like 'FC".$year."%'";
		$database -> setQuery($query);
		$iv_id = $database->loadResult();
		$iv_id += 1;
		$iv_id_t = "FC".$year;
		if($iv_id < 10){
			$iv_id_t = $iv_id_t."00".$iv_id;
		}else if($iv_id < 100){
			$iv_id_t = $iv_id_t."0".$iv_id;
		}else{
			$iv_id_t = $iv_id_t."".$iv_id;
		}
		
		return $iv_id_t;

}

/************************************************************************
create an unique ogm for invoices
************************************************************************/
function createInvoiceOGM($invoice_id,$company){
	//ogm xxx/xxxx/xxxxx (compid/year/sequence.modulo97)
	$com =  $company;
	$part1 = $com; //3
	while($com < 100){
		$part1 = "0".$part1;
		$com*=10;
	}
	$part2 = substr($invoice_id,2,4); //4
	$part3 = substr($invoice_id,6,3); //3
	$temp = $part1."".$part2."".$part3;
	$temp2 = ((int)$temp)%97;
	$part4 = $temp2; //2
	while($temp2<10){
		$part4 = "0".$part4;
		$temp2 *= 10;
	}

	$ogm = "+++".$part1."/".$part2."/".$part3."".$part4."+++";
	return $ogm;
}
/******************************************************************************
* gets the rate, saves a line and return the total line amount
******************************************************************************/
function saveFPLine($total,$companyid,$iid,$subcontract,$startdate,$enddate){
	global $database;
	$query = "SELECT rate_hour FROM f9ko_oc_project as p"
								. " WHERE p.start_date <= ".$database->Quote($startdate)
								. " AND p.end_date >= ".$database->Quote($enddate)
								. " AND p.company_id = ".$companyid;
						
	$unit = "HOUR";

	if($subcontract)
	{
		$database->setQuery($query);
		$rate_hour = $database->loadResult();

		$query2 = "SELECT hours_day FROM f9ko_oc_project as p"
					. " WHERE p.start_date <= ".$database->Quote($startdate)
					. " AND p.end_date >= ".$database->Quote($enddate)
					. " AND p.company_id = ".$companyid;
		$database->setQuery($query2);
		$hours_day = $database->loadResult();
		
		if($hours_day > 0){
			$unit = "DAY";
			$rate_hour = $rate_hour * $hours_day;
			$total = $total / $hours_day;
		}
		if ($database->getErrorNum()) {
			echo $database->stderr();
			$rate_hour = -1;
		}
	}
	else
	{
		$database->setQuery($query);
		$rrows = $database->loadObjectList();
		if ($database->getErrorNum()) {
			echo $database->stderr();
		}
		else{
			$rate_hour = $rrows[0]->rate_hour;
		}
	}
	
	if($rate_hour <= 1)
	{
		$query = "SELECT up.rate_hour FROM f9ko_oc_user_prefs as up"
									. " LEFT JOIN f9ko_oc_project AS p ON (up.project_id = p.id)"
									. " LEFT JOIN f9ko_oc_company AS pc ON (p.company_id = pc.id)"
									. " WHERE pc.id = ".$companyid;
		$database->setQuery($query);
		$urows = $database->loadObjectList();
		if ($database->getErrorNum()) {
			echo $database->stderr();
		}
		else{
			$rate_hour = $urows[0]->rate_hour;
		}
	}
	if($subcontract){
	
//		$query = "SELECT company_name,address,vat_reg_no"
//						. " FROM f9ko_oc_company"
//						. " WHERE id = ".$companyid;
		$query = "SELECT description FROM f9ko_oc_project WHERE company_id = ".$companyid ." AND start_date <= ".$database->Quote($startdate)
					. " AND end_date >= ".$database->Quote($startdate);
		$database->setQuery($query);
		$description = $database->loadResult();
		if ($database->getErrorNum()) {
			echo $database->stderr();
			return false;
		}
		//$description = "IT Consulting at ".$company->company_name;
	}
	else{
		$description = "IT Consulting";
	}

	$line = new josIVIncomeFPline( $database );
	// Setup lines
	$line->id = 0;
	$line->invoice_id = $iid;
	$line->description = $description;
	$line->quantity = $total;
	$line->amount_unit=$rate_hour;
	$line->total_amount = $line->quantity * $line->amount_unit;
	$line->unit=$unit;
	$line->currency = "EUR";
	
	if (!$line->store()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>";
		exit();
	}
	
	return ($total*$rate_hour);
}

/******************************************************************************
* show the printable for the invoice with id
*******************************************************************************/
function showIncomingInvoice($option,$id,$pop=0){
	global $database;
	
	$invoice = new josIVIncome($database);
	$invoice->load($id);

	$query = "SELECT id,company_name,address,vat_reg_no"
						. " FROM f9ko_oc_company"
						. " WHERE id = ".$invoice->company_id;
	$database->setQuery($query);
	$database->loadObject($company);
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}
	
	//load lines
	$lines = Array();
	$query = "SELECT count(1)"
			. " FROM f9ko_iv_income_fpline WHERE invoice_id = ".$id;

	$database -> setQuery($query);
	$numbers = $database->loadResult();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		exit();
	}

	if($numbers == 1)
	{
		$query = "SELECT description, quantity, unit, amount_unit, total_amount "
				. " FROM f9ko_iv_income_fpline WHERE invoice_id = ".$id;
		$database -> setQuery($query);
		$database->loadObject($lines[0]);
		if ($database->getErrorNum()) {
			echo $database->stderr();
			exit();
		}
	}
	else{
		
		$query = "SELECT description, quantity, unit, amount_unit, total_amount,currency "
				. " FROM f9ko_iv_income_fpline WHERE invoice_id = ".$id;
		$database -> setQuery($query);
		$lines=$database->loadObjectList();
		if ($database->getErrorNum()) {
			echo $database->stderr();
			exit();
		}
	}
	
	HTML_invoicewriter_content::showIncomingInvoiceByCompany($option,$invoice,$lines,$company,$pop);
}
/******************************************************************************
 * 
******************************************************************************/
function editIncomingInvoice($option,$iid,$updated=0){
	global $database;
	
	
	$query = "SELECT id,iv_id,company_id,date,description,amount,tax,total_amount,currency,book_date,ogm"
						. " FROM f9ko_iv_income"
						. " WHERE id = ".(int)$iid;
	// echo($query);
	$database->setQuery( $query );
	$iid = $database->loadResult();
	
	$row = new josIVIncome( $database );

	if ($iid) {
		$row->load( $iid );  
		/*load FP lines */
		$query = "SELECT id,invoice_id,description,quantity,total_amount,amount_unit,unit,currency"
						. " FROM f9ko_iv_income_fpline"
						. " WHERE invoice_id = ".(int)$iid;
		$database -> setQuery($query);
		$rows = $database->loadObjectList();
		if ($database->getErrorNum()) {
			echo $database->stderr();
		}
		$fprows = $rows;	

		if($updated){
			$total = 0;
			for($i=0;$i<count($fprows);$i++){
				$total += $fprows[$i]->total_amount;
			}
			$row->amount = $total;
			$row->tax = $row->tax_perc * $total / 100;
			$row->total_amount = $row->amount + $row->tax;
		}
	} else {
		// Setup new entry defaults
		$row->id = 0;
		$row->iv_id = '';		
		$row->date = date("Y-m-d");
		
		$row->iv_id = createInvoiceKey(date("Y-m-d"));
		$row->company_id = 0;
		$row->due_date = date("Y-m-d",strtotime($row->date . " +30 days"));
		$row->period_start = "";
		$row->period_end = "";
		$row->description = "";
		$row->amount = 0;
		$row->tax_perc = 21;
		$row->tax = 0;
		$row->total_amount = 0;
		$row->currency = "EUR";
		$row->book_date = "0000-00-00";
		$row->ogm = '';
	}
	$lists['company_id'] = HTML_invoicewriter::companyselect( 'company_id', $row->company_id, 1, '', 'company_name', '- No Company -', 1, $userid);
	 
	HTML_invoicewriter_content::editIncomingInvoice($option,$row,$lists,$fprows,$updated);
	
}
/******************************************************************************
 * update the totals and save the invoice
******************************************************************************/
function saveIncomingInvoice( $option,$update=0 ) {
	global $database;

	$row = new josIVIncome( $database );
	if (!$row->bind( $_POST )) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>";
		exit();
	}
	
	$row->tax = $row->amount * $row->tax_perc /100;
	$row->total_amount = $row->amount + $row->tax;
	if($row->due_date == ''){
		$row->due_date = date("Y-m-d",strtotime($row->date . " +30 days"));
	}
	if(strlen($row->ogm) < 4 ){
		$row->ogm=createInvoiceOGM($row->iv_id,$row->company_id);
	}
		
	
	if (!$row->store()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>";
		exit();
	}
	if($row->total_amount > 0){
		if($update > 0){
			mosRedirect( "index.php?option=$option&amp;task=editIncomingInvoice&amp;iid=".$row->id."&amp;updated=1");
		}else{
			mosRedirect( "index.php?option=$option&amp;task=showIncomingInvoices");
		}
	}
	else{
		
		if (!$row->store()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>";
		exit();
		}
		mosRedirect( "index.php?option=$option&amp;task=newInvoiceFPLine&amp;iid=".$row->id, "Invoice Saved");
	}
	
}
/******************************************************************************
 * 
******************************************************************************/
function editInvoiceFPLine($option,$iid,$ilid){
	global $database;
	
	if($ilid == 0){
		if($iid == 0){
			mosRedirect( "index.php?option=$option&amp;task=showIncomingInvoices");
		}
		// Setup new entry defaults
		$row->id = 0;
		$row->invoice_id = $iid;
		$row->description = 0;
		$row->quantity = 0;
		$row->total_amount = 0;
		$row->amount_unit=0;
		$row->unit="HOUR";
		$row->currency = "EUR";
		$updatepossible = 1;
	} else{
	
		$query = "SELECT id,invoice_id,description,quantity,total_amount,amount_unit,unit,currency"
						. " FROM f9ko_iv_income_fpline"
						. " WHERE id = ".(int)$ilid;
		// echo($query);
		$database->setQuery( $query );
		$ilid = $database->loadResult();
		
		$row = new josIVIncomeFPline( $database );

		if ($ilid) {
			$row->load( $ilid );  
		} else {
			echo ("Error: please create a new invoice.");
		}
		
		$query = "SELECT book_date "
						. " FROM f9ko_iv_income"
						. " WHERE id = ".(int)$row->invoice_id;
		// echo($query);
		$database->setQuery( $query );
		$booked = $database->loadResult();
		$updatepossible = ($booked=='0000-00-00')?1:0;

	}
 
	HTML_invoicewriter_content::editInvoiceFPLine($option,$row,$updatepossible);
	
}
/******************************************************************************
 * 
******************************************************************************/
function saveInvoiceFPLine( $option) {
	global $database;
	$row = new josIVIncomeFPline( $database );
	
	if (!$row->bind( $_POST )) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>";
		exit();
	}
	$row->total_amount = $row->quantity * $row->amount_unit;
	
	if (!$row->store()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>";
		exit();
	}
	mosRedirect( "index.php?option=$option&amp;task=editIncomingInvoice&amp;iid=".$row->invoice_id."&amp;updated=1","Line saved");
}
/***************************************************************************
 * Delete 1 line
******************************************************************************/
function deleteInvoiceFPLine($option,$iid,$ilid ) {
	global $database;
	
	if ($ilid >= 0) {
		$database->setQuery( "DELETE FROM f9ko_iv_income_fpline WHERE id = ($ilid) AND invoice_id = ($iid)" );
		if (!$database->query()) {
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>";
		}
	}
	mosRedirect( "index.php?option=$option&amp;task=editIncomingInvoice&amp;iid=".$iid."&amp;updated=1");
}

/******************************************************************************
 * Show all invoices
******************************************************************************/
function showIncomingInvoices($option) {
	global $database;
	$limit = getSessionValue('limit', $mosConfig_list_limit);
	$limitstart = getSessionValue('limitstart', 0);
	
			
	$query = "SELECT i.id,c.company_name,i.date,i.description,i.amount,i.tax,i.total_amount,i.currency,i.book_date"
						. " FROM f9ko_iv_income as i"
						. " LEFT JOIN f9ko_oc_company AS c ON (i.company_id = c.id)"
						. " ORDER BY date DESC";
	// echo($query);
	$database->setQuery($query);
	$rows = $database->loadObjectList();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}
	
	$query = "SELECT count(*) FROM f9ko_iv_income"; 
	$database->setQuery( $query );
	$total = $database->loadResult();
	//require_once( $mosConfig_absolute_path .'/includes/pageNavigation.php' );
	require_once dirname(__FILE__) . '/../../includes/pageNavigation.php';
	$pageNav = new mosPageNav( $total, $limitstart, $limit );
	
	HTML_invoicewriter_content::showIncomingInvoices($option, $rows, $pageNav);
}

/******************************************************************************
 * 
******************************************************************************/
function adminDeleteInvoice($option,$cid ) {
	global $database;
	
	if (!is_array( $cid ) || count( $cid ) < 1) {
		echo "<script> alert('Select an item to delete'); window.history.go(-1);</script>";
		exit;
	}
	if (count( $cid )) {
		$cids = implodeIntArray($cid);
		$query="DELETE FROM f9ko_iv_income_fpline WHERE invoice_id IN ($cids)" ;
		$database->setQuery($query);

		if (!$database->query()) {
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>";
		}
		$query = "DELETE FROM f9ko_iv_income WHERE id IN ($cids)" ;
		$database->setQuery($query);
		if (!$database->query()) {
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>";
		}
	}
	mosRedirect( "index.php?option=com_invoicewriter&amp;task=showIncomingInvoices" );
}
/******************************************************************************
 * shows a printable invoice
******************************************************************************/
function showIncomingInvoicePrint($option,$cid ) {
	global $database;
	
	if (!is_array( $cid ) || count( $cid ) != 1 ) {
		echo "<script> alert('You can only select 1 invoice to print!'); window.history.go(-1);</script>";
		exit;
	}
	
	mosRedirect( "index.php?option=com_invoicewriter&amp;task=showIncomingInvoice&amp;iid=".$cid[0] );
}
/******************************************************************************
 * Show all expenses
******************************************************************************/
function showExpenses($option) {
	global $database;
	$limit = getSessionValue('limit', $mosConfig_list_limit);
	$limitstart = getSessionValue('limitstart', 0);
	
			
	$query = "SELECT i.id,c.supplier_name,i.date,i.description,i.ogm,i.amount,i.tax,i.total_amount,i.currency,i.book_date,i.invoice_received"
						. " FROM f9ko_iv_expense as i"
						. " LEFT JOIN f9ko_iv_supplier AS c ON (i.supplier_id = c.id)"
						. " ORDER BY date DESC";
	// echo($query);
	$database->setQuery($query);
	$rows = $database->loadObjectList();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}
	
	$query = "SELECT MAX(book_date) FROM f9ko_iv_expense"; 
	$database->setQuery( $query );
	$booky = $database->loadResult();
	
	$query = "SELECT count(*) FROM f9ko_iv_expense"; 
	$database->setQuery( $query );
	$total = $database->loadResult();
	//require_once( $mosConfig_absolute_path .'/includes/pageNavigation.php' );
	require_once dirname(__FILE__) . '/../../includes/pageNavigation.php';
	$pageNav = new mosPageNav( $total, $limitstart, $limit );
	
	HTML_invoicewriter_content::showExpenses($option, $rows, $pageNav,$booky);
}
/******************************************************************************
 * 
******************************************************************************/
function editExpense($option,$id){
	global $database;
	
	
	$query = "SELECT * FROM f9ko_iv_expense WHERE id = ".(int)$id;
	// echo($query);
	$database->setQuery( $query );
	$id = $database->loadResult();
	
	$row = new josIVExpense( $database );

	if ($id) {
		$row->load( $id );  
	} else {
		// Setup new entry defaults
		$row->id = 0;
		$row->supplier_id = 0;
		$row->expensetype_id=1;
		$row->date = date("Y-m-d");
		$row->description = "";
		$row->amount = 0;
		$row->tax = 0;
		$row->total_amount = 0;
		$row->currency = "EUR";
		$row->book_date = "";
		$row->invoice_received=0;
	}
	
	$lists['supplier_id'] = HTML_invoicewriter::supplierselect( 'supplier_id', $row->supplier_id, 1, '', 'supplier_name', '- No Supplier -');
	$lists['expensetype_id'] = HTML_invoicewriter::expensetypeselect( 'expensetype_id', $row->expensetype_id, 1, '', 'description', '- No Type -',($id>0)?0:1);
	
	HTML_invoicewriter_content::editExpense($option,$row,$lists);
	
}
/******************************************************************************
 * 
******************************************************************************/
function saveExpense( $option) {
	global $database;
	$row = new josIVExpense( $database );
	
	if (!$row->bind( $_POST )) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>";
		exit();
	}
	
	$row->total_amount = $row->amount + $row->tax;
	
	if (!$row->store()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>";
		exit();
	}
	mosRedirect( "index.php?option=$option&amp;task=showExpenses","Expense saved");
}
/******************************************************************************
 * 
******************************************************************************/
function adminDeleteExpense($option,$cid ) {
	global $database;
	
	if (!is_array( $cid ) || count( $cid ) < 1) {
		echo "<script> alert('Select an item to delete'); window.history.go(-1);</script>";
		exit;
	}
	if (count( $cid )) {
		$cids = implodeIntArray($cid);
		$query = "DELETE FROM f9ko_iv_expense WHERE id IN ($cids)" ;
		$database->setQuery($query);
		if (!$database->query()) {
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>";
		}
	}
	mosRedirect( "index.php?option=com_invoicewriter&amp;task=showExpenses" );
}
/******************************************************************************
 * Show all suppliers
******************************************************************************/
function showSuppliers($option) {
	global $database;
	$limit = getSessionValue('limit', $mosConfig_list_limit);
	$limitstart = getSessionValue('limitstart', 0);
	
			
	$query = "SELECT * FROM f9ko_iv_supplier ORDER BY supplier_name";
	// echo($query);
	$database->setQuery($query);
	$rows = $database->loadObjectList();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}
	
	$query = "SELECT count(*) FROM f9ko_iv_supplier"; 
	$database->setQuery( $query );
	$total = $database->loadResult();
	//require_once( $mosConfig_absolute_path .'/includes/pageNavigation.php' );
	require_once dirname(__FILE__) . '/../../includes/pageNavigation.php';
	$pageNav = new mosPageNav( $total, $limitstart, $limit );
	
	HTML_invoicewriter_content::showSuppliers($option, $rows, $pageNav);
}
/******************************************************************************
 *
******************************************************************************/
function editSupplier ($option, $sid,$redirectExpensid=0) {
	global $database;

	$row = new josIVSupplier( $database );
	if ($sid) {
		$row->load( $sid );
	} else {
		$row->id=null;
		$row->supplier_name='New Supplier';
		$row->company_id=0;
		$row->description=null;
		$row->address=null;
		$row->telephone=null;
		$row->contact_name=null;
		$row->email=null;
		$row->website=null;
		$row->vat_reg_no=null;
	}
	$lists['company_id'] = HTML_invoicewriter::companyselect( 'company_id', $row->company_id, 1, '', 'company_name', '- No Customer -', 1, $userid);
	
	HTML_invoicewriter_content::editSupplier( $option, $row, $lists,$redirectExpensid );
}
/******************************************************************************
 * 
******************************************************************************/
function saveSupplier ($option,$redirectExpenseid=0) {
	global $database;
	$row = new josIVSupplier( $database );
	if (!$row->bind( $_POST )) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>";
		exit();
	}
	if (!$row->store()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>";
		exit();
	}
	
	if($redirectExpenseid == 'A'){
		mosRedirect( "index.php?option=$option&amp;task=newExpense");
	}
	if($redirectExpenseid > 0){
		mosRedirect( "index.php?option=$option&amp;task=editExpense&amp;sid=".$redirectExpenseid);
	}else{
		mosRedirect( "index.php?option=$option&amp;task=showSuppliers","Supplier saved");
	}
}
/******************************************************************************
 * 
******************************************************************************/
function adminDeleteSupplier($option,$cid ) {
	global $database;
	
	if (!is_array( $cid ) || count( $cid ) < 1) {
		echo "<script> alert('Select an item to delete'); window.history.go(-1);</script>";
		exit;
	}
	if (count( $cid )) {
		$cids = implodeIntArray($cid);
		$query = "DELETE FROM f9ko_iv_supplier WHERE id IN ($cids)" ;
		$database->setQuery($query);
		if (!$database->query()) {
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>";
		}
	}
	mosRedirect( "index.php?option=com_invoicewriter&amp;task=showSuppliers" );
}
/******************************************************************************
 * 
******************************************************************************/
function showStaff($option) {
	global $database;
	$limit = getSessionValue('limit', $mosConfig_list_limit);
	$limitstart = getSessionValue('limitstart', 0);
	
			
	$query = "SELECT s.id,s.birth_date,s.start_date,s.end_date,u.name FROM f9ko_iv_staff as s LEFT JOIN f9ko_users as u ON (s.user_id = u.id) ORDER BY u.name";
	// echo($query);
	$database->setQuery($query);
	$rows = $database->loadObjectList();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}
	
	$query = "SELECT count(*) FROM f9ko_iv_staff"; 
	$database->setQuery( $query );
	$total = $database->loadResult();
	//require_once( $mosConfig_absolute_path .'/includes/pageNavigation.php' );
	require_once dirname(__FILE__) . '/../../includes/pageNavigation.php';
	$pageNav = new mosPageNav( $total, $limitstart, $limit );
	
	HTML_invoicewriter_content::showStaff($option, $rows, $pageNav);
}
/******************************************************************************
 *
******************************************************************************/
function editStaffMember ($option, $sid) {
	global $database;

	$row = new josIVStaff( $database );
	if ($sid) {
		$row->load( $sid );
	} else {
		$row->id=0;
		$row->user_id=0;
		$row->jobtitle=null;
		$row->passport_id=null;
		$row->birth_date='';
		$row->start_date='';
		$row->end_date='';
		$row->address=null;
		$row->telephone=null;
	}
	$lists['user_id'] = HTML_invoicewriter::userselect( 'user_id', $row->user_id, 1, '', 'name', '- No User -', 1, $userid);
	
	HTML_invoicewriter_content::editStaffMember( $option, $row, $lists );
}
/******************************************************************************
 * 
******************************************************************************/
function saveStaffMember ($option) {
	global $database;
	$row = new josIVStaff( $database );
	if (!$row->bind( $_POST )) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>";
		exit();
	}
	if (!$row->store()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>";
		exit();
	}
	mosRedirect( "index.php?option=$option&amp;task=showStaff","Staff Member saved");
}
/******************************************************************************
 * 
******************************************************************************/
function adminDeleteStaffMember($option,$cid ) {
	global $database;
	
	if (!is_array( $cid ) || count( $cid ) < 1) {
		echo "<script> alert('Select an item to delete'); window.history.go(-1);</script>";
		exit;
	}
	if (count( $cid )) {
		$cids = implodeIntArray($cid);
		$query = "DELETE FROM f9ko_iv_staff WHERE id IN ($cids)" ;
		$database->setQuery($query);
		if (!$database->query()) {
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>";
		}
	}
	mosRedirect( "index.php?option=com_invoicewriter&amp;task=showStaff" );
}
/******************************************************************************
 * 
******************************************************************************/
function showUsers($option) {
	global $database;
	$limit = getSessionValue('limit', $mosConfig_list_limit);
	$limitstart = getSessionValue('limitstart', 0);
	
			
	$query = "SELECT * FROM f9ko_users ORDER BY usertype";
	// echo($query);
	$database->setQuery($query);
	$rows = $database->loadObjectList();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}
	
	$query = "SELECT count(*) FROM f9ko_users"; 
	$database->setQuery( $query );
	$total = $database->loadResult();
	//require_once( $mosConfig_absolute_path .'/includes/pageNavigation.php' );
	require_once dirname(__FILE__) . '/../../includes/pageNavigation.php';
	$pageNav = new mosPageNav( $total, $limitstart, $limit );
	
	HTML_invoicewriter_content::showUsers($option, $rows, $pageNav);
}
/******************************************************************************
 *
******************************************************************************/
function editUser ($option, $uid,$redirectStaffid) {
	global $database;

	$row = new josIVUser( $database );
	if ($uid) {
		$row->load( $uid );
	
		HTML_invoicewriter_content::editUser( $option, $row, $lists,$redirectStaffid);
	}
	else{
		mosRedirect( "index.php?option=$option&amp;task=mainDisplay","no user selected");
	}
}
/******************************************************************************
 * 
******************************************************************************/
function saveUser ($option,$redirectStaffid=0) {
	global $database;
	$row = new josIVUser( $database );
	if (!$row->bind( $_POST )) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>";
		exit();
	}
	if (!$row->store()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>";
		exit();
	}
	if($redirectStaffid > 0){
		mosRedirect( "index.php?option=$option&amp;task=editStaffMemeber&amp;sid=".$redirectStaffid);
	}else{
		mosRedirect( "index.php?option=$option&amp;task=showUsers","Staff Member saved");
	}
}
/******************************************************************************
 * 
******************************************************************************/
function showSalaries($option) {
	global $database;
	$limit = getSessionValue('limit', $mosConfig_list_limit);
	$limitstart = getSessionValue('limitstart', 0);
	
			
	$query = "SELECT s.id,s.date,s.description,s.amount,s.currency,s.book_date,u.name"
						. " FROM f9ko_iv_salary as s"
						. " LEFT JOIN f9ko_iv_staff AS st ON (s.staff_id = st.id)"
						. " LEFT JOIN f9ko_users AS u ON (st.user_id = u.id)"
						. " ORDER BY date DESC";
	// echo($query);
	$database->setQuery($query);
	$rows = $database->loadObjectList();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}
	
	$query = "SELECT count(*) FROM f9ko_iv_salary"; 
	$database->setQuery( $query );
	$total = $database->loadResult();
	//require_once( $mosConfig_absolute_path .'/includes/pageNavigation.php' );
	require_once dirname(__FILE__) . '/../../includes/pageNavigation.php';
	$pageNav = new mosPageNav( $total, $limitstart, $limit );
	
	HTML_invoicewriter_content::showSalaries($option, $rows, $pageNav);
}
/******************************************************************************
 * 
******************************************************************************/
function editSalary($option,$sid){
	global $database;
	
	
	$query = "SELECT * FROM f9ko_iv_salary WHERE id = ".(int)$sid;
	// echo($query);
	$database->setQuery( $query );
	$id = $database->loadResult();
	
	$row = new josIVSalary( $database );

	if ($sid) {
		$row->load( $sid );  
	} else {
		// Setup new entry defaults
		$row->id=0;
		$row->staff_id=0;
		$row->date='';
		$row->description=null;
		$row->amount=0;
		$row->currency='EUR';
		$row->book_date='';
	}
	$lists['staff_id'] = HTML_invoicewriter::staffselect( 'staff_id', $row->staff_id, 1, '');
	 
	HTML_invoicewriter_content::editSalary($option,$row,$lists);
	
}
/******************************************************************************
 * 
******************************************************************************/
function saveSalary( $option) {
	global $database;
	$row = new josIVSalary( $database );
	
	if (!$row->bind( $_POST )) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>";
		exit();
	}
	if (!$row->store()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>";
		exit();
	}
	mosRedirect( "index.php?option=$option&amp;task=showSalaries","Salary saved");
}
/******************************************************************************
 * 
******************************************************************************/
function adminDeleteSalary($option,$cid ) {
	global $database;
	
	if (!is_array( $cid ) || count( $cid ) < 1) {
		echo "<script> alert('Select an item to delete'); window.history.go(-1);</script>";
		exit;
	}
	if (count( $cid )) {
		$cids = implodeIntArray($cid);
		$query = "DELETE FROM f9ko_iv_salary WHERE id IN ($cids)" ;
		$database->setQuery($query);
		if (!$database->query()) {
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>";
		}
	}
	mosRedirect( "index.php?option=com_invoicewriter&amp;task=showSalaries" );
}
/******************************************************************************
 * 
******************************************************************************/
function showFinancialReportCriteria($option){
	global $database;

	HTML_invoicewriter_content::showFinancialReportCriteria($option);
}
/******************************************************************************
 * 
******************************************************************************/
function showFinancialReport($option,$startdate,$enddate,$pop=0){
	global $database;
	
	//get income
	$query = "SELECT book_date,sum(total_amount) as amount_B, sum(amount) as amount_N, sum(tax) as amount_T FROM f9ko_iv_income"
				. " WHERE date >= ".$database->Quote($startdate)
				. " AND date <= ".$database->Quote($enddate);

	$database->setQuery($query);
	$row_income = 0;
	$database->loadObject($row_income);
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}
	//get expenses
	$query = "SELECT ext.id, ext.description,ext.perc_deductable,ext.perc_deductable_tax,ex.book_date, sum(ex.amount) as amount_N, sum(ex.tax) as amount_T, sum(ex.total_amount) as amount_B FROM f9ko_iv_expense as ex"
				. " LEFT JOIN f9ko_iv_expensetype as ext ON (ex.expensetype_id = ext.id)"
				. " WHERE ex.date >= ".$database->Quote($startdate)
				. " AND ex.date <= ".$database->Quote($enddate)	
				. " group by ext.id";

	$database->setQuery($query);
	$row_expenses = 0; 
	$row_expenses = $database->loadObjectList();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}
//echo ("DEBUG ".$row_expenses[0]->description." met ".$row_expenses[0]->perc_deductable." en ".$row_expenses[0]->perc_deductable_tax." en ".$row_expenses[0]->book_date);
	//get salaries
	$query = "SELECT sum(amount) FROM f9ko_iv_salary"
			. " WHERE date >= ".$database->Quote($startdate)
			. " AND date <= ".$database->Quote($enddate);
			
	$database->setQuery($query);
	$salaries = $database->loadResult();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}
	
	//get current saldo
	//get income
	$query = "SELECT sum(total_amount) FROM f9ko_iv_income where book_date <> '0000-00-00'";
	//			. " WHERE date <= ".$database->Quote($enddate)
	//			." AND book_date <> '0000-00-00'";

	$database->setQuery($query);
	$incomeB = $database->loadResult();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}

	$query = "SELECT sum(total_amount) FROM f9ko_iv_expense where book_date <> '0000-00-00'";
	//			. " WHERE date <= ".$database->Quote($enddate)	
	//			. " AND book_date <> '0000-00-00'";

	$database->setQuery($query);
	$expensesB = $database->loadResult();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}
	$query = "SELECT sum(amount) FROM f9ko_iv_salary where book_date <> '0000-00-00'";
	//		. " WHERE date <= ".$database->Quote($enddate)
	//		. " AND book_date <> '0000-00-00'";
			
	$database->setQuery($query);
	$salariesB = $database->loadResult();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}
	
	$query = "SELECT sum(amount) FROM f9ko_iv_tax where book_date <> '0000-00-00'";
	//		. " WHERE date <= ".$database->Quote($enddate)
	//		. " AND book_date <> '0000-00-00'";
			
	$database->setQuery($query);
	$taxes = $database->loadResult();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}
	
	$query = "SELECT sum(amount) FROM f9ko_iv_invest where book_date <> '0000-00-00'";
	//		. " WHERE book_date <= ".$database->Quote($enddate)
	//		. " AND book_date <> '0000-00-00'";
			
	$database->setQuery($query);
	$invests = $database->loadResult();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}
	
	$saldo = $incomeB - $expensesB - $salariesB - $taxes;// + $invests;
	
	//openstaande debiteurensaldo
	$query = "SELECT sum(total_amount) FROM f9ko_iv_income"
				. " WHERE date <= ".$database->Quote($enddate)
				." AND book_date = '0000-00-00'";

	$database->setQuery($query);
	$debits = $database->loadResult();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}
	
	//openstaande crediteurensaldo
	$query = "SELECT sum(total_amount) FROM f9ko_iv_expense "
				. " WHERE date <= ".$database->Quote($enddate)	
				. " AND book_date = '0000-00-00'";

	$database->setQuery($query);
	$credits = $database->loadResult();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}
	//openstaande loonschuld
	$query = "SELECT sum(amount) FROM f9ko_iv_salary"
			. " WHERE date <= ".$database->Quote($enddate)
			. " AND book_date = '0000-00-00'";
			
	$database->setQuery($query);
	$salcredit = $database->loadResult();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}
	$credits +=$salcredit;
	
	//openstaande taxes
	$year=date ("Y", mktime($enddate));
	$d1year=date("Y-m-d",mktime(0, 0, 0, 1, 1, $year));
	if($startdate < $d1year)
		$d1year = $startdate;
	$ldyear=date("Y-m-d",mktime(0, 0, 0, 12, 31, $year));
	
	$query = "SELECT sum(amount) FROM f9ko_iv_tax as t "
			. " WHERE t.date <= '".$ldyear."' AND t.date >= '".$d1year."'"
			. " AND t.book_date = '0000-00-00'";
			
	$database->setQuery($query);
	$taxcredit = $database->loadResult();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}
	$credits +=$taxcredit;
	
	//Get current vat payments
	$query = "SELECT sum(amount) FROM f9ko_iv_tax as t LEFT JOIN f9ko_iv_taxtype as tt ON (tt.id = t.taxtype_id)"
			. " WHERE date <= ".$database->Quote($enddate)			
			. " AND date >= ".$database->Quote($startdate)
			. " AND tt.description like '%VAT%'"
			. " AND book_date <> '0000-00-00'";
			
	$database->setQuery($query);
	$vatpaid = $database->loadResult();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}
	//Get current tax payments
	$query = "SELECT sum(amount) FROM f9ko_iv_tax as t LEFT JOIN f9ko_iv_taxtype as tt ON (tt.id = t.taxtype_id)"
			. " WHERE t.date <= '".$ldyear."' AND t.date >= '".$d1year."'"
			. " AND tt.description like '%TAX%'"
			. " AND book_date <> '0000-00-00'";

	$database->setQuery($query);
	$taxpaid = $database->loadResult();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}
	
	$date = date("Y-m-d");
	HTML_invoicewriter_content::showFinancialReport($option,$date,$startdate,$enddate,$row_income,$row_expenses,$salaries,$saldo,$debits,$credits,$taxpaid, $vatpaid,$invests, $pop);
	
}

/******************************************************************************
 * Show all expenses
******************************************************************************/
function showExpenseTypes($option) {
	global $database;
	$limit = getSessionValue('limit', $mosConfig_list_limit);
	$limitstart = getSessionValue('limitstart', 0);
	
			
	$query = "SELECT * FROM f9ko_iv_expensetype ORDER BY description";
	// echo($query);
	$database->setQuery($query);
	$rows = $database->loadObjectList();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}
	
	$query = "SELECT count(*) FROM f9ko_iv_expensetype"; 
	$database->setQuery( $query );
	$total = $database->loadResult();
	//require_once( $mosConfig_absolute_path .'/includes/pageNavigation.php' );
	require_once dirname(__FILE__) . '/../../includes/pageNavigation.php';
	$pageNav = new mosPageNav( $total, $limitstart, $limit );
	
	HTML_invoicewriter_content::showExpenseTypes($option, $rows, $pageNav);
}
/******************************************************************************
 * 
******************************************************************************/
function editExpenseType($option,$id){
	global $database;
	
	
	$query = "SELECT * FROM f9ko_iv_expensetype WHERE id = ".(int)$id;
	// echo($query);
	$database->setQuery( $query );
	$id = $database->loadResult();
	
	$row = new josIVExpenseType( $database );

	if ($id) {
		$row->load( $id );  
	} else {
		// Setup new entry defaults
		$row->id = 0;
		$row->start_date = date("Y-m-d");
		$row->end_date = '';
		$row->description = "";
		$row->perc_deductable = 0;
		$row->perc_deductable_tax = 0;
	}
	HTML_invoicewriter_content::editExpenseType($option,$row);
	
}
/******************************************************************************
 * 
******************************************************************************/
function saveExpenseType( $option) {
	global $database;
	$row = new josIVExpenseType( $database );
	
	if (!$row->bind( $_POST )) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>";
		exit();
	}
	
	if (!$row->store()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>";
		exit();
	}
	mosRedirect( "index.php?option=$option&amp;task=showExpenseTypes","Expense Type saved");
}
/******************************************************************************
 * 
******************************************************************************/
function adminDeleteExpenseType($option,$cid ) {
	global $database;
	
	if (!is_array( $cid ) || count( $cid ) < 1) {
		echo "<script> alert('Select an item to delete'); window.history.go(-1);</script>";
		exit;
	}
	if (count( $cid )) {
		$cids = implodeIntArray($cid);
		$query = "DELETE FROM f9ko_iv_expensetype WHERE id IN ($cids)" ;
		$database->setQuery($query);
		if (!$database->query()) {
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>";
		}
	}
	mosRedirect( "index.php?option=com_invoicewriter&amp;task=showExpenseTypes" );
}
/******************************************************************************
 * Show all TaxTypes
******************************************************************************/
function showTaxTypes($option) {
	global $database;
	$limit = getSessionValue('limit', $mosConfig_list_limit);
	$limitstart = getSessionValue('limitstart', 0);
	
			
	$query = "SELECT * FROM f9ko_iv_taxtype ORDER BY description";
	// echo($query);
	$database->setQuery($query);
	$rows = $database->loadObjectList();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}
	
	$query = "SELECT count(*) FROM f9ko_iv_taxtype"; 
	$database->setQuery( $query );
	$total = $database->loadResult();
	//require_once( $mosConfig_absolute_path .'/includes/pageNavigation.php' );
	require_once dirname(__FILE__) . '/../../includes/pageNavigation.php';
	$pageNav = new mosPageNav( $total, $limitstart, $limit );
	
	HTML_invoicewriter_content::showTaxTypes($option, $rows, $pageNav);
}
/******************************************************************************
 * 
******************************************************************************/
function editTaxType($option,$id){
	global $database;
	
	
	$query = "SELECT * FROM f9ko_iv_taxtype WHERE id = ".(int)$id;
	// echo($query);
	$database->setQuery( $query );
	$id = $database->loadResult();
	
	$row = new josIVTaxType( $database );

	if ($id) {
		$row->load( $id );  
	} else {
		// Setup new entry defaults
		$row->id = 0;
		$row->description = "";
	}
	HTML_invoicewriter_content::editTaxType($option,$row);
	
}
/******************************************************************************
 * 
******************************************************************************/
function saveTaxType( $option) {
	global $database;
	$row = new josIVTaxType( $database );
	
	if (!$row->bind( $_POST )) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>";
		exit();
	}
	
	if (!$row->store()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>";
		exit();
	}
	mosRedirect( "index.php?option=$option&amp;task=showTaxTypes","Expense Type saved");
}
/******************************************************************************
 * 
******************************************************************************/
function adminDeleteTaxType($option,$cid ) {
	global $database;
	
	if (!is_array( $cid ) || count( $cid ) < 1) {
		echo "<script> alert('Select an item to delete'); window.history.go(-1);</script>";
		exit;
	}
	if (count( $cid )) {
		$cids = implodeIntArray($cid);
		$query = "DELETE FROM f9ko_iv_taxtype WHERE id IN ($cids)" ;
		$database->setQuery($query);
		if (!$database->query()) {
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>";
		}
	}
	mosRedirect( "index.php?option=com_invoicewriter&amp;task=showTaxTypes" );
}
/******************************************************************************
 * Show all taxes
******************************************************************************/
function showTax($option) {
	global $database;
	$limit = getSessionValue('limit', $mosConfig_list_limit);
	$limitstart = getSessionValue('limitstart', 0);
	
			
	$query = "SELECT i.id,c.description as global_description,i.date,i.description,i.amount,i.currency,i.book_date"
						. " FROM f9ko_iv_tax as i"
						. " LEFT JOIN f9ko_iv_taxtype AS c ON (i.taxtype_id = c.id)"
						. " ORDER BY date DESC";
	// echo($query);
	$database->setQuery($query);
	$rows = $database->loadObjectList();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}
	
	$query = "SELECT count(*) FROM f9ko_iv_tax"; 
	$database->setQuery( $query );
	$total = $database->loadResult();
	//require_once( $mosConfig_absolute_path .'/includes/pageNavigation.php' );
	require_once dirname(__FILE__) . '/../../includes/pageNavigation.php';
	$pageNav = new mosPageNav( $total, $limitstart, $limit );
	
	HTML_invoicewriter_content::showTax($option, $rows, $pageNav);
}
/******************************************************************************
 * 
******************************************************************************/
function editTax($option,$id){
	global $database;
	
	
	$query = "SELECT * FROM f9ko_iv_tax WHERE id = ".(int)$id;
	// echo($query);
	$database->setQuery( $query );
	$id = $database->loadResult();
	
	$row = new josIVTax( $database );

	if ($id) {
		$row->load( $id );  
	} else {
		// Setup new entry defaults
		$row->id = 0;
		$row->taxtype_id=1;
		$row->date = date("Y-m-d");
		$row->description = "";
		$row->amount = 0;
		$row->currency = "EUR";
		$row->book_date = "";
	}
	
	$lists['taxtype_id'] = HTML_invoicewriter::taxtypeselect( 'taxtype_id', $row->taxtype_id, 1, '', 'description', '- No Type -');
	
	HTML_invoicewriter_content::editTax($option,$row,$lists);
	
}
/******************************************************************************
 * 
******************************************************************************/
function saveTax( $option) {
	global $database;
	$row = new josIVTax( $database );
	
	if (!$row->bind( $_POST )) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>";
		exit();
	}
	
	if (!$row->store()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>";
		exit();
	}
	mosRedirect( "index.php?option=$option&amp;task=showTax","Tax saved");
}
/******************************************************************************
 * 
******************************************************************************/
function adminDeleteTax($option,$cid ) {
	global $database;
	
	if (!is_array( $cid ) || count( $cid ) < 1) {
		echo "<script> alert('Select an item to delete'); window.history.go(-1);</script>";
		exit;
	}
	if (count( $cid )) {
		$cids = implodeIntArray($cid);
		$query = "DELETE FROM f9ko_iv_tax WHERE id IN ($cids)" ;
		$database->setQuery($query);
		if (!$database->query()) {
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>";
		}
	}
	mosRedirect( "index.php?option=com_invoicewriter&amp;task=showTax" );
}
/******************************************************************************
 * Show all Investments
******************************************************************************/
function showInvests($option) {
	global $database;
	$limit = getSessionValue('limit', $mosConfig_list_limit);
	$limitstart = getSessionValue('limitstart', 0);
	
			
	$query = "SELECT id,description,amount,currency,book_date"
						. " FROM f9ko_iv_invest"
						. " ORDER BY book_date DESC";
	// echo($query);
	$database->setQuery($query);
	$rows = $database->loadObjectList();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}
	
	$query = "SELECT count(*) FROM f9ko_iv_invest"; 
	$database->setQuery( $query );
	$total = $database->loadResult();
	//require_once( $mosConfig_absolute_path .'/includes/pageNavigation.php' );
	require_once dirname(__FILE__) . '/../../includes/pageNavigation.php';
	$pageNav = new mosPageNav( $total, $limitstart, $limit );
	
	HTML_invoicewriter_content::showInvests($option, $rows, $pageNav);
}
/******************************************************************************
 * 
******************************************************************************/
function editInvest($option,$id){
	global $database;
	
	
	$query = "SELECT * FROM f9ko_iv_invest WHERE id = ".(int)$id;
	// echo($query);
	$database->setQuery( $query );
	$id = $database->loadResult();
	
	$row = new josIVInvest( $database );

	if ($id) {
		$row->load( $id );  
	} else {
		// Setup new entry defaults
		$row->id = 0;
		$row->description = "";
		$row->amount = 0;
		$row->currency = "EUR";
		$row->book_date = "";
	}
	
	HTML_invoicewriter_content::editInvest($option,$row,$lists);
	
}
/******************************************************************************
 * 
******************************************************************************/
function saveInvest( $option) {
	global $database;
	$row = new josIVInvest( $database );
	
	if (!$row->bind( $_POST )) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>";
		exit();
	}
	
	if (!$row->store()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>";
		exit();
	}
	mosRedirect( "index.php?option=$option&amp;task=showInvests","Investment saved");
}
/******************************************************************************
 * 
******************************************************************************/
function adminDeleteInvest($option,$cid ) {
	global $database;
	
	if (!is_array( $cid ) || count( $cid ) < 1) {
		echo "<script> alert('Select an item to delete'); window.history.go(-1);</script>";
		exit;
	}
	if (count( $cid )) {
		$cids = implodeIntArray($cid);
		$query = "DELETE FROM f9ko_iv_invest WHERE id IN ($cids)" ;
		$database->setQuery($query);
		if (!$database->query()) {
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>";
		}
	}
	mosRedirect( "index.php?option=com_invoicewriter&amp;task=showInvests" );
}

?>