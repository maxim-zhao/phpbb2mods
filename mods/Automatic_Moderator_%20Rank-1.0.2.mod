############################################################## 
## MOD Title: Automatic Moderator Rank
## MOD Author: tosspot <tosspot@markf.mailshell.com> Mark Fyvie http://www.fyvie.net
## MOD Description: Moderators will automatically assume the rank of Moderator (and associated image) in forums
## in which they have moderator status. In other forums they will appear as their normal rank.
## MOD Version: 1.0.2 
## 
## Installation Level: easy 
## Installation Time: 3 Minutes 
## Files To Edit: 2: viewtopic.php
##                   language/lang_english/lang_main.php 
## Included Files: n/a 
############################################################## 
## For Security Purposes, Please Check: http://www.phpbb.com/mods/ for the 
## latest version of this MOD. Downloading this MOD from other sites could cause malicious code 
## to enter into your phpBB Forum. As such, phpBB will not offer support for MOD's not offered 
## in our MOD-Database, located at: http://www.phpbb.com/mods/ 
############################################################## 
## Author Notes: 
## Please note that this mod assumes that you have created a special rank called "Moderator" (it must be a special
## rank and not a normal one based on post). If you have a different rank name for your moderators, then you must
## edit the variable $moderator_rank_name in only one place (see comment in the code itself). If you fail to do
## this, users will see an error message.
##
## If you already have a special rank called "Moderator" you can safely ignore this note.
##
############################################################## 
## MOD History: 
##
## 2003-05-22 - Version 1.0.0
## - Initial version
## 2003-08-14 - Version 1.0.1
## - Syntax checked for phpbb 2.0.6
## 2003-08-14 - Version 1.0.2 
## - Moved error message to language file
############################################################## 
## Before Adding This MOD To Your Forum, You Should Back Up All Files Related To This MOD 
############################################################## 
# 
#-----[ OPEN ]------------------------------------------ 
# 
viewtopic.php
# 
#-----[ FIND ]------------------------------------------ 
# 
//
// Okay, let's do the loop, yeah come on baby let's do the loop
// and it goes like this ...
//
#
#-----[ BEFORE, ADD ]------------------------------------------ 
# 
//
// Automatic Moderator Rank MOD
//

$sql = "SELECT u.user_id
	FROM " . AUTH_ACCESS_TABLE . " aa, " . USER_GROUP_TABLE . " ug, " . GROUPS_TABLE . " g, " . USERS_TABLE . " u
	WHERE aa.auth_mod = " . TRUE . "
                AND aa.forum_id = $forum_id
		AND ug.group_id = aa.group_id
		AND g.group_id = aa.group_id
		AND u.user_id = ug.user_id";
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not query forum moderator information', '', __LINE__, __FILE__, $sql);
}
$forum_moderators = array();
while( $row = $db->sql_fetchrow($result) )
{
	$forum_moderators[] = $row['user_id'];
}
# 
#-----[ FIND ]------------------------------------------ 
# 
	//
	// Generate ranks, set them to empty string initially.
	//
	$poster_rank = '';
	$rank_image = '';
	if ( $postrow[$i]['user_id'] == ANONYMOUS )
	{
	}
	else if ( $postrow[$i]['user_rank'] )
	{
		for($j = 0; $j < count($ranksrow); $j++)
		{
			if ( $postrow[$i]['user_rank'] == $ranksrow[$j]['rank_id'] && $ranksrow[$j]['rank_special'] )
			{
				$poster_rank = $ranksrow[$j]['rank_title'];
				$rank_image = ( $ranksrow[$j]['rank_image'] ) ? '<img src="' . $ranksrow[$j]['rank_image'] . '" alt="' . $poster_rank . '" title="' . $poster_rank . '" border="0" /><br />' : '';
			}
		}
	}
#
#-----[ AFTER, ADD ]------------------------------------------ 
# 
//
// Start Automatic Moderator Rank Mod
//
        else if ( in_array($postrow[$i]['user_id'],$forum_moderators) )
        {
                $moderator_rank_name = "Moderator"; //Note: Change this if you have not created a rank with this exact name on your system for Moderators

		for($j = 0; $j < count($ranksrow); $j++)
		{
			if ( $ranksrow[$j]['rank_title'] == $moderator_rank_name )
			{
				$poster_rank = $ranksrow[$j]['rank_title'];
				$rank_image = ( $ranksrow[$j]['rank_image'] ) ? '<img src="' . $ranksrow[$j]['rank_image'] . '" alt="' . $poster_rank . '" title="' . $poster_rank . '" border="0" /><br />' : '';
			}
		}
                if ( $poster_rank == '' ) // Double check that the rank name defined in this section actually exists. If not, inform the user
                {
                        $poster_rank = $lang['ModeratorModError'];
                }
        }
/// End Automatic Moderator Rank Mod
# 
#-----[ OPEN ]------------------------------------------ 
#
language/lang_english/lang_main.php
# 
#-----[ FIND ]------------------------------------------ 
#
$lang['A_critical_error']
# 
#-----[ AFTER, ADD ]------------------------------------------ 
#

//
// Automatic Moderator Rank MOD
//
$lang['ModeratorModError'] = 'Mod Config Error! (Auto Moderator Rank MOD) Inform Administrator!!';
# 
#-----[ SAVE/CLOSE ALL FILES ]------------------------------------------ 
# 
# EoM 