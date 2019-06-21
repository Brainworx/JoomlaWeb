<?php
/**
* ObjectClarity TimeWriter Component
* @package TimeWriter
* @copyright (C) 2007 ObjectClarity / All rights reserved
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @link http://www.objectclarity.com
*
* Based on the Mambotastic Timesheets Component
* @copyright (C) 2005 Mark Stewart / All Rights Reserved
* @Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
* @author Mark Stewart / Mambotastic
**/


defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

// Various PHP error logging levels for testing.
// error_reporting(E_ALL ^ E_NOTICE);
// error_reporting(E_ALL);

require_once dirname(__FILE__) . '/timewriter.html.php';
require_once dirname(__FILE__) . '/../../administrator/components/com_timewriter/class.timewriter.php';
require_once dirname(__FILE__) . '/../../administrator/components/com_timewriter/admin.timewriter.html.php';


require_once( $mainframe->getPath( 'admin_html' ) );

// Include the language file.
 if (file_exists(dirname(__FILE__) . '/language/' . $mosConfig_lang . '.php')) {
	require_once dirname(__FILE__) . '/language/' . $mosConfig_lang . '.php';
} else {
	require_once dirname(__FILE__) . '/language/english.php';
}


global $database, $mainframe;

$task = trim( mosGetParam( $_REQUEST, 'task', '' ) );
$redirecttask = trim( mosGetParam( $_REQUEST, 'redirecttask', '' ) );
$option = trim( mosGetParam( $_REQUEST, 'option', '' ) );
$fordate = trim( mosGetParam( $_REQUEST, 'fordate', '' ) );
$startdate = trim( mosGetParam( $_REQUEST, 'current_date', '' ) );
$enddate = trim( mosGetParam( $_REQUEST, 'end_date', '' ) );
$isbillable = trim( mosGetParam( $_REQUEST, 'is_billable', '' ) );
$companyid = trim( mosGetParam( $_REQUEST, 'company_id', '' ) );
$userpid = trim( mosGetParam( $_REQUEST, 'user_id_fp', '' ) );
$projectid = trim( mosGetParam( $_REQUEST, 'project_id', '' ));
$userids = mosGetParam( $_REQUEST, 'user_ids', array() );  
$vehicleid = trim( mosGetParam( $_REQUEST, 'vehicle_id', '' ) );
$period = trim( mosGetParam( $_REQUEST, 'period', '' ) );
$user = $mainframe->getUser();
$userid	= $user->id;
$username = $user->name;
$cid = mosGetParam( $_REQUEST, 'id', '' );
$uid = mosGetParam( $_REQUEST, 'uid', '' );
$pop = mosGetParam( $_REQUEST, 'pop', '0' );

if (!is_array( $cid )) {
	$cid = array($cid);
}

if($userid == NULL){
	mosRedirect( "index.php","You need to be logged in to view this resource");
	echo("You need to be logged in to view this resource");
	return;
}

// ********************************************************************
if (preg_match( "/^admin/i", $task )) {
	// If user is asking for an Admin task, make sure they're an Admin!!
	$isAdmin = HTML_Timesheet::userIsTimesheetAdmin($userid);	
	if (!$isAdmin) {
		echo ("You are not a TimeWriter Administrator.  Permission denied.");
		return;
	}	
} elseif($task == "" || $task == "showReportMenu") {
	// Allow everyone to run these tasks.	
} else {
	// Make sure the user is allowed into the system
	$canEnterTime = HTML_Timesheet::userCanEnterTime($userid);	
	if ($canEnterTime < 1) {
		echo "You must be granted access and assigned to published projects before you can use the TimeWriter system.";
		// Fallback to the Calendar...
		$task = "fallback";		
	}
}
// ********************************************************************

switch($task){
	case 'showSimpleTimesheetReport':
		showSimpleTimesheetReport($option, $fordate, $userid, $username, $pop);
		break;
	case 'showTimesheet':
		showTimesheetForDate($option, $fordate, $userid);
		break;
	// ********************************************************************
	case 'deleteProjectTimesheets':
		deleteProjectTimesheets($option, $cid, $fordate, $userid);
		break;
	case 'newProjectTimesheets':
		editProjectTimesheets($option, $fordate, "", $userid, $redirecttask);
		break;
	case 'editProjectTimesheets':
		editProjectTimesheets($option, $fordate, $uid, $userid, $redirecttask);
		break;
	case 'saveProjectTimesheets':
		saveProjectTimesheets($option, $cid, $fordate, $projectid, $redirecttask);
		break;
	// ********************************************************************
	case 'showReportMenu':
		showReportMenu($option, $fordate, $userid);
		break;
	case 'showTimesheetReportByCompanyCriteria':
		showTimesheetReportByCompanyCriteria($option, $userid, $fordate, $startdate, $enddate, $isbillable, $companyid);
		break;
	case 'showProjectReportByCompany':
		showProjectReportByCompany($option, $userid, $startdate, $enddate, $isbillable, $companyid, $pop);
		break;
	case 'showFlextimeReportByCompanyCriteria':
		showFlextimeReportByCompanyCriteria($option, $userid, $fordate, $period, $companyid);
		break;
	case 'showFlextimeReportByCompany':
		showFlextimeReportByCompany($option, $userid, $period, $companyid, $pop);
		break;

	case 'multiUserWeeklyReportByCompanyCriteria':
		multiUserWeeklyReportByCompanyCriteria($option, $userids, $fordate, $startdate, $enddate, $isbillable, $companyid, $userid);
		break;
	case 'multiUserWeeklyReportByCompany':
		showWeeklyReportByCompany($option, $userids, $startdate, $enddate, $isbillable, $companyid, $pop);
		break;
		
		case 'showTimesheetReportByProjectCriteria':
		showTimesheetReportByProjectCriteria($option, $userid, $fordate, $startdate, $enddate, $isbillable, $projectid);
		break;
	case 'showProjectReportByProject':
		showProjectReportByProject($option, $userid, $startdate, $enddate, $isbillable, $projectid, $pop);
		break;
	// ********************************************************************
	case 'showTotalHoursPerProjectCriteria':
		showTotalHoursPerProjectCriteria($option, $userid, $fordate, $startdate, $enddate, $isbillable);
		break;
	case 'showTotalHoursPerProject':
		showTotalHoursPerProject($option, $userid, $startdate, $enddate, $isbillable, $pop);
		break;
	// ********************************************************************
	case 'multiUserTotalMileageCriteria':
		multiUserTotalMileageCriteria($option, $userids, $fordate, $startdate, $enddate, $isbillable, $companyid, $userid);
		break;
	case 'multiUserTotalMileageReport':
		showTotalMileageReport($option, $userids, $startdate, $enddate, $isbillable, $companyid, $vehicleid, $pop);
		break;		
	case 'showTotalMileageReport':
		showTotalMileageReport($option, $userid, $startdate, $enddate, $isbillable, $companyid, $vehicleid, $pop);
		break;		
	// ********************************************************************
	case 'showTotalMileageCriteria':
		showTotalMileageCriteria($option, $userid, $fordate, $startdate, $enddate, $isbillable, $companyid, $vehicleid);
		break;
	case 'showTotalMileageReport':
		showTotalMileageReport($option, $userid, $startdate, $enddate, $isbillable, $companyid, $vehicleid, $pop);
		break;		
	// ********************************************************************
	case 'showUserPreferencesCriteria':
		showUserPreferencesCriteria($option);
		break;
	case 'showUserPreferences':
		showUserPreferences($option, $fordate, $userpid);
		break;
	case 'saveUserPreferences':
		saveUserPreferences($option, $fordate);
		break;
	// ********************************************************************
	case 'showVehicles':
		showVehicles($option, $fordate, $userid);
		break;
	case 'editVehicle':
		editVehicle($option, $fordate, $uid, $userid);
		break;
	case 'deleteVehicle':
		deleteVehicle($option, $fordate, $cid, $userid);
		break;
	case 'saveVehicle':
		saveVehicle($option, $fordate);
		break;
	// ********************************************************************
	case 'showMileage':
		showMileage($option, $fordate, $userid);
		break;
	case 'newMileage':
		editMileage($option, $fordate, -1, $userid, 0, "showMileage");
		break;		
	case 'editMileage':
		editMileage($option, $fordate, $uid, $userid, $vehicleid, $redirecttask);
		break;
	case 'deleteMileage':
		deleteMileage($option, $fordate, $cid, $userid);
		break;
	case 'saveMileageWithReturn':
		saveMileage($option, $fordate, $redirecttask, 1);
		break;
	case 'saveMileage':
		saveMileage($option, $fordate, $redirecttask);
		break;
	case 'showMileageLogForm':
		showMileageLogForm($option, $username);
		break;
		
	// ********************************************************************
	// ********************************************************************
	// ********************************************************************
	case 'adminShowCompanyList':
		adminShowCompanyList($option, $userid);
		break;
	case "adminUnpublishCompany":
		adminPublishCompany($option, $cid, 0);
		break;
	case "adminPublishCompany":
		adminPublishCompany($option, $cid, 1);
		break;	
	case "adminSaveCompany":
		adminSaveCompany($option);
		break;
	case "adminDeleteCompany":
		adminDeleteCompany($option, $cid); //$id
		break;
	case "adminNewCompany":
		adminEditCompany($option, "");
		break;
	case "adminEditCompany":
		adminEditCompany($option, $uid);  //$id
		break;
	// ********************************************************************
	case 'adminShowProjectList':
		adminShowProjectList($option, $userid);
		break;
	case "adminUnpublishProject":
		adminPublishProject($option, $cid, 0);
		break;
	case "adminPublishProject":
		adminPublishProject($option, $cid, 1);
		break;	
	case "adminSaveProject":
		adminSaveProject($option);
		break;
	case "adminDeleteProject":
		adminDeleteProject($option, $cid);  // $id
		break;
	case "adminNewProject":
		adminEditProject($option, "");
		break;
	case "adminEditProject":
		adminEditProject($option, $uid); // $id
		break;
	case "adminShowProjectUserList":
		adminShowProjectUserList($option, $uid); // $id
		break;
	case "adminAddProjectUsers":
		adminAddProjectUsers($option, $userids, $uid);
		break;
	case "adminDeleteProjectUser":
		adminDeleteProjectUser($option, $cid, $uid);
		break;
// ./index.php?option=com_timewriter&task=adminPromoteProjectUserManager&id=13&uid=1 
	case "adminPromoteProjectUserManager":
		adminToggleProjectUserIsManager($option, $cid, $uid, 1);
		break;
	case "adminDemoteProjectUserManager":
		adminToggleProjectUserIsManager($option, $cid, $uid, 0);
		break;
	case "adminPublishProjectUser":
		adminToggleProjectUserIsPublished($option, $cid, $uid, 1);
		break;
	case "adminUnpublishProjectUser":
		adminToggleProjectUserIsPublished($option, $cid, $uid, 0);
		break;
		
	// ********************************************************************
	// ********************************************************************
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
 *  Cast each id element of an db resultsetArray as Integer before appending it to the output.
******************************************************************************/
function implodeIdArray($idArr, $delim=",") {
	$output = "";

	// echo "count:".count($intArr);
	for($i=0; $i < count( $idArr ); $i++) {
		if (strlen(trim($idArr[$i]->id)) > 0) { 
			$output .= ($i>0?$delim:"") . (int)$idArr[$i]->id;
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
				 "title" => HTML_timesheet_content::fmtDate($fordate, "l, F j, Y"), 
				 "next" => $tablerows[0]->next_day);

}


/******************************************************************************
 * 
******************************************************************************/
function buildProjectCriteria($projectid) {
	global $database;
	$projCriteria = "";
	if (is_array($projectid) && count($projectid) > 0) {
		$projCriteria .= "<li>Projects: ";
		if (count($projectid) == 1 && $projectid[0] == 0) {
			$projCriteria .= "All Projects" ;
		} else {
			$projCriteria .= "<ul>"; 
			$tmp = implodeIntArray($projectid);
			$database->setQuery("SELECT project_name from f9ko_oc_project WHERE id IN (".$tmp.") ORDER BY project_name");
			$rows = $database->loadObjectList();
			if ($database->getErrorNum()) {
				$projCriteria .= $database->stderr();
			}
			for($i=0; $i < count( $rows ); $i++) {					
				$projCriteria .= "<li>" . htmlspecialchars($rows[$i]->project_name, ENT_QUOTES) . "</li>";
			}
			$projCriteria .= "</ul>"; 
		}
		$projCriteria .= "</li>";
	}
	return $projCriteria;	
}


/******************************************************************************
 * 
******************************************************************************/
function buildMultiUserCriteria($userid) {
	global $database;
	$usrCriteria = "";
	if (is_array($userid) && count($userid) > 0) {
		$usrCriteria .= "<li>Users: ";
		if (count($userid) == 1 && $userid[0] == 0) {
			$usrCriteria .= "All Users" ;
		} else {
			$usrCriteria .= "<ul>"; 
			// $tmp = implode(',', $userid);
			$tmp = implodeIntArray($userid);
			$database->setQuery("SELECT name from f9ko_users WHERE id IN (".$tmp.") ORDER BY name");
			$rows = $database->loadObjectList();
			if ($database->getErrorNum()) {
				$usrCriteria .= $database->stderr();
			}
			for($i=0; $i < count( $rows ); $i++) {
				$usrCriteria .= "<li>" . $rows[$i]->name . "</li>";
			}
			$usrCriteria .= "</ul>"; 
		}
		$usrCriteria .= "</li>";
	}
	return $usrCriteria;	
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
function showMileageLogForm($option, $username) {
	$title = "Mileage Log";
	$numberOfRows = 28;  // Tweak as required to fit page...
	HTML_timesheet_content::showMileageLogForm( $option, $title, $username, $numberOfRows);
}

/******************************************************************************
 * 
******************************************************************************/
function getStartEndDates($fordate) {
	global $database;

	if (!$fordate) {
		$fordate = date("Y-m-d");
	}	
	$bits = explode("-", $fordate);
	$YEAR = $bits[0];
	$MONTH = $bits[1];
	$day = $bits[2];
	$start = $YEAR."-".$MONTH."-01";
	
	// Add one MONTH, less one day to calculate the last day of the given MONTH.
	$query = "SELECT date_sub(date_add(".$database->Quote($start).",INTERVAL 1 MONTH),INTERVAL 1 DAY) AS last_day";
		
	$database -> setQuery($query);
	$tablerows = $database->loadObjectList();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}
	
	return array( "start" => $start,
				  "end" => $tablerows[0]->last_day);
}
/******************************************************************************
 * 
******************************************************************************/
function showTimesheetForDate($option, $fordate, $userid) {
	global $database;
		
	$arr = prevTitleNext($fordate);
	$next = $arr["next"];
	$prev = $arr["prev"];
	$weekday = $arr["title"];
	
	$query = "SELECT pt.id,pt.date,pt.total_hours,pt.user_id,pt.description,p.project_name,pc.company_name,pt.published,pt.is_billable,pt.at_customer,u.username,u.name"
					. " FROM f9ko_oc_timesheets AS pt"
					. " LEFT JOIN f9ko_users AS u ON (pt.user_id = u.id)"
					. " LEFT JOIN f9ko_oc_project AS p ON (pt.project_id = p.id)"
					. " LEFT JOIN f9ko_oc_company AS pc ON (p.company_id = pc.id)"
					. " WHERE pt.user_id=" . (int) $userid
					. " AND pt.date=".$database->Quote($fordate)
					. " ORDER BY pt.date";
	$database->setQuery($query);
	$rows = $database->loadObjectList();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}
	HTML_timesheet_content::showTimesheetForDate( $option, $rows, $fordate, $next, $prev, $weekday);
}

/******************************************************************************
 * 
******************************************************************************/
function showWeeklyReportByCompany($option, $userid, $startdate, $enddate, $isbillable, $companyid, $pop) {
	global $database;
	
	$criteria = "<ul>";
	
	$criteria .= buildDateCriteria($startdate, $enddate);
	
	$companywhere = "";
	if ($companyid > 0) {
		$companywhere = " AND p.company_id = " . (int)$companyid;
		
		$database->setQuery("SELECT company_name from f9ko_oc_company WHERE id=" . (int)$companyid);
		$rows = $database->loadObjectList();
		if ($database->getErrorNum()) {
			echo $database->stderr();
			return false;
		}
		
		if($rows[0]->general_contractor_id > 0){
			$globalcompany = $rows[0]->general_contractor_id;
			$database->setQuery("SELECT company_name from f9ko_oc_company WHERE id=" . (int)$globalcompany);
			$rows = $database->loadObjectList();
			if ($database->getErrorNum()) {
				echo $database->stderr();
				return false;
			}
			$criteria .= "<li>General Contractor: ".htmlspecialchars($rows[0]->company_name, ENT_QUOTES)."</li>";
		}
		else{
			$criteria .= "<li>Company: ".htmlspecialchars($rows[0]->company_name, ENT_QUOTES)."</li>";
		}
		
		
	}
	// Left the multi-user report criteria here as template for a PM report.
	$userwhere = "";
	$multiUserReport = false;
	if (is_array($userid) && count($userid) > 0) {
		$multiUserReport = true;
		if (count($userid) == 1 && $userid[0] == 0) {
			$criteria .= "<li>Users: All Users</li>";
		} else {
			$tmp = implodeIntArray($userid);
			$userwhere = " AND pt.user_id IN (".$tmp.")";
			$criteria .= buildMultiUserCriteria($userid);
			
		}
	} else {
		$userwhere = " AND pt.user_id = ". (int)$userid;
	}

	$billablewhere = "";
	if ($isbillable > -1) {
		$billablewhere = " AND pt.is_billable = " . (int)$isbillable;
		$criteria .= "<li>Billable: ".($isbillable?"Yes":"No")."</li>";
	}
	$criteria .= "</ul>";
	$query = "SELECT week(pt.date) as weeknum, pt.user_id, pc.company_name, p.project_name, u.username, u.name, 
			SUM(CASE weekday(pt.date) WHEN 0 THEN CASE pt.is_billable WHEN 1 THEN pt.total_hours ELSE 0 END ELSE 0 END) as monday_billable_hours, 
			SUM(CASE weekday(pt.date) WHEN 0 THEN CASE pt.is_billable WHEN 0 THEN pt.total_hours ELSE 0 END ELSE 0 END) as monday_non_billable_hours,  
			SUM(CASE weekday(pt.date) WHEN 1 THEN CASE pt.is_billable WHEN 1 THEN pt.total_hours ELSE 0 END ELSE 0 END) as tuesday_billable_hours, 
			SUM(CASE weekday(pt.date) WHEN 1 THEN CASE pt.is_billable WHEN 0 THEN pt.total_hours ELSE 0 END ELSE 0 END) as tuesday_non_billable_hours, 
			SUM(CASE weekday(pt.date) WHEN 2 THEN CASE pt.is_billable WHEN 1 THEN pt.total_hours ELSE 0 END ELSE 0 END) as wednesday_billable_hours, 
			SUM(CASE weekday(pt.date) WHEN 2 THEN CASE pt.is_billable WHEN 0 THEN pt.total_hours ELSE 0 END ELSE 0 END) as wednesday_non_billable_hours, 
			SUM(CASE weekday(pt.date) WHEN 3 THEN CASE pt.is_billable WHEN 1 THEN pt.total_hours ELSE 0 END ELSE 0 END) as thursday_billable_hours, 
			SUM(CASE weekday(pt.date) WHEN 3 THEN CASE pt.is_billable WHEN 0 THEN pt.total_hours ELSE 0 END ELSE 0 END) as thursday_non_billable_hours, 
			SUM(CASE weekday(pt.date) WHEN 4 THEN CASE pt.is_billable WHEN 1 THEN pt.total_hours ELSE 0 END ELSE 0 END) as friday_billable_hours, 
			SUM(CASE weekday(pt.date) WHEN 4 THEN CASE pt.is_billable WHEN 0 THEN pt.total_hours ELSE 0 END ELSE 0 END) as friday_non_billable_hours, 
			SUM(CASE weekday(pt.date) WHEN 5 THEN CASE pt.is_billable WHEN 1 THEN pt.total_hours ELSE 0 END ELSE 0 END) as saturday_billable_hours, 
			SUM(CASE weekday(pt.date) WHEN 5 THEN CASE pt.is_billable WHEN 0 THEN pt.total_hours ELSE 0 END ELSE 0 END) as saturday_non_billable_hours , 
			SUM(CASE weekday(pt.date) WHEN 6 THEN CASE pt.is_billable WHEN 1 THEN pt.total_hours ELSE 0 END ELSE 0 END) as sunday_billable_hours, 
			SUM(CASE weekday(pt.date) WHEN 6 THEN CASE pt.is_billable WHEN 0 THEN pt.total_hours ELSE 0 END ELSE 0 END) as sunday_non_billable_hours
		FROM f9ko_oc_timesheets AS pt LEFT JOIN f9ko_users AS u ON (pt.user_id = u.id)
		 LEFT JOIN f9ko_oc_project AS p ON (pt.project_id = p.id) 
		 LEFT JOIN f9ko_oc_company AS pc ON (p.company_id = pc.id) 
		WHERE pt.date >= ".$database->Quote($startdate)." 
		  AND pt.date <= ".$database->Quote($enddate)
						. $userwhere
						. $billablewhere
						. $companywhere
		. " GROUP BY week(pt.date), pt.user_id, pc.company_name, u.username, u.name 
			ORDER BY u.name, pc.company_name, week(pt.date)";

	// echo $query;
	//, p.project_name

	$database->setQuery($query);
	$rows = $database->loadObjectList();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}
	if ($multiUserReport) {
		HTML_timesheet_content::multiUserWeeklyReportByCompany( $option, $rows, $startdate, $enddate, $isbillable, $companyid, $userid, $criteria, $pop);
	}else {
		HTML_timesheet_content::showWeeklyReportByCompany( $option, $rows, $startdate, $enddate, $isbillable, $companyid, $criteria, $pop);
	}
}

/******************************************************************************
 * 
******************************************************************************/
function showProjectReportByCompany($option, $userid, $startdate, $enddate, $isbillable, $companyid, $pop) {
	global $database;
	
	/*
	Get the subcontracts from a general contract and print these!!
	*/
	$criteria = "<ul>";
	
	$criteria .= buildDateCriteria($startdate, $enddate);

	$companywhere = "";
	if ($companyid > 0) {
		//check general contract
		$database->setQuery("SELECT count(1) from f9ko_oc_company WHERE general_contractor_id =" . (int)$companyid);
		$countSubs = $database->loadResult();
		if ($database->getErrorNum()) {
			echo $database->stderr();
			return false;
		}
		
		$subco;
		$comp;
		if($countSubs > 0)
		{
		//the company is a general contractor
			$subco = $companyid;
			$database->setQuery("SELECT company_name from f9ko_oc_company WHERE id=" . (int)$companyid);
			$rows = $database->loadObjectList();
			if ($database->getErrorNum()) {
				echo $database->stderr();
				return false;
			}
			$criteria .= "<li>General Contractor: ".htmlspecialchars($rows[0]->company_name, ENT_QUOTES)."</li>";
			//get the subcontract ids
			$database->setQuery("SELECT id,company_name from f9ko_oc_company WHERE general_contractor_id=" . (int)$companyid);
			$rows = $database->loadObjectList();
			if ($database->getErrorNum()) {
				echo $database->stderr();
				return false;
			}
			$cids = implodeIdArray($rows);
			$companywhere = " AND p.company_id IN (".$cids.")";			
			
		}
		else{
			$companywhere = " AND p.company_id = " . (int)$companyid;
			
			$database->setQuery("SELECT id,company_name,general_contractor_id from f9ko_oc_company WHERE id=" . (int)$companyid);
			$rows = $database->loadObjectList();
			if ($database->getErrorNum()) {
				echo $database->stderr();
				return false;
			}
			if($rows[0]->general_contractor_id > 0){
			//the company is a subcontract
				$globalcompany = $rows[0]->general_contractor_id;
				$subco = $globalcompany;
				$database->setQuery("SELECT company_name from f9ko_oc_company WHERE id=" . (int)$globalcompany);
				$rows = $database->loadObjectList();
				if ($database->getErrorNum()) {
					echo $database->stderr();
					return false;
				}
				$criteria .= "<li>General Contractor: ".htmlspecialchars($rows[0]->company_name, ENT_QUOTES)."</li>";
			}
			else{
				$criteria .= "<li>Company: ".htmlspecialchars($rows[0]->company_name, ENT_QUOTES)."</li>";
				$comp = $rows[0]->id;
			}
		}
		
		/** get the hours_day **/
		$hoursaday=-1;
		
		$query = "SELECT hours_day FROM f9ko_oc_project as p"
								. " WHERE p.start_date <= ".$database->Quote($startdate)
								. " AND p.end_date >= ".$database->Quote($enddate);
								
		if($subco > 0)
		{
			$query = $query." AND p.id = ".(int)$subco;
			$hoursaday = $database->loadResult();
			if ($database->getErrorNum()) {
				echo $database->stderr();
				$hoursaday = -1;
			}
		}
		else
		{
			$query = $query." AND p.id = ".(int)$companyid;
			$database->setQuery($query);
			$rrows = $database->loadObjectList();
			if ($database->getErrorNum()) {
				echo $database->stderr();
			}
			else{
				$hoursaday = $rrows[0]->hours_day;
			}
		}
	}
		
	if($hours_day <= 0)
	{
		/*get hours a day*/
		$query = "SELECT up.hours_day FROM f9ko_oc_user_prefs as up"
							. " LEFT JOIN f9ko_oc_project AS p ON (up.project_id = p.id)"
							. " LEFT JOIN f9ko_oc_company AS pc ON (p.company_id = pc.id)"
							. " WHERE  up.user_id = ". (int)$userid
							. " ".$companywhere;
							
		$database->setQuery($query);
		$urows = $database->loadObjectList();
		if ($database->getErrorNum()) {
			echo $database->stderr();
		}
		else{
			$hoursaday = $urows[0]->hours_day;
		}
		if($hoursaday <= 0){
			$hoursaday = 8;
		}
	}
	
	// Left the multi-user report criteria here as template for a PM report.
	if ($userid) {
		$userwhere = " AND pt.user_id = ". (int)$userid;
	}
	$query = "SELECT name from f9ko_users WHERE id = ". (int)$userid;

	$database->setQuery($query);
	$rows = $database->loadObjectList();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}
	$userlist = "";
	for($i=0; $i < count( $rows ); $i++) {
		$row = $rows[$i];
		$userlist = $userlist . ($i > 0?", ":"") . $rows[$i]->name;
	}
	$criteria .= "<li>User: ".$userlist."</li>";


	$billablewhere = "";
	if ($isbillable > -1) {
		$billablewhere = " AND pt.is_billable = " . (int)$isbillable;
		$criteria .= "<li>Billable: ".($isbillable?"Yes":"No")."</li>";
	}
	$criteria .= "</ul>";
	$database->setQuery( "SELECT pt.id, pt.date, pt.total_hours, pt.user_id, pt.description, pc.company_name, p.project_name,"
						. " pt.published, pt.is_billable,pt.at_customer, u.username, u.name"
						. " FROM f9ko_oc_timesheets AS pt"
						. " LEFT JOIN f9ko_users AS u ON (pt.user_id = u.id)"
						. " LEFT JOIN f9ko_oc_project AS p ON (pt.project_id = p.id)"
						. " LEFT JOIN f9ko_oc_company AS pc ON (p.company_id = pc.id)"
						. " WHERE pt.date >= ".$database->Quote($startdate)
						. " AND pt.date <= ".$database->Quote($enddate)
						. $userwhere
						. $billablewhere
						. $companywhere
						. " ORDER BY pt.date" );
	$rows = $database->loadObjectList();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}
	/*
	get projects
	*/
	
	$database->setQuery("SELECT sum(pt.total_hours) as total_hours, pc.company_name, p.project_name, pt.is_billable, u.name"
						. " FROM f9ko_oc_timesheets AS pt"
						. " LEFT JOIN f9ko_users AS u ON (pt.user_id = u.id)"
						. " LEFT JOIN f9ko_oc_project AS p ON (pt.project_id = p.id)"
						. " LEFT JOIN f9ko_oc_company AS pc ON (p.company_id = pc.id)"
						. " WHERE pt.date >= ".$database->Quote($startdate)
						. " AND pt.date <= ".$database->Quote($enddate)
						. $userwhere
						. $billablewhere
						. $companywhere
						. " GROUP BY pc.company_name, p.project_name, pt.is_billable, u.name");
	$prows = $database->loadObjectList();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}
	/*end get projects*/
	
	//  echo $criteria;
	HTML_timesheet_content::showProjectReportByCompany( $option, $rows, $startdate, $enddate, $isbillable, $companyid, $criteria, $pop,$prows,$criteria,$hoursaday);
}

/******************************************************************************
 * 
******************************************************************************/
function showFlextimeReportByCompany($option, $userid, $period, $companyid, $pop){
	global $database;
	
	//get start en end dates
	$startdate = date("Y-m-d" , mktime(0, 0, 0, date("m", strtotime($period)), 1, date("Y", strtotime($period)))); 
	$enddate = date ("Y-m-d",mktime(0, 0, 0, date("m", strtotime($period)), date("t",strtotime($period)), date("Y", strtotime($period)))); 
	
	/*
	Get the subcontracts from a general contract and print these!!
	*/
	$criteria = "<ul>";
	
	$criteria .= buildDateCriteria($startdate, $enddate);
	
	$companywhere = "";
	if ($companyid > 0) {
		//check general contract
		$database->setQuery("SELECT count(1) from f9ko_oc_company WHERE general_contractor_id =" . (int)$companyid);
		$countSubs = $database->loadResult();
		if ($database->getErrorNum()) {
			echo $database->stderr();
			return false;
		}
		if($countSubs > 0)
		{
		//the company is a general contractor
			$database->setQuery("SELECT company_name from f9ko_oc_company WHERE id=" . (int)$companyid);
			$rows = $database->loadObjectList();
			if ($database->getErrorNum()) {
				echo $database->stderr();
				return false;
			}
			$criteria .= "<li>General Contractor: ".htmlspecialchars($rows[0]->company_name, ENT_QUOTES)."</li>";
			//get the subcontract ids
			$database->setQuery("SELECT id,company_name from f9ko_oc_company WHERE general_contractor_id=" . (int)$companyid);
			$rows = $database->loadObjectList();
			if ($database->getErrorNum()) {
				echo $database->stderr();
				return false;
			}
			$cids = implodeIdArray($rows);
			$companywhere = " AND p.company_id IN (".$cids.")";
			
			for($i=0;$i<count($rows);$i++){
				$criteria .= "<li>Company: ".htmlspecialchars($rows[$i]->company_name, ENT_QUOTES)."</li>";
			}
			
			
		}
		else{
			$companywhere = " AND p.company_id = " . (int)$companyid;
			
			$database->setQuery("SELECT company_name,general_contractor_id from f9ko_oc_company WHERE id=" . (int)$companyid);
			$rows = $database->loadObjectList();
			if ($database->getErrorNum()) {
				echo $database->stderr();
				return false;
			}
			
			if($rows[0]->general_contractor_id > 0){
			//the company is a subcontract
				$globalcompany = $rows[0]->general_contractor_id;
				$database->setQuery("SELECT company_name from f9ko_oc_company WHERE id=" . (int)$globalcompany);
				$rows = $database->loadObjectList();
				if ($database->getErrorNum()) {
					echo $database->stderr();
					return false;
				}
				$criteria .= "<li>General Contractor: ".htmlspecialchars($rows[0]->company_name, ENT_QUOTES)."</li>";
			}
			else{
				$criteria .= "<li>Company: ".htmlspecialchars($rows[0]->company_name, ENT_QUOTES)."</li>";
			}
		}
		
		
	}
	// Left the multi-user report criteria here as template for a PM report.
	if ($userid) {
		$userwhere = " AND pt.user_id = ". (int)$userid;
	}
	$query = "SELECT name from f9ko_users WHERE id = ". (int)$userid;

	$database->setQuery($query);
	$rows = $database->loadObjectList();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}
	$userlist = "";
	for($i=0; $i < count( $rows ); $i++) {
		$row = $rows[$i];
		$userlist = $userlist . ($i > 0?", ":"") . $rows[$i]->name;
	}
	$criteria .= "<li>User: ".$userlist."</li>";

	$criteria .= "</ul>";
	$database->setQuery( "SELECT pt.id, pt.date, pt.total_hours, pt.user_id, pt.description, pc.company_name, p.project_name,"
						. " pt.published, pt.is_billable, pt.at_customer, u.username, u.name"
						. " FROM f9ko_oc_timesheets AS pt"
						. " LEFT JOIN f9ko_users AS u ON (pt.user_id = u.id)"
						. " LEFT JOIN f9ko_oc_project AS p ON (pt.project_id = p.id)"
						. " LEFT JOIN f9ko_oc_company AS pc ON (p.company_id = pc.id)"
						. " WHERE pt.date >= ".$database->Quote($startdate)
						. " AND pt.date <= ".$database->Quote($enddate)
						. " AND p.project_name LIKE '%lex%' "
						. $userwhere
						. " AND pt.is_billable = 0 " 
						. $companywhere
						. " ORDER BY pt.date" );
	$rows = $database->loadObjectList();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}
	/*
	get projects
	*/
	
	$database->setQuery("SELECT sum(pt.total_hours) as total_hours, pc.company_name, p.project_name, pt.is_billable, u.name"
						. " FROM f9ko_oc_timesheets AS pt"
						. " LEFT JOIN f9ko_users AS u ON (pt.user_id = u.id)"
						. " LEFT JOIN f9ko_oc_project AS p ON (pt.project_id = p.id)"
						. " LEFT JOIN f9ko_oc_company AS pc ON (p.company_id = pc.id)"
						. " WHERE pt.date >= ".$database->Quote($startdate)
						. " AND pt.date <= ".$database->Quote($enddate)
						. " AND p.project_name LIKE '%lex%' "
						. $userwhere
						. " AND pt.is_billable = 0 " 
						. $companywhere
						. " GROUP BY pc.company_name, p.project_name, pt.is_billable, u.name");
	$prows = $database->loadObjectList();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}
	/*end get projects*/
	/*get hours a day*/
	$query = "SELECT hours_day FROM f9ko_oc_user_prefs as up"
						. " LEFT JOIN f9ko_oc_project AS p ON (up.project_id = p.id)"
						. " LEFT JOIN f9ko_oc_company AS pc ON (p.company_id = pc.id)"
						. " WHERE  up.user_id = ". (int)$userid
						. " ".$companywhere;
	$database->setQuery($query);
	$urows = $database->loadObjectList();
	if ($database->getErrorNum()) {
		echo $database->stderr();
	}
	else{
		$hoursaday = $urows[0]->hours_day;
	}
	if($hoursaday == 0){
		$hoursaday = 8;
	}
	//  echo $criteria;
	HTML_timesheet_content::showFlextimeReportByCompany( $option, $rows, $startdate, $enddate, $isbillable, $companyid, $criteria, $pop,$prows,$criteria,$hoursaday);
}
/******************************************************************************
 * 
******************************************************************************/
function showProjectReportByProject($option, $userid, $startdate, $enddate, $isbillable, $projectid, $pop) {
	global $database;
	
	$criteria = "<ul>";
	
	$criteria .= buildDateCriteria($startdate, $enddate);
	//$tmp = implodeIntArray($projectid);
	//$projectwhere = " AND pt.project_id IN (".$tmp.")";
	$projectwhere = " AND pt.project_id = ".$projectid;// (".$tmp.")";
	$criteria .= buildProjectCriteria($projectid);
	
		
	// Left the multi-user report criteria here as template for a PM report.
	$userids = "";
	
	if (!is_array( $userids )) {
		$userids = array();
	}
	if ($userid) {
		$userids[] = $userid;
		$tmp = implodeIntArray($userids);
		$userwhere = " AND pt.user_id IN (".$tmp.")";
	}

	$tmp = implodeIntArray($userids);
	$database->setQuery("SELECT name from f9ko_users WHERE id IN (".$tmp.")");
	$rows = $database->loadObjectList();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}
	$userlist = "";
	for($i=0; $i < count( $rows ); $i++) {
		$row = $rows[$i];
		$userlist .= ($i > 0?", ":"") . $rows[$i]->name;
	}
	$criteria .= "<li>User: ".$userlist."</li>";


	$billablewhere = "";
	if ($isbillable > -1) {
		$billablewhere = " AND pt.is_billable = ".(int)$isbillable;
		$criteria .= "<li>Billable: ".($isbillable?"Yes":"No")."</li>";
	}
	$criteria .= "</ul>";
	$database->setQuery( "SELECT pt.id, pt.date, pt.total_hours, pt.user_id, pt.description, pc.company_name, p.project_name,"
						. " pt.published, pt.is_billable, u.username, u.name"
						. " FROM f9ko_oc_timesheets AS pt"
						. " LEFT JOIN f9ko_users AS u ON (pt.user_id = u.id)"
						. " LEFT JOIN f9ko_oc_project AS p ON (pt.project_id = p.id)"
						. " LEFT JOIN f9ko_oc_company AS pc ON (p.company_id = pc.id)"
						. " WHERE pt.date >= ".$database->Quote($startdate)
						. " AND pt.date <= ".$database->Quote($enddate)
						. $userwhere
						. $billablewhere
						. $projectwhere
						. " ORDER BY pt.date" );
	$rows = $database->loadObjectList();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}
	
	/*get hours a day*/
	$query ="SELECT hours_day"
						. " FROM f9ko_oc_user_prefs as pt"
						. " WHERE  pt.user_id = ". (int)$userid
						. " " .$projectwhere;
	$database->setQuery($query);						
	$urows = $database->loadObjectList();
	if ($database->getErrorNum()) {
		echo $database->stderr();
	}
	else{
		$hoursaday = $urows[0]->hours_day;
	}
	if($hoursaday == 0){
		$hoursaday = 8;
	}

	//  echo $criteria;
	HTML_timesheet_content::showProjectReportByProject( $option, $rows, $startdate, $enddate, $isbillable, $projectid, $criteria, $pop, $hoursaday);
}

/******************************************************************************
 * 
******************************************************************************/
function showTotalHoursPerProject($option, $userid, $startdate, $enddate, $isbillable, $pop) {
	global $database;
	
	$criteria = "<ul>";
	
	$criteria .= buildDateCriteria($startdate, $enddate);
	
	$userwhere = "";

	// Left the multi-user report criteria here as template for a Project Manager report.
	$userids = "";	
	if (!is_array( $userids )) {
		$userids = array();
	}
	if ($userid) {
		$userids[] = $userid;
		$tmp = implodeIntArray($userids);
		$userwhere = " AND pt.user_id IN (".$tmp.")";
	}
	$tmp = implodeIntArray($userids);
	$database->setQuery("SELECT name from f9ko_users WHERE id IN (".$tmp.")");
	$rows = $database->loadObjectList();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}
	$userlist = "";
	for($i=0; $i < count( $rows ); $i++) {
		$row = $rows[$i];
		$userlist = $userlist . ($i == 0?"<ul>":"") . "<li>" . $rows[$i]->name ."</li>";
	}
	$criteria .= "<li>Users: ".$userlist."</ul></li>";		

	$billablewhere = "";
	if ($isbillable > -1) {
		$billablewhere = " AND pt.is_billable = '$isbillable'";
		$criteria .= "<li>Billable: ".($isbillable?"Yes":"No")."</li>";
	}
	$criteria .= "</ul>";
	$query = "SELECT sum(pt.total_hours) as total_hours, pc.company_name, p.project_name, pt.is_billable, u.name"
						. " FROM f9ko_oc_timesheets AS pt"
						. " LEFT JOIN f9ko_users AS u ON (pt.user_id = u.id)"
						. " LEFT JOIN f9ko_oc_project AS p ON (pt.project_id = p.id)"
						. " LEFT JOIN f9ko_oc_company AS pc ON (p.company_id = pc.id)"
						. " WHERE pt.date >= ".$database->Quote($startdate)
						. " AND pt.date <= ".$database->Quote($enddate)
						. $userwhere
						. $billablewhere
						. $projectwhere
						. " GROUP BY pc.company_name, p.project_name, pt.is_billable, u.name";
	$database->setQuery($query);
	$rows = $database->loadObjectList();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}
	HTML_timesheet_content::showTotalHoursPerProject( $option, $rows, $startdate, $enddate, $isbillable, $criteria, $pop);
}


/******************************************************************************
 * 
******************************************************************************/
function showTotalMileageReport($option, $userid, $startdate, $enddate, $isbillable, $companyid, $vehicleid, $pop) {
	global $database;
	
	$criteria = "<ul>";
	
	$criteria .= buildDateCriteria($startdate, $enddate);

	$companywhere = "";
	if ($companyid) {
		$database->setQuery("SELECT company_name from f9ko_oc_company WHERE id = " . (int)$companyid);
		$companyName = $database->loadResult();
		if ($database->getErrorNum()) {
			echo $database->stderr();
			return false;
		}
		if($rows[0]->general_contractor_id > 0){
			$globalcompany = $rows[0]->general_contractor_id;
			$database->setQuery("SELECT company_name from f9ko_oc_company WHERE id=" . (int)$globalcompany);
			$rows = $database->loadObjectList();
			if ($database->getErrorNum()) {
				echo $database->stderr();
				return false;
			}
			$criteria .= "<li>General Contractor: ".htmlspecialchars($rows[0]->company_name, ENT_QUOTES)."</li>";
		}
		else{
			$criteria .= "<li>Company: ".htmlspecialchars($rows[0]->company_name, ENT_QUOTES)."</li>";
		}
		
		
		$companywhere = " AND m.company_id = '$companyid'";
	}
	$vehiclewhere = "";
	if ($vehicleid) {
		$database->setQuery("SELECT vehicle_name from f9ko_oc_user_vehicles WHERE id = " . (int)$vehicleid);
		$vehicleName = $database->loadResult();
		if ($database->getErrorNum()) {
			echo $database->stderr();
			return false;
		}
		$criteria .= "<li>Vehicle: ".htmlspecialchars($vehicleName, ENT_QUOTES)."</li>";
		$vehiclewhere = " AND m.vehicle_id = " . (int)$vehicleid;
	}

	$billablewhere = "";
	if ($isbillable > -1) {
		$billablewhere = " AND m.is_billable = " . (int)$isbillable;
		$criteria .= "<li>Billable: ".($isbillable?"Yes":"No")."</li>";
	}

	$userwhere = "";
	$multiUserReport = false;
	if (is_array($userid) && count($userid) > 0) {
		$multiUserReport = true;
		if (count($userid) == 1 && $userid[0] == 0) {
			$criteria .= "<li>Users: All Users</li>";
		} else {
			$tmp = implodeIntArray($userid);
			$userwhere = " AND m.user_id IN (".$tmp.")";
			// $criteria .= "<li>Users: ".implode(', ', $userid)."</li>";
			$criteria .= buildMultiUserCriteria($userid);
			
		}
	} else {
		$userwhere = " AND m.user_id = ".(int)$userid;
		// $criteria .= "<li>User: ".$userid."</li>";
	}
	
	$criteria .= "</ul>";
	
	$query = "SELECT m.*, v.vehicle_name, c.company_name, u.name"
			. " FROM f9ko_oc_user_mileage as m"
			. " left join f9ko_users as u on m.user_id = u.id"
			. " left join f9ko_oc_user_vehicles as v on m.vehicle_id = v.id"
			. " left join f9ko_oc_company as c on m.company_id = c.id"
			. " WHERE m.date >= ".$database->Quote($startdate)." AND m.date <= ".$database->Quote($enddate)
			. $userwhere
			. $billablewhere
			. $companywhere
			. $vehiclewhere
			. " ORDER BY m.date, m.start_odometer, m.id";
	// echo $query;
	$database->setQuery($query);
	$rows = $database->loadObjectList();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}
	
//function multiUserTotalMileageReport( $option, $rows, $startdate, $enddate, $isbillable, $companyid, $userids, $criteria, $pop) {
//function showTotalMileageReport(         $option, $rows, $startdate, $enddate, $isbillable, $companyid, $vehicleid, $userid, $criteria, $pop) {
	
	if ($multiUserReport) {
		HTML_timesheet_content::multiUserTotalMileageReport( $option, $rows, $startdate, $enddate, $isbillable, $companyid, $userid, $criteria, $pop);
	} else {
		HTML_timesheet_content::showTotalMileageReport(      $option, $rows, $startdate, $enddate, $isbillable, $companyid, $vehicleid, $userid, $criteria, $pop);
	}
}

/******************************************************************************
 * 
******************************************************************************/
function showSimpleTimesheetReport($option, $fordate, $userid, $username, $pop) {
	global $database;

	$MONTHname = HTML_timesheet_content::fmtDate($fordate, "F, Y");
	$arr = getStartEndDates($fordate);
	$startdate = $arr["start"];
	$enddate = $arr["end"];

	$query = "SELECT pt.id, pt.date, pt.total_hours, pt.user_id, pt.description, pc.company_name, p.project_name, pt.published, pt.is_billable, pt.at_customer, u.username, u.name"
						. " FROM f9ko_oc_timesheets AS pt"
						. " LEFT JOIN f9ko_users AS u ON (pt.user_id = u.id)"
						. " LEFT JOIN f9ko_oc_project AS p ON (pt.project_id = p.id)"
						. " LEFT JOIN f9ko_oc_company AS pc ON (p.company_id = pc.id)"
						. " WHERE pt.user_id=$userid"
						. " AND pt.date >= ".$database->Quote($startdate)
						. " AND pt.date <= ".$database->Quote($enddate)
						. " ORDER BY pt.date";
	// echo($query);
	$database->setQuery($query);
	$rows = $database->loadObjectList();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}
	
	HTML_timesheet_content::showSimpleTimesheetReport( $option, $rows, $fordate, $MONTHname, $username, $pop);
}


/******************************************************************************
 * 
******************************************************************************/
function saveProjectTimesheets( $option, $cid, $fordate, $projectid, $redirecttask) {
	global $database;

	$row = new josOCTimesheets( $database );
	if (!$row->bind( $_POST )) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>";
		exit();
	}
	if (!$row->store()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>";
		exit();
	}

	mosRedirect( "index.php?option=com_timewriter&amp;task=$redirecttask&amp;fordate=".$fordate);
}

/******************************************************************************
 *
******************************************************************************/
function saveVehicle( $option, $fordate) {
	global $database;

	$row = new josOCUserVehicles( $database );
	if (!$row->bind( $_POST )) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>";
		exit();
	}
	if (!$row->store()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>";
		exit();
	}

	mosRedirect( "index.php?option=$option&amp;task=showVehicles&amp;fordate=$fordate");
}

/******************************************************************************
 *
******************************************************************************/
function saveMileage( $option, $fordate, $redirecttask, $createReturn=0) {
	global $database;

	$row = new josOCUserMileage( $database );
	if (!$row->bind( $_POST )) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>";
		exit();
	}
	if (!$row->store()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>";
		exit();
	}
	if ($createReturn) {
		$row->id = "";
		$row->parking = "";
		$tmp = $row->start_location;
		$row->start_location = $row->end_location;
		$row->end_location = $tmp;
		$tmp = $row->end_odometer;
		$row->end_odometer = $row->end_odometer + ($row->end_odometer - $row->start_odometer);
		$row->start_odometer = $tmp;
		$row->notes = "Return trip automatically created";
		if (!$row->store()) {
			echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>";
			exit();
		}
	}
	mosRedirect( "index.php?option=$option&amp;task=$redirecttask&amp;fordate=$fordate");
}
/******************************************************************************
 * 
******************************************************************************/
function showUserPreferencesCriteria( $option) {
	
	$lists['user_id_fp'] = HTML_timesheet::userselect( 'user_id_fp', 0, 0, '', 'name', '- No User -', 1);
	
	HTML_timesheet_content::showUserPreferencesCriteria( $option, $lists);
}
/******************************************************************************
 * 
******************************************************************************/
function showUserPreferences( $option, $fordate, $userid) {
	global $database;
	
	$query = "SELECT id FROM f9ko_oc_user_prefs WHERE user_id = " . (int)$userid;
	$database->setQuery( $query );
	$prefid = $database->loadResult();

	$row = new josOCUserPrefs( $database );
	if ($prefid) {
		$row->load( $prefid );  
	} else {
		// Setup new entry defaults
		$row->id = "";
		$row->project_id = 0;
		$row->vehicle_id = 0;
		$row->is_billable = 1;
		$row->hours_day=8;
		$row->rate_hour=0;
		$row->tax_rate=21.5;
		$row->mileage_rate=0;
		$row->mileage_is_billable = 1;
		$row->start_location = "";
		$row->end_location = "";
		$row->parking = "";
	}
	$lists['project_id'] = HTML_timesheet::userProjectSelect( 'project_id', $row->project_id, 1, '', 'c.company_name, p.project_name', '- No Project -', 1, 1, $userid);
	$lists['vehicle_id'] = HTML_timesheet::vehicleselect( 'vehicle_id', $row->vehicle_id, $userid, 1); 

	HTML_timesheet_content::showUserPreferences( $option, $lists, $fordate, $userid, $row);
}

/******************************************************************************
 * 
******************************************************************************/
function saveUserPreferences( $option, $fordate) {
	global $database;

	$row = new josOCUserPrefs( $database );
	if (!$row->bind( $_POST )) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>";
		exit();
	}
	if (!$row->store()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>";
		exit();
	}

	mosRedirect( "index.php?option=$option&amp;task=showReportMenu&amp;fordate=$fordate");
}

/******************************************************************************
 * 
******************************************************************************/
function mainDisplay( $option, $fordate) {
	global $database, $mainframe;
	$user=$mainframe->getUser();
	$userid=$user->id;
	
	$currentdate = isset($fordate)?$fordate:NULL;
	
	if($currentdate==NULL || $currentdate == ''){
		//$currentdate=date("Y-m-d");
		$currentdate="current_date()";
		$query="select MONTH($currentdate) as MONTH,
		YEAR($currentdate) as YEAR, 
		YEAR($currentdate + interval 1 MONTH) as next_YEAR, 
		YEAR($currentdate - interval 1 MONTH) as last_YEAR,
		lpad(MONTH($currentdate),2,'0') as MONTHnum,
		concat(lpad(YEAR($currentdate + interval 1 MONTH),4,'0'),'-',lpad(MONTH($currentdate + interval 1 MONTH),2,'0'),'-01') as next_MONTH_date,
		concat(lpad(YEAR($currentdate - interval 1 MONTH),4,'0'),'-',lpad(MONTH($currentdate - interval 1 MONTH),2,'0'),'-01') as last_MONTH_date,
		concat(lpad(YEAR($currentdate),4,'0'),'-',lpad(MONTH($currentdate),2,'0'),'-01') as this_MONTH_date,
		weekday(concat(YEAR($currentdate),'-',lpad(MONTH($currentdate),2,'0'),'-01'))+1 as first_day_num,
		week(concat(YEAR($currentdate),'-',lpad(MONTH($currentdate),2,'0'),'-01')) as weeknumstart;";
	
	} else {
		// Make sure $currentdate is clean before using it.
		$currentdate = $database->Quote($currentdate);
		$query="select MONTH($currentdate) as MONTH,
		YEAR($currentdate) as YEAR, 
		YEAR(date_add($currentdate,interval 1 MONTH)) as next_YEAR, 
		YEAR(date_sub($currentdate,interval 1 MONTH)) as last_YEAR,
		lpad(MONTH($currentdate),2,'0') as MONTHnum,
		concat(lpad(YEAR(date_add($currentdate,interval 1 MONTH)),4,'0'),'-',lpad(MONTH(date_add($currentdate,interval 1 MONTH)),2,'0'),'-01') as next_MONTH_date,
		concat(lpad(YEAR(date_sub($currentdate,interval 1 MONTH)),4,'0'),'-',lpad(MONTH(date_sub($currentdate,interval 1 MONTH)),2,'0'),'-01') as last_MONTH_date,
		concat(lpad(YEAR($currentdate),4,'0'),'-',lpad(MONTH($currentdate),2,'0'),'-01') as this_MONTH_date,
		weekday(concat(YEAR($currentdate),'-',lpad(MONTH($currentdate),2,'0'),'-01'))+1 as first_day_num,
		week(concat(YEAR($currentdate),'-',lpad(MONTH($currentdate),2,'0'),'-01')) as weeknumstart;";

		//Get current MONTH
		$database -> setQuery($query);
		$tablerows = $database->loadObjectList();
		if ($database->getErrorNum()) {
			echo $database->stderr();
			return false;
		}
	}
/*
	// Get both Billable and non-billable totals per date
	$query="SELECT t.date, sum(round(t.billable_hours,2)) AS billable_hours, sum(round(t.nonbillable_hours,2)) AS nonbillable_hours, sum(round(t.mileage,0)) AS mileage FROM ("
			. " SELECT pt.date, pt.total_hours AS billable_hours, 0 AS nonbillable_hours, 0 AS mileage"
			. "  FROM f9ko_oc_timesheets AS pt"
			. "  WHERE pt.is_billable = '1' and pt.user_id=".(int)$userid." and MONTH(pt.date)=MONTH($currentdate) and YEAR(pt.date)=YEAR($currentdate)"
			. " UNION ALL "
			. " SELECT pt.date, 0 AS billable_hours, pt.total_hours AS nonbillable_hours, 0 AS mileage"
			. "  FROM f9ko_oc_timesheets AS pt"
			. "  WHERE pt.is_billable = '0' and pt.user_id=".(int)$userid." and MONTH(pt.date)=MONTH($currentdate) and YEAR(pt.date)=YEAR($currentdate)"
			. " UNION ALL "
			. " SELECT um.date, 0 AS billable_hours, 0 AS nonbillable_hours, (um.end_odometer - um.start_odometer) AS mileage"
			. "  FROM f9ko_oc_user_mileage AS um"
			. "  WHERE um.user_id=".(int)$userid." and MONTH(um.date)=MONTH($currentdate) and YEAR(um.date)=YEAR($currentdate)"
			. " ) AS t GROUP BY t.date ORDER BY t.date";	
	// echo $query;
	
	$database -> setQuery($query);
	$rows = $database->loadObjectList();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}
*/
	$billableDateHours = array();
	$nonbillableDateHours = array();
	$dateMileage = array();

	$query = "SELECT pt.date, SUM(CASE pt.is_billable WHEN 1 THEN round(pt.total_hours, 2) ELSE 0 END) as billable_hours,"
			. " SUM(CASE pt.is_billable WHEN 0 THEN round(pt.total_hours, 2) ELSE 0 END) as nonbillable_hours"
			. " FROM f9ko_oc_timesheets AS pt"
			. " WHERE pt.user_id=$userid and MONTH(pt.date)=MONTH($currentdate) and YEAR(pt.date)=YEAR($currentdate)"
			. " GROUP BY pt.date ORDER BY pt.date";	

	// Get both Billable and non-billable totals per date


	$database -> setQuery($query);
	$rows = $database->loadObjectList();
	if ($database->getErrorNum()&& $database->getErrorNum() != 1065) {
		echo $database->stderr();
		return false;
	}


	for($i=0; $i < count( $rows ); $i++) {					
		if ($rows[$i]->billable_hours) {
			$billableDateHours[$rows[$i]->date] = $rows[$i]->billable_hours;
		}
		if ($rows[$i]->nonbillable_hours) {
			$nonbillableDateHours[$rows[$i]->date] = $rows[$i]->nonbillable_hours;
		}
	}
	// Get Mileage totals per date
	$query="SELECT um.date, SUM(um.end_odometer - um.start_odometer) AS mileage"
			. " FROM f9ko_oc_user_mileage AS um"
			. " WHERE um.user_id=".(int)$userid." and MONTH(um.date)=MONTH($currentdate) and YEAR(um.date)=YEAR($currentdate)"
			. " GROUP BY um.date ORDER BY um.date";	
	$database -> setQuery($query);
	$rows = $database->loadObjectList();
	if ($database->getErrorNum() && $database->getErrorNum() != 1065) {
		echo $database->stderr();
		return false;
	}

	for($i=0; $i < count( $rows ); $i++) {					
		if ($rows[$i]->mileage) {
			$dateMileage[$rows[$i]->date] = $rows[$i]->mileage;
		}
	}
	
	HTML_timesheet_content::mainDisplay($option, $fordate, $tablerows[0], $billableDateHours, $nonbillableDateHours, $dateMileage);
}

/******************************************************************************
 * 
******************************************************************************/
function deleteProjectTimesheets( $option, $cid, $fordate, $userid ) {
	global $database;
	
	if (!is_array( $cid ) || count( $cid ) < 1) {
		echo "<script> alert('Select an item to delete'); window.history.go(-1);</script>";
		exit;
	}
	if (count( $cid )) {
		$cids = implodeIntArray($cid);
		$database->setQuery( "DELETE FROM f9ko_oc_timesheets WHERE id IN ($cids) and user_id = " . (int)$userid );
		if (!$database->query()) {
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>";
		}
	}
	mosRedirect( "index.php?option=com_timewriter&amp;task=showTimesheet&amp;fordate=".$fordate );
}

/******************************************************************************
 * 
******************************************************************************/
function deleteVehicle( $option, $fordate, $cid, $userid ) {
	global $database;

	$cids = implodeIntArray($cid);
	$query = "SELECT count(1) FROM f9ko_oc_user_mileage WHERE id IN ($cids)";
	$database->setQuery( $query );
	$found = $database->loadResult();
	if ($found) {
		 echo "<script> alert('The selected vehicles have been applied to ".(int)$found." mileage entries and cannot be deleted'); window.history.go(-1);</script>";
		 exit;
	}

	if (!is_array( $cid ) || count( $cid ) < 1) {
		echo "<script> alert('Select an item to delete'); window.history.go(-1);</script>";
		exit;
	}
	if (count( $cid )) {
		$cids = implodeIntArray($cid);
		$database->setQuery( "DELETE FROM f9ko_oc_user_vehicles WHERE id IN ($cids) and user_id = " . (int)$userid );
		if (!$database->query()) {
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>";
		}
	}
	mosRedirect( "index.php?option=com_timewriter&amp;task=showVehicles&amp;fordate=".$fordate );
}

/******************************************************************************
 * 
******************************************************************************/
function deleteMileage( $option, $fordate, $cid, $userid ) {
	global $database;

	if (!is_array( $cid ) || count( $cid ) < 1) {
		echo "<script> alert('Select an item to delete'); window.history.go(-1);</script>";
		exit;
	}
	if (count( $cid )) {
		$cids = implodeIntArray($cid);
		$database->setQuery( "DELETE FROM f9ko_oc_user_mileage WHERE id IN ($cids) and user_id = " . (int)$userid );
		if (!$database->query()) {
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>";
		}
	}
	mosRedirect( "index.php?option=com_timewriter&amp;task=showMileage&amp;fordate=".$fordate );
}


/******************************************************************************
 * 
******************************************************************************/
function editProjectTimesheets( $option, $fordate, $uid, $userid, $redirecttask) {
	global $database;
		
	$row = new josOCTimesheets( $database );
	if ($uid) {
		$row->load( $uid );  
	} else {
		// For new Entries...
		$query = "SELECT id FROM f9ko_oc_user_prefs WHERE user_id = " . (int)$userid;
		$database->setQuery( $query );
		$prefid = $database->loadResult();
		$row = new josOCUserPrefs( $database );
		$defbillable = 1;
		$defproject = 0;
		if ($prefid) {
			$row->load( $prefid ); 
			$defbillable = $row->is_billable;
			$defproject = $row->project_id;
		}
		// Setup new entry defaults
		$row->id = "";
		$row->date = $fordate;
		$row->total_hours = "0";
		$row->hours_day = 8;
		$row->project_id = $defproject;
		$row->description = "";
		$row->is_billable = $defbillable;
		$row->at_customer=1;
	}
	
	$lists['project_id'] = HTML_timesheet::userProjectSelect( 'project_id', $row->project_id, 1, '', 'c.company_name, p.project_name', '- No Project -', 1, 1, $userid);
	HTML_timesheet_content::editProjectTimesheets( $option, $lists, $fordate, $userid, $row, $redirecttask);
}

/******************************************************************************
 * 
******************************************************************************/
function editVehicle( $option, $fordate, $uid, $userid) {
	global $database;
	$query = "SELECT id FROM f9ko_oc_user_vehicles WHERE id = ".(int)$uid;

	$database->setQuery( $query );
	$vid = $database->loadResult();
	
	$row = new josOCUserVehicles( $database );

	if ($vid) {
		$row->load( $uid );  
	} else {
		// Setup new entry defaults
		$row->id = "";
		$row->user_id = $userid;
		$row->name = "";
		$row->description = "";
		$row->units = "Kms";
		$row->published = "1";
	}
	$lists['units'] = HTML_timesheet::vehicleunitsradio ($row->units);
	HTML_timesheet_content::editVehicle( $option, $lists, $fordate, $row);
}

/******************************************************************************
 * 
******************************************************************************/
function editMileage( $option, $fordate, $uid, $userid, $vehicle_id, $redirecttask) {
	global $database;
	$query = "SELECT id FROM f9ko_oc_user_mileage WHERE id = ".(int)$uid;

	$database->setQuery( $query );
	$mid = $database->loadResult();

	$row = new josOCUserMileage( $database );
	
	if ($mid) {
		$row->load( $uid );  
	} else {
		// For new Entries...
		$query = "SELECT id FROM f9ko_oc_user_prefs WHERE user_id = ".(int)$userid;
		$database->setQuery( $query );
		$prefid = $database->loadResult();

		$row = new josOCUserPrefs( $database );
		$defbillable = 0;
		$maxodometer = 0;
		$defvehicle_id = 0;
		$parking = "";
		$startloc = "";
		$endloc = "";
		if ($prefid) {
			$row->load( $prefid ); 
			$defbillable = $row->mileage_is_billable;
			$startloc = $row->start_location;
			$endloc = $row->end_location;
			$defvehicle_id = $row->vehicle_id;
			$parking  = $row->parking;
		}
		if ($vehicle_id) {
			// Vehicle is not specified in User Prefs but is in the request.
			$defvehicle_id = $vehicle_id;
		}
		if ($defvehicle_id) {
			$query = "SELECT max(end_odometer) FROM f9ko_oc_user_mileage"
					. " WHERE user_id = ".(int)$userid." AND vehicle_id = " . (int)$defvehicle_id;
			$database->setQuery( $query );
			$maxodometer = $database->loadResult();
		}  

		// Setup new entry defaults
		$row->id = "";
		$row->user_id = $userid;
		$row->is_billable = $defbillable;
		$row->date = $fordate;
		$row->start_odometer = $maxodometer;
		$row->end_odometer = $maxodometer;
		$row->vehicle_id = $defvehicle_id;
		$row->start_location = $startloc;
		$row->end_location = $endloc;
		$row->parking = $parking;
		
		$vehiclejavascript = "onchange=\"window.location.href='./index.php?option=com_timewriter&task=editMileage&id=' + document.adminForm.id.value + '&fordate=' + document.adminForm.date.value + '&vehicle_id=' + document.adminForm.vehicle_id.value + '&redirecttask=' + document.adminForm.redirecttask.value;\"";
	}
	$lists['vehicle_id'] = HTML_timesheet::vehicleselect ('vehicle_id', $row->vehicle_id, $userid, 1, $vehiclejavascript);
	$lists['company_id'] = HTML_timesheet::userCompanySelect( 'company_id', $row->company_id, 1, '', 'company_name', '- Personal Use -', 1, $userid);
	 
	HTML_timesheet_content::editMileage( $option, $lists, $fordate, $row, $redirecttask);
}

/******************************************************************************
 * 
******************************************************************************/
function showVehicles( $option, $fordate, $userid) {
	global $database;
		
	$query = "SELECT * FROM f9ko_oc_user_vehicles WHERE user_id = " . (int)$userid;
	$database->setQuery( $query );
	$tablerows = $database->loadObjectList();
	
	HTML_timesheet_content::showVehicles( $option, $fordate, $userid, $tablerows);
}

/******************************************************************************
 *
******************************************************************************/
function showMileage( $option, $fordate, $userid) {
	global $database;

	$arr = prevTitleNext($fordate);
	$next = $arr["next"];
	$prev = $arr["prev"];
	$title = $arr["title"];
	
	$query = "SELECT m.*, v.vehicle_name, c.company_name"
			. " FROM f9ko_oc_user_mileage as m"
			. " LEFT JOIN f9ko_oc_user_vehicles v on m.vehicle_id = v.id"
			. " LEFT JOIN f9ko_oc_company as c on m.company_id = c.id"
			. " WHERE m.date = ".$database->Quote($fordate)." AND m.user_id = ".(int)$userid
			. " ORDER BY m.start_odometer, m.id";
	$database->setQuery( $query );
	$tablerows = $database->loadObjectList();

	HTML_timesheet_content::showMileage( $option, $fordate, $next, $prev, $userid, $tablerows, $title);
}


/******************************************************************************
 * 
******************************************************************************/
function showReportMenu($option, $fordate, $userid) {

	$isProjectManager = HTML_Timesheet::userIsProjectManager($userid);	
	$isAdmin = HTML_Timesheet::userIsTimesheetAdmin($userid);	

	HTML_timesheet_content::showReportMenu($option, $fordate, $isAdmin, $isProjectManager);
}

/******************************************************************************
 * 
******************************************************************************/
function showWeeklyReportByCompanyCriteria( $option, $userid, $fordate, $startdate, $enddate, $isbillable, $companyid) {
	
	$lists['company_id'] = HTML_timesheet::companyselect( 'company_id', $companyid, 1, '', 'company_name', '- All Companies -', $userid);
	$lists['is_billable'] = HTML_timesheet::isbillableradio(($isbillable==""?1:$isbillable), 1);
	
	if ($startdate == "") {
		$arr = getStartEndDates($fordate);
		$startdate = $arr["start"];
		$enddate = $arr["end"];
	}
	HTML_timesheet_content::showWeeklyReportByCompanyCriteria( $option, $lists, $userid, $startdate, $enddate);
}

/******************************************************************************
 *
******************************************************************************/
function multiUserWeeklyReportByCompanyCriteria( $option, $userids, $fordate, $startdate, $enddate, $isbillable, $companyid, $userid) {

	// Make sure the top one is selected by default
	if (is_array( $userids ) && count($userids) == 0) {
		$userids[] = 0;
	}

	
	$javascript = "onchange=\"window.location.href='./index.php?option=com_timewriter&task=multiUserWeeklyReportByCompanyCriteria&company_id=' + document.adminForm.company_id.value + '&current_date=' + document.adminForm.current_date.value + '&end_date=' + document.adminForm.end_date.value + '&is_billable=' + getCheckboxValue(document.adminForm.is_billable);\"";
	$lists['company_id'] = HTML_timesheet::projectManagerCompanySelect( 'company_id', $companyid, 1, $javascript, 'company_name', '- All Companies -', $userid);
	$lists['user_ids'] = HTML_timesheet::userselect( 'user_id_fp', 0, 0, '', 'name', '- No User -', 1);
	$lists['is_billable'] = HTML_timesheet::isbillableradio(($isbillable==""?1:$isbillable), 1);

	if ($startdate == "") {
		$arr = getStartEndDates($fordate);
		$startdate = $arr["start"];
		$enddate = $arr["end"];
	}
	HTML_timesheet_content::multiUserWeeklyReportByCompanyCriteria( $option, $lists, $userid, $startdate, $enddate);
	// HTML_timesheet_content::multiUserTotalMileageCriteria( $option, $lists, $userid, $startdate, $enddate);
}

/******************************************************************************
 * 
******************************************************************************/
function showTimesheetReportByCompanyCriteria( $option, $userid, $fordate, $startdate, $enddate, $isbillable, $companyid) {
	
	$lists['company_id'] = HTML_timesheet::companyselect( 'company_id', $companyid, 1, '', 'company_name', '- No Company -', 1, $userid);
	$lists['is_billable'] = HTML_timesheet::isbillableradio(($isbillable==""?-1:$isbillable), 1);
	
	if ($startdate == "") {
		$arr = getStartEndDates($fordate);
		$startdate = $arr["start"];
		$enddate = $arr["end"];
	}
	HTML_timesheet_content::showTimesheetReportByCompanyCriteria( $option, $lists, $userid, $startdate, $enddate);
}
/******************************************************************************
 * 
******************************************************************************/
function showFlextimeReportByCompanyCriteria( $option, $userid, $fordate, $period, $companyid) {
	
	$lists['company_id'] = HTML_timesheet::companyselect( 'company_id', $companyid, 1, '', 'company_name', '- No Company -', 1, $userid);
	
	HTML_timesheet_content::showFlextimeReportByCompanyCriteria( $option, $lists, $userid, $period);
}

/******************************************************************************
 * 
******************************************************************************/
function showTimesheetReportByProjectCriteria( $option, $userid, $fordate, $startdate, $enddate, $isbillable, $projectid) {	
	// Make sure the top one is selected by default
	if (is_array( $projectid ) && count($projectid) == 0) {
		$projectid[] = 0;
	}

	$lists['project_id'] = HTML_timesheet::userProjectSelect( 'project_id', $projectid, 1, '', 'c.company_name, p.project_name', '- All Projects -', 1, 1, $userid);	
	$lists['is_billable'] = HTML_timesheet::isbillableradio(($isbillable==""?-1:$isbillable), 1);
	
	if ($startdate == "") {
		$arr = getStartEndDates($fordate);
		$startdate = $arr["start"];
		$enddate = $arr["end"];
	}
	HTML_timesheet_content::showTimesheetReportByProjectCriteria( $option, $lists, $userid, $startdate, $enddate);
}

/******************************************************************************
 * 
******************************************************************************/
function showTotalHoursPerProjectCriteria( $option, $userid, $fordate, $startdate, $enddate, $isbillable) {
	// Make sure the top one is selected by default

	$lists['is_billable'] = HTML_timesheet::isbillableradio(($isbillable==""?-1:$isbillable), 1);

	if ($startdate == "") {
		$arr = getStartEndDates($fordate);
		$startdate = $arr["start"];
		$enddate = $arr["end"];
	}
	HTML_timesheet_content::showTotalHoursPerProjectCriteria( $option, $lists, $userid, $startdate, $enddate);
}

/******************************************************************************
 *
******************************************************************************/
function showTotalMileageCriteria( $option, $userid, $fordate, $startdate, $enddate, $isbillable, $companyid, $vehicleid) {

	$lists['vehicle_id'] = HTML_timesheet::vehicleselect( 'vehicle_id', $vehicleid, $userid, 1, '', 'vehicle_name', '- All Vehicles -'); 
	$lists['company_id'] = HTML_timesheet::userCompanySelect( 'company_id', $companyid, 1, '', 'company_name', '- All Companies -', 1, $userid);
	$lists['is_billable'] = HTML_timesheet::isbillableradio(($isbillable==""?-1:$isbillable), 1);

	if ($startdate == "") {
		$arr = getStartEndDates($fordate);
		$startdate = $arr["start"];
		$enddate = $arr["end"];
	}
	HTML_timesheet_content::showTotalMileageCriteria( $option, $lists, $userid, $startdate, $enddate);
}

/******************************************************************************
 *
******************************************************************************/
function multiUserTotalMileageCriteria( $option, $userids, $fordate, $startdate, $enddate, $isbillable, $companyid, $userid) {

	// Make sure the top one is selected by default
	if (is_array( $userids ) && count($userids) == 0) {
		$userids[] = 0;
	}
	
	$javascript = "onchange=\"window.location.href='./index.php?option=com_timewriter&task=multiUserTotalMileageCriteria&company_id=' + document.adminForm.company_id.value + '&current_date=' + document.adminForm.current_date.value + '&end_date=' + document.adminForm.end_date.value + '&is_billable=' + getCheckboxValue(document.adminForm.is_billable);\"";
	$lists['company_id'] = HTML_timesheet::projectManagerCompanySelect( 'company_id', $companyid, 1, $javascript, 'company_name', '- All Companies -', $userid);
	$lists['user_ids'] = HTML_timesheet::userselect( 'user_id_fp', 0, 0, '', 'name', '- No User -', 1);
	$lists['is_billable'] = HTML_timesheet::isbillableradio(($isbillable==""?-1:$isbillable), 1);

	if ($startdate == "") {
		$arr = getStartEndDates($fordate);
		$startdate = $arr["start"];
		$enddate = $arr["end"];
	}
	HTML_timesheet_content::multiUserTotalMileageCriteria( $option, $lists, $userid, $startdate, $enddate);
}

/******************************************************************************
 *
******************************************************************************/
function adminShowCompanyList($option, $userid) {

  global $database, $mainframe, $mosConfig_list_limit, $mosConfig_absolute_path;

	$limit = getSessionValue('limit', $mosConfig_list_limit);
	$limitstart = getSessionValue('limitstart', 0);
  
	$pubid = getSessionValue('company_published_filter', -1);
	
  $publishedwhere="";
  if($pubid!=-1) {
  	$publishedwhere="and published=" . (int)$pubid;
  }

  $query = "SELECT count(*) FROM f9ko_oc_company WHERE 1=1 $publishedwhere "; 
  $database->setQuery( $query );
  $total = $database->loadResult();

  require_once( $mosConfig_absolute_path .'/includes/pageNavigation.php' );
  $pageNav = new mosPageNav( $total, $limitstart, $limit );

  $database->setQuery( "SELECT * FROM f9ko_oc_company WHERE 1=1 $publishedwhere ORDER BY company_name LIMIT $pageNav->limitstart, $pageNav->limit" );
  $rows = $database->loadObjectList();
  if ($database->getErrorNum()) {
    echo $database->stderr();
    return false;
  }

  $javascript = 'onchange="document.adminForm.submit();"';
  $lists['company_published_filter'] = HTML_Timesheet::publishedselect( $pubid, $javascript, 'company.published_filter');
  
  HTML_Timesheet_content::adminShowCompanyList($option, $rows , $pageNav, $lists);
}

/******************************************************************************
 *
******************************************************************************/
function adminPublishCompany( $option, $cid, $publish=1 ) {
	global $database;

	if (count( $cid ) < 1) {
		$action = $publish ? 'publish' : 'unpublish';
		echo "<script> alert('Select a company to $action'); window.history.go(-1);</script>";
		exit;
	}
	$cids = implodeIntArray($cid);
	$query = "UPDATE f9ko_oc_company SET published=$publish WHERE id IN ($cids)";
	$database->setQuery( $query );
	if (!$database->query()) {
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>";
		exit();
	}

	$labelaction = $publish ? 'Published': 'Unpublished';
	mosRedirect( "index.php?option=com_timewriter&task=adminShowCompanyList", $labelaction);
}

/******************************************************************************
 *
******************************************************************************/
function adminSaveCompany( $option ) {
	global $database;
	$row = new josOCCompany( $database );

	if (!$row->bind( $_POST )) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>";
		exit();
	}
	if (!$row->store()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>";
		exit();
	}
	mosRedirect( "index.php?option=com_timewriter&task=adminShowCompanyList", "Saved" );
}
/******************************************************************************
 *
******************************************************************************/
function adminDeleteCompany( $option, $cid ) {
	global $database;

	if (!is_array( $cid ) || count( $cid ) < 1) {
		echo "<script> alert('Select an item to delete'); window.history.go(-1);</script>";
		exit;
	}
	if (count( $cid )) {
		$cids = implodeIntArray($cid);
		$query = "SELECT count(1) FROM f9ko_oc_project WHERE company_id IN ($cids)";
		$database->setQuery( $query );
		$found = $database->loadResult();
		if ($found > 0) {
			echo "<script> alert('The selected companies have ".(int)$found." projects attached and cannot be deleted'); window.history.go(-1);</script>";
			exit;
		}
		$database->setQuery( "DELETE FROM f9ko_oc_company WHERE id IN ($cids)" );
		if (!$database->query()) {
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>";
		}
	}
	mosRedirect( "index.php?option=com_timewriter&task=adminShowCompanyList" );
}
/******************************************************************************
 *
******************************************************************************/
function adminEditCompany( $option, $uid) {
	global $database;

	$row = new josOCCompany( $database );
	if ($uid) {
		$row->load( $uid );
		if($row->general_contractor_id != null)
		{
			$row->general_contractor_name=getGeneralContractorCompany($row->general_contractor_id);
		}
	} else {
		$row->id=null;
		$row->company_name='New Company';
		$row->address=null;
		$row->general_contractor_id=null;
		$row->description=null;
		$row->telephone=null;
		$row->contact_name=null;
		$row->email=null;
		$row->website=null;
		$row->vat_reg_no=null;
		$row->company_no=null;
		$row->published=0;
	}
	
	$lists['general_contractor_id'] = HTML_Timesheet::companyselect( 'general_contractor_id', $row->general_contractor_id, 1 );
	
	HTML_timesheet_content::adminEditCompany( $option, $row, $lists );
}

/******************************************************************************
 * 
******************************************************************************/
function getGeneralContractorCompany( $uid) {
	global $database;
		
	global $database;

	$row = new josOCCompany( $database );
	if ($uid) {
		$row->load( $uid );
		return $row->company_name;
	} else {
		return "No subcontracting";
	}
}
/******************************************************************************
 *
******************************************************************************/
function adminShowProjectList($option) {
	global $database, $mainframe, $mosConfig_list_limit, $mosConfig_absolute_path;

	$limit = getSessionValue('limit', $mosConfig_list_limit);
	$limitstart = getSessionValue('limitstart', 0);

	$coid = getSessionValue('project_company_filter', 0);
	$pubid = getSessionValue('project_published_filter', -1);

	$companywhere="";
	$publishedwhere="";

	// echo $coid;
	if($coid != 0) {
		$companywhere="and pc.id=" . (int)$coid;
	}
	if($pubid != -1) {
		$publishedwhere="and p.published=" . (int)$pubid;
	}

	$query = "SELECT count(1) FROM f9ko_oc_project as p, f9ko_oc_company as pc WHERE p.company_id=pc.id $companywhere $publishedwhere" ;
	$database->setQuery( $query );
	$total = $database->loadResult();

	require_once( $mosConfig_absolute_path .'/includes/pageNavigation.php' );
	$pageNav = new mosPageNav( $total, $limitstart, $limit );

	 $query = "SELECT p.id,p.project_name,p.description,pc.company_name,p.start_date,p.end_date,p.published,calc.ttl,calc.mgrs,calc.pubs" 
						   . " FROM f9ko_oc_project AS p"
						   . " LEFT OUTER JOIN f9ko_oc_company AS pc ON p.company_id = pc.id"
						   . " LEFT OUTER JOIN (SELECT count( 1 ) ttl, sum( is_project_mgr ) mgrs, sum( published ) pubs, project_id FROM f9ko_oc_project_user GROUP BY project_id) AS calc ON ( p.id = calc.project_id )"
						   . " WHERE 1 = 1 $companywhere $publishedwhere"
						   . " ORDER BY p.start_date LIMIT $pageNav->limitstart, $pageNav->limit";

	// Updated to remove subquery
	//$query = "SELECT p.id,p.project_name,p.description,pc.company_name,p.start_date,p.end_date,p.published,count(1) ttl, sum(u.is_project_mgr) mgrs, sum(u.published) pubs" 
		//				  . " FROM f9ko_oc_project AS p"
			//			  . " LEFT OUTER JOIN f9ko_oc_company AS pc ON p.company_id = pc.id"
				//		  . " LEFT OUTER JOIN f9ko_oc_project_user AS u ON p.id = u.project_id"
					//	  . " WHERE 1 = 1 $companywhere $publishedwhere"
						//  . " GROUP BY p.id, p.project_name, p.description, pc.company_name, p.start_date, p.end_date, p.published"
						  //. " ORDER BY p.start_date LIMIT $pageNav->limitstart, $pageNav->limit";
	// echo $query;
	$database->setQuery($query);
	$rows = $database->loadObjectList();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}

	$javascript = 'onchange="document.adminForm.submit();"';

	$lists['project_company_filter'] = HTML_Timesheet::companyselect( 'project_company_filter', $coid, 1, $javascript, 'company_name', 'All');
	$lists['project_published_filter'] = HTML_Timesheet::publishedselect( $pubid, $javascript, 'project_published_filter' );

	HTML_Timesheet_content::adminShowProjectList($option, $rows , $pageNav, $lists);
}

/******************************************************************************
 *
******************************************************************************/
function adminPublishProject( $option, $cid=null, $publish=1 ) {
	global $database;

	if (count( $cid )) {
		$cids = implodeIntArray($cid);
		$query = "UPDATE f9ko_oc_project SET published=$publish WHERE id IN ($cids)";
		$database->setQuery( $query );
		if (!$database->query()) {
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>";
			exit();
		}
		$labelaction = $publish ? 'Published': 'Unpublished';
	}
	mosRedirect( "index.php?option=com_timewriter&task=adminShowProjectList", $labelaction );
}

/******************************************************************************
 *
******************************************************************************/
function adminSaveProject( $option ) {
	global $database;
	
	$row = new josOCProject( $database );
	if (!$row->bind( $_POST )) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>";
		exit();
	}
	if (!$row->store()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>";
		exit();
	}
	mosRedirect( "index.php?option=com_timewriter&act=new&task=adminShowProjectList", "Saved" );
}

/******************************************************************************
 *
******************************************************************************/
function adminDeleteProject( $option, $cid ) {
	global $database;

	if (!is_array( $cid ) || count( $cid ) < 1) {
		echo "<script> alert('Select an item to delete.'); window.history.go(-1);</script>";
		exit;
	}   
	if (count( $cid )) {
		$cids = implodeIntArray($cid);
		$query = "SELECT count(1) FROM f9ko_oc_timesheets WHERE project_id IN ($cids)";
		$database->setQuery( $query );
		$found = $database->loadResult();
		if ($found) {
			 echo "<script> alert('The selected projects have been applied to $found timesheet entries and cannot be deleted'); window.history.go(-1);</script>";
			 exit;
		}
		$query = "SELECT count(1) FROM f9ko_oc_project_user WHERE project_id IN ($cids)";
		$database->setQuery( $query );
		$found = $database->loadResult();
		if ($found) {
			 echo "<script> alert('The selected projects have $found users assigned and cannot be deleted'); window.history.go(-1);</script>";
			 exit;
		}		
		$database->setQuery( "DELETE FROM f9ko_oc_project WHERE id IN ($cids)" );
		if (!$database->query()) {
		  echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>";
		}	  
	}
	mosRedirect( "index.php?option=com_timewriter&task=adminShowProjectList" );
}

/******************************************************************************
 *
******************************************************************************/
function adminEditProject( $option, $uid ) {
	global $database;

	$row = new josOCProject( $database );
	if ($uid) {
		$row->load( $uid );	
	} else {
		$row->id=null;
		$row->project_name='New Project';
		$row->description=null;
		$row->company_id=0;
		$row->start_date=null;
		$row->end_date=null;
		$row->rate_hour=0;
		$row->hours_day=0;
		$row->published=0;  
	}
	
	$lists['company_id'] = HTML_Timesheet::companyselect( 'company_id', $row->company_id, 1 );
	HTML_Timesheet_content::adminEditProject( $option, $row, $lists );
}

/******************************************************************************
 *
******************************************************************************/
function adminShowProjectUserList($option, $projectid) {
	global $database, $mainframe, $mosConfig_list_limit, $mosConfig_absolute_path;

	$limit = getSessionValue('limit', $mosConfig_list_limit);
	$limitstart = getSessionValue('limitstart', 0);

	$project = new josOCProject( $database );
	$project->load( $projectid );	

	$from = "FROM f9ko_oc_project_user as pu,f9ko_oc_project as p,f9ko_oc_company as pc, f9ko_users as u"
			. " WHERE pc.id=p.company_id and pu.user_id=u.id and pu.project_id=p.id and pu.project_id=" . (int)$projectid;
	$query = "SELECT count(1) " . $from;
	 
	$database->setQuery( $query );
	$total = $database->loadResult();
	require_once( $mosConfig_absolute_path .'/includes/pageNavigation.php' );
	$pageNav = new mosPageNav( $total, $limitstart, $limit );

	$database->setQuery( "SELECT pu.id,pu.is_project_mgr,u.username,u.name,p.project_name,pc.company_name,pu.published " 
							. $from 
							. " ORDER BY u.username LIMIT ".$pageNav->limitstart.", ".$pageNav->limit );
	$rows = $database->loadObjectList();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}

	// Get all Joomla users that are Allowed into the Timesheets system  but not already assigned to this Project.
	// $database->setQuery("SELECT u.* FROM f9ko_users as u, f9ko_oc_user_prefs as pup"
						// . " WHERE u.id = pup.user_id AND pup.is_timesheet_user=1" 
						// . " AND u.id NOT IN (SELECT pu.user_id FROM f9ko_oc_project_user as pu" 
						// . " WHERE pu.project_id=".(int)$projectid.") ORDER BY u.username");
	// Updated to remove subquery
	$database->setQuery("SELECT u.* FROM f9ko_users as u"
						. " LEFT OUTER JOIN f9ko_oc_user_prefs as pup ON u.id = pup.user_id" 
						. " LEFT OUTER JOIN f9ko_oc_project_user as pu ON (u.id = pu.user_id AND pu.project_id=".(int)$projectid.")" 
						. " WHERE pup.is_timesheet_user=1" 
						. " AND pu.project_id is null" 
						. " ORDER BY u.username");
					
	$users = $database->loadObjectList();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}

	HTML_Timesheet_content::adminShowProjectUserList( $option, $rows , $pageNav, $project, $users);
}

/******************************************************************************
 *
******************************************************************************/
function adminAddProjectUsers($option, $userids, $projectid) {
	global $database;
	
	if (count( $userids )) {
		$ids = implodeIntArray($userids);
		// $query = "INSERT INTO f9ko_oc_project_user(user_id, project_id, published)"
			// . " SELECT user_id, ".(int)$projectid.", 1 FROM f9ko_oc_user_prefs WHERE user_id IN ($ids)"
			// . " AND user_id NOT IN (SELECT user_id from f9ko_oc_project_user where project_id=".(int)$projectid.")";

		// Removed the subquery
		$query = "INSERT INTO f9ko_oc_project_user(user_id, project_id, published)"
			. " SELECT up.user_id, ".(int)$projectid.", 1 FROM f9ko_oc_user_prefs up"
			. " LEFT OUTER JOIN f9ko_oc_project_user pu ON (pu.user_id = up.user_id AND pu.project_id =".(int)$projectid.")"
			. " WHERE up.user_id IN ($ids)"
			. " AND pu.user_id IS NULL";
			
		$database->setQuery($query);
		if (!$database->query()) {
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
			exit();
		}	
	}	
	mosRedirect( "index.php?option=com_timewriter&task=adminShowProjectUserList&uid=$projectid", "Added Project Users" );
}

/******************************************************************************
 *
******************************************************************************/
function adminDeleteProjectUser( $option, $cid, $projectid) {
	global $database;

	if (count( $cid )) {
		$cids = implodeIntArray($cid);
		// Look for Timesheet entries associated with this Project / User record.
		$query = "SELECT count(1) FROM f9ko_oc_timesheets t, f9ko_oc_project_user u"
				. " WHERE u.project_id=t.project_id AND u.user_id=t.user_id AND u.id IN ($cids)";

		$database->setQuery( $query );
		$found = $database->loadResult();
		if ($found) {
			echo "<script> alert('The selected user(s) have $found entries against this project and cannot be deleted'); window.history.go(-1);</script>";
			exit;
		}		
		$query = "DELETE FROM f9ko_oc_project_user WHERE id IN ($cids)";
		$database->setQuery($query);
		if (!$database->query()) {
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>";
		}
	}
	mosRedirect( "index.php?option=com_timewriter&task=adminShowProjectUserList&uid=$projectid&limitstart=0", "Deleted Project Users");
}

/******************************************************************************
 *
******************************************************************************/
function adminToggleProjectUserIsManager( $option, $cid, $projectid, $promote=1 ) {
	global $database;
	
	if (count( $cid )) {
		$cids = implodeIntArray($cid);
		$query = "UPDATE f9ko_oc_project_user SET is_project_mgr=".(int)$promote." WHERE id IN ($cids)";

		$database->setQuery( $query );
		if (!$database->query()) {
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>";
			exit();
		}
		$labelaction = $promote ? 'Promoted': 'Demoted';
	}
	mosRedirect( "index.php?option=com_timewriter&task=adminShowProjectUserList&uid=$projectid", $labelaction);
}

/******************************************************************************
 *
******************************************************************************/
function adminToggleProjectUserIsPublished( $option, $cid, $projectid, $promote=1 ) {
	global $database;
	
	if (count( $cid )) {
		$cids = implodeIntArray($cid);
		$query = "UPDATE f9ko_oc_project_user SET published=".(int)$promote." WHERE id IN ($cids)";

		$database->setQuery( $query );
		if (!$database->query()) {
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>";
			exit();
		}
		$labelaction = $promote ? 'Published': 'Unpublished';
	}
	mosRedirect( "index.php?option=com_timewriter&task=adminShowProjectUserList&uid=$projectid", $labelaction);
}

?>