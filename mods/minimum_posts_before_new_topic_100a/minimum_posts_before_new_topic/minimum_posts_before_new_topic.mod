##############################################################
## MOD Title: Minimum posts to start a new topic
## MOD Author: kkroo < princeomz2004@gmail.com > (Omar Ramadan) http://phpbb-login.strangled.net
## MOD Description: Add a new restriction to your forums, minimum posts to start a new topic. If the users post count is below the restriction, they are not allowed to start a new topic. This number can be changed in the admin panel for every indivisual forum.
## MOD Version: 1.0.0
## 
## Installation Level: Easy
## Installation Time: 2 minutes
## Files To Edit: posting.php
##                admin/admin_forums.php
##                language/lang_english/lang_admin.php
##                language/lang_english/lang_main.php
##                templates/subSilver/admin/forum_edit_body.tpl
## Included Files: 
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2
## Generator: MOD Studio [ ModTemplateTools 1.0.2108.38030 ]
##############################################################
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/
##############################################################
## Author Notes: Mod requested by mariocaz
##############################################################
## MOD History:
## 
## 2006-06-08 - Version 1.0.0
## Ready for mod DB
## 
## 2006-06-08 - Version 0.1.0
## Added enable disable button in the admin panel, changed minimum posts from 10 to 5
## 
## 2006-06-07 - Version 0.0.0
## Initial Release
## 
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
##############################################################

#
#-----[ OPEN ]------------------------------------------
#
posting.php
#
#-----[ FIND ]------------------------------------------
#
	if ( $mode == 'poll_delete' && !isset($poll_id) )
	{
		message_die(GENERAL_MESSAGE, $lang['No_such_post']);
	}
#
#-----[ AFTER, ADD ]------------------------------------------
#

	// 
	// Start minimum posts to start new topic MOD
	//
	if ( $mode == 'newtopic' )
	{	
		if ($userdata['session_logged_in'] && $post_info['minimum_posts_enabled'] && $post_info['minimum_posts'] > $userdata['user_posts'] && !$is_auth['auth_mod'] )
		{
			message_die(GENERAL_MESSAGE, sprintf($lang['minimum_posts_new_topic'], $post_info['minimum_posts']));
		}
	}
	// 
	// End  minimum posts to start new topic MOD
	//
	
#
#-----[ OPEN ]------------------------------------------
#
admin/admin_forums.php

#
#-----[ FIND ]------------------------------------------
#
				$forumstatus = $row['forum_status'];
#
#-----[ AFTER, ADD ]------------------------------------------
#
				$minimum_posts = ( empty($row['minimum_posts'] ) ) ? '5' : $row['minimum_posts'];
				$minimum_posts_enabled = ( $row['minimum_posts_enabled'] == '1' ) ? "checked=\"checked\"" : '';
#
#-----[ FIND ]------------------------------------------
#
				'L_DAYS' => $lang['Days'],
#
#-----[ AFTER, ADD ]------------------------------------------
#
				'L_MINIMUM_POSTS' => $lang['Minimum_posts_before_new_topic'],
				'L_MINIMUM_POSTS_NUMBER' => $lang['Minimum_posts_before_new_topic_number'],
#
#-----[ FIND ]------------------------------------------
#
				'FORUM_NAME' => $forumname,
#
#-----[ AFTER, ADD ]------------------------------------------
#
				'MINIMUM_POSTS' => $minimum_posts,
				'S_MINIMUM_POSTS_ENABLED' => $minimum_posts_enabled,
#
#-----[ FIND ]------------------------------------------
#
			$sql = "INSERT INTO " . FORUMS_TABLE . " (forum_id, forum_nam
#
#-----[ IN-LINE FIND ]------------------------------------------
#
forum_status,
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
 minimum_posts, minimum_posts_enabled, 
#
#-----[ FIND ]------------------------------------------
#
				VALUES ('" . $next_id . "', '" . str_replace("\'", "'
#
#-----[ IN-LINE FIND ]------------------------------------------
#
" . intval($HTTP_POST_VARS['forumstatus']) . ",
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
 " . intval($HTTP_POST_VARS['minimum_posts']) . ", " . intval($HTTP_POST_VARS['minimum_posts_enabled']) . ", 
#
#-----[ FIND ]------------------------------------------
#
				SET forum_name = '" . str_replace("\
#
#-----[ IN-LINE FIND ]------------------------------------------
#
forum_status = " . intval($HTTP_POST_VARS['forumstatus']) . "
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, minimum_posts = '" . intval($HTTP_POST_VARS['minimum_posts']) . "'" . ", minimum_posts_enabled = '" . intval($HTTP_POST_VARS['minimum_posts_enabled']) . "'" . "
#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_admin.php
#
#-----[ FIND ]------------------------------------------
#
//
// That's all Folks!
// -------------------------------------------------
#
#-----[ BEFORE, ADD ]------------------------------------------
#

//
//minimum posts to start new topic MOD
//
$lang['Minimum_posts_before_new_topic'] = 'Minimum posts to start a new topic';
$lang['Minimum_posts_before_new_topic_number'] = 'Minimum posts';


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

//
//minimum posts to start new topic MOD
//
$lang['minimum_posts_new_topic'] = 'You must have %s posts before you can start a new topic';


#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/admin/forum_edit_body.tpl
#
#-----[ FIND ]------------------------------------------
#
	<tr> 
	  <td class="row1">{L_FORUM_STATUS}</td>
	  <td class="row2"><select name="forumstatus">{S_STATUS_LIST}</select></td>
	</tr>
#
#-----[ AFTER, ADD ]------------------------------------------
#

	<tr> 
	  <td class="row1">{L_MINIMUM_POSTS}</td>
	  <td class="row2"><table cellspacing="0" cellpadding="1" border="0">
		  <tr> 
			<td align="right" valign="middle">{L_ENABLED}</td>
			<td align="left" valign="middle"><input type="checkbox" name="minimum_posts_enabled" value="1" {S_MINIMUM_POSTS_ENABLED} /></td>
		  </tr>
		  <tr> 
			<td align="right" valign="middle">{L_MINIMUM_POSTS_NUMBER}</td>
			<td align="left" valign="middle">&nbsp;<input type="text" name="minimum_posts" value="{MINIMUM_POSTS}" size="5" class="post" /></td>
		  </tr>
	  </table></td>
	</tr>

#
#-----[ SQL ]------------------------------------------
#
# change phpbb_ to what your phpBB DB extension is.
ALTER TABLE `phpbb_forums` ADD `minimum_posts` MEDIUMINT(8) NOT NULL ;
ALTER TABLE `phpbb_forums` ADD `minimum_posts_enabled` TINYINT NOT NULL ;
UPDATE `phpbb_forums` SET `minimum_posts` = '5';
UPDATE `phpbb_forums` SET `minimum_posts_enabled` = '0';
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
