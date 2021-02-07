############################################################## 
## MOD Title: Show Voters
## MOD Author: Kinfule < kinfule@lycos.es > (Javier B) http://www.kinfule.tk 
## MOD Description: Will show in a line, separated by commas the users who voted on a poll.
## MOD Version: 1.0.0 
## 
## Installation Level: Easy
## Installation Time: 10 Minutes 
## Files To Edit:  3
##								- language/lang_english/lang_main.php
##								- templates/subSilver/viewtopic_poll_result.tpl
##								- viewtopic.php
## Included Files: n/a
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
############################################################## 
## MOD History: 
## 
##   2007-01-31 - Version 1.0.0 
##      - First Public Release
## 
##   2007-02-5 - Version 1.0.0 
##      - Only show voters when there are at least 1 vote.
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################
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
$lang['Voters'] = 'Voter(s)';

# 
#-----[ OPEN ]------------------------------------------ 
#
templates/subSilver/viewtopic_poll_result.tpl

# 
#-----[ FIND ]------------------------------------------ 
#
	  <tr> 
		<td colspan="4" align="center"><span class="gen"><b>{L_TOTAL_VOTES} : {TOTAL_VOTES}</b></span></td>
	  </tr>

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
		<!-- BEGIN show_voters -->
	  <tr> 
			<td colspan="4" align="center"><span class="gensmall"><b>{show_voters.L_VOTERS}:</b>&nbsp;{show_voters.VOTERS}</span></td>
	  </tr>
		<!-- END show_voters -->
# 
#-----[ OPEN ]------------------------------------------ 
#
viewtopic.php


# 
#-----[ FIND ]------------------------------------------ 
#
				'TOTAL_VOTES' => $vote_results_sum)
			);
# 
#-----[ AFTER, ADD ]------------------------------------------ 
#

			$voters = '';
			$sql = "SELECT u.user_id, u.username
					FROM ".VOTE_USERS_TABLE." v, ".USERS_TABLE." u
					WHERE v.vote_id = ".$vote_id."
					AND u.user_id = v.vote_user_id";
			
			$result = $db->sql_query($sql);
			while($voter = $db->sql_fetchrow($result))
			{
				if($voters != '') 
				{
					$voters .= ', ';
				}
				$voters .= '<a href="'.append_sid('profile.'.$phpEx.'?mode=viewprofile&u='.$voter['user_id']).'" class="forumlink">'.$voter['username'].'</a>';
			}
			if($voters != '')
			{
				$template->assign_block_vars('show_voters', array(
					'VOTERS' => $voters,
					'L_VOTERS' => $lang['Voters'])
				);
			}

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 