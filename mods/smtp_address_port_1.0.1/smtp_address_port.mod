############################################################## 
## MOD Title: SMTP address:port Syntax
## MOD Author: 01satkins < stewart@webzone.uni.cc > (Stewart Atkins) http://www.webzone.uni.cc
## MOD Description: This MOD allows the use of address:port syntax 
##                  in the smtp host field of acp
## MOD Version: 1.0.1
## 
## Installation Level: Easy
## Installation Time: 1 Minute 
## Files To Edit: (1) smtp.php
## Included Files: n/a
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2
##############################################################
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/
############################################################## 
## Author Notes: just use address:port syntax for smtp host
## e.g. smtp.wanadoo.co.uk:25
## if no port supplied 25 will be assumed
##
############################################################## 
## MOD History:
##
## 15/05/2006 - first release
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ OPEN ]------------------------------------------ 
#
includes/smtp.php

# 
#-----[ FIND ]------------------------------------------ 
#
	// Ok we have error checked as much as we can to this point let's get on
# 
#-----[ BEFORE, ADD ]------------------------------------------ 
#
	$part=explode(":",$board_config['smtp_host']);
	if($part[1]==""){
		$part[1]=25;
	}
# 
#-----[ FIND ]------------------------------------------ 
#
if( !$socket = @fsockopen($board_config['smtp_host'], 25, $errno, $errstr, 20) )
# 
#-----[ REPLACE WITH ]------------------------------------------ 
#
if( !$socket = @fsockopen($part[0], $part[1], $errno, $errstr, 20) )
# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
#
# EoM