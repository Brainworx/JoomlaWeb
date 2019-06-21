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

class mosMenuBarCustom {


/******************************************************************************
 *  Back to the TimeWriter Admin Menu
******************************************************************************/
	function cancel( $alt='Cancel', $href='', $title='') {
		$image = mosAdminMenus::ImageCheckAdmin( 'cancel_f2.png', '/components/com_timewriter/images/', NULL, NULL, 'Cancel', 'cancel' );
		$image2 = mosAdminMenus::ImageCheckAdmin( 'cancel_f2.png', '/components/com_timewriter/images/', NULL, NULL, 'Cancel', 'cancel', 0 );
		if ( $href ) {
			$link = $href;
		} else {
			$link = 'javascript:window.history.back();';
		}
		?>
		<td>
		<a class="toolbar" <?php echo $title; ?>href="<?php echo $link; ?>" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('cancel','','<?php echo $image2; ?>',1);">
		<?php echo $image; ?>
		<?php echo $alt;?>
		</a>
		</td>
		<?php
	}

/******************************************************************************
 *  Used to designate a Timesheet System Administrator
******************************************************************************/
	function admin( $alt='Admin', $href='', $title='') {
		$image = mosAdminMenus::ImageCheckAdmin( 'keys_f2.png', '/components/com_timewriter/images/', 0, NULL, 'Promote', 'admin');  // Complete html IMG tag.
		$image2 = mosAdminMenus::ImageCheckAdmin( 'keys_f2.png', '/components/com_timewriter/images/', 0, NULL, 'Promote', 'admin', 0); // Image path only!
		if ( $href ) {
			$link = $href;
		} else {
			$link = 'javascript:window.history.back();';
		}
		?>
		<td>
		<a class="toolbar" <?php echo $title; ?> href="<?php echo $link; ?>" onmouseout="MM_swapImgRestore();"  onmouseover="MM_swapImage('admin','','<?php echo $image2; ?>',1);">
		<?php echo $image; ?>
		<?php echo $alt;?>
		</a>
		</td>
		<?php
	}

}

class menuUserPreferences {

	/******************************************************************************
	 *  
	******************************************************************************/
	function TEXT_MENU() {
		mosMenuBar::startTable();
		mosMenuBarCustom::admin('Allow User', "javascript:submitbutton('promoteTimesheetUser');", 'title="Timesheet User"');
		mosMenuBarCustom::cancel('Deny User', "javascript:submitbutton('demoteTimesheetUser');", 'title="Timesheet User"');
		mosMenuBar::divider();
		mosMenuBarCustom::admin('Promote', "javascript:submitbutton('promoteTimesheetAdmin');", 'title="Timesheet Admin"');
		mosMenuBarCustom::cancel('Demote', "javascript:submitbutton('demoteTimesheetAdmin');", 'title="Timesheet Admin"');
		mosMenuBar::divider();
		mosMenuBar::back('Back', './index2.php?option=com_timewriter&task=');
		mosMenuBar::spacer();
		mosMenuBar::endTable();
	}

}

?>
