<?php
/**
* BrainWorX InvoiceWriter Component
* @package InvoiceWriter
* @copyright (C) 2007 BrainWorX / All rights reserved
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @link http://www.BrainWorX.com
*
* Based on the Mambotastic Timesheets Component
* @copyright (C) 2005 Mark Stewart / All Rights Reserved
* @Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
* @author Mark Stewart / Mambotastic
**/

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

function com_install() {

	function addMenuEntry() {
		global $database;
		$database->setQuery("SELECT count(*) FROM `#__menu` WHERE published > 0 AND link = 'index.php?option=com_invoicewriter'");
		$menuItem = $database->loadResult();
		if (!$menuItem) {
			$database->setQuery("SELECT MIN(id) FROM #__components WHERE `option` = 'com_InvoiceWriter'");
			$num = intval($database->loadResult());
			$database->setQuery("SELECT MAX(ordering) FROM `#__menu`");
			$ordering = intval($database->loadResult() + 1);
			$database->setQuery("INSERT INTO `#__menu` "
							." (`id`, `menutype`, `name`, `link`, `type`, `published`, `parent`, `componentid`, `sublevel`, `ordering`, `checked_out`, `checked_out_time`, `pollid`, `browserNav`, `access`, `utaccess`, `params`) "
							." VALUES (NULL , 'mainmenu', 'BrainWorX InvoiceWriter', 'index.php?option=com_invoicewriter', 'components', '1', '0', $num, '0', $ordering, '0', '0000-00-00 00:00:00', '0', '0', '0', '0', '')");

			if ($database->query()) {
				echo "A new menu item that points to BrainWorX InvoiceWriter has been added to your <b>mainmenu</b>.";
			} else {
				echo "Failed to add a new menu item that points to BrainWorX InvoiceWriter. ";
				echo "<br><b>" . $database->getErrorMsg() . "</b>";
			}
		}
	}
?>

  	<div>
	<h2>Welcome to BrainWorX InvoiceWriter. </h2>
	<br>
	To use the component simply go to the components menu in your administration console 
  	and click on the "BrainWorX InvoiceWriter" menu item. 
	<br>
	Please note this component has been designed for usage with the TimeWriter component.
	If you would not want to use the TimeWriter component, you need to modify the SQL install file by removing the foreign key to table 
	of #_iv_supplier to #_oc_company.
	<br><br>
	From there you are able to define which registered users are allowed to use the InvoiceWriter 
	component and which user(s) can administer it.
	<br><br>
	
	<?php addMenuEntry(); ?>	
	<br><br>
		
	Thank you for using this component.
    
	<br><br>
	Please contact us at <a href="http://www.BrainWorX.com" target="_blank">www.BrainWorX.com</a> 
	with any feedback, questions or bug reports.
	</div>
	
<?php
	return true;
}
?>
