##############################################################
## MOD Title: Forum Sponsors
## MOD Author: EXreaction < exreaction@lithiumstudios.org > (Nathan Guse) http://www.lithiumstudios.org
## MOD Description: Allows you to add advertisements in specific forums
## MOD Version: 1.0.02c
##
## Installation Level: Intermediate
## Installation Time: ~5 Minutes
## Files To Edit:	admin/admin_forums.php
##					includes/page_header.php
##					language/lang_english/lang_main.php
##					templates/subSilver/viewforum_body.tpl
##					templates/subSilver/viewtopic_body.tpl
##					templates/subSilver/admin/forum_edit_body.tpl
## Included Files:	none
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
## This mod is owned by WW < bjgobble@yahoo.com > http://www.thearkansashuntingandfishingforum.com,
##  and was created by EXreaction.
##
## Please use my forums(you can find them at http://www.lithiumstudios.org)
##  for support.  WW paid for this mod and was kind enough to allow me to release this mod to everyone, so
##  drop him a thanks over at his forum(located at http://www.thearkansashuntingandfishingforum.com).
##
## If you want to move the location of the ad placement in viewforum and viewtopic, simply change the locations
##  of the sections that were added to viewforum_body.tpl and viewtopic_body.tpl.
##############################################################
## MOD History:
## 
##   2006-07-31 - Version 1.0.0
##      - Initial Release
##   2006-08-20 - Version 1.0.01
##      - Fixes
##   2006-09-19 - Version 1.0.01a
##      - Forgot the language section in the adminCP(thanks LoganSix for noticing it)
##   2006-10-12 - Version 1.0.02
##      - Added BBCode/Smiley Parsing
##   2006-10-20 - Version 1.0.02a
##      - Fixes for Mod Validation
##   2006-10-22 - Version 1.0.02b
##      - More fixes for Mod Validation...
##   2006-10-23 - Version 1.0.02c
##      - Lol, more fixes(this time I got it right though). :-P
##############################################################
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD
##############################################################

#
#-----[ SQL ]-------------------------------------------
#
# Optionally, you may run the db_install.php instead.  If you want to do that, copy db_install.php to your
#  root phpBB2 directory, and run it from your web browser.  You should delete the file afterwards.
#

ALTER TABLE `phpbb_forums` ADD `sponsor` TEXT NOT NULL;

# 
#-----[ OPEN ]------------------------------------------
# 

admin/admin_forums.php

#
#-----[ FIND ]------------------------------------------
# 

			$s_hidden_fields = '<input type="hidden" name="mode" value="' . $newmode .'" /><input type="hidden" name="' . POST_FORUM_URL . '" value="' . $forum_id . '" />';

			$template->assign_vars(array(

# 
#-----[ BEFORE, ADD ]------------------------------------------
# 

			if ($forum_id)
			{
				$sql = "SELECT sponsor
					FROM " .  FORUMS_TABLE . "
					WHERE forum_id = " . intval($forum_id);
				if ( !$result = $db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, 'Could not select forum sponsor data', '', __LINE__, __FILE__, $sql);
				}
	
				while( $row = $db->sql_fetchrow($result) )
				{
					$forum_sponsor = $row['sponsor'];
					$forum_sponsor = str_replace("quote:1", "quote", $forum_sponsor);
				}
			}

# 
#-----[ AFTER, ADD ]------------------------------------------
#

				'SPONSOR'				=> $forum_sponsor,
				'L_FORUM_SPONSOR'		=> $lang['Forum_Sponsor'],
				'L_FORUM_SPONSOR_NOTE'	=> $lang['Forum_Sponsor_Note'],

#
#-----[ FIND ]------------------------------------------
# 

			$sql = "INSERT INTO " . FORUMS_TABLE . " (forum_id, forum_name, cat_id, forum_desc, forum_order, forum_status, prune_enable" . $field_sql . ")

#
#-----[ IN-LINE FIND ]---------------------------------
#

, prune_enable

#
#-----[ IN-LINE AFTER, ADD ]---------------------------
#

, sponsor

#
#-----[ FIND ]------------------------------------------
# 

				VALUES ('" . $next_id . "', '" . str_replace("\'", "''", $HTTP_POST_VARS['forumname']) . "', " . intval($HTTP_POST_VARS[POST_CAT_URL]) . ", '" . str_replace("\'", "''", $HTTP_POST_VARS['forumdesc']) . "', $next_order, " . intval($HTTP_POST_VARS['forumstatus']) . ", " . intval($HTTP_POST_VARS['prune_enable']) . $value_sql . ")";

#
#-----[ IN-LINE FIND ]---------------------------------
#

intval($HTTP_POST_VARS['prune_enable'])

#
#-----[ IN-LINE AFTER, ADD ]---------------------------
#

 . ", '" . str_replace("quote", "quote:1", str_replace("\'", "''", $HTTP_POST_VARS['sponsor']) ) . "'"

#
#-----[ FIND ]------------------------------------------
# 

				SET forum_name = '" . str_replace("\'", "''", $HTTP_POST_VARS['forumname']) . "', cat_id = " . intval($HTTP_POST_VARS[POST_CAT_URL]) . ", forum_desc = '" . str_replace("\'", "''", $HTTP_POST_VARS['forumdesc']) . "', forum_status = " . intval($HTTP_POST_VARS['forumstatus']) . ", prune_enable = " . intval($HTTP_POST_VARS['prune_enable']) . "

#
#-----[ IN-LINE FIND ]---------------------------------
#

" . intval($HTTP_POST_VARS['prune_enable']) . "

#
#-----[ IN-LINE AFTER, ADD ]---------------------------
#

, sponsor = '" . str_replace("quote", "quote:1", str_replace("\'", "''", $HTTP_POST_VARS['sponsor']) ) . "'

# 
#-----[ OPEN ]------------------------------------------
# 

includes/page_header.php

#
#-----[ FIND ]------------------------------------------
# 

//
// The following assigns all _common_ variables that may be used at any point
// in a template.
//

# 
#-----[ BEFORE, ADD ]------------------------------------------
# 

if ($forum_id)
{
	$sql = "SELECT sponsor
		FROM " .  FORUMS_TABLE . "
		WHERE forum_id = " . intval($forum_id);
	if ( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Could not select forum sponsor data', '', __LINE__, __FILE__, $sql);
	}

	while( $row = $db->sql_fetchrow($result) )
	{
		$forum_sponsor = $row['sponsor'];
	}
	
	if ($forum_sponsor != '')
	{
		include_once($phpbb_root_path . "includes/bbcode.$phpEx");
		$forum_sponsor = bbencode_first_pass($forum_sponsor, '1');
		$forum_sponsor = bbencode_second_pass ($forum_sponsor, '1');
		$forum_sponsor = smilies_pass ($forum_sponsor);
		$forum_sponsor = str_replace("quote:1", "quote", $forum_sponsor);
		$forum_sponsor = nl2br($forum_sponsor);
	}
}

#
#-----[ FIND ]------------------------------------------
# 

$template->assign_vars(array(

# 
#-----[ AFTER, ADD ]------------------------------------------
#

	'FORUM_SPONSOR'		=> $forum_sponsor,

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

$lang['Forum_Sponsor'] = 'Forum Sponsor';
$lang['Forum_Sponsor_Note'] = 'Note: HTML and BBCodes are on.';

# 
#-----[ OPEN ]------------------------------------------
# 

templates/subSilver/viewforum_body.tpl

#
#-----[ FIND ]------------------------------------------
# 

</table>

# 
#-----[ AFTER, ADD ]------------------------------------------
#

<table width="100%" cellspacing="1" cellpadding="2" border="0" align="center"> 
	<tr>
		<td align="center">
			{FORUM_SPONSOR}
		</td>
	</tr>
</table>

# 
#-----[ OPEN ]------------------------------------------
# 

templates/subSilver/viewtopic_body.tpl

#
#-----[ FIND ]------------------------------------------
# 

	  -> <a href="{U_VIEW_FORUM}" class="nav">{FORUM_NAME}</a></span></td>
  </tr>
</table>

# 
#-----[ AFTER, ADD ]------------------------------------------
#

<table width="100%" cellspacing="1" cellpadding="2" border="0" align="center"> 
	<tr>
		<td align="center">
			{FORUM_SPONSOR}
		</td>
	</tr>
</table>

# 
#-----[ OPEN ]------------------------------------------
# 

templates/subSilver/admin/forum_edit_body.tpl

#
#-----[ FIND ]------------------------------------------
# 

	  </table></td>
	</tr>

# 
#-----[ AFTER, ADD ]------------------------------------------
#

	<tr>
		<td class="row1">{L_FORUM_SPONSOR}<br/><span class="gensmall">{L_FORUM_SPONSOR_NOTE}</span></td>
		<td class="row2"><textarea rows="5" cols="45" wrap="virtual"  name="sponsor" class="post">{SPONSOR}</textarea></td>
	</tr>

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM