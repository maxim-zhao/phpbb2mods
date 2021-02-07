############################################################## 
## MOD Title: Open/Close All Forums
## MOD Author: [R: R@m$e$ :U] < Ramses@FromRU.com > (Ramses) http://www.phpbbguru.net
## MOD Description: Allow to open/close all forums by clicking only one button
## MOD Version: 1.0.0 
## 
## Installation Level: Easy 
## Installation Time: ~3 Minutes 
## Files To Edit: admin/admin_forums.php, templates/subSilver/admin/forum_admin_body.tpl
##      language/lang_english/lang_admin.php, language/lang_russian/lang_admin.php
## Included Files: n/a 
############################################################## 
## For Security Purposes, Please Check: http://www.phpbbguru.net/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. 
############################################################## 
## Author Notes: 
##      Find bug? Write here - http://www.phpbbguru.net/community/viewtopic.php?t=1596
##      plz =)
##      Russian Language in this topic: http://www.phpbbguru.net/community/viewtopic.php?t=1596 
##  
############################################################## 
## MOD History: 
## 
##   2005-02-13 - Version 1.0.0 
##      - First version +)))
## 
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 

# 
#-----[ OPEN ]------------------------------------------ 
# 

admin/admin_forums.php

# 
#-----[ FIND ]------------------------------------------ 
# 

//
// Begin program proper
//
if( isset($HTTP_POST_VARS['addforum']) || isset($HTTP_POST_VARS['addcategory']) )
{
	$mode = ( isset($HTTP_POST_VARS['addforum']) ) ? "addforum" : "addcat";

	if( $mode == "addforum" )
	{
		list($cat_id) = each($HTTP_POST_VARS['addforum']);
		// 
		// stripslashes needs to be run on this because slashes are added when the forum name is posted
		//
		$forumname = stripslashes($HTTP_POST_VARS['forumname'][$cat_id]);
	}
}

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

// [start] Open/Close All Forums
else if( isset($HTTP_POST_VARS['openforums']) || isset($HTTP_POST_VARS['closeforums']) )
{
	$mode = ( isset($HTTP_POST_VARS['openforums']) ) ? "openforums" : "closeforums";
}
// [end] Open/Close All Forums

# 
#-----[ FIND ]------------------------------------------ 
# 

		case 'forum_sync':
			sync('forum', intval($HTTP_GET_VARS[POST_FORUM_URL]));
			$show_index = TRUE;

			break;

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

		// [start] Open/Close All Forums
		case 'closeforums':
			$sql = "UPDATE " . FORUMS_TABLE . "
				SET forum_status = 1";
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Couldn't close all forums", "", __LINE__, __FILE__, $sql);
			}

			$message = $lang['Forums_updated'] . "<br /><br />" . sprintf($lang['Click_return_forumadmin'], "<a href=\"" . append_sid("admin_forums.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

			message_die(GENERAL_MESSAGE, $message);
			break;
		case 'openforums':
			$sql = "UPDATE " . FORUMS_TABLE . "
				SET forum_status = 0";
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Couldn't open all forums", "", __LINE__, __FILE__, $sql);
			}

			$message = $lang['Forums_updated'] . "<br /><br />" . sprintf($lang['Click_return_forumadmin'], "<a href=\"" . append_sid("admin_forums.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

			message_die(GENERAL_MESSAGE, $message);
			break;
		// [end] Open/Close All Forums

# 
#-----[ FIND ]------------------------------------------ 
# 

	'S_FORUM_ACTION' => append_sid("admin_forums.$phpEx"),

# 
#-----[ AFTER, ADD ]------------------------------------------ 
# 

	// [start] Open/Close All Forums
	'L_CLOSE_FORUMS' => $lang['Close_forums'],
	'L_OPEN_FORUMS' => $lang['Open_forums'],
	// [end] Open/Close All Forums

# 
#-----[ OPEN ]------------------------------------------ 
# 

language/lang_english/lang_admin.php

# 
#-----[ FIND ]------------------------------------------ 
# 

?>

# 
#-----[ BEFORE, ADD ]------------------------------------------ 
# 

// [start] Open/Close All Forums
$lang['Close_forums'] = 'Close all forums';
$lang['Open_forums'] = 'Open all forums';
// [end] Open/Close All Forums

# 
#-----[ OPEN ]------------------------------------------ 
# 

templates/subSilver/admin/forum_admin_body.tpl

# 
#-----[ FIND ]------------------------------------------ 
# 

	<tr>
		<td colspan="7" class="catBottom"><input class="post" type="text" name="categoryname" /> <input type="submit" class="liteoption"  name="addcategory" value="{L_CREATE_CATEGORY}" /></td>
	</tr>

# 
#-----[ REPLACE WITH ]------------------------------------------ 
# 

	<!-- [begin] Open/Close All Forums -->
	<tr>
		<td colspan="7" class="row2"><input class="post" type="text" name="categoryname" /> <input type="submit" class="liteoption"  name="addcategory" value="{L_CREATE_CATEGORY}" /></td>
	</tr>
	<tr>
		<td colspan="7" height="1" class="spaceRow"><img src="../templates/subSilver/images/spacer.gif" alt="" width="1" height="1" /></td>
	</tr>
	<tr>
		<td colspan="7" class="catBottom"><input type="submit" class="liteoption"  name="closeforums" value="{L_CLOSE_FORUMS}" /><input type="submit" class="liteoption"  name="openforums" value="{L_OPEN_FORUMS}" /></td>
	</tr>
	<!-- [end] Open/Close All Forums -->

# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM