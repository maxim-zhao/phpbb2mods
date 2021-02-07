##############################################################
## MOD Title: Memberlist Access
## MOD Author: Joe Belmaati < belmaati@gmail.com > (Joe Belmaati) N/A
## MOD Description: With this MOD admin can decide who gets to view the
## memberlist. Options include: All, registered users, moderators,
## admins. Options are settable from the ACP.
##
## MOD Version: 1.0.3
##
## Installation Level: Easy
## Installation Time: 15 Minutes
## Files To Edit:	(7)
##				memberlist.php
##				includes/constants.php
##				includes/page_header.php
##				language/lang_english/lang_admin.php
##				admin/admin_board.php
##				templates/subSilver/admin/board_config_body.tpl
##				templates/subSilver/overall_header.tpl
##
## Included Files:  (1)
##				install/db_update.php
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
## If you don't have access to phpMyAdmin or Easy MOD you can
## use the included db_update.php file in the install directory.
## Upload the install directory to your phpbb root folder. Call
## the db_update.php file in your browser, i.e.
## www.mysite.com/forum/install/db_update.php -
## then delete the install directory from your server.
##############################################################
## MOD History:
##
##   2006-01-11 - 1.0.3
##      - 	      Re-submitted to MODS database at phpbb.com
##
##   2005-07-27 - 1.0.2
##      - 	      Re-submitted to MODS database at phpbb.com
##
##   2005-05-21 - 1.0.1
##      - 	      Re-submitted to MODS database at phpbb.com
##
##   2005-05-21 - 1.0.0
##      - 	      Submitted to MODS database at phpbb.com
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################
#
#-----[ SQL ]------------------------------------------
#
INSERT INTO `phpbb_config` ( `config_name` , `config_value` ) VALUES ( 'memberlist_access', '0' );
#
#-----[ OPEN ]------------------------------------------
#
memberlist.php
#
#-----[ FIND ]------------------------------------------
#
//
// End session management
//
#
#-----[ AFTER, ADD ]------------------------------------------
#

//
// Make sure that user is authorized to view the memberlist
//
if( $board_config['memberlist_access'] == MEMBERLIST_ACCESS_ADMIN && $userdata['user_level'] != ADMIN )
{
	message_die(GENERAL_MESSAGE, $lang['Not_Authorised']);
}
else if ( $board_config['memberlist_access'] == MEMBERLIST_ACCESS_MOD && ( $userdata['user_level'] != MOD && $userdata['user_level'] != ADMIN ) )
{
	message_die(GENERAL_MESSAGE, $lang['Not_Authorised']);
}
else if( $board_config['memberlist_access'] == MEMBERLIST_ACCESS_REG && !$userdata['session_logged_in'] )
{
	message_die(GENERAL_MESSAGE, $lang['Not_Authorised']);
}
#
#-----[ OPEN ]------------------------------------------
#
includes/constants.php
#
#-----[ FIND ]------------------------------------------
#

// Table names
#
#-----[ BEFORE, ADD ]------------------------------------------
#
// Memberlist access
define('MEMBERLIST_ACCESS_ALL', 0);
define('MEMBERLIST_ACCESS_REG', 1);
define('MEMBERLIST_ACCESS_MOD', 2);
define('MEMBERLIST_ACCESS_ADMIN', 3);
#
#-----[ OPEN ]------------------------------------------
#
includes/page_header.php
#
#-----[ FIND ]------------------------------------------
#
//
// Generate HTML required for Mozilla Navigation bar
//
#
#-----[ BEFORE, ADD ]------------------------------------------
#
// Only show memberlist link to authorized users
if( $board_config['memberlist_access'] == MEMBERLIST_ACCESS_ADMIN && $userdata['user_level'] == ADMIN )
{
	$template->assign_block_vars('switch_memberlist', array());
}
else if ( $board_config['memberlist_access'] == MEMBERLIST_ACCESS_MOD && ( $userdata['user_level'] == MOD || $userdata['user_level'] == ADMIN ) )
{
	$template->assign_block_vars('switch_memberlist', array());
}
else if( $board_config['memberlist_access'] == MEMBERLIST_ACCESS_REG && $userdata['session_logged_in'] )
{
	$template->assign_block_vars('switch_memberlist', array());
}
else if( $board_config['memberlist_access'] == MEMBERLIST_ACCESS_ALL )
{
	$template->assign_block_vars('switch_memberlist', array());
}
#
#-----[ OPEN ]------------------------------------------
#
admin/admin_board.php
#
#-----[ FIND ]------------------------------------------
#
$namechange_no = ( !$new['allow_namechange'] ) ? "checked=\"checked\"" : "";
#
#-----[ AFTER, ADD ]------------------------------------------
#
$memberlist_access_all = ( $new['memberlist_access'] == MEMBERLIST_ACCESS_ALL ) ? "checked=\"checked\"" : "";
$memberlist_access_reg = ( $new['memberlist_access'] == MEMBERLIST_ACCESS_REG ) ? "checked=\"checked\"" : "";
$memberlist_access_mod = ( $new['memberlist_access'] == MEMBERLIST_ACCESS_MOD ) ? "checked=\"checked\"" : "";
$memberlist_access_admin = ( $new['memberlist_access'] == MEMBERLIST_ACCESS_ADMIN ) ? "checked=\"checked\"" : "";
#
#-----[ FIND ]------------------------------------------
#
	"L_ALLOW_NAME_CHANGE" => $lang['Allow_name_change'],
#
#-----[ AFTER, ADD ]------------------------------------------
#
	"L_MEMBERLIST_ACCESS" => $lang['Memberlist_access'],
	"L_ALL" => $lang['All'],
	"L_REG" => $lang['Reg'],
	"L_MOD" => $lang['Mod'],
#
#-----[ FIND ]------------------------------------------
#
	"NAMECHANGE_NO" => $namechange_no,
#
#-----[ AFTER, ADD ]------------------------------------------
#
	"MEMBERLIST_ACCESS_ALL" => MEMBERLIST_ACCESS_ALL,
	"MEMBERLIST_ACCESS_ALL_CHECKED" => $memberlist_access_all,
	"MEMBERLIST_ACCESS_REG" => MEMBERLIST_ACCESS_REG,
	"MEMBERLIST_ACCESS_REG_CHECKED" => $memberlist_access_reg,
	"MEMBERLIST_ACCESS_MOD" => MEMBERLIST_ACCESS_MOD,
	"MEMBERLIST_ACCESS_MOD_CHECKED" => $memberlist_access_mod,
	"MEMBERLIST_ACCESS_ADMIN" => MEMBERLIST_ACCESS_ADMIN,
	"MEMBERLIST_ACCESS_ADMIN_CHECKED" => $memberlist_access_admin,
#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_admin.php
#
#-----[ FIND ]------------------------------------------
#
$lang['Allow_name_change'] = 'Allow Username changes';
#
#-----[ AFTER, ADD ]------------------------------------------
#
$lang['Memberlist_access'] = 'Who can access the memberlist?';
$lang['All'] = 'Everyone';
$lang['Reg'] = 'Registered Users';
$lang['Mod'] = 'Moderators';
#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/admin/board_config_body.tpl
#
#-----[ FIND ]------------------------------------------
#
	<tr>
		<td class="row1">{L_ALLOW_NAME_CHANGE}</td>
		<td class="row2"><input type="radio" name="allow_namechange" value="1" {NAMECHANGE_YES} /> {L_YES}&nbsp;&nbsp;<input type="radio" name="allow_namechange" value="0" {NAMECHANGE_NO} /> {L_NO}</td>
	</tr>
#
#-----[ AFTER, ADD ]------------------------------------------
#
	<tr>
		<td class="row1">{L_MEMBERLIST_ACCESS}</td>
		<td class="row2"><input type="radio" name="memberlist_access" value="{MEMBERLIST_ACCESS_ALL}" {MEMBERLIST_ACCESS_ALL_CHECKED} />{L_ALL}&nbsp; &nbsp;<input type="radio" name="memberlist_access" value="{MEMBERLIST_ACCESS_REG}" {MEMBERLIST_ACCESS_REG_CHECKED} />{L_REG}&nbsp; &nbsp;<br /><input type="radio" name="memberlist_access" value="{MEMBERLIST_ACCESS_MOD}" {MEMBERLIST_ACCESS_MOD_CHECKED} />{L_MOD}&nbsp; &nbsp;<input type="radio" name="memberlist_access" value="{MEMBERLIST_ACCESS_ADMIN}" {MEMBERLIST_ACCESS_ADMIN_CHECKED} />{L_ADMIN}</td>
	</tr>
#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/overall_header.tpl
#
#-----[ FIND ]------------------------------------------
#
						<td align="center" valign="top" nowrap="nowrap"><span class="mainmenu">&nbsp;<a href="{U_FAQ}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_faq.gif" width="12" height="13" border="0" alt="{L_FAQ}" hspace="3" />{L_FAQ}</a>&nbsp; &nbsp;<a href="{U_SEARCH}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_search.gif" width="12" height="13" border="0" alt="{L_SEARCH}" hspace="3" />{L_SEARCH}</a>&nbsp; &nbsp;<a href="{U_MEMBERLIST}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_members.gif" width="12" height="13" border="0" alt="{L_MEMBERLIST}" hspace="3" />{L_MEMBERLIST}</a>&nbsp; &nbsp;<a href="{U_GROUP_CP}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_groups.gif" width="12" height="13" border="0" alt="{L_USERGROUPS}" hspace="3" />{L_USERGROUPS}</a>&nbsp;
#
#-----[ REPLACE WITH ]------------------------------------------
#
						<td align="center" valign="top" nowrap="nowrap"><span class="mainmenu">&nbsp;<a href="{U_FAQ}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_faq.gif" width="12" height="13" border="0" alt="{L_FAQ}" hspace="3" />{L_FAQ}</a>&nbsp; &nbsp;<a href="{U_SEARCH}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_search.gif" width="12" height="13" border="0" alt="{L_SEARCH}" hspace="3" />{L_SEARCH}</a>&nbsp;
						<!-- BEGIN switch_memberlist -->
						&nbsp;<a href="{U_MEMBERLIST}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_members.gif" width="12" height="13" border="0" alt="{L_MEMBERLIST}" hspace="3" />{L_MEMBERLIST}</a>&nbsp;
						<!-- END switch_memberlist -->
						&nbsp;<a href="{U_GROUP_CP}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_groups.gif" width="12" height="13" border="0" alt="{L_USERGROUPS}" hspace="3" />{L_USERGROUPS}</a>&nbsp;
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
