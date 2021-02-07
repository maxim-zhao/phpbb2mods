############################################################## 
## MOD Title: Disable Post Count Increase
## MOD Author: Xore < xore@azuriah.com > (Robert Hetzler) http://www.azuriah.com 
## MOD Description: This mod enables you to selectively turn off post count increments on each forum 
## MOD Version: 1.0.1 
## 
## Installation Level: (Easy) 
## Installation Time: 2 Minutes 
## Files To Edit: includes/functions_post.php,
##                admin/admin_forums.php
##                language/lang_english/lang_admin.php
##                templates/subSilver/admin/forum_edit_body.tpl
## Included Files: (n/a) 
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes: 
## 
############################################################## 
## MOD History: 
## 
##   2003-09-21 - Version 1.0.0 
##      - Initial release 
##   2003-09-23 - Version 1.0.1 
##      - Comma error fixed, fixed "Files To Edit" 
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ SQL ]------------------------------------------ 
# Change the prefix 'phpbb_' accordingly. 'phpbb_' is the default prefix
#
ALTER TABLE phpbb_forums ADD forum_postcount TINYINT( 1 ) DEFAULT '1' NOT NULL;
# 
#-----[ OPEN ]------------------------------------------ 
# 
includes/functions_post.php
# 
#-----[ FIND ]------------------------------------------ 
# 
		$sql = "UPDATE " . USERS_TABLE . "
# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
		$sql = "SELECT forum_postcount
			FROM " . FORUMS_TABLE . "
			WHERE forum_id = $forum_id AND forum_postcount = 0";
		if (!($result = $db->sql_query($sql)))
		{
			message_die(GENERAL_ERROR, 'Error in deleting post', '', __LINE__, __FILE__, $sql);
		}
		if ($row = $db->sql_fetchrow($result))
		{
			return;
		}
# 
#-----[ OPEN ]------------------------------------------ 
# 
admin/admin_forums.php
# 
#-----[ FIND ]------------------------------------------ 
# 
				'S_PRUNE_ENABLED' => $prune_enabled,
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
				'S_FORUM_POSTCOUNT' => ( isset($row) && isset($row['forum_postcount']) && ($row['forum_postcount'] == 0) ) ? '' : 'checked="checked"',
# 
#-----[ FIND ]------------------------------------------ 
# 
				'L_DAYS' => $lang['Days'],
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
				'L_POSTCOUNT' => $lang['Forum_postcount'],
# 
#-----[ FIND ]------------------------------------------ 
# 
prune_enable" . $field_sql
# 
#-----[ IN-LINE FIND  ]------------------------------------------ 
# 
prune_enable
# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# (before the " )
#
, forum_postcount
# 
#-----[ FIND ]------------------------------------------ 
# 
intval($HTTP_POST_VARS['prune_enable']) . $value_sql
# 
#-----[ IN-LINE FIND  ]------------------------------------------ 
# 
intval($HTTP_POST_VARS['prune_enable'])
# 
#-----[ IN-LINE AFTER, ADD ]------------------------------------------ 
# (before the . )
#
 . ", " . intval($HTTP_POST_VARS['forum_postcount'])
# 
#-----[ FIND ]------------------------------------------ 
# 
prune_enable = " . intval($HTTP_POST_VARS['prune_enable']) . "
# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 
, forum_postcount = " . intval($HTTP_POST_VARS['forum_postcount']) . "
# 
#-----[ OPEN ]------------------------------------------ 
# 
language/lang_english/lang_admin.php
# 
#-----[ FIND ]------------------------------------------ 
# 
$lang['prune_freq']
# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
$lang['Forum_postcount'] = 'Count user\'s posts';
# 
#-----[ OPEN ]------------------------------------------ 
# 
templates/subSilver/admin/forum_edit_body.tpl
# 
#-----[ FIND ]------------------------------------------ 
# 
	<tr> 
	  <td class="catBottom" colspan="2" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{S_SUBMIT_VALUE}" class="mainoption" /></td>
# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
	<tr> 
	  <td class="row1">{L_POSTCOUNT}</td>
	  <td class="row2">{L_ENABLED}<input type="checkbox" name="forum_postcount" value="1" {S_FORUM_POSTCOUNT} /></td>
	</tr>
# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 
