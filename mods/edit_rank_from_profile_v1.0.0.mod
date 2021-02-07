##############################################################
## MOD Title: Edit Rank in Profile
## MOD Author: DualFusion < yusuka_madik@yahoo.com > (Kevin Martin) http://dualfusion.freehostia.com
## MOD Author: afterlife_69 < afterlife_60@hotmail.com > (Dean Newman) http://www.gamerzvault.com
## MOD Description: Allows the admin to edit a users rank while viewing their profile
## MOD Version: 1.0.0
## 
## Installation Level: Easy
## Installation Time: 6 minutes
## Files To Edit: includes/usercp_viewprofile.php
##	language/lang_english/lang_main.php
##	templates/subSilver/profile_view_body.tpl
## Included Files: 
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2
## Generator: Phpbb.ModTeam.Tools
##############################################################
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/
##############################################################
## Author Notes: This MOD was taken over from afterlife_69's original MOD
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################

#
#-----[ OPEN ]------------------------------------------
#
includes/usercp_viewprofile.php
#
#-----[ FIND ]------------------------------------------
#
//
// Output page header and profile_view template
#
#-----[ AFTER, ADD ]------------------------------------------
#

//
// BEGIN Edit rank From Profile
//
if( $userdata['user_level'] == ADMIN )
{
	if ( isset( $HTTP_GET_VARS['change_rank'] ) )
	{
		// Secure the coding to prevent SQL Injection.
		$new_rank = intval($HTTP_POST_VARS['user_rank']);

		$sql = "UPDATE ". USERS_TABLE ." SET user_rank = " . $new_rank . " WHERE user_id = " . $profiledata['user_id'] . "";
		if( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Couldn't update user rank", "Database Error", __LINE__, __FILE__, $sql);
		}
    	redirect(append_sid("profile.$phpEx?mode=viewprofile&" . POST_USERS_URL . "={$profiledata['user_id']}",true));
	}
	
	$sql = "SELECT * FROM " . RANKS_TABLE . "
	   WHERE rank_special = 1
	   ORDER BY rank_title";
	if ( !($result = $db->sql_query($sql)) )
	{
	   message_die(GENERAL_ERROR, 'No_data', '', __LINE__, __FILE__, $sql);
	}
	$rank_select_box = '<option value="0">' . $lang['No_assigned_rank'] . '</option>';
	while( $row = $db->sql_fetchrow($result) )
	{
		$rank = $row['rank_title'];
		$rank_id = $row['rank_id'];

		$selected = ( $profiledata['user_rank'] == $rank_id ) ? ' selected="selected"' : '';
		$rank_select_box .= '<option value="' . $rank_id . '"' . $selected . '>' . $rank . '</option>';
	}
	$template->assign_block_vars('switch_is_admin', array());
}
//
// END Edit rank From Profile
//
#
#-----[ FIND ]------------------------------------------
#
$template->assign_vars(array(
#
#-----[ AFTER, ADD ]------------------------------------------
#
//
// BEGIN Edit rank From Profile
//
'RANK_SELECT_BOX' => $rank_select_box,
'L_UPDATE_RANKS' => $lang['update_ranks_title'],
'L_SET_RANK' => $lang['update_ranks_set'],
'U_UPDATE_RANK' => append_sid("profile." . $phpEx . "?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $profiledata['user_id'] . "&change_rank=1"),
//
// END Edit rank From Profile
//

#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_main.php
#
#-----[ FIND ]------------------------------------------
#
//
// That's all, Folks!
#
#-----[ BEFORE, ADD ]------------------------------------------
#
//
// BEGIN Edit rank From Profile
//
$lang['update_ranks_title'] = 'Change rank';
$lang['update_ranks_set'] = 'Set rank';
$lang['No_data'] = 'Could not obtain ranks data';
$lang['No_assigned_rank'] = 'No special rank assigned';
//
// END Edit rank From Profile
//

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/profile_view_body.tpl
#
#-----[ FIND ]------------------------------------------
#
  <tr> 
	<td class="catLeft" align="center" height="28"><b><span class="gen">{L_CONTACT} {USERNAME} </span></b></td>
  </tr>
  <tr> 
	<td class="row1" valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="3">
#
#-----[ IN-LINE FIND ]------------------------------------------
#
class="row1"
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
 rowspan="3"
#
#-----[ FIND ]------------------------------------------
#
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
#
#-----[ BEFORE, ADD ]------------------------------------------
#
<!-- BEGIN switch_is_admin -->
	<tr>
		<td class="catRight"><b><span class="gen">{L_UPDATE_RANKS}</span></b></td>
	</tr>
	<tr>
		<td class="row1">
			<form action="{U_UPDATE_RANK}" method="post"><select name="user_rank">{RANK_SELECT_BOX}</select>
			<input type="submit" name="user_rank_update" class="mainoption" value="{L_SET_RANK}" /></form>
		</td>
	</tr>
<!-- END switch_is_admin -->
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
