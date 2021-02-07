############################################################## 
## MOD Title: Viewonline Auto Refresh
## MOD Author: Brf < b.fermanich@insightbb.com  > (Brad Fermanich) http://castledoom.com/forum 
## MOD Description: This causes viewonline to automatically refresh itself once per minute.
## MOD Version: 1.0.0
## 
## Installation Level: Easy 
## Installation Time: 1 Minute 
## Files To Edit: viewonline.php
## Included Files: None
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2 
############################################################## 
## For security purposes, please check: http://www.phpbb.com/mods/ 
## for the latest version of this MOD. Although MODs are checked 
## before being allowed in the MODs Database there is no guarantee 
## that there are no security problems within the MOD. No support 
## will be given for MODs not found within the MODs Database which 
## can be found at http://www.phpbb.com/mods/
############################################################## 
## Author Notes: 
##
############################################################## 
## MOD History: 
##
##   2006-11-01 - Version 1.0.0
##	- Initial Release
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 
# 
# 
#-----[ OPEN ]------------------------------------------ 
# 
viewonline.php

# 
#-----[ FIND ]------------------------------------------ 
# 
	$page_title = $lang['Who_is_Online'];
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
# Note: The "60" is seconds delay before refreshing.
# It can be changed to any reasonable number if more or less delay is desired
# Add this before the page_header include
#
	$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="60">')
		);

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 
