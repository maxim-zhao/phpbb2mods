#################################################################
## MOD Title: Posts this month (Viewprofile)
## MOD Version: 1.0.1
## MOD Author: kkroo < princeomz2004@hotmail.com > ( Omar Ramadan ) http://phpbb-login.strangled.net
## MOD Author: Afterlife(69) < afterlife_69@hotmail.com > ( Dean Newman ) http://www.ugboards.com
## MOD Description: This modification will add a new section to 
##					viewprofile showing how many posts you have done in the current month.
##
## Installation Level: Easy
## Installation Time: 2 Minutes
## Files To Edit:	includes/usercp_viewprofile.php
##					templates/subSilver/profile_view_body.tpl
##					language/lang_english/lang_main.php
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
## Author Note:
##	Sure to be a favourite for your members.
##############################################################
## MOD History:
##
##	2006-9-07 - Version 1.0.1
##	-	updated query to count posts for faster page load time. (pointed out by drathburn)
## 
##	2006-9-07 - Version 1.0.0
##	-	Ready for mods db.
## 
##	2005-11-17 - Version 0.1.0
##	-	Created first version.
## 
#################################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
#################################################################

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
$current_time = time();
$this_months_posts = 0;
$year = date('Y', $current_time);
$month [0] = mktime (0,0,0,1,1, $year);
$month [1] = $month [0] + 2678400;
$month [2] = mktime (0,0,0,3,1, $year);
$month [3] = $month [2] + 2678400;
$month [4] = $month [3] + 2592000;
$month [5] = $month [4] + 2678400;
$month [6] = $month [5] + 2592000;
$month [7] = $month [6] + 2678400;
$month [8] = $month [7] + 2678400;
$month [9] = $month [8] + 2592000;
$month [10] = $month [9] + 2678400;
$month [11] = $month [10] + 2592000;
$month [12] = $month [11] + 2592000;
$arr_num = ( date('n')-1 );
$time_thismonth = $month[$arr_num];
$sql = "SELECT count(post_id) as monthly_posts
FROM " . POSTS_TABLE . "
WHERE poster_id = {$profiledata['user_id']}
AND post_time > '" . intval($time_thismonth) . "'";
if(! $result = $db->sql_query($sql) )
{
	message_die(GENERAL_ERROR, 'Could not obtain last months postcount.', '', __LINE__, __FILE__, $sql);
}
$row = $db->sql_fetchrow($result);
$this_months_posts = $row['monthly_posts'];

$db->sql_freeresult($result);

#
#-----[ FIND ]------------------------------------------
#
'POSTS' => $profiledata['user_posts'],

#
#-----[ AFTER, ADD ]------------------------------------------
#
	'POSTS_MONTH' => $this_months_posts,

#
#-----[ FIND ]------------------------------------------
#
'L_TOTAL_POSTS' => $lang['Total_posts'],

#
#-----[ AFTER, ADD ]------------------------------------------
#
	'L_POSTS_MONTH' => $lang['Posts_month'],

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/profile_view_body.tpl

#
#-----[ FIND ]------------------------------------------
#
		  <td valign="top"><b><span class="gen">{POSTS}</span></b><br /><span class="genmed">[{POST_PERCENT_STATS} / {POST_DAY_STATS}]</span> <br /><span class="genmed"><a href="{U_SEARCH_USER}" class="genmed">{L_SEARCH_USER_POSTS}</a></span></td>
		</tr>

#
#-----[ AFTER, ADD ]------------------------------------------
#
		<tr> 
		  <td valign="middle" align="right" nowrap="nowrap"><span class="gen">{L_POSTS_MONTH}:&nbsp;</span></td>
		  <td><b><span class="gen">{POSTS_MONTH}</span></b></td>
		</tr>

#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_main.php

#
#-----[ FIND ]------------------------------------------
#
# Note this is a partial find, Full line: $lang['Search_user_posts'] = 'Find all posts by %s'; // Find all posts by username
#
$lang['Search_user_posts']

#
#-----[ AFTER, ADD ]------------------------------------------
#
$lang['Posts_month'] = 'Posts this month';

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM