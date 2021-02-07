############################################################## 
## MOD Title: Default post order: Descending 
## MOD Author: Ro-Maniak < phpbb.com_mod@vandensigtenhorst.net > (Rob van den Sigtenhorst) N/A
## MOD Description: This very simple mod changes the default post order in the topic display from ASCENDING to DESCENDING
## MOD Version: 1.1 
## 
## Installation Level: Easy 
## Installation Time: 1 Minute 
## Files To Edit: viewtopic.php 
## Included Files: N/A 
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2
############################################################## 
## For security purposes, please check: http://www.phpbb.com/mods/ 
## for the latest version of this MOD. Although MODs are checked 
## before being allowed in the MODs Database there is no guarantee 
## that there are no security problems within the MOD. No support 
## will be given for MODs not found within the MODs Database which 
## can be found at http://www.phpbb.com/mods/
############################################################## 
## Author Notes: N/A
## 
############################################################## 
## MOD History: 
## 
##   2006-07-06 - Version 1.0
##      - Initial Release 
##   2006-07-09 - Version 1.1
##      - No technical changes, MOD Template altered to comply to standards 
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ OPEN ]------------------------------------------ 
# 

viewtopic.php

# 
#-----[ FIND ]------------------------------------------ 
# 

	{ 
	   $post_order = 'asc'; 
	   $post_time_order = 'ASC'; 
	}

# 
#-----[ REPLACE WITH ]------------------------------------------ 
# 

	{ 
	   $post_order = 'desc'; 
	   $post_time_order = 'DESC'; 
	} 

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM