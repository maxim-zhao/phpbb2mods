##############################################################
## MOD Title: Extended Hide Forums
## MOD Author: dvandersluis < daniel@codexed.com > (Daniel Vandersluis) http://www.codexed.com
## MOD Description: Allows Admins to set forums as hidden from the jumpbox and/or from the
##					dropdown box on the search page from the ACP.
## MOD Version: 1.2.1
##
## Installation Level: Easy
## Installation Time: 15 Minutes
## Files To Edit: 8
##		search.php
##		viewforum.php
##		viewtopic.php
##		admin/admin_forums.php
##		includes/constants.php
##		includes/functions.php
##		language/lang_english/lang_admin.php
##		templates/subSilver/admin/forum_edit_body.tpl
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
## Author Notes:
##		This mod extends on Hide Forum On Index by
##		Joe Belmaati. However, that mod is not
##		needed for this one to work. That mod hides
##		forums from the index and category listings,
##		this mod hides them from the jumpbox and
##		search dropdowns.
##############################################################
## MOD History:
##
##	 2006-05-08 - Version 1.2.1
##		- Fixed bug with forum sometimes showing up in
##		  jumpbox when it is specified not to.
##
##	 2006-05-08 - Version 1.2.0
##		- Added a whole bunch of code that was missing from
##		  the previous version, and thereby made the mod
##		  not work.
##		- Removed the jumpbox if there is nothing to display
##			in it.
##
##	 2006-04-18 - Version 1.0.0
##      	- First version
##		- submitted to MODs database at phpBB.com
##
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ SQL ]------------------------------------------
#
ALTER TABLE `phpbb_forums` ADD `hide_forum_in_jumpbox` TINYINT( 1 ) DEFAULT '0' NOT NULL;
ALTER TABLE `phpbb_forums` ADD `hide_forum_in_search` TINYINT( 1 ) DEFAULT '0' NOT NULL;

#
#-----[ OPEN ]-----------------------------------------
#
includes/constants.php

#
#-----[ FIND ]-----------------------------------------
#
define('FORUM_LOCKED', 1);

#
#-----[ AFTER, ADD ]-----------------------------------
#
// +Extended Hide Forums
define('SHOW_JUMPBOX', 0);
define('HIDE_JUMPBOX', 1);
define('SHOW_SEARCH', 0);
define('HIDE_SEARCH', 1);
// -Extended Hide Forums

#
#-----[ OPEN ]-----------------------------------------
#
language/lang_english/lang_admin.php

#
#-----[ FIND ]-----------------------------------------
#
$lang['Forums_updated'] = 'Forum and Category information updated successfully';

#
#-----[ BEFORE, ADD ]----------------------------------
#
// +Extended Hide Forums
$lang['Hide_jumpbox_status'] = 'Hide forum from the jumpbox';
$lang['Hide_search_status'] = 'Hide forum from search.php dropdowns';
// -Extended Hide Forums

#
#-----[ OPEN ]-----------------------------------------
#
admin/admin_forums.php

#
#-----[ FIND ]-----------------------------------------
#
                //
                // start forum prune stuff.
                //

#
#-----[ BEFORE, ADD ]----------------------------------
#
				// +Extended Hide Forums
				$jumpboxstatus = $row['hide_forum_in_jumpbox'];
				$searchstatus = $row['hide_forum_in_search'];
				// -Extended Hide Forums

#
#-----[ FIND ]-----------------------------------------
#
                $forum_id = '';
#
#-----[ BEFORE, ADD ]----------------------------------
#
				// +Extended Hide Forums
				$jumpboxstatus = SHOW_JUMPBOX;
				$searchstatus = SHOW_SEARCH;
				// -Extended Hide Forums

#
#-----[ FIND ]-----------------------------------------
#
            $template->set_filenames(array(
                "body" => "admin/forum_edit_body.tpl")
            );

#
#-----[ BEFORE, ADD ]----------------------------------
#

			// +Extended Hide Forums
			$hide_in_jumpbox_yes = ($jumpboxstatus) ? "selected=\"selected\"" : "";
			$hide_in_jumpbox_no = (!$jumpboxstatus) ? " selected=\"selected\"" : "";

			$hide_jumpbox_list = "<option value=\"" . SHOW_JUMPBOX . "\" $hide_in_jumpbox_no>" . $lang['No'] . "</option>\n";
			$hide_jumpbox_list .= "<option value=\"" . HIDE_JUMPBOX . "\" $hide_in_jumpbox_yes>" . $lang['Yes'] . "</option>\n";

			$hide_in_search_yes = ($searchstatus) ? "selected=\"selected\"" : "";
			$hide_in_search_no = (!$searchstatus) ? " selected=\"selected\"" : "";

			$hide_search_list = "<option value=\"" . SHOW_SEARCH . "\" $hide_in_search_no>" . $lang['No'] . "</option>\n";
			$hide_search_list .= "<option value=\"" . HIDE_SEARCH . "\" $hide_in_search_yes>" . $lang['Yes'] . "</option>\n";
			// -Extended Hide Forums

#
#-----[ FIND ]----------------------------------------
#
                'S_PRUNE_ENABLED' => $prune_enabled,

#
#-----[ BEFORE, ADD ]---------------------------------
#
				// +Extended Hide Forums
				'S_HIDE_JUMPBOX_STATUS' => $hide_jumpbox_list,
				'S_HIDE_SEARCH_STATUS' => $hide_search_list,
				// -Extended Hide Forums

#
#-----[ FIND ]---------------------------------------
#
                'L_AUTO_PRUNE' => $lang['Forum_pruning'],

#
#-----[ BEFORE, ADD ]--------------------------------
#
				// +Extended Hide Forums
				'L_HIDE_JUMPBOX_STATUS' => $lang['Hide_jumpbox_status'],
				'L_HIDE_SEARCH_STATUS' => $lang['Hide_search_status'],
				// -Extended Hide Forums

#
#-----[ FIND ]---------------------------------------
#
            $sql = "UPDATE " . FORUMS_TABLE . "
                SET forum_name = '" . str_replace("\'", "''", $HTTP_POST_VARS['forumname']) . "',

#
#-----[ BEFORE, ADD ]--------------------------------
#
			// +Extended Hide Forums
			// after: prune_enable = " . intval($HTTP_POST_VARS['prune_enable']) . "
			// ,
			// hide_forum_in_jumpbox = " . intval($HTTP_POST_VARS['jumpstatus']) . ",
			// hide_forum_in_search = " . intval($HTTP_POST_VARS['searchstatus']) . "
#
#-----[ IN-LINE FIND ]-------------------------------
#
prune_enable = " . intval($HTTP_POST_VARS['prune_enable']) . "

#
#-----[ IN-LINE AFTER, ADD ]-------------------------
#
, hide_forum_in_jumpbox = " . intval($HTTP_POST_VARS['jumpstatus']) . ", hide_forum_in_search = " . intval($HTTP_POST_VARS['searchstatus']) . "
#
#-----[ FIND ]---------------------------------------
#
WHERE

#
#-----[ AFTER, ADD ]---------------------------------
#
			// -Extended Hide Forums

#
#-----[ OPEN ]---------------------------------------
#
viewforum.php

#
#-----[ FIND ]---------------------------------------
#
	'L_AUTHOR' => $lang['Author'],

#
#-----[ AFTER, ADD ]---------------------------------
#
	'L_GO' => $lang['Go'],

#
#-----[ OPEN ]---------------------------------------
#
viewtopic.php

#
#-----[ FIND ]---------------------------------------
#
	'L_AUTHOR' => $lang['Author'],

#
#-----[ AFTER, ADD ]---------------------------------
#
	'L_GO' => $lang['Go'],

#
#-----[ OPEN ]---------------------------------------
#
includes/functions.php

#
#-----[ FIND ]---------------------------------------
#
	$sql = "SELECT c.cat_id
	FROM
	WHERE
	GROUP BY
	ORDER BY

#
#-----[ REPLACE WITH ]-------------------------------
#
	// +Extended Hide Forums
	// Changed SQL statement to JOIN on FORUMS_TABLE and get the forum order
	$sql = "SELECT DISTINCT c.cat_id, c.cat_title
		FROM " . CATEGORIES_TABLE . " AS c
		JOIN " . FORUMS_TABLE . " AS f
			ON c.cat_id = f.cat_id
		WHERE f.hide_forum_in_jumpbox = 0
		ORDER BY c.cat_order";
	// -Extended Hide Forums

#
#-----[ FIND ]---------------------------------------
#
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Couldn't obtain category list.", "", __LINE__, __FILE__, $sql);
	}

#
#-----[ AFTER, ADD ]---------------------------------
#
	// +Extended Hide Forums
	// If there is nothing to display, hide the jumpbox
	if ($db->sql_numrows($result) == 0)
	{
		return false;
	}
	// -Extended Hide Forums

#
#-----[ FIND ]---------------------------------------
#
$sql = "SELECT *

#
#-----[ BEFORE, ADD ]--------------------------------
#
		// +Extended Hide Forums
#
#-----[ FIND ]---------------------------------------
#
ORDER BY

#
#-----[ BEFORE, ADD ]--------------------------------
#
			WHERE hide_forum_in_jumpbox = 0
#
#-----[ AFTER, ADD ]---------------------------------
#
		// -Extended Hide Forums
 
#
#-----[ OPEN ]---------------------------------------
#
search.php

#
#-----[ FIND ]---------------------------------------
#
$sql = "SELECT c.cat_title

#
#-----[ BEFORE, ADD ]--------------------------------
#
// +Extended Hide Forums
// Modified SQL statement to JOIN on FORUMS_TABLE and get forum order info
#
#-----[ FIND ]---------------------------------------
#
FROM

#
#-----[ IN-LINE FIND ]-------------------------------
#
c, " . FORUMS_TABLE . " f

#
#-----[ IN-LINE REPLACE WITH ]-----------------------
#
AS c

#
#-----[ FIND ]---------------------------------------
#
WHERE

#
#-----[ BEFORE, ADD ]---------------------------------
#
	JOIN " . FORUMS_TABLE . " AS f
		ON c.cat_id = f.cat_id 
#
#-----[ FIND ]---------------------------------------
#
ORDER BY

#
#-----[ IN-LINE FIND ]-------------------------------
#
c.cat_order

#
#-----[ IN-LINE AFTER, ADD ]-------------------------
#
, f.forum_order

#
#-----[ BEFORE, ADD ]--------------------------------
#
		AND f.hide_forum_in_search = 0
#
#-----[ AFTER, ADD ]---------------------------------
#
// -Extended Hide Forums

#
#-----[ OPEN ]---------------------------------------
#
templates/subSilver/admin/forum_edit_body.tpl

#
#-----[ FIND ]---------------------------------------
#
	<tr>
      <td class="row1">{L_AUTO_PRUNE}</td>
      <td class="row2">

#
#-----[ BEFORE, ADD ]--------------------------------
#
	<!-- +Extended Hide Forums -->
	<tr>
		<td class="row1">{L_HIDE_JUMPBOX_STATUS}</td>
		<td class="row2"><select name="jumpstatus">{S_HIDE_JUMPBOX_STATUS}</select></td>
	</tr>
	<tr>
		<td class="row1">{L_HIDE_SEARCH_STATUS}</td>
		<td class="row2"><select name="searchstatus">{S_HIDE_SEARCH_STATUS}</select></td>
	</tr>
	<!-- -Extended Hide Forums -->
#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM
