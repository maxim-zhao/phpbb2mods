##############################################################
## MOD Title: Advanced Vote Manager
## MOD Author: soapergem < soapergem@gmail.com > (Gordon Myers) N/A
## MOD Description: This MOD extensively expands the capabilities of voting on
##		your forums. Previous MODs have done one thing or another, but never
##		really offered a comprehensive package to give the most functionality
##		overall, and they had compatibility issues with each other.
##
##			MULTIPLE CHOICE VOTING
##			  * poll creator can set the maximum allowed options on which
##				a user may vote (e.g. creates 7 options, but users may vote on 4)
##			  * if a user votes for fewer options than the maximum allowed,
##				they may still use the rest of their votes later so long
##				as the poll has not expired (only on options they have not
##				already voted on, obviously)
##
##			SIMPLE POLL RESULTS
##			  * same display you are used to, but in addition to "Total Votes,"
##			      the number of voters is also shown
##			  * results are sorted by what's winning so data analysis is easy
##
##			DETAILED POLL RESULTS
##			  * results sorted by options and users in two columns
##			  * results may be exported as a CSV file for Microsoft Excel
##
##			HIDE RESULTS
##			  * poll creator may choose to hide the detailed results either 
##			      permanently or until the poll expires
##			  * poll creator may hide the simple results until the poll expires, so 
##			      long as the detailed results are also hidden
##			  * poll creator may hide the total number of voters until the poll expires,
##			      so long as the simple results are also hidden
##			  * simple results/total number of voters may not be hidden on
##			      "never-ending" polls (with no expiration date)
##			  * simple results are NOT sorted by what's winning when they are hidden,
##			      instead sorted by options
##
##			UNDO/CHANGE VOTES
##			  * poll creator may allow users to undo/change their votes
##			  * this option is configurable for each poll
##			  * users can undo their votes only if the poll is configured to allow that
##			  * users cannot undo their votes after a poll has expired (but admins/mods can)
##
##			ADMINISTRATOR/MODERATOR CONTROL
##			  * admins/mods have control over every setting
##			  * admins/mods may prune (delete) any individual user's votes
##			  * admins/mods may always view detailed results
##			  * these control features apply to all polls for administrators but only 
##			      to specific polls for moderators: mods only have control over polls 
##			      that are in the specific forum(s) which they moderate
##
## MOD Version: 1.0.2
##
## Installation Level: Intermediate
## Installation Time: 20 Minutes
##
## Files To Edit:		8
##                 - posting.php
##                 - viewtopic.php
##                 - includes/functions_post.php,
##                 - language/lang_english/lang_main.php, 
##                 - templates/subSilver/posting_poll_body.tpl,
##                 - templates/subSilver/viewtopic_poll_ballot.tpl
##                 - templates/subSilver/viewtopic_poll_result.tpl
##                 - templates/subSilver/subSilver.cfg
##
## Included Files:	6
##                 - templates/subSilver/images/list_branch0.gif
##                 - templates/subSilver/images/list_branch1.gif
##                 - templates/subSilver/confirm_delete.tpl
##                 - templates/subSilver/vote_manage_body.tpl
##                 - templates/subSilver/vote_manage_select.tpl
##                 - vote_manage.php
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
##	Because this MOD uses altered SQL tables, the functionality
##	it offers DOES NOT APPLY to any polls that have already been
##	been created on your forum PRIOR to its installation. Undoing
##	votes and viewing detailed results of your PREVIOUS polls is
##	simply NOT POSSIBLE with this MOD (unless you know exactly what
##	each user voted for and manually input this data into your SQL
##	table), so DON'T ASK WHY IT DOESN'T WORK FOR YOUR OLD POLLS.
##
##	This MOD has not been tested on any forums with similar vote
##	MODs simultaneously installed, so I will NOT offer support for
##	compatibility issues. I designed this MOD with the intent that
##	it would be the only vote MOD you would need. My recommendation,
##	if there seem to be compatibility issues, is to uninstall any
##	other vote-related MODs and use only this one. If you feel as
##	though my MOD is lacking in some important functionality you
##	would like to see, send me a private message and I will consider
##	revising my MOD to accomodate.
##
##	Also, when asking for support, please remain respectful and
##	understand that this MOD was created on my own time without
##	any sort of compensation or reward; I just like programming.
##	If the need arises to ask me for support, I will probably
##	ignore any vague and ambiguous such as "Why doesn't it work?"
##	I'm not a magician, so I need details if you expect me to debug
##	anything. Please understand, as well, that I am under no
##	obligation to help anyone with support issues related to this
##	MOD. I will try to offer support for any problems that arise,
##	but I do have a life that takes priority.
## 
##############################################################
## MOD History:
##   2006-05-10 - Version 1.0.2
##      - Fixed preview display error
##      - Re-submitted to MODs Database
##   2006-02-14 - Version 1.0.1
##      - Fixed all the silly formatting issues
##      - Used a lot more IN-LINE functions instead of REPLACE WITH
##	  - Used nesting with assign_block_vars() to remove hard-coded HTML
##	  - Added one more template file to avoid hard-coding HTML
##	  - Used intval() to secure some $HTTP_POST_VARS
##      - Re-submitted to MODs Database (on Valentine's Day)
##   2006-02-01 - Version 1.0.0
##      - Submitted to MODs Database
## 
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################
#
#-----[ COPY ]------------------------------------------
#
COPY root/templates/subSilver/images/list_branch0.gif to templates/subSilver/images/list_branch0.gif
COPY root/templates/subSilver/images/list_branch1.gif to templates/subSilver/images/list_branch1.gif
COPY root/templates/subSilver/confirm_delete.tpl to templates/subSilver/confirm_delete.tpl
COPY root/templates/subSilver/vote_manage_body.tpl to templates/subSilver/vote_manage_body.tpl
COPY root/templates/subSilver/vote_manage_select.tpl to templates/subSilver/vote_manage_select.tpl
COPY root/vote_manage.php to vote_manage.php
#
#-----[ SQL ]----------------------------------
#
# CHANGE TABLE PREFIX ACCORDINGLY!!!
#
ALTER TABLE phpbb_vote_desc ADD vote_max INT( 3 ) DEFAULT '1' NOT NULL;
ALTER TABLE phpbb_vote_desc ADD vote_voted INT( 7 ) DEFAULT '0' NOT NULL;
ALTER TABLE phpbb_vote_desc ADD vote_hide TINYINT( 1 ) DEFAULT '1' NOT NULL;
ALTER TABLE phpbb_vote_desc ADD vote_undo TINYINT ( 1 ) DEFAULT '0' NOT NULL;
ALTER TABLE phpbb_vote_voters ADD vote_option_id TINYINT( 4 ) DEFAULT '-1' NOT NULL;
#
#-----[ OPEN ]---------------------------------------------
#
posting.php
#
#-----[ FIND ]---------------------------------------------
#
				$poll_length = $row['vote_length'] / 86400;
#
#-----[ REPLACE WITH ]---------------------------------------------
#
				$poll_length = intval($row['vote_length'] / 86400);
				$poll_length_h = intval( ( $row['vote_length'] - ( $poll_length * 86400) ) / 3600 ) ;
				$max_vote = $row['vote_max'];
				$hide_vote = $row['vote_hide'];
				$undo_vote = $row['vote_undo'];
#
#-----[ FIND ]---------------------------------------------
#
	if ( !empty($HTTP_POST_VARS['vote_id']) )
#
#-----[ IN-LINE FIND ]---------------------------------------------
#
!empty
#
#-----[ IN-LINE BEFORE, ADD ]---------------------------------------------
#
(
#
#-----[ IN-LINE FIND ]---------------------------------------------
#
$HTTP_POST_VARS['vote_id'])
#
#-----[ IN-LINE AFTER, ADD ]---------------------------------------------
#
) && (is_array($HTTP_POST_VARS['vote_id'])) && (isset($HTTP_POST_VARS['vote_id']))
#
#-----[ FIND ]---------------------------------------------
#
		$vote_option_id = intval($HTTP_POST_VARS['vote_id']);
#
#-----[ AFTER, ADD ]---------------------------------------------
#
		$vote_id = $HTTP_POST_VARS['vote_id'];
#
#-----[ FIND ]---------------------------------------------
#
		$sql = "SELECT vd.vote_id    
#
#-----[ IN-LINE FIND ]---------------------------------------------
#
vd.vote_id
#
#-----[ IN-LINE AFTER, ADD ]---------------------------------------------
#
, vd.vote_max
#
#-----[ FIND ]---------------------------------------------
#
		if ( $vote_info = $db->sql_fetchrow($result) )
		{
#
#-----[ AFTER, ADD ]---------------------------------------------
#
			$max_vote = $vote_info['vote_max'];
#
#-----[ FIND ]---------------------------------------------
#
			$vote_id = $vote_info['vote_id'];
#
#-----[ IN-LINE FIND ]---------------------------------------------
#
$vote_id
#
#-----[ IN-LINE REPLACE WITH ]---------------------------------------------
#
$id_vote
#
#-----[ FIND ]---------------------------------------------
#
			$sql = "SELECT * 
#
#-----[ BEFORE, ADD ]---------------------------------------------
#
		}
#
#-----[ FIND ]---------------------------------------------
# 
				WHERE vote_id = $vote_id 
#
#-----[ IN-LINE FIND ]---------------------------------------------
#
$vote_id
#
#-----[ IN-LINE REPLACE WITH ]---------------------------------------------
#
$id_vote
#
#-----[ FIND ]---------------------------------------------
# 
			if ( !($row = $db->sql_fetchrow($result2)) )
			{
#
#-----[ REPLACE WITH ]---------------------------------------------
#
		$prev_vote = $db->sql_numrows();
		$counter = 0;
		$row = $db->sql_fetchrowset($result2);
#
#-----[ FIND ]---------------------------------------------
# 
				$sql = "UPDATE " . VOTE_RESULTS_TABLE . " 
					SET vote_result = vote_result + 1 
					WHERE vote_id = $vote_id 
						AND vote_option_id = $vote_option_id";
#
#-----[ BEFORE, ADD ]---------------------------------------------
# 
		$vbn = array();
		for ($i = 0; $i < count($vote_id); $i++)
		{
			//	check if already voted on certain options
			$flag = false;
			for ($j = 0; $j < $prev_vote; $j++)
			{
				if ($vote_id[$i] == $row[$j]['vote_option_id'])
				{
					$flag = true;
					break;
				}
			}
			if (!$flag)
			{
				$vbn[$counter] = $vote_id[$i];
				$counter++;
			}
		}

		$db->sql_freeresult($result2);

		$sql = "SELECT vd.vote_id    
			FROM " . VOTE_DESC_TABLE . " vd, " . VOTE_RESULTS_TABLE . " vr
			WHERE vd.topic_id = $topic_id 
				AND vr.vote_id = vd.vote_id 
				AND vr.vote_option_id = $vote_option_id
			GROUP BY vd.vote_id";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not obtain vote data for this topic', '', __LINE__, __FILE__, $sql);
		}

		if ( $vote_info = $db->sql_fetchrow($result) )
		{
			$vote_id = $vote_info['vote_id'];

			$sql = "SELECT * 
				FROM " . VOTE_USERS_TABLE . "  
				WHERE vote_id = $vote_id 
					AND vote_user_id = " . $userdata['user_id'];
			if ( !($result2 = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not obtain user vote data for this topic', '', __LINE__, __FILE__, $sql);
			}
			if ( $max_vote >= (count($vbn) + $prev_vote) )	//	Modded	
			{
				foreach ($vbn as $vote_option_id)
				{
#
#-----[ FIND ]---------------------------------------------
#
				$sql = "INSERT INTO " . VOTE_USERS_TABLE . " (vote_id, vote_user_id, vote_user_ip) 
#
#-----[ IN-LINE FIND ]---------------------------------------------
#
vote_user_ip
#
#-----[ IN-LINE AFTER, ADD ]---------------------------------------------
#
, vote_option_id
#
#-----[ FIND ]---------------------------------------------
#
					VALUES ($vote_id, " . $userdata['user_id'] . ", '$user_ip')";
#
#-----[ IN-LINE FIND ]---------------------------------------------
#
'$user_ip'
#
#-----[ IN-LINE AFTER, ADD ]---------------------------------------------
#
, $vote_option_id
#
#-----[ FIND ]---------------------------------------------
#
				if ( !$db->sql_query($sql, END_TRANSACTION) )
				{
					message_die(GENERAL_ERROR, "Could not insert user_id for poll", "", __LINE__, __FILE__, $sql);
				}
#
#-----[ AFTER, ADD ]---------------------------------------------
#
				}
				if ( !($prev_vote) )
				{
					$sql = "UPDATE " . VOTE_DESC_TABLE . " 
						SET vote_voted = vote_voted + 1 
						WHERE vote_id = $vote_id 
							AND topic_id = $topic_id";
					if ( !$db->sql_query($sql) )
					{
						message_die(GENERAL_ERROR, 'Could not update poll voted', '', __LINE__, __FILE__, $sql);
					}
				}
#
#-----[ FIND ]---------------------------------------------
#
			$poll_length = ( isset($HTTP_POST_VARS['poll_length']) && $is_auth['auth_pollcreate'] ) ? $HTTP_POST_VARS['poll_length'] : '';
#
#-----[ REPLACE WITH ]---------------------------------------------
#
			$poll_length = ( isset($HTTP_POST_VARS['poll_length']) && $is_auth['auth_pollcreate'] ) ? intval($HTTP_POST_VARS['poll_length']) : '0';
			$poll_length_h = ( isset($HTTP_POST_VARS['poll_length_h']) && $is_auth['auth_pollcreate'] ) ? intval($HTTP_POST_VARS['poll_length_h']) : '0';
			$max_vote = ( isset($HTTP_POST_VARS['max_vote']) && $is_auth['auth_pollcreate'] ) ? ( ( $HTTP_POST_VARS['max_vote'] == 0 ) ? 1 : intval($HTTP_POST_VARS['max_vote']) ) : '';
			$undo_vote = ( isset($HTTP_POST_VARS['undo_vote']) && $is_auth['auth_pollcreate'] ) ? 1 : '';
			$hide_vote = 0;	//	show all
			if ( isset($HTTP_POST_VARS['hide_dr']) && $is_auth['auth_pollcreate'] )
			{
				//	hide detailed results
				$hide_vote++;
				if ( $poll_length > 0 || $poll_length_h > 0 )
				{
					//	show detailed after expiration
					$hide_vote += ( isset($HTTP_POST_VARS['hide_exp']) ) ? 3 : 0;
					if ( isset($HTTP_POST_VARS['hide_sr']) )
					{
						//	hide simple results until expiration
						$hide_vote++;
						//	hide voters until expiration
						$hide_vote += ( isset($HTTP_POST_VARS['hide_voters']) ) ? 1 : 0;
					}
				}
			}
#
#-----[ FIND ]---------------------------------------------
#
			prepare_post($mode, $post_data, $bbcode_on, $html_on, $smilies_on, $error_msg, $username, $bbcode_uid, $subject, $message, $poll_title, $poll_options, $poll_length);
#
#-----[ IN-LINE FIND ]---------------------------------------------
#
, $poll_length
#
#-----[ IN-LINE AFTER, ADD ]---------------------------------------------
#
, $poll_length_h, $max_vote, $undo_vote
#
#-----[ FIND ]---------------------------------------------
#
				submit_post($mode, $post_data, $return_message, $return_meta, $forum_id, $topic_id, $post_id, $poll_id, $topic_type, $bbcode_on, $html_on, $smilies_on, $attach_sig, $bbcode_uid, str_replace("\'", "''", $username), str_replace("\'", "''", $subject), str_replace("\'", "''", $message), str_replace("\'", "''", $poll_title), $poll_options, $poll_length);
#
#-----[ IN-LINE FIND ]---------------------------------------------
#
, $poll_length
#
#-----[ IN-LINE AFTER, ADD ]---------------------------------------------
#
, $max_vote, $hide_vote, $undo_vote
#
#-----[ FIND ]---------------------------------------------
#
	$poll_length = ( isset($HTTP_POST_VARS['poll_length']) ) ? max(0, intval($HTTP_POST_VARS['poll_length'])) : 0;
#
#-----[ AFTER, ADD ]---------------------------------------------
#
	$poll_length_h = ( isset($HTTP_POST_VARS['poll_length_h']) ) ? max(0, intval($HTTP_POST_VARS['poll_length_h'])) : 0;
	$max_vote = ( isset($HTTP_POST_VARS['max_vote']) ) ? max(1, intval($HTTP_POST_VARS['max_vote'])) : 1;
	$undo_vote = ( isset($HTTP_POST_VARS['undo_vote']) ) ? 1 : 0;
	$hide_vote = 0;	//	show all
	if ( isset($HTTP_POST_VARS['hide_dr']) && $is_auth['auth_pollcreate'] )
	{
		//	hide detailed results
		$hide_vote++;
		if ( $poll_length > 0 || $poll_length_h > 0 )
		{
			//	show detailed after expiration
			$hide_vote += ( isset($HTTP_POST_VARS['hide_exp']) ) ? 3 : 0;
			if ( isset($HTTP_POST_VARS['hide_sr']) )
			{
				//	hide simple results until expiration
				$hide_vote++;
				//	hide voters until expiration
				$hide_vote += ( isset($HTTP_POST_VARS['hide_voters']) ) ? 1 : 0;
			}
		}
	}
#
#-----[ FIND ]---------------------------------------------
#
		$poll_length = '';
#
#-----[ AFTER, ADD ]---------------------------------------------
#
		$poll_length_h = '';
		$max_vote = '1';
		$hide_vote = 0;
		$undo_vote = '';
#
#-----[ FIND ]---------------------------------------------
#
		'L_POLL_LENGTH' => $lang['Poll_for'],  
#
#-----[ AFTER, ADD ]---------------------------------------------
#
		'L_VHIDE' => $lang['Vhide'], 
		'L_HIDE_DR' => $lang['Hide_detailed_results'],
		'L_HIDE_DR_EXP' => $lang['Until_exp'],
		'L_HIDE_SR' => $lang['Also_hide_simple'],
		'L_HIDE_VOTERS' => $lang['Also_hide_voters'], 
		'L_HOURS' => $lang['Hours'], 
		'L_MAX_VOTE' => $lang['Max_vote'], 
		'L_MAX_VOTE_EXPLAIN' => $lang['Max_vote_explain'],
		'L_UNDO' => $lang['Undo_votes'],
		'L_UNDO_VOTE' => $lang['Allow_undo'],
		'IMG_LIST_BRANCH0' => $images['list_branch'][0],
		'IMG_LIST_BRANCH1' => $images['list_branch'][1],
#
#-----[ FIND ]---------------------------------------------
#
		'POLL_LENGTH' => $poll_length)
#
#-----[ BEFORE, ADD ]---------------------------------------------
#
		'HIDE_DR' => ( $hide_vote ) ? 'checked="checked" ' : '',
		'HIDE_DR_EXP' => ( $hide_vote > 3 ) ? 'checked="checked" ' : '',
		'HIDE_SR' => ( $hide_vote && $hide_vote % 3 != 1 ) ? 'checked="checked" ' : '',
		'HIDE_VOTERS' => ( $hide_vote && !($hide_vote % 3) ) ? 'checked="checked" ' : '',
		'UNDO_VOTE' => ( $undo_vote ) ? 'checked="checked"' : '',
		'POLL_LENGTH_H' => $poll_length_h,
		'MAX_VOTE' => $max_vote,
#
#-----[ OPEN ]---------------------------------------------
#
viewtopic.php
#
#-----[ FIND ]---------------------------------------------
#
$topic_id = $post_id = 0;
#
#-----[ AFTER, ADD ]---------------------------------------------
#
$vote_id = array();
#
#-----[ FIND ]---------------------------------------------
#
	$sql = "SELECT vd.vote_id, vd.vote_text, vd.vote_start, vd.vote_length, vr.vote_option_id, vr.vote_option_text, vr.vote_result
#
#-----[ IN-LINE FIND ]---------------------------------------------
#
vd.vote_length
#
#-----[ IN-LINE AFTER, ADD ]---------------------------------------------
#
, vd.vote_max, vd.vote_voted, vd.vote_hide, vd.vote_undo
#
#-----[ FIND ]---------------------------------------------
#
		ORDER BY vr.vote_option_id ASC";
#
#-----[ IN-LINE FIND ]---------------------------------------------
#
vr.vote_option_id
#
#-----[ IN-LINE BEFORE, ADD ]---------------------------------------------
#
vr.vote_result DESC, 
#
#-----[ FIND ]---------------------------------------------
#
		$vote_title = $vote_info[0]['vote_text'];
#
#-----[ AFTER, ADD ]---------------------------------------------
#
		$max_vote = $vote_info[0]['vote_max'];
		$voted_vote = $vote_info[0]['vote_voted'];
		$hide_vote = $vote_info[0]['vote_hide'];
#
#-----[ FIND ]---------------------------------------------
#
		$sql = "SELECT vote_id
#
#-----[ IN-LINE FIND ]---------------------------------------------
#
vote_id
#
#-----[ IN-LINE REPLACE WITH ]---------------------------------------------
#
vote_option_id
#
#-----[ FIND ]---------------------------------------------
#
		$user_voted = ( $row = $db->sql_fetchrow($result) ) ? TRUE : 0;
		$db->sql_freeresult($result);
#
#-----[ REPLACE WITH ]---------------------------------------------
#
		$user_voted = ( $db->sql_numrows() < $max_vote ) ? 0 : TRUE;
		if ( $db->sql_numrows() > 0 && !($user_voted) )	//	get options already voted for
		{ 
			$row = $db->sql_fetchrowset($result);
			for ($i = 0; $i < count($row); $i++)
			{
				$vbn[$i] = $row[$i]['vote_option_id'];
			}
			$db->sql_freeresult($result);
		}
#
#-----[ FIND ]---------------------------------------------
#
		$poll_expired = ( $vote_info[0]['vote_length'] ) ? ( ( $vote_info[0]['vote_start'] + $vote_info[0]['vote_length'] < time() ) ? TRUE : 0 ) : 0;
#
#-----[ AFTER, ADD ]---------------------------------------------
#
		$auth_undo = ( $vote_info[0]['vote_undo'] ) ? true : false;
		if ( $userdata['user_level'] == ADMIN )
		{
			$auth_mod = true;
		}
		else if ( $userdata['user_level'] == MOD )
		{
			$sql = "SELECT ug.user_id 
				FROM " . AUTH_ACCESS_TABLE . " aa, 
				" . USER_GROUP_TABLE . " ug WHERE 
				aa.auth_mod = " . TRUE . " AND 
				aa.group_id = ug.group_id AND 
				aa.forum_id = $forum_id AND 
				ug.user_id = " . $userdata['user_id'];
			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Could not obtain user permissions", '', __LINE__, __FILE__, $sql);
			}
			$auth_mod = ( $db->sql_numrows() ) ? true : false;
		}
		else
		{
			$auth_mod = false;
		}
#
#-----[ FIND ]---------------------------------------------
#
			$vote_graphic = 0;
			$vote_graphic_max = count($images['voting_graphic']);
#
#-----[ AFTER, ADD ]---------------------------------------------
#
			if ( ($hide_vote && ($hide_vote % 3 != 1)) && !$poll_expired && $vote_info[0]['vote_length'] && !$auth_mod )
			{
				//	Resort the options - the results are hidden so we shouldn't
				//	give any inclination to what is winning
				$new_sort = array();
				for ($i = 0; $i < $vote_options; $i++)
				{
					$new_sort[$vote_info[$i]['vote_option_id']] = $i;
				}
				ksort($new_sort);
	
				foreach ($new_sort as $i)
				{
					$vote_percent = ( $vote_results_sum > 0 ) ? $vote_info[$i]['vote_result'] / $vote_results_sum : 0;
					$vote_graphic_length = round($vote_percent * $board_config['vote_graphic_length']);
	
					$vote_graphic_img = $images['voting_graphic'][$vote_graphic];
					$vote_graphic = ($vote_graphic < $vote_graphic_max - 1) ? $vote_graphic + 1 : 0;
	
					if ( count($orig_word) )
					{
						$vote_info[$i]['vote_option_text'] = preg_replace($orig_word, $replacement_word, $vote_info[$i]['vote_option_text']);
					}
	
					$template->assign_block_vars("poll_option", array(
						'POLL_OPTION_CAPTION' => $vote_info[$i]['vote_option_text'],
						'POLL_OPTION_RESULT' => '',
						'POLL_OPTION_PERCENT' => '',
						'POLL_OPTION_IMG' => $vote_graphic_img,
						'POLL_OPTION_IMG_WIDTH' => '0')
					);
				}
			}
			else
			{
#
#-----[ FIND ]---------------------------------------------
#
					'POLL_OPTION_IMG' => $vote_graphic_img,
					'POLL_OPTION_IMG_WIDTH' => $vote_graphic_length)
				);
			}
#
#-----[ AFTER, ADD ]---------------------------------------------
#
			}
#
#-----[ FIND ]---------------------------------------------
#
			$template->assign_vars(array(
				'L_TOTAL_VOTES' => $lang['Total_votes'],
				'TOTAL_VOTES' => $vote_results_sum)
			);
#
#-----[ REPLACE WITH ]---------------------------------------------
#
			if ( ($hide_vote && ($hide_vote % 3 != 1)) && !$poll_expired && $vote_info[0]['vote_length'] && !$auth_mod )
			{
				$template->assign_block_vars("after", array(
					'L_RESULTS_AFTER' => $lang['Results_after'])
				);
				if ( $hide_vote % 3 )
				{
					$template->assign_block_vars("voted", array(
						'L_VOTED' => $lang['Voted_show'],
						'VOTED' => $voted_vote)
					);
				}
			}
			else
			{
				$template->assign_block_vars("voted", array(
					'L_VOTED' => $lang['Voted_show'],
					'VOTED' => $voted_vote)
				);
				$template->assign_block_vars("total", array(
					'L_TOTAL_VOTES' => $lang['Total_votes'],
					'TOTAL_VOTES' => $vote_results_sum)
				);
			}

			if ( !$poll_expired && $vote_info[0]['vote_length'] )
			{
				$time_left = $vote_info[0]['vote_start'] + $vote_info[0]['vote_length'] - time();
				$days_left = intval($time_left / 86400);
				$time_left = $time_left - ( $days_left * 86400 );
				$hours_left = intval($time_left / 3600);
				$time_left = $time_left - ( $hours_left * 3600 );
				$minutes_left = intval($time_left / 60);
				$time_left = (( $days_left == 1 ) ? $days_left . ' ' . $lang['Day'] : $days_left . ' ' . $lang['Days']) . ', ';
				$time_left .= (( $hours_left == 1 ) ? $hours_left . ' ' . $lang['Hour'] : $hours_left . ' ' . $lang['Hours']) . ', ';
				$time_left .= ( $minutes_left == 1 ) ? $minutes_left . ' ' . $lang['Minute'] : $minutes_left . ' ' . $lang['Minutes'];
			
				$template->assign_block_vars("expires", array(
					'L_POLL_EXPIRES' => $lang['Poll_expires'],
					'POLL_EXPIRES' => $time_left)
				);
			}
			else if ($poll_expired == 1)
			{
				$template->assign_block_vars("expires", array(
					'L_POLL_EXPIRES' => $lang['Poll_expired'],
					'POLL_EXPIRES' => '')
				);
			}

			$vote_manage_text = '';
			if ( ($hide_vote > 4 && $poll_expired) || !$hide_vote || $auth_mod )
			{
				$vote_manage_text = $lang['Detailed_results'];
			}
			$vote_manage_text .= ( strlen($vote_manage_text) && ($auth_undo || $auth_mod) ) ? '/'.$lang['Undo_votes'] : (( $auth_undo ) ? $lang['Undo_votes'] : '');
			if ( $vote_manage_text == $lang['Undo_votes'] )
			{
				$vote_manager = '<a href="'.append_sid("vote_manage.$phpEx?vote_id=$vote_id&amp;action=undo&amp;user_id=".$userdata['user_id']).'">'.$vote_manage_text.'</a>';
			}
			else if ( strlen($vote_manage_text) )
			{
				$vote_manager = '<a href="'.append_sid("vote_manage.$phpEx?vote_id=$vote_id").'">'.$vote_manage_text.'</a>';
			}
			if ( strlen($vote_manager) )
			{
				$template->assign_block_vars("vote_manage", array(
					'VOTE_MANAGE' => $vote_manager)
				);
			}
#
#-----[ FIND ]---------------------------------------------
#
				'pollbox' => 'viewtopic_poll_ballot.tpl')
			);
#
#-----[ AFTER, ADD ]---------------------------------------------
#
			$vote_box = ( $max_vote > 1 && ($max_vote - count($vbn) > 1) ) ? 'checkbox' : 'radio';
#
#-----[ FIND ]---------------------------------------------
#
			for($i = 0; $i < $vote_options; $i++)
#
#-----[ BEFORE, ADD ]---------------------------------------------
#
			//	Resort the options -- the user has not voted yet,
			//	so they don't need to see them in order of what's winning
			$new_sort = array();
#
#-----[ AFTER, ADD ]---------------------------------------------
#
# NOTE: This is still after the same for loop we found with FIND
#
			{
				$new_sort[$vote_info[$i]['vote_option_id']] = $i;
			}
			ksort($new_sort);

			foreach ($new_sort as $i)
#
#-----[ FIND ]---------------------------------------------
#
				if ( count($orig_word) )
				{
					$vote_info[$i]['vote_option_text'] = preg_replace($orig_word, $replacement_word, $vote_info[$i]['vote_option_text']);
				}
#
#-----[ AFTER, ADD ]---------------------------------------------
#
				$disable = false;
				if (isset($vbn))
				{
					foreach ($vbn as $option)
					{
						if ($option == $vote_info[$i]['vote_option_id'])
						{
							$disable = true;
						}
					}
				}
				$disabled = ($disable) ? "disabled=\"disabled\" " : "";
#
#-----[ FIND ]---------------------------------------------
#
					'POLL_OPTION_ID' => $vote_info[$i]['vote_option_id'],
#
#-----[ BEFORE, ADD ]---------------------------------------------
#
					'POLL_VOTE_BOX' => $vote_box,
					'POLL_OPTION_DISABLED' => $disabled,
#
#-----[ FIND ]---------------------------------------------
#
			$s_hidden_fields = '<input type="hidden" name="topic_id" value="' . $topic_id . '" /><input type="hidden" name="mode" value="vote" />';
		}
#
#-----[ AFTER, ADD ]---------------------------------------------
#
		if ( $max_vote > 1 && ($max_vote - count($vbn) > 1) )
		{
			$vote_br = '<br/>';
			$max_vote_nb = $max_vote - count($vbn);
		}
		else
		{
			$vote_br = '';
			$lang['Max_voting_1_explain'] = '';
			$lang['Max_voting_2_explain'] = '';
			$max_vote_nb = '';
		}
#
#-----[ FIND ]---------------------------------------------
#
			'POLL_QUESTION' => $vote_title,
#
#-----[ AFTER, ADD ]---------------------------------------------
#
			'POLL_VOTE_BR' => $vote_br,
			'MAX_VOTING_1_EXPLAIN' => $lang['Max_voting_1_explain'],
			'MAX_VOTING_2_EXPLAIN' => $lang['Max_voting_2_explain'],
			'MAX_VOTE' => $max_vote_nb,
#
#-----[ OPEN ]---------------------------------------------
#
includes/functions_post.php
#
#-----[ FIND ]---------------------------------------------
#
function prepare_post(&$mode, &$post_data, &$bbcode_on, &$html_on, &$smilies_on, &$error_msg, &$username, &$bbcode_uid, &$subject, &$message, &$poll_title, &$poll_options, &$poll_length)
#
#-----[ IN-LINE FIND ]---------------------------------------------
#
&$poll_length
#
#-----[ IN-LINE AFTER, ADD ]---------------------------------------------
#
, &$poll_length_h, &$max_vote, &$undo_vote
#
#-----[ FIND ]---------------------------------------------
#
		$poll_length = (isset($poll_length)) ? max(0, intval($poll_length)) : 0;
#
#-----[ REPLACE WITH ]---------------------------------------------
#
		$poll_length = (isset($poll_length)) ? max(0, ($poll_length+$poll_length_h/24)) : 0;
		$max_vote = (isset($max_vote)) ? max(0, intval($max_vote)) : 0;
		$undo_vote = (isset($undo_vote)) ? max(0, intval($undo_vote)) : 0;
#
#-----[ FIND ]---------------------------------------------
#
function submit_post($mode, &$post_data, &$message, &$meta, &$forum_id, &$topic_id, &$post_id, &$poll_id, &$topic_type, &$bbcode_on, &$html_on, &$smilies_on, &$attach_sig, &$bbcode_uid, $post_username, $post_subject, $post_message, $poll_title, &$poll_options, &$poll_length)
#
#-----[ IN-LINE FIND ]---------------------------------------------
#
&$poll_length
#
#-----[ IN-LINE AFTER, ADD ]---------------------------------------------
#
, &$max_vote, &$hide_vote, &$undo_vote
#
#-----[ FIND ]---------------------------------------------
#
		$sql = (!$post_data['has_poll']) ? "INSERT INTO " . VOTE_DESC_TABLE . " (topic_id, vote_text, vote_start, vote_length) VALUES ($topic_id, '$poll_title', $current_time, " . ($poll_length * 86400) . ")" : "UPDATE " . VOTE_DESC_TABLE . " SET vote_text = '$poll_title', vote_length = " . ($poll_length * 86400) . " WHERE topic_id = $topic_id";
#
#-----[ IN-LINE FIND ]---------------------------------------------
#
vote_length
#
#-----[ IN-LINE AFTER, ADD ]---------------------------------------------
#
, vote_max, vote_hide, vote_undo
#
#-----[ IN-LINE FIND ]---------------------------------------------
#
$current_time, " . ($poll_length * 86400) . "
#
#-----[ IN-LINE AFTER, ADD ]---------------------------------------------
#
, '$max_vote', '$hide_vote', '$undo_vote'
#
#-----[ IN-LINE FIND ]---------------------------------------------
#
vote_length = " . ($poll_length * 86400) . "
#
#-----[ IN-LINE AFTER, ADD ]---------------------------------------------
#
, vote_max = '$max_vote', vote_hide = '$hide_vote', vote_undo = '$undo_vote'
#
#-----[ OPEN ]---------------------------------------------
#
language/lang_english/lang_main.php
#
#-----[ FIND ]---------------------------------------------
#
$lang['Hours'] = 'Hours';
#
#-----[ BEFORE, ADD ]---------------------------------------------
#
$lang['Hour'] = 'Hour';
#
#-----[ FIND ]---------------------------------------------
#
$lang['Total_votes'] = 'Total Votes';
#
#-----[ REPLACE WITH ]---------------------------------------------
#
//
// Vote Manager MOD
//
$lang['Csv_novote'] = '';	//	default display is blank for choices not voted for
$lang['Csv_vote'] = 'X';	//	default display is a capital X for choices voted for
$lang['Detailed_results'] = 'Detailed Results';
$lang['Error_poll_early'] = 'This poll was created before the Vote Manager MOD was in place, so specific vote information is unavailable.';
$lang['Error_poll_query'] = 'Could not query polls';
$lang['Export_csv'] = 'Export Data as a CSV File';
$lang['Poll_expires'] = 'Poll expires in ';
$lang['Poll_expired'] = 'This poll has expired.'; 
$lang['Poll_hidden'] = 'Detailed results have been disabled on this poll.';
$lang['Poll_noexpire'] = 'This poll does not expire'; 
$lang['Poll_no_undo'] = 'Undoing your votes has been disabled.';
$lang['Poll_return'] = 'To return to the poll results, click %shere%s';
$lang['Minute'] = 'Minute';
$lang['Minutes'] = 'Minutes';
$lang['No_votes'] = 'No one has voted for this option';
$lang['Remove_votes'] = 'Are you sure you wish to remove these votes?';
$lang['Results_after'] = 'Results will be visible after the poll expires';
$lang['Sort_by_option'] = 'Votes sorted by options';
$lang['Sort_by_question'] = '(sorted by question)';
$lang['Sort_by_topic'] = '(sorted by topic)';
$lang['Sort_by_user'] = 'Votes sorted by users';
$lang['Total_votes'] = 'Total Votes : ';
$lang['Undo_no_votes'] = 'You have not voted on anything yet!';
$lang['Undo_vote'] = '[ remove ]';
$lang['Voted_show'] = 'Users Voted : ';
$lang['Votes_removed'] = 'The votes were successfully removed';
#
#-----[ FIND ]---------------------------------------------
#
$lang['Already_voted'] = 'You have already voted in this poll.';
#
#-----[ REPLACE WITH ]---------------------------------------------
#
$lang['Already_voted'] = 'You have already voted in this poll, or you have attempted to vote on too many options at once.';
#
#-----[ FIND ]---------------------------------------------
#
$lang['Days'] = 'Days'; // This is used for the Run poll for ... Days + in admin_forums for pruning
#
#-----[ BEFORE, ADD ]---------------------------------------------
#
$lang['Day'] = 'Day';
#
#-----[ FIND ]---------------------------------------------
#
$lang['Delete_poll'] = 'Delete Poll';
#
#-----[ AFTER, ADD ]---------------------------------------------
#
//
// Vote Manager MOD
//
$lang['Allow_undo'] = 'Allow users to undo/change their votes';
$lang['Also_hide_simple'] = 'Also Hide Simple Results (until expires)';
$lang['Also_hide_voters'] = 'Also Hide Number of Voters (until expires)';
$lang['Hide_detailed_results'] = 'Hide Detailed Results';
$lang['Hide_vote'] = 'Results';
$lang['Hide_vote_explain'] = '[ Hide until poll expires ]';
$lang['Max_vote'] = 'Maximum selections';
$lang['Max_vote_explain'] = '[ Enter 1 or leave blank to allow only one selection ]';
$lang['Max_voting_1_explain'] = 'Please select at most ';
$lang['Max_voting_2_explain'] = ' choices';
$lang['Undo_votes'] = 'Undo Votes';
$lang['Until_exp'] = 'until expires';
$lang['Vhide'] = 'Hide';
#
#-----[ OPEN ]---------------------------------------------
#
templates/subSilver/posting_poll_body.tpl
#
#-----[ FIND ]---------------------------------------------
#
            <tr>
				<td class="row1"><span class="gen"><b>{L_POLL_OPTION}</b></span></td>
				<td class="row2"><span class="genmed"><input type="text" name="add_poll_option_text" size="50" maxlength="255" class="post" value="{ADD_POLL_OPTION}" /></span> &nbsp;<input type="submit" name="add_poll_option" value="{L_ADD_OPTION}" class="liteoption" /></td>
			</tr>
#
#-----[ AFTER, ADD ]---------------------------------------------
#
            <tr>
				<td class="row1"><span class="gen"><b>{L_MAX_VOTE}</b></span></td>
				<td class="row2"><span class="genmed"><input type="text" name="max_vote" size="3" maxlength="3" class="post" value="{MAX_VOTE}" /></span>&nbsp;<span class="gen"><b>{L_OPTIONS}</b></span> &nbsp; <span class="gensmall">{L_MAX_VOTE_EXPLAIN}</span></td>
			</tr>
#
#-----[ FIND ]---------------------------------------------
#
				<td class="row2"><span class="genmed"><input type="text" name="poll_length" size="3" maxlength="3" class="post" value="{POLL_LENGTH}" /></span>&nbsp;<span class="gen"><b>{L_DAYS}</b></span> &nbsp; <span class="gensmall">{L_POLL_LENGTH_EXPLAIN}</span></td>
			</tr>
#
#-----[ REPLACE WITH ]---------------------------------------------
#
				<td class="row2"><span class="genmed"><input type="text" name="poll_length" size="3" maxlength="3" class="post" value="{POLL_LENGTH}" /></span>&nbsp;<span class="gen"><b>{L_DAYS}</b></span>
					<span class="genmed"><input type="text" name="poll_length_h" size="3" maxlength="3" class="post" value="{POLL_LENGTH_H}" /></span>&nbsp;<span class="gen"><b>{L_HOURS}</b></span>&nbsp; <span class="gensmall">{L_POLL_LENGTH_EXPLAIN}</span></td>
			</tr>
            <tr>
				<td class="row1"><span class="gen"><b>{L_VHIDE}</b></span></td>
				<td class="row2" class="gen"><span class="gensmall">
				  <input type="checkbox" name="hide_dr" {HIDE_DR}/> {L_HIDE_DR} 
				  ( <input type="checkbox" name="hide_exp" {HIDE_DR_EXP}/> {L_HIDE_DR_EXP} )</span><br />
				  <span style="background: url('{IMG_LIST_BRANCH0}') top left no-repeat; padding-left: 19px;" class="gensmall">
					<input type="checkbox" name="hide_sr" {HIDE_SR}/> {L_HIDE_SR}</span><br />
				  <span style="background: url('{IMG_LIST_BRANCH1}') top left no-repeat; padding-left: 39px;" class="gensmall">
					<input type="checkbox" name="hide_voters" {HIDE_VOTERS}/> {L_HIDE_VOTERS}</span></td>
			</tr>
			<tr>
				<td class="row1"><span class="gen"><b>{L_UNDO}</b></span></td>
				<td class="row2"><input type="checkbox" name="undo_vote" {UNDO_VOTE} /> <span class="gensmall">{L_UNDO_VOTE}</span></td>
			</tr>
#
#-----[ OPEN ]---------------------------------------------
#
templates/subSilver/viewtopic_poll_ballot.tpl
#
#-----[ FIND ]---------------------------------------------
#
			<tr>
				<td class="row2" colspan="2"><br clear="all" /><form method="POST" action="{S_POLL_ACTION}"><table cellspacing="0" cellpadding="4" border="0" align="center">
#
#-----[ AFTER, ADD ]---------------------------------------------
#
					<tr>
						<td align="center"><span class="gen"><b>{MAX_VOTING_1_EXPLAIN}{MAX_VOTE}{MAX_VOTING_2_EXPLAIN}{POLL_VOTE_BR}</b> {POLL_VOTE_BR}{POLL_VOTE_BR}</span></td>
					</tr>
#
#-----[ FIND ]---------------------------------------------
#
								<td><input type="radio" name="vote_id" value="{poll_option.POLL_OPTION_ID}" />&nbsp;</td>
#
#-----[ REPLACE WITH ]---------------------------------------------
#
								<td><input type="{poll_option.POLL_VOTE_BOX}" name="vote_id[]" value="{poll_option.POLL_OPTION_ID}" {poll_option.POLL_OPTION_DISABLED}/>&nbsp;</td>
#
#-----[ OPEN ]---------------------------------------------
#
templates/subSilver/viewtopic_poll_result.tpl
#
#-----[ FIND ]---------------------------------------------
#
	  <tr> 
		<td colspan="4" align="center"><span class="gen"><b>{L_TOTAL_VOTES} : {TOTAL_VOTES}</b></span></td>
	  </tr>
#
#-----[ REPLACE WITH ]---------------------------------------------
#
	  <!-- BEGIN voted -->
	  <tr> 
		<td colspan="4" align="center"><span class="gen"><b>{voted.L_VOTED}{voted.VOTED}</b></span></td>
	  </tr>
	  <!-- END voted -->
	  <!-- BEGIN total -->
	  <tr> 
		<td colspan="4" align="center"><span class="gen"><b>{total.L_TOTAL_VOTES}{total.TOTAL_VOTES}</b></span></td>
	  </tr>
	  <!-- END total -->
	  <!-- BEGIN after -->
	  <tr> 
		<td colspan="4" align="center"><span class="gensmall">{after.L_RESULTS_AFTER}</span></td>
	  </tr>
	  <!-- END after -->
	  <!-- BEGIN expires -->
	  <tr> 
		<td colspan="4" align="center"><span class="gensmall">{expires.L_POLL_EXPIRES}{expires.POLL_EXPIRES}</span></td>
	  </tr>
	  <!-- END expires -->
	  <!-- BEGIN vote_manage -->
	  <tr>
	    <td colspan="4" align="center"><span class="gensmall">{vote_manage.VOTE_MANAGE}</span></td>
	  </tr>
	  <!-- END vote_manage -->
#
#-----[ OPEN ]---------------------------------------------
#
templates/subSilver/subSilver.cfg
#
#-----[ FIND ]---------------------------------------------
#
//
// Vote graphic length defines the maximum length of a vote result
#
#-----[ BEFORE, ADD ]---------------------------------------------
#
$images['list_branch'][0] = "$current_template_images/list_branch0.gif";
$images['list_branch'][1] = "$current_template_images/list_branch1.gif";
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM