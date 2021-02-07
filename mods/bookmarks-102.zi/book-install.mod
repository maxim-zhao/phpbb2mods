##############################################################
## MOD Title: Bookmarks
## MOD Author: DanielT < daniel@danielt.com > (Daniel Taylor) http://www.danielt.com
## MOD Description: this mod will allow users to bookmark topics
## MOD Version: 1.0.2
##
## Installation Level: (Intermediate)
## Installation Time: 20 Minutes
## Files To Edit: admin/admin_users.php,
##      includes/constants.php,
##      includes/functions_post.php,
##      includes/page_header.php,
##	includes/prune.php,
##	language/lang_english/lang_main.php,
##	modcp.php,
##	templates/subSilver/overall_header.tpl,
##	templates/subSilver/viewtopic_body.tpl,
##	viewtopic.php
## Included Files: bookmarks.php, book_body.tpl
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
##	This MOD is a replacment for my old 'Favorites' MOD.
##	Big thanks to smitjel for his 'reposition watch topic link' MOD
##	which i was able to re-use here.
##
##############################################################
## MOD History:
##
##   2005-10-27 - Version 1.0.0
##      - This first release of 'Bookmarks' MOD
##   2005-10-27 - Version 1.0.1
##      - This release fixes a small SQL problem and does the
##	  langauge bit correctly.
##   2005-10-30 - Version 1.0.2
##	- Added 'No Bookmarks' text into bookmarks.php
##	- Changed U_BOOK to U_BOOKMARK in viewtopic.php (and .tpl)
##	  since U_BOOK was already used in the header and sometimes
##	  caused problems (when the user was a guest)
##	- fixed redirect problem in bookmarks.php, missed a '.'
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ SQL ]------------------------------------------
#
CREATE TABLE `phpbb_bookmarks` ( 
`book_id` int(11) NOT NULL auto_increment, 
`user_id` int(11) NOT NULL default '0', 
`topic_id` int(11) NOT NULL default '0', 
PRIMARY KEY (`book_id`) 
) 
#
#-----[ COPY ]------------------------------------------
#
copy bookmarks.php to bookmarks.php
copy book_body.tpl to templates/subSilver/book_body.tpl 
#
#-----[ OPEN ]------------------------------------------
# 
admin/admin_users.php
#
#-----[ FIND ]------------------------------------------
# 
				message_die(GENERAL_ERROR, 'Could not delete group for this user', '', __LINE__, __FILE__, $sql);
			}
#
#-----[ AFTER, ADD ]------------------------------------------
# 
			// Bookmarks MOD, 1.0.1
			$sql = "DELETE FROM " . BOOKMARKS_TABLE . "
				WHERE user_id = $user_id";
			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not delete user from bookmarks table', '', __LINE__, __FILE__, $sql);
			}
#
#-----[ OPEN ]------------------------------------------
# 
includes/constants.php
#
#-----[ FIND ]------------------------------------------
# 
'VOTE_USERS_TABLE'
#
#-----[ AFTER, ADD ]------------------------------------------
# 
// Bookmarks MOD, 1.0.1
define('BOOKMARKS_TABLE', $table_prefix.'bookmarks');
#
#-----[ OPEN ]------------------------------------------
# 
includes/functions_post.php
#
#-----[ FIND ]------------------------------------------
# 
					$topic_update_sql .= ', topic_last_post_id = ' . $row['last_post_id'];
				}
#
#-----[ AFTER, ADD ]------------------------------------------
# 
				// Bookmarks MOD, 1.0.1
				$sql = "DELETE FROM " . BOOKMARKS_TABLE . "
					WHERE topic_id = $topic_id";
				if (!$db->sql_query($sql))
				{
					message_die(GENERAL_ERROR, 'Error in deleting bookmark', '', __LINE__, __FILE__, $sql);
				}
#
#-----[ OPEN ]------------------------------------------
# 
includes/page_header.php
#
#-----[ FIND ]------------------------------------------
# 
'L_WHOSONLINE_MOD'
#
#-----[ AFTER, ADD ]------------------------------------------
# 
	'L_BOOK' => $lang['bookmarks'],
#
#-----[ FIND ]------------------------------------------
# 
'U_GROUP_CP'
#
#-----[ AFTER, ADD ]------------------------------------------
# 
	'U_BOOK' => append_sid('bookmarks.'.$phpEx),
#
#-----[ OPEN ]------------------------------------------
# 
includes/prune.php
#
#-----[ FIND ]------------------------------------------
# 
				message_die(GENERAL_ERROR, 'Could not delete watched topics during prune', '', __LINE__, __FILE__, $sql);
			}
#
#-----[ AFTER, ADD ]------------------------------------------
# 
			// Bookmarks MOD, 1.0.1
			$sql = "DELETE FROM " . BOOKMARKS_TABLE . " 
				WHERE topic_id IN ($sql_topics)";
			if ( !$db->sql_query($sql, BEGIN_TRANSACTION) )
			{
				message_die(GENERAL_ERROR, 'Could not delete bookmarked topics during prune', '', __LINE__, __FILE__, $sql);
			}
#
#-----[ OPEN ]------------------------------------------
# 
language/lang_english/lang_main.php
#
#-----[ FIND ]------------------------------------------
#
$lang['Admin_reauthenticate']
#
#-----[ AFTER, ADD ]------------------------------------------
# 
//Bookmark Mod, 1.0.1

$lang['remove_book_data'] = 'Could not remove data from bookmarks table';
$lang['insert_book_data'] = 'Could not insert data into bookmarks table';
$lang['no_book_topic'] = 'No topic was selected!';
$lang['bookmarks'] = 'Bookmarks';
$lang['add_book'] = 'Bookmark topic';
$lang['remove_book'] = 'Remove Bookmark';
$lang['bookmark_added'] = "Topic has been added to bookmarks";
$lang['bookmark_removed'] = "Topic has been removed from bookmarks";
$lang['Click_return_bookmarks'] = "Click %sHere%s to return to bookmarks";
$lang['exist_book'] = "This topic is already in your bookmarks!";
//Bookmark MOD, 1.0.2
$lang['no_bookmarks'] = "You have no bookmarks!";
#
#-----[ OPEN ]------------------------------------------
# 
modcp.php
#
#-----[ FIND ]------------------------------------------
#
			$sql = "DELETE 
				FROM " . TOPICS_WATCH_TABLE . "
#
#-----[ BEFORE, ADD ]------------------------------------------
#
			// Bookmarks MOd, 1.0.1
			$sql = "DELETE 
				FROM " . BOOKMARKS_TABLE . " 
				WHERE topic_id IN ($topic_id_sql)";
			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not delete bookmarked list', '', __LINE__, __FILE__, $sql);
			}
#
#-----[ OPEN ]------------------------------------------
# 
templates/subSilver/overall_header.tpl
#
#-----[ FIND ]------------------------------------------
#
<!-- BEGIN switch_user_logged_out -->
&nbsp;<a href="{U_REGISTER}"
#
#-----[ BEFORE, ADD ]------------------------------------------
#
<!-- BEGIN switch_user_logged_in -->
&nbsp;<a href="{U_BOOK}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_groups.gif" width="12" height="13" border="0" alt="{L_BOOK}" hspace="3" />{L_BOOK}</a>&nbsp;
<!-- END switch_user_logged_in -->
#
#-----[ OPEN ]------------------------------------------
#
templates/subSilver/viewtopic_body.tpl
#
#-----[ FIND ]------------------------------------------
#
	<tr align="right">
		<td class="catHead" colspan="2" height="28"><span class="nav"><a href="{U_VIEW_OLDER_TOPIC}" class="nav">{L_VIEW_PREVIOUS_TOPIC}</a> :: <a href="{U_VIEW_NEWER_TOPIC}" class="nav">{L_VIEW_NEXT_TOPIC}</a> &nbsp;</span></td>
	</tr>
#
#-----[ IN-LINE FIND ]------------------------------------------
#
<span class="nav">
#
#-----[ IN-LINE BEFORE, ADD ]------------------------------------------
#
<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="left" width="50%"><span class="nav">&nbsp;{U_BOOKMARK}</span></td><td align="right"><span class="nav">
#
#-----[ IN-LINE FIND ]------------------------------------------
#
{L_VIEW_NEXT_TOPIC}</a> &nbsp;</span></td>
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
</tr></table></td>
#
#-----[ OPEN ]------------------------------------------
#
viewtopic.php
#
#-----[ FIND ]------------------------------------------
#
	'U_POST_REPLY_TOPIC' => $reply_topic_url)
);
#
#-----[ AFTER, ADD ]------------------------------------------
# 
// Bookmarks MOD, 1.0.1
// Check to see if the topic has already been bookmarked


if ($userdata['session_logged_in']) {
	
	$sql = "SELECT *
		FROM " . BOOKMARKS_TABLE . "
		WHERE user_id = '" . $userdata['user_id'] . "' AND topic_id = '" . intval($topic_id) ."'";

	$result = $db->sql_query($sql);

	$num_row = $db->sql_numrows($result);
	
	if (intval($num_row) == 0) {
		$template->assign_vars(array(
			'U_BOOKMARK' => "<a class=\"nav\" href=\"". append_sid("bookmarks.$phpEx?t=" . $topic_id . "&amp;mode=add" . "\">" . $lang['add_book'] . "</a>")) 
		);
	}
	else {
		$template->assign_vars(array(
			'U_BOOKMARK' => "<a class=\"nav\" href=\"". append_sid("bookmarks.$phpEx?t=" . $topic_id . "&amp;mode=remove" . "\">" . $lang['remove_book'] . "</a>")) 
		);
	}

}
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
