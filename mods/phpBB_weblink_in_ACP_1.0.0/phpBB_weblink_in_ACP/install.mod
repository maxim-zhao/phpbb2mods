##############################################################
## MOD Title: Add phpBB web link to ACP
## MOD Author: cbrain < jamesbigbrain@hotmail.com > (N/A) http://www.spentrix.org
## MOD Description: This MOD will add a link to the phpBB website into your ACP.
## MOD Version: 1.0.0
## 
## Installation Level: Easy
## Installation Time: 2 minutes
## Files To Edit: language/lang_english/lang_admin.php
## Included Files: admin/admin_phpBB_website.php
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
## Author Notes: This is the first version of this MOD!
##############################################################
## MOD History:
## 
## 2006-10-25 - Version 1.0.0
## 
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################

#
#-----[ COPY ]------------------------------------------
#
# This is the file that will add the link. It's good for you because this is the first and last action!
copy admin/admin_phpBB_website.php to admin/admin_phpBB_website.php
#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_admin.php
#
#-----[ FIND ]------------------------------------------
#
?>
#
#-----[ BEFORE, ADD ]------------------------------------------
#
$lang['phpBB_Website'] = 'phpBB Website';
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM