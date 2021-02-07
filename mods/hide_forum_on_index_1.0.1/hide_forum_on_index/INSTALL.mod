##############################################################
## MOD Title: Hide Forum On Index
## MOD Author: Joe Belmaati < belmaati@gmail.com > (Joe Belmaati) N/A
## MOD Description: Enables admin to hide specific forums on index,
## setable from the ACP Forum Admin Management. When a category link
## is clicked then all forums in that category will be displayed -
## even hidden forums. You can also hide a forum both on the main
## index and when a category link is clicked.
##
## MOD Version: 1.0.1
##
## Installation Level: Easy
## Installation Time: 10 Minutes
## Files To Edit:
##					index.php
##					admin/admin_forums.php
##					includes/constants.php
##					language/lang_english/lang_admin.php
##					templates/subSilver/forum_edit_body.tpl
##
## Included Files: db_update.php
## License: http://opensource.org/licenses/gpl-license.php GNU General Public License v2
##############################################################
## For security purposes, please check: http://www.phpbb.com/mods/
## for the latest version of this MOD. Although MODs are checked
## before being allowed in the MODs Database there is no guarantee
## that there are no security problems within the MOD. No support
## will be given for MODs not found within the MODs Database which
## can be found at http://www.phpbb.com/mods/
##############################################################
## Author Notes: Upload and run db_update.php from your phpBB root
## folder, or apply the SQL command directly using phpMyAdmin or
## similar. The MOD should install with EasyMOD.
##############################################################
## MOD History:
##
##   2006-01-07 - 1.0.1
##      - resubmitted to MODs database at phpBB.com
##
##   2005-07-30 - 1.0.0
##      - submitted to MODs database at phpBB.com
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################
#
#-----[ SQL ]------------------------------------------
#
ALTER TABLE `phpbb_forums` ADD `hide_forum_on_index` TINYINT( 1 ) DEFAULT '0' NOT NULL;
ALTER TABLE `phpbb_forums` ADD `hide_forum_in_cat` TINYINT( 1 ) DEFAULT '0' NOT NULL;
#
#-----[ OPEN ]------------------------------------------
#
index.php
#
#-----[ FIND ]------------------------------------------
#
			if ( $viewcat == $cat_id || $viewcat == -1 )
			{
				for($j = 0; $j < $total_forums; $j++)
				{
#
#-----[ AFTER, ADD ]------------------------------------------
#
					if ( $viewcat == $cat_id && !$forum_data[$j]['hide_forum_in_cat'] )
					{
						unset($forum_data[$j]['hide_forum_on_index']);
					}

#
#-----[ FIND ]------------------------------------------
#
					if ( $forum_data[$j]['cat_id'] == $cat_id )
#
#-----[ REPLACE WITH ]------------------------------------------
#
					if ( $forum_data[$j]['cat_id'] == $cat_id && !$forum_data[$j]['hide_forum_on_index'] )
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
				$hidestatus = $row['hide_forum_on_index'];
				$catstatus = $row['hide_forum_in_cat'];
#
#-----[ FIND ]------------------------------------------
#
				$forumstatus = FORUM_UNLOCKED;
#
#-----[ AFTER, ADD ]------------------------------------------
#
				$hidestatus = SHOW_FORUM;
				$catstatus = SHOW_CAT;
#
#-----[ FIND ]------------------------------------------
#
			$statuslist .= "<option value=\"" . FORUM_LOCKED . "\" $forumlocked>" . $lang['Status_locked'] . "</option>\n";

#
#-----[ AFTER, ADD ]------------------------------------------
#
			$hide_yes = ($hidestatus) ? "selected=\"selected\"" : "";
			$hide_no = (!$hidestatus) ? " selected=\"selected\"" : "";

			$hidelist = "<option value=\"" . SHOW_FORUM . "\" $hide_no>" . $lang['No'] . "</option>\n";
			$hidelist .= "<option value=\"" . HIDE_FORUM . "\" $hide_yes>" . $lang['Yes'] . "</option>\n";

			$hide_in_cat_yes = ($catstatus) ? "selected=\"selected\"" : "";
			$hide_in_cat_no = (!$catstatus) ? " selected=\"selected\"" : "";

			$hide_cat_list = "<option value=\"" . SHOW_CAT . "\" $hide_in_cat_no>" . $lang['No'] . "</option>\n";
			$hide_cat_list .= "<option value=\"" . HIDE_CAT . "\" $hide_in_cat_yes>" . $lang['Yes'] . "</option>\n";
#
#-----[ FIND ]------------------------------------------
#
				'S_STATUS_LIST' => $statuslist,
#
#-----[ AFTER, ADD ]------------------------------------------
#
				'S_HIDE_STATUS' => $hidelist,
				'S_HIDE_CAT_STATUS' => $hide_cat_list,
#
#-----[ FIND ]------------------------------------------
#
				'L_FORUM_STATUS' => $lang['Forum_status'],
#
#-----[ AFTER, ADD ]------------------------------------------
#
				'L_HIDE_STATUS' => $lang['Hide_status'],
				'L_HIDE_CAT_STATUS' => $lang['Hide_cat_status'],
				'L_HIDE_CAT_STATUS_EXPLAIN' => $lang['Hide_cat_status_explain'],
#
#-----[ FIND ]------------------------------------------
# Note: this is a partial line match
			$sql = "INSERT INTO " . FORUMS_TABLE . " (forum_id
#
#-----[ IN-LINE FIND ]------------------------------------------
#
, prune_enable" . $field_sql . "
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, hide_forum_on_index, hide_forum_in_cat
#
#-----[ FIND ]------------------------------------------
# Note: this is a partial line match
#
				VALUES ('" . $next_id . "'
#
#-----[ IN-LINE FIND ]------------------------------------------
#
, " . intval($HTTP_POST_VARS['prune_enable']) . $value_sql . "
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, " . intval($HTTP_POST_VARS['hidestatus']) . ", " . intval($HTTP_POST_VARS['catstatus']) . "
#
#-----[ FIND ]------------------------------------------
# Note: this is a partial line match
#
				SET forum_name = '" . str_replace("\'", "''",
#
#-----[ IN-LINE FIND ]------------------------------------------
#
, prune_enable = " . intval($HTTP_POST_VARS['prune_enable']) . "
#
#-----[ IN-LINE AFTER, ADD ]------------------------------------------
#
, hide_forum_on_index = " . intval($HTTP_POST_VARS['hidestatus']) . ", hide_forum_in_cat = " . intval($HTTP_POST_VARS['catstatus']) . "
#
#-----[ OPEN ]------------------------------------------
#
includes/constants.php
#
#-----[ FIND ]------------------------------------------
#
define('FORUM_LOCKED', 1);
#
#-----[ AFTER, ADD ]------------------------------------------
#
define('SHOW_FORUM', 0);
define('HIDE_FORUM', 1);
define('SHOW_CAT', 0);
define('HIDE_CAT', 1);
#
#-----[ OPEN ]------------------------------------------
#
language/lang_english/lang_admin.php
#
#-----[ FIND ]------------------------------------------
#
$lang['Edit_Category_explain'] = 'Use this form to modify a category\'s name.';
#
#-----[ AFTER, ADD ]------------------------------------------
#
$lang['Hide_status'] = 'Hide forum on index';
$lang['Hide_cat_status'] = 'Hide forum when viewing a category';
$lang['Hide_cat_status_explain'] = '(only active if forum hidden on index is selected)';
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
	  <td class="row1">{L_HIDE_STATUS}</td>
	  <td class="row2"><select name="hidestatus">{S_HIDE_STATUS}</select></td>
	</tr>
	<tr>
	  <td class="row1">{L_HIDE_CAT_STATUS}<br /><span class="gensmall">{L_HIDE_CAT_STATUS_EXPLAIN}</span></td>
	  <td class="row2"><select name="catstatus">{S_HIDE_CAT_STATUS}</select></td>
	</tr>
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
