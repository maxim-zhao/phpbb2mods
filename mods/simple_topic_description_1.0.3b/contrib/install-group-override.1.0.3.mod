##############################################################
## MOD Title: Simple Topic Description - Group Override Add-on 
## MOD Author: dvandersluis < daniel@codexed.com > (Daniel Vandersluis) http://www.codexed.com
## MOD Description: Allows admins to explicitly allow or disallow certain user groups
## 		permission to add topic descriptions. 
## MOD Version: 1.0.3
##
## Installation Level: Easy
## Installation Time: ~5-10 Minutes
## Files To Edit: 7
##		admin/admin_boards.php
##		admin/admin_groups.php
##		includes/constants.php
##		includes/functions.php
##		language/lang_english/lang_admin.php
##		templates/subSilver/admin/board_config_body.tpl
##		templates/subSilver/admin/group_edit_body.tpl
## Included Files: N/A
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
##		By default, no user group is explicitly allowed or
##		disallowed access, but default to the board setting.
##		If the permissions add-on is not installed, the
##		default is an implicit 'allowed'.
##
##		To remove an explicit allow/disallow, just reset
##		that group back to Default in the Group Management
##		section of the ACP.
##
##		There is a precidence hierarchy here in terms of
##		determining whether or not a user can add a topic
##		description (higher in the list has higher
##		precedence): 
##		User has permission (if explicitly specified)
##		Group has permission (if explicitly specified)
##		User type has permission
##		Obviously, modules that are not installed are skipped.
##
##		Since users can be a member of more than one group,
##		and each of those groups can have it's own setting,
##		the Admin can choose how to deal with this. In both
##		methods, groups with Default permission are ignored:
##		* Permission only if all groups the user is a member
##		  of have permission. (AND mode)
##		* Permission if any of the groups the user is a
##		  member of has permission (OR mode)
##
##############################################################
## MOD History:
##
##	 2006-04-28 - Version 1.0.3
##		- Fixed bug where being a member of zero groups
##			would result in PHP warnings.
##
##	 2006-04-26 - Version 1.0.2
##		- Removed dependence on SQL aggregate_functions
##		- Allowed Admins, via the ACP, to choose whether
##			to deal with multiple groups with an AND or
##			an OR (see author notes).
##
##	 2006-04-25 - Version 1.0.1
##		- Fixed some bugs
##		- Inserted missing code into MOD (fixing a SQL error)
##
##   2006-04-24 - Version 1.0.0
##      - First version
##		- submitted to MODs database at phpBB.com
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ SQL ]------------------------------------------
#
ALTER TABLE `phpbb_groups` ADD `group_has_td_auth` TINYINT( 1 ) NULL DEFAULT NULL ;

#
#-----[ SQL ]------------------------------------------
#
INSERT INTO `phpbb_config` (`config_name`, `config_value`) VALUES ('td_group_combine_method', 'AND');

#
#-----[ OPEN ]-----------------------------------------
#
admin/admin_board.php

#
#-----[ FIND ]-----------------------------------------
#
$smtp_no = ( !$new['smtp_delivery'] ) ? "checked=\"checked\"" : "";

#
#-----[ AFTER, ADD ]-----------------------------------
#


// +Simple Topic Description + Group Override
$group_method_and = ( $new['td_group_combine_method'] == TD_GROUP_COMBINE_AND ) ? "checked=\"checked\"" : "";
$group_method_or = ( $new['td_group_combine_method'] == TD_GROUP_COMBINE_OR ) ? "checked=\"checked\"" : "";
// -Simple Topic Description

#
#-----[ FIND ]-----------------------------------------
#
	"S_CONFIG_ACTION" => append_sid("admin_board.$phpEx"),

#
#-----[ AFTER, ADD ]-----------------------------------
#
	// +Simple Topic Description + Group Override
	"L_TD_GROUP_COMBINE" => $lang['Topic_Description_group_combine'],
	"L_TD_GROUP_COMBINE_EXPLAIN" => $lang['Topic_Description_group_combine_explain'],
	"L_AND" => $lang['And'],
	"L_OR" => $lang['Or'],
	"S_TD_GROUP_NAME" => 'td_group_combine_method',
	"S_TD_GROUP_AND_VALUE" => TD_GROUP_COMBINE_AND,
	"S_TD_GROUP_OR_VALUE" => TD_GROUP_COMBINE_OR,
	"S_AND_SELECTED" => $group_method_and,
	"S_OR_SELECTED" => $group_method_or,
	// -Simple Topic Description
#
#-----[ OPEN ]-----------------------------------------
#
admin/admin_groups.php

#
#-----[ FIND ]-----------------------------------------
#
			'group_type' => GROUP_OPEN);

#
#-----[ REPLACE WITH ]---------------------------------
#
			// +Simple Topic Description + Group Override
			// -delete
			// 'group_type' => GROUP_OPEN);
			// -add
			'group_type' => GROUP_OPEN,
			'group_has_td_auth' => NULL);
			// -Simple Topic Description

#
#-----[ FIND ]-----------------------------------------
#
	$group_hidden = ( $group_info['group_type'] == GROUP_HIDDEN ) ? ' checked="checked"' : '';

#
#-----[ AFTER, ADD ]-----------------------------------
#


	// +Simple Topic Description + Group Override
	$group_td_auth = (!is_null($group_info['group_has_td_auth']) && intval($group_info['group_has_td_auth']) >= 0
		? intval($group_info['group_has_td_auth']) : NULL);
	// -Simple Topic Description

#
#-----[ FIND ]-----------------------------------------
#
		'L_GROUP_MODERATOR' => $lang['group_moderator'], 

#
#-----[ AFTER, ADD ]-----------------------------------
#
		// +Simple Topic Description + Group Override
		'L_GROUP_TD_AUTH' => $lang['Topic_Description_group_auth'],
		'L_GROUP_TD_EXPLAIN' => $lang['Topic_Description_group_explain'],
		// -Simple Topic Description

#
#-----[ FIND ]-----------------------------------------
#
		'L_YES' => $lang['Yes'],

#
#-----[ AFTER, ADD ]-----------------------------------
#
		// +Simple Topic Description + Group Override
		'L_NO' => $lang['No'],
		'L_DEFAULT' => $lang['Default_group'],
		// -Simple Topic Description

#
#-----[ FIND ]-----------------------------------------
#
		'S_GROUP_HIDDEN_CHECKED' => $group_hidden,

#
#-----[ AFTER, ADD ]-----------------------------------
#


		// +Simple Topic Description + Group Override
		'GROUP_AUTH_DEFAULT' => ($group_td_auth !== 1 && $group_td_auth !== 0) ? 'checked="checked"' : '',
		'GROUP_AUTH_YES' => ($group_td_auth === 1) ? 'checked="checked"' : '',
		'GROUP_AUTH_NO' => ($group_td_auth === 0) ? 'checked="checked"' : '',
		// -Simple Topic Description

#
#-----[ FIND ]-----------------------------------------
#
         $delete_old_moderator = isset($HTTP_POST_VARS['delete_old_moderator']) ? true : false;

#
#-----[ AFTER, ADD ]-----------------------------------
#


		// +Simple Topic Description + Group Override
		$group_td_auth = (isset($HTTP_POST_VARS['group_td_auth']) && intval($HTTP_POST_VARS['group_td_auth'])) >= 0
			? intval($HTTP_POST_VARS['group_td_auth']) : NULL;
		// -Simple Topic Description

#
#-----[ FIND ]-----------------------------------------
#
# Partial Find
			$sql = "UPDATE " . GROUPS_TABLE . "

#
#-----[ BEFORE, ADD ]----------------------------------
#
			// +Simple Topic Description + Group Override
			$group_td_auth = (intval($group_td_auth) === 0 || intval($group_td_auth) === 1 ? intval($group_td_auth) : 'NULL');
			// -add after: group_moderator = $group_moderator
			// , group_has_td_auth = $group_td_auth
			// -Simple Topic Description
#
#-----[ FIND ]-------
#
SET group_type = $group_type

#
#-----[ IN-LINE FIND ]----------------------------------
#
group_moderator = $group_moderator

#
#-----[ IN-LINE AFTER, ADD ]----------------------------
#
, group_has_td_auth = $group_td_auth

#
#-----[ FIND ]-----------------------------------------
#
			$sql = "INSERT INTO " . GROUPS_TABLE . "
				(

#
#-----[ BEFORE, ADD ]----------------------------------
#
			// +Simple Topic Description + Group Override
			$group_td_auth = (intval($group_td_auth) === 0 || intval($group_td_auth) === 1 ? intval($group_td_auth) : 'NULL');
			// -add after: group_moderator
			// , group_has_td_auth
			// -add after: $group_moderator,
			// , $group_td_auth
			// -Simple Topic Description
#
#-----[ IN-LINE FIND ]----------------------------------
#
group_moderator

#
#-----[ IN-LINE AFTER, ADD ]----------------------------
#
, group_has_td_auth

#
#-----[ FIND ]------
#
VALUES (

#
#-----[ IN-LINE FIND ]----------------------------------
#
$group_moderator

#
#-----[ IN-LINE AFTER, ADD ]----------------------------
#
, $group_td_auth

#
#-----[ OPEN ]------------------------------------------
#
includes/constants.php

#
#-----[ FIND ]------------------------------------------
#
?>

#
#-----[ BEFORE, ADD ]-----------------------------------
#
// +Simple Topic Description + Group Override
define('TD_GROUP_COMBINE_AND', "AND");
define('TD_GROUP_COMBINE_OR', "OR");
// -Simple Topic Description

#
#-----[ OPEN ]------------------------------------------
#
includes/functions.php

#
#-----[ FIND ]------------------------------------------
#
// +Simple Topic Description
function user_has_td_auth($userdata)
{

#
#-----[ IN-LINE FIND ]----------------------------------
#
// +Simple Topic Description

#
#-----[ IN-LINE AFTER, ADD ]----------------------------
#
 + Group Override
	
#
#-----[ AFTER, ADD ]------------------------------------
#
	global $db;

#
#-----[ FIND ]------------------------------------------
#
	// 2. Group Override (ignored if default)

#
#-----[ AFTER, ADD ]------------------------------------
# 
	// Check if explictly specified at a group level
	// If the user is a member of multiple groups, 'AND' the results together, as if Yes is TRUE and No is FALSE
	// (ie. if any groups are no, the user is not authenticated)
	$sql = "SELECT g.group_has_td_auth AS auth
		FROM " . GROUPS_TABLE . " AS g
		JOIN " . USER_GROUP_TABLE . " AS ug
			ON ug.group_id = g.group_id
		WHERE ug.user_id = {$userdata['user_id']}
			AND g.group_single_user = 0
			AND NOT g.group_has_td_auth IS NULL";

	if (!($result = $db->sql_query($sql))) return false;
	if ($db->sql_numrows($result) > 0 && !($rows = $db->sql_fetchrowset($result))) return false;

	if ( count($rows > 0) )
	{
		$rows = array_map(create_function('$r', 'return $r["auth"];'), $rows);

		if ($board_config['td_group_combine_method'] == TD_GROUP_COMBINE_AND)
		{
			$res = array_reduce($rows, create_function('$v, $w', 'return $v && $w;'), true);
		}
		elseif ($board_config['td_group_combine_method'] == TD_GROUP_COMBINE_OR)
		{
			$res = array_reduce($rows, create_function('$v, $w', 'return $v || $w;'), false);
		}
		else message_die(GENERAL_ERROR, 'Invalid value for config value td_group_combine_method', '', __LINE__, __FILE__);

		if ($res == 1) return true;
		elseif ($res == 0) return false;
	}

#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_admin.php

#
#-----[ FIND ]------------------------------------------
#
//
// That's all Folks!
// -------------------------------------------------

#
#-----[ BEFORE, ADD ]-----------------------------------
#
// +Simple Topic Description + Group Override
$lang['Topic_Description_group_auth'] = "Group authorized to add topic descriptions?";
$lang['Topic_Description_group_explain'] = "Explicitly set this to Yes or No if you want to allow or disallow authorization "
	. "at this level. If you leave this set to Default, this level will be ignored when determining if a user has the needed "
	. "authorization.";
$lang['Default_group'] = "Default";
$lang['Topic_Description_group_combine'] = "Multiple group topic description permission determination method";
$lang['Topic_Description_group_combine_explain'] = "Since users can be a member of more than one user group, we have to decide "
	. "how to handle the case when more than one group he is a member of has permission explicitly allowed or disallowed:<br />"
	. "And mode means that he will only get permission if all groups he is a member of have permission.<br />"
	. "Or mode means that he will get permission if any groups he is a member of have permission.<br />"
	. "Note: In all cases, groups set to Default mode are ignored for these purposes.";
$lang['And'] = "And";
$lang['Or'] = "Or";
// -Simple Topic Description

#
#-----[ OPEN ]-----------------------------------------
#
templates/subSilver/admin/board_config_body.tpl

#
#-----[ FIND ]-----------------------------------------
#
	<tr>
		<td class="row1">{L_MAX_POLL_OPTIONS}</td>
		<td class="row2"><input class="post" type="text" name="max_poll_options" size="4" maxlength="4" value="{MAX_POLL_OPTIONS}" /></td>
	</tr>

#
#-----[ BEFORE, ADD ]----------------------------------
#
	<!-- +Simple Topic Description + Group Override -->
	<tr>
		<td class="row1">
			{L_TD_GROUP_COMBINE}<br />
			<span class="gensmall">{L_TD_GROUP_COMBINE_EXPLAIN}</span>
		</td>
		<td class="row2">
			<input type="radio" name="{S_TD_GROUP_NAME}" value="{S_TD_GROUP_AND_VALUE}" {S_AND_SELECTED}>{L_AND}
			<input type="radio" name="{S_TD_GROUP_NAME}" value="{S_TD_GROUP_OR_VALUE}" {S_OR_SELECTED}>{L_OR}
		</td>
	</tr>
	<!-- -Simple Topic Description -->
#
#-----[ OPEN ]-----------------------------------------
#
templates/subSilver/admin/group_edit_body.tpl

#
#-----[ FIND ]-----------------------------------------
#
	<tr> 
	  <td class="row1" width="38%"><span class="gen">{L_GROUP_STATUS}:</span></td>

#
#-----[ FIND ]----------
#
</tr>

#
#-----[ AFTER, ADD ]-----------------------------------
#
	<!-- +Simple Topic Description + Group Override -->
	<tr>
		<td class="row1" width="38%">
			<span class="gen">{L_GROUP_TD_AUTH}<br />{L_GROUP_TD_EXPLAIN}</span>
		</td>
		<td class="row2" width="62%">
			<input type="radio" id="td_auth_def" name="group_td_auth" value="-1" {GROUP_AUTH_DEFAULT} />
			<label for="td_auth_def"> {L_DEFAULT} &nbsp;&nbsp;</label>
			<input type="radio" id="td_auth_yes" name="group_td_auth" value="1" {GROUP_AUTH_YES} />
			<label for="td_auth_yes"> {L_YES} &nbsp;&nbsp;</label>
			<input type="radio" id="td_auth_no" name="group_td_auth" value="0" {GROUP_AUTH_NO} />
			<label for="td_auth_no"> {L_NO}</label>
		</td>
	</tr>
	<!-- -Simple Topic Description -->
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
