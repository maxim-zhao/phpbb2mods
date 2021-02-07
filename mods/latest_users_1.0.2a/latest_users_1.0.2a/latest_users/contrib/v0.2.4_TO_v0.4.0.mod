############################################################## 
## MOD Title: Latest Users Online
## MOD Author: Noobarmy < noobarmy@phpbbmodders.com > (Anthony Chu) http://phpbbmodders.com
## MOD Description: Displays the latest users online on the index page.
## MOD Version: 0.2.4
## 
## Installation Level: Easy
## Installation Time: 2 Minutes 
## Files To Edit: 2
##		admin/admin_board.php
##		language/lang_english/lang_main.php
##		templates/subSilver/admin/board_config_body.tpl
##
## Included Files: 1
##		root/images/avatar/default.gif
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
## 	This is an upgrade from 0.2.4 to 0.4.0
##	If you don't have 0.2.4 installed use the 0.4.0 install file
##
############################################################## 
## MOD History: 
## 
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ SQL ]------------------------------------------ 
#
INSERT INTO phpbb_config (config_name, config_value)
VALUES ('default_avatar', 'images/avatar/default.gif');

# 
#-----[ COPY ]------------------------------------------ 
# 
copy root/images/avatar/default.gif to images/avatar/default.gif

# 
#-----[ OPEN ]------------------------------------------ 
# 
language/lang_english/lang_main.php

# 
#-----[ FIND ]------------------------------------------ 
# 
?>

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
$lang['latest_users'] = 'Latest User Config';
$lang['latest_amount_of_users'] = 'Amount of Users to show on Index';
$lang['latest_default_avatar'] = 'Image to use if user does not have an avatar';

# 
#-----[ OPEN ]------------------------------------------ 
# 
admin/admin_board.php

# 
#-----[ FIND ]------------------------------------------ 
# 
	"L_YES" => $lang['Yes'],

# 
#-----[ BEFORE ADD ]------------------------------------------ 
# 
	"L_LATEST_USERS" => $lang['latest_users'],
	"L_LATEST_AMOUNT_OF_USERS" => $lang['latest_amount_of_users'],
	"L_LATEST_DEFAULT_AVATAR" => $lang['latest_default_avatar'],

# 
#-----[ FIND ]------------------------------------------ 
# 
	"S_DISABLE_BOARD_YES" => $disable_board_yes,

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
	"LATEST_AMOUNT_OF_USERS" => $new['show_latest_users_no'],
	"DEFAULT_AVATAR" => $new['default_avatar'],

# 
#-----[ OPEN ]------------------------------------------ 
# 
includes/functions_last_users.php

# 
#-----[ FIND ]------------------------------------------ 
# 
'AVATAR' => ( $avatar != '' ) ? $avatar : '', /* If you wanna add a default image for when a user doesn't have an avatar put it in the '' :) */

# 
#-----[ IN-LINE FIND ]------------------------------------------ 
# 
: ''

# 
#-----[ IN-LINE REPLACE WITH ]------------------------------------------ 
# 
: $board_config['default_avatar']

# 
#-----[ FIND ]------------------------------------------ 
# 
	$show_users = $board_config['show_latest_users_no']

# 
#-----[ REPLACE WITH ]------------------------------------------ 
# 
	$show_users = ( $board_config['show_latest_users_no'] > 0 ) ? $board_config['show_latest_users_no'] : '1';

# 
#-----[ OPEN ]------------------------------------------ 
# 
templates/subSilver/admin/board_config_body.tpl

# 
#-----[ FIND ]------------------------------------------ 
# 
	<tr>
		<th class="thHead" colspan="2">{L_PRIVATE_MESSAGING}</th>
	</tr>

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
	<tr>
		<th class="thHead" colspan="2">{L_LATEST_USERS}</th>
	</tr>
	<tr>
		<td class="row1">{L_LATEST_AMOUNT_OF_USERS}</td>
		<td class="row2"><input type="text" name="show_latest_users_no" value="{LATEST_AMOUNT_OF_USERS}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_LATEST_DEFAULT_AVATAR}</td>
		<td class="row2"><input type="text" name="default_avatar" value="{DEFAULT_AVATAR}" /></td>
	</tr>

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM