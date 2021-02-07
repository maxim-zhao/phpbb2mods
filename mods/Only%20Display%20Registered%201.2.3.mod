##############################################################
## MOD Title: Only Display Registered Users Online
## MOD Author: FoulFoot < webmaster@acaeum.com > (N/A) http://www.acaeum.com
## MOD Description: Only displays visible, registered users in the "Who's Online" block, on the main
##                  forum screen and on the "View Online" screen.  Adjusts "Most Users Ever Online" 
##                  total to ignore guest users.  Not only does this keep hidden users truly hidden,
##                  but it also prevents those annoying spider bots from artificially increasing
##                  your total.  Does not affect "Who is Online" view in Admin CP.
##
## MOD Version: 1.2.3
##
## Installation Level: Intermediate
## Installation Time: ~10 Minutes
##
## Files To Edit: viewonline.php
##                includes/page_header.php 
##                language/lang_english/lang_main.php
##
## Included Files: (N/A) 
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2 
############################################################## 
## For security purposes, please check: http://www.phpbb.com/mods/ 
## for the latest version of this MOD. Although MODs are checked 
## before being allowed in the MODs Database there is no guarantee 
## that there are no security problems within the MOD. No support 
## will be given for MODs not found within the MODs Database which 
## can be found at http://www.phpbb.com/mods/ 
##############################################################
## Author Notes: Please note that this mod will reset your "Most Users Online" total to zero. 
##               If for some reason you want to keep your total (though without guest users counting 
##               towards your total, it's unlikely the record will ever be broken...), do not execute
##               the SQL code (line 57).               
##############################################################
## MOD History:  2005-01-24 - Version 1.0.0
##                          - First Release
##               2005-01-25 - Version 1.1.0
##                          - Hidden users now count towards record total
##               2005-02-02 - Version 1.1.1
##                          - Fixed problem in viewonline.php and added SQL code
##               2005-02-04 - Version 1.2.0
##                          - Record total is now updated if current users *equal* the previous record
##               2005-03-02 - Version 1.2.1
##                          - "View Online" screen no longer displays number of hidden users online (admins
##                            will still see hidden user names, however)
##               2006-07-07 - Version 1.2.2
##                          - Partial re-write for (better) EasyMOD compatibility.  Confirmed to work with 2.0.21.
##                            No functional changes.
##               2006-08-01 - Version 1.2.3
##                          - Partial re-write to get around an EasyMOD bug.  No functional changes.
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
############################################################## 

#
#-----[ SQL ]----------------------------------------------
#
UPDATE `phpbb_config` SET `config_value` = '0' WHERE `config_name` = 'record_online_users' LIMIT 1 ;

#
#-----[ OPEN ]------------------------------------------
#
viewonline.php

# 
#-----[ FIND ]------------------------------------------ 
#
	else
	{
		if ( $row['session_ip'] != $prev_ip )
		{
			$username = $lang['Guest'];
			$view_online = true;
			$guest_users++;
	
			$which_counter = 'guest_counter';
			$which_row = 'guest_user_row';
		}
	}

# 
#-----[ REPLACE WITH ]------------------------------------------ 
#
# code deleted
#

# 
#-----[ FIND ]------------------------------------------ 
#
if( $hidden_users == 0 )
{
	$l_h_user_s = $lang['Hidden_users_zero_online'];
}
else if( $hidden_users == 1 )
{
	$l_h_user_s = $lang['Hidden_user_online'];
}
else
{
	$l_h_user_s = $lang['Hidden_users_online'];
}

if( $guest_users == 0 )
{
	$l_g_user_s = $lang['Guest_users_zero_online'];
}
else if( $guest_users == 1 )
{
	$l_g_user_s = $lang['Guest_user_online'];
}
else
{
	$l_g_user_s = $lang['Guest_users_online'];
}

# 
#-----[ REPLACE WITH ]------------------------------------------ 
#
# code deleted
#

# 
#-----[ FIND ]------------------------------------------ 
#
	'TOTAL_REGISTERED_USERS_ONLINE' => sprintf($l_r_user_s, $registered_users) . sprintf($l_h_user_s, $hidden_users), 
	'TOTAL_GUEST_USERS_ONLINE' => sprintf($l_g_user_s, $guest_users))

# 
#-----[ REPLACE WITH ]------------------------------------------ 
#
	'TOTAL_REGISTERED_USERS_ONLINE' => sprintf($l_r_user_s, $registered_users))

# 
#-----[ FIND ]------------------------------------------ 
#
if ( $registered_users + $hidden_users == 0 )

# 
#-----[ REPLACE WITH ]------------------------------------------ 
#
if ( $registered_users == 0 )

# 
#-----[ FIND ]------------------------------------------ 
#
if ( $guest_users == 0 )
{
	$template->assign_vars(array(
		'L_NO_GUESTS_BROWSING' => $lang['No_users_browsing'])
	);
}

# 
#-----[ REPLACE WITH ]------------------------------------------ 
#
# code deleted
#

#
#-----[ OPEN ]------------------------------------------
#
includes/page_header.php

# 
#-----[ FIND ]------------------------------------------ 
#
	$total_online_users = $logged_visible_online + $logged_hidden_online + $guests_online;

	if ( $total_online_users > $board_config['record_online_users'])
	{
		$board_config['record_online_users'] = $total_online_users;
		$board_config['record_online_date'] = time();

		$sql = "UPDATE " . CONFIG_TABLE . "
			SET config_value = '$total_online_users'

# 
#-----[ REPLACE WITH ]------------------------------------------ 
#
# Note: if you want a new record when the user total is surpassed (instead of equalled), 
#       change:   if ( $total_for_record >= $board_config['record_online_users'])
#       to:       if ( $total_for_record > $board_config['record_online_users'])
#
	$total_online_users = $logged_visible_online;
        $total_for_record = $logged_visible_online + $logged_hidden_online;

	if ( $total_for_record >= $board_config['record_online_users'])
	{
		$board_config['record_online_users'] = $total_for_record;
		$board_config['record_online_date'] = time();

		$sql = "UPDATE " . CONFIG_TABLE . "
			SET config_value = '$total_for_record'

# 
#-----[ FIND ]------------------------------------------ 
#
	if ( $logged_visible_online == 0 )
	{
		$l_r_user_s = $lang['Reg_users_zero_total'];
	}
	else if ( $logged_visible_online == 1 )
	{
		$l_r_user_s = $lang['Reg_user_total'];
	}
	else
	{
		$l_r_user_s = $lang['Reg_users_total'];
	}

	if ( $logged_hidden_online == 0 )
	{
		$l_h_user_s = $lang['Hidden_users_zero_total'];
	}
	else if ( $logged_hidden_online == 1 )
	{
		$l_h_user_s = $lang['Hidden_user_total'];
	}
	else
	{
		$l_h_user_s = $lang['Hidden_users_total'];
	}

	if ( $guests_online == 0 )
	{
		$l_g_user_s = $lang['Guest_users_zero_total'];
	}
	else if ( $guests_online == 1 )
	{
		$l_g_user_s = $lang['Guest_user_total'];
	}
	else
	{
		$l_g_user_s = $lang['Guest_users_total'];
	}

# 
#-----[ REPLACE WITH ]------------------------------------------ 
#
# code deleted
#

# 
#-----[ FIND ]------------------------------------------ 
#
	$l_online_users .= sprintf($l_h_user_s, $logged_hidden_online);
	$l_online_users .= sprintf($l_g_user_s, $guests_online);

# 
#-----[ REPLACE WITH ]------------------------------------------ 
#
# code deleted
#

# 
#-----[ OPEN ]------------------------------------------ 
#
language/lang_english/lang_main.php

# 
#-----[ FIND ]------------------------------------------ 
#
$lang['Online_users_zero_total'] = 'In total there are <b>0</b> users online :: ';

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
#
users online ::

# 
#-----[ IN-LINE REPLACE WITH ]------------------------------------------ 
#
registered users online

# 
#-----[ FIND ]------------------------------------------ 
#
$lang['Online_users_total'] = 'In total there are <b>%d</b> users online :: ';

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
#
users online ::

# 
#-----[ IN-LINE REPLACE WITH ]------------------------------------------ 
#
registered users online

# 
#-----[ FIND ]------------------------------------------ 
#
$lang['Online_user_total'] = 'In total there is <b>%d</b> user online :: ';

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
#
user online ::

# 
#-----[ IN-LINE REPLACE WITH ]------------------------------------------ 
#
registered users online

#
#-----[ FIND ]------------------------------------------ 
#
$lang['Record_online_users'] = 'Most users ever online was <b>%s</b> on %s'; // first %s = number of users, second %s is the date.

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
#
users ever online

# 
#-----[ IN-LINE REPLACE WITH ]------------------------------------------ 
#
registered users ever online at once

#
#-----[ FIND ]------------------------------------------ 
#
$lang['Reg_users_zero_online'] = 'There are 0 Registered users and '; // There are 5 Registered and

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
#
0 Registered users and '; // There are 5 Registered and

# 
#-----[ IN-LINE REPLACE WITH ]------------------------------------------ 
#
zero Registered Users online'; // There are zero Registered Users online

#
#-----[ FIND ]------------------------------------------ 
#
$lang['Reg_users_online'] = 'There are %d Registered users and '; // There are 5 Registered and

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
#
users and '; // There are 5 Registered and

# 
#-----[ IN-LINE REPLACE WITH ]------------------------------------------ 
#
Users online'; // There are 5 Registered Users online

#
#-----[ FIND ]------------------------------------------ 
#
$lang['Reg_user_online'] = 'There is %d Registered user and '; // There is 1 Registered and

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
#
user and '; // There is 1 Registered and

# 
#-----[ IN-LINE REPLACE WITH ]------------------------------------------ 
#
User online'; // There is 1 Registered User online

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 