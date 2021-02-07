##############################################################
## MOD Title: 		Topic Cement!
## MOD Author: 		Renegade88 < renegade88@marino.st > (John Marino) http://www.marino.st
## MOD Description: 	
##			This mod will allow the moderator to set a priority for any topic.
## 			The default priority is zero; all topics with a priority of zero
##			are sorted as they always have been: First by type, and then by
##			descending topic id.  This mod inserts a new sort: First by type, 
##			then by priority (Descending), and then topic id (descending).
##			It adds a text field in the moderator control panel to assign 
##			or remove priority from any topic.
##			
##			The intent of this mod is to be used in a forum of announcements or,
##			in my case, a forum dedicated to distributing official attachments.
##			The users can reply to my attachment post, but I don't want the order
##			of the posts to change, so this mod "cements" the order.  Or think of
##			it as moderator-definable stickiness!
##
## MOD Version: 1.0.3
## 
## Installation Level:	intermediate (required SQL query execution from file)
## Installation Time:	5 Minutes
## Files To Edit: 	
##			templates/subSilver/modcp_body.tpl
##			modcp.php
##			viewforum.php
##			language/lang_english/lang_main.php
## Included Files: 	
##			topic_cement_1.0_install.mod
##############################################################
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
##############################################################
## Author Notes: 	The priority datatype is a signed "smallint" which means the legal range
##			for the priority is ±32768.  For the intent of maintaining small dedicated
##			forums, this is overkill.  Theoretically an unsigned tinyint should be
##			sufficient.  Feel free to modify the query if you agree.	
##############################################################
## MOD History: 
## 
##   2004-03-15 - Version 1.0.0 
##      - Initial release 
##   2004-08-21 - Version 1.0.1
##      - Updated for phpBB 2.0.10 security,  intval($topics[$i])
##      - Changed instructions to use inline changes per MOD Leader request
##   2004-08-25 - Version 1.0.2
##      - Fixed bug introduced by converting to inline changes :(
##   2004-08-30 - Version 1.0.3
##      - Submission of 8-25 was flawed, resubmitted
## 
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################

# 
#-----[ SQL ]------------------------------------------ 
# 
ALTER TABLE phpbb_topics ADD topic_priority SMALLINT DEFAULT '0' NOT NULL;
#
#-----[ OPEN ]------------------------------------------ 
#
templates/subSilver/modcp_body.tpl
#
#-----[ FIND ]------------------------------------------ 
#
	<td class="catHead" colspan="5" align="center" height="28"><span class="cattitle">{L_MOD_CP}</span>
#
#-----[ IN-LINE FIND ]------------------------------------------ 
#
colspan="5"
#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------ 
#
colspan="6"
#
#-----[ FIND ]------------------------------------------ 
#
	  <td class="spaceRow" colspan="5" align="center"><span class="gensmall">{L_MOD_CP_EXPLAIN}</span></td>
#
#-----[ IN-LINE FIND ]------------------------------------------ 
#
colspan="5"
#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------ 
#
colspan="6"
#
#-----[ FIND ]------------------------------------------ 
#
	  <th width="5%" class="thRight" nowrap="nowrap">&nbsp;{L_SELECT}&nbsp;</th>
#
#-----[ REPLACE WITH ]------------------------------------------ 
#
	  <th width="5%" nowrap="nowrap">&nbsp;{L_SELECT}&nbsp;</th>
	  <th width="10%" class="thRight" nowrap="nowrap">&nbsp;{L_PRIORITY}&nbsp;</th>
#
#-----[ FIND ]------------------------------------------ 
#
	  <td class="row2" align="center" valign="middle"> 
		<input type="checkbox" name="topic_id_list[]" value="{topicrow.TOPIC_ID}" />
	  </td>
#
#-----[ AFTER, ADD ]------------------------------------------ 
#
	  <td class="row1" align="center" valign="middle"> 
		<input type="Text" name="topic_cement:{topicrow.TOPIC_ID}" value="{topicrow.TOPIC_PRIORITY}" maxlength="5" size="5" />
	  </td>
#
#-----[ FIND ]------------------------------------------ 
#
	  <td class="catBottom" colspan="5" height="29"> {S_HIDDEN_FIELDS} 
#
#-----[ IN-LINE FIND ]------------------------------------------ 
#
colspan="5"
#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------ 
#
colspan="6"
#
#-----[ FIND ]------------------------------------------ 
#
		<input type="submit" name="unlock" class="liteoption" value="{L_UNLOCK}" />
#
#-----[ AFTER, ADD ]------------------------------------------ 
#
		&nbsp;
		<input type="submit" name="cement" class="liteoption" value="{L_PRIORITIZE}" />
#
#-----[ OPEN ]------------------------------------------ 
#
viewforum.php
#
#-----[ FIND ]------------------------------------------ 
#
	ORDER BY t.topic_last_post_id DESC ";
#
#-----[ IN-LINE FIND ]------------------------------------------ 
#
ORDER BY 
#
#-----[ IN-LINE REPLACE WITH ]------------------------------------------ 
#
ORDER BY t.topic_priority DESC, 
#
#-----[ FIND ]------------------------------------------ 
#
	ORDER BY t.topic_type DESC, t.topic_last_post_id DESC 
#
#-----[ IN-LINE FIND ]------------------------------------------ 
#
t.topic_type DESC
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
#
, t.topic_priority DESC
#
#-----[ OPEN ]------------------------------------------ 
#
modcp.php
#
#-----[ FIND ]------------------------------------------ 
#
$unlock = ( isset($HTTP_POST_VARS['unlock']) ) ? TRUE : FALSE;
#
#-----[ AFTER, ADD ]------------------------------------------ 
#
$cement = ( isset($HTTP_POST_VARS['cement']) ) ? TRUE : FALSE;
#
#-----[ FIND ]------------------------------------------ 
#
	else if ( $unlock )
	{
		$mode = 'unlock';
	}
#
#-----[ AFTER, ADD ]------------------------------------------ 
#
	else if ( $cement )
	{
		$mode = 'cement';
	}
#
#-----[ FIND ]------------------------------------------ 
#
	default:
#
#-----[ BEFORE, ADD ]------------------------------------------ 
#
	case 'cement':
		if ( empty($HTTP_POST_VARS['topic_id_list']) && empty($topic_id) )
		{
			message_die(GENERAL_MESSAGE, $lang['None_selected']);
		}

		$topics = ( isset($HTTP_POST_VARS['topic_id_list']) ) ?  $HTTP_POST_VARS['topic_id_list'] : array($topic_id);

		for($i = 0; $i < count($topics); $i++)
		{
			$priority_box_id = "topic_cement:" . intval($topics[$i]);
			$topic_priority = (isset($HTTP_POST_VARS[$priority_box_id])) ? 
				intval($HTTP_POST_VARS[$priority_box_id]) : 0;
			$sql = "UPDATE " . TOPICS_TABLE . " 
 				SET topic_priority = $topic_priority
 				WHERE topic_id = ".$topics[$i];
 			if ( !($result = $db->sql_query($sql)) )
 			{
 				message_die(GENERAL_ERROR, 'Could not update topics table', '', __LINE__, __FILE__, $sql);
 			}

		}

		if ( !empty($topic_id) )
		{
			$redirect_page = "viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;sid=" . $userdata['session_id'];
			$message = sprintf($lang['Click_return_topic'], '<a href="' . $redirect_page . '">', '</a>');
		}
		else
		{
			$redirect_page = "modcp.$phpEx?" . POST_FORUM_URL . "=$forum_id&amp;sid=" . $userdata['session_id'];
			$message = sprintf($lang['Click_return_modcp'], '<a href="' . $redirect_page . '">', '</a>');
		}

		$message = $message . '<br \><br \>' . sprintf($lang['Click_return_forum'], '<a href="' . "viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id&amp;sid=" . $userdata['session_id'] . '">', '</a>');

		$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . $redirect_page . '">')
		);

		message_die(GENERAL_MESSAGE, $lang['Topics_Prioritized'] . '<br /><br />' . $message);

		break;
#
#-----[ FIND ]------------------------------------------ 
#
			'L_SELECT' => $lang['Select'], 
#
#-----[ AFTER, ADD ]------------------------------------------ 
#
			'L_PRIORITY' =>   $lang['Priority'], 
			'L_PRIORITIZE' => $lang['Prioritize'], 
#
#-----[ FIND ]------------------------------------------ 
#
			ORDER BY t.topic_type DESC, p.post_time DESC
#
#-----[ IN-LINE FIND ]------------------------------------------ 
#
t.topic_type DESC
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
#
, t.topic_priority DESC
#
#-----[ FIND ]------------------------------------------ 
#
			$topic_status = $row['topic_status'];
#
#-----[ AFTER, ADD ]------------------------------------------ 
#
			$topic_priority = $row['topic_priority'];
#
#-----[ FIND ]------------------------------------------ 
#
				'TOPIC_ID' => $topic_id,
#
#-----[ AFTER, ADD ]------------------------------------------ 
#
				'TOPIC_PRIORITY' => $topic_priority,
##
## --- NOTE: You will have to make the following changes to ALL languages that  ---
## ---       you plan to support on your board.  I use "English" as an example  ---
##
# 
#-----[ OPEN ]------------------------------------------ 
# 
language/lang_english/lang_main.php
#
#-----[ FIND ]------------------------------------------ 
# full line is
# $lang['No_Topics_Moved'] = 'No topics were moved.';
$lang['No_Topics_Moved']
#
#-----[ AFTER, ADD ]------------------------------------------ 
#
$lang['Topics_Prioritized'] = 'The selected topics have been prioritized.';
$lang['Priority'] = 'Priority';
$lang['Prioritize'] = 'Prioritize';
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
#
# EoM 
