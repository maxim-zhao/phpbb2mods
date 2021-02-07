#################################################################
## MOD Title: Last topic name (Viewprofile)
## MOD Version: 1.0.1
## MOD Author: kkroo < princeomz2004@hotmail.com > ( Omar Ramadan ) http://phpbb-login.strangled.net
## MOD Author: Afterlife(69) < afterlife_69@hotmail.com > ( Dean Newman ) http://www.ugboards.com
## MOD Description: This modification will add the title of the last topic you posted in to your profile
##
## Installation Level: Easy
## Installation Time: 5 Minutes
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
##	-	fixed up the while loop, pointed out by drathburn
##
##	2006-9-07 - Version 1.0.0
##	-	Mod ready for mod db
## 
##	2005-12-17 - Version 0.1.0
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
$search = '<a href="' . $temp_url . '">

#
#-----[ AFTER, ADD ]------------------------------------------
#
//
// Last post in profile MOD
//
$topic_title = '';
$icon_minipost = '';
$sql = "SELECT t.*, p.post_time, p.post_id
	FROM " . TOPICS_TABLE . " t, " . POSTS_TABLE . " p 
		WHERE p.topic_id = t.topic_id 
			AND p.poster_id = " . $profiledata['user_id'] . "
				ORDER BY p.post_time DESC"; 
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not query new topic information', '', __LINE__, __FILE__, $sql);
}

//
// Get user's auth
//
$is_auth_ary = array();
$is_auth_ary = auth(AUTH_ALL, AUTH_LIST_ALL, $userdata);

$post_found = false;
while( ( ! $post_found ) && ( $row = $db->sql_fetchrow($result) ) )
{
	if( $is_auth_ary[$row['forum_id']]['auth_read'] )
	{
		$topic_title = $row['topic_title'];
		$ttpmod_topic_valid = true;
		$post_found = true;
		$postdata = $row;
	}
	
}
if(!$topic_title)
{
	$topic_title = $lang['TTPMOD_NOTOPIC'];
	$ttpmod_topic_valid = false;
}

// Define censored word matches
$orig_word = array();
$replacement_word = array();
obtain_word_list($orig_word, $replacement_word);

// Censor topic title
if( count($orig_word) )
{
	$topic_title = preg_replace($orig_word, $replacement_word, $topic_title);
}

// Create link for topic title
if($ttpmod_topic_valid)
{
	$topic_title = '<a class="topictitle" title="' . $topic_title . '" href="' . append_sid("viewtopic.$phpEx?t=" . $postdata['topic_id']) . '">' . $topic_title . '</a>';
	$icon_minipost = '<a href="' . append_sid("viewtopic.$phpEx?"  . POST_POST_URL . '=' . $postdata['post_id']) . '#' . $postdata['post_id'] . '"><img src="' . $images['icon_latest_reply'] . '" border="0" alt="' . $lang['View_latest_post'] . '" title="' . $lang['View_latest_post'] . '" /></a>';
}

#
#-----[ FIND ]------------------------------------------
#
'POST_PERCENT_STATS' =>

#
#-----[ AFTER, ADD ]------------------------------------------
#
	'LAST_POST_TOPIC' => $topic_title,
	'LAST_POST_ICON' => $icon_minipost,

#
#-----[ FIND ]------------------------------------------
#
'L_INTERESTS' =>

#
#-----[ AFTER, ADD ]------------------------------------------
#
	'L_LAST_POST_TOPIC' => $lang['TTPMOD_LANG_TITLE'],
	
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
$lang['TTPMOD_NOTOPIC'] = 'This user has not posted.';
$lang['TTPMOD_LANG_TITLE'] = 'Last post';

#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/profile_view_body.tpl

#
#-----[ FIND ]------------------------------------------
#
		  <td width="100%"><b><span class="gen">{JOINED}</span></b></td>
		</tr>

#
#-----[ AFTER, ADD ]------------------------------------------
#
		<tr> 
		  <td valign="middle" align="right" nowrap="nowrap"><span class="gen">{L_LAST_POST_TOPIC}:&nbsp;</span></td>
		  <td><b><span class="topictitle">{LAST_POST_TOPIC}&nbsp;{LAST_POST_ICON}</span></b></td>
		</tr>

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM