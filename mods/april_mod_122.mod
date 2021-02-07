##############################################################
## MOD Title: April Fool MOD
## MOD Author: naderman <naderman@gmx.de> (Nils Adermann) http://www.naderman.de
## MOD Author: A_Jelly_Doughnut <support@jd1.clawz.com> (Josh W) N/A
## MOD Description: With this MOD installed every user has the impression that he is an admin.
## MOD Version: 1.2.2
##
## Installation Level: Easy
## Installation Time: 10 Minutes
## Files To Edit:
##               includes/page_tail.php
##               includes/page_header.php
##               viewonline.php
##               includes/usercp_viewprofile.php
##               viewtopic.php
##               admin/admin_board.php
##               templates/subSilver/admin/board_config_body.tpl
##               language/lang_english/lang_admin.php
##               includes/functions_selects.php
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
## Author Notes:
##
##     The SQL assumes the default phpbb_ table prefix only. If
##     you use a different table prefix you have to change the SQL accordingly.
##
##     Changes in templates/subSilver/admin/board_config.tpl
##     have to be repeated for all installed templates.
##
##############################################################
## MOD History:
##
##   2005-10-04 - Version 0.1.0
##      - Initial Version
##
##   2005-04-24 - Version 1.0.0
##      - removed duplicate file from zip archive
##
##   2005-01-05 - Version 1.0.1
##      - corrected paths in install file
##
##   2005-02-05 - Version 1.2.0
##      - added configuration options in ACP
##      - added on/off switch
##
##   2005-02-05 - Version 1.2.1
##      - forgot to include a function
##
##	 2007-11-21 - Version 1.2.2
##		- Updates to MOD Template
##		- Cross-DBMS compatibility
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ SQL ]------------------------------------------
#
INSERT INTO phpbb_config ( config_name, config_value ) VALUES ('april_rank', '1');
INSERT INTO phpbb_config ( config_name, config_value ) VALUES ('april_mod_disable', '0');

#
#-----[ OPEN ]------------------------------------------
#
includes/page_tail.php

#
#-----[ FIND ]------------------------------------------
#
$admin_link = ( $userdata['user_level'] == ADMIN ) ? '<a href="admin/index.' . $phpEx . '?sid=' . $userdata['session_id'] . '">' . $lang['Admin_panel'] . '</a><br /><br />' : '';

#
#-----[ AFTER, ADD ]------------------------------------------
#

// BEGIN April MOD
if (!$board_config['april_mod_disable'] && $userdata['user_id'] != ANONYMOUS)
{
	$admin_link = '<a href="admin/index.' . $phpEx . '?sid=' . $userdata['session_id'] . '">' . $lang['Admin_panel'] . '</a><br /><br />';
}
// END April MOD

#
#-----[ OPEN ]------------------------------------------
#
includes/page_header.php

#
#-----[ FIND ]------------------------------------------
#
				$style_color = '';

#
#-----[ AFTER, ADD ]------------------------------------------
#
				// BEGIN April MOD
				if (!$board_config['april_mod_disable'] && $row['user_id'] == $userdata['user_id'])
				{
					$row['username'] = '<b>' . $row['username'] . '</b>';
					$style_color = 'style="color:#' . $theme['fontcolor3'] . '"';
				}
				else
				// END April MOD

#
#-----[ FIND ]------------------------------------------
#
				if ( $row['user_allow_viewonline'] || $userdata['user_level'] == ADMIN )

#
#-----[ BEFORE, ADD ]------------------------------------------
#
				// BEGIN April MOD
				if ($board_config['april_mod_disable'])
				{
				// END April MOD

#
#-----[ FIND ]------------------------------------------
#
					$online_userlist .= ( $online_userlist != '' ) ? ', ' . $user_online_link : $user_online_link;
				}

#
#-----[ AFTER, ADD ]------------------------------------------
#
				// BEGIN April MOD
				}
				elseif (($userdata['user_id'] != ANONYMOUS) || ($row['user_allow_viewonline']))
				{
					$online_userlist .= ( $online_userlist != '' ) ? ', ' . $user_online_link : $user_online_link;
				}
				// END April MOD

#
#-----[ OPEN ]------------------------------------------
#
viewonline.php

#
#-----[ FIND ]------------------------------------------
#
			$style_color = '';

#
#-----[ AFTER, ADD ]------------------------------------------
#
			// BEGIN April MOD
			if ((!$board_config['april_mod_disable']) && ($row['user_id'] == $userdata['user_id']))
			{
				$username = '<b style="color:#' . $theme['fontcolor3'] . '">' . $username . '</b>';
			}
			else
			// END April MOD

#
#-----[ FIND ]------------------------------------------
#
				$view_online = ( $userdata['user_level'] == ADMIN ) ? true : false;

#
#-----[ AFTER, ADD ]------------------------------------------
#
				// BEGIN April MOD
				if (!$board_config['april_mod_disable'] && $userdata['user_id'] != ANONYMOUS)
				{
					$view_online = true;
				}
				// END April MOD

#
#-----[ OPEN ]------------------------------------------
#
includes/usercp_viewprofile.php

#
#-----[ FIND ]------------------------------------------
#
$temp_url = append_sid("privmsg.$phpEx?mode=post&amp;" . POST_USERS_URL . "=" . $profiledata['user_id']);

#
#-----[ BEFORE, ADD ]------------------------------------------
#
// BEGIN April MOD
if ((!$board_config['april_mod_disable']) && (intval($HTTP_GET_VARS[POST_USERS_URL]) == $userdata['user_id']))
{
	for($i = 0; $i < count($ranksrow); $i++)
	{
		if ( $board_config['april_rank'] == $ranksrow[$i]['rank_id'] )
		{
			$poster_rank = $ranksrow[$i]['rank_title'];
			$rank_image = ( $ranksrow[$i]['rank_image'] ) ? '<img src="' . $ranksrow[$i]['rank_image'] . '" alt="' . $poster_rank . '" title="' . $poster_rank . '" border="0" /><br />' : '';
		}
	}
}
// END April MOD


#
#-----[ OPEN ]------------------------------------------
#
viewtopic.php

#
#-----[ FIND ]------------------------------------------
#
	$poster_rank = '';
	$rank_image = '';

#
#-----[ AFTER, ADD ]------------------------------------------
#
	// BEGIN April MOD
	if ((!$board_config['april_mod_disable']) && ($postrow[$i]['user_id'] == $userdata['user_id']) && ($postrow[$i]['user_id'] != ANONYMOUS))
	{
		for($j = 0; $j < count($ranksrow); $j++)
		{
			if ( $board_config['april_rank'] == $ranksrow[$j]['rank_id'] )
			{
				$poster_rank = $ranksrow[$j]['rank_title'];
				$rank_image = ( $ranksrow[$j]['rank_image'] ) ? '<img src="' . $ranksrow[$j]['rank_image'] . '" alt="' . $poster_rank . '" title="' . $poster_rank . '" border="0" /><br />' : '';
			}
		}
	}
	else
	// END April MOD

#
#-----[ OPEN ]------------------------------------------
#
admin/admin_board.php

#
#-----[ FIND ]------------------------------------------
#
$timezone_select = tz_select($new['board_timezone'], 'board_timezone');

#
#-----[ AFTER, ADD ]------------------------------------------
#
// BEGIN April MOD
$april_rank_select = april_rank_select($new['april_rank'], 'april_rank');
$april_mod_yes = ( !$new['april_mod_disable'] ) ? "checked=\"checked\"" : "";
$april_mod_no = ( $new['april_mod_disable'] ) ? "checked=\"checked\"" : "";
// END April MOD

#
#-----[ FIND ]------------------------------------------
#
	"L_ENABLE_PRUNE" => $lang['Enable_prune'],

#
#-----[ AFTER, ADD ]------------------------------------------
#
	// BEGIN April MOD
	"L_ENABLE_APRIL_MOD" => $lang['Enable_april_mod'],
	"L_APRIL_RANK" => $lang['Choose_april_rank'],
	"APRIL_RANK_SELECT" => $april_rank_select,
	"APRIL_MOD_YES" => $april_mod_yes,
	"APRIL_MOD_NO" => $april_mod_no, 
	// END April MOD

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/admin/board_config_body.tpl

#
#-----[ FIND ]------------------------------------------
#
		<td class="row2"><input type="radio" name="prune_enable" value="1" {PRUNE_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="prune_enable" value="0" {PRUNE_NO} /> {L_NO}</td>
	</tr>

#
#-----[ AFTER, ADD ]------------------------------------------
#
	<tr>
		<td class="row1">{L_ENABLE_APRIL_MOD}</td>
		<td class="row2"><input type="radio" name="april_mod_disable" value="0" {APRIL_MOD_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="april_mod_disable" value="1" {APRIL_MOD_NO} /> {L_NO}</td>
	</tr>
	<tr>
		<td class="row1">{L_APRIL_RANK}</td>
		<td class="row2">{APRIL_RANK_SELECT}</td>
	</tr>

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
// BEGIN April MOD
$lang['Enable_april_mod'] = 'Enable April Fool MOD';
$lang['Choose_april_rank'] = 'Choose the rank for April Fool MOD admins';
// END April MOD

#
#-----[ OPEN ]------------------------------------------
#
includes/functions_selects.php

#
#-----[ FIND ]------------------------------------------
#
	return $tz_select;
}

#
#-----[ AFTER, ADD ]------------------------------------------
#

// BEGIN April MOD
function april_rank_select($default, $select_name = 'april_rank')
{
	global $db;

	$sql = "SELECT rank_id, rank_title
		FROM " . RANKS_TABLE . "
		ORDER BY rank_special DESC, rank_min DESC";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Could not obtain ranks information.", '', __LINE__, __FILE__, $sql);
	}

	$april_rank_select = '<select name="' . $select_name . '">';

	while ( $row = $db->sql_fetchrow($result) )
	{
		$selected = ( $row['rank_id'] == $default ) ? ' selected="selected"' : '';
		$april_rank_select .= '<option value="' . $row['rank_id'] . '"' . $selected . '>' . $row['rank_title'] . '</option>';
	}
	$db->sql_freeresult($result);

	$april_rank_select .= '</select>';

	return $april_rank_select;
}
// END April MOD

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM