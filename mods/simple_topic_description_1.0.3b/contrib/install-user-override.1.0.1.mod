##############################################################
## MOD Title: Simple Topic Description - User Override Add-On
## MOD Author: dvandersluis < daniel@codexed.com > (Daniel Vandersluis) http://www.codexed.com
## MOD Description: Allows admins to explicitly allow or disallow certain users permission
##		to add topic descriptions. 
## MOD Version: 1.0.1
##
## Installation Level: Easy
## Installation Time: ~5 Minutes
## Files To Edit: 4
##		admin/admin_users.php
##		includes/functions.php
##		language/lang_english/lang_admin.php
##		templates/subSilver/admin/user_edit_body.tpl
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
##		By default, no user is explicitly allowed or
##		disallowed access, but default to the board setting.
##		If the permissions add-on is not installed, the
##		default is an implicit 'allowed'.
##
##		To remove an explicit allow/disallow, just reset
##		that user back to Default in the User Management
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
##############################################################
## MOD History:
##
##	 2006-04-25 - Version 1.0.1
##		- Various MOD bugfixes
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
ALTER TABLE `phpbb_users` ADD `user_has_td_auth` TINYINT( 1 ) NULL DEFAULT NULL ;

#
#-----[ OPEN ]-----------------------------------------
#
admin/admin_users.php

#
#-----[ FIND ]-----------------------------------------
#
		$user_allowavatar = ( !empty($HTTP_POST_VARS['user_allowavatar']) ) ? intval( $HTTP_POST_VARS['user_allowavatar'] ) : 0;

#
#-----[ AFTER, ADD ]-----------------------------------
#
		// +Simple Topic Description + User Override
		$user_td_auth = ( isset($HTTP_POST_VARS['user_td_auth']) && intval($HTTP_POST_VARS['user_td_auth']) >= 0)
			? intval($HTTP_POST_VARS['user_td_auth']) : 'NULL';
		// -Simple Topic Description

#
#-----[ FIND ]-----------------------------------------
#
# Partial Find
			$sql = "UPDATE " . USERS_TABLE . "

#
#-----[ BEFORE, ADD ]----------------------------------
#
			// +Simple Topic Description + User Override
			// -add after: user_active = $user_status
			// , user_has_td_auth = $user_td_auth
			// -Simple Topic Description

#
#-----[ FIND ]------------------------------------------
#
user_active = $user_status,

#
#-----[ AFTER, ADD ]----------------------------
#
					user_has_td_auth = $user_td_auth,
#
#-----[ FIND ]-----------------------------------------
#
		$user_allowpm = $this_userdata['user_allow_pm'];

#
#-----[ AFTER, ADD ]-----------------------------------
#
		// +Simple Topic Description + User Override
		$user_td_auth = (!is_null($this_userdata['user_has_td_auth']) ? intval($this_userdata['user_has_td_auth']) : NULL);
		// -Simple Topic Description

#
#-----[ FIND ]-----------------------------------------
#
			'ALLOW_AVATAR_YES' => ($user_allowavatar) ? 'checked="checked"' : '',

#
#-----[ BEFORE, ADD ]----------------------------------
#
			// +Simple Topic Description + User Override
			'USER_AUTH_DEFAULT' => ($user_td_auth !== 1 && $user_td_auth !== 0) ? 'checked="checked"' : '',
			'USER_AUTH_YES' => ($user_td_auth === 1) ? 'checked="checked"' : '',
			'USER_AUTH_NO' => ($user_td_auth === 0) ? 'checked="checked"' : '',
			// -Simple Topic Description

#
#-----[ FIND ]-----------------------------------------
#
			'L_NO' => $lang['No'],

#
#-----[ AFTER, ADD ]-----------------------------------
#
			// +Simple Topic Description
			'L_DEFAULT' => $lang['Default_user'],
			// -Simple Topic Description

#
#-----[ FIND ]-----------------------------------------
#
			'L_ALLOW_AVATAR' => $lang['User_allowavatar'],

#
#-----[ BEFORE, ADD ]----------------------------------
#
			// +Simple Topic Description
			'L_USER_TD_AUTH' => $lang['Topic_Description_user_auth'],
			'L_USER_TD_EXPLAIN' => $lang['Topic_Description_user_explain'],
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
#-----[ IN-LINE FIND ]----------------------------------
#
// +Simple Topic Description

#
#-----[ IN-LINE AFTER, ADD ]----------------------------
#
 + User Override

#
#-----[ FIND ]-----------------------------------------
#
	// 1. User Override (ignored if default)

#
#-----[ AFTER, ADD ]-----------------------------------
#
	if (!is_null($userdata['user_has_td_auth']))
	{
		if ($userdata['user_has_td_auth'] == 1) return true;
		elseif ($userdata['user_has_td_auth'] == 0) return false;
	}
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
#-----[ BEFORE, ADD ]-----------------------------------
#
// +Simple Topic Description + User Override
$lang['Topic_Description_user_auth'] = "User authorized to add topic descriptions?";
$lang['Topic_Description_user_explain'] = "Explicitly set this to Yes or No if you want to allow or disallow authorization "
	. "at this level. If you leave this set to Default, this level will be ignored when determining if a user has the needed "
	. "authorization.";
$lang['Default_user'] = "Default";
// -Simple Topic Description

#
#-----[ OPEN ]-----------------------------------------
#
templates/subSilver/admin/user_edit_body.tpl

#
#-----[ FIND ]-----------------------------------------
#
	<tr> 
	  <td class="row1"><span class="gen">{L_ALLOW_AVATAR}</span></td>
	  <td class="row2"> 
		<input type="radio" name="user_allowavatar" value="1" {ALLOW_AVATAR_YES} />
		<span class="gen">{L_YES}</span>&nbsp;&nbsp; 
		<input type="radio" name="user_allowavatar" value="0" {ALLOW_AVATAR_NO} />
		<span class="gen">{L_NO}</span></td>
	</tr>

#
#-----[ AFTER, ADD ]-----------------------------------
#
	<!-- +Simple Topic Description + User Override -->
	<tr>
		<td class="row1">
			<span class="gen">{L_USER_TD_AUTH}<br />{L_USER_TD_EXPLAIN}</span>
		</td>
		<td class="row2">
			<input type="radio" name="user_td_auth" value="-1" {USER_AUTH_DEFAULT} />
			<span class="gen"> {L_DEFAULT} &nbsp;&nbsp;</span>
			<input type="radio" name="user_td_auth" value="1" {USER_AUTH_YES} />
			<span class="gen"> {L_YES} &nbsp;&nbsp;</span>
			<input type="radio" name="user_td_auth" value="0" {USER_AUTH_NO} />
			<span class="gen"> {L_NO}</span>
		</td>
	</tr>
	<!-- -Simple Topic Description -->
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
