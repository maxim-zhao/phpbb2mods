##############################################################
## MOD Title: Forum Sponsors 1.0.01 to 1.0.02c upgrade
## MOD Author: EXreaction < exreaction@lithiumstudios.org > (Nathan Guse) http://www.lithiumstudios.org
## MOD Description: Allows you to add advertisements in specific forums
## MOD Version: 1.0.02c
##
## Installation Level: Intermediate
## Installation Time: ~5 Minutes
## Files To Edit:	admin/admin_forums.php
##					includes/page_header.php
##                  language/lang_english/lang_admin.php
##					language/lang_english/lang_main.php
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
#-----[ OPEN ]------------------------------------------
# 

admin/admin_forums.php

#
#-----[ FIND ]------------------------------------------
# 

			if (intval($forum_id) != '')
			{
				$sql = "SELECT sponsor
					FROM " .  FORUMS_TABLE . "
					WHERE forum_id = " . $forum_id;

#
#-----[ REPLACE WITH ]------------------------------------------
#

			if ($forum_id)
			{
				$sql = "SELECT sponsor
					FROM " .  FORUMS_TABLE . "
					WHERE forum_id = " . intval($forum_id);

#
#-----[ FIND ]------------------------------------------
# 

					$forum_sponsor = $row['sponsor'];

# 
#-----[ AFTER, ADD ]------------------------------------------
#

					$forum_sponsor = str_replace("quote:1", "quote", $forum_sponsor);

#
#-----[ FIND ]------------------------------------------
# 

				'SPONSOR'			=> $forum_sponsor,

# 
#-----[ AFTER, ADD ]------------------------------------------
#

				'L_FORUM_SPONSOR'		=> $lang['Forum_Sponsor'],
				'L_FORUM_SPONSOR_NOTE'	=> $lang['Forum_Sponsor_Note'],

#
#-----[ FIND ]------------------------------------------
#

 . ", '" . str_replace("\'", "''", $HTTP_POST_VARS['sponsor']) . "'"
 
#
#-----[ REPLACE WITH ]------------------------------------------
#

 . ", '" . str_replace("quote", "quote:1", str_replace("\'", "''", $HTTP_POST_VARS['sponsor']) ) . "'"

#
#-----[ FIND ]------------------------------------------
#

, sponsor = '" . str_replace("\'", "''", $HTTP_POST_VARS['sponsor']) . "'

#
#-----[ REPLACE WITH ]------------------------------------------
#

, sponsor = '" . str_replace("quote", "quote:1", str_replace("\'", "''", $HTTP_POST_VARS['sponsor']) ) . "'

# 
#-----[ OPEN ]------------------------------------------
# 

includes/page_header.php

#
#-----[ FIND ]------------------------------------------
#

if (intval($forum_id) != '')
{
	$sql = "SELECT sponsor
		FROM " .  FORUMS_TABLE . "
		WHERE forum_id = " . $forum_id;
	if ( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Could not select forum sponsor data', '', __LINE__, __FILE__, $sql);
	}

	while( $row = $db->sql_fetchrow($result) )
	{
		$forum_sponsor = $row['sponsor'];
	}
}

#
#-----[ REPLACE WITH ]------------------------------------------
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

	'L_FORUM_SPONSOR' => $lang['Forum_Sponsor'],

#
#-----[ REPLACE WITH ]------------------------------------------
# (delete it)



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

language/lang_english/lang_main.php

#
#-----[ FIND ]------------------------------------------
# 

$lang['Forum_Sponsor'] = 'Forum Sponsor';

#
#-----[ REPLACE WITH ]------------------------------------------
# (delete it)



# 
#-----[ OPEN ]------------------------------------------
# 

templates/subSilver/admin/forum_edit_body.tpl

#
#-----[ FIND ]------------------------------------------
# 

		<td class="row1">{L_FORUM_SPONSOR}</td>

#
#-----[ IN-LINE FIND ]---------------------------------
#

</td>

#
#-----[ IN-LINE BEFORE, ADD ]---------------------------
#

<br/><span class="gensmall">{L_FORUM_SPONSOR_NOTE}</span>

#
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------
#
# EoM