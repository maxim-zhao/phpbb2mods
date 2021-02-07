##############################################################
## MOD Title: Group Membership (Viewprofile)
## MOD Author: kkroo < princeomz2004@hotmail.com > ( Omar Ramadan ) http://phpbb-login.strangled.net
## MOD Author: Afterlife(69) < afterlife_69@hotmail.com > ( Dean Newman ) http://www.ugboards.com
## MOD Description: This will backport the 'Group Membership' feature when viewing profiles from Olympus to phpBB2
## MOD Version: 1.0.0
##
## Installation Level: Easy
## Installation Time: 5 Minutes
## Files To Edit:	includes/usercp_viewprofile.php
##					language/lang_english/lang_main.php
##					templates/subSilver/profile_view_body.tpl
## Included Files: (n/a)
##
## License: http://opensource.org/licenses/gpl-license.php GNU Public License v2 
##############################################################
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/
##############################################################
## Author Notes: 
##	I love ripping Olympus features to phpBB 2.0.X :)
##############################################################
## MOD History:
##
##	2006-03-27 - Version 1.0.0
##		- Fixed the query to actualy select groups instead of the single user groups thingys. :P
##		- Added a form close tag (</form>) to template.
##		- Hidden groups now show for the member and staff.
##
##	2006-03-24 - Version 0.1.0
##		- It works!
## 
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#----[ OPEN ]---------------------
#
includes/usercp_viewprofile.php

#
#----[ FIND ]---------------------
#
#	Partial Search
#
$search = '<a href="' . $temp_url . '">'

#
#----[ AFTER, ADD ]---------------
#
$groupdata = array();
$sql = "SELECT g.group_id, g.group_name, g.group_type
	FROM " . GROUPS_TABLE . " g, " . USER_GROUP_TABLE . " ug
		WHERE ug.user_id = {$profiledata['user_id']}
			AND g.group_id = ug.group_id 
				AND g.group_single_user <> " . TRUE . "
					ORDER BY g.group_name, g.group_id";
if ( !$result = $db->sql_query($sql) )
{
	message_die(GENERAL_ERROR, 'Could not group membership information', '', __LINE__, __FILE__, $sql);
}
while($row = $db->sql_fetchrow($result))
{
	$groupdata[] = $row;
}
$db->sql_freeresult($result);
$group_options = '';
for($i = 0; $i < sizeof($groupdata); $i++)
{
	if($groupdata[$i]['group_type'] != GROUP_HIDDEN || $userdata['user_id'] == $profiledata['user_id'] || $userdata['user_level'] != USER )
	{
		$group_options .= '<option value="' . $groupdata[$i]['group_id'] . '">' . $groupdata[$i]['group_name'] . '</option>';
	}
}
if(!$group_options)
{
		$group_options .= '<option value="">' . $lang['no_group_membership'] . '</option>';
}
$group_dropdown = '<select name="' . POST_GROUPS_URL . '">' . $group_options . '</select>';
unset($group_options);
unset($groupdata);

#
#----[ FIND ]---------------------
#
'L_INTERESTS' => $lang['Interests'],

#
#----[ AFTER, ADD ]---------------------
#
	'L_GROUP_MEMBERSHIP' => $lang['Group_membership'],
	'L_GROUP_GO' => $lang['Go'],
	'GROUP_DROPDOWN' => $group_dropdown,

#
#----[ OPEN ]---------------------
#
language/lang_english/lang_main.php

#
#----[ FIND ]---------------------
#
?>

#
#----[ BEFORE, ADD ]---------------------
#
$lang['no_group_membership'] = 'This user is not a member of any groups.';

#
#----[ OPEN ]---------------------
#
templates/subSilver/profile_view_body.tpl

#
#----[ FIND ]---------------------
#
		  <td> <b><span class="gen">{INTERESTS}</span></b></td>
		</tr>

#
#----[ AFTER, ADD ]---------------------
#
		<tr> 
		  <td valign="top" align="right" nowrap="nowrap"><span class="gen">{L_GROUP_MEMBERSHIP}:</span></td>
		  <td>
			<span class="gen">
				<form action="{U_GROUP_CP}" method="GET">
				{GROUP_DROPDOWN}
				<input type="submit" value="{L_GROUP_GO}" class="mainoption" />
				</form>
			</span>
		  </td>
		</tr>

#
#----[ SAVE/CLOSE ALL FILES ]-----
#
# EoM