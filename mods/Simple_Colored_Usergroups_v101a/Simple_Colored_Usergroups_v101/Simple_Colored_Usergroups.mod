##############################################################
## MOD Title: Simple Colored Usergroups
## MOD Author: kkroo < princeomz2004@hotmail.com > (Omar Ramadan) http://phpbb-login.sourceforge.net
## MOD Author: Afterlife_69 < afterlife_69@hotmail.com > (Dean Newman) http://www.ugboards.com
## MOD Description: Replaces the current username coloring with a group based system like in Olympus (phpBB3).
## MOD Version: 1.0.1
## 
## Installation Level: Easy
## Installation Time: 5 minutes
## Files To Edit: index.php
##                viewonline.php
##                common.php
##                groupcp.php
##                includes/functions.php
##                includes/page_header.php
##                admin/admin_groups.php
##                admin/admin_users.php
##                templates/subSilver/admin/group_edit_body.tpl
##                templates/subSilver/admin/user_edit_body.tpl
##                templates/subSilver/index_body.tpl
##                language/lang_english/lang_main.php
##                language/lang_english/lang_admin.php
##                includes/usercp_register.php
##                templates/subSilver/profile_add_body.tpl
## Included Files: 
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2
##############################################################
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/
##############################################################
##	Author Notes: 
##		Better than the others :)
##	----------------------------------------------------------
##	MOD Features
##	----------------------------------------------------------
##	* Different sets of colors for each template.
##	* Automaticly use first color found for template if template color unset.
##	* 1 MySQL Query per page added.
##	* User Indepentant Group Priorities.
##	* Group coloring optional, Not applied to all groups.
##	* Ability to change the order of groups on the legend.
##	* Ability to control users Group Priorities.
##	* Show and group group and members for admin/mod if group is hidden.
##
##############################################################
## MOD History:
##
##	2006-04-10 - Version 0.1.0
##		-	Alpha version created.
##
##	2006-04-10 - Version 0.2.0
##		-	Project now is Stable BETA testing stage.
##
##	2006-04-11 - Version 0.3.0
##		-	Fixed a bug in the editprofile page that showed all color group instead of the ones the user was a member of.
##		-	Fixed a bug in the editprofile page that allowed a member to exploit the system and obtain the color of a group they are not a member of via posting a form from another page.
##
##	2006-04-11 - Version 0.4.0
##		-	Added a feature to allow the admin to edit the user's priority group via the ACP.
##
##	2006-06-10 - Version 0.5.0
##		-	Fixed the error message on registration.
##
##	2006-06-10 - Version 1.0.0
##		-	Ready for the MODS DB :).
## 
##	2006-06-10 - Version 1.0.1
##		-	Fixed bug in admin_users.php.
## 
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################

#
#-----[ SQL ]------------------------------------------
#
# Note:	If you prefer you can run the db_update.php file in /contrib
#		however you must run this file before making code changes.
#
ALTER TABLE phpbb_groups ADD group_colored tinyint(1) NOT NULL;
ALTER TABLE phpbb_groups ADD group_colors TEXT NOT NULL;
ALTER TABLE phpbb_groups ADD group_order int(255) NOT NULL;
ALTER TABLE phpbb_users ADD group_priority int(255) NOT NULL;

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

	// SIMPLE COLORED USERGROUPS MOD START
	if ( is_array($color_groups['groupdata']) )
	{
		$group_legend = array();
		foreach($color_groups['groupdata'] AS $group_id => $group_data)
		{
			if ( ! $userdata['session_logged_in'] )
			{
				$group_color = $group_data['group_color'][ $board_config['default_style'] ];
			}
			else
			{
				$group_color = $group_data['group_color'][ $userdata['user_style'] ];
			}
			if ( ! $group_color )
			{
				$match_found = false;
				foreach ( $group_data['group_color'] AS $color )
				{
					if ( ! $match_found )
					{
						if ( $color )
						{
							$group_color = $color;
							$match_found = true;
						}
					}
				}
			}
			if ( $group_color )
			{
				$grouplink = '<a class="gensmall" style="font-weight: bold; color: #' . $group_color . '" href="' . append_sid("groupcp.$phpEx?g=" . $group_data['group_id']) . '">' . $group_data['group_name'] . '</a>';
				$group_legend[] = $grouplink;
			}
		}
		$group_legend = implode(', ', $group_legend);
	}
	if ( ! $group_legend )
	{
		$group_legend = $lang['No_groups_exist'];
	}
	$group_legend = $lang['color_groups_legend'] . ': ' . $group_legend;
	// COLOR GROUPS END

#
#-----[ FIND ]------------------------------------------
#
'FORUM_LOCKED_IMG' => $images['forum_locked'],

#
#-----[ AFTER, ADD ]------------------------------------------
#
		'GROUP_LEGEND' => $group_legend,

#
#-----[ OPEN ]------------------------------------------
#
viewonline.php

#
#-----[ FIND ]------------------------------------------
#
			$style_color = '';
			if ( $row['user_level'] == ADMIN )
			{
				$username = '<b style="color:#' . $theme['fontcolor3'] . '">' . $username . '</b>';
			}
			else if ( $row['user_level'] == MOD )
			{
				$username = '<b style="color:#' . $theme['fontcolor2'] . '">' . $username . '</b>';
			}

#
#-----[ REPLACE WITH ]------------------------------------------
#
			// SIMPLE COLORED USERGROUPS MOD START
			$style_color = ($user_color = color_groups_user($row['user_id'])) ? 'style="font-weight:bold;color: #' . $user_color . '" ' : '';
			$username = '<span ' . $style_color . '>' . $username . '</span>';
			// COLOR GROUPS END

#
#-----[ OPEN ]------------------------------------------
#
common.php

#
#-----[ FIND ]------------------------------------------
#
?>

#
#-----[ BEFORE, ADD ]------------------------------------------
#
$color_groups = color_groups();

#
#-----[ OPEN ]------------------------------------------
#
groupcp.php

#
#-----[ FIND ]------------------------------------------
#
					message_die(GENERAL_ERROR, 'Could not update user level', '', __LINE__, __FILE__, $sql);
				}
			}
		}

#
#-----[ AFTER, ADD ]------------------------------------------
#
		// SIMPLE COLORED USERGROUPS MOD START
		if ( $userdata['group_priority'] == $group_id )
		{
			$sql = 'UPDATE ' . USERS_TABLE . ' SET group_priority = 0 WHERE user_id = ' . $userdata['user_id'];
			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not reset group priority.', '', __LINE__, __FILE__, $sql);
			}
		}
		// COLOR GROUPS END

#
#-----[ FIND ]------------------------------------------
#
						if ( $group_info['auth_mod'] )
						{

#
#-----[ REPLACE WITH ]------------------------------------------
#
						if ( $group_info['auth_mod'] || $userdata['user_level'] == ADMIN )
						{
							// SIMPLE COLORED USERGROUPS MOD START
							$sql = "SELECT group_priority, user_id
										FROM " . USERS_TABLE . "
											WHERE user_id IN ($sql_in) 
												AND group_priority = $group_id";
							if ( !$result = $db->sql_query($sql) )
							{
								message_die(GENERAL_ERROR, 'Could select group users.', '', __LINE__, __FILE__, $sql);
							}
							while ( $row = $db->sql_fetchrow($result) )
							{
								$sql = 'UPDATE ' . USERS_TABLE . ' SET group_priority = 0 WHERE user_id = ' . $row['user_id'];
								if ( !$db->sql_query($sql) )
								{
									message_die(GENERAL_ERROR, 'Could not reset group priority.', '', __LINE__, __FILE__, $sql);
								}
							}
							// COLOR GROUPS END

#
#-----[ OPEN ]------------------------------------------
#
includes/functions.php

#
#-----[ FIND ]------------------------------------------
#
?>

#
#-----[ BEFORE, ADD ]------------------------------------------
#
function color_groups()
{
	global $db, $board_config, $userdata;
	
	$groupdata = array();
	if ( $board_config['color_groups'] = true )
	{
		$rows = array();
		$group_users = array();
		$staff_sql = ($userdata['user_level'] == USER) ? 'AND g.group_type <> ' . GROUP_HIDDEN : '';
		$sql = "SELECT g.group_name, g.group_colors, ug.group_id, u.username, u.user_id, u.group_priority
			FROM " . GROUPS_TABLE . " g, " . USER_GROUP_TABLE . " ug, " . USERS_TABLE . " u
				WHERE g.group_single_user != 1
					AND g.group_colored <> 0
					AND ug.user_pending = 0
					AND ug.group_id = g.group_id
					AND ug.user_id = u.user_id
					$staff_sql
						ORDER BY g.group_order, g.group_name";
		if ( ! $result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not get group data from database', '', __LINE__, __FILE__, $sql);
		}
		while ( $row = $db->sql_fetchrow($result) )
		{
			$row['group_colors'] = unserialize($row['group_colors']);
			$rows[] = $row;
		}
		for($i = 0; $i < sizeof($rows); $i++)
		{
			$groupdata['userdata'][ $rows[$i]['user_id'] ] = array(
				'user_id' => $rows[$i]['user_id'],
				'username' => $rows[$i]['username'],
				'group_priority' => $rows[$i]['group_priority'],
			);
			$group_users[ $rows[$i]['group_id'] ][ $rows[$i]['user_id'] ] = $rows[$i]['user_id'];
			$groupdata['groupdata'][ $rows[$i]['group_id'] ] = array(
				'group_id' => $rows[$i]['group_id'],
				'group_color' => $rows[$i]['group_colors'],
				'group_name' => $rows[$i]['group_name'],
				'group_users' => $group_users[ $rows[$i]['group_id'] ],
			);
		}
	}
	return $groupdata;
}

function color_groups_user($user_id)
{
	global $userdata, $color_groups, $board_config;
	if ( ! $color_groups )
	{
		return false;
	}
	if ( ! is_array($color_groups['groupdata']) )
	{
		return false;
	}
	foreach ( $color_groups['groupdata'] AS $group_data )
	{
		if ( ! $userdata['session_logged_in'] )
		{
			$group_color = $group_data['group_color'][ $board_config['default_style'] ];
		}
		else
		{
			$group_color = $group_data['group_color'][ $userdata['user_style'] ];
		}
		if ( ! $group_color )
		{
			$match_found = false;
			foreach ( $group_data['group_color'] AS $color )
			{
				if ( ! $match_found )
				{
					if ( $color )
					{
						$group_color = $color;
						$match_found = true;
					}
				}
			}
		}
		if ( $color_groups['userdata'][$user_id]['group_priority'] == $group_data['group_id'] || ! $color_groups['userdata'][$user_id]['group_priority'] )
		{
			if ( in_array ( $user_id, $group_data['group_users'] ) )
			{
				return $group_color;
			}
		}
	}
	return false;
}

#
#-----[ OPEN ]------------------------------------------
#
includes/page_header.php

#
#-----[ FIND ]------------------------------------------
#
				$style_color = '';
				if ( $row['user_level'] == ADMIN )
				{
					$row['username'] = '<b>' . $row['username'] . '</b>';
					$style_color = 'style="color:#' . $theme['fontcolor3'] . '"';
				}
				else if ( $row['user_level'] == MOD )
				{
					$row['username'] = '<b>' . $row['username'] . '</b>';
					$style_color = 'style="color:#' . $theme['fontcolor2'] . '"';
				}

#
#-----[ REPLACE WITH ]------------------------------------------
#
				// SIMPLE COLORED USERGROUPS MOD START
				$style_color = ($user_color = color_groups_user($row['user_id'])) ? 'style="font-weight:bold;color: #' . $user_color . '" ' : '';
				// COLOR GROUPS END

#
#-----[ OPEN ]------------------------------------------
#
admin/admin_groups.php

#
#-----[ FIND ]------------------------------------------
#
		$group_moderator = $row['username'];
	}
	else
	{
		$group_moderator = '';
	}

#
#-----[ AFTER, ADD ]------------------------------------------
#
	// SIMPLE COLORED USERGROUPS MOD START
	// Select the template data
	$templatedata = array();
	$sql = "SELECT themes_id AS style_id, template_name AS style_name FROM " . THEMES_TABLE . " ORDER BY template_name";
	if (! $result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Unable to fetch styles data from database.', __LINE__, __FILE__, $sql);
	}
	while ( $row = $db->sql_fetchrow($result) )
	{
		$templatedata[] = $row;
	}
	$db->sql_freeresult($result);

	// Unserialize the group colors.
	$group_info['group_colors'] = unserialize($group_info['group_colors']);

	// Assign the template input boxs
	for ( $i = 0; $i < sizeof($templatedata); $i++ )
	{
		$template->assign_block_vars('styles_block', array(
			'STYLE_ID' => $templatedata[$i]['style_id'],
			'STYLE_NAME' => $templatedata[$i]['style_name'],
			'STYLE_COLOR' => $group_info['group_colors'][ $templatedata[$i]['style_id'] ],
		));
	}

	// Assign the order dropdown
	$template->assign_block_vars('group_row', array(
		'GROUP_ID' => 0,
		'GROUP_NAME' => $lang['color_groups_order_top'],
		'CHECKED' => ( $group_info['group_order'] - 1 == 0 ) ? 'selected="selected"' : '',
	));
	if ( is_array($color_groups['groupdata']) )
	{
		foreach ( $color_groups['groupdata'] AS $group_data )
		{
			$template->assign_block_vars('group_row', array(
				'GROUP_ID' => $group_data['group_id'],
				'GROUP_NAME' => '- ' . $group_data['group_name'],
				'CHECKED' => ( $group_info['group_order'] - 1 == $group_data['group_id'] ) ? 'selected="selected"' : '',
			));
		}
	}
	// COLOR GROUPS END

#
#-----[ FIND ]------------------------------------------
#
'GROUP_MODERATOR' => $group_moderator,

#
#-----[ AFTER, ADD ]------------------------------------------
#
		// SIMPLE COLORED USERGROUPS MOD START
		'L_COLOR_FOR' => $lang['color_groups_for'],
		'L_COLOR_GROUPS' => $lang['color_groups'],
		'L_COLOR_GROUPS_ON' => $lang['color_groups_on'],
		'L_COLOR_GROUPS_ORDER' => $lang['color_groups_order'],
		'S_COLOR_GROUPS_ON_CHECKED' => ( $group_info['group_colored'] ) ? 'checked="checked"' : '',
		// COLOR GROUPS END

#
#-----[ FIND ]------------------------------------------
#
		//
		// Delete Group
		//

#
#-----[ BEFORE, ADD ]------------------------------------------
#
		// SIMPLE COLORED USERGROUPS MOD START
		$sql = "SELECT u.group_priority, u.user_id FROM " . USER_GROUP_TABLE . " ug, " . USERS_TABLE . " u
					WHERE ug.group_id = $group_id
						AND u.user_id = ug.user_id";
		if ( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could select group users.', '', __LINE__, __FILE__, $sql);
		}
		while ( $row = $db->sql_fetchrow($result) )
		{
			if ( $row['group_priority'] == $group_id )
			{
				$sql = 'UPDATE ' . USERS_TABLE . ' SET group_priority = 0 WHERE user_id = ' . $row['user_id'];
				if ( !$db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, 'Could not reset group priority.', '', __LINE__, __FILE__, $sql);
				}
			}
		}
		// COLOR GROUPS END

#
#-----[ FIND ]------------------------------------------
#
$group_type = isset($HTTP_POST_VARS['group_type']) ? intval($HTTP_POST_VARS['group_type']) : GROUP_OPEN;

#
#-----[ BEFORE, ADD ]------------------------------------------
#
		// SIMPLE COLORED USERGROUPS MOD START
		$group_colors = array();
		$templatedata = array();
		$sql = "SELECT themes_id AS style_id, template_name AS style_name FROM " . THEMES_TABLE . " ORDER BY template_name";
		if (! $result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Unable to fetch styles data from database.', __LINE__, __FILE__, $sql);
		}
		while ( $row = $db->sql_fetchrow($result) )
		{
			$templatedata[] = $row;
		}
		$db->sql_freeresult($result);
		for ( $i = 0; $i < sizeof($templatedata); $i++)
		{
			$group_colors[ $templatedata[$i]['style_id'] ] = substr(htmlspecialchars($HTTP_POST_VARS[ 'color_' . $templatedata[$i]['style_id'] ]), 0, 6);
		}
		$group_colors = serialize($group_colors);
		$group_order = intval($HTTP_POST_VARS['color_group_order'] + 1);
		$group_colored_check = ( isset($HTTP_POST_VARS['group_colored']) ) ? 1 : 0;
		// COLOR GROUPS END

#
#-----[ FIND ]------------------------------------------
#
					$sql = "DELETE FROM " . USER_GROUP_TABLE . "
						WHERE user_id = " . $group_info['group_moderator'] . " 
							AND group_id = " . $group_id;
					if ( !$db->sql_query($sql) )
					{
						message_die(GENERAL_ERROR, 'Could not update group moderator', '', __LINE__, __FILE__, $sql);
					}

#
#-----[ AFTER, ADD ]------------------------------------------
#
					// SIMPLE COLORED USERGROUPS MOD START
					if ( $this_userdata['group_priority'] == $group_id )
					{
						$sql = "UPDATE " . USERS_TABLE . " SET group_priority = 0 WHERE user_id = $group_moderator";
						if ( !$db->sql_query($sql) )
						{
							message_die(GENERAL_ERROR, 'Could not insert new user-group info', '', __LINE__, __FILE__, $sql);
						}
					}
					// COLOR GROUPS END

#
#-----[ FIND ]------------------------------------------
#
			$sql = "UPDATE " . GROUPS_TABLE . "
				SET group_type = $group_type, group_name = '" . str_replace("\'", "''", $group_name) . "', group_description = '" . str_replace("\'", "''", $group_description) . "', group_moderator = $group_moderator
				WHERE group_id = $group_id";

#
#-----[ IN-LINE FIND ]------------------------------------------
#
group_moderator = $group_moderator

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, group_colored = '$group_colored_check', group_colors = '$group_colors', group_order = '$group_order' 

#
#-----[ FIND ]------------------------------------------
#
			$sql = "INSERT INTO " . GROUPS_TABLE . " (group_type, group_name, group_description, group_moderator, group_single_user) 

#
#-----[ IN-LINE FIND ]------------------------------------------
#
group_single_user

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, group_colored, group_colors, group_order

#
#-----[ FIND ]------------------------------------------
#
				VALUES ($group_type, '" . str_replace("\'", "''", $group_name) . "', '" . str_replace("\'", "''", $group_description) . "', $group_moderator,	'0')";

#
#-----[ IN-LINE FIND ]------------------------------------------
#
'0'

#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, '$group_colored_check', '$group_colors', '$group_order'

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/admin/group_edit_body.tpl

#
#-----[ FIND ]------------------------------------------
#
		{L_GROUP_DELETE_CHECK}</td>
	</tr>
	<!-- END group_edit -->

#
#-----[ AFTER, ADD ]------------------------------------------
#
<!-- COLOR_GROUPS -->
	<tr> 
	  <th class="thHead" colspan="2">{L_COLOR_GROUPS}</th>
	</tr>
	<!-- BEGIN styles_block -->
	<tr> 
	  <td class="row1" width="38%"><span class="gen">{L_COLOR_FOR} {styles_block.STYLE_NAME}:</span></td>
	  <td class="row2" width="62%">
		<input class="post" type="text" class="post" name="color_{styles_block.STYLE_ID}" maxlength="50" size="20" value="{styles_block.STYLE_COLOR}" />
	  </td>
	</tr>
	<!-- END styles_block -->
	<tr> 
	  <td class="row1" width="38%"><span class="gen">{L_COLOR_GROUPS_ORDER}:</span></td>
	  <td class="row2" width="62%">
		<select name="color_group_order">
			<!-- BEGIN group_row -->
			<option value="{group_row.GROUP_ID}" {group_row.CHECKED}>{group_row.GROUP_NAME}</option>
			<!-- END group_row -->
		</select>
	  </td> 
	</tr>
	<tr> 
	  <td class="row1" width="38%"><span class="gen">{L_COLOR_GROUPS_ON}:</span></td>
	  <td class="row2" width="62%"> 
		<input type="checkbox" name="group_colored" value="{S_COLOR_GROUPS_ON}" {S_COLOR_GROUPS_ON_CHECKED} /> {L_COLOR_GROUPS_ON}
	  </td> 
	</tr>
<!-- COLOR_GROUPS -->

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/index_body.tpl

#
#-----[ FIND ]------------------------------------------
#
<td class="row1" align="center" valign="middle" rowspan="{%:1}"><img src="templates/subSilver/images/whosonline.gif" alt="{L_WHO_IS_ONLINE}" /></td>

#
#-----[ INCREMENT ]-------------------------------------
#
%:1

#
#-----[ FIND ]------------------------------------------
#
	<td class="row1" align="left"><span class="gensmall">{TOTAL_USERS_ONLINE} &nbsp; [ {L_WHOSONLINE_ADMIN} ] &nbsp; [ {L_WHOSONLINE_MOD} ]<br />{RECORD_USERS}<br />{LOGGED_IN_USER_LIST}</span></td>
  </tr>

#
#-----[ REPLACE WITH ]------------------------------------------
#
	<!-- SIMPLE COLORED USERGROUPS MOD BY Afterlife_69 (http://www.ugboards.com) AND kkroo (http://phpbb-login.sourceforge.net) START -->

	<td class="row1" align="left"><span class="gensmall">{TOTAL_USERS_ONLINE}<br />{RECORD_USERS}<br />{LOGGED_IN_USER_LIST}</span></td>
  </tr>
  <tr> 
	<td class="row1" align="left"><span class="gensmall">{GROUP_LEGEND}</span></td>
  </tr>
	<!-- SIMPLE COLORED USERGROUPS MOD END START -->

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
//
// Simple Colored Usergroup MOD
//
$lang['Group_priority'] = 'User Group priority';
$lang['Not_in_group'] = 'You are not in any user groups';
$lang['color_groups_legend'] = 'Legend';

#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_admin.php

#
#-----[ FIND ]------------------------------------------
#
?>

#
#-----[ BEFORE, ADD ]------------------------------------------
#
$lang['color_groups'] = 'Group Colors';
$lang['color_groups_for'] = 'Group color for';
$lang['color_groups_on'] = 'Apply group color to this groups members';
$lang['color_groups_order'] = 'Position after group on legend';
$lang['color_groups_order_top'] = 'Position First';

#
#-----[ OPEN ]------------------------------------------
#
includes/usercp_register.php

#
#-----[ FIND ]------------------------------------------
#
$user_avatar_type = ( empty($user_avatar_local) && $mode == 'editprofile' ) ? $userdata['user_avatar_type'] : '';

#
#-----[ AFTER, ADD ]------------------------------------------
#
   // SIMPLE COLORED USERGROUPS MOD START
   if ( $mode == 'editprofile' )
   {
      $matched = false;
      $group_priority = ( isset($HTTP_POST_VARS['group_priority']) ) ? intval($HTTP_POST_VARS['group_priority']) : 0;
      if ( is_array($color_groups['groupdata']) )
     {
        foreach($color_groups['groupdata'] AS $color_group)
         {
            if ( is_array($color_group['group_users']) )
            {
               if ( in_array($userdata['user_id'], $color_group['group_users']) && $color_group['group_id'] == $group_priority )
               {
                  $matched = true;
               }
            }
         }
         if ( ! $matched )
         {
            $group_priority = 0;
         }
     }
   }
   // COLOR GROUPS END

#
#-----[ FIND ]------------------------------------------
#
				SET " . $username_sql . $passwd_sql . "u
#
#-----[ IN-LINE FIND ]------------------------------------------
#
user_timezone = $user_timezone, 

#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------
#
group_priority = '$group_priority', 
	
#
#-----[ FIND ]------------------------------------------
#
	if ( $user_id != $userdata['user_id'] )
	{
		$error = TRUE;
		$error_msg = $lang['Wrong_Profile'];
	}
#
#-----[ BEFORE, ADD ]------------------------------------------
#
	
	// SIMPLE COLORED USERGROUPS MOD START
	$group_values = '';
	$group_count = 0;
	foreach($color_groups['groupdata'] AS $color_group)
	{
		if ( in_array($userdata['user_id'], $color_group['group_users']) )
		{
			$group_priority_selected = ( $userdata['group_priority'] == $color_group['group_id'] ) ? ' selected="selected"' : '';
			$group_values .= '<option value="' . $color_group['group_id'] . '"' . $group_priority_selected . '>' . $color_group['group_name'] . '</option>';
			$group_count++;
		}
	}
	if ( $group_values && $group_count > 1)
	{
		$group_drop_down = '<select name="group_priority">' . $group_values . '</select>';
		$template->assign_block_vars('switch_color_groups', array());
	}
	else
	{
		$group_priority = 0;
	}
	// COLOR GROUPS END
	
#
#-----[ FIND ]------------------------------------------
#
		'DATE_FORMAT' => $user_dateformat,
#
#-----[ BEFORE, ADD ]------------------------------------------
#

		// SIMPLE COLORED USERGROUPS MOD START
		'GROUP_PRIORITY_SELECT' => $group_drop_down,
		// COLOR GROUPS END	
	
#
#-----[ FIND ]------------------------------------------
#
		'L_DATE_FORMAT' => $lang['Date_format'],
#
#-----[ BEFORE, ADD ]------------------------------------------
#

		// SIMPLE COLORED USERGROUPS MOD START
		'L_GROUP_PRIORITY' => $lang['Group_priority'],
		// COLOR GROUPS END	
	
#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/profile_add_body.tpl
#
#-----[ FIND ]------------------------------------------
#
	<tr> 
	  <td class="row1"><span class="gen">{L_TIMEZONE}:</span></td>
	  <td class="row2"><span class="gensmall">{TIMEZONE_SELECT}</span></td>
	</tr>

#
#-----[ AFTER, ADD ]------------------------------------------
#
	
	<!-- SIMPLE COLORED USERGROUPS MOD BY Afterlife_69 (http://www.ugboards.com) AND kkroo (http://phpbb-login.sourceforge.net) START -->
	<!-- BEGIN switch_color_groups -->
	<tr> 
	  <td class="row1"><span class="gen">{L_GROUP_PRIORITY}:</span></td>
	  <td class="row2"><span class="gensmall">{GROUP_PRIORITY_SELECT}</span></td>
	</tr>
	<!-- END switch_color_groups -->
	<!-- SIMPLE COLORED USERGROUPS END -->

		
#
#-----[ OPEN ]------------------------------------------
#
admin/admin_users.php


#
#-----[ FIND ]------------------------------------------
#
		$user_allowavatar = ( !empty($HTTP_POST_VARS['user_allowavatar']) ) ? intval( $HTTP_POST_VARS['user_allowavatar'] ) : 0;

#
#-----[ AFTER, ADD ]------------------------------------------
#
	
		// SIMPLE COLORED USERGROUPS MOD START
		$group_priority = ( isset($HTTP_POST_VARS['group_priority']) ) ? intval($HTTP_POST_VARS['group_priority']) : 0;
		// COLOR GROUPS END

#
#-----[ FIND ]------------------------------------------
#
				SET " . $username_sql . $passwd_sql

#
#-----[ IN-LINE FIND ]------------------------------------------
#
user_timezone = $user_timezone, 

#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------
#
group_priority = '$group_priority', 


#
#-----[ FIND ]------------------------------------------
#
		$icq = $this_userdata['user_icq'];

#
#-----[ BEFORE, ADD ]------------------------------------------
#

		// SIMPLE COLORED USERGROUPS MOD START
		foreach($color_groups['groupdata'] AS $color_group)
		{
			if ( in_array($this_userdata['user_id'], $color_group['group_users']) )
			{
				$group_priority_selected = ( $this_userdata['group_priority'] == $color_group['group_id'] ) ? ' selected="selected"' : '';
				$group_values .= '<option value="' . $color_group['group_id'] . '"' . $group_priority_selected . '>' . $color_group['group_name'] . '</option>';
				$group_count++;
			}
		}
		if ( $group_values && $group_count > 1)
		{
			$group_drop_down = '<select name="group_priority">' . $group_values . '</select>';
			$template->assign_block_vars('switch_color_groups', array());
		}
		else
		{
			$group_priority = 0;
		}
		// COLOR GROUPS END
		

#
#-----[ FIND ]------------------------------------------
#
			'DATE_FORMAT' => $user_dateformat,

#
#-----[ BEFORE, ADD ]------------------------------------------
#

			// SIMPLE COLORED USERGROUPS MOD START
			'GROUP_PRIORITY_SELECT' => $group_drop_down,
			// COLOR GROUPS END	

#
#-----[ FIND ]------------------------------------------
#
			'L_DATE_FORMAT' => $lang['Date_format'],

#
#-----[ BEFORE, ADD ]------------------------------------------
#
				
			// SIMPLE COLORED USERGROUPS MOD START
			'L_GROUP_PRIORITY' => $lang['Group_priority'],
			// COLOR GROUPS END	

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/admin/user_edit_body.tpl
#
#-----[ FIND ]------------------------------------------
#
	<tr> 
	  <td class="row1"><span class="gen">{L_TIMEZONE}</span></td>
	  <td class="row2">{TIMEZONE_SELECT}</td>
	</tr>

#
#-----[ AFTER, ADD ]------------------------------------------
#
	
	<!-- SIMPLE COLORED USERGROUPS MOD BY Afterlife_69 (http://www.ugboards.com) AND kkroo (http://phpbb-login.sourceforge.net) START -->
	<!-- BEGIN switch_color_groups -->
	<tr> 
	  <td class="row1"><span class="gen">{L_GROUP_PRIORITY}:</span></td>
	  <td class="row2"><span class="gensmall">{GROUP_PRIORITY_SELECT}</span></td>
	</tr>
	<!-- END switch_color_groups -->
	<!-- SIMPLE COLORED USERGROUPS END -->

#
#-----[ DIY INSTRUCTIONS ]---------------------------------------------
# 
This will add a version checker for this MOD compatible with the
Advanced Version Check MOD, if you do not have this MOD you do not
HAVE to upload this file

copy root/admin/avc_mods/avc_scu.php to admin/avc_mods/avc_scu.php

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM