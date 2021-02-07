##############################################################
## MOD Title: Birthday Info In A Seperate Birthdays.php File
## MOD Author: MarkTheDaemon < mods@markthedaemon.co.uk > (Mark Barnes) http://www.markthedaemon.co.uk
## MOD Description: Changes TerraFrosts Birthdays MOD so instead of having the birthdays listed on the index they are listed in a seperate file, improving pageload time for the forum index.
## MOD Version: 1.0.0
## 
## Installation Level: Easy
## Installation Time: 9 minutes
## Files To Edit: language/lang_english/lang_main.php
##                includes/page_header.php
##                templates/subSilver/overall_header.tpl
##                index.php
##                templates/subSilver/index_body.tpl
## Included Files: birthdays.php
##                 templates/subSilver/birthday_body.tpl
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
## 2006-05-01 - Version 1.0.0
## -Initial Release
## 
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################

#
#-----[ COPY ]------------------------------------------
#
copy birthdays.php to birthdays.php
copy templates/subSilver/birthday_body.tpl to templates/subSilver/birthday_body.tpl
#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_main.php
#
#-----[ FIND ]------------------------------------------
#
//
// That's all, Folks!
// -------------------------------------------------
#
#-----[ BEFORE, ADD ]------------------------------------------
#
$lang['Birthday_Nav'] = 'Birthdays';
#
#-----[ OPEN ]------------------------------------------
#
includes/page_header.php
#
#-----[ FIND ]------------------------------------------
#
'L_USERNAME' => $lang['Username'],
#
#-----[ BEFORE, ADD ]------------------------------------------
#
'L_BIRTHDAY' => $lang['Birthday_Nav'],
#
#-----[ FIND ]------------------------------------------
#
'U_SEARCH_NEW' => append_sid('search.'.$phpEx.'?search_id=newposts'),
#
#-----[ AFTER, ADD ]------------------------------------------
#
'U_BIRTHDAY' => append_sid('birthdays.'.$phpEx),
#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/overall_header.tpl
#
#-----[ FIND ]------------------------------------------
#
&nbsp;<a href="{U_FAQ}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_faq.gif" width="12" height="13" border="0" alt="{L_FAQ}" hspace="3" />{L_FAQ}</a>&nbsp; &nbsp;
#
#-----[ BEFORE, ADD ]------------------------------------------
#
&nbsp;<a href="{U_BIRTHDAY}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_groups.gif" width="12" height="13" border="0" alt="{L_FAQ}" hspace="3" />{L_BIRTHDAY}</a>&nbsp;
#
#
#-----[ OPEN ]------------------------------------------
#
index.php
#
#-----[ FIND ]------------------------------------------
#
while( $row = $db->sql_fetchrow($result) )
	{
		$forum_moderators[$row['forum_id']][] = '<a href="' . append_sid("groupcp.$phpEx?" . POST_GROUPS_URL . "=" . $row['group_id']) . '">' . $row['group_name'] . '</a>';
	}
	$db->sql_freeresult($result);
	$sql = "SELECT user_id, username, user_birthday, user_level 
		FROM " . USERS_TABLE . " 
		WHERE user_birthday >= " . gmdate('md0000',time() + (3600 * $board_config['board_timezone'])) . " 
			AND user_birthday <= " . gmdate('md9999',time() + (3600 * $board_config['board_timezone']));
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not query members birthday information', '', __LINE__, __FILE__, $sql);
	}

	$user_birthdays = array();
	while ( $row = $db->sql_fetchrow($result) )
	{
		$bday_year = $row['user_birthday'] % 10000;
		$age = ( $bday_year ) ? ' ('.(gmdate('Y')-$bday_year).')' : '';
		$color = '';
		if ( $row['user_level'] == ADMIN )
		{
			$color = ' style="color:#' . $theme['fontcolor3'] . '"';
		}
		else if ( $row['user_level'] == MOD )
		{
			$color = ' style="color:#' . $theme['fontcolor2'] . '"';
		}
		$user_birthdays[] = '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $row['user_id']) . '"' . $color . '>' . $row['username'] . '</a>' . $age;
	}
	$db->sql_freeresult($result);

	$birthdays = (!empty($user_birthdays)) ?
		sprintf($lang['Congratulations'],implode(', ',$user_birthdays)) :
		$lang['No_birthdays'];

	if ( $board_config['bday_lookahead'] != -1 )
	{
		$start = gmdate('md9999',strtotime('+'.$board_config['bday_lookahead'].' day') + (3600 * $board_config['board_timezone']));
		$end = gmdate('md0000',strtotime('+1 day') + (3600 * $board_config['board_timezone']));
		$operator = ($start > $end) ? 'AND' : 'OR';
		$sql = "SELECT user_id, username, user_birthday, user_level 
			FROM " . USERS_TABLE . " 
			WHERE (user_birthday <= $start 
				$operator user_birthday >= $end)
				AND user_birthday <> 0";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not query upcoming birthday information', '', __LINE__, __FILE__, $sql);
		}
		$upcoming_birthdays = array();
		while ( $row = $db->sql_fetchrow($result) )
		{
			$bday_year = $row['user_birthday'] % 10000;
			$age = ( $bday_year ) ? ' ('.(gmdate('Y')-$bday_year).')' : '';
			$color = '';
			if ( $row['user_level'] == ADMIN )
			{
				$color = ' style="color:#' . $theme['fontcolor3'] . '"';
			}
			else if ( $row['user_level'] == MOD )
			{
				$color = ' style="color:#' . $theme['fontcolor2'] . '"';
			}
			$upcoming_birthdays[] = '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $row['user_id']) . '"' . $color . '>' . $row['username'] . '</a>' . $age;
		}

		$upcoming = (!empty($upcoming_birthdays)) ?
			sprintf($lang['Upcoming_birthdays'],$board_config['bday_lookahead'],implode(', ',$upcoming_birthdays)) :
			sprintf($lang['No_upcoming'],$board_config['bday_lookahead']);
	}

	if ( !empty($user_birthdays) || !empty($upcoming_birthdays) || $board_config['bday_show'] )
	{
		$template->assign_block_vars('birthdays',array());
		if ( !empty($upcoming_birthdays) || $board_config['bday_show'] )
		{
			$template->assign_block_vars('birthdays.upcoming',array());
		}
	}
#
#-----[ REPLACE WITH ]------------------------------------------
#
while( $row = $db->sql_fetchrow($result) )
	{
		$forum_moderators[$row['forum_id']][] = '<a href="' . append_sid("groupcp.$phpEx?" . POST_GROUPS_URL . "=" . $row['group_id']) . '">' . $row['group_name'] . '</a>';
	}
	$db->sql_freeresult($result);
#
#-----[ FIND ]------------------------------------------
#
'NEWEST_USER' => sprintf($lang['Newest_user'], '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=$newest_uid") . '">', $newest_user, '</a>'),
'BIRTHDAYS' => $birthdays,
'UPCOMING' => $upcoming,
#
#-----[ REPLACE WITH ]------------------------------------------
#
'NEWEST_USER' => sprintf($lang['Newest_user'], '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=$newest_uid") . '">', $newest_user, '</a>'),
#
#-----[ FIND ]------------------------------------------
#
'L_TODAYS_BIRTHDAYS' => $lang['Todays_Birthdays'],
'L_VIEW_BIRTHDAYS' => $lang['View_Birthdays'],
'L_FORUM' => $lang['Forum'],
#
#-----[ REPLACE WITH ]------------------------------------------
#
'L_FORUM' => $lang['Forum'],
#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/index_body.tpl
#
#-----[ FIND ]------------------------------------------
#
<tr> 
	<td class="row1" align="left"><span class="gensmall">{TOTAL_USERS_ONLINE} &nbsp; [ {L_WHOSONLINE_ADMIN} ] &nbsp; [ {L_WHOSONLINE_MOD} ]<br />{RECORD_USERS}<br />{LOGGED_IN_USER_LIST}</span></td>
</tr>
  <!-- BEGIN birthdays -->
  <tr> 
	<td class="catHead" colspan="2" height="28"><span class="cattitle">{L_TODAYS_BIRTHDAYS}</span></td>
  </tr>
  <tr> 
	<td class="row1" align="center" valign="middle"><img src="templates/subSilver/images/icon_birthday.gif" alt="{L_VIEW_BIRTHDAYS}" /></td>
	<td class="row1" align="left" width="100%">
	  <span class="gensmall">{BIRTHDAYS}
	  <!-- BEGIN upcoming -->
	  <br />{UPCOMING}
	  <!-- END upcoming -->
	  </span>
	</td>
  </tr>
  <!-- END birthdays -->
#
#-----[ REPLACE WITH ]------------------------------------------
#
<tr> 
	<td class="row1" align="left"><span class="gensmall">{TOTAL_USERS_ONLINE} &nbsp; [ {L_WHOSONLINE_ADMIN} ] &nbsp; [ {L_WHOSONLINE_MOD} ]<br />{RECORD_USERS}<br />{LOGGED_IN_USER_LIST}</span></td>
</tr>
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
