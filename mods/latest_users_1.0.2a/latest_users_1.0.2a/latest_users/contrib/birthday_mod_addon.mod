############################################################## 
## MOD Title: Birthday MOD Add-On
## MOD Author: Noobarmy < noobarmy@phpbbmodders.net > (Anthony Chu) http://phpbbmodders.net
## MOD Description: Add-on For Birthday MOD
## MOD Version: 0.2.0
## 
## Installation Level: Easy
## Installation Time: 2 Minutes 
## Files To Edit: 
##			includes/functions_last_users.php
##			templates/subSilver/latest_users.tpl
##
## Included Files:
##	
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
## 			This is an add-on for terrafrost's birthday mod
##			You must have both birthday mod and latest users installed in order to use this add-on
############################################################## 
## MOD History: 
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ OPEN ]------------------------------------------ 
# 
includes/functions_last_users.php

# 
#-----[ FIND ]------------------------------------------ 
# 
	$sql = 'SELECT user_id, username, user_from, user_avatar, user_avatar_type, user_allowavatar

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 
, user_allowavatar

# 
#-----[ IN-LINE REPLACE WITH ]------------------------------------------ 
# 
, user_birthday

# 
#-----[ FIND ]------------------------------------------ 
# 
	while ( $row = $db->sql_fetchrow($result) )
	{

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
	/* Taken out of Birthday MOD */
	preg_match('/(..)(..)(....)/', sprintf('%08d',$row['user_birthday']), $bday_parts);
	$bday_month = $bday_parts[1];
	$bday_day = $bday_parts[2];
	$bday_year = $bday_parts[3];
	$birthday_format = ($bday_year != 0) ? str_replace(array('y','Y'),array($bday_year % 100,$bday_year),$lang['DATE_FORMAT']) : preg_replace('#[^djFmMnYy]*[Yy]#','',$lang['DATE_FORMAT']);
	$birthday = create_date($birthday_format, gmmktime(0,0,0,$bday_month,$bday_day,4), 0);

# 
#-----[ FIND ]------------------------------------------ 
# 
								'LOCATION' => ( $row['user_from'] != '' ) ? '(' . $row['user_from'] . ')' : '')

# 
#-----[ REPLACE WITH ]------------------------------------------ 
# 
								'LOCATION' => ( $row['user_from'] != '' ) ? '(' . $row['user_from'] . ')' : '',
								'BIRTHDAY' => $birthday )

# 
#-----[ OPEN ]------------------------------------------ 
# 
templates/subSilver/latest_users.tpl

# 
#-----[ FIND ]------------------------------------------ 
# 
<span class="gensmall">{users_loop.LOCATION}</span></a></tr>

# 
#-----[ REPLACE WITH ]------------------------------------------ 
# 
<span class="gensmall">{users_loop.LOCATION}&nbsp;{users_loop.BIRTHDAY}</span></a></tr>

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM