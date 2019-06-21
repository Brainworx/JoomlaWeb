<?php
/**
* BrainWorX invoicewriter Component
* @package invoicewriter
* @copyright (C) 2010 BrainWorX / All rights reserved
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @link http://www.BrainWorX.be
*
* @Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
* @author Stijn Heylen / BrainWorX
**/

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

global $mosConfig_live_site;

class HTML_invoicewriter {


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
		<br /><br />invoicewriter  &copy; 2010, All Rights Reserved
		<br />
		<?php echo HTML_invoicewriter::version(); ?>
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
 *   Get a list of Suppliers
******************************************************************************/
function supplierselect( $suppliername, $active, $nosupplier=0, $javascript=NULL, $order='supplier_name', $blank='- No Supplier -') {
	global $database;

		
	$query = "SELECT id AS value, supplier_name AS text" 
			. " FROM f9ko_iv_supplier"
			. " ORDER BY ". $order;
	$database->setQuery( $query );
	if ( $nosupplier ) {
		$suppliers[] = mosHTML::makeOption( '0', $blank );
		$suppliers = array_merge( $suppliers, $database->loadObjectList() );
	} else {
		$suppliers = $database->loadObjectList();
	}
	$suppliers = mosHTML::selectList( $suppliers, $suppliername, 'class="inputbox" size="1" '. $javascript, 'value', 'text', $active );
	return $suppliers;
}
/******************************************************************************
 *   Get a list of Users
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
 *   Get a list of Expensetypes
******************************************************************************/
function expensetypeselect( $name, $active, $notypes=0, $javascript=NULL, $order='name', $blank='- No Type -',$new=0) {
	global $database;
	
	$datewhere="";
	if($new){
		$date=date("Y-m-d");
		$datewhere = " WHERE start_date <= ".$database->Quote($date)." AND (end_date >= ".$database->Quote($date)." OR end_date = '0000-00-00')";
	}
		
	$query = "SELECT id AS value, CONCAT(description, CASE (end_date) WHEN '0000-00-00' THEN '' ELSE ' (untill end_date)' END)  AS text" 
			. " FROM f9ko_iv_expensetype"
			. $datewhere
			. " ORDER BY ". $order;
	$database->setQuery( $query );
	if ( $notypes ) {
		$types[] = mosHTML::makeOption( '0', $blank );
		$types = array_merge( $types, $database->loadObjectList() );
	} else {
		$types = $database->loadObjectList();
	}
	$types = mosHTML::selectList( $types, $name, 'class="inputbox" size="1" '. $javascript, 'value', 'text', $active );
	return $types;
}
/******************************************************************************
 *   Get a list of Taxtypes
******************************************************************************/
function taxtypeselect( $name, $active, $notypes=0, $javascript=NULL, $order='name', $blank='- No Type -') {
	global $database;
	
	
		
	$query = "SELECT id AS value, description AS text" 
			. " FROM f9ko_iv_taxtype"
			. " ORDER BY ". $order;
	$database->setQuery( $query );
	if ( $notypes ) {
		$types[] = mosHTML::makeOption( '0', $blank );
		$types = array_merge( $types, $database->loadObjectList() );
	} else {
		$types = $database->loadObjectList();
	}
	$types = mosHTML::selectList( $types, $name, 'class="inputbox" size="1" '. $javascript, 'value', 'text', $active );
	return $types;
}
/******************************************************************************
 *   Get a list of Staff Members
******************************************************************************/
function staffselect( $name, $active, $nouser=0, $javascript=NULL, $order='u.name', $blank='- No Staff Memeber -') {
	global $database;

		
	$query = "SELECT s.id AS value, u.name AS text" 
			. " FROM f9ko_iv_staff as s"
			. " LEFT JOIN f9ko_users as u ON (s.user_id = u.id)"
			. " ORDER BY ". $order;
	$database->setQuery( $query );
	if ( $nouser ) {
		$staff[] = mosHTML::makeOption( '0', $blank );
		$staff = array_merge( $staff, $database->loadObjectList() );
	} else {
		$staff = $database->loadObjectList();
	}
	$staff = mosHTML::selectList( $staff, $name, 'class="inputbox" size="1" '. $javascript, 'value', 'text', $active );
	return $staff;
}

/******************************************************************************
 *   Get a list of Incoming invoices
******************************************************************************/
function incomingselect( $companyname, $active, $javascript=NULL, $order='date', $blank='- No Company -', $limitpublished='0') {
	global $database;

	//$booked = ($limitpublished?"WHERE book_date != 'null'":"");
	$booked = "";
		
	$query = "SELECT id AS value, description AS text" 
			. " FROM f9ko_iv_incoming"
			. " $booked"
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
function isbillableradio ($billable, $noselection=0, $blank='All'){
    return ($noselection?"<input type='radio' name='is_billable' value='-1' ".($billable==-1?"checked":"")."/>$blank":"")
	   ."<input type='radio' name='is_billable' value='1' ".($billable==1?"checked":"")."/>Yes" 
	   ."<input type='radio' name='is_billable' value='0' ".($billable==0?"checked":"")."/>No";
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
	HTML_invoicewriter::printAdminHeading("Admin", "Timesheet Control Panel");
	
?>	
		<table align="center" style="width:80%;height:400px;">
		   <tr>
		      <td style="vertical-align:top;">				  
		         <table align="center" class="functions">
			        <tr>
					<td>
						<a href="index2.php?option=com_invoicewriter&task=showUserPreferencesList&limitstart=0" style="text-decoration:none;" title="Grant User Access">
						<img src="./images/addusers.png" width="48px" height="48px" align="middle" border="0"/>
						<br />
						Grant Access
						</a>
			        </td>
					</tr>
		         </table>
			  </td>
		      <td style="vertical-align:top;width:50%;">
				  <table class="aboutComponent">
			         <tr>
			            <th class="cpanel" colspan="1"><b>BrainWorX invoicewriter <?php echo HTML_invoicewriter::version(); ?></b></th>
			         </tr>
			         <tr>
			         <td>
						 <p align="justify">
							<b>Summary</b><br>
					         BrainWorX invoicewriter is a simple invoicing system for small companies.
							 <br>Made by 
							<a href="http://www.brainworx.be">BrainWorX</a> - Stijn Heylen
						 </p>
				         <p align="justify">
							<b>License</b><br>
							BrainWorX invoicewriter is free software released under the GNU General Public License, 
							a copy of this license can be obtained at 
							<a href="http://www.fsf.org/licenses/gpl.html" target="_blank">The Free Software Foundation</a>
				         </p>
				         <p align="justify">
							<?php
								HTML_invoicewriter::copyrightFooter();
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
