##############################################################
## MOD Title: Hidden User Enhancement
## MOD Author: wossName <alexander@dietrich.cx> (Alexander Dietrich)
## MOD Description:
##     Allows only the administrator(s) to see
##     how many hidden users are online.
## MOD Version: 1.0.2
##
## Installation Level: Easy
## Installation Time: 5 Minutes
## Files To Edit:
##     viewonline.php
##     includes/page_header.php
##     language/lang_english/lang_main.php
## Included Files: n/a
##############################################################
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered
## in our MOD-Database, located at: http://www.phpbb.com/mods/
##############################################################
## Author Notes:
## I see no point in giving users the option to hide their online status
## and then counting them in the "Who is Online" statistic. Especially in
## smaller communities this might indicate activity of specific persons.
## Therefore, this MOD removes the hidden users count for non-admin users.
##############################################################
## MOD History:
## 1.0.2: Updated to phpBB 2.0.4
## 1.0.1: OPEN actions now look like in the MOD tutorial
## 1.0.0: Initial release
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ OPEN ]------------------------------------------
#
viewonline.php

#
#-----[ FIND ]------------------------------------------
#
$template->assign_vars(array(
	'TOTAL_REGISTERED_USERS_ONLINE' => sprintf($l_r_user_s, $registered_users) . sprintf($l_h_user_s, $hidden_users), 
	'TOTAL_GUEST_USERS_ONLINE' => sprintf($l_g_user_s, $guest_users))
);

#
#-----[ REPLACE WITH ]------------------------------------------
#
if ( $userdata['user_level'] != ADMIN )
{
	$template->assign_vars(array(
		'TOTAL_REGISTERED_USERS_ONLINE' => sprintf($l_r_user_s, $registered_users), 
		'TOTAL_GUEST_USERS_ONLINE' => sprintf($l_g_user_s, $guest_users))
	);
}
else
{
	$template->assign_vars(array(
		'TOTAL_REGISTERED_USERS_ONLINE' => sprintf($l_r_user_s, $registered_users) . sprintf($l_h_user_s, $hidden_users), 
		'TOTAL_GUEST_USERS_ONLINE' => sprintf($l_g_user_s, $guest_users))
	);
}
 
#
#-----[ OPEN ]------------------------------------------
#
includes/page_header.php

#
#-----[ FIND ]------------------------------------------
#
if ( $total_online_users == 0 )

#
#-----[ REPLACE WITH ]------------------------------------------
#
if ( $userdata['user_level'] != ADMIN )
{
	$total_visible_users = $logged_visible_online + $guests_online;
}
else
{
	$total_visible_users = $total_online_users;
}

if ( $total_visible_users == 0 )

#
#-----[ FIND ]------------------------------------------
#
else if ( $total_online_users == 1 )

#
#-----[ REPLACE WITH ]------------------------------------------
#
else if ( $total_visible_users == 1 )

#
#-----[ FIND ]------------------------------------------
#
$l_online_users = sprintf($l_t_user_s, $total_online_users);
$l_online_users .= sprintf($l_r_user_s, $logged_visible_online);
$l_online_users .= sprintf($l_h_user_s, $logged_hidden_online);
 
#
#-----[ REPLACE WITH ]------------------------------------------
#
$l_online_users = sprintf($l_t_user_s, $total_visible_users);
$l_online_users .= sprintf($l_r_user_s, $logged_visible_online);
if ( $userdata['user_level'] == ADMIN )
{
	$l_online_users .= sprintf($l_h_user_s, $logged_hidden_online);
}

#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_main.php

#
#-----[ FIND ]------------------------------------------
#
$lang['Reg_users_zero_total'] = '0 Registered, ';
$lang['Reg_users_total'] = '%d Registered, ';
$lang['Reg_user_total'] = '%d Registered, ';
$lang['Hidden_users_zero_total'] = '0 Hidden and ';
$lang['Hidden_user_total'] = '%d Hidden and ';
$lang['Hidden_users_total'] = '%d Hidden and ';
$lang['Guest_users_zero_total'] = '0 Guests';
$lang['Guest_users_total'] = '%d Guests';
$lang['Guest_user_total'] = '%d Guest';

#
#-----[ REPLACE WITH ]------------------------------------------
#
$lang['Reg_users_zero_total'] = '0 Registered';
$lang['Reg_users_total'] = '%d Registered';
$lang['Reg_user_total'] = '%d Registered';
$lang['Hidden_users_zero_total'] = ', 0 Hidden';
$lang['Hidden_user_total'] = ', %d Hidden';
$lang['Hidden_users_total'] = ', %d Hidden';
$lang['Guest_users_zero_total'] = ' and 0 Guests';
$lang['Guest_users_total'] = ' and %d Guests';
$lang['Guest_user_total'] = ' and %d Guest';

#
#-----[ FIND ]------------------------------------------
#
$lang['Reg_users_zero_online'] = 'There are 0 Registered users and '; // There are 5 Registered and
$lang['Reg_users_online'] = 'There are %d Registered users and '; // There are 5 Registered and
$lang['Reg_user_online'] = 'There is %d Registered user and '; // There is 1 Registered and
$lang['Hidden_users_zero_online'] = '0 Hidden users online'; // 6 Hidden users online
$lang['Hidden_users_online'] = '%d Hidden users online'; // 6 Hidden users online
$lang['Hidden_user_online'] = '%d Hidden user online'; // 6 Hidden users online
$lang['Guest_users_online'] = 'There are %d Guest users online'; // There are 10 Guest users online
$lang['Guest_users_zero_online'] = 'There are 0 Guest users online'; // There are 10 Guest users online
$lang['Guest_user_online'] = 'There is %d Guest user online'; // There is 1 Guest user online

#
#-----[ REPLACE WITH ]------------------------------------------
#
$lang['Reg_users_zero_online'] = 'There are 0 Registered users'; // There are 5 Registered and
$lang['Reg_users_online'] = 'There are %d Registered users'; // There are 5 Registered and
$lang['Reg_user_online'] = 'There is %d Registered user'; // There are 5 Registered and
$lang['Hidden_users_zero_online'] = ' and 0 Hidden users'; // 6 Hidden users online
$lang['Hidden_users_online'] = ' and %d Hidden users'; // 6 Hidden users online
$lang['Hidden_user_online'] = ' and %d Hidden user'; // 6 Hidden users online
$lang['Guest_users_online'] = 'There are %d Guest users'; // There are 10 Guest users online
$lang['Guest_users_zero_online'] = 'There are 0 Guest users'; // There are 10 Guest users online
$lang['Guest_user_online'] = 'There is %d Guest user'; // There is 1 Guest user online

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
