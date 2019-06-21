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

require_once($mainframe->getPath('toolbar_html'));

if ($task) {

  switch ( $task ) {
    case 'showUserPreferencesList' :
    	menuUserPreferences::TEXT_MENU();
    	break;    
  }
 
}
?>