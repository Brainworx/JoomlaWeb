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

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

global $mosConfig_live_site;

class HTML_Timesheet {


/*****************************************************************************
 *  
*****************************************************************************/
function version() {
	// Version number is also specified in the xml file and the CHANGELOG.
	echo "v1.0.5 stable";	
}

/*****************************************************************************
 *  
*****************************************************************************/
function copyrightFooter() {
?>
	<div style="text-align:center;">
		<br /><br />BrainWorX TimeWriter  &copy; 2010, All Rights Reserved
		<br />
		<?php echo HTML_Timesheet::version(); ?>
	</div>
<?php
}

/******************************************************************************
 * 
******************************************************************************/
function printAdminHeading($left, $right) {
?>
<table class="adminheading" border="0" >
	<tr>
		<th class="edit">
		<?php echo $left; ?>: <small><?php echo $right; ?></small>
		</th>
	</tr>
</table>
<?php
}

/******************************************************************************
 *   Get a list of Companies
******************************************************************************/
function companyselect( $companyname, $active, $nocompany=0, $javascript=NULL, $order='company_name', $blank='- No Company -', $limitpublished='0') {
	global $database;

	$published = ($limitpublished?"WHERE published = '1'":"");
		
	$query = "SELECT id AS value, CONCAT(company_name, CASE (published) WHEN 1 THEN '' ELSE ' (Unpublished)' END) AS text" 
			. " FROM f9ko_oc_company"
			. " $published"
			. " ORDER BY ". $order;
//echo $query;
	$database->setQuery( $query );
	if ( $nocompany ) {
		$companies[] = mosHTML::makeOption( '0', $blank );
		$companies = array_merge( $companies, $database->loadObjectList() );
	} else {
		$companies = $database->loadObjectList();
	}
	$companies = mosHTML::selectList( $companies, $companyname, 'class="inputbox" size="1" '. $javascript, 'value', 'text', $active );
	return $companies;
}
/******************************************************************************
 *  Get a Select list of all the companies that a user can timewrite against.
******************************************************************************/
function userCompanySelect( $companyname, $active, $nocompany=0, $javascript=NULL, $order='company_name', $blank='- No Company -', $limitpublished='0', $userid) {
	global $database;

	$published = ($limitpublished?" AND c.published = '1' AND p.published = '1' AND u.published = '1'":"");
		
	$query = "SELECT DISTINCT c.id AS value, CONCAT(c.company_name, CASE (c.published + p.published + u.published) WHEN 3 THEN '' ELSE ' (Unpublished)' END) AS text" 
			. " FROM #__oc_company c, #__oc_project p, #__oc_project_user u"
			. " WHERE c.id = p.company_id AND p.id = u.project_id AND u.user_id = " . (int)$userid
			. $published
			. " ORDER BY ". $order;
			
	$database->setQuery( $query );
	if ( $nocompany ) {
		$companies[] = mosHTML::makeOption( '0', $blank );
		$companies = array_merge( $companies, $database->loadObjectList() );
	} else {
		$companies = $database->loadObjectList();
	}
	$companies = mosHTML::selectList( $companies, $companyname, 'class="inputbox" size="1" '. $javascript, 'value', 'text', $active );
	return $companies;
}
/******************************************************************************
 *  Get a Select list of all the Companies that the user has written time against. -- forever?  Yup.
******************************************************************************/
function userCompanySelect2( $companyname, $active, $nocompany=0, $javascript=NULL, $order='company_name', $blank='- No Company -', $userid) {
	global $database;

	$query = "SELECT DISTINCT c.id AS value, c.company_name AS text" 
			. " FROM f9ko_oc_company c, f9ko_oc_project p, f9ko_oc_timesheets AS t, f9ko_oc_project_user u"
			. " WHERE c.id = p.company_id AND p.id = t.project_id AND p.id = u.project_id"
			. " AND t.user_id = u.user_id AND t.user_id = " . (int)$userid
			. " ORDER BY ". $order;
			
	$database->setQuery( $query );
	if ( $nocompany ) {
		$companies[] = mosHTML::makeOption( '0', $blank );
		$companies = array_merge( $companies, $database->loadObjectList() );
	} else {
		$companies = $database->loadObjectList();
	}
	$companies = mosHTML::selectList( $companies, $companyname, 'class="inputbox" size="1" '. $javascript, 'value', 'text', $active );
	return $companies;
}

/******************************************************************************
 *  Get a Select list of all the Companies where the user is PM on that Company's Projects.
******************************************************************************/
function projectManagerCompanySelect( $companyname, $active, $nocompany=0, $javascript=NULL, $order='company_name', $blank='- No Company -', $userid) {
	global $database;

	$query = "SELECT DISTINCT c.id AS value, c.company_name AS text" 
			. " FROM f9ko_oc_company c, f9ko_oc_project p, f9ko_oc_project_user u"
			. " WHERE c.id = p.company_id AND p.id = u.project_id"
			. " AND u.is_project_mgr = 1 AND u.user_id = " . (int)$userid
			. " ORDER BY ". $order;
			
	$database->setQuery( $query );
	if ( $nocompany ) {
		$companies[] = mosHTML::makeOption( '0', $blank );
		$companies = array_merge( $companies, $database->loadObjectList() );
	} else {
		$companies = $database->loadObjectList();
	}
	$companies = mosHTML::selectList( $companies, $companyname, 'class="inputbox" size="1" '. $javascript, 'value', 'text', $active );
	return $companies;
}

/******************************************************************************
 * 
******************************************************************************/
function vehicleselect( $vehiclename, $active, $userid, $novehicle=0, $javascript=NULL, $order='vehicle_name', $blank='- No Vehicle -',  $published=1) {
	global $database;

	$pubWhere = ($published?" AND published=1":"");

	$query = "SELECT id AS value, vehicle_name text"
		   . " FROM f9ko_oc_user_vehicles"
		   . " WHERE user_id=" . (int)$userid
		   . $pubWhere
		   . " ORDER BY ". $order;
	$database->setQuery( $query );
	if ( $novehicle ) {
		$vehicles[] = mosHTML::makeOption( '0', $blank );
		$vehicles = array_merge( $vehicles, $database->loadObjectList() );
	} else {
		$vehicles = $database->loadObjectList();
	}
	$users = mosHTML::selectList( $vehicles, $vehiclename, 'class="inputbox" size="1" '. $javascript, 'value', 'text', $active );
	return $users;
}


/******************************************************************************
 * 
******************************************************************************/
function publishedselect ($active, $javascript=NULL, $fieldname='active'){
	return "<select name='".$fieldname."' class='inputbox' size='1' $javascript>"
		."<option value='-1' ".($active==-1?"selected":"").">All</option>"
		."<option value='1' ".($active==1?"selected":"").">Yes</option>"
		."<option value='0' ".($active==0?"selected":"").">No</option>"
		."</select>";
}

/******************************************************************************
 * 
******************************************************************************/
function isbillableradio ($billable, $noselection=0, $blank='All'){
    return ($noselection?"<input type='radio' name='is_billable' value='-1' ".($billable==-1?"checked":"")."/>$blank":"")
	   ."<input type='radio' name='is_billable' value='1' ".($billable==1?"checked":"")."/>Yes" 
	   ."<input type='radio' name='is_billable' value='0' ".($billable==0?"checked":"")."/>No";
}

/******************************************************************************
 * 
******************************************************************************/
function vehicleunitsradio ($units){
    return "<input type='radio' name='units' value='Kms' ".($units=="Kms"?"checked":"")."/>Kms" 
	   ."<input type='radio' name='units' value='Miles' ".($units=="Miles"?"checked":"")."/>Miles";
}


/******************************************************************************
 *  Get an optionally Multi-Select List of all registered Joomla users.
******************************************************************************/
function userselect( $name, $active, $nouser=0, $javascript=NULL, $order='name', $blank='- No User -') {
	global $database;

		
	$query = "SELECT id AS value, name AS text" 
			. " FROM f9ko_users"
			. " ORDER BY ". $order;
	$database->setQuery( $query );
	if ( $nouser ) {
		$users[] = mosHTML::makeOption( '0', $blank );
		$users = array_merge( $users, $database->loadObjectList() );
	} else {
		$users = $database->loadObjectList();
	}
	$users = mosHTML::selectList( $users, $name, 'class="inputbox" size="1" '. $javascript, 'value', 'text', $active );
	return $users;
}

/******************************************************************************
 *  Get a Select List of users that are attached to projects of a given Company.
******************************************************************************/
function userSelectByCompany( $username, $active, $nouser=0, $javascript=NULL, $order='name', $blank='- No User -', $size='1', $company_id) {
	global $database;

	$query = "SELECT count(DISTINCT u.id )"
			. " FROM f9ko_oc_company c, f9ko_oc_project p, f9ko_oc_project_user pu, f9ko__users u"
			. " WHERE c.id = " . (int)$company_id
			. " AND c.id = p.company_id"
			. " AND p.id = pu.project_id" 
			. " AND pu.user_id = u.id";
	$database->setQuery( $query );
	$nr = $database->loadResult();
	
	$query = "SELECT DISTINCT u.id AS value, CONCAT(u.name, ' (', u.username, ')') AS text"
			. " FROM f9ko_oc_company c, f9ko_oc_project p, f9ko_oc_project_user pu, f9ko__users u"
			. " WHERE c.id = " . (int)$company_id
			. " AND c.id = p.company_id"
			. " AND p.id = pu.project_id" 
			. " AND pu.user_id = u.id"
			. " ORDER BY ". $order;
	$database->setQuery( $query );
	// echo $query;
	if($nr > 1){
		if ( $nouser ) {
			$users[] = mosHTML::makeOption( '0', $blank );
			$users = array_merge( $users, $database->loadObjectList() );
		} else {
			$users = $database->loadObjectList();
		}
	}else{
		if ( $nouser ) {
			$users[] = mosHTML::makeOption( '0', $blank );
			$database->loadObject($users[1]);
		} else {
			$database->loadObject($users[count($users-1)]);
		}
	}
	$multi = "";
	if ($size > 1) {
		$multi = "multiple='true'";
	}
	// Need to build some weird array for multiple selected items	
	$sel = array();
	if (is_array( $active )) {
		foreach ($active as $obj) {
			$sel[]->value = $obj;
		}
	} else {
		$sel = $active;
	}
	
	$users = mosHTML::selectList( $users, $username, 'class="inputbox" '.$multi.' size="'.$size.'" '. $javascript, 'value', 'text', $sel );
	return $users;
}

/******************************************************************************
 * 
******************************************************************************/
function projectselect( $projectname, $active, $noproject=0, $javascript=NULL, $order='c.company_name, p.project_name', $blank='- No Project -', $limitpublished='0', $size='1') {
	global $database;

	$published = ($limitpublished?"WHERE p.published = '1' AND  c.published = '1'":"");

	$query = "SELECT p.id AS value, CONCAT(c.company_name, ' &raquo; ', p.project_name, (CASE(p.published + c.published) WHEN 2 THEN '' ELSE ' (Unpublished)' END)) AS text"
		   	. " FROM f9ko_oc_project as p join f9ko_oc_company as c on p.company_id = c.id"
			. " $published"
			. " ORDER BY ". $order;
// echo $query;
	$database->setQuery( $query );
	if ( $noproject ) {
		$projects[] = mosHTML::makeOption( '0', $blank );
		$projects = array_merge( $projects, $database->loadObjectList() );
	} else {
		$projects = $database->loadObjectList();
	}
	$multi = "";
	if ($size > 1) {
		$multi = "multiple='true'";
	}
	// Need to build some weird array for selected items	
	$sel = array();
	if (is_array( $active )) {
		foreach ($active as $obj) {
			$sel[]->value = $obj;
		}
	} else {
		$sel = $active;
	}

	$projects = mosHTML::selectList( $projects, $projectname, 'class="inputbox" '.$multi.' size="'.$size.'" '. $javascript, 'value', 'text', $sel );
	return $projects;
}

/******************************************************************************
 * 
******************************************************************************/
function projectManagerProjectselect( $projectname, $active, $noproject=0, $javascript=NULL, $order='c.company_name, p.project_name', $blank='- No Project -', $limitpublished='0', $size='1', $userid) {
	global $database;

	$published = ($limitpublished?" AND p.published = '1' AND c.published = '1'":"");

	$query = "SELECT p.id AS value, CONCAT(c.company_name, ' &raquo; ', p.project_name, (CASE(p.published + c.published) WHEN 2 THEN '' ELSE ' (Unpublished)' END)) AS text"
			. " FROM f9ko_oc_project as p"
			. " left join f9ko_oc_company as c on p.company_id = c.id"
			. " left join f9ko_oc_project_user as u on p.id = u.project_id"
		   	. " WHERE u.is_project_mgr = 1 AND u.user_id = " . (int)$userid
			. $published
			. " ORDER BY ". $order;
			
	// echo $query;
	$database->setQuery( $query );
	if ( $noproject ) {
		$projects[] = mosHTML::makeOption( '0', $blank );
		$projects = array_merge( $projects, $database->loadObjectList() );
	} else {
		$projects = $database->loadObjectList();
	}
	$multi = "";
	if ($size > 1) {
		$multi = "multiple='true'";
	}
	// Need to build some weird array for selected items	
	$sel = array();
	if (is_array( $active )) {
		foreach ($active as $obj) {
			$sel[]->value = $obj;
		}
	} else {
		$sel = $active;
	}

	$projects = mosHTML::selectList( $projects, $projectname, 'class="inputbox" '.$multi.' size="'.$size.'" '. $javascript, 'value', 'text', $sel );
	return $projects;
}

/******************************************************************************
  *  User is both a Timesheet component user and is assigned to a published Company and Project.
*****************************************************************************/
function userCanEnterTime($userid) {
	global $database;

	$query = "SELECT count(*)"
			. " FROM f9ko_oc_project AS p, f9ko_oc_company AS c, f9ko_oc_project_user AS u, f9ko_oc_user_prefs AS up"
			. " WHERE p.company_id = c.id"
			. " AND p.id = u.project_id"
			. " AND p.published=1"
			. " AND c.published=1"
			. " AND u.user_id=up.user_id"
			. " AND up.is_timesheet_user=1"
			. " AND u.published=1"
			. " AND u.user_id=" . (int)$userid;

	$database->setQuery( $query );
	$total = $database->loadResult();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}	
	return $total;
}


/******************************************************************************
 *  TODO test error checking!!!
******************************************************************************/
function userIsProjectManager($userid) {
	global $database;

	// User is still a Project Manager if his/her Projects are unpublished.
	$query = "SELECT count(*)"
			. " FROM f9ko_oc_project AS p, f9ko_oc_company AS c, f9ko_oc_project_user AS u"
			. " WHERE p.company_id = c.id"
			. " AND p.id = u.project_id"
			. " AND u.is_project_mgr=1"
			. " AND u.user_id=" . (int)$userid;
	
	$database->setQuery( $query );
	$total = $database->loadResult();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}
	
	return ($total > 0);
}

/******************************************************************************
 *  
******************************************************************************/
function userIsTimesheetAdmin($userid) {
	global $database;

	$query = "SELECT is_timesheet_admin FROM f9ko_oc_user_prefs WHERE user_id = " . (int)$userid;
	$database->setQuery( $query );
	$admin = $database->loadResult();
	if ($database->getErrorNum()) {
		echo $database->stderr();
		return false;
	}	
	return $admin;
}

/******************************************************************************
 * Projects assigned to a user
******************************************************************************/
function userProjectSelect( $projectname, $active, $noproject=0, $javascript=NULL, $order='c.company_name, p.project_name', $blank='- No Project -', $limitpublished='0', $size='1', $userid='0') {
	global $database;

	// Option to include only published Companies, Projects and Users that are granted access tp the timesheet.
	$published = ($limitpublished?" AND p.published = '1' AND  c.published = '1' AND  u.published = '1'":"");

	$query = "SELECT p.id AS value, CONCAT(c.company_name, ' &raquo; ', p.project_name, (CASE(p.published + c.published + u.published) WHEN 3 THEN '' ELSE ' (Unpublished)' END)) AS text"
		   	. " FROM f9ko_oc_project as p, f9ko_oc_company as c, f9ko_oc_project_user as u"
			. " WHERE p.company_id = c.id AND p.id = u.project_id AND u.user_id = " . (int)$userid
			. $published
			. " ORDER BY " . $order;
	// echo $query;
	$database->setQuery( $query );
	if ( $noproject ) {
		$projects[] = mosHTML::makeOption( '0', $blank );
		$projects = array_merge( $projects, $database->loadObjectList() );
	} else {
		$projects = $database->loadObjectList();
	}
	$multi = "";
	if ($size > 1) {
		$multi = "multiple='true'";
	}
	// Need to build some weird array for selected items
	$sel = array();
	if (is_array( $active )) {
		foreach ($active as $obj) {
			$sel[]->value = $obj;
		}
	} else {
		$sel = $active;
	}

	$projects = mosHTML::selectList( $projects, $projectname, 'class="inputbox" '.$multi.' size="'.$size.'" '. $javascript, 'value', 'text', $sel );
	return $projects;
}


/******************************************************************************
 * 
******************************************************************************/
function showUserPreferencesList($rows , $pageNav) {
	global $mosConfig_live_site;

	mosCommonHTML::loadOverlib();
	HTML_Timesheet::printAdminHeading("Users", "Timesheet Admin");
?>	


  <script language="javascript" type="text/javascript">

  function submitbutton(pressbutton) {
    var form = document.adminForm;
    if (pressbutton == "cancel") {
      submitform( pressbutton );
      return;
    }
    submitform( pressbutton );
  }
  </script>
  <form action="index2.php" method="post" name="adminForm">

  <table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
   <tr>
    <th width="20"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($rows); ?>);" /></th>
    <th class="title" width="20%">Username</th>
    <th class="title" width="60%">User Name</th>
    <th class="title" width="10%" style="text-align:center;">Timesheet User</th>
    <th class="title" width="10%" style="text-align:center;">Timesheet Admin</th>
   </tr>
  <?php
    $k = 0;
    for($i=0; $i < count( $rows ); $i++) {
    $row = $rows[$i];
   ?>
    <tr class="<?php echo "row$k"; ?>">
     <td><input type="checkbox" id="cb<?php echo $i;?>" name="id[]" value="<?php echo $row->user_id; ?>" onclick="isChecked(this.checked);" /></td>
     <td><?php echo $row->username; ?></td>
     <td><?php echo $row->name; ?></td>
     <td align="center">
      <?php
       if ($row->is_timesheet_user) {
         echo '<a href="./index2.php?option=com_timewriter&task=demoteTimesheetUser&id='.$row->user_id.'" ><img src="images/publish_g.png" border="0" />';
       } else {
         echo '<a href="./index2.php?option=com_timewriter&task=promoteTimesheetUser&id='.$row->user_id.'" ><img src="images/publish_x.png" border="0" />';
       }
      ?>
     </td>
     <td align="center">
      <?php
       if ($row->is_timesheet_admin == "1") {
         echo '<a href="./index2.php?option=com_timewriter&task=demoteTimesheetAdmin&id='.$row->user_id.'" ><img src="images/publish_g.png" border="0" />';
       } else {
         echo '<a href="./index2.php?option=com_timewriter&task=promoteTimesheetAdmin&id='.$row->user_id.'" ><img src="images/publish_x.png" border="0" />';
       }
      ?>
     </td>
     <?php $k = 1 - $k; ?>
    </tr>
  <?php } ?>
  </table>
  <?php echo $pageNav->getListFooter();?>
  <input type="hidden" name="option" value="com_timewriter" />
  <input type="hidden" name="task" value="showUserPreferencesList" />
  <input type="hidden" name="boxchecked" value="0" />
  </form>
<?php 
}

/******************************************************************************
 * 
******************************************************************************/
function mainmenu($showImport){
?>
<style>

table.aboutComponent {
	background-color: #ffffff;
	border: solid 1px #d5d5d5;
	padding: 10px;
	border-collapse: collapse;
}
table.functions {
	background-color: #ffffff;
	border: 1px solid #d5d5d5;
	padding: 5px;
}
table.functions td {
	padding-left: 30px;
	padding-right: 30px;
	text-align: center;
	height:60px;
	width:60px;
	border: 1px;
	border-style:outset;
	border-color:#EFEFEF;
}
table.functions td:hover {
	background-color: #B5CDE8;
	border:	1px solid #30559C;
}
</style>
<table width="100%" >
  <tr>
    <td style="vertical-align:middle;">
<?php 
	HTML_Timesheet::printAdminHeading("Admin", "Timesheet Control Panel");
	
?>	
		<table align="center" style="width:80%;height:400px;">
		   <tr>
		      <td style="vertical-align:top;">				  
		         <table align="center" class="functions">
			        <tr>
					<td>
						<a href="index2.php?option=com_timewriter&task=showUserPreferencesList&limitstart=0" style="text-decoration:none;" title="Grant User Access">
						<img src="./images/addusers.png" width="48px" height="48px" align="middle" border="0"/>
						<br />
						Grant Access
						</a>
			        </td>
					<td>
					<?php if ($showImport) { ?>
						<a href="index2.php?option=com_timewriter&task=importFromMambotastic" style="text-decoration:none;" title="Import from Mambotastic Timesheets">
						<img src="./images/addusers.png" width="48px" height="48px" align="middle" border="0"/>
						<br />
						Mambotastic Import
						</a>
					<?php } else {?>
						<img src="./images/addusers.png" width="48px" height="48px" align="middle" border="0"/>
						<br />
						Mambotastic Import Disabled
					<?php } ?>
			        </td>
					</tr>
		         </table>
			  </td>
		      <td style="vertical-align:top;width:50%;">
				  <table class="aboutComponent">
			         <tr>
			            <th class="cpanel" colspan="1"><b>BrainWorX TimeWriter <?php echo HTML_Timesheet::version(); ?></b></th>
			         </tr>
			         <tr>
			         <td>
						 <p align="justify">
							<b>Summary</b><br>
					         BrainWorx TimeWriter is based on 
							 <a href="http://www.mambotastic.com" target="_blank">Mambotastic Timesheets</a> and ObjectClarity TimeWriter.  
							 It is a simple time and mileage tracking Joomla component that allows a set of 
							 registered users to record and report accurate time spent across multiple Companies 
							 and various Projects.  
							 Reporting, Company and Project administration is added to the front end so that the 
							 Joomla site administrator does not need to be involved in day-to-day activities  
							 within the system.
						 </p>
				         <p align="justify">
							<b>License</b><br>
							BrainWorX TimeWriter is free software released under the GNU General Public License, 
							a copy of this license can be obtained at 
							<a href="http://www.fsf.org/licenses/gpl.html" target="_blank">The Free Software Foundation</a>
				         </p>
				         <p align="justify">
							<?php
								HTML_Timesheet::copyrightFooter();
							?>
				         </p>
			         </td>
			         </tr>
			      </table>		  
		      </td>
		   </tr>
		</table>
	</td>
  </tr>
</table>

<?php
}

// ****************  End of the class  ****************
}
?>
