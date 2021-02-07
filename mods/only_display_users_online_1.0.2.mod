##############################################################
## MOD Title: Only Display Users Online
## MOD Author: battye < cricketmx@hotmail.com > (battye) http://forums.cricketmx.com
## MOD Description: If 0 Registered, that text will not be shown, if 0 Guests are online, that text will
##                             not be shown. If 0 Hidden are online that text will not be shown. For example, say
##                             2 registered and 1 guest were on it would say: 2 Registered, 1 Guest  
##                             Leaving off the 0 Hidden.  
##
## MOD Version: 1.0.2
##
## Installation Level: Easy
## Installation Time: 3 Minutes
##
## Files To Edit (3): includes/page_header.php 
##                           language/lang_english/lang_main.php
##
## Included Files (0): (N/A)
##############################################################
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered
## in our MOD-Database, located at: http://www.phpbb.com/mods/
##############################################################
## Author Notes: Enjoy the MOD :-)
##############################################################
## MOD History:  2005-01-05 - Version 1.0.0
##      - First Release
## MOD History:  2005-01-09 - Version 1.0.1
##      - Fixed Replace action
## MOD History:  2005-01-11 - Version 1.0.2
##      - Fixed Replace error in MOD file.
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
############################################################## 

#
#-----[ OPEN ]------------------------------------------
#
includes/page_header.php
# 
#-----[ FIND ]------------------------------------------ 
#
if ( $logged_visible_online == 0 )
	{
		$l_r_user_s = $lang['Reg_users_zero_total'];
	}
# 
#-----[ REPLACE WITH ]------------------------------------------ 
#
if ( $logged_visible_online == 0 )
	{
		$l_r_user_s = '';
		$logged_visible_online = '';
	}
# 
#-----[ FIND ]------------------------------------------ 
#
	else if ( $logged_visible_online == 1 )
	{
		$l_r_user_s = $lang['Reg_user_total'];
	}
# 
#-----[ REPLACE WITH ]------------------------------------------ 
#
	else if ( $logged_visible_online == 1 )
	{
		$l_r_user_s = $lang['Reg_user_total'];
		if ( $total_online_users == 1 )
		{
		$l_r_user_s = $lang['Reg_user_total_only'];
		}
	}
# 
#-----[ FIND ]------------------------------------------ 
#
	if ( $logged_hidden_online == 0 )
	{
		$l_h_user_s = $lang['Hidden_users_zero_total'];
	}
# 
#-----[ REPLACE WITH ]------------------------------------------ 
#
	if ( $logged_hidden_online == 0 )
	{
		$l_h_user_s = '';
		$logged_hidden_online = '';
	}
# 
#-----[ FIND ]------------------------------------------ 
#
	else if ( $logged_hidden_online == 1 )
	{
		$l_h_user_s = $lang['Hidden_user_total'];
	}
# 
#-----[ REPLACE WITH ]------------------------------------------ 
#
	else if ( $logged_hidden_online == 1 )
	{
		$l_h_user_s = $lang['Hidden_user_total'];
		if ( $total_online_users == 1 )
		{
		$l_h_user_s = $lang['Hidden_user_total_only'];
		}
	}
# 
#-----[ FIND ]------------------------------------------ 
#
	if ( $guests_online == 0 )
	{
		$l_g_user_s = $lang['Guest_users_zero_total'];
	}
# 
#-----[ REPLACE WITH ]------------------------------------------ 
#
	if ( $guests_online == 0 )
	{
		$l_g_user_s = '';
		$guests_online = '';
	}
# 
#-----[ OPEN ]------------------------------------------ 
#
language/lang_english/lang_main.php
# 
#-----[ FIND ]------------------------------------------ 
#
$lang['Reg_user_total'] = '%d Registered, ';
# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
$lang['Reg_user_total_only'] = '%d Registered';
$lang['Hidden_user_total_only'] = '%d Hidden';
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 