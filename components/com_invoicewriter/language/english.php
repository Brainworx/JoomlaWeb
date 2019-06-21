<?php
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
 
/*
	Example taken from :    http://ca3.php.net/sprintf
	
	$format = 'The %2$s contains %1$d monkeys';
		sprintf($format, $num, $location);
	or simply 
		echo $format;
	if there's no subsitution variables.
	
*/
function def($tag, $msg) {
	if (!defined($tag)) {
		DEFINE($tag, $msg);
	}
}

def('_OC_COM_INVOICEWRITER', 'com_invoicewriter');
def('_OC_CALENDAR', 'Calendar');
def('_OC_REPORTS', 'Reports');

?>
