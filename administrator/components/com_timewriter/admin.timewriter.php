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

require_once dirname(__FILE__) . '/admin.timewriter.html.php';
require_once dirname(__FILE__) . '/class.timewriter.php';
require_once( $mainframe->getPath( 'admin_html' ) );

$id = mosGetParam( $_REQUEST, 'id', '' );

switch ($task) {
  case "showUserPreferencesList":
    showUserPreferencesList();
    break;
  case "importFromMambotastic":
    importFromMambotastic();
    break;
  case "promoteTimesheetAdmin":
    toggleTimesheetAdmin(is_array($id)?$id[0]:$id, $id, 1);
    break;	
  case "demoteTimesheetAdmin":
    toggleTimesheetAdmin(is_array($id)?$id[0]:$id, $id, 0);
    break;	
  case "promoteTimesheetUser":
    toggleTimesheetUser(is_array($id)?$id[0]:$id, $id, 1);
    break;	
  case "demoteTimesheetUser":
    toggleTimesheetUser(is_array($id)?$id[0]:$id, $id, 0);
    break;	
  case "mainDisplay":
  case "":
    mainDisplay();
    break;
}

/******************************************************************************
 *
******************************************************************************/
function showUserPreferencesList() {
  global $database, $mainframe, $mosConfig_list_limit, $mosConfig_absolute_path;

    // Insert all users into the preferences table with defaults from the table definition.
	// Fails on MySql 4.0.x
	// $query = "INSERT INTO f9ko_oc_user_prefs(user_id)"
	// 		." SELECT id FROM f9ko_users WHERE id NOT IN (SELECT user_id FROM f9ko_oc_user_prefs)";			
	$query = "INSERT INTO f9ko_oc_user_prefs(user_id)"
			. " SELECT DISTINCT u.id FROM f9ko_users u LEFT JOIN f9ko_oc_user_prefs up ON u.id = up.user_id"
			. " WHERE up.user_id IS NULL";
	$database->setQuery($query);
	if (!$database->query()) {
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		exit();
	}		
	
  // Do the query for the UI
  $limit = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $mosConfig_list_limit );
  $limitstart = $mainframe->getUserStateFromRequest( "viewsectionlimitstart", 'limitstart', 0 );


  $query = "SELECT count(1) FROM f9ko_oc_user_prefs p, f9ko_users u"
                        . " WHERE p.user_id = u.id";
  $database->setQuery( $query );
  $total = $database->loadResult();
  require_once( $mosConfig_absolute_path .'/administrator/includes/pageNavigation.php' );
  $pageNav = new mosPageNav( $total, $limitstart, $limit );

  $database->setQuery( "SELECT p.id, p.user_id, p.is_timesheet_admin, p.is_timesheet_user, u.name, u.username, u.email"
                        . " FROM f9ko_oc_user_prefs p, f9ko_users u"
                        . " WHERE p.user_id = u.id"
                        . " ORDER BY u.username LIMIT $pageNav->limitstart, $pageNav->limit" );
					
  $rows = $database->loadObjectList();
  if ($database->getErrorNum()) {
    echo $database->stderr();
    return false;
  }

  HTML_Timesheet::showUserPreferencesList($rows , $pageNav);
}

/******************************************************************************
 *
******************************************************************************/
function toggleTimesheetAdmin( $userid=null, $cid=null, $promote=1 ) {
	global $database;

	if (!is_array( $cid )) {
		$cid = array();
	}
	if ($userid) {
		$cid[] = $userid;
	}
	if (count( $cid ) < 1) {
		$action = $promote ? 'promote' : 'demote';
		echo "<script> alert('Select a user to $action'); window.history.go(-1);</script>";
		exit;
	}
	$cids = implode( ',', $cid );
	$query = "UPDATE f9ko_oc_user_prefs SET is_timesheet_admin=$promote WHERE user_id IN ($cids)";

	$database->setQuery( $query );
	if (!$database->query()) {
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>";
		exit();
	}
	$labelaction = $promote ? 'Promoted': 'Demoted';
	mosRedirect( "index2.php?option=com_timewriter&task=showUserPreferencesList", $labelaction );
}

/******************************************************************************
 *
******************************************************************************/
function toggleTimesheetUser( $userid=null, $cid=null, $promote=1 ) {
	global $database;

	if (!is_array( $cid )) {
		$cid = array();
	}
	if ($userid) {
		$cid[] = $userid;
	}
	if (count( $cid ) < 1) {
		$action = $promote ? 'allow' : 'deny';
		echo "<script> alert('Select a user to $action access to Timesheets'); window.history.go(-1);</script>";
		exit;
	}
	$cids = implode( ',', $cid );
	$query = "UPDATE f9ko_oc_user_prefs SET is_timesheet_user=$promote WHERE user_id IN ($cids)";
	$database->setQuery( $query );
	if (!$database->query()) {
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>";
		exit();
	}
	$labelaction = $promote ? 'Allowed': 'Denied';
	mosRedirect( "index2.php?option=com_timewriter&task=showUserPreferencesList", "$labelaction" );
}



/******************************************************************************
 * 
******************************************************************************/
function showMambotasticImport() {
	global $database;

	// Check that our tables are empty.
	$query = "SELECT count( 1 ) AS ttl FROM f9ko_oc_company";
	$database->setQuery( $query );
	$total = $database->loadResult();
	if ($database->getErrorNum() || $total) {
		return false;
	}

	$query = "SELECT count( 1 ) AS ttl FROM f9ko_oc_project";
	$database->setQuery( $query );
	$total = $database->loadResult();
	if ($database->getErrorNum() || $total) {
		return false;
	}
	
	$query = "SELECT count( 1 ) AS ttl FROM f9ko_oc_project_user";
	$database->setQuery( $query );
	$total = $database->loadResult();
	if ($database->getErrorNum() || $total) {
		return false;
	}
	
	$query = "SELECT count( 1 ) AS ttl FROM f9ko_oc_timesheets";
	$database->setQuery( $query );
	$total = $database->loadResult();
	if ($database->getErrorNum() || $total) {
		return false;
	}
	
	// Simply to verify that required tables exist.
	$query = "SELECT 1 FROM f9ko_project WHERE 0"
			. " union SELECT 1 FROM f9ko_project_company WHERE 0"
			. " union SELECT 1 FROM f9ko_project_timesheets WHERE 0"
			. " union SELECT 1 FROM f9ko_project_user WHERE 0";

	$database->setQuery( $query );
	$dummy = $database->loadObjectList();
	if ($database->getErrorNum()) {
		return false;
	}	
	return true;
}

/******************************************************************************
 * 
******************************************************************************/
function importFromMambotastic() {
	global $database;
		
	$allowImport = showMambotasticImport();
	
	if (!$allowImport) {
		echo "ObjectClarity TimeWriter tables must be empty to allow importing.";
	} else {
		$query = "INSERT INTO f9ko_oc_company( id, company_name,general_contractor_id, description, telephone, contact_name, email, website, vat_reg_no, company_no, published )"
				. " SELECT id, company_name,general_contractor_id, description, telephone, contact_name, email, website, vat_reg_no, company_no, published FROM f9ko_project_company";
		$database->setQuery($query);
		if (!$database->query()) {
			echo "<script> alert('Importing Companies:".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
			exit();
		} else {
			echo "Imported Companies <br />";
			
			$query = "INSERT INTO f9ko_oc_project (id,global_project_id, project_name, description, company_id, start_date, end_date, published)"
					. " SELECT id, global_project_id, project_name, description, company_id, start_date, end_date, published FROM f9ko_project";
			$database->setQuery($query);
			if (!$database->query()) {
				echo "<script> alert('Importing Projects:".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
				exit();
			} else {
				echo "Imported Projects <br />";
			
				$query = "INSERT INTO f9ko_oc_project_user (id, user_id, project_id, is_project_mgr, published)"
						. " SELECT id, user_id, project_id, 0, published FROM f9ko_project_user";
				$database->setQuery($query);
				if (!$database->query()) {
					echo "<script> alert('Importing Project Users:".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
					exit();
				} else {
					echo "Imported Project Users <br />";
				
					$query = "INSERT INTO f9ko_oc_timesheets (id, user_id, date, total_hours, project_id, description, published)"
							. " SELECT id, user_id, date, total_hours, project_id, description, published FROM f9ko_project_timesheets";
					$database->setQuery($query);
					if (!$database->query()) {
						echo "<script> alert('Importing Timesheet Entries:".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
						exit();
					} else {
						echo "Imported Timesheets <br />";
					}
				}
			}
		}
	}
	// Show the menu
	mainDisplay();
}
 	
/******************************************************************************
 *
******************************************************************************/
function mainDisplay() {

	$showImport = showMambotasticImport();
	HTML_Timesheet::mainmenu($showImport);
}

// *****************************
