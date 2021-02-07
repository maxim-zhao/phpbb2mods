############################################################## 
## MOD Title: Moderator Pruning Controls
## MOD Author: Graham <phpbb@grahameames.co.uk> (Graham Eames) http://www.grahameames.co.uk/phpbb/
## MOD Description: This MOD adds an additional "prune" option
## to the moderator control panel and viewtopic pages. 
## The prune option deletes the posts, like the delete option,
## but without affecting the post counts of those who have posted
## in the topic(s)
##
## MOD Version: 1.0.3
## 
## Installation Level: Easy 
## Installation Time: 5 Minutes 
## Files To Edit:
##	templates/subSilver/subSilver.cfg
##	templates/subSilver/modcp_body.tpl
##	language/lang_english/lang_main.php
##	modcp.php
##	viewtopic.php
## Included Files: topic_prune.gif
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## MOD History:
## Mar 26, 2004 - Version 1.0.3
##  - Fixed missing assignment of L_PRUNE in modcp.php
## Nov 29, 2003 - Version 1.0.1
##  - Updates suggested by MOD Team to reduce code size and improve
##    compatability with other MODs
## Oct 29, 2003 - Version 1.0.0
##  - Initial Release for phpBB 2.0.6
############################################################## 
## Author Notes: 
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ COPY ]------------------------------------------ 
# 
copy topic_prune.gif to templates/subSilver/images/topic_prune.gif 

# 
#-----[ OPEN ]------------------------------------------ 
# 
templates/subSilver/subSilver.cfg

# 
#-----[ FIND ]------------------------------------------ 
# 
$images['topic_mod_delete'] = "$current_template_images/topic_delete.gif";

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
$images['topic_mod_prune'] = "$current_template_images/topic_prune.gif"; // Added by Moderator Pruning Controls MOD

# 
#-----[ OPEN ]------------------------------------------ 
# 
templates/subSilver/modcp_body.tpl

# 
#-----[ FIND ]------------------------------------------ 
# 
		<input type="submit" name="delete" class="liteoption" value="{L_DELETE}" />

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
		&nbsp;
		<input type="submit" name="prune" class="liteoption" value="{L_PRUNE}" />

# 
#-----[ OPEN ]------------------------------------------ 
# 
language/lang_english/lang_main.php

# 
#-----[ FIND ]------------------------------------------ 
# 
$lang['Delete_topic'] = 'Delete this topic';

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
$lang['Prune_topic'] = 'Prune this topic'; // Added by Moderator Pruning Controls MOD

# 
#-----[ FIND ]------------------------------------------ 
# 
$lang['Delete'] = 'Delete';

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
$lang['Prune'] = 'Prune'; // Added by Moderator Pruning Controls MOD

# 
#-----[ FIND ]------------------------------------------ 
# 
$lang['Confirm_delete_topic'] = 'Are you sure you want to remove the selected topic/s?';

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
$lang['Confirm_prune_topic'] = 'Are you sure you want to prune the selected topic/s?'; // Added by Moderator Pruning Controls MOD

# 
#-----[ OPEN ]------------------------------------------ 
# 
viewtopic.php

# 
#-----[ FIND ]------------------------------------------ 
# 
	$topic_mod .= "<a href=\"modcp.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;mode=delete&amp;sid=" . $userdata['session_id'] . '"><img src="' . $images['topic_mod_delete'] . '" alt="' . $lang['Delete_topic'] . '" title="' . $lang['Delete_topic'] . '" border="0" /></a>&nbsp;';

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
	$topic_mod .= "<a href=\"modcp.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;mode=prune&amp;sid=" . $userdata['session_id'] . '"><img src="' . $images['topic_mod_prune'] . '" alt="' . $lang['Prune_topic'] . '" title="' . $lang['Prune_topic'] . '" border="0" /></a>&nbsp;'; // Added by Moderator Pruning Controls MOD

# 
#-----[ FIND ]------------------------------------------ 
# 
	'L_DELETE_TOPIC' => $lang['Delete_topic'],

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
	'L_PRUNE_TOPIC' => $lang['Prune_topic'], // Added by Moderator Pruning Controls MOD

# 
#-----[ OPEN ]------------------------------------------ 
# 
modcp.php

# 
#-----[ FIND ]------------------------------------------ 
# 
$delete = ( isset($HTTP_POST_VARS['delete']) ) ? TRUE : FALSE;

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
$prune = ( isset($HTTP_POST_VARS['prune']) ) ? TRUE : FALSE; // Added by Moderator Pruning Controls MOD

# 
#-----[ FIND ]------------------------------------------ 
# 
	if ( $delete )
	{
		$mode = 'delete';
	}

# 
#-----[ AFTER, ADD ]------------------------------------------ 
#
	// Added by Moderator Pruning Controls MOD
	else if ( $prune )
	{
		$mode = 'prune';
	}
	// End addition by Moderator Pruning Controls MOD

# 
#-----[ FIND ]------------------------------------------ 
# 
   case 'delete':

#
#-----[ AFTER, ADD ]------------------------------------------
#
   case 'prune':

#
#-----[ FIND ]------------------------------------------
#
         $sql = "SELECT poster_id, COUNT(post_id) AS posts
            FROM " . POSTS_TABLE . "
            WHERE topic_id IN ($topic_id_sql)
            GROUP BY poster_id";

#
#-----[ BEFORE, ADD ]------------------------------------------
#
if ($mode != 'prune')
{

#
#-----[ FIND ]------------------------------------------
#
         $sql = "SELECT post_id
            FROM " . POSTS_TABLE . "
            WHERE topic_id IN ($topic_id_sql)";

#
#-----[ BEFORE, ADD ]------------------------------------------
#
}

#
#-----[ FIND ]------------------------------------------
#
				'MESSAGE_TEXT' => $lang['Confirm_delete_topic'],

#
#-----[ IN-LINE FIND ]------------------------------------------
#
$lang['Confirm_delete_topic']

#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------
#
($mode == 'prune') ? $lang['Confirm_prune_topic'] : 

#
#-----[ FIND ]------------------------------------------
#
			'L_DELETE' => $lang['Delete'],
			'L_MOVE' => $lang['Move'],
			'L_LOCK' => $lang['Lock'],
			'L_UNLOCK' => $lang['Unlock'],
#
#-----[ AFTER, ADD ]------------------------------------------
#
			'L_PRUNE' => $lang['Prune'],

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 