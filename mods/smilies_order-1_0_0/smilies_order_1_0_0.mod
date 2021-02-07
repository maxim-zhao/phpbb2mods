######################################################## 
## MOD Title: Smilies Order
## MOD Author: LifeIsPain < brian@orvp.net > (Brian Evans) n/a
## MOD Description: Allows for the smilies order to be changed from the admin panel and gives
##        the ability to the Admin to specify if new smilies should be added before or after
##        existing smilies.
## MOD Version: 1.0.0
## 
## Installation Level: Intermediate
## Installation Time: 15 Minutes
## 
## Files To Edit:         5
##                   - admin/admin_smilies.php
##                   - templates/subSilver/admin/smile_list_body.tpl
##                   - includes/functions_post.php
##                   - includes/constants.php
##                   - language/lang_english/lang_admin.php
## 
## Included Files:   arrow_down.gif, arrow_end.gif, arrow_top.gif, arrow_up.gif
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
##############################################################
## Author Notes: At the bottom of the Smilies Editing Utilities main page, there will be an
##    option for how to add smilies. This setting will effect how all smilies are added, both
##    for one at a time smilies and imports from .pak files.
######################################################## 
## MOD History:
## 
## v1.0.0 - 08/09/2003
##    + submitted to MODs database
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

#
#-----[ SQL ]------------------------------------------
#
ALTER TABLE phpbb_smilies ADD smilies_order INT( 5 ) NOT NULL;

#
#-----[ SQL ]------------------------------------------
#
INSERT INTO phpbb_config VALUES ('smilies_insert', 1);

#
#-----[ COPY ]------------------------------------------
#
copy arrow_down.gif to templates/subSilver/images/arrow_down.gif
copy arrow_end.gif to templates/subSilver/images/arrow_end.gif
copy arrow_top.gif to templates/subSilver/images/arrow_top.gif
copy arrow_up.gif to templates/subSilver/images/arrow_up.gif

#
#-----[ OPEN ]------------------------------------------
#
admin/admin_smilies.php

#
#-----[ FIND ]------------------------------------------
#
		for( $i = 0; $i < count($fcontents); $i++ )

#
#-----[ BEFORE, ADD ]------------------------------------------
#
		if( $board_config['smilies_insert'] == TOP_LIST )
		{
			$sql = "SELECT MIN(smilies_order) AS smilies_extreme
				FROM " . SMILIES_TABLE;
			$shift_it = -10;
		}
		else
		{
			$sql = "SELECT MAX(smilies_order) AS smilies_extreme
				FROM " . SMILIES_TABLE;
			$shift_it = 10;
		}

		if( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Couldn't get extreme values from the smilies table", "", __LINE__, __FILE__, $sql);
		}
		$row = $db->sql_fetchrow($result);

		$order_extreme = $row['smilies_extreme'] + $shift_it;

#
#-----[ FIND ]------------------------------------------
# NOTE: There are two instances of this, this is the first instance
#
$sql = "INSERT INTO " . SMILIES_TABLE

#
#-----[ IN-LINE FIND ]------------------------------------------
#
emoticon

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, smilies_order

#
#-----[ FIND ]------------------------------------------
#
VALUES('" . str_replace("\'", "''", $smile_data[$j])

#
#-----[ IN-LINE FIND ]------------------------------------------
#
$smile_data[1]) . "'

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, $order_extreme

#
#-----[ AFTER, ADD ]------------------------------------------
# NOTE: This line is to be the next full line after the line just edited
#
					$order_extreme = $order_extreme + $shift_it;

#
#-----[ FIND ]------------------------------------------
#
		$sql = "SELECT * 
			FROM " . SMILIES_TABLE;

#
#-----[ REPLACE WITH ]------------------------------------------
#
		$sql = "SELECT * 
			FROM " . SMILIES_TABLE ."
			ORDER BY smilies_order";

#
#-----[ FIND ]------------------------------------------
#
			// Save the data to the smiley table.
			//

#
#-----[ AFTER, ADD ]------------------------------------------
#
			if( $board_config['smilies_insert'] == TOP_LIST )
			{
				$sql = "SELECT MIN(smilies_order) AS smilies_extreme
					FROM " . SMILIES_TABLE;
				$shift_it = -10;
			}
			else
			{
				$sql = "SELECT MAX(smilies_order) AS smilies_extreme
					FROM " . SMILIES_TABLE;
				$shift_it = 10;
			}

			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Couldn't get extreme values from the smilies table", "", __LINE__, __FILE__, $sql);
			}
			$row = $db->sql_fetchrow($result);

			$order_extreme = $row['smilies_extreme'] + $shift_it;

#
#-----[ FIND ]------------------------------------------
#
$sql = "INSERT INTO " . SMILIES_TABLE


#
#-----[ IN-LINE FIND ]------------------------------------------
#
emoticon

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, smilies_order

#
#-----[ FIND ]------------------------------------------
#
VALUES ('" . str_replace("\'", "''", $smile_code)

#
#-----[ IN-LINE FIND ]------------------------------------------
#
$smile_emotion) . "'

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, $order_extreme

#
#-----[ FIND ]------------------------------------------
#
	//
	// This is the main display of the page before the admin has selected

#
#-----[ BEFORE, ADD ]------------------------------------------
#
	if( $HTTP_GET_VARS['option'] == 'select' && isset($HTTP_POST_VARS['insert_position']) )
	{
		$sql = "UPDATE " . CONFIG_TABLE . " SET
			config_value = '" . $HTTP_POST_VARS['insert_position'] . "'
			WHERE config_name = 'smilies_insert'";
		if( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Failed to update general configuration for smilies_insert", "", __LINE__, __FILE__, $sql);
		}
		$board_config['smilies_insert'] = $HTTP_POST_VARS['insert_position'];
	}

	if( $board_config['smilies_insert'] == TOP_LIST )
	{
		$pos_top_checked = ' selected="selected"';
		$pos_bot_checked = '';
	}
	else
	{
		$pos_top_checked = '';
		$pos_bot_checked = ' selected="selected"';
	}
	$position_select = '<select name="insert_position"><option value="' . TOP_LIST . '"' . $pos_top_checked . '>' . $lang['before'] . '</option><option value="' . BOTTOM_LIST . '"' . $pos_bot_checked . '>' . $lang['after'] . '</option></select>';


	if( isset($HTTP_GET_VARS['move']) && isset($HTTP_GET_VARS['id']) )
	{
		$moveit = ($HTTP_GET_VARS['move'] == 'up') ? -15 : 15;
		$sql = "UPDATE " . SMILIES_TABLE . "
			SET smilies_order = smilies_order + $moveit
			WHERE smilies_id = " . $HTTP_GET_VARS['id'];
		if( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Couldn't change smilies order", "", __LINE__, __FILE__, $sql);
		}

		$i = 10;
		$inc = 10;

		$sql = "SELECT *
			FROM " . SMILIES_TABLE . "
			ORDER BY smilies_order";
		if( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Couldn't query smilies order", "", __LINE__, __FILE__, $sql);
		}
		while ( $row = $db->sql_fetchrow($result) )
		{
			if ($row['smilies_order'] != $i)
			{
				$sql = "UPDATE " . SMILIES_TABLE . "
					SET smilies_order = $i
					WHERE smilies_id = " . $row['smilies_id'];
				if( !$db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, "Couldn't update order fields", "", __LINE__, __FILE__, $sql);
				}
			}
			$i += $inc;
		}

	}
	else if( isset($HTTP_GET_VARS['send']) && isset($HTTP_GET_VARS['id']) )
	{
		if( $HTTP_GET_VARS['send'] == 'top' )
		{
			$sql = "SELECT MIN(smilies_order) AS smilies_extreme
				FROM " . SMILIES_TABLE;
			$shift_it = -10;
		}
		else
		{
			$sql = "SELECT MAX(smilies_order) AS smilies_extreme
				FROM " . SMILIES_TABLE;
			$shift_it = 10;
		}

		if( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Couldn't get extreme values from the smilies table", "", __LINE__, __FILE__, $sql);
		}
		$row = $db->sql_fetchrow($result);

		$order_extreme = $row['smilies_extreme'] + $shift_it;

		$sql = "UPDATE " . SMILIES_TABLE . "
			SET smilies_order = $order_extreme
			WHERE smilies_id = " . $HTTP_GET_VARS['id'];
		if( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Couldn't change smilies order", "", __LINE__, __FILE__, $sql);
		}
	}

#
#-----[ FIND ]------------------------------------------
#
		FROM " . SMILIES_TABLE;

#
#-----[ REPLACE WITH ]------------------------------------------
#
		FROM " . SMILIES_TABLE . "
		ORDER BY smilies_order";

#
#-----[ FIND ]------------------------------------------
#
		"L_EXPORT_PACK" => $lang['export_smile_pack'],

#
#-----[ AFTER, ADD ]------------------------------------------
#
		'L_MOVE' => $lang['Move'],
		'L_MOVE_UP' => $lang['Move_up'],
		'L_MOVE_DOWN' => $lang['Move_down'],
		'L_MOVE_TOP' => $lang['Move_top'],
		'L_MOVE_END' => $lang['Move_end'],
		'L_POSITION_NEW_SMILIES' => $lang['position_new_smilies'],
		'L_SMILEY_CHANGE_POSITION' => $lang['smiley_change_position'],
		'L_SMILEY_CONFIG' => $lang['smiley_config'],
		
		'POSITION_SELECT' => $position_select,
		'S_POSITION_ACTION' => append_sid('admin_smilies.' . $phpEx . '?option=select'),

#
#-----[ FIND ]------------------------------------------
#
			"U_SMILEY_EDIT" => append_sid("admin_smilies.$phpEx?mode=edit&amp;id=" . $smilies[$i]['smilies_id']), 

#
#-----[ BEFORE, ADD ]------------------------------------------
#
			'U_SMILEY_MOVE_UP' => append_sid("admin_smilies.$phpEx?move=up&amp;id=" . $smilies[$i]['smilies_id']),
			'U_SMILEY_MOVE_DOWN' => append_sid("admin_smilies.$phpEx?move=down&amp;id=" . $smilies[$i]['smilies_id']),
			'U_SMILEY_MOVE_TOP' => append_sid("admin_smilies.$phpEx?send=top&amp;id=" . $smilies[$i]['smilies_id']),
			'U_SMILEY_MOVE_END' => append_sid("admin_smilies.$phpEx?send=end&amp;id=" . $smilies[$i]['smilies_id']),


#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/admin/smile_list_body.tpl

#
#-----[ FIND ]------------------------------------------
#
		<th class="thTop">{L_EMOT}</th>

#
#-----[ AFTER, ADD ]------------------------------------------
#
		<th class="thTop">{L_MOVE}</th>

#
#-----[ FIND ]------------------------------------------
#
		<td class="{smiles.ROW_CLASS}">{smiles.EMOT}</td>

#
#-----[ AFTER, ADD ]------------------------------------------
#
		<td class="{smiles.ROW_CLASS}" align="center"><a href="{smiles.U_SMILEY_MOVE_TOP}"><img src="../templates/subSilver/images/arrow_top.gif" border="0" alt="{L_MOVE_TOP} " title="{L_MOVE_TOP}" /></a><a href="{smiles.U_SMILEY_MOVE_UP}"><img src="../templates/subSilver/images/arrow_up.gif" border="0" alt="{L_MOVE_UP} " title="{L_MOVE_UP}" /></a><a href="{smiles.U_SMILEY_MOVE_DOWN}"><img src="../templates/subSilver/images/arrow_down.gif" border="0" alt="{L_MOVE_DOWN} " title="{L_MOVE_DOWN}" /></a><a href="{smiles.U_SMILEY_MOVE_END}"><img src="../templates/subSilver/images/arrow_end.gif" border="0" alt="{L_MOVE_END} " title="{L_MOVE_END}" /></a></td>

#
#-----[ FIND ]------------------------------------------
#
		<td class="catBottom" colspan="5" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="add" value="{L_SMILEY_ADD}" class="mainoption" />&nbsp;&nbsp;<input class="liteoption" type="submit" name="import_pack" value="{L_IMPORT_PACK}">&nbsp;&nbsp;<input class="liteoption" type="submit" name="export_pack" value="{L_EXPORT_PACK}"></td>

#
#-----[ IN-LINE FIND ]------------------------------------------
#
5

#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------
#
6

#
#-----[ FIND ]------------------------------------------
#
</table></form>

#
#-----[ AFTER, ADD ]------------------------------------------
#
<form method="post" action="{S_POSITION_ACTION}"><table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline">
	<tr><th class="thTop" colspan="2">{L_SMILEY_CONFIG}</th></tr>
	<tr><td class="row1">{L_POSITION_NEW_SMILIES}</td><td class="row2">{POSITION_SELECT}</td></tr>
	<tr><td class="catBottom" align="center" colspan="2">{S_HIDDEN_FIELDS}<input type="submit" name="change" value="{L_SMILEY_CHANGE_POSITION}" class="mainoption" /></td></tr>
</table></form>


#
#-----[ OPEN ]------------------------------------------
#
includes/functions_post.php

#
#-----[ FIND ]------------------------------------------
#
		ORDER BY smilies_id";

#
#-----[ REPLACE WITH ]------------------------------------------
#
		ORDER BY smilies_order";

#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_admin.php

#
#-----[ FIND ]------------------------------------------
# NOTE: This line is longer, add the next bit on a blank line
#
$lang['Click_return_smileadmin']

#
#-----[ AFTER, ADD ]------------------------------------------
#
$lang['position_new_smilies'] = 'Should new smilies be added before or after existing smilies?';
$lang['smiley_change_position'] = 'Change Insert Location';
$lang['before'] = 'Before';
$lang['after'] = 'After';
$lang['Move_top'] = 'Send to Top';
$lang['Move_end'] = 'Send to End';

#
#-----[ OPEN ]------------------------------------------
#
includes/constants.php

#
#-----[ FIND ]------------------------------------------
#
// Debug Level

#
#-----[ BEFORE, ADD ]------------------------------------------
#
// Smilies Order
define('TOP_LIST', -1);
define('BOTTOM_LIST', 1);


# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM