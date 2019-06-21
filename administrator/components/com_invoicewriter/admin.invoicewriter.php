<?php
/**
* BrainWorX invoicewriter Component
* @package invoicewriter
* @copyright (C) 2010 BrainWorX / All rights reserved
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @link http://www.BrainWorX.be
*
* @Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
* @author Mark Stewart / Mambotastic
**/

require_once dirname(__FILE__) . '/admin.invoicewriter.html.php';
require_once dirname(__FILE__) . '/class.invoicewriter.php';
require_once( $mainframe->getPath( 'admin_html' ) );

$id = mosGetParam( $_REQUEST, 'id', '' );

switch ($task) {
  case "showUserPreferencesList":
   // showUserPreferencesList();
    break;
  case "mainDisplay":
  case "":
    mainDisplay();
    break;
}
 	
/******************************************************************************
 *
******************************************************************************/
function mainDisplay() {

	HTML_Timesheet::mainmenu($showImport);
}

// *****************************
