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


class josOCProject extends mosDBTable {

	var $id=null;
	var $user_id=null;
	var $userid=null;
	var $project_name=null;
	var $description=null;
	var $company_id=null;
	var $start_date=null;
	var $end_date=null;
	var $published=null;

	function josOCProject( &$db ) {
		$this->mosDBTable( 'f9ko_oc_project', 'id', $db );
	}
}

class josOCCompany extends mosDBTable {

	var $id=null;
	var $user_id=null;
	var $company_name=null;
	var $address=null;
	var $general_contractor_id=null;
	var $general_contractor_name=null;
	var $description=null;
	var $telephone=null;
	var $contact_name=null;
	var $email=null;
	var $website=null;
	var $vat_reg_no=null;
	var $company_no=null;
	var $published=null;

	function josOCCompany( &$db ) {
		$this->mosDBTable( 'f9ko_oc_company', 'id', $db );
	}
}

class josOCProjectUser extends mosDBTable {

	var $id=null;
	var $user_id=null;
	var $project_id=null;
	var $company_id=null;
	var $published=null;
	var $is_project_mgr=null;

	function josOCProjectUser( &$db ) {
		$this->mosDBTable( 'f9ko_oc_project_user', 'id', $db );
	}
}

class josOCUserPrefs extends mosDBTable {

	var $id=null;
	var $user_id=null;
	var $is_timesheet_admin=null;  
	var $is_timesheet_user=null;  
	var $project_id=null;
	var $vehicle_id=null;
	var $is_billable=null;
	var $hours_day=null;
	var $rate_hour=null;
	var $tax_rate=null;
	var $mileage_rate=null;
	var $mileage_is_billable=null;
	var $start_location=null;
	var $end_location=null;
	var $parking=null;

	function josOCUserPrefs( &$db ) {
		$this->mosDBTable( 'f9ko_oc_user_prefs', 'id', $db );
	}
}

class josOCUserVehicles extends mosDBTable {

	var $id=null;
	var $user_id=null;
	var $vehicle_name=null;
	var $description=null;
	var $units=null;
	var $published=null;

	function josOCUserVehicles( &$db ) {
		$this->mosDBTable( 'f9ko_oc_user_vehicles', 'id', $db );
	}
}

class josOCUserMileage extends mosDBTable {

	var $id=null;
	var $user_id=null;
	var $vehicle_id=null;
	var $start_location=null;
	var $end_location=null;
	var $start_odometer=null;
	var $end_odometer=null;
	var $date=null;
	var $parking=null;
	var $company_id=null;
	var $is_billable=null;
	var $notes=null;

	function josOCUserMileage( &$db ) {
		$this->mosDBTable( 'f9ko_oc_user_mileage', 'id', $db );
	}
}

class josOCTimesheets extends mosDBTable {

	var $id=null;
	var $user_id=null;
	var $description=null;
	var $project_id=null;
	var $published=null;
	var $total_hours=null;
	var $date=null;
	var $is_billable=null;
	var $at_customer=null;

	function josOCTimesheets( &$db ) {
		$this->mosDBTable( 'f9ko_oc_timesheets', 'id', $db );
	}
}
