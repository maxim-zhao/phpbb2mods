##############################################################
## MOD Title: Simple Auto Group
## MOD Author: eviL3 < evil@phpbbmodders.com > (Igor Wiedler) http://phpbbmodders.com
## MOD Description: This is a very simple auto Groups MOD. It will add all registered users to a specified group.
## MOD Version: 1.0.0
## 
## Installation Level: Easy
## Installation Time: 6 minutes
## Files To Edit: includes/usercp_register.php
##                admin/admin_board.php
##                templates/subSilver/admin/board_config_body.tpl
##                language/lang_english/lang_admin.php
## Included Files: 
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2
## Generator: MOD Studio [ ModTemplateTools 1.0.2288.38406 ]
##############################################################
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/
##############################################################
## Author Notes: 
##############################################################
## MOD History:
## 
## 2006-06-21 - Version 0.1.0
## -First Beta release
##
## 2006-07-24 - Version 1.0.0
## -Updated and submitted
## 
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################
#
#-----[ SQL ]------------------------------------------
#
INSERT INTO phpbb_config (config_name, config_value) VALUES ('auto_group_id',5);

#
#-----[ OPEN ]------------------------------------------
#
includes/usercp_register.php

#
#-----[ FIND ]------------------------------------------
#
			$sql = "INSERT INTO " . USER_GROUP_TABLE . " (user_id, group_id, user_pending)
				VALUES ($user_id, $group_id, 0)";
			if( !($result = $db->sql_query($sql, END_TRANSACTION)) )
			{
				message_die(GENERAL_ERROR, 'Could not insert data into user_group table', '', __LINE__, __FILE__, $sql);
			}

#
#-----[ AFTER, ADD ]------------------------------------------
#
			$auto_group_id = $board_config['auto_group_id'];

			$sql = "INSERT INTO " . USER_GROUP_TABLE . " (user_id, group_id, user_pending)
				VALUES ($user_id, $auto_group_id, 0)";
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not insert data into user_group table', '', __LINE__, __FILE__, $sql);
			}

#
#-----[ OPEN ]------------------------------------------
#
admin/admin_board.php

#
#-----[ FIND ]------------------------------------------
#
$template->set_filenames(array(

#
#-----[ BEFORE, ADD ]------------------------------------------
#
// Simple Auto Usergroup
$simple_auto_group = $new['auto_group_id'];

$sql = "SELECT group_id, group_name, group_type
	FROM " . GROUPS_TABLE . " g
	WHERE group_single_user <> " . TRUE . "
	ORDER BY g.group_name";
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Error getting group information', '', __LINE__, __FILE__, $sql);
}

$s_group_list_opt = '';
while( $row = $db->sql_fetchrow($result) )
{
	if  ( $row['group_type'] != GROUP_HIDDEN || $userdata['user_level'] == ADMIN )
	{
    $s_selected = ( $row['group_id'] == $simple_auto_group ) ? 'selected="selected" ' : '';
		$s_group_list_opt .='<option ' . $s_selected . 'value="' . $row['group_id'] . '">' . $row['group_name'] . '</option>';
	}
}
$s_group_list = '<select name="auto_group_id">' . $s_group_list_opt . '</select>';

$simple_auto_group = $s_group_list;
// Simple auto Usergroup

#
#-----[ FIND ]------------------------------------------
#
	"L_SYSTEM_TIMEZONE" => $lang['System_timezone'],

#
#-----[ AFTER, ADD ]------------------------------------------
#
	"L_AUTO_GROUP" => $lang['Auto_group'],

#
#-----[ FIND ]------------------------------------------
#
	"TIMEZONE_SELECT" => $timezone_select,

#
#-----[ AFTER, ADD ]------------------------------------------
#
	"AUTO_GROUP_ID" => $simple_auto_group,

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/admin/board_config_body.tpl

#
#-----[ FIND ]------------------------------------------
#
	<tr>
		<td class="row1">{L_SYSTEM_TIMEZONE}</td>
		<td class="row2">{TIMEZONE_SELECT}</td>
	</tr>

#
#-----[ AFTER, ADD ]------------------------------------------
#
	<tr>
		<td class="row1">{L_AUTO_GROUP}</td>
		<td class="row2"><span class="gensmall">{AUTO_GROUP_ID}</span></td>
	</tr>

#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_admin.php

#
#-----[ FIND ]------------------------------------------
#
//
// That's all Folks!

#
#-----[ BEFORE, ADD ]------------------------------------------
#
$lang['Auto_group'] = 'Auto Group';

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
