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

// no direct access
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

?>
1. Copyright and disclaimer
---------------------------
This application is open source software released under the GPL.  
Please see source code and the LICENSE file.


2. Changelog
------------
This is a non-exhaustive (but still near complete) changelog for
ObjectClarity TimeWriter, including beta and release candidate versions.
Thanks to all those people who've contributed bug reports and code fixes.

Legend:

* -> Security Fix
# -> Bug Fix
+ -> Addition
^ -> Change
- -> Removed
! -> Note

---------------- 1.0.6 Stable -- [ 22-Aug-2008 ] ------------------------
^ Ported component to Joomla! 1.5.x.
! NOTE:  This version is *NOT* backward compatible with Joomla! 1.0.X!
  

---------------- 1.0.5 Stable -- [ 14-Aug-2008 ] ------------------------

# Fixed 31 days bug with code changes provided by forum user lomanej 


  ---------------- 1.0.4 Beta -- [ 16-Aug-2007 ] ------------------------

# Updated a query in Admin to remove SQL syntax not supported by mySql 4.0.x
# Updated the query used in the front to build the calendar to remove 
  the MONTHNAME() function not supported by mySql 4.0.x
# Removed a number of subqueries from the front end as they too are 
  not supported by mySql 4.0.x


---------------- 1.0.3 Beta -- [ 31-Jul-2007 ] ------------------------

# Fixed the menu item created by the installer as it failed on some systems
+ Added a weekly summary Single User and Multi-User report
  

---------------- 1.0.2 Beta -- [ 18-Jun-2007 ] ------------------------

# Fixed the Company Select in Mileage entry to list distinct companies
# Fixed the filter Select lists on the Manage Projects page
# Fixed Multi-User reports to actually include multiple users
! Did not address the SQL issues when running on old versions of MySQL - yet!
  

---------------- 1.0.1 Beta -- [ 9-May-2007 ] ------------------------

+ Moved the english language file from administrator/components/com_timewriter 
	to /components/com_timewriter and added first couple entries
+ Added import from Mambotastic Timesheet tables
+ Added a changelog and license files
+ Added comment / license headers to all files
+ Added code to create menu item during installation
^ Updated popup reports to include the menubar to allow for landscape printing
^ Minor code mods to remove PHP variable definition notices.


---------------- 1.0.0 Beta -- [ 5-May-2007 ] ------------------------
+ First release
