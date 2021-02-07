##############################################################
## MOD Title: php Info in ACP
## MOD Author: cbrain < jamesbigbrain@hotmail.com > (n/a) n/a
## MOD Description: This simple MOD, will allow you to view information about your servers instelation of php.
## MOD Version: 1.0.1
## 
## Installation Level: Easy
## Installation Time: 3 minutes
## Files To Edit: language/lang_english/lang_admin.php
## Included Files: admin/admin_php_info.php
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2
## Generator: Phpbb.ModTeam.Tools
##############################################################
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/
##############################################################
## Author Notes: 
##############################################################
## MOD History:
## 
## 2006-11-12 - Version 1.0.0
##      -The very first version.
## 
## 2006-11-18 - Version 1.0.1
##      -Fixed a secruity hole.
## 
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################

#
#-----[ COPY ]------------------------------------------
#
copy admin/admin_php_info.php to admin/admin_php_info.php
#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_admin.php
#
#-----[ FIND ]------------------------------------------
#
$lang['Styles'] = 
#
#-----[ AFTER, ADD ]------------------------------------------
#
$lang['php_utilities'] = 'php Utilities';
#
#-----[ FIND ]------------------------------------------
#
$lang['Restore_DB'] = 
#
#-----[ AFTER, ADD ]------------------------------------------
#
$lang['php_info'] = 'php Info';

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
