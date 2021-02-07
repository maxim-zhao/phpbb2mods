##############################################################
## MOD Title: Simple Topic Description - Permissions Add-on 
## MOD Author: dvandersluis < daniel@codexed.com > (Daniel Vandersluis) http://www.codexed.com
## MOD Description: Adds the ability to specify what user level (Admin, Mod, Registered, All)
##		is allowed to add descriptions to topics. All users can still see them, regardless of
##		permission level set.
## MOD Version: 1.0.1
##
## Installation Level: Easy
## Installation Time: ~10 Minutes
## Files To Edit: 7 
##		admin/admin_board.php
##		includes/constants.php
##		includes/functions.php
##		includes/functions_selects.php
##		language/lang_english/lang_admin.php
##		language/lang_english/lang_main.php
##		templates/subSilver/admin/board_config_body.tpl
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
##		This add-on to Simple Topic Description allows for
##		the administrator to specify, via the ACP, the minimum
##		user level necessary to add topic description. From
##		lowest to highest, the levels are All Users,
##		Registered Users, Moderators, Administrators.
##		ie. Set to Registered Users; Moderators and
##		Administrators can also add descriptions.
##
##		This mod assumes that the base install has been
##		already done.
##
##############################################################
## MOD History:
##
##	 2006-04-25 - Version 1.0.1
##		- Fixed some bugs
##		- Added disabled status (Admins can now disable topic
##			descriptions completely)
##
##   2006-04-25 - Version 1.0.0
##      - First version
##		- submitted to MODs database at phpBB.com
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ SQL ]------------------------------------------
#
INSERT INTO `phpbb_config` (`config_name`, `config_value`) VALUES ('topic_description_auth', '3');

#
#-----[ OPEN ]-----------------------------------------
#
admin/admin_board.php

#
#-----[ FIND ]-----------------------------------------
#
$timezone_select = tz_select($new['board_timezone'], 'board_timezone');

#
#-----[ AFTER, ADD ]-----------------------------------
#
// +Simple Topic Description + Permissions
$auth_select = auth_select($new['topic_description_auth'], 'topic_description_auth');
// -Simple Topic Description

#
#-----[ FIND ]-----------------------------------------
#
	"S_CONFIG_ACTION" => append_sid("admin_board.$phpEx"),

#
#-----[ AFTER, ADD ]-----------------------------------
#
	// +Simple Topic Description + Permissions
	"L_TOPIC_DESC_AUTH" => $lang['Topic_Description_min_auth'],
	"AUTH_SELECT" => $auth_select,
	// -Simple Topic Description
#
#-----[ OPEN ]-----------------------------------------
#
includes/constants.php

#
#-----[ FIND ]-----------------------------------------
#
?>

#
#-----[ BEFORE, ADD ]----------------------------------
#
// +Simple Topic Description + Permissions
define('TOPIC_DESC_AUTH_NONE', -1);
define('TOPIC_DESC_AUTH_ALL', 0);
define('TOPIC_DESC_AUTH_REG', 1);
define('TOPIC_DESC_AUTH_MOD', 2);
define('TOPIC_DESC_AUTH_ADMIN', 3);
// -Simple Topic Description

#
#-----[ OPEN ]-----------------------------------------
#
includes/functions.php

#
#-----[ FIND ]-----------------------------------------
#
// +Simple Topic Description
function user_has_td_auth($userdata)

#
#-----[ IN-LINE FIND ]---------------------------------
#
// +Simple Topic Description

#
#-----[ IN-LINE AFTER, ADD ]---------------------------
#
 + Permissions

#
#-----[ FIND ]-----------------------------------------
#
{

#
#-----[ AFTER, ADD ]-----------------------------------
#
	global $board_config;

#
#-----[ FIND ]-----------------------------------------
#
	// 3. User Level

#
#-----[ AFTER, ADD ]-----------------------------------
#
	// Compare user level against required level
	$level = $userdata['user_level'];
	
	$auth = array();
	$auth['Admin'] = ($level == ADMIN) ? true : false;
	$auth['Mod'] = ($level == ADMIN || $level == MOD) ? true : false;
	$auth['Reg'] = ($level == ADMIN || $level == MOD || $userdata['user_id'] > 1) ? true : false;
	$auth['All'] = true;

	if ($board_config['topic_description_auth'] == TOPIC_DESC_AUTH_NONE) return false;
	elseif ($board_config['topic_description_auth'] == TOPIC_DESC_AUTH_ADMIN && $auth['Admin']) return true;
	elseif ($board_config['topic_description_auth'] == TOPIC_DESC_AUTH_MOD && $auth['Mod']) return true;
	elseif ($board_config['topic_description_auth'] == TOPIC_DESC_AUTH_REG && $auth['Reg']) return true;
	elseif ($board_config['topic_description_auth'] == TOPIC_DESC_AUTH_ALL && $auth['All']) return true;
	else return false;

#
#-----[ OPEN ]-----------------------------------------
#
includes/functions_selects.php

#
#-----[ FIND ]-----------------------------------------
#
?>

#
#-----[ BEFORE, ADD ]----------------------------------
#
// +Simple Topic Description + Permissions
function auth_select($default, $select_name = 'auth')
{
	global $lang;

	if ( !isset($default) )
	{
		$default = 0;
	}

	$auth_select = '<select name="' . $select_name . '">';

	while ( list($value, $auth_level) = @each($lang['auth']) )
	{
		$selected = ( $value == $default ) ? ' selected="selected"' : '';
		$auth_select .= '<option value="' . $value . '"' . $selected . '>' . $auth_level . '</option>';
	}

	$auth_select .= '</select>';
	return $auth_select;
}
// -Simple Topic Description

#
#-----[ OPEN ]-----------------------------------------
#
language/lang_english/lang_admin.php

#
#-----[ FIND ]-----------------------------------------
#
//
// That's all Folks!
// -------------------------------------------------

#
#-----[ BEFORE, ADD ]----------------------------------
#
// +Simple Topic Description + Permissions
$lang['Topic_Description_min_auth'] = "Min authorization level needed to create topic descriptions";
// -Simple Topic Description

#
#-----[ OPEN ]-----------------------------------------
#
language/lang_english/lang_main.php

#
#-----[ FIND ]-----------------------------------------
#
$lang['datetime']['Dec'] = 'Dec';

#
#-----[ AFTER, ADD ]-----------------------------------
#


// +Simple Topic Description + Permissions
// Values for the auth select box 
$lang['auth'][TOPIC_DESC_AUTH_NONE] = 'Disabled';
$lang['auth'][TOPIC_DESC_AUTH_ALL] = 'All Users';
$lang['auth'][TOPIC_DESC_AUTH_REG] = 'Registered Users';
$lang['auth'][TOPIC_DESC_AUTH_MOD] = 'Moderators';
$lang['auth'][TOPIC_DESC_AUTH_ADMIN] = 'Administrators';
// -Simple Topic Description

#
#-----[ OPEN ]-----------------------------------------
#
templates/subSilver/admin/board_config_body.tpl

#
#-----[ FIND ]-----------------------------------------
#
	<tr>
	  <th class="thHead" colspan="2">{L_ABILITIES_SETTINGS}</th>
	</tr>

#
#-----[ AFTER, ADD ]-----------------------------------
#
	<!-- +Simple Topic Description + Permissions -->
	<tr>
		<td class="row1">{L_TOPIC_DESC_AUTH}</td>
		<td class="row2">
			{AUTH_SELECT}
		</td>
	</tr>
	<!-- -Simple Topic Description -->
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
