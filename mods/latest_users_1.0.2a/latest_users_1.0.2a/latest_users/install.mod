############################################################## 
## MOD Title: Latest Users Online
## MOD Author: Noobarmy < noobarmy@phpbbmodders.net > (Anthony Chu) http://phpbbmodders.net
## MOD Description: Displays the latest users to login on the index page.
## MOD Version: 1.0.2
## 
## Installation Level: Easy
## Installation Time: 5 Minutes 
## Files To Edit: 5
##		admin/admin_board.php
##		index.php
##		language/lang_english/lang_main.php
##		templates/subSilver/index_body.tpl
##		templates/subSilver/admin/board_config_body.tpl
##
## Included Files: 3
##		root/images/avatar/default.gif
##		root/includes/functions_last_user.php
##		root/templates/subSilver/latest_users.tpl
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
## 
############################################################## 
## MOD History: 
## 
## 	2006-12-13 - Version 1.0.2
##		-	Added option for extra rows
##
## 	2006-10-26 - Version 1.0.0
##		-	Submitted to the MODDB
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ SQL ]------------------------------------------ 
# Set phpbb_ to your actual prefix
INSERT INTO phpbb_config (config_name, config_value) 
VALUES ('show_latest_users_per_row', 10);

INSERT INTO phpbb_config (config_name, config_value) 
VALUES ('show_latest_users_rows', 1);

INSERT INTO phpbb_config (config_name, config_value)
VALUES ('default_avatar', 'images/avatars/default.gif');

# 
#-----[ COPY ]------------------------------------------ 
# 
copy root/includes/functions_last_users.php to includes/functions_last_users.php
copy root/templates/subSilver/latest_users.tpl to templates/subSilver/latest_users.tpl
copy root/images/avatars/default.gif to images/avatars/default.gif

# 
#-----[ OPEN ]------------------------------------------ 
# 
index.php

# 
#-----[ FIND ]------------------------------------------ 
# 
	$template->set_filenames(array(
		'body' => 'index_body.tpl')
	);

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
	include( $phpbb_root_path . 'includes/functions_last_users.' . $phpEx );
	get_latest_users();
# 
#-----[ OPEN ]------------------------------------------ 
# 
admin/admin_board.php

# 
#-----[ FIND ]------------------------------------------ 
# 
	"L_YES" => $lang['Yes'],

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
	"L_LATEST_USERS" => $lang['latest_users'],
	"L_LATEST_AMOUNT_OF_USERS_PER_ROW" => $lang['latest_amount_of_users_per_row'],
	"L_LATEST_AMOUNT_OF_ROWS" => $lang['latest_amount_of_rows'],
	"L_LATEST_DEFAULT_AVATAR" => $lang['latest_default_avatar'],

# 
#-----[ FIND ]------------------------------------------ 
# 
	"S_DISABLE_BOARD_YES" => $disable_board_yes,

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
	"LATEST_AMOUNT_OF_USERS" => $new['show_latest_users_per_row'],
	"LATEST_AMOUNT_OF_ROWS" => $new['show_latest_users_rows'],
	"DEFAULT_AVATAR" => $new['default_avatar'],

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
$lang['latest_amount_of_rows'] = 'Amount of rows of users to show';
$lang['latest_amount_of_users_per_row'] = 'Amount of users to show in a row';
$lang['latest_default_avatar'] = 'Image to use if user does not have an avatar';
$lang['latest_users_online'] = 'Latest Users Online';

# 
#-----[ OPEN ]------------------------------------------ 
# 
templates/subSilver/index_body.tpl

# 
#-----[ FIND ]------------------------------------------ 
# 
<table width="100%" cellpadding="1" cellspacing="1" border="0">
<tr>
	<td align="left" valign="top"><span class="gensmall">{L_ONLINE_EXPLAIN}</span></td>
</tr>
</table>

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
<table width="100%" cellpadding="1" cellspacing="1" border="0">
<tr>
	<td align="center">{LATEST_USERS}</td>
</tr>
</table>

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
		<td class="row1">{L_LATEST_AMOUNT_OF_USERS_PER_ROW}</td>
		<td class="row2"><input type="text" name="show_latest_users_per_row" value="{LATEST_AMOUNT_OF_USERS}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_LATEST_AMOUNT_OF_ROWS}</td>
		<td class="row2"><input type="text" name="show_latest_users_rows" value="{LATEST_AMOUNT_OF_ROWS}" /></td>
	</tr>
	<tr>
		<td class="row1">{L_LATEST_DEFAULT_AVATAR}</td>
		<td class="row2"><input type="text" name="default_avatar" value="{DEFAULT_AVATAR}" /></td>
	</tr>


# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM